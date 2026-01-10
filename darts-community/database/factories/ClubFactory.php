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
            'name' => fake()->company() . ' Darts Club',
            'city' => fake()->city(),
            'federation_id' => Federation::factory(),
            'is_active' => true,
        ];
    }
}
