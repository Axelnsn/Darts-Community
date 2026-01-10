<?php

namespace Tests\Feature\Database;

use App\Models\Club;
use App\Models\Federation;
use Database\Seeders\ClubSeeder;
use Database\Seeders\FederationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SeederTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test FederationSeeder creates FFD federation.
     */
    public function test_federation_seeder_creates_ffd(): void
    {
        $this->seed(FederationSeeder::class);

        $ffd = Federation::where('code', 'FFD')->first();

        $this->assertNotNull($ffd);
        $this->assertEquals('Fédération Française de Darts', $ffd->name);
        $this->assertEquals('FFD', $ffd->code);
        $this->assertEquals('France', $ffd->country);
    }

    /**
     * Test ClubSeeder creates sample clubs.
     */
    public function test_club_seeder_creates_sample_clubs(): void
    {
        $this->seed(FederationSeeder::class);
        $this->seed(ClubSeeder::class);

        $clubs = Club::all();

        $this->assertCount(8, $clubs);
        $this->assertTrue($clubs->contains('name', 'Darts Club Paris'));
        $this->assertTrue($clubs->contains('name', 'Les Flèches Lyonnaises'));
        $this->assertTrue($clubs->contains('name', 'Lille Darts Association'));
    }

    /**
     * Test clubs are associated with FFD federation.
     */
    public function test_clubs_are_associated_with_ffd(): void
    {
        $this->seed(FederationSeeder::class);
        $this->seed(ClubSeeder::class);

        $ffd = Federation::where('code', 'FFD')->first();
        $clubs = Club::all();

        foreach ($clubs as $club) {
            $this->assertEquals($ffd->id, $club->federation_id);
            $this->assertTrue($club->is_active);
        }
    }
}
