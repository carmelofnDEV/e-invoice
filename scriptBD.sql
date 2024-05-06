-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Tiempo de generación: 06-05-2024 a las 11:20:18
-- Versión del servidor: 11.3.2-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `facturas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_access_token`
--

CREATE TABLE `itt_access_token` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `checker` varchar(500) NOT NULL,
  `user_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `token_valid` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_account`
--

CREATE TABLE `itt_account` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `tradename` varchar(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `NIF` varchar(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `zip` int(10) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `category` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_accountuser`
--

CREATE TABLE `itt_accountuser` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_customer`
--

CREATE TABLE `itt_customer` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NOT NULL,
  `account_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `NIF` varchar(11) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `type` varchar(1) DEFAULT NULL,
  `category` varchar(1) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) NOT NULL,
  `search` longtext NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_invoice`
--

CREATE TABLE `itt_invoice` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NOT NULL,
  `issuer_id` int(11) NOT NULL,
  `recipient_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `invoice_state` int(11) NOT NULL,
  `serial_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `NIF` varchar(20) NOT NULL,
  `category` varchar(1) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address1` varchar(50) NOT NULL,
  `address2` varchar(50) DEFAULT NULL,
  `country` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `zip` int(8) NOT NULL,
  `state` varchar(20) NOT NULL,
  `total` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `search` varchar(500) NOT NULL,
  `invoice_date` varchar(50) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `invoice_terms` varchar(500) NOT NULL,
  `name` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_invoice_item`
--

CREATE TABLE `itt_invoice_item` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NOT NULL,
  `id_item` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `invoice_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_invoice_item_tax`
--

CREATE TABLE `itt_invoice_item_tax` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `invoice_item_id` int(11) NOT NULL,
  `tax_id` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `tax_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_product`
--

CREATE TABLE `itt_product` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `title` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `search` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_serial`
--

CREATE TABLE `itt_serial` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `serial_tag` varchar(20) NOT NULL,
  `serial_number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_tax`
--

CREATE TABLE `itt_tax` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `name` varchar(20) NOT NULL,
  `value` varchar(11) NOT NULL,
  `search` varchar(50) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itt_user`
--

CREATE TABLE `itt_user` (
  `id` int(11) NOT NULL,
  `id2` varchar(50) NOT NULL,
  `created` timestamp NOT NULL,
  `updated` timestamp NULL DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `itt_access_token`
--
ALTER TABLE `itt_access_token`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_account`
--
ALTER TABLE `itt_account`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_accountuser`
--
ALTER TABLE `itt_accountuser`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `itt_customer`
--
ALTER TABLE `itt_customer`
  ADD PRIMARY KEY (`id`,`updated`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_invoice`
--
ALTER TABLE `itt_invoice`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`),
  ADD UNIQUE KEY `id2_2` (`id2`);

--
-- Indices de la tabla `itt_invoice_item`
--
ALTER TABLE `itt_invoice_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_invoice_item_tax`
--
ALTER TABLE `itt_invoice_item_tax`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_product`
--
ALTER TABLE `itt_product`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_serial`
--
ALTER TABLE `itt_serial`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `itt_tax`
--
ALTER TABLE `itt_tax`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`);

--
-- Indices de la tabla `itt_user`
--
ALTER TABLE `itt_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id2` (`id2`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `itt_access_token`
--
ALTER TABLE `itt_access_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_account`
--
ALTER TABLE `itt_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_accountuser`
--
ALTER TABLE `itt_accountuser`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_customer`
--
ALTER TABLE `itt_customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_invoice`
--
ALTER TABLE `itt_invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_invoice_item`
--
ALTER TABLE `itt_invoice_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_invoice_item_tax`
--
ALTER TABLE `itt_invoice_item_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_product`
--
ALTER TABLE `itt_product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_serial`
--
ALTER TABLE `itt_serial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_tax`
--
ALTER TABLE `itt_tax`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `itt_user`
--
ALTER TABLE `itt_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
