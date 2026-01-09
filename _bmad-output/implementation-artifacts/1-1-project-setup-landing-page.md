# Story 1.1: Project Setup & Landing Page

## Status: in-progress

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
- [ ] Run `composer create-project laravel/laravel darts-community`
- [ ] Verify PHP 8.2+ and Laravel 11.x versions
- [ ] Configure .env for local development (SQLite)
- [ ] Run `php artisan key:generate`
- [ ] Test with `php artisan serve`

### Task 2: Create Base Layout
- [ ] Create `resources/views/layouts/app.blade.php`
- [ ] Add Tailwind CSS Play CDN: `<script src="https://cdn.tailwindcss.com"></script>`
- [ ] Add Inter font from Google Fonts
- [ ] Configure custom colors in Tailwind config block
- [ ] Add responsive meta viewport
- [ ] Create @yield('content') section

### Task 3: Create Landing Page View
- [ ] Create `resources/views/pages/home.blade.php`
- [ ] Extend app layout
- [ ] Build hero section with:
  - Background gradient (green/dark)
  - Headline: "Votre identité de joueur comme les pros"
  - Sub-headline about the platform
  - CTA buttons
- [ ] Build feature cards section
- [ ] Add footer with basic links

### Task 4: Configure Route
- [ ] Add route in `routes/web.php`: `Route::get('/', fn() => view('pages.home'))->name('home');`
- [ ] Verify route works

### Task 5: Style with Design System Colors
- [ ] Primary: #1B4D3E (Dartboard Green)
- [ ] Secondary: #D4AF37 (Gold)
- [ ] Accent: #C41E3A (Target Red)
- [ ] Apply consistent spacing (16px/24px)
- [ ] Ensure 4.5:1 contrast ratios

### Task 6: Mobile Optimization
- [ ] Test on mobile viewport
- [ ] Adjust hero for stacked layout on mobile
- [ ] Ensure cards stack vertically
- [ ] Verify touch targets

### Task 7: Git Setup
- [ ] Initialize git repository
- [ ] Create appropriate .gitignore
- [ ] Initial commit
- [ ] Create GitHub repository
- [ ] Push to remote

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

- [ ] Laravel 11+ project initialized and running
- [ ] Tailwind CSS working via CDN (no build)
- [ ] Landing page displays at root URL
- [ ] Hero section with French copy and CTAs
- [ ] Feature cards section (3 cards)
- [ ] Page is mobile-responsive
- [ ] Base layout template created and reusable
- [ ] Git repository initialized and pushed to GitHub
- [ ] Code follows PSR-12 and Laravel conventions
- [ ] No console errors in browser

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
