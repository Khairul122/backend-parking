-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2024 at 08:24 AM
-- Server version: 8.0.30
-- PHP Version: 7.4.3

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
  `plat` varchar(20) NOT NULL,
  `biaya` int NOT NULL,
  `waktu` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id`, `plat`, `biaya`, `waktu`, `status`, `created_at`) VALUES
(1, 'AB123CD', 5000, '2024-12-14 14:00:00', 'masuk', '2024-12-14 07:54:42'),
(2, 'AB123CE', 5000, '2024-12-14 08:14:55', 'masuk', '2024-12-14 08:14:55'),
(3, 'AB123CH', 5000, '2024-12-14 15:21:26', 'masuk', '2024-12-14 08:21:26');

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
