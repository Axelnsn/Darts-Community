<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Federation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Club>
 */
class ClubFactory extends Factory
{
    protected $model = Club::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => substr(fake()->company(), 0, 240) . ' Darts Club', // Max 255 chars, leave room for suffix
            'city' => fake()->city(),
            'federation_id' => Federation::factory(),
            'is_active' => true,
        ];
    }
}
