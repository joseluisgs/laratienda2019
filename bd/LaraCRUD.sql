-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 22-02-2019 a las 23:13:01
-- Versión del servidor: 10.1.37-MariaDB
-- Versión de PHP: 7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `LaraCRUD`
--
CREATE DATABASE IF NOT EXISTS `LaraCRUD` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
USE `LaraCRUD`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carritos`
--

DROP TABLE IF EXISTS `carritos`;
CREATE TABLE IF NOT EXISTS `carritos` (
  `identifier` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `instance` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `content` longtext COLLATE utf8_spanish_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`identifier`,`instance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `envios`
--

DROP TABLE IF EXISTS `envios`;
CREATE TABLE IF NOT EXISTS `envios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `provincia` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `codigoPostal` int(11) NOT NULL,
  `telefono` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `venta_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `envios_venta_id_foreign` (`venta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `envios`
--

INSERT INTO `envios` (`id`, `nombre`, `direccion`, `ciudad`, `provincia`, `codigoPostal`, `telefono`, `email`, `venta_id`, `created_at`, `updated_at`) VALUES
(1, 'José Josinez', 'C/ Flamequón, 24- 5-izq', 'Córdoba', 'Córdoba', 14008, 666789878, 'pepe@pepe.com', 1, '2019-02-20 08:21:55', '2019-02-20 08:21:55'),
(2, 'Marta Martínez', 'C/ Pepilandia, 2-3', 'Pepilón', 'Pepinos', 66666, 666666666, 'marta@marta.com', 2, '2019-02-20 08:27:34', '2019-02-20 08:27:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `linea_ventas`
--

DROP TABLE IF EXISTS `linea_ventas`;
CREATE TABLE IF NOT EXISTS `linea_ventas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `venta_id` int(10) UNSIGNED NOT NULL,
  `producto` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `precio` double(8,2) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `total` double(8,2) NOT NULL,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `linea_ventas_venta_id_foreign` (`venta_id`),
  KEY `linea_ventas_producto_id_foreign` (`producto_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `linea_ventas`
--

INSERT INTO `linea_ventas` (`id`, `venta_id`, `producto`, `precio`, `cantidad`, `total`, `producto_id`, `created_at`, `updated_at`) VALUES
(1, 1, 'The Legend of Zelda: Breath of the Wild', 53.89, 1, 53.89, 1, '2019-02-20 08:21:55', '2019-02-20 08:21:55'),
(2, 1, 'Nintendo Switch  Azul Neón/Rojo Neón', 308.99, 1, 308.99, 2, '2019-02-20 08:21:55', '2019-02-20 08:21:55'),
(3, 2, 'Playstation 4 White Edition', 289.90, 1, 289.90, 4, '2019-02-20 08:27:34', '2019-02-20 08:27:34'),
(4, 2, 'God of War 4', 55.95, 1, 55.95, 3, '2019-02-20 08:27:34', '2019-02-20 08:27:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_01_31_182119_create_productos_table', 1),
(4, '2019_02_14_084602_add_stock_to_productos_table', 2),
(5, '2019_02_14_104209_create_shoppingcart_table', 3),
(6, '2019_02_18_094508_create_ventas_table', 3),
(7, '2019_02_18_121039_create_pagos_table', 3),
(8, '2019_02_18_130028_create_envios_table', 3),
(9, '2019_02_18_132802_create_linea_ventas_table', 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

DROP TABLE IF EXISTS `pagos`;
CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titular` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` enum('Visa','MasterCard','AmericanExpress','Discover','PayPal') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Visa',
  `numero` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `cvv` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `mes` int(11) NOT NULL,
  `año` int(11) NOT NULL,
  `venta_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pagos_venta_id_foreign` (`venta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `titular`, `tipo`, `numero`, `cvv`, `mes`, `año`, `venta_id`, `created_at`, `updated_at`) VALUES
(1, 'José Padre', 'Visa', '5678', '345', 5, 25, 1, '2019-02-20 08:21:55', '2019-02-20 08:21:55'),
(2, 'Rosa Gladiolo Clavel', 'Visa', '4567', '777', 6, 21, 2, '2019-02-20 08:27:34', '2019-02-20 08:27:34');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('pepe@pepe.com', '$2y$10$ZCUWvQDREhMyiPN0oKYwiOX9E.dO7YyT2CBwPNW//bt0b.nEUCDAa', '2019-02-07 09:33:09'),
('joseluisgs@me.com', '$2y$10$oSHzimsR51Co3Lgbz8OWAuWiI2Z0US7lMMLsC18eZ3rzSkZsNSt6q', '2019-02-21 20:37:44');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

DROP TABLE IF EXISTS `productos`;
CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `modelo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `precio` double(8,2) NOT NULL,
  `tipo` enum('juego','consola') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'juego',
  `stock` int(10) UNSIGNED NOT NULL DEFAULT '1',
  `imagen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `marca`, `modelo`, `precio`, `tipo`, `stock`, `imagen`, `created_at`, `updated_at`) VALUES
