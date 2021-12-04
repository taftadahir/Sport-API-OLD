<?php

namespace Tests\Feature\statistic;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateStatisticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateUserStatWithValidDataTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->user($user)->workout($workout)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('workouts.statistic.update', ['workout' => $workout->id, 'statistic' => $statistic->id]),
            $statistic->getAttributes()
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'statistic' => ['workout_id', 'reps', 'time', 'set_number']
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateUserStatWithValidDataTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->user($user)->workout($workout)->create();

        Sanctum::actingAs($user2);
        $this->putJson(
            route('workouts.statistic.update', ['workout' => $workout->id, 'statistic' => $statistic->id]),
            $statistic->getAttributes()
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function updateUserStatWithValidDataTokenInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->user($user)->workout($workout)->create();

        Sanctum::actingAs($user);
        $this->putJson(
            route('workouts.statistic.update', ['workout' => $workout->id, 'statistic' => 900]),
            $statistic->getAttributes()
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function updateUserStatWithValidDataInvalidToken()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->user($user)->workout($workout)->create();

        $this->putJson(
            route('workouts.statistic.update', ['workout' => $workout->id, 'statistic' => $statistic->id]),
            $statistic->getAttributes()
        )->assertUnauthorized();
    }
}
