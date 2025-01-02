-- Table: administrateurs
CREATE TABLE administrateurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(50) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('SuperAdmin', 'Admin') DEFAULT 'Admin',
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: benevoles
CREATE TABLE benevoles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    evenement VARCHAR(100) NOT NULL,
    id_statut_benevolat INT NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: categorie_partenaire
CREATE TABLE categorie_partenaire (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
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

-- Table: dons
CREATE TABLE dons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT NOT NULL,
    montant DECIMAL(10, 2) NOT NULL,
    recu TEXT,
    date_don DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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

-- Table: membres
CREATE TABLE membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    prenom VARCHAR(50) NOT NULL,
    nom VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    numero_identite VARCHAR(50),
    telephone VARCHAR(15),
    adresse TEXT,
    photo TEXT,
    recu_paiement TEXT,
    id_type_abonnement INT,
    date_inscription DATE NOT NULL,
    date_expiration DATE NOT NULL,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_membre INT,
    id_type_notification INT NOT NULL,
    titre VARCHAR(100) NOT NULL,
    contenu TEXT NOT NULL,
    envoye_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: partenaires
CREATE TABLE partenaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    id_categorie_partenaire INT NOT NULL,
    ville VARCHAR(50) NOT NULL,
    remise DECIMAL(5, 2),
    details TEXT,
    logo TEXT,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table: type_notification
CREATE TABLE type_notification (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: type_abonnement
CREATE TABLE type_abonnement (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: statut_benevolat
CREATE TABLE statut_benevolat (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL
);

-- Table: remises
CREATE TABLE remises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_partenaire INT NOT NULL,
    id_type_abonnement INT NOT NULL,
    valeur_remise DECIMAL(5, 2),
    offre_speciale TINYINT(1) DEFAULT 0,
    valable_du DATE,
    valable_au DATE,
    cree_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    modifie_le TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
