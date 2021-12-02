<?php

namespace App\Http\Controllers\api\v1\program;

use App\Http\Controllers\Controller;
use App\Http\Requests\program\StoreProgramRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\ProgramResource;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class StoreProgramController extends Controller
{
    /**
     * Instantiate a new StoreProgramController instance.
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
    public function __invoke(StoreProgramRequest $request)
    {
        $validated = $request->validated();

        /**
         * @var User
         */
        $user = Auth::user();
        $program = new Program($validated);
        $user->programs()->save($program);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.program.create.success'),
                    'success' => true,
                    'code' => 201,
                    'data' => [
                        'program' => new ProgramResource($program)
                    ]
                ]
            ),
            201
        );
    }
}
