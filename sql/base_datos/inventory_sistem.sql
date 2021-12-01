-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-12-2021 a las 23:15:56
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `inventory_sistem`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrador`
--

CREATE TABLE `administrador` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `is_password_random` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `administrador`
--

INSERT INTO `administrador` (`id`, `nombre`, `apellido`, `correo`, `password`, `is_password_random`) VALUES
(18, 'ADMINISTRADOR', '123Abc#+', 'admin@upve.edu.mx', '0cbee8715e5908fb780f0786ca212f8c9f36028e0ade32eaa65d04faddd10ae10b0f64d6ed5d7c1a4b5441340229ef3a858907100dcbb0f24a428504bc419c5d', 0);

--
-- Disparadores `administrador`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_ADMIN_BITACORA_DELETE` AFTER DELETE ON `administrador` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES
(CURRENT_USER,'administrador','DELETE',
CONCAT(OLD.id,'|',OLD.nombre,'|',OLD.apellido,'|',
       OLD.correo,'|',OLD.password,'|',OLD.is_password_random));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_ADMIN_BITACORA_INSERT` AFTER INSERT ON `administrador` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'administrador','INSERT',
       CONCAT(NEW.id,'|',NEW.nombre,'|',NEW.apellido,'|',NEW.correo
,'|',NEW.password,'|',NEW.is_password_random));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_ADMIN_BITACORA_UPDATE` AFTER UPDATE ON `administrador` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES
(CURRENT_USER,'administrador','UPDATE',CONCAT(NEW.id,'|',NEW.nombre,'|',
NEW.apellido,'|',NEW.correo,'|',NEW.password,'|',NEW.is_password_random),
CONCAT(OLD.id,'|',OLD.nombre,'|',OLD.apellido,'|',
       OLD.correo,'|',OLD.password,'|',OLD.is_password_random));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bitacora`
--

CREATE TABLE `bitacora` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `fecha_movimiento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tabla` varchar(100) NOT NULL,
  `accion` varchar(50) NOT NULL,
  `informacion_actual` text NOT NULL,
  `informacion_anterior` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `condicion_uso` varchar(50) NOT NULL,
  `num_economico` int(11) NOT NULL,
  `num_serie` varchar(20) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `imagen` text DEFAULT '',
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `equipo`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_EQUIPO_BITACORA_DELETE` AFTER DELETE ON `equipo` FOR EACH ROW BEGIN

SET @fecha_baja_old =OLD.fecha_baja;

IF ISNULL(OLD.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_old = 'is null';
END; END IF;

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'equipo','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.condicion_uso,'|',              OLD.num_economico,'|',
OLD.num_serie,'|',OLD.id_laboratorio,'|',
OLD.imagen,'|',OLD.eliminado,'|',
@fecha_baja_old));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_EQUIPO_BITACORA_INSERT` AFTER INSERT ON `equipo` FOR EACH ROW BEGIN

SET @fecha_baja_new =NEW.fecha_baja;

IF ISNULL(NEW.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_new = 'is null';
END; END IF;

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'equipo','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.condicion_uso,'|',                          NEW.num_economico,'|',
NEW.num_serie,'|',NEW.id_laboratorio,'|',
NEW.imagen,'|',NEW.eliminado,'|',
@fecha_baja_new));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_EQUIPO_BITACORA_UPDATE` AFTER UPDATE ON `equipo` FOR EACH ROW BEGIN

SET @fecha_baja_new =NEW.fecha_baja;
SET @fecha_baja_old =OLD.fecha_baja;

IF ISNULL(NEW.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_new = 'is null';
END; END IF;
IF ISNULL(OLD.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_old = 'is null';
END; END IF;

INSERT INTO bitacora 
(usuario,tabla,accion,informacion_actual,
informacion_anterior)
VALUES(CURRENT_USER,'equipo','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.condicion_uso,'|',                    NEW.num_economico,'|',
NEW.num_serie,'|',NEW.id_laboratorio,'|',
NEW.imagen,'|',NEW.eliminado,'|',
@fecha_baja_new),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.condicion_uso,'|',
OLD.num_economico,'|',
OLD.num_serie,'|',OLD.id_laboratorio,'|',
OLD.imagen,'|',OLD.eliminado,'|',
@fecha_baja_old));

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `laboratorio`
--

CREATE TABLE `laboratorio` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `admin` int(11) NOT NULL,
  `descripcion` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `laboratorio`
--

INSERT INTO `laboratorio` (`id`, `nombre`, `admin`, `descripcion`) VALUES
(3, 'QUIMICA', 18, 'laboratorio de quimica');

--
-- Disparadores `laboratorio`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_LABORAT_BITACORA_DELETE` AFTER DELETE ON `laboratorio` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'laboratorio','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.admin,'|',OLD.descripcion));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_LABORAT_BITACORA_INSERT` AFTER INSERT ON `laboratorio` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'laboratorio','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.admin,'|',NEW.descripcion));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_LABORAT_BITACORA_UPDATE` AFTER UPDATE ON `laboratorio` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,
                     informacion_anterior)