(1, 'Nintendo', 'The Legend of Zelda: Breath of the Wild', 53.89, 'juego', 20, 'storage/f5ytTizzP1FWRfyXvjuf8oyIe1BkTVZ2Bns4narq.jpeg', '2019-02-04 19:29:00', '2019-02-20 08:21:55'),
(2, 'Nintendo', 'Nintendo Switch  Azul Neón/Rojo Neón', 308.99, 'consola', 20, 'storage/CqfQs7qUJ6he7DBfKqgxwhEtFIaPPMKnHRbpv98d.jpeg', '2019-02-04 19:29:00', '2019-02-20 08:21:55'),
(3, 'Sony', 'God of War 4', 55.95, 'juego', 20, 'storage/8VfbylKOtbT2c62lhgBWgMAcflSeLpwJsPNfnk7d.jpeg', '2019-02-04 19:32:11', '2019-02-22 22:10:02'),
(4, 'Sony', 'Playstation 4 White Edition', 289.90, 'consola', 20, 'storage/qhFcn5J7QTJ6icqV3kyyEJu0vwOcTszSbpaT6oDm.jpeg', '2019-02-04 19:33:53', '2019-02-22 19:47:51'),
(5, 'Nintendo', 'Super Mario Odissey', 42.39, 'juego', 20, 'storage/YqT6Y0FlKgIBflKWXoIwocQSsx7w5l1yLslma41Y.jpeg', '2019-02-14 08:31:11', '2019-02-14 08:35:11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tipo` enum('normal','admin') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal',
  `imagen` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `tipo`, `imagen`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'pepe', 'pepe@pepe.com', NULL, '$2y$10$PAoQJNKuqbF1KOsH1eT6r.kcvbR.8bp/xJXGa00Hhjeml3wyHlk2u', 'admin', 'storage/Ij8GSUFISUilu3abNr9i1JQ1NumNn6GJvP3voQl9.jpeg', '4781tVSLYt6yDaAbMj9kVw4qPyJ9Z9ZRFG5G0FGmg1ANyFCOnjGzENHIvoPs', NULL, '2019-02-07 12:56:01'),
(2, 'maria', 'maria@maria.com', NULL, '$2y$10$JLqFh.fc.sOg2sFQRg/iCOh7G7CuZJu.KoieVSTgSphRT2qRYqTBu', 'normal', 'storage/iYVRj4YvEIj1ow13bSYFgeIYfHp3fsqVhzNKkfiY.jpeg', 'eoJaUKdmn54324oMQ8xN59QwtWMp9Rk2FcB18qq2hV6cbBmRekv0mVORfT21', NULL, '2019-02-04 12:48:10'),
(3, 'marta', 'marta@marta.com', NULL, '$2y$10$u1dD2OxzIFOxY57RKQ0ZwOcjhEKQOtwSvzBacHhVLyuqoZ5G/Bkie', 'admin', 'storage/ElyaIwY8fUeJiG6WEiUF7ggOrBS6V47nmaSkLItd.jpeg', 'BIosTkifOVNsQe1WjvTcqIU1xS5v8NgkkuTAQzweo0LI7G7O6DIZVJoQVyx7', '2019-02-03 13:11:22', '2019-02-04 12:48:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ventas`
--

DROP TABLE IF EXISTS `ventas`;
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codigo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `total` double(8,2) NOT NULL,
  `subtotal` double(8,2) NOT NULL,
  `iva` double(8,2) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ventas_codigo_unique` (`codigo`),
  KEY `ventas_user_id_foreign` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ventas`
--

INSERT INTO `ventas` (`id`, `codigo`, `fecha`, `total`, `subtotal`, `iva`, `user_id`, `created_at`, `updated_at`) VALUES
(1, '1-1550650915-20190220', '2019-02-20 09:21:55', 362.88, 299.90, 62.98, 1, '2019-02-20 08:21:55', '2019-02-20 08:21:55'),
(2, '3-1550651254-20190220', '2019-02-20 09:27:34', 345.85, 285.83, 60.02, 3, '2019-02-20 08:27:34', '2019-02-20 08:27:34');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `envios`
--
ALTER TABLE `envios`
  ADD CONSTRAINT `envios_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `linea_ventas`
--
ALTER TABLE `linea_ventas`
  ADD CONSTRAINT `linea_ventas_producto_id_foreign` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`id`),
  ADD CONSTRAINT `linea_ventas_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_venta_id_foreign` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `ventas`
--
ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
