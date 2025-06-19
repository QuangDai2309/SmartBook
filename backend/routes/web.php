<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookCategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class)->only(['index', 'edit', 'update', 'destroy']);
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('book_categories', BookCategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('books', BookController::class);
    Route::resource('banners', BannerController::class);
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
