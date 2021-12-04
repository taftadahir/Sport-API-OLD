<?php

namespace Tests\Feature\workout;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowWorkoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getWorkoutWithValidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();

        Sanctum::actingAs($user);
        $response = $this->getJson(route('program.exercise.workout.show', ['workout' => $workout->id]));

        $response->assertOk()
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
    public function getWorkoutWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        Workout::factory()->program($program)->exercise($exercise)->create();

        Sanctum::actingAs($user);
        $response = $this->getJson(route('program.exercise.workout.show', ['workout' => 22]));

        $response->assertNotFound();
    }
}
