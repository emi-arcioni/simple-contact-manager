<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use App\Interfaces\PeopleServiceInterface;
use Illuminate\Support\Facades\DB;

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
    }

    public function store(Request $request, $contact_id = NULL)
    {
        $this->form_validator_fields = [
            'first_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email']
        ];
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
}
