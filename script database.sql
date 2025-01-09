-- Create database
CREATE DATABASE IF NOT EXISTS association_db;

USE association_db;

-- Table: administrateurs
CREATE TABLE administrateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('SuperAdmin', 'Admin') DEFAULT 'Admin',
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: type_abonnement
CREATE TABLE type_abonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: membres
CREATE TABLE membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(50) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    numero_identite VARCHAR(50) NOT NULL UNIQUE,
    telephone VARCHAR(15) NOT NULL,
    adresse TEXT,
    photo TEXT,
    recu_paiement TEXT,
    id_type_abonnement INT NOT NULL,
    date_inscription DATE NOT NULL,
    date_expiration DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_type_abonnement) REFERENCES type_abonnement(id)
);

-- Table: evenements
CREATE TABLE evenements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    description TEXT,
    date_debut DATE NOT NULL,
    date_fin DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: statut_benevolat
CREATE TABLE statut_benevolat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: benevoles
CREATE TABLE benevoles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    evenement VARCHAR(100) NOT NULL,
    id_statut_benevolat INT NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_membre) REFERENCES membres(id),
    FOREIGN KEY (id_statut_benevolat) REFERENCES statut_benevolat(id)
);

-- Table: categorie_partenaire
CREATE TABLE categorie_partenaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: partenaires
CREATE TABLE partenaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    id_categorie_partenaire INT NOT NULL,
    ville VARCHAR(50) NOT NULL,
    remise DECIMAL(5,2) NOT NULL,
    details TEXT,
    logo TEXT,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_categorie_partenaire) REFERENCES categorie_partenaire(id) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Table: remises
CREATE TABLE remises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_partenaire INT NOT NULL,
    id_type_abonnement INT NOT NULL,
    valeur_remise DECIMAL(5,2) NOT NULL,
    offre_speciale TINYINT(1) NOT NULL,
    valable_du DATE NOT NULL,
    valable_au DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_partenaire) REFERENCES partenaires(id),
    FOREIGN KEY (id_type_abonnement) REFERENCES type_abonnement(id)
);

-- Table: dons
CREATE TABLE dons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    montant DECIMAL(10,2) NOT NULL,
    recu TEXT,
    date_don DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_membre) REFERENCES membres(id)
);

-- Table: demandes_aides
CREATE TABLE demandes_aides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_naissance DATE NOT NULL,
    type_aide VARCHAR(50) NOT NULL,
    description TEXT,
    fichier TEXT,
    numero_identite VARCHAR(50) NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: type_notification
CREATE TABLE type_notification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    id_type_notification INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    contenu TEXT NOT NULL,
    envoye_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_membre) REFERENCES membres(id),
    FOREIGN KEY (id_type_notification) REFERENCES type_notification(id)
);

-- Table: actualites
CREATE TABLE actualites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    image VARCHAR(255) NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert initial categories into categorie_partenaire
INSERT INTO categorie_partenaire (nom) VALUES
('Hôtels'),
('Cliniques'),
('Écoles'),
('Agences de Voyage');

-- Insert sample partner data
INSERT INTO partenaires (nom, id_categorie_partenaire, ville, remise, details, logo) VALUES
('Hôtel Marriott', 1, 'Beb Ezzouar', 20.00, '-20% sur tous les séjours', NULL),
('Hôtel Sheraton', 1, 'Alger Centre', 15.00, '-15% sur les séjours prolongés', NULL),
('Hôtel Ibis', 1, 'Hydra', 25.00, '-25% pour les réservations de groupe', NULL),
('Clinique HADAD', 2, 'Baraki', 15.00, '-15% sur les consultations', NULL),
('Clinique Santé+', 2, 'Kouba', 20.00, '-20% sur les examens médicaux', NULL),
('Clinique Oasis', 2, 'Hussein Dey', 10.00, '-10% pour les traitements longue durée', NULL),
('École Internationale', 3, 'Dar El Beida', 25.00, 'Remise de 25% pour les nouveaux inscrits', NULL),
('Voyages Express', 4, 'Cheraga', 10.00, '-10% sur les forfaits de voyage', NULL);

