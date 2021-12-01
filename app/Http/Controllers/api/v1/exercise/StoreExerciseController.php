<?php

namespace App\Http\Controllers\api\v1\exercise;

use App\Http\Controllers\Controller;
use App\Http\Requests\exercise\StoreExerciseRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreExerciseController extends Controller
{
    /**
     * Instantiate a new StoreExerciseController instance.
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
    public function __invoke(StoreExerciseRequest $request)
    {
        $validated = $request->validated();

        /**
         * @var User
         */
        $user = Auth::user();
        $exercise = new Exercise($validated);
        $user->exercises()->save($exercise);
        $exercise->refresh();

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.exercise.create.success'),
                    'success' => true,
                    'code' => 201,
                    'data' => [
                        'exercise' => new ExerciseResource($exercise)
                    ]
                ]
            ),
            201
        );
    }
}
