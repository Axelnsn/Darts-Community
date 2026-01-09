# Darts Community - AI UI Generation Prompts

> **Purpose:** Prompts optimisés pour générer les mockups avec v0, Lovable, ou outils similaires
> **Date:** 2026-01-08
> **Usage:** Copier-coller chaque prompt dans l'outil AI de votre choix

---

## Instructions d'utilisation

1. **Choisissez votre outil** : v0.dev (Vercel), Lovable.dev, ou similaire
2. **Copiez le prompt complet** pour l'écran souhaité
3. **Générez et itérez** - ajustez selon les résultats
4. **Exportez le code** HTML/Tailwind pour intégration Laravel Blade

---

## Prompt 1: Landing Page

```
Create a modern landing page for "Darts Community" - a French platform for amateur darts players to create their professional player profile.

=== BRAND IDENTITY ===
Colors:
- Primary: #1B4D3E (dark dartboard green)
- Primary hover: #2D7A5C (forest green)
- Secondary: #D4AF37 (gold for highlights)
- Accent: #C41E3A (target red - use sparingly)
- Background: #F3F4F6 (light gray)
- Cards: #FFFFFF
- Text primary: #1F2937
- Text secondary: #4B5563

Typography: Inter font family (Google Fonts)
Style: Professional sports aesthetic meets social profile - "sports card meets social profile"

=== LAYOUT STRUCTURE ===

1. HEADER (sticky, dark green #1B4D3E background)
   - Left: Logo "Darts Community" with dart icon in white
   - Right: "Connexion" link (white) + "Créer mon profil" button (gold background #D4AF37, dark text)

2. HERO SECTION (full viewport height minus header)
   - Background: Subtle gradient from #1B4D3E to #2D7A5C
   - Left side (60%):
     * Headline: "Votre identité de joueur comme les pros" (white, bold, 48px)
     * Subheadline: "Créez votre profil, gérez votre équipement, rejoignez la communauté des fléchettistes français." (white/80%, 20px)
     * CTA button: "Créer mon profil gratuitement" (gold #D4AF37 background, large, with arrow icon)
     * Secondary link: "Découvrir un exemple →" (white underlined)
   - Right side (40%):
     * Mockup of a player profile card floating with subtle shadow
     * Show: avatar, name "Thomas D.", badge "Confirmé" in green, club name

3. FEATURES SECTION (white background, padding 80px vertical)
   - Section title: "Tout pour votre carrière de fléchettiste" (centered, #1F2937)
   - 3 feature cards in a row (equal width, gap 32px):

   Card 1 - "Profil Joueur"
   - Icon: User circle (outline, green)
   - Title: "Profil Joueur" (bold)
   - Description: "Photo, niveau, club, licence FFD... Tout en un seul endroit."

   Card 2 - "Setup Personnalisé"
   - Icon: Target/Bullseye (outline, green)
   - Title: "Setup Personnalisé"
   - Description: "Gérez vos fléchettes composant par composant : pointes, fûts, tiges, ailettes."

   Card 3 - "Communauté"
   - Icon: Users group (outline, green)
   - Title: "Communauté"
   - Description: "Connectez-vous aux clubs et joueurs de toute la France."

   Each card: white background, border-radius 12px, subtle shadow, padding 24px, hover lift effect

4. SOCIAL PROOF SECTION (light gray #F3F4F6 background)
   - Counter: "Rejoignez les 150+ joueurs déjà inscrits"
   - Row of placeholder club logos (grayscale, small)

5. CTA SECTION (dark green background)
   - "Prêt à créer votre profil ?" (white, centered)
   - Large gold CTA button: "Commencer maintenant"

6. FOOTER (dark #1F2937 background)
   - Left: Logo + copyright "© 2026 Darts Community"
   - Center: Links "À propos", "Contact", "Mentions légales", "Politique de confidentialité"
   - Right: Social icons placeholder

=== TECHNICAL REQUIREMENTS ===
- Mobile-first responsive (stack on mobile)
- Tailwind CSS classes only
- Semantic HTML5 structure
- WCAG AA accessible (contrast, focus states)
- Smooth scroll behavior
- French language for all text

=== DO NOT ===
- Use any JavaScript frameworks
- Add complex animations
- Include actual images (use placeholders)
- Add a hamburger menu (keep it simple for now)

Output clean, production-ready HTML with Tailwind CSS classes.
```

