-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 21-09-2019 a las 13:28:20
-- Versión del servidor: 10.3.18-MariaDB-cll-lve
-- Versión de PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `emicapac_sge`
--
CREATE DATABASE IF NOT EXISTS `emicapac_sge` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `emicapac_sge`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BitEventos`
--

DROP TABLE IF EXISTS `BitEventos`;
CREATE TABLE `BitEventos` (
  `eCodEvento` int(11) NOT NULL,
  `eCodEstatus` int(11) NOT NULL DEFAULT 1,
  `eCodUsuario` int(11) NOT NULL,
  `eCodCliente` int(11) NOT NULL,
  `fhFechaEvento` datetime NOT NULL,
  `tmHoraMontaje` time DEFAULT NULL,
  `tDireccion` text NOT NULL,
  `tObservaciones` text NOT NULL,
  `eCodTipoDocumento` int(11) NOT NULL DEFAULT 1,
  `bIVA` int(11) DEFAULT NULL,
  `fhFecha` datetime NOT NULL,
  `tOperadorEntrega` varchar(100) DEFAULT NULL,
  `tOperadorRecoleccion` varchar(100) DEFAULT NULL,
  `bAvisoSem` int(11) DEFAULT NULL,
  `bAvisoDia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `BitEventos`
--

INSERT INTO `BitEventos` (`eCodEvento`, `eCodEstatus`, `eCodUsuario`, `eCodCliente`, `fhFechaEvento`, `tmHoraMontaje`, `tDireccion`, `tObservaciones`, `eCodTipoDocumento`, `bIVA`, `fhFecha`, `tOperadorEntrega`, `tOperadorRecoleccion`, `bAvisoSem`, `bAvisoDia`) VALUES
(1, 1, 21, 1, '2019-08-30 14:00:00', '12:00:00', 'Q29uc3RpdHV5ZW50ZXMgNjQzIHBpc28gNg==', 'U2UgZGViZXLDoW4gcHJlc2VudGFyIGdhbGxldGFzIHN0YW5kYXJk', 1, 1, '2019-08-18 04:22:13', NULL, NULL, NULL, NULL),
(2, 1, 1, 1, '2019-09-28 14:00:00', '12:00:00', 'TW9yZWxvcywgTW9y', 'TW9udGFqZSBlbiBqYXJkw61uLiBUb21hcyBkZSBjb3JyaWVudGUgY2VyY2FuYXM=', 1, 1, '2019-09-16 22:37:54', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `BitTransacciones`
--

DROP TABLE IF EXISTS `BitTransacciones`;
CREATE TABLE `BitTransacciones` (
  `eCodTransaccion` int(11) NOT NULL,
  `eCodUsuario` int(11) NOT NULL,
  `eCodEvento` int(11) NOT NULL,
  `fhFecha` datetime NOT NULL,
  `dMonto` double NOT NULL,
  `eCodTipoPago` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `BitTransacciones`
--

INSERT INTO `BitTransacciones` (`eCodTransaccion`, `eCodUsuario`, `eCodEvento`, `fhFecha`, `dMonto`, `eCodTipoPago`) VALUES
(1, 1, 6, '2018-12-17 17:12:00', 1000, 1),
(2, 1, 6, '2018-12-17 17:17:00', 2500, 4),
(3, 2, 4, '2018-12-17 18:28:00', 300, 4),
(4, 1, 3, '2018-12-27 16:44:26', 500, 1),
(5, 2, 8, '2019-01-11 15:04:33', 4000, 1),
(6, 9, 9, '2019-01-12 12:08:34', 1593, 4),
(7, 8, 12, '2019-01-12 12:39:23', 700, 4),
(8, 7, 13, '2019-01-12 12:58:45', 738, 4),
(9, 7, 14, '2019-01-12 13:03:52', 750, 1),
(10, 7, 15, '2019-01-12 13:21:46', 630, 4),
(11, 7, 16, '2019-01-12 14:04:05', 825, 4),
(12, 9, 18, '2019-01-15 17:38:11', 1000, 4),
(13, 4, 30, '2019-01-19 22:17:32', 100, 1),
(14, 8, 37, '2019-01-25 16:58:16', 400, 4),
(15, 8, 38, '2019-01-26 13:18:57', 1000, 1),
(16, 8, 39, '2019-01-26 13:35:25', 5000, 4),
(17, 8, 11, '2019-01-28 11:55:41', 600, 4),
(18, 4, 43, '2019-01-30 18:15:48', 500, 1),
(19, 4, 44, '2019-02-04 17:46:37', 725, 4),
(20, 8, 46, '2019-02-07 17:46:44', 1700, 4),
(21, 8, 47, '2019-02-07 18:02:31', 800, 4),
(22, 8, 47, '2019-02-09 14:29:28', 925, 4),
(23, 8, 46, '2019-02-09 14:30:12', 1300, 1),
(24, 9, 48, '2019-02-09 14:57:22', 610, 1),
(25, 9, 49, '2019-02-09 16:25:44', 500, 4),
(26, 9, 50, '2019-02-09 16:50:49', 21854.4, 4),
(27, 9, 51, '2019-02-09 17:11:49', 1000, 1),
(28, 8, 52, '2019-02-09 17:20:55', 1300, 4),
(29, 9, 53, '2019-02-09 17:42:12', 5900, 1),
(30, 9, 54, '2019-02-09 17:53:25', 1600, 4),
(31, 7, 59, '2019-02-13 14:29:31', 1500, 4),
(32, 7, 60, '2019-02-13 14:47:51', 1000, 1),
(33, 7, 55, '2019-02-13 15:54:04', 2000, 4),
(34, 7, 58, '2019-02-13 15:55:26', 1000, 4),
(35, 7, 57, '2019-02-13 15:56:27', 740, 4),
(36, 7, 61, '2019-02-13 17:44:08', 2200, 4),
(37, 7, 62, '2019-02-13 17:54:24', 840, 4),
(38, 7, 46, '2019-02-15 15:21:59', 1500, 4),
(39, 7, 64, '2019-02-15 15:34:56', 1280, 4),
(40, 7, 65, '2019-02-15 16:04:03', 2000, 3),
(41, 7, 65, '2019-02-15 16:05:05', 2000, 2),
(42, 7, 67, '2019-02-16 13:17:21', 550, 1),
(43, 7, 68, '2019-02-16 13:46:17', 1000, 1),
(44, 7, 68, '2019-02-16 13:46:54', 9100, 1),
(45, 8, 70, '2019-02-16 14:19:12', 2000, 1),
(46, 8, 70, '2019-02-16 14:20:03', 2150, 1),
(47, 7, 71, '2019-02-16 15:03:53', 1000, 1),
(48, 8, 72, '2019-02-16 15:15:28', 640, 4),
(49, 8, 72, '2019-02-16 15:15:47', 640, 1),
(50, 8, 73, '2019-02-16 15:29:40', 1593, 4),
(51, 8, 73, '2019-02-16 15:30:00', 1592, 1),
(52, 8, 75, '2019-02-16 16:09:36', 9000, 4),
(53, 8, 75, '2019-02-16 16:09:54', 9000, 1),
(54, 8, 76, '2019-02-16 16:15:29', 3000, 4),
(55, 8, 76, '2019-02-16 16:16:03', 3150, 1),
(56, 8, 76, '2019-02-16 16:26:49', 3000, 1),
(57, 8, 78, '2019-02-16 16:28:28', 3000, 1),
(58, 8, 79, '2019-02-19 10:41:14', 400, 4),
(59, 8, 80, '2019-02-19 10:45:27', 400, 4),
(60, 8, 64, '2019-02-19 10:46:19', 1280, 1),
(61, 8, 65, '2019-02-19 10:48:33', 2475, 1),
(62, 8, 63, '2019-02-19 10:50:01', 1500, 4),
(63, 8, 63, '2019-02-19 10:50:33', 1500, 1),
(64, 8, 62, '2019-02-19 10:51:17', 840, 1),
(65, 8, 61, '2019-02-19 10:52:10', 60, 1),
(66, 8, 77, '2019-02-19 10:59:04', 2000, 1),
(67, 8, 70, '2019-02-19 11:00:28', 2150, 1),
(68, 8, 72, '2019-02-19 11:00:52', 640, 1),
(69, 8, 73, '2019-02-19 11:01:21', 1592, 1),
(70, 8, 75, '2019-02-19 11:02:06', 9000, 3),
(71, 8, 76, '2019-02-19 11:02:27', 3150, 1),
(72, 8, 83, '2019-02-19 11:29:33', 4669, 4),
(73, 8, 84, '2019-02-19 11:40:53', 1275, 4),
(74, 8, 86, '2019-02-19 11:55:49', 750, 4),
(75, 8, 88, '2019-02-19 12:44:28', 1775, 4),
(76, 8, 89, '2019-02-19 12:50:11', 785, 4),
(77, 8, 90, '2019-02-20 13:52:36', 1265, 4),
(78, 8, 95, '2019-02-26 10:32:01', 500, 3),
(79, 8, 94, '2019-02-26 10:33:23', 280, 1),
(80, 7, 99, '2019-03-12 16:23:53', 750, 4),
(81, 8, 100, '2019-03-14 16:49:35', 2000, 3),
(82, 8, 101, '2019-03-14 17:28:30', 780, 4),
(83, 8, 102, '2019-03-14 17:45:32', 2000, 4),
(84, 8, 103, '2019-03-14 17:48:54', 2000, 4),
(85, 8, 104, '2019-03-14 17:52:37', 945, 4),
(86, 8, 105, '2019-03-14 17:59:56', 2430, 4),
(87, 8, 106, '2019-03-14 19:00:24', 1500, 4),
(88, 8, 108, '2019-03-15 12:26:03', 780, 4),
(89, 8, 109, '2019-03-15 15:29:13', 920, 4),
(90, 8, 110, '2019-03-15 15:30:10', 920, 4),
(91, 8, 111, '2019-03-15 15:35:00', 300, 4),
(92, 8, 112, '2019-03-15 15:45:42', 500, 4),
(93, 8, 113, '2019-03-15 16:01:02', 500, 3),
(94, 8, 114, '2019-03-15 16:04:11', 3500, 4),
(95, 8, 116, '2019-03-15 16:35:47', 500, 3),
(96, 8, 108, '2019-03-22 12:05:02', 780, 1),
(97, 8, 100, '2019-03-22 12:05:24', 1000, 1),
(98, 8, 118, '2019-03-22 12:16:31', 2000, 4),
(99, 8, 119, '2019-03-22 13:53:28', 600, 4),
(100, 7, 120, '2019-03-22 18:59:15', 800, 4),
(101, 7, 122, '2019-03-22 19:00:35', 2550, 2),
(102, 7, 123, '2019-03-22 19:01:34', 1600, 4),
(103, 4, 113, '2019-03-25 12:51:52', 500, 4),
(104, 4, 127, '2019-03-25 13:31:38', 100, 3),
(105, 4, 135, '2019-03-29 19:50:24', 1000, 1),
(106, 9, 140, '2019-05-07 17:18:59', 500, 1),
(107, 4, 147, '2019-05-20 19:05:14', 1000, 1),
(108, 15, 149, '2019-05-21 12:19:46', 500, 1),
(109, 15, 150, '2019-05-21 14:10:46', 500, 1),
(110, 15, 152, '2019-05-21 17:10:12', 885, 4),
(111, 15, 153, '2019-05-21 17:26:36', 885, 4),
(112, 15, 155, '2019-05-21 18:30:28', 1050, 4),
(113, 15, 161, '2019-05-24 11:07:35', 2000, 4),
(114, 15, 154, '2019-05-24 11:09:21', 1190, 4),
(115, 15, 153, '2019-05-24 11:29:56', 885, 4),
(116, 15, 153, '2019-05-24 11:32:24', -885, 1),
(117, 15, 171, '2019-05-24 18:04:28', 2000, 1),
(118, 15, 170, '2019-05-24 18:05:26', 500, 4),
(119, 15, 168, '2019-05-24 18:06:11', 760, 4),
(120, 15, 167, '2019-05-24 18:06:44', 3850, 4),
(121, 15, 166, '2019-05-24 18:07:42', 3700, 1),
(122, 15, 165, '2019-05-24 18:08:08', 500, 4),
(123, 15, 134, '2019-05-25 12:27:18', 2000, 1),
(124, 15, 178, '2019-05-25 15:39:23', 6500, 4),
(125, 9, 161, '2019-05-27 11:11:25', 2000, 1),
(126, 9, 161, '2019-05-27 11:11:37', 2000, 1),
(127, 9, 180, '2019-05-28 16:53:00', 560, 1),
(128, 9, 181, '2019-05-29 11:30:37', 500, 1),
(129, 15, 140, '2019-06-01 12:32:59', 900, 1),
(130, 15, 140, '2019-06-01 12:34:22', -900, 1),
(131, 15, 173, '2019-06-01 12:35:10', 900, 1),
(132, 15, 174, '2019-06-01 12:43:32', 500, 4),
(133, 15, 176, '2019-06-01 12:45:44', 5500, 1),
(134, 15, 175, '2019-06-01 12:58:08', 500, 1),
(135, 4, 149, '2019-06-15 00:48:40', 100, 3),
(136, 4, 188, '2019-06-15 00:56:49', 100, 3),
(137, 19, 192, '2019-06-20 10:42:18', 5000, 1),
(138, 19, 190, '2019-06-20 10:47:45', 650, 4),
(139, 15, 193, '2019-06-20 15:06:59', 2000, 4),
(140, 15, 179, '2019-06-20 15:09:03', 1700, 4),
(141, 9, 198, '2019-06-27 15:56:46', 910, 1),
(142, 9, 201, '2019-06-27 16:24:22', 2000, 3),
(143, 9, 201, '2019-06-27 16:25:49', 2000, 1),
(144, 19, 204, '2019-06-28 16:19:28', 1040, 1),
(145, 19, 202, '2019-06-28 16:29:25', 863, 1),
(146, 9, 206, '2019-06-29 11:54:13', 6938.82, 4),
(147, 9, 206, '2019-06-29 11:54:25', 6938.82, 4),
(148, 9, 206, '2019-07-02 13:24:32', 6938.32, 4),
(149, 9, 207, '2019-07-02 13:32:31', 2784, 4),
(150, 9, 208, '2019-07-02 13:32:44', 2784, 4),
(151, 19, 220, '2019-07-03 17:05:44', 400, 1),
(152, 19, 222, '2019-07-04 14:25:49', 750, 4),
(153, 19, 224, '2019-07-04 14:37:28', 1655, 4),
(154, 19, 223, '2019-07-04 14:38:10', 1500, 1),
(155, 9, 226, '2019-07-04 15:05:52', 700, 1),
(156, 9, 227, '2019-07-04 15:24:13', 1500, 1),
(157, 9, 216, '2019-07-04 15:32:26', 1000, 1),
(158, 9, 228, '2019-07-04 15:37:55', 2725, 1),
(159, 9, 229, '2019-07-04 15:46:09', 450, 1),
(160, 9, 230, '2019-07-05 10:12:05', 2000, 1),
(161, 19, 234, '2019-07-05 15:57:03', 1890, 1),
(162, 13, 235, '2019-07-05 22:29:38', 3000, 1),
(163, 9, 226, '2019-07-06 13:28:28', 7246, 4),
(164, 9, 237, '2019-07-06 13:36:01', 1000, 1),
(165, 9, 239, '2019-07-06 17:46:25', 1000, 1),
(166, 9, 240, '2019-07-06 17:56:48', 965, 1),
(167, 19, 213, '2019-07-08 10:22:05', 900, 1),
(168, 19, 241, '2019-07-08 16:02:58', 3000, 1),
(169, 9, 248, '2019-07-09 14:19:05', 760, 1),
(170, 19, 257, '2019-07-10 11:30:29', 2500, 3),
(171, 19, 259, '2019-07-10 11:38:37', 3000, 1),
(172, 9, 270, '2019-07-12 13:26:01', 2000, 1),
(173, 9, 277, '2019-07-17 14:17:37', 500, 1),
(174, 9, 282, '2019-07-17 14:53:50', 1100, 1),
(175, 9, 233, '2019-07-19 12:47:10', 1930, 4),
(176, 15, 284, '2019-07-25 11:02:17', 1000, 1),
(177, 19, 287, '2019-07-26 11:48:14', 1760, 1),
(178, 13, 309, '2019-07-26 13:11:19', 10000, 4),
(179, 19, 311, '2019-07-26 13:36:07', 2200, 1),
(180, 19, 310, '2019-07-26 17:36:31', 2320, 4),
(181, 19, 302, '2019-07-27 10:35:35', 10000, 1),
(182, 19, 310, '2019-07-30 13:08:59', 2320, 3),
(183, 19, 303, '2019-07-30 14:33:33', 1296.3, 4),
(184, 19, 315, '2019-07-30 18:10:13', 1630, 3),
(185, 15, 307, '2019-07-31 15:48:34', 2000, 1),
(186, 13, 320, '2019-07-31 16:30:18', 650, 1),
(187, 19, 319, '2019-08-01 17:13:51', 388, 1),
(188, 9, 297, '2019-08-02 11:14:41', 13224, 4),
(189, 9, 318, '2019-08-02 11:19:18', 50, 4),
(190, 9, 318, '2019-08-02 11:19:45', 50, 4),
(191, 19, 322, '2019-08-02 13:20:33', 1050, 4),
(192, 19, 321, '2019-08-03 15:36:41', 750, 4),
(193, 19, 330, '2019-08-07 11:30:04', 1200, 1),
(194, 15, 331, '2019-08-07 13:45:40', 1000, 1),
(195, 19, 334, '2019-08-07 14:07:59', 1000, 1),
(196, 19, 298, '2019-08-07 14:09:03', 1033, 2),
(197, 15, 332, '2019-08-07 14:30:59', 4000, 1),
(198, 15, 335, '2019-08-07 14:31:29', 3000, 1),
(199, 15, 336, '2019-08-07 14:34:17', 1000, 1),
(200, 15, 338, '2019-08-07 14:37:44', 8033, 4),
(201, 19, 339, '2019-08-07 14:38:26', 4050, 1),
(202, 9, 341, '2019-08-07 15:48:28', 2000, 3),
(203, 12, 344, '2019-08-08 10:59:19', 1000, 1),
(204, 12, 344, '2019-08-08 10:59:29', 1000, 1),
(205, 19, 346, '2019-08-09 12:46:12', 1508, 4),
(206, 15, 354, '2019-08-13 12:06:17', 1130, 1),
(207, 9, 349, '2019-08-13 12:20:13', 4500, 2),
(208, 15, 351, '2019-08-13 17:44:07', 500, 1),
(209, 19, 353, '2019-08-14 10:05:40', 1600, 1),
(210, 19, 360, '2019-08-15 11:40:45', 690, 1),
(211, 19, 314, '2019-08-15 14:06:37', 1253, 4),
(212, 19, 355, '2019-08-15 14:17:14', 1253, 4),
(213, 19, 359, '2019-08-15 14:38:53', 900, 4),
(214, 19, 363, '2019-08-15 14:44:03', 720, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatCamionetas`
--

DROP TABLE IF EXISTS `CatCamionetas`;
CREATE TABLE `CatCamionetas` (
  `eCodCamioneta` int(11) NOT NULL,
  `tCodEstatus` varchar(2) NOT NULL DEFAULT 'AC',
  `tNombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `CatCamionetas`
--

INSERT INTO `CatCamionetas` (`eCodCamioneta`, `tCodEstatus`, `tNombre`) VALUES
(1, 'AC', 'Estaquitas placas 333AAA');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatClientes`
--

DROP TABLE IF EXISTS `CatClientes`;
CREATE TABLE `CatClientes` (
  `eCodCliente` int(11) NOT NULL,
  `tTitulo` varchar(25) DEFAULT NULL,
  `tNombres` varchar(100) DEFAULT NULL,
  `tApellidos` varchar(100) DEFAULT NULL,
  `tCorreo` varchar(100) DEFAULT NULL,
  `tPassword` varchar(60) DEFAULT NULL,
  `tTelefonoFijo` varchar(15) DEFAULT NULL,
  `tTelefonoMovil` varchar(15) DEFAULT NULL,
  `fhFechaCreacion` datetime DEFAULT NULL,
  `eCodUsuario` int(11) NOT NULL,
  `eCodEstatus` int(11) DEFAULT NULL,
  `tComentarios` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `CatClientes`
--

INSERT INTO `CatClientes` (`eCodCliente`, `tTitulo`, `tNombres`, `tApellidos`, `tCorreo`, `tPassword`, `tTelefonoFijo`, `tTelefonoMovil`, `fhFechaCreacion`, `eCodUsuario`, `eCodEstatus`, `tComentarios`) VALUES
(1, NULL, 'Basmesa', 'Asociados SC', 'soporte@basesa.com.mx', NULL, '5512345678', '5598765432', '2019-08-18 04:02:00', 21, 3, 'Renta de aulas para capacitaciÃ³n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatCombos`
--

DROP TABLE IF EXISTS `CatCombos`;
CREATE TABLE `CatCombos` (
  `eCodCombo` int(11) NOT NULL,
  `tNombre` varchar(200) NOT NULL,
  `tDescripcion` text NOT NULL,
  `dPrecioVenta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatEstatus`
--

DROP TABLE IF EXISTS `CatEstatus`;
CREATE TABLE `CatEstatus` (
  `eCodEstatus` int(11) NOT NULL,
  `tCodEstatus` varchar(2) DEFAULT NULL,
  `tNombre` varchar(15) DEFAULT NULL,
  `tIcono` varchar(25) DEFAULT NULL,
  `tColor` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `CatEstatus`
--

INSERT INTO `CatEstatus` (`eCodEstatus`, `tCodEstatus`, `tNombre`, `tIcono`, `tColor`) VALUES
(1, 'NU', 'Nuevo', 'far fa-question-circle', NULL),
(2, 'PR', 'En proceso...', 'fas fa-cogs', '#84eefa'),
(3, 'AC', 'Activo', 'fa fa-check', NULL),
(4, 'CA', 'Cancelado', 'fas fa-ban', NULL),
(5, 'RE', 'Rechazado', 'fas fa-minus-circle', NULL),
(6, 'BL', 'Bloqueado', 'fas fa-lock', NULL),
(7, 'EL', 'Eliminado', 'far fa-trash-alt', NULL),
(8, 'FI', 'Finalizado', 'fas fa-check-double', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatInventario`
--

DROP TABLE IF EXISTS `CatInventario`;
CREATE TABLE `CatInventario` (
  `eCodInventario` int(11) NOT NULL,
  `tCodInventario` char(4) DEFAULT NULL,
  `eCodTipoInventario` int(11) NOT NULL,
  `tNombre` varchar(100) NOT NULL,
  `tMarca` varchar(100) NOT NULL,
  `tDescripcion` text NOT NULL,
  `dPrecioInterno` double NOT NULL,
  `dPrecioVenta` double NOT NULL,
  `ePiezas` int(11) NOT NULL,
  `tImagen` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `CatInventario`
--

INSERT INTO `CatInventario` (`eCodInventario`, `tCodInventario`, `eCodTipoInventario`, `tNombre`, `tMarca`, `tDescripcion`, `dPrecioInterno`, `dPrecioVenta`, `ePiezas`, `tImagen`) VALUES
(1, NULL, 1, 'CAFETERA 50 tazas', 'XXXXX', 'hdfhauh', 579, 620, 1, '../inv/5d58cfb6ab540.jpg'),
(2, NULL, 2, 'Mesa 120x40 platico rigido blanco', 'ooooooo', 'Mesa de 120 x 40 de plÃ¡stico rÃ­gido color blanco', 980, 1250, 1, '../inv/5d58d1c2aa684.jpg'),
(3, NULL, 2, 'Mesa Redonda 12 personas', 'S/M', 'Mesa redonda madera-acero 12 personas con soporte de sombrilla', 120, 180, 50, '../inv/5d800bd4c3637.jpg'),
(4, NULL, 1, 'Pista Iluminada Led 3 colores', 'S/M', 'Pista iluminada led RGB 1.2X1.2 metros', 250, 320, 10, '../inv/5d800c1df3da3.jpg'),
(5, NULL, 2, 'Silla Plegable Acojinada Negra', 'S/M', 'Silla plegable acojinada negra metalica', 140, 190, 200, '../inv/5d800c5c1b592.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatServicios`
--

DROP TABLE IF EXISTS `CatServicios`;
CREATE TABLE `CatServicios` (
  `eCodServicio` int(11) NOT NULL,
  `tNombre` varchar(200) NOT NULL,
  `tDescripcion` text NOT NULL,
  `dPrecioVenta` double NOT NULL,
  `dHoraExtra` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `CatServicios`
--

INSERT INTO `CatServicios` (`eCodServicio`, `tNombre`, `tDescripcion`, `dPrecioVenta`, `dHoraExtra`) VALUES
(1, 'Coffe Break', 'Q2Fmw6ksIHTDqSB5IGFndWFzLCBnYWxsZXRhcw==', 650, NULL),
(2, 'pista 30 personas', 'UGFxdWV0ZSBkZSAzIG1lc2FzIHkgcGlzdGEgaWx1bWluYWRhIGluY2x1eWUgY29mZmVlIGJyZWFr', 1600, 270);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatTiposInventario`
--

DROP TABLE IF EXISTS `CatTiposInventario`;
CREATE TABLE `CatTiposInventario` (
  `eCodTipoInventario` int(11) NOT NULL,
  `tNombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `CatTiposInventario`
--

INSERT INTO `CatTiposInventario` (`eCodTipoInventario`, `tNombre`) VALUES
(1, 'Equipo'),
(2, 'Mobiliario'),
(3, 'Accesorios'),
(4, 'Consumibles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatTiposPagos`
--

DROP TABLE IF EXISTS `CatTiposPagos`;
CREATE TABLE `CatTiposPagos` (
  `eCodTipoPago` int(11) NOT NULL,
  `tNombre` varchar(25) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `CatTiposPagos`
--

INSERT INTO `CatTiposPagos` (`eCodTipoPago`, `tNombre`) VALUES
(1, 'Efectivo'),
(2, 'Tarjeta'),
(3, 'Cheque'),
(4, 'Transferencia');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `CatTiposSecciones`
--

DROP TABLE IF EXISTS `CatTiposSecciones`;
CREATE TABLE `CatTiposSecciones` (
  `eCodTipoSeccion` int(11) NOT NULL,
  `tCodTipoSeccion` char(3) NOT NULL,
  `tNombre` varchar(50) NOT NULL,
  `tIcono` varchar(50) DEFAULT NULL,
  `ePosicion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `CatTiposSecciones`
--

INSERT INTO `CatTiposSecciones` (`eCodTipoSeccion`, `tCodTipoSeccion`, `tNombre`, `tIcono`, `ePosicion`) VALUES
(1, 'cat', 'Catalogo', 'fas fa-folder-open', 2),
(2, 'ser', 'Servicio', 'fas fa-list-alt', 3),
(3, 'sis', 'Sistema', 'fas fa-cogs', 5),
(4, 'con', 'Consultas', 'fas fa-search', 4),
(5, 'ini', 'Inicio', 'fas fa-tachometer-alt', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RelEventosPaquetes`
--

DROP TABLE IF EXISTS `RelEventosPaquetes`;
CREATE TABLE `RelEventosPaquetes` (
  `eCodEvento` int(11) NOT NULL,
  `eCodServicio` int(11) NOT NULL,
  `eCantidad` int(11) NOT NULL,
  `eCodTipo` int(11) NOT NULL,
  `dMonto` double DEFAULT 0
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `RelEventosPaquetes`
--

INSERT INTO `RelEventosPaquetes` (`eCodEvento`, `eCodServicio`, `eCantidad`, `eCodTipo`, `dMonto`) VALUES
(1, 2, 1, 2, 1250),
(1, 1, 1, 2, 620),
(2, 2, 1, 1, 1600),
(2, 1, 1, 1, 650),
(2, 5, 5, 2, 950);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RelEventosRutas`
--

DROP TABLE IF EXISTS `RelEventosRutas`;
CREATE TABLE `RelEventosRutas` (
  `eCodEvento` int(11) NOT NULL,
  `eCodUsuarioEntrega` int(11) NOT NULL,
  `eCodUsuarioRecoleccion` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RelNegociosAfiliadosGaleria`
--

DROP TABLE IF EXISTS `RelNegociosAfiliadosGaleria`;
CREATE TABLE `RelNegociosAfiliadosGaleria` (
  `eCodRegistro` int(11) NOT NULL,
  `eCodAfiliacion` int(11) NOT NULL,
  `tTipo` char(3) NOT NULL,
  `tArchivo` varchar(250) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RelRegistrosCargasInventario`
--

DROP TABLE IF EXISTS `RelRegistrosCargasInventario`;
CREATE TABLE `RelRegistrosCargasInventario` (
  `eCodRegistro` int(11) NOT NULL,
  `eCodInventario` int(11) NOT NULL,
  `eCantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `RelServiciosInventario`
--

DROP TABLE IF EXISTS `RelServiciosInventario`;
CREATE TABLE `RelServiciosInventario` (
  `eCodServicio` int(11) NOT NULL,
  `eCodInventario` int(11) NOT NULL,
  `ePiezas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `RelServiciosInventario`
--

INSERT INTO `RelServiciosInventario` (`eCodServicio`, `eCodInventario`, `ePiezas`) VALUES
(1, 1, 1),
(1, 2, 1),
(2, 1, 2),
(2, 4, 2),
(2, 3, 3),
(2, 5, 30);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisBotones`
--

DROP TABLE IF EXISTS `SisBotones`;
CREATE TABLE `SisBotones` (
  `tCodBoton` varchar(2) NOT NULL,
  `tTitulo` varchar(20) DEFAULT NULL,
  `tFuncion` varchar(25) DEFAULT NULL,
  `tAccion` varchar(25) NOT NULL,
  `tIcono` varchar(45) DEFAULT NULL,
  `tId` varchar(15) NOT NULL,
  `tClase` varchar(50) NOT NULL,
  `tHTML` varchar(255) DEFAULT NULL,
  `bDeshabilitado` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisBotones`
--

INSERT INTO `SisBotones` (`tCodBoton`, `tTitulo`, `tFuncion`, `tAccion`, `tIcono`, `tId`, `tClase`, `tHTML`, `bDeshabilitado`) VALUES
('CO', 'Listado', 'window.location=\'url\';', '', '<i class=\"fas fa-table\"></i>', '', 'btn btn-primary', NULL, NULL),
('EL', 'Eliminar', 'eliminar();', '', '<i class=\"far fa-trash-alt\"></i>', '', 'btn btn-danger', NULL, NULL),
('GU', 'Guardar', 'validar();', '', '<i class=\"fa fa-floppy-o\"></i>', 'btnGuardar', 'btn btn-primary', NULL, NULL),
('IM', 'Imprimir', 'imprimir();', '', '<i class=\"fas fa-print\"></i>', '', 'btn btn-success', NULL, NULL),
('NU', 'Nuevo', 'window.location=\'url\';', '', '<i class=\"fa fa-plus\"></i>', 'btnNuevo', 'btn btn-primary', NULL, NULL),
('PD', 'Descargar PDF', 'window.location=\'url\';', 'generar/pdf', '<i class=\"fas fa-file-pdf\"></i>', '', 'btn btn-danger', NULL, NULL),
('RE', 'Rechazar', 'rechazar();', '', '<i class=\"far fa-trash-alt\"></i>', '', 'btn btn-danger', NULL, NULL),
('SR', 'Consultar', 'consultarFecha();', '', '<i class=\"fas fa-search\"></i>', '', 'btn btn-info', '<form id=\"Datos\" method=\"post\" action=\"<?=$_SERVER[\'REQUEST_URI\']?>\"><input type=\"text\" id=\"datepicker\"><input type=\"hidden\" name=\"fhFechaConsulta\" id=\"datepicker1\"></form>', NULL),
('VA', NULL, 'activarValidacion();', '', '<i class=\"fa fa-key\" ></i>', 'btnValidar', 'btn btn-primary', '<input type=\"password\" class=\"form-control col-md-3\" onkeyup=\"validarUsuario()\"  id=\"tPasswordOperaciones\"  style=\"display:none;\" size=\"8\">', NULL),
('XL', 'Descargar XLS', 'window.location=\'url\';', 'exportar/xls', '<i class=\"fas fa-file-excel\"></i>', '', 'btn btn-success', NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisLogs`
--

DROP TABLE IF EXISTS `SisLogs`;
CREATE TABLE `SisLogs` (
  `eCodEvento` int(11) NOT NULL,
  `eCodUsuario` int(11) NOT NULL,
  `fhFecha` datetime NOT NULL,
  `tDescripcion` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisLogs`
--

INSERT INTO `SisLogs` (`eCodEvento`, `eCodUsuario`, `fhFecha`, `tDescripcion`) VALUES
(1, 21, '2019-08-18 04:02:05', 'Se ha insertado/actualizado el cliente 0000001'),
(2, 21, '2019-08-18 04:07:16', 'Se ha insertado/actualizado el paquete 0000001'),
(3, 21, '2019-08-18 04:10:30', 'Se ha insertado/actualizado el producto 0000001'),
(4, 21, '2019-08-18 04:15:31', 'Se ha insertado/actualizado el paquete 0000001'),
(5, 21, '2019-08-18 04:19:14', 'Se ha insertado/actualizado el producto 0000002'),
(6, 21, '2019-08-18 04:20:04', 'Se ha insertado/actualizado el paquete 0000001'),
(7, 21, '2019-08-18 04:22:13', 'Se ha registrado el evento 0000001'),
(8, 1, '2019-08-23 14:21:24', 'Se ha insertado/actualizado el tipo de inventario 0000000'),
(9, 21, '2019-09-16 19:25:04', 'Se ha insertado/actualizado el vehiculo 0000001'),
(10, 21, '2019-09-16 19:28:55', 'Se ha insertado/actualizado el paquete 0000001'),
(11, 1, '2019-09-16 22:22:34', 'Se ha insertado/actualizado el paquete 0000001'),
(12, 1, '2019-09-16 22:25:24', 'Se ha insertado/actualizado el producto 0000003'),
(13, 1, '2019-09-16 22:26:38', 'Se ha insertado/actualizado el producto 0000004'),
(14, 1, '2019-09-16 22:27:40', 'Se ha insertado/actualizado el producto 0000005'),
(15, 1, '2019-09-16 22:29:28', 'Se ha insertado/actualizado el paquete 0000002'),
(16, 1, '2019-09-16 22:37:54', 'Se ha registrado el evento 0000002');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisPerfiles`
--

DROP TABLE IF EXISTS `SisPerfiles`;
CREATE TABLE `SisPerfiles` (
  `eCodPerfil` int(11) NOT NULL,
  `tNombre` varchar(15) DEFAULT NULL,
  `tCodEstatus` varchar(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisPerfiles`
--

INSERT INTO `SisPerfiles` (`eCodPerfil`, `tNombre`, `tCodEstatus`) VALUES
(1, 'Administrador', 'AC'),
(2, 'Coordinador', 'AC'),
(3, 'Ventas', 'AC'),
(4, 'Pagos', 'AC'),
(5, 'Bodega', NULL),
(6, 'Entregas', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisRegistrosCargas`
--

DROP TABLE IF EXISTS `SisRegistrosCargas`;
CREATE TABLE `SisRegistrosCargas` (
  `eCodRegistro` int(11) NOT NULL,
  `eCodEvento` int(11) NOT NULL,
  `eCodUsuario` int(11) NOT NULL,
  `fhFechaCarga` datetime DEFAULT NULL,
  `eCodCamioneta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisSecciones`
--

DROP TABLE IF EXISTS `SisSecciones`;
CREATE TABLE `SisSecciones` (
  `tCodSeccion` varchar(20) NOT NULL,
  `tCodPadre` varchar(20) DEFAULT NULL,
  `tCodTipoSeccion` char(3) NOT NULL,
  `tDirectorio` char(3) NOT NULL,
  `tTitulo` varchar(60) DEFAULT NULL,
  `eCodEstatus` int(11) DEFAULT NULL,
  `ePosicion` int(11) DEFAULT NULL,
  `bFiltro` int(11) NOT NULL,
  `bPublico` int(11) DEFAULT NULL,
  `tIcono` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisSecciones`
--

INSERT INTO `SisSecciones` (`tCodSeccion`, `tCodPadre`, `tCodTipoSeccion`, `tDirectorio`, `tTitulo`, `eCodEstatus`, `ePosicion`, `bFiltro`, `bPublico`, `tIcono`) VALUES
('cata-cam-con', 'sis-dash-con', 'cat', 'veh', 'Camionetas', 3, 3, 1, NULL, 'fa fa-file-text-o'),
('cata-cam-reg', 'cata-cam-con', '', 'veh', '+ Camionetas', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('cata-car-con', 'sis-dash-con', '', 'das', 'Eventos de Carga', 3, 3, 1, NULL, 'fa fa-file-text-o'),
('cata-cli-con', 'sis-dash-con', 'cat', 'cli', 'Clientes', 3, 3, 1, NULL, 'fa fa-file-text-o'),
('cata-cli-det', 'cata-cli-con', '', 'cli', 'Detalles de Clientes', 3, 2, 0, 1, 'fa fa-file-text-o'),
('cata-cli-reg', 'cata-cli-con', '', 'cli', '+ Clientes', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('cata-eve-con', 'sis-dash-con', 'con', 'ser', 'Eventos', 3, 2, 1, NULL, 'fa fa-file-text-o'),
('cata-eve-det', 'cata-eve-con', '', 'ser', 'Detalles de Eventos', 3, 1, 0, 1, 'fa fa-file-text-o'),
('cata-inv-con', 'sis-dash-con', 'cat', 'inv', 'Inventario', 3, 3, 1, NULL, 'fa fa-file-text-o'),
('cata-inv-det', 'cata-inv-con', '', 'inv', 'Detalles de Inventario', 3, 2, 0, 1, 'fa fa-file-text-o'),
('cata-inv-reg', 'cata-inv-con', '', 'inv', '+ Inventario', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('cata-per-reg', 'cata-per-sis', '', 'sis', '+ Perfiles', 3, 5, 0, NULL, 'fa fa-file-text-o'),
('cata-per-sis', 'sis-dash-con', 'sis', 'sis', 'Perfiles', 3, 6, 0, NULL, 'fa fa-file-text-o'),
('cata-ren-con', 'sis-dash-con', 'con', 'ser', 'Rentas', 3, 2, 1, NULL, 'fa fa-file-text-o'),
('cata-ren-det', 'cata-ren-con', '', 'ser', 'Detalles de Rentas', 3, 1, 0, 1, 'fa fa-file-text-o'),
('cata-ser-con', 'sis-dash-con', 'cat', 'inv', 'Paquetes', 3, 3, 1, NULL, 'fa fa-file-text-o'),
('cata-ser-det', 'cata-ser-con', '', 'inv', 'Detalles de Paquetes', 3, 2, 0, 1, 'fa fa-file-text-o'),
('cata-ser-reg', 'cata-ser-con', '', 'inv', '+ Paquetes', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('cata-tiv-con', 'sis-dash-con', 'cat', 'inv', 'Tipos de Inventario', 3, 4, 1, NULL, 'fa fa-file-text-o'),
('cata-tiv-reg', 'cata-tiv-con', '', 'inv', '+ Tipo de Inventario', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('cata-tra-con', 'sis-dash-con', 'con', 'das', 'Transacciones', 3, 4, 1, NULL, 'fa fa-file-text-o'),
('cata-usr-reg', 'cata-usr-sis', '', 'sis', '+ Usuarios', 3, 5, 0, NULL, 'fa fa-file-text-o'),
('cata-usr-sis', 'sis-dash-con', 'sis', 'sis', 'Usuarios', 3, 5, 0, NULL, 'fa fa-file-text-o'),
('oper-eve-cot', 'cata-eve-con', 'ser', 'ser', '+ Eventos', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('oper-ren-cot', 'cata-ren-con', 'ser', 'ser', '+ Rentas', 3, 1, 0, NULL, 'fa fa-file-text-o'),
('sis-bod-con', 'sis-dash-con', 'ini', 'das', 'Bodega', 3, 2, 1, NULL, 'fa-tachometer-alt'),
('sis-dash-con', NULL, 'ini', 'das', 'Dashboard', 3, 1, 1, NULL, 'fa-tachometer-alt'),
('sis-log-con', 'sis-dash-con', 'sis', 'sis', 'Logs', 3, 15, 0, NULL, 'fa fa-file-text-o');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisSeccionesBotones`
--

DROP TABLE IF EXISTS `SisSeccionesBotones`;
CREATE TABLE `SisSeccionesBotones` (
  `eCodRegistro` int(11) NOT NULL,
  `tCodPadre` varchar(15) DEFAULT NULL,
  `tCodSeccion` varchar(15) DEFAULT NULL,
  `tCodBoton` varchar(2) DEFAULT NULL,
  `tFuncion` varchar(25) DEFAULT NULL,
  `tEtiqueta` varchar(30) DEFAULT NULL,
  `ePosicion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisSeccionesBotones`
--

INSERT INTO `SisSeccionesBotones` (`eCodRegistro`, `tCodPadre`, `tCodSeccion`, `tCodBoton`, `tFuncion`, `tEtiqueta`, `ePosicion`) VALUES
(2, 'cata-cli-reg', 'cata-cli-reg', 'GU', NULL, NULL, 2),
(3, 'cata-cli-reg', 'cata-cli-con', 'CO', NULL, NULL, 3),
(5, 'cata-inv-reg', 'cata-inv-reg', 'GU', NULL, NULL, 2),
(6, 'cata-inv-reg', 'cata-inv-con', 'CO', NULL, NULL, 3),
(8, 'cata-per-reg', 'cata-per-reg', 'GU', 'guardar();', NULL, 2),
(9, 'cata-per-reg', 'sis-per-con', 'CO', NULL, NULL, 3),
(11, 'cata-ser-reg', 'cata-ser-reg', 'GU', NULL, NULL, 2),
(12, 'cata-ser-reg', 'cata-ser-con', 'CO', NULL, NULL, 3),
(14, 'cata-usr-reg', 'cata-usr-reg', 'GU', NULL, NULL, 2),
(15, 'cata-usr-reg', 'sis-usr-con', 'CO', NULL, NULL, 3),
(17, 'oper-eve-cot', 'oper-eve-reg', 'GU', NULL, NULL, 2),
(18, 'oper-eve-cot', 'cata-eve-con', 'CO', NULL, NULL, 3),
(20, 'oper-ren-cot', 'oper-ren-cot', 'GU', NULL, NULL, 2),
(21, 'oper-ren-cot', 'cata-ren-con', 'CO', NULL, NULL, 3),
(22, 'cata-cli-con', 'cata-cli-reg', 'NU', NULL, NULL, 1),
(24, 'cata-eve-con', 'oper-eve-cot', 'NU', NULL, NULL, 1),
(25, 'cata-inv-con', 'cata-inv-reg', 'NU', NULL, NULL, 1),
(26, 'cata-ren-con', 'oper-ren-cot', 'NU', NULL, NULL, 1),
(27, 'cata-ser-con', 'cata-ser-reg', 'NU', NULL, NULL, 1),
(28, 'cata-per-sis', 'cata-per-reg', 'NU', NULL, NULL, 1),
(29, 'cata-usr-sis', 'cata-usr-reg', 'NU', NULL, NULL, 1),
(30, 'cata-cli-det', 'cata-cli-con', 'CO', NULL, NULL, 3),
(31, 'cata-eve-det', 'cata-eve-det', 'PD', NULL, NULL, 1),
(32, 'cata-ren-det', 'cata-ren-det', 'PD', NULL, NULL, 1),
(33, 'cata-cli-con', 'cata-cli-reg', 'XL', NULL, NULL, 2),
(34, 'cata-eve-det', 'cata-eve-con', 'CO', NULL, NULL, 3),
(35, 'cata-ren-det', 'cata-ren-con', 'CO', NULL, NULL, 3),
(37, 'sis-dash-con', 'oper-eve-cot', 'NU', NULL, 'Nuevo Evento', 1),
(38, 'sis-dash-con', 'oper-ren-cot', 'NU', NULL, 'Nueva Renta', 2),
(39, 'cata-ser-det', 'cata-ser-con', 'CO', NULL, NULL, 1),
(41, 'cata-inv-det', 'cata-inv-con', 'CO', NULL, NULL, 3),
(44, 'cata-cam-reg', 'cata-cam-reg', 'GU', NULL, NULL, 2),
(45, 'cata-cam-reg', 'cata-cam-con', 'CO', NULL, NULL, 3),
(46, 'cata-cam-con', 'cata-cam-reg', 'NU', NULL, NULL, 1),
(48, 'cata-tiv-con', 'cata-tiv-reg', 'NU', NULL, NULL, 1),
(49, 'cata-tiv-reg', 'cata-tiv-reg', 'GU', 'guardar();', NULL, 2),
(50, 'cata-tiv-reg', 'cata-tiv-con', 'CO', NULL, NULL, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisSeccionesMenusEmergentes`
--

DROP TABLE IF EXISTS `SisSeccionesMenusEmergentes`;
CREATE TABLE `SisSeccionesMenusEmergentes` (
  `eCodMenuEmergente` int(11) NOT NULL,
  `tCodPadre` varchar(20) DEFAULT NULL,
  `tCodSeccion` varchar(20) DEFAULT NULL,
  `tCodPermiso` char(1) NOT NULL,
  `tTitulo` varchar(30) NOT NULL,
  `tAccion` varchar(25) DEFAULT NULL,
  `tFuncion` varchar(50) DEFAULT NULL,
  `tValor` varchar(20) DEFAULT NULL,
  `ePosicion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisSeccionesMenusEmergentes`
--

INSERT INTO `SisSeccionesMenusEmergentes` (`eCodMenuEmergente`, `tCodPadre`, `tCodSeccion`, `tCodPermiso`, `tTitulo`, `tAccion`, `tFuncion`, `tValor`, `ePosicion`) VALUES
(1, 'cata-cli-con', 'cata-cli-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 2),
(2, 'cata-ser-con', 'cata-ser-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 2),
(3, 'cata-eve-con', 'cata-eve-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 2),
(4, 'cata-ren-con', 'cata-ren-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 1),
(5, 'cata-inv-con', 'cata-inv-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 1),
(6, 'cata-eve-con', 'oper-eve-cot', 'A', 'Editar', 'editar-cotizacion', 'window.location=\'url\';', 'editar-cotizacion', 1),
(7, 'cata-cli-con', 'cata-cli-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1),
(8, 'cata-usr-sis', 'cata-usr-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1),
(9, 'cata-ser-con', 'cata-ser-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1),
(10, 'cata-cli-con', 'cata-cli-con', 'D', 'Eliminar', 'eliminar', 'acciones(codigo,\'D\');', 'eliminar', 3),
(11, 'cata-ser-con', 'cata-ser-con', 'D', 'Eliminar', 'eliminar', 'acciones(codigo,\'D\');', 'eliminar', 3),
(12, 'cata-eve-con', 'cata-eve-con', 'D', 'Eliminar', 'eliminar', 'acciones(codigo,\'D\');', 'eliminar', 3),
(13, 'cata-ren-con', 'cata-ren-con', 'D', 'Eliminar', 'eliminar', 'acciones(codigo,\'D\');', 'eliminar', 3),
(14, 'cata-inv-con', 'cata-inv-con', 'D', 'Eliminar', 'eliminar', 'acciones(codigo,\'D\');', 'eliminar', 2),
(16, 'cata-usr-sis', 'cata-usr-sis', 'D', 'Eliminar', 'eliminar', 'acciones(codigo,\'D\');', 'eliminar', 2),
(17, 'cata-eve-con', 'cata-eve-con', 'D', 'Finalizar', 'finalizar', 'acciones(codigo,\'F\');', 'finalizar', 4),
(18, 'cata-ren-con', 'cata-ren-con', 'D', 'Finalizar', 'finalizar', 'acciones(codigo,\'F\');', 'finalizar', 4),
(19, 'cata-ren-con', 'oper-ren-cot', 'A', 'Editar', 'editar-cotizacion', 'window.location=\'url\';', 'editar-cotizacion', 1),
(20, 'cata-eve-con', 'cata-eve-con', 'A', 'Agregar Transaccion', 'agregarTransaccion', 'nuevaTransaccion(codigo);', 'agregarTransaccion', 5),
(21, 'cata-ren-con', 'cata-ren-con', 'A', 'Agregar transaccion', 'agregarTransaccion', 'nuevaTransaccion(codigo);', 'agregarTransaccion', 5),
(22, 'cata-ren-con', 'oper-ren-cot', 'A', 'Editar', 'editar-cotizacion', 'window.location=\'url\';', 'editar-cotizacion', 1),
(23, 'cata-eve-con', 'cata-eve-con', 'A', 'Agregar Transaccion', 'agregarTransaccion', 'nuevaTransaccion(codigo);', 'agregarTransaccion', 5),
(24, 'cata-ren-con', 'cata-ren-con', 'A', 'Agregar transaccion', 'agregarTransaccion', 'nuevaTransaccion(codigo);', 'agregarTransaccion', 5),
(25, 'cata-per-sis', 'cata-per-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1),
(26, 'cata-tra-con', 'cata-eve-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 1),
(27, 'cata-inv-con', 'cata-inv-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1),
(28, 'cata-cam-con', 'cata-cam-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1),
(29, 'cata-car-con', 'cata-eve-det', 'A', 'Detalles', 'detalles', 'window.location=\'url\';', 'detalles', 2),
(30, 'cata-tiv-con', 'cata-tiv-reg', 'A', 'Editar', 'editar', 'window.location=\'url\';', 'editar', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisSeccionesPerfiles`
--

DROP TABLE IF EXISTS `SisSeccionesPerfiles`;
CREATE TABLE `SisSeccionesPerfiles` (
  `eCodPerfil` int(11) DEFAULT NULL,
  `tCodSeccion` varchar(15) DEFAULT NULL,
  `bAll` int(11) DEFAULT NULL,
  `bDelete` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisSeccionesPerfiles`
--

INSERT INTO `SisSeccionesPerfiles` (`eCodPerfil`, `tCodSeccion`, `bAll`, `bDelete`) VALUES
(1, 'sis-dash-con', 1, 1),
(1, 'sis-bod-con', 1, 1),
(1, 'cata-eve-con', 1, 1),
(1, 'cata-eve-det', 0, 0),
(1, 'oper-eve-cot', 0, 0),
(1, 'cata-ren-con', 1, 1),
(1, 'cata-ren-det', 0, 0),
(1, 'oper-ren-cot', 0, 0),
(1, 'cata-cli-con', 1, 1),
(1, 'cata-cli-reg', 0, 0),
(1, 'cata-cli-det', 0, 0),
(1, 'cata-ser-con', 0, 1),
(1, 'cata-ser-reg', 0, 0),
(1, 'cata-ser-det', 0, 0),
(1, 'cata-inv-con', 0, 1),
(1, 'cata-inv-reg', 0, 0),
(1, 'cata-inv-det', 0, 0),
(1, 'cata-tra-con', 1, 1),
(1, 'cata-usr-sis', 0, 1),
(1, 'cata-usr-reg', 0, 0),
(1, 'cata-per-sis', 0, 1),
(1, 'cata-per-reg', 0, 0),
(1, 'sis-log-con', 0, 1),
(6, 'sis-bod-con', 1, 0),
(6, 'cata-ren-con', 1, 0),
(6, 'cata-ren-det', 1, 0),
(6, 'cata-eve-con', 1, 0),
(6, 'cata-eve-det', 1, 0),
(6, 'cata-ser-con', 1, 0),
(6, 'cata-ser-det', 1, 0),
(6, 'cata-cam-reg', 1, 1),
(6, 'cata-cli-det', 0, 0),
(6, 'cata-car-con', 1, 0),
(6, 'cata-tra-con', 1, 0),
(2, 'sis-dash-con', 1, 1),
(2, 'sis-bod-con', 1, 1),
(2, 'cata-ren-con', 1, 1),
(2, 'cata-ren-det', 1, 1),
(2, 'oper-ren-cot', 1, 1),
(2, 'cata-eve-con', 1, 1),
(2, 'cata-eve-det', 1, 1),
(2, 'oper-eve-cot', 1, 1),
(2, 'cata-ser-con', 1, 1),
(2, 'cata-ser-reg', 1, 1),
(2, 'cata-ser-det', 1, 1),
(2, 'cata-cam-con', 1, 1),
(2, 'cata-cam-reg', 1, 1),
(2, 'cata-inv-con', 1, 1),
(2, 'cata-inv-reg', 1, 1),
(2, 'cata-inv-det', 1, 1),
(2, 'cata-cli-con', 1, 1),
(2, 'cata-cli-reg', 1, 1),
(2, 'cata-cli-det', 1, 1),
(2, 'cata-car-con', 1, 1),
(2, 'cata-tra-con', 1, 1),
(3, 'sis-dash-con', 1, 0),
(3, 'cata-ren-con', 1, 0),
(3, 'cata-ren-det', 1, 0),
(3, 'oper-ren-cot', 1, 0),
(3, 'cata-eve-con', 1, 0),
(3, 'cata-eve-det', 1, 0),
(3, 'oper-eve-cot', 1, 0),
(3, 'cata-ser-con', 0, 0),
(3, 'cata-ser-det', 1, 0),
(3, 'cata-inv-con', 1, 0),
(3, 'cata-inv-det', 1, 0),
(3, 'cata-cli-con', 1, 0),
(3, 'cata-cli-reg', 1, 0),
(3, 'cata-cli-det', 1, 0),
(3, 'cata-tra-con', 1, 0),
(5, 'sis-bod-con', 1, 0),
(5, 'cata-ser-con', 0, 0),
(5, 'cata-ser-det', 0, 0),
(5, 'cata-cam-con', 1, 0),
(5, 'cata-inv-con', 1, 0),
(5, 'cata-inv-det', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisSeccionesPerfilesInicio`
--

DROP TABLE IF EXISTS `SisSeccionesPerfilesInicio`;
CREATE TABLE `SisSeccionesPerfilesInicio` (
  `eCodPerfil` int(11) NOT NULL,
  `tCodSeccion` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `SisSeccionesPerfilesInicio`
--

INSERT INTO `SisSeccionesPerfilesInicio` (`eCodPerfil`, `tCodSeccion`) VALUES
(1, 'sis-dash-con'),
(2, 'sis-dash-con'),
(5, 'sis-bod-con'),
(6, 'sis-bod-con'),
(3, 'sis-dash-con');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisSeccionesReemplazos`
--

DROP TABLE IF EXISTS `SisSeccionesReemplazos`;
CREATE TABLE `SisSeccionesReemplazos` (
  `eCodReemplazo` int(11) NOT NULL,
  `tBase` varchar(4) NOT NULL,
  `tNombre` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisSeccionesReemplazos`
--

INSERT INTO `SisSeccionesReemplazos` (`eCodReemplazo`, `tBase`, `tNombre`) VALUES
(1, 'cata', 'catalogo'),
(2, 'oper', 'operaciones'),
(3, 'reg', 'registrar'),
(4, 'inv', 'inventario'),
(5, 'usr', 'usuario'),
(6, 'sis', 'sistema'),
(7, 'bod', 'bodega'),
(8, 'ser', 'paquetes'),
(9, 'per', 'perfiles'),
(10, 'con', 'consultar'),
(11, 'dash', 'dashboard'),
(12, 'eve', 'eventos'),
(13, 'noti', 'notificaciones'),
(14, 'det', 'detalles'),
(15, 'del', 'eliminar'),
(16, 'log', 'logs'),
(17, 'tra', 'transacciones'),
(18, 'cit', 'citas'),
(19, 'gen', 'generar'),
(20, 'xls', 'excel'),
(21, 'pdf', 'pdf'),
(22, 'ren', 'rentas'),
(23, 'cli', 'clientes'),
(24, 'reg', 'editar'),
(25, 'xls', 'xls'),
(26, 'cot', 'crear'),
(27, 'cot', 'editar-cotizacion'),
(28, 'cam', 'camionetas'),
(29, 'car', 'carga'),
(30, 'cam', 'camionetas'),
(31, 'tiv', 'tipo-inventario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisUsuarios`
--

DROP TABLE IF EXISTS `SisUsuarios`;
CREATE TABLE `SisUsuarios` (
  `eCodUsuario` int(11) NOT NULL,
  `eCodEntidad` int(11) DEFAULT NULL,
  `tNombre` varchar(50) DEFAULT NULL,
  `tApellidos` varchar(50) DEFAULT NULL,
  `tCorreo` varchar(100) DEFAULT NULL,
  `tPasswordAcceso` varchar(60) DEFAULT NULL,
  `tPasswordOperaciones` varchar(60) DEFAULT NULL,
  `fhFechaCreacion` datetime DEFAULT NULL,
  `eCodEstatus` int(11) DEFAULT NULL,
  `eCodPerfil` int(11) DEFAULT NULL,
  `bAll` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisUsuarios`
--

INSERT INTO `SisUsuarios` (`eCodUsuario`, `eCodEntidad`, `tNombre`, `tApellidos`, `tCorreo`, `tPasswordAcceso`, `tPasswordOperaciones`, `fhFechaCreacion`, `eCodEstatus`, `eCodPerfil`, `bAll`) VALUES
(1, NULL, 'Mario Ernesto', 'Basurto Medrano', 'babec.soluciones@gmail.com', 'MjgwMjkx', 'MjgwMjkx', '2018-07-29 00:00:00', 3, 1, 1),
(21, NULL, 'Mario E.', 'Basurto L.', 'ebasurtol@basmesa.com.mx', 'bWVzYWJhNjE=', 'bWVzYWJhNjE=', '2019-08-16 18:30:28', 3, 1, 1),
(22, NULL, 'Ma. de los ÃƒÂngeles', 'Medrano SÃƒÂ¡nchez', 'angelesmedranos@hotmail.com', 'YW5nZWxlc21lZHJhbm9z', 'aHR0cDovL3NnZS5zZGliYWJlYy5jb20vaW1hZ2VzL2ljb24vbG9nby5wbmc=', '2019-08-16 18:31:12', 3, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `SisVariables`
--

DROP TABLE IF EXISTS `SisVariables`;
CREATE TABLE `SisVariables` (
  `eCodVariable` int(11) NOT NULL,
  `tNombre` varchar(50) NOT NULL,
  `tValor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `SisVariables`
--

INSERT INTO `SisVariables` (`eCodVariable`, `tNombre`, `tValor`) VALUES
(1, 'tURL', 'http://sge.sdibabec.com/');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `BitEventos`
--
ALTER TABLE `BitEventos`
  ADD PRIMARY KEY (`eCodEvento`);

--
-- Indices de la tabla `BitTransacciones`
--
ALTER TABLE `BitTransacciones`
  ADD PRIMARY KEY (`eCodTransaccion`);

--
-- Indices de la tabla `CatCamionetas`
--
ALTER TABLE `CatCamionetas`
  ADD PRIMARY KEY (`eCodCamioneta`);

--
-- Indices de la tabla `CatClientes`
--
ALTER TABLE `CatClientes`
  ADD PRIMARY KEY (`eCodCliente`),
  ADD KEY `cliente_rel_estatus_fk_idx` (`eCodEstatus`);

--
-- Indices de la tabla `CatCombos`
--
ALTER TABLE `CatCombos`
  ADD PRIMARY KEY (`eCodCombo`);

--
-- Indices de la tabla `CatEstatus`
--
ALTER TABLE `CatEstatus`
  ADD PRIMARY KEY (`eCodEstatus`),
  ADD UNIQUE KEY `tCodEstatus_UNIQUE` (`tCodEstatus`);

--
-- Indices de la tabla `CatInventario`
--
ALTER TABLE `CatInventario`
  ADD PRIMARY KEY (`eCodInventario`);

--
-- Indices de la tabla `CatServicios`
--
ALTER TABLE `CatServicios`
  ADD PRIMARY KEY (`eCodServicio`);

--
-- Indices de la tabla `CatTiposInventario`
--
ALTER TABLE `CatTiposInventario`
  ADD PRIMARY KEY (`eCodTipoInventario`);

--
-- Indices de la tabla `CatTiposPagos`
--
ALTER TABLE `CatTiposPagos`
  ADD PRIMARY KEY (`eCodTipoPago`);

--
-- Indices de la tabla `CatTiposSecciones`
--
ALTER TABLE `CatTiposSecciones`
  ADD PRIMARY KEY (`eCodTipoSeccion`);

--
-- Indices de la tabla `RelNegociosAfiliadosGaleria`
--
ALTER TABLE `RelNegociosAfiliadosGaleria`
  ADD PRIMARY KEY (`eCodRegistro`);

--
-- Indices de la tabla `SisBotones`
--
ALTER TABLE `SisBotones`
  ADD PRIMARY KEY (`tCodBoton`);

--
-- Indices de la tabla `SisLogs`
--
ALTER TABLE `SisLogs`
  ADD PRIMARY KEY (`eCodEvento`);

--
-- Indices de la tabla `SisPerfiles`
--
ALTER TABLE `SisPerfiles`
  ADD PRIMARY KEY (`eCodPerfil`);

--
-- Indices de la tabla `SisRegistrosCargas`
--
ALTER TABLE `SisRegistrosCargas`
  ADD PRIMARY KEY (`eCodRegistro`);

--
-- Indices de la tabla `SisSecciones`
--
ALTER TABLE `SisSecciones`
  ADD PRIMARY KEY (`tCodSeccion`);

--
-- Indices de la tabla `SisSeccionesBotones`
--
ALTER TABLE `SisSeccionesBotones`
  ADD PRIMARY KEY (`eCodRegistro`),
  ADD KEY `tCodPadre_rel_fk_botones_idx` (`tCodPadre`),
  ADD KEY `tCodBoton_rel_fk_botones_idx` (`tCodBoton`);

--
-- Indices de la tabla `SisSeccionesMenusEmergentes`
--
ALTER TABLE `SisSeccionesMenusEmergentes`
  ADD PRIMARY KEY (`eCodMenuEmergente`);

--
-- Indices de la tabla `SisSeccionesPerfiles`
--
ALTER TABLE `SisSeccionesPerfiles`
  ADD KEY `perfil_rel_seccion_fk_idx` (`eCodPerfil`),
  ADD KEY `seccion_rel_perfil_idx` (`tCodSeccion`);

--
-- Indices de la tabla `SisSeccionesReemplazos`
--
ALTER TABLE `SisSeccionesReemplazos`
  ADD PRIMARY KEY (`eCodReemplazo`);

--
-- Indices de la tabla `SisUsuarios`
--
ALTER TABLE `SisUsuarios`
  ADD PRIMARY KEY (`eCodUsuario`),
  ADD KEY `SisUsuarios_rel_perfiles_fk_idx` (`eCodPerfil`),
  ADD KEY `CatEstatus_rel_usuarios_fk_idx` (`eCodEstatus`);

--
-- Indices de la tabla `SisVariables`
--
ALTER TABLE `SisVariables`
  ADD PRIMARY KEY (`eCodVariable`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `BitEventos`
--
ALTER TABLE `BitEventos`
  MODIFY `eCodEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `BitTransacciones`
--
ALTER TABLE `BitTransacciones`
  MODIFY `eCodTransaccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;

--
-- AUTO_INCREMENT de la tabla `CatCamionetas`
--
ALTER TABLE `CatCamionetas`
  MODIFY `eCodCamioneta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `CatClientes`
--
ALTER TABLE `CatClientes`
  MODIFY `eCodCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `CatCombos`
--
ALTER TABLE `CatCombos`
  MODIFY `eCodCombo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `CatEstatus`
--
ALTER TABLE `CatEstatus`
  MODIFY `eCodEstatus` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `CatInventario`
--
ALTER TABLE `CatInventario`
  MODIFY `eCodInventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `CatServicios`
--
ALTER TABLE `CatServicios`
  MODIFY `eCodServicio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `CatTiposInventario`
--
ALTER TABLE `CatTiposInventario`
  MODIFY `eCodTipoInventario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `CatTiposPagos`
--
ALTER TABLE `CatTiposPagos`
  MODIFY `eCodTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `CatTiposSecciones`
--
ALTER TABLE `CatTiposSecciones`
  MODIFY `eCodTipoSeccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `RelNegociosAfiliadosGaleria`
--
ALTER TABLE `RelNegociosAfiliadosGaleria`
  MODIFY `eCodRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `SisLogs`
--
ALTER TABLE `SisLogs`
  MODIFY `eCodEvento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `SisPerfiles`
--
ALTER TABLE `SisPerfiles`
  MODIFY `eCodPerfil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `SisRegistrosCargas`
--
ALTER TABLE `SisRegistrosCargas`
  MODIFY `eCodRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `SisSeccionesBotones`
--
ALTER TABLE `SisSeccionesBotones`
  MODIFY `eCodRegistro` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `SisSeccionesMenusEmergentes`
--
ALTER TABLE `SisSeccionesMenusEmergentes`
  MODIFY `eCodMenuEmergente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `SisSeccionesReemplazos`
--
ALTER TABLE `SisSeccionesReemplazos`
  MODIFY `eCodReemplazo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `SisUsuarios`
--
ALTER TABLE `SisUsuarios`
  MODIFY `eCodUsuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `SisVariables`
--
ALTER TABLE `SisVariables`
  MODIFY `eCodVariable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `SisSeccionesBotones`
--
ALTER TABLE `SisSeccionesBotones`
  ADD CONSTRAINT `tCodBoton_rel_fk_botones` FOREIGN KEY (`tCodBoton`) REFERENCES `SisBotones` (`tCodBoton`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `tCodPadre_rel_fk_botones` FOREIGN KEY (`tCodPadre`) REFERENCES `SisSecciones` (`tCodSeccion`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Filtros para la tabla `SisSeccionesPerfiles`
--
ALTER TABLE `SisSeccionesPerfiles`
  ADD CONSTRAINT `perfil_rel_seccion_fk` FOREIGN KEY (`eCodPerfil`) REFERENCES `SisPerfiles` (`eCodPerfil`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `seccion_rel_perfil` FOREIGN KEY (`tCodSeccion`) REFERENCES `SisSecciones` (`tCodSeccion`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
