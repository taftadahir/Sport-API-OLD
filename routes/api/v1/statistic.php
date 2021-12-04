<?php

use App\Http\Controllers\api\v1\statistic\StoreStatisticController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'workouts/{workout}/statistics', 'as' => 'workouts.statistic.'],
    function () {
        Route::post('', StoreStatisticController::class)
            ->name('store');
    }
);
