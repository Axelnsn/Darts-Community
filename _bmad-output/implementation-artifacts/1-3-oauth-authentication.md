# Story 1.3: OAuth Authentication (Google & Facebook)

Status: ready-for-dev

## Story

**As a** new user,
**I want** to register/login with my Google or Facebook account,
**so that** I can sign up quickly without creating a new password.

## Epic Context

**Epic 1: Foundation & Authentication**

Cette story ajoute l'authentification OAuth via Google et Facebook en utilisant Laravel Socialite. Elle étend le système d'authentification email/password implémenté dans la story 1-2. C'est la dernière pièce du puzzle d'authentification avant les fonctionnalités de profil (Epic 2).

**Dépendance critique:** Story 1-2 (Breeze installé, auth email/password fonctionnel)

---

## Acceptance Criteria

### AC1: Laravel Socialite Installation
```gherkin
Given Laravel Breeze is already installed and configured
When I install Laravel Socialite
Then the package should integrate with existing auth system
And OAuth routes should coexist with Breeze routes
And no existing functionality should break
```

### AC2: Google OAuth Integration
```gherkin
Given I am on the login page
When I click "Se connecter avec Google"
Then I should be redirected to Google's OAuth consent screen
And after authorizing, I should be redirected back to the app
And a user account should be created or matched by email
And I should be automatically logged in
```

### AC3: Facebook OAuth Integration
```gherkin
Given I am on the login page
When I click "Se connecter avec Facebook"
Then I should be redirected to Facebook's OAuth consent screen
And after authorizing, I should be redirected back to the app
And a user account should be created or matched by email
And I should be automatically logged in
```

### AC4: OAuth Buttons on Auth Pages
```gherkin
Given I am on the login page "/login"
When I view the page
Then I should see OAuth buttons:
  - "Se connecter avec Google" (with Google icon)
  - "Se connecter avec Facebook" (with Facebook icon)
And the buttons should be styled with design system colors
And a divider "ou" should separate OAuth from email form

Given I am on the registration page "/register"
When I view the page
Then I should see the same OAuth buttons
And clicking them should start OAuth flow (not just login)
```

### AC5: New User via OAuth Creates Account
```gherkin
Given I have never registered on the platform
When I complete OAuth flow with Google or Facebook
Then a new User record should be created with:
  - email: from OAuth provider
  - name: from OAuth provider (or derived from email)
  - password: null (no password set for OAuth-only users)
  - oauth_provider: "google" or "facebook"
  - oauth_id: unique provider ID
And I should be redirected to /profile/edit
And a welcome message should appear in French
```

### AC6: Existing User via OAuth Logs In
```gherkin
Given I already have an account with email "user@example.com"
When I complete OAuth flow with the same email
Then I should be logged into my existing account
And my oauth_provider and oauth_id should be updated (linked)
And no duplicate account should be created
```

### AC7: OAuth Error Handling
```gherkin
Given OAuth flow is initiated
When the provider returns an error (denied, cancelled)
Then I should be redirected to login page
And a French error message should appear:
  - "L'authentification a été annulée."
  - "Une erreur est survenue lors de la connexion."
And the user should be able to retry or use email/password
```

### AC8: User OAuth Provider Storage
```gherkin
Given a user authenticates via OAuth
When their account is created or updated
Then the users table should store:
  - oauth_provider: string (google, facebook, null)
  - oauth_id: string (provider's unique user ID)
And these fields should be indexed for efficient lookup
```

---

## Tasks

### Task 1: Install Laravel Socialite (AC: 1)
- [ ] Run `composer require laravel/socialite`
- [ ] Verify package is installed correctly
- [ ] Run `php artisan config:clear`
- [ ] Confirm existing auth still works

### Task 2: Database Migration for OAuth Fields (AC: 8)
- [ ] Create migration: `add_oauth_fields_to_users_table`
- [ ] Add columns: `oauth_provider` (string, nullable), `oauth_id` (string, nullable)
- [ ] Make `password` column nullable (OAuth users have no password)
- [ ] Add composite index on `(oauth_provider, oauth_id)`
- [ ] Run migration

### Task 3: Update User Model (AC: 5, 6, 8)
- [ ] Add `oauth_provider`, `oauth_id` to `$fillable`
- [ ] Update `$casts` if needed
- [ ] Keep `password` in fillable but allow null

