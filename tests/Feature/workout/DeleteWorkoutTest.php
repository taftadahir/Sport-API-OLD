<?php

namespace Tests\Feature\workout;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteWorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteWorkoutWithValidTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('program.exercise.workout.destroy', ['workout' => $workout->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
            ]);
    }

    /**
     * @test
     */
    public function deleteWorkoutWithValidTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();

        Sanctum::actingAs($user2);
        $this->deleteJson(
            route('program.exercise.workout.destroy', ['workout' => $workout->id])
        )
            ->assertForbidden();
    }

    /**
     * @test
     */
    public function deleteWorkoutWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        Workout::factory()->program($program)->exercise($exercise)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('program.exercise.workout.destroy', ['workout' => 88])
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function deleteWorkoutWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();

        $this->deleteJson(
            route('program.exercise.workout.destroy', ['workout' => $workout->id])
        )->assertUnauthorized();
    }
}
