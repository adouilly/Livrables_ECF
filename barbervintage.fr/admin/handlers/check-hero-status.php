<?php
session_start();

// Vérification authentification admin
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

require_once '../../includes/config.php';

try {
    // Vérifier le statut de la section hero
    $heroContent = getHeroContent();
    
    $response = [
        'success' => true,
        'hero_configured' => !empty($heroContent['title']) && !empty($heroContent['subtitle']),
        'hero_image' => !empty($heroContent['background_image']),
        'data' => $heroContent
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    
} catch (Exception $e) {
    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false,
        'error' => 'Erreur lors de la vérification du statut hero'
    ]);
}
?>
