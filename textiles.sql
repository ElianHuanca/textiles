-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2025 a las 01:17:45
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `textiles`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `categoria`) VALUES
(1, 'Tela'),
(2, 'Aplique');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `colores`
--

CREATE TABLE `colores` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `color` varchar(100) DEFAULT NULL,
  `codigo` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `colores`
--

INSERT INTO `colores` (`id`, `color`, `codigo`) VALUES
(1, 'Blanco', 'FFFFFF'),
(2, 'Negro', '000000'),
(3, 'Fuchsia', 'FF00FF'),
(4, 'Verde Agua', '00FFFF'),
(5, 'Guindo', '800000'),
(6, 'Azul Electrico', '0000FF'),
(7, 'Verde Botella', '006B3F'),
(8, 'Azul Marino', '000080'),
(9, 'Amarillo', 'FFFF00'),
(10, 'Lila', 'D29BFD'),
(11, 'Rojo', 'FF0000'),
(12, 'Rosado', 'FF69B4'),
(13, 'Rosado Bebe', 'FFB6C1'),
(14, 'Celeste', '00BFFF'),
(15, 'Celeste Azulado', '6DACEF'),
(16, 'Palo De Rosa', 'D7A9A9'),
(17, 'Perla', 'EAE0C8'),
(18, 'Rojo Sandia', 'FA2348'),
(19, 'Palo De Rosa Oscuro', 'BA7B7C'),
(20, 'Verde Pistacho', '93C572'),
(21, 'Melon', 'FDAD70'),
(22, 'Dorado', 'F9DB5C'),
(23, 'Marfil', 'FFFFE3'),
(24, 'Terracota', 'C9511D'),
(25, 'Verde Esmeralda', '57BD9E'),
(26, 'Verde Esmeralda Fuerte', '2CA880'),
(27, 'Gris', 'AAAAAA'),
(28, 'Purpura', 'A1045A'),
(29, 'Barnie', '67032F'),
(30, 'Vino', '722F37');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(10) UNSIGNED NOT NULL,
  `sucursal_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `total` decimal(6,2) DEFAULT NULL,
  `total_gastos` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compras`
--

