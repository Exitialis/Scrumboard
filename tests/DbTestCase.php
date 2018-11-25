<?php

namespace Tests;

use App\Models\User;
use App\Models\Task;

abstract class DbTestCase extends TestCase
{
    use DbTestTrait;

    /**
     * @var User
     */
    private $user;

    public function actingAsUser()
    {
        return $this->apiAs($this->getUser());
    }

    public function actingAsProductOwner()
    {
        return $this->apiAs($this->getProductOwner());
    }

    public function actingAsScrumMaster()
    {
        return $this->apiAs($this->getScrumMaster());
    }

    public function apiAs(User $user)
    {
        $this->user = $user;

        $this->withHeader('Authorization', 'Bearer ' . \JWTAuth::fromUser($user));
        $this->be($user);

        return $this->user;
    }
}
