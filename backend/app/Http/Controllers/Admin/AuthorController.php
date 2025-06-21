<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $query = Author::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $authors = $query->orderByDesc('id')->paginate(10);

        return view('admin.authors.index', compact('authors'));
    }


    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Author::create([
            'name' => $validated['name'],
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Thêm tác giả thành công!');
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $author->update([
            'name' => $validated['name'],
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Cập nhật tác giả thành công!');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Xóa tác giả thành công!');
    }
}
