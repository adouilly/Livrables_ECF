/**
 * Hero Upload - Vintage Barber Shop Admin
 * Gestion de l'upload des images hero
 */

document.addEventListener('DOMContentLoaded', function() {
    
    const heroForm = document.getElementById('heroForm');
    if (heroForm) {
        setupHeroUpload();
    }
    
    function setupHeroUpload() {
        
        // Gestion de l'upload avec retour visuel
        heroForm.addEventListener('submit', function(e) {
            console.log("🚀 Upload hero démarré");
            
            const uploadBtn = document.getElementById('uploadBtn');
            const fileInput = document.getElementById('hero_file');
            
            // Vérifier qu'un fichier est sélectionné
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner une image avant d\'uploader.');
                return false;
            }
            
            console.log("📤 Fichier à uploader:", fileInput.files[0].name);
            
            uploadBtn.textContent = 'Upload en cours...';
            uploadBtn.disabled = true;
            uploadBtn.classList.add('uploading');
        });
    }
    
});

// Fonction de prévisualisation (appelée inline)
function previewHeroImage(input) {
    console.log("🔍 Prévisualisation hero");
    
    const file = input.files[0];
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const heroPreview = document.getElementById('heroPreview');
    
    if (file) {
        console.log("📁 Fichier sélectionné:", file.name, file.type, file.size);
        
        // Afficher les informations du fichier
        if (fileName) fileName.textContent = file.name;
        if (fileInfo) fileInfo.style.display = 'block';
        
        // Activer le bouton d'upload
        if (uploadBtn) {
            uploadBtn.disabled = false;
            uploadBtn.textContent = 'Uploader';
        }
        
        // Prévisualisation de l'image
        const reader = new FileReader();
        reader.onload = function(e) {
            if (heroPreview) {
                heroPreview.src = e.target.result;
                heroPreview.style.opacity = '0.7'; // Indiquer que c'est un aperçu
                console.log("🖼️ Prévisualisation affichée");
            }
        };
        reader.readAsDataURL(file);
        
    } else {
        console.log("❌ Aucun fichier sélectionné");
        
        // Masquer les informations et désactiver le bouton
        if (fileInfo) fileInfo.style.display = 'none';
        if (uploadBtn) {
            uploadBtn.disabled = true;
            uploadBtn.textContent = 'Uploader';
        }
        
        // Restaurer l'image originale
        if (heroPreview) {
            heroPreview.style.opacity = '1';
        }
    }
}
