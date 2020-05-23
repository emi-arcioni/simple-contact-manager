<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testItRedirectsWhenTryingToAccessProtectedRoute()
    {
        $response = $this->get('contacts');

        $this->assertEquals(302, $response->status());
    }

    public function testItDontRedirectWhenUserIsLoggedIn()
    {
        $user = factory(User::class)->create();
        $this->be($user);

        $response = $this->get('contacts');

        $this->assertEquals(200, $response->status());
    }
}
