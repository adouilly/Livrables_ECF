<?php
/**
 * Fonctions pour le back-office de Vintage Barber Shop
 * Fonctions partagées pour la gestion des contenus
 */

// Fonction pour récupérer le contenu hero
if (!function_exists('getHeroContent')) {
    function getHeroContent() {
        global $db;
        try {
            $query = "SELECT id, filename, alt_text, CONCAT('uploads/hero/', filename) as hero_image_path, 
                    DATE_FORMAT(created_at, '%d/%m/%Y à %H:%i') as created_date, 
                    DATE_FORMAT(updated_at, '%d/%m/%Y à %H:%i') as updated_date 
                    FROM hero_images 
                    ORDER BY id DESC LIMIT 1";
            $stmt = $db->query($query);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erreur getHeroContent: " . $e->getMessage());
            return false;
        }
    }
}

// Fonction pour compter les images hero
if (!function_exists('countHeroImages')) {
    function countHeroImages() {
        global $db;
        try {
            $query = $db->query("SELECT COUNT(*) FROM hero_images");
            return $query->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur countHeroImages: " . $e->getMessage());
            return 0;
        }
    }
}

// Fonction pour compter les images de la galerie
if (!function_exists('countGalleryImages')) {
    function countGalleryImages() {
        global $db;
        try {
            $query = $db->query("SELECT COUNT(*) FROM gallery_images");
            return $query->fetchColumn();
        } catch (PDOException $e) {
            error_log("Erreur countGalleryImages: " . $e->getMessage());
            return 0;
        }
    }
}

// Fonction pour récupérer toutes les images de la galerie
if (!function_exists('getAllGalleryImages')) {
    function getAllGalleryImages() {
        global $db;
        try {
            $query = $db->query("SELECT * FROM gallery_images ORDER BY position ASC, id DESC");
            return $query->fetchAll();
        } catch (PDOException $e) {
            error_log("Erreur getAllGalleryImages: " . $e->getMessage());
            return [];
        }
    }
}

// Fonction pour mettre à jour l'image hero
if (!function_exists('mettreAJourImageHero')) {
    function mettreAJourImageHero($nomFichier) {
        global $db;
        try {
            // Vérifie si une image hero existe déjà
            $countQuery = $db->query("SELECT COUNT(*) FROM hero_images");
            $count = $countQuery->fetchColumn();
            
            if ($count > 0) {
                // Mise à jour de l'image existante
                $query = $db->prepare("UPDATE hero_images SET filename = ?, updated_at = NOW() WHERE id = (SELECT id FROM (SELECT id FROM hero_images ORDER BY id DESC LIMIT 1) AS temp)");
                return $query->execute([$nomFichier]);
            } else {
                // Ajout d'une nouvelle image
                $query = $db->prepare("INSERT INTO hero_images (filename, created_at, updated_at) VALUES (?, NOW(), NOW())");
                return $query->execute([$nomFichier]);
            }
        } catch (PDOException $e) {
            error_log("Erreur mettreAJourImageHero: " . $e->getMessage());
            return false;
        }
    }
}

// Fonction pour ajouter une image à la galerie
if (!function_exists('addGalleryImage')) {
    function addGalleryImage($filename, $title, $alt) {
        global $db;
        try {
            // Déterminer la prochaine position
            $positionQuery = $db->query("SELECT MAX(position) FROM gallery_images");
            $maxPosition = $positionQuery->fetchColumn();
            $nextPosition = ($maxPosition !== null) ? $maxPosition + 1 : 1;
            
            // Insérer la nouvelle image
            $query = $db->prepare("INSERT INTO gallery_images (filename, title, alt_text, position, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            return $query->execute([$filename, $title, $alt, $nextPosition]);
        } catch (PDOException $e) {
            error_log("Erreur addGalleryImage: " . $e->getMessage());
            return false;
        }
    }
}

// Fonction pour supprimer une image de la galerie
if (!function_exists('deleteGalleryImage')) {
    function deleteGalleryImage($imageId) {
        global $db;
        try {
            // Récupérer le nom de fichier pour le supprimer du serveur
            $fileQuery = $db->prepare("SELECT filename FROM gallery_images WHERE id = ?");
            $fileQuery->execute([$imageId]);
            $filename = $fileQuery->fetchColumn();
            
            // Supprimer l'entrée de la base de données
            $query = $db->prepare("DELETE FROM gallery_images WHERE id = ?");
            $result = $query->execute([$imageId]);
            
            // Si la suppression en base réussit, supprimer le fichier physique
            if ($result && $filename) {
                $filePath = '../uploads/gallery/' . $filename;
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            
            return $result;
        } catch (PDOException $e) {
            error_log("Erreur deleteGalleryImage: " . $e->getMessage());
            return false;
        }
    }
}

// Fonction générique pour exécuter des requêtes SQL
if (!function_exists('executeQuery')) {
    function executeQuery($sql, $params = []) {
        global $db;
        try {
            $stmt = $db->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        } catch (PDOException $e) {
            // Log error
            error_log("Erreur SQL: " . $e->getMessage());
            return false;
        }
    }
}
