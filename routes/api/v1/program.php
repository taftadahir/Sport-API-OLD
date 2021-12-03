<?php

use App\Http\Controllers\api\v1\program\DeleteProgramController;
use App\Http\Controllers\api\v1\program\ShowProgramController;
use App\Http\Controllers\api\v1\program\StoreProgramController;
use App\Http\Controllers\api\v1\program\UpdateProgramController;
use Illuminate\Support\Facades\Route;

Route::post('/programs', StoreProgramController::class)
    ->name('program.store');

Route::get('/programs/{program}', ShowProgramController::class)
    ->name('program.show');

Route::put('/programs/{program}', UpdateProgramController::class)
    ->name('program.update');

Route::delete('/programs/{program}', DeleteProgramController::class)
    ->name('program.destroy');
