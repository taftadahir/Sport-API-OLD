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

class DeleteStatisticTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteUserStatWithValidTokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('workouts.statistic.destroy', ['statistic' => $statistic->id])
        )
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
            ]);
    }

    /**
     * @test
     */
    public function deleteUserStatWithValidTokenIsNotCreator()
    {
        $user = User::factory()->admin()->create();
        $user2 = User::factory()->male()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->user($user)->create();

        Sanctum::actingAs($user2);
        $this->deleteJson(
            route('workouts.statistic.destroy', ['statistic' => $statistic->id])
        )->assertForbidden();
    }

    /**
     * @test
     */
    public function deleteUserStatWithInvalidIdIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->create();

        Sanctum::actingAs($user);
        $this->deleteJson(
            route('workouts.statistic.destroy', ['statistic' => 22])
        )->assertNotFound();
    }

    /**
     * @test
     */
    public function deleteUserStatWithInvalidtokenIsCreator()
    {
        $user = User::factory()->admin()->create();
        $program = Program::factory()->createdBy($user)->published()->create();
        $exercise = Exercise::factory()->createdBy($user)->create();
        $workout = Workout::factory()->program($program)->exercise($exercise)->create();
        $statistic = Statistic::factory()->workout($workout)->create();

        $this->deleteJson(
            route('workouts.statistic.destroy', ['statistic' => $statistic->id])
        )->assertUnauthorized();
    }
}
