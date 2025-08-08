<?php
/* ========================================
   MENTIONS LÉGALES - VINTAGE BARBER SHOP
   ======================================== */

// Variables du site - pas besoin d'inclure config.php car c'est une page statique
$site_title = "VINTAGE BARBER SHOP";
$site_description = "Mentions légales";
$current_page = "mentionlegales";

// Variables pour le header
$header_type = "front"; // front ou admin
$show_animations = false; // Animations désactivées sur cette page
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $site_title ?> - <?= $site_description ?></title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Mentions légales du salon de coiffure Vintage Barber Shop à Paris">
    <meta name="keywords" content="barbier, vintage, rasage, coupe, traditionnel, mentions légales">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/favicon/favicon.png" type="image/png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="css/common/variables.css">
    <link rel="stylesheet" href="css/common/reset.css">
    <link rel="stylesheet" href="css/front/header.css">
    <link rel="stylesheet" href="css/front/front.css">
    <link rel="stylesheet" href="css/front/footer.css">
    
    <style>
        /* Styles spécifiques pour la page des mentions légales */
        .legal-page {
            padding: 80px 20px;
            width: 100%;
            margin: 0;
            background-color: var(--color-white);
            min-height: 60vh;
            box-sizing: border-box;
        }
        
        .legal-page__title {
            font-family: var(--font-principal);
            font-size: 2.2rem;
            font-weight: var(--font-weight-bold);
            color: var(--color-tertiary);
            margin-bottom: 40px;
            text-transform: uppercase;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            border-bottom: 2px solid var(--color-primary);
            padding-bottom: 20px;
            width: 100%;
        }
        
        .legal-page__content {
            font-family: var(--font-text);
            color: var(--color-text);
            line-height: 1.6;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .legal-page__content p {
            margin-bottom: 20px;
            width: 100%;
        }
        
        .legal-page__content strong {
            color: var(--color-tertiary);
            font-weight: var(--font-weight-bold);
        }
        
        .back-link-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        
        .back-link {
            display: inline-block;
            padding: 12px 25px;
            background-color: var(--color-primary);
            color: var(--color-tertiary);
            text-decoration: none;
            font-family: var(--font-text);
            font-weight: var(--font-weight-bold);
            border-radius: 25px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .back-link:hover {
            background-color: var(--color-tertiary);
            color: var(--color-primary);
        }
    </style>
    
    <!-- JavaScript (defer pour performance) -->
    <script src="js/common/utils.js" defer></script>
    <script src="js/front/header-navigation.js" defer></script>
    <script src="js/front/mentionlegales.js" defer></script>
</head>
<body class="page-mentions-legales">
    
    <!-- Header -->
    <!-- Header -->
    <?php include 'templates/front/header.php'; ?>

    <!-- Conteneur principal -->
    <main class="main-content">
        <section class="legal-page">
            <h1 class="legal-page__title">Mentions Légales</h1>
            <div class="legal-page__content">
                <p><strong>Éditeur du site :</strong><br>
                Vintage Barber Shop<br>
                123 Rue du Barbier, 75000 Paris<br>
                Email : contact@barbervintage.fr<br>
                Téléphone : 01 23 45 67 89</p>
                
                <p><strong>Directeur de la publication :</strong><br>
                Monsieur Jean Dupont</p>
                
                <p><strong>Hébergement :</strong><br>
                OVH SAS<br>
                2 rue Kellermann, 59100 Roubaix, France<br>
                Téléphone : 1007</p>
                
                <p><strong>Propriété intellectuelle :</strong><br>
                L'ensemble des contenus (textes, images, logos, etc.) présents sur ce site sont la propriété exclusive de Vintage Barber Shop. Toute reproduction, représentation, modification, publication, adaptation de tout ou partie des éléments du site, quel que soit le moyen ou le procédé utilisé, est interdite, sauf autorisation écrite préalable.</p>
                
                <p><strong>Données personnelles :</strong><br>
                Les informations recueillies via les formulaires sont destinées uniquement à Vintage Barber Shop et ne sont en aucun cas transmises à des tiers. Conformément à la loi « Informatique et Libertés », vous disposez d'un droit d'accès, de rectification et de suppression des données vous concernant. Pour exercer ce droit, contactez-nous à l'adresse ci-dessus.</p>
                
                <p><strong>Cookies :</strong><br>
                Ce site utilise des cookies à des fins de statistiques et d'amélioration de l'expérience utilisateur. Vous pouvez configurer votre navigateur pour refuser les cookies.</p>
                
                <p><strong>Responsabilité :</strong><br>
                Vintage Barber Shop ne saurait être tenu responsable des dommages directs ou indirects causés au matériel de l'utilisateur lors de l'accès au site.</p>
                
                <div class="back-link-container">
                    <a href="index.php" class="back-link">Retour à l'accueil</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php include 'templates/front/footer.php'; ?>
    
    <!-- Pas besoin de scripts supplémentaires car ils sont déjà chargés dans le head -->
</body>
</html>
