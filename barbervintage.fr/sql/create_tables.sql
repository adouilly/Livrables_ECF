-- Script de création des tables - Vintage Barber Shop
-- Base de données: vintage_barber_db

-- Table des administrateurs
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table du contenu hero
CREATE TABLE IF NOT EXISTS `hero_content` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `file_path` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table des images de galerie
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `display_order` int(11) NOT NULL DEFAULT 1,
  `file_path` varchar(500) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertion de données par défaut

-- Admin par défaut (mot de passe: admin123)
INSERT INTO `admins` (`id`, `username`, `email`, `password_hash`) VALUES
(1, 'admin', 'admin@barbervintage.fr', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');




