<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookFollow;

class BookFollowController extends Controller
{

    public function getFollowedBooksByUser(Request $request)
    {
        $userId = $request->query('user_id'); // Lấy từ query param: ?user_id=1

        if (!$userId) {
            return response()->json(['error' => 'user_id is required'], 400);
        }

        $bookIds = BookFollow::where('user_id', $userId)->pluck('book_id');
        $books = Book::whereIn('id', $bookIds)->get();

        return response()->json([
            'user_id' => $userId,
            'followed_books' => $books
        ]);

    }
    // Thêm yêu thích
    public function follow(Request $request)
    {
        $userId = $request->input('user_id');
        $bookId = $request->input('book_id');

        if (!$userId || !$bookId) {
            return response()->json(['error' => 'user_id và book_id là bắt buộc'], 400);
        }

        BookFollow::firstOrCreate([
            'user_id' => $userId,
            'book_id' => $bookId,
        ]);

        return response()->json(['message' => 'Đã thêm vào danh sách yêu thích']);
    }

    // Xóa yêu thích
    public function unfollow(Request $request)
    {
        $userId = $request->input('user_id');
        $bookId = $request->input('book_id');

        if (!$userId || !$bookId) {
            return response()->json(['error' => 'user_id và book_id là bắt buộc'], 400);
        }

        BookFollow::where('user_id', $userId)->where('book_id', $bookId)->delete();

        return response()->json(['message' => 'Đã xóa khỏi danh sách yêu thích']);
    }
}