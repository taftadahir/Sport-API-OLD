<?php

namespace App\Http\Controllers\api\v1\workout;

use App\Http\Controllers\Controller;
use App\Http\Requests\workout\StoreWorkoutRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\WorkoutResource;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\Set;
use App\Models\Workout;

class StoreWorkoutController extends Controller
{
    /**
     * Instantiate a new StoreWorkoutController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(StoreWorkoutRequest $request, Program $program, Exercise $exercise)
    {
        $validated = $request->validated();

        $workout = new Workout($validated);
        if (array_key_exists('set_id', $validated) && $validated['set_id'] != null) {
            $set = Set::where('id', $validated['set_id'])->first();
            $workout->set()->associate($set);
        }
        $workout->exercise()->associate($exercise);
        $program->workouts()->save($workout);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.workout.create.success'),
                    'success' => true,
                    'code' => 201,
                    'data' => [
                        'workout' => new WorkoutResource($workout)
                    ]
                ]
            ),
            201
        );
    }
}
