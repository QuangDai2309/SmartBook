<?php

use Illuminate\Support\Facades\Route;

// Home (User-side) Controllers
use App\Http\Controllers\Home\BookController as HomeBookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\Home\EbookController;
use App\Http\Controllers\Home\BookFollowController;


// Auth
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;

// Trang chủ
Route::get('/', function () {
    return view('welcome');
});

// ===================== Home APIs =====================
Route::get('api/books', [HomeBookController::class, 'index']);
Route::get('api/books/{id}', [HomeBookController::class, 'show']);
Route::get('api/ebooks', [EbookController::class, 'Ebooks']);
Route::get('api/buyBooks', [BuybookController::class, 'buyBooks']);
Route::resource('books', HomeBookController::class);

// Test API
Route::get('/test-api', function () {
    return response()->json(['message' => 'OK']);
});

// ===================== API Book Follow =====================
Route::get('api/followed-books', [BookFollowController::class, 'getFollowedBooksByUser']);
Route::post('api/books/follow', [BookFollowController::class, 'follow']);
Route::post('api/books/unfollow', [BookFollowController::class, 'unfollow']);



// ===================== Auth & Google Login =====================
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ===================== Dashboard (User) =====================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ===================== User Profile =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Auth scaffolding
require __DIR__.'/auth.php';
