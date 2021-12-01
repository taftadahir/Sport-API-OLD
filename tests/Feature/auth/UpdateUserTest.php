<?php

namespace Tests\Feature\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function updateAccountWithValidDataAndToken()
    {
        $user = User::factory()->unHash()->admin()->create();

        Sanctum::actingAs($user);
        $this
            ->putJson(route('user.update'), ['first_name' => 'Tafta'])
            ->assertOk()
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'message', 'code', 'support',
                'data' => [
                    'user' => [
                        'first_name', 'last_name', 'email', 'gender', 'avatar', 'created_at', 'updated_at',
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateAccountWithInvalidToken()
    {
        $user = User::factory()->unHash()->admin()->create();

        $this
            ->putJson(route('user.update'), ['first_name' => 'Tafta'])
            ->assertUnauthorized();
    }
}
