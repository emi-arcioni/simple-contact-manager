<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactsController extends CRUDController
{
    protected $model;
    protected $label;
    protected $form_validator_fields;
    protected $form_data;

    public function __construct(Contact $model) {
        $this->model = $model;
        $this->label = 'Contact';
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

        return parent::store($request, $contact_id);
    }
}
