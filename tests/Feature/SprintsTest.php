<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\DbTestCase;
use App\Models\Sprint;

class SprintsTest extends DbTestCase
{
    public function testCreateSprint()
    {
        $this->actingAsProductOwner();

        $this->postJson(route('sprints.create'), [
            'name' => 'Test',
        ])->assertOk()->assertJsonFragment([
            'name' => 'Test',
            'status' => Sprint::CREATED,
            'date_start' => null,
            'date_finish' => null
        ]);

        $this->actingAsUser();

        $this->postJson(route('sprints.create'), [
            'name' => 'Test',
        ])->assertStatus(403)->assertJsonFragment([
            'status' => 403
        ]);

        $this->actingAsScrumMaster();

        $this->postJson(route('sprints.create'), [
            'name' => 'Test',
        ])->assertStatus(403)->assertJsonFragment([
            'status' => 403
        ]);
    }

    public function testUpdateSprint()
    {
        $sprint = $this->createSprint();

        $this->actingAsProductOwner();

        $this->putJson(route('sprints.update', $sprint->id), [
            'name' => 'Test1',
            'status' => Sprint::STARTED,
            'date_start' => now()->toDateTimeString(),
            'date_finish' => now()->addDays(5)->toDateTimeString()
        ])->assertOk()->assertJsonFragment([
            'name' => $sprint->name,
            'status' => Sprint::STARTED,
            'date_start' => now()->toDateTimeString(),
            'date_finish' => now()->addDays(5)->toDateTimeString()
        ]);
    }
}
