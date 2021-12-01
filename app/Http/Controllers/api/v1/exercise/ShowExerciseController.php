<?php

namespace App\Http\Controllers\api\v1\exercise;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowExerciseController extends Controller
{
    /**
     * Instantiate a new ShowExerciseController instance.
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
    public function __invoke(Exercise $exercise)
    {
        // Exercise is not published and user is not creator => 404
        if ((!$exercise->published) && auth()->id() != null && ($exercise->created_by != auth()->id())) {
            throw new ModelNotFoundException();
        }

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.exercise.show.success'),
                    'success' => true,
                    'code' => 201,
                    'data' => [
                        'exercise' => new ExerciseResource($exercise)
                    ]
                ]
            ),
            200
        );
    }
}
