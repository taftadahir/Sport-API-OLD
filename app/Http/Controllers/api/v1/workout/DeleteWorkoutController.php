<?php

namespace App\Http\Controllers\api\v1\workout;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Models\Workout;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeleteWorkoutController extends Controller
{
    /**
     * Instantiate a new DeleteWorkoutController instance.
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
    public function __invoke(Workout $workout)
    {
        if (auth()->id() != $workout->program->created_by) {
            throw new AccessDeniedHttpException();
        }

        $workout->delete();

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.workout.delete.success'),
                    'success' => true,
                    'code' => 200
                ]
            ),
            200
        );
    }
}
