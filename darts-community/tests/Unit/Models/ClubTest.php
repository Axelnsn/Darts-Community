<?php

namespace Tests\Unit\Models;

use App\Models\Club;
use App\Models\Federation;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClubTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test club belongs to federation relationship.
     */
    public function test_club_belongs_to_federation(): void
    {
        $federation = Federation::factory()->create();
        $club = Club::factory()->create(['federation_id' => $federation->id]);

        $this->assertInstanceOf(Federation::class, $club->federation);
        $this->assertEquals($federation->id, $club->federation->id);
    }

    /**
     * Test club has many players relationship.
     */
    public function test_club_has_many_players(): void
    {
        $club = Club::factory()->create();

        // Create 3 users with their players (via observer) and assign them to the club
        for ($i = 0; $i < 3; $i++) {
            $user = \App\Models\User::factory()->create();
            $user->player->update(['club_id' => $club->id]);
        }

        $club->refresh();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $club->players);
        $this->assertCount(3, $club->players);
        $this->assertInstanceOf(Player::class, $club->players->first());
    }

    /**
     * Test club has proper fillable attributes.
     */
    public function test_club_fillable_attributes(): void
    {
        $federation = Federation::factory()->create();
        $club = Club::create([
            'name' => 'Darts Club Paris',
            'city' => 'Paris',
            'federation_id' => $federation->id,
            'is_active' => true,
        ]);

        $this->assertEquals('Darts Club Paris', $club->name);
        $this->assertEquals('Paris', $club->city);
        $this->assertEquals($federation->id, $club->federation_id);
        $this->assertTrue($club->is_active);
    }

    /**
     * Test club casts is_active to boolean.
     */
    public function test_club_casts_is_active_to_boolean(): void
    {
        $club = Club::factory()->create(['is_active' => 1]);

        $this->assertIsBool($club->is_active);
        $this->assertTrue($club->is_active);
    }

    /**
     * Test club is_active has correct default value.
     */
    public function test_club_is_active_has_default(): void
    {
        $club = Club::factory()->create();

        $this->assertTrue($club->is_active);
    }

    /**
     * Test that deleting a federation sets club federation_id to null (nullOnDelete).
     */
    public function test_federation_delete_sets_club_federation_id_to_null(): void
    {
        $federation = Federation::factory()->create();
        $club = Club::factory()->create(['federation_id' => $federation->id]);

        $this->assertNotNull($club->federation_id);
        $this->assertEquals($federation->id, $club->federation_id);

        // Delete the federation
        $federation->delete();

        // Refresh club and verify federation_id is now null
        $club->refresh();
        $this->assertNull($club->federation_id);
    }

    /**
     * Test that deleting a club sets player club_id to null (nullOnDelete).
     */
    public function test_club_delete_sets_player_club_id_to_null(): void
    {
        $club = Club::factory()->create();

        // Create a user with a player (via observer) and assign to club
        $user = \App\Models\User::factory()->create();
        $player = $user->player;
        $player->update(['club_id' => $club->id]);

        $this->assertNotNull($player->club_id);
        $this->assertEquals($club->id, $player->club_id);

        // Delete the club
        $club->delete();

        // Refresh player and verify club_id is now null
        $player->refresh();
        $this->assertNull($player->club_id);
    }

    /**
     * Test scope active filters inactive clubs.
     */
    public function test_scope_active_filters_inactive_clubs(): void
    {
        // Create 3 active clubs
        Club::factory()->count(3)->create(['is_active' => true]);

        // Create 2 inactive clubs
        Club::factory()->count(2)->create(['is_active' => false]);

        // Query using active scope
        $activeClubs = Club::active()->get();

        // Assert only 3 active clubs are returned
        $this->assertCount(3, $activeClubs);

        // Assert all returned clubs are active
        foreach ($activeClubs as $club) {
            $this->assertTrue($club->is_active);
        }
    }
}
