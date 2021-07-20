-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 20 juil. 2021 à 17:18
-- Version du serveur :  5.7.31
-- Version de PHP : 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `blog`
--

-- --------------------------------------------------------

--
-- Structure de la table `blogpost`
--

DROP TABLE IF EXISTS "blogpost";
CREATE TABLE IF NOT EXISTS "blogpost" (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `creation_date` datetime NOT NULL,
  `modification_date` datetime DEFAULT NULL,
  `content` text NOT NULL,
  `headline` text NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `fk_user_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `blogpost`
--

INSERT INTO `blogpost` (`post_id`, `user_id`, `title`, `creation_date`, `modification_date`, `content`, `headline`) VALUES
(10, 32, 'Among Us s’offre plusieurs éditions physiques collectors', '2021-07-09 10:03:28', '2021-07-19 11:18:23', '<p>Lors du Summer Game Fest, Innersloth avait dévoilé plusieurs nouveautés qui allaient arriver dans de prochaines mises à jour sur Among Us. L’un d’entre elles a déjà été déployée et elle a amené avec elle des parties allant jusqu’à 15 joueurs maximum, la prise en charge des manettes ainsi que d’autres corrections de bugs.</p>\r\n<p>Ce 7 juillet, le studio a également dévoilé qu’une autre mise à jour avait fait son chemin sur toutes les versions du jeu qui rendait possible le nettoyage des conduits d’aérations. Ceux-ci permettent aux imposteurs de pouvoir se déplacer plus rapidement d’un bout à l’autre de la map sans se faire repérer par les membres de l’équipage.</p>', 'Durant ces derniers jours, Innersloth a fait une floppée d’annonces concernant à la fois les mises à jour d’Among Us à venir, ainsi que des éditions physiques du jeu.');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `creation_date` datetime NOT NULL,
  `content` text NOT NULL,
  `published` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`),
  KEY `fk_blogpost_post_id` (`post_id`),
  KEY `fk1_user_user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`comment_id`, `post_id`, `user_id`, `creation_date`, `content`, `published`) VALUES
(27, 10, 34, '2021-07-09 11:05:31', 'comment', 1);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(35) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(320) NOT NULL,
  `role` int(11) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_unique_email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `login`, `password`, `email`, `role`, `token`) VALUES
(32, 'admin', '$2y$10$2IhTZyBV8IgUD37ioaQDPejCJt274583uhBvBbyIOaL7qJeMGUmoe', 'admin@gmail.com', 1, ''),
(34, 'session', '$2y$10$rv/fPqbJuyGcwsL.k4BBCu3se/Btl8SHpKy.y30YEFZKElUklMh.i', 'session@gmail.com', 0, '');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `blogpost`
--
ALTER TABLE `blogpost`
  ADD CONSTRAINT `fk_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `fk1_user_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_blogpost_post_id` FOREIGN KEY (`post_id`) REFERENCES `blogpost` (`post_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
