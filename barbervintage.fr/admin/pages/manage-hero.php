<?php
/**
 * Gestion de l'image Hero - Vintage Barber Shop
 * Interface moderne pour gérer l'image hero avec visionneuse
 */

// Initialisation de la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Inclusion de la configuration
require_once '../../includes/config.php';

// Messages
$message = '';
$messageType = '';

// Traitement du formulaire de mise à jour
if (isset($_POST['update_hero'])) {
    if (isset($_FILES['hero_image']) && $_FILES['hero_image']['error'] == 0) {
        
            } else {
                $message = 'Image rejetée. Dimensions requises: 851px × 315px. Vos dimensions: ' . $width . 'px × ' . $height . 'px';
                $messageType = 'error';
        // Vérifier le type de fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        $fileType = $_FILES['hero_image']['type'];
        
        if (in_array($fileType, $allowedTypes)) {
            // Obtenir les dimensions
            list($width, $height) = getimagesize($_FILES['hero_image']['tmp_name']);
            
            // Vérifier les dimensions recommandées (851px × 315px)
            if ($width == 851 && $height == 315) {
                
                // Générer un nom de fichier unique
                $extension = pathinfo($_FILES['hero_image']['name'], PATHINFO_EXTENSION);
                $filename = 'hero.' . $extension;
                $destination = '../../assets/hero/' . $filename;
                
                // Déplacer le fichier
                if (move_uploaded_file($_FILES['hero_image']['tmp_name'], $destination)) {
                    
                    // Mettre à jour la base de données - table hero_content
                    try {
                        $alt_text = $_POST['alt_text'] ?? 'Image hero - Vintage Barber Shop';
                        $file_path = 'assets/hero/' . $filename;
                        
                        // Vérifier s'il existe déjà un enregistrement
                        $check = $db->query("SELECT COUNT(*) FROM hero_content")->fetchColumn();
                        
                        if ($check > 0) {
                            // Mettre à jour l'enregistrement existant
                            $stmt = $db->prepare("UPDATE hero_content SET filename = ?, alt_text = ?, file_path = ? WHERE id = 1");
                            $stmt->execute([$filename, $alt_text, $file_path]);
                        } else {
                            // Insérer un nouvel enregistrement
                            $stmt = $db->prepare("INSERT INTO hero_content (id, filename, alt_text, file_path) VALUES (1, ?, ?, ?)");
                            $stmt->execute([$filename, $alt_text, $file_path]);
                        }
                        
                        $message = 'Image hero mise à jour avec succès !';
                        $messageType = 'success';
                        
                    } catch (PDOException $e) {
                        $message = 'Erreur lors de la mise à jour en base de données.';
                        $messageType = 'error';
                        error_log("Erreur BDD: " . $e->getMessage());
                    }
                    
                } else {
                    $message = 'Erreur lors du téléchargement du fichier.';
                    $messageType = 'error';
                }
                
            } else {
                $message = 'Image rejetée. Dimensions requises: 851px × 315px. Vos dimensions: ' . $width . 'px × ' . $height . 'px';
                $messageType = 'error';
            }
            
        } else {
            $message = 'Type de fichier non autorisé. Utilisez JPG, PNG ou WebP.';
            $messageType = 'error';
        }
        
    } else {
        $message = 'Aucun fichier sélectionné ou erreur lors du téléchargement.';
        $messageType = 'error';
    }
}

// Récupérer l'image hero actuelle
$current_hero = null;
try {
    // Utiliser la fonction getHeroContent() de config.php
    $current_hero = getHeroContent();
} catch (Exception $e) {
    error_log("Erreur récupération hero: " . $e->getMessage());
}

