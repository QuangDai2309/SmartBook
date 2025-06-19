<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Hot',
            'Miễn phí',
            'Đọc nhiều',
            'Top tháng',
            'Mới cập nhật',
            'Best seller',
            'Kinh điển',
            'Trinh thám',
            'Thiếu nhi',
            'Lãng mạn',
            'Kỹ năng sống',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag,
                'slug' => Str::slug($tag),
                'is_hidden' => false,
            ]);
        }
    }
}
    