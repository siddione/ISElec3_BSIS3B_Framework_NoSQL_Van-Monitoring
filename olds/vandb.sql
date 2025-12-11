-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 13, 2025 at 11:47 AM
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
-- Database: `vandb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'pauladelapz', 'pau@gmail.com', '0c086cdc772aa579506fd17a735af6e7d14db0ad1d49730c301e007c3e663d36', '2025-04-29 10:37:35'),
(2, 'pipau', 'pipau@gmail.com', '1234', '2025-05-07 04:00:55');

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `driver_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contact_number` varchar(15) DEFAULT NULL,
  `license_number` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_approved` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_picture` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`driver_id`, `name`, `username`, `email`, `contact_number`, `license_number`, `password`, `is_approved`, `created_at`, `profile_picture`) VALUES
(11, 'Paula Bianca Dela Paz', 'pipau', 'dgnkje@gmail.com', '0912354856', '126548949865', '$2y$10$dM52x1elyB5cii0uDcr51eWxjFrGTzcOsyDmv9Cwk.66ZGecYQYoW', 'approved', '2025-04-28 13:19:22', 'driver_681023330f2201.72695670.jpg'),
(12, 'Cardo Dalizay', 'Paula', 'shesh@gmail.com', '09123548562', '15469239', '$2y$10$YWNYujTqdhd0QEfpi7QxoOAgrLKh1kfafTs8vjsQE/31vMcE0Etdu', 'approved', '2025-04-29 00:58:47', 'driver_681026e99e1f78.52120902.png'),
(15, 'Pbdp', 'maria', 'dbhfhs@gmail.com', '0258852', '12365478968', '$2y$10$ppOzAqlrMJeXoIwm4NZot.tlv7lQi0GHEZhse71QZnwJcYpFJ7elO', 'approved', '2025-04-29 10:24:42', 'driver_6810aa38cab206.98536251.jpg'),
(16, 'Annyeong', 'ann', 'ann@gmail.com', '03215445', '1232547', '$2y$10$n.FWi6l6X3JtQo0DfRn3YOayx/QryuQyBRiYsMntcvfgW1wV8oFR.', 'approved', '2025-04-29 21:27:12', NULL),
(19, 'Juliana Maxine', 'max', 'max@gmail.com', '5456465168', '2454124', '$2y$10$glOEhwlwJQeqYphpkT/p5OnvSlHYppDVanng4i84exDQeLoDCNYM.', 'rejected', '2025-04-29 21:39:30', NULL),
(25, 'Yuan Dale Abellano', 'yuan', 'yuan@gmail.com', '096547812', '1254897963', '$2y$10$GKhpye3DmxS1/pf971CmvOXy5OI04aByWsdMwLmVnSBwy253xXv1O', 'pending', '2025-05-09 06:22:43', NULL),
(26, 'Moano Natividad', 'moano', 'moa@gmail.com', '09654872895', '5898536', '$2y$10$FkqJL5zq1.W0Pq/1/JPRnuMTBWui8pibjFVGH7.i7tBhMzR8yhNFm', 'rejected', '2025-05-10 00:02:03', NULL),
(27, 'Cecilia', 'cilia', 'cilia@gmail.com', '09654875654', '254998632', '$2y$10$t3azo74Nk8/0CG9aeksvD..QflPAq9i6lsBrbqPdVhtWN6e3g2T1q', 'pending', '2025-05-10 00:24:19', NULL),
(28, 'Driver Example', 'driver', 'driver@gmail.com', '0965487223', '25469756', '$2y$10$x4bcOOhyUhbzgzmmU76nBOuIQeX/vBYxHx7YuQuKPNXng7NaZyBRe', 'approved', '2025-05-13 08:37:16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vans`
--

CREATE TABLE `vans` (
  `van_id` int(11) NOT NULL,
  `plate_number` varchar(20) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `available_seats` int(11) NOT NULL DEFAULT 0,
  `status` enum('waiting','traveling','arrived','parked') DEFAULT 'waiting',
  `departure_time` datetime DEFAULT NULL,
  `arrival_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vans`
--

INSERT INTO `vans` (`van_id`, `plate_number`, `driver_id`, `available_seats`, `status`, `departure_time`, `arrival_time`) VALUES
(5, 'CVB1234', 11, 9, 'parked', NULL, NULL),
(6, 'BH1234', 12, 18, 'parked', '2025-05-05 16:50:32', '2025-05-05 16:50:37'),
(8, 'BH123', 15, 13, 'traveling', '2025-04-30 05:19:31', NULL),
(9, 'APD18', 16, 14, 'waiting', NULL, NULL),
(11, 'PHSH123', 19, 14, 'arrived', '2025-04-30 06:34:50', '2025-04-30 06:39:30'),
(17, 'PKAJ128', 25, 0, 'waiting', NULL, NULL),
(18, 'LKJ569', 26, 0, 'waiting', NULL, NULL),
(19, 'PKSJ125', 27, 0, 'waiting', NULL, NULL),
(20, 'PAJS487', 28, 18, 'waiting', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`driver_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `license_number` (`license_number`),
  ADD UNIQUE KEY `contact_number` (`contact_number`);

--
-- Indexes for table `vans`
--
ALTER TABLE `vans`
  ADD PRIMARY KEY (`van_id`),
  ADD UNIQUE KEY `plate_number` (`plate_number`),
  ADD KEY `driver_id` (`driver_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `vans`
--
ALTER TABLE `vans`
  MODIFY `van_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vans`
--
ALTER TABLE `vans`
  ADD CONSTRAINT `vans_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`driver_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
