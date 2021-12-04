<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\Program;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class WorkoutFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $exercise = Exercise::factory(10)->create();
        $program = Program::factory(10)->create();
        $prevable_type = $this->faker->randomElement(['program']); // , 'workout', 'set'
        return [
            'prevable_type' => $prevable_type,
            'prevable_id' => $this->faker->randomElement(DB::table($prevable_type . 's')->pluck('id')),
            'exercise_id' => $this->faker->randomElement(Exercise::select('id')->get()),
            'program_id' => $this->faker->randomElement(Program::select('id')->get()),
            'day' => $this->faker->numberBetween(0, 100),
            'reps_based' => $this->faker->boolean,
            'reps' => $this->faker->numberBetween(0, 100),
            'time_based' => $this->faker->boolean,
            'time' => $this->faker->numberBetween(0, 1000000),
            'set_number' => $this->faker->numberBetween(0, 100),
            'rest_time' => $this->faker->numberBetween(0, 10000000),
        ];
    }

    public function time_based()
    {
        return $this->state(function (array $attributes) {
            return [
                'time_based' => true,
            ];
        });
    }

    public function reps_based()
    {
        return $this->state(function (array $attributes) {
            return [
                'reps_based' => true,
            ];
        });
    }

    public function program($program)
    {
        return $this->state(function (array $attributes) use ($program) {
            return [
                'program_id' => $program->id,
            ];
        });
    }

    public function exercise($exercise)
    {
        return $this->state(function (array $attributes) use ($exercise) {
            return [
                'exercise_id' => $exercise->id,
            ];
        });
    }

    public function set($set)
    {
        return $this->state(function (array $attributes) use ($set) {
            return [
                'set_id' => $set->id,
            ];
        });
    }
}
