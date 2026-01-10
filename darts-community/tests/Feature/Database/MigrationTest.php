<?php

namespace Tests\Feature\Database;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that federations table rollback works correctly.
     */
    public function test_federations_table_rollback(): void
    {
        // Table should exist after migrations
        $this->assertTrue(Schema::hasTable('federations'));
        $this->assertTrue(Schema::hasColumns('federations', [
            'id', 'name', 'code', 'country', 'created_at', 'updated_at'
        ]));

        // Rollback the federations migration
        $this->artisan('migrate:rollback', [
            '--path' => 'database/migrations/2026_01_10_000001_create_federations_table.php'
        ]);

        // Table should not exist after rollback
        $this->assertFalse(Schema::hasTable('federations'));
    }

    /**
     * Test that clubs table rollback works correctly.
     */
    public function test_clubs_table_rollback(): void
    {
        // Table should exist after migrations
        $this->assertTrue(Schema::hasTable('clubs'));
        $this->assertTrue(Schema::hasColumns('clubs', [
            'id', 'name', 'city', 'federation_id', 'is_active', 'created_at', 'updated_at'
        ]));

        // Rollback the clubs migration
        $this->artisan('migrate:rollback', [
            '--path' => 'database/migrations/2026_01_10_000002_create_clubs_table.php'
        ]);

        // Table should not exist after rollback
        $this->assertFalse(Schema::hasTable('clubs'));
    }

    /**
     * Test that players table foreign keys rollback works correctly.
     */
    public function test_players_table_foreign_keys_rollback(): void
    {
        // Columns should exist after migrations
        $this->assertTrue(Schema::hasColumns('players', ['club_id', 'federation_id']));

        // Rollback the player foreign keys migration
        $this->artisan('migrate:rollback', [
            '--path' => 'database/migrations/2026_01_10_000003_add_club_and_federation_to_players_table.php'
        ]);

        // Foreign key columns should not exist after rollback
        $this->assertFalse(Schema::hasColumn('players', 'club_id'));
        $this->assertFalse(Schema::hasColumn('players', 'federation_id'));
    }

    /**
     * Test that all migrations can be rolled back and re-run successfully.
     */
    public function test_complete_migration_cycle(): void
    {
        // Verify tables exist
        $this->assertTrue(Schema::hasTable('federations'));
        $this->assertTrue(Schema::hasTable('clubs'));
        $this->assertTrue(Schema::hasColumn('players', 'club_id'));

        // Rollback all migrations
        $this->artisan('migrate:rollback');

        // Verify federation and club tables are gone
        $this->assertFalse(Schema::hasTable('federations'));
        $this->assertFalse(Schema::hasTable('clubs'));

        // Re-run migrations
        $this->artisan('migrate');

        // Verify tables exist again
        $this->assertTrue(Schema::hasTable('federations'));
        $this->assertTrue(Schema::hasTable('clubs'));
        $this->assertTrue(Schema::hasColumn('players', 'club_id'));
    }
}