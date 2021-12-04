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

class StoreWorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeWorkoutWithValidDataAndIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->make();

        Sanctum::actingAs($user);
        $this->postJson(route('program.exercise.workout.store', [
            'program' => $program->id,
            'exercise' => $exercise->id,
        ]), $workout->getAttributes())
            ->assertCreated()
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
    public function storeWorkoutWithValidDatasAndIsNotProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $exercise = Exercise::factory()->createdBy($user2)->create();
        $program = Program::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->make();

        Sanctum::actingAs($user2);
        $this->postJson(route('program.exercise.workout.store', [
            'program' => $program->id,
            'exercise' => $exercise->id,
        ]), $workout->getAttributes())->assertForbidden();
    }

    /**
     * @test
     */
    public function storeWorkoutWithInvalidDatasAndIsProgramCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user2)->create();
        $workout = Workout::factory()->make();
        $data = $workout->getAttributes();
        $data['day'] = 'test';

        Sanctum::actingAs($user);
        $this->postJson(route('program.exercise.workout.store', [
            'program' => $program->id,
            'exercise' => $exercise->id,
        ]), $data)->assertUnprocessable();
    }

    /**
     * @test
     */
    public function storeWorkoutWithValidDatasAndNotLogin()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->make();

        $this->postJson(route('program.exercise.workout.store', [
            'program' => $program->id,
            'exercise' => $exercise->id,
        ]), $workout->getAttributes())->assertUnauthorized();
    }
}
