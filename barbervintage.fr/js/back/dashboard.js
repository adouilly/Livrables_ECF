/**
 * Dashboard Admin - Vintage Barber Shop v1 FINALE
 * Gestion des interactions et fonctionnalités du tableau de bord
 *
 * - Gestion des images de galerie (suppression)
 * - Formulaire changement mot de passe avec animation
 * - Validation côté client et gestion erreurs
 */

// ================================
// GESTION DES IMAGES DE GALERIE
// ================================
function supprimerImageGalerie(idImage) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette image de la galerie ?')) {
        window.location.href = `manage-gallery.php?action=delete&id=${idImage}`;
    }
}

// ================================
// GESTION DU FORMULAIRE MOT DE PASSE
// ================================
function basculerFormulaireMotDePasse() {
    const container = document.getElementById('passwordFormContainer');
    const btn = document.getElementById('changePasswordBtn');

    if (container.style.display === 'none' || !container.classList.contains('expanded')) {
        // Afficher et étendre
        container.style.display = 'block';
        setTimeout(() => {
            container.classList.add('expanded');
        }, 10);
        btn.textContent = '🔒 Fermer';
        btn.classList.add('active');
    } else {
        // Rétracter et masquer
        container.classList.remove('expanded');
        setTimeout(() => {
            container.style.display = 'none';
        }, 300);
        btn.textContent = 'Changer mot de passe';
        btn.classList.remove('active');
    }
}

// Gestion du formulaire de changement de mot de passe
document.addEventListener('DOMContentLoaded', function() {
    const passwordForm = document.getElementById('passwordForm');

    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const newPasswordElement = document.getElementById('new_password');
            const confirmPasswordElement = document.getElementById('confirm_password');

            if (!newPasswordElement || !confirmPasswordElement) {
                console.error('❌ Éléments de mot de passe non trouvés');
                return;
            }

            const newPassword = newPasswordElement.value;
            const confirmPassword = confirmPasswordElement.value;

            // Validation des mots de passe
            if (newPassword !== confirmPassword) {
                alert('Les nouveaux mots de passe ne correspondent pas !');
                return;
            }

            if (newPassword.length < 6) {
                alert('Le nouveau mot de passe doit contenir au moins 6 caractères !');
                return;
            }

            // Envoi AJAX
            const formData = new FormData(passwordForm);

            fetch('handlers/change-password-ajax.php', {
                method: 'POST',
                body: formData
            })
            .then(async response => {
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.indexOf('application/json') !== -1) {
                    return response.json();
                } else {
                    // Réponse inattendue (HTML, texte, etc.)
                    throw new Error('Réponse non-JSON du serveur');
                }
            })
            .then(data => {
                if (data.success) {
                    alert('Mot de passe changé avec succès !');
                    basculerFormulaireMotDePasse();
                    passwordForm.reset();
                } else {
                    alert('Erreur: ' + (data.message || 'Erreur inconnue'));
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                if (error.message === 'Réponse non-JSON du serveur') {
                    alert('Erreur de communication avec le serveur (réponse inattendue)');
                } else {
                    alert('Erreur de communication avec le serveur');
                }
            });
        });
    }
});

