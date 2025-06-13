<?php

use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\Home\EbookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//api allbooks
Route::get('api/books', [BookController::class, 'index']);
//api chitiet
Route::get('api/books/{id}', [BookController::class, 'show']);
//api ebooks
Route::get('api/ebooks', [EbookController::class, 'Ebooks']);
//api buy books
Route::get('api/buyBooks', [BuybookController::class, 'buyBooks']);

Route::resource('books', BookController::class);
Route::get('/test-api', function () {
    return response()->json(['message' => 'OK']);
});