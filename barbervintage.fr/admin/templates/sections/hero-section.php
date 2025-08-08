<!-- Section Hero Management -->
<section class="dashboard-section">
    <div class="dashboard-card">
        <h2 class="dashboard-card__title">Gestion Hero</h2>
        <div class="dashboard-card__contenu">
            
            <!-- Messages de retour -->
            <?php if (!empty($hero_message)): ?>
                <div class="message message--<?php echo $hero_message_type; ?>" style="margin-bottom: 1rem;">
                    <?php echo $hero_message; ?>
                </div>
            <?php endif; ?>
            
            <!-- Visionneuse Hero -->
            <div class="visionneuse-hero">
                <?php if ($hero_content && !empty($hero_content['filename'])): ?>
                    <?php 
                    // Utiliser le cache-busting pour s'assurer que l'image est à jour
                    require_once '../includes/cache-utils.php';
                    $heroImageUrl = getAssetUrl('assets/hero/' . $hero_content['filename']);
                    ?>
                    <img src="../<?php echo $heroImageUrl; ?>" 
                         alt="<?php echo htmlspecialchars($hero_content['alt_text'] ?? 'Hero image'); ?>" 
                         class="visionneuse-hero__image" id="heroPreview">
                <?php else: ?>
                    <div class="visionneuse-hero__placeholder">
                        <p>Aucune image hero configurée</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <!-- Formulaire d'upload -->
            <form method="POST" enctype="multipart/form-data" id="heroForm" style="margin-top: 1rem;">
                
                <input type="file" 
                       id="hero_file" 
                       name="hero_file" 
                       accept="image/jpeg,image/png,image/webp"
                       style="display: none;"
                       onchange="previewHeroImage(this)">
                
                <input type="hidden" 
                       name="hero_alt_text" 
                       value="Image hero - Vintage Barber Shop">
                
                <div class="actions-hero">
                    <button type="button" 
                            class="btn-admin btn-admin--secondaire" 
                            onclick="document.getElementById('hero_file').click()">
                        📁 Choisir une image
                    </button>
                    <button type="submit" 
                            class="btn-admin btn-admin--primaire"
                            id="uploadBtn"
                            disabled>
                        📤 Uploader
                    </button>
                </div>
                
                <div id="fileInfo" style="text-align: center; margin-top: 0.5rem; font-size: 0.9rem; color: var(--color-white); background-color: var(--color-tertiary); padding: 8px 15px; border-radius: 8px; display: none;">
                    <p>Fichier sélectionné: <span id="fileName"></span></p>
                </div>
                
            </form>
        </div>
    </div>
</section>
