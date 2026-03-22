<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('room_types')->updateOrInsert(
            ['name' => 'Standard Room'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        DB::table('room_types')->updateOrInsert(
            ['name' => 'Deluxe Room'],
            ['created_at' => now(), 'updated_at' => now()]
        );
    }
}
