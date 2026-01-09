# Project Brief: Darts Community

> **Version:** 1.0
> **Date:** 7 janvier 2026
> **Statut:** Validé

---

## Executive Summary

**Darts Community** est une plateforme web communautaire dédiée aux joueurs de fléchettes amateurs et aux clubs. L'application permet aux joueurs de créer un profil complet regroupant leurs informations personnelles, leur affiliation à un club, leur matériel (avec un système modulaire de composants de fléchettes), leurs statistiques et leur palmarès.

**Problème principal :** Les joueurs de fléchettes amateurs n'ont pas d'espace centralisé pour gérer leur identité de joueur, suivre leur progression, et se connecter à l'écosystème (clubs, fédérations, compétitions).

**Marché cible :** Joueurs de fléchettes amateurs en France (puis international), clubs affiliés aux fédérations (FFD), et les fédérations elles-mêmes.

**Proposition de valeur :** Une plateforme "tout-en-un" gamifiée qui professionnalise l'expérience du joueur amateur tout en facilitant la gestion des clubs et l'organisation de compétitions.

---

## Problem Statement

### État Actuel et Points de Douleur

**Pour les joueurs :**
- Aucun espace personnel centralisé pour regrouper licence, statistiques, palmarès et matériel
- Difficulté à suivre sa progression et comparer ses performances
- Processus d'inscription aux clubs fastidieux et peu digitalisé
- Pas de visibilité sur les clubs disponibles dans sa région
- Collection de matériel non documentée (perte d'informations sur les setups)

**Pour les clubs :**
- Gestion administrative manuelle (inscriptions, licences, communication)
- Manque de visibilité en ligne pour attirer de nouveaux membres
- Difficulté à communiquer efficacement avec les membres
- Pas d'outil centralisé pour organiser événements et entraînements

**Pour les fédérations :**
- Pas de vue d'ensemble sur l'écosystème des clubs
- Organisation de tournois complexe sans outils adaptés
- Statistiques et classements difficiles à maintenir

### Pourquoi les Solutions Existantes Échouent

- Les applications de comptage (Dartscounter, n01) se limitent aux scores sans dimension communautaire
- Les sites de clubs sont éparpillés, souvent obsolètes, sans interconnexion
- Aucune plateforme ne propose de gestion modulaire du matériel (composants individuels)
- Pas d'aspect "gamification" pour engager la communauté amateur

### Urgence

Le marché des fléchettes connaît une croissance significative (popularité PDC, streaming). Les joueurs amateurs cherchent à professionnaliser leur pratique. Premier entrant = avantage compétitif majeur.

---

## Proposed Solution

### Concept Central

Darts Community est une **plateforme communautaire gamifiée** structurée en trois piliers interconnectés :

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│  PROFIL JOUEUR  │◄───►│  FICHE CLUB     │◄───►│   FÉDÉRATION    │
│  (Priorité MVP) │     │  (Phase 2)      │     │   (Phase 3)     │
└─────────────────┘     └─────────────────┘     └─────────────────┘
```

### Différenciateurs Clés

1. **Système modulaire de fléchettes** : Gestion indépendante des composants (pointes, fûts, tiges, ailettes) permettant de créer des setups personnalisés et de collectionner chaque pièce séparément

2. **Walk-on Song** : Fonctionnalité unique permettant aux joueurs de définir leur musique d'entrée (comme les pros), renforçant l'identité et l'engagement

3. **Interconnexion Club-Joueur-Fédération** : Écosystème où les données circulent (transferts, palmarès, compétitions officielles)

4. **Gamification** : Classements, comparaisons de stats, environnement compétitif même au niveau amateur

### Vision Produit

Devenir LA référence communautaire pour tout joueur de fléchettes amateur francophone, puis international - l'équivalent de Strava pour les fléchettes.

---

## Target Users

### Segment Primaire : Le Joueur de Fléchettes Amateur

**Profil démographique :**
- Âge : 18-55 ans (cœur de cible 25-45 ans)
- Genre : Majoritairement masculin (80%), mais audience féminine en croissance
- Localisation : France métropolitaine (MVP), puis Belgique, Suisse, international
- Pratique : 1 à 5 fois par semaine, en club ou à domicile

**Comportements actuels :**
- Membre d'un club local affilié FFD ou indépendant
- Utilise des apps de comptage (Dartscounter, n01) de manière isolée
- Suit les compétitions pro (PDC) sur YouTube/streaming
- Achète du matériel en ligne (boutiques spécialisées)
- Communique via groupes Facebook/WhatsApp du club

**Besoins et pain points :**
- Centraliser toutes ses infos de joueur en un seul endroit
- Suivre sa progression avec des statistiques claires
- Documenter et gérer sa collection de matériel
- Trouver facilement un club et s'inscrire
- Se comparer aux autres joueurs de son niveau

**Objectifs :**
- Progresser et mesurer son amélioration
- Participer à des compétitions
- Faire partie d'une communauté
- Avoir une "identité" de joueur (comme les pros)

### Segment Secondaire : L'Administrateur de Club

**Profil :**
- Membre du bureau d'un club (président, secrétaire, trésorier)
- Gère entre 10 et 100 membres
- Souvent bénévole avec peu de temps disponible

**Besoins :**
- Simplifier la gestion administrative (inscriptions, licences)
- Communiquer efficacement avec les membres
- Donner de la visibilité au club
- Organiser entraînements et événements facilement

### Segment Tertiaire : La Fédération

**Profil :**
- Fédération Française de Darts (FFD) et ligues régionales
- Gère des centaines de clubs et milliers de licenciés

**Besoins :**
- Vue d'ensemble de l'écosystème
- Organisation de compétitions officielles
- Gestion des classements nationaux
- Communication avec clubs et joueurs

---

## Goals & Success Metrics

### Business Objectives

- **Acquisition :** Atteindre 100 profils joueurs créés dans les 6 mois post-lancement MVP
- **Engagement :** 40% des utilisateurs actifs mensuels (MAU) sur les utilisateurs inscrits
- **Rétention :** Taux de rétention J30 > 25%
- **Croissance :** Croissance organique de 10% mensuel via bouche-à-oreille
- **Conversion future :** Base solide pour monétisation Freemium (objectif 5% conversion premium à terme)

### User Success Metrics

- Temps moyen pour compléter un profil < 10 minutes
- 80% des utilisateurs renseignent leur setup actuel
- 60% des utilisateurs connectent leur club
- NPS (Net Promoter Score) > 40

### Key Performance Indicators (KPIs)

| KPI | Définition | Cible MVP |
|-----|------------|-----------|
| Inscriptions | Nouveaux comptes créés | 100 en 6 mois |
| DAU/MAU | Ratio utilisateurs actifs quotidiens/mensuels | > 15% |
| Profils complets | % profils avec toutes sections remplies | > 50% |
| Setups créés | Nombre de setups de fléchettes configurés | 200 |
| Taux rebond | % visiteurs quittant après 1 page | < 50% |

---

## MVP Scope

### Core Features (Must Have)

#### 1. Authentification & Onboarding
- **OAuth Google & Facebook** : Connexion simplifiée via comptes sociaux
- **Email/Password** : Authentification classique en backup
- **Onboarding guidé** : Parcours de création de profil étape par étape
- **Gestion de compte** : Modification email, mot de passe, suppression compte

#### 2. Profil Joueur - Identité
- **Informations de base** : Nom, prénom, pseudo, date de naissance, ville
- **Contact** : Email (visibilité configurable)
- **Visuels** : Photo de profil + photo de couverture (style Facebook)
- **Niveau** : Auto-déclaration (Débutant, Amateur, Confirmé, Semi-pro, Pro)
- **Walk-on Song** : Embed YouTube/Spotify OU upload MP3 (max 2 min)

#### 3. Profil Joueur - Affiliation
- **Club actuel** : Sélection parmi les clubs existants ou "Sans club"
- **Numéro de licence** : Saisie manuelle du numéro FFD
- **Fédération** : Sélection (FFD, etc.)
- **Historique clubs** : Liste chronologique avec dates (lecture seule, alimenté par transferts)

#### 4. Profil Joueur - Setup Actuel
- **Système modulaire de composants** :
  - Pointes (Tips) : Marque, modèle, type (acier/soft), longueur
  - Fûts (Barrels) : Marque, modèle, poids, matériau, grip
  - Tiges (Shafts) : Marque, modèle, longueur, matériau
  - Ailettes (Flights) : Marque, modèle, forme, épaisseur
- **Assemblage de fléchette** : Combiner les composants pour créer une fléchette complète
- **Setup actuel** : Désigner 1 à 3 sets de fléchettes comme "setup actuel"
- **Catalogue prédéfini** : Base de données de marques/modèles (alimentée par admin)
- **Saisie libre** : Option d'ajouter un composant non catalogué avec photo

#### 5. Gestion de la Visibilité
- **Paramètres de confidentialité par section** :
  - Informations personnelles (nom, email) : Public / Privé
  - Setup actuel : Public / Privé
  - Affiliation : Public / Privé
- **Profil public** : Vue accessible sans connexion (selon paramètres)

#### 6. Catalogue de Matériel (Admin)
- **Interface admin** : CRUD pour marques et modèles de composants
- **Structure hiérarchique** : Marque > Gamme > Modèle
- **Attributs par type** : Champs spécifiques selon le type de composant

### Out of Scope for MVP

- Collection de matériel (au-delà du setup actuel)
- Statistiques et graphiques de performance
- Palmarès et compétitions
- Comparaison entre joueurs
- Intégration API Dartscounter ou autres apps
- Fiches clubs complètes
- Module Fédération
- Messagerie / Chat
- Notifications push
- Application mobile native
- Système de paiement / Freemium
- Multi-langue (anglais)
- Flux e-commerce partenaires

### MVP Success Criteria

Le MVP sera considéré comme réussi si :
1. Un joueur peut créer un compte, compléter son profil et configurer son setup en moins de 15 minutes
2. Le système modulaire de fléchettes fonctionne sans friction (ajout, modification, assemblage)
3. Les profils sont partageables via URL unique
4. 50+ inscriptions organiques dans les 3 premiers mois
5. Retours utilisateurs positifs sur l'UX (questionnaire satisfaction > 7/10)

---

## Post-MVP Vision

### Phase 2 Features

**Collection de Matériel Étendue**
- Onglet "Collection" séparé du "Setup actuel"
- Historique des setups passés
- Wishlist de composants

**Statistiques Joueur**
- Saisie manuelle des scores (PPD, MPR, moyennes)
- Historique des parties
- Graphiques de progression
- Points forts / points faibles

**Fiches Clubs (Base)**
- Migration des données ACF existantes
- Profil club public
- Liste des membres (avec consentement)
- Informations de contact et localisation

**Améliorations Profil**
- Badges et achievements
- Niveau calculé (basé sur stats)

### Phase 3 Features

**Module Fédération**
- Annuaire des clubs par fédération
- Organisation de compétitions officielles
- Classements et leaderboards
- Attribution automatique du palmarès

**Social & Communauté**
- Comparaison de statistiques entre joueurs
- Défis entre joueurs
- Fil d'actualité
- Messagerie privée

**Clubs Avancé**
- Gestion des inscriptions en ligne
- Salons de discussion privés
- Calendrier d'événements
- Communication interne

### Long-term Vision (1-2 ans)

- **Plateforme de référence** pour la communauté fléchettes francophone
- **Expansion internationale** : Anglais, Allemand, Espagnol
- **Intégrations API** : Dartscounter, Phoenix Darts, Darts Live
- **Marketplace** : Connexion avec e-commerces partenaires (flux produits)
- **Application mobile** : iOS et Android natives
- **Monétisation Freemium** :
  - Gratuit : Fonctionnalités de base
  - Premium : Stats avancées, stockage illimité, badges exclusifs
- **Partenariats** : Marques de fléchettes, fédérations officielles

### Expansion Opportunities

- Organisation de tournois en ligne (brackets, scores en direct)
- Streaming intégré des compétitions
- Coaching et contenu éducatif
- E-sport fléchettes amateur
- Intégration avec cibles connectées

---

## Technical Considerations

### Platform Requirements

| Aspect | Spécification |
|--------|---------------|
| **Target Platforms** | Web responsive (Desktop + Mobile) |
| **Browser Support** | Chrome, Firefox, Safari, Edge (2 dernières versions) |
| **Mobile** | PWA-ready pour installation home screen |
| **Performance** | LCP < 2.5s, FID < 100ms, CLS < 0.1 (Core Web Vitals) |
| **Disponibilité** | 99.5% uptime |

### Technology Preferences

| Couche | Technologie | Justification |
|--------|-------------|---------------|
| **Backend** | Laravel 11+ | Expertise existante, écosystème riche, Eloquent ORM |
| **Frontend** | Blade + Tailwind CSS (CDN) | Simplicité, pas de build process, cohérence avec stack existante |
| **Base de données** | MySQL/MariaDB | Relationnel adapté, hébergement standard |
| **Authentification** | Laravel Socialite (OAuth Google/Facebook) + Breeze (email/password) | Multi-provider + fallback classique |
| **Stockage fichiers** | Local puis S3-compatible | Photos profil, MP3 walk-on |
| **Hébergement** | Plateforme dédiée (hébergement indépendant) | Autonomie, performances, scalabilité |

### Architecture Considerations

**Repository Structure**
```
darts-fighter/
├── app/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Player.php
│   │   ├── Club.php
│   │   ├── Component.php (STI: Tip, Barrel, Shaft, Flight)
│   │   ├── Dart.php (assemblage)
│   │   └── Setup.php
│   ├── Http/Controllers/
│   └── Services/
├── database/
│   └── migrations/
├── resources/
│   └── views/
├── public/
└── routes/
```

**Service Architecture**
- Monolithique Laravel (adapté à la taille du projet)
- API RESTful interne pour futures extensions
- Queue jobs pour traitements lourds (upload images, MP3)

**Integration Requirements**
- OAuth 2.0 Google & Facebook
- YouTube/Spotify embed (iframes)
- Google Maps embed (localisation clubs)
- Future : APIs externes (Dartscounter, etc.)

**Security/Compliance**
- RGPD : Consentement explicite, droit à l'oubli, export données
- Validation stricte des uploads (types, tailles)
- Protection CSRF, XSS, SQL injection (Laravel natif)
- Rate limiting sur authentification
- Données sensibles chiffrées (email si privé)

---

## Constraints & Assumptions

### Constraints

| Type | Contrainte |
|------|------------|
| **Budget** | Projet personnel / bootstrap - pas de budget marketing initial |
| **Timeline** | MVP souhaité rapidement, développement itératif |
| **Resources** | Développeur solo (Axel) + Claude Code |
| **Technical** | Hébergement dédié indépendant |
| **Legal** | RGPD applicable (utilisateurs français) |

### Key Assumptions

- Les joueurs de fléchettes amateurs sont demandeurs d'une telle plateforme
- L'authentification multi-provider (Google, Facebook, email/password) couvrira tous les cas d'usage
- Le catalogue de matériel peut démarrer avec quelques marques principales
- Les clubs existants (données ACF) pourront être migrés vers Laravel
- La FFD et les fédérations seront intéressées à terme par la plateforme
- Le modèle Freemium sera viable une fois la base utilisateurs établie
- L'hébergement dédié garantira de bonnes performances et une scalabilité future

---

## Risks & Open Questions

### Key Risks

| Risque | Impact | Probabilité | Mitigation |
|--------|--------|-------------|------------|
| **Adoption faible** | Critique | Moyen | MVP minimal, feedback early adopters, itérations rapides |
| **Complexité technique setup modulaire** | Élevé | Moyen | Prototypage UX early, tests utilisateurs |
| **Performances hébergement** | Moyen | Faible | Monitoring, CDN si nécessaire, scaling horizontal |
| **RGPD non-conformité** | Élevé | Faible | Audit early, CGU/politique confidentialité |
| **Catalogue matériel incomplet** | Moyen | Élevé | Saisie libre en fallback, enrichissement progressif |
| **Concurrence émergente** | Moyen | Faible | First mover advantage, communauté engagée |

### Open Questions

- Quel hébergeur choisir pour la plateforme dédiée ?
- Quelle stratégie de lancement ? (beta fermée, lancement public direct ?)
- Partenariat initial avec un/des clubs pour beta test ?
- Faut-il prévoir une modération des photos/contenus uploadés ?
- Quelle limite de stockage par utilisateur pour les photos ?
- Format de partage du profil sur réseaux sociaux (Open Graph) ?

### Areas Needing Further Research

- API Dartscounter : Existe-t-elle ? Documentation ? Coût ?
- Catalogue fléchettes : Existe-t-il une base de données publique ?
- Comportement utilisateur : Interviews avec joueurs amateurs pour valider hypothèses
- SEO fléchettes : Analyse des mots-clés et volumes de recherche
- Concurrence : Audit des solutions existantes (même partielles)

---

## Appendices

### A. Research Summary

**Données existantes analysées :**
- Export ACF WordPress (`acf-export-2026-01-07.json`) contenant la structure complète des fiches clubs avec :
  - Profil club (photos, nom, caractéristiques)
  - Localisation (pays, fédération, ligue, comité, adresse, coordonnées GPS)
  - Informations clés (date création, nombre adhérents, niveau, description, FAQ)
  - Contact (site, email, téléphone, réseaux sociaux)
  - Membres du bureau (jusqu'à 8 personnes)
  - Inscription (formulaire, licences, étapes)
  - Entraînements (lieu, fréquence, horaires, niveau)
  - Tournois
  - Palmarès
  - Partenaires
  - Galerie photos
  - Boutique

Cette structure servira de base pour la migration des fiches clubs en Phase 2.

### B. Stakeholder Input

**Product Owner :** Axel
- Vision claire de la plateforme communautaire
- Priorité au profil joueur avec système modulaire de fléchettes
- Importance de la gamification et de l'aspect "identité pro"
- Approche MVP itérative validée

### C. References

- Fédération Française de Darts : https://www.ffrda.fr/
- Dartscounter App : https://www.dartscounter.com/
- PDC (Professional Darts Corporation) : https://www.pdc.tv/
- Laravel Documentation : https://laravel.com/docs
- Laravel Socialite : https://laravel.com/docs/socialite

---

## Next Steps

### Immediate Actions

1. **Valider ce Project Brief** avec le Product Owner
2. **Créer le PRD (Product Requirements Document)** détaillant les spécifications fonctionnelles
3. **Concevoir l'architecture technique** et le schéma de base de données
4. **Prototyper l'UX** du système modulaire de fléchettes
5. **Initialiser le projet Laravel** dans l'environnement de développement
6. **Constituer le catalogue initial** de marques/modèles de fléchettes

### PM Handoff

Ce Project Brief fournit le contexte complet pour **Darts Community**. L'étape suivante est de générer le PRD en travaillant section par section, en clarifiant les spécifications fonctionnelles détaillées et en définissant les user stories pour le MVP.

---

*Document généré le 7 janvier 2026*
*Darts Community - Project Brief v1.0*
