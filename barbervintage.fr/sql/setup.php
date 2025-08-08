<?php
/**
 * Script de création des tables - Vintage Barber Shop
 * Exécutez ce script pour créer les tables nécessaires pour le site
 */

// Charger la configuration de la base de données
require_once '../includes/config.php';

// Utiliser la connexion PDO
$db = $pdo;

// Charger le contenu du fichier SQL
$sql = file_get_contents('images_tables.sql');

// Exécuter les requêtes SQL
try {
    $db->exec($sql);
    echo "Tables créées avec succès!";
} catch (PDOException $e) {
    echo "Erreur lors de la création des tables : " . $e->getMessage();
}
