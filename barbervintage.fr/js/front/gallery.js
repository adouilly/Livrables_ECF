/* ========================================
   GALLERY RÉTRO - VINTAGE BARBER SHOP
   JavaScript pour galerie avec navigation et animations
   ======================================== */

document.addEventListener('DOMContentLoaded', function() {
    
    // ========================================
    // VARIABLES ET ÉLÉMENTS
    // ========================================
    
    const imageContainer = document.querySelector('.gallery__image-container');
    const mainImage = document.getElementById('gallery-main-image');
    const fadeOverlay = document.querySelector('.gallery__fade-overlay');
    const prevBtn = document.querySelector('.gallery__btn--prev');
    const nextBtn = document.querySelector('.gallery__btn--next');
    
    // Configuration
    let currentImageIndex = 0;
    let images = [];
    let isTransitioning = false;
    
    // Liste des images de la galerie (triées par display_order de la base)
    // Ces images sont chargées dynamiquement depuis la base de données
    // et respectent l'ordre défini dans l'administration
    const galleryImages = [
        // Note: Ces images sont maintenant chargées via gallery-dynamic.php
        // qui utilise les données de la base avec l'ordre display_order
        {
            src: 'assets/gallery/barber_vintage (1).jpg',
            alt: 'Salon vintage - Vue d\'ensemble',
            order: 1
        },
        {
            src: 'assets/gallery/barber_vintage (2).jpg', 
            alt: 'Espace coiffure traditionnel',
            order: 2
        },
        {
            src: 'assets/gallery/barber_vintage (3).jpg',
            alt: 'Outils de barbier vintage',
            order: 3
        },
        {
            src: 'assets/gallery/barber_vintage (4).jpg',
            alt: 'Détail salon rétro',
            order: 4
        },
        {
            src: 'assets/gallery/barber_vintage (5).jpg',
            alt: 'Ambiance barbier vintage',
            order: 5
        },
        {
            src: 'assets/gallery/pexels-zvolskiy-1570807.jpg',
            alt: 'Prestation barbier professionnel',
            order: 6
        }
    ];
    
    // Trier les images par order pour s'assurer du bon ordre d'affichage
    galleryImages.sort((a, b) => (a.order || 0) - (b.order || 0));
    
    // Gallery initialization without logs for production
    
    // ========================================
    // INITIALISATION
    // ========================================
    
    function initGallery() {
        
        if (!mainImage || !prevBtn || !nextBtn) {
            return;
        }
        
        // Filtrer les images existantes
        images = galleryImages;
        
        if (images.length === 0) {
            return;
        }
        
        
        // Charger la première image
        loadImage(currentImageIndex);
        
        // Event listeners
        prevBtn.addEventListener('click', showPreviousImage);
        nextBtn.addEventListener('click', showNextImage);
        
        // Gestion clavier
        document.addEventListener('keydown', handleKeyboard);
        
        // Mettre à jour l'état des boutons
        updateButtonsState();
        
    }
    
    // ========================================
    // CHARGEMENT ET AFFICHAGE DES IMAGES
    // ========================================
    
    function loadImage(index) {
        if (index < 0 || index >= images.length) return;
        
        const imageData = images[index];
        
        // Vérifier si l'image existe
        const img = new Image();
        img.onload = function() {
            mainImage.src = imageData.src;
            mainImage.alt = imageData.alt;
        };
        img.onerror = function() {
            mainImage.src = 'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAwIiBoZWlnaHQ9IjMwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48cmVjdCB3aWR0aD0iMTAwJSIgaGVpZ2h0PSIxMDAlIiBmaWxsPSIjZGRkIi8+PHRleHQgeD0iNTAlIiB5PSI1MCUiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxOCIgZmlsbD0iIzk5OSIgdGV4dC1hbmNob3I9Im1pZGRsZSIgZHk9Ii4zZW0iPkltYWdlIG5vbiBkaXNwb25pYmxlPC90ZXh0Pjwvc3ZnPg==';
            mainImage.alt = 'Image non disponible';
        };
        img.src = imageData.src;
    }
    
    // ========================================
    // NAVIGATION AVEC ANIMATION
    // ========================================
    
    function showNextImage() {
        if (isTransitioning) return;
        
        const nextIndex = (currentImageIndex + 1) % images.length;
        changeImage(nextIndex);
    }
    
    function showPreviousImage() {
        if (isTransitioning) return;
        
        const prevIndex = currentImageIndex === 0 ? images.length - 1 : currentImageIndex - 1;
        changeImage(prevIndex);
    }
    
    function changeImage(newIndex) {
        if (isTransitioning || newIndex === currentImageIndex) return;
        
        isTransitioning = true;
        
        // Animation fondu au noir
        imageContainer.classList.add('fading');
        fadeOverlay.classList.add('animating');
        
        // Changer l'image au milieu de l'animation
        setTimeout(() => {
            currentImageIndex = newIndex;
            loadImage(currentImageIndex);
            updateButtonsState();
        }, 300); // Milieu de l'animation de 0.6s
        
        // Terminer l'animation
        setTimeout(() => {
            imageContainer.classList.remove('fading');
            fadeOverlay.classList.remove('animating');
            isTransitioning = false;
        }, 600);
    }
    
    // ========================================
    // GESTION DES BOUTONS
    // ========================================
    
    function updateButtonsState() {
        if (images.length <= 1) {
            prevBtn.disabled = true;
            nextBtn.disabled = true;
            return;
        }
        
        // Pour une galerie circulaire, les boutons sont toujours actifs
        prevBtn.disabled = false;
        nextBtn.disabled = false;
    }
    
    // ========================================
    // GESTION CLAVIER
    // ========================================
    
    function handleKeyboard(event) {
        if (isTransitioning) return;
        
        switch(event.key) {
            case 'ArrowLeft':
                showPreviousImage();
                break;
            case 'ArrowRight':
                showNextImage();
                break;
        }
    }
    
    // ========================================
    // AUTO-PLAY (OPTIONNEL)
    // ========================================
    
    let autoPlayInterval;
    
    function startAutoPlay(interval = 5000) {
        stopAutoPlay();
        autoPlayInterval = setInterval(showNextImage, interval);
    }
    
    function stopAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
            autoPlayInterval = null;
        }
    }
    
    // Arrêter l'auto-play lors de l'interaction utilisateur
    function handleUserInteraction() {
        stopAutoPlay();
        // Reprendre après 10 secondes d'inactivité
        setTimeout(() => {
            if (!isTransitioning) {
                startAutoPlay();
            }
        }, 10000);
    }
    
    // ========================================
    // INITIALISATION ET EXPORT
    // ========================================
    
    initGallery();
    
    // Optionnel : démarrer l'auto-play
    // startAutoPlay(4000);
    
    // Export pour utilisation externe
    window.vintageGallery = {
        next: showNextImage,
        prev: showPreviousImage,
        goTo: changeImage,
        startAutoPlay: startAutoPlay,
        stopAutoPlay: stopAutoPlay
    };
    
});
        stopAutoPlay: stopAutoPlay
    };
    
});
