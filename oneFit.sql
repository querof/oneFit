-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: oneFit
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.16.04.1

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
-- Table structure for table `excercises`
--

DROP TABLE IF EXISTS `excercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `excercises` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=992 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `excercises`
--

LOCK TABLES `excercises` WRITE;
/*!40000 ALTER TABLE `excercises` DISABLE KEYS */;
INSERT INTO `excercises` VALUES (980,'Curl',''),(981,'Press',''),(982,'Running',''),(983,'Triceps',''),(984,'Ex','Des. Ex'),(985,'excercises Test API Mod','Des Test API Mod'),(987,'Ex. Test API - 6472','Ex Des Test API - 6472'),(988,'Ex. Test API - 3800','Ex Des Test API - 3800'),(989,'Ex. Test API - 4759','Ex Des Test API - 4759'),(990,'Ex. Test API - 1991','Ex Des Test API - 1991'),(991,'Ex. Test API - 7267','Ex Des Test API - 7267');
/*!40000 ALTER TABLE `excercises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `plan`
--

DROP TABLE IF EXISTS `plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2331 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plan`
--

LOCK TABLES `plan` WRITE;
/*!40000 ALTER TABLE `plan` DISABLE KEYS */;
INSERT INTO `plan` VALUES (2311,'Advanced user',''),(2312,'Plan 2',''),(2313,'Advanced user',NULL),(2314,'Plan Test API Mod','Des Test API Mod'),(2316,'UserPlan Test API Delete','Des Test API Set'),(2317,'UserPlan Test API Delete','Des Test API Set'),(2318,'UserPlan Test API Delete','Des Test API Set'),(2319,'UserPlan Test API Delete','Des Test API Set'),(2320,'UserPlan Test API Delete','Des Test API Set'),(2321,'UserPlan Test API Delete','Des Test API Set'),(2322,'UserPlan Test API Delete','Des Test API Set'),(2323,'UserPlan Test API Delete','Des Test API Set'),(2324,'UserPlan Test API Delete','Des Test API Set'),(2325,'UserPlan Test API Delete','Des Test API Set'),(2326,'UserPlan Test API Delete','Des Test API Set'),(2327,'UserPlan Test API Delete','Des Test API Set'),(2328,'UserPlan Test API Delete','Des Test API Set'),(2329,'UserPlan Test API Delete','Des Test API Set'),(2330,'UserPlan Test API Delete','Des Test API Set');
/*!40000 ALTER TABLE `plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(33) CHARACTER SET utf8 DEFAULT NULL,
  `size` decimal(19,2) NOT NULL,
  `weight` decimal(19,0) NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=1421 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1386,'Frank','Quero','querof@gmail.com',170.00,80,'3b77923bc05401fce448035af88c809c',1),(1413,'User-4113','UserLastname-4113','querof4113@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL),(1414,'User-9049','UserLastname-9049','querof9049@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL),(1415,'User-6687','UserLastname-6687','querof6687@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL),(1416,'User-7124','UserLastname-7124','querof7124@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL),(1417,'User-3129','UserLastname-3129','querof3129@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL),(1418,'User-3799','UserLastname-3799','querof3799@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL),(1419,'User-2665','UserLastname-2665','querof2665@gmail.com',2.00,100,'81dc9bdb52d04dc20036dbd8313ed055',NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_plan`
--

DROP TABLE IF EXISTS `user_plan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_plan` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `userid` int(10) NOT NULL,
  `planid` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_user_plan` (`userid`),
  KEY `fk_plan_user_plan` (`planid`),
  CONSTRAINT `fk_plan_user_plan` FOREIGN KEY (`planid`) REFERENCES `plan` (`id`),
  CONSTRAINT `fk_user_user_plan` FOREIGN KEY (`userid`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=538 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_plan`
--

LOCK TABLES `user_plan` WRITE;
/*!40000 ALTER TABLE `user_plan` DISABLE KEYS */;
INSERT INTO `user_plan` VALUES (532,1386,2311),(533,1386,2312),(534,1414,2327),(535,1415,2328),(536,1416,2329);
/*!40000 ALTER TABLE `user_plan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workout_days`
--

DROP TABLE IF EXISTS `workout_days`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workout_days` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `planid` int(10) NOT NULL,
  `weekday` char(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_plan_workout_days` (`planid`),
  CONSTRAINT `fk_plan_workout_days` FOREIGN KEY (`planid`) REFERENCES `plan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=900 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workout_days`
--

LOCK TABLES `workout_days` WRITE;
/*!40000 ALTER TABLE `workout_days` DISABLE KEYS */;
INSERT INTO `workout_days` VALUES (889,'Chest','',2311,'MON'),(890,'Leg','',2311,'MON'),(891,'Day 1','',2312,'MON'),(892,'Leg Day - Get Test','Des. LegDay',2317,'MON'),(893,'workoutdays Test API Mod','Des Test API Mod',2319,'MON'),(895,'Workout Day - 6472','Des. - 6472',2321,'MON'),(896,'Workout Day - 3800','Des. - 3800',2322,'MON'),(897,'Workout Day - 4759','Des. - 4759',2323,'MON'),(898,'Workout Day - 1991','Des. - 1991',2324,'MON'),(899,'Workout Day - 7267','Des. - 7267',2325,'MON');
/*!40000 ALTER TABLE `workout_days` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `workout_days_excercises`
--

DROP TABLE IF EXISTS `workout_days_excercises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `workout_days_excercises` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `workoutdaysid` int(10) NOT NULL,
  `excercisesid` int(10) NOT NULL,
  `repetitions` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_workout_days_workout_days_excercises` (`workoutdaysid`),
  KEY `fk_excercises_workout_days_excercises` (`excercisesid`),
  CONSTRAINT `fk_excercises_workout_days_excercises` FOREIGN KEY (`excercisesid`) REFERENCES `excercises` (`id`),
  CONSTRAINT `fk_workout_days_workout_days_excercises` FOREIGN KEY (`workoutdaysid`) REFERENCES `workout_days` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=369 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `workout_days_excercises`
--

LOCK TABLES `workout_days_excercises` WRITE;
/*!40000 ALTER TABLE `workout_days_excercises` DISABLE KEYS */;
INSERT INTO `workout_days_excercises` VALUES (364,889,980,4),(365,890,982,3),(366,896,988,3),(367,898,990,5);
/*!40000 ALTER TABLE `workout_days_excercises` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-28 10:30:11
