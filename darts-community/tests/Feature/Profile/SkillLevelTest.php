<?php

namespace Tests\Feature\Profile;

use App\Enums\SkillLevel;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkillLevelTest extends TestCase
{
    use RefreshDatabase;

    // ===========================================
    // Task 1: Skill Level Enum Tests (AC: 5)
    // ===========================================

    public function test_skill_level_enum_exists(): void
    {
        $this->assertTrue(enum_exists(SkillLevel::class));
    }

    public function test_skill_level_enum_has_correct_values(): void
    {
        $expectedValues = ['debutant', 'amateur', 'confirme', 'semi-pro', 'pro'];

        $actualValues = array_map(fn($case) => $case->value, SkillLevel::cases());

        $this->assertEquals($expectedValues, $actualValues);
    }

    public function test_skill_level_enum_has_french_labels(): void
    {
        $this->assertEquals('Débutant', SkillLevel::DEBUTANT->label());
        $this->assertEquals('Amateur', SkillLevel::AMATEUR->label());
        $this->assertEquals('Confirmé', SkillLevel::CONFIRME->label());
        $this->assertEquals('Semi-pro', SkillLevel::SEMI_PRO->label());
        $this->assertEquals('Pro', SkillLevel::PRO->label());
    }

    public function test_player_skill_level_is_cast_to_enum(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        $player->update(['skill_level' => 'amateur']);
        $player->refresh();

        $this->assertInstanceOf(SkillLevel::class, $player->skill_level);
        $this->assertEquals(SkillLevel::AMATEUR, $player->skill_level);
    }

    public function test_player_skill_level_can_be_null(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        $this->assertNull($player->skill_level);
    }

    public function test_player_skill_level_can_be_set_and_retrieved(): void
    {
        $user = User::factory()->create();
        $player = $user->player;

        foreach (SkillLevel::cases() as $level) {
            $player->update(['skill_level' => $level->value]);
            $player->refresh();

            $this->assertEquals($level, $player->skill_level);
        }
    }

    // ===========================================
    // Task 2: Profile Edit Form Tests (AC: 1, 2, 6)
    // ===========================================

    public function test_profile_edit_page_displays_skill_level_dropdown(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Niveau de jeu');
        $response->assertSee('skill_level');
    }

    public function test_profile_edit_dropdown_shows_all_french_labels(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('player.profile.edit'));

        $response->assertStatus(200);
        $response->assertSee('Débutant');
        $response->assertSee('Amateur');
        $response->assertSee('Confirmé');
        $response->assertSee('Semi-pro');
        $response->assertSee('Pro');
    }

    public function test_profile_edit_dropdown_has_no_default_selection(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('player.profile.edit'));

        $response->assertStatus(200);
        // Check for placeholder option
        $response->assertSee('Sélectionnez votre niveau');
    }

    public function test_skill_level_can_be_updated_via_profile_form(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('player.profile.update'), [
            'skill_level' => 'confirme',
        ]);

        $response->assertRedirect(route('player.profile.edit'));

        $user->refresh();
        $this->assertEquals(SkillLevel::CONFIRME, $user->player->skill_level);
    }

    public function test_skill_level_validation_rejects_invalid_values(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('player.profile.update'), [
            'skill_level' => 'invalid-level',
        ]);

        $response->assertSessionHasErrors('skill_level');
    }

    // ===========================================
    // Task 3: Skill Badge Component Tests (AC: 3, 4)
    // ===========================================

    public function test_skill_badge_component_exists(): void
    {
        $this->assertFileExists(
            resource_path('views/components/profile/skill-badge.blade.php')
        );
    }

    public function test_skill_badge_renders_correct_label(): void
    {
        $user = User::factory()->create();
        $user->player->update(['skill_level' => 'pro']);

        $view = $this->blade(
            '<x-profile.skill-badge :level="$level" />',
            ['level' => SkillLevel::PRO]
        );

        $view->assertSee('Pro');
    }

    public function test_skill_badge_has_different_colors_per_level(): void
    {
        // Each level should have a distinct visual style
        $colorMap = [
            'debutant' => 'gray',
            'amateur' => 'green',
            'confirme' => 'blue',
            'semi-pro' => 'purple',
            'pro' => 'yellow', // gold
        ];

        foreach ($colorMap as $level => $expectedColor) {
            $view = $this->blade(
                '<x-profile.skill-badge :level="$level" />',
                ['level' => SkillLevel::from($level)]
            );

            $view->assertSee($expectedColor, false);
        }
    }

    // ===========================================
    // Task 4: Profile View Tests (AC: 3)
    // ===========================================

    public function test_profile_view_displays_skill_badge_when_set(): void
    {
        $user = User::factory()->create();
        $user->player->update(['skill_level' => 'amateur']);

        $response = $this->actingAs($user)->get(route('player.profile.show'));

        $response->assertStatus(200);
        $response->assertSee('Amateur');
    }

    public function test_profile_view_handles_null_skill_level(): void
    {
        $user = User::factory()->create();
        // skill_level is null by default

        $response = $this->actingAs($user)->get(route('player.profile.show'));

        $response->assertStatus(200);
        $response->assertDontSee('skill-badge');
    }

    public function test_skill_badge_displayed_prominently_on_profile(): void
    {
        $user = User::factory()->create();
        $user->player->update(['skill_level' => 'pro']);

        $response = $this->actingAs($user)->get(route('player.profile.show'));

        $response->assertStatus(200);
        // Badge should appear in the header area near the name
        $response->assertSeeInOrder(['Mon Profil', 'Pro']);
    }
}
