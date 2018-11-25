<?php

namespace Tests;

use App\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Sprint;
use App\Models\Task;

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

    public function getScrumMaster()
    {
        return factory(User::class)->states('scrum_master')->create();
    }

    public function getUsers(int $count)
    {
        return factory(User::class, $count)->create();
    }

    public function getUser()
    {
        return factory(User::class)->create();
    }

    public function createTask(int $executor = null, int $sprint = null)
    {
        return factory(Task::class)->create([
            'creator' => $this->user ? $this->user->id : null,
            'executor' => $executor,
            'sprint' => $sprint
        ]);
    }

    public function createSprint()
    {
        return factory(Sprint::class)->create();
    }
}
