<?php

namespace Tests\Feature\Profile;

use App\Enums\WalkonSongType;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WalkonSongTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected Player $player;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        // UserObserver creates Player automatically, so we get it instead of creating another
        $this->player = $this->user->player;
    }

    // =========================================
    // Task 1: WalkonSongController Tests
    // =========================================

    public function test_user_can_store_youtube_walkon_song(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'youtube',
                'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ]);

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'walkon-updated');

        $this->player->refresh();
        $this->assertEquals(WalkonSongType::YouTube, $this->player->walkon_song_type);
        $this->assertEquals('https://www.youtube.com/watch?v=dQw4w9WgXcQ', $this->player->walkon_song_url);
    }

    public function test_user_can_store_spotify_walkon_song(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'spotify',
                'walkon_song_url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
            ]);

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'walkon-updated');

        $this->player->refresh();
        $this->assertEquals(WalkonSongType::Spotify, $this->player->walkon_song_type);
        $this->assertEquals('https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT', $this->player->walkon_song_url);
    }

    public function test_user_can_store_mp3_walkon_song(): void
    {
        Storage::fake('public');

        // Create a fake MP3 file (small, under 10MB)
        $file = UploadedFile::fake()->create('walkon.mp3', 1024, 'audio/mpeg');

        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'mp3',
                'walkon_song_file' => $file,
            ]);

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'walkon-updated');

        $this->player->refresh();
        $this->assertEquals(WalkonSongType::Mp3, $this->player->walkon_song_type);
        $this->assertNotNull($this->player->walkon_song_url);
        Storage::disk('public')->assertExists($this->player->walkon_song_url);
    }

    public function test_user_can_destroy_walkon_song(): void
    {
        $this->player->update([
            'walkon_song_type' => WalkonSongType::YouTube,
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->actingAs($this->user)
            ->delete(route('player.profile.walkon.destroy'));

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'walkon-deleted');

        $this->player->refresh();
        $this->assertNull($this->player->walkon_song_type);
        $this->assertNull($this->player->walkon_song_url);
    }

    public function test_destroying_mp3_walkon_song_removes_file(): void
    {
        Storage::fake('public');

        $filePath = 'walkon/test-song.mp3';
        Storage::disk('public')->put($filePath, 'fake mp3 content');

        $this->player->update([
            'walkon_song_type' => WalkonSongType::Mp3,
            'walkon_song_url' => $filePath,
        ]);

        $this->actingAs($this->user)
            ->delete(route('player.profile.walkon.destroy'));

        Storage::disk('public')->assertMissing($filePath);
    }

    public function test_guest_cannot_store_walkon_song(): void
    {
        $response = $this->post(route('player.profile.walkon.store'), [
            'walkon_song_type' => 'youtube',
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_destroy_walkon_song(): void
    {
        $response = $this->delete(route('player.profile.walkon.destroy'));

        $response->assertRedirect(route('login'));
    }

    // =========================================
    // Task 2: URL Validation Tests
    // =========================================

    public function test_youtube_url_validation_accepts_valid_formats(): void
    {
        $validUrls = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://youtube.com/watch?v=dQw4w9WgXcQ',
            'https://youtu.be/dQw4w9WgXcQ',
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ&list=PLrAXtmErZgOeiKm4sgNOknGvNjby9efdf',
        ];

        foreach ($validUrls as $url) {
            $response = $this->actingAs($this->user)
                ->post(route('player.profile.walkon.store'), [
                    'walkon_song_type' => 'youtube',
                    'walkon_song_url' => $url,
                ]);

            $response->assertSessionDoesntHaveErrors('walkon_song_url');
        }
    }

    public function test_youtube_url_validation_rejects_invalid_formats(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'youtube',
                'walkon_song_url' => 'https://vimeo.com/123456',
            ]);

        $response->assertSessionHasErrors('walkon_song_url');
    }

    public function test_spotify_url_validation_accepts_valid_formats(): void
    {
        $validUrls = [
            'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
            'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT?si=abc123',
        ];

        foreach ($validUrls as $url) {
            $response = $this->actingAs($this->user)
                ->post(route('player.profile.walkon.store'), [
                    'walkon_song_type' => 'spotify',
                    'walkon_song_url' => $url,
                ]);

            $response->assertSessionDoesntHaveErrors('walkon_song_url');
        }
    }

    public function test_spotify_url_validation_rejects_invalid_formats(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'spotify',
                'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ]);

        $response->assertSessionHasErrors('walkon_song_url');
    }

    public function test_url_is_required_for_youtube_type(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'youtube',
            ]);

        $response->assertSessionHasErrors('walkon_song_url');
    }

    public function test_url_is_required_for_spotify_type(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'spotify',
            ]);

        $response->assertSessionHasErrors('walkon_song_url');
    }

    // =========================================
    // Task 3: MP3 Upload & Validation Tests
    // =========================================

    public function test_mp3_file_type_validation(): void
    {
        Storage::fake('public');

        // Try uploading a non-MP3 file
        $file = UploadedFile::fake()->create('song.txt', 100, 'text/plain');

        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'mp3',
                'walkon_song_file' => $file,
            ]);

        $response->assertSessionHasErrors('walkon_song_file');
    }

    public function test_mp3_file_size_validation_rejects_over_10mb(): void
    {
        Storage::fake('public');

        // Create a file over 10MB (10240 KB)
        $file = UploadedFile::fake()->create('walkon.mp3', 11000, 'audio/mpeg');

        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'mp3',
                'walkon_song_file' => $file,
            ]);

        $response->assertSessionHasErrors('walkon_song_file');
    }

    public function test_mp3_file_is_required_for_mp3_type(): void
    {
        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'mp3',
            ]);

        $response->assertSessionHasErrors('walkon_song_file');
    }

    public function test_mp3_stored_in_correct_directory(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->create('walkon.mp3', 1024, 'audio/mpeg');

        $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'mp3',
                'walkon_song_file' => $file,
            ]);

        $this->player->refresh();
        $this->assertStringStartsWith('walkon/', $this->player->walkon_song_url);
    }

    // =========================================
    // Task 4: User can switch between options
    // =========================================

    public function test_user_can_switch_from_youtube_to_spotify(): void
    {
        $this->player->update([
            'walkon_song_type' => WalkonSongType::YouTube,
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'spotify',
                'walkon_song_url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
            ]);

        $response->assertRedirect(route('player.profile.edit'));

        $this->player->refresh();
        $this->assertEquals(WalkonSongType::Spotify, $this->player->walkon_song_type);
        $this->assertEquals('https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT', $this->player->walkon_song_url);
    }

    public function test_switching_from_mp3_removes_old_file(): void
    {
        Storage::fake('public');

        $oldFilePath = 'walkon/old-song.mp3';
        Storage::disk('public')->put($oldFilePath, 'fake mp3 content');

        $this->player->update([
            'walkon_song_type' => WalkonSongType::Mp3,
            'walkon_song_url' => $oldFilePath,
        ]);

        $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'youtube',
                'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            ]);

        Storage::disk('public')->assertMissing($oldFilePath);
    }

    public function test_uploading_new_mp3_removes_old_mp3_file(): void
    {
        Storage::fake('public');

        $oldFilePath = 'walkon/old-song.mp3';
        Storage::disk('public')->put($oldFilePath, 'fake old mp3 content');

        $this->player->update([
            'walkon_song_type' => WalkonSongType::Mp3,
            'walkon_song_url' => $oldFilePath,
        ]);

        $newFile = UploadedFile::fake()->create('new-walkon.mp3', 1024, 'audio/mpeg');

        $this->actingAs($this->user)
            ->post(route('player.profile.walkon.store'), [
                'walkon_song_type' => 'mp3',
                'walkon_song_file' => $newFile,
            ]);

        // Old file should be deleted
        Storage::disk('public')->assertMissing($oldFilePath);

        // New file should exist
        $this->player->refresh();
        Storage::disk('public')->assertExists($this->player->walkon_song_url);
        $this->assertNotEquals($oldFilePath, $this->player->walkon_song_url);
    }

    // =========================================
    // Task 5: Walkon Player Component Tests
    // =========================================

    public function test_profile_view_shows_youtube_embed(): void
    {
        $this->player->update([
            'walkon_song_type' => WalkonSongType::YouTube,
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.show'));

        $response->assertStatus(200);
        $response->assertSee('youtube.com/embed/dQw4w9WgXcQ');
    }

    public function test_profile_view_shows_spotify_embed(): void
    {
        $this->player->update([
            'walkon_song_type' => WalkonSongType::Spotify,
            'walkon_song_url' => 'https://open.spotify.com/track/4cOdK2wGLETKBW3PvgPWqT',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.show'));

        $response->assertStatus(200);
        $response->assertSee('open.spotify.com/embed/track/4cOdK2wGLETKBW3PvgPWqT');
    }

    public function test_profile_view_shows_mp3_audio_player(): void
    {
        Storage::fake('public');

        $filePath = 'walkon/test-song.mp3';
        Storage::disk('public')->put($filePath, 'fake mp3 content');

        $this->player->update([
            'walkon_song_type' => WalkonSongType::Mp3,
            'walkon_song_url' => $filePath,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.show'));

        $response->assertStatus(200);
        $response->assertSee('<audio', false);
        $response->assertSee($filePath);
    }

    public function test_profile_view_without_walkon_song(): void
    {
        $this->player->update([
            'walkon_song_type' => null,
            'walkon_song_url' => null,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.show'));

        $response->assertStatus(200);
        $response->assertDontSee('youtube.com/embed');
        $response->assertDontSee('spotify.com/embed');
        $response->assertDontSee('<audio', false);
    }

    // =========================================
    // Task 4: Profile Edit View Tests
    // =========================================

    public function test_profile_edit_page_shows_walkon_song_section(): void
    {
        $response = $this->actingAs($this->user)
            ->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Walk-on Song');
        $response->assertSee('YouTube');
        $response->assertSee('Spotify');
        $response->assertSee('MP3');
    }

    public function test_profile_edit_page_shows_current_walkon_song_preview(): void
    {
        $this->player->update([
            'walkon_song_type' => WalkonSongType::YouTube,
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Musique actuelle');
        $response->assertSee('youtube.com/embed/dQw4w9WgXcQ');
    }

    public function test_profile_edit_page_shows_delete_button_when_walkon_exists(): void
    {
        $this->player->update([
            'walkon_song_type' => WalkonSongType::YouTube,
            'walkon_song_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Supprimer la musique');
    }

    public function test_profile_edit_page_hides_delete_button_when_no_walkon(): void
    {
        $this->player->update([
            'walkon_song_type' => null,
            'walkon_song_url' => null,
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertDontSee('Supprimer la musique');
    }

    // =========================================
    // Enum Tests
    // =========================================

    public function test_walkon_song_type_enum_exists(): void
    {
        $this->assertTrue(enum_exists(WalkonSongType::class));
        $this->assertEquals('youtube', WalkonSongType::YouTube->value);
        $this->assertEquals('spotify', WalkonSongType::Spotify->value);
        $this->assertEquals('mp3', WalkonSongType::Mp3->value);
    }
}
