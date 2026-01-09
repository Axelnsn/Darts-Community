# Darts Community Product Requirements Document (PRD)

> **Version:** 1.1
> **Date:** 2026-01-08
> **Status:** Validé - Prêt pour Architecture

---

## 1. Goals and Background Context

### 1.1 Goals

- **Enable amateur darts players to create a comprehensive digital identity** centralizing their personal info, club affiliation, equipment, and career history
- **Provide a modular dart equipment management system** allowing players to manage individual components (tips, barrels, shafts, flights) and assemble complete setups
- **Create a shareable public profile** with customizable privacy settings and unique "walk-on song" identity feature
- **Establish foundation for community platform** connecting players, clubs, and federations in the French darts ecosystem
- **Achieve MVP validation** with 100 user signups within 6 months and 50+ organic registrations in first 3 months

### 1.2 Background Context

Darts Community addresses a significant gap in the amateur darts ecosystem: players currently lack a centralized platform to manage their player identity, track progression, and connect with clubs and federations. Existing solutions like Dartscounter and n01 focus solely on score counting without community features, while club websites are fragmented and often outdated.

The platform capitalizes on growing darts popularity (driven by PDC streaming) among amateurs seeking to professionalize their experience. By offering a gamified "all-in-one" platform - the "Strava for darts" - Darts Community aims to become the reference for the French-speaking darts community before expanding internationally.

### 1.3 Change Log

| Date | Version | Description | Author |
|------|---------|-------------|--------|
| 2026-01-08 | 1.1 | Added Epic 7: Back-Office Administrateur (6 stories, FR26-31) | John (PM) |
| 2026-01-08 | 1.0 | Complete PRD with 6 epics, 24 stories, checklist validated | John (PM) |
| 2026-01-08 | 0.1 | Initial PRD draft based on Project Brief v1.0 | John (PM) |

---

## 2. Requirements

### 2.1 Functional Requirements

**Authentication & Onboarding**
- **FR1:** The system shall provide OAuth authentication via Google and Facebook using Laravel Socialite
- **FR2:** The system shall provide email/password authentication as a fallback option using Laravel Breeze
- **FR3:** The system shall guide new users through a step-by-step onboarding flow to complete their profile
- **FR4:** Users shall be able to modify their email, password, and delete their account (GDPR compliance)

**Player Profile - Identity**
- **FR5:** Users shall create a player profile with basic info: name, surname, nickname, date of birth, city
- **FR6:** Users shall upload a profile photo and cover photo (Facebook-style banner)
- **FR7:** Users shall self-declare their skill level: Débutant, Amateur, Confirmé, Semi-pro, Pro
- **FR8:** Users shall configure a "walk-on song" via YouTube/Spotify embed OR upload an MP3 file (max 2 minutes)
- **FR9:** Users shall configure email visibility (public/private)

**Player Profile - Club Affiliation**
- **FR10:** Users shall select their current club from a list of existing clubs or mark as "Sans club" (No club)
- **FR11:** Users shall enter their FFD license number manually
- **FR12:** Users shall select their federation (FFD, etc.)
- **FR13:** The system shall display a read-only club history timeline (populated by future transfer system)

**Equipment Management - Modular System**
- **FR14:** Users shall add dart components to their inventory: Tips (pointes), Barrels (fûts), Shafts (tiges), Flights (ailettes)
- **FR15:** Each component type shall have specific attributes:
  - Tips: brand, model, type (steel/soft), length
  - Barrels: brand, model, weight, material, grip style
  - Shafts: brand, model, length, material
  - Flights: brand, model, shape, thickness
- **FR16:** Users shall assemble components into complete dart configurations
- **FR17:** Users shall designate 1-3 dart sets as their "current setup"
- **FR18:** The system shall provide a pre-populated catalog of brands/models (admin-maintained)
- **FR19:** Users shall add custom components not in the catalog with optional photo upload

**Privacy & Visibility**
- **FR20:** Users shall configure visibility per profile section: Personal info, Setup, Affiliation (Public/Private)
- **FR21:** The system shall generate a unique shareable URL for each player's public profile
- **FR22:** Public profiles shall be viewable without authentication (respecting privacy settings)

**Admin - Equipment Catalog**
- **FR23:** Administrators shall perform CRUD operations on brands and component models
- **FR24:** The catalog shall follow hierarchical structure: Brand > Range > Model
- **FR25:** Each component type shall have type-specific attribute fields

