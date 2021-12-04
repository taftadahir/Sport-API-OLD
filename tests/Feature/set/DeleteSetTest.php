<?php

namespace Tests\Feature\set;

use App\Models\Program;
use App\Models\Set;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteSetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteSetWithValidTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('program.set.destroy', ['set' => $set->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
            ]);
    }

    /**
     * @test
     */
    public function deleteSetWithValidTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        Sanctum::actingAs($user2);
        $this->deleteJson(
            route('program.set.destroy', ['set' => $set->id])
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function deleteSetWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        Set::factory()->program($program)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('program.set.destroy', ['set' => 88])
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function deleteSetWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $set = Set::factory()->program($program)->create();

        $this->deleteJson(
            route('program.set.destroy', ['set' => $set->id])
        )->assertUnauthorized();
    }
}
