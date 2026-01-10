# Story 3.1: Club & Federation Data Models

Status: review

## Story

**As a** system administrator,
**I want** club and federation data structures in place,
**so that** players can affiliate with organizations.

## Acceptance Criteria

1. Club model created with fields: name, city, federation_id
2. Federation model created with fields: name, code (e.g., FFD), country
3. Seed data: FFD federation pre-populated
4. Basic club seeder with 5-10 sample French clubs
5. Player model has club_id foreign key (nullable)
6. Database migrations created and tested

## Tasks / Subtasks

- [x] Task 1: Create Federation Model & Migration (AC: 2)
  - [x] Create Federation model with proper type hints
  - [x] Create migration with name, code (unique), country columns
  - [x] Add Eloquent relationships (hasMany Club, hasMany Player)
  - [x] Add proper casts and fillable attributes

- [x] Task 2: Create Club Model & Migration (AC: 1)
  - [x] Create Club model with proper type hints
  - [x] Create migration with name, city, federation_id, is_active
  - [x] Add belongsTo Federation relationship
  - [x] Add hasMany Player relationship
  - [x] Add proper casts and fillable attributes

- [x] Task 3: Update Player Model (AC: 5)
  - [x] Add club_id and federation_id foreign keys to players migration
  - [x] Add belongsTo Club relationship to Player model
  - [x] Add belongsTo Federation relationship to Player model
  - [x] Update $fillable array

- [x] Task 4: Create Seeders (AC: 3, 4)
  - [x] Create FederationSeeder with FFD data
  - [x] Create ClubSeeder with 8 French clubs
  - [x] Add seeders to DatabaseSeeder call chain

- [x] Task 5: Run Migrations & Test (AC: 6)
  - [x] Run migrations fresh with seed
  - [x] Test migrations rollback
  - [x] Verify foreign key constraints work

- [x] Task 6: Write Tests
  - [x] Unit tests for Federation model relationships
  - [x] Unit tests for Club model relationships
  - [x] Unit tests for Player model club/federation relationships
  - [x] Feature tests for seeders (data exists)

## Dev Notes

### Ultimate Context for Flawless Implementation

Cette story pose les fondations du système d'affiliation des joueurs aux clubs et fédérations. C'est la première story de l'Epic 3 et elle prépare le terrain pour les stories suivantes (3.2 Club Selection Interface, 3.3 License Info, 3.4 Club History).

### Architecture Requirements (MUST FOLLOW)

**Federation Model Structure:**
```php
// Table: federations
- id: bigint unsigned (primary key)
- name: string (ex: "Fédération Française de Darts")
- code: string unique (ex: "FFD")
- country: string (ex: "France")
- timestamps (created_at, updated_at)
```

**Club Model Structure:**
```php
// Table: clubs
- id: bigint unsigned (primary key)
- name: string (ex: "Darts Club Paris")
- city: string nullable (ex: "Paris")
- federation_id: bigint unsigned nullable (foreign key)
- is_active: boolean default true
- timestamps (created_at, updated_at)
```

**Player Model Updates:**
```php
// Add to existing players table migration:
- club_id: bigint unsigned nullable (foreign key)
- federation_id: bigint unsigned nullable (foreign key)
```

### Code Patterns from Previous Stories

D'après l'analyse des stories 2.4 et 2.5, voici les patterns établis à suivre:

1. **Type Hints Obligatoires:** Toutes les méthodes doivent avoir des type hints de retour
2. **Casts Eloquent:** Utiliser `protected $casts` pour les types (boolean, etc.)
3. **Fillable:** Définir `protected $fillable` explicitement
4. **Relationships:** Utiliser les méthodes Laravel standard (belongsTo, hasMany)
5. **PSR-12:** Respecter les conventions de code Laravel/PSR-12

### Sample Club Data for Seeder

```php
[
    ['name' => 'Darts Club Paris', 'city' => 'Paris'],
    ['name' => 'Les Flèches Lyonnaises', 'city' => 'Lyon'],
    ['name' => 'Darts Marseille', 'city' => 'Marseille'],
    ['name' => 'Club de Fléchettes de Bordeaux', 'city' => 'Bordeaux'],
    ['name' => 'Nantes Darts', 'city' => 'Nantes'],
    ['name' => 'Toulouse Darts Club', 'city' => 'Toulouse'],
    ['name' => 'Strasbourg Fléchettes', 'city' => 'Strasbourg'],
    ['name' => 'Lille Darts Association', 'city' => 'Lille'],
]
```

### Federation Seed Data

```php
[
    'name' => 'Fédération Française de Darts',
    'code' => 'FFD',
    'country' => 'France',
]
```

### Testing Requirements

