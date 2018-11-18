<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DbTestCase;

class TasksTest extends DbTestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNewTaskCreation()
    {
        $user = $this->getProductOwner();
        $this->actingAs($user);

        $response = $this->post(route('tasks.create'), [
            'name' => 'Test',
        ])->assertOk();

        $this->assertDatabaseHas('tasks', [
            'name' => 'Test',
            'creator' => $user->id,
            'executor' => null,
            'description' => null,
            'sprint' => null,
            'status' => 0
        ]);
    }
}
