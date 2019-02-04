-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 31 Janvier 2019 à 10:24
-- Version du serveur :  5.7.25-0ubuntu0.18.04.2
-- Version de PHP :  7.2.10-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `lecteur`
--
CREATE DATABASE IF NOT EXISTS `lecteur` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lecteur`;

-- --------------------------------------------------------

--
-- Structure de la table `mp3_albums`
--

CREATE TABLE IF NOT EXISTS `mp3_albums` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_profil_artiste` mediumint(8) UNSIGNED NOT NULL,
  `titre` varchar(60) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_profil_artiste` (`id_profil_artiste`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `mp3_ecoutes`
--

CREATE TABLE IF NOT EXISTS `mp3_ecoutes` (
  `id_fichier` mediumint(8) UNSIGNED NOT NULL,
  `id_pers` mediumint(8) UNSIGNED NOT NULL,
  `date_first_ecoute` datetime NOT NULL COMMENT 'date de la première écoute',
  `pourcent_ecoute` float UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Un nombre entre 0 et 1',
  `is_liked` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_fichier`,`id_pers`),
  KEY `id_pers` (`id_pers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Ecoutes ralatives à un morceau en particulier';

-- --------------------------------------------------------

--
-- Structure de la table `mp3_fichiers`
--

CREATE TABLE IF NOT EXISTS `mp3_fichiers` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_album` mediumint(8) UNSIGNED DEFAULT NULL,
  `id_style` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `id_profil_artiste` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `id_licence` tinyint(3) UNSIGNED DEFAULT '4',
  `libelle` varchar(100) NOT NULL DEFAULT 'Titre du morceau',
  `liste_points` varchar(2024) NOT NULL COMMENT 'Tableau des coordonnées de point de la musique',
  `chemin_mp3` varchar(255) NOT NULL,
  `chemin_pochette` varchar(255) NOT NULL,
  `artiste_original` varchar(60) NOT NULL COMMENT 'Dans le cas d''une reprise',
  `composition` enum('N','Y') NOT NULL DEFAULT 'N' COMMENT '''Y'' si le morceau est une composition, ''N'' si c''est une reprise',
  `taille` int(11) DEFAULT NULL,
  `duree` time NOT NULL,
  `nb_ecoutes` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `nb_telechargements` smallint(5) UNSIGNED NOT NULL DEFAULT '0',
  `date_insertion` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `id_profil_artiste` (`id_profil_artiste`),
  KEY `id_album` (`id_album`),
  KEY `id_style` (`id_style`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `mp3_playlist`
--

CREATE TABLE IF NOT EXISTS `mp3_playlist` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_pers` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mp3_playlist` (`id_pers`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='Playlist de musiques';

-- --------------------------------------------------------

--
-- Structure de la table `mp3_playlist_fichiers`
--

CREATE TABLE IF NOT EXISTS `mp3_playlist_fichiers` (
  `id_playlist` mediumint(8) UNSIGNED NOT NULL,
  `id_fichier` mediumint(8) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_playlist`,`id_fichier`),
  KEY `mp3_playlist_fichiers_ibfk_2` (`id_fichier`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `mp3_styles`
--

CREATE TABLE IF NOT EXISTS `mp3_styles` (
  `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `pers_personnes`
--

CREATE TABLE IF NOT EXISTS `pers_personnes` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `date_inscription` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `login` varchar(25) CHARACTER SET utf8 NOT NULL,
  `md5_password` varchar(32) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(70) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `profil_profils_artistes`
--

CREATE TABLE IF NOT EXISTS `profil_profils_artistes` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `mp3_albums`
--
ALTER TABLE `mp3_albums`
  ADD CONSTRAINT `mp3_albums_ibfk_1` FOREIGN KEY (`id_profil_artiste`) REFERENCES `profil_profils_artistes` (`id`);

--
-- Contraintes pour la table `mp3_ecoutes`
--
ALTER TABLE `mp3_ecoutes`
  ADD CONSTRAINT `mp3_ecoutes_ibfk_1` FOREIGN KEY (`id_pers`) REFERENCES `pers_personnes` (`id`),
  ADD CONSTRAINT `mp3_ecoutes_ibfk_2` FOREIGN KEY (`id_fichier`) REFERENCES `mp3_fichiers` (`id`);

--
-- Contraintes pour la table `mp3_fichiers`
--
ALTER TABLE `mp3_fichiers`
  ADD CONSTRAINT `mp3_fichiers_ibfk_1` FOREIGN KEY (`id_profil_artiste`) REFERENCES `profil_profils_artistes` (`id`),
  ADD CONSTRAINT `mp3_fichiers_ibfk_2` FOREIGN KEY (`id_album`) REFERENCES `mp3_albums` (`id`),
  ADD CONSTRAINT `mp3_fichiers_ibfk_3` FOREIGN KEY (`id_style`) REFERENCES `mp3_styles` (`id`);

--
-- Contraintes pour la table `mp3_playlist`
--
ALTER TABLE `mp3_playlist`
  ADD CONSTRAINT `mp3_playlist_ibfk_1` FOREIGN KEY (`id_pers`) REFERENCES `pers_personnes` (`id`);

--
-- Contraintes pour la table `mp3_playlist_fichiers`
--
ALTER TABLE `mp3_playlist_fichiers`
  ADD CONSTRAINT `mp3_playlist_fichiers_ibfk_1` FOREIGN KEY (`id_playlist`) REFERENCES `mp3_playlist` (`id`),
  ADD CONSTRAINT `mp3_playlist_fichiers_ibfk_2` FOREIGN KEY (`id_fichier`) REFERENCES `mp3_fichiers` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
