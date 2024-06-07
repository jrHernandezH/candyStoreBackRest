-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 07-06-2024 a las 07:48:01
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
-- Base de datos: `candy`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_pedido`
--

CREATE TABLE `detalle_pedido` (
  `id` int(11) NOT NULL,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(10,2) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `detalle_pedido`
--

INSERT INTO `detalle_pedido` (`id`, `pedido_id`, `producto_id`, `cantidad`, `precio_unitario`, `subtotal`) VALUES
(2, 2, 3, 3, 19.99, 99.99);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen_producto`
--

CREATE TABLE `imagen_producto` (
  `id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `imagen_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `imagen_producto`
--

INSERT INTO `imagen_producto` (`id`, `producto_id`, `imagen_url`) VALUES
(2, 3, 'https://ejemplo.com/imagen.jpg'),
(3, 10, 'http://localhost/candyStoreRest/src/assets/global/6662544c8a327_photo_0.png'),
(4, 11, 'http://localhost/candyStoreRest/src/assets/global/666254c39156b_photo_0.png'),
(5, 12, 'http://localhost/candyStoreRest/src/assets/global/666254fba986c_photo_0.png'),
(6, 12, 'http://localhost/candyStoreRest/src/assets/global/666254fbad88c_photo_2.png'),
(7, 12, 'http://localhost/candyStoreRest/src/assets/global/666254fbacc13_photo_1.png'),
(8, 13, 'http://localhost/candyStoreRest/src/assets/global/66625672d9897_photo_0.png'),
(9, 14, 'http://localhost/candyStoreRest/src/assets/global/666256b8c7687_photo_0.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `id` int(11) NOT NULL,
  `usuario_id` varchar(50) NOT NULL,
  `direccion_envio` varchar(255) NOT NULL,
  `metodo_pago` varchar(50) NOT NULL,
  `estado` enum('pendiente','enviado','entregado') NOT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`id`, `usuario_id`, `direccion_envio`, `metodo_pago`, `estado`, `fecha_creacion`) VALUES
(2, 'maxconm190@gmail.com', 'Nueva Calle 456, Ciudad Ejemplos', 'Tarjeta de Crédito', 'enviado', '2024-06-05 13:39:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL,
  `origen` varchar(50) DEFAULT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `proveedor` varchar(100) DEFAULT NULL,
  `fecha_creacion` datetime NOT NULL DEFAULT current_timestamp(),
  `fecha_actualizacion` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `stock`, `marca`, `categoria`, `origen`, `tipo`, `proveedor`, `fecha_creacion`, `fecha_actualizacion`) VALUES
(3, 'Chocolates', 'Deliciosos chocolates variados', 10.99, 100, 'Nestlé', 'Dulces', 'Suiza', 'Chocolate con leche', 'Distribuidora Dulce Sabor', '2024-06-05 09:10:58', '2024-06-05 11:12:55'),
(10, 'asd', 'asd', 123.00, 123, 'marcaA', 'categoriaA', 'nacional', 'tipoA', 'asd', '2024-06-06 18:29:00', '2024-06-06 18:29:00'),
(11, 'asd', 'asd', 123.00, 123, 'marcaA', 'categoriaA', 'nacional', 'tipoA', 'asd', '2024-06-06 18:30:59', '2024-06-06 18:30:59'),
(12, 'asd', 'asd', 123.00, 123, 'marcaA', 'categoriaA', 'nacional', 'tipoA', 'asd', '2024-06-06 18:31:55', '2024-06-06 18:31:55'),
(13, 'asd', 'asd', 123.00, 123, 'marcaA', 'categoriaA', 'nacional', 'tipoA', 'asd', '2024-06-06 18:38:10', '2024-06-06 18:38:10'),
(14, 'asd', '1asd', 123.00, 123, 'marcaA', 'categoriaA', 'nacional', 'tipoA', 'asd', '2024-06-06 18:39:20', '2024-06-06 18:39:20');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `cuenta` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellidos` varchar(75) NOT NULL,
  `rfc` varchar(13) DEFAULT NULL,
  `direccion` varchar(255) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `colonia` varchar(100) NOT NULL,
  `codigo_postal` varchar(10) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `telefono` varchar(20) NOT NULL,
  `avatar` text NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT current_timestamp(),
  `activo` enum('activo','inactivo') NOT NULL,
  `rol` enum('cliente','administrador') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`cuenta`, `password`, `nombre`, `apellidos`, `rfc`, `direccion`, `calle`, `colonia`, `codigo_postal`, `ciudad`, `estado`, `telefono`, `avatar`, `fecha_registro`, `activo`, `rol`) VALUES
('L20011247@orizaba.tecnm.mx', '$2y$10$H3pmxzJAmLxKrva4Zgdsd.ytjeY69kYEMD/QXqptAzkABGZH/9fwy', 'Hugo', 'Hernandez Flores', '2023hvzrlga', 'Del Trabajo 12, Benito Juárez, 94744 Cd Mendoza, Ver.', 'Juana de arco', 'Benito Juarez', '94744', 'CD Mendoza', 'Veracruz', '2722341582', 'http://localhost/candyStoreRest/src/assets/avatar/66622fac40030_undraw_Male_avatar_g98d.png', '2024-06-06 15:52:44', 'activo', 'cliente'),
('maxconm190@gmail.com', '$2y$10$cw7s3TP.p04x8JPdMjyuiuYRlgDBjDbtN1dJS.ljAXokQFMKJdg5q', 'Hugo', 'Hernandez Flores', '230602HVZRLGA', 'AV. Del trabajo #8', 'juana de arco', 'Benito Juarez', '94740', 'Camerino Z Mendoza', 'Veracruz', '2722341582', 'http://localhost/candyStoreRest/src/assets/avatar/66622fac40030_undraw_Male_avatar_g98d.png', '2024-06-05 13:23:31', 'activo', 'administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `FK_pedido_id` (`pedido_id`);

--
-- Indices de la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_producto_id` (`producto_id`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`cuenta`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detalle_pedido`
--
ALTER TABLE `detalle_pedido`
  ADD CONSTRAINT `FK_pedido_id` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `detalle_pedido_ibfk_1` FOREIGN KEY (`pedido_id`) REFERENCES `pedido` (`id`),
  ADD CONSTRAINT `detalle_pedido_ibfk_2` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `imagen_producto`
--
ALTER TABLE `imagen_producto`
  ADD CONSTRAINT `FK_producto_id` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `imagen_producto_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `producto` (`id`);

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `pedido_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`cuenta`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
