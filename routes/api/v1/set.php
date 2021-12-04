<?php

use App\Http\Controllers\api\v1\set\DeleteSetController;
use App\Http\Controllers\api\v1\set\ShowSetController;
use App\Http\Controllers\api\v1\set\StoreSetController;
use App\Http\Controllers\api\v1\set\UpdateSetController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'programs/{program}/sets', 'as' => 'program.set.'],
    function () {
        Route::post('', StoreSetController::class)
            ->name('store');

        Route::put('/{set}', UpdateSetController::class)
            ->name('update');
    }
);

Route::get('sets/{set}', ShowSetController::class)
    ->name('program.set.show');

Route::delete('sets/{set}', DeleteSetController::class)
    ->name('program.set.destroy');
