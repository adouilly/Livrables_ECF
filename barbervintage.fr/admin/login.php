<?php
/**
 * Page de connexion admin - Vintage Barber Shop
 * Permet aux administrateurs de se connecter au panneau d'administration
 */

// Initialisation de la session
session_start();

// Redirection si déjà connecté
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Inclusion de la configuration et fonctions
require_once '../includes/config.php';

// Variables pour les messages
$error_message = '';
$success_message = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    // Validation basique
    if (empty($username) || empty($password)) {
        $error_message = 'Tous les champs sont obligatoires';
    } else {
        // Vérification des identifiants
        $admin = checkAdminLogin($username, $password);
        
        if ($admin) {
            // Connexion réussie - Initialisation de la session
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_last_activity'] = time();
            
            // Redirection vers le dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            // Échec de connexion
            $error_message = 'Identifiants incorrects';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin - Vintage Barber Shop</title>
    <!-- Styles CSS -->
    <link rel="stylesheet" href="../css/common/reset.css">
    <link rel="stylesheet" href="../css/common/variables.css">
    <link rel="stylesheet" href="../css/back/login.css">
    <!-- Polices de caractères -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Grenze+Gotisch:wght@400;700&family=Kings&family=Nabla&family=Roboto:wght@400;700&family=Yatra+One&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="../assets/favicon/favicon.png" type="image/png">
</head>
<body class="login-page">
    <div class="login-container">
        <!-- Bloc flottant principal -->
        <div class="login-floating-block">
            <div class="login-header">
                <a href="../index.php" class="login-logo">
                    <img src="../assets/img/logo.png" alt="Vintage Barber Shop" class="logo-image">
                </a>
            </div>
            
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            
            <form class="login-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <div class="form-group">
                    <input type="text" id="username" name="username" 
                           value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" 
                           class="contact-style-input" 
                           placeholder="Nom d'utilisateur" 
                           required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" 
                           class="contact-style-input" 
                           placeholder="Mot de passe" 
                           required>
                </div>
                <button type="submit" class="contact-style-button">Se connecter</button>
            </form>
            
            <div class="login-footer">
                <a href="../index.php" class="back-to-site-btn">Retour au site</a>
            </div>
        </div>
    </div>
    
    <!-- JavaScript pour la sécurité et l'expérience utilisateur -->
    <script src="../js/back/login.js"></script>
</body>
</html>
