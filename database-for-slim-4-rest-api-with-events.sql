-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 16-08-2021 a las 13:56:23
-- Versión del servidor: 10.4.20-MariaDB
-- Versión de PHP: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `database-for-slim-4-rest-api`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `items`
--

CREATE TABLE `items` (
  `id_item` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `items`
--

INSERT INTO `items` (`id_item`, `item_name`) VALUES
(1, 'item1'),
(2, 'item2'),
(3, 'item3');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `session_token` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `user_name`, `user_email`, `user_password`, `session_token`) VALUES
(1, 'fran', 'valid@valid.com', '81dc9bdb52d04dc20036dbd8313ed055', NULL),
(2, 'fran', 'prietofranc@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '6b4b80ea579f115db250b0530b57fd9d'),
(3, 'aaaaaa', 'tritir@hh.com', 'e10adc3949ba59abbe56e057f20f883e', '4e04df250e72bb9366b44710cd4c25e2'),
(4, 'JUANTXOa', 'valid2@valid.com', '25d55ad283aa400af464c76d713c07ad', '847fdab90fc66cafdeea3a5e87d57f2e');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id_item`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `items`
--
ALTER TABLE `items`
  MODIFY `id_item` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `reset-items` ON SCHEDULE EVERY 1 DAY STARTS '2021-08-16 13:17:13' ON COMPLETION PRESERVE ENABLE DO TRUNCATE TABLE items$$

CREATE DEFINER=`root`@`localhost` EVENT `create-items` ON SCHEDULE EVERY 1 DAY STARTS '2021-08-16 13:18:04' ON COMPLETION PRESERVE ENABLE DO INSERT INTO items (item_name)
 VALUES ("item1"),
("item2"),
("item3")$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
