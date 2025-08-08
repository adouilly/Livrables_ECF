Développer une application web OnePage responsive destinée à présenter l'activité d'un artisan local (exemples : fleuriste, menuisier, pâtissier, coiffeur, céramiste…).
Le site devra être développé en mobile-first et inclure un panneau d’administration permettant de modifier les contenus du site.

Contexte
Un artisan local souhaite disposer d’un site vitrine pour :

présenter son savoir-faire
mettre en avant ses réalisations
permettre aux visiteurs de le contacter facilement

Il souhaite également pouvoir mettre à jour lui-même certaines informations (ex : images de ses réalisations ou texte de présentation) via un espace d’administration sécurisé.

✅ Fonctionnalités attendues
🔷 Front-Office (visible au public)
Le site est une OnePage responsive, composé des sections suivantes :

Header
Logo ou nom de l’artisan
Menu burger (sur mobile), classique (sur desktop)
Navigation fluide vers les sections

Présentation
Photo ou image
Texte décrivant l’activité de l’artisan

Prestations / Services
Liste de 3 à 6 prestations avec titres et descriptions
Affichage responsive (grille ou liste selon la taille d’écran)

Galerie de réalisations
Affichage de 6 à 10 images, avec légendes possibles
Responsive et esthétique

Contact
Formulaire de contact (nom, email, message) ou simple bouton mailto
Adresse / téléphone (fictifs acceptés)

Footer
Mentions légales (lien ou texte)
Réseaux sociaux (facultatif)

🔷 Responsive Design
Le site doit s’adapter à 3 tailles :

Mobile (360px)
Tablette (768px)
Ordinateur (1200px+)

L’intégration doit suivre une logique mobile-firs
Utiliser des media queries
🔷 Back-Office (interface d’administration)
Accessible via /admin, l’espace d’administration permettra :

Connexion sécurisée
Identifiant + mot de passe
Gestion de $_SESSION (PHP)

Modification de contenu :
Modifier le texte de présentation
Ajouter / modifier / supprimer des prestations
Ajouter / modifier / supprimer des images de la galerie

Upload d’images
Interface d’upload sécurisée (formats autorisés, taille max)
Stockage des fichiers dans un dossier uploads/
Affichage immédiat sur le front après mise à jour

Contraintes techniques
Front-end
HTML5, CSS3
Menu burger fonctionnel en JS
Flexbox ou Grid

Back-end
PHP + MySQL
Sécurité
Connexion sécurisée avec hash de mot de passe

Structure du projet suggérée
/site-vitrine-artisan
│
├── /assets
│   ├── /images
│   └── /css
├── /uploads
├── /admin
│   ├── login.php
│   ├── dashboard.php
│   └── logout.php
├── index.html / index.php
├── style.css
├── script.js
└── README.md


Livrables attendus
Code source complet du projet
MCD
README avec :
Présentation du projet
Instructions d’installation
Capture d’écrans des 3 formats (mobile, tablette, desktop)