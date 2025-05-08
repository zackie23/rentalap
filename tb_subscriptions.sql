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
-- Table structure for table `tb_subscriptions`
--

CREATE TABLE `tb_subscriptions` (
  `id` int(11) NOT NULL,
  `id_owner` bigint(20) UNSIGNED NOT NULL,
  `id_package` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_subscriptions`
--

INSERT INTO `tb_subscriptions` (`id`, `id_owner`, `id_package`, `start_date`, `end_date`, `is_active`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 1, 4, '2025-05-07', '0000-00-00', 1, '2025-05-07 13:23:18', '2025-05-07 13:56:57', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(3, 3, 3, '2025-05-07', '2025-06-06', 1, '2025-05-07 13:58:52', '2025-05-07 14:16:54', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(4, 1, 5, '2025-05-07', '2025-08-05', 1, '2025-05-07 14:13:24', '2025-05-07 14:13:24', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_subscriptions`
--
ALTER TABLE `tb_subscriptions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_subscriptions`
--
ALTER TABLE `tb_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
