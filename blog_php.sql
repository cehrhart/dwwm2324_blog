-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  lun. 07 jan. 2019 à 15:16
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `blog_php`
--

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `article_title` varchar(255) NOT NULL,
  `article_img` varchar(255) NOT NULL,
  `article_content` mediumtext NOT NULL,
  `article_createdate` datetime NOT NULL,
  `article_creator` int(11) NOT NULL,
  PRIMARY KEY (`article_id`),
  KEY `article_creator` (`article_creator`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `articles`
--

INSERT INTO `articles` (`article_id`, `article_title`, `article_img`, `article_content`, `article_createdate`, `article_creator`) VALUES
(1, 'LE devenir du Javascript', 'js.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vel accumsan tortor, finibus a tum fermentum, mauris odio consequat velit, eu hendrerit arcu magna nec tortor. Nulla facilisi.', '2017-05-11 00:00:00', 2),
(2, 'Qu\'est-ce que le HTML?', 'html.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vel accumsan tortor, finibus a tum fermentum, mauris odio consequat velit, eu hendrerit arcu magna nec tortor. Nulla facilisi.', '2017-04-04 00:00:00', 1),
(3, 'Utiliser le CSS correctement', 'css.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vel accumsan tortor, finibus a tum fermentum, mauris odio consequat velit, eu hendrerit arcu magna nec tortor. Nulla facilisi.', '2017-05-08 00:00:00', 1),
(4, 'Utiliser PhpMyAdmin', 'mysql.png', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam vel accumsan tortor, finibus a tum fermentum, mauris odio consequat velit, eu hendrerit arcu magna nec tortor. Nulla facilisi.', '2017-05-21 00:00:00', 1),
(5, 'Les bases du PHP', 'php.png', 'Vous en êtes où ?', '2017-04-26 00:00:00', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `user_pwd` varchar(255) NOT NULL,
  PRIMARY KEY (`user_id`),
  KEY `user_mail` (`user_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_firstname`, `user_mail`, `user_pwd`) VALUES
(1, 'Ehrhart', 'Christel', 'contact@ce-formation.com', 'Christel1234'),
(2, 'Test', 'Utilisateur', 'tes@ce-formation.com', 'Test1234');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`article_creator`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
