<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Lấy tất cả tác giả
     */
    public function index()
    {
        try {
            $authors = Author::all();
            
            return response()->json([
                'success' => true,
                'data' => $authors,
                'message' => 'Lấy danh sách tác giả thành công'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy tất cả tác giả kèm theo sách
     */
    public function indexWithBooks()
    {
        try {
            $authors = Author::with('books')->get();
            
            return response()->json([
                'success' => true,
                'data' => $authors,
                'message' => 'Lấy danh sách tác giả kèm sách thành công'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Lấy tác giả theo ID
     */
    public function show($id)
    {
        try {
            $author = Author::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $author,
                'message' => 'Lấy thông tin tác giả thành công'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy tác giả'
            ], 404);
        }
    }

    /**
     * Lấy tác giả theo ID kèm theo sách
     */
    public function showWithBooks($id)
    {
        try {
            $author = Author::with('books')->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $author,
                'message' => 'Lấy thông tin tác giả kèm sách thành công'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy tác giả'
            ], 404);
        }
    }
}