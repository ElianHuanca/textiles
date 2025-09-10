-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-09-2025 a las 21:57:07
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
(20, 'Verde Pistacho', '93C572');

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
(2, 1, '2025-09-10', 0.00, 0.00),
(3, 1, '2025-09-10', 0.00, 0.00);

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
(2, 1, 4, 10.00, 0.00, 0.00),
(2, 1, 5, 29.00, 0.00, 0.00),
(2, 1, 6, 11.00, 0.00, 0.00),
(2, 1, 7, 9.00, 0.00, 0.00),
(2, 1, 8, 7.00, 0.00, 0.00),
(2, 1, 9, 5.00, 0.00, 0.00),
(2, 1, 10, 5.00, 0.00, 0.00),
(2, 1, 11, 4.00, 0.00, 0.00),
(2, 1, 12, 2.00, 0.00, 0.00),
(2, 1, 13, 3.00, 0.00, 0.00),
(2, 1, 14, 1.00, 0.00, 0.00),
(2, 1, 15, 2.00, 0.00, 0.00),
(2, 1, 16, 2.00, 0.00, 0.00),
(3, 1, 18, 1.00, 0.00, 0.00),
(3, 1, 19, 1.00, 0.00, 0.00),
(3, 2, 20, 1.00, 0.00, 0.00);

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
(1, 1, 1, 10.00),
(1, 1, 2, 5.00),
(1, 1, 3, 14.00),
(1, 1, 4, 10.00),
(1, 1, 5, 29.00),
(1, 1, 6, 11.00),
(1, 1, 7, 9.00),
(1, 1, 8, 7.00),
(1, 1, 9, 5.00),
(1, 1, 10, 5.00),
(1, 1, 11, 4.00),
(1, 1, 12, 2.00),
(1, 1, 13, 3.00),
(1, 1, 14, 1.00),
(1, 1, 15, 2.00),
(1, 1, 16, 2.00),
(1, 1, 17, 0.00),
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
(2, 1, 17, 0.00);

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
(3, 'Flor Suizo - Bolsa x100 und - Pequeno', NULL, 0.00, 2, 1);

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
  `fecha` date DEFAULT NULL,
  `total` decimal(6,2) DEFAULT NULL,
  `descuento` decimal(6,2) DEFAULT NULL,
  `total_ganancias` decimal(6,2) DEFAULT NULL,
  `sucursal_id` tinyint(3) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `venta_producto`
--
ALTER TABLE `venta_producto`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

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
