-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2021 a las 06:14:39
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
(18, 'Juan', 'Perez', '180080049@upve.edu.mx', 'e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', 0);

--
-- Disparadores `administrador`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_ADMIN_BITACORA_DELETE` AFTER DELETE ON `administrador` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES
(CURRENT_USER,'administrador','DELETE',
CONCAT(OLD.id,'|',OLD.nombre,'|',OLD.apellido,'|',
       OLD.correo,'|',OLD.password));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_ADMIN_BITACORA_INSERT` AFTER INSERT ON `administrador` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'administrador','INSERT',CONCAT(NEW.id,'|',NEW.nombre,'|',NEW.apellido,'|',NEW.correo,'|',NEW.password));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_ADMIN_BITACORA_UPDATE` AFTER UPDATE ON `administrador` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES
(CURRENT_USER,'administrador','UPDATE',CONCAT(NEW.id,'|',NEW.nombre,'|',
NEW.apellido,'|',NEW.correo,'|',NEW.password),
CONCAT(OLD.id,'|',OLD.nombre,'|',OLD.apellido,'|',
       OLD.correo,'|',OLD.password));
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

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `usuario`, `fecha_movimiento`, `tabla`, `accion`, `informacion_actual`, `informacion_anterior`) VALUES
(7, 'root@localhost', '2021-11-11 20:55:39', 'administrador', 'INSERT', '5|usuario|user appel|user@gmail.com|23r', ''),
(8, 'root@localhost', '2021-11-11 20:56:24', 'administrador', 'UPDATE', '5|usuario|cambio|user@gmail.com|23r', '5|usuario|user appel|user@gmail.com|23r'),
(9, 'root@localhost', '2021-11-11 20:56:39', 'administrador', 'DELETE', '', '5|usuario|cambio|user@gmail.com|23r'),
(10, 'root@localhost', '2021-11-11 20:57:09', 'equipo', 'INSERT', '2|equipo 1|24|23f|23|12|1', ''),
(11, 'root@localhost', '2021-11-11 20:57:20', 'equipo', 'UPDATE', '2|equipo 1|25|23f|23|12|1', '2|equipo 1|24|23f|23|12|1'),
(12, 'root@localhost', '2021-11-11 20:57:37', 'equipo', 'DELETE', '', '2|equipo 1|25|23f|23|12|1'),
(13, 'root@localhost', '2021-11-11 20:58:01', 'laboratorio', 'INSERT', '2|lab 1|1|23f', ''),
(14, 'root@localhost', '2021-11-11 20:58:27', 'laboratorio', 'UPDATE', '2|lab 1|1|23f333', '2|lab 1|1|23f'),
(15, 'root@localhost', '2021-11-11 20:58:43', 'laboratorio', 'DELETE', '', '2|lab 1|1|23f333'),
(16, 'root@localhost', '2021-11-11 21:12:33', 'equipo', 'INSERT', '4|equipo 1|todo bien|animo|876|fdjj3|1', ''),
(17, 'root@localhost', '2021-11-11 21:12:44', 'mantenimiento', 'INSERT', '1|0|todo bien|4', ''),
(18, 'root@localhost', '2021-11-11 21:13:05', 'mantenimiento', 'INSERT', '2|0|todo bien|4', ''),
(19, 'root@localhost', '2021-11-11 21:13:48', 'mantenimiento', 'DELETE', '', '1|0000-00-00 00:00:00|todo bien|4'),
(20, 'root@localhost', '2021-11-11 21:13:48', 'mantenimiento', 'DELETE', '', '2|0000-00-00 00:00:00|todo bien|4'),
(21, 'root@localhost', '2021-11-11 21:14:14', 'mantenimiento', 'INSERT', '3|2021-11-11 14:14:14|todo bien|4', ''),
(22, 'root@localhost', '2021-11-11 21:15:13', 'reactivo', 'INSERT', '1|reactivo 1|1|12|todo bien|2323|323f23fss23|2021-11-302|3|1', ''),
(23, 'root@localhost', '2021-11-11 21:15:37', 'reactivo', 'INSERT', '2|reactivo 2|1|12|todo bien|2323|323f23fss23|2021-11-302|3|1', ''),
(24, 'root@localhost', '2021-11-11 21:15:54', 'reactivo', 'UPDATE', '1|reactivo 1|1|13|todo bien|2323|323f23fss23|2021-11-302|3|1', '1|reactivo 1|1|12|todo bien|2323|323f23fss23|2021-11-302|3|1'),
(25, 'root@localhost', '2021-11-11 21:16:03', 'reactivo', 'DELETE', '', '2|reactivo 2|1|12|todo bien|2323|323f23fss23|2021-11-302|3|1'),
(26, 'root@localhost', '2021-11-11 21:16:46', 'tipo_material', 'INSERT', '1|corcho', ''),
(27, 'root@localhost', '2021-11-11 21:16:46', 'tipo_material', 'INSERT', '2|carton', ''),
(28, 'root@localhost', '2021-11-11 21:17:06', 'tipo_material', 'INSERT', '3|vidrio', ''),
(29, 'root@localhost', '2021-11-11 21:17:06', 'tipo_material', 'INSERT', '4|plastico', ''),
(30, 'root@localhost', '2021-11-11 21:17:14', 'tipo_material', 'UPDATE', '3|Bidrio', '3|vidrio'),
(31, 'root@localhost', '2021-11-11 21:17:21', 'tipo_material', 'DELETE', '', '3|Bidrio'),
(32, 'root@localhost', '2021-11-11 21:18:22', 'recipiente', 'INSERT', '1|recipiente 1|2|10 lt|1', ''),
(33, 'root@localhost', '2021-11-11 21:18:22', 'recipiente', 'INSERT', '2|recipiente 2|1|3 lt|1', ''),
(34, 'root@localhost', '2021-11-11 21:18:34', 'recipiente', 'UPDATE', '2|recipiente 2|1|35 lt|1', '2|recipiente 2|1|3 lt|1'),
(35, 'root@localhost', '2021-11-11 21:18:38', 'recipiente', 'DELETE', '', '2|recipiente 2|1|35 lt|1'),
(36, 'root@localhost', '2021-11-14 21:31:34', 'administrador', 'INSERT', '6||||', ''),
(37, 'root@localhost', '2021-11-14 21:32:44', 'administrador', 'INSERT', '7||||', ''),
(38, 'root@localhost', '2021-11-14 21:34:21', 'administrador', 'INSERT', '8|prueba 1|||', ''),
(39, 'root@localhost', '2021-11-14 21:38:10', 'administrador', 'INSERT', '9|prueba 1|prueba 2|prueba@gmail.com|12341234', ''),
(40, 'root@localhost', '2021-11-14 21:44:40', 'administrador', 'INSERT', '10|prueba 1|prueba 2|prueba@gmail.com|12341234', ''),
(41, 'root@localhost', '2021-11-14 21:45:14', 'administrador', 'DELETE', '', '6||||'),
(42, 'root@localhost', '2021-11-14 21:45:14', 'administrador', 'DELETE', '', '7||||'),
(43, 'root@localhost', '2021-11-14 21:45:14', 'administrador', 'DELETE', '', '8|prueba 1|||'),
(44, 'root@localhost', '2021-11-14 21:45:14', 'administrador', 'DELETE', '', '9|prueba 1|prueba 2|prueba@gmail.com|12341234'),
(45, 'root@localhost', '2021-11-14 21:46:09', 'administrador', 'INSERT', '11|prueba 1|prueba 2|prueba1@gmail.com|4d93efb3f585e5cd386af821667357b5dd65bd000dd1c2cbda', ''),
(46, 'root@localhost', '2021-11-14 21:55:21', 'administrador', 'INSERT', '16|gato|gatop|gato@gmail.com|54b40d8b8c1d49a42bbf4bb673e2f63cf392806476520931e6', ''),
(47, 'root@localhost', '2021-11-14 21:57:26', 'administrador', 'INSERT', '17|gato|prueba 2|gato2@gmail.com|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406', ''),
(48, 'root@localhost', '2021-11-15 20:19:17', 'administrador', 'DELETE', '', '17|gato|prueba 2|gato2@gmail.com|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406'),
(49, 'root@localhost', '2021-11-15 20:19:22', 'administrador', 'DELETE', '', '16|gato|gatop|gato@gmail.com|54b40d8b8c1d49a42bbf4bb673e2f63cf392806476520931e6'),
(50, 'root@localhost', '2021-11-15 20:19:25', 'administrador', 'DELETE', '', '11|prueba 1|prueba 2|prueba1@gmail.com|4d93efb3f585e5cd386af821667357b5dd65bd000dd1c2cbda'),
(51, 'root@localhost', '2021-11-15 20:19:50', 'administrador', 'INSERT', '18|admin|admin apellido|admin@gmail.com|4d93efb3f585e5cd386af821667357b5dd65bd000dd1c2cbdaaf53eb017fea65a9cdf9db19808b88e7ecaf2d497f1c8ca5aa5cbef3c1b8502ddf558960e0c108', ''),
(52, 'root@localhost', '2021-11-16 01:04:35', 'administrador', 'UPDATE', '18|admin|admin apellido|150050112@upve.edu.mx|4d93efb3f585e5cd386af821667357b5dd65bd000dd1c2cbdaaf53eb017fea65a9cdf9db19808b88e7ecaf2d497f1c8ca5aa5cbef3c1b8502ddf558960e0c108', '18|admin|admin apellido|admin@gmail.com|4d93efb3f585e5cd386af821667357b5dd65bd000dd1c2cbdaaf53eb017fea65a9cdf9db19808b88e7ecaf2d497f1c8ca5aa5cbef3c1b8502ddf558960e0c108'),
(53, 'root@localhost', '2021-11-16 20:21:15', 'administrador', 'UPDATE', '18|admin|admin apellido|150050112@upve.edu.mx|fa1719fcdfad3fce8bfd786d43f42e54f723df54ac4d5636c3dd82335cded8016d928e2887bcfdeb6a49e616d0d77b8afa047825a017e66cf0fc0948ee0e9d74', '18|admin|admin apellido|150050112@upve.edu.mx|4d93efb3f585e5cd386af821667357b5dd65bd000dd1c2cbdaaf53eb017fea65a9cdf9db19808b88e7ecaf2d497f1c8ca5aa5cbef3c1b8502ddf558960e0c108'),
(54, 'root@localhost', '2021-11-16 20:22:33', 'administrador', 'UPDATE', '18|admin|admin apellido|150050112@upve.edu.mx|55e51cb7ecb0dbb2305fc4582922ed2508810d8292c6c7c94d754daf94aac58ab6ace103ae6abcebeeac5819423cf1a91db7bb30618df73417845ab1bb4cd2e6', '18|admin|admin apellido|150050112@upve.edu.mx|fa1719fcdfad3fce8bfd786d43f42e54f723df54ac4d5636c3dd82335cded8016d928e2887bcfdeb6a49e616d0d77b8afa047825a017e66cf0fc0948ee0e9d74'),
(55, 'root@localhost', '2021-11-16 20:23:47', 'administrador', 'UPDATE', '1|juan|perez|juan@gmail.com|42094c7e2a650ef8b31f49ea6ed05bc96187c7ab922b28482189c6f315838b3664a3c92bd78419f6608ea50767b18c4ce05f87d1ce823db9e7aec587aff9d89a', '1|juan|perez|juan@gmail.com|1234'),
(56, 'root@localhost', '2021-11-16 20:26:19', 'mantenimiento', 'DELETE', '', '3|2021-11-11 14:14:14|todo bien|4'),
(57, 'root@localhost', '2021-11-16 20:26:29', 'equipo', 'DELETE', '', '4|equipo 1|todo bien|animo|876|fdjj3|1'),
(58, 'root@localhost', '2021-11-16 20:26:43', 'reactivo', 'DELETE', '', '1|reactivo 1|1|13|todo bien|2323|323f23fss23|2021-11-302|3|1'),
(59, 'root@localhost', '2021-11-16 20:27:10', 'recipiente', 'DELETE', '', '1|recipiente 1|2|10 lt|1'),
(60, 'root@localhost', '2021-11-16 20:27:38', 'laboratorio', 'DELETE', '', '1|gya|1|qwf'),
(61, 'root@localhost', '2021-11-16 20:27:44', 'administrador', 'DELETE', '', '1|juan|perez|juan@gmail.com|42094c7e2a650ef8b31f49ea6ed05bc96187c7ab922b28482189c6f315838b3664a3c92bd78419f6608ea50767b18c4ce05f87d1ce823db9e7aec587aff9d89a'),
(62, 'root@localhost', '2021-11-16 20:27:48', 'administrador', 'DELETE', '', '3|Maria|Lopez Atondo|maria@gmail.com|1234'),
(63, 'root@localhost', '2021-11-16 20:27:52', 'administrador', 'DELETE', '', '10|prueba 1|prueba 2|prueba@gmail.com|12341234'),
(64, 'root@localhost', '2021-11-16 22:00:44', 'administrador', 'UPDATE', '18|admin|admin apellido|150050112@upve.edu.mx|4aabe28dabf6194f502ed15ea23f7e63f661b12beca7345c2c135a516c56f3603095c6399bf2a4b96ecde58162b12eb21a9ce3fbe0420c0281d5a13cc9b8672b', '18|admin|admin apellido|150050112@upve.edu.mx|55e51cb7ecb0dbb2305fc4582922ed2508810d8292c6c7c94d754daf94aac58ab6ace103ae6abcebeeac5819423cf1a91db7bb30618df73417845ab1bb4cd2e6'),
(65, 'root@localhost', '2021-11-16 22:04:52', 'administrador', 'UPDATE', '18|admin|admin apellido|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f', '18|admin|admin apellido|150050112@upve.edu.mx|4aabe28dabf6194f502ed15ea23f7e63f661b12beca7345c2c135a516c56f3603095c6399bf2a4b96ecde58162b12eb21a9ce3fbe0420c0281d5a13cc9b8672b'),
(66, 'root@localhost', '2021-11-16 22:06:48', 'administrador', 'UPDATE', '18|admin|santos|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f', '18|admin|admin apellido|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f'),
(67, 'root@localhost', '2021-11-16 22:06:55', 'administrador', 'UPDATE', '18|Juan|santos|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f', '18|admin|santos|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f'),
(68, 'root@localhost', '2021-11-16 22:07:00', 'administrador', 'UPDATE', '18|Juan|Perez|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f', '18|Juan|santos|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f'),
(69, 'root@localhost', '2021-11-16 22:07:24', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f', '18|Juan|Perez|150050112@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f'),
(70, 'root@localhost', '2021-11-16 22:07:46', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|b25c002453f0c1459c5c93a3afa8041edaf80b8b585adb942b762baa2b0e6980caf18e67c6b50069a29300f77d42fd92a6c63c8e386ee2807c2948d7f1146b35', '18|Juan|Perez|180080049@upve.edu.mx|fa1ce21ae2e8525dfff73655d4ffbf13c00f6038e067b9fa0dde036ad115c398e364bc4c238564f1b8044b43cff8ef0017485699d06c867f0d1ab29c91d8308f'),
(71, 'root@localhost', '2021-11-16 22:12:29', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|bbda7c2d297463e437ea09aa47ac38391d9362eeab7270c42bb93d39d1178846feb55909fb375cc3f1b2f40440805d4be485da05b3ccbc778e87246251af7184', '18|Juan|Perez|180080049@upve.edu.mx|b25c002453f0c1459c5c93a3afa8041edaf80b8b585adb942b762baa2b0e6980caf18e67c6b50069a29300f77d42fd92a6c63c8e386ee2807c2948d7f1146b35'),
(72, 'root@localhost', '2021-11-16 22:43:15', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|741cfa24e1992873684f7521c2cb5afd19a9b9d11841f0dabd12657565ca872ac971c4c12bf58723317d0d192c4d88be76f660bbdbb252e1aa73e408e6282450', '18|Juan|Perez|180080049@upve.edu.mx|bbda7c2d297463e437ea09aa47ac38391d9362eeab7270c42bb93d39d1178846feb55909fb375cc3f1b2f40440805d4be485da05b3ccbc778e87246251af7184'),
(73, 'root@localhost', '2021-11-16 23:05:11', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|741cfa24e1992873684f7521c2cb5afd19a9b9d11841f0dabd12657565ca872ac971c4c12bf58723317d0d192c4d88be76f660bbdbb252e1aa73e408e6282450', '18|Juan|Perez|180080049@upve.edu.mx|741cfa24e1992873684f7521c2cb5afd19a9b9d11841f0dabd12657565ca872ac971c4c12bf58723317d0d192c4d88be76f660bbdbb252e1aa73e408e6282450'),
(74, 'root@localhost', '2021-11-16 23:10:14', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|b5ed0a7fd8c7ecdd56106548990419c4e43fc16b6684aa4bd42c9bb20f0ed36860e69d41c61cdf2820df6c47486605adef5332adc4000839c87063958db42571', '18|Juan|Perez|180080049@upve.edu.mx|741cfa24e1992873684f7521c2cb5afd19a9b9d11841f0dabd12657565ca872ac971c4c12bf58723317d0d192c4d88be76f660bbdbb252e1aa73e408e6282450'),
(75, 'root@localhost', '2021-11-16 23:54:03', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|b5ed0a7fd8c7ecdd56106548990419c4e43fc16b6684aa4bd42c9bb20f0ed36860e69d41c61cdf2820df6c47486605adef5332adc4000839c87063958db42571'),
(76, 'root@localhost', '2021-11-16 23:55:10', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|642c648989e091e3e94d6ccf80a5ca65510d7704c640826f5a0235187b7fe3e3f61820d112cc564f7704d5c07a3ac9134ba24aa0cd7188d0391dbd9be9b1ba9c', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(77, 'root@localhost', '2021-11-16 23:55:47', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|642c648989e091e3e94d6ccf80a5ca65510d7704c640826f5a0235187b7fe3e3f61820d112cc564f7704d5c07a3ac9134ba24aa0cd7188d0391dbd9be9b1ba9c'),
(78, 'root@localhost', '2021-11-16 23:57:25', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|2af886eed91e4b69b102acc90ef910316ff948e843b5f3a7467f6c5086f92002ef62c5fae4e27588c0ebb1e8d57b23fd0ecb8b830151c1923a148b1d893f7fbc', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(79, 'root@localhost', '2021-11-17 00:10:52', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|2af886eed91e4b69b102acc90ef910316ff948e843b5f3a7467f6c5086f92002ef62c5fae4e27588c0ebb1e8d57b23fd0ecb8b830151c1923a148b1d893f7fbc');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipo`
--

