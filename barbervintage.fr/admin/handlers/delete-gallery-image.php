<?php
/**
 * Gestionnaire AJAX pour la suppression d'images de galerie
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

// Récupérer et valider l'ID de l'image à supprimer
$image_id = intval($_POST['image_id'] ?? 0);

if ($image_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID image invalide']);
    exit;
}

// Vérifier que l'admin est bien connecté avec un ID valide
$admin_id = intval($_SESSION['admin_id'] ?? 0);
if ($admin_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Session admin invalide']);
    exit;
}

try {
    // Récupérer les informations de l'image avant suppression
    $stmt = $pdo->prepare("SELECT filename, file_path FROM gallery_images WHERE id = ?");
    $stmt->execute([$image_id]);
    $image = $stmt->fetch();
    
    if (!$image) {
        echo json_encode(['success' => false, 'message' => 'Image non trouvée']);
        exit;
    }
    
    // Supprimer le fichier physique
    $file_path = "../../assets/gallery/" . $image['filename'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
    
    // Supprimer l'enregistrement de la base de données
    $stmt = $pdo->prepare("DELETE FROM gallery_images WHERE id = ?");
    $result = $stmt->execute([$image_id]);
    
    if ($result && $stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Image supprimée avec succès']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erreur lors de la suppression en base']);
    }
    
} catch (PDOException $e) {
    error_log("Erreur suppression image galerie: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Erreur serveur']);
}
?>
