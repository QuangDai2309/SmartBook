<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $tags = $query->orderByDesc('id')->paginate(10);
        return view('admin.tags.index', compact('tags'));
    }



    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags',
        ]);

        Tag::create($validated + [
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Thêm tag thành công!');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:tags,slug,' . $tag->id,
        ]);

        $tag->update($validated + [
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.tags.index')->with('success', 'Cập nhật tag thành công!');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.index')->with('success', 'Xóa tag thành công!');
    }
}
