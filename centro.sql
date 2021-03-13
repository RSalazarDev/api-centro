-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 13, 2021 at 11:31 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `centro`
--

-- --------------------------------------------------------

--
-- Table structure for table `cita`
--

CREATE TABLE `cita` (
  `id` int(11) NOT NULL,
  `medico_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cita`
--

INSERT INTO `cita` (`id`, `medico_id`, `usuario_id`, `fecha`, `estado`) VALUES
(1, 8, 1, '2021-03-17', 'Activa'),
(2, 7, 1, '2021-03-25', 'Activa'),
(3, 9, 1, '2021-03-10', 'Activa'),
(6, 10, 1, '2021-05-11', 'Activa');

-- --------------------------------------------------------

--
-- Table structure for table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210311195744', '2021-03-11 20:58:03', 286);

-- --------------------------------------------------------

--
-- Table structure for table `especialidad`
--

CREATE TABLE `especialidad` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `especialidad`
--

INSERT INTO `especialidad` (`id`, `nombre`) VALUES
(1, 'Alergología'),
(2, 'Anatomía Patológica'),
(3, 'Anestesiología y Reanimación \r\n'),
(4, 'Cardiología'),
(5, 'Cirugía Torácica'),
(6, 'Geriatría '),
(7, 'Neumología'),
(8, 'Neurología'),
(9, 'Oftalmología'),
(10, 'Psiquiatría '),
(11, 'Urología'),
(12, 'Oncología');

-- --------------------------------------------------------

--
-- Table structure for table `medico`
--

CREATE TABLE `medico` (
  `id` int(11) NOT NULL,
  `especialidad_id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `medico`
--

INSERT INTO `medico` (`id`, `especialidad_id`, `nombre`, `apellidos`) VALUES
(1, 1, 'Alfredo', 'Gonzalez Elche'),
(2, 2, 'Marta', 'Calvo Andorra'),
(3, 3, 'Jorge', 'Alvarez Manzano'),
(4, 4, 'Sandra', 'Prueba Alejo'),
(5, 5, 'Marta', 'Area Ande'),
(6, 6, 'Francisco', 'Roman Alve'),
(7, 7, 'Nuria', 'González González'),
(8, 8, 'Daniel', 'Pérez Jiménez'),
(9, 9, 'Carmen', 'Hernández Dimin'),
(10, 10, 'Raquel', 'Romero Navarro'),
(11, 11, 'Manuel', 'Torres Torres'),
(12, 12, 'Alfredo', 'Ramos Bedoya');

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(9) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seguridad_social` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `roles`, `password`, `nombre`, `apellidos`, `telefono`, `seguridad_social`) VALUES
(1, 'ccc@gmail.com', '[]', '$2y$10$WvenZR.ug161OXLgq.5BruBZo5IdhD8myCGXFXjSMBNRFxdW287iq', 'cccd', 'cddd', '6563353', '314151351'),
(2, 'usu@gmail.com', '[]', '$2y$10$dJ35teZPu1SpxnJe/GOCqOTzNhpDlWiO2PVypngyfd1F3O6EN3tZK', 'usu', 'ssdaxda', '76646464', '764374574'),
(3, 'editado@gmail.com', '[]', '$2y$10$Pcr3ptJic9MfMApbXMJLHunGwIi.MLAxE6zVrsYKIjmHozueLfQyC', 'editado', 'edit', '6542332', '7426262457'),
(4, 'nuevo@gmail.com', '[]', '$2y$10$0ts4NphC24uwB4KjUYNd4.bHIsEZiMWHlm1R07vhc35nC5IBvo.X2', 'aaaa', 'bbbb', '656353', '65337373'),
(5, 'estoyactu@gmail.com', '[]', '$2y$10$XfePoaTYTSQYTexy3.DskOictxNyPmBWuiDm/nOAMjx3Nizo9hHKi', 'actu', 'actu', '63432333', '4763373577');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cita`
--
ALTER TABLE `cita`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_3E379A62A7FB1C0C` (`medico_id`),
  ADD KEY `IDX_3E379A62DB38439E` (`usuario_id`);

--
-- Indexes for table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `especialidad`
--
ALTER TABLE `especialidad`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `medico`
--
ALTER TABLE `medico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_34E5914C16A490EC` (`especialidad_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_2265B05DE7927C74` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cita`
--
ALTER TABLE `cita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `especialidad`
--
ALTER TABLE `especialidad`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `medico`
--
ALTER TABLE `medico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cita`
--
ALTER TABLE `cita`
  ADD CONSTRAINT `FK_3E379A62A7FB1C0C` FOREIGN KEY (`medico_id`) REFERENCES `medico` (`id`),
  ADD CONSTRAINT `FK_3E379A62DB38439E` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`);

--
-- Constraints for table `medico`
--
ALTER TABLE `medico`
  ADD CONSTRAINT `FK_34E5914C16A490EC` FOREIGN KEY (`especialidad_id`) REFERENCES `especialidad` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
