<?php

namespace Tests\Feature\Profile;

use App\Enums\SkillLevel;
use App\Enums\WalkonSongType;
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

    // AC2: Cover photo displayed as header banner
    public function test_profile_shows_cover_photo_banner(): void
    {
        $user = User::factory()->create();
        $user->player->update(['cover_photo_path' => 'covers/test-cover.jpg']);

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('covers/test-cover.jpg');
        $response->assertSee('profile-cover-banner');
    }

    public function test_profile_shows_placeholder_when_no_cover_photo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('profile-cover-banner');
    }

    // AC3: Profile photo displayed as avatar overlay
    public function test_profile_shows_avatar_overlay(): void
    {
        $user = User::factory()->create();
        $user->player->update(['profile_photo_path' => 'profiles/test-avatar.jpg']);

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('profiles/test-avatar.jpg');
        $response->assertSee('profile-avatar-overlay');
    }

    public function test_profile_shows_default_avatar_when_no_photo(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('profile-avatar-overlay');
    }

    // AC5: Skill level badge visible
    public function test_profile_shows_skill_badge_when_set(): void
    {
        $user = User::factory()->create();
        $user->player->update(['skill_level' => SkillLevel::CONFIRME]);

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('skill-badge');
        $response->assertSee('Confirmé');
    }

    // AC6: Walk-on song player embedded
    public function test_profile_shows_walkon_player_when_configured(): void
    {
        $user = User::factory()->create();
        $user->player->update([
            'walkon_song_type' => WalkonSongType::YouTube,
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('walkon-player');
    }

    // AC7: Card-based layout for profile sections
    public function test_profile_uses_card_layout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        $response->assertSee('profile-card');
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

    // AC8: Mobile-responsive design tests
    public function test_profile_has_responsive_layout_classes(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        // Check for responsive padding classes
        $response->assertSee('py-6 sm:py-12', false);
        $response->assertSee('px-4 sm:px-6 lg:px-8', false);
    }

    public function test_profile_cover_has_responsive_height(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        // Cover should have mobile (h-48) and desktop (sm:h-64) heights
        $response->assertSee('h-48 sm:h-64', false);
    }

    public function test_profile_avatar_has_responsive_sizing(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        // Avatar should have mobile (w-32 h-32) and desktop (sm:w-40 sm:h-40) sizes
        $response->assertSee('w-32 h-32 sm:w-40 sm:h-40', false);
    }

    public function test_profile_layout_flexbox_responsive(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        // Layout should stack on mobile (flex-col) and row on desktop (sm:flex-row)
        $response->assertSee('flex-col sm:flex-row', false);
    }

    public function test_profile_grid_responsive(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile');

        // Grid should be 1 column on mobile, 2 on desktop
        $response->assertSee('grid-cols-1', false);
        $response->assertSee('sm:grid-cols-2', false);
    }

    // Profile Completeness Calculation Tests
    public function test_profile_completeness_calculates_percentage_correctly(): void
    {
        $user = User::factory()->create();

        // Empty profile should be 0%
        $response = $this->actingAs($user)->get('/player/profile');
        $response->assertSee('Profil incomplet (0%)');

        // Fill 4 out of 8 fields = 50%
        $user->player->update([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nickname' => 'JD',
            'city' => 'Paris',
        ]);

        $response = $this->actingAs($user)->get('/player/profile');
        $response->assertSee('Profil incomplet (50%)');
    }

    public function test_profile_completeness_shows_progress_bar(): void
    {
        $user = User::factory()->create();
        $user->player->update([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'city' => 'Paris',
        ]);

        $response = $this->actingAs($user)->get('/player/profile');

        // Should show progress bar with width style
        $response->assertSee('width: 38%', false); // 3/8 = 37.5% rounded to 38%
    }

    public function test_profile_completeness_hides_when_100_percent(): void
    {
        $user = User::factory()->create();
        $user->player->update([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'nickname' => 'JD',
            'date_of_birth' => '1990-01-01',
            'city' => 'Paris',
            'skill_level' => 'amateur',
            'profile_photo_path' => 'profiles/test.jpg',
            'cover_photo_path' => 'covers/test.jpg',
        ]);

        $response = $this->actingAs($user)->get('/player/profile');

        // Should NOT show incomplete profile hint
        $response->assertDontSee('Profil incomplet');
    }
}
