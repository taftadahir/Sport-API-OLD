<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\v1\DataResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeleteUserController extends Controller
{
    /**
     * Instantiate a new DeleteUserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        /**
         * @var User
         */
        $user = Auth::user();
        $user->tokens()->delete();
        $user->delete();

        return response()->json(new DataResource([
            'message' => __('messages.user.delete.success'),
            'success' => true,
            'code' => 200,
        ]));
    }
}
