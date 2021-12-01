<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\auth\UpdateUserRequest;
use App\Http\Resources\v1\DataResource;
use App\Http\Resources\v1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UpdateUserController extends Controller
{
    /**
     * Instantiate a new UpdateUserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(UpdateUserRequest $request)
    {
        $validated = $request->validated();

        /**
         * @var \App\Models\User
         */
        $user = Auth::user();
        $user->update($validated);

        return response()->json(new DataResource([
            'message' => __('messages.user.update.success'),
            'success' => true,
            'code' => 200,
            'data' => [
                'user' => new UserResource($user)
            ]
        ]), 200);
    }
}
