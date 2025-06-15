<?php

use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\BookFollowController;
use App\Http\Controllers\Home\EbookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/ebooks', [EbookController::class, 'listEbooks']);
Route::post('books/follow', [BookFollowController::class, 'follow']);


Route::get('/followed-books', [BookFollowController::class, 'getFollowedBooksByUser']);

Route::post('/books/follow', [BookFollowController::class, 'follow']);
Route::post('/books/unfollow', [BookFollowController::class, 'unfollow']);
