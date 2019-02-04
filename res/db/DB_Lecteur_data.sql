-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 31 Janvier 2019 à 10:25
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
CREATE DATABASE IF NOT EXISTS `lecteur_test` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lecteur_test`;

--
-- Contenu de la table `mp3_albums`
--

INSERT INTO `mp3_albums` (`id`, `id_profil_artiste`, `titre`, `date`) VALUES
(1, 1, 'Agartha', '2017-01-01'),
(2, 6, 'On You', '2018-01-01'),
(3, 9, 'Kickass Metal', '1990-01-01');

--
-- Contenu de la table `mp3_ecoutes`
--

INSERT INTO `mp3_ecoutes` (`id_fichier`, `id_pers`, `date_first_ecoute`, `pourcent_ecoute`, `is_liked`) VALUES
(1, 4, '2019-01-30 11:35:36', 0.55, 0),
(1, 5, '2019-01-30 11:00:20', 0.3, 0),
(2, 4, '2019-01-30 11:00:20', 0.66, 0);

--
-- Contenu de la table `mp3_fichiers`
--

INSERT INTO `mp3_fichiers` (`id`, `id_album`, `id_style`, `id_profil_artiste`, `id_licence`, `libelle`, `liste_points`, `chemin_mp3`, `chemin_pochette`, `artiste_original`, `composition`, `taille`, `duree`, `nb_ecoutes`, `nb_telechargements`, `date_insertion`) VALUES
(1, 1, 4, 1, 4, 'Eurotrap', '[2 , 5, 4, 4, 1, 6, 6, 4, 2, 4, 6, 6, 5, 4, 5, 4, 3, 2, 3, 2, 3, 2, 2, 2, 3, 3, 2, 3, 4, 4, 3, 2, 2, 1, 1, 1, 2, 2, 3, 3, 4, 3, 3, 2, 3, 2, 0, 0, 1, 6, 4, 3, 1, 2, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1, 4, 4, 3, 4, 4, 3, 1, 1, 2, 2, 4, 4, 3, 1, 2, 5, 4, 2, 5, 5, 3, 2, 3, 4, 3, 5, 9, 10, 10, 15, 16, 13, 8, 12, 14, 13, 7, 14, 16, 11, 7, 15, 13, 13, 14, 15, 15, 9, 9, 16, 12, 7, 14, 17, 13, 8, 21, 25, 19, 5, 5, 6, 6, 4, 5, 7, 4, 3, 3, 4, 5, 7, 7, 5, 2, 4, 5, 5, 4, 5, 6, 5, 5, 5, 6, 7, 11, 12, 12, 16, 21, 18, 11, 11, 18, 15, 11, 14, 18, 17, 6, 13, 18, 13, 13, 16, 15, 13, 6, 14, 14, 11, 6, 14, 15, 9, 10, 22, 20, 17, 4, 5, 4, 4, 5, 5, 5, 6, 7, 6, 5, 4, 6, 7, 4, 1, 3, 3, 4, 3, 4, 4, 5, 5, 6, 5, 4, 5, 6, 5, 13, 15, 16, 15, 14, 17, 10, 8, 9, 7, 6, 7, 7, 7, 5, 8, 16, 16, 16, 13, 14, 13, 10, 7, 8, 9, 8, 9, 12, 9, 6, 7, 5, 7, 4, 8, 8, 8, 6, 8, 7, 7, 10, 15, 17, 23, 16, 18, 11, 4, 2, 3, 2, 2, 6, 7, 9, 5, 7, 9, 6, 5, 4, 5, 7, 11, 15, 16, 12, 8, 8, 9, 6, 5, 8, 8, 7, 6, 9, 9, 13, 17, 17, 17, 20, 17, 15, 9, 15, 15, 14, 7, 16, 17, 13, 7, 16, 17, 14, 15, 16, 17, 11, 9, 16, 14, 9, 10, 15, 15, 8, 14, 25, 21, 23, 29, 40, 32, 22, 31, 34, 31, 8, 5, 11, 7, 7, 9, 12, 8, 4, 4, 5, 7, 16, 22, 26, 25, 33, 33, 29, 21, 30, 28, 22, 23, 23, 20, 13, 21, 23, 18, 13, 25, 23, 6, 8, 14, 21, 27, 34, 33, 24, 17, 28, 24, 16, 18, 20, 14, 5, 10, 15, 20, 27, 32, 32, 27, 33, 28, 30, 31, 40, 38, 21]', 'vald-eurotrap.mp3', 'vald-eurotrap.jpg', 'Vald', 'N', NULL, '11:12:00', 999, 555, '2019-01-30 10:57:10'),
(2, 2, 3, 6, 4, 'On You', '[2 , 5, 4, 4, 1, 6, 6, 4, 2, 4, 6, 6, 5, 4, 5, 4, 3, 2, 3, 2, 3, 2, 2, 2, 3, 3, 2, 3, 4, 4, 3, 2, 2, 1, 1, 1, 2, 2, 3, 3, 4, 3, 3, 2, 3, 2, 0, 0, 1, 6, 4, 3, 1, 2, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1, 4, 4, 3, 4, 4, 3, 1, 1, 2, 2, 4, 4, 3, 1, 2, 5, 4, 2, 5, 5, 3, 2, 3, 4, 3, 5, 9, 10, 10, 15, 16, 13, 8, 12, 14, 13, 7, 14, 16, 11, 7, 15, 13, 13, 14, 15, 15, 9, 9, 16, 12, 7, 14, 17, 13, 8, 21, 25, 19, 5, 5, 6, 6, 4, 5, 7, 4, 3, 3, 4, 5, 7, 7, 5, 2, 4, 5, 5, 4, 5, 6, 5, 5, 5, 6, 7, 11, 12, 12, 16, 21, 18, 11, 11, 18, 15, 11, 14, 18, 17, 6, 13, 18, 13, 13, 16, 15, 13, 6, 14, 14, 11, 6, 14, 15, 9, 10, 22, 20, 17, 4, 5, 4, 4, 5, 5, 5, 6, 7, 6, 5, 4, 6, 7, 4, 1, 3, 3, 4, 3, 4, 4, 5, 5, 6, 5, 4, 5, 6, 5, 13, 15, 16, 15, 14, 17, 10, 8, 9, 7, 6, 7, 7, 7, 5, 8, 16, 16, 16, 13, 14, 13, 10, 7, 8, 9, 8, 9, 12, 9, 6, 7, 5, 7, 4, 8, 8, 8, 6, 8, 7, 7, 10, 15, 17, 23, 16, 18, 11, 4, 2, 3, 2, 2, 6, 7, 9, 5, 7, 9, 6, 5, 4, 5, 7, 11, 15, 16, 12, 8, 8, 9, 6, 5, 8, 8, 7, 6, 9, 9, 13, 17, 17, 17, 20, 17, 15, 9, 15, 15, 14, 7, 16, 17, 13, 7, 16, 17, 14, 15, 16, 17, 11, 9, 16, 14, 9, 10, 15, 15, 8, 14, 25, 21, 23, 29, 40, 32, 22, 31, 34, 31, 8, 5, 11, 7, 7, 9, 12, 8, 4, 4, 5, 7, 16, 22, 26, 25, 33, 33, 29, 21, 30, 28, 22, 23, 23, 20, 13, 21, 23, 18, 13, 25, 23, 6, 8, 14, 21, 27, 34, 33, 24, 17, 28, 24, 16, 18, 20, 14, 5, 10, 15, 20, 27, 32, 32, 27, 33, 28, 30, 31, 40, 38, 21]', 'kazy-lambist-onyou.mp3', 'kazy-lambist-onyou.jpg', 'Kazy Lambist', 'N', NULL, '11:12:00', 333, 666, '2019-01-30 10:57:10'),
(3, 3, 1, 9, 4, 'Nothing Else Matters', '[2 , 5, 4, 4, 1, 6, 6, 4, 2, 4, 6, 6, 5, 4, 5, 4, 3, 2, 3, 2, 3, 2, 2, 2, 3, 3, 2, 3, 4, 4, 3, 2, 2, 1, 1, 1, 2, 2, 3, 3, 4, 3, 3, 2, 3, 2, 0, 0, 1, 6, 4, 3, 1, 2, 1, 0, 1, 0, 0, 0, 0, 1, 0, 0, 1, 4, 4, 3, 4, 4, 3, 1, 1, 2, 2, 4, 4, 3, 1, 2, 5, 4, 2, 5, 5, 3, 2, 3, 4, 3, 5, 9, 10, 10, 15, 16, 13, 8, 12, 14, 13, 7, 14, 16, 11, 7, 15, 13, 13, 14, 15, 15, 9, 9, 16, 12, 7, 14, 17, 13, 8, 21, 25, 19, 5, 5, 6, 6, 4, 5, 7, 4, 3, 3, 4, 5, 7, 7, 5, 2, 4, 5, 5, 4, 5, 6, 5, 5, 5, 6, 7, 11, 12, 12, 16, 21, 18, 11, 11, 18, 15, 11, 14, 18, 17, 6, 13, 18, 13, 13, 16, 15, 13, 6, 14, 14, 11, 6, 14, 15, 9, 10, 22, 20, 17, 4, 5, 4, 4, 5, 5, 5, 6, 7, 6, 5, 4, 6, 7, 4, 1, 3, 3, 4, 3, 4, 4, 5, 5, 6, 5, 4, 5, 6, 5, 13, 15, 16, 15, 14, 17, 10, 8, 9, 7, 6, 7, 7, 7, 5, 8, 16, 16, 16, 13, 14, 13, 10, 7, 8, 9, 8, 9, 12, 9, 6, 7, 5, 7, 4, 8, 8, 8, 6, 8, 7, 7, 10, 15, 17, 23, 16, 18, 11, 4, 2, 3, 2, 2, 6, 7, 9, 5, 7, 9, 6, 5, 4, 5, 7, 11, 15, 16, 12, 8, 8, 9, 6, 5, 8, 8, 7, 6, 9, 9, 13, 17, 17, 17, 20, 17, 15, 9, 15, 15, 14, 7, 16, 17, 13, 7, 16, 17, 14, 15, 16, 17, 11, 9, 16, 14, 9, 10, 15, 15, 8, 14, 25, 21, 23, 29, 40, 32, 22, 31, 34, 31, 8, 5, 11, 7, 7, 9, 12, 8, 4, 4, 5, 7, 16, 22, 26, 25, 33, 33, 29, 21, 30, 28, 22, 23, 23, 20, 13, 21, 23, 18, 13, 25, 23, 6, 8, 14, 21, 27, 34, 33, 24, 17, 28, 24, 16, 18, 20, 14, 5, 10, 15, 20, 27, 32, 32, 27, 33, 28, 30, 31, 40, 38, 21]', 'metallica.mp3', 'metallica.jpg', 'Metallica', 'N', NULL, '11:12:00', 17666, 15443, '2019-01-30 10:57:10');

--
-- Contenu de la table `mp3_playlist`
--

INSERT INTO `mp3_playlist` (`id`, `id_pers`, `name`) VALUES
(1, 3, ''),
(2, 4, ''),
(3, 5, '');

--
-- Contenu de la table `mp3_playlist_fichiers`
--

INSERT INTO `mp3_playlist_fichiers` (`id_playlist`, `id_fichier`) VALUES
(1, 1),
(1, 2),
(1, 3);

--
-- Contenu de la table `mp3_styles`
--

INSERT INTO `mp3_styles` (`id`, `libelle`) VALUES
(1, 'ROCK'),
(2, 'POP'),
(3, 'ELECTRO'),
(4, 'RAP'),
(5, 'CLASSIQUE');

--
-- Contenu de la table `pers_personnes`
--

INSERT INTO `pers_personnes` (`id`, `date_inscription`, `login`, `md5_password`, `nom`, `prenom`, `email`) VALUES
(3, '2019-01-30 10:39:42', 'toto', 'f71dbe52628a3f83a77ab494817525c6', 'Toto', 'tutu', 'tutu.toto@tutu.com'),
(4, '2019-01-30 10:39:42', 'tata', '49d02d55ad10973b7b9d0dc9eba7fdf0', 'Tata', 'tete', 'tete.tata@tete.com'),
(5, '2019-01-30 10:39:42', 'titi', '5d933eef19aee7da192608de61b6c23d', 'Titi', 'tyty', 'tyty.titi@tyty.com');

--
-- Contenu de la table `profil_profils_artistes`
--

INSERT INTO `profil_profils_artistes` (`id`, `nom`) VALUES
(1, 'VALD'),
(2, 'SOPRANO'),
(3, 'BACH'),
(4, 'MOZART'),
(5, 'DAVID GUETTA'),
(6, 'KAZY LAMBIST'),
(7, 'NIRVANA'),
(8, 'LED ZEPPELIN'),
(9, 'METALLICA'),
(10, 'KATY PERRY'),
(11, 'RIHANNA');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
