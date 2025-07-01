<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // Thêm bài viết
    public function store(Request $request)
{
    if (!$request->title || !$request->content || !$request->category_id) {
        return response()->json(['message' => 'Thiếu thông tin bắt buộc'], 400);
    }

    $post = new Post();
    $post->title = $request->title;
    $post->content = $request->content;
    $post->image = $request->image;
    $post->category_id = $request->category_id;
    $post->save();

    return response()->json([
        'message' => 'Thêm bài viết thành công',
        'id'      => $post->id
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show($id)
{
    $post = Post::with('category')->find($id);

    if ($post) {
        return response()->json([
            'id'         => $post->id,
            'title'      => $post->title,
            'content'    => $post->content,
            'image'      => $post->image,
            'category'   => $post->category ? $post->category->name : null,
        ]);
    } else {
        return response()->json([
            'message' => 'Bài viết không tồn tại'
        ], 404);
    }
}

    /**
     * Update the specified resource in storage.
     */
    // Sửa bài viết
    public function update(Request $request, $id)
{
    $post = Post::find($id);

    if (!$post) {
        return response()->json(['message' => 'Bài viết không tồn tại'], 404);
    }

    if ($request->title) {
        $post->title = $request->title;
    }

    if ($request->content) {
        $post->content = $request->content;
    }

    if ($request->image !== null) {
        $post->image = $request->image;
    }

    if ($request->category_id) {
        $post->category_id = $request->category_id;
    }

    $post->save();

    return response()->json([
        'message' => 'Cập nhật bài viết thành công'
    ]);
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
