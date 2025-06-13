<?php

use Illuminate\Support\Facades\Route;

// Home (User-side) Controllers
use App\Http\Controllers\Home\BookController as HomeBookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\Home\EbookController;

// Admin Controllers
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublisherController;

Route::get('/', function () {
    return view('welcome');
});

// // ===================== API for client side =====================
// // api: Danh sách tất cả sách
// Route::get('api/books', [HomeBookController::class, 'index']);
// // api: Chi tiết sách
// Route::get('api/books/{id}', [HomeBookController::class, 'show']);
// // api: Sách điện tử
// Route::get('api/ebooks', [EbookController::class, 'Ebooks']);
// // api: Sách có thể mua
// Route::get('api/buyBooks', [BuybookController::class, 'buyBooks']);

// // Test route
// Route::get('/test-api', function () {
//     return response()->json(['message' => 'OK']);
// });

// ===================== Admin Routes =====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', AdminBookController::class);
    Route::resource('banners', BannerController::class);
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
