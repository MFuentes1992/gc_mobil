-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-server
-- Tiempo de generación: 24-01-2024 a las 18:46:47
-- Versión del servidor: 8.3.0
-- Versión de PHP: 8.2.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u579469339_gestion_com`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tbl_visitas`
--

CREATE TABLE `visitas` (
  `id` int NOT NULL,
  `id_usuario` int NOT NULL,
  `id_tipo_visita` int NOT NULL,
  `id_tipo_ingreso` int NOT NULL,
  `id_instalacion` int NOT NULL,
  `fecha_ingreso` varchar(255) NOT NULL,
  `fecha_salida` varchar(255) NOT NULL,
  `multiple_entrada` tinyint(1) NOT NULL,
  `notificaciones` tinyint(1) NOT NULL,
  `uniqueID` varchar(255) NOT NULL,
  `nombre_visita` varchar(255) NOT NULL,
  `fecha_registro` varchar(255) NOT NULL,
  `fecha_actualizacion` varchar(255) NOT NULL,
  `estatus_registro` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tbl_visitas`
--

-- INSERT INTO `visitas` (`id`, `id_usuario`, `id_tipo_visita`, `id_tipo_ingreso`, `fecha_ingreso`, `fecha_salida`, `multiple_entrada`, `notificaciones`, `uniqueID`, `nombre_visita`, `fecha_registro`, `fecha_actualizacion` ,`estatus_registro`) VALUES
-- (1, 7, 2, 1, '2024-01-24T11:17:00', '2024-01-24T17:00:00', 0, 1, '693a3ab9-4118-46cf-b410-373777cc4784', 'Test Visita 1.1', CONVERT(NOW(), CHAR), CONVERT(NOW(), CHAR),1),
-- (2, 8, 1, 1, '2024-01-25T09:00:00', '2024-01-25T19:00:00', 1, 1, '64a3498d-1299-4bc2-ae0f-07b3867d7bb1', 'Test visita 1.2', CONVERT(NOW(), CHAR), CONVERT(NOW(), CHAR),1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tbl_visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tbl_visitas`
--
ALTER TABLE `visitas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
