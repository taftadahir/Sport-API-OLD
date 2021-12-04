<?php

use App\Http\Controllers\api\v1\set\ShowSetController;
use App\Http\Controllers\api\v1\set\StoreSetController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['prefix' => 'programs/{program}/sets', 'as' => 'program.set.'],
    function () {
        Route::post('', StoreSetController::class)
            ->name('store');

        Route::get('/{set}', ShowSetController::class)
            ->name('show');
    }
);
