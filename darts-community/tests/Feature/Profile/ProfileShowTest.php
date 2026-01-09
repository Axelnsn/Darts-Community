<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_profile_show_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertOk();
        $response->assertViewIs('pages.profile.show');
    }

    public function test_player_profile_show_page_requires_authentication(): void
    {
        $response = $this->get('/player/profile');

        $response->assertRedirect('/login');
    }

    public function test_player_profile_shows_all_fields(): void
    {
        $user = User::factory()->create();
        $user->player->update([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'nickname' => 'JD',
            'date_of_birth' => '1990-05-15',
            'city' => 'Paris',
        ]);

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('Jean');
        $response->assertSee('Dupont');
        $response->assertSee('JD');
        $response->assertSee('15/05/1990'); // French date format
        $response->assertSee('Paris');
    }

    public function test_player_profile_shows_french_labels(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('Prénom');
        $response->assertSee('Nom');
        $response->assertSee('Pseudo');
        $response->assertSee('Date de naissance');
        $response->assertSee('Ville');
    }

    public function test_player_profile_has_edit_link(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee(route('player.profile.edit'));
    }

    public function test_player_profile_handles_empty_fields(): void
    {
        $user = User::factory()->create();
        // Player has null fields by default

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertOk();
        // Should show placeholder or empty state for missing fields
        $response->assertSee('Non renseigné');
    }
}
