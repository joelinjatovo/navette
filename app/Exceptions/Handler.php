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
            $validation = null;
            switch(true){
                case $exception instanceof \Illuminate\Auth\Access\AuthorizationException:
                    $status = 401;
                    $code = 101;
                    $errors = [];
                break;
                case $exception instanceof \Illuminate\Validation\ValidationException:
                    $status = $exception->status;
                    $code = 102;
                    $validation = $exception->errors();
                    $errors = [];
                break;
                case $exception instanceof \Symfony\Component\HttpKernel\Exception\HttpException:
                    $status = $exception->getStatusCode();
                    $code = 103;
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
                case $exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException:
                    $status = 404;
                    $code = 104;
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
                case $exception instanceof ApiKeyException:
                    $status = 401;
                    $code = 105;
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
                case $exception instanceof AccessTokenException:
                    $status = 401;
                    $code = 106;
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
                default:
                    $status = 500;
                    $code = 199;
                    $errors = [
                        [
                            'file' => $exception->getFile(),
                            'line' => $exception->getLine(),
                        ]
                    ];
                break;
            }

            return response()->json([
                'http_status' => $status,
                'status_code' => $code,
                'message' => $exception->getMessage(),
                'errors' => $errors,
                'validation' => $validation,
                'data' => null
            ])->setStatusCode(200);
        }
		
        return parent::render($request, $exception);
    }
}
