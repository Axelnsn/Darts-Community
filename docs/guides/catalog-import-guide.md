# Guide d'Import du Catalogue Équipement

> Ce guide explique comment préparer votre fichier CSV/Excel pour importer les marques et composants de fléchettes.

---

## 1. Structure des Données

Le catalogue est organisé en 2 niveaux :
1. **Marques** (Brands) - Les fabricants
2. **Composants** (Components) - Les produits par type

### Types de composants

| Type | Français | Attributs spécifiques |
|------|----------|----------------------|
| `tip` | Pointe | type (steel/soft), length |
| `barrel` | Fût | weight, material, grip_style |
| `shaft` | Tige | length, material |
| `flight` | Ailette | shape, thickness |

---

## 2. Fichier Excel/CSV - Marques

### Feuille 1 : `brands`

| Colonne | Obligatoire | Description | Exemple |
|---------|-------------|-------------|---------|
| name | ✅ Oui | Nom de la marque | Target |
| website | Non | Site officiel | https://www.target-darts.co.uk |

### Exemple

```csv
name,website
Target,https://www.target-darts.co.uk
Winmau,https://www.winmau.com
Unicorn,https://www.unicorn-darts.com
Red Dragon,https://www.reddragondarts.com
Harrows,https://www.harrowsdarts.com
Koto,
Shot,https://www.shotdarts.com
Bull's,https://www.bulls.nl
```

---

## 3. Fichier Excel/CSV - Composants

### Feuille 2 : `components`

| Colonne | Obligatoire | Description | Exemple |
|---------|-------------|-------------|---------|
| brand | ✅ Oui | Nom de la marque (doit exister dans brands) | Target |
| type | ✅ Oui | Type : tip, barrel, shaft, flight | barrel |
| name | ✅ Oui | Nom du modèle | Phil Taylor Power 9Five G7 |
| *attributs...* | Selon type | Voir ci-dessous | |

### Attributs par type

#### Pour les Pointes (tip)

| Colonne | Obligatoire | Description | Valeurs possibles |
|---------|-------------|-------------|-------------------|
| tip_type | ✅ Oui | Type de pointe | steel, soft |
| length | Non | Longueur | 26mm, 32mm, etc. |

#### Pour les Fûts (barrel)

| Colonne | Obligatoire | Description | Valeurs possibles |
|---------|-------------|-------------|-------------------|
| weight | ✅ Oui | Poids | 18g, 21g, 24g, etc. |
| material | Non | Matériau | tungsten, brass, nickel |
| grip_style | Non | Type de grip | ringed, knurled, smooth, shark |

#### Pour les Tiges (shaft)

| Colonne | Obligatoire | Description | Valeurs possibles |
|---------|-------------|-------------|-------------------|
| length | ✅ Oui | Longueur | short, medium, long |
| material | Non | Matériau | nylon, aluminum, carbon, titanium |

#### Pour les Ailettes (flight)

| Colonne | Obligatoire | Description | Valeurs possibles |
|---------|-------------|-------------|-------------------|
| shape | ✅ Oui | Forme | standard, slim, kite, pear, fantail |
| thickness | Non | Épaisseur (microns) | 75, 100, 150 |

---

## 4. Exemples Complets

### Pointes (tips)

```csv
brand,type,name,tip_type,length
Target,tip,Storm Point,steel,26mm
Target,tip,Storm Point Nano,steel,26mm
Winmau,tip,Stealth Point,steel,32mm
Red Dragon,tip,Trident Point,steel,26mm
Harrows,tip,Retina Point,steel,26mm
```

### Fûts (barrels)

