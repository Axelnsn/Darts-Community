<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed federations and clubs
        // Note: WithoutModelEvents trait affects all code in this run() method
        $this->call([
            FederationSeeder::class,
            ClubSeeder::class,
        ]);

        // User::factory(10)->create();

        // Note: This User creation benefits from WithoutModelEvents
        // (prevents duplicate Player creation since UserObserver will be disabled)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
