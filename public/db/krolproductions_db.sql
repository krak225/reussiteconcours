-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 02 août 2022 à 15:02
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `krolproductions_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `commande_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0',
  `commande_numero` varchar(255) NOT NULL DEFAULT '0',
  `commande_montant_total` bigint(20) DEFAULT NULL,
  `commande_nombre_article` int(11) DEFAULT NULL,
  `commande_date_creation` datetime DEFAULT NULL,
  `commande_statut` enum('BROUILLON','VALIDE') DEFAULT 'BROUILLON',
  `commande_statut_paiement` enum('PAYE','IMPAYE') DEFAULT 'IMPAYE',
  PRIMARY KEY (`commande_id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`commande_id`, `user_id`, `commande_numero`, `commande_montant_total`, `commande_nombre_article`, `commande_date_creation`, `commande_statut`, `commande_statut_paiement`) VALUES
(19, 3, '92056280-8bf6-47b1-9f74-b630338a309c', 8000, NULL, '2022-08-01 07:17:15', 'BROUILLON', 'PAYE'),
(20, 3, '1f1933d8-778a-4c74-b795-07e6add7d089', 12500, 4, '2022-08-01 07:32:35', 'BROUILLON', 'PAYE'),
(21, 4, '1c879084-d9bb-418b-b19d-6702975eff73', 5500, 2, '2022-08-01 11:06:42', 'BROUILLON', 'PAYE'),
(22, 5, '14ee83a2-d77b-4df2-ba14-16566d7efd05', 3000, 1, '2022-08-01 11:13:06', 'BROUILLON', 'PAYE'),
(23, 4, 'e2b9d877-35c2-4c06-b51e-cdc3e6f62ba7', 5500, 2, '2022-08-01 11:17:39', 'BROUILLON', 'PAYE'),
(24, 5, 'f64e65ce-d43f-4e41-8921-831baedc43f6', 3000, 1, '2022-08-01 12:05:19', 'BROUILLON', 'PAYE'),
(25, 1, 'c060313a-c6df-49b3-bc1f-88551b1d10d1', 12500, 4, '2022-08-01 12:20:18', 'BROUILLON', 'PAYE'),
(26, 6, '4581c3da-52f2-458b-87fd-f55e16e196cb', 7000, 2, '2022-08-01 14:15:40', 'BROUILLON', 'IMPAYE');

-- --------------------------------------------------------

--
-- Structure de la table `concours`
--

DROP TABLE IF EXISTS `concours`;
CREATE TABLE IF NOT EXISTS `concours` (
  `concours_id` int(11) NOT NULL AUTO_INCREMENT,
  `concours_libelle` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`concours_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `concours`
--

INSERT INTO `concours` (`concours_id`, `concours_libelle`) VALUES
(1, 'INHP'),
(2, 'INFS'),
(3, 'INFAS'),
(4, 'CAFOP'),
(5, 'POLICE'),
(6, 'GENDARMERIE');

-- --------------------------------------------------------

--
-- Structure de la table `detail_commande`
--

DROP TABLE IF EXISTS `detail_commande`;
CREATE TABLE IF NOT EXISTS `detail_commande` (
  `detail_commande_id` int(11) NOT NULL AUTO_INCREMENT,
  `commande_id` int(11) DEFAULT NULL,
  `livre_id` int(11) DEFAULT NULL,
  `detail_commande_livre_nom` varchar(255) DEFAULT NULL,
  `detail_commande_quantite` int(11) DEFAULT NULL,
  `detail_commande_prix` bigint(20) DEFAULT NULL,
  `detail_commande_statut_telechargement` enum('AUTORISE','NON AUTORISE') DEFAULT 'NON AUTORISE',
  `detail_commande_nombre_telechargement` int(11) DEFAULT '0',
  `detail_commande_date_creation` datetime DEFAULT NULL,
  PRIMARY KEY (`detail_commande_id`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `detail_commande`
--

INSERT INTO `detail_commande` (`detail_commande_id`, `commande_id`, `livre_id`, `detail_commande_livre_nom`, `detail_commande_quantite`, `detail_commande_prix`, `detail_commande_statut_telechargement`, `detail_commande_nombre_telechargement`, `detail_commande_date_creation`) VALUES
(1, 10, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-07-31 22:43:54'),
(2, 10, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-07-31 22:43:54'),
(3, 11, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-07-31 22:57:51'),
(4, 11, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-07-31 22:57:51'),
(5, 12, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-07-31 23:09:12'),
(6, 12, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-07-31 23:09:12'),
(7, 12, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-07-31 23:09:12'),
(8, 13, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 06:23:44'),
(9, 13, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 06:23:44'),
(10, 13, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 06:23:44'),
(11, 14, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 06:24:11'),
(12, 14, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 06:24:11'),
(13, 14, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 06:24:11'),
(14, 15, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 06:30:51'),
(15, 15, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 06:30:51'),
(16, 15, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 06:30:51'),
(17, 16, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 06:40:34'),
(18, 16, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 06:40:34'),
(19, 16, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 06:40:34'),
(20, 17, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 06:41:01'),
(21, 17, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 06:41:01'),
(22, 17, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 06:41:01'),
(23, 18, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 06:43:42'),
(24, 18, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 06:43:42'),
(25, 18, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 06:43:42'),
(26, 19, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 07:17:15'),
(27, 19, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 07:17:15'),
(28, 20, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 07:32:35'),
(29, 20, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 07:32:35'),
(30, 20, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 07:32:35'),
(31, 20, 1, NULL, 1, 2000, 'NON AUTORISE', 0, '2022-08-01 07:32:36'),
(32, 21, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 11:06:42'),
(33, 21, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 11:06:42'),
(34, 22, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 11:13:06'),
(35, 23, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 11:17:39'),
(36, 23, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 11:17:39'),
(37, 24, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 12:05:19'),
(38, 25, 1, NULL, 1, 2000, 'NON AUTORISE', 0, '2022-08-01 12:20:18'),
(39, 25, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 12:20:18'),
(40, 25, 2, NULL, 1, 3000, 'NON AUTORISE', 0, '2022-08-01 12:20:18'),
(41, 25, 4, NULL, 1, 2500, 'NON AUTORISE', 0, '2022-08-01 12:20:18'),
(42, 26, 3, NULL, 1, 5000, 'NON AUTORISE', 0, '2022-08-01 14:15:40'),
(43, 26, 1, NULL, 1, 2000, 'NON AUTORISE', 0, '2022-08-01 14:15:40');

-- --------------------------------------------------------

--
-- Structure de la table `livre`
--

DROP TABLE IF EXISTS `livre`;
CREATE TABLE IF NOT EXISTS `livre` (
  `livre_id` int(11) NOT NULL AUTO_INCREMENT,
  `concours_id` int(11) DEFAULT NULL,
  `livre_nom` varchar(50) DEFAULT NULL,
  `livre_description` varchar(255) DEFAULT NULL,
  `livre_couverture` varchar(255) DEFAULT NULL,
  `livre_fichier_complet` varchar(255) DEFAULT NULL,
  `livre_fichier_extrait` varchar(255) DEFAULT NULL,
  `livre_prix` bigint(20) DEFAULT NULL,
  `livre_statut` enum('VALIDE','SUPPRIME') DEFAULT 'VALIDE',
  PRIMARY KEY (`livre_id`),
  KEY `FK_livre_concours` (`concours_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `livre`
--

INSERT INTO `livre` (`livre_id`, `concours_id`, `livre_nom`, `livre_description`, `livre_couverture`, `livre_fichier_complet`, `livre_fichier_extrait`, `livre_prix`, `livre_statut`) VALUES
(1, 4, 'MATHEMATIQUES', 'Un très bon document de préparation des concours à avoir absolument. Il contient les sujets des sessions de 2000 à 2021', '1.jpg', '1.pdf', '1.pdf', 2000, 'VALIDE'),
(2, 3, 'FRANCAIS', 'Un très bon document de préparation des concours à avoir absolument. Il contient les sujets des sessions de 2000 à 2021', '2.jpg', '2.pdf', '2.pdf', 3000, 'VALIDE'),
(3, 5, 'OPAJ', 'Un très bon document de préparation des concours à avoir absolument. Il contient les sujets des sessions de 2000 à 2021', '3.jpg', '3.pdf', '3.pdf', 5000, 'VALIDE'),
(4, 6, 'DICTEE', 'Un très bon document de préparation des concours à avoir absolument. Il contient les sujets des sessions de 2000 à 2021', '4.jpg', '4.pdf', '4.pdf', 2500, 'VALIDE');

-- --------------------------------------------------------

--
-- Structure de la table `rcp_historique_connexion`
--

DROP TABLE IF EXISTS `rcp_historique_connexion`;
CREATE TABLE IF NOT EXISTS `rcp_historique_connexion` (
  `rcp_historique_connexion_id` int(11) NOT NULL AUTO_INCREMENT,
  `rcp_historique_connexion_login` varchar(100) DEFAULT NULL,
  `rcp_historique_connexion_password` varchar(100) DEFAULT NULL,
  `rcp_historique_connexion_etat` varchar(100) DEFAULT NULL,
  `rcp_historique_connexion_date` datetime DEFAULT NULL,
  `rcp_historique_connexion_date_modification` datetime DEFAULT NULL,
  `rcp_historique_connexion_ip` varchar(255) DEFAULT NULL,
  `rcp_historique_connexion_meta` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`rcp_historique_connexion_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `rcp_historique_connexion`
--

INSERT INTO `rcp_historique_connexion` (`rcp_historique_connexion_id`, `rcp_historique_connexion_login`, `rcp_historique_connexion_password`, `rcp_historique_connexion_etat`, `rcp_historique_connexion_date`, `rcp_historique_connexion_date_modification`, `rcp_historique_connexion_ip`, `rcp_historique_connexion_meta`) VALUES
(1, 'krak225@gmail.com', '$2y$10$Zpc.DHlN/YsIKk2mlubEQuXlhnMx0QbzJxlIiOnzdvbqq7VcNXS7a', 'AUTHENTICATED', '2022-07-31 00:12:15', '2022-07-31 00:12:16', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(2, 'djebaso@gmail.com', '$2y$10$F9QPmHjY7EI4d/VyUEXe6uROjLbVgA0T08Vmq2j63ajq43n0M1kRK', 'ATTEMPT', '2022-07-31 00:21:54', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(3, 'djebaso@gmail.com', '$2y$10$1fXiDXECS6vKES3d3ta2jOUFp8Jb2tcrx/fsbjb6QOCCruffn.Iui', 'ATTEMPT', '2022-07-31 19:54:49', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(4, 'djebaso@gmail.com', '$2y$10$n/7dyXc/Yk1HlFMMkcZFzeRdSdK1/IOe0mK3yhfaSnLyRo8jrx7eO', 'ATTEMPT', '2022-07-31 20:10:16', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(5, 'djebaso@gmail.com', '$2y$10$MbZO2SIb5taThTPK95.dJ.dql6y8JXKp2DzELvhW7gj6sd69Lfa4O', 'ATTEMPT', '2022-07-31 20:10:21', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(6, 'djebaso@gmail.com', '$2y$10$AMzqpUV7/9rijvN5CcQC4.4YkoDMYFjqrMi3EVFRtuy/hUBJy1XR.', 'ATTEMPT', '2022-07-31 20:10:33', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(7, 'krak225@gmail.com', '$2y$10$HA9AW4ln7bVOWFssyDDSruh/Lb3vXTiwx5PET3ZQGN6LyVPW6JoWy', 'AUTHENTICATED', '2022-07-31 20:11:01', '2022-07-31 20:11:02', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(8, 'krak225@gmail.com', '$2y$10$2Y086qBSvWTbEBPWJ.61iOsmXPpnFXv3tSSnAjCQ0ZJfvzuSG3mKu', 'AUTHENTICATED', '2022-07-31 20:58:12', '2022-07-31 20:58:12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(9, 'krak225@gmail.com', '$2y$10$vFlsz5Z20MZiRphwWLoFXOp1T7M0DADAeYJVJGLSzVBDmTzWmi9dq', 'AUTHENTICATED', '2022-07-31 23:08:45', '2022-07-31 23:08:45', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(10, 'marc@gmail.com', '$2y$10$WlZLdmytInpV5KmF5dlu3OJWKI1CHVYXwFQhnA6wfbZGRgMLJKs3C', 'AUTHENTICATED', '2022-08-01 06:23:38', '2022-08-01 06:23:39', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0'),
(11, 'emma@gmail.com', '$2y$10$XwyvSKEoxIIlmTSiPQJkbOqt5SZkzqBpSLyy6ettO6b1VJgdKbARm', 'AUTHENTICATED', '2022-08-01 11:06:36', '2022-08-01 11:06:36', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.5060.134 Safari/537.36 Edg/103.0.1264.71'),
(12, 'krak225@gmail.com', '$2y$10$5T2OQRZcpQqxqKO7SYUQzOdg1O1m5ovIvNCwzG72z7WVKMMDzYHE6', 'AUTHENTICATED', '2022-08-01 12:20:15', '2022-08-01 12:20:15', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:103.0) Gecko/20100101 Firefox/103.0');

-- --------------------------------------------------------

--
-- Structure de la table `tb_password_resets`
--

DROP TABLE IF EXISTS `tb_password_resets`;
CREATE TABLE IF NOT EXISTS `tb_password_resets` (
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tb_profil`
--

DROP TABLE IF EXISTS `tb_profil`;
CREATE TABLE IF NOT EXISTS `tb_profil` (
  `profil_id` int(11) NOT NULL AUTO_INCREMENT,
  `profil_libelle` varchar(50) DEFAULT NULL,
  `profil_statut` enum('VALIDE','BROUILLON','SUPPRIME') DEFAULT 'VALIDE',
  PRIMARY KEY (`profil_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `tb_profil`
--

INSERT INTO `tb_profil` (`profil_id`, `profil_libelle`, `profil_statut`) VALUES
(1, 'CLIENT', 'VALIDE');

-- --------------------------------------------------------

--
-- Structure de la table `tb_users`
--

DROP TABLE IF EXISTS `tb_users`;
CREATE TABLE IF NOT EXISTS `tb_users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type_declarant_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `profil_id` int(11) NOT NULL DEFAULT '2',
  `service_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `categorie_personnel_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `type_personnel_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `equipe_id` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `bureauID` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `nature_piece_id` int(10) UNSIGNED DEFAULT '0',
  `pays_id` int(10) UNSIGNED DEFAULT '0',
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenoms` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `societe` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_importateur` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_compte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_personne_id` int(11) DEFAULT NULL,
  `civilite` enum('M.','Mme','Mlle') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lieu_naissance` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_naissance` date DEFAULT NULL,
  `date_embauche` date DEFAULT NULL,
  `fonction` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `titre` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `libelle_interesse` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone_fixe` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `matricule` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_piece` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fichier_piece_identite` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_registre_commerce` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fichier_registre_commerce` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `numero_compte_contribuable` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signature` longtext COLLATE utf8mb4_unicode_ci,
  `adresse_postale` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adresse_email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `situation_geographique` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `ip_derniere_connexion` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_derniere_connexion` datetime DEFAULT NULL,
  `statut_connexion` enum('CONNECTE','DECONNECTE') COLLATE utf8mb4_unicode_ci DEFAULT 'DECONNECTE',
  `statut_signature` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `statut` enum('VALIDE','SUPPRIME') COLLATE utf8mb4_unicode_ci DEFAULT 'VALIDE',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `users_email_unique` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tb_users`
--

INSERT INTO `tb_users` (`id`, `type_declarant_id`, `profil_id`, `service_id`, `categorie_personnel_id`, `type_personnel_id`, `equipe_id`, `bureauID`, `nature_piece_id`, `pays_id`, `nom`, `prenoms`, `societe`, `code_importateur`, `type_compte`, `type_personne_id`, `civilite`, `lieu_naissance`, `date_naissance`, `date_embauche`, `fonction`, `titre`, `libelle_interesse`, `telephone`, `telephone_fixe`, `matricule`, `numero_piece`, `fichier_piece_identite`, `numero_registre_commerce`, `fichier_registre_commerce`, `numero_compte_contribuable`, `photo`, `signature`, `adresse_postale`, `adresse_email`, `situation_geographique`, `email`, `password`, `remember_token`, `created_at`, `updated_at`, `ip_derniere_connexion`, `date_derniere_connexion`, `statut_connexion`, `statut_signature`, `statut`) VALUES
(1, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'KOUASSI', 'RICHMOND', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'krak225@gmail.com', '$2y$10$wvJ0c/O21bMaifnw2K0bAO8vrCq3HxNc2l8G5Ok9v2JTX3SJxNpda', NULL, '2022-07-30 09:22:41', '2022-07-30 09:22:41', NULL, NULL, 'DECONNECTE', NULL, 'VALIDE'),
(2, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'dsdsd', 'sdsd', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'jsljd@sdsjdl', '$2y$10$T9viAsA4PS4ShTPuDI5KQesKKLAuuRCgih/L.49lYc3TZ0MbzyLhS', NULL, '2022-07-30 09:56:28', '2022-07-30 09:56:28', NULL, NULL, 'DECONNECTE', NULL, 'VALIDE'),
(3, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'KOUASSI', 'MARC', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'marc@gmail.com', '$2y$10$tM7VSpUy0OC4tXUX.pCPaOuZ5RyvT/bPIOrZkJCFsr2u9MFxS5UE.', NULL, '2022-07-31 17:55:31', '2022-07-31 17:55:31', NULL, NULL, 'DECONNECTE', NULL, 'VALIDE'),
(4, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'BOUSSOU', 'EMMA', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'emma@gmail.com', '$2y$10$u0Pca2.oVIzJ6wxsNJIOlumM8xiLms2kwE1azkOngNNdPitrqaBxO', NULL, '2022-08-01 10:46:32', '2022-08-01 10:46:32', NULL, NULL, 'DECONNECTE', NULL, 'VALIDE'),
(5, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'DOVOGUIE', 'FLORA', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'flora@gmail.com', '$2y$10$qqYk.wXxz0nMliHFLSPjZeMtx/R7QNu6CiYaww2ihhsNWiPxlxH8q', NULL, '2022-08-01 11:12:48', '2022-08-01 11:12:48', NULL, NULL, 'DECONNECTE', NULL, 'VALIDE'),
(6, 0, 2, 0, 0, 0, 0, 0, 0, 0, 'Coulibaly', 'Audrey', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', '', 'audrey@gmail.com', '$2y$10$JIDngx8Xqavq0zlPBFe8..2aXzCbyo2xd0l71NtDQEISQvJe.iEXa', NULL, '2022-08-01 14:15:35', '2022-08-01 14:15:35', NULL, NULL, 'DECONNECTE', NULL, 'VALIDE');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `livre`
--
ALTER TABLE `livre`
  ADD CONSTRAINT `FK_livre_concours` FOREIGN KEY (`concours_id`) REFERENCES `concours` (`concours_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
