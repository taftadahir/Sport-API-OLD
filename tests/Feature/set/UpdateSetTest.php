<?php

namespace Tests\Feature\set;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateSetWithValidDataTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('program.set.update', ['set' => $set->id, 'program' => $program->id]),
            $set->getAttributes()
        )
            ->assertOk()
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
    public function updateSetWithValidDataTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user2);
        $this->putJson(
            route('program.set.update', ['set' => $set->id, 'program' => $program->id]),
            $set->getAttributes()
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function updateSetWithValidDataTokenIsProgramCreatorAndInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('program.set.update', ['set' => 9000000, 'program' => 90]),
            $set->getAttributes()
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function updateSetWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        $this->putJson(
            route('program.set.update', ['set' => $set->id, 'program' => $program->id]),
            $set->getAttributes()
        )->assertUnauthorized();
    }
}
