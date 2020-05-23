<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class ContactTest extends TestCase
{
    use RefreshDatabase;
    
    public function setUp():void
    {
        parent::setUp();

        $this->app->bind(\App\Interfaces\PeopleServiceInterface::class, \App\Services\FakePeopleService::class);
    }

    public function testItCanBeCreated()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        
        $response = $this->post('contacts', [
            'first_name' => 'Emilio',
            'email' => 'emilio@arcioni.com.ar'
        ]);

        $response->assertRedirect('contacts');
    }
    
    public function testItFailsWhenCreatingWithMissingParameters()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        
        $response = $this->post('contacts', [
            'first_name' => 'Emilio'
        ]);

        $response->assertRedirect('');
    }
    
    public function testItCanBeUpdated()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        
        $response = $this->put('contacts/1', [
            'first_name' => 'Emi',
            'email' => 'emilio@arcioni.com.ar'
        ]);

        $response->assertRedirect('contacts');
    }

    public function testItFailsWhenUpdatingWithWrongParameters()
    {
        $user = factory(User::class)->create();
        $this->be($user);
        
        $response = $this->post('contacts', [
            'first_name' => 'Emilio',
            'email' => 'emilioarcioni.com.ar'
        ]);

        $response->assertRedirect('');
    }
}
