/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE TABLE `citas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `usuarioId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarioId` (`usuarioId`),
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `citasservicios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `citaId` int DEFAULT NULL,
  `servicioId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citaId` (`citaId`),
  KEY `servicioId` (`servicioId`),
  CONSTRAINT `citasservicios_ibfk_3` FOREIGN KEY (`citaId`) REFERENCES `citas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  CONSTRAINT `citasservicios_ibfk_4` FOREIGN KEY (`servicioId`) REFERENCES `servicios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `servicios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(60) DEFAULT NULL,
  `apellido` varchar(60) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `telefono` varchar(9) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES
(3, '2025-02-10', '16:43:00', 18);
INSERT INTO `citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES
(4, '2025-02-11', '16:44:00', 18);
INSERT INTO `citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES
(5, '2025-02-11', '15:17:00', 18);
INSERT INTO `citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES
(6, '2025-02-24', '15:22:00', 18),
(7, '2025-02-25', '14:23:00', 18),
(8, '2025-02-12', '11:00:00', 14);

INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(1, 3, 3);
INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(2, 4, 4);
INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(3, 5, 6);
INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(4, 5, 5),
(5, 5, 7),
(6, 5, 8),
(7, 6, 10),
(8, 6, 9),
(9, 6, 7),
(10, 6, 8),
(11, 7, 10),
(12, 7, 11),
(13, 7, 9),
(14, 8, 9),
(15, 8, 10),
(16, 8, 8),
(17, 8, 7),
(18, 8, 5),
(19, NULL, 3),
(20, NULL, 4),
(21, NULL, 2),
(22, NULL, 1),
(23, NULL, 5),
(24, NULL, 6);

INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(1, 'Corte de Cabello Mujer', '190.00');
INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(2, 'Corte de Cabello Hombre', '180.00');
INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(3, 'Corte de Cabello Niño', '60.00');
INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(4, 'Peinado Mujer', '80.00'),
(5, 'Peinado Hombre', '60.00'),
(6, 'Peinado Niño', '60.00'),
(7, 'Corte de Barba', '60.00'),
(8, 'Tinte Mujer', '100.00'),
(9, 'Uñas', '400.00'),
(10, 'Lavado de Cabello', '50.00'),
(11, 'Tratamiento Capilar', '150.00');

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `admin`, `confirmado`, `token`, `password`) VALUES
(14, ' Jorge', 'Sanchez', 'correo@correo.com', '123456789', 0, 1, '706d712bd19a268fc4832a38e0bc9114 ', '$2y$10$hQW.D3JZjZwJkaA2iQkh.uPHg0FdFKexu.ZnKxWUTFIOJx4t.tcky');
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `admin`, `confirmado`, `token`, `password`) VALUES
(17, 'Jorge', 'Sanchez', 'admin@admin.com', '123456789', 1, 1, '', '$2y$10$cSIUEBNlURmXEu6vifpJguCXOK36vGwxxo.hJnRjiEqfA3zxwcCXW');
INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `telefono`, `admin`, `confirmado`, `token`, `password`) VALUES
(18, 'Keiko', 'Keiko', 'keiko@gmail.com', '123456789', 0, 1, '', '$2y$10$FmUpXEDETHe3gZ2aglkrNOw/dlup/0rjEpo8zG3A8fVtXQ5qBGYi6');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;