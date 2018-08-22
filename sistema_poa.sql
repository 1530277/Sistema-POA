-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-04-2018 a las 05:51:01
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sistema_poa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE `actividades` (
  `id_actividad` int(11) NOT NULL,
  `numero` int(11) NOT NULL,
  `id_proyecto` varchar(20) COLLATE utf8_bin NOT NULL,
  `meses_plan` text COLLATE utf8_bin NOT NULL,
  `meses_ejec` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `areas`
--

CREATE TABLE `areas` (
  `id_area` char(5) COLLATE utf8_bin NOT NULL,
  `nombre_area` varchar(20) COLLATE utf8_bin NOT NULL,
  `encargado` int(11) NOT NULL,
  `depende_de` char(5) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ejes_rectores`
--

CREATE TABLE `ejes_rectores` (
  `id_eje` varchar(15) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(15) COLLATE utf8_bin NOT NULL,
  `objetivo` text COLLATE utf8_bin NOT NULL,
  `id_area` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados`
--

CREATE TABLE `empleados` (
  `numero_empleado` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8_bin NOT NULL,
  `apellido_paterno` varchar(20) COLLATE utf8_bin NOT NULL,
  `apellido_materno` varchar(20) COLLATE utf8_bin NOT NULL,
  `calle` varchar(20) COLLATE utf8_bin NOT NULL,
  `colonia_fraccionamiento` varchar(30) COLLATE utf8_bin NOT NULL,
  `numero_casa` varchar(10) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(15) COLLATE utf8_bin NOT NULL,
  `correo` varchar(20) COLLATE utf8_bin NOT NULL,
  `curp` varchar(20) COLLATE utf8_bin NOT NULL,
  `numero_seguro` varchar(24) COLLATE utf8_bin NOT NULL,
  `fecha_ingreso` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleados_puestos`
--

CREATE TABLE `empleados_puestos` (
  `id_empelado` int(11) NOT NULL,
  `id_puesto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `clave` varchar(20) COLLATE utf8_bin NOT NULL,
  `nombre` varchar(20) COLLATE utf8_bin NOT NULL,
  `id_partida` int(11) NOT NULL,
  `unidad` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `partidas`
--

CREATE TABLE `partidas` (
  `id_partida` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programas`
--

CREATE TABLE `programas` (
  `id_programa` int(11) NOT NULL,
  `nombre` int(11) NOT NULL,
  `objetivo` int(11) NOT NULL,
  `id_eje` varchar(15) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `clave` varchar(20) COLLATE utf8_bin NOT NULL,
  `nombre` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_area` int(11) NOT NULL,
  `justificacion` text COLLATE utf8_bin NOT NULL,
  `objetivo` text COLLATE utf8_bin NOT NULL,
  `metas` text COLLATE utf8_bin NOT NULL,
  `indicador_resultados` text COLLATE utf8_bin NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos_materiales`
--

CREATE TABLE `proyectos_materiales` (
  `id_proyecto` varchar(20) COLLATE utf8_bin NOT NULL,
  `id_material` varchar(20) COLLATE utf8_bin NOT NULL,
  `cantidad` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puestos`
--

CREATE TABLE `puestos` (
  `id_puesto` int(11) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_bin NOT NULL,
  `descripcion` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(10) COLLATE utf8_bin NOT NULL,
  `password` varchar(8) COLLATE utf8_bin NOT NULL,
  `nombre_pila` varchar(30) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `password`, `nombre_pila`) VALUES
(1, '1530277', 'luis123', 'Luis Angel Torres Grimaldo'),
(2, 'ojasso', 'omarj', 'Jorge Omar Jasso Luna');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD PRIMARY KEY (`id_actividad`),
  ADD KEY `id_proyecto` (`id_proyecto`);

--
-- Indices de la tabla `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id_area`),
  ADD UNIQUE KEY `encargado` (`encargado`),
  ADD KEY `depende_de` (`depende_de`);

--
-- Indices de la tabla `ejes_rectores`
--
ALTER TABLE `ejes_rectores`
  ADD PRIMARY KEY (`id_eje`);

--
-- Indices de la tabla `empleados`
--
ALTER TABLE `empleados`
  ADD PRIMARY KEY (`numero_empleado`);

--
-- Indices de la tabla `empleados_puestos`
--
ALTER TABLE `empleados_puestos`
  ADD PRIMARY KEY (`id_empelado`,`id_puesto`),
  ADD KEY `id_puesto` (`id_puesto`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`clave`),
  ADD KEY `id_partida` (`id_partida`);

--
-- Indices de la tabla `partidas`
--
ALTER TABLE `partidas`
  ADD PRIMARY KEY (`id_partida`);

--
-- Indices de la tabla `programas`
--
ALTER TABLE `programas`
  ADD PRIMARY KEY (`id_programa`),
  ADD KEY `id_eje` (`id_eje`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`clave`),
  ADD KEY `id_programa` (`id_programa`);

--
-- Indices de la tabla `proyectos_materiales`
--
ALTER TABLE `proyectos_materiales`
  ADD PRIMARY KEY (`id_proyecto`,`id_material`),
  ADD KEY `id_material` (`id_material`);

--
-- Indices de la tabla `puestos`
--
ALTER TABLE `puestos`
  ADD PRIMARY KEY (`id_puesto`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividades`
--
ALTER TABLE `actividades`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `empleados`
--
ALTER TABLE `empleados`
  MODIFY `numero_empleado` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `puestos`
--
ALTER TABLE `puestos`
  MODIFY `id_puesto` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`clave`);

--
-- Filtros para la tabla `areas`
--
ALTER TABLE `areas`
  ADD CONSTRAINT `areas_ibfk_1` FOREIGN KEY (`depende_de`) REFERENCES `areas` (`id_area`),
  ADD CONSTRAINT `areas_ibfk_2` FOREIGN KEY (`encargado`) REFERENCES `empleados` (`numero_empleado`);

--
-- Filtros para la tabla `empleados_puestos`
--
ALTER TABLE `empleados_puestos`
  ADD CONSTRAINT `empleados_puestos_ibfk_1` FOREIGN KEY (`id_empelado`) REFERENCES `empleados` (`numero_empleado`),
  ADD CONSTRAINT `empleados_puestos_ibfk_2` FOREIGN KEY (`id_puesto`) REFERENCES `puestos` (`id_puesto`);

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `materiales_ibfk_1` FOREIGN KEY (`id_partida`) REFERENCES `partidas` (`id_partida`);

--
-- Filtros para la tabla `programas`
--
ALTER TABLE `programas`
  ADD CONSTRAINT `programas_ibfk_1` FOREIGN KEY (`id_eje`) REFERENCES `ejes_rectores` (`id_eje`);

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programas` (`id_programa`);

--
-- Filtros para la tabla `proyectos_materiales`
--
ALTER TABLE `proyectos_materiales`
  ADD CONSTRAINT `proyectos_materiales_ibfk_1` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`clave`),
  ADD CONSTRAINT `proyectos_materiales_ibfk_2` FOREIGN KEY (`id_material`) REFERENCES `materiales` (`clave`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
