# Documentation Base de Données - Vintage Barber Shop

## Structure des Tables

### Table `admins`
Gestion des comptes administrateurs du back-office.

| Colonne | Type | Description |
|---------|------|-------------|
| `id` | INT PRIMARY KEY | Identifiant unique de l'admin |
| `username` | VARCHAR | Nom d'utilisateur pour la connexion |
| `email` | VARCHAR | Adresse email de l'admin |
| `password_hash` | VARCHAR | Mot de passe hashé (password_hash()) |

**Exemple d'insertion :**
```sql
INSERT INTO admins (username, email, password_hash) 
VALUES ('admin', 'admin@barbervintage.fr', '$2y$10$...');
```

---

### Table `hero_content`
Contenu de l'image hero affichée sur la page d'accueil.

| Colonne | Type | Description |
|---------|------|-------------|
| `id` | INT PRIMARY KEY | Identifiant (toujours 1 pour l'image unique) |
| `filename` | VARCHAR | Nom du fichier image |
| `alt_text` | VARCHAR | Texte alternatif pour l'accessibilité |
| `file_path` | VARCHAR | Chemin complet vers le fichier |

**Exemple d'utilisation :**
```sql
-- Insertion/mise à jour de l'image hero
INSERT INTO hero_content (id, filename, alt_text, file_path) 
VALUES (1, 'hero.jpg', 'Image hero - Vintage Barber Shop', 'assets/hero/hero.jpg')
ON DUPLICATE KEY UPDATE 
    filename = VALUES(filename),
    alt_text = VALUES(alt_text),
    file_path = VALUES(file_path);
```

---

### Table `gallery_images`
Images de la galerie affichées sur le site.

| Colonne | Type | Description |
|---------|------|-------------|
| `id` | INT PRIMARY KEY AUTO_INCREMENT | Identifiant unique de l'image |
| `filename` | VARCHAR | Nom du fichier image |
| `alt_text` | VARCHAR | Texte alternatif pour l'accessibilité |
| `display_order` | INT | Ordre d'affichage des images (1, 2, 3...) |
| `file_path` | VARCHAR | Chemin complet vers le fichier |

**Exemple d'utilisation :**
```sql
-- Ajouter une image à la galerie
INSERT INTO gallery_images (filename, alt_text, display_order, file_path) 
VALUES ('gallery-1234567890.jpg', 'Coupe de cheveux moderne', 1, 'assets/gallery/gallery-1234567890.jpg');

-- Réorganiser l'ordre d'affichage
UPDATE gallery_images SET display_order = 1 WHERE id = 5;
UPDATE gallery_images SET display_order = 2 WHERE id = 3;
```

---

## Requêtes Utiles

### Hero Content
```sql
-- Récupérer l'image hero actuelle
SELECT * FROM hero_content WHERE id = 1;

-- Mettre à jour l'image hero
UPDATE hero_content SET filename = 'hero.jpg', alt_text = 'Nouveau texte', file_path = 'assets/hero/hero.jpg' WHERE id = 1;
```

### Gallery Images
```sql
-- Récupérer toutes les images triées par ordre d'affichage
SELECT * FROM gallery_images ORDER BY display_order ASC;

-- Obtenir la position maximale pour ajouter une nouvelle image
SELECT MAX(display_order) as max_order FROM gallery_images;

-- Supprimer une image
DELETE FROM gallery_images WHERE id = ?;
```

### Admins
```sql
-- Vérifier les identifiants de connexion
SELECT * FROM admins WHERE username = ?;

-- Créer un nouvel admin
INSERT INTO admins (username, email, password_hash) 
VALUES ('admin', 'admin@example.com', PASSWORD_HASH);
```

---

## Chemins des Fichiers

- **Images Hero :** `assets/hero/` (filename: `hero.jpg` généralement)
- **Images Galerie :** `assets/gallery/` (filename: `gallery-timestamp.ext`)
- **Logo/Assets :** `assets/img/`

---

## Notes Techniques

1. **Hero Content :** Une seule image avec `id = 1`
2. **Gallery Images :** Utilise `display_order` pour l'ordre d'affichage
3. **Admins :** Utilise `password_hash()` PHP pour les mots de passe
4. **File Paths :** Stockés avec le chemin complet depuis la racine web
