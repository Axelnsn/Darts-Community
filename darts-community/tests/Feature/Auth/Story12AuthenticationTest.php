<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Story 1-2: Email/Password Authentication Feature Tests
 *
 * Tests for all Acceptance Criteria of Story 1-2
 */
class Story12AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    // AC1: Registration Form Tests

    public function test_ac1_registration_form_contains_email_field(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('type="email"', false);
        $response->assertSee('name="email"', false);
    }

    public function test_ac1_registration_form_contains_password_field(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('type="password"', false);
        $response->assertSee('name="password"', false);
    }

    public function test_ac1_registration_form_contains_password_confirmation_field(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('name="password_confirmation"', false);
    }

    // AC2: Form Fields in French

    public function test_ac2_registration_form_labels_are_in_french(): void
    {
        $response = $this->get('/register');

        $response->assertSee('Adresse email');
        $response->assertSee('Mot de passe');
        $response->assertSee('Confirmer le mot de passe');
    }

    public function test_ac2_login_form_labels_are_in_french(): void
    {
        $response = $this->get('/login');

        $response->assertSee('Adresse email');
        $response->assertSee('Mot de passe');
        $response->assertSee('Se souvenir de moi');
    }

    // AC3: Password Validation (8+ characters)

    public function test_ac3_password_minimum_8_characters_required(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'short', // Only 5 characters
            'password_confirmation' => 'short',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_ac3_password_with_8_characters_succeeds(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'password', // Exactly 8 characters
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
    }

    // AC4: Email Validation (unique)

    public function test_ac4_duplicate_email_rejected(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_ac4_unique_email_accepted(): void
    {
        $response = $this->post('/register', [
            'email' => 'unique@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', ['email' => 'unique@example.com']);
    }

    // AC5: Registration Redirect to Profile

    public function test_ac5_registration_redirects_to_profile_edit(): void
    {
        $response = $this->post('/register', [
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/profile/edit');
    }

    // AC6: Login Form Tests

    public function test_ac6_login_form_contains_required_fields(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('name="email"', false);
        $response->assertSee('name="password"', false);
        $response->assertSee('name="remember"', false);
    }

    public function test_ac6_login_with_valid_credentials_succeeds(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        $this->assertAuthenticated();
    }

    public function test_ac6_login_with_invalid_credentials_fails(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors();
    }

    // AC7: Rate Limiting

    public function test_ac7_rate_limiting_after_5_failed_attempts(): void
    {
        $user = User::factory()->create([
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
        ]);

        // Make 5 failed login attempts
        for ($i = 0; $i < 5; $i++) {
            $this->post('/login', [
                'email' => 'user@example.com',
                'password' => 'wrongpassword',
            ]);
        }

        // 6th attempt should be rate limited
        $response = $this->post('/login', [
            'email' => 'user@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
        // Check for throttle message in French
        $this->assertTrue(
            collect($response->getSession()->get('errors')->getBag('default')->get('email'))
                ->contains(fn($error) => str_contains($error, 'secondes') || str_contains($error, 'tentatives'))
        );
    }

    // AC8: Forgot Password Flow

    public function test_ac8_forgot_password_form_displayed(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Mot de passe oublié');
        $response->assertSee('name="email"', false);
    }

    public function test_ac8_password_reset_email_sent(): void
    {
        $user = User::factory()->create(['email' => 'user@example.com']);

        $response = $this->post('/forgot-password', [
            'email' => 'user@example.com',
        ]);

        $response->assertSessionHas('status');
    }

    // AC9: Logout Flow

    public function test_ac9_logout_clears_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }

    // AC10: Design System Integration

    public function test_ac10_auth_pages_use_design_system_colors(): void
    {
        $response = $this->get('/login');

        // Check for design system colors in the Vite compiled CSS context
        $response->assertStatus(200);
        // The guest layout uses dart-green background
        $response->assertSee('dart-green', false);
    }

    public function test_ac10_auth_pages_include_inter_font(): void
    {
        $response = $this->get('/login');

        $response->assertSee('fonts.googleapis.com', false);
        $response->assertSee('Inter', false);
    }

    // Additional French UI Tests

    public function test_forgot_password_page_in_french(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertSee('Mot de passe oublié');
        $response->assertSee('Envoyer le lien de réinitialisation');
    }

    public function test_registration_button_in_french(): void
    {
        $response = $this->get('/register');

        $response->assertSee("S'inscrire");
    }

    public function test_login_button_in_french(): void
    {
        $response = $this->get('/login');

        $response->assertSee('Se connecter');
    }
}
