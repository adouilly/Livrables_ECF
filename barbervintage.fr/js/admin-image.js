// Scripts pour la gestion des images dans l'administration
document.addEventListener('DOMContentLoaded', function() {
    
    // Prévisualisation d'image avant upload pour l'image Hero
    const heroImageInput = document.getElementById('hero_image');
    const heroPreview = document.querySelector('.hero-back__preview');
    
    if (heroImageInput && heroPreview) {
        heroImageInput.addEventListener('change', function() {
            previewImage(this, heroPreview);
        });
    }
    
    // Prévisualisation d'image avant upload pour la galerie
    const galleryImageInput = document.getElementById('gallery_image');
    const galleryPreviewContainer = document.querySelector('.gallery-back__preview-container');
    
    if (galleryImageInput && galleryPreviewContainer) {
        galleryImageInput.addEventListener('change', function() {
            previewImage(this, galleryPreviewContainer);
        });
    }
    
    // Fonction de prévisualisation d'image
    function previewImage(input, previewContainer) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                if (!previewContainer.querySelector('img')) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = 'Prévisualisation';
                    previewContainer.innerHTML = '';
                    previewContainer.appendChild(img);
                } else {
                    previewContainer.querySelector('img').src = e.target.result;
                }
                
                // Afficher les dimensions
                const image = new Image();
                image.onload = function() {
                    if (previewContainer.querySelector('.dimensions-info')) {
                        previewContainer.querySelector('.dimensions-info').remove();
                    }
                    
                    const dimensionsInfo = document.createElement('div');
                    dimensionsInfo.classList.add('dimensions-info');
                    dimensionsInfo.innerHTML = `Dimensions: ${this.width}px × ${this.height}px`;
                    previewContainer.appendChild(dimensionsInfo);
                };
                image.src = e.target.result;
            };
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Validation des dimensions et ratio pour l'image Hero
    function validateHeroImage() {
        const input = document.getElementById('hero_image');
        if (input.files && input.files[0]) {
            const img = new Image();
            img.onload = function() {
                if (this.width !== 851 || this.height !== 315) {
                    alert(`Les dimensions de l'image doivent être exactement 851×315 pixels. Dimensions actuelles: ${this.width}×${this.height} pixels`);
                    input.value = '';
                    return false;
                }
            };
            img.src = URL.createObjectURL(input.files[0]);
        }
        return true;
    }
    
    // Validation du ratio 16:9 pour les images de galerie
    function validateGalleryImage() {
        const input = document.getElementById('gallery_image');
        if (input.files && input.files[0]) {
            const img = new Image();
            img.onload = function() {
                const ratio = this.width / this.height;
                const targetRatio = 16/9;
                const tolerance = 0.01;
                
                if (Math.abs(ratio - targetRatio) > tolerance) {
                    alert(`L'image doit avoir un ratio 16:9 (ex: 1920×1080 pixels). Ratio actuel: ${ratio.toFixed(2)}`);
                    input.value = '';
                    return false;
                }
            };
            img.src = URL.createObjectURL(input.files[0]);
        }
        return true;
    }
    
    // Ajouter les validations aux formulaires
    const heroForm = document.querySelector('.hero-back__form');
    if (heroForm) {
        heroForm.addEventListener('submit', function(e) {
            if (!validateHeroImage()) {
                e.preventDefault();
            }
        });
    }
    
    const galleryForm = document.querySelector('.gallery-back__form');
    if (galleryForm) {
        galleryForm.addEventListener('submit', function(e) {
            if (!validateGalleryImage()) {
                e.preventDefault();
            }
        });
    }
});
