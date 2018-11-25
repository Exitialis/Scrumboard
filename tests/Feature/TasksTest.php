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
        $user = $this->actingAsProductOwner();

        $this->post(route('tasks.create'), [
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

    public function testUpdateTaskNameByProductOwner()
    {
        $user = $this->actingAsProductOwner();
        $task = $this->createTask();

        $response = $this->putJson(route('tasks.update', $task->id), [
            'name' => 'Test',
            'status' => $task->status
        ]);

        $response->assertOk()->assertJsonFragment([
            'name' => 'Test'
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => 'Test'
        ]);
    }

    public function testUpdateTaskByMemberOnlyStatus()
    {
        $user = $this->actingAsUser();
        $task = $this->createTask();

        $response = $this->putJson(route('tasks.update', $task->id), [
            'name' => 'Test',
            'description' => 'lol',
            'creator' => 1,
            'executor' => 1,
            'status' => 2
        ]);

        $response->assertOk()->assertJsonMissing([
            'name' => 'Test',
            'description' => 'lol',
            'creator' => 1,
            'executor' => 1,
            'sprint' => 1,
        ])->assertJsonFragment([
            'name' => $task->name,
            'description' => $task->description,
            'status' => 2
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'status' => 2,
            'creator' => $task->creator,
            'executor' => $task->executor,
            'sprint' => $task->sprint,
        ]);
    }

    public function testUpdateTaskByScrumMaster()
    {
        $user = $this->actingAsScrumMaster();
        $executor = $this->getUser();
        $task = $this->createTask();
        $sprint = $this->createSprint();

        $response = $this->putJson(route('tasks.update', $task->id), [
            'name' => 'Test',
            'description' => 'lol',
            'creator' => 1,
            'executor' => $executor->id,
            'status' => 2,
            'sprint' => $sprint->id
        ]);

        $response->assertOK()->assertJsonFragment([
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'status' => 2,
            'executor' => $executor->id,
            'sprint' => $sprint->id
        ]);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'name' => $task->name,
            'creator' => $task->creator,
            'executor' => $executor->id,
            'status' => 2,
            'sprint' => $sprint->id
        ]);
    }
}
