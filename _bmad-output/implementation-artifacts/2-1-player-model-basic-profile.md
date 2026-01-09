# Story 2.1: Player Model & Basic Profile Fields

## Status: done

## Story

**As a** registered user,
**I want** to create my player profile with basic information,
**so that** I have a foundation for my darts identity.

## Acceptance Criteria

1. Player model created with one-to-one relationship to User
2. Player profile automatically created upon user registration
3. Profile edit form with fields:
   - First name (prénom)
   - Last name (nom)
   - Nickname/pseudo (optional)
   - Date of birth
   - City (ville)
4. All fields validated appropriately (required fields, date format)
5. Profile data persisted to database
6. Success/error feedback displayed in French
7. Profile page displays entered information

## Tasks / Subtasks

- [x] Task 1: Create Player Model & Migration (AC: 1)
  - [x] Create Player model with fillable fields
  - [x] Create migration with all columns
  - [x] Define belongsTo User relationship
  - [x] Define hasOne Player in User model

- [x] Task 2: Auto-create Player on Registration (AC: 2)
  - [x] Create PlayerService with createForUser method
  - [x] Create UserObserver to trigger on user creation
  - [x] Generate unique public_slug

- [x] Task 3: Create Profile Edit Form (AC: 3, 4)
  - [x] Create ProfileController with edit/update methods
  - [x] Create ProfileUpdateRequest for validation
  - [x] Create `resources/views/pages/profile/edit.blade.php`
  - [x] Add all form fields with French labels

- [x] Task 4: Profile View Page (AC: 7)
  - [x] Add show method to ProfileController
  - [x] Create `resources/views/pages/profile/show.blade.php`
  - [x] Display all profile fields

- [x] Task 5: Flash Messages (AC: 5, 6)
  - [x] Implement success message on save
  - [x] Implement error display for validation

## Dev Notes

### Relevant Architecture References

**Player Model Fields:**
```php
- id: bigint unsigned
- user_id: bigint unsigned (unique, FK)
- first_name: string nullable
- last_name: string nullable
- nickname: string nullable
- date_of_birth: date nullable
- city: string nullable
- skill_level: enum nullable
- profile_photo_path: string nullable
- cover_photo_path: string nullable
- public_slug: string unique
```

**PlayerService:**
```php
public function createForUser(User $user): Player
{
    return Player::create([
        'user_id' => $user->id,
        'public_slug' => $this->generateUniqueSlug($user),
    ]);
}
```

### Testing

**Test Location:** `tests/Feature/Profile/ProfileTest.php`

### Context Notes

- Story 1-3 (OAuth Authentication) est mise de côté pour le moment
- Cette story démarre l'Epic 2 (Player Profile Core)
- Dépend de: Story 1-1 (Project Setup) et Story 1-2 (Email/Password Auth) - toutes deux terminées

## Dev Agent Record

### Implementation Plan
1. Created Player model with all required fields and User relationship
2. Created migration with proper column types and constraints
3. Created PlayerService for player creation with unique slug generation
4. Created UserObserver to auto-create Player on user registration
5. Created PlayerProfileController with edit/update/show methods
6. Created PlayerProfileUpdateRequest with French validation messages
7. Created profile edit form view with all fields in French
8. Created profile show view with profile completeness indicator
9. Added tests for flash messages and French validation messages

### Debug Log
- Initial tests passed after adjusting "Non renseigné" placeholder text

### Completion Notes
All acceptance criteria met:
- AC1: Player model with one-to-one relationship to User ✓
- AC2: Player auto-created on registration ✓
- AC3: Profile edit form with all required fields ✓
- AC4: Validation rules properly configured ✓
- AC5: Data persisted to database ✓
- AC6: French success/error messages ✓
- AC7: Profile view page displays all information ✓

## File List

### Created Files
- `app/Models/Player.php`
- `app/Http/Controllers/PlayerProfileController.php`
- `app/Http/Requests/PlayerProfileUpdateRequest.php`
- `app/Services/PlayerService.php`
- `app/Observers/UserObserver.php`
- `database/migrations/2026_01_09_000001_create_players_table.php`
- `resources/views/pages/profile/edit.blade.php`
- `resources/views/pages/profile/show.blade.php`
- `tests/Feature/Profile/PlayerModelTest.php`
- `tests/Feature/Profile/PlayerAutoCreationTest.php`
- `tests/Feature/Profile/ProfileEditTest.php`
- `tests/Feature/Profile/ProfileShowTest.php`

### Modified Files
- `app/Models/User.php` - Added hasOne Player relationship
- `app/Providers/AppServiceProvider.php` - Registered UserObserver
- `routes/web.php` - Added player profile routes

## Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-01-08 | 1.0 | Initial story creation from PRD | Sarah (PO) |
| 2026-01-09 | 1.1 | Story prepared for development | Claude |
