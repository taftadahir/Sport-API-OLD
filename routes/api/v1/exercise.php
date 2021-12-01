<?php

use App\Http\Controllers\api\v1\exercise\StoreExerciseController;
use Illuminate\Support\Facades\Route;

Route::post('/exercises', StoreExerciseController::class)
    ->name('exercise.store');
