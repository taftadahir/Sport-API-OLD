<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Workout;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomElement(User::select('id')->get()),
            'workout_id' => $this->faker->randomElement(Workout::select('id')->get()),
            'reps' => $this->faker->numberBetween(0, 100),
            'time' => $this->faker->numberBetween(0, 1000000),
            'set' => $this->faker->numberBetween(0, 100),
        ];
    }

    public function user($user)
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }

    public function workout($workout)
    {
        return $this->state(function (array $attributes) use ($workout) {
            return [
                'workout_id' => $workout->id,
            ];
        });
    }
}
