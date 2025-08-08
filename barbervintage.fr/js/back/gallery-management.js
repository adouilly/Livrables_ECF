/**
 * Script pour la gestion de la galerie avec drag & drop et uplo    for (let i = 0; i < fileInput.files.length; i++) {
        formData.append('gallery_files[]', fileInput.files[i]);
    }
    
    fetch('handlers/upload-gallery-ajax.php', {
        method: 'POST',
        body: formData
    })e
 * Vintage Barber Shop - Admin Panel
 */

// Variables globales
let draggedElement = null;
let orderChanged = false;

document.addEventListener('DOMContentLoaded', function() {
    initGalleryDragDrop();
    initGalleryButtons();
    initGalleryUpload();
});

/**
 * Initialiser l'upload de galerie
 */
function initGalleryUpload() {
    const fileInput = document.getElementById('gallery_files');
    const uploadBtn = document.getElementById('uploadGalleryBtn');
    
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const files = this.files;
            const preview = document.getElementById('galleryFilePreview');
            const fileList = document.getElementById('galleryFileList');
            
            if (files.length > 0) {
                fileList.innerHTML = '';
                for (let i = 0; i < files.length; i++) {
                    const li = document.createElement('li');
                    li.style.cssText = 'padding: 0.25rem; margin: 0.25rem 0; background: #f8f9fa; border-radius: 4px;';
                    li.textContent = files[i].name + ' (' + Math.round(files[i].size / 1024) + ' KB)';
                    fileList.appendChild(li);
                }
                preview.style.display = 'block';
                if (uploadBtn) uploadBtn.disabled = false;
            } else {
                preview.style.display = 'none';
                if (uploadBtn) uploadBtn.disabled = true;
            }
        });
    }
    
    if (uploadBtn) {
        uploadBtn.addEventListener('click', uploadGalleryImages);
    }
}

/**
 * Uploader les images sélectionnées
 */
function uploadGalleryImages() {
    const fileInput = document.getElementById('gallery_files');
    const uploadBtn = document.getElementById('uploadGalleryBtn');
    
    if (!fileInput.files.length) {
        showGalleryMessage('Aucun fichier sélectionné', 'error');
        return;
    }
    
    // Désactiver le bouton pendant l'upload
    uploadBtn.disabled = true;
    uploadBtn.textContent = '⏳ Upload en cours...';
    
    const formData = new FormData();
    for (let i = 0; i < fileInput.files.length; i++) {
        formData.append('gallery_files[]', fileInput.files[i]);
    }
    
    fetch('handlers/upload-gallery-ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showGalleryMessage(data.message, 'success');
            
            // Réinitialiser le formulaire
            fileInput.value = '';
            document.getElementById('galleryFilePreview').style.display = 'none';
            uploadBtn.disabled = true;
            uploadBtn.textContent = '📤 Uploader les images';
            
            // Rafraîchir les images avec cache busting si disponible
            if (data.cache_refreshed) {
                refreshGalleryImages();
            }
            
            // Recharger la galerie après un délai
            setTimeout(() => {
                location.reload();
            }, 2000);
            
        } else {
            showGalleryMessage('Erreur: ' + data.message, 'error');
            uploadBtn.disabled = false;
            uploadBtn.textContent = '📤 Uploader les images';
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showGalleryMessage('Erreur de communication avec le serveur', 'error');
        uploadBtn.disabled = false;
        uploadBtn.textContent = '📤 Uploader les images';
    });
}

/**
 * Initialiser le drag & drop pour la galerie
 */
function initGalleryDragDrop() {
    const galleryGrid = document.querySelector('.grille-galerie');
    if (!galleryGrid) return;
    const galleryItems = galleryGrid.querySelectorAll('.element-galerie');
    galleryItems.forEach(item => {
        item.setAttribute('draggable', 'true');
        item.addEventListener('dragstart', handleDragStart);
        item.addEventListener('dragover', handleDragOver);
        item.addEventListener('drop', handleDrop);
        item.addEventListener('dragend', handleDragEnd);
        item.addEventListener('dragenter', function() {
            this.classList.add('drag-over');
        });
        item.addEventListener('dragleave', function() {
            this.classList.remove('drag-over');
        });
    });
}

/**
 * Gérer le début du drag
 */
function handleDragStart(e) {
    draggedElement = this;
    this.classList.add('dragging');
    e.dataTransfer.effectAllowed = 'move';
}

/**
 * Gérer le survol pendant le drag
 */
function handleDragOver(e) {
    e.preventDefault();
    e.dataTransfer.dropEffect = 'move';
    return false;
}

/**
 * Gérer le drop
 */
function handleDrop(e) {
    e.preventDefault();
    if (draggedElement === this) return;
    const galleryGrid = this.parentNode;
    // Déplacer le nœud DOM
    galleryGrid.insertBefore(draggedElement, this);
    orderChanged = true;
    updateGalleryNumbers();
    showSaveButton();
}

/**
 * Gérer la fin du drag
 */
function handleDragEnd(e) {
    const items = document.querySelectorAll('.element-galerie');
    items.forEach(item => {
        item.classList.remove('dragging', 'drag-over');
    });
}

/**
 * Mettre à jour les numéros d'ordre des images
 */
function updateGalleryNumbers() {
    const items = document.querySelectorAll('.element-galerie');
    items.forEach((item, index) => {
        const numberElement = item.querySelector('.element-galerie__numero');
        if (numberElement) {
            numberElement.textContent = index + 1;
        }
    });
}

