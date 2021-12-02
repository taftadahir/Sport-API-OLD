<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->realText(10),
            'days' => $this->faker->numberBetween(0, 100),
            'use_warm_up' => $this->faker->boolean,
            'use_program_set' => $this->faker->boolean,
            'use_workout_set' => $this->faker->boolean,
            'published' => false,
            'image' => $this->faker->slug,
            'created_by' => $this->faker->randomElement(User::select('id')->get())
        ];
    }

    public function published()
    {
        return $this->state(function (array $attributes) {
            return [
                'published' => true,
            ];
        });
    }

    public function name($name)
    {
        return $this->state(function (array $attributes) use ($name) {
            return [
                'name' => $name,
            ];
        });
    }

    public function createdBy($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'created_by' => $user->id,
            ];
        });
    }
}
