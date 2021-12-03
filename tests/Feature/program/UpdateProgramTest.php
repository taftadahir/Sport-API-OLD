<?php

namespace Tests\Feature\program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateProgramTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateProgramWithValidDataTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->createdBy($user)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('program.update', ['program' => $record->id]),
            $record->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'program' => [
                        'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateProgramWithValidDataTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $record = Program::factory()->createdBy($user)->create();

        Sanctum::actingAs($user2);
        $this->putJson(
            route('program.update', ['program' => $record->id]),
            $record->getAttributes()
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function updateProgramWithInvalidIdValidDataToken()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $record = Program::factory()->createdBy($user)->create();

        Sanctum::actingAs($user2);
        $this->putJson(
            route('program.update', ['program' => 22]),
            $record->getAttributes()
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function updateProgramWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $record = Program::factory()->createdBy($user)->create();

        $this->putJson(
            route('program.update', ['program' => $record->id]),
            $record->getAttributes()
        )->assertUnauthorized();
    }
}
