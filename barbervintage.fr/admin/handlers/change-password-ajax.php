<?php
// Toujours renvoyer du JSON
header('Content-Type: application/json');
/**
 * Script AJAX pour changer le mot de passe admin
 * Vintage Barber Shop - Admin Panel
 */

session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Session expirée']);
    exit;
}

// Vérifier que c'est une requête POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    exit;
}

// Inclusion de la configuration
require_once '../../includes/config.php';

// Récupérer les données POST avec validation
$new_password = trim($_POST['new_password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

// Validation stricte
if (empty($new_password) || empty($confirm_password)) {
    echo json_encode(['success' => false, 'message' => 'Tous les champs sont requis']);
    exit;
}

if (strlen($new_password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe doit contenir au moins 6 caractères']);
    exit;
}

if (strlen($new_password) > 255) {
    echo json_encode(['success' => false, 'message' => 'Le mot de passe ne peut pas dépasser 255 caractères']);
    exit;
}

if ($new_password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Les mots de passe ne correspondent pas']);
    exit;
}

// Vérifier que l'admin_id est valide
$admin_id = intval($_SESSION['admin_id']);
if ($admin_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Session admin invalide']);
    exit;
}

try {
    // Hasher le nouveau mot de passe
    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
    
    // Mettre à jour le mot de passe en base avec requête préparée
    $stmt = $pdo->prepare("UPDATE admins SET password_hash = ? WHERE id = ?");
    $result = $stmt->execute([$password_hash, $admin_id]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Mot de passe mis à jour avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la mise à jour']);
    }
    
} catch (PDOException $e) {
    error_log("Erreur changement mot de passe: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
?>
