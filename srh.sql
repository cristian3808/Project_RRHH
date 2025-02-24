-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-02-2025 a las 21:37:38
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
-- Base de datos: `srh`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`id`, `usuario`, `password`) VALUES
(1, 'Admin', '$2y$10$6y3UnxJMY5POqmiHwjpNWOG43JNCRZF7n4Zq5b4dtJrYwVasDOK/C');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anios`
--

CREATE TABLE `anios` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `anios`
--

INSERT INTO `anios` (`id`, `titulo`) VALUES
(1, '2025'),
(2, '2026'),
(3, '2027'),
(4, '2028'),
(5, '2029'),
(6, '2030'),
(7, '2031'),
(8, '2032'),
(9, '2033'),
(10, '2034'),
(11, '2035'),
(12, '2036'),
(13, '2037'),
(14, '2038'),
(15, '2039'),
(16, '2040'),
(17, '2041'),
(18, '2042'),
(19, '2043'),
(20, '2044');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `botas`
--

CREATE TABLE `botas` (
  `id` int(11) NOT NULL,
  `cantidad_botas` varchar(10) NOT NULL,
  `talla_botas` varchar(10) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camisas_hombre`
--

CREATE TABLE `camisas_hombre` (
  `id` int(11) NOT NULL,
  `cantidad_camisas` int(11) NOT NULL,
  `talla_camisas` varchar(10) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `camisas_mujer`
--

CREATE TABLE `camisas_mujer` (
  `id` int(11) NOT NULL,
  `cantidad_camisas` int(11) NOT NULL,
  `talla_camisas` varchar(10) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cascos`
--

CREATE TABLE `cascos` (
  `id` int(11) NOT NULL,
  `cantidad_cascos` int(11) NOT NULL,
  `anio_id` int(11) NOT NULL,
  `fecha_subida` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gafas`
--

CREATE TABLE `gafas` (
  `id` int(11) NOT NULL,
  `color_gafas` varchar(40) NOT NULL,
  `cantidad_gafas` int(11) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `gafas_especiales`
--

CREATE TABLE `gafas_especiales` (
  `id` int(11) NOT NULL,
  `color_gafas_especiales` varchar(40) NOT NULL,
  `cantidad_gafas_especiales` int(11) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guantes`
--

CREATE TABLE `guantes` (
  `id` int(11) NOT NULL,
  `cantidad_guantes` int(11) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jeans_hombre`
--

CREATE TABLE `jeans_hombre` (
  `id` int(11) NOT NULL,
  `cantidad_jeans` int(11) NOT NULL,
  `talla_jeans` varchar(10) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `jeans_mujer`
--

CREATE TABLE `jeans_mujer` (
  `id` int(11) NOT NULL,
  `cantidad_jeans` int(11) NOT NULL,
  `talla_jeans` varchar(10) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mascarillas`
--

CREATE TABLE `mascarillas` (
  `id` int(11) NOT NULL,
  `cantidad_mascarillas` int(11) NOT NULL,
  `anio_id` int(11) NOT NULL,
  `fecha_subida` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `nomex`
--

CREATE TABLE `nomex` (
  `id` int(11) NOT NULL,
  `cantidad_nomex` int(10) NOT NULL,
  `talla_nomex` varchar(10) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proyectos`
--

CREATE TABLE `proyectos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tapabocas`
--

CREATE TABLE `tapabocas` (
  `id` int(11) NOT NULL,
  `cantidad_tapabocas` int(11) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tapa_oidos`
--

CREATE TABLE `tapa_oidos` (
  `id` int(11) NOT NULL,
  `nombre_tapa_oidos` varchar(40) NOT NULL,
  `cantidad_tapa_oidos` int(11) NOT NULL,
  `fecha_subida` date NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombres` varchar(100) NOT NULL,
  `apellidos` varchar(50) NOT NULL,
  `cedula` varchar(20) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `anio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios_r`
--

CREATE TABLE `usuarios_r` (
  `id` int(11) NOT NULL,
  `nombres` varchar(50) DEFAULT NULL,
  `apellidos` varchar(50) DEFAULT NULL,
  `genero` varchar(55) DEFAULT NULL,
  `cedula` varchar(50) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `lugar_nacimiento` varchar(255) DEFAULT NULL,
  `fecha_expedicion_cedula` date DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `municipio_residencia` varchar(50) NOT NULL,
  `nombre_contacto` varchar(255) DEFAULT NULL,
  `telefono_contacto` varchar(20) DEFAULT NULL,
  `tipo_sangre` varchar(60) DEFAULT NULL,
  `eps` varchar(60) DEFAULT NULL,
  `arl` varchar(60) DEFAULT NULL,
  `fondo_pension` varchar(50) DEFAULT NULL,
  `hoja_vida` varchar(255) DEFAULT NULL,
  `subir_cedula` varchar(255) DEFAULT NULL,
  `certificados_estudio` varchar(255) DEFAULT NULL,
  `certificados_laborales` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `certificados_eps` varchar(255) NOT NULL,
  `carnet_vacunas` varchar(255) DEFAULT NULL,
  `certificacion_bancaria` varchar(255) DEFAULT NULL,
  `certificado_antecedentes` varchar(255) DEFAULT NULL,
  `certificado_afp` varchar(255) NOT NULL,
  `certificados_territorialidad` varchar(255) DEFAULT NULL,
  `talla_camisa` varchar(10) DEFAULT NULL,
  `talla_pantalon` varchar(10) DEFAULT NULL,
  `talla_botas` varchar(10) DEFAULT NULL,
  `talla_nomex` varchar(10) DEFAULT NULL,
  `enviado` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `anios`
--
ALTER TABLE `anios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `botas`
--
ALTER TABLE `botas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `camisas_hombre`
--
ALTER TABLE `camisas_hombre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `camisas_mujer`
--
ALTER TABLE `camisas_mujer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cascos`
--
ALTER TABLE `cascos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gafas`
--
ALTER TABLE `gafas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `gafas_especiales`
--
ALTER TABLE `gafas_especiales`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `guantes`
--
ALTER TABLE `guantes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jeans_hombre`
--
ALTER TABLE `jeans_hombre`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `jeans_mujer`
--
ALTER TABLE `jeans_mujer`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `mascarillas`
--
ALTER TABLE `mascarillas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `nomex`
--
ALTER TABLE `nomex`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anio_id` (`anio_id`);

--
-- Indices de la tabla `tapabocas`
--
ALTER TABLE `tapabocas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tapa_oidos`
--
ALTER TABLE `tapa_oidos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cedula` (`cedula`),
  ADD UNIQUE KEY `correo` (`correo`),
  ADD KEY `usuarios_ibfk_1` (`anio_id`);

--
-- Indices de la tabla `usuarios_r`
--
ALTER TABLE `usuarios_r`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `anios`
--
ALTER TABLE `anios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `botas`
--
ALTER TABLE `botas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `camisas_hombre`
--
ALTER TABLE `camisas_hombre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `camisas_mujer`
--
ALTER TABLE `camisas_mujer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `cascos`
--
ALTER TABLE `cascos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `gafas`
--
ALTER TABLE `gafas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `gafas_especiales`
--
ALTER TABLE `gafas_especiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `guantes`
--
ALTER TABLE `guantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `jeans_hombre`
--
ALTER TABLE `jeans_hombre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT de la tabla `jeans_mujer`
--
ALTER TABLE `jeans_mujer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mascarillas`
--
ALTER TABLE `mascarillas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `nomex`
--
ALTER TABLE `nomex`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `proyectos`
--
ALTER TABLE `proyectos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tapabocas`
--
ALTER TABLE `tapabocas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tapa_oidos`
--
ALTER TABLE `tapa_oidos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `usuarios_r`
--
ALTER TABLE `usuarios_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `proyectos`
--
ALTER TABLE `proyectos`
  ADD CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`anio_id`) REFERENCES `anios` (`id`);

--
-- Filtros para la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD CONSTRAINT `usuarios_ibfk_1` FOREIGN KEY (`anio_id`) REFERENCES `proyectos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
