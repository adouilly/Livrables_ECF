# 🪒 Vintage Barber Shop - Site Web Admin v1 FINALE

## 📋 Présentation du Projet

Site web professionnel pour un salon de coiffure vintage avec panneau d'administration complet. Le site permet de gérer le contenu, les images et les informations via une interface d'administration sécurisée.

**🎯 VERSION 1 FINALE - Statut Complet ✅**

## 🎯 Fonctionnalités Principales

### ✅ Front-Office (Site Public)
- **Page d'accueil moderne** avec image hero personnalisable via admin
- **Galerie d'images** avec système de visualisation fluide et navigation
- **Design responsive parfait** adaptatif mobile (360px)/tablette (768px)/desktop (1200px+)
- **Interface utilisateur intuitive** avec animations professionnelles
- **Navigation fluide** avec scroll behavior et tondeuse animation responsive
- **Footer optimisé** avec espacement équilibré et design centré

### ✅ Back-Office (Administration)
- **Système d'authentification sécurisé** avec timeout de session
- **Dashboard centralisé** avec interface full-width sans marges optimisée
- **Gestion de l'image hero** : Upload direct depuis dashboard avec preview inline
- **Gestion de la galerie** : Upload multiple, drag & drop, suppression, réorganisation
- **Section galerie full-width** occupant toute la largeur d'écran pour gestion optimale
- **Design dashboard cohérent** avec espacement parfait entre tous les éléments
- **Changement de mot de passe** simplifié et sécurisé (sans ancien mot de passe requis)
- **Session management** avec timeout automatique d'inactivité (2 minutes)
- **Architecture modulaire** CSS et JS pour maintenance facilitée
- **Cache busting** automatique pour mises à jour instantanées

### 🛡️ Sécurité Implémentée
- **Protection contre l'injection SQL** avec requêtes préparées PDO
- **Validation stricte des données** d'entrée avec filtres et contrôles
- **Gestion sécurisée des uploads** : Types MIME, taille max, répertoires sécurisés
- **Sessions sécurisées** avec timeout d'inactivité et regeneration ID
- **Contrôle d'accès** strict sur toutes les pages admin avec redirections
- **Hashage des mots de passe** avec password_hash() PHP moderne
- **Protection CSRF** sur les formulaires critiques

## 🔧 Technologies Utilisées

- **Backend**: PHP 8.3+ avec PDO pour base de données
- **Base de données**: MySQL 9.1+ avec UTF8MB4 et transactions
- **Frontend**: HTML5, CSS3 moderne, JavaScript ES6+ modulaire
- **Upload**: Système AJAX avec preview et validation client/serveur
- **Cache**: Système de cache-busting pour assets mis à jour
- **Responsive**: Mobile-first avec breakpoints optimisés
- **Serveur**: Apache 2.4+ (WAMP)
- **Architecture**: MVC simplifié avec templates modulaires

## 📂 Structure du Projet

```
barbervintage.fr/
├── 📁 admin/                     # Back-office
│   ├── 📄 dashboard.php          # Dashboard principal (modularisé)
│   ├── 📄 login.php              # Authentification
│   ├── 📄 change-password-ajax.php # Changement mot de passe
│   ├── 📄 upload-gallery-ajax.php  # Upload galerie AJAX
│   ├── 📄 delete-gallery-image.php # Suppression image AJAX
│   ├── 📄 reorder-gallery.php    # Réorganisation drag & drop
│   ├── 📁 templates/             # Templates modulaires
│   │   ├── 📄 header.php         # Header admin
│   │   ├── 📄 footer.php         # Footer admin
│   │   ├── 📄 admin-info-bar.php # Barre admin + changement mdp
│   │   └── 📁 sections/          # Sections du dashboard
│   │       ├── 📄 info-section.php    # Recommandations
│   │       ├── 📄 hero-section.php    # Gestion hero
│   │       └── 📄 gallery-section.php # Gestion galerie
│   └── 📁 includes/              # Scripts inclus
│       ├── 📄 hero-upload-handler.php # Handler upload hero
│       └── 📄 functions.php      # Fonctions communes
├── 📁 assets/                    # Ressources
│   ├── 📁 hero/                  # Images hero
│   └── 📁 gallery/               # Images galerie
├── 📁 css/                       # Styles CSS
│   ├── 📁 common/               # CSS commun
│   ├── 📁 front/                # CSS front-office
│   └── 📁 back/                 # CSS back-office (avec drag & drop)
├── 📁 js/                        # JavaScript
│   ├── 📁 front/                # JS front-office
│   └── 📁 back/                 # JS back-office
│       ├── 📄 dashboard.js       # Scripts dashboard
│       ├── 📄 hero-upload.js     # Upload hero
│       └── 📄 gallery-management.js # Galerie + drag & drop
├── 📁 includes/                  # Configuration
│   └── 📄 config.php            # Configuration BDD
└── 📁 sql/                       # Scripts SQL
    └── 📄 database_structure.md  # Documentation BDD
```

## 🗄️ Base de Données

### Tables Principales

#### `admins`
- **id** (INT, PRIMARY KEY) - Identifiant unique
- **username** (VARCHAR) - Nom d'utilisateur
- **email** (VARCHAR) - Email de l'admin
- **password_hash** (VARCHAR) - Mot de passe hashé (password_hash())

