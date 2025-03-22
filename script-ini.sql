-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: nutrinur
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `analisisclinico`
--

DROP TABLE IF EXISTS `analisisclinico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `analisisclinico` (
  `id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `diagnosticoId` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaRealizacion` date NOT NULL,
  `observaciones` text COLLATE utf8mb4_spanish_ci,
  `conclusion` text COLLATE utf8mb4_spanish_ci,
  `estaConcluido` tinyint(1) NOT NULL DEFAULT '0',
  `tipoAnalisis_id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `diagnosticoId` (`diagnosticoId`),
  KEY `tipoAnalisis_id` (`tipoAnalisis_id`),
  CONSTRAINT `analisisclinico_ibfk_1` FOREIGN KEY (`diagnosticoId`) REFERENCES `diagnostico` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analisisclinico_ibfk_2` FOREIGN KEY (`tipoAnalisis_id`) REFERENCES `tipoanalisis` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `diagnostico`
--

DROP TABLE IF EXISTS `diagnostico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `diagnostico` (
  `id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pacienteId` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha` date NOT NULL DEFAULT '1990-02-25',
  `peso` float NOT NULL,
  `altura` float NOT NULL,
  `descripcion` text COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipoDiagnostico_id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estadoDiagnostico` enum('Activo','Inactivo','Pendiente') COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pacienteId` (`pacienteId`),
  KEY `tipoDiagnostico_id` (`tipoDiagnostico_id`),
  CONSTRAINT `diagnostico_ibfk_1` FOREIGN KEY (`pacienteId`) REFERENCES `paciente` (`id`) ON DELETE CASCADE,
  CONSTRAINT `diagnostico_ibfk_2` FOREIGN KEY (`tipoDiagnostico_id`) REFERENCES `tipodiagnostico` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `entrevista`
--

DROP TABLE IF EXISTS `entrevista`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `entrevista` (
  `id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `pacienteId` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaRealizacion` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pacienteId` (`pacienteId`),
  CONSTRAINT `entrevista_ibfk_1` FOREIGN KEY (`pacienteId`) REFERENCES `paciente` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `paciente`
--

DROP TABLE IF EXISTS `paciente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paciente` (
  `id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaNacimiento` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipoanalisis`
--

DROP TABLE IF EXISTS `tipoanalisis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipoanalisis` (
  `id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tipodiagnostico`
--

DROP TABLE IF EXISTS `tipodiagnostico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipodiagnostico` (
  `id` char(36) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-03-22  0:46:41
