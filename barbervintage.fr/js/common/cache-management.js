/**
 * Cache Management Global - Vintage Barber Shop
 * Script optimisé pour gérer le cache sans surcharge
 */

// Fonction principale de rafraîchissement du cache
function globalCacheRefresh() {
    const timestamp = Date.now();
    
    console.log("🔄 Rafraîchissement cache démarré");
    
    // 1. Rafraîchir seulement les images hero et galerie
    refreshSpecificImages(timestamp);
    
    // 2. Vider le localStorage si utilisé  
    if (typeof(Storage) !== "undefined") {
        localStorage.removeItem('hero_cache');
        localStorage.removeItem('gallery_cache');
    }
    
    console.log("✅ Rafraîchissement terminé");
}

// Rafraîchir seulement les images spécifiques
function refreshSpecificImages(timestamp) {
    const selectors = [
        'img[src*="assets/hero/"]',
        'img[src*="assets/gallery/"]'
    ];
    
    selectors.forEach(selector => {
        document.querySelectorAll(selector).forEach(img => {
            const baseUrl = img.src.split('?')[0];
            img.src = baseUrl + '?v=' + timestamp;
        });
    });
}

// Exécution uniquement si explicitement demandée
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    
    if (urlParams.get('cache_refresh') || urlParams.get('force_reload')) {
        console.log("🔄 Paramètre de rafraîchissement détecté");
        setTimeout(globalCacheRefresh, 500);
    }
});

// Exposer la fonction globalement pour utilisation manuelle
window.globalCacheRefresh = globalCacheRefresh;
