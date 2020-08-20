-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Lun 20 Juin 2016 à 11:57
-- Version du serveur: 5.5.16
-- Version de PHP: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `pfe`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE IF NOT EXISTS `abonnement` (
  `idAbonnement` int(255) NOT NULL AUTO_INCREMENT,
  `adresse` varchar(255) DEFAULT NULL,
  `file` varchar(45) DEFAULT NULL,
  `n_contrat` varchar(45) DEFAULT NULL,
  `client` int(255) DEFAULT NULL,
  `distributeur` int(255) DEFAULT NULL,
  PRIMARY KEY (`idAbonnement`),
  KEY `client` (`client`),
  KEY `distributeur` (`distributeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `abonnement`
--

INSERT INTO `abonnement` (`idAbonnement`, `adresse`, `file`, `n_contrat`, `client`, `distributeur`) VALUES
(3, 'abdelmoumen casablanca', 'contrat.pdf', '65432', 50, 7),
(4, 'Ghandi casablanca', 'file.pdf', '4354323', 51, 8);

-- --------------------------------------------------------

--
-- Structure de la table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `idAccount` int(255) NOT NULL AUTO_INCREMENT,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `type` varchar(35) NOT NULL,
  PRIMARY KEY (`idAccount`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=111 ;

--
-- Contenu de la table `account`
--

INSERT INTO `account` (`idAccount`, `username`, `password`, `type`) VALUES
(1, 'admin@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'admin'),
(108, 'client@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'client'),
(109, 'controleur@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'controleur'),
(110, 'client2@gmail.com', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'client');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `idClient` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `n_tel` varchar(20) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `account` int(255) DEFAULT NULL,
  PRIMARY KEY (`idClient`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Contenu de la table `client`
--

INSERT INTO `client` (`idClient`, `nom`, `n_tel`, `sex`, `account`) VALUES
(50, 'hemza amine', '06 32 43 15', 'm', 108),
(51, 'Mustapha Hamid', '06 54 32 45 67', 'm', 110);

-- --------------------------------------------------------

--
-- Structure de la table `distributeur`
--

CREATE TABLE IF NOT EXISTS `distributeur` (
  `idDistributeur` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) NOT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `agence` varchar(45) DEFAULT NULL,
  `n_tel` varchar(45) DEFAULT NULL,
  `freq_visite` int(11) NOT NULL,
  PRIMARY KEY (`idDistributeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `distributeur`
--

INSERT INTO `distributeur` (`idDistributeur`, `nom`, `adresse`, `agence`, `n_tel`, `freq_visite`) VALUES
(7, 'Lydec', 'casablanca', 'casabalnca', '05 22 33 44', 3),
(8, 'ONEE', 'Bvd Hassane', 'Casablanca', '05 22 33 66', 1);

-- --------------------------------------------------------

--
-- Structure de la table `facture`
--

CREATE TABLE IF NOT EXISTS `facture` (
  `idFacture` int(255) NOT NULL AUTO_INCREMENT,
  `n_facture` varchar(45) DEFAULT NULL,
  `mois` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `valeur_compteur` int(255) DEFAULT NULL,
  `ecart` int(255) NOT NULL,
  `montant` int(255) DEFAULT NULL,
  `statut` varchar(45) DEFAULT NULL,
  `estimated` tinyint(1) NOT NULL,
  `abonnement` int(255) DEFAULT NULL,
  PRIMARY KEY (`idFacture`),
  UNIQUE KEY `unique_facture_date` (`mois`,`annee`,`abonnement`),
  KEY `abonnement` (`abonnement`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=177 ;

--
-- Contenu de la table `facture`
--

INSERT INTO `facture` (`idFacture`, `n_facture`, `mois`, `annee`, `valeur_compteur`, `ecart`, `montant`, `statut`, `estimated`, `abonnement`) VALUES
(143, '3062016', 6, 2016, 20, 20, 1000, 'payee', 0, 3),
(144, '3720161', 7, 2016, 27, 7, 350, 'payee', 1, 3),
(145, '3820162', 8, 2016, 36, 9, 460, 'payee', 1, 3),
(146, '3062016', 9, 2016, 47, 11, 550, 'impayee', 0, 3),
(147, '31020161', 10, 2016, 53, 6, 287, 'impayee', 1, 3),
(148, '31120162', 11, 2016, 58, 6, 280, 'impayee', 1, 3),
(149, '3122016', 12, 2016, 70, 12, 600, 'brouillon', 0, 3),
(173, '312017', 1, 2017, 81, 11, 550, 'brouillon', 0, 3),
(174, '3220171', 2, 2017, 96, 15, 742, 'brouillon', 1, 3),
(175, '3320172', 3, 2017, 111, 15, 768, 'brouillon', 1, 3),
(176, '4062016', 6, 2016, 5, 5, 1000, 'brouillon', 0, 4);

-- --------------------------------------------------------

--
-- Structure de la table `tranche`
--

CREATE TABLE IF NOT EXISTS `tranche` (
  `idTranche` int(255) NOT NULL AUTO_INCREMENT,
  `nomtranche` varchar(35) DEFAULT NULL,
  `seuiltranche` int(255) NOT NULL,
  `valtranche` int(255) DEFAULT NULL,
  `distributeur` int(255) DEFAULT NULL,
  PRIMARY KEY (`idTranche`),
  KEY `distributeur` (`distributeur`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Contenu de la table `tranche`
--

INSERT INTO `tranche` (`idTranche`, `nomtranche`, `seuiltranche`, `valtranche`, `distributeur`) VALUES
(12, 'base consomation', 100, 50, 7),
(13, 'moyen consomation', 200, 150, 7),
(14, 'hute consomation', 300, 250, 7),
(15, 'Basse consomation', 120, 200, 8),
(16, 'moyen consomation', 300, 400, 8),
(17, 'Haute consomation', 600, 500, 8);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `idUser` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(45) DEFAULT NULL,
  `n_tel` varchar(20) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `account` int(255) DEFAULT NULL,
  PRIMARY KEY (`idUser`),
  UNIQUE KEY `account` (`account`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`idUser`, `nom`, `n_tel`, `sex`, `account`) VALUES
(1, 'Abderahim Sekkaki', '0661451678', 'm', 1),
(10, 'alem ahmed', '06 32 43 12', 'm', 109);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD CONSTRAINT `abonnement_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`idClient`),
  ADD CONSTRAINT `abonnement_ibfk_2` FOREIGN KEY (`distributeur`) REFERENCES `distributeur` (`idDistributeur`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `client_ibfk_1` FOREIGN KEY (`account`) REFERENCES `account` (`idAccount`);

--
-- Contraintes pour la table `facture`
--
ALTER TABLE `facture`
  ADD CONSTRAINT `facture_ibfk_1` FOREIGN KEY (`abonnement`) REFERENCES `abonnement` (`idAbonnement`);

--
-- Contraintes pour la table `tranche`
--
ALTER TABLE `tranche`
  ADD CONSTRAINT `tranche_ibfk_1` FOREIGN KEY (`distributeur`) REFERENCES `distributeur` (`idDistributeur`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`account`) REFERENCES `account` (`idAccount`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