---

## Prompt 2: Player Profile View

```
Create a player profile page for "Darts Community" - showing a darts player's complete profile with cover photo, avatar, and tabbed content sections.

=== BRAND IDENTITY ===
Colors:
- Primary: #1B4D3E (dark dartboard green)
- Primary light: #2D7A5C
- Secondary/Gold: #D4AF37
- Accent/Red: #C41E3A
- Success: #22C55E
- Background: #F3F4F6
- Cards: #FFFFFF
- Text: #1F2937 / #4B5563

Typography: Inter font family
Skill level badges:
- Débutant: gray (#6B7280)
- Amateur: blue (#3B82F6)
- Confirmé: green (#22C55E)
- Semi-pro: orange (#F59E0B)
- Pro: gold (#D4AF37) with subtle glow

=== LAYOUT STRUCTURE ===

1. HEADER (same as landing page - dark green, sticky)
   - Logo left
   - Navigation: "Mon Profil" (active), "Mon Équipement", "Paramètres"
   - Right: User avatar dropdown

2. COVER PHOTO SECTION
   - Full width cover photo area (height: 200px mobile, 280px desktop)
   - Placeholder gradient from #1B4D3E to #2D7A5C if no photo
   - Edit button (pencil icon) in top right corner (only visible to owner)

3. PROFILE HEADER (overlapping cover by 60px)
   - Avatar: 128px circle, white border 4px, positioned left
   - Right of avatar:
     * Name: "Jean-Marc Dubois" (bold, 28px)
     * Nickname in quotes: "Le Sniper" (italic, gray)
     * Location: pin icon + "Lyon, France"
     * Skill badge: "Confirmé" (green pill badge)
   - Far right:
     * "Modifier le profil" button (secondary style)
     * "Partager" button with share icon

4. PROFILE COMPLETION BAR (if not 100%)
   - Thin progress bar showing completion percentage
   - Text: "Profil complété à 75% - Ajoutez votre walk-on song!"
   - Link to complete missing sections

5. TAB NAVIGATION
   - Three tabs: "Identité" | "Club" | "Setup"
   - Active tab: green underline, bold text
   - Tabs horizontally scrollable on mobile

6. TAB CONTENT: IDENTITÉ (default active)
   - Card with sections:

   Section "Informations personnelles":
   - Prénom: Jean-Marc
   - Nom: Dubois
   - Date de naissance: 15 mars 1985
   - Ville: Lyon
   - Email: Masqué (with lock icon) or visible

   Section "Walk-on Song":
   - Embedded player mockup (YouTube/Spotify style)
   - Song title: "Eye of the Tiger - Survivor"
   - Play button, progress bar

7. TAB CONTENT: CLUB (show when clicked)
   - Card with:
   - Club actuel: "AS Fléchettes Lyon" (with club logo placeholder)
   - Fédération: "FFD - Fédération Française de Darts"
   - N° Licence: "FFD-2024-12345"
   - Historique (timeline):
     * 2022-présent: AS Fléchettes Lyon
     * 2019-2022: Darts Club Villeurbanne

8. TAB CONTENT: SETUP (show when clicked)
   - Header: "Mon Setup Actuel" with edit button
   - 3 dart assembly cards in a row:

   Each dart card:
   - Card title: "Match Darts", "Practice Set", "Backup"
   - Star icon if current setup
   - Visual representation of dart (vertical):
     * Pointe: "Target Storm Points 26mm"
     * Fût: "Target Adrian Lewis 24g"
     * Tige: "Target Pro Grip Medium"
     * Ailette: "Target Pro Ultra No.6"
   - Each component clickable to see details

=== RESPONSIVE BEHAVIOR ===
- Mobile: Stack everything vertically, tabs scrollable
- Tablet: 2 dart cards per row
- Desktop: 3 dart cards, sidebar possible

=== TECHNICAL REQUIREMENTS ===
- Tailwind CSS only
- Card-based design with 12px border-radius
- Subtle shadows (shadow-sm to shadow-md)
- Smooth transitions on hover/focus
- French language
- Accessible focus states

Output clean HTML with Tailwind classes, simulating a complete player profile.
```

