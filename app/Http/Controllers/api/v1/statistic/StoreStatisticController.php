<?php

namespace App\Http\Controllers\api\v1\statistic;

use App\Http\Controllers\Controller;
use App\Http\Requests\statistic\StoreStatisticRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\StatisticResource;
use App\Models\Statistic;
use App\Models\Workout;
use Illuminate\Support\Facades\Auth;

class StoreStatisticController extends Controller
{
    /**
     * Instantiate a new StoreStatisticController instance.
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
    public function __invoke(StoreStatisticRequest $request, Workout $workout)
    {
        $validated = $request->validated();
        $statistic = new Statistic($validated);
        $statistic->workout()->associate($workout);

        /**
         * @var User
         */
        $user = Auth::user();
        $user->statistics()->save($statistic);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.statistic.create.success'),
                    'success' => true,
                    'code' => 201,
                    'data' => [
                        'statistic' => new StatisticResource($statistic)
                    ]
                ]
            ),
            201
        );
    }
}
