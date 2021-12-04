<?php

namespace Tests\Feature\statistic;

use App\Models\Exercise;
use App\Models\Program;
use App\Models\Statistic;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowStatisticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getUserStatWithValidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->create();

        Sanctum::actingAs($user);
        $response = $this->getJson(route('workouts.statistic.show', ['statistic' => $statistic->id]));

        $response->assertOk()
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
    public function getUserStatWithInvalidId()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->create();

        Sanctum::actingAs($user);
        $response = $this->getJson(route('workouts.statistic.show', ['statistic' => 22]));

        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function getUserStatWhenNotLogin()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->create();

        $response = $this->getJson(route('workouts.statistic.show', ['statistic' => 22]));

        $response->assertUnauthorized();
    }
}
