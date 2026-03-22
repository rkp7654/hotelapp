<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountSeeder extends Seeder
{
    public function run(): void
    {
        $data = [

            // 🔥 Long Stay Discounts (discount_type_id = 1)
            [
                'discount_type_id' => 1,
                'days' => 3,
                'discount' => 10.00, // 10%
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type_id' => 1,
                'days' => 5,
                'discount' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type_id' => 1,
                'days' => 7,
                'discount' => 20.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // 🔥 Last Minute Discounts (discount_type_id = 2)
            [
                'discount_type_id' => 2,
                'days' => 1,
                'discount' => 20.00, // 20%
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type_id' => 2,
                'days' => 2,
                'discount' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'discount_type_id' => 2,
                'days' => 3,
                'discount' => 10.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('discounts')->insert($data);
    }
}