<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;
use Illuminate\Support\Facades\Validator;

class ContactsController extends Controller
{
    public function __construct() {}

    public function index(Request $request) 
    {
        $contacts = Contact::where('user_id', auth()->user()->id)->get();
        $view_data = [
            'contacts' => $contacts
        ];

        return view('contacts', $view_data);
    }

    public function form(Request $request, $contact_id = NULL)
    {
        if ($contact_id) {
            $contact = Contact::where('user_id', auth()->user()->id)->where('id', $contact_id)->firstOrFail();
            $title = 'Edit Contact';
        } else {
            $contact = [];
            $title = 'New Contact';
        }

        $view_data = [
            'title' => $title,
            'contact' => $contact
        ];

        return view('contact', $view_data);
    }

    public function store(Request $request, $contact_id = NULL)
    {
        Validator::make($request->all(), [
            'first_name' => ['required', 'max:255'],
            'email' => ['required', 'max:255', 'email']
        ])->validate();

        if ($contact_id) {
            if (Contact::where('user_id', auth()->user()->id)->where('id', $contact_id)->update([
                'first_name' => $request->input('first_name'),
                'email' => $request->input('email'),
                'phone' => $request->has('phone') ? $request->input('phone') : NULL
            ])) {
                $message = 'The contact has been succesfully updated';
                $type = 'success';
            } else {
                $message = 'The contact has not been updated';
                $type = 'danger';
            }            
        } else {
            if (Contact::create([
                'user_id' => auth()->user()->id,
                'first_name' => $request->input('first_name'),
                'email' => $request->input('email'),
                'phone' => $request->has('phone') ? $request->input('phone') : NULL
            ])) {
                $message = 'The contact has been succesfully created';
                $type = 'success';
            } else {
                $message = 'The contact has not been created';
                $type = 'danger';
            }
        }

        return redirect('/contacts')->with($type, $message);
    }

    public function delete(Request $request, $contact_id)
    {
        Contact::where('user_id', auth()->user()->id)->where('id', $contact_id)->delete();

        return redirect('/contacts')->with('success', 'The contact has been succesfully removed');
    }
}
