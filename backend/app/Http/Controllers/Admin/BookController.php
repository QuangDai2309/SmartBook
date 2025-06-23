<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\BookImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'publisher', 'category'])->paginate(10);
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.books.create', compact('authors', 'publishers', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048'
        ]);

        $book = Book::create([
            'book_code' => 'BOOK-' . strtoupper(Str::random(8)),
            'slug' => Str::slug($request->title),
            'title' => $request->title,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        // Upload ảnh
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $uploadedImage = Cloudinary::upload($image->getRealPath());
                BookImage::create([
                    'book_id' => $book->id,
                    'image_url' => $uploadedImage->getSecurePath(),
                    'alt_text' => $book->title . ' - Ảnh ' . ($index + 1),
                    'is_main' => $index === 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.books.index')->with('success', 'Đã thêm sách mới.');
    }

    public function edit(Book $book)
    {
        $book->load('images');
        $authors = Author::all();
        $publishers = Publisher::all();
        $categories = Category::all();
        return view('admin.books.edit', compact('book', 'authors', 'publishers', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $book->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $uploadedImage = Cloudinary::upload($image->getRealPath());
                BookImage::create([
                    'book_id' => $book->id,
                    'image_url' => $uploadedImage->getSecurePath(),
                    'alt_text' => $book->title . ' - Ảnh thêm',
                    'is_main' => false,
                    'sort_order' => BookImage::where('book_id', $book->id)->max('sort_order') + 1,
                ]);
            }
        }

        return redirect()->route('admin.books.edit', $book)->with('success', 'Đã cập nhật sách.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Đã xóa sách.');
    }

    // 🧩 Đặt ảnh chính
    public function setMainImage(BookImage $image)
    {
        BookImage::where('book_id', $image->book_id)->update(['is_main' => false]);
        $image->update(['is_main' => true]);
        return back()->with('success', 'Đã đặt ảnh chính.');
    }

    // ❌ Xoá ảnh
    public function deleteImage(BookImage $image)
    {
        $image->delete();
        return back()->with('success', 'Đã xoá ảnh.');
    }
}
