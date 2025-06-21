<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with(['author', 'publisher', 'category']);

        if ($request->filled('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('title', 'like', "%$keyword%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        $books = $query->latest()->paginate(10);
        $categories = BookCategory::where('is_hidden', false)->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $authors = Author::where('is_hidden', false)->get();
        $publishers = Publisher::where('is_hidden', false)->get();
        $categories = BookCategory::where('is_hidden', false)->get();

        return view('admin.books.create', compact('authors', 'publishers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_code' => 'required|unique:books',
            'title' => 'required',
            'slug' => 'required|unique:books',
            'description' => 'nullable|string', // 👉 THÊM DÒNG NÀY
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'nullable|exists:book_categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'book_type' => 'required|in:physical,ebook',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,coming_soon,unavailable',
        ]);

        Book::create($validated + [
            'is_featured' => $request->has('is_featured'),
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Thêm sách thành công!');
    }

    public function edit(Book $book)
    {
        $authors = Author::where('is_hidden', false)->get();
        $publishers = Publisher::where('is_hidden', false)->get();
        $categories = BookCategory::where('is_hidden', false)->get();

        return view('admin.books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'book_code' => 'required|unique:books,book_code,' . $book->id,
            'title' => 'required',
            'slug' => 'required|unique:books,slug,' . $book->id,
            'description' => 'nullable|string', // 👉 THÊM DÒNG NÀY
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'nullable|exists:book_categories,id',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'book_type' => 'required|in:physical,ebook',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:available,coming_soon,unavailable',
        ]);

        $book->update($validated + [
            'is_featured' => $request->has('is_featured'),
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Cập nhật sách thành công!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Xóa sách thành công!');
    }
}
