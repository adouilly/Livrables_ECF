/* ========================================
   FLIP BOX INTERACTION - VINTAGE BARBER SHOP
   JavaScript pour gérer les clics sur mobile
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // VARIABLES ET ÉLÉMENTS
    // ========================================
    
    const flipContainer = document.querySelector('.services__flip-container');
    const flipCard = document.querySelector('.services__flip-card');
    
    let isFlipped = false;
    
    // ========================================
    // DÉTECTION DU TYPE D'APPAREIL
    // ========================================
    
    function isMobileDevice() {
        return window.innerWidth <= 767 || 'ontouchstart' in window;
    }
    
    // ========================================
    // GESTION DES CLICS SUR MOBILE
    // ========================================
    
    function handleFlipBoxClick(event) {
        // Seulement sur mobile ou touch devices
        if (!isMobileDevice()) return;
        
        // Forcer la gestion de l'état plutôt que de basculer
        if (isFlipped) {
            // Si déjà retourné, revenir à l'état initial
            isFlipped = false;
            flipCard.classList.remove('flipped');
        } else {
            // Si non retourné, basculer
            isFlipped = true;
            flipCard.classList.add('flipped');
        }
        
        // Pour s'assurer que l'événement ne se propage pas
        event.stopPropagation();
    }
    
    // ========================================
    // RÉINITIALISATION SUR REDIMENSIONNEMENT
    // ========================================
    
    function handleResize() {
        // Réinitialiser l'état si on passe de mobile à desktop
        if (!isMobileDevice() && isFlipped) {
            flipCard.classList.remove('flipped');
            isFlipped = false;
        }
    }
    
    // ========================================
    // INITIALISATION
    // ========================================
    
    if (flipContainer && flipCard) {
        // Event listener pour les clics - non passif pour permettre le toggle sur mobile
        flipContainer.addEventListener('click', handleFlipBoxClick, { passive: false });
        
        // Gestionnaire touchend pour mobile avec option non-passive
        flipContainer.addEventListener('touchend', function(e) {
            e.preventDefault(); // Empêche le comportement par défaut
            handleFlipBoxClick(e);
        }, { passive: false });
        
        // Event listener pour le redimensionnement
        window.addEventListener('resize', handleResize);
        
    } else {
        console.warn('⚠️ Éléments flip box non trouvés');
    }
    
});
