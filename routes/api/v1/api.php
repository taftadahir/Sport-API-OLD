<?php

use App\Http\Resources\v1\DataResource;
use App\Models\User;
use Illuminate\Support\Facades\Route;

// Route exemple
// Route::get('/', function ($locale) {
//     app()->setLocale($locale);
//     return new DataResource(
//         [
//             'code' => 401,
//             'message' => 'message from api',
//             'success' => true,
//             'data' => [
//                 'user' => [
//                     'name' => 'Taftadjani'
//                 ]
//             ]
//         ]
//     );
// });

// Route fallback
Route::fallback(function () {
    return response()->json([
        'message' => __('messages.errors.404.fallback_route'),
    ], 404);
});
