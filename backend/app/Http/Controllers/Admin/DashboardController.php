<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\Banner;

class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê tổng số lượng
        $stats = [
            'bookCount'      => Book::count(),
            'authorCount'    => Author::count(),
            'publisherCount' => Publisher::count(),
            'categoryCount'  => Category::count(),
            'bannerCount'    => Banner::count(),
            'totalViews'     => Book::sum('views'),
            'totalLikes'     => Book::sum('likes'),
        ];

        // 5 sách mới nhất
        $recentBooks = Book::latest()->take(5)->get();

        // Lượt xem theo danh mục (chỉ lấy danh mục có sách và tổng views > 0)
        $viewsByCategory = Category::with('books')->get()
            ->map(function ($category) {
                return [
                    'label' => $category->name,
                    'views' => $category->books->sum('views'),
                ];
            })->filter(fn($item) => $item['views'] > 0)->values();

        // Số lượng sách theo nhà xuất bản
        $booksByPublisher = Publisher::withCount('books')->get()
            ->map(fn($publisher) => [
                'name'         => $publisher->name,
                'books_count'  => $publisher->books_count,
            ]);

        return view('admin.dashboard', compact(
            'stats', 'recentBooks', 'viewsByCategory', 'booksByPublisher'
        ));
    }
}