-- Insert sample news
INSERT INTO actualites (titre, description, image) VALUES
('Une Histoire de Réussite', 'Comment notre communauté a transformé la vie de Marie...', 'Images/image1.png'),
('Impact Communautaire', 'Découvrez comment nos bénévoles ont créé un changement...', 'Images/image2.png'),
('Projet Réussi', 'Le projet de rénovation du centre communautaire est terminé...', 'Images/image3.png'),
('Une Histoire Inspirante', 'Marie, 8 ans, a pu bénéficier d\'une opération grâce à vos dons...', 'Images/image4.png');















-------------------------admin 
-- Ajout de colonnes statistiques dans la table partenaires
ALTER TABLE partenaires
ADD COLUMN nombre_utilisations INT DEFAULT 0,
ADD COLUMN total_remises_accordees DECIMAL(10,2) DEFAULT 0.00;

-- Table pour tracer l'utilisation des remises (pour les statistiques)
CREATE TABLE utilisation_remises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    id_partenaire INT NOT NULL,
    id_remise INT NOT NULL,
    date_utilisation TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    montant_avant_remise DECIMAL(10,2) NOT NULL,
    montant_remise DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_membre) REFERENCES membres(id),
    FOREIGN KEY (id_partenaire) REFERENCES partenaires(id),
    FOREIGN KEY (id_remise) REFERENCES remises(id)
);

-- Statut pour gérer les demandes d'aide
ALTER TABLE demandes_aides
ADD COLUMN statut ENUM('En attente', 'Approuvée', 'Rejetée') DEFAULT 'En attente';

-- Ajout d'une colonne pour le statut des dons
ALTER TABLE dons
ADD COLUMN statut ENUM('En attente', 'Validé', 'Rejeté') DEFAULT 'En attente';

-- Table pour les paramètres de l'application
CREATE TABLE parametres_application (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cle VARCHAR(50) NOT NULL UNIQUE,
    valeur TEXT NOT NULL,
    description TEXT,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table pour l'historique des actions administratives
CREATE TABLE historique_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_administrateur INT NOT NULL,
    type_action ENUM('Creation', 'Modification', 'Suppression') NOT NULL,
    table_concernee VARCHAR(50) NOT NULL,
    id_enregistrement INT NOT NULL,
    details TEXT,
    date_action TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_administrateur) REFERENCES administrateurs(id)
);

-- Table pour les avis sur les partenaires
CREATE TABLE avis_partenaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    id_partenaire INT NOT NULL,
    note INT NOT NULL CHECK (note BETWEEN 1 AND 5),
    commentaire TEXT,
    date_avis TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_membre) REFERENCES membres(id),
    FOREIGN KEY (id_partenaire) REFERENCES partenaires(id)
);

-- Insertion des paramètres par défaut
INSERT INTO parametres_application (cle, valeur, description) VALUES
('logo_path', 'Images/logo_elmountada.png', 'Chemin vers le logo de l''association'),
('theme_couleur_primaire', '#007bff', 'Couleur principale du thème'),
('theme_couleur_secondaire', '#6c757d', 'Couleur secondaire du thème'),
('duree_diaporama', '3000', 'Durée du diaporama en millisecondes'),
('email_contact', 'el_mountada@association.com', 'Email de contact principal');






















--------------insertion historique admin 
-- First, let's insert a test admin if none exists
INSERT INTO administrateurs (nom_utilisateur, mot_de_passe, role) 
SELECT 'admin_super', '$2y$10$example_hash', 'SuperAdmin'
WHERE NOT EXISTS (SELECT 1 FROM administrateurs WHERE nom_utilisateur = 'admin_super');

-- Get the admin ID for our inserts
SET @admin_id = (SELECT id FROM administrateurs WHERE nom_utilisateur = 'admin_super' LIMIT 1);

