<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookFollow;

class BookFollowController extends Controller
{
 

    // Lấy danh sách sách đã follow
    public function getFollowedBooksByUser(Request $request)
    {
        $userId = auth()->id();

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xác thực người dùng'
            ], 401);
        }

        $bookIds = BookFollow::where('user_id', $userId)->pluck('book_id');
        $books = Book::whereIn('id', $bookIds)->get();

        return response()->json([
            'status' => true,
            'user_id' => $userId,
            'followed_books' => $books
        ]);
    }

    // Thêm sách vào danh sách yêu thích
    public function follow(Request $request)
    {
        $userId = auth()->id();
        $bookId = $request->input('book_id');

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xác thực người dùng'
            ], 401);
        }

        if (!$bookId) {
            return response()->json([
                'status' => false,
                'message' => 'book_id là bắt buộc'
            ], 400);
        }

        $book = Book::find($bookId);
        if (!$book) {
            return response()->json([
                'status' => false,
                'message' => 'Sách không tồn tại'
            ], 404);
        }

        $record = BookFollow::firstOrCreate([
            'user_id' => $userId,
            'book_id' => $bookId,
        ]);

        if (!$record->wasRecentlyCreated) {
            return response()->json([
                'status' => false,
                'message' => 'Sách đã có trong danh sách yêu thích'
            ], 409);
        }

        return response()->json([
            'status' => true,
            'message' => 'Đã thêm vào danh sách yêu thích',
            'data' => [
                'user_id' => $userId,
                'book_id' => $bookId,
                'book_title' => $book->title ?? null
            ]
        ]);
    }

    // Xóa sách khỏi danh sách yêu thích
    public function unfollow(Request $request)
    {
        $userId = auth()->id();
        $bookId = $request->input('book_id');

        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xác thực người dùng'
            ], 401);
        }

        if (!$bookId) {
            return response()->json([
                'status' => false,
                'message' => 'book_id là bắt buộc'
            ], 400);
        }

        $deleted = BookFollow::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'status' => false,
                'message' => 'Sách không có trong danh sách yêu thích'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Đã xóa khỏi danh sách yêu thích',
            'data' => [
                'user_id' => $userId,
                'book_id' => $bookId
            ]
        ]);
    }

    // Kiểm tra trạng thái follow
    public function checkFollowStatus(Request $request)
    {
        $userId = auth()->id();
        $bookId = $request->query('book_id');

        if (!$bookId) {
            return response()->json([
                'status' => false,
                'message' => 'book_id là bắt buộc'
            ], 400);
        }

        $isFollowed = BookFollow::where('user_id', $userId)
            ->where('book_id', $bookId)
            ->exists();

        return response()->json([
            'status' => true,
            'is_followed' => $isFollowed,
            'user_id' => $userId,
            'book_id' => $bookId
        ]);
    }
}
