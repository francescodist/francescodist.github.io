-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Giu 19, 2017 alle 19:16
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

--
-- Dump dei dati per la tabella `Acquisto`
--

INSERT INTO `Acquisto` (`id_acquisto`, `data`, `totale`, `id_indirizzo`, `id_utente`) VALUES
(1, '2017-06-18', 61.2, 11, 3),
(2, '2017-06-18', 8, 11, 3),
(3, '2017-06-18', 20.4, 12, 3),
(4, '2017-06-18', 164, 13, 4),
(5, '2017-06-18', 28.4, 5, 3);

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

--
-- Dump dei dati per la tabella `Carta_Di_Credito`
--

INSERT INTO `Carta_Di_Credito` (`id_carta`, `id_utente`, `numero_carta`, `scadenza`) VALUES
(18, 3, '1234567812345678', '2017-01-30'),
(30, 3, '1234567812345679', '0000-00-00'),
(31, 4, '1111111111111111', '2017-11-30');

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

--
-- Dump dei dati per la tabella `Dettagli_Acquisto`
--

INSERT INTO `Dettagli_Acquisto` (`id_scarpa`, `id_taglia`, `id_acquisto`, `quantita`, `prezzo`) VALUES
(15, 5, 1, 3, 20.4),
(1, 1, 2, 1, 8),
(15, 10, 3, 1, 20.4),
(3, 9, 4, 4, 41),
(15, 9, 5, 1, 20.4),
(1, 4, 5, 1, 8);

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

--
-- Dump dei dati per la tabella `Indirizzo`
--

INSERT INTO `Indirizzo` (`id_indirizzo`, `id_utente`, `nome`, `citta`, `via`, `CAP`, `altro`) VALUES
(5, 3, 'Mario Rossi', 'Trapani', 'Via Garibaldi', '91100', 'scala B interno 10'),
(6, 3, 'Maria Rossi', 'Trapani', 'Via Fardella', '91100', ''),
(11, 3, 'Tizio Bianchi', 'Palermo', 'Via Marino Torre', '90123', ''),
(12, 3, 'Prova Ciao', 'Roma', 'Via Fasulla 123', '00155', 'prova'),
(13, 4, 'Giacomo Calcara', 'Trapani', 'Via G.ppe La Francesca, 4', '91100', '');

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
(6, 'Converse');

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

--
-- Dump dei dati per la tabella `Scarpa`
--

