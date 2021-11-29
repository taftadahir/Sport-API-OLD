<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'user_name' => $this->faker->userName,
            'full_name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('pass1234PASS@'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    public function unHash()
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => 'pass1234PASS@',
            ];
        });
    }

    public function withConfirmation()
    {
        return $this->state(function (array $attributes) {
            return [
                'password_confirmation' => 'pass1234PASS@',
            ];
        });
    }

    public function male()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => $this->faker->firstName('male'),
                'gender' => 'male',
            ];
        });
    }

    public function female()
    {
        return $this->state(function (array $attributes) {
            return [
                'first_name' => $this->faker->firstName('female'),
                'gender' => 'female',
            ];
        });
    }

    public function avatar($avatar = 'default')
    {
        return $this->state(function (array $attributes) use ($avatar) {
            return [
                'avatar' => $avatar,
            ];
        });
    }

    public function email($email)
    {
        return $this->state(function (array $attributes) use ($email) {
            return [
                'email' => $email,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'email' => 'admin@admin.com',
                'first_name' => 'admin',
                'last_name' => 'admin'
            ];
        });
    }
}
