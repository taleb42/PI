
-- Création de la base de données
CREATE DATABASE IF NOT EXISTS khadamati;
USE khadamati;

-- Table des administrateurs
CREATE TABLE Administrateur (
    id_admin INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL -- mot de passe de connexion
) ENGINE=InnoDB;

-- Table des clients
CREATE TABLE Client (
    id_client INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL -- mot de passe de connexion
) ENGINE=InnoDB;

-- Table des services
CREATE TABLE Service (
    id_service INT AUTO_INCREMENT PRIMARY KEY,
    nom_service VARCHAR(100) NOT NULL,
    description TEXT,
    categorie VARCHAR(50),
    prix DECIMAL(10,2),
    duree_estimee INT, -- durée en minutes
    id_admin INT,
    -- Relation avec l'administrateur (chaque service est géré par un admin)
    CONSTRAINT fk_service_admin FOREIGN KEY (id_admin)
        REFERENCES Administrateur(id_admin)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table des employés
CREATE TABLE Employe (
    id_employe INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    specialite VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    numero_telephone VARCHAR(20),
    adresse TEXT,
    statut ENUM('actif', 'inactif') DEFAULT 'actif',
    id_service INT,
    -- Relation avec le service (chaque employé appartient à un service)
    CONSTRAINT fk_employe_service FOREIGN KEY (id_service)
        REFERENCES Service(id_service)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Table des demandes
CREATE TABLE Demande (
    id_demande INT AUTO_INCREMENT PRIMARY KEY,
    description TEXT,
    statut ENUM('en_attente', 'en_cours', 'terminee', 'annulee') DEFAULT 'en_attente',
    id_service INT,
    id_client INT,
    id_employe INT,
    date_demande DATE NOT NULL,
    date_execution DATE,
    image TEXT,
    note_client TINYINT, -- note de satisfaction client (1 à 5)
    commentaire_client TEXT,
    -- Relation avec le service concerné
    CONSTRAINT fk_demande_service FOREIGN KEY (id_service)
        REFERENCES Service(id_service)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    -- Relation avec le client (celui qui a fait la demande)
    CONSTRAINT fk_demande_client FOREIGN KEY (id_client)
        REFERENCES Client(id_client)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    -- Relation avec l'employé (celui qui traite la demande)
    CONSTRAINT fk_demande_employe FOREIGN KEY (id_employe)
        REFERENCES Employe(id_employe)
        ON DELETE SET NULL
        ON UPDATE CASCADE
) ENGINE=InnoDB;
