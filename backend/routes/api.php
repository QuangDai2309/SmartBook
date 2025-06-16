<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\BookFollowController;
use App\Http\Controllers\Home\EbookController;
use App\Http\Controllers\Auth\AuthController;

// Lấy thông tin user bằng sanctum (nếu dùng Sanctum thôi)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes - không cần đăng nhập
Route::get('/books', [BookController::class, 'index']);
Route::get('/ebooks', [EbookController::class, 'listEbooks']);
Route::get('/test-api', function () {
    return response()->json(['message' => 'API đang hoạt động ✅']);
});

// Route đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Route lấy thông tin người dùng sau đăng nhập (DÙNG TOKEN NHƯ /me)
Route::get('/me', [AuthController::class, 'me']); // không cần middleware

// Protected routes - cần token Bearer (auth:api)
 
    Route::get('/books/followed', [BookFollowController::class, 'getFollowedBooksByUser']);
    Route::post('/books/follow', [BookFollowController::class, 'follow']);
    Route::delete('/books/unfollow', [BookFollowController::class, 'unfollow']);
    Route::get('/books/check-follow', [BookFollowController::class, 'checkFollowStatus']);
 
// Quan trọng: đặt sau cùng để tránh nuốt route
Route::get('/books/{id}', [BookController::class, 'show']);
