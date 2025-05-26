SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
    `ID` int(11) NOT NULL AUTO_INCREMENT,
    `Pseudo` varchar(255) NOT NULL,
    `Nom` varchar(255) NOT NULL,
    `Prénom` varchar(255) NOT NULL,
    `Mail` varchar(255) NOT NULL,
    `Mdp` varchar(255) NOT NULL,
    PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=110 DEFAULT CHARSET=latin1;