CREATE TABLE `equipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `condicion_uso` varchar(50) NOT NULL,
  `mantenimiento` varchar(200) NOT NULL,
  `num_economico` int(11) NOT NULL,
  `num_serie` varchar(20) NOT NULL,
  `id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `equipo`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_EQUIPO_BITACORA_DELETE` AFTER DELETE ON `equipo` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'equipo','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.condicion_uso,'|',                          OLD.mantenimiento,'|',OLD.num_economico,'|',
OLD.num_serie,'|',OLD.id_laboratorio));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_EQUIPO_BITACORA_INSERT` AFTER INSERT ON `equipo` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'equipo','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.condicion_uso,'|',                          NEW.mantenimiento,'|',NEW.num_economico,'|',
NEW.num_serie,'|',NEW.id_laboratorio));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_EQUIPO_BITACORA_UPDATE` AFTER UPDATE ON `equipo` FOR EACH ROW BEGIN

INSERT INTO bitacora 
(usuario,tabla,accion,informacion_actual,
informacion_anterior)
VALUES(CURRENT_USER,'equipo','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.condicion_uso,'|',                    NEW.mantenimiento,'|',NEW.num_economico,'|',
NEW.num_serie,'|',NEW.id_laboratorio),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.condicion_uso,'|',
OLD.mantenimiento,'|',OLD.num_economico,'|',
OLD.num_serie,'|',OLD.id_laboratorio));

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
  `id_equipo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `mantenimiento`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_MANT_BITACORA_DELETE` AFTER DELETE ON `mantenimiento` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'mantenimiento','DELETE',CONCAT(OLD.id,'|',
OLD.fecha_mantenimiento,'|',OLD.observaciones,'|',OLD.id_equipo));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_MANT_BITACORA_INSERT` AFTER INSERT ON `mantenimiento` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'mantenimiento','INSERT',CONCAT(NEW.id,'|',
NEW.fecha_mantenimiento,'|',NEW.observaciones,'|',NEW.id_equipo));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_MANT_BITACORA_UPDATE` AFTER UPDATE ON `mantenimiento` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,
                     informacion_anterior)
VALUES(CURRENT_USER,'mantenimiento','UPDATE',CONCAT(NEW.id,'|',
NEW.fecha_mantenimiento,'|',NEW.observaciones,'|',NEW.id_equipo),
CONCAT(OLD.id,'|',
OLD.fecha_mantenimiento,'|',OLD.observaciones,'|',OLD.id_equipo));

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
  `cantidad_reactivo` int(11) NOT NULL,
  `unidad_medida` varchar(50) NOT NULL,
  `codigo_almacenamiento` varchar(50) NOT NULL,
  `caducidad` date NOT NULL,
  `num_mueble` int(11) NOT NULL,
  `num_estante` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `reactivo`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_REACTIVO_BITACORA_DELETE` AFTER DELETE ON `reactivo` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'reactivo','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.reactividad,'|',OLD.inflamabilidad,
