<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    /**
     * Lấy danh sách tất cả banners
     * GET /api/banners
     */
    public function index(): JsonResponse
    {
        $banners = Banner::all();
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy danh sách banner thành công',
            'data' => $banners
        ]);
    }

    /**
     * Tạo banner mới
     * POST /api/banners
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url'
        ]);

        // Upload image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner = Banner::create([
            'image' => $imagePath,
            'link' => $request->link
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tạo banner thành công',
            'data' => $banner
        ], 201);
    }

    /**
     * Lấy thông tin 1 banner
     * GET /api/banners/{id}
     */
    public function show($id): JsonResponse
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy banner'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin banner thành công',
            'data' => $banner
        ]);
    }

    /**
     * Cập nhật banner
     * PUT /api/banners/{id}
     */
    public function update(Request $request, $id): JsonResponse
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy banner'
            ], 404);
        }

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url'
        ]);

        // Upload image mới nếu có
        if ($request->hasFile('image')) {
            // Xóa image cũ
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            
            $imagePath = $request->file('image')->store('banners', 'public');
            $banner->image = $imagePath;
        }

        // Cập nhật link
        if ($request->has('link')) {
            $banner->link = $request->link;
        }

        $banner->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật banner thành công',
            'data' => $banner
        ]);
    }

    /**
     * Xóa banner
     * DELETE /api/banners/{id}
     */
    public function destroy($id): JsonResponse
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy banner'
            ], 404);
        }

        // Xóa file image
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa banner thành công'
        ]);
    }
}