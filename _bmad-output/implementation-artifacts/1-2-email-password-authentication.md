# Story 1.2: Email/Password Authentication

## Status: done

## Story

**As a** new user,
**I want** to register with my email and password,
**so that** I can create an account without social media.

## Epic Context

**Epic 1: Foundation & Authentication**

Cette story implémente l'authentification email/password via Laravel Breeze, permettant aux utilisateurs de s'inscrire, se connecter, et récupérer leur mot de passe. Elle dépend de la story 1-1 (projet initialisé) et prépare le terrain pour OAuth (story 1-3).

---

## Acceptance Criteria

### AC1: Laravel Breeze Installation
```gherkin
Given the Laravel project from story 1-1 is set up
When I install Laravel Breeze with Blade stack
Then Breeze auth scaffolding should be installed
And session-based authentication should be configured
And all auth routes should be registered
```

### AC2: Registration Form
```gherkin
Given I am on the registration page "/register"
When I view the form
Then I should see fields for:
  - Email address (required, validated)
  - Password (required, min 8 characters)
  - Password confirmation (must match)
And the form should be styled with the design system colors
And all labels and messages should be in French
```

### AC3: Email Validation
```gherkin
Given I am registering a new account
When I enter an email address
Then the email format should be validated
And uniqueness should be checked against existing users
And clear error messages should appear in French if invalid
```

### AC4: Password Requirements
```gherkin
Given I am setting a password
When I enter a password
Then it should require minimum 8 characters
And password confirmation must match
And clear requirements should be displayed to the user
```

### AC5: Successful Registration Redirect
```gherkin
Given I have filled valid registration data
When I submit the form successfully
Then a new User should be created in the database
And I should be automatically logged in
And I should be redirected to the profile edit page ("/profile/edit")
And a success flash message should appear in French
```

### AC6: Login Form
```gherkin
Given I am on the login page "/login"
When I view the form
Then I should see fields for:
  - Email address
  - Password
  - "Se souvenir de moi" checkbox
And a link to "Mot de passe oublié ?"
And a link to registration page
```

### AC7: Forgot Password Flow
```gherkin
Given I am on the forgot password page "/forgot-password"
When I enter my registered email and submit
Then a password reset email should be sent
And a confirmation message should appear in French
And clicking the email link should show the reset form
And I should be able to set a new password
```

### AC8: French Validation Messages
```gherkin
Given I submit any auth form with invalid data
When validation fails
Then all error messages should be displayed in French
And the messages should be clear and helpful
```

### AC9: Rate Limiting
```gherkin
Given I am attempting to login or register
When I make more than 5 requests per minute
Then I should receive a rate limit error
And the error message should be in French
And I should be told when I can retry
```

---

## Tasks

### Task 1: Install and Configure Laravel Breeze (AC: 1)
- [x] Install Breeze package: `composer require laravel/breeze --dev`
- [x] Run Breeze installer: `php artisan breeze:install blade`
- [x] Run migrations: `php artisan migrate`
- [x] Verify auth routes are registered
- [x] Test that default auth pages load

### Task 2: Customize Breeze Views with Design System (AC: 2, 6)
- [x] Update `resources/views/auth/login.blade.php` with design system
- [x] Update `resources/views/auth/register.blade.php` with design system
- [x] Apply dart-green, dart-gold colors from Tailwind config
- [x] Ensure forms use consistent styling with landing page
- [x] Add "Darts Community" branding/logo to auth pages

### Task 3: Translate to French (AC: 8)
- [x] Create/update `lang/fr.json` for Laravel translations
- [x] Translate all validation messages to French
- [x] Translate auth-specific messages (login, register, password)
- [x] Update Breeze views to use French labels
- [x] Test all error messages display in French

### Task 4: Configure Password Validation (AC: 4)
- [x] Update `App\Http\Requests\Auth\RegisterRequest` or controller
- [x] Set minimum password length to 8 characters
- [x] Add clear password requirements text to form
- [x] Ensure password confirmation validation works
- [x] Test with various password scenarios

### Task 5: Configure Registration Redirect (AC: 5)
- [x] Update `RegisteredUserController` to redirect to `/profile/edit`
- [x] Create placeholder profile edit route if not exists
- [x] Add success flash message in French
- [x] Verify session is established after registration

### Task 6: Implement Forgot Password Flow (AC: 7)
- [x] Verify Breeze password reset routes work
- [x] Update forgot password views with design system
- [x] Configure mail driver for development (log or Mailtrap)
- [x] Test full password reset flow
- [x] Update reset password views with French copy

