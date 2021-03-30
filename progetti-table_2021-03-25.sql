-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Creato il: Mar 25, 2021 alle 08:24
-- Versione del server: 8.0.18
-- Versione PHP: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `donatefor`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `progetti`
--

CREATE TABLE `progetti` (
  `IDProgetto` int(11) NOT NULL,
  `Nome` varchar(50) NOT NULL,
  `Descrizione` text NOT NULL,
  `Obbiettivo` int(11) NOT NULL,
  `DataI` date NOT NULL,
  `DataF` date NOT NULL,
  `IDTag` int(11) NOT NULL,
  `IDOnlus` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dump dei dati per la tabella `progetti`
--

INSERT INTO `progetti` (`IDProgetto`, `Nome`, `Descrizione`, `Obbiettivo`, `DataI`, `DataF`, `IDTag`, `IDOnlus`) VALUES
(1, 'Aziz e la Pietra Perduta', 'Aiuta anche tu a trovare la pietra perduta di Aziz Il Muratore', 50000, '2021-03-25', '2021-03-31', 1, 1),
(2, 'Minei e la Gomma Bucata', 'Aiuta Francesco a cambiare una gomma', 250, '2021-03-11', '2021-03-31', 1, 1);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `progetti`
--
ALTER TABLE `progetti`
  ADD PRIMARY KEY (`IDProgetto`),
  ADD KEY `Tag` (`IDTag`),
  ADD KEY `OnlusProgetto` (`IDOnlus`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `progetti`
--
ALTER TABLE `progetti`
  MODIFY `IDProgetto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `progetti`
--
ALTER TABLE `progetti`
  ADD CONSTRAINT `OnlusProgetto` FOREIGN KEY (`IDOnlus`) REFERENCES `utenti` (`IDUtenti`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `Tag` FOREIGN KEY (`IDTag`) REFERENCES `tag` (`IDTag`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
