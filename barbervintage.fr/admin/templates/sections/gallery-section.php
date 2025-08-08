<!-- Section Galerie -->
<section class="dashboard-section section-galerie">
    <div class="dashboard-card">
        <div class="dashboard-card__contenu">
            
            <!-- Messages de retour -->
            <div id="galleryMessage" style="display: none;" class="message"></div>
            
            <div class="statistiques-galerie">
                <p><strong>Total des images en galerie:</strong> <span id="galleryCount"><?php echo $gallery_count; ?></span></p>
            </div>
            
            <p class="dashboard-card__description" style="text-align: center; margin: 1.5rem 0;">
                Gérez les images de la galerie affichées sur le site. Glissez-déposez pour réorganiser l'ordre.
            </p>
            
            <?php 
            // Récupérer les images de la galerie pour affichage
            $gallery_images = [];
            try {
                // IMPORTANT: ORDER BY display_order pour afficher dans le bon ordre
                $stmt = $db->query("SELECT id, filename, alt_text, display_order FROM gallery_images ORDER BY display_order ASC, id ASC");
                $gallery_images = $stmt->fetchAll();
            } catch (PDOException $e) {
                error_log("Erreur récupération galerie: " . $e->getMessage());
            }
            ?>
            
            <?php if (!empty($gallery_images)): ?>
                <div class="grille-galerie" id="galleryGrid">
                    <?php foreach ($gallery_images as $image): ?>
                        <div class="element-galerie" data-id="<?php echo $image['id']; ?>" draggable="true">
                            <div class="element-galerie__numero"><?php echo $image['display_order']; ?></div>
                            <img src="../assets/gallery/<?php echo htmlspecialchars($image['filename']); ?>?v=<?php echo time(); ?>" 
                                 alt="<?php echo htmlspecialchars($image['alt_text']); ?>" 
                                 class="element-galerie__img">
                            <div class="element-galerie__actions">
                                <button class="element-galerie__suppression" onclick="deleteGalleryImage(<?php echo $image['id']; ?>)">
                                    🗑️ Supprimer
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- Bouton de sauvegarde de l'ordre (masqué par défaut) -->
                <div style="text-align: center; margin: 1.5rem 0;">
                    <button id="saveGalleryOrder" 
                            class="btn-admin btn-admin--primaire" 
                            style="display: none;">
                        💾 Mettre à jour l'ordre
                    </button>
                    <p style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">
                        Glissez-déposez les images pour réorganiser l'ordre d'affichage
                    </p>
                </div>
            <?php else: ?>
                <p class="no-content">Aucune image dans la galerie.</p>
            <?php endif; ?>
            
            <!-- Formulaire d'upload inline - Maintenant en bas -->
            <div class="gallery-upload-section">
                <form id="galleryUploadForm" enctype="multipart/form-data" style="margin-bottom: 1.5rem;">
                    <div class="actions-galerie-upload">
                        <input type="file" 
                               id="gallery_files" 
                               name="gallery_files[]" 
                               accept="image/jpeg,image/png,image/webp"
                               multiple
                               style="display: none;">
                        
                        <button type="button" 
                                class="btn-admin btn-admin--secondaire" 
                                onclick="document.getElementById('gallery_files').click()">
                            📁 Choisir des images
                        </button>
                        
                        <button type="button" 
                                class="btn-admin btn-admin--primaire"
                                id="uploadGalleryBtn"
                                disabled>
                            📤 Uploader les images
                        </button>
                    </div>
                    
                    <div id="galleryFilePreview" style="display: none; margin-top: 1rem;">
                        <p><strong>Images sélectionnées:</strong></p>
                        <ul id="galleryFileList" style="list-style: none; padding: 0;"></ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
