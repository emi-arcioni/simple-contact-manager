<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Contact;
use App\Setting;
use App\Interfaces\PeopleServiceInterface;

class PeopleService implements PeopleServiceInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function request($type, $url, $data = [])
    {
        $api_key = Setting::privateApiKey();

        // workaround due to klaviyo inconsistency of passing the api_key parameter depending of its version
        if (substr($url, 0, 2) == 'v1') {
            $data['form_params']['api_key'] = $api_key;
        } else {
            $url .= '?api_key=' . $api_key;
        }
        $response = $this->client->request($type, $url, $data);

		return !empty($response) ? json_decode($response->getBody()->getContents()) : [];
    }

    public function create(array $contacts)
    {
        $list_id = $this->getListId();

        // -- Setup of the array of contacts that will be sent to Klaviyo endpoint
        $profiles = array_map(function(Contact $contact) {
            return [
                'first_name' => $contact->first_name,
                'email' => $contact->email,
                'phone_number' => $contact->phone
            ];
        }, $contacts);

        $response = $this->request('POST', 'v2/list/' . $list_id . '/members' , [
            'json' => [
                'profiles' => $profiles
            ]
        ]);

        return $response;
    }
    
    public function update(Contact $contact)
    {
        $response = $this->request('PUT', 'v1/person/' . $contact->external_id, [
            'form_params' => [
                'first_name' => $contact->first_name,
                'email' => $contact->email,
                'phone_number' => $contact->phone
            ]
        ]);

        return $response;
    }

    public function delete(Contact $contact)
    {
        $list_id = $this->getListId();

        $response = $this->request('DELETE', 'v2/list/' . $list_id . '/members', [
            'form_params' => [
                'emails' => $contact->email
            ]
        ]);
    }

    private function getListId()
    {
        // -- Check for the lists in Klaviyo. 
        $lists = $this->request('GET', 'v2/lists');
        if (!empty($lists['error-message'])) return $lists['error-message'];

        // -- If there are no lists, then create one with "Challenge" name and get that list ID
        if (empty($lists)) {
            $response = $this->request('POST', 'v2/lists', [
                'form_params' => [
                    'list_name' => 'Challenge'
                ]
            ]);
            $list_id = $response->list_id;
        } else { // -- If there are lists, I get the list ID of the first list
            $list_id = $lists[0]->list_id;
        }

        return $list_id;
    }
}