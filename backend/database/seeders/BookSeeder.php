<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use Illuminate\Support\Str;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        // Ví dụ tạo 5 sách mẫu
        for ($i = 1; $i <= 5; $i++) {
            Book::create([
                'book_code'      => 'BOOK' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'title'          => 'Sách mẫu số ' . $i,
                'slug'           => Str::slug('Sách mẫu số ' . $i),
                'description'    => 'Đây là mô tả ngắn cho sách mẫu số ' . $i,
                'author_id'      => rand(1, 3), // đảm bảo đã có author_id 1-3
                'publisher_id'   => rand(1, 3), // đảm bảo đã có publisher_id 1-3
                'category_id'    => rand(1, 3), // đảm bảo đã có book_category_id 1-3

                'price'          => rand(100, 300) * 1000,
                'discount_price' => rand(1, 5) % 2 == 0 ? rand(50, 100) * 1000 : null,
                'book_type'      => ['physical', 'ebook'][rand(0, 1)],
                'stock'          => rand(10, 100),
                'is_featured'    => rand(0, 1),

                'published_year' => rand(2018, 2023),
                'language'       => 'Tiếng Việt',
                'page_count'     => rand(100, 500),
                'weight'         => rand(200, 800) / 10,
                'dimensions'     => '20x13x2 cm',
                'is_hidden'      => false,
                'status'         => ['available', 'coming_soon', 'unavailable'][rand(0, 2)],
            ]);
        }
    }
}
