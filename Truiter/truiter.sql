-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 18-11-2022 a las 20:08:23
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `truiter`
--
CREATE DATABASE IF NOT EXISTS `truiter` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `truiter`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `width` int(11) NOT NULL,
  `alt_text` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `tweet_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `media`
--

INSERT INTO `media` (`id`, `height`, `width`, `alt_text`, `url`, `tweet_id`) VALUES
(6, 1440, 2560, '6376632aa3f78.jpg', 'uploads/6376632aa3f78.jpg', 11),
(7, 1440, 2560, '6376632aa412d.jpg', 'uploads/6376632aa412d.jpg', 11),
(8, 1100, 1048, '637663aa90625.jpg', 'uploads/637663aa90625.jpg', 12);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tweet`
--

CREATE TABLE `tweet` (
  `id` int(11) NOT NULL,
  `text` varchar(280) NOT NULL,
  `author_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `like_count` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tweet`
--

INSERT INTO `tweet` (`id`, `text`, `author_id`, `created_at`, `like_count`) VALUES
(1, 'Hola món!', 3, '2022-11-15 00:00:00', 1),
(3, 'Normalmente no rezo, pero si estás ahí, por favor, sálvame Superman.', 2, '2022-11-15 00:00:00', 2),
(4, 'Hay dos tipos de estudiantes: los fuertes y los gilis. ¡Como atleta es mi deber hacerle la vida imposible a los gilis! ', 2, '2022-11-15 00:00:00', 3),
(5, 'Multiplícate por cero tío te has hecho amigos de los gilís', 1, '2022-11-15 00:00:00', 3),
(11, 'Foto de Hogwarts Legacy i de NY', 3, '2022-11-17 00:00:00', 2),
(12, 'Foto de quan era jove', 7, '2022-11-17 00:00:00', 3),
(13, 'Un espartà mai deixa que l&#39;esquena toqui terra.', 7, '2022-11-17 00:00:00', 2),
(14, 'Si algo hemos aprendido de los Picapiedra es que los pelícanos sirven para mezclar cemento', 2, '2022-11-18 19:58:29', 2),
(15, 'Por la cerveza: causa y solución de todos los problemas', 2, '2022-11-18 20:00:05', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(15) NOT NULL,
  `created_at` date NOT NULL,
  `password` varchar(255) NOT NULL,
  `verified` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `name`, `username`, `created_at`, `password`, `verified`) VALUES
(1, 'Bart', 'bart', '2022-11-14', '$2a$12$bXReqFTRCWqU713YVRmEuujciyLbQOOmqeFVFROBwqZMjspBt6AdC', 1),
(2, 'Homer', 'homer', '2022-11-14', '$2a$12$TdjuA7yPfiQGyH88GDrCHO4xP6REXWhglbJvp/gD/VqRwW3CqNfFa', 0),
(3, 'Carlos', 'carlos', '2022-11-14', '$2a$12$Pyjrc8lsJDYe1MneZtJSaezp.at.KmosPlG7OVJVfJ9KQGPWLlQ7m', 1),
(4, 'admin', 'admin', '2022-11-14', '$2a$12$b4CerRMg7Oq61uQo3kbWkeiPpgOCHxSu.es8wPYDSGoDbdTogwHVO', 0),
(7, 'Kratos', 'kratos', '2022-11-17', '$2y$10$WYIqKqApvpYbvfzxOR808OpsefPRMcfvlIJno4H.Uop.iCYwBgcxy', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tweet_id` (`tweet_id`);

--
-- Indices de la tabla `tweet`
--
ALTER TABLE `tweet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `tweet`
--
ALTER TABLE `tweet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`tweet_id`) REFERENCES `tweet` (`id`);

--
-- Filtros para la tabla `tweet`
--
ALTER TABLE `tweet`
  ADD CONSTRAINT `tweet_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