**Test Location:** `tests/Unit/Models/FederationTest.php`, `tests/Unit/Models/ClubTest.php`, `tests/Feature/Database/SeedersTest.php`

**Tests à créer:**
1. Federation has many clubs relationship
2. Federation has many players relationship
3. Club belongs to federation relationship
4. Club has many players relationship
5. Player belongs to club relationship
6. Player belongs to federation relationship
7. Seeder creates FFD federation
8. Seeder creates sample clubs

### Git Intelligence from Recent Work

Commits récents montrent:
- Pattern de commit: `feat: Story X-Y - Title` pour l'implémentation
- Pattern de commit: `fix: Code review fixes for Story X-Y` pour les corrections
- Tous les tests doivent passer avant commit
- Le fichier sprint-status.yaml doit être mis à jour

### Laravel Conventions (From Architecture)

- **Migrations:** Format `YYYY_MM_DD_HHMMSS_create_table_name.php`
- **Models:** PascalCase singulier (`Federation.php`, `Club.php`)
- **Seeders:** Format `TableNameSeeder.php` (`FederationSeeder.php`, `ClubSeeder.php`)
- **Foreign Keys:** Utiliser `constrained()` pour les contraintes automatiques
- **Nullable:** Utiliser `nullable()` pour les colonnes optionnelles

### Important Warnings

⚠️ **NE PAS:**
- Créer de routes ou contrôleurs (pas nécessaire pour cette story)
- Créer d'interface UI (Story 3.2 s'en charge)
- Ajouter de logique métier complexe (juste les modèles de base)
- Over-engineer avec des abstractions prématurées

✅ **FAIRE:**
- Suivre strictement les conventions Laravel
- Ajouter les type hints partout
- Écrire les tests avant de considérer terminé
- Vérifier que tous les tests passent (212 tests existants + nouveaux)

### Database Schema Relationships

```
federations
    ├─→ clubs (hasMany via federation_id)
    └─→ players (hasMany via federation_id)

clubs
    ├─→ federation (belongsTo via federation_id)
    └─→ players (hasMany via club_id)

players (existing)
    ├─→ club (belongsTo via club_id)
    └─→ federation (belongsTo via federation_id)
```

### Project Context Reference

Voir [docs/project-context.md](../../docs/project-context.md) pour:
- Conventions de nommage
- Standards de code PSR-12
- Workflow Git (feature branches)
- Design system colors (si nécessaire plus tard)

### References

- Architecture: [_bmad-output/planning-artifacts/architecture.md](../planning-artifacts/architecture.md) - Section 4.3 (Federation), 4.4 (Club)
- PRD: Story requirements originaux
- Previous Story: [2-5-profile-view-page.md](2-5-profile-view-page.md) - Patterns établis

## Dev Agent Record

### Agent Model Used

Claude Sonnet 4.5 (via bmad:bmm:workflows:dev-story)

### Debug Log References

N/A - Implementation completed without major debugging issues

### Completion Notes List

✅ Implemented TDD approach (Red-Green-Refactor cycle) for all features
✅ Created Federation and Club models with full Eloquent relationships
✅ Updated Player model to support club and federation affiliations
✅ Created comprehensive test suite (23 new tests, all passing)
✅ Implemented seeders for FFD federation and 8 sample French clubs
✅ All 6 acceptance criteria satisfied
✅ 234/235 total tests passing (1 pre-existing failure unrelated to this story)

### File List

**Models Created:**
- app/Models/Federation.php
- app/Models/Club.php

**Models Modified:**
- app/Models/Player.php

**Migrations Created:**
- database/migrations/2026_01_10_000001_create_federations_table.php
- database/migrations/2026_01_10_000002_create_clubs_table.php
- database/migrations/2026_01_10_000003_add_club_and_federation_to_players_table.php

**Factories Created:**
- database/factories/FederationFactory.php
- database/factories/ClubFactory.php

**Seeders Created:**
- database/seeders/FederationSeeder.php
- database/seeders/ClubSeeder.php

**Seeders Modified:**
- database/seeders/DatabaseSeeder.php

**Tests Created:**
- tests/Unit/Models/FederationTest.php
- tests/Unit/Models/ClubTest.php
- tests/Unit/Models/PlayerRelationshipsTest.php
- tests/Feature/Database/SeederTest.php

**Tests Modified:**
- tests/Feature/Profile/PlayerModelTest.php

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-01-08 | 1.0 | Initial story creation from PRD | Sarah (PO) |
| 2026-01-10 | 2.0 | Ultimate context engine analysis - comprehensive developer guide created | Claude (SM Agent) |
| 2026-01-10 | 3.0 | Story implementation completed - All ACs satisfied, 23 tests added, all passing | Claude (Dev Agent) |