// ================================
// GESTION DE L'UPLOAD HERO
// ================================
function previewHeroImage(input) {
    const file = input.files[0];
    const uploadBtn = document.getElementById('uploadBtn');
    const fileInfo = document.getElementById('fileInfo');
    const fileName = document.getElementById('fileName');
    const heroPreview = document.getElementById('heroPreview');

    if (file) {
        // Afficher les informations du fichier
        if (fileName) fileName.textContent = file.name;
        if (fileInfo) fileInfo.style.display = 'block';

        // Activer le bouton d'upload
        if (uploadBtn) {
            uploadBtn.disabled = false;
            uploadBtn.textContent = 'Uploader';
            uploadBtn.style.opacity = '1';
        }

        // Prévisualisation de l'image
        const reader = new FileReader();
        reader.onload = function(e) {
            if (heroPreview) {
                heroPreview.src = e.target.result;
                heroPreview.style.opacity = '0.7'; // Indiquer que c'est un aperçu
            }
        };
        reader.readAsDataURL(file);

    } else {
        // Masquer les informations et désactiver le bouton
        if (fileInfo) fileInfo.style.display = 'none';
        if (uploadBtn) {
            uploadBtn.disabled = true;
            uploadBtn.textContent = 'Uploader';
            uploadBtn.style.opacity = '0.5';
        }

        // Restaurer l'image originale si elle existe
        if (heroPreview) {
            heroPreview.style.opacity = '1';
        }
    }
}

// Gestion de l'upload avec retour visuel
document.addEventListener('DOMContentLoaded', function() {
    const heroForm = document.getElementById('heroForm');
    if (heroForm) {
        heroForm.addEventListener('submit', function(e) {
            const uploadBtn = document.getElementById('uploadBtn');
            const fileInput = document.getElementById('hero_file');
            // Vérifier qu'un fichier est sélectionné
            if (!fileInput.files || fileInput.files.length === 0) {
                e.preventDefault();
                alert('Veuillez sélectionner une image avant d\'uploader.');
                return false;
            }
            if (uploadBtn) {
                uploadBtn.textContent = 'Upload en cours...';
                uploadBtn.disabled = true;
                uploadBtn.classList.add('uploading');
            }
            // Ajouter timestamp pour forcer le rafraîchissement de l'image
            const currentImg = document.getElementById('heroPreview');
            if (currentImg) {
                // Attendre la soumission du formulaire puis rafraîchir
                setTimeout(() => {
                    const baseUrl = currentImg.src.split('?')[0];
                    const newTimestamp = Date.now();
                    currentImg.src = baseUrl + '?v=' + newTimestamp;
                    // Rafraîchissement global optimisé
                    refreshAllImages();
                    aggressiveCacheClear();
                }, 1000);
            }
        });
    }
});

// ================================
// FONCTION DE RAFRAÎCHISSEMENT GLOBAL
// ================================
function refreshAllImages() {
    const timestamp = Date.now();
    document.querySelectorAll('img[src*="assets/hero/"], img[src*="assets/gallery/"]').forEach(img => {
        const baseUrl = img.src.split('?')[0];
        img.src = baseUrl + '?v=' + timestamp;
    });
}

/**
 * Vider le cache du navigateur de manière agressive (optimisé)
 * Utilisé après upload pour forcer le rechargement des images hero.
 */
function aggressiveCacheClear() {
    // Modifier seulement les images hero pour forcer le rechargement
    const images = document.querySelectorAll('img[src*="assets/hero/"]');
    images.forEach(img => {
        const originalSrc = img.src;
        img.src = '';
        setTimeout(() => {
            img.src = originalSrc.split('?')[0] + '?v=' + Date.now();
        }, 50);
    });
}

// ================================
// DIAGNOSTIC HERO UPLOAD (SIMPLIFIÉ)
// ================================

// Diagnostic simplifié - pas de requêtes AJAX qui surchargent
// Vider le cache du navigateur de manière agressive (optimisé)
//  */
function aggressiveCacheClear() {
    // Modifier seulement les images hero pour forcer le rechargement
    const images = document.querySelectorAll('img[src*="assets/hero/"]');
    images.forEach(img => {
        const originalSrc = img.src;
        img.src = '';
        setTimeout(() => {
            img.src = originalSrc.split('?')[0] + '?v=' + Date.now();
        }, 50);
    });
}

// ================================
// DIAGNOSTIC HERO UPLOAD (SIMPLIFIÉ)
// ================================

// Diagnostic simplifié - pas de requêtes AJAX qui surchargent
console.log("✅ Dashboard hero management ready");
