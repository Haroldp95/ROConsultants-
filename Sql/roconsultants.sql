-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 01 dec 2021 om 09:11
-- Serverversie: 10.4.21-MariaDB
-- PHP-versie: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `roconsultants`
--
CREATE DATABASE IF NOT EXISTS `roconsultants` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `roconsultants`;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `costs`
--

CREATE TABLE `costs` (
  `costId` int(11) NOT NULL,
  `costName` varchar(120) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projectcosts`
--

CREATE TABLE `projectcosts` (
  `projectcostId` int(11) NOT NULL,
  `projectcostDate` date NOT NULL,
  `projectcostCreationDate` datetime NOT NULL,
  `projectcostAmount` float NOT NULL,
  `projectcostCodeId` int(11) NOT NULL,
  `projectcostUserId` int(11) NOT NULL,
  `projectcostCostId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projectmembers`
--

CREATE TABLE `projectmembers` (
  `memberId` int(11) NOT NULL,
  `memberProjectId` int(11) NOT NULL,
  `memberUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `projects`
--

CREATE TABLE `projects` (
  `projectId` int(11) NOT NULL,
  `projectName` varchar(100) NOT NULL,
  `projectCreationDate` datetime NOT NULL,
  `projectUserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `userFirstName` varchar(100) NOT NULL,
  `userLastName` varchar(100) NOT NULL,
  `userNickName` varchar(100) NOT NULL,
  `userGender` varchar(60) NOT NULL,
  `userDateOfBirth` date NOT NULL,
  `userEmail` varchar(120) NOT NULL,
  `userPassword` varchar(300) NOT NULL,
  `userProfileStatus` int(3) NOT NULL,
  `userAccountCreationDate` datetime NOT NULL,
  `userLastLogin` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `costs`
--
ALTER TABLE `costs`
  ADD PRIMARY KEY (`costId`);

--
-- Indexen voor tabel `projectcosts`
--
ALTER TABLE `projectcosts`
  ADD PRIMARY KEY (`projectcostId`),
  ADD KEY `projectcosts_ibfk_1` (`projectcostCodeId`),
  ADD KEY `projectcosts_ibfk_2` (`projectcostUserId`),
  ADD KEY `projectcosts_ibfk_3` (`projectcostCostId`);

--
-- Indexen voor tabel `projectmembers`
--
ALTER TABLE `projectmembers`
  ADD PRIMARY KEY (`memberId`),
  ADD KEY `projectmembers_ibfk_1` (`memberProjectId`),
  ADD KEY `projectmembers_ibfk_2` (`memberUserId`);

--
-- Indexen voor tabel `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`projectId`),
  ADD KEY `projects_ibfk_1` (`projectUserId`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `projectcosts`
--
ALTER TABLE `projectcosts`
  MODIFY `projectcostId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `projectmembers`
--
ALTER TABLE `projectmembers`
  MODIFY `memberId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `projects`
--
ALTER TABLE `projects`
  MODIFY `projectId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `projectcosts`
--
ALTER TABLE `projectcosts`
  ADD CONSTRAINT `projectcosts_ibfk_1` FOREIGN KEY (`projectcostCodeId`) REFERENCES `projects` (`projectId`) ON DELETE CASCADE,
  ADD CONSTRAINT `projectcosts_ibfk_2` FOREIGN KEY (`projectcostUserId`) REFERENCES `users` (`userId`) ON DELETE CASCADE,
  ADD CONSTRAINT `projectcosts_ibfk_3` FOREIGN KEY (`projectcostCostId`) REFERENCES `costs` (`costId`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `projectmembers`
--
ALTER TABLE `projectmembers`
  ADD CONSTRAINT `projectmembers_ibfk_1` FOREIGN KEY (`memberProjectId`) REFERENCES `projects` (`projectId`) ON DELETE CASCADE,
  ADD CONSTRAINT `projectmembers_ibfk_2` FOREIGN KEY (`memberUserId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;

--
-- Beperkingen voor tabel `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `projects_ibfk_1` FOREIGN KEY (`projectUserId`) REFERENCES `users` (`userId`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
