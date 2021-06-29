-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 29. Jun 2021 um 12:13
-- Server-Version: 8.0.25-0ubuntu0.20.04.1
-- PHP-Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `listing.loc`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `events`
--

CREATE TABLE `events` (
  `id` int NOT NULL,
  `not_applicable` int DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `team` varchar(10) DEFAULT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `repeat` int DEFAULT NULL,
  `repeat_parent` int DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams`
--

CREATE TABLE `teams` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `color` varchar(7) NOT NULL,
  `active` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_events`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_events` (
`id` int
,`not_applicable` int
,`event` varchar(255)
,`team` varchar(10)
,`start` date
,`end` date
,`repeat` int
,`repeat_parent` int
,`room` varchar(50)
,`team_name` varchar(255)
,`team_color` varchar(7)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_events_current`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_events_current` (
`id` int
,`not_applicable` int
,`event` varchar(255)
,`team` varchar(10)
,`start` date
,`end` date
,`repeat` int
,`repeat_parent` int
,`room` varchar(50)
,`team_name` varchar(255)
,`team_color` varchar(7)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_events_future`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_events_future` (
`id` int
,`not_applicable` int
,`event` varchar(255)
,`team` varchar(10)
,`start` date
,`end` date
,`repeat` int
,`repeat_parent` int
,`room` varchar(50)
,`team_name` varchar(255)
,`team_color` varchar(7)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_teams`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_teams` (
`id` int
,`name` varchar(255)
,`alias` varchar(10)
,`color` varchar(7)
,`active` int
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_teams_active`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_teams_active` (
`id` int
,`name` varchar(255)
,`alias` varchar(10)
,`color` varchar(7)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_teams_inactive`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_teams_inactive` (
`id` int
,`name` varchar(255)
,`alias` varchar(10)
,`color` varchar(7)
);

-- --------------------------------------------------------

--
-- Struktur des Views `v_events`
--
DROP TABLE IF EXISTS `v_events`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_events`  AS  select `events`.`id` AS `id`,`events`.`not_applicable` AS `not_applicable`,`events`.`event` AS `event`,`events`.`team` AS `team`,`events`.`start` AS `start`,`events`.`end` AS `end`,`events`.`repeat` AS `repeat`,`events`.`repeat_parent` AS `repeat_parent`,`events`.`room` AS `room`,`teams`.`name` AS `team_name`,`teams`.`color` AS `team_color` from (`events` join `teams` on((`events`.`team` = `teams`.`alias`))) where (`events`.`deleted_at` is null) ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_events_current`
--
DROP TABLE IF EXISTS `v_events_current`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_events_current`  AS  select `events`.`id` AS `id`,`events`.`not_applicable` AS `not_applicable`,`events`.`event` AS `event`,`events`.`team` AS `team`,`events`.`start` AS `start`,`events`.`end` AS `end`,`events`.`repeat` AS `repeat`,`events`.`repeat_parent` AS `repeat_parent`,`events`.`room` AS `room`,`teams`.`name` AS `team_name`,`teams`.`color` AS `team_color` from (`events` join `teams` on((`events`.`team` = `teams`.`alias`))) where ((`events`.`deleted_at` is null) and (`events`.`start` <= curdate()) and (`events`.`end` >= curdate())) order by `events`.`start` ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_events_future`
--
DROP TABLE IF EXISTS `v_events_future`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_events_future`  AS  select `events`.`id` AS `id`,`events`.`not_applicable` AS `not_applicable`,`events`.`event` AS `event`,`events`.`team` AS `team`,`events`.`start` AS `start`,`events`.`end` AS `end`,`events`.`repeat` AS `repeat`,`events`.`repeat_parent` AS `repeat_parent`,`events`.`room` AS `room`,`teams`.`name` AS `team_name`,`teams`.`color` AS `team_color` from (`events` join `teams` on((`events`.`team` = `teams`.`alias`))) where ((`events`.`start` <= (curdate() + interval 30 day)) and (`events`.`start` >= (curdate() + interval 1 day)) and (`events`.`deleted_at` is null)) order by `events`.`start` ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_teams`
--
DROP TABLE IF EXISTS `v_teams`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_teams`  AS  select `teams`.`id` AS `id`,`teams`.`name` AS `name`,`teams`.`alias` AS `alias`,`teams`.`color` AS `color`,`teams`.`active` AS `active` from `teams` order by `teams`.`name` ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_teams_active`
--
DROP TABLE IF EXISTS `v_teams_active`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_teams_active`  AS  select `teams`.`id` AS `id`,`teams`.`name` AS `name`,`teams`.`alias` AS `alias`,`teams`.`color` AS `color` from `teams` where (`teams`.`active` = 1) order by `teams`.`name` ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_teams_inactive`
--
DROP TABLE IF EXISTS `v_teams_inactive`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_teams_inactive`  AS  select `teams`.`id` AS `id`,`teams`.`name` AS `name`,`teams`.`alias` AS `alias`,`teams`.`color` AS `color` from `teams` where (`teams`.`active` = 0) order by `teams`.`name` ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `team` (`team`);

--
-- Indizes für die Tabelle `teams`
--
ALTER TABLE `teams`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `events`
--
ALTER TABLE `events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT für Tabelle `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `team` FOREIGN KEY (`team`) REFERENCES `teams` (`alias`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
