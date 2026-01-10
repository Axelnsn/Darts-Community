<?php

namespace Database\Factories;

use App\Models\Federation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Federation>
 */
class FederationFactory extends Factory
{
    protected $model = Federation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => substr(fake()->company(), 0, 230) . ' Darts Federation', // Max 255 chars, leave room for suffix
            'code' => fake()->unique()->regexify('[A-Z]{3}'),
            'country' => fake()->country(),
        ];
    }
}
