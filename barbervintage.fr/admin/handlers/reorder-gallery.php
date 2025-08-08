<?php
/**
 * Gestionnaire AJAX pour réorganiser l'ordre des images de galerie
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

// Récupérer les données JSON
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['order']) || !is_array($input['order'])) {
    echo json_encode(['success' => false, 'message' => 'Données invalides']);
    exit;
}

try {
    // Commencer une transaction
    $pdo->beginTransaction();
    
    // Mettre à jour l'ordre de chaque image
    foreach ($input['order'] as $index => $image_id) {
        $new_order = $index + 1;
        $stmt = $pdo->prepare("UPDATE gallery_images SET display_order = ? WHERE id = ?");
        $stmt->execute([$new_order, intval($image_id)]);
    }
    
    // Valider la transaction
    $pdo->commit();
    
    echo json_encode(['success' => true, 'message' => 'Ordre mis à jour avec succès']);
    
} catch (PDOException $e) {
    // Annuler la transaction en cas d'erreur
    $pdo->rollBack();
    error_log("Erreur réorganisation galerie: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
?>
