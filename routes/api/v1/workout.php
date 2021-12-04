<?php

use App\Http\Controllers\api\v1\workout\StoreWorkoutController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'programs/{program}/exercises/{exercise}/workouts', 'as' => 'program.exercise.workout.'],
    function () {
        Route::post('', StoreWorkoutController::class)
            ->name('store');
    }
);
