<?php
/* ========================================
   SECTION GALLERY - VINTAGE BARBER SHOP
   ======================================== */
?>

<!-- ========================================
     SECTION GALLERY
     ======================================== -->
<section class="gallery" id="gallery">
    
    <!-- Titre principal centré avec background noir -->
    <div class="gallery__title-container">
        <h2 class="gallery__title">Galerie</h2>
    </div>
    
    <!-- Conteneur principal galerie rétro -->
    <div class="gallery__container">
        
        <!-- Conteneur interne pour centrer le contenu -->
        <div class="gallery__inner">
        
            <!-- ========================================
                 BLOC SUPÉRIEUR - AFFICHAGE IMAGE
                 ======================================== -->
            <div class="gallery__display">
                <!-- Image décorative frontstore (en dehors du flux, masquée sur mobile) -->
                <div class="gallery__frontstore-decoration">
                    <img src="assets/img2/frontstore.png" alt="Décoration frontstore" class="gallery__frontstore-image">
                </div>
                
                <!-- Image principale avec animation de fondu -->
                <div class="gallery__image-container">
                    <img src="" alt="Image galerie" class="gallery__image" id="gallery-main-image">
                    <!-- Overlay pour animation fondu au noir -->
                    <div class="gallery__fade-overlay"></div>
                </div>
            </div>
            
            <!-- ========================================
                 BLOC INFÉRIEUR - CONTRÔLES NAVIGATION
                 ======================================== -->
            <div class="gallery__controls">
                <div class="gallery__controls-container">
                    
                    <!-- Bouton précédent (gauche) -->
                    <button class="gallery__btn gallery__btn--prev" 
                            aria-label="Image précédente" 
                            title="Image précédente">
                        <div class="gallery__btn-arrow gallery__btn-arrow--left"></div>
                    </button>
                    
                    <!-- Bouton suivant (droite) -->
                    <button class="gallery__btn gallery__btn--next" 
                            aria-label="Image suivante" 
                            title="Image suivante">
                        <div class="gallery__btn-arrow gallery__btn-arrow--right"></div>
                    </button>
                    
                </div>
            </div>
            
        </div> <!-- Fin .gallery__inner -->
        
    </div> <!-- Fin .gallery__container -->
    
</section>
