<?php

namespace App\Http\Controllers\api\v1\program;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowProgramController extends Controller
{
    /**
     * Instantiate a new ShowProgramController instance.
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
    public function __invoke(Program $program)
    {
        // Program is not published and user is not creator => 404
        if ((!$program->published) && auth()->id() != null && ($program->createdBy->id != auth()->id())) {
            throw new NotFoundHttpException();
        }

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.program.show.success'),
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'program' => new ProgramResource($program)
                    ]
                ]
            ),
            200
        );
    }
}
