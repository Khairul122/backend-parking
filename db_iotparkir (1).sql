-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2024 at 11:24 AM
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
  `sensor_id` varchar(50) NOT NULL,
  `status_parkir` enum('Parkir','Tidak Parkir') NOT NULL,
  `status` enum('Proses','Selesai') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `durasi` int DEFAULT NULL,
  `biaya` varchar(11) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `parkir`
--

INSERT INTO `parkir` (`id`, `sensor_id`, `status_parkir`, `status`, `created_at`, `durasi`, `biaya`, `updated_at`) VALUES
(371, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:12:55', NULL, NULL, NULL),
(372, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:12:56', NULL, NULL, NULL),
(373, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:13:17', 21, '2000', '2024-12-19 11:13:19'),
(374, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:13:22', NULL, NULL, NULL),
(375, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:13:27', 2, '2000', '2024-12-19 11:13:28'),
(376, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:13:32', NULL, NULL, NULL),
(377, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:14:52', 2, '2000', '2024-12-19 11:14:55'),
(378, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:14:57', NULL, NULL, NULL),
(379, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:15:14', NULL, NULL, NULL),
(380, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:15:20', 5, '2000', '2024-12-19 11:15:21'),
(381, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:15:24', 20, '2000', '2024-12-19 11:15:27'),
(382, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:15:56', NULL, NULL, NULL),
(383, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:16:13', NULL, NULL, NULL),
(384, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:16:18', NULL, NULL, NULL),
(385, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:16:24', NULL, NULL, NULL),
(386, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:16:29', NULL, NULL, NULL),
(387, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:16:33', 59, '2000', '2024-12-19 11:16:56'),
(388, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:17:05', NULL, NULL, NULL),
(389, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:17:26', 2, '2000', '2024-12-19 11:17:27'),
(390, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:17:58', NULL, NULL, NULL),
(391, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:17:59', NULL, NULL, NULL),
(392, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:18:10', 11, '2000', '2024-12-19 11:18:12'),
(393, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:18:14', 14, '2000', '2024-12-19 11:18:15'),
(394, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:18:20', NULL, NULL, NULL),
(395, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:18:31', 2, '2000', '2024-12-19 11:18:31'),
(396, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:18:47', NULL, NULL, NULL),
(397, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:18:57', 5, '2000', '2024-12-19 11:19:00'),
(398, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:19:01', NULL, NULL, NULL),
(399, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:19:08', NULL, NULL, NULL),
(400, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:19:13', 5, '2000', '2024-12-19 11:19:16'),
(401, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:19:18', NULL, NULL, NULL),
(402, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:19:29', 11, '2000', '2024-12-19 11:19:31'),
(403, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:20:00', 3, '2000', '2024-12-19 11:20:01'),
(404, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:20:05', NULL, NULL, NULL),
(405, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:20:37', NULL, NULL, NULL),
(406, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:20:43', NULL, NULL, NULL),
(407, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:21:09', 2, '2000', '2024-12-19 11:21:12'),
(408, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:21:20', NULL, NULL, NULL),
(409, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:21:36', 2, '2000', '2024-12-19 11:21:39'),
(410, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:22:13', NULL, NULL, NULL),
(411, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:22:14', NULL, NULL, NULL),
(412, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:22:24', 9, '2000', '2024-12-19 11:22:25'),
(413, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:22:30', NULL, NULL, NULL),
(414, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:22:40', 11, '2000', '2024-12-19 11:22:43'),
(415, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:22:46', NULL, NULL, NULL),
(416, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:22:55', 41, '2000', '2024-12-19 11:22:58'),
(417, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:22:57', 8, '2000', '2024-12-19 11:22:58'),
(418, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:23:01', NULL, NULL, NULL),
(419, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:23:02', NULL, NULL, NULL),
(420, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:23:13', 8, '2000', '2024-12-19 11:23:13'),
(421, 'ULTRASONIC_02', 'Parkir', 'Proses', '2024-12-19 18:23:19', NULL, NULL, NULL),
(422, 'ULTRASONIC_02', 'Tidak Parkir', 'Selesai', '2024-12-19 18:23:29', 9, '2000', '2024-12-19 11:23:31'),
(423, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:23:34', 32, '2000', '2024-12-19 11:23:37'),
(424, 'ULTRASONIC_01', 'Parkir', 'Proses', '2024-12-19 18:23:44', NULL, NULL, NULL),
(425, 'ULTRASONIC_01', 'Tidak Parkir', 'Selesai', '2024-12-19 18:24:00', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `servo`
--

CREATE TABLE `servo` (
  `id_servo` int NOT NULL,
  `palang` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `value` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `servo`
--

INSERT INTO `servo` (`id_servo`, `palang`, `value`) VALUES
(2, '1', 1),
(3, '2', 1);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=426;

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
