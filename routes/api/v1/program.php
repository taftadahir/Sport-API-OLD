<?php

use App\Http\Controllers\api\v1\program\ShowProgramController;
use App\Http\Controllers\api\v1\program\StoreProgramController;
use Illuminate\Support\Facades\Route;

Route::post('/programs', StoreProgramController::class)
    ->name('program.store');

Route::get('/programs/{program}', ShowProgramController::class)
    ->name('program.show');
