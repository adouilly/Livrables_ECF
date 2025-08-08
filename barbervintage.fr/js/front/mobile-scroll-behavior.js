/* ========================================
   COMPORTEMENT SCROLL & BOUTON TOP - VINTAGE BARBER SHOP
   JavaScript pour header rétractable fluide et scroll to top
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // VARIABLES ET ÉLÉMENTS
    // ========================================
    
    const header = document.querySelector('.header');
    const scrollTopBtn = document.querySelector('.bouton-retour-haut');
    
    let lastScrollY = window.scrollY;
    let isScrolling = false;
    let isHeaderRetracted = false;
    let headerClickListener = null;
    
    // Configuration
    const SCROLL_THRESHOLD = 100; // Seuil pour afficher le bouton
    const HEADER_HIDE_THRESHOLD = 80; // Seuil pour rétracter le header
    
    // ========================================
    // GESTION DU SCROLL POUR HEADER (TOUS FORMATS)
    // ========================================
    
    function handleScroll() {
        if (isScrolling) return;
        
        isScrolling = true;
        
        requestAnimationFrame(() => {
            const currentScrollY = window.scrollY;
            const scrollDirection = currentScrollY > lastScrollY ? 'down' : 'up';
            
            // Header rétractable sur tous les formats (mobile, tablette, desktop)
            handleHeaderBehavior(currentScrollY, scrollDirection);
            
            // Bouton retour en haut (toutes tailles d'écran)
            handleScrollTopButton(currentScrollY);
            
            lastScrollY = currentScrollY;
            isScrolling = false;
        });
    }
    
    // ========================================
    // COMPORTEMENT HEADER FLUIDE (TOUS FORMATS)
    // ========================================
    
    function handleHeaderBehavior(scrollY, direction) {
        if (!header) return;
        
        // Rétracter le header en scrollant vers le bas
        if (direction === 'down' && scrollY > HEADER_HIDE_THRESHOLD && !isHeaderRetracted) {
            retractHeader();
        }
        
        // Restaurer le header en scrollant vers le haut
        if (direction === 'up' && scrollY <= HEADER_HIDE_THRESHOLD && isHeaderRetracted) {
            restoreHeader();
        }
    }
    
    // ========================================
    // GESTION DE LA RÉTRACTION DU HEADER
    // ========================================
    
    function retractHeader() {
        if (!header || isHeaderRetracted) return;
        
        
        // Appliquer l'état rétracté
        header.classList.add('header--retracted');
        isHeaderRetracted = true;
        
        // Ajouter l'event listener pour le clic sur le header rétracté
        headerClickListener = function(event) {
            event.preventDefault();
            event.stopPropagation();
            restoreHeader();
        };
        
        header.addEventListener('click', headerClickListener);
        
        // Ajouter un indicateur visuel pour informer l'utilisateur
        header.setAttribute('title', 'Cliquez pour restaurer le header');
    }
    
    function restoreHeader() {
        if (!header || !isHeaderRetracted) return;
        
        
        // Retirer l'état rétracté
        header.classList.remove('header--retracted');
        isHeaderRetracted = false;
        
        // Retirer l'event listener
        if (headerClickListener) {
            header.removeEventListener('click', headerClickListener);
            headerClickListener = null;
        }
        
        // Retirer l'indicateur visuel
        header.removeAttribute('title');
    }
    
    // ========================================
    // GESTION BOUTON RETOUR EN HAUT
    // ========================================
    
    function handleScrollTopButton(scrollY) {
        if (!scrollTopBtn) return;
        
        // Afficher le bouton après le seuil
        if (scrollY > SCROLL_THRESHOLD) {
            scrollTopBtn.classList.add('bouton-retour-haut--visible');
        } else {
            scrollTopBtn.classList.remove('bouton-retour-haut--visible');
        }
    }
    
    // ========================================
    // RETOUR EN HAUT DE PAGE
    // ========================================
    
    function scrollToTop() {
        // Animation fluide vers le haut
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        
        // S'assurer que le header soit restauré après le retour en haut
        setTimeout(() => {
            if (header && isHeaderRetracted) {
                restoreHeader();
            }
        }, 100);
    }
    
    // ========================================
    // EVENT LISTENERS
    // ========================================
    
    // Écoute du scroll avec throttling
    let ticking = false;
    window.addEventListener('scroll', () => {
        if (!ticking) {
            requestAnimationFrame(() => {
                handleScroll();
                ticking = false;
            });
            ticking = true;
        }
    });
    
    // Clic sur le bouton retour en haut
    if (scrollTopBtn) {
        scrollTopBtn.addEventListener('click', scrollToTop);
    }
    
    // ========================================
    // GESTION DU REDIMENSIONNEMENT
    // ========================================
    
    window.addEventListener('resize', () => {
        // Conserver l'état du header lors du redimensionnement
        lastScrollY = window.scrollY;
        
        // Si le header est rétracté, s'assurer que les styles sont corrects
        if (isHeaderRetracted && header) {
            // Forcer une mise à jour des styles CSS
            header.classList.remove('header--retracted');
            setTimeout(() => {
                header.classList.add('header--retracted');
            }, 50);
        }
    });
    
    // ========================================
    // INITIALISATION
    // ========================================
    
    // État initial basé sur la position de scroll actuelle
    handleScroll();
    
    
});
