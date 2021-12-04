<?php

namespace Tests\Feature\exercise;

use App\Models\Exercise;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreExerciseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeExerciseWithValidDatas()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->make();
        Sanctum::actingAs($user);
        $this->postJson(route('exercise.store'), $exercise->getAttributes())
            ->assertCreated()
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
    public function storeExerciseWithInvalidName()
    {
        $user = User::factory()->unHash()->admin()->create();
        $exercise = Exercise::factory()->name(890)->make();
        Sanctum::actingAs($user);
        $this->postJson(route('exercise.store'), $exercise->getAttributes())
            ->assertUnprocessable()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'errors' => [
                    'name'
                ]
            ]);
    }

    /**
     * @test
     */
    public function storeExerciseWithInvalidToken()
    {
        $exercise = Exercise::factory()->make();
        $this->postJson(route('exercise.store'), $exercise->getAttributes())
            ->assertUnauthorized();
    }
}
