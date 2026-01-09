<?php

namespace Tests\Feature\Profile;

use App\Models\Player;
use App\Models\User;
use App\Services\PlayerService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerAutoCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_service_exists(): void
    {
        $this->assertTrue(class_exists(PlayerService::class));
    }

    public function test_player_created_automatically_on_user_factory(): void
    {
        // When user is created via factory, player is auto-created by observer
        $user = User::factory()->create();

        $this->assertNotNull($user->player);
        $this->assertInstanceOf(Player::class, $user->player);
        $this->assertEquals($user->id, $user->player->user_id);
        $this->assertNotNull($user->player->public_slug);
    }

    public function test_player_service_generates_unique_slug(): void
    {
        $user1 = User::factory()->create(['email' => 'user1@test.com']);
        $user2 = User::factory()->create(['email' => 'user2@test.com']);

        // Players auto-created by observer should have unique slugs
        $this->assertNotEquals($user1->player->public_slug, $user2->player->public_slug);
    }

    public function test_player_created_automatically_on_user_registration(): void
    {
        $response = $this->post('/register', [
            'email' => 'newuser@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'gdpr_consent' => true,
        ]);

        $user = User::where('email', 'newuser@example.com')->first();

        $this->assertNotNull($user);
        $this->assertNotNull($user->player);
        $this->assertInstanceOf(Player::class, $user->player);
        $this->assertNotNull($user->player->public_slug);
    }

    public function test_slug_format_is_valid(): void
    {
        $user = User::factory()->create(['email' => 'test-user@example.com']);

        // Slug should only contain lowercase letters, numbers, and hyphens
        $this->assertMatchesRegularExpression('/^[a-z0-9-]+$/', $user->player->public_slug);
    }

    public function test_player_not_created_if_already_exists(): void
    {
        $user = User::factory()->create();
        $service = new PlayerService();

        // Player already exists from observer
        $existingPlayer = $user->player;

        // Try to create again - should return existing player
        $player = $service->createForUserIfNotExists($user);

        $this->assertEquals($existingPlayer->id, $player->id);
        $this->assertEquals(1, Player::where('user_id', $user->id)->count());
    }

    public function test_same_email_prefix_generates_different_slugs(): void
    {
        // Two users with same email prefix but different domains
        $user1 = User::factory()->create(['email' => 'john@domain1.com']);
        $user2 = User::factory()->create(['email' => 'john@domain2.com']);

        // Should have different slugs (second one gets a counter)
        $this->assertNotEquals($user1->player->public_slug, $user2->player->public_slug);
        $this->assertEquals('john', $user1->player->public_slug);
        $this->assertEquals('john-1', $user2->player->public_slug);
    }
}
