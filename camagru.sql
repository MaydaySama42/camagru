-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Mar 06 Août 2019 à 19:02
-- Version du serveur :  5.7.27-0ubuntu0.18.04.1
-- Version de PHP :  7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `camagru`
--

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `comment_id` int(11) NOT NULL,
  `comment_text` text,
  `user_id` int(11) DEFAULT NULL,
  `pic_id` int(11) DEFAULT NULL,
  `comment_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `comment`
--

INSERT INTO `comment` (`comment_id`, `comment_text`, `user_id`, `pic_id`, `comment_date`) VALUES
(49, 'nul', 18, 37, '2019-08-03 23:25:21'),
(50, 'eada', 18, 37, '2019-08-03 23:25:22'),
(51, 'aedea', 18, 37, '2019-08-03 23:25:25'),
(52, 'edea', 18, 37, '2019-08-04 00:41:08'),
(53, 'edaea', 22, 37, '2019-08-04 00:58:53'),
(54, 'eeafea', 22, 37, '2019-08-04 00:59:02'),
(55, 'aefaef', 18, 41, '2019-08-05 01:17:55'),
(56, 'aa', 18, 40, '2019-08-05 01:17:58'),
(57, 'qqqqqq', 18, 39, '2019-08-05 01:18:02'),
(58, 'a', 18, 41, '2019-08-05 01:20:15'),
(59, 'a', 18, 37, '2019-08-05 15:40:50'),
(60, 'a', 18, 42, '2019-08-05 17:37:29'),
(61, 'ed', 18, 42, '2019-08-05 17:37:31'),
(62, 'a', 22, 42, '2019-08-05 18:48:26'),
(63, 'dfadfda', 22, 42, '2019-08-05 18:48:32'),
(64, 'c nul', 22, 43, '2019-08-05 18:49:48'),
(65, 't une merde', 18, 43, '2019-08-05 18:50:32'),
(66, 'a', 18, 42, '2019-08-05 22:06:05'),
(67, 'a', 18, 48, '2019-08-06 00:31:10'),
(68, 'tes', 18, 48, '2019-08-06 02:34:02'),
(69, 'sds', 18, 48, '2019-08-06 14:17:46'),
(70, 'a', 18, 37, '2019-08-06 14:18:08'),
(71, 't une merde', 18, 43, '2019-08-06 14:21:22'),
(72, 'tes nul', 18, 50, '2019-08-06 15:51:39');

-- --------------------------------------------------------

--
-- Structure de la table `filter`
--

CREATE TABLE `filter` (
  `filter_id` int(11) NOT NULL,
  `filter_path` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `filter`
--

INSERT INTO `filter` (`filter_id`, `filter_path`) VALUES
(1, '../resources/img/filter/filter0.png'),
(2, '../resources/img/filter/filter1.png'),
(3, '../resources/img/filter/filter2.png'),
(4, '../resources/img/filter/filter3.png'),
(5, '../resources/img/filter/filter4.png'),
(6, '../resources/img/filter/filter5.png'),
(7, '../resources/img/filter/filter6.png'),
(8, '../resources/img/filter/filter7.png');

-- --------------------------------------------------------

--
-- Structure de la table `picture`
--

CREATE TABLE `picture` (
  `pic_id` int(11) NOT NULL,
  `pic_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `pic_path` text,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `picture`
--

