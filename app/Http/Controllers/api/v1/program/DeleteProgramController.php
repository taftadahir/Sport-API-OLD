<?php

namespace App\Http\Controllers\api\v1\program;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Models\Program;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeleteProgramController extends Controller
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
        if (auth()->id() != $program->created_by) {
            throw new AccessDeniedHttpException();
        }

        $program->delete();

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.program.delete.success'),
                    'success' => true,
                    'code' => 200,
                ]
            ),
            200
        );
    }
}
