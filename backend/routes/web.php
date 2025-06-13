<?php

<<<<<<< HEAD
use App\Http\Controllers\Home\BookController;
use App\Http\Controllers\Home\BuybookController;
use App\Http\Controllers\Home\EbookController;
=======
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublisherController;
>>>>>>> f1a15383b71f715a9a2828075d4b021cc99f54bb
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
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
=======
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('banners', BannerController::class);
});
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
>>>>>>> f1a15383b71f715a9a2828075d4b021cc99f54bb
