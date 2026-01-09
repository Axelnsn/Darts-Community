<?php

namespace Tests\Feature\Profile;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_player_profile_edit_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile/edit');

        $response->assertOk();
        $response->assertViewIs('pages.profile.edit');
    }

    public function test_player_profile_edit_page_requires_authentication(): void
    {
        $response = $this->get('/player/profile/edit');

        $response->assertRedirect('/login');
    }

    public function test_player_profile_edit_form_contains_all_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile/edit');

        $response->assertSee('name="first_name"', false);
        $response->assertSee('name="last_name"', false);
        $response->assertSee('name="nickname"', false);
        $response->assertSee('name="date_of_birth"', false);
        $response->assertSee('name="city"', false);
    }

    public function test_player_profile_edit_form_labels_are_in_french(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/player/profile/edit');

        $response->assertSee('Prénom');
        $response->assertSee('Nom');
        $response->assertSee('Pseudo');
        $response->assertSee('Date de naissance');
        $response->assertSee('Ville');
    }

    public function test_player_profile_can_be_updated(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'nickname' => 'JD',
            'date_of_birth' => '1990-05-15',
            'city' => 'Paris',
        ]);

        $response->assertRedirect('/player/profile/edit');

        $user->refresh();
        $player = $user->player;

        $this->assertEquals('Jean', $player->first_name);
        $this->assertEquals('Dupont', $player->last_name);
        $this->assertEquals('JD', $player->nickname);
        $this->assertEquals('1990-05-15', $player->date_of_birth->format('Y-m-d'));
        $this->assertEquals('Paris', $player->city);
    }

    public function test_date_of_birth_must_be_valid_date(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'date_of_birth' => 'invalid-date',
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    public function test_date_of_birth_cannot_be_in_future(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'date_of_birth' => now()->addYear()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    public function test_date_of_birth_must_be_reasonable_age(): void
    {
        $user = User::factory()->create();

        // User cannot be over 120 years old
        $response = $this->actingAs($user)->put('/player/profile', [
            'date_of_birth' => now()->subYears(130)->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('date_of_birth');
    }

    public function test_first_name_cannot_exceed_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'first_name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('first_name');
    }

    public function test_last_name_cannot_exceed_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'last_name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('last_name');
    }

    public function test_nickname_cannot_exceed_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'nickname' => str_repeat('a', 51),
        ]);

        $response->assertSessionHasErrors('nickname');
    }

    public function test_city_cannot_exceed_max_length(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'city' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('city');
    }

    public function test_player_profile_edit_shows_existing_data(): void
    {
        $user = User::factory()->create();
        $user->player->update([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'nickname' => 'JD',
            'city' => 'Paris',
        ]);

        $response = $this->actingAs($user)->get('/player/profile/edit');

        $response->assertSee('value="Jean"', false);
        $response->assertSee('value="Dupont"', false);
        $response->assertSee('value="JD"', false);
        $response->assertSee('value="Paris"', false);
    }

    public function test_all_fields_are_optional(): void
    {
        $user = User::factory()->create();

        // Update with empty data should work
        $response = $this->actingAs($user)->put('/player/profile', []);

        $response->assertRedirect('/player/profile/edit');
        $response->assertSessionHasNoErrors();
    }

    public function test_player_profile_update_shows_success_message(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'first_name' => 'Jean',
        ]);

        $response->assertRedirect('/player/profile/edit');
        $response->assertSessionHas('status', 'profile-updated');

        // Follow redirect and check message is displayed
        $followup = $this->actingAs($user)->get('/player/profile/edit');
        $followup->assertSee('Profil mis à jour');
    }

    public function test_validation_error_messages_are_in_french(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put('/player/profile', [
            'first_name' => str_repeat('a', 256),
        ]);

        $response->assertSessionHasErrors('first_name');

        // Check the error message is in French
        $errors = session('errors');
        $this->assertStringContainsString('prénom', strtolower($errors->get('first_name')[0]));
    }
}
