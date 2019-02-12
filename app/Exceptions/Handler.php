<?php

namespace App\Exceptions;

use Response;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Spatie\QueryBuilder\Exceptions\InvalidFilterQuery;
use Symfony\Component\HttpFoundation\Response as HTTP;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\QueryBuilder\Exceptions\InvalidIncludeQuery;
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
     * @return \Illuminate\Http\Response | \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthenticationException) {
            if (session()->previousUrl() === null) {
                return redirect()->route('home')->with('side_content', 'login');
            }

            return back()->with('side_content', 'login');
        }

        if (
            $exception instanceof ModelNotFoundException
            || $exception instanceof NotFoundHttpException
        ) {
            return Response::custom('not_found', $exception, HTTP::HTTP_NOT_FOUND);
        }

        if ($exception instanceof UnauthorizedException) {
            return Response::custom('unauthorized', $exception, HTTP::HTTP_UNAUTHORIZED);
        }

        if (
            $exception instanceof InvalidFilterQuery
            || $exception instanceof InvalidIncludeQuery
        ) {
            return Response::custom('bad_request', $exception, HTTP::HTTP_BAD_REQUEST);
        }

        return parent::render($request, $exception);
    }
}
