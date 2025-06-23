<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

// Auth Controllers
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\GoogleController; 
use App\Http\Controllers\ProfileController;

<<<<<<< HEAD

// Auth
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ProfileController;
=======
// Admin Controllers
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PublisherController;

// Home Controllers
use App\Http\Controllers\Home\BookController as HomeBookController;
use App\Http\Controllers\Home\EbookController;
>>>>>>> khiem

// ===================== Public Routes =====================
Route::get('/', function () {
    return view('welcome');
});

// Route xem sách ở giao diện người dùng
Route::resource('books', HomeBookController::class);

<<<<<<< HEAD
// Test API
Route::get('/test-api', function () {
    return response()->json(['message' => 'OK']);
});

// ===================== API Book Follow =====================
Route::get('api/followed-books', [BookFollowController::class, 'getFollowedBooksByUser']);
Route::post('api/books/follow', [BookFollowController::class, 'follow']);
Route::post('api/books/unfollow', [BookFollowController::class, 'unfollow']);


=======
// ===================== Admin Routes =====================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('authors', AuthorController::class);
    Route::resource('publishers', PublisherController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('books', BookController::class);
    Route::resource('banners', BannerController::class);

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Đặt ảnh chính
    Route::post('/book-images/{image}/set-main', [BookController::class, 'setMainImage'])->name('books.set-main-image');
    
    // Xoá ảnh
    Route::delete('/book-images/{image}', [BookController::class, 'deleteImage'])->name('books.delete-image');
});
>>>>>>> khiem

// ===================== Auth Routes =====================
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// ===================== Dashboard cho user thường =====================
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ===================== Profile =====================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===================== Test upload Cloudinary (tuỳ chọn) =====================
Route::post('/test-upload', function(Request $request) {
    $request->validate([
        'image' => 'required|image|max:2048'
    ]);

    $file = $request->file('image');

    $uploaded = Cloudinary::uploadFile($file->getRealPath(), [
        'upload_preset' => config('cloudinary.upload_preset')
    ]);

    return response()->json([
        'url' => $uploaded->getSecurePath()
    ]);
});

// ===================== Auth scaffolding =====================
require __DIR__.'/auth.php';
