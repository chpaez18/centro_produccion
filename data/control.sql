-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 27-02-2021 a las 16:42:48
-- Versión del servidor: 8.0.21
-- Versión de PHP: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `control`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `almacenes`
--

DROP TABLE IF EXISTS `almacenes`;
CREATE TABLE IF NOT EXISTS `almacenes` (
  `id_almacen` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `ubicacion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_almacen`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `almacenes`
--

INSERT INTO `almacenes` (`id_almacen`, `nombre`, `ubicacion`) VALUES
(17, 'almacen 1', 'ubicacion 1'),
(18, 'almacen 2', 'ubicacion 2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

DROP TABLE IF EXISTS `clientes`;
CREATE TABLE IF NOT EXISTS `clientes` (
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `tipo` int NOT NULL COMMENT '0: Externo, 1: Interno',
  `alias` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `rif` varchar(100) NOT NULL,
  `direccion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `telefono` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `website` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `contacto` varchar(255) NOT NULL,
  `telefono_contacto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `email_contacto` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `estatus` int NOT NULL DEFAULT '1' COMMENT '0: Inactivo, 1: Activo (Default)',
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `tipo`, `alias`, `nombre`, `rif`, `direccion`, `telefono`, `email`, `website`, `contacto`, `telefono_contacto`, `email_contacto`, `fecha_registro`, `estatus`) VALUES
(1, 0, 'prueba', 'cliente 1', '34dfd', 'nnbnb', 'bnbn', 'bnvnbv@ddd.com', 'nbvnbv', 'nbvnbv', 'bnvnbv', '', '2020-11-15 00:16:38', 1),
(2, 0, 'cliente de prueba 2', 'cliente 2', 'dsdfdfsdfdf', 'dfsdfsdf', 'dsjjsjsjs', 'email prueba', 'website de prueba', 'contacto de prueba', 'telefono de prueba ', 'email de contacto prueba', '2020-11-15 00:16:38', 1),
(3, 0, 'prueba', 'producto 12', 'J-dfsdfdfd', 'sdsdfsdfsdf', 'sdfsfdf', 'christianpaez1029@gmail.com', 'sdfsdf', '', '', '', '0000-00-00 00:00:00', 1),
(13, 1, 'prueba de nuevo', 'otra vezzz', 'J-34234234', '', 'dfsdfsdf', 'impormotor.desarrollo@gmail.com', '', '', '', '', '0000-00-00 00:00:00', 1),
(14, 0, 'cliente 3 edicion', 'cliente 3', 'J-34324', '', 'dfsdfsdf', 'prueba@prueba.com', '', '', '', '', '0000-00-00 00:00:00', 1),
(24, 1, 'prueba de cliente', 'prueba', 'J-34324', 'prueba ', '222222222', 'impormotor.desarrollo@gmail.com', 'sdfsdf', '', '', '', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

DROP TABLE IF EXISTS `inventario`;
CREATE TABLE IF NOT EXISTS `inventario` (
  `id_inventario` int NOT NULL AUTO_INCREMENT,
  `id_almacen` int NOT NULL,
  `tipo` int NOT NULL COMMENT '0: Materia Prima, 1: Producto Terminado',
  `id_producto` int DEFAULT NULL,
  `id_materia_prima` int DEFAULT NULL,
  `cantidad` int NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `fecha_carga` timestamp NULL DEFAULT NULL,
  `estatus` int NOT NULL COMMENT '0: No Disponible; 1: Disponible',
  PRIMARY KEY (`id_inventario`),
  KEY `fk_id_almacen` (`id_almacen`),
  KEY `fk_id_producto` (`id_producto`),
  KEY `fk_id_materia_prima` (`id_materia_prima`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`id_inventario`, `id_almacen`, `tipo`, `id_producto`, `id_materia_prima`, `cantidad`, `fecha_registro`, `fecha_carga`, `estatus`) VALUES
(1, 17, 1, 16, NULL, 14, '2020-11-15 15:50:13', NULL, 1),
(13, 17, 0, NULL, 1, 222222, '2020-11-16 07:49:49', NULL, 1),
(15, 17, 0, NULL, 3, 111, '2020-11-19 12:31:19', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materias_primas`
--

DROP TABLE IF EXISTS `materias_primas`;
CREATE TABLE IF NOT EXISTS `materias_primas` (
  `id_materia_prima` int NOT NULL AUTO_INCREMENT,
  `fecha_registro` timestamp NOT NULL,
  `estatus` int NOT NULL COMMENT '0: No Disponible; 1: Disponible',
  `nombre` varchar(255) NOT NULL,
  `unidad` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL COMMENT 'kg, oz, etc',
  PRIMARY KEY (`id_materia_prima`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `materias_primas`
--

INSERT INTO `materias_primas` (`id_materia_prima`, `fecha_registro`, `estatus`, `nombre`, `unidad`) VALUES
(1, '2020-11-15 21:55:59', 1, 'materia 1', 'kg'),
(2, '0000-00-00 00:00:00', 1, 'materia prima 2', 'kg'),
(3, '0000-00-00 00:00:00', 1, 'maiz   ', 'kg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mermas`
--

DROP TABLE IF EXISTS `mermas`;
CREATE TABLE IF NOT EXISTS `mermas` (
  `id_merma` int NOT NULL AUTO_INCREMENT,
  `id_producto` int DEFAULT NULL,
  `id_materia_prima` int DEFAULT NULL,
  `registrado_por` int DEFAULT NULL,
  `fecha_registro` date DEFAULT NULL,
  `cantidad_devuelta` double DEFAULT NULL,
  PRIMARY KEY (`id_merma`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id_producto` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `estatus` int NOT NULL COMMENT '0: No Disponible; 1: Disponible',
  PRIMARY KEY (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `nombre`, `fecha_registro`, `estatus`) VALUES
(16, 'producto dinamico', '0000-00-00 00:00:00', 0),
(17, 'ultimo producto', '0000-00-00 00:00:00', 0),
(18, 'ultimo producto 2', '0000-00-00 00:00:00', 1),
(19, 'producto dinamico 3', '0000-00-00 00:00:00', 1),
(20, 'nuevo producto', '0000-00-00 00:00:00', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos_componentes`
--

DROP TABLE IF EXISTS `productos_componentes`;
CREATE TABLE IF NOT EXISTS `productos_componentes` (
  `id_producto_componente` int NOT NULL AUTO_INCREMENT,
  `id_producto` int NOT NULL,
  `id_materia_prima` int NOT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`id_producto_componente`),
  KEY `fk_id_producto_productos_componentes` (`id_producto`),
  KEY `fk_id_materia_prima_productos_componentes` (`id_materia_prima`)
) ENGINE=InnoDB AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `productos_componentes`
--

INSERT INTO `productos_componentes` (`id_producto_componente`, `id_producto`, `id_materia_prima`, `cantidad`) VALUES
(43, 16, 2, 1),
(44, 16, 2, 2),
(49, 17, 2, 3),
(50, 17, 1, 1),
(55, 18, 2, 12),
(56, 18, 1, 33),
(65, 19, 3, 12),
(66, 19, 2, 13),
(68, 20, 2, 99),
(69, 20, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_almacen_materia_prima`
--

DROP TABLE IF EXISTS `solicitud_almacen_materia_prima`;
CREATE TABLE IF NOT EXISTS `solicitud_almacen_materia_prima` (
  `id_solicitud_almacen_materia_prima` int NOT NULL AUTO_INCREMENT,
  `id_solicitud_produccion` int NOT NULL,
  `id_materia_prima` int NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `estatus` int NOT NULL COMMENT '0: Solicitado; 1: Entregado',
  `solicitado_por` int NOT NULL,
  `entregado_por` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitud_almacen_materia_prima`),
  KEY `fk_id_solicitud_produccion_solicitud_almacen_materia_prima` (`id_solicitud_produccion`),
  KEY `fk_solicitado_por_solicitud_almacen_materia_prima` (`solicitado_por`),
  KEY `fk_entregado_por_solicitud_almacen_materia_prima` (`entregado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud_almacen_materia_prima`
--

INSERT INTO `solicitud_almacen_materia_prima` (`id_solicitud_almacen_materia_prima`, `id_solicitud_produccion`, `id_materia_prima`, `fecha_registro`, `estatus`, `solicitado_por`, `entregado_por`) VALUES
(21, 24, 3, '2021-02-03 06:25:41', 1, 1, 1),
(22, 24, 2, '2021-02-03 06:25:44', 1, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_almacen_materia_prima_items`
--

DROP TABLE IF EXISTS `solicitud_almacen_materia_prima_items`;
CREATE TABLE IF NOT EXISTS `solicitud_almacen_materia_prima_items` (
  `id_solicitud_almacen_materia_prima_item` int NOT NULL AUTO_INCREMENT,
  `id_solicitud_almacen_materia_prima` int NOT NULL,
  `id_materia_prima` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitud_almacen_materia_prima_item`),
  KEY `fk_id_solicitud_almacen_materia_prima_solicitud_almacen` (`id_solicitud_almacen_materia_prima`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_almacen_producto`
--

DROP TABLE IF EXISTS `solicitud_almacen_producto`;
CREATE TABLE IF NOT EXISTS `solicitud_almacen_producto` (
  `id_solicitud_almacen_producto` int NOT NULL AUTO_INCREMENT,
  `id_solicitud_cliente` int NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `fecha_recepcion` timestamp NULL DEFAULT NULL,
  `estatus` int NOT NULL COMMENT '0: Solicitado; 1: Entregado (Update Fecha Recepción)',
  `observacion` text,
  `solicitado_por` int NOT NULL,
  `entregado_por` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitud_almacen_producto`),
  KEY `fk_id_solicitud_requerimiento_almacen_producto` (`id_solicitud_cliente`),
  KEY `fk_solicitado_por_usuario` (`solicitado_por`),
  KEY `fk_entregado_por_usuario` (`entregado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud_almacen_producto`
--

INSERT INTO `solicitud_almacen_producto` (`id_solicitud_almacen_producto`, `id_solicitud_cliente`, `fecha_registro`, `fecha_recepcion`, `estatus`, `observacion`, `solicitado_por`, `entregado_por`) VALUES
(22, 24, '2021-02-03 06:25:10', NULL, 0, 'paso 2', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_clientes`
--

DROP TABLE IF EXISTS `solicitud_clientes`;
CREATE TABLE IF NOT EXISTS `solicitud_clientes` (
  `id_solicitud_cliente` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `fecha_registro` timestamp NOT NULL,
  `estatus` int DEFAULT NULL COMMENT '0: No atendida, 1: Atendida en espera,  2: Por entregar, 3: Despachado, 4:Devuelto',
  `id_usuario` int DEFAULT NULL,
  `observacion` text NOT NULL,
  PRIMARY KEY (`id_solicitud_cliente`) USING BTREE,
  KEY `fk_id_cliente_solicitud_requerimiento` (`id_cliente`),
  KEY `fk_recibido_por_solicitud_requerimiento` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud_clientes`
--

INSERT INTO `solicitud_clientes` (`id_solicitud_cliente`, `id_cliente`, `fecha_registro`, `estatus`, `id_usuario`, `observacion`) VALUES
(24, 14, '2021-02-03 06:23:35', 1, 1, 'paso 1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_clientes_items`
--

DROP TABLE IF EXISTS `solicitud_clientes_items`;
CREATE TABLE IF NOT EXISTS `solicitud_clientes_items` (
  `id_solicitud_cliente_item` int NOT NULL AUTO_INCREMENT,
  `id_solicitud_cliente` int NOT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `estatus_almacen` int NOT NULL COMMENT '0: No atendida, 1: Solicitado, 2: Entregado (estatus 1 y 2 lo ve Almacén)',
  `estatus_produccion` int NOT NULL COMMENT '0: No atendida, 1: Solicitado, 2: Entregado  ',
  PRIMARY KEY (`id_solicitud_cliente_item`) USING BTREE,
  KEY `fk_id_solicitud_requerimiento_solicitud_requerimiento_items` (`id_solicitud_cliente`),
  KEY `fk_id_producto_solicitud_requerimiento_items` (`id_producto`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud_clientes_items`
--

INSERT INTO `solicitud_clientes_items` (`id_solicitud_cliente_item`, `id_solicitud_cliente`, `id_producto`, `cantidad`, `estatus_almacen`, `estatus_produccion`) VALUES
(45, 24, 20, 12, 2, 0),
(46, 24, 19, 22, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_compras`
--

DROP TABLE IF EXISTS `solicitud_compras`;
CREATE TABLE IF NOT EXISTS `solicitud_compras` (
  `id_solicitud_compra` int NOT NULL AUTO_INCREMENT,
  `id_materia_prima` int DEFAULT NULL,
  `id_solicitud_almacen_materia_prima` int DEFAULT NULL,
  `fecha_registro` timestamp NULL DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `unidad` varchar(255) DEFAULT NULL,
  `estatus` int DEFAULT NULL COMMENT '0: solicitado; 1:comprado; 2:entregado',
  `solicitado_por` int DEFAULT NULL,
  `entregado_por` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitud_compra`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud_compras`
--

INSERT INTO `solicitud_compras` (`id_solicitud_compra`, `id_materia_prima`, `id_solicitud_almacen_materia_prima`, `fecha_registro`, `cantidad`, `unidad`, `estatus`, `solicitado_por`, `entregado_por`) VALUES
(15, 3, 21, '2021-02-08 06:41:02', 12, 'kg', 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_produccion`
--

DROP TABLE IF EXISTS `solicitud_produccion`;
CREATE TABLE IF NOT EXISTS `solicitud_produccion` (
  `id_solicitud_produccion` int NOT NULL AUTO_INCREMENT,
  `id_solicitud_almacen_producto` int NOT NULL,
  `id_producto` int DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  `estatus` int NOT NULL COMMENT '0: Solicitado; 1: Entregado',
  `fecha_registro` timestamp NOT NULL,
  `solicitado_por` int NOT NULL,
  `entregado_por` int DEFAULT NULL,
  PRIMARY KEY (`id_solicitud_produccion`),
  KEY `fk_id_solicitud_almacen_producto_almacen_producto` (`id_solicitud_almacen_producto`),
  KEY `fk_solicitado_por_usuario_solicitud_produccion` (`solicitado_por`),
  KEY `fk_entregado_por_usuario_solicitud_produccion` (`entregado_por`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `solicitud_produccion`
--

INSERT INTO `solicitud_produccion` (`id_solicitud_produccion`, `id_solicitud_almacen_producto`, `id_producto`, `cantidad`, `estatus`, `fecha_registro`, `solicitado_por`, `entregado_por`) VALUES
(24, 22, 19, 22, 0, '2021-02-03 06:25:25', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitud_produccion_materia`
--

DROP TABLE IF EXISTS `solicitud_produccion_materia`;
CREATE TABLE IF NOT EXISTS `solicitud_produccion_materia` (
  `id_solicitud_produccion_materia` int NOT NULL AUTO_INCREMENT,
  `id_solicitud_produccion` int NOT NULL,
  `id_materia_prima` int NOT NULL,
  `estatus_produccion` int NOT NULL COMMENT '0: Solicitado; 1: Entregado (Éste estatus lo ve producción)',
  PRIMARY KEY (`id_solicitud_produccion_materia`) USING BTREE,
  KEY `fk_id_solicitud_produccion_solicitud_produccion_items` (`id_solicitud_produccion`),
  KEY `fk_id_solicitud_requerimiento_item_solicitud_requerimiento_item` (`id_materia_prima`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `cod_usuario` int NOT NULL AUTO_INCREMENT,
  `nom_usuario` varchar(255) NOT NULL,
  `pass_usuario` varchar(255) NOT NULL,
  `ssid` varchar(255) DEFAULT NULL,
  `rol` int DEFAULT NULL,
  PRIMARY KEY (`cod_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cod_usuario`, `nom_usuario`, `pass_usuario`, `ssid`, `rol`) VALUES
(1, 'admin', '8d3d825912f60e5b84fd42cc771ccb68dbeb27cf', 'c279da2fdbadadb4fd839d55010eba945623a391', 1);

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `fk_id_almacen` FOREIGN KEY (`id_almacen`) REFERENCES `almacenes` (`id_almacen`);

--
-- Filtros para la tabla `productos_componentes`
--
ALTER TABLE `productos_componentes`
  ADD CONSTRAINT `fk_id_materia_prima_productos_componentes` FOREIGN KEY (`id_materia_prima`) REFERENCES `materias_primas` (`id_materia_prima`),
  ADD CONSTRAINT `fk_id_producto_productos_componentes` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`);

--
-- Filtros para la tabla `solicitud_almacen_materia_prima`
--
ALTER TABLE `solicitud_almacen_materia_prima`
  ADD CONSTRAINT `fk_entregado_por_solicitud_almacen_materia_prima` FOREIGN KEY (`entregado_por`) REFERENCES `usuario` (`cod_usuario`),
  ADD CONSTRAINT `fk_id_solicitud_produccion_solicitud_almacen_materia_prima` FOREIGN KEY (`id_solicitud_produccion`) REFERENCES `solicitud_produccion` (`id_solicitud_produccion`),
  ADD CONSTRAINT `fk_solicitado_por_solicitud_almacen_materia_prima` FOREIGN KEY (`solicitado_por`) REFERENCES `usuario` (`cod_usuario`);

--
-- Filtros para la tabla `solicitud_almacen_materia_prima_items`
--
ALTER TABLE `solicitud_almacen_materia_prima_items`
  ADD CONSTRAINT `fk_id_solicitud_almacen_materia_prima_solicitud_almacen` FOREIGN KEY (`id_solicitud_almacen_materia_prima`) REFERENCES `solicitud_almacen_materia_prima` (`id_solicitud_almacen_materia_prima`);

--
-- Filtros para la tabla `solicitud_almacen_producto`
--
ALTER TABLE `solicitud_almacen_producto`
  ADD CONSTRAINT `fk_entregado_por_usuario` FOREIGN KEY (`entregado_por`) REFERENCES `usuario` (`cod_usuario`),
  ADD CONSTRAINT `fk_id_solicitud_requerimiento_almacen_producto` FOREIGN KEY (`id_solicitud_cliente`) REFERENCES `solicitud_clientes` (`id_solicitud_cliente`),
  ADD CONSTRAINT `fk_solicitado_por_usuario` FOREIGN KEY (`solicitado_por`) REFERENCES `usuario` (`cod_usuario`);

--
-- Filtros para la tabla `solicitud_clientes`
--
ALTER TABLE `solicitud_clientes`
  ADD CONSTRAINT `fk_id_cliente_solicitud_requerimiento` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `fk_recibido_por_solicitud_requerimiento` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`cod_usuario`);

--
-- Filtros para la tabla `solicitud_clientes_items`
--
ALTER TABLE `solicitud_clientes_items`
  ADD CONSTRAINT `fk_id_producto_solicitud_requerimiento_items` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `fk_id_solicitud_requerimiento_solicitud_requerimiento_items` FOREIGN KEY (`id_solicitud_cliente`) REFERENCES `solicitud_clientes` (`id_solicitud_cliente`);

--
-- Filtros para la tabla `solicitud_produccion`
--
ALTER TABLE `solicitud_produccion`
  ADD CONSTRAINT `fk_entregado_por_usuario_solicitud_produccion` FOREIGN KEY (`entregado_por`) REFERENCES `usuario` (`cod_usuario`),
  ADD CONSTRAINT `fk_id_solicitud_almacen_producto_almacen_producto` FOREIGN KEY (`id_solicitud_almacen_producto`) REFERENCES `solicitud_almacen_producto` (`id_solicitud_almacen_producto`),
  ADD CONSTRAINT `fk_solicitado_por_usuario_solicitud_produccion` FOREIGN KEY (`solicitado_por`) REFERENCES `usuario` (`cod_usuario`);

--
-- Filtros para la tabla `solicitud_produccion_materia`
--
ALTER TABLE `solicitud_produccion_materia`
  ADD CONSTRAINT `fk_id_solicitud_produccion_solicitud_produccion_items` FOREIGN KEY (`id_solicitud_produccion`) REFERENCES `solicitud_produccion` (`id_solicitud_produccion`),
  ADD CONSTRAINT `fk_id_solicitud_requerimiento_item_solicitud_requerimiento_item` FOREIGN KEY (`id_materia_prima`) REFERENCES `solicitud_clientes_items` (`id_solicitud_cliente_item`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