---

## Prompt 3: Equipment Builder (Dart Assembly)

```
Create a dart assembly builder interface for "Darts Community" - where players can build a complete dart by selecting 4 components: Tip, Barrel, Shaft, and Flight.

=== BRAND IDENTITY ===
Colors:
- Primary: #1B4D3E (dark green)
- Secondary: #D4AF37 (gold)
- Success: #22C55E (slot filled)
- Empty slot: #E5E7EB (gray)
- Background: #F3F4F6
- Cards: #FFFFFF
- Text: #1F2937

Typography: Inter font family

=== MOBILE-FIRST LAYOUT (Primary) ===

1. HEADER
   - Back arrow + "Nouvelle Fléchette" title
   - Optional: Save draft icon right

2. DART BUILDER VISUAL (Center of screen)
   - Vertical representation of a dart with 4 slots
   - Each slot is a rounded rectangle (full width - 32px margins)
   - Slots connected by thin vertical line
   - Order from top to bottom:

   SLOT 1 - POINTE (Tip)
   - Label: "Pointe" with icon
   - Empty state: Dashed border, gray, "+ Sélectionner"
   - Filled state: Green border, component image, brand + model text
   - Tap to open selection panel

   SLOT 2 - FÛT (Barrel)
   - Same pattern as above
   - Show weight when filled (e.g., "24g")

   SLOT 3 - TIGE (Shaft)
   - Same pattern
   - Show length when filled (e.g., "Medium")

   SLOT 4 - AILETTE (Flight)
   - Same pattern
   - Show shape when filled (e.g., "Standard")

3. PROGRESS INDICATOR
   - "2/4 composants sélectionnés" with progress dots
   - Green dots for completed, gray for remaining

4. DART NAME INPUT
   - Label: "Nom de la fléchette"
   - Input field: placeholder "Ex: Match Darts"
   - Character count: "0/30"

5. SAVE BUTTON (Sticky bottom)
   - Full width gold button: "Sauvegarder"
   - Disabled state if not all 4 slots filled
   - Secondary option: "Définir comme setup actuel" checkbox

=== COMPONENT SELECTION PANEL (Bottom Sheet) ===
Opens when tapping a slot:

1. PANEL HEADER
   - Title: "Sélectionner une Pointe" (dynamic per slot type)
   - Close X button right
   - Drag handle at top

2. SEARCH BAR
   - Search icon + input "Rechercher..."
   - Filter chips: "Mon inventaire" | "Catalogue"

3. MY INVENTORY SECTION
   - Title: "Mon inventaire" with count "(3)"
   - Horizontal scroll of component cards:

   Component Card (small, square):
   - Component image (or placeholder icon)
   - Brand name: "Target"
   - Model name: "Storm Points"
   - Key attribute: "26mm"
   - Checkmark overlay if already selected in another dart

4. CATALOG SECTION
   - Title: "Catalogue"
   - "Voir tout →" link
   - Grid of popular items

5. ADD CUSTOM OPTION
   - Card with dashed border
   - "+ Ajouter un composant personnalisé"
   - Opens a form modal

=== DESKTOP LAYOUT (Side-by-Side) ===
- Left 40%: Dart builder visual (larger, centered)
- Right 60%: Selection panel always visible (not a bottom sheet)
- Selected component highlights in real-time on the dart visual

=== INTERACTION STATES ===
- Slot hover: subtle lift and shadow
- Slot tap/click: opens panel with slide-up animation
- Component hover in panel: border highlight
- Component select: checkmark, panel closes, slot animates to filled
- Filled slot tap: shows component details + "Remplacer" button

=== TECHNICAL REQUIREMENTS ===
- Tailwind CSS only
- Mobile-first responsive
- Touch-friendly (44px minimum tap targets)
- Smooth transitions (200ms ease-out)
- French language throughout
- Form validation before save

=== VISUAL DETAILS ===
- Dart slots have icons: needle for tip, cylinder for barrel, stick for shaft, wing for flight
- Color-coded borders when filled (all use success green #22C55E)
- Component cards show brand logo if available
- Empty slots pulse subtly to draw attention

Output complete HTML with Tailwind for both mobile and desktop layouts.
```

