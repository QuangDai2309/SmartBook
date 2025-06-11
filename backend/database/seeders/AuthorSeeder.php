<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AuthorSeeder extends Seeder
{
    public function run()
    {
        DB::table('authors')->insert([
            ['id' => 1, 'name' => 'Eiichiro Oda'],
            ['id' => 2, 'name' => 'Masashi Kishimoto'],
            ['id' => 3, 'name' => 'J.K. Rowling'],
            ['id' => 4, 'name' => 'George R.R. Martin'],
            ['id' => 5, 'name' => 'Haruki Murakami'],
            ['id' => 6, 'name' => 'Stephen King'],
            ['id' => 7, 'name' => 'Agatha Christie'],
            ['id' => 8, 'name' => 'Dan Brown'],
            ['id' => 9, 'name' => 'Suzanne Collins'],
            ['id' => 10, 'name' => 'Neil Gaiman'],
        ]);
    }
}
