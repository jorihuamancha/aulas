-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: symfony
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Table structure for table `Actividad`
--

DROP TABLE IF EXISTS `Actividad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Actividad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actividad`
--

LOCK TABLES `Actividad` WRITE;
/*!40000 ALTER TABLE `Actividad` DISABLE KEYS */;
INSERT INTO `Actividad` VALUES (1,'Facebook','unica'),(2,'Gimnasia','Semanal'),(3,'A','a');
/*!40000 ALTER TABLE `Actividad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Administrador`
--

DROP TABLE IF EXISTS `Administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Administrador` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `personaAdministrador_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_F787EED4402A0DD7` (`personaAdministrador_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Administrador`
--

LOCK TABLES `Administrador` WRITE;
/*!40000 ALTER TABLE `Administrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `Administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Alerta`
--

DROP TABLE IF EXISTS `Alerta`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Alerta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_36FB4151A8B7D9` (`fecha`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Alerta`
--

LOCK TABLES `Alerta` WRITE;
/*!40000 ALTER TABLE `Alerta` DISABLE KEYS */;
/*!40000 ALTER TABLE `Alerta` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Aula`
--

DROP TABLE IF EXISTS `Aula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Aula` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `piso` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `capacidad` int(11) NOT NULL,
  `activo` tinyint(1) NOT NULL,
  `recursosFijos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A32B3F9A3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Aula`
--

LOCK TABLES `Aula` WRITE;
/*!40000 ALTER TABLE `Aula` DISABLE KEYS */;
INSERT INTO `Aula` VALUES (1,'a','5',5,1,'',NULL),(2,'101','1',40,1,'Cañon, 40 bancos, pizarra, computadora, televisor',NULL),(3,'alalla','2',50,1,'lalala',NULL);
/*!40000 ALTER TABLE `Aula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Carrera`
--

DROP TABLE IF EXISTS `Carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Carrera` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `universidad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `facultad` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `plan` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A3F4AC3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Carrera`
--

LOCK TABLES `Carrera` WRITE;
/*!40000 ALTER TABLE `Carrera` DISABLE KEYS */;
INSERT INTO `Carrera` VALUES (4,'a','a','a','#ff0000',NULL,'a'),(5,'aa','aa','aa','#5900ff',NULL,'aa'),(6,'llala','UNLP','Informatica','#d93cd9','sadas','2007');
/*!40000 ALTER TABLE `Carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Curso`
--

DROP TABLE IF EXISTS `Curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Curso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `anio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `Carrera_id` int(11) DEFAULT NULL,
  `ciclo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `semestre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFA6FE8892CB7DF` (`Carrera_id`),
  CONSTRAINT `FK_BFA6FE8892CB7DF` FOREIGN KEY (`Carrera_id`) REFERENCES `Carrera` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Curso`
--

LOCK TABLES `Curso` WRITE;
/*!40000 ALTER TABLE `Curso` DISABLE KEYS */;
INSERT INTO `Curso` VALUES (4,'a','1',4,'a','1'),(5,'a','2',5,'1','1'),(6,'b','2016',5,'2016','2'),(7,'j','2',4,'2','1'),(8,'c','5',4,'5','1'),(9,'f','11',4,'2015','1'),(10,'b','154',4,'45','1');
/*!40000 ALTER TABLE `Curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Docente`
--

DROP TABLE IF EXISTS `Docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Docente` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `apellido` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `personaDocente_id` int(11) DEFAULT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3222F638971875FA` (`personaDocente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Docente`
--

LOCK TABLES `Docente` WRITE;
/*!40000 ALTER TABLE `Docente` DISABLE KEYS */;
INSERT INTO `Docente` VALUES (1,'J','a',NULL,NULL),(2,'b','h',NULL,NULL);
/*!40000 ALTER TABLE `Docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Movimiento`
--

DROP TABLE IF EXISTS `Movimiento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Movimiento` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` datetime NOT NULL,
  `reservaAula` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reservaHoraDesde` datetime NOT NULL,
  `reservaHoraHasta` datetime NOT NULL,
  `reservaParaDiaDeReserva` datetime NOT NULL,
  `movimientoPersona` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `apellidoDocente` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nombreDocente` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tarea` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Movimiento`
--

LOCK TABLES `Movimiento` WRITE;
/*!40000 ALTER TABLE `Movimiento` DISABLE KEYS */;
INSERT INTO `Movimiento` VALUES (1,'2015-02-27 04:41:27','a','2000-01-01 08:00:00','2000-01-01 08:30:00','2015-02-27 00:00:00','admin','a','J','a (Curso)'),(2,'2015-03-04 05:05:18','a','2000-01-01 18:00:00','2000-01-01 20:00:00','2015-02-27 00:00:00','admin','h','b','a (Curso)'),(3,'2015-03-06 04:56:13','101','2000-01-01 08:00:00','2000-01-01 09:00:00','2015-02-27 00:00:00','admin','a','J','a (Curso)'),(4,'2015-03-06 04:56:21','101','2000-01-01 09:00:00','2000-01-01 10:00:00','2015-02-27 00:00:00','admin','a','J','a (Curso)'),(5,'2015-03-06 04:56:27','101','2000-01-01 20:00:00','2000-01-01 22:00:00','2015-02-27 00:00:00','admin','a','J','a (Curso)'),(6,'2015-03-06 04:56:32','a','2000-01-01 13:00:00','2000-01-01 14:00:00','2015-02-27 00:00:00','admin','a','J','a (Curso)'),(7,'2015-03-06 04:56:37','a','2000-01-01 08:00:00','2000-01-01 09:00:00','2015-02-28 00:00:00','admin','a','J','a (Curso)'),(8,'2015-03-06 04:56:42','a','2000-01-01 08:00:00','2000-01-01 09:00:00','2015-03-01 00:00:00','admin','a','J','a (Curso)'),(9,'2015-03-06 04:56:47','a','2000-01-01 14:00:00','2000-01-01 18:00:00','2015-03-03 00:00:00','admin','a','J','a (Curso)'),(10,'2015-03-06 04:56:59','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-03 00:00:00','admin','a','J','a (Curso)'),(11,'2015-03-09 02:02:36','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-06 00:00:00','admin','a','J','a (Curso)'),(12,'2015-03-09 02:02:38','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','admin','a','J','a (Curso)'),(13,'2015-03-09 02:02:39','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-09 00:00:00','admin','a','J','a (Curso)'),(14,'2015-03-09 02:02:44','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-04-10 00:00:00','admin','a','J','a (Curso)'),(15,'2015-03-09 02:02:48','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-20 00:00:00','admin','a','J','a (Curso)'),(16,'2015-03-09 02:02:52','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-27 00:00:00','admin','a','J','a (Curso)'),(17,'2015-03-09 02:02:56','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-04-03 00:00:00','admin','a','J','a (Curso)'),(18,'2015-03-09 02:02:59','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-13 00:00:00','admin','a','J','a (Curso)'),(19,'2015-03-09 02:03:02','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-04-17 00:00:00','admin','a','J','a (Curso)'),(20,'2015-03-09 02:03:06','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-04-24 00:00:00','admin','a','J','a (Curso)'),(21,'2015-03-09 02:03:09','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-05-01 00:00:00','admin','a','J','a (Curso)'),(22,'2015-03-09 02:03:15','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-05-22 00:00:00','admin','a','J','a (Curso)'),(23,'2015-03-09 02:03:18','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-05-08 00:00:00','admin','a','J','a (Curso)'),(24,'2015-03-09 02:03:23','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-05-15 00:00:00','admin','a','J','a (Curso)'),(25,'2015-03-09 02:03:27','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-06-26 00:00:00','admin','a','J','a (Curso)'),(26,'2015-03-09 02:03:46','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-05-29 00:00:00','admin','a','J','a (Curso)'),(27,'2015-03-09 02:03:49','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-06-05 00:00:00','admin','a','J','a (Curso)'),(28,'2015-03-09 02:03:52','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-06-12 00:00:00','admin','a','J','a (Curso)'),(29,'2015-03-09 02:03:55','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-06-19 00:00:00','admin','a','J','a (Curso)'),(30,'2015-03-09 02:03:58','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-07-03 00:00:00','admin','a','J','a (Curso)'),(31,'2015-03-09 02:04:01','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-07-10 00:00:00','admin','a','J','a (Curso)'),(32,'2015-03-09 02:04:04','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-07-17 00:00:00','admin','a','J','a (Curso)'),(33,'2015-03-09 02:04:11','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-07-24 00:00:00','admin','a','J','a (Curso)'),(34,'2015-03-09 02:04:53','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-07-31 00:00:00','admin','a','J','a (Curso)'),(35,'2015-03-09 02:04:57','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-10 00:00:00','admin','a','J','a (Curso)'),(36,'2015-03-09 02:05:00','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-11 00:00:00','admin','a','J','a (Curso)'),(37,'2015-03-09 02:05:03','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-12 00:00:00','admin','a','J','a (Curso)'),(38,'2015-03-09 02:05:06','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-16 00:00:00','admin','a','J','a (Curso)'),(39,'2015-03-09 02:05:09','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-23 00:00:00','admin','a','J','a (Curso)'),(40,'2015-03-09 02:05:12','a','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-30 00:00:00','admin','a','J','a (Curso)'),(41,'2015-03-09 02:05:26','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-10 00:00:00','admin','a','J','a (Curso)'),(42,'2015-03-09 02:05:28','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-11 00:00:00','admin','a','J','a (Curso)'),(43,'2015-03-09 02:05:31','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-12 00:00:00','admin','a','J','a (Curso)'),(44,'2015-03-09 02:05:38','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-13 00:00:00','admin','a','J','a (Curso)'),(45,'2015-03-09 02:05:41','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-14 00:00:00','admin','a','J','a (Curso)'),(46,'2015-03-09 02:05:44','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-15 00:00:00','admin','a','J','a (Curso)'),(47,'2015-03-09 02:05:47','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-16 00:00:00','admin','a','J','a (Curso)'),(48,'2015-03-09 02:05:49','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-17 00:00:00','admin','a','J','a (Curso)'),(49,'2015-03-09 02:05:52','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-18 00:00:00','admin','a','J','a (Curso)'),(50,'2015-03-09 02:06:11','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-19 00:00:00','admin','a','J','a (Curso)'),(51,'2015-03-09 02:06:15','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-20 00:00:00','admin','a','J','a (Curso)'),(52,'2015-03-09 02:06:18','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-21 00:00:00','admin','a','J','a (Curso)'),(53,'2015-03-09 02:06:21','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-22 00:00:00','admin','a','J','a (Curso)'),(54,'2015-03-09 02:06:25','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-23 00:00:00','admin','a','J','a (Curso)'),(55,'2015-03-09 02:06:29','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-24 00:00:00','admin','a','J','a (Curso)'),(56,'2015-03-09 02:06:34','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-25 00:00:00','admin','a','J','a (Curso)'),(57,'2015-03-09 02:06:36','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-26 00:00:00','admin','a','J','a (Curso)'),(58,'2015-03-09 02:06:39','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-27 00:00:00','admin','a','J','a (Curso)'),(59,'2015-03-09 02:06:42','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-28 00:00:00','admin','a','J','a (Curso)'),(60,'2015-03-09 02:06:45','a','2000-01-01 13:00:00','2000-01-01 20:00:00','2015-03-29 00:00:00','admin','a','J','a (Curso)');
/*!40000 ALTER TABLE `Movimiento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recurso`
--

DROP TABLE IF EXISTS `Recurso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Recurso` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_7D060EF83A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recurso`
--

LOCK TABLES `Recurso` WRITE;
/*!40000 ALTER TABLE `Recurso` DISABLE KEYS */;
INSERT INTO `Recurso` VALUES (1,'Cañon',NULL),(2,'VC',NULL),(3,'Silla',NULL),(4,'a',NULL),(5,'b',NULL),(6,'c',NULL),(7,'d',NULL),(8,'e',NULL),(9,'f',NULL),(10,'g',NULL),(11,'h',NULL);
/*!40000 ALTER TABLE `Recurso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reserva`
--

DROP TABLE IF EXISTS `Reserva`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reserva` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docente_id` int(11) DEFAULT NULL,
  `aula_id` int(11) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `actividad_id` int(11) DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `horaDesde` datetime NOT NULL,
  `horaHasta` datetime NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `fechaRegistro` datetime NOT NULL,
  `horaRegistro` datetime NOT NULL,
  `diosReserva` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rangoHasta` datetime NOT NULL,
  `rango` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D73017A794E27525` (`docente_id`),
  KEY `IDX_D73017A7AD1A1255` (`aula_id`),
  KEY `IDX_D73017A787CB4A1F` (`curso_id`),
  KEY `IDX_D73017A76014FACA` (`actividad_id`),
  CONSTRAINT `FK_D73017A76014FACA` FOREIGN KEY (`actividad_id`) REFERENCES `Actividad` (`id`),
  CONSTRAINT `FK_D73017A787CB4A1F` FOREIGN KEY (`curso_id`) REFERENCES `Curso` (`id`),
  CONSTRAINT `FK_D73017A794E27525` FOREIGN KEY (`docente_id`) REFERENCES `Docente` (`id`),
  CONSTRAINT `FK_D73017A7AD1A1255` FOREIGN KEY (`aula_id`) REFERENCES `Aula` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reserva`
--

LOCK TABLES `Reserva` WRITE;
/*!40000 ALTER TABLE `Reserva` DISABLE KEYS */;
INSERT INTO `Reserva` VALUES (60,1,1,4,NULL,'2015-03-09 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(61,1,1,4,NULL,'2015-03-10 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(62,1,1,4,NULL,'2015-03-11 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(63,1,1,4,NULL,'2015-03-12 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(64,1,1,4,NULL,'2015-03-13 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(65,1,1,4,NULL,'2015-03-14 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(66,1,1,4,NULL,'2015-03-15 00:00:00','2000-01-01 08:00:00','2000-01-01 10:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(67,1,1,4,NULL,'2015-03-09 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(68,1,1,4,NULL,'2015-03-10 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(69,1,1,4,NULL,'2015-03-11 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(70,1,1,4,NULL,'2015-03-12 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(71,1,1,4,NULL,'2015-03-13 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(72,1,1,4,NULL,'2015-03-14 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(73,1,1,4,NULL,'2015-03-15 00:00:00','2000-01-01 16:00:00','2000-01-01 18:00:00',NULL,'2015-03-09 02:07:00','2015-03-09 02:07:00','admin','2015-03-15 00:00:00',1),(74,1,1,4,NULL,'2015-03-09 00:00:00','2000-01-01 11:00:00','2000-01-01 15:00:00',NULL,'2015-03-09 02:08:00','2015-03-09 02:08:00','admin','2015-03-15 00:00:00',0);
/*!40000 ALTER TABLE `Reserva` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reservas_Recursos`
--

DROP TABLE IF EXISTS `Reservas_Recursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reservas_Recursos` (
  `idReserva` int(11) NOT NULL,
  `idRecurso` int(11) NOT NULL,
  PRIMARY KEY (`idReserva`,`idRecurso`),
  KEY `IDX_F6A4E4AE83445C9` (`idReserva`),
  KEY `IDX_F6A4E4AEA2025C96` (`idRecurso`),
  CONSTRAINT `FK_F6A4E4AE83445C9` FOREIGN KEY (`idReserva`) REFERENCES `Reserva` (`id`),
  CONSTRAINT `FK_F6A4E4AEA2025C96` FOREIGN KEY (`idRecurso`) REFERENCES `Recurso` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reservas_Recursos`
--

LOCK TABLES `Reservas_Recursos` WRITE;
/*!40000 ALTER TABLE `Reservas_Recursos` DISABLE KEYS */;
/*!40000 ALTER TABLE `Reservas_Recursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `docente_id` int(11) DEFAULT NULL,
  `administrador_id` int(11) DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `locked` tinyint(1) NOT NULL,
  `expired` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  `confirmation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `credentials_expired` tinyint(1) NOT NULL,
  `credentials_expire_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EDD889C192FC23A8` (`username_canonical`),
  UNIQUE KEY `UNIQ_EDD889C1A0D96FBF` (`email_canonical`),
  UNIQUE KEY `UNIQ_EDD889C194E27525` (`docente_id`),
  UNIQUE KEY `UNIQ_EDD889C148DFEBB7` (`administrador_id`),
  CONSTRAINT `FK_EDD889C148DFEBB7` FOREIGN KEY (`administrador_id`) REFERENCES `Administrador` (`id`),
  CONSTRAINT `FK_EDD889C194E27525` FOREIGN KEY (`docente_id`) REFERENCES `Docente` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,NULL,NULL,'admin','admin','a@a.com','a@a.com',1,'cm3hgr2wpy8k44ks04co8gk8swg0skw','ajmeeepFSVr6ZahZvUBu/bovvgIYbllDvIyXrWxjQiYb9s7si40p/vq7eZMu7G29ekrpzQR/OJFjXPXPlZqd1Q==','2015-03-09 06:53:06',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL);
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-10  2:40:01
