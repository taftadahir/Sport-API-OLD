<?php

use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

require __DIR__ . '/exercise.php';

// Route fallback
Route::fallback(function () {
    return response()->json([
        'message' => __('messages.route.fallback'),
    ], 404);
});