```csv
brand,type,name,weight,material,grip_style
Target,barrel,Phil Taylor Power 9Five G7,24g,tungsten,ringed
Target,barrel,Rob Cross Voltage,22g,tungsten,shark
Winmau,barrel,Michael van Gerwen Aspire,23g,tungsten,knurled
Winmau,barrel,Simon Whitlock,22g,tungsten,ringed
Unicorn,barrel,Gary Anderson Phase 5,23g,tungsten,ringed
Red Dragon,barrel,Gerwyn Price Iceman,24g,tungsten,shark
Harrows,barrel,Dave Chisnall Chizzy,22g,tungsten,ringed
Shot,barrel,Michael Smith Bully Boy,22g,tungsten,knurled
```

### Tiges (shafts)

```csv
brand,type,name,length,material
Target,shaft,Pro Grip,medium,nylon
Target,shaft,Pro Grip Spin,medium,nylon
Target,shaft,Titanium Pro,short,titanium
Winmau,shaft,Vecta,medium,aluminum
Unicorn,shaft,Gripper 4,short,nylon
Harrows,shaft,Supergrip Carbon,medium,carbon
```

### Ailettes (flights)

```csv
brand,type,name,shape,thickness
Target,flight,Phil Taylor Power Vision,standard,100
Target,flight,Rob Cross Voltage,standard,100
Winmau,flight,Prism Alpha,standard,100
Winmau,flight,Prism Delta,kite,100
Unicorn,flight,Ultrafly,standard,75
Red Dragon,flight,Hardcore,standard,150
Harrows,flight,Marathon,standard,100
```

---

## 5. Fichier Combiné (Recommandé)

Vous pouvez tout mettre dans un seul fichier avec plusieurs feuilles :

### Structure Excel (.xlsx)

```
📄 darts-catalog.xlsx
├── Feuille "brands"     → Liste des marques
├── Feuille "tips"       → Toutes les pointes
├── Feuille "barrels"    → Tous les fûts
├── Feuille "shafts"     → Toutes les tiges
└── Feuille "flights"    → Toutes les ailettes
```

### Ou plusieurs fichiers CSV

```
📁 catalog/
├── brands.csv
├── tips.csv
├── barrels.csv
├── shafts.csv
└── flights.csv
```

---

## 6. Conseils Pratiques

### Marques à inclure (vos 8 marques)

| Marque | Spécialité |
|--------|------------|
| Target | Fûts haut de gamme, innovations (Phil Taylor, Rob Cross) |
| Winmau | Cibles, équipement complet (MvG) |
| Unicorn | Historique, large gamme (Gary Anderson) |
| Red Dragon | Bon rapport qualité/prix (Gerwyn Price) |
| Harrows | Qualité britannique (Dave Chisnall) |
| Koto | Entrée de gamme accessible |
| Shot | Marque néo-zélandaise montante |
| Bull's | Marque allemande/néerlandaise |

### Commencer petit

Pour le MVP, je recommande :
- 8 marques ✅
- 5-10 fûts populaires par marque
- 3-5 modèles de tiges par marque
- 3-5 modèles d'ailettes par marque
- 2-3 types de pointes par marque

**Total estimé : ~100-150 composants**

### Où trouver les références ?

- Sites officiels des marques
- [Dartshopper.com](https://www.dartshopper.com)
- [DartsCorner.co.uk](https://www.dartscorner.co.uk)
- [Amazon](https://www.amazon.fr) (recherche "flechettes")

---

## 7. Template à Télécharger

Je peux générer un fichier Excel template vide avec les bonnes colonnes. Voulez-vous que je le crée ?

En attendant, vous pouvez copier les exemples ci-dessus dans Excel ou Google Sheets.

---

## 8. Import dans l'Application

Une fois le fichier prêt, l'import se fera via :

1. **Commande Artisan** (pour le développeur) :
   ```bash
   php artisan catalog:import chemin/vers/catalog.xlsx
   ```

2. **Interface Admin** (optionnel pour plus tard) :
   - Aller dans Admin → Catalogue → Importer
   - Uploader le fichier
   - Vérifier le preview
   - Confirmer l'import

---

*Guide créé le 2026-01-08 pour Darts Community*
