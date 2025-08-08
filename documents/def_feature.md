# Vintage Barber Shop - Principales Caractéristiques & Exemples de Code

## 1. Architecture Modulaire

Chaque fonctionnalité est isolée dans son propre fichier pour faciliter la maintenance et l'évolution du projet.

**Exemple :**
```php
// admin/dashboard.php
include 'templates/header.php';
include 'templates/sections/hero-section.php';
include 'templates/sections/gallery-section.php';
include 'templates/footer.php';
```

## 2. Upload d'Images Hero et Galerie

Upload sécurisé avec validation côté client et serveur, preview avant envoi.

**Exemple JS :**
```javascript
function previewHeroImage(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('heroPreview').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}
```
**Exemple PHP :**
```php
// admin/handlers/hero-upload-handler.php
if ($_FILES['hero_file']['size'] < 5*1024*1024) {
    // Traitement upload
}
```

## 3. Gestion Galerie Drag & Drop

Réorganisation dynamique des images avec sauvegarde de l’ordre en base.

**Exemple JS :**
```javascript
// js/back/gallery-management.js
function reorderGallery() {
    // Drag & drop puis AJAX vers reorder-gallery.php
}
```

## 4. Sécurité

- Requêtes préparées PDO
- Validation stricte des entrées
- Hashage des mots de passe

**Exemple PHP :**
```php
$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
$stmt->execute([$username]);
```

## 5. Responsive Design

CSS mobile-first, breakpoints optimisés.

**Exemple CSS :**
```css
@media (max-width: 768px) {
    .gallery-section { flex-direction: column; }
}
```

## 6. Cache Busting

Forçage du rechargement des images après upload.

**Exemple JS :**
```javascript
function refreshAllImages() {
    const timestamp = Date.now();
    document.querySelectorAll('img[src*="assets/hero/"], img[src*="assets/gallery/"]').forEach(img => {
        const baseUrl = img.src.split('?')[0];
        img.src = baseUrl + '?v=' + timestamp;
    });
}
```

## 7. Gestion des Sessions

Timeout automatique, sécurisation des accès admin.

**Exemple PHP :**
```php
// includes/functions.php
if (time() - $_SESSION['last_activity'] > 120) {
    session_destroy();
}
```

## 8. Documentation & Nettoyage

- Tous les fichiers sont commentés et nettoyés des doublons et surcouches.
- Les fonctionnalités sont documentées dans les fichiers README et docs.

---

Ce document synthétise les principales caractéristiques du projet et illustre chaque feature par un exemple de code issu du codebase.
