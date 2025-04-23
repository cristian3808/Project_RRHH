-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 23-04-2025 a las 22:04:10
-- Versión del servidor: 10.11.10-MariaDB
-- Versión de PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `u498964512_srh`
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
-- Estructura de tabla para la tabla `hijos`
--

CREATE TABLE `hijos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre_completo_hijo` varchar(100) NOT NULL,
  `tipo_documento_hijo` varchar(50) NOT NULL,
  `numero_documento_hijo` varchar(50) NOT NULL,
  `edad_hijo` varchar(3) NOT NULL
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

--
-- Volcado de datos para la tabla `proyectos`
--

INSERT INTO `proyectos` (`id`, `titulo`, `anio_id`) VALUES
(12, 'Ecopetrol', 1),
(14, 'Staff TF', 1),
(16, 'prueba', 1);

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

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombres`, `apellidos`, `cedula`, `correo`, `anio_id`) VALUES
(9, 'Cristian Alejandro', 'Jimenez Mora', '1012329993', 'cristian.mora3808@gmail.com', 12),
(10, 'Sandra Liliana', 'Sissa Pinzon', '53069693', 'liliana.sissa@tfauditores.net', 12),
(14, 'Manuel Antonio', 'Tibaquira Naranjo', '19348582', 'manueltibaquira@tfauditores.com', 14),
(15, 'Clara Virginia', 'Forero Rojas', '51594132', 'claravirginiaforero@tfauditores.com', 14),
(16, 'Luis Carlos', 'Chavarro Palacios', '19078945', 'luis.chavarro@tfauditores.com', 14),
(17, 'Hernan Mauricio', 'Carreno Beltran', '91539493', 'hernan.carrenob@tfauditores.com', 14),
(18, 'Jairo Saul', 'Rincon Baez', '74326034', 'jairo.rincon@tfauditores.com', 14),
(19, 'Luisa Fernanda', 'Riveros Fraile', '1019030463', 'luisa.riveros@tfauditores.com', 14),
(20, 'Victor Armando', 'Gonzalez Plata', '13566088', 'victor.gonzalez@tfauditores.com', 14),
(21, 'Deisy', 'Mendivelso Torres', '53062349', 'deisy.mendivelso@tfauditores.com', 14),
(22, 'Maria Del Rosario', 'Romero', '52107102', 'ROSARIO23.ROMERO@hotmail.com', 14),
(23, 'Herman', 'Villamarin Castaneda', '79748004', 'herman.villamarin@tfauditores.com', 14),
(24, 'Yenny Yanibe', 'Lopez Morales', '52888542', 'yenny.lopez@tfauditores.com', 14),
(25, 'Dilia Deisa', 'Cardenas Romero', '52807859', 'recepcion@tfauditores.com', 14),
(26, 'Clara Yolanda', 'Chaparro Barrera', '39724569', 'clara.chaparro@tfauditores.com', 14),
(27, 'Manuel Esteban', 'Tibaquira Forero', '80185831', 'esteban.tibaquira@tfauditores.com', 14),
(28, 'Laura Cristina', 'Tibaquira Forero', '1019029450', 'laura.tibaquira@tfauditores.com', 14),
(29, 'Luis Antonio', 'Rojas Salcedo', '1108763265', 'luis.rojas@tfauditores.com', 14),
(30, 'Mario Rodolfo', 'Acosta Navarrete', '1024525584', 'mario.acosta@tfauditores.com', 14),
(31, 'Diana Marcela', 'Rubiano Sepulveda', '52897873', 'diana.rubiano@tfauditores.com', 14),
(32, 'Jesica Dayana', 'Achury Quevedo', '1022439201', 'jesica.achury@tfauditores.com', 14),
(33, 'Jesus Eduardo', 'Plata Garcia', '1140820849', 'jesus.plata@tfauditores.com', 14),
(34, 'Edgar Alberto', 'Gaitan Fajardo', '79598590', 'edgar.gaitan@tfauditores.com', 14),
(35, 'Adriana Patricia', 'Tibaquira Campos', '52955035', 'adriana.tibaquira@tfauditores.com', 14),
(36, 'Raul Antonio', 'Ballen Hernandez', '80114430', 'raul.ballen@tfauditores.com', 14),
(37, 'Juan Sebastian', 'Chia Montana ', '1015428612', 'hseq@tfauditores.com', 14),
(38, 'Andres David', 'Ortiz Valencia', '1026568883', 'seleccion@tfauditores.com', 14),
(39, 'Laura Daniela', 'Joya Oicata', '1010126753', 'laura.joya@tfauditores.com', 14);

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
  `direccion` varchar(255) DEFAULT NULL,
  `fecha_expedicion_cedula` date DEFAULT NULL,
  `correo` varchar(255) DEFAULT NULL,
  `municipio_residencia` varchar(50) NOT NULL,
  `nombre_contacto` varchar(255) DEFAULT NULL,
  `telefono_contacto` varchar(20) DEFAULT NULL,
  `tipo_sangre` varchar(60) DEFAULT NULL,
  `eps` varchar(60) DEFAULT NULL,
  `fondo_pension` varchar(50) DEFAULT NULL,
  `arl` varchar(60) DEFAULT NULL,
  `hoja_vida` varchar(255) DEFAULT NULL,
  `subir_cedula` varchar(255) DEFAULT NULL,
  `certificados_laborales` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `certificados_eps` varchar(255) NOT NULL,
  `certificados_estudio` varchar(255) DEFAULT NULL,
  `carnet_vacunas` varchar(255) DEFAULT NULL,
  `certificacion_bancaria` varchar(255) DEFAULT NULL,
  `	cert_antecedente_policia` varchar(255) DEFAULT NULL,
  `cert_antecedente_contraloria` varchar(255) DEFAULT NULL,
  `cert_antecedente_procuraduria` varchar(255) DEFAULT NULL,
  `certificado_afp` varchar(255) NOT NULL,
  `certificados_territorialidad` varchar(255) DEFAULT NULL,
  `talla_camisa` varchar(10) DEFAULT NULL,
  `talla_pantalon` varchar(10) DEFAULT NULL,
  `talla_botas` varchar(10) DEFAULT NULL,
  `talla_nomex` varchar(10) DEFAULT NULL,
  `enviado` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `estado_civil` varchar(50) NOT NULL,
  `nombre_pareja` varchar(50) NOT NULL,
  `tiene_hijos` varchar(50) NOT NULL,
  `cuantos_hijos` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios_r`
