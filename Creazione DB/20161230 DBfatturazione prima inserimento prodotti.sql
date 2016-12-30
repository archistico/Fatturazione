-- phpMyAdmin SQL Dump
-- version 4.6.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Dic 30, 2016 alle 17:51
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
(1, 'Rollandin Emilie', 'via Guillet 6', '11027', 'Saint Vincent', '3457054951', '', 'emilie.rollandin@gmail.com', '01160680078', 0),
(2, 'Laurent Marisa', 'via Guillet 6', '11027', 'Saint Vincent', '0166511415', '', 'laurent.marisa@gmail.com', 'LRNMRS55S63A326H', 0),
(3, 'Groppo Elettra', 'via Guillet 6', '11027', 'Saint Vincent', '3889207016', '', 'elmisworld@gmail.com', 'GRPLTR82T47XXXX', 0),
(4, 'Ditta Esempiò s.n.c.  ', 'Via delle Virtù, 6', '11027', 'Santhià', '0166511415', '0166511416', 'esempio@libero.it', '01100660067', 0),
(5, 'Nuova gestione snc  ', 'via delle pizze, 4', '12065', 'Roma', '', '', 'gestione@libero.it', 'RLLMLE77S65E379H', 0);

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
(1, 1, 2016, '2016-06-01', 2, '', 'Vendita', 'Destinatario', 'Sfuso', '1', '2016-06-12', '120', '22.00', 0, 0, 24, 0),
(2, 2, 2016, '2016-06-13', 1, '', 'Vendita', 'Destinatario', 'Sfuso', '1', '2016-06-13', '20', '49.26', 0, 0, 20, 0),
(3, 3, 2016, '2016-06-12', 1, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-06-12', '12', '87.50', 0, 0, 20, 0),
(4, 4, 2016, '2016-07-28', 2, 'via Ponte Romano ', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-07-28', '1202', '2329.75', 0, 1, 22, 0),
(5, 5, 2016, '2016-07-28', 1, '-', 'Vendita', 'Destinatario', 'Sfuso', '1', '2016-07-28', '1203', '18.00', 0, 0, 20, 0),
(6, 6, 2016, '2016-07-29', 3, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-07-29', '1204', '9.30', 0, 0, 18, 0),
(7, 7, 2016, '2016-08-01', 3, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-08-01', '1205', '36.00', 1, 0, NULL, 0),
(8, 8, 2016, '2016-07-26', 2, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-08-03', '120', '7.50', 0, 0, 22, 0),
(9, 9, 2016, '2016-07-26', 2, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-08-03', '120', '65.00', 0, 0, 25, 0),
(10, 10, 2016, '2016-12-06', 4, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-27', '500', '145.00', 0, 1, 26, 0),
(11, 11, 2016, '2016-12-10', 4, '', 'Tentata vendita', 'Vettore', 'Sfuso', '2', '2016-12-10', '150', '52.50', 0, 0, 27, 0),
(12, 12, 2016, '2016-12-13', 4, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-13', '100', '0.00', 0, 0, NULL, 0),
(17, 13, 2016, '2016-12-14', 4, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-14', '2356', '27.90', 0, 0, NULL, 0),
(18, 14, 2016, '2016-12-14', 1, '', 'Omaggio', 'Mittente', 'Sfuso', '1', '2016-12-14', '300', '44.75', 0, 0, NULL, 0),
(19, 15, 2016, '2016-12-14', 1, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-14', '1235', '69.00', 0, 1, NULL, 0),
(20, 16, 2016, '2016-12-14', 2, '', 'Vendita', 'Mittente', 'Sfuso', '1', '2016-12-14', '6666', '150.60', 1, 0, NULL, 0);

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
(1, 2, '3.000', 2, '215', 0),
(2, 2, '1.200', 4, '215', 0),
(4, 2, '0.200', 8, '300', 0),
(5, 4, '3.500', 2, '202', 0),
(6, 4, '1.000', 5, '100', 0),
(9, 3, '2.000', 5, '100', 0),
(10, 3, '1.000', 8, '100', 0),
(11, 3, '1.000', 7, '200', 0),
(12, 3, '0.500', 8, '200', 0),
(15, 2, '0.200', 7, '100', 0),
(16, 1, '1.000', 7, '0', 0),
(17, 5, '1.000', 5, '0', 0),
(18, 6, '1.000', 4, '0', 0),
(19, 7, '2.000', 5, '0', 0),
(20, 8, '0.500', 1, '100', 0),
(21, 9, '5.000', 3, '150', 0),
(22, 3, '1.000', 6, '100', 0),
(23, 4, '5.000', 6, '150', 0),
(24, 4, '100.000', 7, '1230', 0),
(25, 4, '1.000', 9, '0100 28/11/2016', 0),
(26, 10, '5.000', 5, '100', 0),
(27, 10, '5.000', 8, '125', 0),
(28, 11, '5.000', 2, '150', 0),
(29, 17, '3.000', 4, '1556', 0),
(31, 18, '1.500', 9, '301', 0),
(32, 18, '2.000', 3, '302', 0),
(33, 18, '0.000', 0, '', 0),
(34, 19, '2.000', 1, '1111', 0),
(35, 19, '3.000', 3, '2222', 0),
(38, 20, '12.000', 8, '9876', 0),
(39, 20, '2.000', 4, '100', 0);

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
(18, 1, 2016, '2016-11-27', 3, 1, 0),
(19, 2, 2016, '2016-11-27', 2, 0, 1),
(20, 3, 2016, '2016-11-27', 1, 1, 0),
(22, 4, 2016, '2016-11-27', 2, 0, 0),
(23, 5, 2016, '2016-12-07', 2, 0, 1),
(24, 6, 2016, '2016-12-07', 2, 0, 0),
(25, 7, 2016, '2016-12-07', 2, 0, 0),
(26, 8, 2016, '2016-12-09', 4, 0, 0),
(27, 9, 2016, '2016-12-10', 4, 0, 0);

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
(1, 'Carne bovino', 'Sottofiletto', '15.00', '10.00', 0),
(2, 'Carne bovino', 'Fegato', '10.50', '10.00', 0),
(3, 'Carne bovino', 'Trita magra', '13.00', '10.00', 0),
(4, 'Carne bovino', 'Rolata', '9.30', '10.00', 0),
(5, 'Carne cinghiale', 'Coscia', '18.00', '10.00', 0),
(6, 'Insaccati', 'Lardo Arnad Bertolin', '13.00', '10.00', 0),
(7, 'Insaccati', 'Prosciutto cotto Bossolein', '22.00', '10.00', 0),
(8, 'Carne bovino', 'Presalé', '11.00', '10.00', 0),
(9, 'Carne bovino', 'Spezzatino', '12.50', '4.00', 0),
(10, 'Prova categoria', 'Prova descrizione', '100.00', '10.00', 0);

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
  MODIFY `cli_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT per la tabella `ddt`
--
ALTER TABLE `ddt`
  MODIFY `ddt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT per la tabella `ddtdettaglio`
--
ALTER TABLE `ddtdettaglio`
  MODIFY `ddd_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
--
-- AUTO_INCREMENT per la tabella `fattura`
--
ALTER TABLE `fattura`
  MODIFY `fat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT per la tabella `prodotto`
--
ALTER TABLE `prodotto`
  MODIFY `pro_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
