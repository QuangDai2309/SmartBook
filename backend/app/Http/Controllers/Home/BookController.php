<?php

namespace App\Http\Controllers\Home;


use App\Models\Author;
use App\Models\Category;
use App\Models\Publisher;
use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

public function index()
{
    $books = Book::with(['author', 'category', 'publisher'])->get();

    return response()->json([
        'status' => 'success',
        'data' => $books
    ]);
}


 // sách chi tiết
    public function show($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        // Xử lý tùy theo type
        if ($book->is_physical	 == 0) {
            // Sách giấy
            return response()->json([
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'pages' => $book->pages,
                'format' => 'paper',
            ]);
        } elseif ($book->is_physical == 1) {
            // Sách điện tử
            return response()->json([
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'file_url' => $book->file_url,
                'format' => 'ebook',
            ]);
        } else {
            return response()->json(['message' => 'Unknown book type'], 400);
        }
    }
}