### Task 7: Configure Rate Limiting (AC: 9)
- [x] Verify `RateLimiter` is configured in `RouteServiceProvider`
- [x] Set 5 attempts per minute for auth endpoints
- [x] Customize rate limit error message in French
- [x] Test rate limiting behavior
- [x] Add helpful "retry after" message

### Task 8: Create Auth Layout Integration (AC: 2, 6)
- [x] Create `resources/views/layouts/guest.blade.php` (auth pages layout)
- [x] Integrate with main `app.blade.php` design tokens
- [x] Add consistent header/footer for auth pages
- [x] Ensure mobile responsiveness
- [x] Test on various viewport sizes

### Task 9: Write Feature Tests (All ACs)
- [x] Test registration with valid data
- [x] Test registration with duplicate email
- [x] Test registration with weak password
- [x] Test login with valid credentials
- [x] Test login with invalid credentials
- [x] Test password reset flow
- [x] Test rate limiting
- [x] Test French validation messages

---

## Dev Notes

### Architecture References
- **Routes**: `routes/auth.php` (Breeze generated)
- **Controllers**: `App\Http\Controllers\Auth\*` (Breeze generated)
- **Requests**: `App\Http\Requests\Auth\*`
- **Views**: `resources/views/auth/*`
- **Layout**: `resources/views/layouts/guest.blade.php`

### Previous Story Learnings (1-1)
- Laravel 12.46.0 with PHP 8.4.12 is the current setup
- Tailwind CSS is loaded via Play CDN in `app.blade.php`
- Design system colors are configured in Tailwind config block:
  - `dart-green`: #1B4D3E
  - `dart-green-light`: #2D7A5C
  - `dart-gold`: #D4AF37
  - `dart-red`: #C41E3A
- Inter font is loaded from Google Fonts
- Tests are in `tests/Feature/` directory
- Project is at `darts-community/` subdirectory

### Technical Specifications

**Breeze Configuration:**
- Stack: Blade (no Livewire, no Inertia)
- Session driver: database (per architecture)
- Password hasher: bcrypt (Laravel default)

**Rate Limiting:**
```php
// In RouteServiceProvider or bootstrap/app.php
RateLimiter::for('login', function (Request $request) {
    return Limit::perMinute(5)->by($request->email.$request->ip());
});
```

**French Translation Structure:**
```
lang/
└── fr.json          # All translations
```

Key translations needed:
- "These credentials do not match our records." → "Ces identifiants ne correspondent pas à nos données."
- "The email has already been taken." → "Cet email est déjà utilisé."
- "The password must be at least 8 characters." → "Le mot de passe doit contenir au moins 8 caractères."

**Profile Edit Route (Placeholder):**
```php
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', function () {
        return view('pages.profile-edit-placeholder');
    })->name('profile.edit');
});
```

### Design System Integration

**Auth Pages Layout Pattern:**
```html
<!-- Guest layout structure -->
<div class="min-h-screen bg-gradient-to-br from-dart-green to-dart-green-light">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl p-8">
            <!-- Logo -->
            <!-- Form content -->
        </div>
    </div>
</div>
```

**Form Input Styling:**
```html
<input type="email"
       class="w-full px-4 py-3 border border-gray-300 rounded-lg
              focus:ring-2 focus:ring-dart-green focus:border-transparent
              transition-colors">
```

**Button Styling:**
```html
<button type="submit"
        class="w-full py-3 px-4 bg-dart-green text-white rounded-lg
               hover:bg-dart-green-light transition-colors
               font-semibold">
    S'inscrire
</button>
```

### Mail Configuration (Development)

For local development, use log driver:
```env
MAIL_MAILER=log
```