INSERT INTO `picture` (`pic_id`, `pic_date`, `pic_path`, `user_id`) VALUES
(37, '2019-07-31 20:53:48', '../resources/user-19/pic37-19-1564606428.png', 19),
(38, '2019-08-05 01:01:52', '../resources/user-18/pic38-18-1564966912.png', 18),
(39, '2019-08-05 01:03:21', '../resources/user-18/pic39-18-1564967001.png', 18),
(40, '2019-08-05 01:05:29', '../resources/user-18/pic40-18-1564967129.png', 18),
(41, '2019-08-05 01:06:22', '../resources/user-18/pic41-18-1564967182.png', 18),
(42, '2019-08-05 15:32:57', '../resources/user-18/pic42-18-1565019177.png', 18),
(43, '2019-08-05 18:49:33', '../resources/user-22/pic43-22-1565030973.png', 22),
(44, '2019-08-05 21:13:27', '../resources/user-18/pic44-18-1565039607.png', 18),
(45, '2019-08-05 21:13:45', '../resources/user-18/pic45-18-1565039625.png', 18),
(46, '2019-08-05 22:13:36', '../resources/user-18/pic46-18-1565043215.png', 18),
(47, '2019-08-05 22:14:04', '../resources/user-18/pic47-18-1565043244.png', 18),
(48, '2019-08-05 22:43:52', '../resources/user-18/pic48-18-1565045032.png', 18),
(49, '2019-08-06 14:19:21', '../resources/user-18/pic49-18-1565101161.png', 18),
(50, '2019-08-06 14:19:36', '../resources/user-18/pic50-18-1565101176.png', 18),
(51, '2019-08-06 15:53:20', '../resources/user-18/pic51-18-1565106800.png', 18),
(52, '2019-08-06 16:01:30', '../resources/user-18/pic52-18-1565107289.png', 18);

-- --------------------------------------------------------

--
-- Structure de la table `reactions`
--

CREATE TABLE `reactions` (
  `reaction_id` int(11) NOT NULL,
  `reaction_type` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pic_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `reactions`
--

INSERT INTO `reactions` (`reaction_id`, `reaction_type`, `user_id`, `pic_id`) VALUES
(4, 3, 19, 37),
(10, 1, 18, 42),
(11, 3, 18, 41),
(12, 3, 18, 40),
(13, 3, 22, 43),
(14, 1, 18, 45),
(15, 2, 18, 46),
(16, 3, 18, 48),
(17, 3, 18, 49),
(18, 4, 18, 50),
(22, 3, 18, 52);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `user_name` text,
  `user_password` varchar(99) DEFAULT NULL,
  `user_mail` varchar(99) DEFAULT NULL,
  `user_crea_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `user_confirm` varchar(64) DEFAULT NULL,
  `notification` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_password`, `user_mail`, `user_crea_date`, `user_confirm`, `notification`) VALUES
(18, 'mayday', '25d55ad283aa400af464c76d713c07ad', 'dalil.mahdi@gmail.com', '2019-08-06 15:50:07', '', 0),
(19, 'samee', 'd41d8cd98f00b204e9800998ecf8427e', 'samee.essentials@gmail.com', '2019-08-02 13:46:32', '', 0),
(22, 'link', '25d55ad283aa400af464c76d713c07ad', 'mehdidalil42@gmail.com', '2019-08-04 00:59:20', '', 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pic_id` (`pic_id`);

--
-- Index pour la table `filter`
--
ALTER TABLE `filter`
  ADD PRIMARY KEY (`filter_id`);

--
-- Index pour la table `picture`
--
ALTER TABLE `picture`
  ADD PRIMARY KEY (`pic_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `reactions`
--
ALTER TABLE `reactions`
  ADD PRIMARY KEY (`reaction_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pic_id` (`pic_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
--
-- AUTO_INCREMENT pour la table `filter`
--
ALTER TABLE `filter`
  MODIFY `filter_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `picture`
--
ALTER TABLE `picture`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT pour la table `reactions`
--
ALTER TABLE `reactions`
  MODIFY `reaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`pic_id`) REFERENCES `picture` (`pic_id`);

--
-- Contraintes pour la table `picture`
--
ALTER TABLE `picture`
  ADD CONSTRAINT `picture_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `picture_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `reactions`
--
ALTER TABLE `reactions`
  ADD CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `reactions_ibfk_2` FOREIGN KEY (`pic_id`) REFERENCES `picture` (`pic_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
