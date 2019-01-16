<?php

namespace App\Exceptions;

use Response;
use Exception;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return Response::modelNotFound($request);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response(
                [
                    'message'   =>  trans('http.not_found'),
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND,
                [
                    'Content-Type'  =>  enum('system.response.json'),
                ]
            );
        }

        if ($exception instanceof UnauthorizedException) {
            return response(
                [
                    'message'   =>  trans('http.unauthorized'),
                ],
                \Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED,
                [
                    'Content-Type'  =>  enum('system.response.json'),
                ]
            );
        }

        return parent::render($request, $exception);
    }
}
