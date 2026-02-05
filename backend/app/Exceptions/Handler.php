<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

// JWT exceptions
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     */
    public function report(Throwable $e): void
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $e)
    {
        // --- JWT: token hết hạn ---
        if ($e instanceof TokenExpiredException) {
            return response()->json(['message' => 'Token hết hạn'], 401);
        }

        // --- JWT: token sai/biến dạng ---
        if ($e instanceof TokenInvalidException) {
            return response()->json(['message' => 'Token không hợp lệ'], 401);
        }

        // --- JWT: thiếu token / parse fail ---
        if ($e instanceof JWTException) {
            return response()->json(['message' => 'Thiếu token'], 401);
        }

        // --- Laravel auth fail (không có/không nhận ra user) ---
        if ($e instanceof AuthenticationException) {
            return response()->json(['message' => 'Chưa xác thực'], 401);
        }

        return parent::render($request, $e);
    }

    /**
     * (Option cho các bản Laravel cũ) Tùy biến phản hồi khi chưa auth.
     * Nếu project của ông đang có method này, giữ lại để đảm bảo JSON.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => 'Chưa xác thực'], 401);
    }
}
