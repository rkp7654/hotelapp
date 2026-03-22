<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscountTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('discount_type')->insert([
            [
                'name' => 'Long Stay',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Last Minute',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}