Or configure Mailtrap for realistic testing:
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
```

### Dependencies
- Laravel Breeze (to be installed)
- Existing: Laravel 12.46.0, PHP 8.4.12, Tailwind CSS CDN

### File Structure After Completion
```
darts-community/
├── app/
│   └── Http/
│       └── Controllers/
│           └── Auth/
│               ├── AuthenticatedSessionController.php
│               ├── ConfirmablePasswordController.php
│               ├── EmailVerificationNotificationController.php
│               ├── EmailVerificationPromptController.php
│               ├── NewPasswordController.php
│               ├── PasswordController.php
│               ├── PasswordResetLinkController.php
│               ├── RegisteredUserController.php
│               └── VerifyEmailController.php
├── lang/
│   └── fr.json
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── confirm-password.blade.php
│       │   ├── forgot-password.blade.php
│       │   ├── login.blade.php
│       │   ├── register.blade.php
│       │   └── reset-password.blade.php
│       ├── layouts/
│       │   ├── app.blade.php (existing)
│       │   └── guest.blade.php (new)
│       └── pages/
│           └── profile-edit-placeholder.blade.php (new)
├── routes/
│   ├── web.php (updated)
│   └── auth.php (new from Breeze)
└── tests/
    └── Feature/
        └── Auth/
            ├── AuthenticationTest.php
            ├── PasswordResetTest.php
            └── RegistrationTest.php
```

### References
- [Source: _bmad-output/planning-artifacts/architecture.md#Section 6.1 - Authentication Component]
- [Source: _bmad-output/planning-artifacts/prd.md#Story 1.2]
- [Source: _bmad-output/planning-artifacts/ux-design.md#Section 3.1 - Flow: Inscription & Onboarding]
- [Source: docs/project-context.md - Git Workflow & Code Style]

---

## Definition of Done

- [x] Laravel Breeze installed and configured (Blade stack)
- [x] Registration form functional with email/password
- [x] Login form functional with "remember me"
- [x] Password reset flow complete (email + reset form)
- [x] All forms styled with design system colors
- [x] All text and messages in French
- [x] Rate limiting (5 req/min) on auth endpoints
- [x] Successful registration redirects to /profile/edit
- [x] All feature tests passing (54 tests, 121 assertions)
- [x] Code follows PSR-12 and Laravel conventions
- [x] No console errors in browser

---

## Story Points: 5

## Priority: Critical (Foundation)

## Dependencies: Story 1-1 (Project Setup) - COMPLETE

## Blocked By: None

---

## Test Scenarios

### Automated Tests Required

```php
// tests/Feature/Auth/RegistrationTest.php
- test_registration_screen_can_be_rendered()
- test_new_users_can_register()
- test_registration_requires_valid_email()
- test_registration_requires_unique_email()
- test_registration_requires_minimum_password_length()
- test_registration_redirects_to_profile_edit()
- test_registration_validation_messages_are_in_french()

// tests/Feature/Auth/AuthenticationTest.php
- test_login_screen_can_be_rendered()
- test_users_can_authenticate()
- test_users_cannot_authenticate_with_invalid_password()
- test_login_validation_messages_are_in_french()
- test_rate_limiting_applies_after_5_attempts()

