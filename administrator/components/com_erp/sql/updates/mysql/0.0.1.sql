-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2016 a las 19:22:59
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de datos: `solicito`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_departamento`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_departamento` (
  `id` int(11) NOT NULL,
  `departamento` varchar(30) NOT NULL,
  `sigla` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_empresa`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_empresa` (
  `id` int(11) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `logo` varchar(20) NOT NULL,
  `sitioweb` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `celular` varchar(30) NOT NULL,
  `fecha_registro` date NOT NULL,
  `habilitado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_empresa_plan`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_empresa_plan` (
  `id_empresa` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `fecha_registro` date NOT NULL,
  `vigente` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_formulario`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_formulario` (
  `id` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_departamento` int(11) NOT NULL,
  `codigo` varchar(30) NOT NULL,
  `cargo` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `tiempo` tinyint(4) NOT NULL,
  `comision` tinyint(1) NOT NULL,
  `pasantia` tinyint(1) NOT NULL,
  `pretension` tinyint(1) NOT NULL,
  `anonimo` tinyint(1) NOT NULL,
  `fecha_creacion` date NOT NULL,
  `fecha_publicacion` date NOT NULL,
  `fecha_finalizacion` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_formulario_cualidades`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_formulario_cualidades` (
  `id` int(11) NOT NULL,
  `id_formulario` int(11) NOT NULL,
  `cualidad` varchar(150) NOT NULL,
  `requerido` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_grupos`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_grupos` (
  `id` int(11) NOT NULL,
  `grupo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_planes`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_planes` (
  `id` int(11) NOT NULL,
  `plan` varchar(50) NOT NULL,
  `forms` int(11) NOT NULL,
  `habilitado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_postulante`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_postulante` (
  `id` int(11) NOT NULL,
  `id_formulario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `ap_paterno` varchar(100) NOT NULL,
  `ap_materno` varchar(100) NOT NULL,
  `fecha_nacimiento` date NOT NULL,
  `ci` varchar(20) NOT NULL,
  `ci_departamento` int(11) NOT NULL,
  `departamento` int(11) NOT NULL,
  `ciudad` varchar(50) NOT NULL,
  `barrio` varchar(50) NOT NULL,
  `direccion` varchar(250) NOT NULL,
  `email` varchar(100) NOT NULL,
  `celular` varchar(30) NOT NULL,
  `telefono` varchar(30) NOT NULL,
  `tiempo` tinyint(4) NOT NULL,
  `pasantia` tinyint(1) NOT NULL,
  `salario` int(11) NOT NULL,
  `comision` tinyint(1) NOT NULL,
  `comentario` text NOT NULL,
  `foto` varchar(30) NOT NULL,
  `cv` varchar(30) NOT NULL,
  `trabajos_realizados` text NOT NULL,
  `fecha_registro` date NOT NULL,
  `estado` int(1) NOT NULL,
  `observaciones` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_postulante_conocimiento`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_postulante_conocimiento` (
  `id_postulante` int(11) NOT NULL,
  `id_cualidad` int(11) NOT NULL,
  `nivel` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_postulante_expestudio`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_postulante_expestudio` (
  `id` int(11) NOT NULL,
  `id_postulante` int(11) NOT NULL,
  `detalle` varchar(150) NOT NULL,
  `fecha_desde` date NOT NULL,
  `fecha_hasta` date NOT NULL,
  `tipo` int(1) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cgn_solicito_usuarios`
--

CREATE TABLE IF NOT EXISTS `cgn_solicito_usuarios` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_grupo` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cgn_solicito_departamento`
--
ALTER TABLE `cgn_solicito_departamento`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cgn_solicito_empresa`
--
ALTER TABLE `cgn_solicito_empresa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cgn_solicito_empresa_plan`
--
ALTER TABLE `cgn_solicito_empresa_plan`
  ADD PRIMARY KEY (`id_empresa`,`id_plan`),
  ADD KEY `id_plan` (`id_plan`);

--
-- Indices de la tabla `cgn_solicito_formulario`
--
ALTER TABLE `cgn_solicito_formulario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_empresa` (`id_empresa`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_departamento` (`id_departamento`);

--
-- Indices de la tabla `cgn_solicito_formulario_cualidades`
--
ALTER TABLE `cgn_solicito_formulario_cualidades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_formulario` (`id_formulario`);

--
-- Indices de la tabla `cgn_solicito_grupos`
--
ALTER TABLE `cgn_solicito_grupos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cgn_solicito_planes`
--
ALTER TABLE `cgn_solicito_planes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `cgn_solicito_postulante`
--
ALTER TABLE `cgn_solicito_postulante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_formulario` (`id_formulario`),
  ADD KEY `ci_departamento` (`ci_departamento`),
  ADD KEY `departamento` (`departamento`);

--
-- Indices de la tabla `cgn_solicito_postulante_conocimiento`
--
ALTER TABLE `cgn_solicito_postulante_conocimiento`
  ADD PRIMARY KEY (`id_postulante`,`id_cualidad`),
  ADD KEY `id_cualidad` (`id_cualidad`);

--
-- Indices de la tabla `cgn_solicito_postulante_expestudio`
--
ALTER TABLE `cgn_solicito_postulante_expestudio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_postulante` (`id_postulante`);

--
-- Indices de la tabla `cgn_solicito_usuarios`
--
ALTER TABLE `cgn_solicito_usuarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_grupo` (`id_grupo`),
  ADD KEY `id_empresa` (`id_empresa`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cgn_solicito_departamento`
--
ALTER TABLE `cgn_solicito_departamento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_empresa`
--
ALTER TABLE `cgn_solicito_empresa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_formulario`
--
ALTER TABLE `cgn_solicito_formulario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_formulario_cualidades`
--
ALTER TABLE `cgn_solicito_formulario_cualidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_grupos`
--
ALTER TABLE `cgn_solicito_grupos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_planes`
--
ALTER TABLE `cgn_solicito_planes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_postulante`
--
ALTER TABLE `cgn_solicito_postulante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_postulante_expestudio`
--
ALTER TABLE `cgn_solicito_postulante_expestudio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `cgn_solicito_usuarios`
--
ALTER TABLE `cgn_solicito_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;