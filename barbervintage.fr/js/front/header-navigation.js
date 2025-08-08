/* ========================================
   HEADER NAVIGATION - VINTAGE BARBER SHOP
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // === ÉLÉMENTS DOM ===
    const header = document.getElementById('header');
    const burgerBtn = document.getElementById('burger-btn');
    const burgerContainer = document.getElementById('burger-container');
    const mainNav = document.getElementById('main-nav');
    
    // Variables d'état
    let isMenuOpen = false;
    let tondeuseAnimationCompleted = false; // Nouvelle variable pour tracker l'animation
    
    // === INITIALISATION ===
    initializeHeader();
    setupEventListeners();
    
    /* ========================================
       INITIALISATION DU HEADER
       ======================================== */
    function initializeHeader() {
        // État initial du header
        header.classList.add('state-initial');
        mainNav.style.display = 'none';
        burgerContainer.style.display = 'flex';
    }
    
    /* ========================================
       ÉVÉNEMENTS
       ======================================== */
    function setupEventListeners() {
        // Clic sur le burger
        burgerBtn.addEventListener('click', handleBurgerClick);
        
        // Smooth scroll pour la navigation
        setupSmoothScroll();
    }
    
    /* ========================================
       GESTION DU CLIC BURGER
       ======================================== */
    function handleBurgerClick() {
        // Si l'animation tondeuse est terminée, le burger ne doit plus être cliquable
        if (tondeuseAnimationCompleted) {
            return;
        }
        
        if (!isMenuOpen) {
            openMenu();
        } else {
            closeMenu();
        }
    }
    
    /* ========================================
       OUVERTURE DU MENU
       ======================================== */
    function openMenu() {
        
        // ÉTAPE 1: Déclencher l'animation de la tondeuse vers la gauche
        const tondeuse = document.querySelector('.header__tondeuse-animation');
        if (tondeuse && !tondeuse.classList.contains('disappeared')) {
            // Supprimer les classes précédentes et remettre le flottement
            tondeuse.classList.remove('menu-closing');
            tondeuse.style.animation = 'float-gentle 3s ease-in-out infinite';
            tondeuse.classList.add('menu-triggered');
        } else if (tondeuse && tondeuse.classList.contains('disappeared')) {
        }
        
        // ÉTAPE 2: Masquer le burger immédiatement
        burgerContainer.style.transition = 'all 0.3s ease';
        burgerContainer.style.opacity = '0';
        burgerContainer.style.transform = 'scale(0.8)';
        
        setTimeout(() => {
            burgerContainer.style.display = 'none';
        }, 300);
        
        // ÉTAPE 3: Attendre que la tondeuse arrive au repère 10% (1200ms = durée transition CSS)
        setTimeout(() => {
            const tondeuse = document.querySelector('.header__tondeuse-animation');
            
            // Ne faire l'animation que si la tondeuse n'a pas déjà disparu
            if (tondeuse && !tondeuse.classList.contains('disappeared')) {
                
                // Afficher la navigation cachée derrière la tondeuse
                mainNav.style.display = 'flex';
                mainNav.style.opacity = '0';
                mainNav.style.transform = 'translateX(50px)';
                mainNav.setAttribute('aria-hidden', 'false');
                
                // Animation d'apparition du menu
                setTimeout(() => {
                    mainNav.style.transition = 'all 0.8s ease';
                    mainNav.style.opacity = '1';
                    mainNav.style.transform = 'translateX(0)';
                    mainNav.classList.add('is-visible');
                    
                }, 100);
                
                // RETOUR IMMÉDIAT de la tondeuse
                if (tondeuse) {
                    tondeuse.classList.remove('menu-triggered');
                    tondeuse.classList.add('menu-closing');
                    
                    // Disparition définitive après le retour
                    setTimeout(() => {
                        tondeuse.classList.remove('menu-closing');
                        tondeuse.classList.add('disappeared');
                        tondeuse.style.animation = 'none';
                        
                        // MARQUER L'ANIMATION COMME TERMINÉE
                        tondeuseAnimationCompleted = true;
                        
                    }, 1800); // Durée de l'animation de retour (1.8s)
                }
            } else {
                // Si la tondeuse a déjà disparu, afficher directement la navigation
                mainNav.style.display = 'flex';
                mainNav.style.opacity = '1';
                mainNav.style.transform = 'translateX(0)';
                mainNav.setAttribute('aria-hidden', 'false');
                mainNav.classList.add('is-visible');
                
                // MARQUER L'ANIMATION COMME TERMINÉE
                tondeuseAnimationCompleted = true;
            }
            
        }, 1200); // Attendre la fin du déplacement de la tondeuse (ralenti)
        
        // État final
        setTimeout(() => {
            header.classList.remove('state-initial');
            header.classList.add('state-expanded');
            
            isMenuOpen = true;
            
            // Mettre à jour l'accessibilité
            burgerBtn.setAttribute('aria-expanded', 'true');
            burgerBtn.setAttribute('aria-label', 'Fermer le menu');
        }, 500);
    }
    
    /* ========================================
       FERMETURE DU MENU
       ======================================== */
    function closeMenu() {
        // Si la tondeuse a disparu, ne jamais refermer le menu ni réafficher le burger
        if (tondeuseAnimationCompleted) {
            // Le menu nav doit rester visible, le burger doit rester caché
            mainNav.style.display = 'flex';
            mainNav.style.opacity = '1';
            mainNav.style.transform = 'translateX(0)';
            mainNav.setAttribute('aria-hidden', 'false');
            mainNav.classList.add('is-visible');
            burgerContainer.style.display = 'none';
            header.classList.remove('state-initial');
            header.classList.add('state-expanded');
            isMenuOpen = true;
            burgerBtn.setAttribute('aria-expanded', 'true');
            burgerBtn.setAttribute('aria-label', 'Menu permanent');
            return;
        }
        // Sinon, comportement normal (avant disparition tondeuse)
        // ...existing code...
    }

    /* ========================================
       NAVIGATION SMOOTH SCROLL
       ======================================== */
    function setupSmoothScroll() {
        const navLinks = document.querySelectorAll('[data-scroll]');
        
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('data-scroll');
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    // Calculer la hauteur du header pour l'offset
                    const headerHeight = header.offsetHeight;
                    const elementPosition = targetElement.offsetTop;
                    const offsetPosition = elementPosition - headerHeight - 20; // 20px de marge supplémentaire
                    
                    // S'assurer que le header soit restauré avant la navigation
                    if (header.classList.contains('header--retracted')) {
                        header.classList.remove('header--retracted');
                        
                        // Attendre la transition du header avant de scroller
                        setTimeout(() => {
                            window.scrollTo({
                                top: offsetPosition,
                                behavior: 'smooth'
                            });
                        }, 400); // Délai correspondant à la transition CSS
                    } else {
                        // Scroll direct si le header n'était pas rétracté
                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });
                    }
                    
                    
                    // NE PLUS fermer le menu après navigation si l'animation tondeuse est terminée
                    if (isMenuOpen && !tondeuseAnimationCompleted) {
                        setTimeout(() => {
                            closeMenu();
                        }, 300);
                    } else if (tondeuseAnimationCompleted) {
                        // Forcer le menu nav à rester visible et le burger à rester caché
                        mainNav.style.display = 'flex';
                        mainNav.style.opacity = '1';
                        mainNav.style.transform = 'translateX(0)';
                        mainNav.setAttribute('aria-hidden', 'false');
                        mainNav.classList.add('is-visible');
                        burgerContainer.style.display = 'none';
                        header.classList.remove('state-initial');
                        header.classList.add('state-expanded');
                        isMenuOpen = true;
                        burgerBtn.setAttribute('aria-expanded', 'true');
                        burgerBtn.setAttribute('aria-label', 'Menu permanent');
                    }
                }
            });
        });
    }
    
    /* ========================================
       RESPONSIVE ET PERFORMANCE
       ======================================== */
    
    // Gestion responsive
    function handleResize() {
        const isMobile = window.innerWidth <= 768;
        
        if (isMobile) {
            // Adaptations spécifiques mobile si nécessaire
            header.classList.add('header--mobile');
        } else {
            header.classList.remove('header--mobile');
        }
    }
    
    // Vérifier au redimensionnement
    window.addEventListener('resize', handleResize);
    handleResize();
    
});
