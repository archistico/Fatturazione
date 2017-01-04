-- phpMyAdmin SQL Dump
-- version 4.6.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Gen 04, 2017 alle 19:46
-- Versione del server: 5.5.52-MariaDB
-- Versione PHP: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fatturazione`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `cliente`
--

CREATE TABLE `cliente` (
  `cli_id` int(11) NOT NULL,
  `cli_denominazione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_indirizzo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_cap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cli_comune` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_telefono` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cli_fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cli_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cli_piva` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_vecchio` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `cliente`
--

INSERT INTO `cliente` (`cli_id`, `cli_denominazione`, `cli_indirizzo`, `cli_cap`, `cli_comune`, `cli_telefono`, `cli_fax`, `cli_email`, `cli_piva`, `cli_vecchio`) VALUES
(1, 'Meite Celestin di Seris Micol  ', 'Fraz. Eresaz, 51', '11020', 'Emarese', '0166 519130', '', '', '01185730072', 0),
(2, 'GMI Servizi s.r.l. ', 'Regione Amerique, 9', '11020', 'Quart', '', '', '', '09226890011', 0),
(3, 'Vinarius s.r.l. ', 'Via E. Chanoux, 33', '11027', 'Saint-Vincent', '0166 518118', '', '', '01061320071', 0),
(4, 'Hosterie  La posa de Bertolin ', 'Piazza Cavour, 1/3', '11020', 'Bard', '347 1623055', '', '', '01038360077 / BRTRLL73B66A326Y', 0),
(5, 'Ristorante Cuney di Koval Alla ', 'Frazione Lignan, 36', '11020', 'Nus', '0165 770023', '', 'info@hotelristorantecuney.it', '04097650164 / KVLLLA66M44Z138L', 0),
(6, 'Hotel Elena ', 'Via Biavaz, 2', '11027', 'Saint-Vincent', '0166 512140', '0166 537459', 'info@hotelelena.be', '00048460075', 0),
(7, 'Le Bon Plaisir di Lomello Sandra  ', 'Via Marconi, 21', '11027', 'Saint-Vincent', '', '', '', '01209740073', 0),
(8, 'Coop. Sociale Nella a r.l.   ', 'Via Trento, 10', '11027', 'Saint-Vincent', '0166 537671', '0166 537671', 'laruche@libero.it', '00413510074', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ddt`
--

CREATE TABLE `ddt` (
  `ddt_id` int(11) NOT NULL,
  `ddt_numero` int(11) NOT NULL,
  `ddt_anno` int(11) NOT NULL,
  `ddt_data` date NOT NULL,
  `ddt_fkcliente` int(11) NOT NULL,
  `ddt_destinazione` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddt_causale` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddt_trasporto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddt_aspetto` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddt_colli` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddt_ritiro` date DEFAULT NULL,
  `ddt_scontrino` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ddt_importo` decimal(10,2) NOT NULL,
  `ddt_fatturazioneelettronica` tinyint(1) NOT NULL DEFAULT '0',
  `ddt_pagato` tinyint(1) NOT NULL DEFAULT '0',
  `ddt_fkfattura` int(11) DEFAULT NULL,
  `ddt_annullato` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `ddt`
--

INSERT INTO `ddt` (`ddt_id`, `ddt_numero`, `ddt_anno`, `ddt_data`, `ddt_fkcliente`, `ddt_destinazione`, `ddt_causale`, `ddt_trasporto`, `ddt_aspetto`, `ddt_colli`, `ddt_ritiro`, `ddt_scontrino`, `ddt_importo`, `ddt_fatturazioneelettronica`, `ddt_pagato`, `ddt_fkfattura`, `ddt_annullato`) VALUES
(1, 1, 2016, '2016-12-30', 1, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-30', '100', '37.40', 0, 0, 1, 0),
(2, 2, 2016, '2016-12-30', 4, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-30', '100', '28.10', 0, 0, NULL, 0),
(3, 3, 2016, '2017-01-02', 6, '', 'Omaggio', 'Mittente', 'Sfuso', '1', '2017-01-02', '150', '38.00', 0, 0, 15, 0),
(4, 1, 2017, '2017-01-02', 7, '', 'Vendita', 'Mittente', 'Sfuso', '2', '2017-01-02', '1235', '66.50', 0, 0, 14, 0),
(5, 2, 2017, '2017-01-02', 8, 'Fiera dell est', 'Vendita', 'Mittente', 'Sfuso', '1', '2017-01-02', 'Fiera dell est', '34.00', 0, 0, NULL, 0),
(6, 3, 2017, '2017-01-02', 6, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2017-01-02', 'modificato 123', '161.90', 0, 1, 7, 0),
(7, 4, 2017, '2017-01-04', 3, 'Fiera Saint Vincent', 'Omaggio', 'Vettore', 'Pacco', '3', '2017-01-04', '100', '13.00', 0, 1, NULL, 0),
(8, 5, 2017, '2017-01-02', 4, '', 'Tentata vendita', 'Vettore', 'Sfuso', '1', '2017-01-02', '3652', '44.97', 0, 0, NULL, 0),
(9, 6, 2017, '2017-01-04', 2, '', 'Omaggio', 'Mittente', 'Sfuso', '1', '2017-01-04', '1100', '62.10', 0, 1, 13, 0),
(10, 7, 2017, '2017-01-04', 7, 'Destinazione nuova', 'Vendita', 'Mittente', 'Sfuso', '1', '2017-01-04', '1230', '24.00', 0, 1, 14, 0),
(11, 8, 2017, '2017-01-04', 6, '', 'Omaggio', 'Mittente', 'Sfuso', '1', '2017-01-04', '120', '322.30', 0, 0, 15, 0),
(12, 9, 2017, '2017-01-04', 6, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2017-01-04', '122', '28.50', 0, 1, 15, 0),
(13, 10, 2017, '2017-01-04', 6, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2017-01-04', '233', '109.50', 0, 0, 15, 0),
(14, 11, 2017, '2017-01-04', 6, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2017-01-04', '133', '240.70', 0, 0, 15, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `ddtdettaglio`
--

CREATE TABLE `ddtdettaglio` (
  `ddd_id` int(11) NOT NULL,
  `ddd_fkddt` int(11) NOT NULL,
  `ddd_quantita` decimal(10,3) NOT NULL,
  `ddd_fkprodotto` int(11) NOT NULL,
  `ddd_tracciabilita` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd_annullato` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `ddtdettaglio`
--

INSERT INTO `ddtdettaglio` (`ddd_id`, `ddd_fkddt`, `ddd_quantita`, `ddd_fkprodotto`, `ddd_tracciabilita`, `ddd_annullato`) VALUES
(1, 1, '3.000', 5, '200', 0),
(3, 2, '1.000', 2, '20', 0),
(4, 3, '4.000', 6, '5500', 0),
(7, 4, '5.000', 1, '-', 0),
(8, 4, '3.000', 4, '-', 0),
(9, 5, '4.000', 1, 'fiera dell est', 0),
(10, 2, '2.000', 5, '500', 0),
(11, 6, '3.000', 5, '-', 0),
(12, 6, '15.000', 49, '-', 0),
(13, 6, '1.000', 14, '200', 0),
(14, 7, '1.000', 12, '-', 0),
(15, 8, '1.000', 14, '-', 0),
(16, 8, '2.000', 16, '-', 0),
(17, 8, '0.520', 20, '-', 0),
(19, 8, '0.016', 1, '-', 0),
(20, 1, '1.000', 2, '200', 0),
(21, 9, '3.000', 2, '100', 0),
(22, 9, '2.000', 20, '150', 0),
(23, 9, '2.000', 47, '123', 0),
(24, 10, '3.000', 4, '100', 0),
(25, 11, '5.000', 1, '-', 0),
(26, 11, '3.000', 1, '-', 0),
(27, 11, '1.000', 1, '-', 0),
(28, 11, '3.000', 33, '-', 0),
(29, 11, '5.000', 33, '-', 0),
(30, 11, '1.000', 33, '-', 0),
(31, 11, '3.000', 33, '-', 0),
(32, 11, '1.000', 53, '-', 0),
(33, 11, '1.000', 69, '-', 0),
(34, 11, '3.000', 85, '-', 0),
(35, 12, '3.000', 2, '-', 0),
(36, 13, '3.000', 19, '-', 0),
(37, 13, '2.000', 34, '-', 0),
(38, 13, '1.000', 52, '-', 0),
(39, 13, '1.000', 67, '-', 0),
(40, 13, '3.000', 82, '-', 0),
(41, 14, '3.000', 24, '-', 0),
(42, 14, '12.000', 57, '-', 0),
(43, 11, '1.000', 5, '12', 0),
(44, 11, '3.000', 4, '1', 0),
(45, 11, '5.000', 20, '3', 0),
(46, 14, '0.200', 68, '123', 0),
(47, 14, '5.000', 2, '12', 0),
(48, 14, '1.000', 2, '000', 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `fattura`
--

CREATE TABLE `fattura` (
  `fat_id` int(11) NOT NULL,
  `fat_numero` int(11) NOT NULL,
  `fat_anno` int(11) NOT NULL,
  `fat_data` date NOT NULL,
  `fat_fkcliente` int(11) NOT NULL,
  `fat_pagata` tinyint(1) NOT NULL DEFAULT '0',
  `fat_annullata` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `fattura`
--

INSERT INTO `fattura` (`fat_id`, `fat_numero`, `fat_anno`, `fat_data`, `fat_fkcliente`, `fat_pagata`, `fat_annullata`) VALUES
(1, 1, 2016, '2016-12-30', 1, 0, 0),
(7, 1, 2017, '2017-01-02', 6, 1, 0),
(13, 2, 2017, '2017-01-04', 2, 0, 0),
(14, 3, 2017, '2017-01-04', 7, 0, 0),
(15, 4, 2017, '2017-01-04', 6, 0, 0);

-- --------------------------------------------------------

--
-- Struttura della tabella `prodotto`
--

CREATE TABLE `prodotto` (
  `pro_id` int(11) NOT NULL,
  `pro_categoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pro_descrizione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pro_prezzo` decimal(10,2) NOT NULL,
  `pro_iva` decimal(5,2) NOT NULL,
  `pro_vecchio` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dump dei dati per la tabella `prodotto`
--

INSERT INTO `prodotto` (`pro_id`, `pro_categoria`, `pro_descrizione`, `pro_prezzo`, `pro_iva`, `pro_vecchio`) VALUES
(1, 'Anatra', 'Carne', '8.50', '10.00', 0),
(2, 'Bovino', 'Arrosto', '9.50', '10.00', 0),
(3, 'Bovino', 'Bollito c.o.', '7.00', '10.00', 0),
(4, 'Bovino', 'Bollito misto', '8.00', '10.00', 0),
(5, 'Bovino', 'Bollito polpa', '9.30', '10.00', 0),
(6, 'Bovino', 'Brasato', '9.50', '10.00', 0),
(7, 'Bovino', 'Carbonada', '10.00', '10.00', 0),
(8, 'Bovino', 'Carne trita', '8.00', '10.00', 0),
(9, 'Bovino', 'Carne trita magra', '13.00', '10.00', 0),
(10, 'Bovino', 'Carne trita sugo', '5.00', '10.00', 0),
(11, 'Bovino', 'Coda', '6.00', '10.00', 0),
(12, 'Bovino', 'Coscia', '13.00', '10.00', 0),
(13, 'Bovino', 'Fegato', '10.00', '10.00', 0),
(14, 'Bovino', 'Fettine', '14.00', '10.00', 0),
(15, 'Bovino', 'Franburger', '11.50', '10.00', 0),
(16, 'Bovino', 'Hamburger', '13.00', '10.00', 0),
(17, 'Bovino', 'Lingua', '7.00', '10.00', 0),
(18, 'Bovino', 'Lingua cotta salmistrata', '16.00', '10.00', 0),
(19, 'Bovino', 'Nodino', '16.50', '10.00', 0),
(20, 'Bovino', 'Ossibuchi', '9.30', '10.00', 0),
(21, 'Bovino', 'Polpa per bollito muscolo', '9.50', '10.00', 0),
(22, 'Bovino', 'Polpa per vitello tonnato', '13.00', '10.00', 0),
(23, 'Bovino', 'Presalé', '11.00', '10.00', 0),
(24, 'Bovino', 'Reale', '8.50', '10.00', 0),
(25, 'Bovino', 'Ritagli per ragù', '4.00', '10.00', 0),
(26, 'Bovino', 'Rognone', '5.00', '10.00', 0),
(27, 'Bovino', 'Rolate', '9.30', '10.00', 0),
(28, 'Bovino', 'Scaloppine', '14.00', '10.00', 0),
(29, 'Bovino', 'Scamone', '13.00', '10.00', 0),
(30, 'Bovino', 'Sottofiletto a fette', '16.50', '10.00', 0),
(31, 'Bovino', 'Sottofiletto intero', '15.50', '10.00', 0),
(32, 'Bovino', 'Spalla cotta Nadia', '10.00', '10.00', 0),
(33, 'Bovino', 'Spezzatino', '8.00', '10.00', 0),
(34, 'Bovino', 'Spiedoburger', '11.50', '10.00', 0),
(35, 'Bovino', 'Svizzera', '15.00', '10.00', 0),
(36, 'Bovino', 'Tondino', '15.00', '10.00', 0),
(37, 'Bovino', 'Trippa', '6.00', '10.00', 0),
(38, 'Bovino', 'Filetto vitellone', '28.00', '10.00', 0),
(39, 'Coniglio', 'Carne', '9.00', '10.00', 0),
(40, 'Faraona', 'Carne', '8.00', '10.00', 0),
(41, 'Maiale', 'Arrosto', '6.50', '10.00', 0),
(42, 'Maiale', 'Capocollo', '6.50', '10.00', 0),
(43, 'Maiale', 'Costine', '5.50', '10.00', 0),
(44, 'Maiale', 'Cotechino', '7.50', '10.00', 0),
(45, 'Maiale', 'Filetto', '11.00', '10.00', 0),
(46, 'Maiale', 'Lonza', '9.00', '10.00', 0),
(47, 'Maiale', 'Pasta salsiccia', '7.50', '10.00', 0),
(48, 'Maiale', 'Porchetta', '16.00', '10.00', 0),
(49, 'Maiale', 'Salsiccia', '8.00', '10.00', 0),
(50, 'Maiale', 'Stinchi', '5.00', '10.00', 0),
(51, 'Misto', 'Fagottini', '13.00', '10.00', 0),
(52, 'Misto', 'Giardiniera', '12.00', '10.00', 0),
(53, 'Misto', 'Gressonare', '13.00', '10.00', 0),
(54, 'Misto', 'Involtini', '16.00', '10.00', 0),
(55, 'Misto', 'Polpette', '13.00', '10.00', 0),
(56, 'Misto', 'Spiedini', '13.00', '10.00', 0),
(57, 'Misto', 'Tramezzini', '13.00', '10.00', 0),
(58, 'Pollo', 'Bocconcini', '10.00', '10.00', 0),
(59, 'Pollo', 'Cappone', '11.00', '10.00', 0),
(60, 'Pollo', 'Cosce', '5.50', '10.00', 0),
(61, 'Pollo', 'Fegatini', '5.00', '10.00', 0),
(62, 'Pollo', 'Fettine', '10.00', '10.00', 0),
(63, 'Pollo', 'Fusi', '6.50', '10.00', 0),
(64, 'Salumi', 'Bon Bocon Bertolin', '16.50', '10.00', 0),
(65, 'Salumi', 'Bresaola', '30.00', '10.00', 0),
(66, 'Salumi', 'Coppa', '18.00', '10.00', 0),
(67, 'Salumi', 'Lardo Arnad Bertolin', '13.00', '10.00', 0),
(68, 'Salumi', 'Lardo della casa', '11.00', '10.00', 0),
(69, 'Salumi', 'Mocetta', '30.00', '10.00', 0),
(70, 'Salumi', 'Mocetta affettata', '33.00', '10.00', 0),
(71, 'Salumi', 'Mortadella', '12.00', '10.00', 0),
(72, 'Salumi', 'Pancetta coppata', '18.00', '10.00', 0),
(73, 'Salumi', 'Prosciutto cotto', '19.00', '10.00', 0),
(74, 'Salumi', 'Prosciutto cotto spalla', '10.00', '10.00', 0),
(75, 'Salumi', 'Prosciutto crudo', '26.00', '10.00', 0),
(76, 'Salumi', 'Rosa d\'Aosta', '28.00', '10.00', 0),
(77, 'Salumi', 'Salame contadino', '18.00', '10.00', 0),
(78, 'Salumi', 'Salame cotto Nadia', '10.00', '10.00', 0),
(79, 'Salumi', 'Salamini Bertolin', '16.50', '10.00', 0),
(80, 'Salumi', 'Speck', '18.00', '10.00', 0),
(81, 'Tacchino', 'Arrosto cotto', '16.00', '10.00', 0),
(82, 'Tacchino', 'Cosce', '4.00', '10.00', 0),
(83, 'Tacchino', 'Fesa', '9.00', '10.00', 0),
(84, 'Tacchino', 'Fettine', '9.00', '10.00', 0),
(85, 'Tacchino', 'Rolate', '9.00', '10.00', 0),
(86, 'Tacchino', 'Spezzatino', '9.00', '10.00', 0),
(87, 'Uova', 'Dozzina', '3.80', '10.00', 0);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `cliente`
--
ALTER TABLE `cliente`
  ADD PRIMARY KEY (`cli_id`);

--
-- Indici per le tabelle `ddt`
--
ALTER TABLE `ddt`
  ADD PRIMARY KEY (`ddt_id`);

--
-- Indici per le tabelle `ddtdettaglio`
--
ALTER TABLE `ddtdettaglio`
  ADD PRIMARY KEY (`ddd_id`);

--
-- Indici per le tabelle `fattura`
--
ALTER TABLE `fattura`
  ADD PRIMARY KEY (`fat_id`);

--
-- Indici per le tabelle `prodotto`
--
ALTER TABLE `prodotto`
  ADD PRIMARY KEY (`pro_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `cliente`
--
ALTER TABLE `cliente`
  MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT per la tabella `ddt`
--
ALTER TABLE `ddt`
  MODIFY `ddt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT per la tabella `ddtdettaglio`
--
ALTER TABLE `ddtdettaglio`
  MODIFY `ddd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT per la tabella `fattura`
--
ALTER TABLE `fattura`
  MODIFY `fat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
