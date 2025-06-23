<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// ========== Auth Controllers ==========
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GoogleController;

// ========== Module Controllers ==========
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\EbookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\Home\BookFollowController;

// ========== Auth Routes ==========
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:api')->get('/me', [AuthController::class, 'me']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Google Login (frontend gửi token)
Route::post('/login/google', [GoogleController::class, 'loginWithGoogle']);

// ========== Public Book Routes ==========
Route::get('/books', [BookController::class, 'index']);
Route::get('/books/search', [BookController::class, 'search']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/ebooks', [EbookController::class, 'Ebooks']);
Route::get('/buybooks', [BuybookController::class, 'buyBooks']);

// ========== Author Routes ==========
Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/authors/with-books', [AuthorController::class, 'indexWithBooks']);
Route::get('/authors/{id}/with-books', [AuthorController::class, 'showWithBooks']);

// ========== Category Routes ==========
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/with-books', [CategoryController::class, 'indexWithBooks']);
Route::get('/categories/{id}/with-books', [CategoryController::class, 'showWithBooks']);

// (Tuỳ chọn - quản trị)
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// ========== Banner Routes ==========
Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);
    Route::post('/', [BannerController::class, 'store']);
    Route::get('/{id}', [BannerController::class, 'show']);
    Route::put('/{id}', [BannerController::class, 'update']);
    Route::delete('/{id}', [BannerController::class, 'destroy']);
});

// ========== Book Follow (cần đăng nhập) ==========
Route::middleware('auth:api')->group(function () {
    Route::get('/books/followed', [BookFollowController::class, 'getFollowedBooksByUser']);
    Route::post('/books/follow', [BookFollowController::class, 'follow']);
    Route::delete('/books/unfollow', [BookFollowController::class, 'unfollow']);
    Route::get('/books/check-follow', [BookFollowController::class, 'checkFollowStatus']);
});

// ========== Rating ==========
Route::get('/ratings/book/{bookId}/stats', [RatingController::class, 'getBookRatingStats']);
Route::get('/ratings/book/{bookId}/filter', [RatingController::class, 'getRatingsByStar']);

Route::middleware('auth:api')->group(function () {
    Route::post('/ratings', [RatingController::class, 'store']);
    Route::get('/ratings/book/{bookId}', [RatingController::class, 'getUserRating']);
    Route::get('/ratings/my-ratings', [RatingController::class, 'getUserRatings']);
    Route::delete('/ratings/book/{bookId}', [RatingController::class, 'destroy']);
});