VALUES(CURRENT_USER,'laboratorio','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.admin,'|',NEW.descripcion),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.admin,'|',OLD.descripcion));

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mantenimiento`
--

CREATE TABLE `mantenimiento` (
  `id` int(11) NOT NULL,
  `fecha_mantenimiento` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `observaciones` varchar(200) NOT NULL,
  `id_equipo` int(11) NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `mantenimiento`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_MANT_BITACORA_DELETE` AFTER DELETE ON `mantenimiento` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'mantenimiento','DELETE',CONCAT(OLD.id,'|',
OLD.fecha_mantenimiento,'|',OLD.observaciones,'|',OLD.id_equipo
,'|',OLD.eliminado));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_MANT_BITACORA_INSERT` AFTER INSERT ON `mantenimiento` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'mantenimiento','INSERT',CONCAT(NEW.id,'|',
NEW.fecha_mantenimiento,'|',NEW.observaciones,'|',NEW.id_equipo,
'|',NEW.eliminado));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_MANT_BITACORA_UPDATE` AFTER UPDATE ON `mantenimiento` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,
                     informacion_anterior)
VALUES(CURRENT_USER,'mantenimiento','UPDATE',CONCAT(NEW.id,'|',
NEW.fecha_mantenimiento,'|',NEW.observaciones,'|',NEW.id_equipo,
'|',NEW.eliminado),
CONCAT(OLD.id,'|',
OLD.fecha_mantenimiento,'|',OLD.observaciones,'|',OLD.id_equipo
,'|',OLD.eliminado));

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reactivo`
--

CREATE TABLE `reactivo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `reactividad` int(11) NOT NULL,
  `inflamabilidad` int(11) NOT NULL,
  `riesgo_salud` int(11) NOT NULL,
  `presentacion` varchar(50) NOT NULL,
  `cantidad_reactivo` varchar(50) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `codigo_almacenamiento` varchar(50) NOT NULL,
  `caducidad` date NOT NULL,
  `num_mueble` int(11) NOT NULL,
  `num_estante` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `reactivo`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_REACTIVO_BITACORA_DELETE` AFTER DELETE ON `reactivo` FOR EACH ROW BEGIN

SET @fecha_baja_old =OLD.fecha_baja;

IF ISNULL(OLD.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_old = 'is null';
END; END IF;

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'reactivo','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.reactividad,'|',OLD.inflamabilidad,
'|',OLD.riesgo_salud,'|',OLD.presentacion,'|',OLD.cantidad_reactivo,
'|',OLD.unidad_medida,'|',OLD.codigo_almacenamiento,'|',OLD.caducidad,
'|',OLD.num_mueble,'|',OLD.num_estante,'|',OLD.id_laboratorio
,'|',OLD.eliminado,'|',@fecha_baja_old));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_REACTIVO_BITACORA_INSERT` AFTER INSERT ON `reactivo` FOR EACH ROW BEGIN
SET @fecha_baja_new =NEW.fecha_baja;

IF ISNULL(NEW.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_new = 'is null';
END; END IF;
 
INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'reactivo','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.reactividad,'|',NEW.inflamabilidad,
'|',NEW.riesgo_salud,'|',NEW.presentacion,'|',NEW.cantidad_reactivo,
'|',NEW.unidad_medida,'|',NEW.codigo_almacenamiento,'|',NEW.caducidad,
'|',NEW.num_mueble,'|',NEW.num_estante,'|',NEW.id_laboratorio,'|',
NEW.eliminado,'|',@fecha_baja_new));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_REACTIVO_BITACORA_UPDATE` AFTER UPDATE ON `reactivo` FOR EACH ROW BEGIN

SET @fecha_baja_new =NEW.fecha_baja;
SET @fecha_baja_old =OLD.fecha_baja;

IF ISNULL(NEW.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_new = 'is null';
END; END IF;
IF ISNULL(OLD.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_old = 'is null';
END; END IF;
 
INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES(CURRENT_USER,'reactivo','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.reactividad,'|',NEW.inflamabilidad,
'|',NEW.riesgo_salud,'|',NEW.presentacion,'|',NEW.cantidad_reactivo,
'|',NEW.unidad_medida,'|',NEW.codigo_almacenamiento,'|',NEW.caducidad,
'|',NEW.num_mueble,'|',NEW.num_estante,'|',NEW.id_laboratorio
,'|',NEW.eliminado,'|',@fecha_baja_new),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.reactividad,'|',OLD.inflamabilidad,
'|',OLD.riesgo_salud,'|',OLD.presentacion,'|',OLD.cantidad_reactivo,
'|',OLD.unidad_medida,'|',OLD.codigo_almacenamiento,'|',OLD.caducidad,
'|',OLD.num_mueble,'|',OLD.num_estante,'|',OLD.id_laboratorio
,'|',OLD.eliminado,'|',@fecha_baja_old));

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recipiente`
--