#### `hero_content`
- **id** (INT, PRIMARY KEY) - Identifiant (toujours 1)
- **filename** (VARCHAR) - Nom du fichier image
- **alt_text** (VARCHAR) - Texte alternatif
- **file_path** (VARCHAR) - Chemin vers le fichier

#### `gallery_images`
- **id** (INT, PRIMARY KEY) - Identifiant unique
- **filename** (VARCHAR) - Nom du fichier image
- **alt_text** (VARCHAR) - Texte alternatif
- **display_order** (INT) - Ordre d'affichage (drag & drop)
- **file_path** (VARCHAR) - Chemin vers le fichier

## 🚀 Installation et Configuration

### Prérequis
- **WAMP** (Windows) ou équivalent LAMP/MAMP
- **PHP 8.3+** avec extensions PDO, PDO_MySQL, GD, mbstring
- **MySQL 9.1+**
- **Apache 2.4+**

### Étapes d'Installation

1. **Cloner le projet** dans le répertoire web
2. **Configurer le virtual host** (ex: barberdd)
3. **Créer la base de données** `vintage_barber_db`
4. **Configurer** `includes/config.php` avec vos paramètres
5. **Exécuter** le script de setup : `http://votre-domaine/admin/setup-hero-table.php`
6. **Tester** avec : `http://votre-domaine/admin/test-database.php`

### Configuration Virtual Host (exemple)
```apache
<VirtualHost *:80>
    DocumentRoot "E:/projet dev/ProjetExamenECF/Vintage_Barber/barbervintage.fr"
    ServerName barberdd
    <Directory "E:/projet dev/ProjetExamenECF/Vintage_Barber/barbervintage.fr">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## 🎮 Utilisation

### Accès Administration
- **URL**: `http://barberdd/admin/`
- **Login**: Défini en base de données
- **Fonctionnalités** :
  - Upload image hero direct depuis dashboard
  - Upload multiple d'images galerie avec prévisualisation
  - Réorganisation galerie par drag & drop
  - Suppression d'images en AJAX (sans déconnexion)
  - Changement de mot de passe simplifié

### Gestion du Contenu
- **Image Hero** : Format recommandé 851px × 315px
- **Images Galerie** : Ratio 16:9 (1920px × 1080px)
- **Formats supportés** : JPG, PNG, WebP
- **Taille maximum** : 5MB par fichier
- **Interface dashboard** : Design optimisé sans marges parasites
- **Section galerie** : Affichage full-width pour utilisation maximale de l'espace

### Optimisations Interface
- **Dashboard cohérent** : Suppression des marges entre titres et contenus
- **Galerie full-width** : Section galerie occupe 100% de la largeur d'écran
- **Espacement parfait** : Éléments collés sans espaces vides indésirables
- **Animation tondeuse responsive** : 
  - Mobile : Animation verticale avec rotation et scale x3
  - Tablette : Animation horizontale avec scale x1.5 pour visibilité
  - Desktop : Animation horizontale taille normale

## 🔄 Workflow de Développement

### Architecture Modulaire
- **Templates séparés** pour faciliter la maintenance
- **Handlers spécialisés** pour chaque fonctionnalité
- **JavaScript modulaire** (front/back séparés)
- **CSS organisé** par domaine fonctionnel

### Sécurité Implémentée
- ✅ **Requêtes préparées** pour toutes les interactions BDD
- ✅ **Validation stricte** des données d'entrée
- ✅ **Échappement HTML** pour prévenir XSS
- ✅ **Contrôle de session** avec timeout
- ✅ **Vérification des permissions** de fichiers

## 🛠️ Scripts Utilitaires

- **setup-hero-table.php** : Création/vérification table hero_content
- **test-database.php** : Test complet des tables et connexions
- **test-wamp.php** : Diagnostic configuration serveur

## 📈 État du Projet - Version Actuelle

### ✅ Fonctionnalités Complètes
- [x] Dashboard modularisé avec design optimisé sans marges
- [x] Upload hero avec correction INSERT ON DUPLICATE KEY UPDATE
- [x] Upload galerie multiple avec AJAX (sans redirection)
- [x] Drag & drop pour réorganisation galerie
- [x] Suppression images galerie sans déconnexion
- [x] Changement mot de passe sans ancien mot de passe
- [x] Protection injection SQL sur toutes les requêtes
- [x] Interface centrée et design uniforme
- [x] Section galerie full-width optimisée
- [x] Animation tondeuse responsive multi-breakpoints
- [x] Gestion d'erreurs complète

### 🔄 Prochaines Améliorations (V2)
- [ ] Optimisation des performances
- [ ] Compression automatique des images
- [ ] Système de backup automatique
- [ ] Logs d'activité admin
- [ ] Interface de gestion multi-admin
- [ ] API REST pour intégrations futures

### 🧪 Tests à Effectuer
- [ ] Test upload fichiers galerie
- [ ] Test changement mot de passe
- [ ] Test drag & drop réorganisation
- [ ] Test suppression images
- [ ] Test sécurité injection SQL

## 📞 Support et Maintenance

Le projet est structuré pour faciliter la maintenance future avec :
- **Code commenté** et documenté
- **Architecture modulaire** extensible
- **Logs d'erreurs** détaillés
- **Scripts de diagnostic** intégrés

---

**Version**: 1.0 - Fonctionnalités complètes  
**Dernière mise à jour**: Août 2025  
**Statut**: Prêt pour tests finaux avant V2
