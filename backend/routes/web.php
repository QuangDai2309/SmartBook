<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Home (User-side) Controllers
use App\Http\Controllers\Home\BookController as HomeBookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\Home\EbookController;

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublisherController;

use App\Http\Controllers\Auth\GoogleController; 
use App\Http\Controllers\ProfileController;
Route::get('/', function () {
    return view('welcome');
});


Route::get('api/books', [HomeBookController::class, 'index']);
Route::get('api/books/{id}', [HomeBookController::class, 'show']);
Route::get('api/ebooks', [EbookController::class, 'Ebooks']);
Route::get('api/buyBooks', [BuybookController::class, 'buyBooks']);
Route::resource('books', HomeBookController::class);
// Route::get('api/banners', [HomeController::class, 'banners']);

Route::get('/test-api', function () {
    return response()->json(['message' => 'OK']);
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', AdminBookController::class);
    Route::resource('banners', BannerController::class);
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';