<?php

namespace Tests\Feature\set;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function createSetWithValidData()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->make();

        Sanctum::actingAs($user);
        $this->postJson(route('program.set.store', ['program' => $program->id]), $set->getAttributes())
            ->assertCreated()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'set' => [
                        'name', 'program_id', 'day', 'number', 'rest_time', 'warm_up_set'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function createSetWithValidDataAndIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->make();

        Sanctum::actingAs($user2);
        $this->postJson(route('program.set.store', ['program' => $program->id]), $set->getAttributes())
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function createSetWithInvalidData()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->make();

        Sanctum::actingAs($user);
        $this->postJson(route('program.set.store', ['program' => 222]), $set->getAttributes())
            ->assertNotFound();
    }

    /**
     * @test
     */
    public function createSetWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->make();

        $this->postJson(route('program.set.store', ['program' => $program->id]), $set->getAttributes())
            ->assertUnauthorized();
    }
}
