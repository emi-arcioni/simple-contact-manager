<?php

namespace App\Interfaces;

use App\Contact;

interface PeopleServiceInterface
{
    public function request(string $type, string $url, array $data);
    public function create(array $contacts);
    public function update(Contact $contact);
    public function delete(Contact $contact);
}