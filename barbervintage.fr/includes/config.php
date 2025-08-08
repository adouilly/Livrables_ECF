<?php
/**
 * Configuration de connexion à la base de données
 * Vintage Barber Shop - Base de données MySQL
 * 
 * ENVIRONNEMENT DE DÉVELOPPEMENT :
 * - Serveur : WAMP Server
 * - Apache : 2.4.62.1 (Port 80)
 * - PHP : 8.3.14 [Apache module] 
 * - MySQL : 9.1.0 (Port 3306)
 * - Virtual Host : barberdd
 * - Accès local : http://barberdd/
 */

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'vintage_barber_db');
define('DB_USER', 'root');
define('DB_PASS', ''); // WAMP par défaut : mot de passe vide

// Options PDO pour une connexion sécurisée
$pdo_options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4",
    PDO::ATTR_EMULATE_PREPARES => false
];

try {
    // Création de la connexion PDO
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        $pdo_options
    );
    
    // Alias pour compatibilité avec le code existant
    $db = $pdo;
    
    // Variable pour indiquer le statut de connexion (utilisée par JavaScript)
    $db_connection_status = true;
    
} catch (PDOException $e) {
    // Variable pour indiquer l'échec de connexion
    $db_connection_status = false;
    $db_error_message = $e->getMessage();
}

/**
 * Fonction helper pour exécuter une requête simple
 * @param string $query La requête SQL
 * @param array $params Les paramètres pour la requête préparée
 * @return PDOStatement
 */
function executeQuery($query, $params = []) {
    global $pdo;
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Fonction pour récupérer toutes les images de la galerie
 * @return array
 */
function recupererImagesGalerie() {
    // IMPORTANT: ORDER BY display_order pour respecter l'ordre défini dans l'admin
    $images = executeQuery("SELECT * FROM gallery_images ORDER BY display_order ASC, id ASC")->fetchAll();
    
    // Ajout du chemin complet pour chaque image
    foreach ($images as &$image) {
        // Assurer que le chemin commence par assets/gallery/
        $image['image_path'] = 'assets/gallery/' . $image['filename'];
    }
    
    return $images;
}

/**
 * Fonction pour récupérer le contenu hero
 * @return array|false
 */
function getHeroContent() {
    $heroData = executeQuery("SELECT * FROM hero_content LIMIT 1")->fetch();
    
    // Utiliser file_path s'il existe, sinon construire le chemin avec assets/hero/
    if ($heroData) {
        if (!empty($heroData['file_path'])) {
            $heroData['hero_image_path'] = $heroData['file_path'];
        } else {
            // Fallback si file_path est vide
            $heroData['hero_image_path'] = 'assets/hero/' . $heroData['filename'];
        }
    }
    
    return $heroData;
}

/**
 * Fonction pour vérifier les identifiants admin
 * @param string $username
 * @param string $password
 * @return array|false
 */
function checkAdminLogin($username, $password) {
    $stmt = executeQuery("SELECT * FROM admins WHERE username = ?", [$username]);
    $admin = $stmt->fetch();
    
    if ($admin && password_verify($password, $admin['password_hash'])) {
        return $admin;
    }
    return false;
}

/**
 * DÉVELOPPEMENT - Fonction pour générer les données de debug pour JavaScript
 */
function getDatabaseDebugData() {
    global $db_connection_status, $db_error_message;
    
    $debugData = [
        'connection' => $db_connection_status,
        'error' => isset($db_error_message) ? $db_error_message : null,
        'hero_status' => false,
        'hero_count' => 0,
        'gallery_status' => false,
        'gallery_count' => 0
    ];
    
    // Vérification Hero Content si connexion OK
    if ($db_connection_status) {
        try {
            $heroData = getHeroContent();
            if ($heroData && !empty($heroData['filename'])) {
                $debugData['hero_status'] = true;
                $debugData['hero_count'] = 1;
                $debugData['hero_image'] = $heroData['filename'];
                $debugData['hero_path'] = $heroData['file_path'] ?? 'assets/hero/';
            }
        } catch (Exception $e) {
            $debugData['hero_error'] = $e->getMessage();
        }
        
        // Vérification Gallery Images si connexion OK
        try {
            $galleryData = getGalleryImages();
            if (!empty($galleryData)) {
                $debugData['gallery_status'] = true;
                $debugData['gallery_count'] = count($galleryData);
                // Ajout des informations sur les chemins de fichiers
                $debugData['gallery_paths'] = array_column($galleryData, 'file_path');
                $debugData['gallery_files'] = array_column($galleryData, 'filename');
            }
        } catch (Exception $e) {
            $debugData['gallery_error'] = $e->getMessage();
        }
    }
    
    return $debugData;
}
?>