### Task 4: Configure OAuth Providers (AC: 2, 3)
- [ ] Add to `config/services.php`:
  ```php
  'google' => [
      'client_id' => env('GOOGLE_CLIENT_ID'),
      'client_secret' => env('GOOGLE_CLIENT_SECRET'),
      'redirect' => env('GOOGLE_REDIRECT_URI'),
  ],
  'facebook' => [
      'client_id' => env('FACEBOOK_CLIENT_ID'),
      'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
      'redirect' => env('FACEBOOK_REDIRECT_URI'),
  ],
  ```
- [ ] Add placeholders to `.env.example`:
  ```env
  GOOGLE_CLIENT_ID=
  GOOGLE_CLIENT_SECRET=
  GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

  FACEBOOK_CLIENT_ID=
  FACEBOOK_CLIENT_SECRET=
  FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
  ```

### Task 5: Create SocialiteController (AC: 2, 3, 5, 6, 7)
- [ ] Create `app/Http/Controllers/Auth/SocialiteController.php`
- [ ] Implement `redirect($provider)` method
- [ ] Implement `callback($provider)` method
- [ ] Handle new user creation (email, oauth_provider, oauth_id)
- [ ] Handle existing user login (match by email)
- [ ] Handle OAuth provider linking for existing accounts
- [ ] Implement error handling with French messages

### Task 6: Add OAuth Routes (AC: 2, 3)
- [ ] Add to `routes/auth.php`:
  ```php
  Route::get('auth/{provider}', [SocialiteController::class, 'redirect'])
      ->name('socialite.redirect');
  Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])
      ->name('socialite.callback');
  ```
- [ ] Limit `{provider}` to `google|facebook`

### Task 7: Update Auth Views with OAuth Buttons (AC: 4)
- [ ] Update `login.blade.php` to include OAuth buttons
- [ ] Update `register.blade.php` to include OAuth buttons
- [ ] Add SVG icons for Google and Facebook
- [ ] Style buttons according to design system
- [ ] Add "ou" divider between OAuth and email form

### Task 8: Create OAuth Button Component (AC: 4)
- [ ] Create `resources/views/components/oauth-button.blade.php`
- [ ] Accept `provider` prop (google, facebook)
- [ ] Display appropriate icon and French label
- [ ] Style with hover states

### Task 9: Write Feature Tests (All ACs)
- [ ] Test OAuth redirect to provider
- [ ] Test new user creation via OAuth (mock Socialite)
- [ ] Test existing user login via OAuth
- [ ] Test OAuth provider linking
- [ ] Test error handling (cancelled, denied)
- [ ] Test OAuth buttons appear on login/register pages
- [ ] Test French error messages

---

## Dev Notes

### Architecture References
- **Controller**: `App\Http\Controllers\Auth\SocialiteController` (NEW)
- **Routes**: `routes/auth.php` (extended)
- **Model**: `App\Models\User` (modified)
- **Views**: `resources/views/auth/login.blade.php`, `register.blade.php` (modified)
- **Component**: `resources/views/components/oauth-button.blade.php` (NEW)

### Previous Story Learnings (1-2)

**CRITICAL PATTERNS TO FOLLOW:**

1. **Breeze is already installed** - Do NOT reinstall or modify core Breeze files unnecessarily
2. **Design system colors are in `tailwind.config.js`**:
   - `dart-green`: #1B4D3E
   - `dart-green-light`: #2D7A5C
   - `dart-gold`: #D4AF37
   - `dart-red`: #C41E3A
3. **French translations** in `lang/fr.json`, `lang/fr/auth.php`, etc.
4. **Guest layout** uses `x-guest-layout` component with dartboard pattern background
5. **Registration redirects to `/profile/edit`** - OAuth should do the same
6. **User name derived from email** in `RegisteredUserController`:
   ```php
   'name' => explode('@', $request->email)[0],
   ```

**EXISTING AUTH STRUCTURE:**
- Controllers in `app/Http/Controllers/Auth/`
- Routes in `routes/auth.php` (guest and auth middleware groups)
- Views use Blade components: `x-text-input`, `x-input-label`, `x-primary-button`
- All tests in `tests/Feature/Auth/`

### Technical Specifications

