-- MySQL dump 10.13  Distrib 5.5.16, for Win32 (x86)
--
-- Host: localhost    Database: pricing
-- ------------------------------------------------------
-- Server version	5.5.16

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
-- Table structure for table `agreement`
--

DROP TABLE IF EXISTS `agreement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `agreement` (
  `agreement_id` int(11) NOT NULL AUTO_INCREMENT,
  `offer_no` varchar(50) DEFAULT NULL,
  `agreement_date` date DEFAULT NULL,
  `plan_id` int(11) DEFAULT NULL,
  `sp_id` varchar(20) NOT NULL,
  `cam_id` varchar(20) NOT NULL,
  `cust_no` varchar(20) NOT NULL,
  `site_id` varchar(20) NOT NULL,
  `product_no` varchar(20) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `ba_type` int(11) DEFAULT NULL,
  `currency` char(3) DEFAULT NULL,
  `rate` decimal(10,0) DEFAULT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`agreement_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `agreement`
--

LOCK TABLES `agreement` WRITE;
/*!40000 ALTER TABLE `agreement` DISABLE KEYS */;
INSERT INTO `agreement` VALUES (1,'OFFER001','2018-03-22',1,'FRO','HP','70085','70085-001','PM-88/90','2018-04-01','2018-11-30',2250000,3,'IDR',0,'test input data agreement.','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(2,'OFFER002','2018-04-01',2,'FRO','CR','70085','70085-002','PM-88/90','2018-04-01','2018-11-30',2250000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(3,'OFFER003','2018-04-02',3,'FRO','CR','70086','70086-001','PM-88/90','2018-04-02','2018-11-30',2350000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(4,'OFFER004','2018-04-03',4,'FRO','CR','70087','70087-001','PM-88/90','2018-04-03','2018-11-30',2350000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(5,'OFFER005','2018-04-04',5,'FRO','CR','70085','70085-001','PM-99/90','2018-04-04','2018-11-30',3250000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(6,'OFFER006','2018-04-05',6,'FRO','CR','70085','70085-002','PM-99/90','2018-04-05','2018-11-30',3250000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(7,'OFFER007','2018-04-06',7,'FRO','CR','70086','70086-001','PM-99/90','2018-04-06','2018-11-30',3350000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(8,'OFFER008','2018-04-07',8,'FRO','CR','70087','70087-001','PM-99/90','2018-04-07','2018-11-30',3450000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(9,'OFFER009','2018-04-08',9,'FRO','CR','70085','70085-001','PR-10/30','2018-04-08','2018-11-30',4250000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(10,'OFFER010','2018-04-09',10,'FRO','CR','70085','70085-002','PR-10/30','2018-04-09','2018-11-30',4250000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(11,'OFFER011','2018-05-10',11,'FRO','CR','70086','70086-001','PR-10/30','2018-05-10','2018-11-30',4350000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(12,'OFFER012','2018-05-11',12,'FRO','CR','70087','70087-001','PR-10/30','2018-05-11','2018-11-30',4450000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(13,'OFFER013','2018-05-12',13,'NSD','HP','70085','70085-001','PR-456/50','2018-05-12','2018-11-30',6250000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(14,'OFFER014','2018-05-13',14,'NSD','HP','70085','70085-002','PR-456/50','2018-05-13','2018-11-30',6250000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(15,'OFFER015','2018-05-14',15,'NSD','HP','70086','70086-001','PR-456/50','2018-05-14','2018-11-30',6350000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(16,'OFFER016','2018-05-15',16,'NSD','HP','70087','70087-001','PR-456/50','2018-05-15','2018-11-30',6450000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(17,'OFFER017','2018-05-16',17,'NSD','HP','70085','70085-001','PR-80/10','2018-05-16','2018-11-30',7250000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(18,'OFFER018','2018-05-17',18,'NSD','HP','70085','70085-002','PR-80/10','2018-05-17','2018-11-30',7250000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(19,'OFFER019','2018-05-18',19,'NSD','HP','70086','70086-001','PR-80/10','2018-05-18','2018-11-30',7350000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:38','fromansyah','2018-11-09 18:25:38'),(20,'OFFER020','2018-05-19',20,'NSD','HP','70087','70087-001','PR-80/10','2018-05-19','2018-11-30',7450000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:39','fromansyah','2018-11-09 18:25:39'),(21,'OFFER021','2018-05-20',21,'SSA','HP','70085','70085-001','RH-30/50','2018-05-20','2018-11-30',8250000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:39','fromansyah','2018-11-09 18:25:39'),(22,'OFFER022','2018-05-21',22,'SSA','HP','70085','70085-002','RH-30/50','2018-05-21','2018-11-30',8250000,3,'IDR',0,'','fromansyah','2018-11-09 18:25:39','fromansyah','2018-11-09 18:25:39'),(23,'OFFER023','2018-05-22',23,'SSA','HP','70086','70086-001','RH-30/50','2018-05-22','2018-11-30',8350000,1,'IDR',0,'','fromansyah','2018-11-09 18:25:39','fromansyah','2018-11-09 18:25:39'),(24,'OFFER024','2018-05-23',24,'SSA','HP','70087','70087-001','RH-30/50','2018-05-23','2018-11-30',8450000,2,'IDR',0,'','fromansyah','2018-11-09 18:25:39','fromansyah','2018-11-09 18:25:39');
/*!40000 ALTER TABLE `agreement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cam`
--

DROP TABLE IF EXISTS `cam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cam` (
  `cam_id` varchar(20) NOT NULL,
  `cam_name` varchar(100) NOT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`cam_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cam`
--

LOCK TABLES `cam` WRITE;
/*!40000 ALTER TABLE `cam` DISABLE KEYS */;
INSERT INTO `cam` VALUES ('DS','Dyah Soewito','Test Input Data.\r\n','fromansyah','2018-10-25 20:11:35','fromansyah','2018-10-25 20:11:35'),('HP','Hasto Prabowo','Test input data edit.','fromansyah','2018-10-25 20:04:16','fromansyah','2018-10-25 20:04:39'),('IEA','Ira Eddymurthy Andamara','Test Input\r\n','fromansyah','2018-10-25 20:09:31','fromansyah','2018-10-25 20:09:31');
/*!40000 ALTER TABLE `cam` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(11) NOT NULL,
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `corporate`
--

DROP TABLE IF EXISTS `corporate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `corporate` (
  `corp_id` varchar(20) NOT NULL,
  `corp_name` varchar(100) NOT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`corp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `corporate`
--

LOCK TABLES `corporate` WRITE;
/*!40000 ALTER TABLE `corporate` DISABLE KEYS */;
INSERT INTO `corporate` VALUES ('ABC','PT. ABC Setia','Corporate abc.','fromansyah','2018-11-07 09:47:40','fromansyah','2018-11-07 09:47:40'),('AI','PT. Anda Indonesia','Corporate ai.','fromansyah','2018-11-07 09:47:40','fromansyah','2018-11-07 09:47:40'),('XYZ','PT. XYZ Abadi Jaya','Test input data.','fromansyah','2018-11-07 09:47:40','fromansyah','2018-11-07 09:47:40');
/*!40000 ALTER TABLE `corporate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cust_site`
--

DROP TABLE IF EXISTS `cust_site`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cust_site` (
  `site_id` varchar(20) NOT NULL,
  `cust_id` varchar(20) NOT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`site_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cust_site`
--

LOCK TABLES `cust_site` WRITE;
/*!40000 ALTER TABLE `cust_site` DISABLE KEYS */;
INSERT INTO `cust_site` VALUES ('70085-001','70085','Jl. Jend. Sudirman Kav. 60 Jakarta Selatan 12920 Indonesia','fromansyah','2018-11-07 10:16:54','fromansyah','2018-11-07 10:16:54'),('70085-002','70085','Jl. Panjang No. 110 Jakarta','fromansyah','2018-11-07 10:16:55','fromansyah','2018-11-07 10:16:55'),('70086-001','70086','Jl. Panglima Polim No. 10 Jakarta','fromansyah','2018-11-07 10:16:55','fromansyah','2018-11-07 10:16:55'),('70087-001','70087','Jl. Kebayoran Lama No. 12 Jakarta','fromansyah','2018-11-07 10:16:55','fromansyah','2018-11-07 10:16:55');
/*!40000 ALTER TABLE `cust_site` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `cust_id` varchar(20) NOT NULL,
  `corp_id` varchar(20) DEFAULT NULL,
  `cust_name` varchar(100) NOT NULL,
  `cust_type` varchar(20) NOT NULL,
  `bu` varchar(20) DEFAULT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`cust_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES ('70085','ABC','PT. ABC Setia','CA','Mining','Note.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29'),('70086','AI','PT. Anda Indonesia','CA','Mining','Note dua.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29'),('70087','','Customer Kita','Street','Heavy','Note tiga.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29'),('70088','XYZ','PT. XYZ Abadi Jaya','CA','Mining','Tidak ada note.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29'),('70089','','PT. Maju','Street','Paper','Note belum ada.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29'),('70090','','PT. Sejahtera','Street','Paper','Note sedang dikerjakan.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29'),('70091','','PT. Setia','Street','Paper','Notenya ini.','fromansyah','2018-11-07 10:02:29','fromansyah','2018-11-07 10:02:29');
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dyn_groups`
--

DROP TABLE IF EXISTS `dyn_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dyn_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(20) NOT NULL,
  `abbrev` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dyn_groups`
--

LOCK TABLES `dyn_groups` WRITE;
/*!40000 ALTER TABLE `dyn_groups` DISABLE KEYS */;
INSERT INTO `dyn_groups` VALUES (1,'Header','header'),(2,'Sidebar','sidebar'),(3,'Footer','footer'),(4,'Topbar','topbar'),(5,'Sidebar 1','sidebar 1'),(6,'Sidebar 2','sidebar 2');
/*!40000 ALTER TABLE `dyn_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dyn_menu`
--

DROP TABLE IF EXISTS `dyn_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dyn_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `link_type` varchar(20) NOT NULL,
  `page_id` int(11) NOT NULL,
  `module_name` varchar(100) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `uri` varchar(100) DEFAULT NULL,
  `dyn_group_id` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `target` varchar(100) DEFAULT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `is_parent` int(11) NOT NULL DEFAULT '0',
  `show_menu` bit(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dyn_menu`
--

LOCK TABLES `dyn_menu` WRITE;
/*!40000 ALTER TABLE `dyn_menu` DISABLE KEYS */;
INSERT INTO `dyn_menu` VALUES (1,'Home','page',1,NULL,'Menu_utama',NULL,1,0,NULL,0,0,''),(3,'Product','page',2,NULL,'Product',NULL,1,0,NULL,0,0,''),(4,'Corporate','page',3,NULL,'Corporate',NULL,1,0,NULL,0,0,''),(5,'Customer','page',4,NULL,'Customer',NULL,1,0,NULL,0,0,''),(6,'Sales Person','page',5,NULL,'Sales_person',NULL,1,0,NULL,0,0,'\0'),(7,'CAM','page',6,NULL,'Cam',NULL,1,0,NULL,0,0,'\0'),(8,'Plan','page',7,NULL,'Plan',NULL,1,0,NULL,0,0,''),(9,'Agreement','page',8,NULL,'Agreement',NULL,1,0,NULL,0,0,''),(10,'Sales','page',9,NULL,'Sales',NULL,1,0,NULL,0,0,''),(11,'Master Data','page',10,NULL,NULL,NULL,1,0,NULL,0,0,''),(12,'Master Data Type','page',11,NULL,'Master_data_type',NULL,1,0,NULL,11,0,''),(13,'User','page',14,NULL,'User',NULL,1,0,NULL,0,0,''),(14,'Menu','page',13,NULL,'Dyn_menu',NULL,1,0,NULL,11,0,''),(15,'Report','page',12,NULL,'Report',NULL,1,0,NULL,0,0,''),(16,'Change Password','page',15,NULL,'User/change_password',NULL,1,0,NULL,0,0,''),(17,'Periode','page',16,NULL,'Periode',NULL,1,0,NULL,11,0,''),(18,'Employee','page',5,NULL,'Employee',NULL,1,0,NULL,0,0,''),(19,'Role','page',17,NULL,'Role',NULL,1,0,NULL,11,0,''),(20,'Backup','page',18,NULL,'Backup_db',NULL,1,0,NULL,0,0,'');
/*!40000 ALTER TABLE `dyn_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employee`
--

DROP TABLE IF EXISTS `employee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employee` (
  `emp_id` varchar(20) NOT NULL,
  `emp_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(100) NOT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`emp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employee`
--

LOCK TABLES `employee` WRITE;
/*!40000 ALTER TABLE `employee` DISABLE KEYS */;
INSERT INTO `employee` VALUES ('CR','Chaidir Robiansyah','c.robiansyah@gmail.com','CAM','','fromansyah','2018-11-07 10:30:40','fromansyah','2018-11-07 10:30:40'),('FRO','Firat Romansyah','firat.romansyah@gmail.com','SP','','fromansyah','2018-11-07 10:30:40','fromansyah','2018-11-07 10:30:40'),('HP','Hasto Prabowo','h.prabowo@gmail.com','CAM','','fromansyah','2018-11-07 10:30:40','fromansyah','2018-11-07 10:30:40'),('NSD','Natalia Shinta Dewi','shinta@gmail.com','SP','','fromansyah','2018-11-07 10:30:40','fromansyah','2018-11-07 10:30:40'),('SSA','Sandy Sri Agustina','s.agustina@gmail.com','SP','','fromansyah','2018-11-07 10:30:40','fromansyah','2018-11-07 10:30:40');
/*!40000 ALTER TABLE `employee` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_data`
--

DROP TABLE IF EXISTS `master_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(150) NOT NULL DEFAULT '',
  `name` varchar(150) NOT NULL,
  `value` varchar(11) NOT NULL DEFAULT '0',
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_data`
--

LOCK TABLES `master_data` WRITE;
/*!40000 ALTER TABLE `master_data` DISABLE KEYS */;
INSERT INTO `master_data` VALUES (1,'BA_TYPE','Usage','1','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(2,'BA_TYPE','Use - Risk','2','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(3,'BA_TYPE','Ship and Bill','3','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(4,'BU_TYPE','Heavy','Heavy','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),(5,'BU_TYPE','Light','Light','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),(6,'BU_TYPE','Mining','Mining','System','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),(7,'BU_TYPE','Paper','Paper','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),(8,'CUST_TYPE','CA','CA','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),(9,'CUST_TYPE','Street','Street','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),(10,'POSITION','Sales Person','SP','system','2018-10-31 00:00:00','system','2018-10-31 00:00:00'),(11,'POSITION','CAM','CAM','system','2018-10-31 00:00:00','system','2018-10-31 00:00:00'),(12,'POSITION','Marketing','M','system','2018-10-31 00:00:00','system','2018-10-31 00:00:00');
/*!40000 ALTER TABLE `master_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_data_type`
--

DROP TABLE IF EXISTS `master_data_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `master_data_type` (
  `type` varchar(150) NOT NULL DEFAULT '',
  `type_name` varchar(150) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_data_type`
--

LOCK TABLES `master_data_type` WRITE;
/*!40000 ALTER TABLE `master_data_type` DISABLE KEYS */;
INSERT INTO `master_data_type` VALUES ('BA_TYPE','BA_TYPE','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),('BU_TYPE','BU_TYPE','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),('CUST_TYPE','CUST_TYPE','system','2018-10-24 00:00:00','system','2018-10-24 00:00:00'),('POSITION','POSITION','system','2018-10-31 00:00:00','system','2018-10-31 00:00:00');
/*!40000 ALTER TABLE `master_data_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periode`
--

DROP TABLE IF EXISTS `periode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periode` (
  `periode_id` int(11) NOT NULL AUTO_INCREMENT,
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`periode_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periode`
--

LOCK TABLES `periode` WRITE;
/*!40000 ALTER TABLE `periode` DISABLE KEYS */;
INSERT INTO `periode` VALUES (1,'2015-01-12','2100-11-30','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00');
/*!40000 ALTER TABLE `periode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `periode_detail`
--

DROP TABLE IF EXISTS `periode_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `periode_detail` (
  `periode_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `periode_id` int(11) NOT NULL,
  `periode_num` int(11) NOT NULL,
  `month` char(2) NOT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`periode_detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `periode_detail`
--

LOCK TABLES `periode_detail` WRITE;
/*!40000 ALTER TABLE `periode_detail` DISABLE KEYS */;
INSERT INTO `periode_detail` VALUES (0,1,1,'12','system','2018-10-29 00:00:00','fromansyah','2018-10-26 09:39:20'),(2,1,2,'01','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(3,1,3,'02','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(4,1,4,'03','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(5,1,5,'04','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(6,1,6,'05','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(7,1,7,'06','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(8,1,8,'07','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(9,1,9,'08','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(10,1,10,'09','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(11,1,11,'10','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(12,1,12,'11','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00');
/*!40000 ALTER TABLE `periode_detail` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan` (
  `plan_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_no` varchar(20) NOT NULL,
  `price_id` int(11) DEFAULT NULL,
  `cust_site` varchar(20) NOT NULL,
  `cust_no` varchar(20) NOT NULL,
  `sp_id` varchar(20) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `implementation_periode_year` int(11) DEFAULT NULL,
  `implementation_periode_month` int(2) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`plan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan`
--

LOCK TABLES `plan` WRITE;
/*!40000 ALTER TABLE `plan` DISABLE KEYS */;
INSERT INTO `plan` VALUES (1,'PM-88/90',9,'70085-001','70085','FRO','2017-12-01','2018-11-30',2150000,2018,1,'fromansyah','2018-11-08 09:08:45','fromansyah','2018-11-08 09:08:45'),(2,'PM-88/90',9,'70085-002','70085','FRO','2017-12-01','2018-11-30',2150000,2018,1,'fromansyah','2018-11-08 09:08:45','fromansyah','2018-11-08 09:08:45'),(3,'PM-88/90',9,'70086-001','70086','FRO','2017-12-01','2018-11-30',2150000,2018,1,'fromansyah','2018-11-08 09:08:45','fromansyah','2018-11-08 09:08:45'),(4,'PM-88/90',9,'70087-001','70087','FRO','2017-12-01','2018-11-30',2150000,2018,1,'fromansyah','2018-11-08 09:08:45','fromansyah','2018-11-08 09:08:45'),(5,'PM-99/90',10,'70085-001','70085','FRO','2017-12-01','2018-11-30',3150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(6,'PM-99/90',10,'70085-002','70085','FRO','2017-12-01','2018-11-30',3150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(7,'PM-99/90',10,'70086-001','70086','FRO','2017-12-01','2018-11-30',3150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(8,'PM-99/90',10,'70087-001','70087','FRO','2017-12-01','2018-11-30',3150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(9,'PR-10/30',11,'70085-001','70085','FRO','2017-12-01','2018-11-30',4150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(10,'PR-10/30',11,'70085-002','70085','FRO','2017-12-01','2018-11-30',4150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(11,'PR-10/30',11,'70086-001','70086','FRO','2017-12-01','2018-11-30',4150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(12,'PR-10/30',11,'70087-001','70087','FRO','2017-12-01','2018-11-30',4150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(13,'PR-456/50',13,'70085-001','70085','NSD','2017-12-01','2018-11-30',6150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(14,'PR-456/50',13,'70085-002','70085','NSD','2017-12-01','2018-11-30',6150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(15,'PR-456/50',13,'70086-001','70086','NSD','2017-12-01','2018-11-30',6150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(16,'PR-456/50',13,'70087-001','70087','NSD','2017-12-01','2018-11-30',6150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(17,'PR-80/10',14,'70085-001','70085','NSD','2017-12-01','2018-11-30',7150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(18,'PR-80/10',14,'70085-002','70085','NSD','2017-12-01','2018-11-30',7150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(19,'PR-80/10',14,'70086-001','70086','NSD','2017-12-01','2018-11-30',7150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(20,'PR-80/10',14,'70087-001','70087','NSD','2017-12-01','2018-11-30',7150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(21,'RH-30/50',15,'70085-001','70085','SSA','2017-12-01','2018-11-30',8150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(22,'RH-30/50',15,'70085-002','70085','SSA','2017-12-01','2018-11-30',8150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(23,'RH-30/50',15,'70086-001','70086','SSA','2017-12-01','2018-11-30',8150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(24,'RH-30/50',15,'70087-001','70087','SSA','2017-12-01','2018-11-30',8150000,2018,1,'fromansyah','2018-11-08 09:08:46','fromansyah','2018-11-08 09:08:46'),(25,'PM-88/90',NULL,'70085-001','70085','FRO','2018-12-01','2019-11-30',2500000,2019,1,'fromansyah','2018-11-15 05:48:13','fromansyah','2018-11-15 05:48:13');
/*!40000 ALTER TABLE `plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product` (
  `product_no` varchar(20) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `kg_pail` decimal(10,2) DEFAULT NULL,
  `desc` varchar(500) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`product_no`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product`
--

LOCK TABLES `product` WRITE;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` VALUES ('DR-10/20','Product 8',50.00,'Product Number 8','fromansyah','2018-11-16 04:58:45','fromansyah','2018-11-16 04:58:45'),('PM-88/90','Product 2',25.00,'Product Number 2.','system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),('PM-99/90','Product 3',25.00,'Product Number 3.\r\n','fromansyah','2018-10-23 05:01:31','fromansyah','2018-10-23 05:01:31'),('PR-10/30','Product 7',25.00,'Product Number 7.','fromansyah','2018-11-07 08:27:05','fromansyah','2018-11-07 08:27:05'),('PR-456/45','Product 1',25.00,'Product Number 1.','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),('PR-456/50','Product 6',25.00,'Product Number 6.','fromansyah','2018-11-07 08:27:05','fromansyah','2018-11-07 08:27:05'),('PR-80/10','Product 5',25.00,'Product Number 5.\r\n','fromansyah','2018-10-23 05:12:57','fromansyah','2018-10-23 05:12:57'),('RH-30/50','Product 4',25.00,'Product Number 4.\r\n','fromansyah','2018-10-23 05:01:31','fromansyah','2018-10-23 05:01:31');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_price`
--

DROP TABLE IF EXISTS `product_price`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_price` (
  `price_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_no` varchar(20) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `catalogue_price` decimal(10,0) DEFAULT NULL,
  `periode_year` int(11) DEFAULT NULL,
  `periode_month` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`price_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_price`
--

LOCK TABLES `product_price` WRITE;
/*!40000 ALTER TABLE `product_price` DISABLE KEYS */;
INSERT INTO `product_price` VALUES (1,'PM-88/90','2017-12-01','2018-12-31',1000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:02:57'),(2,'PM-99/90','2017-12-01','2018-12-31',2000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:02:57'),(3,'PR-10/30','2017-12-01','2018-12-31',3000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:02:57'),(4,'PR-456/45','2017-12-01','2018-05-31',4000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:10:34'),(5,'PR-456/50','2017-12-01','2018-12-31',5000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:02:57'),(6,'PR-80/10','2017-12-01','2018-12-31',6000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:02:57'),(7,'RH-30/50','2017-12-01','2018-12-31',7000000,2017,1,'fromansyah','2018-11-07 09:02:57','fromansyah','2018-11-07 09:02:57'),(8,'PR-456/45','2018-06-01','2018-12-31',4500000,2018,7,'fromansyah','2018-11-07 09:11:28','fromansyah','2018-11-07 09:11:28'),(9,'PM-88/90','2017-12-01','2018-05-31',2000000,2018,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-08 07:57:16'),(10,'PM-99/90','2019-01-01','2019-12-31',3000000,2018,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-07 09:14:05'),(11,'PR-10/30','2019-01-01','2019-12-31',4000000,2018,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-07 09:14:05'),(12,'PR-456/45','2019-01-01','2019-12-31',5000000,2019,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-07 09:14:05'),(13,'PR-456/50','2019-01-01','2019-12-31',6000000,2018,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-07 09:14:05'),(14,'PR-80/10','2019-01-01','2019-12-31',7000000,2018,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-07 09:14:05'),(15,'RH-30/50','2019-01-01','2019-12-31',8000000,2018,1,'fromansyah','2018-11-07 09:14:05','fromansyah','2018-11-07 09:14:05'),(16,'PM-88/90','2018-06-01','2018-12-31',2500000,2018,7,'fromansyah','2018-11-08 07:56:35','fromansyah','2018-11-08 07:56:35');
/*!40000 ALTER TABLE `product_price` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `url` varchar(200) NOT NULL,
  `group` int(11) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
INSERT INTO `report` VALUES (1,'Product List Report','product_list_report.rptdesign',1,'fromansyah','2018-10-26 09:47:07','fromansyah','2018-10-26 11:02:58');
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role` varchar(100) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(50) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (1,'ADMIN','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(2,'USER','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_menu`
--

DROP TABLE IF EXISTS `role_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_by` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(50) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_menu`
--

LOCK TABLES `role_menu` WRITE;
/*!40000 ALTER TABLE `role_menu` DISABLE KEYS */;
INSERT INTO `role_menu` VALUES (1,1,1,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(2,1,3,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(3,1,4,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(4,1,5,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(5,1,6,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(6,1,7,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(7,1,8,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(8,1,9,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(9,1,10,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(10,1,11,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(11,1,12,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(12,1,13,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(13,1,14,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(14,1,15,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(15,1,16,'system','2018-10-23 00:00:00','system','2018-10-23 00:00:00'),(16,1,18,'system','2018-10-31 00:00:00','system','2018-10-31 00:00:00'),(17,1,20,'system','2018-11-16 00:00:00','system','2018-11-16 00:00:00');
/*!40000 ALTER TABLE `role_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sale`
--

DROP TABLE IF EXISTS `sale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sale` (
  `sale_id` int(11) NOT NULL AUTO_INCREMENT,
  `agreement_id` int(11) DEFAULT NULL,
  `product_no` varchar(20) DEFAULT NULL,
  `quantity` decimal(12,2) DEFAULT NULL,
  `currency` char(3) DEFAULT NULL,
  `rate` decimal(12,2) DEFAULT NULL,
  `price` decimal(12,2) DEFAULT NULL,
  `total` decimal(12,2) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `cust_no` varchar(20) DEFAULT NULL,
  `site_id` varchar(20) DEFAULT NULL,
  `sp_id` varchar(20) DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sale_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sale`
--

LOCK TABLES `sale` WRITE;
/*!40000 ALTER TABLE `sale` DISABLE KEYS */;
INSERT INTO `sale` VALUES (1,1,'PM-88/90',20.00,'IDR',0.00,2250000.00,45000000.00,'2018-11-13','70085','70085-001','FRO','fromansyah','2018-11-13 09:53:22','fromansyah','2018-11-13 09:53:22'),(2,1,'PM-88/90',10.00,'IDR',0.00,2250000.00,22500000.00,'2018-11-12','70085','70085-001','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(3,2,'PM-88/90',20.00,'IDR',0.00,2250000.00,45000000.00,'2018-11-12','70085','70085-002','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(4,3,'PM-88/90',30.00,'IDR',0.00,2350000.00,70500000.00,'2018-11-12','70086','70086-001','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(5,4,'PM-88/90',40.00,'IDR',0.00,2350000.00,94000000.00,'2018-11-12','70087','70087-001','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(6,5,'PM-99/90',50.00,'IDR',0.00,3250000.00,162500000.00,'2018-11-12','70085','70085-001','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(7,6,'PM-99/90',60.00,'IDR',0.00,3250000.00,195000000.00,'2018-11-12','70085','70085-002','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(8,7,'PM-99/90',70.00,'IDR',0.00,3350000.00,234500000.00,'2018-11-12','70086','70086-001','FRO','fromansyah','2018-11-14 08:41:08','fromansyah','2018-11-14 08:41:08'),(9,8,'PM-99/90',80.00,'IDR',0.00,3450000.00,276000000.00,'2018-11-12','70087','70087-001','FRO','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(10,9,'PR-10/30',90.00,'IDR',0.00,4250000.00,382500000.00,'2018-11-12','70085','70085-001','FRO','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(11,10,'PR-10/30',10.00,'IDR',0.00,4250000.00,42500000.00,'2018-11-12','70085','70085-002','FRO','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(12,11,'PR-10/30',20.00,'IDR',0.00,4350000.00,87000000.00,'2018-11-12','70086','70086-001','FRO','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(13,12,'PR-10/30',30.00,'IDR',0.00,4450000.00,133500000.00,'2018-11-12','70087','70087-001','FRO','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(14,13,'PR-456/50',40.00,'IDR',0.00,6250000.00,250000000.00,'2018-11-12','70085','70085-001','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(15,14,'PR-456/50',50.00,'IDR',0.00,6250000.00,312500000.00,'2018-11-12','70085','70085-002','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(16,15,'PR-456/50',60.00,'IDR',0.00,6350000.00,381000000.00,'2018-11-12','70086','70086-001','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(17,16,'PR-456/50',70.00,'IDR',0.00,6450000.00,451500000.00,'2018-11-12','70087','70087-001','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(18,17,'PR-80/10',80.00,'IDR',0.00,7250000.00,580000000.00,'2018-11-12','70085','70085-001','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(19,18,'PR-80/10',90.00,'IDR',0.00,7250000.00,652500000.00,'2018-11-12','70085','70085-002','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(20,19,'PR-80/10',10.00,'IDR',0.00,7350000.00,73500000.00,'2018-11-12','70086','70086-001','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(21,20,'PR-80/10',20.00,'IDR',0.00,7450000.00,149000000.00,'2018-11-12','70087','70087-001','NSD','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(22,21,'RH-30/50',30.00,'IDR',0.00,8250000.00,247500000.00,'2018-11-12','70085','70085-001','SSA','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(23,22,'RH-30/50',40.00,'IDR',0.00,8250000.00,330000000.00,'2018-11-12','70085','70085-002','SSA','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(24,23,'RH-30/50',50.00,'IDR',0.00,8350000.00,417500000.00,'2018-11-12','70086','70086-001','SSA','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09'),(25,24,'RH-30/50',60.00,'IDR',0.00,8450000.00,507000000.00,'2018-11-12','70087','70087-001','SSA','fromansyah','2018-11-14 08:41:09','fromansyah','2018-11-14 08:41:09');
/*!40000 ALTER TABLE `sale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_person`
--

DROP TABLE IF EXISTS `sales_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_person` (
  `sp_id` varchar(20) NOT NULL,
  `sp_name` varchar(100) NOT NULL,
  `note` text,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sp_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_person`
--

LOCK TABLES `sales_person` WRITE;
/*!40000 ALTER TABLE `sales_person` DISABLE KEYS */;
INSERT INTO `sales_person` VALUES ('FR','Futuhur Rochman','Test input data.\r\n','fromansyah','2018-10-25 17:55:24','fromansyah','2018-10-25 17:55:24'),('FRO','Firat Romansyah','Test update.','fromansyah','2018-10-25 17:46:05','fromansyah','2018-10-25 17:46:11'),('NS','Natalia Shinta','Test juga\r\n','fromansyah','2018-10-25 17:53:59','fromansyah','2018-10-25 17:53:59'),('SSA','Sandy Sri Agustina','Test Input\r\n','fromansyah','2018-10-25 17:53:59','fromansyah','2018-10-25 17:53:59');
/*!40000 ALTER TABLE `sales_person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `fullname` varchar(150) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` int(11) NOT NULL DEFAULT '0',
  `user_group` varchar(10) NOT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `created_date` datetime DEFAULT NULL,
  `last_update_by` varchar(20) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'Firat Romansyah','firat.romansyah@gmail.com','fromansyah','04722c4e7b0c8cca8e31b4f0f909a023',1,'ADMIN','system','2018-10-22 00:00:00','system','2018-10-22 00:00:00'),(2,'Dyah Kirana','dyah.kirana@gmail.com','dkirana','dd32aad11fad5e004d9805324f3e2c24',1,'ADMIN','fromansyah','2018-10-25 20:29:52','dkirana','2018-10-25 20:36:42');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-11-16 14:12:14