--

INSERT INTO `usuarios_r` (`id`, `nombres`, `apellidos`, `genero`, `cedula`, `telefono`, `fecha_nacimiento`, `lugar_nacimiento`, `direccion`, `fecha_expedicion_cedula`, `correo`, `municipio_residencia`, `nombre_contacto`, `telefono_contacto`, `tipo_sangre`, `eps`, `fondo_pension`, `arl`, `hoja_vida`, `subir_cedula`, `certificados_laborales`, `foto`, `certificados_eps`, `certificados_estudio`, `carnet_vacunas`, `certificacion_bancaria`, `	cert_antecedente_policia`, `cert_antecedente_contraloria`, `cert_antecedente_procuraduria`, `certificado_afp`, `certificados_territorialidad`, `talla_camisa`, `talla_pantalon`, `talla_botas`, `talla_nomex`, `enviado`, `created_at`, `estado_civil`, `nombre_pareja`, `tiene_hijos`, `cuantos_hijos`) VALUES
(39, 'Cristian Alejandro', 'Jimenez Mora', 'masculino', '1012329993', '3234909423', '2005-02-08', 'BOGOTÁ D.C.', 'CR 15 B 18 55 SUR CASA', '2023-03-13', 'cristian.mora3808@gmail.com', 'SOACHA', 'Yanneth Mora', '3234909423', 'O+', 'CAPITAL SALUD', 'Skandia', 'AXA COLPATRIA', 'uploads/hoja de vida.pdf', '../../uploads/CC Cristian Jiménez.pdf', 'uploads/CC Cristian Jiménez.pdf', 'uploads/foto 3x2.jpg', 'uploads/CC Cristian Jiménez.pdf', 'uploads/CC Cristian Jiménez.pdf', 'uploads/Certificado Diploma de Reconocimiento Profesional Negro y Dorado.pdf', 'uploads/Certificado Diploma de Reconocimiento Profesional Negro y Dorado.pdf', 'uploads/Certificado Diploma de Reconocimiento Profesional Negro y Dorado.pdf', '', '', 'uploads/Certificado Diploma de Reconocimiento Profesional Negro y Dorado.pdf', 'no', 'L', '32', '40', '42', '1', '2025-04-07 16:19:36', 'soltero', '', 'no', 0);

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
-- Indices de la tabla `hijos`
--
ALTER TABLE `hijos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

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
-- AUTO_INCREMENT de la tabla `hijos`
--
ALTER TABLE `hijos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT de la tabla `usuarios_r`
--
ALTER TABLE `usuarios_r`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `hijos`
--
ALTER TABLE `hijos`
  ADD CONSTRAINT `hijos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios_r` (`id`) ON DELETE CASCADE;

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