---

## Prompt 4: Login & Registration

```
Create authentication pages for "Darts Community" - Login and Registration with OAuth options (Google, Facebook) and email/password fallback.

=== BRAND IDENTITY ===
Colors:
- Primary: #1B4D3E (dark green)
- Secondary: #D4AF37 (gold)
- Error: #EF4444
- Background: #F3F4F6
- Cards: #FFFFFF
- Text: #1F2937 / #4B5563

Typography: Inter font family

=== LOGIN PAGE LAYOUT ===

1. CENTERED CARD (max-width 420px)
   - White background, rounded-xl, shadow-lg
   - Padding 32px

2. HEADER
   - Logo: "Darts Community" with dart icon (centered)
   - Title: "Connexion" (centered, bold, 24px)
   - Subtitle: "Accédez à votre profil de joueur" (gray, 14px)

3. OAUTH BUTTONS (Stack vertically, full width)

   Google Button:
   - White background, gray border
   - Google "G" logo left
   - Text: "Continuer avec Google"
   - Hover: light gray background

   Facebook Button:
   - Facebook blue #1877F2 background
   - Facebook "f" logo left (white)
   - Text: "Continuer avec Facebook" (white)
   - Hover: darker blue

4. DIVIDER
   - Horizontal line with "ou" text centered
   - Line color: #E5E7EB

5. EMAIL/PASSWORD FORM

   Email Field:
   - Label: "Adresse email"
   - Input with envelope icon left
   - Placeholder: "vous@exemple.com"
   - Error state: red border, error message below

   Password Field:
   - Label: "Mot de passe"
   - Input with lock icon left
   - Eye icon right (toggle visibility)
   - Placeholder: "••••••••"

   Forgot Password Link:
   - Right-aligned: "Mot de passe oublié ?"
   - Green text, underline on hover

6. SUBMIT BUTTON
   - Full width, primary green #1B4D3E
   - Text: "Se connecter" (white, bold)
   - Hover: lighter green
   - Loading state: spinner icon

7. REGISTRATION LINK
   - Text: "Pas encore de compte ?"
   - Link: "Créer un profil" (green, bold)

=== REGISTRATION PAGE LAYOUT ===

Same card structure, with differences:

1. HEADER
   - Title: "Créer votre profil"
   - Subtitle: "Rejoignez la communauté des fléchettistes"

2. OAUTH BUTTONS (same as login)

3. FORM FIELDS

   Email Field (same as login)

   Password Field:
   - Requirements hint below: "Minimum 8 caractères"
   - Strength indicator (optional): weak/medium/strong bar

   Confirm Password Field:
   - Label: "Confirmer le mot de passe"
   - Match validation

4. TERMS CHECKBOX
   - Checkbox + label: "J'accepte les conditions d'utilisation et la politique de confidentialité"
   - Links in green

5. GDPR CONSENT
   - Small text: "Vos données sont protégées conformément au RGPD."
   - Info icon with tooltip

6. SUBMIT BUTTON
   - Text: "Créer mon profil"

7. LOGIN LINK
   - Text: "Déjà inscrit ?"
   - Link: "Se connecter"

=== FORGOT PASSWORD PAGE ===

Simple card:
- Title: "Mot de passe oublié"
- Description: "Entrez votre email pour recevoir un lien de réinitialisation."
- Email input
- Submit: "Envoyer le lien"
- Back to login link

=== ERROR STATES ===
- Invalid email format: "Format d'email invalide"
- Password too short: "Le mot de passe doit contenir au moins 8 caractères"
- Passwords don't match: "Les mots de passe ne correspondent pas"
- Email already exists: "Cette adresse email est déjà utilisée"
- Invalid credentials: "Email ou mot de passe incorrect"

=== TECHNICAL REQUIREMENTS ===
- Tailwind CSS only
- Mobile responsive (card full width on mobile with padding)
- Accessible form labels and error messages
- Focus visible states (green outline)
- French language
- Form validation styling

Output complete HTML for Login, Registration, and Forgot Password pages.
```

