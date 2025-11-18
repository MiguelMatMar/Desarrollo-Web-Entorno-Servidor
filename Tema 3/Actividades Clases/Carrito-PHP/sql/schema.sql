-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.4.32-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para carrito_php
CREATE DATABASE IF NOT EXISTS `carrito_php` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `carrito_php`;

-- Volcando estructura para tabla carrito_php.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `total` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla carrito_php.pedidos: ~0 rows (aproximadamente)
INSERT INTO `pedidos` (`id`, `usuario_id`, `fecha`, `total`) VALUES
	(1, 1, '2025-11-18 23:06:51', 12.99);

-- Volcando estructura para tabla carrito_php.pedido_detalle
CREATE TABLE IF NOT EXISTS `pedido_detalle` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) DEFAULT NULL,
  `producto_id` int(11) DEFAULT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pedido_id` (`pedido_id`),
  KEY `producto_id` (`producto_id`),
  CONSTRAINT `pedido_detalle_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`id`),
  CONSTRAINT `pedido_detalle_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla carrito_php.pedido_detalle: ~0 rows (aproximadamente)
INSERT INTO `pedido_detalle` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio`) VALUES
	(1, 1, 1, 1, 12.99);

-- Volcando estructura para tabla carrito_php.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Volcando datos para la tabla carrito_php.productos: ~20 rows (aproximadamente)
INSERT INTO `productos` (`id`, `nombre`, `precio`, `stock`) VALUES
	(1, 'Camiseta básica blanca', 12.99, 50),
	(2, 'Pantalón vaquero azul', 34.90, 35),
	(3, 'Sudadera con capucha', 24.50, 40),
	(4, 'Zapatillas deportivas', 54.99, 20),
	(5, 'Gorra negra ajustable', 9.99, 80),
	(6, 'Auriculares Bluetooth', 29.99, 25),
	(7, 'Teclado mecánico RGB', 59.90, 15),
	(8, 'Ratón inalámbrico', 19.50, 30),
	(9, 'Monitor 24 pulgadas', 139.00, 10),
	(10, 'Cargador USB-C', 14.99, 60),
	(11, 'Café molido 500g', 5.49, 100),
	(12, 'Caja de té verde', 3.99, 70),
	(13, 'Galletas artesanales', 4.50, 45),
	(14, 'Aceite de oliva 1L', 7.90, 55),
	(15, 'Chocolate negro 70%', 2.99, 90),
	(16, 'Libro: "El principito"', 8.99, 40),
	(17, 'Libro: "1984" George Orwell', 11.50, 35),
	(18, 'Cuaderno A5 tapa dura', 3.20, 120),
	(19, 'Bolígrafo azul', 0.80, 200),
	(20, 'Mochila escolar', 17.99, 25);

-- Volcando estructura para tabla carrito_php.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
