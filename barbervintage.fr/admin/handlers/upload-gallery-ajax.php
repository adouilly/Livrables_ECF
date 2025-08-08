<?php
/**
 * Gestionnaire AJAX pour l'upload inline d'images de galerie
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

// Vérifier les fichiers uploadés
if (!isset($_FILES['gallery_files']) || empty($_FILES['gallery_files']['name'][0])) {
    echo json_encode(['success' => false, 'message' => 'Aucun fichier sélectionné']);
    exit;
}

$upload_dir = "../../assets/gallery/";
$allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
$uploaded_count = 0;
$errors = [];

// Créer le dossier si nécessaire
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// Gérer les uploads multiples
$files = $_FILES['gallery_files'];
$file_count = count($files['name']);

// Obtenir le prochain display_order
try {
    $stmt = $pdo->prepare("SELECT MAX(display_order) as max_order FROM gallery_images");
    $stmt->execute();
    $result = $stmt->fetch();
    $next_order = ($result['max_order'] ?? 0) + 1;
    
    // Log pour debug
    error_log("Upload galerie - Prochain display_order: " . $next_order);
} catch (PDOException $e) {
    $next_order = 1;
    error_log("Erreur récupération max display_order: " . $e->getMessage());
}

for ($i = 0; $i < $file_count; $i++) {
    // Vérifier les erreurs d'upload
    if ($files['error'][$i] !== 0) {
        $errors[] = "Erreur upload fichier " . ($i + 1);
        continue;
    }
    
    // Vérifier le type de fichier
    if (!in_array($files['type'][$i], $allowed_types)) {
        $errors[] = "Type de fichier non autorisé pour " . $files['name'][$i];
        continue;
    }
    
    // Vérifier la taille (max 5MB)
    if ($files['size'][$i] > 5 * 1024 * 1024) {
        $errors[] = "Fichier trop volumineux: " . $files['name'][$i];
        continue;
    }
    
    // Générer un nom de fichier unique
    $extension = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
    $filename = "gallery-" . time() . "-" . $i . "." . $extension;
    $target_file = $upload_dir . $filename;
    
    // Déplacer le fichier
    if (move_uploaded_file($files['tmp_name'][$i], $target_file)) {
        
        // Ajouter en base de données
        try {
            $alt_text = "Image galerie - Vintage Barber Shop";
            $file_path = "assets/gallery/" . $filename;
            
            $stmt = $pdo->prepare("INSERT INTO gallery_images (filename, alt_text, display_order, file_path) VALUES (?, ?, ?, ?)");
            $result = $stmt->execute([$filename, $alt_text, $next_order, $file_path]);
            
            if ($result) {
                $uploaded_count++;
                error_log("Image galerie uploadée: " . $filename . " avec display_order: " . $next_order);
                $next_order++;
            } else {
                $errors[] = "Erreur BDD pour " . $files['name'][$i];
                error_log("Erreur BDD pour " . $filename);
            }
            
        } catch (PDOException $e) {
            $errors[] = "Erreur base de données: " . $e->getMessage();
            error_log("Erreur PDO upload galerie: " . $e->getMessage());
        }
        
    } else {
        $errors[] = "Erreur déplacement fichier " . $files['name'][$i];
    }
}

// Préparer la réponse
$response = [
    'success' => $uploaded_count > 0,
    'uploaded_count' => $uploaded_count,
    'total_files' => $file_count,
    'errors' => $errors
];

if ($uploaded_count > 0) {
    // Rafraîchir le cache après un upload réussi
    require_once '../../includes/cache-utils.php';
    refreshAssetCache();
    
    $response['message'] = "$uploaded_count image(s) ajoutée(s) avec succès";
    $response['cache_refreshed'] = true;
    error_log("Cache rafraîchi après upload de $uploaded_count images dans la galerie");
    
    if (!empty($errors)) {
        $response['message'] .= " (avec quelques erreurs)";
    }
} else {
    $response['message'] = "Aucune image n'a pu être uploadée";
    error_log("Aucune image uploadée - Erreurs: " . implode(', ', $errors));
}

echo json_encode($response);
?>
