<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Instantiate a new LogoutController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke()
    {
        /**
         * @var User
         */
        $user = Auth::user();

        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->delete();

        return response()->json(new DataResource([
            'message' => __('messages.logout.success'),
            'success' => true,
            'code' => 200,
        ]));
    }
}
