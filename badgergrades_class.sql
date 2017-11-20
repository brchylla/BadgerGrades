CREATE DATABASE  IF NOT EXISTS `badgergrades` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `badgergrades`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 127.0.0.1    Database: badgergrades
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `class`
--

DROP TABLE IF EXISTS `class`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `class` (
  `CourseID` int(11) NOT NULL AUTO_INCREMENT,
  `CourseCode` varchar(45) NOT NULL,
  `CourseName` varchar(90) NOT NULL,
  `Schedule` varchar(45) DEFAULT NULL,
  `Instructor` varchar(45) DEFAULT NULL,
  `Credits` decimal(3,2) NOT NULL,
  `SemesterID` int(11) NOT NULL,
  `InstitutionID` int(11) NOT NULL,
  PRIMARY KEY (`CourseID`),
  KEY `SemesterID_idx` (`SemesterID`),
  KEY `InstitutionID_idx` (`InstitutionID`),
  CONSTRAINT `InstitutionID` FOREIGN KEY (`InstitutionID`) REFERENCES `institution` (`InstitutionID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `SemesterID` FOREIGN KEY (`SemesterID`) REFERENCES `semester` (`SemesterID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `class`
--

LOCK TABLES `class` WRITE;
/*!40000 ALTER TABLE `class` DISABLE KEYS */;
INSERT INTO `class` VALUES (1,'CHEM 110','Intro to Chemistry','MoWe 8:30 am - 9:50 pm, Tu 1:00 pm - 4:50 pm','Kretchmar, David',4.00,2,1),(2,'CS 180','Intro to Computing and Programming','MoWe 2:00 pm-3:50 pm','Alexandrian, Greg',4.00,5,1),(3,'CS 150','Digital Life Through Multimedia','MoWeFr 9:00 am-9:50 am','Doyd, Nathan',3.00,5,1),(4,'COMMS 100','Introduction to Communication','MoWeFr 3:00 pm-3:50 pm','Liang, Xuan',3.00,3,1),(5,'CS 270','Introduction to Database Structures','MoWe 4:00 pm-5:50 pm','Khasawneh, Samer',4.00,4,1),(6,'MATH 121','Statistics','MoWeFr 9:00 am-9:50 am','Post, Steven',3.00,4,1),(7,'MATH 232','Calculus II','MoTuThFr 12:00 pm-12:50 pm','Post, Steven',4.00,4,1),(8,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,4,1),(9,'PHIL 104','Ethics','TuTh 2:00 pm-3:20 pm','Kavaloski, Vincent',3.00,4,1),(10,'PHIL 117','Eagles Debate Team','Fr 4:00 pm-6:00 pm','Mortensen, Daniel',1.00,4,1),(11,'PHIL 101','Logic: Practice of Critical Thinking','TuTh 2:00 pm-3:20 pm','Hinds, Juli',3.00,5,1),(12,'ENG 111A-1C','Fairy Tales as Cultural Narratives','TuTh 10:00 am-11:50 am','Lacey, Lauren',4.00,5,1),(13,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,5,1),(14,'CS 301','Info Systems: Analysis & Design','MoWe 10:00 am-11:50 am','Khasawneh, Samer',4.00,3,1),(15,'CS 340','Introduction to Web Development','TuTh 2:00 pm-3:50 pm','Alexandrian, Greg',4.00,3,1),(16,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,3,1),(17,'PHIL 117','Eagles Debate Team','Fr 4:00 pm-6:00 pm','Mortensen, Daniel',1.00,3,1),(18,'ECON 240','Principles of Economics','TuTh 8:00 am-9:50 am','Belkis, Cerrato',4.00,2,1),(19,'CS 220','Introduction to Networking Tech','TuTh 10:00 am-11:50 am','Sinha, Atreyee',4.00,2,1),(20,'CS 302','Info Systems: Design & Implementation','MoWe 10:00 am-11:50 am','Khasawneh, Samer',4.00,2,1),(21,'MUS 310','Jazz Ensemble','Th 6:00 pm-8:00 pm','Wallach, Daniel',1.00,2,1),(22,'PHIL 117','Eagles Debate Team','Fr 4:00 pm-6:00 pm','Mortensen, Daniel',1.00,2,1),(23,'UWMADCLLB PRG','LINEAR ALG & DIFF EQUATIONS','','',3.00,3,1),(24,'MATH 320','Linear Algebra & Differential Equations','TuTh 9:30 am-10:45 am, Mo 1:20 pm-2:10 pm','Smith, Leslie & Sangari, Arash',3.00,3,2),(25,'CS 252','Intro to Computer Engineering','MoWeFr 11:00 am-11:50 am','Sankaralingam, Karu',2.00,1,2),(27,'CS 240 / MATH 240','Intro to Discrete Mathematics','TuTh 9:30 am-10:45 am, Mo 8:50 am-9:40 am','Hasti, Beck',3.00,1,2),(28,'CS 367','Intro to Data Structures','TuTh 1:00 pm-2:15 pm','Skrentny, James',3.00,1,2),(30,'SPANISH 102','Second Semester Spanish','MoTuWeThFr 2:25 pm-3:15 pm','Rios, Jeremy',4.00,1,2),(31,'CS 352','Digital System Fundamentals','MoWeFr 1:20 pm-2:10 pm, Tu 4:30 pm-6:20 pm','Zhang, Xinyu',3.00,6,2),(32,'CS 354','Machine Organization and Programming','MoWeFr 9:55 am-10:45 am','Rajendran, Ganesh',3.00,6,2),(33,'AFROAMER 231','Introduction to Afro-American Studies','TuTh 9:55 am-10:45 am','Clark-Pujara, Christy',3.00,6,2),(34,'MATH 234','Calculus: Functions of Variables','TuTh 1:00 pm-2:15 pm, Mo We 12:05 pm-12:55 pm','Mitchell, Julie',4.00,6,2);
/*!40000 ALTER TABLE `class` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-27  1:01:06
