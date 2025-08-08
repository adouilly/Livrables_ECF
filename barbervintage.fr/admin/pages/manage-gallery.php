
<?php
/**
 * Gestion de la Galerie - Vintage Barber Shop
 * Page d'administration pour gérer les images de la galerie
 */

// Initialisation de la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}

// Vérifier le timeout d'inactivité (2 minutes = 120 secondes)
$inactivity_timeout = 120;
if (isset($_SESSION['admin_last_activity']) && (time() - $_SESSION['admin_last_activity'] > $inactivity_timeout)) {
    session_unset();
    session_destroy();
    header('Location: login.php?session_expired=1');
    exit;
}

// Mettre à jour le timestamp de dernière activité
$_SESSION['admin_last_activity'] = time();

// Inclusion de la configuration et fonctions
require_once '../../includes/config.php';

// Messages d'erreur et de succès
$message = '';
$messageType = '';

// Traitement du formulaire d'ajout d'image
if (isset($_POST['add_gallery_image'])) {
    // Vérification du fichier uploadé
    if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] == 0) {
        
        // Vérifier le type de fichier
        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (in_array($_FILES['gallery_image']['type'], $allowedTypes)) {
            
            // Obtenir les dimensions de l'image
            list($width, $height) = getimagesize($_FILES['gallery_image']['tmp_name']);
            
            // Vérifier si l'image a le bon ratio 16:9
            // Tolérance de 1% pour tenir compte des arrondis
            $targetRatio = 16/9;
            $actualRatio = $width / $height;
            $tolerance = 0.01;
            
            if (abs($actualRatio - $targetRatio) <= $tolerance) {
                
                // Créer le répertoire assets/gallery s'il n'existe pas
                $upload_dir = '../../assets/gallery/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                
                // Générer un nom de fichier unique
                $filename = 'gallery-' . time() . '.' . pathinfo($_FILES['gallery_image']['name'], PATHINFO_EXTENSION);
                $uploadPath = $upload_dir . $filename;
                
                // Déplacer le fichier uploadé
                if (move_uploaded_file($_FILES['gallery_image']['tmp_name'], $uploadPath)) {
                    
                    // Récupérer la position maximale actuelle
                    $max_position_query = "SELECT MAX(display_order) as max_order FROM gallery_images";
                    $max_position_result = executeQuery($max_position_query)->fetch();
                    $display_order = ($max_position_result['max_order'] ?? 0) + 1;
                    
                    // Ajouter l'image à la base de données
                    $query = "INSERT INTO gallery_images 
                             (filename, alt_text, display_order, file_path)
                             VALUES (:filename, :alt_text, :display_order, :file_path)";
                    $params = [
                        ':filename' => $filename,
                        ':alt_text' => $_POST['gallery_alt'],
                        ':display_order' => $display_order,
                        ':file_path' => 'assets/gallery/' . $filename
                    ];
                    
                    if (executeQuery($query, $params)) {
                        $message = "L'image a été ajoutée à la galerie avec succès.";
                        $messageType = "success";
                    } else {
                        $message = "Erreur lors de l'ajout en base de données.";
                        $messageType = "error";
                    }
                    
                } else {
                    $message = "Erreur lors de l'upload du fichier.";
                    $messageType = "error";
                }
                
            } else {
                $message = "L'image doit avoir un ratio 16:9. Ratio actuel: " . round($actualRatio, 2);
                $messageType = "error";
            }
            
        } else {
            $message = "Format de fichier non autorisé. Utilisez JPG, PNG ou WEBP.";
            $messageType = "error";
        }
        
    } elseif (!isset($_FILES['gallery_image']) || $_FILES['gallery_image']['error'] != 4) {
        // Erreur 4 = pas de fichier soumis, donc on ignore cette condition si c'est le cas
        $message = "Erreur lors de l'upload du fichier (code: " . $_FILES['gallery_image']['error'] . ").";
        $messageType = "error";
    }
}

