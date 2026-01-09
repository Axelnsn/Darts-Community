<?php

namespace Tests\Feature\Profile;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoUploadTest extends TestCase
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

    // ========================================
    // Task 1: UploadService Tests (AC: 5, 6, 9)
    // ========================================

    public function test_upload_service_validates_mime_type(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        // Attempt to upload a non-image file
        $file = UploadedFile::fake()->create('document.pdf', 1000, 'application/pdf');

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_upload_service_validates_file_size(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        // Create a file larger than 5MB (5120KB)
        $file = UploadedFile::fake()->image('large.jpg')->size(6000);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_profile_photo_stored_in_avatars_directory(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('avatar.jpg', 800, 800);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect();

        $this->player->refresh();
        $this->assertNotNull($this->player->profile_photo_path);
        $this->assertStringStartsWith('avatars/', $this->player->profile_photo_path);
        Storage::disk('public')->assertExists($this->player->profile_photo_path);
    }

    public function test_cover_photo_stored_in_covers_directory(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('cover.jpg', 1200, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'cover',
            'photo' => $file,
        ]);

        $response->assertRedirect();

        $this->player->refresh();
        $this->assertNotNull($this->player->cover_photo_path);
        $this->assertStringStartsWith('covers/', $this->player->cover_photo_path);
        Storage::disk('public')->assertExists($this->player->cover_photo_path);
    }

    // ========================================
    // Task 2: ProfilePhotoController Tests (AC: 1, 2, 8)
    // ========================================

    public function test_user_can_upload_profile_photo(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('avatar.jpg', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'photo-updated');
    }

    public function test_user_can_upload_cover_photo(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('cover.jpg', 1200, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'cover',
            'photo' => $file,
        ]);

        $response->assertRedirect(route('player.profile.edit'));
        $response->assertSessionHas('status', 'photo-updated');
    }

    public function test_user_can_delete_profile_photo(): void
    {
        Storage::fake('public');

        // First upload a photo
        $this->player->update(['profile_photo_path' => 'avatars/test.jpg']);
        Storage::disk('public')->put('avatars/test.jpg', 'fake content');

        $this->actingAs($this->user);

        $response = $this->delete(route('player.profile.photo.destroy', ['type' => 'profile']));

        $response->assertRedirect(route('player.profile.edit'));

        $this->player->refresh();
        $this->assertNull($this->player->profile_photo_path);
        Storage::disk('public')->assertMissing('avatars/test.jpg');
    }

    public function test_user_can_delete_cover_photo(): void
    {
        Storage::fake('public');

        // First upload a photo
        $this->player->update(['cover_photo_path' => 'covers/test.jpg']);
        Storage::disk('public')->put('covers/test.jpg', 'fake content');

        $this->actingAs($this->user);

        $response = $this->delete(route('player.profile.photo.destroy', ['type' => 'cover']));

        $response->assertRedirect(route('player.profile.edit'));

        $this->player->refresh();
        $this->assertNull($this->player->cover_photo_path);
        Storage::disk('public')->assertMissing('covers/test.jpg');
    }

    public function test_old_photo_deleted_when_replaced(): void
    {
        Storage::fake('public');

        // Set up existing photo
        $this->player->update(['profile_photo_path' => 'avatars/old.jpg']);
        Storage::disk('public')->put('avatars/old.jpg', 'old content');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('new.jpg', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect();

        // Old file should be deleted
        Storage::disk('public')->assertMissing('avatars/old.jpg');

        // New file should exist
        $this->player->refresh();
        Storage::disk('public')->assertExists($this->player->profile_photo_path);
    }

    // ========================================
    // Task 3: Upload Form Request Tests (AC: 3, 4, 9)
    // ========================================

    public function test_accepts_jpg_format(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('photo.jpg', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors('photo');
    }

    public function test_accepts_png_format(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('photo.png', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors('photo');
    }

    public function test_accepts_webp_format(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('photo.webp', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionDoesntHaveErrors('photo');
    }

    public function test_rejects_gif_format(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('photo.gif', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('photo');
    }

    public function test_type_field_is_required(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('photo.jpg', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('type');
    }

    public function test_type_must_be_profile_or_cover(): void
    {
        Storage::fake('public');

        $this->actingAs($this->user);

        $file = UploadedFile::fake()->image('photo.jpg', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'invalid',
            'photo' => $file,
        ]);

        $response->assertSessionHasErrors('type');
    }

    // ========================================
    // Authentication Tests
    // ========================================

    public function test_guest_cannot_upload_photo(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('photo.jpg', 400, 400);

        $response = $this->post(route('player.profile.photo.store'), [
            'type' => 'profile',
            'photo' => $file,
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_delete_photo(): void
    {
        $response = $this->delete(route('player.profile.photo.destroy', ['type' => 'profile']));

        $response->assertRedirect(route('login'));
    }

    public function test_delete_with_invalid_type_returns_404(): void
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('player.profile.photo.destroy', ['type' => 'invalid']));

        $response->assertStatus(404);
    }

    // ========================================
    // Task 4: View Tests (AC: 1, 2, 7)
    // ========================================

    public function test_profile_edit_page_shows_profile_photo_upload_section(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Photo de profil');
        $response->assertSee('Choisir une image');
    }

    public function test_profile_edit_page_shows_cover_photo_upload_section(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Photo de couverture');
        $response->assertSee('format 3:1');
    }

    public function test_profile_edit_page_shows_default_placeholder_when_no_profile_photo(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('player.profile.edit'));

        $response->assertStatus(200);
        // Should not have a delete button when no photo
        $response->assertDontSee('action="' . route('player.profile.photo.destroy', ['type' => 'profile']) . '"');
    }

    public function test_profile_edit_page_shows_delete_button_when_profile_photo_exists(): void
    {
        $this->player->update(['profile_photo_path' => 'avatars/test.jpg']);

        $this->actingAs($this->user);

        $response = $this->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Supprimer');
    }

    public function test_profile_edit_page_shows_accepted_formats(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('JPG, PNG, WebP');
    }

    public function test_profile_edit_page_shows_max_file_size(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('5 Mo');
    }
}
