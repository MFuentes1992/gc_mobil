-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: mysql-server
-- Tiempo de generación: 24-01-2024 a las 18:47:21
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
-- Estructura de tabla para la tabla `lst_TipoVisita`
--

CREATE TABLE `lst_tipo_visita` (
  `id` int NOT NULL,
  `tipo_visita` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `estatus` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lst_TipoVisita`
--

INSERT INTO `lst_tipo_visita` (`id`, `tipo_visita`, `descripcion`, `estatus`) VALUES
(1, 'Visita', 'Vista a casa', 1),
(2, 'Servicio domestico', 'Servicios de limpieza en general', 1),
(3, 'Provedor', 'Provedor de servicios, cable, mant, etc.', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `lst_TipoVisita`
--
ALTER TABLE `lst_tipo_visita`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `lst_TipoVisita`
--
ALTER TABLE `lst_tipo_visita`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
