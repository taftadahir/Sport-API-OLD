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

class StoreStatisticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeUserStatWithValidDatas()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->make();

        Sanctum::actingAs($user);
        $this->postJson(route('workouts.statistic.store', ['workout' => $workout->id]), $statistic->getAttributes())
            ->assertCreated()
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
    public function storeUserStatWithInvalidDatas()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->make();
        $statistic['reps'] = 'error';

        Sanctum::actingAs($user);
        $this->postJson(route('workouts.statistic.store', ['workout' => $workout->id]), $statistic->getAttributes())->assertUnprocessable();
    }

    /**
     * @test
     */
    public function storeUserStatWhenNotLogin()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->make();

        $this->postJson(route('workouts.statistic.store', ['workout' => $workout->id]), $statistic->getAttributes())->assertUnauthorized();
    }
}
