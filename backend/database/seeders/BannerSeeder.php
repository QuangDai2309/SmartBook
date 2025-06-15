<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('banners')->insert([
            [
                'image' => 'https://res.cloudinary.com/das2n0byo/image/upload/v1749198181/banner_uploads/y2uotvf5e3m9ieofiwk9.webp',
                'link' => 'https://example.com/banner1'
            ],
            [
                'image' => 'https://res.cloudinary.com/das2n0byo/image/upload/v1749198181/banner_uploads/y2uotvf5e3m9ieofiwk9.webp',
                'link' => 'https://example.com/banner2'
            ],
            [
                'image' => 'https://res.cloudinary.com/das2n0byo/image/upload/v1749198181/banner_uploads/y2uotvf5e3m9ieofiwk9.webp',
                'link' => 'https://example.com/banner3'
            ],
            [
                'image' => 'https://res.cloudinary.com/das2n0byo/image/upload/v1749198181/banner_uploads/y2uotvf5e3m9ieofiwk9.webp',
                'link' => 'https://example.com/banner4'
            ],
            [
                'image' => 'https://res.cloudinary.com/das2n0byo/image/upload/v1749198181/banner_uploads/y2uotvf5e3m9ieofiwk9.webp',
                'link' => 'https://example.com/banner5'
            ],
        ]);
    }
}
