<?php

namespace Tests\Unit\Models;

use App\Models\Club;
use App\Models\Federation;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FederationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test federation has many clubs relationship.
     */
    public function test_federation_has_many_clubs(): void
    {
        $federation = Federation::factory()->create();
        Club::factory()->count(3)->create(['federation_id' => $federation->id]);

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $federation->clubs);
        $this->assertCount(3, $federation->clubs);
        $this->assertInstanceOf(Club::class, $federation->clubs->first());
    }

    /**
     * Test federation has many players relationship.
     */
    public function test_federation_has_many_players(): void
    {
        $federation = Federation::factory()->create();

        // Create 2 users with their players (via observer) and assign them to the federation
        for ($i = 0; $i < 2; $i++) {
            $user = \App\Models\User::factory()->create();
            $user->player->update(['federation_id' => $federation->id]);
        }

        $federation->refresh();

        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $federation->players);
        $this->assertCount(2, $federation->players);
        $this->assertInstanceOf(Player::class, $federation->players->first());
    }

    /**
     * Test federation has proper fillable attributes.
     */
    public function test_federation_fillable_attributes(): void
    {
        $federation = Federation::create([
            'name' => 'Fédération Française de Darts',
            'code' => 'FFD',
            'country' => 'France',
        ]);

        $this->assertEquals('Fédération Française de Darts', $federation->name);
        $this->assertEquals('FFD', $federation->code);
        $this->assertEquals('France', $federation->country);
    }

    /**
     * Test federation code is unique.
     */
    public function test_federation_code_is_unique(): void
    {
        Federation::factory()->create(['code' => 'FFD']);

        $this->expectException(\Illuminate\Database\QueryException::class);
        Federation::factory()->create(['code' => 'FFD']);
    }

    /**
     * Test federation code must be exactly 3 uppercase letters.
     */
    public function test_federation_code_must_be_three_uppercase_letters(): void
    {
        // Valid codes should work
        $federation = Federation::create([
            'name' => 'Test Federation',
            'code' => 'ABC',
            'country' => 'France',
        ]);
        $this->assertEquals('ABC', $federation->code);

        // Test invalid formats
        $invalidCodes = [
            'ab',      // Too short
            'ABCD',    // Too long
            'abc',     // Lowercase
            'Ab1',     // Contains number
            'A-B',     // Contains special char
            '123',     // All numbers
        ];

        foreach ($invalidCodes as $invalidCode) {
            $this->expectException(\InvalidArgumentException::class);
            Federation::create([
                'name' => 'Test Federation',
                'code' => $invalidCode,
                'country' => 'France',
            ]);
        }
    }

    /**
     * Test federation code validation on update.
     */
    public function test_federation_code_validation_on_update(): void
    {
        $federation = Federation::factory()->create(['code' => 'ABC']);

        // Valid update should work
        $federation->update(['code' => 'XYZ']);
        $this->assertEquals('XYZ', $federation->code);

        // Invalid update should fail
        $this->expectException(\InvalidArgumentException::class);
        $federation->update(['code' => 'invalid']);
    }
}
