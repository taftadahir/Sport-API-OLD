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
    public function __invoke(Set $set)
    {
        $program = Program::where('id', $set->program_id)->first();
        // Program is not published and user is not creator => 404
        if ((!$program->published) && auth()->id() != null && ($program->created_by != auth()->id())) {
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
