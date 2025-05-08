-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 08, 2025 at 07:13 AM
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
-- Database: `db_rentalapp`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_owners`
--

CREATE TABLE `tb_owners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `business_name` varchar(100) NOT NULL,
  `status` enum('active','suspended','pending') DEFAULT 'pending',
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_owners`
--

INSERT INTO `tb_owners` (`id`, `user_id`, `business_name`, `status`, `verified_at`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 8, 'Yasser Sport', '', NULL, '2025-04-17 20:55:07', '2025-04-29 03:47:13', NULL, NULL),
(3, 15, 'badminton', '', NULL, '2025-04-29 05:07:16', '2025-04-29 06:47:44', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(5, 16, 'bola', 'pending', NULL, '2025-04-29 05:33:14', '2025-04-29 05:33:14', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_owners`
--
ALTER TABLE `tb_owners`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_owners`
--
ALTER TABLE `tb_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
