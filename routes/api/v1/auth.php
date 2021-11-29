<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterUserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterUserController::class)
    ->name('user.register');

Route::post('/login', LoginController::class)
    ->name('user.login');
