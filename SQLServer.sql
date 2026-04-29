/*M!999999\- enable the sandbox mode */
-- MariaDB dump 10.19  Distrib 10.11.14-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: gestion_escolar
-- ------------------------------------------------------
-- Server version       10.11.14-MariaDB-0+deb12u2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Administrador`
--

DROP TABLE IF EXISTS `Administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Administrador` (
  `ID_administrador` int(11) NOT NULL,
  `Permisos_especiales` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_administrador`),
  CONSTRAINT `fk_administrador_persona` FOREIGN KEY (`ID_administrador`) REFERENCES `Persona` (`ID_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Administrador`
--

LOCK TABLES `Administrador` WRITE;
/*!40000 ALTER TABLE `Administrador` DISABLE KEYS */;
/*!40000 ALTER TABLE `Administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Alumno`
--

DROP TABLE IF EXISTS `Alumno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Alumno` (
  `ID_alumno` int(11) NOT NULL,
  `fecha_inscripcion` date DEFAULT NULL,
  PRIMARY KEY (`ID_alumno`),
  CONSTRAINT `fk_alumno_persona` FOREIGN KEY (`ID_alumno`) REFERENCES `Persona` (`ID_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Alumno`
--

LOCK TABLES `Alumno` WRITE;
/*!40000 ALTER TABLE `Alumno` DISABLE KEYS */;
INSERT INTO `Alumno` VALUES
(23896799,'2002-05-22');
/*!40000 ALTER TABLE `Alumno` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Calificacion`
--

DROP TABLE IF EXISTS `Calificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Calificacion` (
  `ID_entrega` int(11) NOT NULL,
  `Puntuacion_obtenida` int(11) DEFAULT NULL,
  `Comentarios_profesor` text DEFAULT NULL,
  PRIMARY KEY (`ID_entrega`),
  CONSTRAINT `fk_calificacion_tiene` FOREIGN KEY (`ID_entrega`) REFERENCES `Tiene` (`ID_entrega`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Calificacion`
--

LOCK TABLES `Calificacion` WRITE;
/*!40000 ALTER TABLE `Calificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Calificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Categoria`
--

DROP TABLE IF EXISTS `Categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Categoria` (
  `ID_categoria` int(11) NOT NULL,
  `Nombre_categoria` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `ID_categoria1` int(11) DEFAULT NULL,
  `ID_administrador` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_categoria`),
  KEY `fk_categoria_parent` (`ID_categoria1`),
  KEY `fk_categoria_administrador` (`ID_administrador`),
  CONSTRAINT `fk_categoria_administrador` FOREIGN KEY (`ID_administrador`) REFERENCES `Administrador` (`ID_administrador`),
  CONSTRAINT `fk_categoria_parent` FOREIGN KEY (`ID_categoria1`) REFERENCES `Categoria` (`ID_categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Categoria`
--

LOCK TABLES `Categoria` WRITE;
/*!40000 ALTER TABLE `Categoria` DISABLE KEYS */;
/*!40000 ALTER TABLE `Categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comunicacion`
--

DROP TABLE IF EXISTS `Comunicacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Comunicacion` (
  `ID_profesor` int(11) NOT NULL,
  `ID_alumno` int(11) NOT NULL,
  PRIMARY KEY (`ID_profesor`,`ID_alumno`),
  KEY `fk_comunicacion_alumno` (`ID_alumno`),
  CONSTRAINT `fk_comunicacion_alumno` FOREIGN KEY (`ID_alumno`) REFERENCES `Alumno` (`ID_alumno`),
  CONSTRAINT `fk_comunicacion_profesor` FOREIGN KEY (`ID_profesor`) REFERENCES `Profesor` (`ID_profesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comunicacion`
--

LOCK TABLES `Comunicacion` WRITE;
/*!40000 ALTER TABLE `Comunicacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `Comunicacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Curso`
--

DROP TABLE IF EXISTS `Curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Curso` (
  `ID_curso` int(11) NOT NULL,
  `Nombre_curso` varchar(100) DEFAULT NULL,
  `Fecha_inicio` date DEFAULT NULL,
  `Fecha_fin` date DEFAULT NULL,
  `ID_administrador` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_curso`),
  KEY `fk_curso_administrador` (`ID_administrador`),
  CONSTRAINT `fk_curso_administrador` FOREIGN KEY (`ID_administrador`) REFERENCES `Administrador` (`ID_administrador`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Curso`
--

LOCK TABLES `Curso` WRITE;
/*!40000 ALTER TABLE `Curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `Curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Imparto`
--

DROP TABLE IF EXISTS `Imparto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Imparto` (
  `ID_profesor` int(11) NOT NULL,
  `ID_curso` int(11) NOT NULL,
  PRIMARY KEY (`ID_profesor`,`ID_curso`),
  KEY `fk_imparto_curso` (`ID_curso`),
  CONSTRAINT `fk_imparto_curso` FOREIGN KEY (`ID_curso`) REFERENCES `Curso` (`ID_curso`),
  CONSTRAINT `fk_imparto_profesor` FOREIGN KEY (`ID_profesor`) REFERENCES `Profesor` (`ID_profesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Imparto`
--

LOCK TABLES `Imparto` WRITE;
/*!40000 ALTER TABLE `Imparto` DISABLE KEYS */;
/*!40000 ALTER TABLE `Imparto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Matricula`
--

DROP TABLE IF EXISTS `Matricula`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Matricula` (
  `ID_alumno` int(11) NOT NULL,
  `ID_curso` int(11) NOT NULL,
  PRIMARY KEY (`ID_alumno`,`ID_curso`),
  KEY `fk_matricula_curso` (`ID_curso`),
  CONSTRAINT `fk_matricula_alumno` FOREIGN KEY (`ID_alumno`) REFERENCES `Alumno` (`ID_alumno`),
  CONSTRAINT `fk_matricula_curso` FOREIGN KEY (`ID_curso`) REFERENCES `Curso` (`ID_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Matricula`
--

LOCK TABLES `Matricula` WRITE;
/*!40000 ALTER TABLE `Matricula` DISABLE KEYS */;
/*!40000 ALTER TABLE `Matricula` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Persona`
--

DROP TABLE IF EXISTS `Persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Persona` (
  `ID_persona` int(11) NOT NULL,
  `Nombre` varchar(50) DEFAULT NULL,
  `Apellido1` varchar(50) DEFAULT NULL,
  `Apellido2` varchar(50) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `estado_cuenta` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Persona`
--

LOCK TABLES `Persona` WRITE;
/*!40000 ALTER TABLE `Persona` DISABLE KEYS */;
INSERT INTO `Persona` VALUES
(23896799,'Marc','García','Navarro','garcianavarromarc02@gmail.com','Activo');
/*!40000 ALTER TABLE `Persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Profesor`
--

DROP TABLE IF EXISTS `Profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Profesor` (
  `ID_profesor` int(11) NOT NULL,
  `titulo_academico` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ID_profesor`),
  CONSTRAINT `fk_profesor_persona` FOREIGN KEY (`ID_profesor`) REFERENCES `Persona` (`ID_persona`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Profesor`
--

LOCK TABLES `Profesor` WRITE;
/*!40000 ALTER TABLE `Profesor` DISABLE KEYS */;
/*!40000 ALTER TABLE `Profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Recurso_curso`
--

DROP TABLE IF EXISTS `Recurso_curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Recurso_curso` (
  `ID_recurso` int(11) NOT NULL,
  `ID_curso` int(11) NOT NULL,
  `ID_categoria` int(11) DEFAULT NULL,
  `Nombre_recurso` varchar(100) DEFAULT NULL,
  `Tipo` varchar(50) DEFAULT NULL,
  `Ubicacion` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`ID_recurso`,`ID_curso`),
  KEY `fk_recurso_curso` (`ID_curso`),
  KEY `fk_recurso_categoria` (`ID_categoria`),
  CONSTRAINT `fk_recurso_categoria` FOREIGN KEY (`ID_categoria`) REFERENCES `Categoria` (`ID_categoria`),
  CONSTRAINT `fk_recurso_curso` FOREIGN KEY (`ID_curso`) REFERENCES `Curso` (`ID_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Recurso_curso`
--

LOCK TABLES `Recurso_curso` WRITE;
/*!40000 ALTER TABLE `Recurso_curso` DISABLE KEYS */;
/*!40000 ALTER TABLE `Recurso_curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tarea`
--

DROP TABLE IF EXISTS `Tarea`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tarea` (
  `ID_tarea` int(11) NOT NULL,
  `Nombre_tarea` varchar(100) DEFAULT NULL,
  `Descripcion` text DEFAULT NULL,
  `ID_profesor` int(11) DEFAULT NULL,
  `Puntuacion_maxima` int(11) DEFAULT NULL,
  `Fecha_limite` date DEFAULT NULL,
  `ID_curso` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_tarea`),
  KEY `fk_tarea_profesor` (`ID_profesor`),
  KEY `fk_tarea_curso` (`ID_curso`),
  CONSTRAINT `fk_tarea_curso` FOREIGN KEY (`ID_curso`) REFERENCES `Curso` (`ID_curso`),
  CONSTRAINT `fk_tarea_profesor` FOREIGN KEY (`ID_profesor`) REFERENCES `Profesor` (`ID_profesor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tarea`
--

LOCK TABLES `Tarea` WRITE;
/*!40000 ALTER TABLE `Tarea` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tarea` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tiene`
--

DROP TABLE IF EXISTS `Tiene`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `Tiene` (
  `ID_alumno` int(11) NOT NULL,
  `ID_tarea` int(11) NOT NULL,
  `ID_entrega` int(11) NOT NULL,
  `Fecha_entrega` date DEFAULT NULL,
  `Contenido_adjunto` varchar(200) DEFAULT NULL,
  `Estado` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_alumno`,`ID_tarea`,`ID_entrega`),
  UNIQUE KEY `uq_tiene_id_entrega` (`ID_entrega`),
  KEY `fk_tiene_tarea` (`ID_tarea`),
  CONSTRAINT `fk_tiene_alumno` FOREIGN KEY (`ID_alumno`) REFERENCES `Alumno` (`ID_alumno`),
  CONSTRAINT `fk_tiene_tarea` FOREIGN KEY (`ID_tarea`) REFERENCES `Tarea` (`ID_tarea`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tiene`
--

LOCK TABLES `Tiene` WRITE;
/*!40000 ALTER TABLE `Tiene` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tiene` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-04-29 17:48:21