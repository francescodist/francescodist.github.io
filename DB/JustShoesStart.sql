-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Giu 23, 2017 alle 19:54
-- Versione del server: 10.1.21-MariaDB
-- Versione PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `JustShoes`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `Acquisto`
--

CREATE TABLE `Acquisto` (
  `id_acquisto` int(10) NOT NULL,
  `data` date DEFAULT NULL,
  `totale` float DEFAULT NULL,
  `id_indirizzo` int(10) DEFAULT NULL,
  `id_utente` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Carta_Di_Credito`
--

CREATE TABLE `Carta_Di_Credito` (
  `id_carta` int(10) NOT NULL,
  `id_utente` int(11) NOT NULL,
  `numero_carta` char(16) DEFAULT NULL,
  `scadenza` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Categoria`
--

CREATE TABLE `Categoria` (
  `id_categoria` int(10) NOT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Categoria`
--

INSERT INTO `Categoria` (`id_categoria`, `nome`) VALUES
(1, 'Uomo'),
(3, 'Bambino'),
(5, 'Corsa'),
(6, 'Passeggio'),
(7, 'Donna');

-- --------------------------------------------------------

--
-- Struttura della tabella `Dettagli_Acquisto`
--

CREATE TABLE `Dettagli_Acquisto` (
  `id_scarpa` int(10) DEFAULT NULL,
  `id_taglia` int(10) NOT NULL,
  `id_acquisto` int(10) DEFAULT NULL,
  `quantita` int(11) NOT NULL,
  `prezzo` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Gruppo_Applicativo`
--

CREATE TABLE `Gruppo_Applicativo` (
  `id_gruppo_applicativo` int(10) NOT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Gruppo_Applicativo`
--

INSERT INTO `Gruppo_Applicativo` (`id_gruppo_applicativo`, `nome`) VALUES
(1, 'Admin'),
(2, 'Cliente');

-- --------------------------------------------------------

--
-- Struttura della tabella `Indirizzo`
--

CREATE TABLE `Indirizzo` (
  `id_indirizzo` int(10) NOT NULL,
  `id_utente` int(10) DEFAULT NULL,
  `nome` varchar(100) DEFAULT NULL,
  `citta` varchar(50) DEFAULT NULL,
  `via` varchar(50) DEFAULT NULL,
  `CAP` char(5) DEFAULT NULL,
  `altro` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Marca`
--

CREATE TABLE `Marca` (
  `id_marca` int(10) NOT NULL,
  `nome` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Marca`
--

INSERT INTO `Marca` (`id_marca`, `nome`) VALUES
(1, 'Nike'),
(2, 'Adidas'),
(4, 'Asics'),
(6, 'Converse'),
(8, 'Diadora');

-- --------------------------------------------------------

--
-- Struttura della tabella `Scarpa`
--

CREATE TABLE `Scarpa` (
  `id_scarpa` int(10) NOT NULL,
  `codice` varchar(20) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `prezzo` float DEFAULT NULL,
  `sconto` float NOT NULL,
  `id_marca` int(10) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `descrizione` varchar(1000) NOT NULL,
  `attivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Scarpa_Categoria`
--

CREATE TABLE `Scarpa_Categoria` (
  `id_scarpa` int(10) DEFAULT NULL,
  `id_categoria` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Stock_Scarpe`
--

CREATE TABLE `Stock_Scarpe` (
  `quantita` int(10) DEFAULT NULL,
  `id_scarpa` int(10) DEFAULT NULL,
  `id_taglia` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struttura della tabella `Taglia`
--

CREATE TABLE `Taglia` (
  `id_taglia` int(10) NOT NULL,
  `taglia_uk_m` float DEFAULT NULL,
  `taglia_uk_f` float NOT NULL,
  `taglia_eu` float DEFAULT NULL,
  `taglia_us_m` float DEFAULT NULL,
  `taglia_us_f` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Taglia`
--

INSERT INTO `Taglia` (`id_taglia`, `taglia_uk_m`, `taglia_uk_f`, `taglia_eu`, `taglia_us_m`, `taglia_us_f`) VALUES
(1, 3, 2.5, 35, 3.5, 5),
(2, 3.5, 3, 35.5, 4, 5.5),
(3, 4, 3.5, 36, 4.5, 6),
(4, 4.5, 4, 37, 5, 6.5),
(5, 5, 4.5, 37.5, 5.5, 7),
(6, 5.5, 5, 38, 6, 7.5),
(7, 6, 5.5, 38.5, 6.5, 8),
(8, 6.5, 6, 39, 7, 8.5),
(9, 7, 6.5, 40, 7.5, 9),
(10, 7.5, 7, 41, 8, 9.5),
(11, 8, 7.5, 42, 8.5, 10),
(12, 8.5, 8, 43, 9, 10.5),
(13, 10, 9.5, 44, 10.5, 12),
(14, 11, 10.5, 45, 11.5, 13),
(15, 12, 11.5, 46.5, 12.5, 14),
(16, 13.5, 13, 48.5, 14, 15.5);

-- --------------------------------------------------------

--
-- Struttura della tabella `Utente`
--

CREATE TABLE `Utente` (
  `id_utente` int(10) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `id_gruppo_applicativo` int(10) DEFAULT NULL,
  `attivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Utente`
--

INSERT INTO `Utente` (`id_utente`, `email`, `password`, `id_gruppo_applicativo`, `attivo`) VALUES
(1, 'admin@root', '702baf0ab00246bf06bdacd5b1e542b6', 1, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Wishlist`
--

CREATE TABLE `Wishlist` (
  `id_utente` int(10) DEFAULT NULL,
  `id_scarpa` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `Acquisto`
--
ALTER TABLE `Acquisto`
  ADD PRIMARY KEY (`id_acquisto`),
  ADD KEY `FK_Acquisto_0` (`id_indirizzo`),
  ADD KEY `FK_Acquisto_1` (`id_utente`);

--
-- Indici per le tabelle `Carta_Di_Credito`
--
ALTER TABLE `Carta_Di_Credito`
  ADD PRIMARY KEY (`id_carta`,`id_utente`);

--
-- Indici per le tabelle `Categoria`
--
ALTER TABLE `Categoria`
  ADD PRIMARY KEY (`id_categoria`);

--
-- Indici per le tabelle `Dettagli_Acquisto`
--
ALTER TABLE `Dettagli_Acquisto`
  ADD KEY `FK_Dettagli_Acquisto_0` (`id_scarpa`),
  ADD KEY `FK_Dettagli_Acquisto_1` (`id_acquisto`),
  ADD KEY `FK_Dettagli_Acquisto_2` (`id_taglia`);

--
-- Indici per le tabelle `Gruppo_Applicativo`
--
ALTER TABLE `Gruppo_Applicativo`
  ADD PRIMARY KEY (`id_gruppo_applicativo`);

--
-- Indici per le tabelle `Indirizzo`
--
ALTER TABLE `Indirizzo`
  ADD PRIMARY KEY (`id_indirizzo`),
  ADD KEY `FK_Indirizzo_0` (`id_utente`);

--
-- Indici per le tabelle `Marca`
--
ALTER TABLE `Marca`
  ADD PRIMARY KEY (`id_marca`);

--
-- Indici per le tabelle `Scarpa`
--
ALTER TABLE `Scarpa`
  ADD PRIMARY KEY (`id_scarpa`),
  ADD UNIQUE KEY `codice` (`codice`),
  ADD KEY `FK_Scarpa_0` (`id_marca`);

--
-- Indici per le tabelle `Scarpa_Categoria`
--
ALTER TABLE `Scarpa_Categoria`
  ADD KEY `FK_Scarpa_Categoria_0` (`id_scarpa`),
  ADD KEY `FK_Scarpa_Categoria_1` (`id_categoria`);

--
-- Indici per le tabelle `Stock_Scarpe`
--
ALTER TABLE `Stock_Scarpe`
  ADD UNIQUE KEY `id_scarpa` (`id_scarpa`,`id_taglia`),
  ADD KEY `FK_Stock_Scarpe_0` (`id_scarpa`),
  ADD KEY `FK_Stock_Scarpe_1` (`id_taglia`);

--
-- Indici per le tabelle `Taglia`
--
ALTER TABLE `Taglia`
  ADD PRIMARY KEY (`id_taglia`);

--
-- Indici per le tabelle `Utente`
--
ALTER TABLE `Utente`
  ADD PRIMARY KEY (`id_utente`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `FK_Utente_0` (`id_gruppo_applicativo`);

--
-- Indici per le tabelle `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD UNIQUE KEY `id_utente` (`id_utente`,`id_scarpa`),
  ADD KEY `FK_Wishlist_0` (`id_scarpa`),
  ADD KEY `FK_Wishlist_1` (`id_utente`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `Acquisto`
--
ALTER TABLE `Acquisto`
  MODIFY `id_acquisto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT per la tabella `Carta_Di_Credito`
--
ALTER TABLE `Carta_Di_Credito`
  MODIFY `id_carta` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT per la tabella `Categoria`
--
ALTER TABLE `Categoria`
  MODIFY `id_categoria` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT per la tabella `Indirizzo`
--
ALTER TABLE `Indirizzo`
  MODIFY `id_indirizzo` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT per la tabella `Marca`
--
ALTER TABLE `Marca`
  MODIFY `id_marca` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT per la tabella `Scarpa`
--
ALTER TABLE `Scarpa`
  MODIFY `id_scarpa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT per la tabella `Taglia`
--
ALTER TABLE `Taglia`
  MODIFY `id_taglia` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT per la tabella `Utente`
--
ALTER TABLE `Utente`
  MODIFY `id_utente` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `Acquisto`
--
ALTER TABLE `Acquisto`
  ADD CONSTRAINT `FK_Acquisto_0` FOREIGN KEY (`id_indirizzo`) REFERENCES `Indirizzo` (`id_indirizzo`),
  ADD CONSTRAINT `FK_Acquisto_1` FOREIGN KEY (`id_utente`) REFERENCES `Utente` (`id_utente`);

--
-- Limiti per la tabella `Dettagli_Acquisto`
--
ALTER TABLE `Dettagli_Acquisto`
  ADD CONSTRAINT `FK_Dettagli_Acquisto_0` FOREIGN KEY (`id_scarpa`) REFERENCES `Scarpa` (`id_scarpa`),
  ADD CONSTRAINT `FK_Dettagli_Acquisto_1` FOREIGN KEY (`id_acquisto`) REFERENCES `Acquisto` (`id_acquisto`),
  ADD CONSTRAINT `FK_Dettagli_Acquisto_2` FOREIGN KEY (`id_taglia`) REFERENCES `Taglia` (`id_taglia`);

--
-- Limiti per la tabella `Indirizzo`
--
ALTER TABLE `Indirizzo`
  ADD CONSTRAINT `FK_Indirizzo_0` FOREIGN KEY (`id_utente`) REFERENCES `Utente` (`id_utente`);

--
-- Limiti per la tabella `Scarpa`
--
ALTER TABLE `Scarpa`
  ADD CONSTRAINT `FK_Scarpa_0` FOREIGN KEY (`id_marca`) REFERENCES `Marca` (`id_marca`);

--
-- Limiti per la tabella `Scarpa_Categoria`
--
ALTER TABLE `Scarpa_Categoria`
  ADD CONSTRAINT `FK_Scarpa_Categoria_0` FOREIGN KEY (`id_scarpa`) REFERENCES `Scarpa` (`id_scarpa`),
  ADD CONSTRAINT `FK_Scarpa_Categoria_1` FOREIGN KEY (`id_categoria`) REFERENCES `Categoria` (`id_categoria`);

--
-- Limiti per la tabella `Stock_Scarpe`
--
ALTER TABLE `Stock_Scarpe`
  ADD CONSTRAINT `FK_Stock_Scarpe_0` FOREIGN KEY (`id_scarpa`) REFERENCES `Scarpa` (`id_scarpa`),
  ADD CONSTRAINT `FK_Stock_Scarpe_1` FOREIGN KEY (`id_taglia`) REFERENCES `Taglia` (`id_taglia`);

--
-- Limiti per la tabella `Utente`
--
ALTER TABLE `Utente`
  ADD CONSTRAINT `FK_Utente_0` FOREIGN KEY (`id_gruppo_applicativo`) REFERENCES `Gruppo_Applicativo` (`id_gruppo_applicativo`);

--
-- Limiti per la tabella `Wishlist`
--
ALTER TABLE `Wishlist`
  ADD CONSTRAINT `FK_Wishlist_0` FOREIGN KEY (`id_scarpa`) REFERENCES `Scarpa` (`id_scarpa`),
  ADD CONSTRAINT `FK_Wishlist_1` FOREIGN KEY (`id_utente`) REFERENCES `Utente` (`id_utente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
