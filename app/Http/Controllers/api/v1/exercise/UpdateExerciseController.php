<?php

namespace App\Http\Controllers\api\v1\exercise;

use App\Http\Controllers\Controller;
use App\Http\Requests\exercise\UpdateExerciseRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Http\Request;

class UpdateExerciseController extends Controller
{
    /**
     * Instantiate a new UpdateExerciseController instance.
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
    public function __invoke(UpdateExerciseRequest $request, Exercise $exercise)
    {
        $validated = $request->validated();
        $exercise->update($validated);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.exercise.update.success'),
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'exercise' => new ExerciseResource($exercise)
                    ]
                ]
            ),
            200
        );
    }
}