// Traitement de la suppression d'image
if (isset($_POST['delete_gallery_image']) && isset($_POST['image_id'])) {
    $image_id = (int)$_POST['image_id'];
    
    // Vérifier qu'il reste plus d'une image dans la galerie
    $count_query = "SELECT COUNT(*) as count FROM gallery_images";
    $count_result = executeQuery($count_query)->fetch();
    
    if ($count_result['count'] <= 1) {
        $message = "Impossible de supprimer la dernière image de la galerie. Vous devez en conserver au moins une.";
        $messageType = "error";
    } else {
        // Récupérer le nom du fichier à supprimer
        $file_query = "SELECT filename FROM gallery_images WHERE id = :id";
        $file_result = executeQuery($file_query, [':id' => $image_id])->fetch();
        
        if ($file_result) {
            // Supprimer l'enregistrement de la base de données
            $delete_query = "DELETE FROM gallery_images WHERE id = :id";
            if (executeQuery($delete_query, [':id' => $image_id])) {
                
                // Supprimer le fichier physique
                $file_path = '../../assets/gallery/' . $file_result['filename'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
                
                $message = "L'image a été supprimée avec succès.";
                $messageType = "success";
            } else {
                $message = "Erreur lors de la suppression de l'image.";
                $messageType = "error";
            }
        } else {
            $message = "Image introuvable.";
            $messageType = "error";
        }
    }
}

// Traitement de la mise à jour des positions
if (isset($_POST['update_positions']) && isset($_POST['positions'])) {
    $positions = $_POST['positions'];
    $success = true;
    
    foreach ($positions as $id => $display_order) {
        $update_query = "UPDATE gallery_images SET display_order = :display_order WHERE id = :id";
        $result = executeQuery($update_query, [':display_order' => $display_order, ':id' => $id]);
        
        if (!$result) {
            $success = false;
            break;
        }
    }
    
    if ($success) {
        $message = "L'ordre des images a été mis à jour avec succès.";
        $messageType = "success";
    } else {
        $message = "Erreur lors de la mise à jour de l'ordre des images.";
        $messageType = "error";
    }
}

// Récupérer toutes les images de la galerie
$gallery_query = "SELECT id, filename, alt_text, display_order, file_path
                 FROM gallery_images
                 ORDER BY display_order ASC, id DESC";
$gallery_images = executeQuery($gallery_query)->fetchAll();

// Fonction pour exécuter les requêtes SQL
function executeQuery($sql, $params = []) {
    global $db;
    try {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        // Log error
        error_log("Erreur SQL: " . $e->getMessage());
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Galerie - Vintage Barber Shop</title>
    <!-- Styles CSS -->
    <link rel="stylesheet" href="../../css/common/variables.css">
    <link rel="stylesheet" href="../../css/common/reset.css">
    <link rel="stylesheet" href="../../css/back/back.css">
    <link rel="stylesheet" href="../../css/back/back-content.css">
    <!-- Polices de caractères -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Grenze+Gotisch:wght@400;700&family=Kings&family=Nabla&family=Roboto:wght@400;700&family=Yatra+One&display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon" href="../../assets/favicon/favicon.png" type="image/png">
    <!-- Sortable.js pour le drag & drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
</head>
<body class="admin-page">
    <!-- En-tête -->
    <header class="header admin-header">
        <div class="header__container">
            <div class="header__logo">
                <img src="../../assets/img/logo.png" alt="Logo Vintage Barber Shop" class="header__logo-img">
            </div>
            <div class="header__title">
                <h1>Vintage Barber Shop</h1>
                <h2>Administration - Gestion Galerie</h2>
            </div>
            <div class="header__actions">
                <a href="../dashboard.php" class="header__btn">Dashboard</a>
                <a href="../logout.php" class="header__logout-btn">Déconnexion</a>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="admin-main">
        <div class="admin-info-bar">
            <div class="admin-info-container">
                <div class="admin-breadcrumb">
                    <a href="../dashboard.php">Dashboard</a> &gt; Gestion Galerie
                </div>
            </div>
        </div>
        
        <!-- Section Gallery Management -->
        <section class="gallery-back">
            <div class="galerie-admin__conteneur">
                <h2 class="galerie-admin__titre">Gestion de la galerie</h2>
                
                <?php if (!empty($message)): ?>
                    <div class="message message--<?php echo $messageType; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Formulaire d'ajout d'image -->
                <div class="galerie-admin__formulaire">
                    <h3 class="galerie-admin__soustitre">Ajouter une image</h3>
                    <form class="galerie-admin__formulaire-form" method="POST" enctype="multipart/form-data">
                        <div class="galerie-admin__groupe-formulaire">
                            <label for="gallery_image" class="galerie-admin__etiquette">Image (ratio 16:9)</label>
                            <input type="file" id="gallery_image" name="gallery_image" class="galerie-admin__champ" accept=".jpg,.jpeg,.png,.webp" required>
                        </div>
                        
                        <div class="galerie-admin__groupe-formulaire">
                            <label for="gallery_alt" class="galerie-admin__etiquette">Titre et texte alternatif</label>
                            <input type="text" id="gallery_alt" name="gallery_alt" class="galerie-admin__champ" 
                                   placeholder="Ex: Coupe de cheveux moderne" required>
                        </div>
                        
                        <div class="galerie-admin__exigences">
                            <p><strong>Exigences :</strong></p>
                            <ul>
                                <li>Format : JPG, PNG ou WEBP</li>
                                <li>Ratio : 16:9 (ex: 1920px × 1080px)</li>
                                <li>Poids maximum : 1Mo</li>
                            </ul>
                        </div>
                        
                        <div class="galerie-admin__groupe-formulaire">
                            <button type="submit" name="add_gallery_image" class="galerie-admin__bouton">Ajouter à la galerie</button>
                        </div>
                    </form>
                </div>
                
                <!-- Affichage et réorganisation des images -->
                <div class="galerie-admin__actuel">
                    <h3 class="galerie-admin__soustitre">Images actuelles</h3>
                    <p class="galerie-admin__instruction">Glissez-déposez les images pour réorganiser leur ordre d'affichage</p>
                    
                    <?php if (!empty($gallery_images)): ?>
                        <form method="POST" id="positions_form">
                            <div class="galerie-admin__grille" id="sortable_gallery">
                                <?php foreach ($gallery_images as $image): ?>
                                    <div class="galerie-admin__item" data-id="<?php echo $image['id']; ?>">
                                        <div class="galerie-admin__apercu">
                                            <?php 
                                            // Utiliser file_path s'il existe, sinon construire le chemin
                                            $image_path = !empty($image['file_path']) 
                                                ? '../' . $image['file_path'] 
                                                : '../../assets/gallery/' . $image['filename'];
                                            ?>
                                            <img src="<?php echo htmlspecialchars($image_path); ?>" 
                                                 alt="<?php echo htmlspecialchars($image['alt_text']); ?>">
                                        </div>
                                        <div class="galerie-admin__details">
                                            <h4 class="galerie-admin__titre-image"><?php echo htmlspecialchars($image['alt_text']); ?></h4>
                                            <p class="galerie-admin__ordre">Ordre: <?php echo $image['display_order']; ?></p>
                                            <input type="hidden" name="positions[<?php echo $image['id']; ?>]" value="<?php echo $image['display_order']; ?>" class="position-input">
                                            <form method="POST" class="galerie-admin__form-suppression">
                                                <input type="hidden" name="image_id" value="<?php echo $image['id']; ?>">
                                                <button type="submit" name="delete_gallery_image" class="galerie-admin__bouton-suppression"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette image ?');">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="galerie-admin__actions">
                                <button type="submit" name="update_positions" class="galerie-admin__bouton galerie-admin__bouton--sauvegarder">
                                    Enregistrer l'ordre
                                </button>
                            </div>
                        </form>
                    <?php else: ?>
                        <p class="galerie-admin__aucune-image">Aucune image dans la galerie</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer admin-footer">
        <span>Copyright © 2025 barbervintage.fr | Propulsé par Atlantis Designs</span>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser Sortable pour le drag & drop
            var sortableGallery = document.getElementById('sortable_gallery');
            if (sortableGallery) {
                var sortable = Sortable.create(sortableGallery, {
                    animation: 150,
                    ghostClass: 'galerie-admin__item--fantome',
                    onEnd: function() {
                        // Mettre à jour les positions après le déplacement
                        updatePositions();
                    }
                });
            }
            
            function updatePositions() {
                // Mettre à jour les champs cachés avec les nouvelles positions
                var items = document.querySelectorAll('.galerie-admin__item');
                items.forEach(function(item, index) {
                    var id = item.getAttribute('data-id');
                    var input = item.querySelector('.position-input');
                    if (input) {
                        input.value = index + 1;
                    }
                });
            }
        });
    </script>
</body>
</html>
