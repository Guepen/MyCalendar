-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 22 okt 2014 kl 22:27
-- Serverversion: 5.6.15-log
-- PHP-version: 5.5.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databas: `mycalendar`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `eventId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `month` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `day` varchar(50) COLLATE utf8_swedish_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `startHour` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `startMinute` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `endHour` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `endMinute` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `year` varchar(15) COLLATE utf8_swedish_ci NOT NULL,
  PRIMARY KEY (`eventId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=86 ;

--
-- Dumpning av Data i tabell `event`
--

INSERT INTO `event` (`eventId`, `userId`, `title`, `month`, `day`, `description`, `startHour`, `startMinute`, `endHour`, `endMinute`, `year`) VALUES
(78, 1, 'Deadline Projekt', '10', '26', 'Deadline fÃ¶r projektet.erdtfyuhi', '00', '01', '23', '59', '2014'),
(39, 1, 'Deadline Workshops', '11', '7', 'Sista dagen att bli klar med alla workshops', '00', '01', '12', '00', '2014'),
(77, 1, 'Projektredovisning', '10', '27', 'Projektredovisning', '08', '15', '16', '00', '2014'),
(36, 1, 'Tenta', '10', '31', 'Hemtenta i kursen Objektorienterad Analys och Design', '10', '00', '12', '00', '2014'),
(37, 1, 'Workshop 3 UML', '10', '22', 'Workshop 3 i UML', '09', '00', '15', '00', '2014'),
(38, 1, 'Ipiwich - Rovers', '10', '18', 'Bortamatch mot Ipswich', '16', '00', '18', '15', '2014'),
(31, 1, 'KHK-IKO', '10', '18', 'Hemmamatch mot Oskarshamn', '16', '00', '18', '15', '2014'),
(67, 1, 'Deadline Workshop 3', '10', '28', 'Deadline Workshop 2 i UML.', '00', '01', '12', '00', '2014'),
(71, 1, 'Kursstart MVC', '11', '3', 'FÃ¶relÃ¤sning, kursintroduktion', '10', '15', '12', '00', '2014'),
(72, 1, 'Kursstart Webbteknik', '11', '3', 'FÃ¶relÃ¤sning, kursintroduktion Webbteknik 2.', '13', '15', '15', '00', '2014');

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(70) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `cookieExpireTime` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `cookiePassword` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  PRIMARY KEY (`userId`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci AUTO_INCREMENT=8 ;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`userId`, `username`, `password`, `cookieExpireTime`, `cookiePassword`) VALUES
(1, 'Guepen', '$2y$10$YmZPLV2BmT/FEqsIlRMTKeUwOZbyLLosZKHNUpQ91/2CN0wzGPZAK', '1413992219', '$2y$10$Y7w1ABCk57.YcTwakN4O6.B5.UuwzjBrv62mGvi1qqKauM18DZsSC'),
(5, 'Testare', '$2y$10$stNPYmoLUXaxKYtDsN.S7O1ATuRyBjKsOBl2W/bbAfy6lSuhePVAi', '', ''),
(7, 'Admin', '$2y$10$Zb3rmYzJCaeej.qXlNew8Om.oDgq4c09bU0m7ZrSjlapAX8sHm2l2', '1413827539', '$2y$10$2OolVUJciAz0zp2ryt958OX1p7eF8YcL0CpUxybYJ2MsOP9MLOZVK');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
