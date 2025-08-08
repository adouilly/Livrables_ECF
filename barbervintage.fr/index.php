<?php
/* ========================================
   INDEX.PH    <!-- Header -->
    <?php include 'templates/front/header.php'; ?>
    
    <!-- Hero Section -->
    <?php include 'templates/front/hero.php'; ?>
    
    <!-- Animation Tondeuse (élément indépendant) -->
    <div class="header__tondeuse-animation">
        <img src="assets/img/tondeuse.png" 
             alt="Tondeuse" 
             class="header__tondeuse-img">
    </div>
    
    <!-- Conteneur principal -->
    <main class="main-contenu"">BARBER SHOP
   Point d'entrée principal du site
   ======================================== */

// Inclusion de la configuration de base de données
require_once 'includes/config.php';

// Récupération des données depuis la base
$heroContent = getHeroContent();
$galleryImages = recupererImagesGalerie();

// Configuration et variables du site
$site_title = "VINTAGE BARBER SHOP";
$site_description = "L'art du rasage depuis 1950";
$current_page = "accueil";

// Variables pour le header
$header_type = "front"; // front ou admin
$show_animations = true; // Animations activées
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title ?> - <?= $site_description ?></title>
    
    <!-- Meta SEO -->
    <meta name="description" content="<?= $site_description ?>">
    <meta name="keywords" content="barbier, vintage, rasage, coupe, traditionnel">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/common/variables.css">
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/front/header.css">
    <link rel="stylesheet" href="css/front/hero.css">
    <link rel="stylesheet" href="css/front/services.css">
    <link rel="stylesheet" href="css/front/gallery.css">
    <link rel="stylesheet" href="css/features/tondeuse-animation.css">
    <link rel="stylesheet" href="css/front/front.css">
    <link rel="stylesheet" href="css/front/footer.css">
    
    <!-- Force masquer scrollbar (sécurité) -->
    <style>
        html, body, * {
            scrollbar-width: none !important;
            -ms-overflow-style: none !important;
        }
        ::-webkit-scrollbar {
            width: 0 !important;
            height: 0 !important;
            display: none !important;
        }
    </style>
    
    <!-- JavaScript (defer pour performance) -->
    <script src="js/common/cache-management.js" defer></script>
    <script src="js/common/utils.js" defer></script>
    <script src="js/front/header-navigation.js" defer></script>
    <script src="js/front/header-animations.js" defer></script>
    <script src="js/front/mobile-scroll-behavior.js" defer></script>
    <script src="templates/front/gallery-dynamic.php" defer></script>
    <script src="js/front/flip-box-interaction.js" defer></script>
    <script src="js/front/contact-form.js" defer></script>
    
    <!-- Script pour forcer le scroll en haut au chargement -->
    <script>
        // Force le scroll en haut à chaque chargement/rechargement
        if ('scrollRestoration' in history) {
            history.scrollRestoration = 'manual';
        }
        window.addEventListener('beforeunload', function() {
            window.scrollTo(0, 0);
        });
        window.addEventListener('load', function() {
            setTimeout(function() {
                window.scrollTo(0, 0);
            }, 0);
        });
    </script>
    
</head>
<body class="front-page">
    
    <!-- Header -->
    <?php include 'templates/front/header.php'; ?>
    
    <!-- Hero Section -->
    <?php include 'templates/front/hero.php'; ?>
    
    <!-- Animation Tondeuse (élément indépendant) -->
    <div class="header__tondeuse-animation">
        <img src="assets/img/tondeuse.png" 
             alt="Tondeuse" 
             class="header__tondeuse-img">
    </div>
    
    <!-- Conteneur principal -->
    <main class="main-content">
        
        <!-- Section Services -->
        <?php include 'templates/front/services.php'; ?>
        
        <!-- Section Gallery -->
        <?php include 'templates/front/gallery.php'; ?>
        
        <!-- Section Contact -->
        <?php include 'templates/front/contact.php'; ?>
        
    </main>
    
    <!-- Bouton retour en haut -->
    <?php include 'templates/components/scroll-top-button.php'; ?>


    <!-- Footer -->
    <?php include 'templates/front/footer.php'; ?>

</body>
</html>