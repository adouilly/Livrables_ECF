<?php
/**
 * Template Hero Section - Vintage Barber Shop
 * Image full-width responsive sous le header
 */

// Récupération des données hero depuis la variable globale
global $heroContent;

// Inclure les utilitaires de cache
require_once 'includes/cache-utils.php';

// Vérification que les données hero existent
if ($heroContent && !empty($heroContent['hero_image'])) {
    $heroImagePath = 'assets/hero/' . $heroContent['hero_image'];
    $heroAltText = $heroContent['alt_text'] ?? 'Hero image - Vintage Barber Shop';
} else {
    // Image de fallback si aucune image en base
    $heroImagePath = 'assets/hero/hero.jpg';
    $heroAltText = 'Hero image - Vintage Barber Shop';
}

// Utiliser le cache-busting pour s'assurer que l'image est toujours à jour
$heroImageWithCache = getAssetUrl($heroImagePath);
?>

<!-- ========================================
     SECTION HERO - IMAGE FULL WIDTH
     ======================================== -->
<section class="hero" role="banner">
    <div class="hero__image-container">
        <img src="<?= htmlspecialchars($heroImageWithCache) ?>" 
             alt="<?= htmlspecialchars($heroAltText) ?>" 
             class="hero__image"
             loading="eager"
             decoding="async">
    </div>
</section>
