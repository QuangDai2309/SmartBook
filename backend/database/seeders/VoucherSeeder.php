<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $vouchers = [
            [
                'code' => 'GIAM10',
                'discount_type' => 'percentage',
                'discount_value' => 10,
                'max_discount' => 50000,
                'min_order_value' => 200000,
            ],
            [
                'code' => 'GIAM20',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'max_discount' => 80000,
                'min_order_value' => 300000,
            ],
            [
                'code' => 'SALE50K',
                'discount_type' => 'fixed',
                'discount_value' => 50000,
                'max_discount' => null,
                'min_order_value' => 150000,
            ],
            [
                'code' => 'BOOK100',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'max_discount' => null,
                'min_order_value' => 400000,
            ],
            [
                'code' => 'TET25',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'max_discount' => 100000,
                'min_order_value' => 500000,
            ],
            [
                'code' => 'SUMMER2025',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'max_discount' => 70000,
                'min_order_value' => 250000,
            ],
            [
                'code' => 'READMORE',
                'discount_type' => 'fixed',
                'discount_value' => 30000,
                'max_discount' => null,
                'min_order_value' => 100000,
            ],
            [
                'code' => 'EBOOK20',
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'max_discount' => 60000,
                'min_order_value' => 0,
            ],
            [
                'code' => 'HOTBOOK',
                'discount_type' => 'fixed',
                'discount_value' => 20000,
                'max_discount' => null,
                'min_order_value' => 50000,
            ],
            [
                'code' => 'NEWUSER',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'max_discount' => 40000,
                'min_order_value' => 100000,
            ],
        ];

        foreach ($vouchers as $item) {
            DB::table('vouchers')->insert([
                'code' => $item['code'],
                'discount_value' => $item['discount_value'],
                'discount_type' => $item['discount_type'],
                'max_discount' => $item['max_discount'],
                'min_order_value' => $item['min_order_value'],
                'description' => 'Mã giảm giá: ' . $item['code'],
                'quantity' => rand(10, 100),
                'is_hidden' => false,
                'start_date' => $now->copy()->subDays(rand(1, 5)),
                'end_date' => $now->copy()->addDays(rand(10, 60)),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
