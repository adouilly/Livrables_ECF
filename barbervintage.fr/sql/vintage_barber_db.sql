-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 08 août 2025 à 10:00
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `vintage_barber_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password_hash`) VALUES
(2, 'admin', 'admin@vintagebarber.com', '$2y$10$I51xetPozTqPxjgAfKPJ8OeuVaVuj9F862.Q35N05q18v2ZMoPvvS');

-- --------------------------------------------------------

--
-- Structure de la table `gallery_images`
--

DROP TABLE IF EXISTS `gallery_images`;
CREATE TABLE IF NOT EXISTS `gallery_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display_order` int DEFAULT '0',
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assets/gallery/',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `gallery_images`
--

INSERT INTO `gallery_images` (`id`, `filename`, `alt_text`, `display_order`, `file_path`) VALUES
(1, 'barber_vintage (1).jpg', 'Barbier vintage coupe homme classique salon rétro', 2, 'assets/gallery/'),
(2, 'barber_vintage (2).jpg', 'Coiffure masculine barbe rasage barbershop traditionnel', 5, 'assets/gallery/'),
(3, 'barber_vintage (3).jpg', 'Salon de coiffure homme vintage accessoires de barbier professionnel', 4, 'assets/gallery/'),
(4, 'barber_vintage (4).jpg', 'Taille de barbe soins homme produits barbier authentique', 8, 'assets/gallery/'),
(5, 'barber_vintage (5).jpg', 'Coupe cheveux homme style rétro salon barbier décoration vintage', 6, 'assets/gallery/'),
(13, 'gallery-1754423898-0.jpg', 'Image galerie - Vintage Barber Shop', 3, 'assets/gallery/gallery-1754423898-0.jpg'),
(11, 'gallery-1754419997-1.jpg', 'Image galerie - Vintage Barber Shop', 7, 'assets/gallery/gallery-1754419997-1.jpg'),
(30, 'gallery-1754641733-0.jpg', 'Image galerie - Vintage Barber Shop', 1, 'assets/gallery/gallery-1754641733-0.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `hero_content`
--

DROP TABLE IF EXISTS `hero_content`;
CREATE TABLE IF NOT EXISTS `hero_content` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_text` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assets/hero/',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `hero_content`
--

INSERT INTO `hero_content` (`id`, `filename`, `alt_text`, `file_path`) VALUES
(1, 'hero.jpg', 'Image hero - Vintage Barber Shop', 'assets/hero/hero.jpg');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
