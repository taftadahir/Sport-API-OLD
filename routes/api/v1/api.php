<?php

use App\Http\Resources\v1\DataResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;


require __DIR__ . '/auth.php';

// Route fallback
Route::fallback(function () {
    return response()->json([
        'message' => __('messages.route.fallback'),
    ], 404);
});
