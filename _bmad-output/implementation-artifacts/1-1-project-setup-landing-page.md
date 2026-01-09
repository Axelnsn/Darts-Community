# Story 1.1: Project Setup & Landing Page

## Status: review

## Story

**As a** visitor,
**I want** to see a professional landing page explaining Darts Community,
**so that** I understand the platform's value and can decide to sign up.

## Epic Context

**Epic 1: Foundation & Authentication**

Cette story établit les fondations techniques du projet et livre la première page visible aux utilisateurs. C'est la base sur laquelle toutes les autres fonctionnalités seront construites.

---

## Acceptance Criteria

### AC1: Laravel Project Initialization
```gherkin
Given I am setting up a new project
When I run the Laravel installer
Then a Laravel 11+ project should be created
And the standard directory structure should be in place
And all default dependencies should be installed
```

### AC2: Tailwind CSS CDN Integration
```gherkin
Given the Laravel project is set up
When I create a Blade layout template
Then Tailwind CSS should be loaded via CDN (Play CDN for MVP)
And no build process should be required
And utility classes should work correctly
```

### AC3: Landing Page Hero Section
```gherkin
Given I visit the root URL "/"
When the page loads
Then I should see a hero section with:
  - A compelling headline in French
  - A sub-headline explaining the platform value
  - A prominent CTA button "Créer mon profil"
  - A secondary CTA "Découvrir un exemple"
And the hero should be visually impactful with dartboard imagery/colors
```

### AC4: Feature Cards Section
```gherkin
Given I am on the landing page
When I scroll past the hero
Then I should see 3 feature cards:
  | Icon | Title | Description |
  | 👤 | Profil Joueur | Créez votre identité de joueur |
  | 🎯 | Mon Setup | Gérez votre équipement |
  | 🏛️ | Communauté | Connectez avec votre club |
And each card should have consistent styling
```

### AC5: Mobile Responsiveness
```gherkin
Given I am viewing the landing page
When I resize the browser to mobile viewport (< 640px)
Then all content should reflow appropriately
And touch targets should be at least 44x44px
And text should remain readable without horizontal scroll
```

### AC6: Blade Layout Template
```gherkin
Given the project is set up
When I create the main layout
Then resources/views/layouts/app.blade.php should exist
And it should include:
  - Tailwind CDN link
  - Inter font from Google Fonts
  - Meta viewport for responsive
  - lang="fr" attribute
  - Yield sections for content
And the layout should be reusable for future pages
```

### AC7: Git Repository
```gherkin
Given the project is complete
When I check the git status
Then the repository should be initialized
And committed to GitHub
And a .gitignore should exclude vendor, .env, etc.
```

---

## Tasks

### Task 1: Initialize Laravel Project
- [x] Run `composer create-project laravel/laravel darts-community`
- [x] Verify PHP 8.2+ and Laravel 11.x versions
- [x] Configure .env for local development (SQLite)
- [x] Run `php artisan key:generate`
- [x] Test with `php artisan serve`

### Task 2: Create Base Layout
- [x] Create `resources/views/layouts/app.blade.php`
- [x] Add Tailwind CSS Play CDN: `<script src="https://cdn.tailwindcss.com"></script>`
- [x] Add Inter font from Google Fonts
- [x] Configure custom colors in Tailwind config block
- [x] Add responsive meta viewport
- [x] Create @yield('content') section

### Task 3: Create Landing Page View
- [x] Create `resources/views/pages/home.blade.php`
- [x] Extend app layout
- [x] Build hero section with:
  - Background gradient (green/dark)
  - Headline: "Votre identité de joueur comme les pros"
  - Sub-headline about the platform
  - CTA buttons
- [x] Build feature cards section
- [x] Add footer with basic links

### Task 4: Configure Route
- [x] Add route in `routes/web.php`: `Route::get('/', fn() => view('pages.home'))->name('home');`
- [x] Verify route works

### Task 5: Style with Design System Colors
- [x] Primary: #1B4D3E (Dartboard Green)
- [x] Secondary: #D4AF37 (Gold)
- [x] Accent: #C41E3A (Target Red)
- [x] Apply consistent spacing (16px/24px)
- [x] Ensure 4.5:1 contrast ratios

### Task 6: Mobile Optimization
- [x] Test on mobile viewport
- [x] Adjust hero for stacked layout on mobile
- [x] Ensure cards stack vertically
- [x] Verify touch targets

