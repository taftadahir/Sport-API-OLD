<?php

namespace Tests\Feature\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function logoutWithValidToken()
    {
        $user = User::factory()->male()->create();
        Sanctum::actingAs($user);
        $logoutResp = $this->deleteJson(route('user.logout'));
        $logoutResp->assertStatus(200);
    }

    /**
     * @test
     */
    public function logoutWithInValidToken()
    {
        $response = $this->deleteJson(route('user.logout'));
        $response->assertUnauthorized();
    }
}
