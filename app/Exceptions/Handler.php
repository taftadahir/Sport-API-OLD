<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'message' => __('messages.errors.401.unauthenticated')
            ], 401);
        });

        $this->renderable(function (Exception $e, $request) {
            if ($e->getPrevious() && $e->getPrevious() instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => __('messages.errors.404.model.no_found')
                ], 404);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => __('messages.errors.404.model.not_found')
            ], 404);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'message' => __('messages.errors.405.method.not_allowed', [
                    'method' => $request->getMethod()
                ])
            ], 405);
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json([
                'message' => __('messages.errors.403.unauthorized')
            ], 403);
        });
    }
}
