<?php

namespace Tests\Feature\workout;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateWorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateWorkoutWithValidDataTokenIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('program.exercise.workout.update', ['program' => $program->id, 'exercise' => $exercise->id, 'workout' => $workout->id]),
            $workout->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'workout' => [
                        'exercise_id', 'program_id', 'set_id', 'day', 'reps_based', 'reps', 'time_based', 'time', 'set_number', 'rest_time'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateWorkoutWithValidDataTokenIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->create();

        Sanctum::actingAs($user2);
        $this->putJson(
            route('program.exercise.workout.update', ['program' => $program->id, 'exercise' => $exercise->id, 'workout' => $workout->id]),
            $workout->getAttributes()
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function updateWorkoutWithValidDataTokenIsProgramCreatorAndInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('program.exercise.workout.update', ['program' => $program->id, 'exercise' => $exercise->id, 'workout' => 9000000]),
            $workout->getAttributes()
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function updateWorkoutWithInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->create();

        $this->putJson(
            route('program.exercise.workout.update', ['program' => $program->id, 'exercise' => $exercise->id, 'workout' => $workout->id]),
            $workout->getAttributes()
        )->assertUnauthorized();
    }
}
