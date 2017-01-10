-- MySQL dump 10.14  Distrib 5.5.53-MariaDB, for Linux ()
--
-- Host: fatturazione    Database: fatturazione
-- ------------------------------------------------------
-- Server version	5.5.53-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cliente`
--

DROP TABLE IF EXISTS `cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cliente` (
  `cli_id` int(11) NOT NULL AUTO_INCREMENT,
  `cli_denominazione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_indirizzo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_cap` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `cli_comune` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_telefono` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cli_fax` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cli_email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cli_piva` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cli_vecchio` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cli_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cliente`
--

LOCK TABLES `cliente` WRITE;
/*!40000 ALTER TABLE `cliente` DISABLE KEYS */;
INSERT INTO `cliente` VALUES (1,'Meite Celestin di Seris Micol  ','Fraz. Eresaz, 51','11020','Emarese','0166 519130','','','01185730072',0),(2,'GMI Servizi s.r.l. ','Regione Amerique, 9','11020','Quart','','','','09226890011',0),(3,'Vinarius s.r.l. ','Via E. Chanoux, 33','11027','Saint-Vincent','0166 518118','','','01061320071',0),(4,'Hosterie  La posa de Bertolin ','Piazza Cavour, 1/3','11020','Bard','347 1623055','','','01038360077 / BRTRLL73B66A326Y',0),(5,'Ristorante Cuney di Koval Alla ','Frazione Lignan, 36','11020','Nus','0165 770023','','info@hotelristorantecuney.it','04097650164 / KVLLLA66M44Z138L',0),(6,'Hotel Elena ','Via Biavaz, 2','11027','Saint-Vincent','0166 512140','0166 537459','info@hotelelena.be','00048460075',0),(7,'Le Bon Plaisir di Lomello Sandra  ','Via Marconi, 21','11027','Saint-Vincent','','','','01209740073',0),(8,'Coop. Sociale Nella a r.l.   ','Via Trento, 10','11027','Saint-Vincent','0166 537671','0166 537671','laruche@libero.it','00413510074',0);
/*!40000 ALTER TABLE `cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ddt`
--

DROP TABLE IF EXISTS `ddt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ddt` (
  `ddt_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `ddt_annullato` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ddt`
--

LOCK TABLES `ddt` WRITE;
/*!40000 ALTER TABLE `ddt` DISABLE KEYS */;
INSERT INTO `ddt` VALUES (1,1,2016,'2016-12-30',1,'','Vendita','Mittente','Sfuso','1','2016-12-30','100',37.40,0,0,1,0),(2,2,2016,'2016-12-30',4,'','Vendita','Mittente','Sfuso','1','2016-12-30','100',28.10,0,0,NULL,0),(3,3,2016,'2017-01-02',6,'','Omaggio','Mittente','Sfuso','1','2017-01-02','150',38.00,0,0,15,0),(4,1,2017,'2017-01-02',7,'','Vendita','Mittente','Sfuso','2','2017-01-02','1235',66.50,0,0,14,0),(5,2,2017,'2017-01-02',8,'Fiera dell est','Vendita','Mittente','Sfuso','1','2017-01-02','Fiera dell est',34.00,0,0,NULL,0),(6,3,2017,'2017-01-02',6,'','Vendita','Mittente','Sfuso','1','2017-01-02','modificato 123',161.90,0,1,7,0),(7,4,2017,'2017-01-04',3,'Fiera Saint Vincent','Omaggio','Vettore','Pacco','3','2017-01-04','100',13.00,0,1,NULL,0),(8,5,2017,'2017-01-02',4,'','Tentata vendita','Vettore','Sfuso','2','2017-01-02','3652',73.47,0,0,16,0),(9,6,2017,'2017-01-04',2,'','Omaggio','Mittente','Sfuso','1','2017-01-04','1100',62.10,0,1,13,0),(10,7,2017,'2017-01-04',7,'Destinazione nuova','Vendita','Mittente','Sfuso','1','2017-01-04','1230',24.00,0,1,14,0),(11,8,2017,'2017-01-04',6,'','Omaggio','Mittente','Sfuso','1','2017-01-04','120',322.30,0,0,15,0),(12,9,2017,'2017-01-04',6,'','Vendita','Mittente','Sfuso','1','2017-01-04','122',28.50,0,1,15,0),(13,10,2017,'2017-01-04',6,'','Vendita','Mittente','Sfuso','1','2017-01-04','233',118.00,0,0,15,0),(14,11,2017,'2017-01-04',6,'','Vendita','Mittente','Sfuso','1','2017-01-04','133',252.10,0,0,15,0),(15,12,2017,'2017-01-05',8,'','Vendita','Mittente','Sfuso','1','2017-01-05','111',5.40,0,0,NULL,0);
/*!40000 ALTER TABLE `ddt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ddtdettaglio`
--

DROP TABLE IF EXISTS `ddtdettaglio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ddtdettaglio` (
  `ddd_id` int(11) NOT NULL AUTO_INCREMENT,
  `ddd_fkddt` int(11) NOT NULL,
  `ddd_quantita` decimal(10,3) NOT NULL,
  `ddd_fkprodotto` int(11) NOT NULL,
  `ddd_tracciabilita` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ddd_annullato` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ddd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ddtdettaglio`
--

LOCK TABLES `ddtdettaglio` WRITE;
/*!40000 ALTER TABLE `ddtdettaglio` DISABLE KEYS */;
INSERT INTO `ddtdettaglio` VALUES (1,1,3.000,5,'200',0),(3,2,1.000,2,'20',0),(4,3,4.000,6,'5500',0),(7,4,5.000,1,'-',0),(8,4,3.000,4,'-',0),(9,5,4.000,1,'fiera dell est',0),(10,2,2.000,5,'500',0),(11,6,3.000,5,'-',0),(12,6,15.000,49,'-',0),(13,6,1.000,14,'200',0),(14,7,1.000,12,'-',0),(15,8,1.000,14,'-',0),(16,8,2.000,16,'-',0),(17,8,0.520,20,'-',0),(19,8,0.016,1,'-',0),(20,1,1.000,2,'200',0),(21,9,3.000,2,'100',0),(22,9,2.000,20,'150',0),(23,9,2.000,47,'123',0),(24,10,3.000,4,'100',0),(25,11,5.000,1,'-',0),(26,11,3.000,1,'-',0),(27,11,1.000,1,'-',0),(28,11,3.000,33,'-',0),(29,11,5.000,33,'-',0),(30,11,1.000,33,'-',0),(31,11,3.000,33,'-',0),(32,11,1.000,53,'-',0),(33,11,1.000,69,'-',0),(34,11,3.000,85,'-',0),(35,12,3.000,2,'-',0),(36,13,3.000,19,'-',0),(37,13,2.000,34,'-',0),(38,13,1.000,52,'-',0),(39,13,1.000,67,'-',0),(40,13,3.000,82,'-',0),(41,14,3.000,24,'-',0),(42,14,12.000,57,'-',0),(43,11,1.000,5,'12',0),(44,11,3.000,4,'1',0),(45,11,5.000,20,'3',0),(46,14,0.200,68,'123',0),(47,14,5.000,2,'12',0),(48,14,1.000,2,'000',0),(49,13,1.000,1,'123',0),(50,8,3.000,2,'222',0),(51,14,3.000,87,'100',0),(52,15,3.000,89,'100',0);
/*!40000 ALTER TABLE `ddtdettaglio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fattura`
--

DROP TABLE IF EXISTS `fattura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fattura` (
  `fat_id` int(11) NOT NULL AUTO_INCREMENT,
  `fat_numero` int(11) NOT NULL,
  `fat_anno` int(11) NOT NULL,
  `fat_data` date NOT NULL,
  `fat_fkcliente` int(11) NOT NULL,
  `fat_pagata` tinyint(1) NOT NULL DEFAULT '0',
  `fat_annullata` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fattura`
--

LOCK TABLES `fattura` WRITE;
/*!40000 ALTER TABLE `fattura` DISABLE KEYS */;
INSERT INTO `fattura` VALUES (1,1,2016,'2016-12-30',1,0,0),(7,1,2017,'2017-01-02',6,1,0),(13,2,2017,'2017-01-04',2,0,0),(14,3,2017,'2017-01-04',7,0,0),(15,4,2017,'2017-01-04',6,0,0),(16,5,2017,'2017-01-10',4,0,0);
/*!40000 ALTER TABLE `fattura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prodotto`
--

DROP TABLE IF EXISTS `prodotto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prodotto` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_categoria` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pro_descrizione` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `pro_prezzo` decimal(10,2) NOT NULL,
  `pro_iva` decimal(5,2) NOT NULL,
  `pro_vecchio` tinyint(1) NOT NULL DEFAULT '0',
  `pro_misura` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'kg',
  PRIMARY KEY (`pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prodotto`
--

LOCK TABLES `prodotto` WRITE;
/*!40000 ALTER TABLE `prodotto` DISABLE KEYS */;
INSERT INTO `prodotto` VALUES (1,'Anatra','Carne',8.50,10.00,0,'kg'),(2,'Bovino','Arrosto',9.50,10.00,0,'kg'),(3,'Bovino','Bollito c.o.',7.00,10.00,0,'kg'),(4,'Bovino','Bollito misto',8.00,10.00,0,'kg'),(5,'Bovino','Bollito polpa',9.30,10.00,0,'kg'),(6,'Bovino','Brasato',9.50,10.00,0,'kg'),(7,'Bovino','Carbonada',10.00,10.00,0,'kg'),(8,'Bovino','Carne trita',8.00,10.00,0,'kg'),(9,'Bovino','Carne trita magra',13.00,10.00,0,'kg'),(10,'Bovino','Carne trita sugo',5.00,10.00,0,'kg'),(11,'Bovino','Coda',6.00,10.00,0,'kg'),(12,'Bovino','Coscia',13.00,10.00,0,'kg'),(13,'Bovino','Fegato',10.00,10.00,0,'kg'),(14,'Bovino','Fettine',14.00,10.00,0,'kg'),(15,'Bovino','Franburger',11.50,10.00,0,'kg'),(16,'Bovino','Hamburger',13.00,10.00,0,'kg'),(17,'Bovino','Lingua',7.00,10.00,0,'kg'),(18,'Bovino','Lingua cotta salmistrata',16.00,10.00,0,'kg'),(19,'Bovino','Nodino',16.50,10.00,0,'kg'),(20,'Bovino','Ossibuchi',9.30,10.00,0,'kg'),(21,'Bovino','Polpa per bollito muscolo',9.50,10.00,0,'kg'),(22,'Bovino','Polpa per vitello tonnato',13.00,10.00,0,'kg'),(23,'Bovino','Presalé',11.00,10.00,0,'kg'),(24,'Bovino','Reale',8.50,10.00,0,'kg'),(25,'Bovino','Ritagli per ragù',4.00,10.00,0,'kg'),(26,'Bovino','Rognone',5.00,10.00,0,'kg'),(27,'Bovino','Rolate',9.30,10.00,0,'kg'),(28,'Bovino','Scaloppine',14.00,10.00,0,'kg'),(29,'Bovino','Scamone',13.00,10.00,0,'kg'),(30,'Bovino','Sottofiletto a fette',16.50,10.00,0,'kg'),(31,'Bovino','Sottofiletto intero',15.50,10.00,0,'kg'),(32,'Bovino','Spalla cotta Nadia',10.00,10.00,0,'kg'),(33,'Bovino','Spezzatino',8.00,10.00,0,'kg'),(34,'Bovino','Spiedoburger',11.50,10.00,0,'kg'),(35,'Bovino','Svizzera',15.00,10.00,0,'kg'),(36,'Bovino','Tondino',15.00,10.00,0,'kg'),(37,'Bovino','Trippa',6.00,10.00,0,'kg'),(38,'Bovino','Filetto vitellone',28.00,10.00,0,'kg'),(39,'Coniglio','Carne',9.00,10.00,0,'kg'),(40,'Faraona','Carne',8.00,10.00,0,'kg'),(41,'Maiale','Arrosto',6.50,10.00,0,'kg'),(42,'Maiale','Capocollo',6.50,10.00,0,'kg'),(43,'Maiale','Costine',5.50,10.00,0,'kg'),(44,'Maiale','Cotechino',7.50,10.00,0,'kg'),(45,'Maiale','Filetto',11.00,10.00,0,'kg'),(46,'Maiale','Lonza',9.00,10.00,0,'kg'),(47,'Maiale','Pasta salsiccia',7.50,10.00,0,'kg'),(48,'Maiale','Porchetta',16.00,10.00,0,'kg'),(49,'Maiale','Salsiccia',8.00,10.00,0,'kg'),(50,'Maiale','Stinchi',5.00,10.00,0,'kg'),(51,'Misto','Fagottini',13.00,10.00,0,'kg'),(52,'Misto','Giardiniera',12.00,10.00,0,'kg'),(53,'Misto','Gressonare',13.00,10.00,0,'kg'),(54,'Misto','Involtini',16.00,10.00,0,'kg'),(55,'Misto','Polpette',13.00,10.00,0,'kg'),(56,'Misto','Spiedini',13.00,10.00,0,'kg'),(57,'Misto','Tramezzini',13.00,10.00,0,'kg'),(58,'Pollo','Bocconcini',10.00,10.00,0,'kg'),(59,'Pollo','Cappone',11.00,10.00,0,'kg'),(60,'Pollo','Cosce',5.50,10.00,0,'kg'),(61,'Pollo','Fegatini',5.00,10.00,0,'kg'),(62,'Pollo','Fettine',10.00,10.00,0,'kg'),(63,'Pollo','Fusi',6.50,10.00,0,'kg'),(64,'Salumi','Bon Bocon Bertolin',16.50,10.00,0,'kg'),(65,'Salumi','Bresaola',30.00,10.00,0,'kg'),(66,'Salumi','Coppa',18.00,10.00,0,'kg'),(67,'Salumi','Lardo Arnad Bertolin',13.00,10.00,0,'kg'),(68,'Salumi','Lardo della casa',11.00,10.00,0,'kg'),(69,'Salumi','Mocetta',30.00,10.00,0,'kg'),(70,'Salumi','Mocetta affettata',33.00,10.00,0,'kg'),(71,'Salumi','Mortadella',12.00,10.00,0,'kg'),(72,'Salumi','Pancetta coppata',18.00,10.00,0,'kg'),(73,'Salumi','Prosciutto cotto',19.00,10.00,0,'kg'),(74,'Salumi','Prosciutto cotto spalla',10.00,10.00,0,'kg'),(75,'Salumi','Prosciutto crudo',26.00,10.00,0,'kg'),(76,'Salumi','Rosa d\'Aosta',28.00,10.00,0,'kg'),(77,'Salumi','Salame contadino',18.00,10.00,0,'kg'),(78,'Salumi','Salame cotto Nadia',10.00,10.00,0,'kg'),(79,'Salumi','Salamini Bertolin',16.50,10.00,0,'kg'),(80,'Salumi','Speck',18.00,10.00,0,'kg'),(81,'Tacchino','Arrosto cotto',16.00,10.00,0,'kg'),(82,'Tacchino','Cosce',4.00,10.00,0,'kg'),(83,'Tacchino','Fesa',9.00,10.00,0,'kg'),(84,'Tacchino','Fettine',9.00,10.00,0,'kg'),(85,'Tacchino','Rolate',9.00,10.00,0,'kg'),(86,'Tacchino','Spezzatino',9.00,10.00,0,'kg'),(87,'Uova','Dozzina',3.80,10.00,0,'cf'),(89,'Uova','Biologiche',1.80,10.00,0,'cf');
/*!40000 ALTER TABLE `prodotto` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-10 12:59:40
