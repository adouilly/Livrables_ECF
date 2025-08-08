<?php
/**
 * Script de déconnexion - Vintage Barber Shop
 * Déconnecte l'administrateur et détruit la session
 */

// Initialiser la session
session_start();

// Détruire toutes les variables de session
$_SESSION = array();

// Détruire le cookie de session si utilisé
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion avec un message approprié
$message = isset($_GET['timeout']) ? 'timeout=1' : 'logout=1';
header("Location: login.php?$message");
exit;
