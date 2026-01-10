<?php

namespace Tests\Unit\Models;

use App\Models\Club;
use App\Models\Federation;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerRelationshipsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test player belongs to club relationship.
     */
    public function test_player_belongs_to_club(): void
    {
        $club = Club::factory()->create();
        $user = User::factory()->create();
        $player = $user->player; // Created via Observer
        $player->update(['club_id' => $club->id]);

        $this->assertInstanceOf(Club::class, $player->club);
        $this->assertEquals($club->id, $player->club->id);
    }

    /**
     * Test player belongs to federation relationship.
     */
    public function test_player_belongs_to_federation(): void
    {
        $federation = Federation::factory()->create();
        $user = User::factory()->create();
        $player = $user->player; // Created via Observer
        $player->update(['federation_id' => $federation->id]);

        $this->assertInstanceOf(Federation::class, $player->federation);
        $this->assertEquals($federation->id, $player->federation->id);
    }

    /**
     * Test player can have nullable club and federation.
     */
    public function test_player_can_have_nullable_club_and_federation(): void
    {
        $user = User::factory()->create();
        $player = $user->player; // Created via Observer

        $this->assertNull($player->club_id);
        $this->assertNull($player->federation_id);
    }
}
