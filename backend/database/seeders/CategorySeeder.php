<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Manga'],
            ['id' => 2, 'name' => 'Fantasy'],
            ['id' => 3, 'name' => 'Science Fiction'],
            ['id' => 4, 'name' => 'Mystery'],
            ['id' => 5, 'name' => 'Thriller'],
            ['id' => 6, 'name' => 'Romance'],
            ['id' => 7, 'name' => 'Horror'],
            ['id' => 8, 'name' => 'Adventure'],
            ['id' => 9, 'name' => 'Young Adult'],
            ['id' => 10, 'name' => 'Non-fiction'],
        ]);
    }
}
