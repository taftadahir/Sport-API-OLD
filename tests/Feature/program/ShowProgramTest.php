<?php

namespace Tests\Feature\program;

use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ShowProgramTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function getProgramWithValidIdPublished()
    {
        // Create user
        $user = User::factory()->unHash()->create();

        // Create Program
        $program = Program::factory()->published()->create();

        // Get program
        Sanctum::actingAs($user);
        $response = $this->getJson(route('program.show', ['program' => $program->id]));

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'program' => [
                        'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image'
                    ]
                ]
            ],);
    }

    /**
     * @test
     */
    public function getProgramWithValidIdNotPublishedAndNotCreator()
    {
        // Create user
        $user = User::factory()->unHash()->create();

        // Create user2
        $user2 = User::factory()->unHash()->create();

        // Create program
        $program = Program::factory()->createdBy($user)->create();

        // Get program
        Sanctum::actingAs($user2);
        $response = $this->getJson(route('program.show', ['program' => $program->id]));

        // Assert
        $response->assertNotFound();
    }

    /**
     * @test
     */
    public function getProgramWithValidIdNotPublishedAndIsCreator()
    {
        // Create user
        $user = User::factory()->unHash()->create();

        // Create program
        $program = Program::factory()->createdBy($user)->create();

        // Get program
        Sanctum::actingAs($user);
        $response = $this->getJson(route('program.show', ['program' => $program->id]));

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'code', 'message', 'support',
                'data' => [
                    'program' => [
                        'name', 'days', 'use_warm_up', 'use_program_set', 'use_workout_set', 'published', 'image'
                    ]
                ]
            ],);
    }

    /**
     * @test
     */
    public function getProgramWithInvalidId()
    {
        // Create user
        $user = User::factory()->unHash()->create();

        // Get program
        Sanctum::actingAs($user);
        $response = $this->getJson(route('program.show', ['program' => 9000]));

        // Assert
        $response
            ->assertNotFound();
    }
}