INSERT INTO `Scarpa` (`id_scarpa`, `codice`, `nome`, `prezzo`, `sconto`, `id_marca`, `foto`, `descrizione`, `attivo`) VALUES
(1, 'yuwegeryuwgruwey', 'air max', 8, 0, 1, 'ok.png', '', 1),
(3, 'ibnvdidvbninusd', 'ehg', 41, 0, 1, 'ok.png', '', 1),
(5, 'prova12', 'prova13', 45, 0, 1, 'ok.png', '', 1),
(6, 'prova2', 'prova2', 36, 0, 2, 'ok.png', '', 1),
(7, 'prova3', 'prova3', 23, 0, 6, 'ok.png', '', 1),
(8, 'sdfgoijdfsoui', 'ciao', 24, 0, 6, 'ok.png', '', 1),
(9, 'yuegeryuwgruwey', 'air max', 8, 0, 1, 'ok.png', '', 1),
(10, 'cabuya', 'ders', 31, 0, 4, 'ok.png', '', 1),
(12, 'cabuyas', 'ders', 31, 0, 4, 'ok.png', '', 1),
(13, 'nk126798345', 'air max 90', 120, 0, 1, 'ok.png', '', 1),
(14, 'sdfubufsdy', 'asdds', 25, 0, 4, 'ok.png', '', 1),
(15, 'cabuyass', 'cabuyas', 25.5, 20, 1, 'ok.png', '<h1>Prova</h1>\r\n<p>Questa Ã¨ una prova</p>', 1),
(16, 'cabuyal', 'cabuyas 2', 21, 10, 2, 'ok.png', '<h3>Cabuyas 2!</h3>\r\n<p>Ora anche da donna!</p>', 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Scarpa_Categoria`
--

CREATE TABLE `Scarpa_Categoria` (
  `id_scarpa` int(10) DEFAULT NULL,
  `id_categoria` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Scarpa_Categoria`
--

INSERT INTO `Scarpa_Categoria` (`id_scarpa`, `id_categoria`) VALUES
(9, 1),
(9, 5),
(10, 1),
(10, 5),
(12, 1),
(12, 5),
(13, 1),
(13, 5),
(14, 1),
(14, 6),
(5, 1),
(5, 3),
(15, 1),
(15, 5),
(16, 5),
(16, 7);

-- --------------------------------------------------------

--
-- Struttura della tabella `Stock_Scarpe`
--

CREATE TABLE `Stock_Scarpe` (
  `quantita` int(10) DEFAULT NULL,
  `id_scarpa` int(10) DEFAULT NULL,
  `id_taglia` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Stock_Scarpe`
--

INSERT INTO `Stock_Scarpe` (`quantita`, `id_scarpa`, `id_taglia`) VALUES
(1, 13, 1),
(2, 13, 2),
(3, 13, 3),
(2, 13, 4),
(5, 13, 5),
(2, 13, 6),
(5, 13, 7),
(4, 13, 8),
(10, 13, 9),
(20, 13, 10),
(20, 13, 11),
(20, 13, 12),
(0, 13, 13),
(5, 13, 14),
(1, 13, 15),
(0, 13, 16),
(1, 14, 1),
(2, 14, 2),
(4, 14, 3),
(6, 14, 4),
(3, 14, 5),
(5, 14, 7),
(7, 14, 8),
(10, 14, 9),
(12, 14, 10),
(13, 14, 11),
(10, 14, 12),
(4, 14, 13),
(5, 14, 14),
(0, 14, 15),
(0, 14, 16),
(0, 15, 1),
(0, 15, 2),
(0, 15, 3),
(0, 15, 4),
(20, 15, 5),
(10, 15, 7),
(0, 15, 8),
(5, 15, 9),
(17, 15, 10),
(10, 15, 11),
(0, 15, 12),
(0, 15, 13),
(0, 15, 14),
(0, 15, 15),
(0, 15, 16),
(1, 1, 1),
(0, 1, 2),
(0, 1, 3),
(3, 1, 4),
(0, 1, 5),
(5, 1, 7),
(0, 1, 8),
(0, 1, 9),
(3, 1, 10),
(0, 1, 11),
(3, 1, 12),
(0, 1, 13),
(0, 1, 14),
(0, 1, 15),
(0, 1, 16),
(0, 3, 1),
(0, 3, 2),
(0, 3, 3),
(0, 3, 4),
(0, 3, 5),
(0, 3, 7),
(0, 3, 8),
(4, 3, 9),
(0, 3, 10),
(0, 3, 11),
(0, 3, 12),
(0, 3, 13),
(0, 3, 14),
(0, 3, 15),
(0, 3, 16),
(2, 16, 1),
(23, 16, 2),
(0, 16, 3),
(40, 16, 4),
(0, 16, 5),
(100, 16, 7),
(25, 16, 8),
(30, 16, 9),
(40, 16, 10),
(20, 16, 11),
(0, 16, 12),
(6, 16, 13),
(3, 16, 14),
(1, 16, 15),
(0, 16, 16);

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
(1, 'admin@root', '702baf0ab00246bf06bdacd5b1e542b6', 1, 1),
(3, 'prova@example.com', '920b271ca21afa3b009317115781f296', 2, 1),
(4, 'prova2@example.com', '920b271ca21afa3b009317115781f296', 2, 1),
(39, 'prova3@example.com', '920b271ca21afa3b009317115781f296', 2, 1),
(40, 'prova4@example.com', '920b271ca21afa3b009317115781f296', 2, 1);

-- --------------------------------------------------------

--
-- Struttura della tabella `Wishlist`
--

CREATE TABLE `Wishlist` (
  `id_utente` int(10) DEFAULT NULL,
  `id_scarpa` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dump dei dati per la tabella `Wishlist`
--

INSERT INTO `Wishlist` (`id_utente`, `id_scarpa`) VALUES
(3, 13);

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
  MODIFY `id_acquisto` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
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
  MODIFY `id_marca` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT per la tabella `Scarpa`
--
ALTER TABLE `Scarpa`
  MODIFY `id_scarpa` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
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
