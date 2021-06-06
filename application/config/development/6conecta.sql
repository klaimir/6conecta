--
-- Estructura de tabla para la tabla `conciertos`
--

CREATE TABLE `conciertos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,  
  `numero_espectadores` int(11) UNSIGNED DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  `rentabilidad` int(11) UNSIGNED DEFAULT NULL,
  `id_recinto` int(11) UNSIGNED NOT NULL,
  `id_promotor` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `conciertos`
--
ALTER TABLE `conciertos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de la tabla `conciertos`
--
ALTER TABLE `conciertos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
  
--
-- Estructura de tabla para la tabla `recintos`
--

CREATE TABLE `recintos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,  
  `coste_alquiler` int(11) UNSIGNED DEFAULT 0,
  `precio_entrada` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `recintos`
--
ALTER TABLE `recintos`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT de la tabla `recintos`
--
ALTER TABLE `recintos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `recintos` (`nombre`, `coste_alquiler`, `precio_entrada`) VALUES ('Recinto 1', 1000, 10);
INSERT INTO `recintos` (`nombre`, `coste_alquiler`, `precio_entrada`) VALUES ('Recinto 2', 2000, 20);
INSERT INTO `recintos` (`nombre`, `coste_alquiler`, `precio_entrada`) VALUES ('Recinto 3', 3000, 30);

--
-- Estructura de tabla para la tabla `grupos`
--

CREATE TABLE `grupos` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,  
  `cache` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `grupos`
--
ALTER TABLE `grupos`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT de la tabla `grupos`
--
ALTER TABLE `grupos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `grupos` (`nombre`, `cache`) VALUES ('Grupo 1', 100);
INSERT INTO `grupos` (`nombre`, `cache`) VALUES ('Grupo 2', 200);
INSERT INTO `grupos` (`nombre`, `cache`) VALUES ('Grupo 3', 300);

--
-- Estructura de tabla para la tabla `medios_publicitarios`
--

CREATE TABLE `medios_publicitarios` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,  
  `cache` int(11) UNSIGNED DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `medios_publicitarios`
--
ALTER TABLE `medios_publicitarios`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT de la tabla `medios_publicitarios`
--
ALTER TABLE `medios_publicitarios`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `medios_publicitarios` (`nombre`) VALUES ('Medio 1');
INSERT INTO `medios_publicitarios` (`nombre`) VALUES ('Medio 2');
INSERT INTO `medios_publicitarios` (`nombre`) VALUES ('Medio 3');

--
-- Estructura de tabla para la tabla `grupos_conciertos`
--

CREATE TABLE `grupos_conciertos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_grupo` int(11) UNSIGNED NOT NULL, 
  `id_concierto` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `grupos_conciertos`
--
ALTER TABLE `grupos_conciertos`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT de la tabla `grupos_conciertos`
--
ALTER TABLE `grupos_conciertos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
  
--
-- Estructura de tabla para la tabla `medios_conciertos`
--

CREATE TABLE `medios_conciertos` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_medio` int(11) UNSIGNED NOT NULL, 
  `id_concierto` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `medios_conciertos`
--
ALTER TABLE `medios_conciertos`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT de la tabla `medios_conciertos`
--
ALTER TABLE `medios_conciertos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Estructura de tabla para la tabla `promotores`
--

CREATE TABLE `promotores` (
  `id` int(11) UNSIGNED NOT NULL,
  `nombre` varchar(100) NOT NULL,  
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indices de la tabla `promotores`
--
ALTER TABLE `promotores`
  ADD PRIMARY KEY (`id`);
  
--
-- AUTO_INCREMENT de la tabla `promotores`
--
ALTER TABLE `promotores`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

INSERT INTO `promotores` (`nombre`, `email`) VALUES ('Promotor 1', 'angel.berasuain@gmail.com');
INSERT INTO `promotores` (`nombre`, `email`) VALUES ('Promotor 2', 'angel.berasuain@gmail.com');
INSERT INTO `promotores` (`nombre`, `email`) VALUES ('Promotor 3', 'angel.berasuain@gmail.com');


