<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Interfaces\PeopleServiceInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ContactsController extends CRUDController
{
    protected $model;
    protected $label;
    protected $form_validator_fields;
    protected $form_data;
    protected $peopleService;

    public function __construct(Contact $model, PeopleServiceInterface $peopleService) 
    {
        $this->model = $model;
        $this->label = 'Contact';
        $this->peopleService = $peopleService;

        $this->form_validator_fields = [
            'first_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email']
        ];
    }

    public function store(Request $request, $contact_id = NULL)
    {
        $this->form_data = [
            'user_id' => auth()->user()->id,
            'first_name' => $request->input('first_name'),
            'email' => $request->input('email'),
            'phone' => $request->has('phone') ? $request->input('phone') : NULL
        ];

        DB::beginTransaction();
        $response = parent::store($request, $contact_id);

        if ($this->item->wasRecentlyCreated) {
            $external_users = $this->peopleService->create([$this->item]);
            $this->item->external_id = $external_users[0]->id;
            $this->item->save();
        } else {
            $this->peopleService->update($this->item);
        }
        DB::commit();

        return $response;
    }

    public function delete(Request $request, $contact_id)
    {
        DB::beginTransaction();

        parent::delete($request, $contact_id);
        $this->peopleService->delete($this->item);

        DB::commit();
    }

    public function formUpload(Request $request)
    {
        return view('upload');
    }

    public function formUploadProcess(Request $request)
    {
        Validator::make($request->all(), [
            'file' => ['required', 'mimes:csv,txt']
        ])->validate();

        $keys = ['first_name', 'email', 'phone'];
        $user_id = auth()->user()->id;
        $content = file($request->file('file'));

        $contacts_to_add = [];
        $contacts_to_sync = [];
        foreach($content as $line) {
            $fields = array_combine($keys, array_map('trim', explode(",", $line)));
            
            $fields['user_id'] = $user_id;
            $fields['created_at'] = Carbon::now()->format("Y-m-d H:i:s");
            
            $validator = Validator::make($fields, $this->form_validator_fields);
            if (!$validator->fails()) {
                $contacts_to_add[] = $fields;
                $contacts_to_sync[] = (object)$fields;
            }
        }

        DB::beginTransaction();

        Contact::insert($contacts_to_add);
        $external_users = $this->peopleService->create($contacts_to_sync);
        array_map(function($external_user) {
            Contact::where('email', $external_user->email)->update(['external_id' => $external_user->id]);
        }, $external_users);

        DB::commit();

        $view_data = [
            'total_uploaded' => count($contacts_to_add)
        ];

        return view('upload', $view_data);
    }
}
