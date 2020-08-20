-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:3306
-- Généré le :  Dim 19 Juin 2016 à 21:12
-- Version du serveur :  5.5.42
-- Version de PHP :  5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `factures_project`
--

-- --------------------------------------------------------

--
-- Structure de la table `abonnement`
--

CREATE TABLE `abonnement` (
  `idAbonnement` int(255) NOT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `file` varchar(45) DEFAULT NULL,
  `n_contrat` varchar(45) DEFAULT NULL,
  `client` int(255) DEFAULT NULL,
  `distributeur` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

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

CREATE TABLE `account` (
  `idAccount` int(255) NOT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `type` varchar(35) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=latin1;

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

CREATE TABLE `client` (
  `idClient` int(255) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `n_tel` varchar(20) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `account` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;

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

CREATE TABLE `distributeur` (
  `idDistributeur` int(255) NOT NULL,
  `nom` varchar(45) NOT NULL,
  `adresse` varchar(45) DEFAULT NULL,
  `agence` varchar(45) DEFAULT NULL,
  `n_tel` varchar(45) DEFAULT NULL,
  `freq_visite` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

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

CREATE TABLE `facture` (
  `idFacture` int(255) NOT NULL,
  `n_facture` varchar(45) DEFAULT NULL,
  `mois` int(11) NOT NULL,
  `annee` int(11) NOT NULL,
  `valeur_compteur` int(255) DEFAULT NULL,
  `ecart` int(255) NOT NULL,
  `montant` int(255) DEFAULT NULL,
  `statut` varchar(45) DEFAULT NULL,
  `estimated` tinyint(1) NOT NULL,
  `abonnement` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;

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
(150, '3120171', 1, 2017, 75, 5, 247, 'brouillon', 1, 3),
(151, '3220172', 2, 2017, 80, 5, 246, 'brouillon', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `tranche`
--

CREATE TABLE `tranche` (
  `idTranche` int(255) NOT NULL,
  `nomtranche` varchar(35) DEFAULT NULL,
  `seuiltranche` int(255) NOT NULL,
  `valtranche` int(255) DEFAULT NULL,
  `distributeur` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

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

CREATE TABLE `user` (
  `idUser` int(255) NOT NULL,
  `nom` varchar(45) DEFAULT NULL,
  `n_tel` varchar(20) DEFAULT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `account` int(255) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`idUser`, `nom`, `n_tel`, `sex`, `account`) VALUES
(1, 'yassine taya', '0661451678', 'm', 1),
(10, 'alem ahmed', '06 32 43 12', 'm', 109);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `abonnement`
--
ALTER TABLE `abonnement`
  ADD PRIMARY KEY (`idAbonnement`),
  ADD KEY `client` (`client`),
  ADD KEY `distributeur` (`distributeur`);

--
-- Index pour la table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`idAccount`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`idClient`),
  ADD UNIQUE KEY `account` (`account`);

--
-- Index pour la table `distributeur`
--
ALTER TABLE `distributeur`
  ADD PRIMARY KEY (`idDistributeur`);

--
-- Index pour la table `facture`
--
ALTER TABLE `facture`
  ADD PRIMARY KEY (`idFacture`),
  ADD UNIQUE KEY `unique_facture_date` (`mois`,`annee`,`abonnement`),
  ADD KEY `abonnement` (`abonnement`);

--
-- Index pour la table `tranche`
--
ALTER TABLE `tranche`
  ADD PRIMARY KEY (`idTranche`),
  ADD KEY `distributeur` (`distributeur`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `account` (`account`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `abonnement`
--
ALTER TABLE `abonnement`
  MODIFY `idAbonnement` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `account`
--
ALTER TABLE `account`
  MODIFY `idAccount` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=111;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `idClient` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT pour la table `distributeur`
--
ALTER TABLE `distributeur`
  MODIFY `idDistributeur` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `facture`
--
ALTER TABLE `facture`
  MODIFY `idFacture` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=152;
--
-- AUTO_INCREMENT pour la table `tranche`
--
ALTER TABLE `tranche`
  MODIFY `idTranche` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
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
