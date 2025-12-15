-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-12-2025 a las 05:35:01
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
-- Base de datos: `sga_final`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administrativos`
--

CREATE TABLE `administrativos` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `area` enum('Secretaría Académica','Tesorería','Registro','Ventanilla Única','Otro') DEFAULT 'Otro',
  `telefono` varchar(15) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administrativos`
--

INSERT INTO `administrativos` (`id`, `usuario_id`, `nombres`, `apellidos`, `dni`, `area`, `telefono`, `fecha_ingreso`) VALUES
(1, 7, 'Luis', 'Ram??rez Torres', '99887766', 'Otro', '987654001', '2025-11-09'),
(2, 8, 'Carmen', 'Flores Vega', '88776655', 'Registro', '987654002', '2025-11-09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asistencias`
--

CREATE TABLE `asistencias` (
  `id` int(11) NOT NULL,
  `matricula_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` enum('Asistió','Tardanza','Falta','Justificado') DEFAULT 'Falta',
  `observacion` varchar(255) DEFAULT NULL,
  `hora_registro` time DEFAULT NULL COMMENT 'Hora en que se registró',
  `registrado_por` int(11) DEFAULT NULL COMMENT 'Usuario que registró'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `asistencias`
--

INSERT INTO `asistencias` (`id`, `matricula_id`, `fecha`, `estado`, `observacion`, `hora_registro`, `registrado_por`) VALUES
(1, 64, '2025-12-06', '', NULL, '21:57:30', NULL),
(2, 65, '2025-12-06', '', NULL, '21:57:30', NULL),
(3, 66, '2025-12-06', '', NULL, '21:57:30', NULL),
(4, 67, '2025-12-06', '', NULL, '21:57:30', NULL),
(5, 68, '2025-12-06', '', NULL, '21:57:30', NULL),
(6, 69, '2025-12-06', '', NULL, '21:57:30', NULL),
(7, 70, '2025-12-06', '', NULL, '21:57:30', NULL),
(8, 71, '2025-12-06', '', NULL, '21:57:30', NULL),
(9, 72, '2025-12-06', '', NULL, '21:57:30', NULL),
(10, 73, '2025-12-06', '', NULL, '21:57:30', NULL),
(16, 46, '2025-12-07', 'Tardanza', NULL, '22:31:50', NULL),
(17, 72, '2025-12-07', 'Tardanza', NULL, '05:28:52', NULL),
(18, 67, '2025-12-07', 'Tardanza', NULL, '05:28:52', NULL),
(19, 92, '2025-12-07', 'Justificado', NULL, '05:28:52', NULL),
(20, 77, '2025-12-07', 'Falta', NULL, '05:28:52', NULL),
(21, 48, '2025-12-07', 'Falta', NULL, '05:28:52', NULL),
(22, 82, '2025-12-07', 'Falta', NULL, '05:28:52', NULL),
(23, 53, '2025-12-07', 'Falta', NULL, '05:28:52', NULL),
(24, 87, '2025-12-07', 'Falta', NULL, '05:28:52', NULL),
(25, 58, '2025-12-07', 'Falta', NULL, '05:28:52', NULL),
(26, 64, '2025-12-07', 'Tardanza', NULL, '18:09:14', NULL),
(27, 69, '2025-12-07', 'Asistió', NULL, '18:09:14', NULL),
(28, 89, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(29, 60, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(30, 45, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(31, 74, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(32, 50, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(33, 79, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(34, 55, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(35, 84, '2025-12-07', 'Falta', NULL, '18:09:14', NULL),
(36, 69, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(37, 64, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(38, 60, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(39, 89, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(40, 45, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(41, 74, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(42, 50, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(43, 79, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(44, 84, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(45, 55, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(46, 100, '2025-12-14', 'Falta', NULL, '23:09:51', NULL),
(47, 105, '2025-12-14', 'Tardanza', NULL, '23:09:51', NULL),
(48, 64, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(49, 69, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(50, 89, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(51, 60, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(52, 115, '2025-12-15', 'Tardanza', NULL, '04:13:48', NULL),
(53, 45, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(54, 74, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(55, 79, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(56, 50, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(57, 110, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(58, 55, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(59, 84, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(60, 100, '2025-12-15', 'Falta', NULL, '04:13:48', NULL),
(61, 105, '2025-12-15', 'Falta', NULL, '04:13:48', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aulas`
--

CREATE TABLE `aulas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `capacidad` int(11) NOT NULL,
  `ubicacion` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aulas`
--

INSERT INTO `aulas` (`id`, `nombre`, `capacidad`, `ubicacion`) VALUES
(1, 'Aula 101', 40, 'Pabellón A'),
(2, 'Aula 102', 35, 'Pabellón A'),
(3, 'Aula 201', 45, 'Pabellón B');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificaciones`
--

CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL,
  `matricula_id` int(11) NOT NULL,
  `nota1` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Nota 0-20',
  `nota2` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Nota 0-20',
  `nota3` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Nota 0-20',
  `nota_final` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Nota final 0-20',
  `observaciones` text DEFAULT NULL,
  `componente1` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Componente 1 (0-20)',
  `componente2` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Componente 2 (0-20)',
  `componente3` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Componente 3 (0-20)',
  `componente4` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Componente 4 (0-20)',
  `componente5` decimal(4,2) UNSIGNED DEFAULT NULL COMMENT 'Componente 5 (0-20)',
  `fecha_actualizacion` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `calificaciones`
--

INSERT INTO `calificaciones` (`id`, `matricula_id`, `nota1`, `nota2`, `nota3`, `nota_final`, `observaciones`, `componente1`, `componente2`, `componente3`, `componente4`, `componente5`, `fecha_actualizacion`) VALUES
(9, 45, NULL, NULL, NULL, 18.17, NULL, 17.50, 18.00, 19.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(10, 67, NULL, NULL, NULL, 12.00, NULL, 12.00, 12.00, 12.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(11, 72, NULL, NULL, NULL, 10.33, NULL, 11.00, 20.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(12, 92, NULL, NULL, NULL, 4.33, NULL, 13.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(13, 48, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(14, 77, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(15, 53, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(16, 82, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(17, 58, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(18, 87, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(19, 64, NULL, NULL, NULL, 14.33, NULL, 13.00, 15.00, 15.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(20, 69, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(21, 60, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(22, 89, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(23, 74, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(24, 50, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(25, 79, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(26, 55, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(27, 84, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(28, 100, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(29, 105, NULL, NULL, NULL, 12.00, NULL, 12.00, 12.00, 12.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(30, 103, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(31, 108, NULL, NULL, NULL, 13.67, NULL, 14.00, 15.00, 12.00, 0.00, 0.00, '2025-12-15 00:47:17'),
(32, 115, NULL, NULL, NULL, 11.00, NULL, 11.00, 11.00, 11.00, 0.00, 0.00, '2025-12-15 04:12:45'),
(33, 110, NULL, NULL, NULL, 0.00, NULL, 0.00, 0.00, 0.00, 0.00, 0.00, '2025-12-15 04:12:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carreras`
--

CREATE TABLE `carreras` (
  `id` int(11) NOT NULL,
  `facultad_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `duracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `carreras`
--

INSERT INTO `carreras` (`id`, `facultad_id`, `nombre`, `duracion`) VALUES
(1, 1, 'Ingeniería de Sistemas', 5),
(2, 1, 'Ingeniería Industrial', 5),
(3, 2, 'Ingeniería Mecánica', 5),
(4, 2, 'Ingeniería de Energía', 5),
(5, 3, 'Ingeniería Eléctrica', 5),
(6, 3, 'Ingeniería Electrónica', 5),
(7, 4, 'Ingeniería Civil', 5),
(8, 5, 'Ingeniería Química', 5),
(9, 5, 'Ingeniería Textil', 5),
(10, 6, 'Ingeniería Económica', 5),
(11, 6, 'Ingeniería Pesquera', 5),
(12, 9, 'Contabilidad', 5),
(13, 10, 'Administración', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cursos`
--

CREATE TABLE `cursos` (
  `id` int(11) NOT NULL,
  `carrera_id` int(11) NOT NULL,
  `docente_id` int(11) DEFAULT NULL,
  `codigo_curso` varchar(20) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `ciclo` int(11) DEFAULT 1,
  `creditos` int(11) NOT NULL,
  `horas_semana` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cursos`
--

INSERT INTO `cursos` (`id`, `carrera_id`, `docente_id`, `codigo_curso`, `nombre`, `ciclo`, `creditos`, `horas_semana`) VALUES
(14, 1, 9, 'ISEG101', 'C??lculo I', 1, 4, NULL),
(15, 1, 13, 'ISEG102', 'Matem??tica B??sica', 1, 4, NULL),
(16, 1, 10, 'ISEG103', 'Econom??a de la Empresa', 1, 3, NULL),
(17, 1, 11, 'ISEG104', 'Idioma I', 1, 2, NULL),
(18, 1, 12, 'ISEG105', 'Actividades Culturales', 1, 2, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docentes`
--

CREATE TABLE `docentes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `fecha_ingreso` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docentes`
--

INSERT INTO `docentes` (`id`, `usuario_id`, `nombres`, `apellidos`, `dni`, `especialidad`, `telefono`, `fecha_ingreso`) VALUES
(9, 26, 'Victor Edgardo', 'Rocha Fernandez', '23460001', 'Matematicas', '987654101', '2025-12-01'),
(10, 27, 'Loyo Pepe', 'Zapata Villar', '27140001', 'Economía y Negocios', '987654102', '2025-12-01'),
(11, 28, 'Jose Marcelino', 'Garay Torres', '61670001', 'Idiomas', '987654103', '2025-12-01'),
(12, 29, 'Maria Elena', 'Soto Quispe', '45670001', 'Cultura y Artes', '987654104', '2025-12-01'),
(13, 30, 'Carlos Alberto', 'Perez Luna', '34560001', 'Matematicas Aplicadas', '987654105', '2025-12-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiantes`
--

CREATE TABLE `estudiantes` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `codigo_estudiante` varchar(20) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `dni` varchar(15) DEFAULT NULL,
  `direccion` varchar(255) DEFAULT NULL,
  `telefono` varchar(15) DEFAULT NULL,
  `carrera_id` int(11) NOT NULL,
  `fecha_registro` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiantes`
--

INSERT INTO `estudiantes` (`id`, `usuario_id`, `codigo_estudiante`, `nombres`, `apellidos`, `dni`, `direccion`, `telefono`, `carrera_id`, `fecha_registro`) VALUES
(34, 51, 'E2025001', 'Cristhian Anthony', 'Estalla Quinteros', '70001001', 'Lomas de Zapallal', '900000001', 1, '2025-12-01'),
(35, 52, 'E2025002', 'Mar??a', 'L??pez Vega', '70001002', NULL, '900000002', 1, '2025-12-01'),
(36, 53, 'E2025003', 'Juan', 'Mart??nez Silva', '70001003', NULL, '900000003', 1, '2025-12-01'),
(37, 54, 'E2025004', 'Ana', 'Rodr??guez Torres', '70001004', NULL, '900000004', 1, '2025-12-01'),
(38, 55, 'E2025005', 'Luis', 'Fern??ndez Cruz', '70001005', NULL, '900000005', 1, '2025-12-01'),
(39, 56, 'E2025006', 'Carmen', 'S??nchez Rojas', '70001006', NULL, '900000006', 1, '2025-12-01'),
(40, 57, 'E2025007', 'Pedro', 'Ram??rez Flores', '70001007', NULL, '900000007', 1, '2025-12-01'),
(41, 58, 'E2025008', 'Rosa', 'Castro D??az', '70001008', NULL, '900000008', 1, '2025-12-01'),
(42, 59, 'E2025009', 'Jorge', 'Vargas', '70001009', '', '900000009', 1, '2025-12-01'),
(43, 60, 'E2025010', 'Laura', 'Morales Ruiz', '70001010', NULL, '900000010', 1, '2025-12-01'),
(44, 61, 'E2025011', 'Diego', 'Herrera Luna', '70001011', NULL, '900000011', 1, '2025-12-01'),
(45, 62, 'E2025012', 'Patricia', 'Jim??nez Quispe', '70001012', NULL, '900000012', 1, '2025-12-01'),
(46, 63, 'E2025013', 'Miguel', 'Paredes Soto', '70001013', NULL, '900000013', 1, '2025-12-01'),
(47, 64, 'E2025014', 'Isabel', 'Guti??rrez Acosta', '70001014', NULL, '900000014', 1, '2025-12-01'),
(48, 65, 'E2025015', 'Roberto', 'Medina Campos', '70001015', NULL, '900000015', 1, '2025-12-01'),
(49, 66, 'E2025016', 'Sof??a', 'Reyes N????ez', '70001016', NULL, '900000016', 1, '2025-12-01'),
(50, 67, 'E2025017', 'Fernando', 'Navarro Ortiz', '70001017', NULL, '900000017', 1, '2025-12-01'),
(51, 68, 'E2025018', 'Gabriela', 'Ch??vez Palacios', '70001018', NULL, '900000018', 1, '2025-12-01'),
(52, 69, 'E2025019', 'Andr??s', 'Salazar Espinoza', '70001019', NULL, '900000019', 1, '2025-12-01'),
(53, 70, 'E2025020', 'Valeria', 'Delgado Romero', '70001020', NULL, '900000020', 1, '2025-12-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `facultades`
--

CREATE TABLE `facultades` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `facultades`
--

INSERT INTO `facultades` (`id`, `nombre`, `descripcion`) VALUES
(1, 'FIIS', 'Facultad de Ingeniería Industrial y de Sistemas'),
(2, 'FIME', 'Facultad de Ingeniería Mecánica y de Energía'),
(3, 'FIEE', 'Facultad de Ingeniería Eléctrica y Electrónica'),
(4, 'FIC', 'Facultad de Ingeniería Civil'),
(5, 'FIQT', 'Facultad de Ingeniería Química y Textil'),
(6, 'FIEP', 'Facultad de Ingeniería Económica y de Pesquería'),
(7, 'FCS', 'Facultad de Ciencias'),
(8, 'FIARN', 'Facultad de Ingeniería Ambiental y de Recursos Naturales'),
(9, 'FCC', 'Facultad de Ciencias Contables'),
(10, 'FCA', 'Facultad de Ciencias Administrativas'),
(11, 'FCED', 'Facultad de Ciencias Económicas y Desarrollo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulas_calificacion`
--

CREATE TABLE `formulas_calificacion` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `nombre_componente` varchar(100) NOT NULL COMMENT 'Ej: Prácticas, Examen Parcial, etc',
  `porcentaje` decimal(5,2) NOT NULL COMMENT 'Porcentaje del 0-100',
  `orden` tinyint(4) DEFAULT 1,
  `activo` tinyint(1) DEFAULT 1,
  `fecha_creacion` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `formulas_calificacion`
--

INSERT INTO `formulas_calificacion` (`id`, `curso_id`, `nombre_componente`, `porcentaje`, `orden`, `activo`, `fecha_creacion`) VALUES
(1, 14, 'Prácticas Calificadas (PC)', 30.00, 1, 1, '2025-12-06 21:28:34'),
(2, 15, 'Prácticas Calificadas (PC)', 30.00, 1, 1, '2025-12-06 21:28:34'),
(3, 16, 'Prácticas Calificadas (PC)', 30.00, 1, 1, '2025-12-06 21:28:34'),
(4, 17, 'Prácticas Calificadas (PC)', 30.00, 1, 1, '2025-12-06 21:28:34'),
(5, 18, 'Prácticas Calificadas (PC)', 30.00, 1, 1, '2025-12-06 21:28:34'),
(6, 14, 'Examen Parcial (EP)', 30.00, 2, 1, '2025-12-06 21:28:34'),
(7, 15, 'Examen Parcial (EP)', 30.00, 2, 1, '2025-12-06 21:28:34'),
(8, 16, 'Examen Parcial (EP)', 30.00, 2, 1, '2025-12-06 21:28:34'),
(9, 17, 'Examen Parcial (EP)', 30.00, 2, 1, '2025-12-06 21:28:34'),
(10, 18, 'Examen Parcial (EP)', 30.00, 2, 1, '2025-12-06 21:28:34'),
(11, 14, 'Examen Final (EF)', 40.00, 3, 1, '2025-12-06 21:28:34'),
(12, 15, 'Examen Final (EF)', 40.00, 3, 1, '2025-12-06 21:28:34'),
(13, 16, 'Examen Final (EF)', 40.00, 3, 1, '2025-12-06 21:28:34'),
(14, 17, 'Examen Final (EF)', 40.00, 3, 1, '2025-12-06 21:28:34'),
(15, 18, 'Examen Final (EF)', 40.00, 3, 1, '2025-12-06 21:28:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios`
--

CREATE TABLE `horarios` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `aula_id` int(11) NOT NULL,
  `dia` enum('Lunes','Martes','Miércoles','Jueves','Viernes','Sábado') DEFAULT NULL,
  `hora_inicio` time DEFAULT NULL,
  `hora_fin` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horarios_curso`
--

CREATE TABLE `horarios_curso` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `dia_semana` tinyint(1) NOT NULL COMMENT '1=Lunes, 2=Martes... 7=Domingo',
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `aula_id` int(11) DEFAULT NULL,
  `periodo_academico_id` int(11) NOT NULL,
  `activo` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horarios_curso`
--

INSERT INTO `horarios_curso` (`id`, `curso_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `aula_id`, `periodo_academico_id`, `activo`) VALUES
(3, 17, 3, '14:00:00', '16:00:00', NULL, 6, 1),
(4, 18, 5, '16:00:00', '18:00:00', NULL, 6, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `materiales`
--

CREATE TABLE `materiales` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `archivo` varchar(255) NOT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `materiales`
--

INSERT INTO `materiales` (`id`, `curso_id`, `docente_id`, `titulo`, `descripcion`, `archivo`, `fecha_subida`) VALUES
(4, 17, 11, 'Harry Potter y la piedra filosofal', 'telefono de alta gama', '1765081901_be1f1a0e753b8c5d8788.pdf', '2025-12-06 23:31:41'),
(6, 17, 11, 'Harry Potter y la piedra filosofal', '', '1765084134_cdfe9028bfbdef2caf83.png', '2025-12-07 00:08:54'),
(9, 14, 9, 'Desarollo Web', '', '1765751352_849b509ee5d3a9ff7483.png', '2025-12-14 17:29:12'),
(10, 14, 9, 'Harry Potter y la piedra filosofal', 'telefono de alta gama', '1765753651_d3b33ba86c49612b4e17.png', '2025-12-14 18:07:31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `matriculas`
--

CREATE TABLE `matriculas` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `periodo_id` int(11) NOT NULL,
  `fecha_matricula` date DEFAULT current_timestamp(),
  `estado` enum('matriculado','aprobada','retirado','finalizado') DEFAULT 'matriculado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `matriculas`
--

INSERT INTO `matriculas` (`id`, `estudiante_id`, `curso_id`, `periodo_id`, `fecha_matricula`, `estado`) VALUES
(45, 35, 14, 2, '2025-12-01', 'aprobada'),
(46, 35, 15, 2, '2025-12-01', 'aprobada'),
(47, 35, 16, 2, '2025-12-01', 'aprobada'),
(48, 35, 17, 2, '2025-12-01', 'aprobada'),
(49, 35, 18, 2, '2025-12-01', 'aprobada'),
(50, 36, 14, 2, '2025-12-01', 'aprobada'),
(51, 36, 15, 2, '2025-12-01', 'aprobada'),
(52, 36, 16, 2, '2025-12-01', 'aprobada'),
(53, 36, 17, 2, '2025-12-01', 'aprobada'),
(54, 36, 18, 2, '2025-12-01', 'aprobada'),
(55, 37, 14, 2, '2025-12-01', 'aprobada'),
(56, 37, 15, 2, '2025-12-01', 'aprobada'),
(57, 37, 16, 2, '2025-12-01', 'aprobada'),
(58, 37, 17, 2, '2025-12-01', 'aprobada'),
(59, 37, 18, 2, '2025-12-01', 'aprobada'),
(60, 38, 14, 2, '2025-12-01', 'aprobada'),
(61, 38, 15, 2, '2025-12-01', 'aprobada'),
(62, 38, 16, 2, '2025-12-01', 'aprobada'),
(63, 38, 18, 2, '2025-12-01', 'aprobada'),
(64, 34, 14, 2, '2025-12-06', 'aprobada'),
(65, 34, 15, 2, '2025-12-06', 'aprobada'),
(66, 34, 16, 2, '2025-12-06', 'aprobada'),
(67, 34, 17, 2, '2025-12-06', 'aprobada'),
(68, 34, 18, 2, '2025-12-06', 'aprobada'),
(69, 34, 14, 6, '2025-12-06', 'aprobada'),
(70, 34, 15, 6, '2025-12-06', 'aprobada'),
(71, 34, 16, 6, '2025-12-06', 'aprobada'),
(72, 34, 17, 6, '2025-12-06', 'aprobada'),
(73, 34, 18, 6, '2025-12-06', 'aprobada'),
(74, 35, 14, 6, '2025-12-06', 'aprobada'),
(75, 35, 15, 6, '2025-12-06', 'aprobada'),
(76, 35, 16, 6, '2025-12-06', 'aprobada'),
(77, 35, 17, 6, '2025-12-06', 'aprobada'),
(78, 35, 18, 6, '2025-12-06', 'aprobada'),
(79, 36, 14, 6, '2025-12-06', 'aprobada'),
(80, 36, 15, 6, '2025-12-06', 'aprobada'),
(81, 36, 16, 6, '2025-12-06', 'aprobada'),
(82, 36, 17, 6, '2025-12-06', 'aprobada'),
(83, 36, 18, 6, '2025-12-06', 'aprobada'),
(84, 37, 14, 6, '2025-12-06', 'aprobada'),
(85, 37, 15, 6, '2025-12-06', 'aprobada'),
(86, 37, 16, 6, '2025-12-06', 'aprobada'),
(87, 37, 17, 6, '2025-12-06', 'aprobada'),
(88, 37, 18, 6, '2025-12-06', 'aprobada'),
(89, 38, 14, 6, '2025-12-06', 'aprobada'),
(90, 38, 15, 6, '2025-12-06', 'aprobada'),
(91, 38, 16, 6, '2025-12-06', 'aprobada'),
(92, 38, 17, 6, '2025-12-06', 'aprobada'),
(93, 38, 18, 6, '2025-12-06', 'aprobada'),
(100, 39, 14, 3, '2025-12-14', 'matriculado'),
(101, 39, 15, 3, '2025-12-14', 'matriculado'),
(102, 39, 16, 3, '2025-12-14', 'matriculado'),
(103, 39, 17, 3, '2025-12-14', 'matriculado'),
(104, 39, 18, 3, '2025-12-14', 'matriculado'),
(105, 42, 14, 3, '2025-12-14', 'matriculado'),
(106, 42, 15, 3, '2025-12-14', 'matriculado'),
(107, 42, 16, 3, '2025-12-14', 'matriculado'),
(108, 42, 17, 3, '2025-12-14', 'matriculado'),
(109, 42, 18, 3, '2025-12-14', 'matriculado'),
(110, 43, 14, 3, '2025-12-14', 'matriculado'),
(111, 43, 15, 3, '2025-12-14', 'matriculado'),
(112, 43, 16, 3, '2025-12-14', 'matriculado'),
(113, 43, 17, 3, '2025-12-14', 'matriculado'),
(114, 43, 18, 3, '2025-12-14', 'matriculado'),
(115, 44, 14, 3, '2025-12-14', 'matriculado'),
(116, 44, 15, 3, '2025-12-14', 'matriculado'),
(117, 44, 16, 3, '2025-12-14', 'matriculado'),
(118, 44, 17, 3, '2025-12-14', 'matriculado'),
(119, 44, 18, 3, '2025-12-14', 'matriculado'),
(120, 45, 14, 3, '2025-12-14', 'matriculado'),
(121, 45, 15, 3, '2025-12-14', 'matriculado'),
(122, 45, 16, 3, '2025-12-14', 'matriculado'),
(123, 45, 17, 3, '2025-12-14', 'matriculado'),
(124, 45, 18, 3, '2025-12-14', 'matriculado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `mensaje` text NOT NULL,
  `tipo` enum('general','pago','tramite','matricula','calificacion','sistema') DEFAULT 'general',
  `fecha_envio` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0,
  `archivo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`id`, `usuario_id`, `titulo`, `mensaje`, `tipo`, `fecha_envio`, `leido`, `archivo`) VALUES
(38, 4, '11111111', 'gfdsgs', 'general', '2025-11-24 17:21:04', 1, '1764004864_a56dcf65ec6c4098d78d.png'),
(39, 5, '11111111', 'gfdsgs', 'general', '2025-11-24 17:21:04', 0, '1764004864_a56dcf65ec6c4098d78d.png'),
(40, 6, '11111111', 'gfdsgs', 'general', '2025-11-24 17:21:04', 0, '1764004864_a56dcf65ec6c4098d78d.png'),
(41, 2, '11111111', 'gfdsgs', 'general', '2025-11-24 17:21:04', 1, '1764004864_a56dcf65ec6c4098d78d.png'),
(42, 3, '11111111', 'gfdsgs', 'general', '2025-11-24 17:21:04', 0, '1764004864_a56dcf65ec6c4098d78d.png'),
(43, 4, '11111111', 'fdsa', 'general', '2025-11-24 17:36:18', 1, '1764005778_b23a39b63ddc9c41d16f.png'),
(44, 5, '11111111', 'fdsa', 'general', '2025-11-24 17:36:18', 0, '1764005778_b23a39b63ddc9c41d16f.png'),
(45, 6, '11111111', 'fdsa', 'general', '2025-11-24 17:36:18', 0, '1764005778_b23a39b63ddc9c41d16f.png'),
(46, 2, '11111111', 'fdsa', 'general', '2025-11-24 17:36:18', 1, '1764005778_b23a39b63ddc9c41d16f.png'),
(47, 3, '11111111', 'fdsa', 'general', '2025-11-24 17:36:18', 0, '1764005778_b23a39b63ddc9c41d16f.png'),
(48, 5, 'Actualización de Trámite', 'Tu trámite \"Constancia de Estudios\" ha sido actualizado a: pendiente', 'tramite', '2025-11-26 21:13:55', 0, NULL),
(49, 5, 'Actualización de Trámite', 'Tu trámite \"Constancia de Estudios\" ha sido actualizado a: aprobado', 'tramite', '2025-11-26 21:14:01', 0, NULL),
(50, 4, 'Actualización de Trámite', 'Tu trámite \"Constancia de Estudios\" ha sido actualizado a: aprobado', 'tramite', '2025-11-26 21:15:47', 1, NULL),
(51, 4, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(52, 5, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(53, 6, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(54, 10, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 1, '1764597894_7d15a72eba98be0dd131.png'),
(55, 11, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(56, 12, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(57, 13, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(58, 14, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(59, 15, 'afd', 'afd', 'general', '2025-12-01 14:04:54', 0, '1764597894_7d15a72eba98be0dd131.png'),
(63, 19, 'afd', 'afd', 'general', '2025-12-01 14:04:55', 0, '1764597894_7d15a72eba98be0dd131.png'),
(64, 2, 'afd', 'afd', 'general', '2025-12-01 14:04:55', 0, '1764597894_7d15a72eba98be0dd131.png'),
(65, 3, 'afd', 'afd', 'general', '2025-12-01 14:04:55', 0, '1764597894_7d15a72eba98be0dd131.png'),
(66, 9, 'afd', 'afd', 'general', '2025-12-01 14:04:55', 0, '1764597894_7d15a72eba98be0dd131.png'),
(67, 5, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-01 14:11:08', 0, NULL),
(69, 51, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-01 15:18:41', 1, NULL),
(70, 52, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-01 16:16:33', 1, NULL),
(71, 53, 'Actualización de Trámite', 'Tu trámite \"Constancia de Estudios\" ha sido aprobado.', 'tramite', '2025-12-01 16:41:02', 1, NULL),
(72, 53, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-01 17:06:17', 1, NULL),
(73, 54, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-01 17:28:57', 1, NULL),
(74, 55, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-01 17:42:47', 1, NULL),
(75, 51, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-06 16:47:58', 1, NULL),
(100, 51, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-07 02:58:47', 1, NULL),
(101, 56, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-07 02:58:52', 1, NULL),
(102, 57, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-07 02:58:56', 1, NULL),
(103, 58, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-07 02:59:00', 0, NULL),
(104, 56, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-14 21:57:20', 1, NULL),
(105, 59, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-14 23:06:03', 1, NULL),
(106, 59, 'Actualización de Trámite', 'Tu trámite \"Duplicado de Carnet\" ha sido aprobado.', 'tramite', '2025-12-14 23:17:44', 1, NULL),
(107, 60, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-15 03:43:38', 1, NULL),
(108, 61, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-15 04:07:37', 0, NULL),
(109, 62, '✅ Solicitud de Matrícula Aprobada', 'Tu solicitud de matrícula ha sido APROBADA. Ya puedes seleccionar tus cursos desde el menú de Matrícula.', 'matricula', '2025-12-15 04:16:25', 1, NULL),
(110, 51, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(111, 52, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(112, 53, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(113, 54, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(114, 55, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(115, 56, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(116, 57, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(117, 58, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(118, 59, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(119, 60, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(120, 61, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(121, 62, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(122, 63, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(123, 64, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(124, 65, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(125, 66, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(126, 67, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(127, 68, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(128, 69, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(129, 70, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(130, 26, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(131, 27, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(132, 28, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(133, 29, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png'),
(134, 30, 'Java', 'aaaa', 'general', '2025-12-15 04:29:23', 0, '1765772963_c28e5ea0444645ed8d9c.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `tramite_id` int(11) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `metodo_pago` enum('Efectivo','Tarjeta','Transferencia','Yape','Plin') DEFAULT 'Efectivo',
  `fecha_pago` date DEFAULT current_timestamp(),
  `estado` enum('pendiente','pagado','anulado') DEFAULT 'pendiente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `tramite_id`, `monto`, `metodo_pago`, `fecha_pago`, `estado`) VALUES
(1, 1, 25.00, 'Yape', '2025-11-09', 'pagado'),
(2, 2, 15.00, 'Efectivo', '2025-11-09', 'pendiente'),
(3, 3, 10.00, 'Transferencia', '2025-11-09', 'pagado'),
(4, 30, 45.00, 'Yape', '2025-12-14', 'pagado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `periodos_academicos`
--

CREATE TABLE `periodos_academicos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `periodos_academicos`
--

INSERT INTO `periodos_academicos` (`id`, `nombre`, `fecha_inicio`, `fecha_fin`) VALUES
(2, '2025-II', '2025-08-01', '2025-12-19'),
(3, '2026-I', '2026-03-02', '2026-07-20'),
(6, '2025-I', '2025-03-01', '2025-07-31');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prerrequisitos`
--

CREATE TABLE `prerrequisitos` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `curso_prerrequisito_id` int(11) NOT NULL,
  `obligatorio` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prerrequisitos`
--

INSERT INTO `prerrequisitos` (`id`, `curso_id`, `curso_prerrequisito_id`, `obligatorio`) VALUES
(1, 2, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programacion_horaria`
--

CREATE TABLE `programacion_horaria` (
  `id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `docente_id` int(11) NOT NULL,
  `periodo_id` int(11) NOT NULL,
  `dia_semana` enum('Lunes','Martes','Mi??rcoles','Jueves','Viernes','S??bado') NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `aula` varchar(50) DEFAULT NULL,
  `seccion` varchar(10) DEFAULT '01S',
  `tipo_clase` enum('Teor??a','Pr??ctica','Laboratorio') DEFAULT 'Teor??a',
  `activo` tinyint(1) DEFAULT 1,
  `cupos_totales` int(11) DEFAULT 30,
  `cupos_ocupados` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `programacion_horaria`
--

INSERT INTO `programacion_horaria` (`id`, `curso_id`, `docente_id`, `periodo_id`, `dia_semana`, `hora_inicio`, `hora_fin`, `aula`, `seccion`, `tipo_clase`, `activo`, `cupos_totales`, `cupos_ocupados`) VALUES
(1, 14, 9, 2, 'Martes', '08:00:00', '10:30:00', 'FIIS1A01', '01S', 'Teor??a', 1, 30, 0),
(2, 14, 9, 2, 'Martes', '10:30:00', '12:10:00', 'FIIS1A01', '01S', 'Pr??ctica', 1, 30, 0),
(3, 15, 13, 2, 'Mi??rcoles', '08:00:00', '10:30:00', 'FIIS1A01', '01S', 'Teor??a', 1, 30, 0),
(4, 15, 13, 2, 'Mi??rcoles', '10:30:00', '12:10:00', 'FIIS1A01', '01S', 'Pr??ctica', 1, 30, 0),
(5, 16, 10, 2, 'Mi??rcoles', '13:50:00', '15:30:00', 'FIIS3A04', '01S', 'Teor??a', 1, 30, 0),
(6, 16, 10, 2, 'Mi??rcoles', '15:30:00', '17:10:00', 'FIIS3A04', '01S', 'Pr??ctica', 1, 30, 0),
(7, 17, 11, 2, 'Jueves', '08:00:00', '11:20:00', 'FIIS1A01', '01S', 'Pr??ctica', 1, 30, 0),
(8, 18, 12, 2, 'Lunes', '08:00:00', '09:40:00', 'FIIS1A01', '01S', 'Teor??a', 1, 30, 0),
(9, 18, 12, 2, 'Lunes', '09:40:00', '11:20:00', 'FIIS1A01', '01S', 'Pr??ctica', 1, 30, 0),
(10, 14, 0, 3, 'Lunes', '08:00:00', '10:00:00', 'AUTO', '01S', 'Teor??a', 1, 40, 5),
(11, 15, 0, 3, 'Lunes', '08:00:00', '10:00:00', 'AUTO', '01S', 'Teor??a', 1, 40, 4),
(12, 16, 0, 3, 'Lunes', '08:00:00', '10:00:00', 'AUTO', '01S', 'Teor??a', 1, 40, 5),
(13, 17, 0, 3, 'Lunes', '08:00:00', '10:00:00', 'AUTO', '01S', 'Teor??a', 1, 40, 5),
(14, 18, 0, 3, 'Lunes', '08:00:00', '10:00:00', 'AUTO', '01S', 'Teor??a', 1, 40, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `nombre`) VALUES
(1, 'Administrador'),
(2, 'Docente'),
(3, 'Estudiante'),
(4, 'Administrativo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_matricula`
--

CREATE TABLE `solicitudes_matricula` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `periodo_id` int(11) NOT NULL,
  `comprobante_pago` varchar(255) NOT NULL,
  `monto` decimal(10,2) NOT NULL,
  `fecha_solicitud` datetime DEFAULT current_timestamp(),
  `estado` enum('pendiente','aprobado','rechazado') DEFAULT 'pendiente',
  `observaciones` text DEFAULT NULL,
  `revisado_por` int(11) DEFAULT NULL,
  `fecha_revision` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes_matricula`
--

INSERT INTO `solicitudes_matricula` (`id`, `estudiante_id`, `periodo_id`, `comprobante_pago`, `monto`, `fecha_solicitud`, `estado`, `observaciones`, `revisado_por`, `fecha_revision`) VALUES
(40, 35, 2, 'comprobante_E2025002.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-01 16:16:33'),
(41, 36, 2, 'comprobante_E2025003.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-01 17:06:17'),
(42, 37, 2, 'comprobante_E2025004.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-01 17:28:57'),
(43, 38, 2, 'comprobante_E2025005.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-01 17:42:47'),
(44, 39, 2, 'comprobante_E2025006.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-07 02:58:52'),
(45, 40, 2, 'comprobante_E2025007.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-07 02:58:56'),
(46, 41, 2, 'comprobante_E2025008.pdf', 350.00, '2025-12-01 10:14:13', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-07 02:59:00'),
(47, 42, 2, 'comprobante_E2025009.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(48, 43, 2, 'comprobante_E2025010.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(49, 44, 2, 'comprobante_E2025011.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(50, 45, 2, 'comprobante_E2025012.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(51, 46, 2, 'comprobante_E2025013.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(52, 47, 2, 'comprobante_E2025014.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(53, 48, 2, 'comprobante_E2025015.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(54, 49, 2, 'comprobante_E2025016.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(55, 50, 2, 'comprobante_E2025017.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(56, 51, 2, 'comprobante_E2025018.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(57, 52, 2, 'comprobante_E2025019.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(58, 53, 2, 'comprobante_E2025020.pdf', 350.00, '2025-12-01 10:14:13', 'pendiente', NULL, NULL, NULL),
(72, 34, 2, '1765039653_1c6600eba6cdda67bc42.jpg', 350.00, '2025-12-06 16:47:33', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-06 16:47:58'),
(73, 34, 3, '1765071811_ff356cfc70c86307996e.jpg', 350.00, '2025-12-07 01:43:31', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-07 02:58:47'),
(74, 39, 3, '1765749421_f47ded8e4dbf4610fe04.png', 350.00, '2025-12-14 21:57:01', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-14 21:57:20'),
(75, 42, 3, '1765753536_721b08604cdcdbc1997e.png', 350.00, '2025-12-14 23:05:36', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-14 23:06:03'),
(76, 43, 3, '1765770188_ac00cc57df0e7e36eda3.png', 80.00, '2025-12-15 03:43:08', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-15 03:43:38'),
(77, 44, 3, '1765771621_01b09e3d3090539d673e.png', 350.00, '2025-12-15 04:07:01', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-15 04:07:37'),
(78, 45, 3, '1765772104_f0ed9e60fa648e0912df.png', 350.00, '2025-12-15 04:15:04', 'aprobado', 'Solicitud aprobada correctamente', 1, '2025-12-15 04:16:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tramites`
--

CREATE TABLE `tramites` (
  `id` int(11) NOT NULL,
  `estudiante_id` int(11) NOT NULL,
  `administrativo_id` int(11) DEFAULT NULL,
  `tipo` enum('Constancia de Estudios','Duplicado de Carnet','Retiro de Curso','Solicitud de Prórroga','Otro') NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_solicitud` date DEFAULT current_timestamp(),
  `estado` enum('pendiente','en proceso','aprobado','rechazado') DEFAULT 'pendiente',
  `motivo` text DEFAULT NULL,
  `tipo_documento` varchar(50) DEFAULT NULL,
  `documento` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tramites`
--

INSERT INTO `tramites` (`id`, `estudiante_id`, `administrativo_id`, `tipo`, `descripcion`, `fecha_solicitud`, `estado`, `motivo`, `tipo_documento`, `documento`) VALUES
(1, 1, 1, 'Constancia de Estudios', 'Solicita constancia para prácticas.', '2025-11-09', 'aprobado', NULL, NULL, NULL),
(2, 2, 1, 'Duplicado de Carnet', 'Pérdida del carnet universitario.', '2025-11-09', 'pendiente', NULL, NULL, NULL),
(3, 3, 1, 'Solicitud de Prórroga', 'Extensión de entrega de trabajo final.', '2025-11-09', 'aprobado', NULL, NULL, NULL),
(14, 2, 1, 'Constancia de Estudios', 'Solicito constancia de estudios actualizada ni', '2025-11-15', 'aprobado', NULL, NULL, NULL),
(17, 4, NULL, 'Duplicado de Carnet', 'gftjhnfgh\n\nTeléfono de contacto: 987456321', '2025-12-01', 'pendiente', NULL, NULL, NULL),
(18, 36, 1, 'Constancia de Estudios', 'daf\n\nTeléfono de contacto: 633.653\nCorreo: mamela4627@izeao.com\nMotivo: afdaf', '2025-12-01', 'aprobado', NULL, NULL, NULL),
(27, 34, 1, 'Constancia de Estudios', 'Solicito la constancia de Estudios para un trabajo.', '2025-12-06', 'aprobado', 'Necesito el documento urgente, plazo maximo 3 dias.', 'imagen', '1765063810_73afab3c2b6682c0b88c.jpg'),
(28, 34, NULL, 'Constancia de Estudios', 'Solicito la constancia', '2025-12-06', 'pendiente', 'Necesito la constancia para un trabajo', '', '1765063088_115384ac3bc18a6622e7.pdf'),
(29, 34, 1, 'Constancia de Estudios', 'Solicito la constancia de Estudios', '2025-12-07', 'aprobado', 'Lo necesito para un trabajo', '', '1765065660_1bdc03382163c573fbc3.jpg'),
(30, 42, 1, 'Duplicado de Carnet', 'ragfsdgeethegrthjkiujhygtffyhujikik', '2025-12-14', 'aprobado', 'fgs', 'PNG', '1765754042_6ae07c7a1fc35736d432.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rol_id` int(11) NOT NULL,
  `estado` enum('activo','inactivo') DEFAULT 'activo',
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password`, `email`, `rol_id`, `estado`, `fecha_registro`) VALUES
(1, 'admin', 'admin123', 'admin@sga.edu', 1, 'activo', '2025-12-14 18:19:25'),
(7, 'administrativo1', 'admin123', 'lramirez@sga.edu', 4, 'activo', '2025-11-09 19:19:04'),
(8, 'administrativo2', 'admin123', 'cflores@sga.edu', 4, 'activo', '2025-11-09 19:19:04'),
(26, 'docente_rocha', 'admin123', 'vrocha@unac.edu.pe', 2, 'activo', '2025-12-01 10:03:22'),
(27, 'docente_zapata', 'admin123', 'lzapata@unac.edu.pe', 2, 'activo', '2025-12-01 10:03:22'),
(28, 'docente_garay', 'admin123', 'jgaray@unac.edu.pe', 2, 'activo', '2025-12-01 10:03:23'),
(29, 'docente_soto', 'admin123', 'msoto@unac.edu.pe', 2, 'activo', '2025-12-01 10:03:23'),
(30, 'docente_perez', 'admin123', 'cperez@unac.edu.pe', 2, 'activo', '2025-12-01 10:03:23'),
(51, 'est_01', 'admin123', 'est01@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(52, 'est_02', 'admin123', 'est02@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(53, 'est_03', 'admin123', 'est03@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(54, 'est_04', 'admin123', 'est04@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(55, 'est_05', 'admin123', 'est05@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(56, 'est_06', 'admin123', 'est06@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(57, 'est_07', 'admin123', 'est07@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(58, 'est_08', 'admin123', 'est08@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(59, 'est_09', 'admin123', 'est09@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:11'),
(60, 'est_10', 'admin123', 'est10@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(61, 'est_11', 'admin123', 'est11@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(62, 'est_12', 'admin123', 'est12@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(63, 'est_13', 'admin123', 'est13@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(64, 'est_14', 'admin123', 'est14@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(65, 'est_15', 'admin123', 'est15@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(66, 'est_16', 'admin123', 'est16@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(67, 'est_17', 'admin123', 'est17@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(68, 'est_18', 'admin123', 'est18@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(69, 'est_19', 'admin123', 'est19@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(70, 'est_20', 'admin123', 'est20@unac.edu.pe', 3, 'activo', '2025-12-01 10:14:12'),
(76, 'nvargas', '$2y$10$wlmqncHV/xv2To4YQKjsJuO24jGquxP1EsPR2WKoJ6kqGprl4hig.', 'nvargas@gmail.com', 4, 'activo', '2025-12-15 02:10:49');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_calificaciones`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_calificaciones` (
`codigo_estudiante` varchar(20)
,`nombres` varchar(100)
,`apellidos` varchar(100)
,`curso` varchar(100)
,`nota1` decimal(4,2) unsigned
,`nota2` decimal(4,2) unsigned
,`nota3` decimal(4,2) unsigned
,`nota_final` decimal(4,2) unsigned
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `vista_calificaciones_detallada`
-- (Véase abajo para la vista actual)
--
CREATE TABLE `vista_calificaciones_detallada` (
`codigo_estudiante` varchar(20)
,`nombres` varchar(100)
,`apellidos` varchar(100)
,`curso` varchar(100)
,`curso_id` int(11)
,`nota1` decimal(4,2) unsigned
,`nota2` decimal(4,2) unsigned
,`nota3` decimal(4,2) unsigned
,`componente1` decimal(4,2) unsigned
,`componente2` decimal(4,2) unsigned
,`componente3` decimal(4,2) unsigned
,`componente4` decimal(4,2) unsigned
,`componente5` decimal(4,2) unsigned
,`nota_final` decimal(4,2) unsigned
,`observaciones` text
,`matricula_id` int(11)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_calificaciones`
--
DROP TABLE IF EXISTS `vista_calificaciones`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_calificaciones`  AS SELECT `e`.`codigo_estudiante` AS `codigo_estudiante`, `e`.`nombres` AS `nombres`, `e`.`apellidos` AS `apellidos`, `c`.`nombre` AS `curso`, `ca`.`nota1` AS `nota1`, `ca`.`nota2` AS `nota2`, `ca`.`nota3` AS `nota3`, `ca`.`nota_final` AS `nota_final` FROM (((`calificaciones` `ca` join `matriculas` `m` on(`ca`.`matricula_id` = `m`.`id`)) join `estudiantes` `e` on(`m`.`estudiante_id` = `e`.`id`)) join `cursos` `c` on(`m`.`curso_id` = `c`.`id`)) ;

-- --------------------------------------------------------

--
-- Estructura para la vista `vista_calificaciones_detallada`
--
DROP TABLE IF EXISTS `vista_calificaciones_detallada`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vista_calificaciones_detallada`  AS SELECT `e`.`codigo_estudiante` AS `codigo_estudiante`, `e`.`nombres` AS `nombres`, `e`.`apellidos` AS `apellidos`, `c`.`nombre` AS `curso`, `c`.`id` AS `curso_id`, `ca`.`nota1` AS `nota1`, `ca`.`nota2` AS `nota2`, `ca`.`nota3` AS `nota3`, `ca`.`componente1` AS `componente1`, `ca`.`componente2` AS `componente2`, `ca`.`componente3` AS `componente3`, `ca`.`componente4` AS `componente4`, `ca`.`componente5` AS `componente5`, `ca`.`nota_final` AS `nota_final`, `ca`.`observaciones` AS `observaciones`, `m`.`id` AS `matricula_id` FROM (((`calificaciones` `ca` join `matriculas` `m` on(`ca`.`matricula_id` = `m`.`id`)) join `estudiantes` `e` on(`m`.`estudiante_id` = `e`.`id`)) join `cursos` `c` on(`m`.`curso_id` = `c`.`id`)) ;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_matricula_fecha` (`matricula_id`,`fecha`),
  ADD KEY `matricula_id` (`matricula_id`),
  ADD KEY `idx_asistencia_fecha` (`fecha`,`matricula_id`);

--
-- Indices de la tabla `aulas`
--
ALTER TABLE `aulas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `matricula_id` (`matricula_id`),
  ADD KEY `idx_calificacion_matricula` (`matricula_id`);

--
-- Indices de la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facultad_id` (`facultad_id`);

--
-- Indices de la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `carrera_id` (`carrera_id`),
  ADD KEY `docente_id` (`docente_id`);

--
-- Indices de la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_estudiante` (`codigo_estudiante`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `carrera_id` (`carrera_id`);

--
-- Indices de la tabla `facultades`
--
ALTER TABLE `facultades`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `formulas_calificacion`
--
ALTER TABLE `formulas_calificacion`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_curso` (`curso_id`);

--
-- Indices de la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `aula_id` (`aula_id`);

--
-- Indices de la tabla `horarios_curso`
--
ALTER TABLE `horarios_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_curso_horario` (`curso_id`),
  ADD KEY `idx_dia` (`dia_semana`),
  ADD KEY `idx_periodo` (`periodo_academico_id`),
  ADD KEY `fk_horario_aula` (`aula_id`);

--
-- Indices de la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `docente_id` (`docente_id`),
  ADD KEY `idx_material_curso` (`curso_id`,`fecha_subida`);

--
-- Indices de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_matricula` (`estudiante_id`,`curso_id`,`periodo_id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `periodo_id` (`periodo_id`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tramite_id` (`tramite_id`);

--
-- Indices de la tabla `periodos_academicos`
--
ALTER TABLE `periodos_academicos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prerrequisitos`
--
ALTER TABLE `prerrequisitos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `curso_prerrequisito_id` (`curso_prerrequisito_id`);

--
-- Indices de la tabla `programacion_horaria`
--
ALTER TABLE `programacion_horaria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `curso_id` (`curso_id`),
  ADD KEY `docente_id` (`docente_id`),
  ADD KEY `periodo_id` (`periodo_id`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `solicitudes_matricula`
--
ALTER TABLE `solicitudes_matricula`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `periodo_id` (`periodo_id`),
  ADD KEY `revisado_por` (`revisado_por`);

--
-- Indices de la tabla `tramites`
--
ALTER TABLE `tramites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `estudiante_id` (`estudiante_id`),
  ADD KEY `administrativo_id` (`administrativo_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `rol_id` (`rol_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administrativos`
--
ALTER TABLE `administrativos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `asistencias`
--
ALTER TABLE `asistencias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT de la tabla `aulas`
--
ALTER TABLE `aulas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT de la tabla `carreras`
--
ALTER TABLE `carreras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `cursos`
--
ALTER TABLE `cursos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `docentes`
--
ALTER TABLE `docentes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `facultades`
--
ALTER TABLE `facultades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `formulas_calificacion`
--
ALTER TABLE `formulas_calificacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `horarios`
--
ALTER TABLE `horarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `horarios_curso`
--
ALTER TABLE `horarios_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `materiales`
--
ALTER TABLE `materiales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `matriculas`
--
ALTER TABLE `matriculas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=135;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `periodos_academicos`
--
ALTER TABLE `periodos_academicos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `prerrequisitos`
--
ALTER TABLE `prerrequisitos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `programacion_horaria`
--
ALTER TABLE `programacion_horaria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `solicitudes_matricula`
--
ALTER TABLE `solicitudes_matricula`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT de la tabla `tramites`
--
ALTER TABLE `tramites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `administrativos`
--
ALTER TABLE `administrativos`
  ADD CONSTRAINT `administrativos_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `asistencias`
--
ALTER TABLE `asistencias`
  ADD CONSTRAINT `asistencias_ibfk_1` FOREIGN KEY (`matricula_id`) REFERENCES `matriculas` (`id`);

--
-- Filtros para la tabla `calificaciones`
--
ALTER TABLE `calificaciones`
  ADD CONSTRAINT `calificaciones_ibfk_1` FOREIGN KEY (`matricula_id`) REFERENCES `matriculas` (`id`);

--
-- Filtros para la tabla `carreras`
--
ALTER TABLE `carreras`
  ADD CONSTRAINT `carreras_ibfk_1` FOREIGN KEY (`facultad_id`) REFERENCES `facultades` (`id`);

--
-- Filtros para la tabla `cursos`
--
ALTER TABLE `cursos`
  ADD CONSTRAINT `cursos_ibfk_1` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`),
  ADD CONSTRAINT `cursos_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`);

--
-- Filtros para la tabla `docentes`
--
ALTER TABLE `docentes`
  ADD CONSTRAINT `docentes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `estudiantes`
--
ALTER TABLE `estudiantes`
  ADD CONSTRAINT `estudiantes_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `estudiantes_ibfk_2` FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`);

--
-- Filtros para la tabla `formulas_calificacion`
--
ALTER TABLE `formulas_calificacion`
  ADD CONSTRAINT `fk_formula_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `horarios`
--
ALTER TABLE `horarios`
  ADD CONSTRAINT `horarios_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `horarios_ibfk_2` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`);

--
-- Filtros para la tabla `horarios_curso`
--
ALTER TABLE `horarios_curso`
  ADD CONSTRAINT `fk_horario_aula` FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_horario_curso` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_horario_periodo` FOREIGN KEY (`periodo_academico_id`) REFERENCES `periodos_academicos` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `materiales`
--
ALTER TABLE `materiales`
  ADD CONSTRAINT `materiales_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `materiales_ibfk_2` FOREIGN KEY (`docente_id`) REFERENCES `docentes` (`id`);

--
-- Filtros para la tabla `matriculas`
--
ALTER TABLE `matriculas`
  ADD CONSTRAINT `matriculas_ibfk_1` FOREIGN KEY (`estudiante_id`) REFERENCES `estudiantes` (`id`),
  ADD CONSTRAINT `matriculas_ibfk_2` FOREIGN KEY (`curso_id`) REFERENCES `cursos` (`id`),
  ADD CONSTRAINT `matriculas_ibfk_3` FOREIGN KEY (`periodo_id`) REFERENCES `periodos_academicos` (`id`);

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`tramite_id`) REFERENCES `tramites` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
