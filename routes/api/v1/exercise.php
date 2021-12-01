<?php

use App\Http\Controllers\api\v1\exercise\ShowExerciseController;
use App\Http\Controllers\api\v1\exercise\StoreExerciseController;
use App\Http\Controllers\api\v1\exercise\UpdateExerciseController;
use Illuminate\Support\Facades\Route;

Route::post('/exercises', StoreExerciseController::class)
    ->name('exercise.store');

Route::get('/exercises/{exercise}', ShowExerciseController::class)
    ->name('exercise.show');

Route::put('/exercises/{exercise}', UpdateExerciseController::class)
    ->name('exercise.update');