OLD.riesgo_salud,'|',OLD.presentacion,'|',OLD.cantidad_reactivo,
OLD.unidad_medida,'|',OLD.codigo_almacenamiento,'|',OLD.caducidad,
OLD.num_mueble,'|',OLD.num_estante,'|',OLD.id_laboratorio));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_REACTIVO_BITACORA_INSERT` AFTER INSERT ON `reactivo` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'reactivo','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.reactividad,'|',NEW.inflamabilidad,
NEW.riesgo_salud,'|',NEW.presentacion,'|',NEW.cantidad_reactivo,
NEW.unidad_medida,'|',NEW.codigo_almacenamiento,'|',NEW.caducidad,
NEW.num_mueble,'|',NEW.num_estante,'|',NEW.id_laboratorio));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_REACTIVO_BITACORA_UPDATE` AFTER UPDATE ON `reactivo` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES(CURRENT_USER,'reactivo','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.reactividad,'|',NEW.inflamabilidad,
NEW.riesgo_salud,'|',NEW.presentacion,'|',NEW.cantidad_reactivo,
NEW.unidad_medida,'|',NEW.codigo_almacenamiento,'|',NEW.caducidad,
NEW.num_mueble,'|',NEW.num_estante,'|',NEW.id_laboratorio),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.reactividad,'|',OLD.inflamabilidad,
OLD.riesgo_salud,'|',OLD.presentacion,'|',OLD.cantidad_reactivo,
OLD.unidad_medida,'|',OLD.codigo_almacenamiento,'|',OLD.caducidad,
OLD.num_mueble,'|',OLD.num_estante,'|',OLD.id_laboratorio));

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
  `id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Disparadores `recipiente`
--
DELIMITER $$
CREATE TRIGGER `TRIGGER_RECIPIENTE_BITACORA_DELETE` AFTER DELETE ON `recipiente` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_anterior)
VALUES(CURRENT_USER,'recipiente','DELETE',CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.id_tipo_material,'|',OLD.capacidad,
'|',OLD.id_laboratorio));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_RECIPIENTE_BITACORA_INSERT` AFTER INSERT ON `recipiente` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual)
VALUES(CURRENT_USER,'recipiente','INSERT',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.id_tipo_material,'|',NEW.capacidad,
'|',NEW.id_laboratorio));

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `TRIGGER_RECIPIENTE_BITACORA_UPDATE` AFTER UPDATE ON `recipiente` FOR EACH ROW BEGIN

INSERT INTO bitacora (usuario,tabla,accion,informacion_actual,informacion_anterior)
VALUES(CURRENT_USER,'recipiente','UPDATE',CONCAT(NEW.id,'|',
NEW.nombre,'|',NEW.id_tipo_material,'|',NEW.capacidad,
'|',NEW.id_laboratorio),CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.id_tipo_material,'|',OLD.capacidad,
'|',OLD.id_laboratorio));

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
(1, 'corcho'),
(2, 'carton'),
(4, 'plastico');

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrador`
--
ALTER TABLE `administrador`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `bitacora`
--
ALTER TABLE `bitacora`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `reactivo`
--
ALTER TABLE `reactivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `recipiente`
--
ALTER TABLE `recipiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tipo_material`
--
ALTER TABLE `tipo_material`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
