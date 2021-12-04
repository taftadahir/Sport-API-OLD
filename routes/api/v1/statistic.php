<?php

use App\Http\Controllers\api\v1\statistic\ShowStatisticController;
use App\Http\Controllers\api\v1\statistic\StoreStatisticController;
use App\Http\Controllers\api\v1\statistic\UpdateStatisticController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'workouts/{workout}/statistics', 'as' => 'workouts.statistic.'],
    function () {
        Route::post('', StoreStatisticController::class)
            ->name('store');

        Route::put('/{statistic}', UpdateStatisticController::class)
            ->name('update');
    }
);

Route::get('/statistics/{statistic}', ShowStatisticController::class)
    ->name('workouts.statistic.show');
