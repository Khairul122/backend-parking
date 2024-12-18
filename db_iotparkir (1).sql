-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 18, 2024 at 02:55 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_iotparkir`
--

-- --------------------------------------------------------

--
-- Table structure for table `parkir`
--

CREATE TABLE `parkir` (
  `id` int NOT NULL,
  `id_parkir` varchar(50) NOT NULL,
  `status` varchar(20) NOT NULL,
  `plat_nomor` varchar(20) NOT NULL,
  `waktu_mulai` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `durasi` int DEFAULT NULL,
  `biaya` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id`, `id_parkir`, `status`, `plat_nomor`, `waktu_mulai`, `waktu_selesai`, `durasi`, `biaya`) VALUES
(262, 'ULTRASONIC_01', 'Tidak Parkir', 'BA 1010 AB', '2024-12-18 14:47:55', '2024-12-18 14:48:22', 27, 2000),
(263, 'ULTRASONIC_01', 'Tidak Parkir', 'BA 1010 AB', '2024-12-18 14:48:00', '2024-12-18 14:48:16', 16, 2000),
(264, 'ULTRASONIC_01', 'Tidak Parkir', 'BA 1010 AB', '2024-12-18 14:48:05', '2024-12-18 14:48:11', 6, 2000),
(265, 'ULTRASONIC_01', 'Tidak Parkir', 'BA 1010 AB', '2024-12-18 14:48:49', '2024-12-18 14:48:54', 5, 2000),
(266, 'ULTRASONIC_01', 'Tidak Parkir', 'BA 1010 AB', '2024-12-18 14:54:00', '2024-12-18 14:54:05', 5, 2000);

-- --------------------------------------------------------

--
-- Table structure for table `servo`
--

CREATE TABLE `servo` (
  `id_servo` int NOT NULL,
  `nama_servo` varchar(30) NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `servo`
--

INSERT INTO `servo` (`id_servo`, `nama_servo`, `value`) VALUES
(2, '1', 1),
(3, '2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`) VALUES
(2, 'admin', '12345', 'admin@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `parkir`
--
ALTER TABLE `parkir`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `servo`
--
ALTER TABLE `servo`
  ADD PRIMARY KEY (`id_servo`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `parkir`
--
ALTER TABLE `parkir`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT for table `servo`
--
ALTER TABLE `servo`
  MODIFY `id_servo` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
