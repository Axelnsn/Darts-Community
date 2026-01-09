# Git & GitHub Conventions - Darts Community

> **Version:** 1.0
> **Date:** 2026-01-09
> **Statut:** Actif

Ce document définit les règles et bonnes pratiques Git/GitHub pour le projet Darts Community. **Tous les agents BMAD doivent suivre ces conventions.**

---

## 1. Structure des Branches

### 1.1 Branches Principales

| Branche | Usage | Protection |
|---------|-------|------------|
| `main` | Code de production stable | Protégée - pas de push direct de code |
| `develop` | Intégration des features (optionnel) | Non utilisée pour l'instant |

### 1.2 Branches de Travail

```
main
 │
 ├── feature/X-X-nom-story     # Nouvelles fonctionnalités
 ├── fix/description-bug       # Corrections de bugs
 ├── docs/description          # Documentation uniquement
 └── refactor/description      # Refactoring sans nouvelle feature
```

### 1.3 Convention de Nommage des Branches

| Type | Format | Exemple |
|------|--------|---------|
| Feature (story) | `feature/{story-id}` | `feature/1-1-project-setup-landing-page` |
| Feature (autre) | `feature/{description}` | `feature/add-dark-mode` |
| Bug fix | `fix/{description}` | `fix/login-redirect-loop` |
| Documentation | `docs/{description}` | `docs/api-documentation` |
| Refactoring | `refactor/{description}` | `refactor/extract-services` |

---

## 2. Règles de Commit

### 2.1 Ce qui peut être commité directement sur `main`

- Documents de planning (`_bmad-output/planning-artifacts/`)
- Fichiers de configuration BMAD (`_bmad/`)
- Documentation (`docs/`)
- Fichiers de suivi (`sprint-status.yaml`)
- Fichiers stories (`_bmad-output/implementation-artifacts/*.md`)

### 2.2 Ce qui DOIT passer par une branche feature

- **Tout code source** (PHP, Blade, JS, CSS)
- Migrations de base de données
- Tests
- Configuration Laravel (`.env.example`, `config/`)

### 2.3 Format des Messages de Commit

```
<type>: <description courte>

<description détaillée (optionnel)>

🤖 Generated with [Claude Code](https://claude.com/claude-code)

Co-Authored-By: Claude Opus 4.5 <noreply@anthropic.com>
```

**Types de commit:**

| Type | Usage |
|------|-------|
| `feat` | Nouvelle fonctionnalité |
| `fix` | Correction de bug |
| `docs` | Documentation uniquement |
| `style` | Formatage, pas de changement de code |
| `refactor` | Refactoring sans nouvelle feature |
| `test` | Ajout ou modification de tests |
| `chore` | Maintenance, dépendances, config |

**Exemples:**

```bash
# Feature
feat: Add landing page with hero section and feature cards

# Bug fix
fix: Correct redirect after OAuth login

# Documentation
docs: Add API endpoint documentation

# Planning (direct sur main)
chore: Complete Phase 3 planning - ready for implementation
```

### 2.4 Règles des Messages

1. **Langue:** Anglais pour les commits (standard international)
2. **Longueur:** Première ligne < 72 caractères
3. **Temps:** Impératif présent ("Add" pas "Added")
4. **Signature:** Toujours inclure le footer Claude Code

---

## 3. Workflow de Développement

### 3.1 Avant de commencer une story

```bash
# 1. S'assurer d'être sur main à jour
git checkout main
git pull origin main

# 2. Créer la branche feature
git checkout -b feature/X-X-nom-story
```

### 3.2 Pendant le développement

```bash
# Commits réguliers et atomiques
git add <fichiers>
git commit -m "feat: description"

# Pousser régulièrement (sauvegarde)
git push -u origin feature/X-X-nom-story
```

### 3.3 Quand la story est terminée

