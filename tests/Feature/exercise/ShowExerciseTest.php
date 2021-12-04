<?php

namespace Tests\Feature\exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowExerciseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getExerciseWithValidIdPublished()
    {
        // Create user
        $user = User::factory()->unHash()->create();

        // Create exercise
        $exercise = Exercise::factory()->createdBy($user)->published()->create();

        Sanctum::actingAs($user);
        // Get exercise
        $response = $this
            ->getJson(route('exercise.show', ['exercise' => $exercise->id]));

        // Assert
        $response->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'exercise' => [
                        'name', 'time_based', 'reps_based', 'published', 'image', 'created_at', 'updated_at'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function getExerciseWithValidIdNotPublishedAndNotCreator()
    {
        // Create user
        $user = User::factory()->create();

        // Create user2
        $user2 = User::factory()->create();

        // Create exercise
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user2);
        // Get exercise
        $response = $this
            ->getJson(route('exercise.show', ['exercise' => $exercise->id]));

        // Assert
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function getExerciseWithValidIdNotPublishedAndIsCreator()
    {
        // Create user
        $user = User::factory()->create();

        // Create exercise
        $exercise = Exercise::factory()->createdBy($user)->create();

        Sanctum::actingAs($user);
        // Get exercise
        $response = $this
            ->getJson(route('exercise.show', ['exercise' => $exercise->id]));

        // Assert
        $response->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'exercise' => [
                        'name', 'time_based', 'reps_based', 'published', 'image', 'created_at', 'updated_at'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function getExerciseWithInvalidId()
    {
        // Create user
        $user = User::factory()->create();

        Sanctum::actingAs($user);
        // Get exercise
        $response = $this
            ->getJson(route('exercise.show', ['exercise' => 9000]));

        // Assert
        $response->assertNotFound();
    }
}