**SocialiteController Pattern:**
```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback(string $provider): RedirectResponse
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect()->route('login')
                ->with('error', 'L\'authentification a été annulée.');
        }

        // Find existing user by email OR oauth credentials
        $user = User::where('email', $socialUser->getEmail())
            ->orWhere(function ($query) use ($provider, $socialUser) {
                $query->where('oauth_provider', $provider)
                      ->where('oauth_id', $socialUser->getId());
            })
            ->first();

        if ($user) {
            // Link OAuth if not already linked
            if (!$user->oauth_provider) {
                $user->update([
                    'oauth_provider' => $provider,
                    'oauth_id' => $socialUser->getId(),
                ]);
            }
        } else {
            // Create new user
            $user = User::create([
                'name' => $socialUser->getName() ?? explode('@', $socialUser->getEmail())[0],
                'email' => $socialUser->getEmail(),
                'password' => null,
                'oauth_provider' => $provider,
                'oauth_id' => $socialUser->getId(),
                'email_verified_at' => now(), // OAuth emails are pre-verified
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->route('profile.edit')
            ->with('status', 'Bienvenue sur Darts Community !');
    }
}
```

**Migration Pattern:**
```php
Schema::table('users', function (Blueprint $table) {
    $table->string('oauth_provider')->nullable()->after('remember_token');
    $table->string('oauth_id')->nullable()->after('oauth_provider');
    $table->index(['oauth_provider', 'oauth_id']);
});

// Make password nullable
Schema::table('users', function (Blueprint $table) {
    $table->string('password')->nullable()->change();
});
```

**OAuth Button Component:**
```blade
@props(['provider'])

@php
$config = [
    'google' => [
        'label' => 'Continuer avec Google',
        'bg' => 'bg-white hover:bg-gray-50',
        'text' => 'text-gray-700',
        'border' => 'border border-gray-300',
        'icon' => 'google',
    ],
    'facebook' => [
        'label' => 'Continuer avec Facebook',
        'bg' => 'bg-[#1877F2] hover:bg-[#166FE5]',
        'text' => 'text-white',
        'border' => '',
        'icon' => 'facebook',
    ],
][$provider];
@endphp

<a href="{{ route('socialite.redirect', $provider) }}"
   class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-lg font-medium transition-colors {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
    @if($provider === 'google')
        {{-- Google SVG icon --}}
        <svg class="w-5 h-5" viewBox="0 0 24 24">...</svg>
    @else
        {{-- Facebook SVG icon --}}
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">...</svg>
    @endif
    {{ $config['label'] }}
</a>
```

**Test Pattern (Mocking Socialite):**
```php
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;

public function test_new_user_can_register_via_google(): void
{
    $socialiteUser = Mockery::mock(SocialiteUser::class);
    $socialiteUser->shouldReceive('getId')->andReturn('google-123');
    $socialiteUser->shouldReceive('getEmail')->andReturn('newuser@gmail.com');
    $socialiteUser->shouldReceive('getName')->andReturn('New User');

    Socialite::shouldReceive('driver->user')->andReturn($socialiteUser);

    $response = $this->get('/auth/google/callback');

    $response->assertRedirect(route('profile.edit'));
    $this->assertDatabaseHas('users', [
        'email' => 'newuser@gmail.com',
        'oauth_provider' => 'google',
    ]);
    $this->assertAuthenticated();
}
```

### Design System Integration

**OAuth Section in Auth Forms:**
```html
{{-- OAuth buttons section --}}
<div class="space-y-3">
    <x-oauth-button provider="google" />
    <x-oauth-button provider="facebook" />
</div>

{{-- Divider --}}
<div class="relative my-6">
    <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300"></div>
    </div>
    <div class="relative flex justify-center text-sm">
        <span class="px-2 bg-white text-gray-500">ou</span>
    </div>
</div>

{{-- Email form below --}}
```

### Security Considerations

1. **CSRF Protection**: OAuth routes are GET requests but callbacks should validate state
2. **Email Trust**: OAuth provider emails are considered verified (set `email_verified_at`)
3. **Provider Validation**: Only allow 'google' and 'facebook' in route constraint
4. **No Password Required**: OAuth users can have null password - handle in login form

### Dependencies

- Laravel Socialite (to be installed)
- Existing: Laravel 12.x, Breeze 2.4.1, PHP 8.4

### Environment Variables Required

```env
# Google OAuth (obtain from Google Cloud Console)
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Facebook OAuth (obtain from Meta Developer Console)
FACEBOOK_CLIENT_ID=your-facebook-app-id
FACEBOOK_CLIENT_SECRET=your-facebook-app-secret
FACEBOOK_REDIRECT_URI="${APP_URL}/auth/facebook/callback"
```

**Note:** For local development, use placeholder values. OAuth testing will use mocked responses.

### File Structure After Completion

