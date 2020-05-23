<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testItCanRegister()
    {
        $response = $this->post('register', [
            'name' => 'Emilio',
            'email' => 'emilio@arcioni.com.ar',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertRedirect('home');
    }

    public function testItFailsWhenRegisteringWithMissingParameters()
    {
        $response = $this->post('register', [
            'name' => 'Emilio',
            'email' => 'emilio@arcioni.com.ar'
        ]);

        $response->assertRedirect(''); 
    }

    public function testItCanLogin()
    {
        $user = factory(User::class)->create();

        $response = $this->post('login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
    
        $response->assertRedirect('home');
    }

    public function testItCanLogout()
    {
        $response = $this->post('logout');
        $response->assertRedirect('/');
    }

}
