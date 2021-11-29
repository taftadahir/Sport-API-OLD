<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\RegisterUserRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class RegisterUserController extends Controller
{
    public function __invoke(RegisterUserRequest $request)
    {
        $validated = $request->all();
        $user = User::create($validated);
        $token = $user->createToken($request->email);

        return response()->json(new DataResource(
            [
                'message' => __('messages.user.register.success'),
                'success' => true,
                'code' => 201,
                'data' => [
                    'token' => $token->plainTextToken,
                    'user' => new UserResource($user)
                ]
            ]
        ), 201);
    }
}
