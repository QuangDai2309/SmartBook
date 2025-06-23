<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookImage;
use Illuminate\Http\Request;

class BookImageController extends Controller
{
    public function destroy($id)
    {
        $image = BookImage::findOrFail($id);
        $image->delete();

        return back()->with('success', 'Đã xóa ảnh.');
    }

    public function setMain($id)
    {
        $image = BookImage::findOrFail($id);

        // Bỏ ảnh chính cũ
        BookImage::where('book_id', $image->book_id)->update(['is_main' => false]);

        // Gán ảnh mới làm chính
        $image->is_main = true;
        $image->save();

        return back()->with('success', 'Đã đặt ảnh chính.');
    }
}
