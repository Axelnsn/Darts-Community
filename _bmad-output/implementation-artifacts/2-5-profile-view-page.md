# Story 2.5: Profile View Page

## Status: done

## Story

**As a** player,
**I want** to view my complete profile,
**so that** I can see how my information is presented.

## Acceptance Criteria

1. Dedicated profile view page (not edit mode)
2. Cover photo displayed as header banner
3. Profile photo displayed as avatar overlay
4. Name, nickname, city displayed prominently
5. Skill level badge visible
6. Walk-on song player embedded (if configured)
7. Card-based layout for profile sections
8. Mobile-responsive design
9. Navigation to edit mode for profile owner

## Tasks / Subtasks

- [x] Task 1: Create Profile View Route & Controller (AC: 1, 9)
  - [x] Add `GET /player/profile` route
  - [x] Add show method to ProfileController
  - [x] Add "Modifier" button for owner

- [x] Task 2: Create Profile View Template (AC: 2, 3, 4, 7)
  - [x] Create `resources/views/pages/profile/show.blade.php`
  - [x] Add cover photo as header banner
  - [x] Add profile photo as avatar overlay
  - [x] Display name, nickname, city
  - [x] Use card components for sections

- [x] Task 3: Integrate Components (AC: 5, 6)
  - [x] Include skill-badge component
  - [x] Include walkon-player component

- [x] Task 4: Responsive Design (AC: 8)
  - [x] Ensure mobile-first layout
  - [x] Test on various screen sizes
  - [x] Adjust card layout for mobile

## Review Follow-ups (AI Code Review)

### Issues Fixed (7 items - version 2.1)
- [x] [AI-Review][HIGH] Git vs Story File List discrepancy - Added missing files to File List
- [x] [AI-Review][HIGH] Route documentation error - Corrected `/profile` to `/player/profile` in Task 1
- [x] [AI-Review][MEDIUM] City display missing fallback - Added "Ville non renseignée" for consistency
- [x] [AI-Review][HIGH] Missing responsive design tests - Added 5 tests for AC8 validation [ProfileShowTest.php:164-215]
- [x] [AI-Review][MEDIUM] Hardcoded i18n strings - Added TODO comment for future extraction [show.blade.php:1]
- [x] [AI-Review][MEDIUM] Profile completeness logic untested - Added 3 tests for percentage calculation [ProfileShowTest.php:217-271]
- [x] [AI-Review][MEDIUM] Uncommitted git changes - Created .gitignore for Claude settings

### Additional Improvements (2 items - version 2.2)
- [x] [AI-Review][LOW] Magic number extracted to Player model - Added getCompletableFields() and getCompletenessPercentage() methods [Player.php:62-87, show.blade.php:149]
- [x] [AI-Review][LOW] Accessibility improved - Added aria-label and role attributes to all SVG icons [show.blade.php:13,22,44,66,85,138,155]

## Dev Notes

### Relevant Architecture References

**Profile View Layout:**
```
┌─────────────────────────────────┐
│        Cover Photo Banner       │
│    ┌────────┐                   │
│    │ Avatar │                   │
│    └────────┘                   │
├─────────────────────────────────┤
│  Name  │  Nickname  │  City     │
│        Skill Badge              │
├─────────────────────────────────┤
│     Walk-on Song Player         │
├─────────────────────────────────┤
│  [Club Card]  [Setup Card]      │
└─────────────────────────────────┘
```

**Card Component:**
```blade
<x-ui.card title="Mon Setup">
    {{ $slot }}
</x-ui.card>
```

### Testing

**Test Location:** `tests/Feature/Profile/ProfileShowTest.php`

### Dependencies

- Requires Story 2.1 (Player Model) to be completed first
- Requires Story 2.2 (Profile Photo) for images
- Requires Story 2.3 (Skill Level) for badge
- Requires Story 2.4 (Walk-on Song) for audio player

## Dev Agent Record

### Implementation Plan
La story 2.5 implémente une page de visualisation du profil joueur avec:
- Cover photo en banner header avec gradient par défaut
- Avatar overlay positionné en bas du banner
- Affichage du nom, pseudo et ville avec icône de localisation
- Badge de niveau intégré à côté du nom
- Lecteur walk-on song dans une carte dédiée
- Layout responsive avec Tailwind (mobile-first)
- Bouton "Modifier" accessible depuis la page

### Debug Log
- Correction du test `test_profile_shows_skill_badge_when_set`: utilisation de `SkillLevel::CONFIRME` au lieu de `SkillLevel::Intermediate`
- Correction du test `test_profile_completeness_includes_skill_level`: ajout des champs photo dans le calcul de complétion (8 champs au total)
- Correction du test `test_skill_badge_displayed_prominently_on_profile`: suppression de la dépendance au header "Mon Profil" qui n'existe plus dans le nouveau layout

### Completion Notes
Implémentation complète de la page de visualisation du profil avec:
- Layout moderne avec cover photo et avatar overlay
- Affichage conditionnel des composants (skill-badge, walkon-player)
- Barre de progression de complétion du profil améliorée (inclut photos)
- Design responsive avec breakpoints sm/lg
- 13 tests unitaires et d'intégration couvrant tous les AC
- Tous les 212 tests du projet passent sans régression

## File List

- `darts-community/app/Models/Player.php` (modified)
- `darts-community/resources/views/pages/profile/show.blade.php` (modified)
- `darts-community/tests/Feature/Profile/ProfileShowTest.php` (modified)
- `darts-community/tests/Feature/Profile/SkillLevelTest.php` (modified)
- `_bmad-output/implementation-artifacts/sprint-status.yaml` (modified)
- `_bmad-output/implementation-artifacts/2-5-profile-view-page.md` (modified)
- `.gitignore` (created)

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-01-08 | 1.0 | Initial story creation from PRD | Sarah (PO) |
| 2026-01-09 | 1.1 | Story prepared for development | Claude |
| 2026-01-09 | 2.0 | Implementation complete - profile view with cover/avatar/cards | Dev Agent (Amelia) |
| 2026-01-10 | 2.1 | Code review fixes: File List updated, route doc corrected, city fallback, responsive tests, i18n TODO, completeness tests | Review Agent |
| 2026-01-10 | 2.2 | LOW priority improvements: Magic number extraction (Player methods), accessibility attributes (SVG aria-label) | Review Agent |
