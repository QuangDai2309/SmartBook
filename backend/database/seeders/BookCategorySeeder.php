<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Kinh Tế',
            'Văn Học',
            'Tâm Lý – Kỹ Năng',
            'Thiếu Nhi',
            'Tiểu Thuyết',
            'Công Nghệ Thông Tin',
        ];

        foreach ($categories as $index => $name) {
            DB::table('book_categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => 'Danh mục: ' . $name,
                'is_hidden' => false,
                'order_index' => $index + 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
