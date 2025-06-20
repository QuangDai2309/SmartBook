<?php

namespace Database\Seeders;

use App\Models\BookView;
use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class BookViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::pluck('id')->toArray();
        $users = User::pluck('id')->toArray();

        if (empty($books)) {
            $this->command->warn('❌ Không có sách nào để tạo lượt xem.');
            return;
        }

        for ($i = 0; $i < 20; $i++) {
            BookView::create([
                'book_id' => fake()->randomElement($books),
                'user_id' => fake()->optional()->randomElement($users),
                'view_count' => fake()->numberBetween(1, 10),
                'last_viewed_at' => Carbon::now()->subDays(rand(0, 30)),
            ]);
        }
    }
}
