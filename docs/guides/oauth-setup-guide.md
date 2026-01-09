# Guide de Configuration OAuth - Google & Facebook

> Ce guide vous accompagne pas à pas pour configurer l'authentification Google et Facebook pour Darts Community.

---

## 1. Configuration Google OAuth

### Étape 1 : Accéder à la Google Cloud Console

1. Allez sur [console.cloud.google.com](https://console.cloud.google.com)
2. Connectez-vous avec votre compte Google
3. Cliquez sur **Sélectionner un projet** → **Nouveau projet**
4. Nom du projet : `Darts Community`
5. Cliquez **Créer**

### Étape 2 : Activer l'API Google+

1. Dans le menu hamburger (☰), allez dans **API et services** → **Bibliothèque**
2. Recherchez `Google+ API` (ou `Google People API`)
3. Cliquez dessus puis **Activer**

### Étape 3 : Configurer l'écran de consentement OAuth

1. Allez dans **API et services** → **Écran de consentement OAuth**
2. Choisissez **Externe** (pour permettre à tous de se connecter)
3. Remplissez les informations :
   - **Nom de l'application** : Darts Community
   - **Email d'assistance utilisateur** : votre email
   - **Logo** : (optionnel, ajoutez-le plus tard)
   - **Domaine autorisé** : `dartscommunity.com`
   - **Email du développeur** : votre email
4. Cliquez **Enregistrer et continuer**
5. **Scopes** : Cliquez sur **Ajouter ou supprimer des champs d'application**
   - Cochez : `email`, `profile`, `openid`
   - Cliquez **Mettre à jour** puis **Enregistrer et continuer**
6. **Utilisateurs test** : Ignorez pour l'instant → **Enregistrer et continuer**
7. **Récapitulatif** : Vérifiez et cliquez **Retour au tableau de bord**

### Étape 4 : Créer les identifiants OAuth

1. Allez dans **API et services** → **Identifiants**
2. Cliquez **+ Créer des identifiants** → **ID client OAuth**
3. Type d'application : **Application Web**
4. Nom : `Darts Community Web`
5. **Origines JavaScript autorisées** :
   - `https://dartscommunity.com`
   - `http://dartscommunity.test` (pour dev local)
6. **URI de redirection autorisés** :
   - `https://dartscommunity.com/auth/google/callback`
   - `http://dartscommunity.test/auth/google/callback`
7. Cliquez **Créer**

### Étape 5 : Récupérer vos identifiants

Après création, vous verrez :
- **ID client** : `xxxxx.apps.googleusercontent.com`
- **Code secret du client** : `GOCSPX-xxxxx`

**Copiez ces valeurs** et gardez-les en sécurité !

### Étape 6 : Configurer dans Laravel

Dans votre fichier `.env` :

```env
GOOGLE_CLIENT_ID=xxxxx.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-xxxxx
GOOGLE_REDIRECT_URI=https://dartscommunity.com/auth/google/callback
```

Pour le développement local, utilisez :
```env
GOOGLE_REDIRECT_URI=http://dartscommunity.test/auth/google/callback
```

---

## 2. Configuration Facebook OAuth

### Étape 1 : Créer une application Facebook

1. Allez sur [developers.facebook.com](https://developers.facebook.com)
2. Connectez-vous avec votre compte Facebook
3. Cliquez sur **Mes applications** → **Créer une application**
4. Choisissez **Permettre aux utilisateurs de se connecter avec leur compte Facebook**
5. Cliquez **Suivant**
6. Nom de l'application : `Darts Community`
7. Email de contact : votre email
8. Cliquez **Créer une application**

### Étape 2 : Configurer Facebook Login

1. Dans le tableau de bord, trouvez **Facebook Login** et cliquez **Configurer**
2. Choisissez **Web**
3. URL du site : `https://dartscommunity.com`
4. Cliquez **Enregistrer** puis **Continuer**
5. Ignorez les étapes suivantes du guide rapide

### Étape 3 : Configurer les paramètres OAuth

1. Dans le menu gauche, allez dans **Facebook Login** → **Paramètres**
2. Remplissez **URI de redirection OAuth valides** :
   ```
   https://dartscommunity.com/auth/facebook/callback
   http://dartscommunity.test/auth/facebook/callback
   ```
3. Cliquez **Enregistrer les modifications**

### Étape 4 : Récupérer vos identifiants

1. Dans le menu gauche, allez dans **Paramètres** → **Général**
2. Vous verrez :
   - **Identifiant de l'application** : `123456789`
   - **Clé secrète** : Cliquez **Afficher** → `abc123...`

**Copiez ces valeurs** et gardez-les en sécurité !

### Étape 5 : Passer en mode Production

⚠️ **Important** : Par défaut, l'app est en mode développement (seuls vous pouvez vous connecter).

Pour permettre à tous de se connecter :
1. En haut du tableau de bord, vous verrez **Mode de l'app : Développement**
2. Cliquez sur le toggle pour passer en **Production**
3. Facebook vous demandera peut-être de compléter une vérification

### Étape 6 : Configurer dans Laravel

Dans votre fichier `.env` :

```env
FACEBOOK_CLIENT_ID=123456789
FACEBOOK_CLIENT_SECRET=abc123...
FACEBOOK_REDIRECT_URI=https://dartscommunity.com/auth/facebook/callback
```

Pour le développement local, utilisez :
```env
FACEBOOK_REDIRECT_URI=http://dartscommunity.test/auth/facebook/callback
```

---

## 3. Vérification de la Configuration

### Test en local

1. Assurez-vous que votre `.env` local a les bonnes valeurs
2. Lancez l'application : `php artisan serve` ou via Laravel Herd
3. Allez sur la page de connexion
4. Cliquez sur "Se connecter avec Google" ou "Se connecter avec Facebook"
5. Vous devriez être redirigé vers le provider, puis revenir connecté

### Problèmes courants

| Problème | Solution |
|----------|----------|
| "redirect_uri_mismatch" | Vérifiez que l'URI dans `.env` correspond exactement à celle configurée chez Google/Facebook |
| "App not verified" (Google) | Normal en mode test. Cliquez "Continuer" ou "Accès avancé" |
| "App in development mode" (Facebook) | Passez l'app en mode Production |
| Erreur 403 | Vérifiez que les scopes email et profile sont activés |

---

## 4. Checklist Finale

### Google
- [ ] Projet créé sur Google Cloud Console
- [ ] API Google+ ou People API activée
- [ ] Écran de consentement configuré
- [ ] Identifiants OAuth créés
- [ ] URIs de redirection ajoutées (prod + dev)
- [ ] Valeurs copiées dans `.env`

### Facebook
- [ ] Application créée sur Facebook Developers
- [ ] Facebook Login configuré
- [ ] URIs de redirection ajoutées
- [ ] Valeurs copiées dans `.env`
- [ ] App passée en mode Production (avant lancement)

---

*Guide créé le 2026-01-08 pour Darts Community*
