<?php
/**
 * Script PHP qui génère dynamiquement le JavaScript pour la galerie
 * en utilisant les données de la base de données
 */
require_once dirname(dirname(__DIR__)) . '/includes/config.php';

// Récupérer les images de la galerie depuis la base de données
$galleryImages = recupererImagesGalerie();

// Définir le content type comme JavaScript
header('Content-Type: application/javascript');
?>
// ========================================
// GALLERY RÉTRO - VINTAGE BARBER SHOP
// Généré dynamiquement depuis la base de données
// ========================================

document.addEventListener('DOMContentLoaded', function() {
    'use strict';
    
    // Éléments DOM
    const imageContainer = document.querySelector('.gallery__image-container');
    const mainImage = document.getElementById('gallery-main-image');
    const fadeOverlay = document.querySelector('.gallery__fade-overlay');
    const prevBtn = document.querySelector('.gallery__btn--prev');
    const nextBtn = document.querySelector('.gallery__btn--next');
    
    // Variables de contrôle
    let currentImageIndex = 0;
    let images = [];
    let isTransitioning = false;
    let autoSlideInterval = null;
    let autoSlideActive = true;
    const slideInterval = 10000; // Intervalle de 10 secondes entre chaque diapositive
    
    // Liste des images de la galerie chargée depuis la base de données
    // ORDRE RESPECTÉ selon display_order de la table gallery_images
    const galleryImages = [
        <?php if (!empty($galleryImages)): ?>
            <?php 
            // Assurer que les images sont triées par display_order
            usort($galleryImages, function($a, $b) {
                return intval($a['display_order']) - intval($b['display_order']);
            });
            ?>
            <?php foreach ($galleryImages as $index => $image): ?>
            {
                src: 'assets/gallery/<?php echo htmlspecialchars($image['filename']); ?>?v=<?= time() ?>',
                alt: '<?php echo htmlspecialchars($image['alt_text'] ?: 'Image galerie ' . ($index + 1)); ?>',
                order: <?php echo intval($image['display_order']); ?>
            }<?php echo ($index < count($galleryImages) - 1) ? ',' : ''; ?>
            <?php endforeach; ?>
        <?php else: ?>
            // Images par défaut si aucune image en base
            {
                src: 'assets/gallery/barber_vintage (1).jpg?v=<?= time() ?>',
                alt: 'Image galerie par défaut'
            }
        <?php endif; ?>
    ];
    
    // ========================================
    // INITIALISATION
    // ========================================
    
    function initGallery() {
        
        if (!mainImage || !prevBtn || !nextBtn) {
            console.warn('⚠️ Éléments de galerie manquants');
            return;
        }
        
        // Filtrer les images existantes
        images = galleryImages;
        
        if (images.length === 0) {
            console.warn('⚠️ Aucune image dans la galerie');
            return;
        }
        
        
        // Charger la première image
        loadImage(currentImageIndex);
        
        // Event listeners
        prevBtn.addEventListener('click', function() {
            showPrevImage();
            resetAutoSlide(); // Réinitialiser le diaporama automatique
        });
        nextBtn.addEventListener('click', function() {
            showNextImage();
            resetAutoSlide(); // Réinitialiser le diaporama automatique
        });
        
        // Mise à jour de l'état des boutons
        updateButtonStates();
        
        // Démarrer le diaporama automatique
        startAutoSlide();
        
    }
    
    // ========================================
    // FONCTIONS DE NAVIGATION
    // ========================================
    
    function showPrevImage() {
        if (isTransitioning || currentImageIndex === 0) return;
        
        transitionToImage(currentImageIndex - 1);
    }
    
    function showNextImage() {
        if (isTransitioning || currentImageIndex === images.length - 1) return;
        
        transitionToImage(currentImageIndex + 1);
    }
    
    function transitionToImage(newIndex) {
        if (isTransitioning) return;
        
        isTransitioning = true;
        
        // Ajouter la classe pour l'animation de fondu
        fadeOverlay.classList.add('gallery__fade-overlay--active');
        
        // Attendre que l'animation de fondu soit terminée
        setTimeout(function() {
            loadImage(newIndex);
            
            // Retirer la classe pour revenir
            fadeOverlay.classList.remove('gallery__fade-overlay--active');
            
            isTransitioning = false;
        }, 300); // Durée de la transition (ms)
    }
    
    function loadImage(index) {
        if (index < 0 || index >= images.length) {
            console.warn('⚠️ Index d\'image invalide:', index);
            return;
        }
        
        currentImageIndex = index;
        const image = images[index];
        
        mainImage.src = image.src;
        mainImage.alt = image.alt;
        
        updateButtonStates();
    }
    
    function updateButtonStates() {
        // Désactiver le bouton précédent si on est à la première image
        prevBtn.disabled = currentImageIndex === 0;
        prevBtn.classList.toggle('gallery__btn--disabled', currentImageIndex === 0);
        
        // Désactiver le bouton suivant si on est à la dernière image
        nextBtn.disabled = currentImageIndex === images.length - 1;
        nextBtn.classList.toggle('gallery__btn--disabled', currentImageIndex === images.length - 1);
    }
    
    // ========================================
    // DIAPORAMA AUTOMATIQUE
    // ========================================
    
    function startAutoSlide() {
        // Nettoyer tout intervalle existant
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
        
        // Démarrer un nouvel intervalle
        autoSlideInterval = setInterval(function() {
            if (!autoSlideActive) return;
            
            // Si on est à la dernière image, revenir à la première
            if (currentImageIndex >= images.length - 1) {
                transitionToImage(0);
            } else {
                // Sinon, passer à l'image suivante
                transitionToImage(currentImageIndex + 1);
            }
        }, slideInterval);
        
    }
    
    function resetAutoSlide() {
        // Réinitialiser le diaporama après une interaction manuelle
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
        startAutoSlide();
    }
    
    // Arrêter le diaporama lorsque l'utilisateur quitte la page
    window.addEventListener('beforeunload', function() {
        if (autoSlideInterval) {
            clearInterval(autoSlideInterval);
        }
    });
    
    // Initialisation de la galerie
    initGallery();
});
