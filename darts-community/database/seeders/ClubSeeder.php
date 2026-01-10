<?php

namespace Database\Seeders;

use App\Models\Club;
use App\Models\Federation;
use Illuminate\Database\Seeder;

class ClubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the FFD federation
        $ffd = Federation::where('code', 'FFD')->first();

        if (!$ffd) {
            $this->command->warn('FFD Federation not found. Run FederationSeeder first.');
            return;
        }

        // Create sample French darts clubs
        $clubs = [
            ['name' => 'Darts Club Paris', 'city' => 'Paris'],
            ['name' => 'Les Flèches Lyonnaises', 'city' => 'Lyon'],
            ['name' => 'Darts Marseille', 'city' => 'Marseille'],
            ['name' => 'Club de Fléchettes de Bordeaux', 'city' => 'Bordeaux'],
            ['name' => 'Nantes Darts', 'city' => 'Nantes'],
            ['name' => 'Toulouse Darts Club', 'city' => 'Toulouse'],
            ['name' => 'Strasbourg Fléchettes', 'city' => 'Strasbourg'],
            ['name' => 'Lille Darts Association', 'city' => 'Lille'],
        ];

        foreach ($clubs as $clubData) {
            Club::create([
                'name' => $clubData['name'],
                'city' => $clubData['city'],
                'federation_id' => $ffd->id,
                'is_active' => true,
            ]);
        }
    }
}