```bash
# 1. S'assurer que tous les tests passent
php artisan test

# 2. Mettre à jour depuis main (éviter les conflits)
git checkout main
git pull origin main
git checkout feature/X-X-nom-story
git merge main

# 3. Résoudre les conflits si nécessaire

# 4. Pousser la branche finale
git push origin feature/X-X-nom-story

# 5. Créer une Pull Request sur GitHub
```

### 3.4 Merge de la Pull Request

```bash
# Après approbation de la PR sur GitHub:

# 1. Merger sur main (via GitHub UI ou CLI)
git checkout main
git merge feature/X-X-nom-story

# 2. Pousser main
git push origin main

# 3. Supprimer la branche feature
git branch -d feature/X-X-nom-story
git push origin --delete feature/X-X-nom-story
```

---

## 4. Pull Requests

### 4.1 Quand créer une PR

- **Toujours** pour du code source
- **Optionnel** pour de la documentation simple

### 4.2 Format de la PR

**Titre:** `[Story X.X] Description courte`

**Corps:**
```markdown
## Summary
- Point 1 des changements
- Point 2 des changements

## Story Reference
Implements story: X-X-nom-story

## Test Plan
- [ ] Tests unitaires passent
- [ ] Tests feature passent
- [ ] Testé manuellement sur navigateur

🤖 Generated with [Claude Code](https://claude.com/claude-code)
```

### 4.3 Checklist avant merge

- [ ] Code review effectuée (via `/bmad:bmm:workflows:code-review`)
- [ ] Tous les tests passent
- [ ] Pas de conflits avec `main`
- [ ] Story mise à jour dans `sprint-status.yaml`

---

## 5. Instructions pour les Agents BMAD

### 5.1 Agent Dev (`/bmad:bmm:workflows:dev-story`)

**Au début de la story:**
```bash
git checkout main
git pull origin main
git checkout -b feature/{story-id}
```

**Pendant le développement:**
- Commits atomiques et fréquents
- Messages descriptifs en anglais
- Push régulier pour sauvegarde

**À la fin de la story:**
- Ne PAS merger automatiquement
- Pousser la branche
- Informer l'utilisateur qu'une PR est prête

### 5.2 Agent Code Review (`/bmad:bmm:workflows:code-review`)

- Vérifier les conventions de commit
- Vérifier la structure du code
- Suggérer des corrections si nécessaire

### 5.3 Agent SM / Planning

- Peut commiter directement sur `main` pour:
  - Mise à jour de `sprint-status.yaml`
  - Création de fichiers stories
  - Documents de planning

---

## 6. Fichiers Ignorés (.gitignore)

Le `.gitignore` doit inclure:

```gitignore
# Laravel
/vendor
/node_modules
/.env
/storage/*.key
/public/hot
/public/storage

# IDE
/.idea
/.vscode
*.swp
*.swo

# OS
.DS_Store
Thumbs.db

# Logs
*.log
/storage/logs/*

# Cache
/bootstrap/cache/*
/.phpunit.cache

# Build
/public/build
```

---

## 7. Récapitulatif des Règles Clés

| Règle | Description |
|-------|-------------|
| **Pas de push direct de code sur main** | Toujours via branche + PR |
| **Branches feature pour le code** | `feature/X-X-nom-story` |
| **Commits atomiques** | Un commit = un changement logique |
| **Messages en anglais** | Standard international |
| **Footer Claude Code obligatoire** | Traçabilité des contributions IA |
| **Tests avant merge** | `php artisan test` doit passer |
| **PR pour le code** | Review avant intégration |

---

## 8. Commandes Utiles

```bash
# Voir l'historique
git log --oneline -10

# Voir les branches
git branch -a

# Voir le statut
git status

# Annuler les changements non commités
git checkout -- .

# Voir les différences
git diff

# Créer un tag de version
git tag -a v1.0.0 -m "Version 1.0.0"
git push origin v1.0.0
```

---

*Document créé le 2026-01-09*
*Projet: Darts Community*