/**
 * Afficher le bouton de sauvegarde
 */
function showSaveButton() {
    const saveButton = document.getElementById('saveGalleryOrder');
    if (saveButton) {
        saveButton.style.display = 'inline-block';
    }
}

/**
 * Initialiser les boutons de la galerie
 */
function initGalleryButtons() {
    const saveButton = document.getElementById('saveGalleryOrder');
    if (saveButton) {
        saveButton.addEventListener('click', saveGalleryOrder);
    }
}

/**
 * Sauvegarder l'ordre de la galerie
 */
function saveGalleryOrder() {
    const items = document.querySelectorAll('.element-galerie');
    const order = Array.from(items).map(item => parseInt(item.dataset.id));
    fetch('handlers/reorder-gallery.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ order: order })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showGalleryMessage('Ordre mis à jour avec succès ! L\'ordre sera visible sur le site.', 'success');
            document.getElementById('saveGalleryOrder').style.display = 'none';
            orderChanged = false;
            refreshGalleryImages();
            updateGalleryNumbers();
        } else {
            showGalleryMessage('Erreur: ' + data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        showGalleryMessage('Erreur de communication avec le serveur', 'error');
    });
}

/**
 * Supprimer une image de la galerie
 */
function deleteGalleryImage(imageId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
        return;
    }
    fetch('handlers/delete-gallery-image.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `image_id=${encodeURIComponent(imageId)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`.element-galerie[data-id="${imageId}"]`);
            if (item) {
                item.remove();
                updateGalleryNumbers();
                updateGalleryCount();
            }
            showGalleryMessage('Image supprimée avec succès !', 'success');
        } else {
            showGalleryMessage('Erreur: ' + data.message, 'error');
        }
    })
    .catch(error => {
        showGalleryMessage('Erreur de communication avec le serveur', 'error');
    });
}

/**
 * Mettre à jour le compteur d'images
 */
function updateGalleryCount() {
    const countElement = document.getElementById('galleryCount');
    const items = document.querySelectorAll('.gallery-item');
    if (countElement) {
        countElement.textContent = items.length;
    }
}

/**
 * Afficher un message dans la galerie
 */
function showGalleryMessage(message, type) {
    const messageElement = document.getElementById('galleryMessage');
    if (messageElement) {
        messageElement.textContent = message;
        messageElement.className = 'message message--' + type;
        messageElement.style.display = 'block';
        
        // Masquer après 5 secondes
        setTimeout(() => {
            messageElement.style.display = 'none';
        }, 5000);
    }
}

/**
 * Rafraîchir les images de galerie avec cache busting (optimisé)
 */
function refreshGalleryImages() {
    const timestamp = Date.now();
    document.querySelectorAll('img[src*="assets/gallery/"]').forEach(img => {
        const baseUrl = img.src.split('?')[0];
        img.src = baseUrl + '?v=' + timestamp;
    });
}

/**
 * Afficher un message d'information pour la galerie
 */
function showGalleryMessage(message, type = 'info') {
    // Chercher un conteneur de messages existant ou le créer
    let messageContainer = document.getElementById('gallery-message-container');
    if (!messageContainer) {
        messageContainer = document.createElement('div');
        messageContainer.id = 'gallery-message-container';
        messageContainer.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            max-width: 400px;
        `;
        document.body.appendChild(messageContainer);
    }
    
    // Créer l'élément message
    const messageDiv = document.createElement('div');
    messageDiv.className = `gallery-message gallery-message-${type}`;
    
    const colors = {
        success: { bg: '#4CAF50', border: '#45a049' },
        error: { bg: '#f44336', border: '#da190b' },
        warning: { bg: '#ff9800', border: '#e68900' },
        info: { bg: '#2196F3', border: '#1976D2' }
    };
    
    const color = colors[type] || colors.info;
    
    messageDiv.style.cssText = `
        background-color: ${color.bg};
        color: white;
        padding: 12px 16px;
        margin-bottom: 10px;
        border-radius: 4px;
        border-left: 4px solid ${color.border};
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        animation: slideInRight 0.3s ease-out;
        cursor: pointer;
        font-size: 14px;
        line-height: 1.4;
    `;
    
    messageDiv.textContent = message;
    
    // Ajouter l'animation CSS si elle n'existe pas
    if (!document.getElementById('gallery-message-styles')) {
        const style = document.createElement('style');
        style.id = 'gallery-message-styles';
        style.textContent = `
            @keyframes slideInRight {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            .gallery-message:hover {
                opacity: 0.9;
            }
        `;
        document.head.appendChild(style);
    }
    
    // Supprimer au clic
    messageDiv.addEventListener('click', () => {
        messageDiv.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => {
            if (messageDiv.parentNode) {
                messageDiv.parentNode.removeChild(messageDiv);
            }
        }, 300);
    });
    
    // Ajouter au conteneur
    messageContainer.appendChild(messageDiv);
    
    // Supprimer automatiquement après 5 secondes
    setTimeout(() => {
        if (messageDiv.parentNode) {
            messageDiv.style.animation = 'fadeOut 0.3s ease-out';
            setTimeout(() => {
                if (messageDiv.parentNode) {
                    messageDiv.parentNode.removeChild(messageDiv);
                }
            }, 300);
        }
    }, 5000);
}
