<?php

namespace Tests\Feature\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function deleteAccountWithValidToken()
    {
        $user = User::factory()->unHash()->admin()->create();
        Sanctum::actingAs($user);
        $this->deleteJson(route('user.delete'))
            ->assertOk()
            ->assertJsonStructure([
                'message'
            ]);
    }

    /**
     * @test
     */
    public function deleteAccountWithInvalidToken()
    {
        $this->deleteJson(route('user.delete'))
            ->assertUnauthorized()
            ->assertJsonStructure([
                'message'
            ]);
    }
}
