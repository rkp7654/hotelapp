<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceWithPersonsSeeder extends Seeder
{
    public function run(): void
    {
        $inventories = DB::table('inventory')->get();

        $data = [];

        foreach ($inventories as $inventory) {

            // Base price logic (you can customize this)
            $basePrice = 1000;

            $data[] = [
                'inventory_id' => $inventory->id,
                'person_count' => 1,
                'price' => $basePrice,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $data[] = [
                'inventory_id' => $inventory->id,
                'person_count' => 2,
                'price' => $basePrice + 300,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $data[] = [
                'inventory_id' => $inventory->id,
                'person_count' => 3,
                'price' => $basePrice + 600,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('price_with_persons')->insert($data);
    }
}