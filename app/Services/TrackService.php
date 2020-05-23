<?php

namespace App\Services;

use GuzzleHttp\Client;
use App\Setting;
use App\Interfaces\TrackServiceInterface;
use Carbon\Carbon;

class TrackService implements TrackServiceInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function track()
    {

        $data = base64_encode(json_encode([
            'token' => Setting::publicApiKey(),
            'event' => 'Button clicked',
            'customer_properties' => [
                'email' => auth()->user()->email
            ],
            'time' => Carbon::now()->timestamp
        ]));

        $response = $this->client->request('GET', 'track?data=' . $data);
        
        return $response->getBody()->getContents();
    }
}