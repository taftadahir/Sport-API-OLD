<?php

namespace App\Http\Controllers\api\v1\set;

use App\Http\Controllers\Controller;
use App\Http\Requests\set\UpdateSetRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\SetResource;
use App\Models\Program;
use App\Models\Set;

class UpdateSetController extends Controller
{
    /**
     * Instantiate a new UpdateSetController instance.
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
    public function __invoke(UpdateSetRequest $request, Program $program, Set $set)
    {
        $validated = $request->validated();

        if ($program->id != $set->program->id) {
            $set->program()->associate($program);
        }
        $set->update($validated);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.set.update.success'),
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
