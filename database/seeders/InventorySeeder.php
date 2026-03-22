<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventorySeeder extends Seeder
{
    public function run(): void
    {
        $startDate = Carbon::today();
        $days = 30;

        $data = [];

        // Assuming:
        // room_type_id = 1 (Standard)
        // room_type_id = 2 (Deluxe)

        for ($i = 0; $i < $days; $i++) {

            $date = $startDate->copy()->addDays($i);

            // Standard Room (5 rooms)
            for ($room = 1; $room <= 5; $room++) {
                $data[] = [
                    'room_type_id'   => 1,
                    'breakfast_price' => 500,
                    'available_on'   => $date,
                    'available_rooms'=> 5,
                    'room_number'    => 'S-' . $room,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }

            // Deluxe Room (5 rooms)
            for ($room = 1; $room <= 5; $room++) {
                $data[] = [
                    'room_type_id'   => 2,
                    'breakfast_price' => 800,
                    'available_on'   => $date,
                    'available_rooms'=> 5,
                    'room_number'    => 'D-' . $room,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ];
            }
        }

        DB::table('inventory')->insert($data);
    }
}