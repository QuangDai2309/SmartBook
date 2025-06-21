<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookCategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BookViewController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublisherController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VoucherController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::get('book_views', [BookViewController::class, 'index'])->name('book_views.index');
    Route::patch('users/{user}/toggle', [UserController::class, 'toggle'])->name('users.toggle');
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('book_categories', BookCategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('books', BookController::class);
    Route::resource('vouchers', VoucherController::class);
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
