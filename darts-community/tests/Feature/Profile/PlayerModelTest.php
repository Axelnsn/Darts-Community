<?php

namespace Tests\Feature\Profile;

use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlayerModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_model_exists(): void
    {
        $this->assertTrue(class_exists(Player::class));
    }

    public function test_player_has_correct_fillable_attributes(): void
    {
        $player = new Player();

        $expectedFillable = [
            'user_id',
            'first_name',
            'last_name',
            'nickname',
            'date_of_birth',
            'city',
            'skill_level',
            'profile_photo_path',
            'cover_photo_path',
            'public_slug',
        ];

        $this->assertEquals($expectedFillable, $player->getFillable());
    }

    public function test_player_belongs_to_user(): void
    {
        // Player is auto-created when user is created via observer
        $user = User::factory()->create();
        $player = $user->player;

        $this->assertInstanceOf(User::class, $player->user);
        $this->assertEquals($user->id, $player->user->id);
    }

    public function test_user_has_one_player(): void
    {
        // Player is auto-created when user is created via observer
        $user = User::factory()->create();

        $this->assertInstanceOf(Player::class, $user->player);
        $this->assertNotNull($user->player->id);
    }

    public function test_player_public_slug_is_unique(): void
    {
        $user1 = User::factory()->create(['email' => 'test@example.com']);
        $user2 = User::factory()->create(['email' => 'other@example.com']);

        // Update first player's slug to a specific value
        $user1->player->update(['public_slug' => 'unique-slug']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // Try to set same slug on second player
        $user2->player->update(['public_slug' => 'unique-slug']);
    }

    public function test_player_user_id_is_unique(): void
    {
        // Test that we cannot create two players for the same user
        $user = User::factory()->create();

        // Player already exists from observer
        $this->assertNotNull($user->player);

        $this->expectException(\Illuminate\Database\QueryException::class);

        // Try to create another player for same user
        Player::create([
            'user_id' => $user->id,
            'public_slug' => 'another-slug',
        ]);
    }

    public function test_player_date_of_birth_is_cast_to_date(): void
    {
        $user = User::factory()->create();

        // Update existing player with date of birth
        $user->player->update(['date_of_birth' => '1990-05-15']);
        $user->player->refresh();

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $user->player->date_of_birth);
        $this->assertEquals('1990-05-15', $user->player->date_of_birth->format('Y-m-d'));
    }

    public function test_player_fields_are_nullable(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        // Auto-created player should have null fields except user_id and public_slug
        $this->assertNull($player->first_name);
        $this->assertNull($player->last_name);
        $this->assertNull($player->nickname);
        $this->assertNull($player->date_of_birth);
        $this->assertNull($player->city);
        $this->assertNull($player->skill_level);
        $this->assertNull($player->profile_photo_path);
        $this->assertNull($player->cover_photo_path);
    }
}
