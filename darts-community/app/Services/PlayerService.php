<?php

namespace App\Services;

use App\Models\Player;
use App\Models\User;
use Illuminate\Support\Str;

class PlayerService
{
    /**
     * Create a new player for the given user.
     */
    public function createForUser(User $user): Player
    {
        return Player::create([
            'user_id' => $user->id,
            'public_slug' => $this->generateUniqueSlug($user),
        ]);
    }

    /**
     * Create a player for the user if one doesn't already exist.
     */
    public function createForUserIfNotExists(User $user): Player
    {
        return $user->player ?? $this->createForUser($user);
    }

    /**
     * Generate a unique public slug for the player.
     */
    protected function generateUniqueSlug(User $user): string
    {
        $baseSlug = $this->generateBaseSlug($user);
        $slug = $baseSlug;
        $counter = 1;

        while (Player::where('public_slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Generate a base slug from user data.
     */
    protected function generateBaseSlug(User $user): string
    {
        // Use email prefix as base, sanitized for URL
        $emailPrefix = Str::before($user->email, '@');

        return Str::slug($emailPrefix);
    }
}
