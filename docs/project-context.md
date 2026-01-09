# Darts Community - Project Context

> **Ce fichier est la source de vérité pour les règles et patterns du projet.**
> **Tous les agents BMAD doivent le consulter avant de travailler.**

---

## Quick Reference

| Aspect | Référence |
|--------|-----------|
| **Git/GitHub** | [docs/git-conventions.md](git-conventions.md) |
| **Architecture** | [_bmad-output/planning-artifacts/architecture.md](../_bmad-output/planning-artifacts/architecture.md) |
| **PRD** | [_bmad-output/planning-artifacts/prd.md](../_bmad-output/planning-artifacts/prd.md) |
| **UX Design** | [_bmad-output/planning-artifacts/ux-design.md](../_bmad-output/planning-artifacts/ux-design.md) |
| **Sprint Status** | [_bmad-output/implementation-artifacts/sprint-status.yaml](../_bmad-output/implementation-artifacts/sprint-status.yaml) |

---

## Project Identity

- **Nom:** Darts Community
- **Langue UI:** Français
- **Langue Code/Commits:** Anglais
- **Owner:** Axel

---

## Tech Stack (Ne pas dévier)

| Layer | Technology | Notes |
|-------|------------|-------|
| Backend | Laravel 11+ | Monolithe MVC |
| Frontend | Blade + Tailwind CSS | CDN, pas de build |
| Database | MySQL (prod) / SQLite (dev) | Eloquent ORM |
| Auth | Breeze + Socialite | Session-based |
| Hosting | o2switch | Hébergement mutualisé |

---

## Critical Rules for Agents

### 1. Git Workflow
- **Code source** → Branche feature + PR
- **Documents/planning** → Commit direct sur main OK
- **Toujours** inclure le footer Claude Code dans les commits

### 2. Code Style
- PSR-12 pour PHP
- Conventions Laravel
- Type hints obligatoires
- Form Requests pour validation

### 3. No Over-Engineering
- Pas d'abstraction prématurée
- Pas de features non demandées
- KISS (Keep It Simple, Stupid)

### 4. Testing
- Tests pour la logique métier
- Feature tests pour les endpoints
- `php artisan test` doit passer avant merge

---

## File Naming Conventions

| Type | Convention | Exemple |
|------|------------|---------|
| Controllers | PascalCase + Controller | `ProfileController.php` |
| Models | PascalCase singulier | `Player.php` |
| Migrations | snake_case avec date | `2026_01_09_create_players_table.php` |
| Views | kebab-case | `profile-edit.blade.php` |
| Routes | kebab-case | `/profile/edit` |

---

## Design System Colors

```
Primary:     #1B4D3E (Dartboard Green)
Secondary:   #D4AF37 (Gold)
Accent:      #C41E3A (Target Red)
Success:     #22C55E
Error:       #EF4444
```

---

*Dernière mise à jour: 2026-01-09*