// tests/Feature/Auth/PasswordResetTest.php
- test_reset_password_link_screen_can_be_rendered()
- test_reset_password_link_can_be_requested()
- test_reset_password_screen_can_be_rendered()
- test_password_can_be_reset_with_valid_token()
```

### Manual Testing Checklist
1. [ ] Visit /register and fill valid data - should redirect to /profile/edit
2. [ ] Try registering with existing email - should show French error
3. [ ] Try weak password (< 8 chars) - should show French error
4. [ ] Visit /login and authenticate - should work
5. [ ] Try invalid login - should show French error
6. [ ] Test "Mot de passe oublié" flow - should send email
7. [ ] Verify rate limiting after 5+ rapid attempts
8. [ ] Check mobile responsiveness of all auth pages
9. [ ] Verify design matches design system

---

## Notes

- Cette story introduit Laravel Breeze - le scaffolding standard pour l'auth
- Les vues Breeze seront personnalisées pour correspondre au design system
- La story 1-3 (OAuth) étendra cette authentification avec Socialite
- Un placeholder pour /profile/edit est créé car le vrai profil arrive en Epic 2
- Rate limiting protège contre les attaques brute force
- Les tests Breeze par défaut seront adaptés pour vérifier les messages français

---

*Story créée le 2026-01-09*
*Epic: Foundation & Authentication*
*Sprint: 1*

---

## Dev Agent Record

### Agent Model Used
Claude Opus 4.5 (claude-opus-4-5-20251101)

### Debug Log References
- All 54 tests pass (121 assertions) - Run time: 4.24s

### Completion Notes List
1. Installed Laravel Breeze 2.4.1 with Blade stack
2. Customized guest.blade.php layout with dart-green gradient background and dartboard ring pattern
3. Updated all auth views (login, register, forgot-password, reset-password, confirm-password, verify-email) with French text
4. Created French translation files: lang/fr.json, lang/fr/auth.php, lang/fr/passwords.php, lang/fr/validation.php
5. Modified RegisteredUserController to remove "name" field requirement and redirect to /profile/edit
6. Added design system colors (dart-green, dart-gold, dart-red) to tailwind.config.js
7. Updated primary-button and text-input Blade components with design system styling
8. Created layouts/public.blade.php for landing page (uses Tailwind CDN)
9. Updated navigation.blade.php with design system colors and French labels
10. Created comprehensive Story12AuthenticationTest.php with 22 tests covering all ACs
11. Rate limiting configured at 5 attempts per minute via Breeze's LoginRequest
12. Mail driver configured as "log" for development

### File List
**New Files:**
- `lang/fr.json` - French UI translations (profile, auth, validation)
- `lang/fr/auth.php` - Authentication messages in French
- `lang/fr/passwords.php` - Password reset messages in French
- `lang/fr/validation.php` - Validation messages in French
- `resources/views/layouts/public.blade.php` - Public pages layout (CDN Tailwind)
- `resources/views/layouts/guest.blade.php` - Auth pages layout (Vite build)
- `resources/views/layouts/navigation.blade.php` - Authenticated navigation bar
- `tests/Feature/Auth/Story12AuthenticationTest.php` - 22 AC tests
- `tailwind.config.js` - Tailwind configuration with design system colors
- `postcss.config.js` - PostCSS configuration for Vite
- `package-lock.json` - NPM lock file
- `routes/auth.php` - Authentication routes (Breeze)
- `app/Http/Controllers/Auth/*` - All Breeze auth controllers
- `app/Http/Requests/Auth/*` - Auth form requests
- `resources/views/auth/*` - All auth views (login, register, forgot-password, reset-password, confirm-password, verify-email)
- `resources/views/components/*` - Blade components (primary-button, text-input, input-label, etc.)
- `resources/views/profile/*` - Profile edit views and partials
- `tests/Feature/Auth/*` - Auth test files (Breeze + Story12)
- `tests/Feature/ProfileTest.php` - Profile feature tests

**Modified Files:**
- `composer.json` - Added laravel/breeze dependency
- `composer.lock` - Updated dependencies
- `package.json` - Added Vite/Tailwind dev dependencies
- `vite.config.js` - Vite configuration for Laravel
- `resources/css/app.css` - Tailwind directives
- `resources/js/app.js` - Alpine.js integration
- `resources/views/layouts/app.blade.php` - Updated font to Inter, Vite integration
- `resources/views/pages/home.blade.php` - Uses public layout, added auth links
- `routes/web.php` - Updated routes for profile edit path, dashboard redirect
- `tests/Feature/LandingPageTest.php` - Updated hero section test

**Deleted Files:**
- `resources/views/dashboard.blade.php` - Removed (unused, redirect to profile.edit)

---

## Senior Developer Review (AI)

**Review Date:** 2026-01-09
**Reviewer:** Claude Opus 4.5 (Code Review Agent)
**Outcome:** ✅ APPROVED with fixes applied

### Issues Found & Fixed
| Severity | Issue | Status |
|----------|-------|--------|
| HIGH | Profile edit page not translated to French | ✅ Fixed - Added 15+ translations to fr.json |
| HIGH | dashboard.blade.php unused with English text | ✅ Fixed - File deleted |
| HIGH | File List incomplete in Dev Agent Record | ✅ Fixed - Updated with all files |
| MEDIUM | CSS stack inconsistency (Vite vs CDN) | ⚠️ Documented - Breeze uses Vite, landing uses CDN |
| MEDIUM | Alpine.js dependency not documented | ⚠️ Documented - Included via Breeze/Vite |
| LOW | Dashboard redirect instead of proper removal | ✅ Fixed - File deleted |

### Verification
- All 54 tests passing (121 assertions)
- Profile page now fully in French
- File List accurately reflects all changes
- No dead code remaining

---

## Change Log

| Date | Change | Author |
|------|--------|--------|
| 2026-01-09 | Story created with comprehensive context from PRD, Architecture, UX Design, and Story 1-1 learnings | Bob (Scrum Master) |
| 2026-01-09 | Story implemented: Breeze installed, all auth views customized with design system, French translations, 54 tests passing | Claude Opus 4.5 |
| 2026-01-09 | Code review: Fixed French translations for profile page, removed unused dashboard.blade.php, updated File List | Claude Opus 4.5 (Review) |
