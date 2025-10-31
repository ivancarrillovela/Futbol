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


-- Volcando estructura de base de datos para futbol_db
CREATE DATABASE IF NOT EXISTS `futbol_db` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `futbol_db`;

-- Volcando estructura para tabla futbol_db.equipos
CREATE TABLE IF NOT EXISTS `equipos` (
  `id_equipo` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `estadio` varchar(100) NOT NULL,
  PRIMARY KEY (`id_equipo`),
  UNIQUE KEY `nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futbol_db.equipos: ~10 rows (aproximadamente)
INSERT INTO `equipos` (`id_equipo`, `nombre`, `estadio`) VALUES
	(1, 'Real Madrid CF', 'Santiago Bernabéu'),
	(2, 'FC Barcelona', 'Spotify Camp Nou'),
	(3, 'Atlético de Madrid', 'Cívitas Metropolitano'),
	(4, 'Athletic Club', 'San Mamés'),
	(5, 'Real Sociedad', 'Reale Arena'),
	(6, 'CA Osasuna', 'El Sadar'),
	(7, 'Sevilla FC', 'Ramón Sánchez-Pizjuán'),
	(8, 'Valencia CF', 'Mestalla'),
	(9, 'Real Betis', 'Benito Villamarín'),
	(10, 'Villarreal CF', 'Estadio de la Cerámica');

-- Volcando estructura para tabla futbol_db.partidos
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
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla futbol_db.partidos: ~8 rows (aproximadamente)
INSERT INTO `partidos` (`id_partido`, `id_local`, `id_visitante`, `resultado`, `jornada`, `estadio_partido`) VALUES
	(1, 1, 2, '1', 1, 'Santiago Bernabéu'),
	(2, 3, 7, 'X', 1, 'Cívitas Metropolitano'),
	(3, 4, 5, '2', 1, 'San Mamés'),
	(4, 6, 8, '1', 1, 'El Sadar'),
	(5, 9, 10, 'X', 1, 'Benito Villamarín'),
	(6, 2, 3, '1', 2, 'Spotify Camp Nou'),
	(7, 1, 7, '1', 2, 'Santiago Bernabéu'),
	(8, 5, 9, '2', 2, 'Reale Arena');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
