# Présentation du projet

Ce projet est une application web OnePage responsive destinée à présenter l'activité d'un artisan local (ex : coiffeur, pâtissier, menuisier, etc.).  
Le site vitrine permet de présenter le savoir-faire de l'artisan, ses réalisations, et de faciliter la prise de contact.  
Un panneau d'administration sécurisé permet à l'artisan de modifier les contenus du site (textes, images).

## Fonctionnalités principales

- Site OnePage responsive (mobile, tablette, desktop)
- Présentation de l'activité
- Liste des prestations/services
- Galerie de réalisations
- Formulaire de contact
- Footer avec mentions légales
- Espace d'administration pour la gestion des contenus

---

# Instructions d'installation

## Prérequis

- WAMP ou équivalent (Apache, PHP, MySQL/MariaDB)
- PHP >= 8.3
- MySQL >= 9.1 ou MariaDB >= 11.5
- phpMyAdmin recommandé

## Installation en local

1. **Cloner ou extraire le projet dans votre dossier web local**  
   Exemple : `e:\projet dev\ecf livrable\`

2. **Importer la base de données**
   - Ouvrir phpMyAdmin
   - Créer une nouvelle base de données (ex : `vintage_barber_db`)
   - Importer le fichier `vintage_barber_db.sql` fourni dans le projet

3. **Configurer la connexion à la base de données**
   - Vérifier le fichier de configuration (ex : `config.php`)
   - Adapter les paramètres si besoin :
     - Hôte : `localhost`
     - Utilisateur : `root`
     - Mot de passe : (laisser vide par défaut en local)
     - Nom de la base : `vintage_barber_db`

4. **Lancer le serveur local**
   - Démarrer WAMP ou votre stack locale
   - Accéder au site via `http://localhost/nom_du_projet/`

5. **Accès à l'administration**
   - URL : `/admin` ou bouton dédié sur le site
   - Identifiants par défaut :  
     - Utilisateur : `admin`  
     - Mot de passe : `password`

---

# Configuration serveur utilisée (exemple)

- Apache/2.4.62 (Win64)
- PHP/8.3.14
- MySQL 9.1.0 (port 3306)
- MariaDB 11.5.2 (port 3307)
- phpMyAdmin 5.2.1

---

# Captures d'écran

Veuillez placer ici les captures d'écran des 3 formats requis :  
- Mobile (360px)
- Tablette (768px)
- Desktop (1200px+)

---

# Export BDD

Le fichier d'export de la base de données est : `vintage_barber_db.sql`

---

# MCD

Le MCD (Modèle Conceptuel de Données) est disponible dans le dossier `document` du projet.

---

# Informations complémentaires

Pour toute question ou problème d'installation, consultez la documentation ou contactez le développeur.

Document détaillant l'installation du site en local avec la bdd.
Pour se connecter en admin : ( admin / password )

config :
WAMP EN LOCAL
Serveur de base de données
Serveur : MySQL (127.0.0.1 via TCP/IP)
Type de serveur : MySQL
Connexion au serveur : SSL n'est pas utilisé Documentation
Version du serveur : 9.1.0 - MySQL Community Server - GPL
Version du protocole : 10
Utilisateur : root@localhost
Jeu de caractères du serveur : UTF-8 Unicode (utf8mb4)
Serveur Web
Apache/2.4.62 (Win64) PHP/8.3.14 mod_fcgid/2.3.10-dev
Version du client de base de données : libmysql - mysqlnd 8.3.14
Extension PHP : mysqli Documentation curl Documentation mbstring Documentation
Version de PHP : 8.3.14
phpMyAdmin
Version : 5.2.1, dernière version stable : 5.2.2
Documentation
Site officiel
Contribuer
Obtenir de l'aide
Liste des changements
Licence

-----------------------------------------------------------------------------------

Configuration Serveur
Version Apache :
2.4.62.1  - Documentation Apache - Modules Apache chargés
Server Software :
Apache/2.4.62 (Win64) PHP/8.3.14 mod_fcgid/2.3.10-dev - Port défini pour Apache : 80
Version de PHP :
[Apache module]  8.3.14 - Documentation PHP - Extensions PHP chargées - Utilisation versions PHP
 
[FCGI] 7.4.33 - 8.0.30 - 8.1.31 - 8.2.26 - 8.3.14 - 8.4.0 - Aide mode FCGI
Version de MySQL :
9.1.0 - Port défini pour MySQL : 3306 - SGBD par défaut -  Documentation MySQL
Version de MariaDB :
11.5.2 - Port défini pour MariaDB : 3307 -  Documentation MariaDB - MySQL - MariaDB

EXPORT BDD : fichier : vintage_barber_db.sql

-----------------------------------------------------------------------------------

