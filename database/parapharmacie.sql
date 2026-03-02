-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 02 mars 2026 à 09:10
-- Version du serveur : 8.0.19
-- Version de PHP : 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `parapharmacie`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

DROP TABLE IF EXISTS `commandes`;
CREATE TABLE IF NOT EXISTS `commandes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `adresse` text,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `date_commande` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id`, `nom`, `prenom`, `adresse`, `telephone`, `email`, `date_commande`) VALUES
(1, 'Harroudi', 'Yasmine', 'BP 198 TANGER PRINCIPAL TANGER MAROC', '+212772633934', 'yasmineharroudi2020@gmail.com', '2025-06-06 18:13:16'),
(7, 'saousaou', 'zaid', 'BP 198 TANGER PRINCIPAL TANGER MAROC', '+212780875420', 'saousaouzaid@gmail.com', '2025-06-11 09:53:09'),
(8, 'Motich', 'Ihsan', 'Placa toro Tanger 28', '+212623929094', 'Ihsanmotich@gmail.com', '2025-06-11 09:59:01'),
(9, 'HARROUDI', 'Yasmine', 'BP 198 TANGER PRINCIPAL TANGER MAROC', '+212772633934', 'yasmineharroudi2020@gmail.com', '2025-08-10 18:37:35'),
(10, 'HARROUDI', 'Yasmine', 'BP 198 TANGER PRINCIPAL TANGER MAROC', '+212777777777', 'yasmineharroudi2020@gmail.com', '2025-08-10 18:38:21'),
(11, 'HARROUDI', 'Yasmine', 'AL IRFANE 1 GH 29 IMB 294 ETG 3 N 53 TANGER', '+212777777777', 'yasmineharroudi2020@gmail.com', '2025-09-26 19:15:45'),
(12, 'HARROUDI', 'Yasmine', 'AL IRFANE 1 GH 29 IMB 294 ETG 3 N 53 TANGER', '+212777777777', 'yasmineharroudi2020@gmail.com', '2025-09-27 15:54:36'),
(13, 'HARROUDI', 'Yasmine', 'AL IRFANE 1 GH 29 IMB 294 ETG 3 N 53 TANGER', '+212777777777', 'yasmineharroudi2020@gmail.com', '2025-09-29 19:38:29');

-- --------------------------------------------------------

--
-- Structure de la table `commande_produits`
--

DROP TABLE IF EXISTS `commande_produits`;
CREATE TABLE IF NOT EXISTS `commande_produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `commande_id` int DEFAULT NULL,
  `produit_id` int DEFAULT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  `quantite` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `commande_id` (`commande_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `commande_produits`
--

INSERT INTO `commande_produits` (`id`, `commande_id`, `produit_id`, `prix`, `quantite`) VALUES
(14, 7, 2, 59.50, 2),
(15, 7, 4, 120.00, 1),
(16, 8, 3, 45.00, 1),
(17, 8, 4, 120.00, 1),
(18, 9, 3, 45.00, 1),
(19, 9, 4, 120.00, 1),
(20, 10, 3, 45.00, 1),
(21, 10, 4, 120.00, 1),
(22, 11, 3, 45.00, 1),
(23, 11, 4, 120.00, 1),
(24, 12, 3, 45.00, 1),
(25, 12, 4, 120.00, 1),
(26, 13, 3, 45.00, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

DROP TABLE IF EXISTS `produits`;
CREATE TABLE IF NOT EXISTS `produits` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `nom`, `prix`, `image`) VALUES
(1, 'Crème hydratante visage', 89.90, '../images/creme_visage.jpg'),
(2, 'Shampoing doux', 59.50, '../images/shampoing.jpg'),
(3, 'Gel douche revitalisant', 45.00, '../images/gel_douche.jpg'),
(4, 'Crème solaire SPF 50', 120.00, '../images/creme_solaire.jpg'),
(5, 'Sérum anti-âge', 150.00, '../images/serum_anti_age.jpg'),
(6, 'Masque purifiant', 75.00, '../images/masque_purifiant.jpg'),
(7, 'Crème pour les mains', 30.00, '../images/creme_mains.jpg'),
(8, 'Brosse à cheveux en bambou', 25.00, '../images/brosse_bambou.jpg'),
(9, 'Huile essentielle de lavande', 40.00, '../images/huile_lavande.jpg'),
(10, 'Baume à lèvres hydratant', 15.00, '../images/baume_levres.jpg'),
(11, 'Spray rafraîchissant visage', 55.00, '../images/spray_visage.webp'),
(12, 'Crème anti-rides contour des yeux', 110.00, '../images/creme_yeux.jpg'),
(13, 'Gel coiffant naturel', 35.00, '../images/gel_coiffant.webp'),
(14, 'Savon artisanal à l\'argile', 20.00, '../images/savon_argile.webp'),
(15, 'Crème de nuit régénérante', 95.00, '../images/creme_nuit.webp'),
(16, 'Lotion tonique hydratante', 70.00, '../images/lotion_tonique.webp'),
(17, 'Gommage doux pour le corps', 50.00, '../images/gommage_corps.webp'),
(18, 'Crème dépilatoire douce', 65.00, '../images/creme_depilatoire.jpg'),
(19, 'Poudre matifiante', 40.00, '../images/poudre_matifiante.jpg'),
(20, 'Crème apaisante après-soleil', 85.00, '../images/creme_apaisante.webp');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_produits`
--
ALTER TABLE `commande_produits`
  ADD CONSTRAINT `commande_produits_ibfk_1` FOREIGN KEY (`commande_id`) REFERENCES `commandes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
