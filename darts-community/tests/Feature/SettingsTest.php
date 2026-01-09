<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    // ===================
    // Settings Page Tests
    // ===================

    public function test_settings_page_is_displayed_for_authenticated_users(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/settings');

        $response->assertOk();
        $response->assertSee('Paramètres du compte');
    }

    public function test_settings_page_redirects_unauthenticated_users(): void
    {
        $response = $this->get('/settings');

        $response->assertRedirect('/login');
    }

    public function test_settings_page_contains_email_section(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/settings');

        $response->assertSee("Modifier l'adresse email");
    }

    public function test_settings_page_contains_password_section(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/settings');

        $response->assertSee('Modifier le mot de passe');
    }

    public function test_settings_page_contains_export_data_section(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/settings');

        $response->assertSee('Exporter mes données');
    }

    public function test_settings_page_contains_delete_account_section(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/settings');

        $response->assertSee('Supprimer mon compte');
    }

    public function test_navigation_contains_settings_link(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get('/profile/edit');

        $response->assertSee('Paramètres');
        $response->assertSee('href="' . route('settings.index') . '"', false);
    }

    // ========================
    // Email Modification Tests
    // ========================

    public function test_user_can_update_email_with_valid_password(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'old@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->put('/settings/email', [
                'email' => 'new@example.com',
                'current_password' => 'password',
            ]);

        $response->assertSessionHas('status', 'email-updated');
        $response->assertRedirect();

        $user->refresh();
        $this->assertEquals('new@example.com', $user->email);
        $this->assertNull($user->email_verified_at);

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_user_cannot_update_email_without_current_password(): void
    {
        $user = User::factory()->create([
            'email' => 'old@example.com',
        ]);

        $response = $this
            ->actingAs($user)
            ->put('/settings/email', [
                'email' => 'new@example.com',
                'current_password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors('current_password');
        $user->refresh();
        $this->assertEquals('old@example.com', $user->email);
    }

    public function test_user_cannot_update_to_existing_email(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $user = User::factory()->create(['email' => 'old@example.com']);

        $response = $this
            ->actingAs($user)
            ->put('/settings/email', [
                'email' => 'existing@example.com',
                'current_password' => 'password',
            ]);

        $response->assertSessionHasErrors('email');
        $user->refresh();
        $this->assertEquals('old@example.com', $user->email);
    }

    public function test_user_cannot_update_email_with_invalid_format(): void
    {
        $user = User::factory()->create(['email' => 'old@example.com']);

        $response = $this
            ->actingAs($user)
            ->put('/settings/email', [
                'email' => 'invalid-email',
                'current_password' => 'password',
            ]);

        $response->assertSessionHasErrors('email');
        $user->refresh();
        $this->assertEquals('old@example.com', $user->email);
    }

    // =======================
    // Password Change Tests
    // =======================

    public function test_user_can_update_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'password',
                'password' => 'new-password123',
                'password_confirmation' => 'new-password123',
            ]);

        $response->assertSessionHas('status', 'password-updated');
        $response->assertRedirect();
    }

    public function test_user_cannot_update_password_with_wrong_current(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'wrong-password',
                'password' => 'new-password123',
                'password_confirmation' => 'new-password123',
            ]);

        $response->assertSessionHasErrors('current_password', null, 'updatePassword');
    }

    public function test_user_cannot_update_password_without_confirmation(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'password',
                'password' => 'new-password123',
                'password_confirmation' => 'different-password',
            ]);

        $response->assertSessionHasErrors('password', null, 'updatePassword');
    }

    public function test_user_cannot_update_password_with_short_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->put('/settings/password', [
                'current_password' => 'password',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

        $response->assertSessionHasErrors('password', null, 'updatePassword');
    }

    // ============================
    // Account Deletion Tests
    // ============================

    public function test_user_can_delete_account_with_confirmation(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/settings/account', [
                'confirmation' => 'SUPPRIMER',
                'password' => 'password',
            ]);

        $response->assertRedirect('/');

        // User should be soft deleted
        $this->assertSoftDeleted('users', ['id' => $user->id]);

        // User should have gdpr_deletion_requested_at set
        $user->refresh();
        $this->assertNotNull($user->gdpr_deletion_requested_at);
    }

    public function test_user_cannot_delete_without_typing_supprimer(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/settings/account', [
                'confirmation' => 'wrong',
                'password' => 'password',
            ]);

        $response->assertSessionHasErrors('confirmation', null, 'accountDeletion');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function test_user_cannot_delete_without_correct_password(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/settings/account', [
                'confirmation' => 'SUPPRIMER',
                'password' => 'wrong-password',
            ]);

        $response->assertSessionHasErrors('password', null, 'accountDeletion');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'deleted_at' => null]);
    }

    public function test_deleted_user_is_soft_deleted(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $this
            ->actingAs($user)
            ->delete('/settings/account', [
                'confirmation' => 'SUPPRIMER',
                'password' => 'password',
            ]);

        // User should still exist in database (soft deleted)
        $this->assertDatabaseHas('users', ['id' => $userId]);

        // But should be soft deleted
        $deletedUser = User::withTrashed()->find($userId);
        $this->assertNotNull($deletedUser->deleted_at);
    }

    public function test_deleted_user_is_logged_out(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->delete('/settings/account', [
                'confirmation' => 'SUPPRIMER',
                'password' => 'password',
            ]);

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    // ============================
    // Data Export Tests
    // ============================

    public function test_user_can_export_their_data(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/settings/export');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/json');
        $response->assertHeader('Content-Disposition');
    }

    public function test_export_data_contains_required_fields(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'email_verified_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/settings/export');

        $content = $response->streamedContent();
        $data = json_decode($content, true);

        $this->assertArrayHasKey('export_date', $data);
        $this->assertArrayHasKey('user', $data);
        $this->assertArrayHasKey('email', $data['user']);
        $this->assertArrayHasKey('created_at', $data['user']);
        $this->assertEquals('test@example.com', $data['user']['email']);
    }

    // ============================
    // Grace Period Tests
    // ============================

    public function test_grace_period_not_expired_within_30_days(): void
    {
        $user = User::factory()->create([
            'gdpr_deletion_requested_at' => now()->subDays(15),
        ]);

        $this->assertFalse($user->gracePeriodExpired());
    }

    public function test_grace_period_expired_after_30_days(): void
    {
        $user = User::factory()->create([
            'gdpr_deletion_requested_at' => now()->subDays(31),
        ]);

        $this->assertTrue($user->gracePeriodExpired());
    }

    // ============================
    // Privacy Policy & Terms Tests
    // ============================

    public function test_privacy_policy_page_is_accessible(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertOk();
        $response->assertSee('Politique de confidentialité');
    }

    public function test_terms_page_is_accessible(): void
    {
        $response = $this->get('/terms');

        $response->assertOk();
        $response->assertSee("Conditions d'utilisation");
    }

    public function test_privacy_policy_page_shows_gdpr_rights(): void
    {
        $response = $this->get('/privacy-policy');

        $response->assertSee('RGPD');
        $response->assertSee('Droit d\'accès', false);
        $response->assertSee('Droit à l\'effacement', false);
    }

    public function test_terms_page_shows_rules(): void
    {
        $response = $this->get('/terms');

        $response->assertSee('Règles de conduite');
        $response->assertSee('Propriété intellectuelle');
    }

    // ============================
    // GDPR Consent Tests
    // ============================

    public function test_registration_requires_gdpr_consent(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            // No gdpr_consent
        ]);

        $response->assertSessionHasErrors('gdpr_consent');
    }

    public function test_registration_fails_without_checking_gdpr_consent(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'gdpr_consent' => '0',
        ]);

        $response->assertSessionHasErrors('gdpr_consent');
    }

    public function test_gdpr_consent_is_stored_on_registration(): void
    {
        $response = $this->post('/register', [
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'gdpr_consent' => '1',
        ]);

        $response->assertRedirect('/profile/edit');

        $user = User::where('email', 'newuser@example.com')->first();
        $this->assertNotNull($user);
        $this->assertNotNull($user->gdpr_consent_at);
    }

    public function test_registration_form_shows_gdpr_checkbox(): void
    {
        $response = $this->get('/register');

        $response->assertOk();
        $response->assertSee('gdpr_consent', false);
        $response->assertSee('politique de confidentialité', false);
    }

    public function test_registration_form_links_to_privacy_policy(): void
    {
        $response = $this->get('/register');

        $response->assertSee(route('privacy-policy'), false);
        $response->assertSee(route('terms'), false);
    }
}
