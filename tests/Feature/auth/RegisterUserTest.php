<?php

namespace Tests\Feature\auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function registerUserWithValidDatas()
    {
        $user = User::factory()->unHash()->withConfirmation()->admin()->make();
        $this->postJson(route('user.register'), $user->getAttributes())
            ->assertStatus(201)
            ->assertJsonStructure([
                'service',
                'version',
                'language',
                'success',
                'message',
                'code',
                'support',
                'data' => [
                    'token',
                    'user' => [
                        'first_name',
                        'last_name',
                        'email',
                        'gender',
                        'avatar',
                        'created_at',
                        'updated_at',
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function registerUserWithInvalidDatas()
    {
        $user = User::factory()->email('Invalid Email Address')->unHash()->make();
        $this->postJson(route('user.register'), $user->getAttributes())
            ->assertStatus(422)
            ->assertJsonStructure([
                'service',
                'version',
                'language',
                'success',
                'message',
                'code',
                'support',
                'errors' => [
                    'email'
                ]
            ]);
    }
}
