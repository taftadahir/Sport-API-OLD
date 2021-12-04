<?php

namespace App\Http\Controllers\api\v1\set;

use App\Http\Controllers\Controller;
use App\Http\Requests\set\StoreSetRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\SetResource;
use App\Models\Program;
use App\Models\Set;
use Illuminate\Http\Request;

class StoreSetController extends Controller
{
    /**
     * Instantiate a new StoreSetController instance.
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
    public function __invoke(StoreSetRequest $request, Program $program)
    {
        $validated = $request->validated();
        $set = new Set($validated);
        $program->sets()->save($set);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.set.create.success'),
                    'success' => true,
                    'code' => 201,
                    'data' => [
                        'set' => new SetResource($set)
                    ]
                ]
            ),
            201
        );
    }
}
