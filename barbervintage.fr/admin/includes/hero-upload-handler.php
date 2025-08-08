<?php
/**
 * Handler pour l'upload de l'image hero
 * Vintage Barber Shop - Admin Panel
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['hero_file'])) {
    
    // Sécurité: Vérifier session admin
    if (!isset($_SESSION['admin_id'])) {
        $hero_message = "Erreur: Session admin expirée. Reconnectez-vous.";
        $hero_message_type = "error";
        return;
    }
    
    // Vérifier les erreurs d'upload
    if ($_FILES['hero_file']['error'] !== 0) {
        $error_messages = [
            UPLOAD_ERR_INI_SIZE => 'Fichier trop volumineux.',
            UPLOAD_ERR_FORM_SIZE => 'Fichier trop volumineux.',
            UPLOAD_ERR_PARTIAL => 'Upload partiel.',
            UPLOAD_ERR_NO_FILE => 'Aucun fichier sélectionné.',
            UPLOAD_ERR_NO_TMP_DIR => 'Dossier temporaire manquant.',
            UPLOAD_ERR_CANT_WRITE => 'Impossible d\'écrire le fichier.',
            UPLOAD_ERR_EXTENSION => 'Extension PHP bloque l\'upload.'
        ];
        
        $hero_message = $error_messages[$_FILES['hero_file']['error']] ?? 'Erreur inconnue.';
        $hero_message_type = "error";
        return;
    }
    
    $upload_dir = "../assets/hero/";
    $allowed_types = ['image/jpeg', 'image/png', 'image/webp'];
    
    // Vérifier le type de fichier
    if (!in_array($_FILES["hero_file"]["type"], $allowed_types)) {
        $hero_message = "Type de fichier non autorisé. Utilisez JPG, PNG ou WebP.";
        $hero_message_type = "error";
        return;
    }
    
    // Créer le dossier si nécessaire
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    
    // Vérifier les permissions d'écriture
    if (!is_writable($upload_dir)) {
        $hero_message = "Dossier non accessible en écriture.";
        $hero_message_type = "error";
        return;
    }
    
    $target_file = $upload_dir . "hero.jpg";
    
    // Supprimer l'ancien fichier
    if (file_exists($target_file)) {
        unlink($target_file);
    }
    
    // Déplacer le fichier
    if (move_uploaded_file($_FILES["hero_file"]["tmp_name"], $target_file)) {
        
        // Mettre à jour la base de données
        try {
            $alt_text = $_POST['hero_alt_text'] ?? 'Image hero - Vintage Barber Shop';
            $file_path = 'assets/hero/hero.jpg';
            
            // Utiliser INSERT ... ON DUPLICATE KEY UPDATE pour gérer l'insertion/mise à jour
            $stmt = $pdo->prepare("
                INSERT INTO hero_content (id, filename, alt_text, file_path) 
                VALUES (1, ?, ?, ?)
                ON DUPLICATE KEY UPDATE 
                    filename = VALUES(filename),
                    alt_text = VALUES(alt_text),
                    file_path = VALUES(file_path)
            ");
            
            $result = $stmt->execute(['hero.jpg', $alt_text, $file_path]);
            
            if ($result) {
                // Inclure les utilitaires de cache
                require_once '../includes/cache-utils.php';
                
                // Rafraîchir le cache global
                refreshAssetCache();
                
                // Ajouter des headers pour forcer le rafraîchissement
                addImageRefreshHeaders();
                
                // Redirection pour éviter les problèmes de cache avec timestamp unique
                $cacheParam = time();
                header("Location: dashboard.php?hero_updated=" . $cacheParam . "&cache_refresh=1&force_reload=" . $cacheParam);
                exit;
            } else {
                $hero_message = "Erreur lors de la mise à jour en base de données.";
                $hero_message_type = "error";
                
                // Debug: Vérifier la structure de la table
                error_log("=== DEBUG BDD ===");
                try {
                    $tables = $pdo->query("SHOW TABLES LIKE 'hero_content'")->fetchAll();
                    error_log("Table hero_content existe: " . (count($tables) > 0 ? 'OUI' : 'NON'));
                    
                    if (count($tables) > 0) {
                        $structure = $pdo->query("DESCRIBE hero_content")->fetchAll();
                        error_log("Structure hero_content: " . print_r($structure, true));
                    }
                } catch (Exception $e) {
                    error_log("Erreur debug BDD: " . $e->getMessage());
                }
            }
            
        } catch (PDOException $e) {
            $hero_message = "Erreur base de données: " . $e->getMessage();
            $hero_message_type = "error";
            error_log("Erreur PDO upload hero: " . $e->getMessage());
        }
        
    } else {
        $hero_message = "Erreur lors de l'upload du fichier.";
        $hero_message_type = "error";
    }
}
?>
