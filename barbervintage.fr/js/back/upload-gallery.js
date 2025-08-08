/**
 * Script pour la page d'upload de galerie
 * Vintage Barber Shop - Admin Panel
 */

document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation des fichiers sélectionnés
    const fileInput = document.getElementById('gallery_files');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const files = this.files;
            const preview = document.getElementById('filePreview');
            const fileList = document.getElementById('fileList');
            
            if (files.length > 0) {
                fileList.innerHTML = '';
                for (let i = 0; i < files.length; i++) {
                    const li = document.createElement('li');
                    li.textContent = files[i].name + ' (' + Math.round(files[i].size / 1024) + ' KB)';
                    fileList.appendChild(li);
                }
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }
        });
    }
});
