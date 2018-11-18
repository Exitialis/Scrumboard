<?php

namespace Tests;

use App\Payment;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

trait DbTestTrait
{
    use RefreshDatabase;

    protected $baseUrl;

    public function setUp()
    {
        parent::setUp();

        $this->baseUrl = env('APP_URL', null);
    }

    /**
     * Get User with admin rights.
     *
     * @return mixed
     */
    public function getProductOwner()
    {
        return factory(User::class)->states('product_owner')->create();
    }

    public function getUsers(int $count)
    {
        return factory(User::class, $count)->create();
    }

    public function getUser()
    {
        return factory(User::class)->create();
    }

    public function actingAsUser()
    {
        $user = $this->getUser();
        $this->actingAs($user);
        return $user;
    }

    public function actingAsProductOwner()
    {
        $user = $this->getProductOwner();
        $this->actingAs($user);
        return $user;
    }
}
