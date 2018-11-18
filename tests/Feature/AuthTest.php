<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DbTestCase;
use App\User;

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
        $password = '12345';
        $email = 'test@mail.ru';

        $this->post(route('auth.login'), [
            'username' => $username,
            'password' => $password,
            'email' => $email
        ])->assertOk();

        $this->assertDatabaseHas('users', [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'group' => User::MEMBER
        ]);
    }
}
