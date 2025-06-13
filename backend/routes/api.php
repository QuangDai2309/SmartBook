<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\EbookController;

\Log::info('✅ API route file loaded'); // LOG kiểm tra

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::get('/ebooks', [EbookController::class, 'listEbooks']);
