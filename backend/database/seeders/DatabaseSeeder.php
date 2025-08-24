<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Call the other table seeders
        $this->call([
            BookingsTableSeeder::class,
            ImagesTableSeeder::class,
            PaymentsTableSeeder::class,
            ReviewsTableSeeder::class,
            EventsTableSeeder::class,   // changed from ServicesTableSeeder → EventsTableSeeder
            AdminAccountSeeder::class
        ]);
    }
}
