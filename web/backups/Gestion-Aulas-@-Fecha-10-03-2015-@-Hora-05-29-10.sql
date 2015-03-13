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
  `disertantes` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Actividad`
--

LOCK TABLES `Actividad` WRITE;
/*!40000 ALTER TABLE `Actividad` DISABLE KEYS */;
INSERT INTO `Actividad` VALUES (1,'PEMTA','Trade',NULL);
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
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `recursosFijos` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A32B3F9A3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Aula`
--

LOCK TABLES `Aula` WRITE;
/*!40000 ALTER TABLE `Aula` DISABLE KEYS */;
INSERT INTO `Aula` VALUES (1,'101','1',30,NULL,1,'Moto de Agua'),(2,'102','1',30,NULL,1,'Carpa de Bosque'),(3,'103','2',35,NULL,1,'Moto de Nieve');
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
  `plan` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_A3F4AC3A909126` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Carrera`
--

LOCK TABLES `Carrera` WRITE;
/*!40000 ALTER TABLE `Carrera` DISABLE KEYS */;
INSERT INTO `Carrera` VALUES (1,'Analista Programador Universitario','UNLP','Informatica','#c714c7','2007','Buena gente');
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
  `carrera_id` int(11) DEFAULT NULL,
  `nombre` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `anio` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `ciclo` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `semestre` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BFA6FE8C671B40F` (`carrera_id`),
  CONSTRAINT `FK_BFA6FE8C671B40F` FOREIGN KEY (`carrera_id`) REFERENCES `Carrera` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Curso`
--

LOCK TABLES `Curso` WRITE;
/*!40000 ALTER TABLE `Curso` DISABLE KEYS */;
INSERT INTO `Curso` VALUES (1,1,'Matematica I','1','2015','1'),(2,1,'Objetos','2','2015','1'),(3,1,'ADP','1','2015','1');
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
  `observaciones` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `personaDocente_id` int(11) DEFAULT NULL,
  `telefono` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_3222F638971875FA` (`personaDocente_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Docente`
--

LOCK TABLES `Docente` WRITE;
/*!40000 ALTER TABLE `Docente` DISABLE KEYS */;
INSERT INTO `Docente` VALUES (1,'Jorge','Runco',NULL,NULL,NULL,NULL),(2,'Cali','Piola',NULL,NULL,NULL,NULL),(3,'La rubia','Esta re buena',NULL,NULL,NULL,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Movimiento`
--

