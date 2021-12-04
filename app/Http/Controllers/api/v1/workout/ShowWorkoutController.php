<?php

namespace App\Http\Controllers\api\v1\workout;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\WorkoutResource;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\Workout;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowWorkoutController extends Controller
{
    /**
     * Instantiate a new ShowWorkoutController instance.
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
        $program = Program::where('id', $workout->program_id)->first();
        // Program is not published and user is not creator => 404
        if ((!$program->published) && auth()->id() != null && ($program->created_by != auth()->id())) {
            throw new NotFoundHttpException();
        }
        $workout->refresh()->with('exercise');

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.workout.show.success'),
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
