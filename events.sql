-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Erstellungszeit: 01. Jul 2021 um 08:45
-- Server-Version: 10.3.29-MariaDB-0+deb10u1
-- PHP-Version: 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `events`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `config`
--

CREATE TABLE `config` (
  `id` int(11) NOT NULL,
  `setting` varchar(50) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `config`
--

INSERT INTO `config` (`id`, `setting`, `value`) VALUES
(1, 'refresh', '15'),
(2, 'future_day', '30');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `not_applicable` int(11) DEFAULT NULL,
  `event` varchar(255) DEFAULT NULL,
  `team` varchar(10) DEFAULT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `repeat` int(11) DEFAULT NULL,
  `repeat_parent` int(11) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `events`
--

INSERT INTO `events` (`id`, `not_applicable`, `event`, `team`, `start`, `end`, `repeat`, `repeat_parent`, `room`, `deleted_at`) VALUES
(1, NULL, 'Urlaub', 'FISI19', '2021-07-03', '2021-07-25', NULL, NULL, '', NULL),
(2, NULL, 'Urlaub', 'FISI20', '2021-07-03', '2021-07-25', NULL, NULL, '', NULL);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `teams`
--

CREATE TABLE `teams` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `color` varchar(7) NOT NULL,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Daten für Tabelle `teams`
--

INSERT INTO `teams` (`id`, `name`, `alias`, `color`, `active`) VALUES
(1, 'Fachinformatiker für Systemintegration 2019', 'FISI19', '#8080ff', 1),
(2, 'Fachinformatiker für Systemintegration 2020', 'FISI20', '#00ff00', 1),
(3, 'Berufsvorbereitende Bildungsmaßnahme', 'BvB', '#24c7fa', 1);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_events`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_events` (
`id` int(11)
,`not_applicable` int(11)
,`event` varchar(255)
,`team` varchar(10)
,`start` date
,`end` date
,`repeat` int(11)
,`repeat_parent` int(11)
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
`id` int(11)
,`not_applicable` int(11)
,`event` varchar(255)
,`team` varchar(10)
,`start` date
,`end` date
,`repeat` int(11)
,`repeat_parent` int(11)
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
`id` int(11)
,`not_applicable` int(11)
,`event` varchar(255)
,`team` varchar(10)
,`start` date
,`end` date
,`repeat` int(11)
,`repeat_parent` int(11)
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
`id` int(11)
,`name` varchar(255)
,`alias` varchar(10)
,`color` varchar(7)
,`active` int(11)
);

-- --------------------------------------------------------

--
-- Stellvertreter-Struktur des Views `v_teams_active`
-- (Siehe unten für die tatsächliche Ansicht)
--
CREATE TABLE `v_teams_active` (
`id` int(11)
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
`id` int(11)
,`name` varchar(255)
,`alias` varchar(10)
,`color` varchar(7)
);

-- --------------------------------------------------------

--
-- Struktur des Views `v_events`
--
DROP TABLE IF EXISTS `v_events`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_events`  AS  select `id` AS `id`,`not_applicable` AS `not_applicable`,`event` AS `event`,`team` AS `team`,`start` AS `start`,`end` AS `end`,`repeat` AS `repeat`,`repeat_parent` AS `repeat_parent`,`room` AS `room`,`teams`.`name` AS `team_name`,`teams`.`color` AS `team_color` from (`events` join `teams` on(`team` = `teams`.`alias`)) where `deleted_at` is null ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_events_current`
--
DROP TABLE IF EXISTS `v_events_current`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_events_current`  AS  select `id` AS `id`,`not_applicable` AS `not_applicable`,`event` AS `event`,`team` AS `team`,`start` AS `start`,`end` AS `end`,`repeat` AS `repeat`,`repeat_parent` AS `repeat_parent`,`room` AS `room`,`teams`.`name` AS `team_name`,`teams`.`color` AS `team_color` from (`events` join `teams` on(`team` = `teams`.`alias`)) where `deleted_at` is null and `start` <= curdate() and `end` >= curdate() order by `start` ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_events_future`
--
DROP TABLE IF EXISTS `v_events_future`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_events_future`  AS  select `id` AS `id`,`not_applicable` AS `not_applicable`,`event` AS `event`,`team` AS `team`,`start` AS `start`,`end` AS `end`,`repeat` AS `repeat`,`repeat_parent` AS `repeat_parent`,`room` AS `room`,`teams`.`name` AS `team_name`,`teams`.`color` AS `team_color` from (`events` join `teams` on(`team` = `teams`.`alias`)) where `start` <= curdate() + interval (select `config`.`value` from `config` where `config`.`setting` = 'future_day') day and `start` >= curdate() + interval 1 day and `deleted_at` is null order by `start` ;

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

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_teams_active`  AS  select `teams`.`id` AS `id`,`teams`.`name` AS `name`,`teams`.`alias` AS `alias`,`teams`.`color` AS `color` from `teams` where `teams`.`active` = 1 order by `teams`.`name` ;

-- --------------------------------------------------------

--
-- Struktur des Views `v_teams_inactive`
--
DROP TABLE IF EXISTS `v_teams_inactive`;

CREATE ALGORITHM=UNDEFINED DEFINER=`webroot`@`%` SQL SECURITY DEFINER VIEW `v_teams_inactive`  AS  select `teams`.`id` AS `id`,`teams`.`name` AS `name`,`teams`.`alias` AS `alias`,`teams`.`color` AS `color` from `teams` where `teams`.`active` = 0 order by `teams`.`name` ;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `config`
--
ALTER TABLE `config`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting` (`setting`);

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
-- AUTO_INCREMENT für Tabelle `config`
--
ALTER TABLE `config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `teams`
--
ALTER TABLE `teams`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `team` FOREIGN KEY (`team`) REFERENCES `teams` (`alias`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