LOCK TABLES `Movimiento` WRITE;
/*!40000 ALTER TABLE `Movimiento` DISABLE KEYS */;
INSERT INTO `Movimiento` VALUES (1,'2015-03-09 06:47:20','101','2000-01-01 08:00:00','2000-01-01 10:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(2,'2015-03-09 06:47:59','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(3,'2015-03-09 06:54:40','102','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(4,'2015-03-09 06:56:56','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(5,'2015-03-09 07:12:40','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(6,'2015-03-09 20:18:07','101','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-16 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(7,'2015-03-09 20:18:18','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(8,'2015-03-09 20:18:24','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-16 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(9,'2015-03-09 20:23:03','101','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(10,'2015-03-09 20:23:24','101','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-23 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(11,'2015-03-09 20:24:02','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-30 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(12,'2015-03-09 20:25:20','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-23 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(13,'2015-03-09 20:25:38','101','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-30 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(14,'2015-03-09 22:41:09','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-11-27 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(15,'2015-03-09 22:41:18','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-11-22 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(16,'2015-03-09 22:41:38','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-31 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(17,'2015-03-09 22:43:04','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-10 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(18,'2015-03-09 22:43:27','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-17 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(19,'2015-03-09 22:43:48','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(20,'2015-03-09 23:19:08','101','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(21,'2015-03-09 23:20:00','101','2000-01-01 08:00:00','2000-01-01 10:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(22,'2015-03-09 23:20:31','101','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(23,'2015-03-09 23:22:41','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(24,'2015-03-09 23:23:41','101','2000-01-01 08:00:00','2000-01-01 11:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(25,'2015-03-09 23:27:30','102','2000-01-01 08:00:00','2000-01-01 10:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(26,'2015-03-09 23:27:31','101','2000-01-01 08:00:00','2000-01-01 10:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(27,'2015-03-09 23:37:13','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-23 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)'),(28,'2015-03-09 23:37:15','102','2000-01-01 08:00:00','2000-01-01 12:00:00','2015-03-09 00:00:00','Neg90','Runco','Jorge','Matematica I (Curso)');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recurso`
--

LOCK TABLES `Recurso` WRITE;
/*!40000 ALTER TABLE `Recurso` DISABLE KEYS */;
INSERT INTO `Recurso` VALUES (1,'cañon',NULL);
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
  `diosReserva` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fechaRegistro` datetime NOT NULL,
  `horaRegistro` datetime NOT NULL,
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
) ENGINE=InnoDB AUTO_INCREMENT=307 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reserva`
--

LOCK TABLES `Reserva` WRITE;
/*!40000 ALTER TABLE `Reserva` DISABLE KEYS */;
INSERT INTO `Reserva` VALUES (297,1,1,1,NULL,'2015-03-11 00:00:00','2000-01-01 08:00:00','2000-01-01 12:00:00',NULL,'Neg90','2015-03-09 23:52:00','2015-03-09 23:52:00','2015-03-13 00:00:00',1),(298,1,1,1,NULL,'2015-03-12 00:00:00','2000-01-01 08:00:00','2000-01-01 12:00:00',NULL,'Neg90','2015-03-09 23:52:00','2015-03-09 23:52:00','2015-03-13 00:00:00',1),(299,1,1,1,NULL,'2015-03-13 00:00:00','2000-01-01 08:00:00','2000-01-01 12:00:00',NULL,'Neg90','2015-03-09 23:52:00','2015-03-09 23:52:00','2015-03-13 00:00:00',1),(300,2,3,2,NULL,'2015-03-10 00:00:00','2000-01-01 08:00:00','2000-01-01 13:00:00',NULL,'Neg90','2015-03-10 00:17:00','2015-03-10 00:17:00','2015-03-13 00:00:00',1),(301,2,3,2,NULL,'2015-03-11 00:00:00','2000-01-01 08:00:00','2000-01-01 13:00:00',NULL,'Neg90','2015-03-10 00:17:00','2015-03-10 00:17:00','2015-03-13 00:00:00',1),(302,2,3,2,NULL,'2015-03-12 00:00:00','2000-01-01 08:00:00','2000-01-01 13:00:00',NULL,'Neg90','2015-03-10 00:17:00','2015-03-10 00:17:00','2015-03-13 00:00:00',1),(303,2,3,2,NULL,'2015-03-13 00:00:00','2000-01-01 08:00:00','2000-01-01 13:00:00',NULL,'Neg90','2015-03-10 00:17:00','2015-03-10 00:17:00','2015-03-13 00:00:00',1),(304,1,1,1,NULL,'2015-03-10 00:00:00','2000-01-01 14:00:00','2000-01-01 15:00:00',NULL,'Neg90','2015-03-10 00:38:00','2015-03-10 00:38:00','2015-03-14 00:00:00',7),(305,3,1,2,NULL,'2015-03-14 00:00:00','2000-01-01 08:00:00','2000-01-01 11:00:00',NULL,'Neg90','2015-03-10 00:38:00','2015-03-10 00:38:00','2015-03-15 00:00:00',1),(306,3,1,2,NULL,'2015-03-15 00:00:00','2000-01-01 08:00:00','2000-01-01 11:00:00',NULL,'Neg90','2015-03-10 00:38:00','2015-03-10 00:38:00','2015-03-15 00:00:00',1);
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
INSERT INTO `Usuario` VALUES (1,NULL,NULL,'Neg90','neg90','neg90@hotmail.com','neg90@hotmail.com',1,'e78b36dui6o88wc8ow0sk00o8ogwoks','FSRFkPdLeeRbQtJpl9Doqtg9D5hj+n/deiiSkzCXxmIEuJliXjVT8jX96XtqAytZ0j+0kc7dgHGIEPBNNoy6vw==','2015-03-10 05:28:19',0,0,NULL,NULL,NULL,'a:1:{i:0;s:16:\"ROLE_SUPER_ADMIN\";}',0,NULL);
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

-- Dump completed on 2015-03-10  5:29:10
