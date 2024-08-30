-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 22 mai 2024 à 15:41
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
-- Structure de la table `discussions`
--

DROP TABLE IF EXISTS `discussions`;
CREATE TABLE IF NOT EXISTS `discussions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name_sender` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `numero` varchar(255) DEFAULT NULL,
  `message` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `discussions`
--

INSERT INTO `discussions` (`id`, `name_sender`, `numero`, `message`, `created_at`, `updated_at`) VALUES
(3, NULL, NULL, 'cc', '2024-02-11 03:48:31', '2024-02-11 03:48:31'),
(4, NULL, NULL, 'yyy', '2024-02-11 03:48:42', '2024-02-11 03:48:42'),
(5, 'Dako', '60189511', 'cc', '2024-02-11 04:01:21', '2024-02-11 04:01:21'),
(6, 'Dako', '60189512', 'gyj', '2024-02-11 04:35:24', '2024-02-11 04:35:24'),
(7, 'Dako', '60189511', 'coucou', '2024-02-11 04:45:56', '2024-02-11 04:45:56'),
(8, 'Dako', '60189512', 'salut', '2024-02-11 04:49:33', '2024-02-11 04:49:33'),
(9, 'Dako', '60189512', 'J\'aimerais vous signaler un delit dotn j\'ai ete victime', '2024-02-11 04:50:20', '2024-02-11 04:50:20'),
(10, 'Dako', '60189512', 'Alors merci', '2024-02-11 04:50:33', '2024-02-11 04:50:33'),
(11, 'Dako', '60189511', 'cc', '2024-02-11 23:50:21', '2024-02-11 23:50:21'),
(12, 'Dako', '60189511', 'cc', '2024-02-12 14:03:30', '2024-02-12 14:03:30'),
(13, 'Dako', '60189511', 'cc', '2024-02-12 14:03:34', '2024-02-12 14:03:34'),
(14, 'Dako', '60189511', 'cc', '2024-02-12 14:03:45', '2024-02-12 14:03:45'),
(15, 'Dako', '60189511', 'cc', '2024-02-12 14:03:46', '2024-02-12 14:03:46'),
(16, 'Dako', '60189511', 'cc', '2024-02-12 14:03:46', '2024-02-12 14:03:46'),
(17, 'Dako', '60189511', 'cc', '2024-02-12 14:03:46', '2024-02-12 14:03:46'),
(18, 'Dako', '60189511', 'cc', '2024-02-12 14:03:46', '2024-02-12 14:03:46'),
(19, 'Dako', '60189511', 'cc', '2024-02-12 14:03:46', '2024-02-12 14:03:46'),
(20, 'Dako', '60189511', 'cc', '2024-02-12 14:03:47', '2024-02-12 14:03:47'),
(21, 'Dako', '60189511', 'cc', '2024-02-12 14:03:47', '2024-02-12 14:03:47'),
(22, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:04', '2024-02-12 14:04:04'),
(23, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:05', '2024-02-12 14:04:05'),
(24, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:06', '2024-02-12 14:04:06'),
(25, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:06', '2024-02-12 14:04:06'),
(26, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:06', '2024-02-12 14:04:06'),
(27, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:06', '2024-02-12 14:04:06'),
(28, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:07', '2024-02-12 14:04:07'),
(29, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:07', '2024-02-12 14:04:07'),
(30, 'Dako', '60189511', 'ccdfg', '2024-02-12 14:04:07', '2024-02-12 14:04:07'),
(31, 'Dako', '60189511', 'cc', '2024-02-12 14:04:21', '2024-02-12 14:04:21'),
(32, 'Dako', '60189511', 'cc', '2024-02-12 14:04:24', '2024-02-12 14:04:24'),
(33, 'Dako', '60189511', 'cc', '2024-02-12 14:05:44', '2024-02-12 14:05:44'),
(34, 'Dako', '60189511', 'cc', '2024-02-12 14:07:39', '2024-02-12 14:07:39'),
(35, 'Dako', '60189511', 'cc', '2024-02-12 14:58:52', '2024-02-12 14:58:52'),
(36, 'Dako', '60189511', 'cc', '2024-02-12 15:26:58', '2024-02-12 15:26:58'),
(37, 'Dako', '60189511', 'cc', '2024-02-12 15:29:24', '2024-02-12 15:29:24'),
(38, 'Dako', '60189511', 'dt', '2024-02-12 16:02:55', '2024-02-12 16:02:55'),
(39, 'Dako', '60189511', 'cc', '2024-02-12 16:04:42', '2024-02-12 16:04:42'),
(40, 'Dako', '60189511', 'cc', '2024-02-12 16:10:19', '2024-02-12 16:10:19'),
(41, 'Dako', '60189511', 'jkl', '2024-02-12 17:43:21', '2024-02-12 17:43:21'),
(42, 'Dako', '60189511', 'cc', '2024-02-12 17:59:23', '2024-02-12 17:59:23'),
(43, 'Dako', '60189511', 'cc', '2024-02-12 18:33:25', '2024-02-12 18:33:25'),
(44, 'Dako', '60189512', 'cc', '2024-02-12 18:58:14', '2024-02-12 18:58:14'),
(45, 'Dako', '60189511', 'bonsoir oj', '2024-02-12 20:18:29', '2024-02-12 20:18:29');

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
  `message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `like_to` (`like_to`),
  KEY `liked_by` (`liked_by`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `likes`
--

INSERT INTO `likes` (`id`, `like_to`, `liked_by`, `created_at`, `updated_at`, `message`) VALUES
(1, 9, 12, '2024-03-22 07:01:21', '2024-03-22 07:01:21', 'Anita a aimé votre profil.'),
(2, 11, 12, '2024-03-22 07:01:25', '2024-03-22 07:01:25', 'Anita a aimé votre profil.'),
(3, 13, 12, '2024-03-22 07:01:27', '2024-03-22 07:01:27', 'Anita a aimé votre profil.'),
(4, 16, 10, '2024-03-25 08:11:39', '2024-03-25 08:11:39', 'Nathan a aimé votre profil.'),
(5, 13, 10, '2024-03-25 08:11:44', '2024-03-25 08:11:44', 'Nathan a aimé votre profil.'),
(6, 9, 10, '2024-03-25 08:25:48', '2024-03-25 08:25:48', 'Nathan a aimé votre profil.');

-- --------------------------------------------------------

--
-- Structure de la table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message` text NOT NULL,
  `user_id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Rachelle a aimé votre profil.', 9, '2024-03-22 06:52:26', '2024-03-22 06:52:26'),
(2, 'Rachelle a aimé votre profil.', 12, '2024-03-22 06:52:30', '2024-03-22 06:52:30'),
(3, 'Rachelle a aimé votre profil.', 13, '2024-03-22 06:52:32', '2024-03-22 06:52:32');

-- --------------------------------------------------------

--
-- Structure de la table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
CREATE TABLE IF NOT EXISTS `paiements` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `numero` bigint NOT NULL,
  `id_user` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id_user`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Structure de la table `publicites`
--

DROP TABLE IF EXISTS `publicites`;
CREATE TABLE IF NOT EXISTS `publicites` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `offre` varchar(255) NOT NULL,
  `detail` varchar(255) NOT NULL,
  `statut` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `publicites`
--

INSERT INTO `publicites` (`id`, `name`, `logo`, `offre`, `detail`, `statut`, `created_at`, `updated_at`) VALUES
(1, 'ghjkl', 'qqs', 'ertfgyuhji', 'ertfgyujiklm;s,jnbhxgysjhcb,avjhf,', 0, '2024-03-14 09:41:01', '2024-03-14 09:35:42'),
(2, 'fdfghjklok', 'C:\\wamp64\\tmp\\php69D1.tmp', 'edrftyuhjikl', '\'rdtfgyuhijl,;cngtrduhksrr-tèuyjryfgh', 0, '2024-03-14 08:56:24', '2024-03-15 07:23:47'),
(3, 'f', 'C:\\wamp64\\tmp\\phpC699.tmp', 'edrftyuhjiklo', '\'rdtfgyuhijl,;cngtrduhksrr-tèuyjryfgho', 0, '2024-03-14 08:57:38', '2024-03-19 14:07:30'),
(4, 'dfcgvhj', 'C:\\wamp64\\tmp\\php281E.tmp', 'fvhbj', 'jhjiio', 0, '2024-03-14 09:13:27', '2024-03-19 14:07:35'),
(5, 'zefgjkmlù', '1710411562.jpg', 'edrtfyujikok', 'iuy', 0, '2024-03-14 09:19:22', '2024-03-19 14:07:37'),
(6, 'gyujk', '1710489096.jpeg', 'fcghj', 'fyguhij', 0, '2024-03-15 06:51:36', '2024-03-19 14:07:39'),
(7, 'erftyu', '1710491066.png', 'zdfhj', 'yuijjjkuhk', 1, '2024-03-15 07:24:26', '2024-03-15 07:24:26'),
(8, 'xdfctgyuhj', '1710862853.jpeg', 'abitech', '<p>rdtfyujiok <a href=\"https://www.nous-meet.com/\">https://www.nous-meet.com/</a></p>', 1, '2024-03-19 14:07:24', '2024-03-19 14:40:53');

-- --------------------------------------------------------

--
-- Structure de la table `reponses`
--

DROP TABLE IF EXISTS `reponses`;
CREATE TABLE IF NOT EXISTS `reponses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_discussion` int NOT NULL,
  `contenu` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_discussion` (`id_discussion`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `reponses`
--

INSERT INTO `reponses` (`id`, `id_discussion`, `contenu`, `created_at`, `updated_at`) VALUES
(1, 10, 'coucou', '2024-02-12 12:28:53', '2024-02-12 12:28:53'),
(2, 10, 'aller', '2024-02-12 12:40:52', '2024-02-12 12:40:52'),
(3, 10, 'cc', '2024-02-12 12:41:31', '2024-02-12 12:41:31'),
(4, 10, 'vous aller bien ?', '2024-02-12 13:04:06', '2024-02-12 13:04:06'),
(5, 10, 'vous aller bien ?', '2024-02-12 13:07:26', '2024-02-12 13:07:26'),
(6, 10, 'coucou', '2024-02-12 13:07:38', '2024-02-12 13:07:38'),
(7, 10, 'coucou', '2024-02-12 13:07:42', '2024-02-12 13:07:42'),
(8, 10, 'ff', '2024-02-12 13:20:41', '2024-02-12 13:20:41'),
(9, 10, 'fg', '2024-02-12 13:22:47', '2024-02-12 13:22:47'),
(10, 10, 'cc', '2024-02-12 13:22:53', '2024-02-12 13:22:53'),
(11, 10, 'cc', '2024-02-12 13:24:27', '2024-02-12 13:24:27'),
(12, 10, 'cg', '2024-02-12 13:24:46', '2024-02-12 13:24:46'),
(13, 11, 'coucou', '2024-02-12 13:25:19', '2024-02-12 13:25:19'),
(14, 45, 'salut', '2024-02-12 20:18:55', '2024-02-12 20:18:55');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `pseudo` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `role` varchar(255) NOT NULL,
  `numero` bigint DEFAULT NULL,
  `town` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `birthplace` varchar(255) DEFAULT NULL,
  `looking_for` varchar(255) DEFAULT NULL,
  `genre` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
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
  `paiement_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb3;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `pseudo`, `role`, `numero`, `town`, `password`, `birthdate`, `birthplace`, `looking_for`, `genre`, `mariatal_status`, `hair_color`, `eyes_color`, `origin_country`, `espace`, `photo1`, `photo2`, `photo3`, `photo4`, `photo5`, `age`, `about`, `interests`, `active`, `paiement`, `paiement_date`, `created_at`, `updated_at`, `activated_at`) VALUES
(1, 'dsfsd', NULL, 'sdfcg', '', NULL, 'sdfcgvh', NULL, '2024-01-01', 'hgfdsq', 'femme', '', 'marie', 'brun', 'marron', 'Gambia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-01-25 10:02:38', '2024-01-25 10:02:38', NULL),
(2, 'dsfsd', NULL, 'sdfcg', '', NULL, 'sdfcgvh', NULL, '2024-01-01', 'hgfdsq', 'femme', '', 'marie', 'brun', 'marron', 'Gambia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-01-25 10:04:28', '2024-01-25 10:04:28', NULL),
(3, 'dsfsd', NULL, 'sdfcg', '', NULL, 'sdfcgvh', NULL, '2024-01-01', 'hgfdsq', 'femme', '', 'marie', 'brun', 'marron', 'Gambia', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-01-25 10:05:33', '2024-01-25 10:05:33', NULL),
(4, 'dz', NULL, 'qs', '', NULL, 'qx', NULL, '2024-01-04', 'qs', 'homme', '', 'celibataire', 'brun', 'marron', 'Togo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-01-26 06:43:38', '2024-01-26 06:43:38', NULL),
(5, 'fghjsk', NULL, 'czjsk', '', NULL, 'rtfyu', NULL, '2024-01-01', 'xwdsret', 'femme', '', 'marie', 'blond', 'noir', 'Guinea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-01-29 07:18:31', '2024-01-29 07:18:31', NULL),
(6, 'fghjsk', NULL, 'czjsk', '', NULL, 'rtfyu', NULL, '2024-01-01', 'xwdsret', 'femme', '', 'marie', 'blond', 'noir', 'Guinea', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-01-29 07:22:11', '2024-01-29 07:22:11', NULL),
(7, 'zesdrtfyujiklkkl', NULL, 'iujh', '', NULL, 'zrt', NULL, '2024-01-01', 'ertyu', 'femme', '', 'marie', 'blond', 'noir', 'Ivoire', NULL, 'photos/lhFtPPxJ40uBXkebc9DFms5Fsg2mu1qxJJYY1h7q.jpg', NULL, NULL, NULL, NULL, NULL, 'Etudiant hjklr;az,rzrjvdfk', NULL, 0, 0, NULL, '2024-01-29 07:34:25', '2024-01-29 07:34:25', NULL),
(8, 'sssssfgv', NULL, 'djk', 'nous', 60183568, 'qqq', '$2y$12$V6OCmD5ea5iHbKwLM7XvYux48NTnqkMgXOaP0Ug8QhW5mwQFyPjiq', '2024-01-01', 'sdsds', 'femme', '', 'celibataire', 'brun', NULL, 'Benin', NULL, NULL, NULL, NULL, NULL, NULL, 19, 'ztffffffffffffffffffffffffffffffffffffffffffffffffffffffff yy', 'sdfghj,rfguio', 0, 0, NULL, '2024-01-29 09:31:27', '2024-01-29 13:49:04', NULL),
(9, 'Joel', NULL, 'jl', 'nous', 67651240, 'jhuj', '$2y$12$9s9s79w9aLiuHTuFcYb/TOrfwU9TWRnmP1Y1ra4jvhQdIxShU82ia', '2024-01-01', 'dtryuui', 'femme', 'homme', 'celibataire', 'noir', 'noirs', 'Benin', NULL, NULL, 'photos/bjFlhhmki5m3oJ4gDBr2dvsvYZg9eQTRSWIBfnKm.jpg', 'photos/P17e3ok2mD5W52YiGIKhhXogJEEkwudqZNwvG7JZ.jpg', 'photos/YRO1ldG4pBWi0U4CHQJwQ43Vru9GxB2vJcQpIyKu.jpg', 'photos/mLHM79UNRutseGobP7D2S0RfOPy84QIV6cmaO9r5.jpg', 18, 'Etudiant hjklr;az,rzrjvdfk', 'foot,lecture', 0, 1, NULL, '2024-01-29 09:39:52', '2024-01-30 12:05:37', NULL),
(10, 'Nathan', 'd@gmail.com', 'nath', 'admin', 60189511, 'Cotonou', '$2y$12$xf19BMb/QHQjhsJfpPJngOp3hgUMR/7hm69wXAX5qWtY.Ff7L/PU2', '2003-06-11', 'Cotonou', 'homme', 'femme', 'celibataire', 'noir', NULL, 'Benin', NULL, 'photos/xZ8J4vkwYB5o4issoYMviNlGTuHPqwjaKUt2RuBd.jpg', 'photos/nlhw2714215Vw65elZneP1xugmm3oOQAihjJCDGr.jpg', 'photos/y51Kdl3rOIxZ7CqHHB17vnFcYEFiokYGkeXJz6MJ.jpg', 'photos/DMAHsVwhGm15so3UemmZJix7ukUmTPcfJyEdUEO1.jpg', NULL, 24, 'Jeune etudiant', 'foot', 0, 1, NULL, '2024-01-30 11:57:26', '2024-02-13 08:30:21', NULL),
(11, 'Rachelle', NULL, 'Rach', 'nous', 96990965, 'jjhte', '$2y$12$mxbnK4rRa7x6EAy.GBAdZO/iQQQL61oaRzNVMtziOPUBpy4VXm1Y2', '2002-06-05', 'uujr', 'homme', 'femme', 'celibataire', 'noir', 'marron', 'Benin', NULL, 'photos/TGIftqmPPPC0SiMZBcyLv3F6Upt5UWlAh1oKA6VK.jpg', 'photos/7ma3jF2buCMHQ1XD4qwjvNdbjVlCKIORJlpHXPa3.jpg', NULL, NULL, NULL, 21, 'Etudiante', 'Foot,lecture,musique', 0, 1, NULL, '2024-02-02 06:59:10', '2024-02-02 07:03:56', NULL),
(12, 'Anita', NULL, 'anita', 'nous', 60189513, 'ijk', '$2y$12$mxbnK4rRa7x6EAy.GBAdZO/iQQQL61oaRzNVMtziOPUBpy4VXm1Y2', '2000-10-10', 'zgej', 'lesdeux', 'femme', 'celibataire', 'noir', 'noir', 'Benin', NULL, 'photos/m0rQEUlJqAI9ilOTxqtpxIno3OBHmFukksfs89NS.jpg', 'photos/3ZsBYzhHSWrF4ebF8h8w2wJw3JdF2GMvduxLUwhL.jpg', 'photos/N6cIKC5z3CPt3jxyt0yFjuA6Qsthxf9CwRM2NiI9.jpg', 'photos/ZOBaQd9Nfc97JsFdnG2y5p4T9Nd7Rg1gq1Fl1Ezj.jpg', NULL, 23, 'dfghj,nvcv', 'foot', 0, 0, NULL, '2024-02-08 06:40:30', '2024-02-14 08:41:38', NULL),
(13, 'Dako', NULL, 'Jaquekine', 'nous', 22960606060, 'fyjh', '$2y$12$mxbnK4rRa7x6EAy.GBAdZO/iQQQL61oaRzNVMtziOPUBpy4VXm1Y2', '2003-01-08', 'fhj', 'lesdeux', 'femme', 'celibataire', 'brun', 'noir', 'cotonou', NULL, NULL, NULL, NULL, NULL, NULL, 21, NULL, 'foot', 0, 0, NULL, '2024-02-14 08:25:38', '2024-02-14 08:38:44', NULL),
(14, 're', NULL, 'r', 'admin', 60189510, 'r\'', '$2y$12$OGOHB/lwU7aEvXE2N3jauuqKvmSngHdL8nPKSbfdgvDCa2Uso24VW', '2002-12-30', 'e', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2024-03-13 15:51:03', '2024-03-13 15:51:03', NULL),
(15, 'Dako', NULL, 'anita', 'karaoke', 96565796, 'cotonou', '$2y$12$VzSiHgAR9/t0KkejADCYCOoDBnGEP1w/iAS2oCA494zP2pEd55R4q', '2024-03-14', 'Cotonou', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'photos/PzH5AKOFFCNrm6dMhmUzbk2ua8UOW0KDCppYs0ji.jpg', 'photos/p5LNMx65xYKweMvVQelBvuVHLogvApaTpsnvQ0rl.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2024-03-19 09:22:37', '2024-03-19 09:31:46', '2024-03-19'),
(16, 'diane', NULL, 'df', 'nous', 60189520, 'erf', '$2y$12$mxbnK4rRa7x6EAy.GBAdZO/iQQQL61oaRzNVMtziOPUBpy4VXm1Y2', '2002-06-05', 'erty', 'Amitie', 'femme', 'celibataire', 'noir', 'noir', 'sdf', NULL, NULL, NULL, NULL, NULL, NULL, 21, NULL, NULL, 0, 0, '2024-03-21', '2024-03-21 13:17:27', '2024-03-21 13:17:27', NULL),
(17, 'dzkk', NULL, NULL, 'visiteur', 56777777, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-03-21 14:33:21', '2024-03-21 14:33:21', NULL),
(18, 'dzkk', NULL, NULL, 'visiteur', 56777777, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-03-21 14:34:13', '2024-03-21 14:34:13', NULL),
(19, 'dzkk', NULL, NULL, 'visiteur', 56777777, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, NULL, '2024-03-21 14:38:26', '2024-03-21 14:38:26', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
