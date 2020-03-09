<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($request->wantsJson()) {
            switch(true){
                case $exception instanceof \Illuminate\Auth\Access\AuthorizationException:
                    return response()->json([
                        'code' => 401,
                        'status' => 'Unauthorized',
                        'message' => $exception->getMessage(),
                        'errors' => [],
                        'data' => null
                    ])->setStatusCode(401);
                case $exception instanceof \Illuminate\Validation\ValidationException:
                    return response()->json([
                        'code' => $exception->status,
                        'status' => 'Unprocessable Entity',
                        'message' => $exception->getMessage(),
                        'errors' => $exception->errors(),
                        'data' => null
                    ])->setStatusCode($exception->status);
                case $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException:
                    $status = $exception->getStatusCode();
                    switch($status){
                        case 400:
                            return response()->json([
                                'code' => $status,
                                'status' => 'Bad Request',
                                'message' => $exception->getMessage(),
                                'errors' => [],
                                'data' => null
                            ])->setStatusCode($status);
                        case 401:
                            return response()->json([
                                'code' => $status,
                                'status' => 'Unauthorized',
                                'message' => $exception->getMessage(),
                                'errors' => [],
                                'data' => null
                            ])->setStatusCode($status);
                        case 403:
                            return response()->json([
                                'code' => $exception->getStatusCode(),
                                'status' => 'Forbidden',
                                'message' => $exception->getMessage(),
                                'errors' => [],
                                'data' => null
                            ])->setStatusCode($status);
                    }
                    break;
                default:
                    return response()->json([
                        'code' => 500,
                        'status' => 'Unknown',
                        'message' => $exception->getMessage(),
                        'errors' => [
                            [
                                'file' => $exception->getFile(),
                                'line' => $exception->getLine(),
                            ]
                        ],
                        'data' => null
                    ])->setStatusCode(500);
            }
        }
        return parent::render($request, $exception);
    }
}
