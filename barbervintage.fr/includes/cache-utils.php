<?php
/**
 * Utilitaires pour la gestion du cache
 * Vintage Barber Shop
 */

/**
 * Générer un paramètre de cache busting basé sur le timestamp du fichier
 * @param string $filePath Le chemin relatif du fichier depuis la racine web
 * @return string Le paramètre de cache (ex: "?v=1672531200")
 */
function getCacheBustingParam($filePath) {
    $fullPath = __DIR__ . '/../' . $filePath;
    
    if (file_exists($fullPath)) {
        $timestamp = filemtime($fullPath);
        return '?v=' . $timestamp;
    }
    
    // Fallback avec timestamp actuel si fichier introuvable
    return '?v=' . time();
}

/**
 * Générer une URL avec cache busting
 * @param string $filePath Le chemin relatif du fichier
 * @return string L'URL complète avec paramètre de cache
 */
function getAssetUrl($filePath) {
    return $filePath . getCacheBustingParam($filePath);
}

/**
 * Forcer le rafraîchissement du cache pour tous les assets
 * Appelé après les uploads d'images
 */
function refreshAssetCache() {
    // Vider le cache opcode PHP si disponible
    if (function_exists('opcache_reset')) {
        opcache_reset();
    }
    
    // Optionnel : Enregistrer un timestamp global de dernière modification
    $cacheFile = __DIR__ . '/cache_timestamp.txt';
    file_put_contents($cacheFile, time());
}

/**
 * Obtenir le timestamp global de cache
 * @return int Le timestamp de dernière modification globale
 */
function getGlobalCacheTimestamp() {
    $cacheFile = __DIR__ . '/cache_timestamp.txt';
    
    if (file_exists($cacheFile)) {
        return (int) file_get_contents($cacheFile);
    }
    
    return time();
}

/**
 * Ajouter des headers pour forcer le rafraîchissement du cache navigateur
 */
function addNoCacheHeaders() {
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Last-Modified: " . gmdate('D, d M Y H:i:s') . ' GMT');
}

/**
 * Ajouter des headers spécifiques pour les images après upload
 */
function addImageRefreshHeaders() {
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
    header("Last-Modified: " . gmdate('D, d M Y H:i:s') . ' GMT');
    header("ETag: " . md5(time()));
}

/**
 * Ajouter des headers pour un cache optimal des assets
 * @param int $maxAge Durée de cache en secondes (par défaut 1 heure)
 */
function addAssetCacheHeaders($maxAge = 3600) {
    header("Cache-Control: public, max-age=$maxAge");
    header("Expires: " . gmdate('D, d M Y H:i:s', time() + $maxAge) . ' GMT');
}
?>