---

## Prompt 5: Admin Dashboard

```
Create an admin dashboard for "Darts Community" - a back-office interface for platform administrators to monitor metrics and manage users.

=== BRAND IDENTITY ===
Colors:
- Primary: #1B4D3E (dark green)
- Secondary: #D4AF37 (gold)
- Background: #F3F4F6
- Sidebar: #1F2937 (dark charcoal)
- Cards: #FFFFFF
- Success: #22C55E
- Warning: #F59E0B
- Error: #EF4444
- Text: #1F2937 / #4B5563

Typography: Inter font family

=== DESKTOP LAYOUT (Primary) ===

1. SIDEBAR (Fixed left, 256px width)
   - Background: #1F2937
   - Top: Logo "Darts Community" + "Admin" badge

   Navigation items (vertical):
   - Dashboard (chart icon) - ACTIVE
   - Utilisateurs (users icon)
   - Catalogue (box icon)
   - Clubs (building icon)
   - Modération (shield icon)
   - Separator line
   - Retour au site (arrow left icon)

   Active item: green left border, lighter background
   Hover: lighter background
   All text white, icons white/gray

2. MAIN CONTENT AREA (Right of sidebar)

   TOP BAR:
   - Left: "Tableau de bord" title (24px, bold)
   - Right: Admin avatar + name dropdown, notification bell

3. KPI CARDS ROW (4 cards, equal width)

   Card 1 - Users:
   - Icon: Users (green circle background)
   - Value: "156" (bold, 32px)
   - Label: "Utilisateurs totaux"
   - Trend: "+12 ce mois" (green text, up arrow)

   Card 2 - New Registrations:
   - Icon: User plus (blue circle)
   - Value: "23"
   - Label: "Nouveaux cette semaine"
   - Trend: "+8 vs semaine dernière"

   Card 3 - Profile Completion:
   - Icon: Check circle (green)
   - Value: "68%"
   - Label: "Profils complets"
   - Visual: Small circular progress indicator

   Card 4 - Moderation Queue:
   - Icon: Shield exclamation (orange if items pending)
   - Value: "3"
   - Label: "Contenus à modérer"
   - Badge: "Urgent" if > 5

4. CHARTS ROW (2 charts side by side)

   Chart 1 - Registrations Over Time (60% width):
   - Title: "Inscriptions (30 derniers jours)"
   - Line or bar chart placeholder
   - X-axis: dates
   - Y-axis: count
   - Tooltip on hover

   Chart 2 - Skill Level Distribution (40% width):
   - Title: "Répartition par niveau"
   - Donut/pie chart placeholder
   - Legend: Débutant, Amateur, Confirmé, Semi-pro, Pro
   - Colors matching skill badges

5. QUICK ACTIONS ROW (4 cards, same style as main nav)

   Card: "Utilisateurs"
   - Icon: Users
   - Description: "Gérer les comptes"
   - Arrow right
   - Hover: lift effect

   Card: "Catalogue"
   - Icon: Package
   - Description: "Marques & modèles"

   Card: "Clubs & Fédérations"
   - Icon: Building
   - Description: "Gérer les organisations"

   Card: "Modération"
   - Icon: Shield
   - Description: "Contenus signalés"
   - Badge if pending items

6. RECENT ACTIVITY TABLE (Full width)
   - Title: "Activité récente"
   - Columns: Date | Action | Utilisateur | Détails
   - Example rows:
     * "08 jan 2026" | "Inscription" | "Marie D." | "marie@email.com"
     * "08 jan 2026" | "Setup créé" | "Thomas L." | "Match Darts"
     * "07 jan 2026" | "Photo uploadée" | "Jean M." | "En attente de modération"
   - Pagination at bottom

=== MOBILE LAYOUT ===
- Sidebar becomes hamburger menu (slide-in)
- KPI cards: 2x2 grid then scroll
- Charts stack vertically
- Table becomes cards

=== COMPONENT STATES ===
- Cards: hover lift with shadow increase
- Table rows: hover highlight
- Action buttons: loading spinners when clicked
- Notifications: dropdown panel

=== TECHNICAL REQUIREMENTS ===
- Tailwind CSS only
- Responsive (sidebar collapses on tablet/mobile)
- Data placeholders (no real charts needed, just styled containers)
- French language
- Accessible navigation (skip links, focus management)
- Print-friendly styles (optional)

Output complete HTML with Tailwind for the admin dashboard.
```

