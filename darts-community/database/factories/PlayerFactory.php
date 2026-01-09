<?php

namespace Database\Factories;

use App\Models\Player;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'nickname' => fake()->optional()->userName(),
            'date_of_birth' => fake()->optional()->dateTimeBetween('-60 years', '-18 years'),
            'city' => fake()->optional()->city(),
            'skill_level' => null,
            'profile_photo_path' => null,
            'cover_photo_path' => null,
            'public_slug' => fake()->unique()->slug(3),
        ];
    }
}
