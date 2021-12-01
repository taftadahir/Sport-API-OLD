<?php

namespace App\Exceptions;

use App\Http\Resources\v1\DataResource;
use BadMethodCallException;
use Exception;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
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

        // $this->renderable(function (RouteNotFoundException $e, $request) {
        //     return response()->json([
        //         'message' => __('messages.unauthenticated')
        //     ], 500);
        // });

        // $this->renderable(function (ServerException $e, $request) {
        //     return response()->json([
        //         'message' => __('messages.unauthenticatedx')
        //     ], 500);
        // });

        // $this->renderable(function (BadMethodCallException $e, $request) {
        //     return response()->json([
        //         'message' => __('messages.unauthenticatedx')
        //     ], 500);
        // });

        $this->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'message' => __('messages.unauthenticated')
            ], 401);
        });

        $this->renderable(function (Exception $e, $request) {
            if ($e->getPrevious() && $e->getPrevious() instanceof ModelNotFoundException) {
                return response()->json([
                    'message' => __('messages.model.no_found')
                ], 404);
            }
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'message' => __('messages.model.not_found')
            ], 404);
        });

        $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
            return response()->json([
                'message' => __('messages.method.not_allowed', [
                    'method' => $request->getMethod()
                ])
            ], 405);
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            return response()->json([
                'message' => __('messages.unauthorized')
            ], 403);
        });
    }

    /**
     * Convert a validation exception into a JSON response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Validation\ValidationException  $exception
     * @return \Illuminate\Http\JsonResponse
     */
    protected function invalidJson($request, ValidationException $exception)
    {
        return response()->json(new DataResource(
            [
                'message' => $exception->getMessage(),
                'success' => false,
                'code' => $exception->status,
                'errors' => $exception->errors()
            ]
        ), $exception->status);
    }
}
