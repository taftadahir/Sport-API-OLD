<?php

namespace Tests\Feature\exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateExerciseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateExerciseWithValidDataTokenIsCreator()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            $exercise->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'exercise' => [
                        'name', 'time_based', 'reps_based', 'published', 'avatar', 'created_at', 'updated_at'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateExerciseWithInvalidDataValidTokenIsCreator()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            [
                'name' => 1222,
            ]
        )->assertUnprocessable();
    }

    /**
     * @test
     */
    public function updateExerciseWithValidDataTokenIsNotCreator()
    {
        $user = User::factory()->unHash()->admin()->create();
        $user2 = User::factory()->unHash()->male()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user2);
        $this->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            $exercise->getAttributes()
        )
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function updateExerciseWithInvalidIdValidDataToken()
    {
        $user = User::factory()->unHash()->male()->create();
        $exercise = Exercise::factory()->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('exercise.update', ['exercise' => 22]),
            $exercise->getAttributes()
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function updateExerciseWithInvalidToken()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();

        $this->putJson(
            route('exercise.update', ['exercise' => $exercise->id]),
            $exercise->getAttributes()
        )->assertUnauthorized();
    }
}
