<?php

namespace App\Http\Controllers\Home;

use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Banner;

class BookController extends Controller
{
    public function index()
    {
        // 5 sách giấy được thích nhiều nhất
        $topLikedBooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 0)
            ->orderByDesc('likes')
            ->take(5)
            ->get();

        // 5 sách giấy được xem nhiều nhất
        $topViewedBooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 0)
            ->orderByDesc('views')
            ->take(5)
            ->get();

        // 10 sách giấy mới nhất
        $latestPaperBooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 0)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        // 10 sách ebook mới nhất
        $latestEbooks = Book::with(['author', 'category', 'publisher'])
            ->where('is_physical', 1)
            ->orderByDesc('created_at')
            ->take(10)
            ->get();

        return response()->json([
            'status' => 'success',
            'top_liked_books' => $topLikedBooks,         // 5 sách giấy yêu thích nhất
            'top_viewed_books' => $topViewedBooks,       // 5 sách giấy xem nhiều nhất
            'latest_paper_books' => $latestPaperBooks,   // 10 sách giấy mới
            'latest_ebooks' => $latestEbooks             // 10 sách điện tử mới
        ]);
    }


    // Chi tiết sách
    public function show($id)
    {
        $book = Book::with(['author', 'publisher', 'category'])->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found1'], 404);
        }

        if ($book->is_physical == 1) {
            // Sách giấy
            return response()->json([
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'author' => $book->author ? [
                    'id' => $book->author->id,
                    'name' => $book->author->name,
                ] : null,
                'publisher' => $book->publisher ? [
                    'id' => $book->publisher->id,
                    'name' => $book->publisher->name,
                ] : null,
                'category' => $book->category ? [
                    'id' => $book->category->id,
                    'name' => $book->category->name,
                ] : null,
                'price' => $book->price,
                'stock' => $book->stock,
                'views' => $book->views,
                'likes' => $book->likes,
                'format' => 'paper',
            ]);
        } elseif ($book->is_physical == 0) {
            // Sách điện tử
            return response()->json([
                'id' => $book->id,
                'title' => $book->title,
                'description' => $book->description,
                'cover_image' => $book->cover_image,
                'author' => $book->author ? [
                    'id' => $book->author->id,
                    'name' => $book->author->name,
                ] : null,
                'publisher' => $book->publisher ? [
                    'id' => $book->publisher->id,
                    'name' => $book->publisher->name,
                ] : null,
                'category' => $book->category ? [
                    'id' => $book->category->id,
                    'name' => $book->category->name,
                ] : null,
                'views' => $book->views,
                'likes' => $book->likes,
                'format' => 'ebook',
            ]);
        } else {
            return response()->json(['message' => 'Unknown book type'], 400);
        }
    }
}
    