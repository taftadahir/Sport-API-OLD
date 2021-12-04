<?php

namespace App\Http\Controllers\api\v1\workout;

use App\Http\Controllers\Controller;
use App\Http\Requests\workout\UpdateWorkoutRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\WorkoutResource;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\Workout;

class UpdateWorkoutController extends Controller
{
    /**
     * Instantiate a new UpdateWorkoutController instance.
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
    public function __invoke(UpdateWorkoutRequest $request, Program $program, Exercise $exercise, Workout $workout)
    {
        $validated = $request->validated();
        if ($program->id != $workout->program_id) {
            $workout->program()->associate($program);
        }
        if ($exercise->id != $workout->exercise_id) {
            $workout->exercise()->associate($exercise);
        }
        $workout->update($validated);
        $workout->refresh()->with('exercise');

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.workout.update.success'),
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'workout' => new WorkoutResource($workout)
                    ]
                ]
            )
        );
    }
}
