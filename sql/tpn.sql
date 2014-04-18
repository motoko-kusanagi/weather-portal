-- phpMyAdmin SQL Dump -- version 3.4.11.1deb2 -- http://www.phpmyadmin.net -- -- Host: localhost -- Czas wygenerowania: 09 Kwi 
2014, 12:27 -- Wersja serwera: 5.5.35 -- Wersja PHP: 5.4.4-14+deb7u7 SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO"; SET time_zone = 
"+00:00"; /*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */; /*!40101 SET 
@OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */; /*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */; 
/*!40101 SET NAMES utf8 */; -- -- Baza danych: `topr` -- -- -------------------------------------------------------- -- -- 
Struktura tabeli dla tabeli `avalanche_level` -- DROP TABLE IF EXISTS `avalanche_level`; CREATE TABLE IF NOT EXISTS 
`avalanche_level` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `LEVEL` int(11) DEFAULT NULL,
  `TEND` varchar(2) COLLATE utf8_polish_ci DEFAULT NULL,
  `DATE_XML` datetime DEFAULT NULL,
  `DATE_SYSTEM` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=49 ; -- 
-------------------------------------------------------- -- -- Struktura tabeli dla tabeli `pressure` -- DROP TABLE IF EXISTS 
`pressure`; CREATE TABLE IF NOT EXISTS `pressure` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `ZAKOPANE` float DEFAULT NULL,
  `KASPROWY_WIERCH` float DEFAULT NULL,
  `LOMNICA` float DEFAULT NULL,
  `KRAKOW` float DEFAULT NULL,
  `DATE_SYSTEM` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=50 ; -- 
-------------------------------------------------------- -- -- Struktura tabeli dla tabeli `temperature` -- DROP TABLE IF EXISTS 
`temperature`; CREATE TABLE IF NOT EXISTS `temperature` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `GORYCZKOWA` float DEFAULT NULL,
  `PIEC_STAWOW` float DEFAULT NULL,
  `MORSKIE_OKO` float DEFAULT NULL,
  `LOMNICKY_STIT` float DEFAULT NULL,
  `KRAKOW` float DEFAULT NULL,
  `DATE_XML` datetime DEFAULT NULL,
  `DATE_SYSTEM` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2224 ; -- 
-------------------------------------------------------- -- -- Struktura tabeli dla tabeli `wind_direction` -- DROP TABLE IF 
EXISTS `wind_direction`; CREATE TABLE IF NOT EXISTS `wind_direction` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `GORYCZKOWA` float DEFAULT NULL,
  `PIEC_STAWOW` float DEFAULT NULL,
  `MORSKIE_OKO` float DEFAULT NULL,
  `DATE_XML` datetime DEFAULT NULL,
  `DATE_SYSTEM` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2172 ; -- 
-------------------------------------------------------- -- -- Struktura tabeli dla tabeli `wind_speed_averange` -- DROP TABLE 
IF EXISTS `wind_speed_averange`; CREATE TABLE IF NOT EXISTS `wind_speed_averange` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `GORYCZKOWA` float DEFAULT NULL,
  `PIEC_STAWOW` float DEFAULT NULL,
  `MORSKIE_OKO` float DEFAULT NULL,
  `DATE_XML` datetime DEFAULT NULL,
  `DATE_SYSTEM` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2174 ; -- 
-------------------------------------------------------- -- -- Struktura tabeli dla tabeli `wind_speed_maximum` -- DROP TABLE IF 
EXISTS `wind_speed_maximum`; CREATE TABLE IF NOT EXISTS `wind_speed_maximum` (
  `id` mediumint(9) NOT NULL AUTO_INCREMENT,
  `GORYCZKOWA` float DEFAULT NULL,
  `PIEC_STAWOW` float DEFAULT NULL,
  `MORSKIE_OKO` float DEFAULT NULL,
  `DATE_XML` datetime DEFAULT NULL,
  `DATE_SYSTEM` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2174 ; /*!40101 SET 
CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */; /*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */; /*!40101 
SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
