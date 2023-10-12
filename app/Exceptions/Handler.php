<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            error_log($e);
            if ($request->is('api/*')) {
                if ($e instanceof AuthenticationException) {
                    return response()->json([
                        'message' => 'Unauthorized',
                    ], 401);
                }

                return response()->json([
                    'message' => $e->getMessage() ?? 'System Error',
                ], $e->getCode() <= 0 ? 500 : $e->getCode());
            } else {
                return null;
            }
        });
    }

}
