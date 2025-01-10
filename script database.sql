-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 10, 2025 at 08:28 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elmountada`
--

-- --------------------------------------------------------

--
-- Table structure for table `abonnement_classique`
--

DROP TABLE IF EXISTS `abonnement_classique`;
CREATE TABLE IF NOT EXISTS `abonnement_classique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_type_abonnement` int NOT NULL,
  `avantages` text,
  PRIMARY KEY (`id`),
  KEY `id_type_abonnement` (`id_type_abonnement`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `abonnement_classique`
--

INSERT INTO `abonnement_classique` (`id`, `id_type_abonnement`, `avantages`) VALUES
(1, 1, 'Accès aux événements de base'),
(2, 1, 'Accès aux événements de base, newsletter mensuelle'),
(3, 4, 'Accès aux événements de base, réduction de 10% sur les dons');

-- --------------------------------------------------------

--
-- Table structure for table `abonnement_premium`
--

DROP TABLE IF EXISTS `abonnement_premium`;
CREATE TABLE IF NOT EXISTS `abonnement_premium` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_type_abonnement` int NOT NULL,
  `services_exclusifs` text,
  PRIMARY KEY (`id`),
  KEY `id_type_abonnement` (`id_type_abonnement`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `abonnement_premium`
--

INSERT INTO `abonnement_premium` (`id`, `id_type_abonnement`, `services_exclusifs`) VALUES
(1, 2, 'Accès VIP aux événements'),
(2, 2, 'Accès VIP aux événements, support prioritaire, cadeau de bienvenue'),
(3, 5, 'Accès VIP aux événements, réduction de 20% sur les dons, consultation gratuite');

-- --------------------------------------------------------

--
-- Table structure for table `actualites`
--

DROP TABLE IF EXISTS `actualites`;
CREATE TABLE IF NOT EXISTS `actualites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `actualites`
--

INSERT INTO `actualites` (`id`, `titre`, `description`, `image`, `cree_le`, `modifie_le`) VALUES
(1, 'Une Histoire de Réussites', 'Comment notre communauté a transformé la vie de Rym...', '', '2025-01-02 03:35:25', '2025-01-09 09:46:21'),
(2, 'Impact Communautaires', 'Découvrez comment nos bénévoles ont créé un changement...', '', '2025-01-02 03:35:25', '2025-01-09 09:43:33'),
(3, 'Projet Réussi', 'Le projet de rénovation du centre communautaire est terminé...', 'Images/image3.png', '2025-01-02 03:35:25', '2025-01-02 03:35:25'),
(4, 'Une Histoire Inspirante', 'Rym, 8 ans, a pu bénéficier d\'une opération grâce à vos dons...', 'Images/image4.png', '2025-01-02 03:35:25', '2025-01-02 03:35:25'),
(14, '55555', 'dfh', 'C:/wamp64/www/projet/views/admin/uploads/beach_cleaning.jpg', '2025-01-09 09:47:23', '2025-01-09 09:47:23'),
(12, 'Actualite TEST', 'je veux tester l\'inseertipon des actualites ', 'admin/uploads/blood_donation.jpg', '2025-01-09 09:43:10', '2025-01-09 09:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `administrateurs`
--

DROP TABLE IF EXISTS `administrateurs`;
CREATE TABLE IF NOT EXISTS `administrateurs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_utilisateur` varchar(50) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `role` enum('SuperAdmin','Admin') DEFAULT 'Admin',
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom_utilisateur` (`nom_utilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `administrateurs`
--

INSERT INTO `administrateurs` (`id`, `nom_utilisateur`, `mot_de_passe`, `role`, `cree_le`, `modifie_le`) VALUES
(1, 'admin_super', '$2y$10$example_hash', 'SuperAdmin', '2025-01-09 08:34:36', '2025-01-09 08:34:36');

-- --------------------------------------------------------

--
-- Table structure for table `avis_partenaires`
--

DROP TABLE IF EXISTS `avis_partenaires`;
CREATE TABLE IF NOT EXISTS `avis_partenaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `id_partenaire` int NOT NULL,
  `note` int NOT NULL,
  `commentaire` text,
  `date_avis` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_membre` (`id_membre`),
  KEY `id_partenaire` (`id_partenaire`)
) ;

-- --------------------------------------------------------

--
-- Table structure for table `benevoles`
--

DROP TABLE IF EXISTS `benevoles`;
CREATE TABLE IF NOT EXISTS `benevoles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `evenement` varchar(100) NOT NULL,
  `id_statut_benevolat` int NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_membre` (`id_membre`),
  KEY `id_statut_benevolat` (`id_statut_benevolat`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `benevoles`
--

INSERT INTO `benevoles` (`id`, `id_membre`, `evenement`, `id_statut_benevolat`, `cree_le`, `modifie_le`) VALUES
(1, 1, 'Collecte de fonds', 1, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(2, 2, 'Distribution alimentaire', 2, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(3, 3, 'Sensibilisation', 1, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(4, 4, 'Nettoyage communautaire', 3, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(5, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:53:29', '2025-01-10 07:53:29'),
(6, 2, 'Collecte de Sang', 2, '2025-01-10 07:53:29', '2025-01-10 07:53:29'),
(7, 3, 'Marathon Caritatif', 1, '2025-01-10 07:53:29', '2025-01-10 07:53:29'),
(8, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:54:06', '2025-01-10 07:54:06'),
(9, 2, 'Collecte de Sang', 2, '2025-01-10 07:54:06', '2025-01-10 07:54:06'),
(10, 3, 'Marathon Caritatif', 1, '2025-01-10 07:54:06', '2025-01-10 07:54:06'),
(11, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:54:24', '2025-01-10 07:54:24'),
(12, 2, 'Collecte de Sang', 2, '2025-01-10 07:54:24', '2025-01-10 07:54:24'),
(13, 3, 'Marathon Caritatif', 1, '2025-01-10 07:54:24', '2025-01-10 07:54:24'),
(14, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:54:45', '2025-01-10 07:54:45'),
(15, 2, 'Collecte de Sang', 2, '2025-01-10 07:54:45', '2025-01-10 07:54:45'),
(16, 3, 'Marathon Caritatif', 1, '2025-01-10 07:54:45', '2025-01-10 07:54:45'),
(17, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:55:11', '2025-01-10 07:55:11'),
(18, 2, 'Collecte de Sang', 2, '2025-01-10 07:55:11', '2025-01-10 07:55:11'),
(19, 3, 'Marathon Caritatif', 1, '2025-01-10 07:55:11', '2025-01-10 07:55:11'),
(20, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(21, 2, 'Collecte de Sang', 2, '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(22, 3, 'Marathon Caritatif', 1, '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(23, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(24, 2, 'Collecte de Sang', 2, '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(25, 3, 'Marathon Caritatif', 1, '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(26, 1, 'Nettoyage de Plage', 1, '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(27, 2, 'Collecte de Sang', 2, '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(28, 3, 'Marathon Caritatif', 1, '2025-01-10 07:59:21', '2025-01-10 07:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `categorie_partenaire`
--

DROP TABLE IF EXISTS `categorie_partenaire`;
CREATE TABLE IF NOT EXISTS `categorie_partenaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categorie_partenaire`
--

INSERT INTO `categorie_partenaire` (`id`, `nom`) VALUES
(1, 'Hôtel'),
(2, 'Clinique'),
(3, 'École'),
(4, 'Agence de voyage');

-- --------------------------------------------------------

--
-- Table structure for table `demandes_aides`
--

DROP TABLE IF EXISTS `demandes_aides`;
CREATE TABLE IF NOT EXISTS `demandes_aides` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `date_naissance` date NOT NULL,
  `type_aide` varchar(50) NOT NULL,
  `description` text,
  `fichier` text,
  `numero_identite` varchar(50) NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` enum('En attente','Approuvée','Rejetée') DEFAULT 'En attente',
  PRIMARY KEY (`id`),
  KEY `numero_identite` (`numero_identite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dons`
--

DROP TABLE IF EXISTS `dons`;
CREATE TABLE IF NOT EXISTS `dons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `montant` decimal(10,2) NOT NULL,
  `recu` text,
  `date_don` date NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` enum('En attente','Validé','Rejeté') DEFAULT 'En attente',
  PRIMARY KEY (`id`),
  KEY `id_membre` (`id_membre`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `dons`
--

INSERT INTO `dons` (`id`, `id_membre`, `montant`, `recu`, `date_don`, `cree_le`, `modifie_le`, `statut`) VALUES
(1, 1, 100.50, 'Reçu pour don mensuel', '2023-10-01', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'Validé'),
(2, 2, 200.00, NULL, '2023-10-02', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'En attente'),
(3, 3, 50.75, 'Reçu pour don ponctuel', '2023-10-03', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'Validé'),
(4, 4, 300.00, NULL, '2023-10-04', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'Rejeté'),
(5, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:53:29', '2025-01-10 07:53:29', 'Validé'),
(6, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:53:29', '2025-01-10 07:53:29', 'En attente'),
(7, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:53:29', '2025-01-10 07:53:29', 'Validé'),
(8, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:54:06', '2025-01-10 07:54:06', 'Validé'),
(9, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:54:06', '2025-01-10 07:54:06', 'En attente'),
(10, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:54:06', '2025-01-10 07:54:06', 'Validé'),
(11, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:54:24', '2025-01-10 07:54:24', 'Validé'),
(12, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:54:24', '2025-01-10 07:54:24', 'En attente'),
(13, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:54:24', '2025-01-10 07:54:24', 'Validé'),
(14, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:54:45', '2025-01-10 07:54:45', 'Validé'),
(15, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:54:45', '2025-01-10 07:54:45', 'En attente'),
(16, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:54:45', '2025-01-10 07:54:45', 'Validé'),
(17, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:55:11', '2025-01-10 07:55:11', 'Validé'),
(18, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:55:11', '2025-01-10 07:55:11', 'En attente'),
(19, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:55:11', '2025-01-10 07:55:11', 'Validé'),
(20, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:55:29', '2025-01-10 07:55:29', 'Validé'),
(21, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:55:29', '2025-01-10 07:55:29', 'En attente'),
(22, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:55:29', '2025-01-10 07:55:29', 'Validé'),
(23, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:58:43', '2025-01-10 07:58:43', 'Validé'),
(24, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:58:43', '2025-01-10 07:58:43', 'En attente'),
(25, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:58:43', '2025-01-10 07:58:43', 'Validé'),
(26, 1, 100.50, 'recu1.jpg', '2023-10-01', '2025-01-10 07:59:21', '2025-01-10 07:59:21', 'Validé'),
(27, 2, 200.00, NULL, '2023-10-02', '2025-01-10 07:59:21', '2025-01-10 07:59:21', 'En attente'),
(28, 3, 50.75, 'recu3.jpg', '2023-10-03', '2025-01-10 07:59:21', '2025-01-10 07:59:21', 'Validé');

-- --------------------------------------------------------

--
-- Table structure for table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
CREATE TABLE IF NOT EXISTS `evenements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `evenements`
--

INSERT INTO `evenements` (`id`, `nom`, `description`, `image`, `date_debut`, `date_fin`, `cree_le`, `modifie_le`) VALUES
(1, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'Images/beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(2, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'Images/blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(3, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'Images/marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(4, 'Atelier de Formation', 'Atelier de formation pour les bénévoles sur la gestion des projets.', 'Images/training_workshop.jpg', '2024-04-10', '2024-04-11', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(5, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:53:29', '2025-01-10 07:53:29'),
(6, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:53:29', '2025-01-10 07:53:29'),
(7, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:53:29', '2025-01-10 07:53:29'),
(8, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:54:06', '2025-01-10 07:54:06'),
(9, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:54:06', '2025-01-10 07:54:06'),
(10, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:54:06', '2025-01-10 07:54:06'),
(11, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:54:24', '2025-01-10 07:54:24'),
(12, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:54:24', '2025-01-10 07:54:24'),
(13, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:54:24', '2025-01-10 07:54:24'),
(14, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:54:45', '2025-01-10 07:54:45'),
(15, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:54:45', '2025-01-10 07:54:45'),
(16, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:54:45', '2025-01-10 07:54:45'),
(17, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:55:11', '2025-01-10 07:55:11'),
(18, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:55:11', '2025-01-10 07:55:11'),
(19, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:55:11', '2025-01-10 07:55:11'),
(20, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(21, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(22, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(23, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(24, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(25, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(26, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(27, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(28, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-10 07:59:21', '2025-01-10 07:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `historique_admin`
--

DROP TABLE IF EXISTS `historique_admin`;
CREATE TABLE IF NOT EXISTS `historique_admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_administrateur` int NOT NULL,
  `type_action` enum('Creation','Modification','Suppression') NOT NULL,
  `table_concernee` varchar(50) NOT NULL,
  `id_enregistrement` int NOT NULL,
  `details` text,
  `date_action` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_administrateur` (`id_administrateur`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `historique_admin`
--

INSERT INTO `historique_admin` (`id`, `id_administrateur`, `type_action`, `table_concernee`, `id_enregistrement`, `details`, `date_action`) VALUES
(1, 1, 'Creation', 'membres', 1, 'Création d\'un nouveau membre: Ahmed Benali', '2024-01-10 08:15:00'),
(2, 1, 'Modification', 'membres', 1, 'Mise à jour du numéro de téléphone', '2024-01-10 13:30:00'),
(3, 1, 'Suppression', 'membres', 2, 'Suppression du compte à la demande du membre', '2024-01-11 10:20:00'),
(4, 1, 'Creation', 'partenaires', 1, 'Ajout du nouveau partenaire: Clinique El Shifa', '2024-01-12 09:00:00'),
(5, 1, 'Modification', 'partenaires', 1, 'Mise à jour du taux de remise de 15% à 20%', '2024-01-13 15:45:00'),
(6, 1, 'Suppression', 'partenaires', 3, 'Fin du partenariat', '2024-01-14 08:30:00'),
(7, 1, 'Creation', 'evenements', 1, 'Création de l\'événement: Journée portes ouvertes', '2024-01-15 10:00:00'),
(8, 1, 'Modification', 'evenements', 1, 'Changement de la date de l\'événement', '2024-01-16 13:20:00'),
(9, 1, 'Suppression', 'evenements', 2, 'Annulation de l\'événement', '2024-01-17 14:30:00'),
(10, 1, 'Creation', 'dons', 1, 'Enregistrement d\'un nouveau don de 5000 DA', '2024-01-18 08:45:00'),
(11, 1, 'Modification', 'dons', 1, 'Validation du reçu de don', '2024-01-18 09:30:00'),
(12, 1, 'Modification', 'dons', 2, 'Changement du statut en \"Validé\"', '2024-01-19 10:15:00'),
(13, 1, 'Creation', 'demandes_aides', 1, 'Nouvelle demande d\'aide médicale', '2024-01-20 07:30:00'),
(14, 1, 'Modification', 'demandes_aides', 1, 'Approbation de la demande d\'aide', '2024-01-21 09:45:00'),
(15, 1, 'Modification', 'demandes_aides', 2, 'Demande mise en attente - documents supplémentaires requis', '2024-01-22 13:20:00'),
(16, 1, 'Creation', 'remises', 1, 'Création d\'une nouvelle offre spéciale', '2024-01-23 08:00:00'),
(17, 1, 'Modification', 'remises', 1, 'Extension de la période de validité', '2024-01-24 10:30:00'),
(18, 1, 'Suppression', 'remises', 2, 'Suppression d\'une remise expirée', '2024-01-25 15:45:00'),
(19, 1, 'Modification', 'parametres_application', 1, 'Mise à jour du logo de l\'association', '2024-01-26 12:15:00'),
(20, 1, 'Modification', 'parametres_application', 2, 'Changement de la couleur principale du thème', '2024-01-27 09:20:00'),
(21, 1, 'Modification', 'parametres_application', 3, 'Mise à jour de l\'email de contact', '2024-01-28 14:40:00');

-- --------------------------------------------------------

--
-- Table structure for table `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) NOT NULL,
  `nom` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mot_de_passe` varchar(255) NOT NULL,
  `numero_identite` varchar(50) NOT NULL,
  `telephone` varchar(15) DEFAULT NULL,
  `adresse` text,
  `photo` text,
  `recu_paiement` text,
  `id_type_abonnement` int NOT NULL,
  `date_inscription` date NOT NULL,
  `date_expiration` date NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `statut` enum('En attente','Approuvé','Rejeté') DEFAULT 'En attente',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `numero_identite` (`numero_identite`),
  KEY `fk_type_abonnement` (`id_type_abonnement`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `membres`
--

INSERT INTO `membres` (`id`, `prenom`, `nom`, `email`, `mot_de_passe`, `numero_identite`, `telephone`, `adresse`, `photo`, `recu_paiement`, `id_type_abonnement`, `date_inscription`, `date_expiration`, `cree_le`, `modifie_le`, `statut`) VALUES
(1, 'prenom1', 'nom1', 'email1@example.com', 'password123', '123456789', '1234567890', 'alg', 'Images/photo1.jpg', 'recu1.jpg', 1, '2023-10-01', '2023-11-01', '2025-01-09 09:59:14', '2025-01-09 09:59:14', 'Approuvé'),
(2, 'prenom2', 'nom2', 'email2@example.com', 'password456', '987654321', '0987654321', 'alg', 'Images/photo2.jpg', 'recu2.jpg', 2, '2023-10-05', '2024-01-05', '2025-01-09 09:59:14', '2025-01-09 10:27:30', 'Rejeté'),
(3, 'Ahmed', 'Benali', 'ahmed.benali@example.com', 'password123', '123456798', '0550123456', 'Alger', 'ahmed.jpg', 'recu1.jpg', 1, '2023-10-01', '2023-11-01', '2025-01-10 07:54:06', '2025-01-10 07:54:06', 'Approuvé'),
(4, 'Fatima', 'Zohra', 'fatima.zohra@example.com', 'password456', '987654333', '0550987654', 'Oran', 'fatima.jpg', 'recu2.jpg', 2, '2023-10-05', '2024-01-05', '2025-01-10 07:54:45', '2025-01-10 07:54:45', 'Approuvé'),
(5, 'Karim', 'Bouazza', 'karim.bouazza@example.com', 'password789', '456123777', '0550112233', 'Constantine', 'karim.jpg', 'recu3.jpg', 3, '2023-10-10', '2024-10-10', '2025-01-10 07:54:45', '2025-01-10 07:54:45', 'En attente');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_membre` int DEFAULT NULL,
  `id_type_notification` int NOT NULL,
  `titre` varchar(100) NOT NULL,
  `contenu` text NOT NULL,
  `envoye_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_membre` (`id_membre`),
  KEY `id_type_notification` (`id_type_notification`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parametres_application`
--

DROP TABLE IF EXISTS `parametres_application`;
CREATE TABLE IF NOT EXISTS `parametres_application` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cle` varchar(50) NOT NULL,
  `valeur` text NOT NULL,
  `description` text,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cle` (`cle`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parametres_application`
--

INSERT INTO `parametres_application` (`id`, `cle`, `valeur`, `description`, `modifie_le`) VALUES
(1, 'logo_path', 'Images/logo_elmountada.png', 'Chemin vers le logo de l\'association', '2025-01-09 07:59:28'),
(2, 'theme_couleur_primaire', '#007bff', 'Couleur principale du thème', '2025-01-09 07:59:28'),
(3, 'theme_couleur_secondaire', '#6c757d', 'Couleur secondaire du thème', '2025-01-09 07:59:28'),
(4, 'duree_diaporama', '3000', 'Durée du diaporama en millisecondes', '2025-01-09 07:59:28'),
(5, 'email_contact', 'el_mountada@association.com', 'Email de contact principal', '2025-01-09 07:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `partenaires`
--

DROP TABLE IF EXISTS `partenaires`;
CREATE TABLE IF NOT EXISTS `partenaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `remise` decimal(5,2) NOT NULL,
  `details` text,
  `logo` text,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `partenaires`
--

INSERT INTO `partenaires` (`id`, `nom`, `ville`, `remise`, `details`, `logo`, `cree_le`, `modifie_le`) VALUES
(1, 'Hôtel Marriott', 'Beb Ezzouar', 20.00, '-20% sur tous les séjours', NULL, '2025-01-10 07:48:45', '2025-01-10 07:48:45'),
(2, 'Clinique HADAD', 'Baraki', 15.00, '-15% sur les consultations', NULL, '2025-01-10 07:48:45', '2025-01-10 07:48:45'),
(3, 'École Internationale', 'Dar El Beida', 25.00, 'Remise de 25% pour les nouveaux inscrits', NULL, '2025-01-10 07:48:45', '2025-01-10 07:48:45'),
(4, 'Hôtel Marriott', 'Beb Ezzouar', 20.00, '-20% sur tous les séjours', 'marriott_logo.png', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(5, 'Clinique HADAD', 'Baraki', 15.00, '-15% sur les consultations', 'hadad_logo.png', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(6, 'École Internationale', 'Dar El Beida', 25.00, 'Remise de 25% pour les nouveaux inscrits', 'ecole_logo.png', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(7, 'Voyages Express', 'Cheraga', 10.00, '-10% sur les forfaits de voyage', 'voyages_logo.png', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(8, 'Hôtel Sheraton', 'Alger Centre', 15.00, '-15% sur les séjours prolongés', 'sheraton_logo.png', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(9, 'Clinique Santé+', 'Kouba', 20.00, '-20% sur les examens médicaux', 'santeplus_logo.png', '2025-01-10 07:55:29', '2025-01-10 07:55:29'),
(10, 'Hôtel Marriott', 'Beb Ezzouar', 20.00, '-20% sur tous les séjours', 'marriott_logo.png', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(11, 'Clinique HADAD', 'Baraki', 15.00, '-15% sur les consultations', 'hadad_logo.png', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(12, 'École Internationale', 'Dar El Beida', 25.00, 'Remise de 25% pour les nouveaux inscrits', 'ecole_logo.png', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(13, 'Voyages Express', 'Cheraga', 10.00, '-10% sur les forfaits de voyage', 'voyages_logo.png', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(14, 'Hôtel Sheraton', 'Alger Centre', 15.00, '-15% sur les séjours prolongés', 'sheraton_logo.png', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(15, 'Clinique Santé+', 'Kouba', 20.00, '-20% sur les examens médicaux', 'santeplus_logo.png', '2025-01-10 07:58:43', '2025-01-10 07:58:43'),
(16, 'Hôtel Marriott', 'Beb Ezzouar', 20.00, '-20% sur tous les séjours', 'marriott_logo.png', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(17, 'Clinique HADAD', 'Baraki', 15.00, '-15% sur les consultations', 'hadad_logo.png', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(18, 'École Internationale', 'Dar El Beida', 25.00, 'Remise de 25% pour les nouveaux inscrits', 'ecole_logo.png', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(19, 'Voyages Express', 'Cheraga', 10.00, '-10% sur les forfaits de voyage', 'voyages_logo.png', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(20, 'Hôtel Sheraton', 'Alger Centre', 15.00, '-15% sur les séjours prolongés', 'sheraton_logo.png', '2025-01-10 07:59:21', '2025-01-10 07:59:21'),
(21, 'Clinique Santé+', 'Kouba', 20.00, '-20% sur les examens médicaux', 'santeplus_logo.png', '2025-01-10 07:59:21', '2025-01-10 07:59:21');

-- --------------------------------------------------------

--
-- Table structure for table `partenaire_agence_voyage`
--

DROP TABLE IF EXISTS `partenaire_agence_voyage`;
CREATE TABLE IF NOT EXISTS `partenaire_agence_voyage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_partenaire` int NOT NULL,
  `destinations` text,
  `services_voyage` text,
  PRIMARY KEY (`id`),
  KEY `id_partenaire` (`id_partenaire`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `partenaire_agence_voyage`
--

INSERT INTO `partenaire_agence_voyage` (`id`, `id_partenaire`, `destinations`, `services_voyage`) VALUES
(1, 4, 'Paris, Istanbul, Dubaï', 'Billets d\'avion, Réservation d\'hôtels, Visites guidées'),
(2, 4, 'Paris, Istanbul, Dubaï', 'Billets d\'avion, Réservation d\'hôtels, Visites guidées');

-- --------------------------------------------------------

--
-- Table structure for table `partenaire_clinique`
--

DROP TABLE IF EXISTS `partenaire_clinique`;
CREATE TABLE IF NOT EXISTS `partenaire_clinique` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_partenaire` int NOT NULL,
  `specialites` text,
  `equipements` text,
  PRIMARY KEY (`id`),
  KEY `id_partenaire` (`id_partenaire`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `partenaire_clinique`
--

INSERT INTO `partenaire_clinique` (`id`, `id_partenaire`, `specialites`, `equipements`) VALUES
(1, 2, 'Cardiologie, Dermatologie', 'IRM, Scanner'),
(2, 2, 'Cardiologie, Dermatologie', 'IRM, Scanner, Laboratoire d\'analyses'),
(3, 6, 'Pédiatrie, Gynécologie', 'Échographie, Radiologie');

-- --------------------------------------------------------

--
-- Table structure for table `partenaire_ecole`
--

DROP TABLE IF EXISTS `partenaire_ecole`;
CREATE TABLE IF NOT EXISTS `partenaire_ecole` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_partenaire` int NOT NULL,
  `niveaux_scolaires` text,
  `activites` text,
  PRIMARY KEY (`id`),
  KEY `id_partenaire` (`id_partenaire`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `partenaire_ecole`
--

INSERT INTO `partenaire_ecole` (`id`, `id_partenaire`, `niveaux_scolaires`, `activites`) VALUES
(1, 3, 'Primaire, Collège, Lycée', 'Activités sportives, Ateliers artistiques');

-- --------------------------------------------------------

--
-- Table structure for table `partenaire_hotel`
--

DROP TABLE IF EXISTS `partenaire_hotel`;
CREATE TABLE IF NOT EXISTS `partenaire_hotel` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_partenaire` int NOT NULL,
  `nombre_chambres` int DEFAULT NULL,
  `services` text,
  PRIMARY KEY (`id`),
  KEY `id_partenaire` (`id_partenaire`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `partenaire_hotel`
--

INSERT INTO `partenaire_hotel` (`id`, `id_partenaire`, `nombre_chambres`, `services`) VALUES
(1, 1, 200, 'Piscine, Spa, Restaurant'),
(2, 1, 200, 'Piscine, Spa, Restaurant, Wi-Fi gratuit'),
(3, 5, 150, 'Piscine, Salle de conférence, Petit-déjeuner inclus');

-- --------------------------------------------------------

--
-- Table structure for table `remises`
--

DROP TABLE IF EXISTS `remises`;
CREATE TABLE IF NOT EXISTS `remises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_partenaire` int NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type_remise` enum('permanente','limitee') NOT NULL,
  `valeur_remise` varchar(50) NOT NULL,
  `expire_le` date NOT NULL,
  `cree_le` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categorie` (`id_categorie`),
  KEY `fk_partenaire` (`id_partenaire`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `remises`
--

INSERT INTO `remises` (`id`, `id_partenaire`, `nom`, `description`, `type_remise`, `valeur_remise`, `expire_le`, `cree_le`, `modifie_le`, `id_categorie`) VALUES
(42, 1, 'Remise Séjour Hôtel', '20% sur tous les séjours pour une durée limitée', 'permanente', '-20%', '2026-01-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 1),
(43, 2, 'Offre Consultation Médicale', '15% sur les consultations médicales', 'permanente', '-15%', '2026-01-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 2),
(44, 3, 'Remise Nouveaux Inscrits', '25% pour les nouveaux inscrits', 'permanente', '-25%', '2026-01-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 3),
(45, 4, 'Remise Forfait Voyage', '10% sur les forfaits de voyage', 'limitee', '-10%', '2025-07-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 4),
(46, 5, 'Offre Examen Médical', '20% sur les examens médicaux', 'permanente', '-20%', '2026-01-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 2),
(47, 6, 'Remise Traitement Longue Durée', '10% pour les traitements longue durée', 'limitee', '-10%', '2025-07-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 2),
(48, 7, 'Remise Séjour Hôtel VIP', '30% sur les suites VIP', 'limitee', '-30%', '2025-12-31', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 1),
(49, 8, 'Offre Spéciale École', '15% sur les frais de scolarité', 'permanente', '-15%', '2026-01-03', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 3),
(50, 9, 'Remise Forfait Voyage Premium', '20% sur les forfaits premium', 'limitee', '-20%', '2025-09-30', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 4),
(51, 10, 'Remise Séjour Hôtel Été', '25% sur les séjours estivaux', 'limitee', '-25%', '2025-08-31', '2025-01-10 09:03:56', '2025-01-10 09:03:56', 1);

-- --------------------------------------------------------

--
-- Table structure for table `statut_benevolat`
--

DROP TABLE IF EXISTS `statut_benevolat`;
CREATE TABLE IF NOT EXISTS `statut_benevolat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `statut_benevolat`
--

INSERT INTO `statut_benevolat` (`id`, `nom`) VALUES
(1, 'Inscrit'),
(2, 'Confirmé'),
(3, 'Terminé');

-- --------------------------------------------------------

--
-- Table structure for table `type_abonnement`
--

DROP TABLE IF EXISTS `type_abonnement`;
CREATE TABLE IF NOT EXISTS `type_abonnement` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `duree` int NOT NULL,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `type_abonnement`
--

INSERT INTO `type_abonnement` (`id`, `nom`, `prix`, `duree`, `cree_le`, `modifie_le`) VALUES
(1, 'Classique', 50.00, 30, '2025-01-10 07:48:45', '2025-01-10 07:48:45'),
(2, 'Premium', 100.00, 30, '2025-01-10 07:48:45', '2025-01-10 07:48:45'),
(3, 'Annuel', 500.00, 365, '2025-01-10 07:48:45', '2025-01-10 07:48:45'),
(4, 'Trimestriel', 150.00, 90, '2025-01-10 07:50:01', '2025-01-10 07:50:01'),
(5, 'Mensuel', 60.00, 30, '2025-01-10 07:50:01', '2025-01-10 07:50:01');

-- --------------------------------------------------------

--
-- Table structure for table `type_notification`
--

DROP TABLE IF EXISTS `type_notification`;
CREATE TABLE IF NOT EXISTS `type_notification` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `type_notification`
--

INSERT INTO `type_notification` (`id`, `nom`) VALUES
(1, 'Événement'),
(2, 'Promotion'),
(3, 'Renouvellement');

-- --------------------------------------------------------

--
-- Table structure for table `utilisation_remises`
--

DROP TABLE IF EXISTS `utilisation_remises`;
CREATE TABLE IF NOT EXISTS `utilisation_remises` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_membre` int NOT NULL,
  `id_partenaire` int NOT NULL,
  `id_remise` int NOT NULL,
  `date_utilisation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `montant_avant_remise` decimal(10,2) NOT NULL,
  `montant_remise` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_membre` (`id_membre`),
  KEY `id_partenaire` (`id_partenaire`),
  KEY `id_remise` (`id_remise`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
