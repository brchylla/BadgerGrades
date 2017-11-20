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
-- Table structure for table `graded_item_type`
--

DROP TABLE IF EXISTS `graded_item_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `graded_item_type` (
  `GradedItemTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `GradedItemType` varchar(45) NOT NULL,
  `PortionOfGrade` decimal(3,2) NOT NULL,
  `CourseID` int(11) NOT NULL,
  PRIMARY KEY (`GradedItemTypeID`),
  KEY `CourseID_idx` (`CourseID`),
  CONSTRAINT `CourseID` FOREIGN KEY (`CourseID`) REFERENCES `class` (`CourseID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `graded_item_type`
--

LOCK TABLES `graded_item_type` WRITE;
/*!40000 ALTER TABLE `graded_item_type` DISABLE KEYS */;
INSERT INTO `graded_item_type` VALUES (1,'Exams',0.56,1),(2,'Labs',0.24,1),(3,'Quizzes',0.10,1),(4,'Homework',0.07,1),(5,'Lab Final',0.02,1),(6,'Participation',0.01,1),(7,'Assignment',0.50,2),(8,'Test',0.30,2),(9,'Quiz',0.05,2),(10,'InClass Quiz',0.10,2),(11,'Participation',0.05,2),(12,'Assignment',0.50,3),(13,'Blog',0.10,3),(14,'Information Literacy assignments',0.15,3),(15,'Information Literacy quizzes',0.05,3),(16,'Class Participation',0.10,3),(17,'Final Draft Team Project & Presentation',0.10,3),(18,'Participation',0.20,4),(19,'Assignments',0.40,4),(20,'Exams',0.40,4),(21,'Overall Grade',1.00,5),(22,'Overall Grade',1.00,6),(23,'Overall Grade',1.00,7),(24,'Overall Grade',1.00,8),(25,'Overall Grade',1.00,9),(26,'Overall Grade',1.00,10),(27,'Overall Grade',1.00,11),(28,'Overall Grade',1.00,12),(29,'Overall Grade',1.00,13),(31,'Overall Grade',1.00,14),(32,'Overall Grade',1.00,15),(33,'Overall Grade',1.00,16),(34,'Overall Grade',1.00,17),(35,'Quizzes',0.10,18),(36,'Midterm Exams',0.30,18),(37,'Participation',0.10,18),(38,'Group Country Research Project',0.15,18),(39,'Group Country Presentation',0.05,18),(40,'Problem Sets',0.15,18),(41,'Final Exam ',0.15,18),(42,'Discussions',0.05,19),(43,'Blog',0.05,19),(44,'Exams',0.15,19),(45,'Assignments & Quizzes',0.25,19),(46,'Group Topic Discussion',0.05,19),(47,'Final Research Project',0.15,19),(48,'Class Participation',0.05,19),(49,'In-Class activities/Hands On',0.25,19),(50,'Overall Grade',1.00,21),(51,'Overall Grade',1.00,22),(52,'Overall Grade',1.00,23),(53,'Mid-term test',0.15,20),(54,'Assignments',0.15,20),(55,'Team Client Project',0.25,20),(56,'Individual Project',0.25,20),(57,'In-Class Activities',0.10,20),(58,'Class Participation',0.10,20),(59,'Overall Grade',1.00,24),(60,'Homeworks',0.30,25),(61,'Midterms',0.70,25),(71,'Homework Assignments',0.39,27),(73,'Exams',0.60,27),(74,'Participation',0.01,27),(81,'Tests',0.15,30),(82,'Oral Midterm',0.10,30),(83,'Written Midterm',0.15,30),(84,'Oral Final',0.10,30),(85,'Written Final',0.15,30),(86,'Homework/Quiz',0.15,30),(87,'Participation',0.05,30),(88,'Attendance',0.05,30),(89,'Writing Assignments',0.10,30),(90,'WisCEL Exercises',0.10,31),(91,'WHWs: Written Homeworks',0.20,31),(92,'AHWs: Applied Homeworks',0.15,31),(94,'Quizzes',0.10,32),(95,'Projects',0.40,32),(96,'Exams',0.40,32),(97,'Participation',0.10,32),(98,'Essay',0.40,33),(99,'Midterm Exam',0.20,33),(100,'Final Exam',0.20,33),(101,'Attendance',0.10,33),(102,'Participation',0.10,33),(103,'Homework',0.10,34),(104,'Quiz',0.10,34),(105,'Midterm',0.50,34),(106,'Final Exam',0.30,34),(107,'Overall Grade',1.00,28);
/*!40000 ALTER TABLE `graded_item_type` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-27  1:01:05