---

## Prompt 6: Account Settings

```
Create an account settings page for "Darts Community" - where users can manage their email, password, privacy settings, and account deletion.

=== BRAND IDENTITY ===
Colors:
- Primary: #1B4D3E (dark green)
- Secondary: #D4AF37 (gold)
- Error/Danger: #EF4444
- Success: #22C55E
- Background: #F3F4F6
- Cards: #FFFFFF
- Text: #1F2937 / #4B5563

Typography: Inter font family

=== LAYOUT STRUCTURE ===

1. HEADER (Same as authenticated pages)
   - Navigation with "Paramètres" active

2. PAGE TITLE
   - "Paramètres du compte"
   - Breadcrumb: "Accueil > Paramètres"

3. SETTINGS NAVIGATION (Left sidebar on desktop, tabs on mobile)

   Sections:
   - Compte (active)
   - Confidentialité
   - Notifications
   - Zone danger

4. SECTION: COMPTE

   Card "Email":
   - Current email display: "jean@exemple.com"
   - Edit button (pencil icon)
   - When editing: input field + "Sauvegarder" + "Annuler"
   - Note: "Un email de vérification sera envoyé"

   Card "Mot de passe":
   - Display: "••••••••" (last changed date if known)
   - "Modifier le mot de passe" button
   - Opens inline form:
     * Mot de passe actuel
     * Nouveau mot de passe
     * Confirmer le nouveau mot de passe
     * Save/Cancel buttons

   Card "Méthode de connexion":
   - If OAuth: "Connecté via Google" with Google icon
   - Option to link/unlink other methods

5. SECTION: CONFIDENTIALITÉ

   Card "Visibilité du profil":
   - Toggle sections with labels:

   Toggle 1: "Informations personnelles"
   - Description: "Nom, prénom, ville, date de naissance"
   - Toggle: Public / Privé

   Toggle 2: "Affiliation club"
   - Description: "Club actuel, licence, fédération"
   - Toggle: Public / Privé

   Toggle 3: "Setup & équipement"
   - Description: "Vos fléchettes et composants"
   - Toggle: Public / Privé

   Toggle 4: "Adresse email"
   - Description: "Afficher votre email sur votre profil public"
   - Toggle: Visible / Masqué
   - Warning if visible: "Votre email sera visible publiquement"

   Card "Profil public":
   - URL display: "dartscommunity.com/player/jean-dubois"
   - Copy button
   - "Voir mon profil public" link

6. SECTION: ZONE DANGER

   Red-tinted card:
   - Title: "Zone danger" (red text)
   - Warning icon

   Option 1: "Désactiver mon compte"
   - Description: "Votre profil sera masqué mais vos données conservées"
   - Button: "Désactiver" (outline red)

   Option 2: "Supprimer mon compte"
   - Description: "Toutes vos données seront supprimées définitivement après 30 jours"
   - Button: "Supprimer mon compte" (solid red)
   - Opens confirmation modal:
     * Title: "Êtes-vous sûr ?"
     * Text: "Cette action est irréversible. Toutes vos données seront supprimées."
     * Input: "Tapez SUPPRIMER pour confirmer"
     * Buttons: "Annuler" (gray) | "Supprimer définitivement" (red)

7. SECTION: EXPORT DATA (GDPR)

   Card:
   - Title: "Exporter mes données"
   - Description: "Téléchargez une copie de toutes vos données personnelles"
   - Button: "Demander l'export"
   - Note: "Vous recevrez un email avec le lien de téléchargement"

=== TOGGLE COMPONENT ===
- iOS-style toggle switch
- Off: gray background
- On: green #22C55E background
- White circle indicator
- Smooth transition

=== RESPONSIVE ===
- Desktop: Sidebar navigation + content area
- Mobile: Stacked sections with accordion or tabs

=== FEEDBACK STATES ===
- Success toast: "Paramètres enregistrés"
- Error toast: "Une erreur est survenue"
- Loading: Skeleton or spinner on save

=== TECHNICAL REQUIREMENTS ===
- Tailwind CSS only
- French language
- Accessible toggles (keyboard, screen reader)
- Form validation
- Confirmation modals for destructive actions

Output complete HTML with Tailwind for all settings sections.
```

