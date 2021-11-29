<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\LoginRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\UserResource;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $request->authenticate();
        /**
         * @var App\Model\User 
         */
        $user = auth()->user();

        $token = $user->createToken($request->email);
        return response()->json(new DataResource([
            'message' => __('messages.login.success'),
            'success' => true,
            'code' => 200,
            'data' => [
                'token' => $token->plainTextToken,
                'user' => new UserResource($user)
            ]
        ]), 200);
    }
}
