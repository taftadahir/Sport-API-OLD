<?php

namespace Tests\Feature\set;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function showSetWithValidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user);
        $response = $this
            ->getJson(route('program.set.show', ['set' => $set->id, 'program' => $program->id]));

        $response->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'set' => [
                        'name', 'program_id', 'day', 'set', 'rest_time', 'warm_up_set'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function showSetWithValidIdIsNotProgramCreatorAndProgramNotPublished()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user2);
        $response = $this
            ->getJson(route('program.set.show', ['set' => $set->id, 'program' => $program->id]));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function showSetWhenNotLogIn()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        $response = $this
            ->getJson(route('program.set.show', ['set' => $set->id, 'program' => $program->id]));

        $response->assertUnauthorized();
    }
}
