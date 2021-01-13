<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // AuthorizationException::class,
        // HttpException::class,
        // ModelNotFoundException::class,
        // ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpResponseException || $exception instanceof QueryException) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        } elseif ($exception instanceof MethodNotAllowedHttpException) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_METHOD_NOT_ALLOWED);
        } elseif ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof AuthorizationException) {
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_UNAUTHORIZED);
        }  elseif ($exception instanceof ValidationException) {
            return response()->json(['message' => $exception->getMessage(), 'errors' => $exception->validator->getMessageBag()], 422);
        }else{
            return response()->json(['message' => $exception->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}