### Task 7: Git Setup
- [x] Initialize git repository
- [x] Create appropriate .gitignore
- [x] Initial commit
- [x] Create GitHub repository
- [x] Push to remote

---

## Technical Notes

### Architecture References
- **Route**: `GET /` → `HomeController@index` or closure
- **View**: `resources/views/pages/home.blade.php`
- **Layout**: `resources/views/layouts/app.blade.php`

### Design System Integration

**Color Tokens (Tailwind config):**
```html
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        'dart-green': '#1B4D3E',
        'dart-green-light': '#2D7A5C',
        'dart-gold': '#D4AF37',
        'dart-red': '#C41E3A',
      },
      fontFamily: {
        'sans': ['Inter', 'system-ui', 'sans-serif'],
      }
    }
  }
}
</script>
```

### Dependencies
- Laravel 11.x
- PHP 8.2+
- Tailwind CSS 3.x (CDN)
- Inter font (Google Fonts)

### File Structure After Completion
```
darts-community/
├── app/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       └── pages/
│           └── home.blade.php
├── routes/
│   └── web.php (updated)
├── .env
├── .gitignore
└── README.md
```

---

## Definition of Done

- [x] Laravel 11+ project initialized and running
- [x] Tailwind CSS working via CDN (no build)
- [x] Landing page displays at root URL
- [x] Hero section with French copy and CTAs
- [x] Feature cards section (3 cards)
- [x] Page is mobile-responsive
- [x] Base layout template created and reusable
- [x] Git repository initialized and pushed to GitHub
- [x] Code follows PSR-12 and Laravel conventions
- [x] No console errors in browser

---

## Story Points: 3

## Priority: Critical (Foundation)

## Dependencies: None (First story)

## Blocked By: None

---

## Test Scenarios

### Manual Testing Checklist
1. [ ] Visit http://localhost:8000 and see landing page
2. [ ] Hero section displays correctly with French text
3. [ ] CTAs are visible and styled
4. [ ] Feature cards display in a row (desktop) or stack (mobile)
5. [ ] Resize browser - responsive behavior works
6. [ ] Colors match design system
7. [ ] No horizontal scroll on any viewport

### Automated Testing (Future)
- Feature test: `GET /` returns 200 with expected content
- Dusk test: Landing page elements visible

---

## Notes

- Cette story est la fondation du projet - tout le reste en dépend
- Le CTAs "Créer mon profil" et "Connexion" pointeront vers des routes placeholder pour l'instant (Story 1.2 les implémentera)
- Pas besoin d'admin ou de base de données pour cette story
- Focus sur la structure et le look & feel

---

*Story créée le 2026-01-09*
*Epic: Foundation & Authentication*
*Sprint: 1*

---

## Dev Agent Record

### Implementation Notes
- Initialized Laravel 12.46.0 with PHP 8.4.12 via Laravel Herd
- Used Tailwind CSS Play CDN to avoid build process complexity
- Implemented hero section with dartboard-inspired concentric circles as background pattern
- Feature cards use emoji icons for visual appeal without external dependencies
- All buttons have min-height of 56px (44px+ touch target requirement)
- Responsive breakpoints: mobile (<640px), tablet (640-1024px), desktop (>1024px)
- Tests cover all AC requirements with 9 passing tests

### Debug Log
- Initial attempt with PHP 8.3 failed due to Laravel 12 requiring PHP 8.4+
- Resolved by using PHP 8.4.12 from Herd installation

### Completion Notes
Implementation complete. All 7 tasks done, all 7 acceptance criteria satisfied. 9 feature tests passing. Story ready for code review.

---

## File List

### New Files
- `darts-community/` - Complete Laravel 12.46.0 project
- `darts-community/resources/views/layouts/app.blade.php` - Base layout with Tailwind CDN
- `darts-community/resources/views/pages/home.blade.php` - Landing page
- `darts-community/routes/web.php` - Updated with home route
- `darts-community/tests/Feature/LandingPageTest.php` - Feature tests for landing page

### Modified Files
- `_bmad-output/implementation-artifacts/sprint-status.yaml` - Status updated to in-progress → review
- `_bmad-output/implementation-artifacts/1-1-project-setup-landing-page.md` - This file

---

## Change Log

| Date | Change | Author |
|------|--------|--------|
| 2026-01-09 | Story implementation complete - Laravel 12 project with landing page | Claude Opus 4.5 |
