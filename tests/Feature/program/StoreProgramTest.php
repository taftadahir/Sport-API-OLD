<?php

namespace Tests\Feature\program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class StoreProgramTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function storeProgramWithValidData()
    {
        $user = User::factory()->unHash()->admin()->create();
        $record = Program::factory()->make();

        Sanctum::actingAs($user);
        $this->postJson(route('program.store'), $record->getAttributes())
            ->assertCreated()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'program' => [
                        'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function storeProgramWithInvalidData()
    {
        $user = User::factory()->unHash()->withConfirmation()->admin()->make();
        $record = Program::factory()->name(890)->make();

        Sanctum::actingAs($user);
        $this->postJson(route('program.store'), $record->getAttributes())
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
    public function storeProgramWithInvalidToken()
    {
        $record = Program::factory()->make();
        $this->postJson(route('program.store'), $record->getAttributes())
            ->assertUnauthorized();
    }
}
