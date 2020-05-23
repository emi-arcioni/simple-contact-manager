<?php

namespace App\Services;

use App\Contact;
use App\Setting;
use App\Interfaces\PeopleServiceInterface;

class FakePeopleService implements PeopleServiceInterface
{
    public function request($type, $url, $data = [])
    {
        return [];
    }

    public function create(array $contacts)
    {
        return [
            (object)[
                "id" => "abcDEF",
                "email" => "george.washington@example.com",
            ],
            (object)[
                "id" => "dEFAbc",
                "email" => "thomas.jefferson@example.com",
                "phone_number" => "+12223334444"
            ]
        ];
    }
    
    public function update(Contact $contact)
    {
        return [];
    }

    public function delete(Contact $contact)
    {
        return [];
    }
}