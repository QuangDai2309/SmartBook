<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $authors = Author::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%");
        })->orderBy('id', 'desc')->paginate(10);

        return view('admin.authors.index', compact('authors'));
    }


    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Author::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.authors.index')->with('success', 'Tác giả đã được thêm thành công!');
    }


    public function edit(Author $author)
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        $author->update([
            'name' => $request->name
        ]);

        return redirect()->route('admin.authors.index')->with('success', '✅ Tác giả đã được cập nhật.');
    }

    public function destroy(Author $author)
    {
        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', '🗑️ Tác giả đã bị xóa.');
    }
}
