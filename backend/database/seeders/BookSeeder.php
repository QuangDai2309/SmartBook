<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'title' => 'One Piece',
                'description' => 'Hành trình của Luffy để trở thành Vua Hải Tặc.',
                'author_id' => 1,
                'publisher_id' => 1,
                'category_id' => 1,
            ],
            [
                'title' => 'Naruto',
                'description' => 'Câu chuyện về ninja Uzumaki Naruto.',
                'author_id' => 2,
                'publisher_id' => 1,
                'category_id' => 1,
            ],
            [
                'title' => 'Attack on Titan',
                'description' => 'Cuộc chiến sinh tồn giữa loài người và Titan.',
                'author_id' => 3,
                'publisher_id' => 2,
                'category_id' => 1,
            ],
            [
                'title' => 'Doraemon',
                'description' => 'Chú mèo máy đến từ tương lai giúp đỡ Nobita.',
                'author_id' => 4,
                'publisher_id' => 3,
                'category_id' => 2,
            ],
            [
                'title' => 'Detective Conan',
                'description' => 'Thám tử học sinh bị teo nhỏ phá giải các vụ án.',
                'author_id' => 5,
                'publisher_id' => 3,
                'category_id' => 2,
            ],
            [
                'title' => 'Dragon Ball',
                'description' => 'Cuộc phiêu lưu của Son Goku từ bé đến khi trưởng thành.',
                'author_id' => 6,
                'publisher_id' => 1,
                'category_id' => 1,
            ],
            [
                'title' => 'Death Note',
                'description' => 'Cuốn sổ tử thần và cuộc đấu trí giữa L và Kira.',
                'author_id' => 7,
                'publisher_id' => 2,
                'category_id' => 3,
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'description' => 'Chiến đấu với lời nguyền để bảo vệ nhân loại.',
                'author_id' => 8,
                'publisher_id' => 2,
                'category_id' => 1,
            ],
            [
                'title' => 'Chainsaw Man',
                'description' => 'Chàng trai biến thành người máy cưa chống lại quỷ dữ.',
                'author_id' => 9,
                'publisher_id' => 2,
                'category_id' => 1,
            ],
            [
                'title' => 'Tokyo Revengers',
                'description' => 'Quay ngược thời gian để cứu người mình yêu.',
                'author_id' => 10,
                'publisher_id' => 2,
                'category_id' => 1,
            ],
        ];

        foreach ($books as $book) {Book::create($book);
        }
    }
}
