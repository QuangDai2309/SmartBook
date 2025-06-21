<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        // 1. Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'), // nhớ đổi khi dùng thật
            'role' => 'admin',
            'is_hidden' => false,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Users thường
        for ($i = 1; $i <= 9; $i++) {
            DB::table('users')->insert([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'), // mật khẩu mặc định
                'phone' => '09000000' . $i,
                'address' => 'TP.HCM',
                'role' => 'user',
                'is_hidden' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
