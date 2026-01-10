<?php

namespace Database\Seeders;

use App\Models\Federation;
use Illuminate\Database\Seeder;

class FederationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the French Darts Federation (FFD)
        Federation::create([
            'name' => 'Fédération Française de Darts',
            'code' => 'FFD',
            'country' => 'France',
        ]);
    }
}
