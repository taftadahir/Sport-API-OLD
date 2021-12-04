<?php

namespace App\Http\Controllers\api\v1\set;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\SetResource;
use App\Models\Program;
use App\Models\Set;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ShowSetController extends Controller
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
    public function __invoke(Program $program, Set $set)
    {
        // Program is not published and user is not creator => 404
        if (((!$program->published) && auth()->id() != null && ($program->createdBy->id != auth()->id())) || $program->id != $set->program_id) {
            throw new NotFoundHttpException();
        }

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.set.show.success'),
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'set' => new SetResource($set)
                    ]
                ]
            ),
            200
        );
    }
}
