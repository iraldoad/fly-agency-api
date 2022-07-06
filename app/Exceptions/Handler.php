<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Throwable $e, $request) {
            return $request->ajax()
            || $request->acceptsJson()
            || $request->expectsJson()
            || $request->isJson()
            || $request->wantsJson() ? match (true) {
                $e instanceof ValidationException
                => jsend_fail([
                    'errors' => $e->errors(),
                ]),

                $e->getPrevious() instanceof ModelNotFoundException
                => jsend_fail([
                    'message' => __('model.model_not_found', [
                        'model' => class_basename($e->getPrevious()->getModel()),
                        'key' => implode(', ', $e->getPrevious()->getIds()),
                    ])
                ]),

                $e instanceof ModelNotFoundException
                => jsend_fail([
                    'message' => __('model.model_not_found', [
                        'model' => class_basename($e->getModel()),
                        'key' => implode(', ', $e->getIds()),
                    ])
                ]),

                $e instanceof NotFoundHttpException
                => jsend_fail([
                    'message' => __('route.404_not_found')
                ]),

                $e instanceof UnauthorizedHttpException,
                    $e instanceof AuthorizationException
                => jsend_fail([
                    'message' => __('auth.unauthorized'),
                ]),

                default => jsend_error($e->getMessage()),
            } : $this;
        });
    }
}
