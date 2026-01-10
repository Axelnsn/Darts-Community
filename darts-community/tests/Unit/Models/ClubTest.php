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
}
