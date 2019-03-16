<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Validation\UnauthorizedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        UnauthorizedException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        $status = 400;
        $error = [
            'message' => $e->getMessage(),
            'status' => $status,
        ];

        switch (true) {
            case is_a($e, ModelNotFoundException::class): {
                $status = 404;
                $error = [
                    'message' => 'The item was not found.',
                    'status' => $status,
                ];

                break;
            }
            case is_a($e, HttpException::class): {
                $status = 400;
                $error = [
                    'message' => 'Incorrect request.',
                    'status' => $status,
                ];

                break;
            }
            case is_a($e, UnauthorizedException::class): {
                $status = 401;
                $error = [
                    'message' => 'Unauthorized.',
                    'status' => $status,
                ];

                break;
            }
        }
        
        return response()->json([
            'error' => $error,
        ], $status);
    }
}
