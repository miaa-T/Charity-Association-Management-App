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
);

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
) ;

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
) ;



INSERT INTO `benevoles` (`id`, `id_membre`, `evenement`, `id_statut_benevolat`, `cree_le`, `modifie_le`) VALUES
(1, 1, 'Collecte de fonds', 1, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(2, 2, 'Distribution alimentaire', 2, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(3, 3, 'Sensibilisation', 1, '2025-01-09 10:42:53', '2025-01-09 10:42:53'),
(4, 4, 'Nettoyage communautaire', 3, '2025-01-09 10:42:53', '2025-01-09 10:42:53');



DROP TABLE IF EXISTS `categorie_partenaire`;
CREATE TABLE IF NOT EXISTS `categorie_partenaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ;


INSERT INTO `categorie_partenaire` (`id`, `nom`) VALUES
(1, 'Hôtel'),
(2, 'Clinique'),
(3, 'École'),
(4, 'Agence de voyage');



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
);



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
);



INSERT INTO `dons` (`id`, `id_membre`, `montant`, `recu`, `date_don`, `cree_le`, `modifie_le`, `statut`) VALUES
(1, 1, 100.50, 'Reçu pour don mensuel', '2023-10-01', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'Validé'),
(2, 2, 200.00, NULL, '2023-10-02', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'En attente'),
(3, 3, 50.75, 'Reçu pour don ponctuel', '2023-10-03', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'Validé'),
(4, 4, 300.00, NULL, '2023-10-04', '2025-01-09 10:42:40', '2025-01-09 10:42:40', 'Rejeté');



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
);


INSERT INTO `evenements` (`id`, `nom`, `description`, `image`, `date_debut`, `date_fin`, `cree_le`, `modifie_le`) VALUES
(1, 'Nettoyage de Plage', 'Un événement communautaire pour nettoyer les plages de la région.', 'Images/beach_cleaning.jpg', '2024-01-10', '2024-01-12', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(2, 'Collecte de Sang', 'Une journée de collecte de sang pour aider les hôpitaux locaux.', 'Images/blood_donation.jpg', '2024-02-01', '2024-02-01', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(3, 'Marathon Caritatif', 'Un marathon pour collecter des fonds pour les enfants malades.', 'Images/marathon.jpg', '2024-03-15', '2024-03-15', '2025-01-02 03:36:06', '2025-01-02 03:36:06'),
(4, 'Atelier de Formation', 'Atelier de formation pour les bénévoles sur la gestion des projets.', 'Images/training_workshop.jpg', '2024-04-10', '2024-04-11', '2025-01-02 03:36:06', '2025-01-02 03:36:06');



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
) ;




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
(21, 1, 'Modification', 'parametres_application', 3, 'Mise à jour de l email de contact', '2024-01-28 14:40:00');



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
  UNIQUE KEY `numero_identite` (`numero_identite`)
);


INSERT INTO `membres` (`id`, `prenom`, `nom`, `email`, `mot_de_passe`, `numero_identite`, `telephone`, `adresse`, `photo`, `recu_paiement`, `id_type_abonnement`, `date_inscription`, `date_expiration`, `cree_le`, `modifie_le`, `statut`) VALUES
(1, 'prenom1', 'nom1', 'email1@example.com', 'password123', '123456789', '1234567890', 'alg', 'Images/photo1.jpg', 'recu1.jpg', 1, '2023-10-01', '2023-11-01', '2025-01-09 09:59:14', '2025-01-09 09:59:14', 'Approuvé'),
(2, 'prenom2', 'nom2', 'email2@example.com', 'password456', '987654321', '0987654321', 'alg', 'Images/photo2.jpg', 'recu2.jpg', 2, '2023-10-05', '2024-01-05', '2025-01-09 09:59:14', '2025-01-09 10:27:30', 'Rejeté');



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
);



DROP TABLE IF EXISTS `parametres_application`;
CREATE TABLE IF NOT EXISTS `parametres_application` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cle` varchar(50) NOT NULL,
  `valeur` text NOT NULL,
  `description` text,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cle` (`cle`)
) ;

--
-- Dumping data for table `parametres_application`
--

INSERT INTO `parametres_application` (`id`, `cle`, `valeur`, `description`, `modifie_le`) VALUES
(1, 'logo_path', 'Images/logo_elmountada.png', 'Chemin vers le logo de l association', '2025-01-09 07:59:28'),
(2, 'theme_couleur_primaire', '#007bff', 'Couleur principale du thème', '2025-01-09 07:59:28'),
(3, 'theme_couleur_secondaire', '#6c757d', 'Couleur secondaire du thème', '2025-01-09 07:59:28'),
(4, 'duree_diaporama', '3000', 'Durée du diaporama en millisecondes', '2025-01-09 07:59:28'),
(5, 'email_contact', 'el_mountada@association.com', 'Email de contact principal', '2025-01-09 07:59:28');



DROP TABLE IF EXISTS `partenaires`;
CREATE TABLE IF NOT EXISTS `partenaires` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `id_categorie_partenaire` int NOT NULL,
  `ville` varchar(50) NOT NULL,
  `remise` decimal(5,2) NOT NULL,
  `details` text,
  `logo` text,
  `cree_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modifie_le` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_categorie_partenaire` (`id_categorie_partenaire`)
) ;


INSERT INTO `partenaires` (`id`, `nom`, `id_categorie_partenaire`, `ville`, `remise`, `details`, `logo`, `cree_le`, `modifie_le`) VALUES
(1, 'Hôtel Marriott', 1, 'Beb Ezzouar', 20.00, '-20% sur tous les séjours', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(2, 'Hôtel Sheraton', 1, 'Alger Centre', 15.00, '-15% sur les séjours prolongés', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(3, 'Hôtel Ibis', 1, 'Hydra', 66.00, '-66% pour les réservations de groupe', NULL, '2025-01-02 02:55:02', '2025-01-02 03:05:53'),
(4, 'Clinique HADAD', 2, 'Baraki', 15.00, '-15% sur les consultations', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(5, 'Clinique Santé+', 2, 'Kouba', 20.00, '-20% sur les examens médicaux', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(6, 'Clinique Oasis', 2, 'Hussein Dey', 10.00, '-10% pour les traitements longue durée', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(7, 'École Internationale', 3, 'Dar El Beida', 25.00, 'Remise de 25% pour les nouveaux inscrits', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(8, 'Voyages Express', 4, 'Cheraga', 10.00, '-10% sur les forfaits de voyage', NULL, '2025-01-02 02:55:02', '2025-01-02 02:55:02'),
(9, 'TOUBAL', 4, 'Medea Center', 20.00, 'hsfrthh', '', '2025-01-09 10:24:16', '2025-01-09 10:24:16');

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
  KEY `id_partenaire` (`id_partenaire`),
  KEY `fk_categorie` (`id_categorie`)
) ;

--
-- Dumping data for table `remises`
--

INSERT INTO `remises` (`id`, `id_partenaire`, `nom`, `description`, `type_remise`, `valeur_remise`, `expire_le`, `cree_le`, `modifie_le`, `id_categorie`) VALUES
(1, 1, 'Remise Séjour Hôtel', '20% sur tous les séjours pour une durée limitée', 'permanente', '-20%', '2026-01-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 1),
(2, 2, 'Offre Séjour Long', '15% sur les séjours prolongés', 'permanente', '-15%', '2026-01-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 1),
(3, 3, 'Remise Groupe Hôtel Ibis', '66% pour les réservations de groupe', 'limitee', '-66%', '2025-07-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 1),
(4, 4, 'Remise Consultation Médicale', '15% sur les consultations médicales', 'permanente', '-15%', '2026-01-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 2),
(5, 5, 'Offre Examen Médical', '20% sur les examens médicaux', 'permanente', '-20%', '2026-01-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 2),
(6, 6, 'Remise Traitement Longue Durée', '10% pour les traitements longue durée', 'limitee', '-10%', '2025-07-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 2),
(7, 7, 'Remise Nouveaux Inscrits', '25% pour les nouveaux inscrits', 'permanente', '-25%', '2026-01-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 3),
(8, 8, 'Remise Forfait Voyage', '10% sur les forfaits de voyage', 'limitee', '-10%', '2025-07-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 4),
(9, 9, 'Offre Spéciale Commerce', '5% sur les achats de produits locaux', 'permanente', '-5%', '2026-01-03', '2025-01-03 09:39:34', '2025-01-03 12:19:51', 4);

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
) ;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `nom` (`nom`)
) ;

--
-- Dumping data for table `type_abonnement`
--

INSERT INTO `type_abonnement` (`id`, `nom`) VALUES
(1, 'Classique'),
(2, 'Premium'),
(3, 'Mensuel'),
(4, 'Trimestriel'),
(5, 'Annuel');

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
) ;

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
) ;
