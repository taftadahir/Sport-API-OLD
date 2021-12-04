<?php

namespace App\Http\Controllers\api\v1\statistic;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use App\Models\Statistic;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class DeleteStatisticController extends Controller
{
    /**
     * Instantiate a new DeleteStatisticController instance.
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
    public function __invoke(Statistic $statistic)
    {
        if (auth()->id() != $statistic->user_id) {
            throw new AccessDeniedHttpException();
        }

        $statistic->delete();
        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.statistic.delete.success'),
                    'success' => true,
                    'code' => 200,
                ]
            ),
            200
        );
    }
}