---

## How to Use These Prompts

### With v0.dev (Vercel)

1. Go to [v0.dev](https://v0.dev)
2. Paste the complete prompt
3. Wait for generation
4. Iterate with follow-up prompts like:
   - "Make the header sticky"
   - "Add hover animations to the cards"
   - "Make it more mobile-friendly"
5. Export the code

### With Lovable.dev

1. Start a new project
2. Paste the prompt in the chat
3. Review and refine interactively
4. Export React/HTML code
5. Convert to Blade if needed

### Converting to Laravel Blade

After generating HTML:

1. Create Blade component files in `resources/views/components/`
2. Replace static content with `{{ $variable }}` or `{{ $slot }}`
3. Add `@props` directives
4. Use `@if`, `@foreach` for dynamic content
5. Extract repeated elements into sub-components

Example conversion:
```html
<!-- Generated HTML -->
<button class="bg-green-800 text-white px-4 py-2 rounded">
    Sauvegarder
</button>

<!-- Blade Component -->
{{-- resources/views/components/ui/button.blade.php --}}
@props(['variant' => 'primary', 'type' => 'button'])

<button
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'px-4 py-2 rounded ' . match($variant) {
        'primary' => 'bg-green-800 text-white hover:bg-green-700',
        'secondary' => 'border border-green-800 text-green-800 hover:bg-green-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        default => 'bg-green-800 text-white'
    }]) }}
>
    {{ $slot }}
</button>
```

---

## Important Reminders

1. **AI-generated code requires review** - Always check for:
   - Accessibility issues
   - Missing responsive breakpoints
   - Hardcoded values that should be variables
   - French language consistency

2. **Iterate, don't expect perfection** - Use follow-up prompts to refine

3. **Test on real devices** - AI mockups may not account for all edge cases

4. **Maintain consistency** - Ensure generated components match the design system

---

*Document créé le 2026-01-08 par Sally (UX Expert Agent)*
