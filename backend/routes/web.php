<?php

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


Route::get('/', function () {
    return view('welcome');
});

// ===================== Admin Routes =====================
// Home APIs
// Route::get('api/books', [HomeBookController::class, 'index']);
// Route::get('api/books/{id}', [HomeBookController::class, 'show']);
// Route::get('api/ebooks', [EbookController::class, 'Ebooks']);
// Route::get('api/buyBooks', [BuybookController::class, 'buyBooks']);
// Route::resource('books', HomeBookController::class);
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
