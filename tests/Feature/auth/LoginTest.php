<?php

namespace Tests\Feature\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function loginWithValidCredential()
    {
        $user = User::factory()->create();

        $response = $this->postJson(route('user.login'), [
            'email' => $user->email,
            'password' => 'pass1234PASS@'
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'service', 'version', 'language', 'success', 'message', 'code', 'support',
            'data' => [
                'token',
                'user' => [
                    'first_name', 'last_name', 'email', 'gender', 'avatar', 'created_at', 'updated_at',
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function loginWithInvalidEmailAddress()
    {
        $this->postJson(route('user.login'), [
            'email' => 'Invalid Email Address',
            'password' => 'abc123@ABC123'
        ])
            ->assertStatus(422)
            ->assertJsonStructure([
                'service', 'version', 'language', 'success', 'message', 'code', 'support',
                'errors' => [
                    'email'
                ]
            ]);
    }

    /**
     * @test
     */
    public function loginWithTooMuchAttempts()
    {
        $user = User::factory()->create();
        for ($i = 0; $i < 4; $i++) {
            $response = $this->postJson(route('user.login'), [
                'email' => $user->email,
                'password' => 'xxpass1234PASS@'
            ]);
        }
        $response->assertStatus(422)->assertJsonStructure([
            'service', 'version', 'language', 'success', 'message', 'code', 'support',
            'errors' => [
                'message'
            ]
        ]);
    }
}
