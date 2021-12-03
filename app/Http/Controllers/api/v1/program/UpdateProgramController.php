<?php

namespace App\Http\Controllers\api\v1\program;

use App\Http\Controllers\Controller;
use App\Http\Requests\program\UpdateProgramRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\ProgramResource;
use App\Models\Program;
use Illuminate\Http\Request;

class UpdateProgramController extends Controller
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
    public function __invoke(UpdateProgramRequest $request, Program $program)
    {
        $validated = $request->validated();
        $program->update($validated);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.program.update.success'),
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
