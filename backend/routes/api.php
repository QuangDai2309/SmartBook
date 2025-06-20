<?php

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BannerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\BookFollowController;
use App\Http\Controllers\Home\EbookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\RatingController;

// Lấy thông tin user bằng sanctum (nếu dùng Sanctum thôi)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/with-books', [AuthorController::class, 'indexWithBooks']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::get('/authors/{id}/with-books', [AuthorController::class, 'showWithBooks']);


Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/with-books', [CategoryController::class, 'indexWithBooks']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/{id}/with-books', [CategoryController::class, 'showWithBooks']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Public routes - không cần đăng nhập
Route::get('/books', [BookController::class, 'index']);
Route::get('/ebooks', [EbookController::class, 'Ebooks']);
Route::get('/buybooks', [BuybookController::class, 'buyBooks']);
Route::get('/books/search', [BookController::class, 'search']);
Route::get('/test-api', function () {
    return response()->json(['message' => 'API đang hoạt động ✅']);
});
Route::post('/register', [AuthController::class, 'register']);
// Route đăng nhập
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login/google', [GoogleController::class, 'redirectToGoogle']);

//api login google
Route::get('/google-redirect', function () {
    return view('auth.google-redirect'); // Tạo file blade này
});

Route::get('/login/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// routes/api.php
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
    
Route::get('/reset-password', function (Request $request) {
    return view('auth.reset-password', [
        'token' => $request->token,
        'email' => $request->email
    ]);
})->name('password.reset');


// Route lấy thông tin người dùng sau đăng nhập (DÙNG TOKEN NHƯ /me)
Route::get('/me', [AuthController::class, 'me']); // không cần middleware

// Protected routes - cần token Bearer (auth:api)

Route::get('/books/followed', [BookFollowController::class, 'getFollowedBooksByUser']);
Route::post('/books/follow', [BookFollowController::class, 'follow']);
Route::delete('/books/unfollow', [BookFollowController::class, 'unfollow']);
Route::get('/books/check-follow', [BookFollowController::class, 'checkFollowStatus']);


Route::prefix('banners')->group(function () {
    Route::get('/', [BannerController::class, 'index']);          // GET /api/banners
    Route::post('/', [BannerController::class, 'store']);         // POST /api/banners
    Route::get('/{id}', [BannerController::class, 'show']);       // GET /api/banners/{id}
    Route::put('/{id}', [BannerController::class, 'update']);     // PUT /api/banners/{id}
    Route::delete('/{id}', [BannerController::class, 'destroy']); // DELETE /api/banners/{id}
});


// Rating routes - yêu cầu authentication
Route::middleware('auth:api')->group(function () {
    // Tạo hoặc cập nhật rating
    Route::post('/ratings', [RatingController::class, 'store']);
    
    // Lấy rating của user cho một sách cụ thể
    Route::get('/ratings/book/{bookId}', [RatingController::class, 'getUserRating']);
    
    // Lấy tất cả ratings của user hiện tại
    Route::get('/ratings/my-ratings', [RatingController::class, 'getUserRatings']);
    
    // Xóa rating của user cho một sách
    Route::delete('/ratings/book/{bookId}', [RatingController::class, 'destroy']);
  
});

// Public route - không cần authentication
Route::get('/ratings/book/{bookId}/stats', [RatingController::class, 'getBookRatingStats']);
  Route::get('/ratings/book/{bookId}/filter', [RatingController::class, 'getRatingsByStar']);

// Quan trọng: đặt sau cùng để tránh nuốt route
Route::get('/books/{id}', [BookController::class, 'show']);
