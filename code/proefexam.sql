-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2025 at 11:00 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proefexam`
--

-- --------------------------------------------------------

--
-- Table structure for table `kandidaten`
--

CREATE TABLE `kandidaten` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `partij` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kandidaten`
--

INSERT INTO `kandidaten` (`id`, `naam`, `partij`) VALUES
(3, 'Jan', 'Democratische'),
(4, 'Maria', 'Groene Partij'),
(5, 'Pieter ', 'Progressieve'),
(6, 'Lisa', 'Conservatieve'),
(7, 'Ahmed', 'Arbeiderspartij'),
(8, 'Ahmed', 'Arbeiderspartij');

-- --------------------------------------------------------

--
-- Table structure for table `stemmen`
--

CREATE TABLE `stemmen` (
  `id` int(11) NOT NULL,
  `verkiezing_id` int(11) DEFAULT NULL,
  `kandidaat_id` int(11) DEFAULT NULL,
  `stem_tijd` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stemmen`
--

INSERT INTO `stemmen` (`id`, `verkiezing_id`, `kandidaat_id`, `stem_tijd`) VALUES
(1, 8, 4, '2025-01-24 20:57:02'),
(2, 8, 5, '2025-01-24 20:57:51'),
(3, 8, 4, '2025-01-24 20:58:19'),
(4, 8, 4, '2025-01-24 20:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `verkiezing`
--

CREATE TABLE `verkiezing` (
  `id` int(11) NOT NULL,
  `datum` date NOT NULL,
  `beschrijving` text DEFAULT NULL,
  `kandidaat_id` int(11) DEFAULT NULL,
  `naam` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verkiezing`
--

INSERT INTO `verkiezing` (`id`, `datum`, `beschrijving`, `kandidaat_id`, `naam`) VALUES
(8, '2025-01-26', 'TEST1', NULL, 'TEST1');

-- --------------------------------------------------------

--
-- Table structure for table `verkiezing_kandidaten`
--

CREATE TABLE `verkiezing_kandidaten` (
  `verkiezing_id` int(11) NOT NULL,
  `kandidaat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `verkiezing_kandidaten`
--

INSERT INTO `verkiezing_kandidaten` (`verkiezing_id`, `kandidaat_id`) VALUES
(8, 4),
(8, 5),
(8, 6),
(8, 8);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kandidaten`
--
ALTER TABLE `kandidaten`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stemmen`
--
ALTER TABLE `stemmen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `verkiezing_id` (`verkiezing_id`),
  ADD KEY `kandidaat_id` (`kandidaat_id`);

--
-- Indexes for table `verkiezing`
--
ALTER TABLE `verkiezing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kandidaat` (`kandidaat_id`);

--
-- Indexes for table `verkiezing_kandidaten`
--
ALTER TABLE `verkiezing_kandidaten`
  ADD PRIMARY KEY (`verkiezing_id`,`kandidaat_id`),
  ADD KEY `kandidaat_id` (`kandidaat_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kandidaten`
--
ALTER TABLE `kandidaten`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `stemmen`
--
ALTER TABLE `stemmen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `verkiezing`
--
ALTER TABLE `verkiezing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stemmen`
--
ALTER TABLE `stemmen`
  ADD CONSTRAINT `stemmen_ibfk_1` FOREIGN KEY (`verkiezing_id`) REFERENCES `verkiezing` (`id`),
  ADD CONSTRAINT `stemmen_ibfk_2` FOREIGN KEY (`kandidaat_id`) REFERENCES `kandidaten` (`id`);

--
-- Constraints for table `verkiezing`
--
ALTER TABLE `verkiezing`
  ADD CONSTRAINT `verkiezing_ibfk_1` FOREIGN KEY (`kandidaat_id`) REFERENCES `kandidaten` (`id`);

--
-- Constraints for table `verkiezing_kandidaten`
--
ALTER TABLE `verkiezing_kandidaten`
  ADD CONSTRAINT `verkiezing_kandidaten_ibfk_1` FOREIGN KEY (`verkiezing_id`) REFERENCES `verkiezing` (`id`),
  ADD CONSTRAINT `verkiezing_kandidaten_ibfk_2` FOREIGN KEY (`kandidaat_id`) REFERENCES `kandidaten` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
