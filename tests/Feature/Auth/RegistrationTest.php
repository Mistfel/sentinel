<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertOk();
    }

    public function test_new_users_can_register()
    {
        $email = 'test@example.com';

        $response = $this->post(route('register.store'), [
            'email' => $email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => $email,
            'name' => Str::of($email)->before('@')->replace(['.', '_', '-'], ' ')->title()->value(),
        ]);
        $response->assertRedirect(route('dashboard', absolute: false));
    }
}
