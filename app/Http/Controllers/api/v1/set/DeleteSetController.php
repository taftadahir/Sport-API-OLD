<?php

namespace App\Http\Controllers\api\v1\set;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Models\Set;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeleteSetController extends Controller
{
    /**
     * Instantiate a new DeleteSetController instance.
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
        if (auth()->id() != $set->program->created_by) {
            throw new AccessDeniedHttpException();
        }
        $set->delete();

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.set.delete.success'),
                    'success' => true,
                    'code' => 200,
                ]
            ),
            200
        );
    }
}
