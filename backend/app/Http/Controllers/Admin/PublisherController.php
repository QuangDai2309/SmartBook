<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $publishers = Publisher::when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.publishers.index', compact('publishers', 'keyword'));
    }

    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        Publisher::create([
            'name' => $validated['name'],
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.publishers.index')->with('success', 'Thêm NXB thành công!');
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
        ]);

        $publisher->update([
            'name' => $validated['name'],
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.publishers.index')->with('success', 'Cập nhật NXB thành công!');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')->with('success', 'Xóa NXB thành công!');
    }
}
