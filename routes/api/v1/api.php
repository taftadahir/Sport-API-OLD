<?php

use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

require __DIR__ . '/exercise.php';

require __DIR__ . '/program.php';

require __DIR__ . '/set.php';

require __DIR__ . '/workout.php';

require __DIR__ . '/statistic.php';

// Route fallback
Route::fallback(function () {
    return response()->json([
        'message' => __('messages.route.fallback'),
    ], 404);
});
