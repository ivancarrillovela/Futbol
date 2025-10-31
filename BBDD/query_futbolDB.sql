-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.12.0.7122
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando base de datos futboldb
CREATE DATABASE IF NOT EXISTS 'futbolDB' DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Seleccionando base de datos futboldb
USE 'futbolDB';

-- Volcando estructura para tabla futboldb.equipos
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estadio` varchar(100) NOT NULL,
  PRIMARY KEY (`id_equipo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futboldb.equipos: ~11 rows (aproximadamente)
INSERT INTO `equipos` (`nombre`, `estadio`) VALUES
	('Real Madrid CF', 'Santiago Bernabéu'),
	('FC Barcelona', 'Spotify Camp Nou'),
	('Atlético de Madrid', 'Cívitas Metropolitano'),
	('Athletic Club', 'San Mamés'),
	('Real Sociedad', 'Reale Arena'),
	('CA Osasuna', 'El Sadar'),
	('Sevilla FC', 'Ramón Sánchez-Pizjuán'),
	('Valencia CF', 'Mestalla'),
	('Real Betis', 'Benito Villamarín'),
	('Villarreal CF', 'Estadio de la Cerámica'),
	('Mutilvera', 'Polideportivo Mutilva');

-- Volcando estructura para tabla futboldb.partidos
CREATE TABLE IF NOT EXISTS `partidos` (
  `id_partido` int(11) NOT NULL AUTO_INCREMENT,
  `id_local` int(11) NOT NULL,
  `id_visitante` int(11) NOT NULL,
  `resultado` enum('1','X','2') NOT NULL,
  `jornada` int(11) NOT NULL,
  `estadio_partido` varchar(100) NOT NULL,
  PRIMARY KEY (`id_partido`),
  KEY `id_visitante` (`id_visitante`),
  KEY `idx_jornada` (`jornada`),
  KEY `idx_equipos_partido` (`id_local`,`id_visitante`),
  CONSTRAINT `partidos_ibfk_1` FOREIGN KEY (`id_local`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE,
  CONSTRAINT `partidos_ibfk_2` FOREIGN KEY (`id_visitante`) REFERENCES `equipos` (`id_equipo`) ON DELETE CASCADE,
  CONSTRAINT `CONSTRAINT_1` CHECK (`id_local` <> `id_visitante`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futboldb.partidos: ~8 rows (aproximadamente)
INSERT INTO `partidos` (`id_local`, `id_visitante`, `resultado`, `jornada`, `estadio_partido`) VALUES
	(12, 14, '1', 1, 'Santiago Bernabéu'),
	(13, 18, 'X', 1, 'Spotify Camp Nou'),
	(15, 16, '2', 1, 'San Mamés'),
	(19, 20, '1', 1, 'Mestalla'),
	(14, 13, 'X', 2, 'Cívitas Metropolitano'),
	(18, 12, '2', 2, 'Ramón Sánchez-Pizjuán'),
	(16, 19, '1', 2, 'Reale Arena'),
	(20, 15, '1', 2, 'Benito Villamarín');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
