<?php

use App\Http\Controllers\auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterUserController::class)
    ->name('user.register');
