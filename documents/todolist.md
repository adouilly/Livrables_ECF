# ToDo List Projet ECF Vintage Barber

## 1. Simplification du Code

- Analyser le projet global et chaque fichier pour identifier les simplifications possibles sans perte de fonctionnalités ou de design.
- Privilégier des solutions simples et accessibles aux débutants, tout en maintenant la complétude du projet.
- Instancier de nouvelles variables ou créer des éléments réutilisables si cela permet de simplifier le code.
- Maintenir la spécialisation de chaque fichier (un fichier = une fonctionnalité).
- Vérifier et optimiser la structure du projet selon les besoins et les consignes.
- S'assurer que la simplification ne casse aucune fonctionnalité ou design.
- Maintenir un code propre et professionnel.
- **Nettoyer le code mort, les doublons, les surcouches et mettre à jour les commentaires dans tous les fichiers.**

## 2. Base de Données (BDD) & Documentation

- Vérifier la cohérence entre la BDD réelle et sa documentation.
- Exporter la BDD dans : `barbervintage.fr\sql\vintage_barber_db.sql` (garder ce fichier tel quel pour l'examinateur).
- Mettre à jour la documentation SQL selon l’export.
- Supprimer les fichiers SQL inutiles.
- Centraliser toutes les informations liées à la BDD et SQL dans un seul fichier pour une vue globale.

## 3. Documentation Générale

- Mettre à jour toute la documentation du projet.
- Créer des fichiers dédiés pour détailler le design des pages ou tout autre aspect utile à la compréhension.
- Faire le bilan de la V1 en fonction des consignes.
- Nettoyer les fichiers de documentation : supprimer les doublons, surcouches et commentaires inutiles.
- Ne documenter que ce qui est effectivement présent dans le projet.
- Mettre en place une documentation structurée et hiérarchisée.

## 4. Sécurité & Connexion

- Désactiver temporairement la déconnexion automatique du login (sera réactivée en V2).
- Réactiver les sécurités désactivées temporairement.
- Supprimer tous les `console.log` et autres informations de debug visibles en front ou dans la console.

## 5. Derniere couche de design
- Utiliser le fichier : CANVA_EFFECT.md pour mettre en place la dernière couche de design.
- Design et effet dynamique.

## 6. Versions Futures

### V2 : Mise en place du MVC

- Créer un nouveau dossier pour la V2.
- Implémenter l’architecture MVC selon les consignes.

### V3 : Finalisation

- SEO, optimisation et sécurité (selon les consignes).
- Corriger l’icône du site : utiliser simplement le logo du site.
- Ajouter un élément de design dynamique sur l’index (uniquement tablette et desktop). Se référer au fichier `CANVA_EFFECT.md`.
