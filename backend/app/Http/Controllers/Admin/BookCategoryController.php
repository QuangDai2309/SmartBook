<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookCategoryController extends Controller
{
    public function index(Request $request)
    {
        $parentCategories = BookCategory::whereNull('parent_id')->get();

        $categories = BookCategory::with('parent')
            ->when(
                $request->filled('keyword'),
                fn($q) => $q->where('name', 'like', '%' . $request->keyword . '%')
            )
            ->when(
                $request->filled('parent_id'),
                fn($q) => $q->where('parent_id', $request->parent_id)
            )
            ->orderBy('order_index')
            ->paginate(10);

        return view('admin.book_categories.index', compact('categories', 'parentCategories'));
    }

    public function create()
    {
        return view('admin.book_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:book_categories',
            'description' => 'nullable',
            'order_index' => 'nullable|integer',
        ]);

        BookCategory::create($validated + [
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.book_categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit(BookCategory $book_category)
    {
        return view('admin.book_categories.edit', ['category' => $book_category]);
    }

    public function update(Request $request, BookCategory $book_category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:book_categories,slug,' . $book_category->id,
            'description' => 'nullable',
            'order_index' => 'nullable|integer',
        ]);

        $book_category->update($validated + [
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.book_categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy(BookCategory $book_category)
    {
        $book_category->delete();
        return redirect()->route('admin.book_categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
