<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DbTestCase;
use App\Models\User;

class AuthTest extends DbTestCase
{
    public function testLogin()
    {
        $user = $this->getUser();

        $this->post(route('auth.login'), [
            'username' => $user->username,
            'password' => 'secret'
        ])->assertOk()->assertHeader('Authorization');
    }

    public function testRegister()
    {
        $username = 'test';
        $password = '123456';
        $email = 'test@mail.ru';

        $this->post(route('auth.register'), [
            'username' => $username,
            'password' => $password,
            'email' => $email
        ])->assertOk();

        $this->assertDatabaseHas('users', [
            'username' => $username,
            'email' => $email,
            'group' => User::MEMBER
        ]);

        $this->post(route('auth.login'), [
            'username' => $username,
            'password' => $password
        ])->assertOK()->assertHeader('Authorization');
    }

    public function testGetUser()
    {
        $user = $this->actingAsUser();

        $this->get(route('auth.me'))->assertOK()->assertJsonFragment([
            'username' => $user->username,
            'email' => $user->email,
            'group' => $user->group
        ]);
    }

    public function testLogout()
    {
        $user = $this->actingAsUser();

        $response = $this->get(route('auth.logout'))->assertOK()->assertJsonFragment([
            'status' => 200,
            'data' => 'Logged out Successfully.'
        ]);
    }
}
