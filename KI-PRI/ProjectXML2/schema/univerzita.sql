-- Adminer 4.8.1 MySQL 8.3.0 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `Fakulta`;
CREATE TABLE `Fakulta` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50),
  `dekan` int unsigned,
  PRIMARY KEY (`id`),
  KEY `dekan` (`dekan`),
  CONSTRAINT `Fakulta_ibfk_1` FOREIGN KEY (`dekan`) REFERENCES `Osoba` (`id`)
);

INSERT INTO `Fakulta` (`id`, `nazev`, `dekan`) VALUES
(1,	'Přírodovědecká',	1),
(2,	'Filozofická',	2);

DROP TABLE IF EXISTS `Katedra`;
CREATE TABLE `Katedra` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `id_fakulty` int unsigned,
  `nazev` varchar(50),
  PRIMARY KEY (`id`),
  KEY `id_fakulty` (`id_fakulty`),
  CONSTRAINT `katedra_ibfk_1` FOREIGN KEY (`id_fakulty`) REFERENCES `Fakulta` (`id`)
);

INSERT INTO `Katedra` (`id`, `id_fakulty`, `nazev`) VALUES
(1,	1,	'Informatika'),
(2,	2,	'Matematika');

DROP TABLE IF EXISTS `Osoba`;
CREATE TABLE `Osoba` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(50) NOT NULL,
  `prijmeni` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO `Osoba` (`id`, `jmeno`, `prijmeni`, `email`) VALUES
(1,	'Joseph',	'Smith',	'j.s@gmail.com'),
(2,	'Martin',	'Luther',	'm.l@gmail.com');

DROP TABLE IF EXISTS `Predmet`;
CREATE TABLE `Predmet` (
  `id` int unsigned NOT NULL,
  `id_katedry` int unsigned,
  `nazev` varchar(50),
  KEY `id_katedry` (`id_katedry`),
  CONSTRAINT `predmet_ibfk_1` FOREIGN KEY (`id_katedry`) REFERENCES `Katedra` (`id`)
);

INSERT INTO `Predmet` (`id`, `id_katedry`, `nazev`) VALUES
(1,	1,	'Úvod do programování'),
(2,	2,	'Lineární­ algebra');

DROP TABLE IF EXISTS `Student`;
CREATE TABLE `Student` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `st_cislo` varchar(10),
  `F_cislo` varchar(10),
  `id_fakulty` int unsigned,
  `jmeno` varchar(255),
  `prijmeni` varchar(255),
  PRIMARY KEY (`id`),
  KEY `id_fakulty` (`id_fakulty`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`id_fakulty`) REFERENCES `Fakulta` (`id`)
);

INSERT INTO `Student` (`id`, `st_cislo`, `F_cislo`, `id_fakulty`, `jmeno`, `prijmeni`) VALUES
(1,	'12345',	'67890',	1,	'Petr',	'Noha'),
(2,	'23456',	'98765',	2,	'Eva',	'Slavná');

DROP TABLE IF EXISTS `Zamestnanec`;
CREATE TABLE `Zamestnanec` (
  `id_osoby` int unsigned NOT NULL,
  `id_katedry` int unsigned NOT NULL,
  UNIQUE KEY `id_osoby_id_katedry` (`id_osoby`,`id_katedry`),
  KEY `id_katedry` (`id_katedry`),
  CONSTRAINT `Zamestnanec_ibfk_1` FOREIGN KEY (`id_osoby`) REFERENCES `Osoba` (`id`),
  CONSTRAINT `Zamestnanec_ibfk_2` FOREIGN KEY (`id_katedry`) REFERENCES `Katedra` (`id`)
);
