-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jun 02, 2025 at 08:29 PM
-- Server version: 9.1.0
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khadamati`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrateur`
--

DROP TABLE IF EXISTS `administrateur`;
CREATE TABLE IF NOT EXISTS `administrateur` (
  `id_admin` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `tel` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_admin`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `nom`, `tel`, `email`, `password`) VALUES
(1, 'Muhamed Mamy', NULL, '24152@supnum.mr', '01010101'),
(2, 'Taleb Ejwed Ahmed', NULL, '24215@supnum.mr', '11223344'),
(3, 'MED', NULL, '2000@gmail.com', '$2y$10$Git4/1MiNH.dwewmEfHGfeP/GP8LRR5X98RE6fWGxJwIruqNufH/2'),
(12, 'jjj', NULL, '200@supnum.mr', '$2y$10$YSFpb6KHBV5VkwEKGIz/i.VVA9cf0HGYa17kAq5lagywWQlwO3AUS'),
(22, 'youssef', NULL, 'youssef@gmail.com', '$2y$10$6x1NT5ry7VtXdXfamnVWyeOasQ9yvi7gdvXMU6xoUYLX2ULl9CHCm'),
(23, 'mohamed', '32122334', 'mohamed@gmail.com', '$2y$10$zbeeRtDS1Ttnmv4rixhPo.A2yAS2uvITREAdjDdrw2fqaeFZVMxrC'),
(25, 'admin', '32122334', 'admin@supnum.mr', '$2y$10$LCTlIu9JglLVp9lC/xBVEeQ0mBdmlt/bggQDbB1d9TdF6RZsaU.bq');

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`id`, `nom`, `description`) VALUES
(1, 'Plomberie', 'Tous les travaux de plomberie'),
(2, 'Mécanique', 'Réparation des voitures'),
(3, 'Électricité', 'Travaux électriques'),
(4, 'Jardinage', 'Entretien des jardins'),
(5, 'Transport', 'Services de livraison');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id_client` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_client`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `email`, `password`) VALUES
(4, 'MED', '2000@gmail.com', '12345678.'),
(5, 'KHALED', '2000@supnum.mr', '12345678'),
(6, 'MED', '200@gmail.com', '12345678'),
(9, 'youssef', 'youssef@gmail.com', '112233Mm'),
(10, 'mohamed', 'mohamed@gmail.com', '112233Mm'),
(11, 'Abd lahi', 'abd@gmail.com', '010203'),
(12, 'Abd hay', 'abdhay@gmail.com', '1234567');

-- --------------------------------------------------------

--
-- Table structure for table `demande`
--

DROP TABLE IF EXISTS `demande`;
CREATE TABLE IF NOT EXISTS `demande` (
  `id_demande` int NOT NULL AUTO_INCREMENT,
  `description` text COLLATE utf8mb4_general_ci,
  `statut` enum('en_attente','en_cours','terminee','annulee') COLLATE utf8mb4_general_ci DEFAULT 'en_attente',
  `id_service` int DEFAULT NULL,
  `id_client` int DEFAULT NULL,
  `id_employe` int DEFAULT NULL,
  `date_demande` date NOT NULL,
  `date_execution` date DEFAULT NULL,
  `adresse` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `image` text COLLATE utf8mb4_general_ci,
  PRIMARY KEY (`id_demande`),
  KEY `fk_demande_service` (`id_service`),
  KEY `fk_demande_employe` (`id_employe`),
  KEY `fk_demande_client` (`id_client`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `demande`
--

INSERT INTO `demande` (`id_demande`, `description`, `statut`, `id_service`, `id_client`, `id_employe`, `date_demande`, `date_execution`, `adresse`, `image`) VALUES
(44, 'je demande de plombier', 'terminee', 1, 9, NULL, '2025-05-29', NULL, 'karafor ', NULL),
(45, 'Mecanique', 'terminee', 2, 9, NULL, '2025-05-29', NULL, 'karafor ', NULL),
(46, 'je demande de l\'electricite', 'annulee', 3, 4, NULL, '2025-05-29', NULL, 'karafor ', NULL),
(47, 'je demandeLivraison', 'en_attente', 5, 9, NULL, '2025-05-29', NULL, 'karafor ', NULL),
(48, 'je demande electricite\r\n', 'terminee', 3, 4, NULL, '2025-05-29', NULL, 'tvz', NULL),
(49, 'Livraison', 'en_cours', 5, 9, NULL, '2025-05-29', NULL, 'arafat', NULL),
(50, 'ffdsbbt', 'terminee', 3, 4, NULL, '2025-05-29', NULL, 'tvz', NULL),
(51, 'liveraison', 'en_attente', 5, 9, NULL, '2025-05-29', NULL, 'tenadi', NULL),
(52, 'mecanique', 'en_cours', 2, 9, NULL, '2025-05-29', NULL, 'arafat', NULL),
(53, 'je demande electricite', 'terminee', 3, 10, NULL, '2025-05-30', NULL, 'arafat', 'uploads/demandes/68394b620cadb.png'),
(58, 'Le moteur de la voiture est en panne', 'en_attente', 2, 9, NULL, '2025-05-30', NULL, 'ppkaa', NULL),
(59, 'mecanique', 'en_cours', 2, 10, NULL, '2025-05-31', NULL, 'tenadi', NULL),
(60, 'hbndsl,l', 'en_attente', 2, 10, NULL, '2025-05-31', NULL, 'assssss', NULL),
(61, 'fghjkl;', 'en_attente', 2, 10, NULL, '2025-05-31', NULL, 'tenadi', NULL),
(62, 'hhhnjn', 'en_attente', 2, 9, NULL, '2025-05-31', NULL, 'ppkaa', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id_employe` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `specialite` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `numero_telephone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `adresse` text COLLATE utf8mb4_general_ci,
  `statut` enum('actif','inactif') COLLATE utf8mb4_general_ci DEFAULT 'actif',
  `id_service` int DEFAULT NULL,
  PRIMARY KEY (`id_employe`),
  UNIQUE KEY `email` (`email`),
  KEY `fk_employe_service` (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employe`
--

INSERT INTO `employe` (`id_employe`, `nom`, `specialite`, `email`, `numero_telephone`, `adresse`, `statut`, `id_service`) VALUES
(1, 'mohamed', 'Mecanique', '25162@supnum.mr', '41141212', 'karafor', 'actif', 4),
(4, 'ejwed', 'ELEC', '24215@supnuum.mr', '22343243', 'EUEU', 'actif', NULL),
(5, 'muhamed', 'nottoyage', 'muhamed@gmail.com', '41141212', 'NSSS18', 'actif', 4),
(6, 'khady', 'livraison', 'khady@mail.com', '41141212', 'NDB', 'actif', 1);

-- --------------------------------------------------------

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id_service` int NOT NULL AUTO_INCREMENT,
  `nom_service` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci,
  `categorie` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `duree_estimee` int DEFAULT NULL,
  `id_admin` int DEFAULT NULL,
  `id_categorie` int DEFAULT NULL,
  PRIMARY KEY (`id_service`),
  KEY `fk_service_admin` (`id_admin`),
  KEY `fk_service_categorie` (`id_categorie`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `service`
--

INSERT INTO `service` (`id_service`, `nom_service`, `description`, `categorie`, `prix`, `duree_estimee`, `id_admin`, `id_categorie`) VALUES
(1, 'Plomberie', 'Réparation des fuites et des canalisations.', NULL, 400.00, 1, 2, 1),
(2, 'Mecanique', 'Réparation de voiture, tous types de problèmes.', NULL, 2000.00, 3, 1, 2),
(3, 'Electricite', 'Installation et réparation de systèmes électriques.', NULL, 250.00, 1, 1, 3),
(4, 'Nettoyage', 'Service de nettoyage domestique complet.', NULL, 1000.00, 48, 2, 4),
(5, 'Livraison', 'Service de livraison rapide à domicile.', NULL, 100.00, 1, 1, 5),
(26, 'mettenace', 'problem de l\'oridanateur', NULL, 1200.00, 60, 1, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `demande`
--
ALTER TABLE `demande`
  ADD CONSTRAINT `fk_demande_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_demande_employe` FOREIGN KEY (`id_employe`) REFERENCES `employe` (`id_employe`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_demande_service` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `employe`
--
ALTER TABLE `employe`
  ADD CONSTRAINT `fk_employe_service` FOREIGN KEY (`id_service`) REFERENCES `service` (`id_service`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `fk_service_admin` FOREIGN KEY (`id_admin`) REFERENCES `administrateur` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_service_categorie` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
