<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index(Request $request)
{
    $query = Publisher::query();

    if ($request->has('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $publishers = $query->orderBy('name')->paginate(10); // dùng paginate, không phải get()

    return view('admin.publishers.index', compact('publishers'));
}


    public function create()
    {
        return view('admin.publishers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        Publisher::create($request->only('name'));

        return redirect()->route('admin.publishers.index')->with('success', 'Nhà xuất bản đã được thêm.');
    }

    public function edit(Publisher $publisher)
    {
        return view('admin.publishers.edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $request->validate([
            'name' => 'required|max:100'
        ]);

        $publisher->update($request->only('name'));

        return redirect()->route('admin.publishers.index')->with('success', 'Nhà xuất bản đã được cập nhật.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return redirect()->route('admin.publishers.index')->with('success', 'Nhà xuất bản đã bị xóa.');
    }
}
