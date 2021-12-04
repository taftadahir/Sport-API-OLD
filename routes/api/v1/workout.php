<?php

use App\Http\Controllers\api\v1\workout\ShowWorkoutController;
use App\Http\Controllers\api\v1\workout\StoreWorkoutController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'programs/{program}/exercises/{exercise}/workouts', 'as' => 'program.exercise.workout.'],
    function () {
        Route::post('', StoreWorkoutController::class)
            ->name('store');
    }
);

Route::get('workouts/{workout}', ShowWorkoutController::class)
    ->name('program.exercise.workout.show');