```
darts-community/
├── app/
│   └── Http/
│       └── Controllers/
│           └── Auth/
│               ├── SocialiteController.php (NEW)
│               └── ... (existing Breeze controllers)
├── database/
│   └── migrations/
│       └── 2026_01_09_XXXXXX_add_oauth_fields_to_users_table.php (NEW)
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php (MODIFIED)
│       │   └── register.blade.php (MODIFIED)
│       └── components/
│           └── oauth-button.blade.php (NEW)
├── routes/
│   └── auth.php (MODIFIED - OAuth routes added)
├── config/
│   └── services.php (MODIFIED - OAuth config)
└── tests/
    └── Feature/
        └── Auth/
            └── OAuthTest.php (NEW)
```

### References

- [Source: _bmad-output/planning-artifacts/architecture.md#Section 4.1 - User Model]
- [Source: _bmad-output/planning-artifacts/architecture.md#Section 6.1 - Authentication Component]
- [Source: _bmad-output/planning-artifacts/architecture.md#Section 10.4 - Authentication Flow]
- [Source: _bmad-output/planning-artifacts/prd.md#FR1 - OAuth via Socialite]
- [Source: _bmad-output/planning-artifacts/ux-design.md#Section 3.1 - Flow: Inscription & Onboarding]
- [Source: _bmad-output/implementation-artifacts/1-2-email-password-authentication.md - Design patterns]

---

## Definition of Done

- [ ] Laravel Socialite installed and configured
- [ ] Database migration adds oauth_provider, oauth_id, makes password nullable
- [ ] User model updated with OAuth fields
- [ ] SocialiteController handles redirect and callback
- [ ] Google OAuth flow works (mocked in tests)
- [ ] Facebook OAuth flow works (mocked in tests)
- [ ] OAuth buttons displayed on login and register pages
- [ ] OAuth buttons styled with design system
- [ ] New users via OAuth are created correctly
- [ ] Existing users via OAuth are logged in (matched by email)
- [ ] OAuth errors handled gracefully with French messages
- [ ] All feature tests passing
- [ ] Code follows PSR-12 and Laravel conventions
- [ ] No regressions in existing email/password auth
- [ ] No console errors in browser

---

## Story Points: 5

## Priority: Critical (Foundation)

## Dependencies: Story 1-2 (Email/Password Auth) - COMPLETE

## Blocked By: None

---

## Test Scenarios

### Automated Tests Required

```php
// tests/Feature/Auth/OAuthTest.php

// Redirect Tests
- test_google_oauth_redirect_works()
- test_facebook_oauth_redirect_works()
- test_invalid_provider_returns_404()

// New User Tests
- test_new_user_can_register_via_google()
- test_new_user_can_register_via_facebook()
- test_new_oauth_user_has_verified_email()
- test_new_oauth_user_redirects_to_profile_edit()

// Existing User Tests
- test_existing_user_can_login_via_google()
- test_existing_user_can_login_via_facebook()
- test_oauth_links_to_existing_account_by_email()

// Error Handling Tests
- test_oauth_cancelled_shows_french_error()
- test_oauth_error_redirects_to_login()

// UI Tests
- test_login_page_shows_oauth_buttons()
- test_register_page_shows_oauth_buttons()
```

### Manual Testing Checklist

1. [ ] OAuth buttons visible on /login
2. [ ] OAuth buttons visible on /register
3. [ ] Google button has correct styling (white bg, Google colors)
4. [ ] Facebook button has correct styling (#1877F2 blue)
5. [ ] "ou" divider separates OAuth from email form
6. [ ] Test OAuth flow with real credentials (if available)
7. [ ] Verify new user created via OAuth has correct fields
8. [ ] Verify existing user can login via OAuth
9. [ ] Verify error message appears when OAuth cancelled
10. [ ] Mobile responsiveness of OAuth buttons

---

## Notes

- Cette story nécessite des credentials OAuth réels pour les tests manuels complets
- En développement, utiliser les mocks Socialite pour les tests automatisés
- Les utilisateurs OAuth n'ont pas de mot de passe - ils ne peuvent pas utiliser "Mot de passe oublié"
- L'email OAuth est considéré comme vérifié (email_verified_at est défini)
- Si un utilisateur OAuth veut ajouter un mot de passe plus tard, c'est hors scope (Epic 2 ou futur)

---

*Story créée le 2026-01-09*
*Epic: Foundation & Authentication*
*Sprint: 1*

---

## Dev Agent Record

### Agent Model Used
{{agent_model_name_version}}

### Debug Log References

### Completion Notes List

### File List
