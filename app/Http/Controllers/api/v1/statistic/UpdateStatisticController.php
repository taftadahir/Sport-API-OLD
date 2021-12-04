<?php

namespace App\Http\Controllers\api\v1\statistic;

use App\Http\Controllers\Controller;
use App\Http\Requests\statistic\UpdateStatisticRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\StatisticResource;
use App\Models\Statistic;
use App\Models\Workout;

class UpdateStatisticController extends Controller
{
    /**
     * Instantiate a new UpdateStatisticController instance.
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
    public function __invoke(UpdateStatisticRequest $request, Workout $workout, Statistic $statistic)
    {
        $validated = $request->validated();

        if ($workout->id != $statistic->workout_id) {
            $statistic->workout()->associate($workout);
        }
        $statistic->update($validated);

        return response()->json(
            new DataResource(
                [
                    'message' => __('messages.statistic.update.success'),
                    'success' => true,
                    'code' => 200,
                    'data' => [
                        'statistic' => new StatisticResource($statistic)
                    ]
                ]
            ),
            200
        );
    }
}