**Admin - Back-Office**
- **FR26:** Administrators shall access a dashboard displaying key platform metrics (users, registrations, activity)
- **FR27:** Administrators shall view, search, and filter the complete user list
- **FR28:** Administrators shall perform account actions: view profile, edit info, suspend/reactivate, force password reset, delete
- **FR29:** Administrators shall manage admin roles (promote/demote users, view action history)
- **FR30:** Administrators shall moderate user-uploaded content (photos, MP3s) with approve/flag/remove actions
- **FR31:** Administrators shall manage clubs and federations (CRUD, bulk import, merge duplicates)

### 2.2 Non-Functional Requirements

**Performance**
- **NFR1:** Page load time shall achieve Core Web Vitals targets: LCP < 2.5s, FID < 100ms, CLS < 0.1
- **NFR2:** Profile completion flow shall be achievable in under 10 minutes
- **NFR3:** The platform shall maintain 99.5% uptime

**Security & Compliance**
- **NFR4:** The system shall comply with GDPR: explicit consent, right to erasure, data export
- **NFR5:** All file uploads shall be validated for type and size (prevent malicious uploads)
- **NFR6:** The system shall implement CSRF, XSS, and SQL injection protection (Laravel native)
- **NFR7:** Authentication endpoints shall implement rate limiting
- **NFR8:** Private email addresses shall be encrypted at rest

**Compatibility**
- **NFR9:** The platform shall support Chrome, Firefox, Safari, Edge (last 2 versions)
- **NFR10:** The UI shall be fully responsive (desktop and mobile)
- **NFR11:** The platform shall be PWA-ready for home screen installation

**Scalability**
- **NFR12:** Database schema shall support future expansion (clubs, federations, competitions)
- **NFR13:** File storage architecture shall support migration from local to S3-compatible storage

**Localization**
- **NFR14:** MVP shall be in French only; architecture shall support future multi-language expansion

---

## 3. User Interface Design Goals

### 3.1 Overall UX Vision

