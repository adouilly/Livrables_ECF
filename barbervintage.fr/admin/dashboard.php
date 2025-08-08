<?php
/**
 * Tableau de bord admin - Vintage Barber Shop
 * Panneau d'administration principal pour gérer le contenu du site
 */

// Ajouter des headers pour éviter le cache
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

// Initialisation de la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Vérifier le timeout d'inactivité (2 minutes = 120 secondes)
$inactivity_timeout = 120;
if (isset($_SESSION['admin_last_activity']) && (time() - $_SESSION['admin_last_activity'] > $inactivity_timeout)) {
    session_unset();
    session_destroy();
    header('Location: login.php?session_expired=1');
    exit;
}

// Mettre à jour le timestamp de dernière activité
$_SESSION['admin_last_activity'] = time();

// Inclusion de la configuration
require_once '../includes/config.php';

// Variables globales
$db = $pdo;
$hero_message = '';
$hero_message_type = '';

// Vérifier si on revient d'un upload réussi
if (isset($_GET['hero_updated'])) {
    $hero_message = "Image hero mise à jour avec succès !";
    $hero_message_type = "success";
    
    // Ajouter des headers pour forcer le rafraîchissement
    require_once '../includes/cache-utils.php';
    addNoCacheHeaders();
}

// Fonction countGalleryImages
if (!function_exists('countGalleryImages')) {
    function countGalleryImages() {
        global $db;
        try {
            $query = $db->query("SELECT COUNT(*) FROM gallery_images");
            return $query->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur countGalleryImages: " . $e->getMessage());
            return 0;
        }
    }
}

// Traitement de l'upload hero
require_once 'includes/hero-upload-handler.php';

// Récupérer les données
$admin_id = $_SESSION['admin_id'];
$admin_username = $_SESSION['admin_username'];
$gallery_count = countGalleryImages();
$hero_content = getHeroContent();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Vintage Barber Shop</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="../css/common/reset.css">
    <link rel="stylesheet" href="../css/common/variables.css">
    <link rel="stylesheet" href="../css/back/back.css">
    <link rel="stylesheet" href="../css/back/back-content.css">
    <link rel="stylesheet" href="../css/back/hero-management.css">
    
    <!-- Favicon -->
    <link rel="icon" href="../assets/favicon/favicon.png" type="image/png">
</head>
<body class="admin-page">
    
    <!-- Header Admin -->
    <?php include 'templates/header.php'; ?>

    <!-- Contenu principal -->
    <main class="admin-main">
        
        <!-- Barre info admin -->
        <?php include 'templates/admin-info-bar.php'; ?>
        
        <!-- Dashboard container -->
        <div class="dashboard-container">
            
            <!-- Section Infos -->
            <?php include 'templates/sections/info-section.php'; ?>
            
            <!-- Gestion Hero -->
            <?php include 'templates/sections/hero-section.php'; ?>
            
            <!-- Titre Galerie indépendant -->
            <h2 class="dashboard-title-standalone">Gestion Galerie</h2>
            
            <!-- Gestion Galerie -->
            <?php include 'templates/sections/gallery-section.php'; ?>
            
        </div>
    </main>

    <!-- Footer -->
    <?php include 'templates/footer.php'; ?>

    <!-- JavaScript -->
    <script src="../js/common/cache-management.js"></script>
    <script src="../js/back/dashboard.js"></script>
    <script src="../js/back/hero-upload.js"></script>
    <script src="../js/back/gallery-management.js"></script>
</body>
</html>