-- Insert history records for member management
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Creation', 'membres', 1, 'Création d\'un nouveau membre: Ahmed Benali', '2024-01-10 09:15:00'),
(@admin_id, 'Modification', 'membres', 1, 'Mise à jour du numéro de téléphone', '2024-01-10 14:30:00'),
(@admin_id, 'Suppression', 'membres', 2, 'Suppression du compte à la demande du membre', '2024-01-11 11:20:00');

-- Insert history records for partner management
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Creation', 'partenaires', 1, 'Ajout du nouveau partenaire: Clinique El Shifa', '2024-01-12 10:00:00'),
(@admin_id, 'Modification', 'partenaires', 1, 'Mise à jour du taux de remise de 15% à 20%', '2024-01-13 16:45:00'),
(@admin_id, 'Suppression', 'partenaires', 3, 'Fin du partenariat', '2024-01-14 09:30:00');

-- Insert history records for event management
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Creation', 'evenements', 1, 'Création de l\'événement: Journée portes ouvertes', '2024-01-15 11:00:00'),
(@admin_id, 'Modification', 'evenements', 1, 'Changement de la date de l\'événement', '2024-01-16 14:20:00'),
(@admin_id, 'Suppression', 'evenements', 2, 'Annulation de l\'événement', '2024-01-17 15:30:00');

-- Insert history records for donation management
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Creation', 'dons', 1, 'Enregistrement d\'un nouveau don de 5000 DA', '2024-01-18 09:45:00'),
(@admin_id, 'Modification', 'dons', 1, 'Validation du reçu de don', '2024-01-18 10:30:00'),
(@admin_id, 'Modification', 'dons', 2, 'Changement du statut en "Validé"', '2024-01-19 11:15:00');

-- Insert history records for aid request management
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Creation', 'demandes_aides', 1, 'Nouvelle demande d\'aide médicale', '2024-01-20 08:30:00'),
(@admin_id, 'Modification', 'demandes_aides', 1, 'Approbation de la demande d\'aide', '2024-01-21 10:45:00'),
(@admin_id, 'Modification', 'demandes_aides', 2, 'Demande mise en attente - documents supplémentaires requis', '2024-01-22 14:20:00');

-- Insert history records for discount management
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Creation', 'remises', 1, 'Création d\'une nouvelle offre spéciale', '2024-01-23 09:00:00'),
(@admin_id, 'Modification', 'remises', 1, 'Extension de la période de validité', '2024-01-24 11:30:00'),
(@admin_id, 'Suppression', 'remises', 2, 'Suppression d\'une remise expirée', '2024-01-25 16:45:00');

-- Insert history records for system parameter changes
INSERT INTO historique_admin 
(id_administrateur, type_action, table_concernee, id_enregistrement, details, date_action)
VALUES
(@admin_id, 'Modification', 'parametres_application', 1, 'Mise à jour du logo de l\'association', '2024-01-26 13:15:00'),
(@admin_id, 'Modification', 'parametres_application', 2, 'Changement de la couleur principale du thème', '2024-01-27 10:20:00'),
(@admin_id, 'Modification', 'parametres_application', 3, 'Mise à jour de l\'email de contact', '2024-01-28 15:40:00');











-- Insertion des types d'abonnement
INSERT INTO type_abonnement (nom) VALUES
('Mensuel'),
('Trimestriel'),
('Annuel');

-- Insertion de membres de test
INSERT INTO membres (prenom, nom, email, mot_de_passe, numero_identite, telephone, adresse, photo, recu_paiement, id_type_abonnement, date_inscription, date_expiration, statut) VALUES
('prenom1', 'nom1', 'email1@example.com', 'password123', '123456789', '1234567890', 'alg', 'Images/photo1.jpg', 'recu1.jpg', 1, '2023-10-01', '2023-11-01', 'Approuvé'),
('prenom2', 'nom2', 'email2@example.com', 'password456', '987654321', '0987654321', 'alg', 'Images/photo2.jpg', 'recu2.jpg', 2, '2023-10-05', '2024-01-05', 'En attente');