INSERT INTO `compras` (`id`, `sucursal_id`, `fecha`, `total`, `total_gastos`) VALUES
(1, 1, '2025-09-10', 0.00, 0.00),
(9, 1, '2025-09-19', 0.00, 0.00),
(10, 1, '2025-09-19', 0.00, 0.00),
(11, 1, '2025-09-20', 0.00, 0.00),
(12, 1, '2025-09-20', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compra_producto`
--

CREATE TABLE `compra_producto` (
  `compra_id` int(10) UNSIGNED NOT NULL,
  `producto_id` tinyint(3) UNSIGNED NOT NULL,
  `color_id` tinyint(3) UNSIGNED NOT NULL,
  `cantidad` decimal(6,2) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL,
  `subtotal` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `compra_producto`
--

INSERT INTO `compra_producto` (`compra_id`, `producto_id`, `color_id`, `cantidad`, `precio`, `subtotal`) VALUES
(1, 1, 1, 10.00, 0.00, 0.00),
(1, 1, 2, 5.00, 0.00, 0.00),
(1, 1, 3, 14.00, 0.00, 0.00),
(1, 1, 4, 10.00, 0.00, 0.00),
(1, 1, 5, 29.00, 0.00, 0.00),
(1, 1, 6, 11.00, 0.00, 0.00),
(1, 1, 7, 9.00, 0.00, 0.00),
(1, 1, 8, 7.00, 0.00, 0.00),
(1, 1, 9, 5.00, 0.00, 0.00),
(1, 1, 10, 5.00, 0.00, 0.00),
(1, 1, 11, 4.00, 0.00, 0.00),
(1, 1, 12, 2.00, 0.00, 0.00),
(1, 1, 13, 3.00, 0.00, 0.00),
(1, 1, 14, 1.00, 0.00, 0.00),
(1, 1, 15, 2.00, 0.00, 0.00),
(1, 1, 16, 2.00, 0.00, 0.00),
(1, 1, 18, 1.00, 0.00, 0.00),
(1, 1, 19, 1.00, 0.00, 0.00),
(1, 2, 20, 1.00, 0.00, 0.00),
(1, 3, 1, 7.00, 0.00, 0.00),
(1, 3, 2, 9.00, 0.00, 0.00),
(1, 3, 3, 21.00, 0.00, 0.00),
(1, 3, 4, 2.00, 0.00, 0.00),
(1, 3, 5, 15.00, 0.00, 0.00),
(1, 3, 6, 4.00, 0.00, 0.00),
(1, 3, 9, 4.00, 0.00, 0.00),
(1, 3, 10, 8.00, 0.00, 0.00),
(1, 3, 11, 3.00, 0.00, 0.00),
(1, 3, 14, 10.00, 0.00, 0.00),
(1, 3, 15, 2.00, 0.00, 0.00),
(1, 3, 16, 3.00, 0.00, 0.00),
(1, 3, 17, 2.00, 0.00, 0.00),
(1, 3, 21, 10.00, 0.00, 0.00),
(1, 3, 23, 4.00, 0.00, 0.00),
(1, 4, 22, 2.00, 0.00, 0.00),
(1, 5, 1, 8.00, 0.00, 0.00),
(1, 5, 2, 2.00, 0.00, 0.00),
(1, 5, 3, 16.00, 0.00, 0.00),
(1, 5, 4, 1.00, 0.00, 0.00),
(1, 5, 5, 2.00, 0.00, 0.00),
(1, 5, 6, 1.00, 0.00, 0.00),
(1, 5, 7, 8.00, 0.00, 0.00),
(1, 5, 8, 3.00, 0.00, 0.00),
(1, 5, 9, 6.00, 0.00, 0.00),
(1, 5, 10, 5.00, 0.00, 0.00),
(1, 5, 11, 5.00, 0.00, 0.00),
(1, 5, 14, 5.00, 0.00, 0.00),
(1, 5, 17, 3.00, 0.00, 0.00),
(1, 5, 19, 1.00, 0.00, 0.00),
(1, 5, 20, 1.00, 0.00, 0.00),
(1, 5, 21, 8.00, 0.00, 0.00),
(1, 5, 22, 5.00, 0.00, 0.00),
(1, 5, 23, 9.00, 0.00, 0.00),
(1, 5, 24, 5.00, 0.00, 0.00),
(1, 5, 25, 2.00, 0.00, 0.00),
(1, 5, 26, 1.00, 0.00, 0.00),
(1, 5, 27, 3.00, 0.00, 0.00),
(1, 5, 28, 1.00, 0.00, 0.00),
(1, 5, 29, 2.00, 0.00, 0.00),
(1, 5, 30, 1.00, 0.00, 0.00),
(9, 3, 5, 1.00, 0.00, 0.00),
(9, 6, 1, 8.00, 0.00, 0.00),
(9, 6, 3, 3.00, 0.00, 0.00),
(9, 6, 4, 2.00, 0.00, 0.00),
(9, 6, 11, 6.00, 0.00, 0.00),
(9, 6, 13, 7.00, 0.00, 0.00),
(9, 6, 16, 3.00, 0.00, 0.00),
(9, 7, 1, 10.00, 0.00, 0.00),
(9, 7, 2, 10.00, 0.00, 0.00),
(9, 7, 3, 5.00, 0.00, 0.00),
(9, 7, 7, 1.00, 0.00, 0.00),
(9, 7, 11, 22.00, 0.00, 0.00),
(9, 7, 12, 1.00, 0.00, 0.00),
(9, 7, 17, 8.00, 0.00, 0.00),
(9, 8, 1, 6.00, 0.00, 0.00),
(9, 8, 3, 11.00, 0.00, 0.00),
(9, 8, 4, 20.80, 0.00, 0.00),
(9, 8, 10, 1.00, 0.00, 0.00),
(9, 8, 12, 3.50, 0.00, 0.00),
(9, 8, 14, 4.00, 0.00, 0.00),
(9, 8, 21, 3.00, 0.00, 0.00),
(9, 9, 1, 4.00, 0.00, 0.00),
(9, 9, 3, 4.00, 0.00, 0.00),
(9, 9, 9, 6.00, 0.00, 0.00),
(9, 9, 12, 8.00, 0.00, 0.00),
(9, 9, 14, 1.00, 0.00, 0.00),
(9, 9, 16, 5.00, 0.00, 0.00),
(9, 9, 17, 1.00, 0.00, 0.00),
(9, 9, 21, 7.00, 0.00, 0.00),
(10, 1, 11, 1.00, 0.00, 0.00),
(10, 5, 10, 7.00, 0.00, 0.00),
(10, 5, 14, 1.00, 0.00, 0.00),
(11, 3, 16, 1.00, 0.00, 0.00),
(12, 1, 11, 21.00, 0.00, 0.00),
(12, 3, 2, 3.00, 0.00, 0.00),
(12, 3, 5, 5.00, 0.00, 0.00),
(12, 3, 9, 6.00, 0.00, 0.00),
(12, 3, 21, 14.00, 0.00, 0.00),
(12, 6, 13, 4.00, 0.00, 0.00),
(12, 6, 16, 2.00, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gastos`
--

CREATE TABLE `gastos` (
  `tipo_gasto_id` tinyint(3) UNSIGNED NOT NULL,
  `compra_id` int(10) UNSIGNED NOT NULL,
  `gasto` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventario`
--

CREATE TABLE `inventario` (
  `sucursal_id` tinyint(3) UNSIGNED NOT NULL,
  `producto_id` tinyint(3) UNSIGNED NOT NULL,
  `color_id` tinyint(3) UNSIGNED NOT NULL,
  `stock` decimal(6,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `inventario`
--

INSERT INTO `inventario` (`sucursal_id`, `producto_id`, `color_id`, `stock`) VALUES
(1, 1, 1, 9.00),
(1, 1, 2, 5.00),
(1, 1, 3, 14.00),
(1, 1, 4, 9.00),
(1, 1, 5, 29.00),
(1, 1, 6, 11.00),
(1, 1, 7, 9.00),
(1, 1, 8, 6.00),
(1, 1, 9, 4.00),
(1, 1, 10, 4.00),
(1, 1, 11, 25.00),
(1, 1, 12, 0.00),
(1, 1, 13, 0.00),
(1, 1, 14, 0.00),
(1, 1, 15, 2.00),
(1, 1, 16, 1.00),
(1, 1, 17, 0.00),
(1, 1, 18, 1.00),
(1, 1, 19, 1.00),
(1, 2, 20, 1.00),
(1, 3, 1, 7.00),
(1, 3, 2, 12.00),
(1, 3, 3, 21.00),
(1, 3, 4, 2.00),
(1, 3, 5, 21.00),
(1, 3, 6, 4.00),
(1, 3, 9, 10.00),
(1, 3, 10, 8.00),
(1, 3, 11, 2.00),
(1, 3, 14, 10.00),
(1, 3, 15, 2.00),
(1, 3, 16, 0.00),
(1, 3, 17, 2.00),
(1, 3, 21, 24.00),
(1, 3, 23, 4.00),
(1, 4, 22, 0.00),
(1, 5, 1, 7.00),
(1, 5, 2, 1.00),
(1, 5, 3, 15.00),
(1, 5, 4, 1.00),
(1, 5, 5, 1.00),
(1, 5, 6, 0.00),
(1, 5, 7, 6.00),
(1, 5, 8, 3.00),
(1, 5, 9, 4.00),
(1, 5, 10, 10.00),
(1, 5, 11, 4.00),
(1, 5, 14, 3.00),
(1, 5, 16, 0.00),
(1, 5, 17, 2.00),
(1, 5, 19, 0.00),
(1, 5, 20, 0.00),
(1, 5, 21, 7.00),
(1, 5, 22, 4.00),
(1, 5, 23, 7.00),
(1, 5, 24, 4.00),
(1, 5, 25, 2.00),
(1, 5, 26, 1.00),
(1, 5, 27, 3.00),
(1, 5, 28, 0.00),
(1, 5, 29, 2.00),
(1, 5, 30, 0.00),
(1, 6, 1, 8.00),
(1, 6, 3, 3.00),
(1, 6, 4, 2.00),
(1, 6, 11, 6.00),
(1, 6, 13, 11.00),
(1, 6, 16, 5.00),
(1, 7, 1, 10.00),
(1, 7, 2, 10.00),
(1, 7, 3, 5.00),
(1, 7, 7, 1.00),
(1, 7, 11, 22.00),
(1, 7, 12, 1.00),
(1, 7, 17, 8.00),
(1, 7, 30, 0.00),
(1, 8, 1, 6.00),
(1, 8, 3, 11.00),
(1, 8, 4, 20.80),
(1, 8, 10, 1.00),
(1, 8, 12, 3.50),
(1, 8, 14, 4.00),
(1, 8, 21, 3.00),
(1, 9, 1, 4.00),
(1, 9, 3, 4.00),
(1, 9, 9, 6.00),
(1, 9, 12, 8.00),
(1, 9, 14, 1.00),
(1, 9, 16, 5.00),
(1, 9, 17, 1.00),
(1, 9, 21, 7.00),
(2, 1, 1, 0.00),
(2, 1, 2, 0.00),
(2, 1, 3, 0.00),
(2, 1, 4, 0.00),
(2, 1, 5, 0.00),
(2, 1, 6, 0.00),
(2, 1, 7, 0.00),
(2, 1, 8, 0.00),
(2, 1, 9, 0.00),
(2, 1, 10, 0.00),
(2, 1, 11, 0.00),
(2, 1, 12, 0.00),
(2, 1, 13, 0.00),
(2, 1, 14, 0.00),
(2, 1, 15, 0.00),
(2, 1, 16, 0.00),
(2, 1, 17, 0.00),
(2, 1, 18, 0.00),
(2, 1, 19, 0.00),
(2, 2, 20, 0.00),
(2, 3, 1, 0.00),
(2, 3, 2, 0.00),
(2, 3, 3, 0.00),
(2, 3, 4, 0.00),
(2, 3, 5, 0.00),
(2, 3, 6, 0.00),
(2, 3, 9, 0.00),
(2, 3, 10, 0.00),
(2, 3, 11, 0.00),
(2, 3, 14, 0.00),
(2, 3, 15, 0.00),
(2, 3, 16, 0.00),
(2, 3, 17, 0.00),
(2, 3, 21, 0.00),
(2, 3, 22, 0.00),
(2, 3, 23, 0.00),
(2, 5, 1, 0.00),
(2, 5, 2, 0.00),
(2, 5, 3, 0.00),
(2, 5, 4, 0.00),
(2, 5, 5, 0.00),
(2, 5, 6, 0.00),
(2, 5, 7, 0.00),
(2, 5, 8, 0.00),
(2, 5, 9, 0.00),
(2, 5, 10, 0.00),
(2, 5, 11, 0.00),
(2, 5, 14, 0.00),
(2, 5, 16, 0.00),
(2, 5, 17, 0.00),
(2, 5, 19, 0.00),
(2, 5, 20, 0.00),
(2, 5, 21, 0.00),
(2, 5, 22, 0.00),
(2, 5, 23, 0.00),
(2, 5, 24, 0.00),
(2, 5, 25, 0.00),
(2, 5, 26, 0.00),
(2, 5, 27, 0.00),
(2, 5, 28, 0.00),
(2, 5, 29, 0.00),
(2, 5, 30, 0.00),
(2, 6, 1, 0.00),
(2, 6, 3, 0.00),
(2, 6, 4, 0.00),
(2, 6, 11, 0.00),
(2, 6, 13, 0.00),
(2, 6, 16, 0.00),
(2, 7, 1, 0.00),
(2, 7, 2, 0.00),
(2, 7, 3, 0.00),
(2, 7, 7, 0.00),
(2, 7, 11, 0.00),
(2, 7, 12, 0.00),
(2, 7, 17, 0.00),
(2, 7, 30, 0.00),
(2, 8, 1, 0.00),
(2, 8, 3, 0.00),
(2, 8, 4, 0.00),
(2, 8, 10, 0.00),
(2, 8, 12, 0.00),
(2, 8, 14, 0.00),
(2, 8, 21, 0.00),
(2, 9, 1, 0.00),
(2, 9, 3, 0.00),
(2, 9, 9, 0.00),
(2, 9, 12, 0.00),
(2, 9, 14, 0.00),
(2, 9, 16, 0.00),
(2, 9, 17, 0.00),
(2, 9, 21, 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `producto` varchar(100) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `costo` decimal(6,2) DEFAULT 0.00,
  `categoria_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `producto`, `url`, `costo`, `categoria_id`, `activo`) VALUES
(1, 'Flor Petalo Suizo Grande - Bolsa x100 und', NULL, 0.00, 2, 1),
(2, 'Flor Petalo Razo Grande - Bolsa x100 und	', NULL, 0.00, 2, 1),
(3, 'Flor Petalo Suizo Pequeno - Bolsa x100 und', NULL, 0.00, 2, 1),
(4, 'Flor Petalo Brilloso Pequeno - Bolsa x100 und	', NULL, 0.00, 2, 1),
(5, 'Mariposa Razo Mediano - Bolsa x100 und', NULL, 0.00, 2, 1),
(6, 'Mariposa Suizo Mediano - Bolsa x100 und	', NULL, 0.00, 2, 1),
(7, 'Mariposa Razo Grande - Bolsa x100 und	', NULL, 0.00, 2, 1),
(8, 'Mariposa Razo Chico - Bolsa x100 und', NULL, 0.00, 2, 1),
(9, 'Mariposa Razo Extra Chico - Bolsa x100 und', NULL, 0.00, 2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sucursales`
--

CREATE TABLE `sucursales` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `sucursal` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `sucursales`
--

INSERT INTO `sucursales` (`id`, `sucursal`) VALUES
(1, 'Ramada'),
(2, 'Feria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_gastos`
--

CREATE TABLE `tipos_gastos` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `tipo_gasto` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_gastos`
--

INSERT INTO `tipos_gastos` (`id`, `tipo_gasto`) VALUES
(1, 'Transporte Terrestre'),
(2, 'Transporte Maritimo'),
(3, 'Transporte Aereo'),
(4, 'Nacionalizacion'),
(5, 'Poliza'),
(6, 'Taxi');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

CREATE TABLE `ventas` (
  `id` int(10) UNSIGNED NOT NULL,
  `fecha` date NOT NULL DEFAULT curdate(),
  `total` decimal(6,2) DEFAULT NULL,
  `descuento` decimal(6,2) DEFAULT NULL,
  `total_ganancias` decimal(6,2) DEFAULT NULL,
  `sucursal_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `fecha`, `total`, `descuento`, `total_ganancias`, `sucursal_id`) VALUES
(1, '2025-09-12', 345.00, 0.00, 0.00, 1),
(3, '2025-09-19', 403.00, 0.00, 0.00, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_producto`
--

CREATE TABLE `venta_producto` (
  `id` int(10) UNSIGNED NOT NULL,
  `venta_id` int(10) UNSIGNED DEFAULT NULL,
  `producto_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `color_id` tinyint(3) UNSIGNED DEFAULT NULL,
  `cantidad` decimal(6,2) DEFAULT NULL,
  `precio` decimal(6,2) DEFAULT NULL,
  `subtotal` decimal(6,2) DEFAULT NULL,
  `ganancias` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `venta_producto`
--

INSERT INTO `venta_producto` (`id`, `venta_id`, `producto_id`, `color_id`, `cantidad`, `precio`, `subtotal`, `ganancias`) VALUES
(1, 1, 1, 9, 1.00, 18.00, 18.00, 0.00),
(2, 1, 1, 16, 1.00, 18.00, 18.00, 0.00),
(3, 1, 1, 11, 1.00, 18.00, 18.00, 0.00),
(4, 1, 1, 8, 1.00, 18.00, 18.00, 0.00),
(5, 1, 1, 1, 1.00, 18.00, 18.00, 0.00),
(6, 1, 1, 10, 1.00, 18.00, 18.00, 0.00),
(7, 1, 1, 13, 1.00, 18.00, 18.00, 0.00),
(8, 1, 1, 14, 1.00, 18.00, 18.00, 0.00),
(9, 1, 1, 4, 1.00, 18.00, 18.00, 0.00),
(10, 1, 4, 22, 2.00, 18.00, 36.00, 0.00),
(11, 1, 5, 14, 2.00, 13.00, 26.00, 0.00),
(12, 1, 5, 2, 1.00, 13.00, 13.00, 0.00),
(13, 1, 5, 7, 1.00, 13.00, 13.00, 0.00),
(14, 1, 5, 23, 1.00, 13.00, 13.00, 0.00),
(15, 1, 5, 10, 1.00, 13.00, 13.00, 0.00),
(16, 1, 5, 9, 1.00, 13.00, 13.00, 0.00),
(17, 1, 5, 19, 1.00, 13.00, 13.00, 0.00),
(18, 1, 5, 17, 1.00, 13.00, 13.00, 0.00),
(19, 1, 5, 30, 1.00, 13.00, 13.00, 0.00),
(20, 1, 3, 16, 1.00, 17.00, 17.00, 0.00),
(21, 3, 1, 13, 2.00, 22.00, 44.00, 0.00),
(22, 3, 1, 12, 2.00, 22.00, 44.00, 0.00),
(23, 3, 5, 9, 1.00, 17.00, 17.00, 0.00),
(24, 3, 5, 6, 1.00, 17.00, 17.00, 0.00),
(25, 3, 5, 1, 1.00, 17.00, 17.00, 0.00),
(26, 3, 5, 24, 1.00, 17.00, 17.00, 0.00),
(27, 3, 5, 21, 1.00, 17.00, 17.00, 0.00),
(28, 3, 5, 7, 1.00, 17.00, 17.00, 0.00),
(29, 3, 5, 23, 1.00, 17.00, 17.00, 0.00),
(30, 3, 5, 14, 1.00, 17.00, 17.00, 0.00),
(31, 3, 5, 20, 1.00, 17.00, 17.00, 0.00),
(32, 3, 5, 22, 1.00, 17.00, 17.00, 0.00),
(33, 3, 5, 5, 1.00, 17.00, 17.00, 0.00),
(34, 3, 5, 10, 1.00, 17.00, 17.00, 0.00),
(35, 3, 5, 28, 1.00, 17.00, 17.00, 0.00),
(36, 3, 5, 11, 1.00, 17.00, 17.00, 0.00),
(37, 3, 5, 3, 1.00, 17.00, 17.00, 0.00),
(38, 3, 3, 16, 3.00, 15.00, 45.00, 0.00),
(39, 3, 3, 11, 1.00, 15.00, 15.00, 0.00);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `colores`
--
ALTER TABLE `colores`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sucursal_id` (`sucursal_id`);

--
-- Indices de la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  ADD PRIMARY KEY (`compra_id`,`producto_id`,`color_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indices de la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD PRIMARY KEY (`tipo_gasto_id`,`compra_id`),
  ADD KEY `compra_id` (`compra_id`);

--
-- Indices de la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD PRIMARY KEY (`sucursal_id`,`producto_id`,`color_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `color_id` (`color_id`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categoria_id` (`categoria_id`);

--
-- Indices de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_gastos`
--
ALTER TABLE `tipos_gastos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sucursal_id` (`sucursal_id`);

--
-- Indices de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `color_id` (`color_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `colores`
--
ALTER TABLE `colores`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `sucursales`
--
ALTER TABLE `sucursales`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipos_gastos`
--
ALTER TABLE `tipos_gastos`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `ventas`
--
ALTER TABLE `ventas`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `compra_producto`
--
ALTER TABLE `compra_producto`
  ADD CONSTRAINT `compra_producto_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `compra_producto_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `compra_producto_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`);

--
-- Filtros para la tabla `gastos`
--
ALTER TABLE `gastos`
  ADD CONSTRAINT `gastos_ibfk_1` FOREIGN KEY (`compra_id`) REFERENCES `compras` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `gastos_ibfk_2` FOREIGN KEY (`tipo_gasto_id`) REFERENCES `tipos_gastos` (`id`);

--
-- Filtros para la tabla `inventario`
--
ALTER TABLE `inventario`
  ADD CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`),
  ADD CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`);

--
-- Filtros para la tabla `productos`
--
ALTER TABLE `productos`
  ADD CONSTRAINT `productos_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`sucursal_id`) REFERENCES `sucursales` (`id`);

--
-- Filtros para la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  ADD CONSTRAINT `venta_producto_ibfk_1` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `venta_producto_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `venta_producto_ibfk_3` FOREIGN KEY (`color_id`) REFERENCES `colores` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
