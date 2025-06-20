<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\BookFollowController;
use App\Http\Controllers\Home\EbookController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



// \log::info('✅ API route file loaded'); // LOG kiểm tra


Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/ebooks', [EbookController::class, 'listEbooks']);

Route::get('/followed-books', [BookFollowController::class, 'getFollowedBooksByUser']);
Route::post('/books/follow', [BookFollowController::class, 'follow']);
Route::post('/books/unfollow', [BookFollowController::class, 'unfollow']);
Route::get('/test-api', function () {
    return response()->json(['message' => 'API đang hoạt động ✅']);
});