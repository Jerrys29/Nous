-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 06 fév. 2024 à 07:35
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `nous`
--

-- --------------------------------------------------------

--
-- Structure de la table `likes`
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE IF NOT EXISTS `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `like_to` int NOT NULL,
  `liked_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `like_to` (`like_to`),
  KEY `liked_by` (`liked_by`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `like_to`, `liked_by`, `created_at`, `updated_at`) VALUES
(9, 9, 10, '2024-01-31 14:05:03', '2024-01-31 14:05:03'),
(8, 9, 10, '2024-01-31 14:04:01', '2024-01-31 14:04:01'),
(10, 9, 10, '2024-01-31 14:05:23', '2024-01-31 14:05:23'),
(18, 9, 11, '2024-02-02 10:36:13', '2024-02-02 10:36:13');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `numero` bigint NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pseudo` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `numero` bigint DEFAULT NULL,
  `town` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `looking_for` varchar(255) DEFAULT NULL,
  `genre` varchar(255) NOT NULL,
  `mariatal_status` varchar(255) DEFAULT NULL,
  `hair_color` varchar(255) DEFAULT NULL,
  `eyes_color` varchar(255) DEFAULT NULL,
  `origin_country` varchar(255) DEFAULT NULL,
  `espace` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `photo1` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `photo2` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `photo3` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `photo4` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `photo5` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `age` int DEFAULT NULL,
  `about` text,
  `interests` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `paiement` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pseudo`, `role`, `numero`, `town`, `password`, `birthdate`, `birthplace`, `looking_for`, `genre`, `mariatal_status`, `hair_color`, `eyes_color`, `origin_country`, `espace`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`, `age`, `about`, `interests`, `active`, `paiement`, `created_at`, `updated_at`) VALUES
(1, 'dsfsd', NULL, 'sdfcg', '', NULL, 'sdfcgvh', NULL, '2024-01-01', 'hgfdsq', 'femme', '', 'marie', 'brun', 'marron', 'Gambia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2024-01-25 10:02:38', '2024-01-25 10:02:38'),
(2, 'dsfsd', NULL, 'sdfcg', '', NULL, 'sdfcgvh', NULL, '2024-01-01', 'hgfdsq', 'femme', '', 'marie', 'brun', 'marron', 'Gambia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2024-01-25 10:04:28', '2024-01-25 10:04:28'),
(3, 'dsfsd', NULL, 'sdfcg', '', NULL, 'sdfcgvh', NULL, '2024-01-01', 'hgfdsq', 'femme', '', 'marie', 'brun', 'marron', 'Gambia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2024-01-25 10:05:33', '2024-01-25 10:05:33'),
(4, 'dz', NULL, 'qs', '', NULL, 'qx', NULL, '2024-01-04', 'qs', 'homme', '', 'celibataire', 'brun', 'marron', 'Togo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2024-01-26 06:43:38', '2024-01-26 06:43:38'),
(5, 'fghjsk', NULL, 'czjsk', '', NULL, 'rtfyu', NULL, '2024-01-01', 'xwdsret', 'femme', '', 'marie', 'blond', 'noir', 'Guinea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2024-01-29 07:18:31', '2024-01-29 07:18:31'),
(6, 'fghjsk', NULL, 'czjsk', '', NULL, 'rtfyu', NULL, '2024-01-01', 'xwdsret', 'femme', '', 'marie', 'blond', 'noir', 'Guinea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, '2024-01-29 07:22:11', '2024-01-29 07:22:11'),
(7, 'zesdrtfyujiklkkl', NULL, 'iujh', '', NULL, 'zrt', NULL, '2024-01-01', 'ertyu', 'femme', '', 'marie', 'blond', 'noir', 'Ivoire', NULL, 'photos/lhFtPPxJ40uBXkebc9DFms5Fsg2mu1qxJJYY1h7q.jpg', NULL, NULL, NULL, NULL, NULL, 'Etudiant hjklr;az,rzrjvdfk', NULL, 0, 0, '2024-01-29 07:34:25', '2024-01-29 07:34:25'),
(8, 'sssssfgv', NULL, 'djk', 'nous', 60183568, 'qqq', '$2y$12$V6OCmD5ea5iHbKwLM7XvYux48NTnqkMgXOaP0Ug8QhW5mwQFyPjiq', '2024-01-01', 'sdsds', 'femme', '', 'celibataire', 'brun', NULL, 'Benin', NULL, NULL, NULL, NULL, NULL, NULL, 19, 'ztffffffffffffffffffffffffffffffffffffffffffffffffffffffff yy', 'sdfghj,rfguio', 0, 0, '2024-01-29 09:31:27', '2024-01-29 13:49:04'),
(9, 'Joel', NULL, 'jl', 'nous', 67651240, 'jhuj', '$2y$12$9s9s79w9aLiuHTuFcYb/TOrfwU9TWRnmP1Y1ra4jvhQdIxShU82ia', '2024-01-01', 'dtryuui', 'femme', 'homme', 'celibataire', 'noir', 'noirs', 'Benin', NULL, 'photos/lhFtPPxJ40uBXkebc9DFms5Fsg2mu1qxJJYY1h7q.jpg', 'photos/bjFlhhmki5m3oJ4gDBr2dvsvYZg9eQTRSWIBfnKm.jpg', 'photos/P17e3ok2mD5W52YiGIKhhXogJEEkwudqZNwvG7JZ.jpg', 'photos/YRO1ldG4pBWi0U4CHQJwQ43Vru9GxB2vJcQpIyKu.jpg', 'photos/mLHM79UNRutseGobP7D2S0RfOPy84QIV6cmaO9r5.jpg', 18, 'Etudiant hjklr;az,rzrjvdfk', 'foot,lecture', 0, 1, '2024-01-29 09:39:52', '2024-01-30 12:05:37'),
(10, 'Nathan', NULL, 'nath', 'nous', 60189511, 'Cotonou', '$2y$12$d8U4tUhi8uYz75nskb0MZuxbF3RvY6qN.DJucrPZvuEvOeFdC4jY2', '2003-06-11', 'Cotonou', 'homme', 'femme', 'celibataire', 'noir', NULL, 'Benin', NULL, 'photos/2SVb8BnokqS46QtE7NoH9Lg7pFxz7O7vpbqRQwq9.jpg', NULL, NULL, NULL, NULL, 24, 'Jeune etudiant', 'foot', 0, 1, '2024-01-30 11:57:26', '2024-01-30 12:10:02'),
(11, 'Rachelle', NULL, 'Rach', 'nous', 96990965, 'jjhte', '$2y$12$ZZoTum8mAohvle3HLcoH4OpdJPmYdAyERuRb1XO5s5cJfJJUmY3re', '2002-06-05', 'uujr', 'homme', 'femme', 'celibataire', 'noir', 'marron', 'Benin', NULL, 'photos/TGIftqmPPPC0SiMZBcyLv3F6Upt5UWlAh1oKA6VK.jpg', 'photos/7ma3jF2buCMHQ1XD4qwjvNdbjVlCKIORJlpHXPa3.jpg', NULL, NULL, NULL, 21, 'Etudiante', 'Foot,lecture,musique', 0, 1, '2024-02-02 06:59:10', '2024-02-02 07:03:56');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