// Si aucune image en BDD, utiliser l'image par défaut
if (!$current_hero) {
    $current_hero = [
        'filename' => 'hero.jpg',
        'alt_text' => 'Image hero par défaut - Vintage Barber Shop',
        'created_at' => 'Image par défaut'
    ];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Image Hero - Vintage Barber Shop</title>
    
    <!-- Favicon -->
    <link rel="icon" href="../../assets/favicon/favicon.png" type="image/png">
    
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/common/variables.css">
    <link rel="stylesheet" href="../../css/back/back.css">
    <link rel="stylesheet" href="../../css/back/back-content.css">
</head>
<body>
    <!-- Header Admin -->
    <header class="admin-header">
        <div class="admin-header__container">
            <div class="admin-header__brand">
                <h1 class="admin-header__title">🎯 Gestion Image Hero</h1>
                <span class="admin-header__subtitle">Interface de gestion</span>
            </div>
            <div class="admin-header__actions">
                <a href="../dashboard.php" class="btn-admin btn-admin--secondaire">← Retour Dashboard</a>
                <a href="../logout.php" class="btn-admin btn-admin--danger">Déconnexion</a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="admin-main">
        <div class="admin-container">
            
            <!-- Messages -->
            <?php if ($message): ?>
                <div class="alert alert--<?php echo $messageType; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Section Visionneuse Hero -->
            <section class="visionneuse-hero">
                <div class="visionneuse-hero__container">
                    <h2 class="visionneuse-hero__titre">🖼️ Image Hero Actuelle</h2>
                    
                    <div class="visionneuse-hero__apercu">
                        <div class="visionneuse-hero__cadre">
                            <img src="../../assets/hero/<?php echo htmlspecialchars($current_hero['filename']); ?>" 
                                 alt="<?php echo htmlspecialchars($current_hero['alt_text']); ?>" 
                                 class="visionneuse-hero__image"
                                 id="heroPreview">
                        </div>
                        
                        <div class="visionneuse-hero__info">
                            <p><strong>📁 Fichier:</strong> <?php echo htmlspecialchars($current_hero['filename']); ?></p>
                            <p><strong>📝 Alt text:</strong> <?php echo htmlspecialchars($current_hero['alt_text']); ?></p>
                            <p><strong>📅 Mise à jour:</strong> <?php echo isset($current_hero['updated_at']) ? $current_hero['updated_at'] : $current_hero['created_at']; ?></p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Upload -->
            <section class="hero-upload">
                <div class="hero-upload__container">
                    <h2 class="hero-upload__title">📤 Changer l'Image Hero</h2>
                    
                    <form method="POST" enctype="multipart/form-data" class="hero-form" id="heroForm">
                        
                        <!-- Sélection fichier -->
                        <div class="form-group">
                            <label for="hero_image" class="form-label">Sélectionner une nouvelle image</label>
                            <div class="file-input-wrapper">
                                <input type="file" 
                                       id="hero_image" 
                                       name="hero_image" 
                                       accept="image/jpeg,image/png,image/webp"
                                       class="file-input"
                                       required>
                                <label for="hero_image" class="file-input-label">
                                    📁 Choisir un fichier...
                                </label>
                                <span class="file-input-feedback" id="fileSelected">Aucun fichier sélectionné</span>
                            </div>
                        </div>

                        <!-- Preview temporaire -->
                        <div class="temp-preview" id="tempPreview" style="display: none;">
                            <h3>🔍 Aperçu de la nouvelle image</h3>
                            <div class="temp-preview__frame">
                                <img id="tempImage" class="temp-preview__image" alt="Aperçu temporaire">
                            </div>
                            <div class="temp-preview__info" id="tempInfo"></div>
                        </div>

                        <!-- Alt text -->
                        <div class="form-group">
                            <label for="alt_text" class="form-label">Texte alternatif (optionnel)</label>
                            <input type="text" 
                                   id="alt_text" 
                                   name="alt_text" 
                                   class="form-input"
                                   placeholder="Description de l'image..."
                                   value="Image hero - Vintage Barber Shop">
                        </div>

                        <!-- Recommandations -->
                        <div class="recommendations">
                            <h3>📋 Recommandations</h3>
                            <ul>
                                <li><strong>Dimensions:</strong> 851px × 315px (exactement)</li>
                                <li><strong>Formats:</strong> JPG, PNG ou WebP</li>
                                <li><strong>Poids:</strong> Max 2 MB (compressez si nécessaire)</li>
                                <li><strong>Qualité:</strong> Privilégiez les images nettes et contrastées</li>
                            </ul>
                        </div>

                        <!-- Bouton de validation -->
                        <div class="form-actions">
                            <button type="submit" name="update_hero" class="btn-admin btn-admin--primaire" id="updateBtn" disabled>
                                ✅ Mettre à jour l'image hero
                            </button>
                            <button type="button" class="btn-admin btn-admin--secondaire" onclick="resetForm()">
                                🔄 Réinitialiser
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </main>

    <!-- JavaScript -->
    <script>
        const fileInput = document.getElementById('hero_image');
        const fileSelectedSpan = document.getElementById('fileSelected');
        const tempPreview = document.getElementById('tempPreview');
        const tempImage = document.getElementById('tempImage');
        const tempInfo = document.getElementById('tempInfo');
        const updateBtn = document.getElementById('updateBtn');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                fileSelectedSpan.textContent = file.name;
                fileSelectedSpan.className = 'file-input-feedback file-input-feedback--success';
                
                // Créer un aperçu
                const reader = new FileReader();
                reader.onload = function(e) {
                    tempImage.src = e.target.result;
                    
                    // Créer un objet Image pour obtenir les dimensions
                    const img = new Image();
                    img.onload = function() {
                        const width = this.width;
                        const height = this.height;
                        const fileSize = (file.size / 1024 / 1024).toFixed(2); // MB
                        
                        let dimensionsCheck = '';
                        let dimensionsClass = '';
                        
                        if (width === 851 && height === 315) {
                            dimensionsCheck = '✅ Dimensions parfaites !';
                            dimensionsClass = 'success';
                            updateBtn.disabled = false;
                        } else {
                            dimensionsCheck = `❌ Dimensions incorrectes ! Requis: 851×315px, Trouvé: ${width}×${height}px`;
                            dimensionsClass = 'error';
                            updateBtn.disabled = true;
                        }
                        
                        tempInfo.innerHTML = `
                            <p><strong>📐 Dimensions:</strong> <span class="${dimensionsClass}">${dimensionsCheck}</span></p>
                            <p><strong>📦 Taille:</strong> ${fileSize} MB</p>
                            <p><strong>🎨 Format:</strong> ${file.type}</p>
                        `;
                        
                        tempPreview.style.display = 'block';
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
                
            } else {
                fileSelectedSpan.textContent = 'Aucun fichier sélectionné';
                fileSelectedSpan.className = 'file-input-feedback';
                tempPreview.style.display = 'none';
                updateBtn.disabled = true;
            }
        });

        function resetForm() {
            document.getElementById('heroForm').reset();
            fileSelectedSpan.textContent = 'Aucun fichier sélectionné';
            fileSelectedSpan.className = 'file-input-feedback';
            tempPreview.style.display = 'none';
            updateBtn.disabled = true;
        }

        // Confirmation avant soumission
        document.getElementById('heroForm').addEventListener('submit', function(e) {
            if (!confirm('Êtes-vous sûr de vouloir remplacer l\'image hero actuelle ?')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
