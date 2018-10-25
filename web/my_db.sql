-- MySQL dump 10.13  Distrib 5.5.53, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: my_db
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

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
-- Table structure for table `led_rgb`
--

DROP TABLE IF EXISTS `led_rgb`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `led_rgb` (
  `id` int(11) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `address` varchar(15) DEFAULT NULL,
  `blink_option` int(11) DEFAULT NULL,
  `value` varchar(40) DEFAULT NULL,
  `value1` varchar(40) DEFAULT NULL,
  `value2` varchar(40) DEFAULT NULL,
  `auto1` int(11) DEFAULT NULL,
  `auto2` int(11) DEFAULT NULL,
  `blink_option1` int(11) DEFAULT NULL,
  `blink_option2` int(11) DEFAULT NULL,
  `on1` varchar(40) DEFAULT NULL,
  `on2` varchar(40) DEFAULT NULL,
  `off1` varchar(40) DEFAULT NULL,
  `off2` varchar(40) DEFAULT NULL,
  `day1` varchar(40) DEFAULT NULL,
  `day2` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `led_rgb`
--

LOCK TABLES `led_rgb` WRITE;
/*!40000 ALTER TABLE `led_rgb` DISABLE KEYS */;
INSERT INTO `led_rgb` VALUES (1,'test',1,'192.168.0.153',7,'E2BD19,658500,331D0A,720860,45FF40','194EE2,658500,331D0A,720860,45FF40','000000,aaa500,441DFF,257228,54dee8',0,0,1,1,'21:15','22:10:00','21:09','22:40:00','Fri','Sun'),(2,'test2',0,'192.168.0.152',1,'33E7D8,aaa500,000000,720860,54dee8','000000,aaa500,000000,720860,54dee8','e74040,aaa500,0ee235,720860,54dee8',0,0,1,1,'02:00:00','15:10:00','03:10:00','15:40:00','Tue,Wed,Thu','Sun,Mon,Tue,Wed');
/*!40000 ALTER TABLE `led_rgb` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `switch`
--

DROP TABLE IF EXISTS `switch`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `switch` (
  `id` int(11) DEFAULT NULL,
  `value` int(11) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `enable` int(11) DEFAULT NULL,
  `address` int(11) DEFAULT NULL,
  `data` int(11) DEFAULT NULL,
  `auto_en` int(11) DEFAULT NULL,
  `auto_on` time DEFAULT NULL,
  `auto_off` time DEFAULT NULL,
  `auto_day` varchar(50) DEFAULT NULL,
  `auto_en2` int(11) DEFAULT NULL,
  `auto_on2` time DEFAULT NULL,
  `auto_off2` time DEFAULT NULL,
  `auto_day2` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `switch`
--

LOCK TABLES `switch` WRITE;
/*!40000 ALTER TABLE `switch` DISABLE KEYS */;
INSERT INTO `switch` VALUES (1,1,'House14 - Second Hall Light',1,1,1,1,'12:10:00','12:30:00','Tue,Wed',0,'22:50:00','23:35:00','Mon,Tue'),(2,0,'House14 - Dining Hall Light',1,1,2,0,'03:59:00','23:50:00','Sun,Mon,Thu,Fri,Sat',0,'12:10:10','00:23:00','Fri');
/*!40000 ALTER TABLE `switch` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-15 12:22:55
