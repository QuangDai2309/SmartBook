<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookFollow;

class BookFollowSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['book_id' => 8, 'user_id' => 1],
            ['book_id' => 9, 'user_id' => 1],
            ['book_id' => 10, 'user_id' => 1],
            ['book_id' => 11, 'user_id' => 1],
            ['book_id' => 12, 'user_id' => 1],
        ];

        foreach ($data as $item) {
            BookFollow::firstOrCreate($item);
        }
    }
}
