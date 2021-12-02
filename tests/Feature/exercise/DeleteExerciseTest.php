<?php

namespace Tests\Feature\exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteExerciseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteExerciseWithValidTokenIsCreator()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('exercise.destroy', ['exercise' => $exercise->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support'
            ]);
    }

    /**
     * @test
     */
    public function deleteExerciseWithValidTokenIsNotCreator()
    {
        $user = User::factory()->unHash()->admin()->create();
        $user2 = User::factory()->unHash()->male()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user2);
        $this->deleteJson(
            route('exercise.destroy', ['exercise' => $exercise->id])
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function deleteExerciseWithValidTokenIsCreatorInvalidId()
    {
        $user = User::factory()->unHash()->admin()->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('exercise.destroy', ['exercise' => 22])
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function deleteExerciseWithInvalidToken()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        $this->deleteJson(
            route('exercise.destroy', ['exercise' => $exercise->id])
        )->assertUnauthorized();
    }
}
