<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Văn Học', 'parent_id' => null],
            ['name' => 'Văn Học Việt Nam', 'parent_id' => 1],
            ['name' => 'Văn Học Nước Ngoài', 'parent_id' => 1],
            ['name' => 'Kinh Tế - Kinh Doanh', 'parent_id' => null],
            ['name' => 'Tâm Lý – Kỹ Năng Sống', 'parent_id' => null],
            ['name' => 'Sách Thiếu Nhi', 'parent_id' => null],
            ['name' => 'Công Nghệ - Lập Trình', 'parent_id' => null],
            ['name' => 'Tiểu Thuyết Giả Tưởng', 'parent_id' => null],
            ['name' => 'Sách Giáo Khoa', 'parent_id' => null],
            ['name' => 'Sách Lịch Sử - Văn Hoá', 'parent_id' => null],
        ];

        foreach ($categories as $index => $cate) {
            DB::table('book_categories')->insert([
                'name' => $cate['name'],
                'slug' => Str::slug($cate['name']),
                'description' => 'Danh mục: ' . $cate['name'],
                'is_hidden' => false,
                'order_index' => $index + 1,
                'parent_id' => $cate['parent_id'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