A clean, modern, and approachable interface that evokes the energy of professional darts while remaining accessible to amateur players. The design should feel aspirational (like a pro player's profile) but not intimidating. Think "sports card meets social profile" - showcasing the player's identity with pride.

Key principles:
- **Progressive disclosure**: Complex features (equipment builder) revealed gradually
- **Mobile-first responsive**: Designed for phone use at the club, with full desktop support
- **Gamified touches**: Subtle animations and visual feedback that reinforce the "pro" feeling
- **French-first**: All copy in French, culturally appropriate design patterns

### 3.2 Key Interaction Paradigms

- **Card-based layout**: Profile sections presented as distinct cards (Identity, Club, Setup) that can be expanded/collapsed
- **Drag-and-drop assembly**: For the modular dart builder - drag components to assemble a complete dart
- **Inline editing**: Edit profile fields directly without navigating to separate edit pages
- **Modal dialogs**: For adding components, walk-on song configuration, privacy settings
- **Progressive onboarding**: Wizard-style flow for initial profile creation with skip options

### 3.3 Core Screens and Views

| Screen | Purpose |
|--------|---------|
| Landing Page | Marketing homepage with value proposition, CTA to sign up |
| Registration/Login | OAuth buttons (Google, Facebook) + email/password form |
| Onboarding Wizard | Step-by-step profile creation (Identity → Club → Setup) |
| Player Profile (Public) | Shareable view with visible sections based on privacy settings |
| Player Profile (Private/Edit) | Full profile with edit capabilities for authenticated owner |
| Equipment Builder | Modular interface for creating/managing dart components and assemblies |
| Setup Showcase | Visual display of current dart setup with component details |
| Account Settings | Email, password, privacy settings, account deletion |
| Admin: Catalog Manager | CRUD interface for brands/models (admin only) |
| Admin: Dashboard | Platform metrics and KPIs overview |
| Admin: User Management | User list, details, actions (suspend, delete, etc.) |
| Admin: Content Moderation | Review and moderate uploaded content |
| Admin: Club/Federation Management | CRUD for clubs and federations |

### 3.4 Accessibility

**WCAG AA Compliance**

- Sufficient color contrast ratios (4.5:1 for text)
- Keyboard navigation support for all interactive elements
- Screen reader compatible with proper ARIA labels
- Focus indicators visible on all interactive elements
- Alt text for all images (profile photos, component images)

### 3.5 Branding

- **Color palette**: Deep green (dartboard feel) + gold/yellow accents (scoring highlights) + dark grays
- **Typography**: Modern sans-serif, bold headers for impact
- **Imagery**: High-quality dart photography, clean iconography
- **Tone**: Professional but fun, competitive but welcoming

*Note: No formal brand guide exists yet. Recommend creating brand tokens early in development.*

### 3.6 Target Devices and Platforms

**Web Responsive**

- **Primary**: Mobile web (players at club checking profiles on phone)
- **Secondary**: Desktop (profile editing, admin functions)
- **PWA-ready**: Installable on home screen for quick access
- **No native app for MVP**: Web-only to reduce development complexity

---

## 4. Technical Assumptions

### 4.1 Repository Structure

**Monorepo**

Single repository containing the complete Laravel application. Given the solo developer context and monolithic architecture, a monorepo simplifies development workflow, deployment, and dependency management.

```
darts-community/
├── app/                    # Laravel application code
│   ├── Models/
│   ├── Http/Controllers/
│   └── Services/
├── database/
│   └── migrations/
├── resources/
│   └── views/
├── public/
├── routes/
├── tests/
└── storage/
```

### 4.2 Service Architecture

**Monolith (Laravel)**

A monolithic Laravel application is the right choice for this MVP:

- **Rationale**: Solo developer, limited resources, need for rapid iteration
- **Framework**: Laravel 11+ with Eloquent ORM
- **Frontend**: Blade templates + Tailwind CSS (CDN) - no build process
- **API design**: Internal RESTful patterns for future API expansion
- **Queue jobs**: Laravel Queue for heavy operations (image processing, MP3 uploads)

### 4.3 Testing Requirements

**Unit + Integration Testing**

| Test Type | Scope | Tools |
|-----------|-------|-------|
| Unit Tests | Models, Services, isolated logic | PHPUnit |
| Feature Tests | HTTP endpoints, authentication flows | Laravel HTTP Tests |
| Browser Tests | Critical user journeys (optional MVP) | Laravel Dusk (if needed) |

**MVP Testing Strategy:**
- Focus on critical paths: authentication, profile CRUD, equipment assembly
- Aim for 70%+ code coverage on business logic
- Integration tests for OAuth flows
- Manual testing for UI/UX validation

### 4.4 Additional Technical Assumptions and Requests

**Authentication Stack**
- Laravel Breeze for email/password authentication scaffolding
- Laravel Socialite for OAuth (Google, Facebook)
- Session-based authentication (not API tokens for MVP)

**Database**
- MySQL/MariaDB for production (relational model fits domain well)
- SQLite for local development
- Migrations for all schema changes

**File Storage**
- Local filesystem for MVP (storage/app/public)
- S3-compatible adapter configured but not active
- Image optimization on upload (resize, compress)
- MP3 validation (format, duration limit)

**Development Environment**
- Laravel Herd for local development
- Git + GitHub for version control
- No CI/CD for MVP (manual deployment initially)

**Hosting**
- Dedicated hosting (not shared) for performance
- Specific provider TBD

**Third-Party Integrations**
- YouTube embed (iframe) for walk-on songs
- Spotify embed (iframe) for walk-on songs
- Google Maps embed for future club locations

**Security Implementation**
- Laravel's built-in CSRF protection
- Rate limiting via Laravel's RateLimiter
- File upload validation (MIME type, size limits)

**Code Style**
- PSR-12 coding standard
- Laravel conventions for naming and structure

---

## 5. Epic List

| Epic | Title | Goal |
|------|-------|------|
| **Epic 1** | Foundation & Authentication | Establish project infrastructure, authentication system (OAuth + email/password), and basic user account management with a functional landing page |
| **Epic 2** | Player Profile Core | Enable players to create and manage their complete profile identity including personal info, photos, skill level, and walk-on song |
| **Epic 3** | Club Affiliation | Allow players to connect with clubs, enter license information, and display federation affiliations |
| **Epic 4** | Equipment Catalog & Admin | Build the admin-managed catalog of dart component brands/models that powers the equipment system |
| **Epic 5** | Modular Equipment System | Implement the component-based dart assembly system allowing players to manage their equipment and showcase their current setup |
| **Epic 6** | Privacy & Public Profiles | Add privacy controls per section and enable shareable public profile URLs |
| **Epic 7** | Back-Office Administrateur | Provide administrators with a complete dashboard to manage users, monitor platform growth, and moderate content |

---

## 6. Epic Details

### Epic 1: Foundation & Authentication

**Goal:** Establish project infrastructure, authentication system (OAuth + email/password), and basic user account management with a functional landing page. This epic delivers the technical foundation and first deployable increment - users can visit the site, understand its purpose, register, login, and manage their basic account.

#### Story 1.1: Project Setup & Landing Page

**As a** visitor,
**I want** to see a professional landing page explaining Darts Community,
**so that** I understand the platform's value and can decide to sign up.

**Acceptance Criteria:**
1. Laravel 11+ project initialized with standard directory structure
2. Tailwind CSS loaded via CDN (no build process)
3. Landing page displays at root URL with:
   - Hero section with value proposition in French
   - Key features overview (profile, equipment, community)
   - Call-to-action buttons for registration/login
4. Page is mobile-responsive
5. Basic Blade layout template established for reuse
6. Git repository initialized and pushed to GitHub

#### Story 1.2: Email/Password Authentication

**As a** new user,
**I want** to register with my email and password,
**so that** I can create an account without social media.

**Acceptance Criteria:**
1. Laravel Breeze installed and configured for session-based auth
2. Registration form collects: email, password, password confirmation
3. Email validation (format, uniqueness)
4. Password requirements enforced (min 8 characters)
5. Successful registration redirects to dashboard/profile placeholder
6. Login form with email/password fields
7. "Forgot password" flow functional with email reset link
8. All forms display validation errors in French
9. Rate limiting applied to auth endpoints (5 attempts/minute)

#### Story 1.3: OAuth Authentication (Google & Facebook)

**As a** new user,
**I want** to register/login with my Google or Facebook account,
**so that** I can sign up quickly without creating a new password.

**Acceptance Criteria:**
1. Laravel Socialite installed and configured
2. Google OAuth integration functional (client ID/secret configured)
3. Facebook OAuth integration functional (app ID/secret configured)
4. OAuth buttons displayed on login/registration pages
5. New users via OAuth create account automatically
6. Existing users via OAuth log in to existing account (matched by email)
7. OAuth errors handled gracefully with user-friendly French messages
8. User's OAuth provider stored for future reference

#### Story 1.4: Account Settings & GDPR Compliance

**As a** registered user,
**I want** to manage my account settings and delete my account,
**so that** I have control over my data per GDPR requirements.

**Acceptance Criteria:**
1. Account settings page accessible to authenticated users
2. User can update email address (with re-verification)
3. User can change password (requires current password)
4. User can request account deletion with confirmation modal
5. Account deletion removes all user data (soft delete with 30-day grace period, then hard delete)
6. GDPR consent checkbox on registration form
7. Privacy policy and terms of service pages exist (placeholder content)
8. User can export their data (JSON format) - basic implementation

---

### Epic 2: Player Profile Core

**Goal:** Enable players to create and manage their complete profile identity including personal info, photos, skill level, and walk-on song. This epic delivers the core user value - players can establish their digital identity as a darts player.

#### Story 2.1: Player Model & Basic Profile Fields

**As a** registered user,
**I want** to create my player profile with basic information,
**so that** I have a foundation for my darts identity.

**Acceptance Criteria:**
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

#### Story 2.2: Profile Photo & Cover Image Upload

**As a** player,
**I want** to upload my profile photo and cover image,
**so that** my profile looks professional and personalized.

**Acceptance Criteria:**
1. Profile photo upload field (square, displayed as avatar)
2. Cover photo upload field (wide banner, Facebook-style)
3. Accepted formats: JPG, PNG, WebP
4. Maximum file size: 5MB per image
5. Images automatically resized/optimized on upload
6. Images stored in storage/app/public with proper paths
7. Default placeholder images shown when not uploaded
8. User can replace or remove uploaded images
9. MIME type validation to prevent malicious uploads

#### Story 2.3: Skill Level Selection

**As a** player,
**I want** to declare my skill level,
**so that** others know my playing experience.

**Acceptance Criteria:**
1. Skill level dropdown/selector on profile edit
2. Options: Débutant, Amateur, Confirmé, Semi-pro, Pro
3. Level displayed prominently on profile view
4. Visual indicator/badge for skill level
5. Level stored in player record
6. Default value: none selected (requires user choice)

#### Story 2.4: Walk-on Song Configuration

**As a** player,
**I want** to set my walk-on song,
**so that** I can express my personality like professional players.

**Acceptance Criteria:**
1. Walk-on song section on profile edit page
2. Option 1: YouTube URL input with embed preview
3. Option 2: Spotify URL input with embed preview
4. Option 3: MP3 file upload (max 2 minutes, max 10MB)
5. URL validation for YouTube/Spotify formats
6. MP3 duration validation (reject files > 2 minutes)
7. Audio player displayed on profile view
8. User can switch between embed and upload options
9. User can remove walk-on song

#### Story 2.5: Profile View Page

**As a** player,
**I want** to view my complete profile,
**so that** I can see how my information is presented.

**Acceptance Criteria:**
1. Dedicated profile view page (not edit mode)
2. Cover photo displayed as header banner
3. Profile photo displayed as avatar overlay
4. Name, nickname, city displayed prominently
5. Skill level badge visible
6. Walk-on song player embedded (if configured)
7. Card-based layout for profile sections
8. Mobile-responsive design
9. Navigation to edit mode for profile owner

---

### Epic 3: Club Affiliation

**Goal:** Allow players to connect with clubs, enter license information, and display federation affiliations. This epic adds the community connection layer to player profiles.

#### Story 3.1: Club & Federation Data Models

**As a** system administrator,
**I want** club and federation data structures in place,
**so that** players can affiliate with organizations.

**Acceptance Criteria:**
1. Club model created with fields: name, city, federation_id
2. Federation model created with fields: name, code (e.g., FFD), country
3. Seed data: FFD federation pre-populated
4. Basic club seeder with 5-10 sample French clubs
5. Player model has club_id foreign key (nullable)
6. Database migrations created and tested

#### Story 3.2: Club Selection Interface

**As a** player,
**I want** to select my current club,
**so that** my club affiliation is visible on my profile.

**Acceptance Criteria:**
1. Club selection dropdown on profile edit page
2. Searchable/filterable club list (by name, city)
3. "Sans club" (No club) option available
4. Selected club displayed on profile view
5. Club name links to club info (placeholder for future club pages)
6. Club change persisted to database

#### Story 3.3: License & Federation Information

**As a** player,
**I want** to enter my license number and federation,
**so that** my official status is documented.

**Acceptance Criteria:**
1. License number text input field
2. Federation dropdown (FFD pre-selected as default)
3. License number validation (format check if applicable)
4. Federation and license displayed on profile view
5. Fields are optional (player can skip)
6. Data persisted to player record

#### Story 3.4: Club History Timeline (Read-Only)

**As a** player,
**I want** to see my club history,
**so that** my career path is documented.

**Acceptance Criteria:**
1. Club history section on profile view
2. Displays chronological list of clubs with dates
3. Current club marked as "Actuel"
4. History initially empty (populated by future transfer system)
5. Read-only display (no manual editing for MVP)
6. Placeholder message when no history exists

---

### Epic 4: Equipment Catalog & Admin

**Goal:** Build the admin-managed catalog of dart component brands/models that powers the equipment system. This epic creates the foundation data that users will select from.

#### Story 4.1: Admin Role & Access Control

**As a** system administrator,
**I want** admin-only access to catalog management,
**so that** only authorized users can modify the catalog.

**Acceptance Criteria:**
1. Admin role added to User model (is_admin boolean)
2. Admin middleware protecting catalog routes
3. First user or seeded user marked as admin
4. Admin navigation visible only to admin users
5. Non-admin users redirected if accessing admin routes

#### Story 4.2: Brand Management

**As an** administrator,
**I want** to manage dart equipment brands,
**so that** users can select from known manufacturers.

**Acceptance Criteria:**
1. Brand model with fields: name, logo (optional), website (optional)
2. Admin CRUD interface for brands
3. Brand list view with search/filter
4. Create brand form with validation
5. Edit/delete brand functionality
6. Seed data: 10-15 popular brands (Target, Winmau, Harrows, Unicorn, etc.)

#### Story 4.3: Component Type Structure

**As an** administrator,
**I want** to define component types with specific attributes,
**so that** each dart part has appropriate fields.

**Acceptance Criteria:**
1. ComponentType enum or model: Tip, Barrel, Shaft, Flight
2. Type-specific attribute definitions:
   - Tip: type (steel/soft), length
   - Barrel: weight, material, grip_style
   - Shaft: length, material
   - Flight: shape, thickness
3. Attribute validation rules per type
4. UI adapts form fields based on component type

#### Story 4.4: Component Model Management

**As an** administrator,
**I want** to add component models to the catalog,
**so that** users can select specific products.

**Acceptance Criteria:**
1. Component model with fields: brand_id, type, name, attributes (JSON), image (optional)
2. Admin CRUD interface for components
3. Filter components by type and brand
4. Create component form with dynamic fields based on type
5. Image upload for component (optional)
6. Seed data: 20-30 popular components across types

#### Story 4.5: Catalog Hierarchy View

**As an** administrator,
**I want** to view the catalog organized by brand and type,
**so that** I can manage the inventory effectively.

**Acceptance Criteria:**
1. Catalog dashboard showing statistics (total brands, components per type)
2. Hierarchical view: Brand > Type > Models
3. Quick filters by brand, type
4. Search across all components
5. Export catalog data (optional, for backup)

---

### Epic 5: Modular Equipment System

**Goal:** Implement the component-based dart assembly system allowing players to manage their equipment and showcase their current setup. This is the key differentiator of the platform.

#### Story 5.1: Player Component Inventory

**As a** player,
**I want** to add components to my personal inventory,
**so that** I can track all my dart equipment.

**Acceptance Criteria:**
1. PlayerComponent model linking Player to Component (or custom)
2. "My Components" section in profile
3. Add component from catalog (searchable dropdown)
4. Add custom component (manual entry with optional photo)
5. View all owned components grouped by type
6. Remove component from inventory

#### Story 5.2: Custom Component Entry

**As a** player,
**I want** to add components not in the catalog,
**so that** I can track all my equipment regardless of catalog coverage.

**Acceptance Criteria:**
1. "Add Custom" option when component not found
2. Manual entry form: brand name, model name, type, attributes
3. Optional photo upload for custom component
4. Custom components marked differently from catalog items
5. Custom components only visible to owner (not in global catalog)

#### Story 5.3: Dart Assembly Builder

**As a** player,
**I want** to assemble components into complete darts,
**so that** I can define my dart configurations.

**Acceptance Criteria:**
1. Dart model: tip_id, barrel_id, shaft_id, flight_id, player_id, name
2. "Create Dart" interface showing 4 component slots
3. Select components from player's inventory for each slot
4. Visual representation of assembled dart
5. Name the dart configuration (e.g., "Match Darts", "Practice Set")
6. Save dart assembly to database
7. Edit/delete existing dart assemblies

#### Story 5.4: Current Setup Designation

**As a** player,
**I want** to mark darts as my current setup,
**so that** visitors see what I'm currently using.

**Acceptance Criteria:**
1. "Set as Current" action on dart assemblies
2. Maximum 3 dart sets as current setup
3. Current setup highlighted in inventory view
4. Current setup prominently displayed on profile view
5. Remove from current setup functionality
6. Reorder current setup display (optional)

#### Story 5.5: Setup Showcase Display

**As a** visitor,
**I want** to see a player's current dart setup,
**so that** I can learn about their equipment choices.

**Acceptance Criteria:**
1. "Mon Setup" section on profile view
2. Visual card for each current dart showing all components
3. Component details on hover/tap (brand, model, specs)
4. Photos displayed if available
5. Empty state message if no setup configured
6. Mobile-responsive layout

---

### Epic 6: Privacy & Public Profiles

**Goal:** Add privacy controls per section and enable shareable public profile URLs. This epic completes the MVP by allowing players to control their visibility and share their profiles.

#### Story 6.1: Privacy Settings Model

**As a** player,
**I want** privacy settings for my profile sections,
**so that** I control what information is public.

**Acceptance Criteria:**
1. Privacy settings stored in Player model or separate table
2. Configurable sections: Personal Info, Club Affiliation, Equipment Setup
3. Options per section: Public, Private
4. Default setting: All sections Public
5. Privacy settings persisted to database

#### Story 6.2: Privacy Settings Interface

**As a** player,
**I want** to configure my privacy settings,
**so that** I decide what others can see.

**Acceptance Criteria:**
1. Privacy settings section in account settings
2. Toggle switches for each section visibility
3. Clear labels explaining what each setting controls
4. Changes saved immediately or via save button
5. Confirmation feedback when settings updated

#### Story 6.3: Public Profile URL

**As a** player,
**I want** a unique shareable URL for my profile,
**so that** I can share my darts identity.

**Acceptance Criteria:**
1. Public profile URL format: /player/{username} or /p/{unique_id}
2. Username or unique slug generated from player name
3. URL displayed in profile settings for easy copying
4. "Share Profile" button with copy-to-clipboard
5. Social media share buttons (Facebook, Twitter/X) - optional

#### Story 6.4: Public Profile View

**As a** visitor,
**I want** to view a player's public profile,
**so that** I can learn about them without logging in.

**Acceptance Criteria:**
1. Public profile accessible without authentication
2. Only sections marked "Public" are displayed
3. Private sections show placeholder or are hidden entirely
4. Profile owner sees all sections regardless of privacy
5. Visual indicator for profile owner showing public vs private view
6. SEO-friendly meta tags (title, description, Open Graph)

#### Story 6.5: Email Visibility Control

**As a** player,
**I want** to control whether my email is visible,
**so that** I protect my contact information.

**Acceptance Criteria:**
1. Email visibility toggle in privacy settings
2. Options: Public (visible on profile), Private (hidden)
3. Private emails encrypted at rest in database
4. Contact section hidden if email is private and no other contact method
5. Default: Private

---

### Epic 7: Back-Office Administrateur

**Goal:** Provide administrators with a complete dashboard to manage users, monitor platform growth, and moderate content. This epic gives the platform owner (Axel) full control over the application and its users.

#### Story 7.1: Admin Dashboard & Analytics

**As an** administrator,
**I want** to see a dashboard with key platform metrics,
**so that** I can monitor the health and growth of Darts Community.

**Acceptance Criteria:**
1. Admin dashboard accessible at /admin route
2. Key metrics displayed:
   - Total registered users
   - New registrations (today, this week, this month)
   - Active users (DAU/MAU)
   - Profiles completed (%)
   - Setups configured (%)
3. Simple charts/graphs for trends over time
4. Quick links to other admin sections
5. Dashboard refreshes on page load (no real-time updates for MVP)

#### Story 7.2: User Management

**As an** administrator,
**I want** to view and manage all user accounts,
**so that** I can support users and handle issues.

**Acceptance Criteria:**
1. User list view with search and filters (by email, name, registration date, status)
2. Sortable columns (date registered, last login, profile completion)
3. User detail view showing:
   - Account info (email, registration date, OAuth provider)
   - Player profile summary
   - Account status (active, suspended, pending deletion)
4. Pagination for large user lists
5. Export user list to CSV (basic implementation)

#### Story 7.3: User Account Actions

**As an** administrator,
**I want** to perform actions on user accounts,
**so that** I can manage the platform effectively.

**Acceptance Criteria:**
1. View any user's full profile (bypass privacy settings)
2. Edit user's basic info (email, name) with audit note
3. Suspend/reactivate user account with reason
4. Force password reset (sends email to user)
5. Delete user account (with confirmation, respects GDPR grace period)
6. Impersonate user (login as user for debugging) - optional, with audit log
7. All admin actions logged with timestamp and admin user

#### Story 7.4: Role & Permission Management

**As an** administrator,
**I want** to manage admin roles,
**so that** I can delegate platform management.

**Acceptance Criteria:**
1. View list of all admin users
2. Promote regular user to admin role
3. Revoke admin role (cannot revoke own role)
4. Super-admin concept: first admin cannot be demoted
5. Admin action history visible per admin user
6. Confirmation modal for role changes

#### Story 7.5: Content Moderation

**As an** administrator,
**I want** to review and moderate user-uploaded content,
**so that** I can maintain platform quality and safety.

**Acceptance Criteria:**
1. Queue/list of recently uploaded content (photos, MP3s)
2. Filter by content type (profile photos, cover photos, walk-on songs, component photos)
3. Preview content directly in admin interface
4. Actions: Approve (default), Flag for review, Remove with reason
5. Removed content notification sent to user (optional)
6. Flagged content report for periodic review

#### Story 7.6: Club & Federation Management

**As an** administrator,
**I want** to manage clubs and federations,
**so that** the platform data stays accurate.

**Acceptance Criteria:**
1. CRUD interface for federations
2. CRUD interface for clubs
3. Bulk import clubs from CSV (for initial data population)
4. View players affiliated with each club
5. Merge duplicate clubs (transfer all players to target club)
6. Deactivate clubs (hide from selection, preserve history)

---

## 7. Checklist Results Report

### Executive Summary

| Metric | Value |
|--------|-------|
| **Overall PRD Completeness** | 92% |
| **MVP Scope Appropriateness** | Just Right |
| **Readiness for Architecture Phase** | Ready |
| **Critical Gaps** | None blocking |

### Category Analysis

| Category | Status | Critical Issues |
|----------|--------|-----------------|
| 1. Problem Definition & Context | ✅ PASS | None - well documented in Brief |
| 2. MVP Scope Definition | ✅ PASS | Clear in/out of scope boundaries |
| 3. User Experience Requirements | ✅ PASS | Core screens and flows defined |
| 4. Functional Requirements | ✅ PASS | 31 FRs clearly documented |
| 5. Non-Functional Requirements | ✅ PASS | 14 NFRs with specific targets |
| 6. Epic & Story Structure | ✅ PASS | 7 epics, 30 stories with ACs |
| 7. Technical Guidance | ✅ PASS | Stack, architecture, constraints clear |
| 8. Cross-Functional Requirements | ⚠️ PARTIAL | Data entities need ERD from Architect |
| 9. Clarity & Communication | ✅ PASS | Well-structured, French context |

### Top Issues by Priority

**BLOCKERS:** None

**HIGH:**
- Data model relationships should be detailed by Architect (planned for architecture phase)

**MEDIUM:**
- Hosting provider decision pending (TBD noted in Technical Assumptions)
- Brand guide not yet created (noted in Branding section)

**LOW:**
- Club seeder data could be more comprehensive
- Open Graph implementation details deferred to development

### MVP Scope Assessment

**Features appropriate for MVP:** ✅
- Authentication (OAuth + email/password)
- Player profile with photos, skill level, walk-on song
- Club affiliation
- Modular equipment system
- Privacy controls and public profiles

**Features correctly excluded:**
- Statistics and performance tracking
- Competition management
- Messaging/chat
- Multi-language support
- Native mobile apps

**Complexity concerns:**
- Equipment builder UI is the most complex feature - recommend prototyping early
- MP3 upload duration validation requires server-side processing

**Timeline realism:** Achievable with solo developer + Claude Code workflow

### Technical Readiness

**Clear technical constraints:** ✅
- Laravel 11+, Blade, Tailwind CDN
- MySQL (prod) / SQLite (dev)
- No build process
- Session-based auth

**Identified technical risks:**
1. OAuth configuration (Google/Facebook app setup)
2. File upload optimization (images, MP3)
3. Equipment catalog data seeding

**Areas for Architect investigation:**
1. ERD design for modular equipment system
2. File storage abstraction (local → S3)
3. Privacy settings implementation pattern

### Recommendations

1. **Proceed to Architecture phase** - PRD is comprehensive and ready
2. **UX Expert** should create wireframes for Equipment Builder first (highest complexity)
3. **Architect** should prioritize database schema design
4. **Early decision needed** on hosting provider before Epic 1 completion

### Final Decision

**✅ READY FOR ARCHITECT**

The PRD is comprehensive, properly structured, and ready for architectural design. All epics have clear goals, stories have testable acceptance criteria, and technical constraints are well-documented.

---

## 8. Next Steps

### 8.1 UX Expert Prompt

```
Bonjour ! Je suis le PM de Darts Community. Le PRD est maintenant finalisé (docs/prd.md).

Pouvez-vous créer les wireframes et le design system pour ce projet ?

Priorités :
1. Design system (couleurs, typographie, composants)
2. Wireframes des écrans principaux (Landing, Profil, Equipment Builder)
3. Flow d'onboarding utilisateur
4. Responsive mobile-first

Référence : Section 3 du PRD pour les guidelines UI/UX.
```

### 8.2 Architect Prompt

```
Bonjour ! Je suis le PM de Darts Community. Le PRD est maintenant finalisé (docs/prd.md).

Pouvez-vous créer l'architecture technique et le schéma de base de données ?

Priorités :
1. Schéma de base de données complet (ERD)
2. Architecture des composants Laravel
3. Structure des fichiers et dossiers
4. Spécifications des API internes
5. Plan de migration et seeders

Référence : Section 4 du PRD pour les contraintes techniques.
Stack : Laravel 11+, Blade, Tailwind CDN, MySQL/SQLite.
```

---

*Document généré le 2026-01-08*
*Darts Community - PRD v0.1*

