<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublisherSeeder extends Seeder
{
    public function run()
    {
        DB::table('publishers')->insert([
            ['id' => 1, 'name' => 'Shueisha'],
            ['id' => 2, 'name' => 'Kodansha'],
            ['id' => 3, 'name' => 'Bloomsbury Publishing'],
            ['id' => 4, 'name' => 'Bantam Books'],
            ['id' => 5, 'name' => 'Vintage International'],
            ['id' => 6, 'name' => 'Scribner'],
            ['id' => 7, 'name' => 'HarperCollins'],
            ['id' => 8, 'name' => 'Doubleday'],
            ['id' => 9, 'name' => 'Scholastic'],
            ['id' => 10, 'name' => 'William Morrow'],
        ]);
    }
}
