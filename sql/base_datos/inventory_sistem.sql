-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 29-11-2021 a las 21:00:55
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
(18, 'Juan', 'Perez', '180080049@upve.edu.mx', '0cbee8715e5908fb780f0786ca212f8c9f36028e0ade32eaa65d04faddd10ae10b0f64d6ed5d7c1a4b5441340229ef3a858907100dcbb0f24a428504bc419c5d', 0);

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

--
-- Volcado de datos para la tabla `bitacora`
--

INSERT INTO `bitacora` (`id`, `usuario`, `fecha_movimiento`, `tabla`, `accion`, `informacion_actual`, `informacion_anterior`) VALUES
(82, 'root@localhost', '2021-11-18 06:42:07', 'administrador', 'INSERT', '19|prueba|appel|pruea@gmail.com|792d7149fbe05092e25c638869d1b076580a072cc10d0f3136d6e05c493ff3a0c6b39471420d90100b0398e23265717157a40a306d9552a52052769beca11e7a', ''),
(83, 'root@localhost', '2021-11-18 06:43:03', 'administrador', 'UPDATE', '19|prueba|appelll|pruea@gmail.com|792d7149fbe05092e25c638869d1b076580a072cc10d0f3136d6e05c493ff3a0c6b39471420d90100b0398e23265717157a40a306d9552a52052769beca11e7a', '19|prueba|appel|pruea@gmail.com|792d7149fbe05092e25c638869d1b076580a072cc10d0f3136d6e05c493ff3a0c6b39471420d90100b0398e23265717157a40a306d9552a52052769beca11e7a'),
(84, 'root@localhost', '2021-11-18 06:43:28', 'administrador', 'DELETE', '', '19|prueba|appelll|pruea@gmail.com|792d7149fbe05092e25c638869d1b076580a072cc10d0f3136d6e05c493ff3a0c6b39471420d90100b0398e23265717157a40a306d9552a52052769beca11e7a'),
(85, 'root@localhost', '2021-11-18 06:51:31', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|962f5b8ffc2d504b4f47f65e7a7df13c37a2f4a14a1ef2f2f9f3477b9c243d6f4306470744e62c458f7b06527d6450b35f3b4270f04f5d9b1d658c2cd5fc1f30', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(86, 'root@localhost', '2021-11-18 06:55:12', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|962f5b8ffc2d504b4f47f65e7a7df13c37a2f4a14a1ef2f2f9f3477b9c243d6f4306470744e62c458f7b06527d6450b35f3b4270f04f5d9b1d658c2cd5fc1f30'),
(87, 'root@localhost', '2021-11-18 18:23:47', 'laboratorio', 'INSERT', '3|quimica|18|laboratorio de quimica', ''),
(88, 'root@localhost', '2021-11-18 18:30:47', 'reactivo', 'INSERT', '3|butamol|1|11|presentacion|50lts|334JFEWD2|2022-09-281|1|3|0', ''),
(89, 'root@localhost', '2021-11-18 18:33:10', 'reactivo', 'UPDATE', '3|butamol|1|11|frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|0', '3|butamol|1|11|presentacion|50lts|334JFEWD2|2022-09-281|1|3|0'),
(90, 'root@localhost', '2021-11-18 18:33:35', 'reactivo', 'UPDATE', '3|butamol|1|11|Frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|0', '3|butamol|1|11|frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|0'),
(91, 'root@localhost', '2021-11-18 20:25:07', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|b94a0e9da4327cac5c4b3690e94ff45134622c6172fa2608d2de369d7e2a0a8f06975521a2a3093d0cd985f9b39a895f03b464c58375ff0d0d8858423635cad5', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(92, 'root@localhost', '2021-11-18 23:34:25', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|528a5fc4442e10492b7f088c9d1cdf86fba6ce1bc4a185aed1990cb0528e7d6741cad5c775e266bd8bad3baa6a535c77b28ee3270c278b5a9cbb85ac8062cba9', '18|Juan|Perez|180080049@upve.edu.mx|b94a0e9da4327cac5c4b3690e94ff45134622c6172fa2608d2de369d7e2a0a8f06975521a2a3093d0cd985f9b39a895f03b464c58375ff0d0d8858423635cad5'),
(93, 'root@localhost', '2021-11-18 23:35:35', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|528a5fc4442e10492b7f088c9d1cdf86fba6ce1bc4a185aed1990cb0528e7d6741cad5c775e266bd8bad3baa6a535c77b28ee3270c278b5a9cbb85ac8062cba9'),
(94, 'root@localhost', '2021-11-18 23:36:06', 'equipo', 'INSERT', '5|Vaso de precipitados|en buenas condiciones|mantienido|1|1|3', ''),
(95, 'root@localhost', '2021-11-19 00:27:45', 'administrador', 'UPDATE', '18|Juan|Perez|180080043@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(96, 'root@localhost', '2021-11-19 00:28:06', 'administrador', 'UPDATE', '18|Juan|Perez|180080043@upve.edu.mx|83938af5334590068f6f96f56883eb1d6d00eb7a20cc0a7f08f47eecc5bc24fcab66c77448b9617d672375276a488d24b21b29b52050d03c6b3b914b378959b4', '18|Juan|Perez|180080043@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(97, 'root@localhost', '2021-11-19 00:58:33', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|83938af5334590068f6f96f56883eb1d6d00eb7a20cc0a7f08f47eecc5bc24fcab66c77448b9617d672375276a488d24b21b29b52050d03c6b3b914b378959b4', '18|Juan|Perez|180080043@upve.edu.mx|83938af5334590068f6f96f56883eb1d6d00eb7a20cc0a7f08f47eecc5bc24fcab66c77448b9617d672375276a488d24b21b29b52050d03c6b3b914b378959b4'),
(98, 'root@localhost', '2021-11-19 00:58:52', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|c62bcca9e21f323c2fa0899a4dfa55ef482c51ea5ff01ffd23b100638084e0622017cba0c4fcacfffa673884b111d888dc78d5949008b73bc8bb6e7e6df3628b', '18|Juan|Perez|180080049@upve.edu.mx|83938af5334590068f6f96f56883eb1d6d00eb7a20cc0a7f08f47eecc5bc24fcab66c77448b9617d672375276a488d24b21b29b52050d03c6b3b914b378959b4'),
(99, 'root@localhost', '2021-11-19 00:59:49', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|c62bcca9e21f323c2fa0899a4dfa55ef482c51ea5ff01ffd23b100638084e0622017cba0c4fcacfffa673884b111d888dc78d5949008b73bc8bb6e7e6df3628b'),
(100, 'root@localhost', '2021-11-19 16:01:21', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|f3b27a7574f7264642a7f00f6771737477617ac92d2e5e89ae3cceb01e5b5fbe633e2d57287388f5d2a4a0573414fac0c5226b906688cbde9f98003454b0a540', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(101, 'root@localhost', '2021-11-19 16:09:51', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|f3b27a7574f7264642a7f00f6771737477617ac92d2e5e89ae3cceb01e5b5fbe633e2d57287388f5d2a4a0573414fac0c5226b906688cbde9f98003454b0a540'),
(102, 'root@localhost', '2021-11-19 16:18:36', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|5e08b926dd557f931d49ec1bf0b52a0efc4fd963a21078a476a45653530553d4f1f94183a154f74007a24023d820c8dc69e9d76fc8df5189678f3a06c4110969', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(103, 'root@localhost', '2021-11-19 16:19:52', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|5e08b926dd557f931d49ec1bf0b52a0efc4fd963a21078a476a45653530553d4f1f94183a154f74007a24023d820c8dc69e9d76fc8df5189678f3a06c4110969'),
(104, 'root@localhost', '2021-11-19 16:21:28', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|b583c2bb16666253c9a01b041e5a67d1b75b857e10e71e81ca76c22c4ca4dcbd8fd70d9237235deeb2933995f702d6bf2dfeaef0aeafa3b06497b627cfa09b2e', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(105, 'root@localhost', '2021-11-19 16:22:22', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|b583c2bb16666253c9a01b041e5a67d1b75b857e10e71e81ca76c22c4ca4dcbd8fd70d9237235deeb2933995f702d6bf2dfeaef0aeafa3b06497b627cfa09b2e'),
(106, 'root@localhost', '2021-11-19 16:27:40', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|bd6862617c266a35aa8d5e7abf40f2960c4e91d019ab1d2fd80f8e9b2adc50e840ba388f6b8db3f528a2e4c182efda5b41f6ddcb40820f367a2cd174b6a62dcc', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(107, 'root@localhost', '2021-11-19 16:30:52', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|bd6862617c266a35aa8d5e7abf40f2960c4e91d019ab1d2fd80f8e9b2adc50e840ba388f6b8db3f528a2e4c182efda5b41f6ddcb40820f367a2cd174b6a62dcc', '18|Juan|Perez|180080049@upve.edu.mx|bd6862617c266a35aa8d5e7abf40f2960c4e91d019ab1d2fd80f8e9b2adc50e840ba388f6b8db3f528a2e4c182efda5b41f6ddcb40820f367a2cd174b6a62dcc'),
(108, 'root@localhost', '2021-11-19 16:32:29', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|6c3c3a4e52c08d971c3608c398579cf3c6992dd90c9742ab28f92e3422b490e15485b1e8cd01e6773f491bbac73412e6d0d70f4d2700b70dab50b8f7fdceced9', '18|Juan|Perez|180080049@upve.edu.mx|bd6862617c266a35aa8d5e7abf40f2960c4e91d019ab1d2fd80f8e9b2adc50e840ba388f6b8db3f528a2e4c182efda5b41f6ddcb40820f367a2cd174b6a62dcc'),
(109, 'root@localhost', '2021-11-19 16:38:32', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|6c3c3a4e52c08d971c3608c398579cf3c6992dd90c9742ab28f92e3422b490e15485b1e8cd01e6773f491bbac73412e6d0d70f4d2700b70dab50b8f7fdceced9'),
(110, 'root@localhost', '2021-11-19 16:39:16', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|6ab6e44ce162746e8f9530b8c3c17581b9cc1b750e7323ed5a31c7803c36be836b1852cbd30666781b3b914cda4807d6ff2baa74220562f4fcfeb0ec5b26f881', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(111, 'root@localhost', '2021-11-19 16:39:46', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|6ab6e44ce162746e8f9530b8c3c17581b9cc1b750e7323ed5a31c7803c36be836b1852cbd30666781b3b914cda4807d6ff2baa74220562f4fcfeb0ec5b26f881'),
(112, 'root@localhost', '2021-11-19 16:43:39', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|1471acd30dc2338fddbb1b461b04b237ee633b1c5876fd5c0b9880cc65d517b25ce6d58e47764541163155fedf49c3692c6b22bef0cb0c7c98f7447f7fe45c0a', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(113, 'root@localhost', '2021-11-19 16:47:11', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|1471acd30dc2338fddbb1b461b04b237ee633b1c5876fd5c0b9880cc65d517b25ce6d58e47764541163155fedf49c3692c6b22bef0cb0c7c98f7447f7fe45c0a'),
(114, 'root@localhost', '2021-11-19 18:58:12', 'mantenimiento', 'INSERT', '4|2021-11-19 11:58:12|se aplico mantenimiento|5|0', ''),
(115, 'root@localhost', '2021-11-19 18:58:26', 'mantenimiento', 'INSERT', '5|2021-11-19 11:58:26|se aplico mantenimiento otra vez|5|0', ''),
(116, 'root@localhost', '2021-11-19 20:08:11', 'recipiente', 'INSERT', '3|recipiente 1|4|10 lt|3|0', ''),
(117, 'root@localhost', '2021-11-19 20:26:16', 'reactivo', 'INSERT', '4|octanol|2|12|Frasco vidrio|23ml|HHSJ332K|2021-11-023|6|3|0', ''),
(118, 'root@localhost', '2021-11-19 22:09:46', 'reactivo', 'UPDATE', '3|butamol|1|11|Frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|1', '3|butamol|1|11|Frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|0'),
(119, 'root@localhost', '2021-11-19 22:09:59', 'reactivo', 'UPDATE', '3|butamol|1|11|Frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|0', '3|butamol|1|11|Frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|1'),
(120, 'root@localhost', '2021-11-19 22:20:04', 'reactivo', 'INSERT', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|0', ''),
(121, 'root@localhost', '2021-11-19 22:20:39', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-262|3|3|0', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|0'),
(122, 'root@localhost', '2021-11-19 22:21:08', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-272|3|3|0', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-262|3|3|0'),
(123, 'root@localhost', '2021-11-19 22:21:29', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|0', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-272|3|3|0'),
(138, 'root@localhost', '2021-11-20 18:29:08', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|1', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|0'),
(139, 'root@localhost', '2021-11-20 19:25:57', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|0', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|1'),
(140, 'root@localhost', '2021-11-21 18:43:50', 'equipo', 'UPDATE', '5|Vaso de precipitados|en buenas condiciones|1|1|3', '5|Vaso de precipitados|en buenas condiciones|1|1|3'),
(141, 'root@localhost', '2021-11-21 18:44:22', 'reactivo', 'UPDATE', '4|octanol|2|12|Frasco vidrio|23ml|HHSJ332K|2021-11-023|6|3|1', '4|octanol|2|12|Frasco vidrio|23ml|HHSJ332K|2021-11-023|6|3|0'),
(142, 'root@localhost', '2021-11-21 18:44:51', 'recipiente', 'UPDATE', '3|recipiente 1|4|10 lt|3|1', '3|recipiente 1|4|10 lt|3|0'),
(143, 'root@localhost', '2021-11-21 18:45:49', 'equipo', 'INSERT', '6|equipo 2|muy bueno|124234|11009934|3', ''),
(144, 'root@localhost', '2021-11-21 18:46:22', 'recipiente', 'INSERT', '4|recipiente 2|1|40 lt|3|0', ''),
(145, 'root@localhost', '2021-11-22 18:20:03', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|b8478a763f60027807d0268b68f5695490cfada44fc3dd2837da4e027dd5dfd38d5aab8c6651c2c7c3dac2f4fabf635782b5cbb36aa4683d8d341827049743bf', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(146, 'root@localhost', '2021-11-22 18:23:16', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd', '18|Juan|Perez|180080049@upve.edu.mx|b8478a763f60027807d0268b68f5695490cfada44fc3dd2837da4e027dd5dfd38d5aab8c6651c2c7c3dac2f4fabf635782b5cbb36aa4683d8d341827049743bf'),
(147, 'root@localhost', '2021-11-23 20:16:19', 'tipo_material', 'UPDATE', '1|Vidrio', '1|corcho'),
(148, 'root@localhost', '2021-11-23 20:16:27', 'tipo_material', 'UPDATE', '2|Plástico', '2|carton'),
(149, 'root@localhost', '2021-11-23 20:16:55', 'tipo_material', 'UPDATE', '4|Plástico', '4|plastico'),
(150, 'root@localhost', '2021-11-23 20:16:59', 'tipo_material', 'DELETE', '', '2|Plástico'),
(151, 'root@localhost', '2021-11-25 23:01:09', 'reactivo', 'INSERT', '7|reactivo 1|0|00|Frasco Plástico|PocoMililitro|Inflamable|2021-12-10213|2|3|0', ''),
(152, 'root@localhost', '2021-11-25 23:03:25', 'reactivo', 'INSERT', '8|reactivo 2|1|23|Frasco Plástico|MedioGramo|Oxidante|2022-03-03123|21|3|0', ''),
(153, 'root@localhost', '2021-11-25 23:04:48', 'reactivo', 'INSERT', '9|reactivo 3|0|00|Bidón Plástico|LlenoGramo|Inflamable|2021-12-09123|12|3|0', ''),
(154, 'root@localhost', '2021-11-25 23:09:27', 'reactivo', 'INSERT', '10|reactivo 4|1|23|Frasco Plástico|LlenoGramo|Inflamable|2022-01-21123|12|3|0', ''),
(155, 'root@localhost', '2021-11-25 23:35:45', 'reactivo', 'INSERT', '11|butamol|1|11|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0', ''),
(156, 'root@localhost', '2021-11-25 23:42:45', 'reactivo', 'INSERT', '12|butamol 2|1|11|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0', ''),
(157, 'root@localhost', '2021-11-25 23:49:35', 'reactivo', 'UPDATE', '11|butamol 3|1|11|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0', '11|butamol|1|11|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0'),
(158, 'root@localhost', '2021-11-25 23:51:11', 'reactivo', 'UPDATE', '11|butamol 3|1|21|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0', '11|butamol 3|1|11|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0'),
(159, 'root@localhost', '2021-11-25 23:53:19', 'reactivo', 'UPDATE', '3|butamol|1|11|Frasco Plástico|MedioLitro|Oxidante|2022-09-281|1|3|0', '3|butamol|1|11|Frasco vidrio|50lts|334JFEWD2|2022-09-281|1|3|0'),
(160, 'root@localhost', '2021-11-26 00:00:50', 'reactivo', 'INSERT', '13|asfa|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0', ''),
(161, 'root@localhost', '2021-11-26 00:01:25', 'reactivo', 'UPDATE', '13|udpate|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0', '13|asfa|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0'),
(162, 'root@localhost', '2021-11-26 00:10:27', 'reactivo', 'UPDATE', '13|udpate3|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0', '13|udpate|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0'),
(163, 'root@localhost', '2021-11-26 00:10:53', 'reactivo', 'UPDATE', '13|udpate33|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0', '13|udpate3|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0'),
(164, 'root@localhost', '2021-11-26 00:12:20', 'reactivo', 'UPDATE', '13|udpate33|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-1032|234|3|0', '13|udpate33|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-10324234|234|3|0'),
(165, 'root@localhost', '2021-11-26 00:12:59', 'reactivo', 'INSERT', '14|asd|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', ''),
(166, 'root@localhost', '2021-11-26 00:13:59', 'reactivo', 'UPDATE', '14|otro|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|asd|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(167, 'root@localhost', '2021-11-26 00:14:27', 'reactivo', 'UPDATE', '14|otro 2|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(168, 'root@localhost', '2021-11-26 00:14:52', 'reactivo', 'UPDATE', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro 2|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(169, 'root@localhost', '2021-11-26 00:17:12', 'reactivo', 'UPDATE', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(170, 'root@localhost', '2021-11-26 00:17:25', 'reactivo', 'UPDATE', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(171, 'root@localhost', '2021-11-26 00:17:46', 'reactivo', 'UPDATE', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(172, 'root@localhost', '2021-11-26 00:29:17', 'reactivo', 'UPDATE', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(173, 'root@localhost', '2021-11-26 00:29:43', 'reactivo', 'UPDATE', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(174, 'root@localhost', '2021-11-26 00:30:10', 'reactivo', 'INSERT', '15|asd|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0', ''),
(175, 'root@localhost', '2021-11-26 00:30:43', 'reactivo', 'UPDATE', '15|asd|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0', '15|asd|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0'),
(176, 'root@localhost', '2021-11-26 00:30:59', 'reactivo', 'UPDATE', '15|elminar|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0', '15|asd|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0'),
(177, 'root@localhost', '2021-11-26 00:31:37', 'reactivo', 'UPDATE', '15|elminar 4|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0', '15|elminar|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0'),
(178, 'root@localhost', '2021-11-26 00:44:04', 'reactivo', 'UPDATE', '15|elminar 4|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|1', '15|elminar 4|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|0'),
(179, 'root@localhost', '2021-11-26 00:44:48', 'reactivo', 'DELETE', '', '15|elminar 4|0|00|Bidón Plástico|MedioMililitro|Oxidante|2021-12-0932|32|3|1'),
(180, 'root@localhost', '2021-11-26 00:44:51', 'reactivo', 'DELETE', '', '14|otro 1|0|00|Frasco Vidrio|LlenoGramo|Oxidante|2021-12-112341|12|3|0'),
(181, 'root@localhost', '2021-11-26 00:44:54', 'reactivo', 'DELETE', '', '13|udpate33|0|00|Bidón Plástico|MedioGramo|Corrosivo|2021-12-1032|234|3|0'),
(182, 'root@localhost', '2021-11-26 00:44:57', 'reactivo', 'DELETE', '', '12|butamol 2|1|11|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0'),
(183, 'root@localhost', '2021-11-26 00:45:00', 'reactivo', 'DELETE', '', '11|butamol 3|1|21|Bidón Vidrio|MedioGramo|Tóxico|2022-09-281|1|3|0'),
(184, 'root@localhost', '2021-11-26 00:45:03', 'reactivo', 'DELETE', '', '10|reactivo 4|1|23|Frasco Plástico|LlenoGramo|Inflamable|2022-01-21123|12|3|0'),
(185, 'root@localhost', '2021-11-26 00:45:05', 'reactivo', 'DELETE', '', '9|reactivo 3|0|00|Bidón Plástico|LlenoGramo|Inflamable|2021-12-09123|12|3|0'),
(186, 'root@localhost', '2021-11-26 00:45:09', 'reactivo', 'DELETE', '', '8|reactivo 2|1|23|Frasco Plástico|MedioGramo|Oxidante|2022-03-03123|21|3|0'),
(187, 'root@localhost', '2021-11-26 00:45:12', 'reactivo', 'DELETE', '', '7|reactivo 1|0|00|Frasco Plástico|PocoMililitro|Inflamable|2021-12-10213|2|3|0'),
(188, 'root@localhost', '2021-11-26 00:45:50', 'reactivo', 'INSERT', '16|nuevo reactivo|0|00|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|0', ''),
(189, 'root@localhost', '2021-11-26 00:46:01', 'reactivo', 'UPDATE', '16|nuevo reactivo|0|00|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|0', '16|nuevo reactivo|0|00|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|0'),
(190, 'root@localhost', '2021-11-26 00:46:17', 'reactivo', 'UPDATE', '16|nuevo reactivo|1|32|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|0', '16|nuevo reactivo|0|00|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|0'),
(191, 'root@localhost', '2021-11-26 00:46:27', 'reactivo', 'UPDATE', '16|nuevo reactivo|1|32|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|1', '16|nuevo reactivo|1|32|Frasco Plástico|MedioGramo|Oxidante|2021-12-03213|23|3|0'),
(192, 'root@localhost', '2021-11-26 00:49:33', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Bidón Vidrio|MedioGramo|Oxidante|2021-11-242|3|3|0', '5|sulfónico|1|23|Frasco vidrio|45gr|JJD344300D|2021-11-242|3|3|0'),
(193, 'root@localhost', '2021-11-26 00:50:13', 'reactivo', 'UPDATE', '3|butamol|1|11|Frasco Plástico|PocoLitro|Oxidante|2022-09-281|1|3|0', '3|butamol|1|11|Frasco Plástico|MedioLitro|Oxidante|2022-09-281|1|3|0'),
(194, 'root@localhost', '2021-11-26 04:37:22', 'reactivo', 'INSERT', '17|reactivo 1|1|22|Frasco Plástico|MedioGramo|Inflamable|2021-11-30342|234|3|0', ''),
(195, 'root@localhost', '2021-11-26 04:39:37', 'reactivo', 'UPDATE', '17|reactivo 2|1|22|Frasco Plástico|MedioGramo|Inflamable|2021-11-30342|234|3|0', '17|reactivo 1|1|22|Frasco Plástico|MedioGramo|Inflamable|2021-11-30342|234|3|0'),
(196, 'root@localhost', '2021-11-26 04:40:08', 'reactivo', 'UPDATE', '17|reactivo 2|1|22|Frasco Plástico|MedioGramo|Inflamable|2021-11-30342|234|3|1', '17|reactivo 2|1|22|Frasco Plástico|MedioGramo|Inflamable|2021-11-30342|234|3|0'),
(197, 'root@localhost', '2021-11-26 04:53:42', 'reactivo', 'INSERT', '18|sasf|0|00|Frasco Plástico|LlenoMililitro|Oxidante|2021-12-0224|23|3|0', ''),
(198, 'root@localhost', '2021-11-26 05:01:44', 'reactivo', 'UPDATE', '18|sasf|0|00|Frasco Plástico|LlenoMililitro|Oxidante|2021-12-0224|23|3|1', '18|sasf|0|00|Frasco Plástico|LlenoMililitro|Oxidante|2021-12-0224|23|3|0'),
(199, 'root@localhost', '2021-11-26 19:40:49', 'equipo', 'INSERT', '7|equipo 3|asf|3|asf|3', ''),
(200, 'root@localhost', '2021-11-26 19:42:27', 'equipo', 'UPDATE', '7|equipo 3|asf|3|asf|3', '7|equipo 3|asf|3|asf|3'),
(201, 'root@localhost', '2021-11-26 19:42:38', 'equipo', 'DELETE', '', '7|equipo 3|asf|3|asf|3'),
(202, 'root@localhost', '2021-11-26 19:43:05', 'equipo', 'INSERT', '8|nombre|condicion|1|serie|3', ''),
(203, 'root@localhost', '2021-11-26 19:45:09', 'equipo', 'INSERT', '9|equipo 3|asf|32|sdf32|3', ''),
(204, 'root@localhost', '2021-11-26 21:34:35', 'equipo', 'DELETE', '', '9|equipo 3|asf|32|sdf32|3'),
(205, 'root@localhost', '2021-11-26 21:35:25', 'equipo', 'INSERT', '10|prueba |23|998|98hih|3', ''),
(206, 'root@localhost', '2021-11-26 21:40:02', 'equipo', 'DELETE', '', '10|prueba |23|998|98hih|3'),
(207, 'root@localhost', '2021-11-26 21:40:49', 'equipo', 'INSERT', '11|prueba|23|234|2324|3', ''),
(208, 'root@localhost', '2021-11-26 21:42:07', 'equipo', 'UPDATE', '11|prueba 2|23|234|2324|3', '11|prueba|23|234|2324|3'),
(209, 'root@localhost', '2021-11-26 21:44:02', 'equipo', 'UPDATE', '11|prueba 2|23|234|2324|3', '11|prueba 2|23|234|2324|3'),
(210, 'root@localhost', '2021-11-26 21:51:02', 'equipo', 'UPDATE', '11|prueba 2|23|234|2324|3', '11|prueba 2|23|234|2324|3'),
(211, 'root@localhost', '2021-11-26 22:02:27', 'equipo', 'DELETE', '', '11|prueba 2|23|234|2324|3'),
(212, 'root@localhost', '2021-11-26 22:03:08', 'equipo', 'INSERT', '12|prueba|23|234|234|3', ''),
(213, 'root@localhost', '2021-11-26 22:04:05', 'equipo', 'UPDATE', '12|prueba 2|23|234|234|3', '12|prueba|23|234|234|3'),
(214, 'root@localhost', '2021-11-26 22:04:40', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 2|23|234|234|3'),
(215, 'root@localhost', '2021-11-26 22:04:57', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(216, 'root@localhost', '2021-11-26 22:09:20', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(217, 'root@localhost', '2021-11-26 22:11:00', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(218, 'root@localhost', '2021-11-26 22:12:48', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(219, 'root@localhost', '2021-11-26 22:13:53', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(220, 'root@localhost', '2021-11-26 22:16:36', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(221, 'root@localhost', '2021-11-26 22:17:49', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(222, 'root@localhost', '2021-11-26 22:18:52', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(223, 'root@localhost', '2021-11-26 22:20:40', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(224, 'root@localhost', '2021-11-26 22:21:37', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(225, 'root@localhost', '2021-11-26 22:24:04', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(226, 'root@localhost', '2021-11-26 22:27:03', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(227, 'root@localhost', '2021-11-26 22:27:29', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(228, 'root@localhost', '2021-11-26 22:28:05', 'equipo', 'UPDATE', '8|nombre|condicion|1|serie|3', '8|nombre|condicion|1|serie|3'),
(229, 'root@localhost', '2021-11-26 22:28:26', 'equipo', 'UPDATE', '8|nombre|condicion|1|serie|3', '8|nombre|condicion|1|serie|3'),
(230, 'root@localhost', '2021-11-26 22:30:00', 'equipo', 'UPDATE', '12|prueba 3|23|234|234|3', '12|prueba 3|23|234|234|3'),
(231, 'root@localhost', '2021-11-27 20:16:07', 'administrador', 'INSERT', '20|asfasfa|asfafs|micorreo@gmail.com|1aecd2f827873fa7588cd59ba1fb8954c3c6f6317cc68de62e671e0b54db4325f53be87cf12bbbb54d9fa960c81001de337672880b08436fe524d38f2b4a4cb9', ''),
(232, 'root@localhost', '2021-11-27 20:16:35', 'administrador', 'DELETE', '', '20|asfasfa|asfafs|micorreo@gmail.com|1aecd2f827873fa7588cd59ba1fb8954c3c6f6317cc68de62e671e0b54db4325f53be87cf12bbbb54d9fa960c81001de337672880b08436fe524d38f2b4a4cb9'),
(233, 'root@localhost', '2021-11-27 20:17:07', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|9f0fb3fae77cb8ccec42189a5d18beca7cf12af81d6bb2cbce9fe7368dda05c77a171fc5e3b32bf74a1f4559dd52a60e16a975f818dee188a528f091fc7d852a', '18|Juan|Perez|180080049@upve.edu.mx|e7354e85f120abcc0e4654d1dc56ffb285f44b9a9a7c10e406460f38d3738756dd401539603872e19800d26ad6eed57a751620396242b148366901831d967ebd'),
(234, 'root@localhost', '2021-11-27 20:30:26', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|0cbee8715e5908fb780f0786ca212f8c9f36028e0ade32eaa65d04faddd10ae10b0f64d6ed5d7c1a4b5441340229ef3a858907100dcbb0f24a428504bc419c5d', '18|Juan|Perez|180080049@upve.edu.mx|9f0fb3fae77cb8ccec42189a5d18beca7cf12af81d6bb2cbce9fe7368dda05c77a171fc5e3b32bf74a1f4559dd52a60e16a975f818dee188a528f091fc7d852a'),
(235, 'root@localhost', '2021-11-27 20:33:10', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|66b671aafae42bb0fc70ec637f9bff599a0e28065e3b5a3b0144be357c792a0ff43d747952fdc57b3e64412df9189d5a96f66a3eac237714df15395f7094ab71', '18|Juan|Perez|180080049@upve.edu.mx|0cbee8715e5908fb780f0786ca212f8c9f36028e0ade32eaa65d04faddd10ae10b0f64d6ed5d7c1a4b5441340229ef3a858907100dcbb0f24a428504bc419c5d'),
(236, 'root@localhost', '2021-11-27 20:34:16', 'administrador', 'UPDATE', '18|Juan|Perez|180080049@upve.edu.mx|0cbee8715e5908fb780f0786ca212f8c9f36028e0ade32eaa65d04faddd10ae10b0f64d6ed5d7c1a4b5441340229ef3a858907100dcbb0f24a428504bc419c5d', '18|Juan|Perez|180080049@upve.edu.mx|66b671aafae42bb0fc70ec637f9bff599a0e28065e3b5a3b0144be357c792a0ff43d747952fdc57b3e64412df9189d5a96f66a3eac237714df15395f7094ab71'),
(237, 'root@localhost', '2021-11-27 21:52:02', 'recipiente', 'INSERT', '5|recipiente 3|1|Kilogramo|3|0', ''),
(238, 'root@localhost', '2021-11-27 22:57:59', 'recipiente', 'UPDATE', '5|recipiente 3|1|Kilogramo|3|0', '5|recipiente 3|1|Kilogramo|3|0'),
(239, 'root@localhost', '2021-11-27 23:00:13', 'recipiente', 'UPDATE', '5|recipiente 3|1|Kilogramo|3|0', '5|recipiente 3|1|Kilogramo|3|0'),
(240, 'root@localhost', '2021-11-27 23:01:12', 'recipiente', 'UPDATE', '4|recipiente 2|1|Volúmen|3|0', '4|recipiente 2|1|40 lt|3|0'),
(241, 'root@localhost', '2021-11-27 23:04:00', 'recipiente', 'INSERT', '6|kjh|1|Volúmen|3|0', ''),
(242, 'root@localhost', '2021-11-27 23:04:17', 'recipiente', 'UPDATE', '6|kjh|1|Volúmen|3|1', '6|kjh|1|Volúmen|3|0'),
(243, 'root@localhost', '2021-11-27 23:04:33', 'recipiente', 'DELETE', '', '6|kjh|1|Volúmen|3|1'),
(244, 'root@localhost', '2021-11-29 17:53:09', 'mantenimiento', 'INSERT', '6|2021-11-29 00:00:00|todo bien|8|0', ''),
(245, 'root@localhost', '2021-11-29 18:00:08', 'mantenimiento', 'INSERT', '7|2021-12-01 11:59:00|todo fain|8|0', ''),
(246, 'root@localhost', '2021-11-29 18:03:28', 'mantenimiento', 'INSERT', '8|2021-12-02 13:00:00|todo deli|8|0', ''),
(247, 'root@localhost', '2021-11-29 18:15:41', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Bidón Vidrio|MedioGramo|Oxidante|2021-11-242|3|3|0|vacio', '5|sulfónico|1|23|Bidón Vidrio|MedioGramo|Oxidante|2021-11-242|3|3|0|vacio'),
(248, 'root@localhost', '2021-11-29 18:50:22', 'reactivo', 'UPDATE', '5|sulfónico|1|23|Bidón Vidrio|MedioGramo|Oxidante|2021-11-242|3|3|0|is null', '5|sulfónico|1|23|Bidón Vidrio|MedioGramo|Oxidante|2021-11-242|3|3|0|is null'),
(249, 'root@localhost', '2021-11-29 19:44:38', 'mantenimiento', 'INSERT', '9|2021-11-29 12:44:00|ahi va|8|0', ''),
(250, 'root@localhost', '2021-11-29 19:48:34', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:44:00|ahi va|8|0', '9|2021-11-29 12:44:00|ahi va|8|0'),
(251, 'root@localhost', '2021-11-29 19:50:11', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:44:00|ahi va|8|0', '9|2021-11-29 12:44:00|ahi va|8|0'),
(252, 'root@localhost', '2021-11-29 19:50:19', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:44:00|ahi va|8|0', '9|2021-11-29 12:44:00|ahi va|8|0'),
(253, 'root@localhost', '2021-11-29 19:51:06', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:45:00|ahi va|8|0', '9|2021-11-29 12:44:00|ahi va|8|0'),
(254, 'root@localhost', '2021-11-29 19:55:25', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:55:25|ahi va|8|1', '9|2021-11-29 12:45:00|ahi va|8|0'),
(255, 'root@localhost', '2021-11-29 19:58:12', 'mantenimiento', 'UPDATE', '8|2021-11-29 12:58:12|todo deli|8|1', '8|2021-12-02 13:00:00|todo deli|8|0'),
(256, 'root@localhost', '2021-11-29 19:58:25', 'mantenimiento', 'UPDATE', '8|2021-11-29 12:58:25|todo deli|8|0', '8|2021-11-29 12:58:12|todo deli|8|1'),
(257, 'root@localhost', '2021-11-29 19:58:28', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:58:28|ahi va|8|0', '9|2021-11-29 12:55:25|ahi va|8|1'),
(258, 'root@localhost', '2021-11-29 19:58:51', 'mantenimiento', 'UPDATE', '8|2021-11-29 12:58:25|todo bien|8|0', '8|2021-11-29 12:58:25|todo deli|8|0'),
(259, 'root@localhost', '2021-11-29 19:59:01', 'mantenimiento', 'UPDATE', '9|2021-11-29 12:58:28|todo bien|8|0', '9|2021-11-29 12:58:28|ahi va|8|0'),
(260, 'root@localhost', '2021-11-29 19:59:46', 'mantenimiento', 'INSERT', '10|2021-11-29 12:59:00|sin problemas.|12|0', ''),
(261, 'root@localhost', '2021-11-29 20:00:22', 'equipo', 'UPDATE', '12|prueba 3|todo bien|234|234|3|1637965800.png|0|is null', '12|prueba 3|23|234|234|3|1637965800.png|0|is null');

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
  `imagen` text DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `equipo`
--

INSERT INTO `equipo` (`id`, `nombre`, `condicion_uso`, `num_economico`, `num_serie`, `id_laboratorio`, `imagen`, `eliminado`, `fecha_baja`) VALUES
(5, 'Vaso de precipitados', 'en buenas condiciones', 1, '1', 3, NULL, 1, NULL),
(6, 'equipo 2', 'muy bueno', 124234, '11009934', 3, NULL, 0, '2021-11-21 19:45:20'),
(8, 'nombre', 'condicion', 1, 'serie', 3, '1637965706.jpg', 0, NULL),
(12, 'prueba 3', 'todo bien', 234, '234', 3, '1637965800.png', 0, NULL);

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
(3, 'quimica', 18, 'laboratorio de quimica');

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
-- Volcado de datos para la tabla `mantenimiento`
--

INSERT INTO `mantenimiento` (`id`, `fecha_mantenimiento`, `observaciones`, `id_equipo`, `eliminado`) VALUES
(4, '2021-11-19 18:58:12', 'se aplico mantenimiento', 5, 0),
(5, '2021-11-19 18:58:26', 'se aplico mantenimiento otra vez', 5, 0),
(6, '2021-11-29 07:00:00', 'todo bien', 8, 0),
(7, '2021-12-01 18:59:00', 'todo fain', 8, 0),
(8, '2021-11-29 19:58:25', 'todo bien', 8, 0),
(9, '2021-11-29 19:58:28', 'todo bien', 8, 0),
(10, '2021-11-29 19:59:00', 'sin problemas.', 12, 0);

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
-- Volcado de datos para la tabla `reactivo`
--

INSERT INTO `reactivo` (`id`, `nombre`, `reactividad`, `inflamabilidad`, `riesgo_salud`, `presentacion`, `cantidad_reactivo`, `unidad_medida`, `codigo_almacenamiento`, `caducidad`, `num_mueble`, `num_estante`, `id_laboratorio`, `eliminado`, `fecha_baja`) VALUES
(3, 'butamol', 1, 1, 1, 'Frasco Plástico', 'Poco', 'Litro', 'Oxidante', '2022-09-28', 1, 1, 3, 0, NULL),
(4, 'octanol', 2, 1, 2, 'Frasco vidrio', '23', 'ml', 'HHSJ332K', '2021-11-02', 3, 6, 3, 1, NULL),
(5, 'sulfónico', 1, 2, 3, 'Bidón Vidrio', 'Medio', 'Gramo', 'Oxidante', '2021-11-24', 2, 3, 3, 0, NULL),
(16, 'nuevo reactivo', 1, 3, 2, 'Frasco Plástico', 'Medio', 'Gramo', 'Oxidante', '2021-12-03', 213, 23, 3, 1, '2021-11-25 17:46:27'),
(17, 'reactivo 2', 1, 2, 2, 'Frasco Plástico', 'Medio', 'Gramo', 'Inflamable', '2021-11-30', 342, 234, 3, 1, '2021-11-25 21:40:08'),
(18, 'sasf', 0, 0, 0, 'Frasco Plástico', 'Lleno', 'Mililitro', 'Oxidante', '2021-12-02', 24, 23, 3, 1, '2021-11-25 22:01:44');

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
OLD.riesgo_salud,'|',OLD.presentacion,'|',OLD.cantidad_reactivo,
OLD.unidad_medida,'|',OLD.codigo_almacenamiento,'|',OLD.caducidad,
OLD.num_mueble,'|',OLD.num_estante,'|',OLD.id_laboratorio
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
NEW.riesgo_salud,'|',NEW.presentacion,'|',NEW.cantidad_reactivo,
NEW.unidad_medida,'|',NEW.codigo_almacenamiento,'|',NEW.caducidad,
NEW.num_mueble,'|',NEW.num_estante,'|',NEW.id_laboratorio,'|',
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
NEW.riesgo_salud,'|',NEW.presentacion,'|',NEW.cantidad_reactivo,
NEW.unidad_medida,'|',NEW.codigo_almacenamiento,'|',NEW.caducidad,
NEW.num_mueble,'|',NEW.num_estante,'|',NEW.id_laboratorio
,'|',NEW.eliminado,'|',@fecha_baja_new),
CONCAT(OLD.id,'|',
OLD.nombre,'|',OLD.reactividad,'|',OLD.inflamabilidad,
OLD.riesgo_salud,'|',OLD.presentacion,'|',OLD.cantidad_reactivo,
OLD.unidad_medida,'|',OLD.codigo_almacenamiento,'|',OLD.caducidad,
OLD.num_mueble,'|',OLD.num_estante,'|',OLD.id_laboratorio
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
  `imagen` text DEFAULT NULL,
  `eliminado` tinyint(1) NOT NULL DEFAULT 0,
  `fecha_baja` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `recipiente`
--

INSERT INTO `recipiente` (`id`, `nombre`, `id_tipo_material`, `capacidad`, `id_laboratorio`, `imagen`, `eliminado`, `fecha_baja`) VALUES
(3, 'recipiente 1', 4, '10 lt', 3, NULL, 1, NULL),
(4, 'recipiente 2', 1, 'Volúmen', 3, '1638054072.jpg', 0, '2021-11-21 19:45:57'),
(5, 'recipiente 3', 1, 'Kilogramo', 3, '1638054013.png', 0, NULL);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=262;

--
-- AUTO_INCREMENT de la tabla `equipo`
--
ALTER TABLE `equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `laboratorio`
--
ALTER TABLE `laboratorio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `mantenimiento`
--
ALTER TABLE `mantenimiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `reactivo`
--
ALTER TABLE `reactivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de la tabla `recipiente`
--
ALTER TABLE `recipiente`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
