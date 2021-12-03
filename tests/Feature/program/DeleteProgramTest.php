<?php

namespace Tests\Feature\program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteProgramTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteProgramWithValidTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('program.destroy', ['program' => $program->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support'
            ]);
    }

    /**
     * @test
     */
    public function deleteProgramWithValidTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();

        Sanctum::actingAs($user2);
        $this->deleteJson(
            route('program.destroy', ['program' => $program->id])
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function deleteProgramWithValidTokenIsCreatorInvalidId()
    {
        $user = User::factory()->admin()->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('program.destroy', ['program' => 22])
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function deleteProgramWithInValidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();

        $this->deleteJson(
            route('program.destroy', ['program' => $program->id])
        )->assertUnauthorized();
    }
}
