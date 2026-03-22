<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoomTypeSeeder;
use Database\Seeders\InventorySeeder;
use Database\Seeders\PriceWithPersonsSeeder;
use Database\Seeders\DiscountTypeSeeder;
use Database\Seeders\DiscountSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoomTypeSeeder::class,
            InventorySeeder::class,
            PriceWithPersonsSeeder::class,
            DiscountTypeSeeder::class,
            DiscountSeeder::class,
        ]);


        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
