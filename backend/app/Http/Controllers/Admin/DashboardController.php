<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;

class DashboardController extends Controller
{
    public function index()
    {
        $bookCount = Book::count();
        $authorCount = \App\Models\Author::count();
        $publisherCount = Publisher::count();
        $categoryCount = Category::count();
        $bannerCount = \App\Models\Banner::count();
        $totalViews = Book::sum('views');
        $totalLikes = Book::sum('likes');

        $recentBooks = Book::latest()->take(5)->get();

        // Lượt xem theo danh mục (chỉ lấy danh mục có sách và có views > 0)
        $viewsByCategory = Category::with('books')->get()
            ->map(function ($category) {
                return [
                    'label' => $category->name,
                    'views' => $category->books->sum('views'),
                ];
            })->filter(fn($item) => $item['views'] > 0)->values();

        // Số lượng sách theo nhà xuất bản (map lại cho đúng định dạng)
        $booksByPublisher = Publisher::withCount('books')->get()
            ->map(function ($publisher) {
                return [
                    'name' => $publisher->name,
                    'books_count' => $publisher->books_count,
                ];
            });

        return view('admin.dashboard', compact(
            'bookCount', 'authorCount', 'publisherCount', 'categoryCount',
            'bannerCount', 'totalViews', 'totalLikes', 'recentBooks',
            'viewsByCategory', 'booksByPublisher'
        ));
    }
}
