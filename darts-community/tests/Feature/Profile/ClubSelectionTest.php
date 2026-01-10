<?php

namespace Tests\Feature\Profile;

use App\Models\Club;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClubSelectionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test club dropdown displays active clubs only.
     */
    public function test_club_dropdown_displays_active_clubs_only(): void
    {
        $user = User::factory()->create();

        // Create 2 active clubs
        $activeClub1 = Club::factory()->create(['name' => 'Active Club 1', 'is_active' => true]);
        $activeClub2 = Club::factory()->create(['name' => 'Active Club 2', 'is_active' => true]);

        // Create 1 inactive club
        $inactiveClub = Club::factory()->create(['name' => 'Inactive Club', 'is_active' => false]);

        $response = $this->actingAs($user)->get(route('player.profile.edit'));

        // Should see active clubs
        $response->assertSee($activeClub1->name);
        $response->assertSee($activeClub2->name);

        // Should NOT see inactive club
        $response->assertDontSee($inactiveClub->name);

        // Should see "Sans club" option
        $response->assertSee('Sans club');
    }

    /**
     * Test player can select a club.
     */
    public function test_player_can_select_club(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        $club = Club::factory()->create(['name' => 'Test Club']);

        $response = $this->actingAs($user)->put(route('player.profile.update'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'club_id' => $club->id,
        ]);

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'profile-updated');

        // Verify club_id persisted in database
        $player->refresh();
        $this->assertEquals($club->id, $player->club_id);
    }

    /**
     * Test player can select "Sans club" (no club).
     */
    public function test_player_can_select_no_club(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        // First assign a club
        $club = Club::factory()->create();
        $player->update(['club_id' => $club->id]);
        $this->assertNotNull($player->club_id);

        // Now remove club by sending null
        $response = $this->actingAs($user)->put(route('player.profile.update'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'club_id' => null,
        ]);

        $response->assertRedirect(route('player.profile.edit'));

        // Verify club_id is now null
        $player->refresh();
        $this->assertNull($player->club_id);
    }

    /**
     * Test selected club displays on profile view.
     */
    public function test_selected_club_displays_on_profile_view(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        $club = Club::factory()->create(['name' => 'My Darts Club', 'city' => 'Paris']);
        $player->update(['club_id' => $club->id]);

        $response = $this->actingAs($user)->get(route('player.profile.show'));

        $response->assertOk();
        $response->assertSee('My Darts Club');
        $response->assertSee('Paris');
        $response->assertSee('Affiliation');
    }

    /**
     * Test "Sans club" displays when no club selected.
     */
    public function test_no_club_displays_on_profile_view(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        // Ensure no club assigned
        $player->update(['club_id' => null]);

        $response = $this->actingAs($user)->get(route('player.profile.show'));

        $response->assertOk();
        $response->assertSee('Sans club');
        $response->assertSee('Affiliation');
    }

    /**
     * Test validation rejects invalid club_id.
     */
    public function test_validation_rejects_invalid_club_id(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('player.profile.update'), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'club_id' => 99999, // Non-existent club ID
        ]);

        $response->assertSessionHasErrors('club_id');
    }

    /**
     * Test club dropdown shows club with city correctly.
     */
    public function test_club_dropdown_displays_club_with_city(): void
    {
        $user = User::factory()->create();

        $clubWithCity = Club::factory()->create([
            'name' => 'Club Paris',
            'city' => 'Paris',
            'is_active' => true,
        ]);

        $clubWithoutCity = Club::factory()->create([
            'name' => 'Club Lyon',
            'city' => null,
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get(route('player.profile.edit'));

        $response->assertOk();
        // Club with city should display "Name - City"
        $response->assertSee('Club Paris');
        $response->assertSee('Paris');
        // Club without city should just display name
        $response->assertSee('Club Lyon');
    }

    /**
     * Test old input is preserved on validation errors.
     */
    public function test_old_input_preserved_on_validation_error(): void
    {
        $user = User::factory()->create();
        $club = Club::factory()->create(['name' => 'Valid Club']);

        // Submit with valid club but invalid other field to trigger validation error
        $response = $this->actingAs($user)->put(route('player.profile.update'), [
            'first_name' => str_repeat('a', 300), // Exceeds max:255
            'club_id' => $club->id,
        ]);

        $response->assertSessionHasErrors('first_name');
        $response->assertRedirect();

        // Follow redirect to edit page
        $response = $this->actingAs($user)->get(route('player.profile.edit'));

        // Club should still be selected (via old() helper)
        $response->assertSee('value="' . $club->id . '"', false);
    }
}
