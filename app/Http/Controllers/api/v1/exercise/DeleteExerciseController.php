<?php

namespace App\Http\Controllers\api\v1\exercise;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeleteExerciseController extends Controller
{
    /**
     * Instantiate a new DeleteExerciseController instance.
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
        if (auth()->id() != $exercise->created_by) {
            throw new AccessDeniedHttpException();
        }

        $exercise->delete();

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.exercise.delete.success'),
                    'success' => true,
                    'code' => 200,
                ]
            ),
            200
        );
    }
}