CREATE TABLE `recipiente` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `id_tipo_material` int(11) NOT NULL,
  `capacidad` varchar(50) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `imagen` text DEFAULT '',
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `recipiente`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_RECIPIENTE_BITACORA_DELETE` AFTER DELETE ON `recipiente` FOR EACH ROW BEGIN

SET @fecha_baja_old =OLD.fecha_baja;

IF ISNULL(OLD.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_old = 'is null';
END; END IF;

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'recipiente','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.id_tipo_material,'|',OLD.capacidad,
'|',OLD.id_laboratorio,'|',OLD.imagen,
'|',OLD.eliminado,'|',@fecha_baja_old));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_RECIPIENTE_BITACORA_INSERT` AFTER INSERT ON `recipiente` FOR EACH ROW BEGIN

SET @fecha_baja_new =NEW.fecha_baja;

IF ISNULL(NEW.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_new = 'is null';
END; END IF;

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'recipiente','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.id_tipo_material,'|',NEW.capacidad,
'|',NEW.id_laboratorio,'|',NEW.imagen,
'|',NEW.eliminado,'|',@fecha_baja_new));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_RECIPIENTE_BITACORA_UPDATE` AFTER UPDATE ON `recipiente` FOR EACH ROW BEGIN

SET @fecha_baja_new =NEW.fecha_baja;
SET @fecha_baja_old =OLD.fecha_baja;

IF ISNULL(NEW.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_new = 'is null';
END; END IF;
IF ISNULL(OLD.fecha_baja) = 1 THEN BEGIN
	SET @fecha_baja_old = 'is null';
END; END IF;

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES(CURRENT_USER,'recipiente','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.id_tipo_material,'|',NEW.capacidad,
'|',NEW.id_laboratorio,'|',NEW.imagen,
'|',NEW.eliminado,'|', @fecha_baja_new),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.id_tipo_material,'|',OLD.capacidad,
'|',OLD.id_laboratorio,'|',OLD.imagen,
'|',OLD.eliminado,'|',@fecha_baja_old));

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_material`
--

CREATE TABLE `tipo_material` (
  `id` int(11) NOT NULL,
  `tipo_material` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tipo_material`
--

INSERT INTO `tipo_material` (`id`, `tipo_material`) VALUES
(4, 'Plástico'),
(1, 'Vidrio');

--
-- Disparadores `tipo_material`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_TIPOMATERIAL_BITACORA_DELETE` AFTER DELETE ON `tipo_material` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'tipo_material','DELETE',CONCAT(OLD.id,'|',
OLD.tipo_material));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_TIPOMATERIAL_BITACORA_INSERT` AFTER INSERT ON `tipo_material` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'tipo_material','INSERT',CONCAT(NEW.id,'|',
NEW.tipo_material));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_TIPOMATERIAL_BITACORA_UPDATE` AFTER UPDATE ON `tipo_material` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES(CURRENT_USER,'tipo_material','UPDATE',CONCAT(NEW.id,'|',
NEW.tipo_material),CONCAT(OLD.id,'|',
OLD.tipo_material));

END
$$
DELIMITER ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrador`
--
ALTER TABLE `administrador`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- Indices de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_laboratorio` (`id_laboratorio`);

--
-- Indices de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `admin` (`admin`);

--
-- Indices de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_equipo` (`id_equipo`);

--
-- Indices de la tabla `reactivo`
--
ALTER TABLE `reactivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_laboratorio` (`id_laboratorio`);

--
-- Indices de la tabla `recipiente`
--
ALTER TABLE `recipiente`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_laboratorio` (`id_laboratorio`),
  ADD KEY `id_tipo_material` (`id_tipo_material`);

--
-- Indices de la tabla `tipo_material`
--
ALTER TABLE `tipo_material`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tipo_material` (`tipo_material`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=373;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `reactivo`
--
ALTER TABLE `reactivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `recipiente`
--
ALTER TABLE `recipiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `tipo_material`
--
ALTER TABLE `tipo_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipo`
--
ALTER TABLE `equipo`
  ADD CONSTRAINT `equipo_ibfk_1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id`);

--
-- Filtros para la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  ADD CONSTRAINT `laboratorio_ibfk_1` FOREIGN KEY (`admin`) REFERENCES `administrador` (`id`);

--
-- Filtros para la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  ADD CONSTRAINT `mantenimiento_ibfk_1` FOREIGN KEY (`id_equipo`) REFERENCES `equipo` (`id`);

--
-- Filtros para la tabla `reactivo`
--
ALTER TABLE `reactivo`
  ADD CONSTRAINT `reactivo_ibfk_1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id`);

--
-- Filtros para la tabla `recipiente`
--
ALTER TABLE `recipiente`
  ADD CONSTRAINT `recipiente_ibfk_1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id`),
  ADD CONSTRAINT `recipiente_ibfk_2` FOREIGN KEY (`id_tipo_material`) REFERENCES `tipo_material` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
