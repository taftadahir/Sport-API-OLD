<?php

use App\Http\Controllers\auth\DeleteUserController;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RegisterUserController;
use App\Http\Controllers\auth\UpdateUserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', RegisterUserController::class)
    ->name('user.register');

Route::post('/login', LoginController::class)
    ->name('user.login');

Route::delete('/logout', LogoutController::class)
    ->name('user.logout');

Route::delete('/user/delete', DeleteUserController::class)
    ->name('user.delete');

Route::put('/user/update', UpdateUserController::class)
    ->name('user.update');
