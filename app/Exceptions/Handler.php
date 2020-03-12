<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
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
                    $statusCode = 401;
                    $errors = [];
                break;
                case $exception instanceof \Illuminate\Validation\ValidationException:
                    $statusCode = $exception->status;
                    $errors = $exception->errors();
                break;
                case $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException:
                    $statusCode = $exception->getStatusCode();
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
                default:
                    $statusCode = 500;
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
            }

            return response()->json([
                'code' => $statusCode,
                'status' => isset(Response::$statusTexts[$statusCode]) ? Response::$statusTexts[$statusCode] : 'unknown status',
                'message' => $exception->getMessage(),
                'errors' => $errors,
                'data' => null
            ])->setStatusCode($statusCode);
        }
        return parent::render($request, $exception);
    }
}
