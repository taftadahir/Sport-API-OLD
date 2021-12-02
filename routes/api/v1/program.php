<?php

use App\Http\Controllers\api\v1\program\StoreProgramController;
use Illuminate\Support\Facades\Route;

Route::post('/programs', StoreProgramController::class)
    ->name('program.store');
