<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
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
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            $status = $exception->status;
            $message = collect($exception->errors())
                ->map(function ($item, $key) {
                    return [$key => $item[0]];
                })
                ->mapWithKeys(function ($item) {
                    return $item;
                })
                ->join(", ");
            return response()->json(
                [
                    'status' => (isset($message) ? $message : $exception->getMessage())
                ],
                Response::HTTP_BAD_REQUEST,
                ['Content-type'=>'application/problem+json; charset=utf-8']
            );
        } else {
            return response()->json(
                [
                    'status' => "Invalid resource",
                ],
                Response::HTTP_NOT_FOUND,
                ['Content-type'=>'application/problem+json; charset=utf-8']
            );
            //return parent::render($request, $exception);
        }

    }
}
