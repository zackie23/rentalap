-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 28, 2025 at 04:33 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_rentalapp_johan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_bookings`
--

CREATE TABLE `tb_bookings` (
  `id` bigint(20) NOT NULL,
  `field_id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `team_id` bigint(20) DEFAULT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` enum('pending','paid','cancelled','checked_in') NOT NULL,
  `payment_method` enum('online','cod') NOT NULL,
  `total_price` int(11) NOT NULL,
  `qr_checkin_code` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_branches`
--

CREATE TABLE `tb_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_branches`
--

INSERT INTO `tb_branches` (`id`, `owner_id`, `name`, `address`, `city`, `phone`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 0, 'gor manuntung', 'jl samarinda', 'bontang', '1', '2025-04-16 05:29:48', '2025-04-16 05:29:48', NULL, NULL),
(3, 0, 'kartika', 'gunung guntur', 'balikpapan', '2', '2025-04-16 05:30:25', '2025-04-16 05:30:25', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_data_error`
--

CREATE TABLE `tb_data_error` (
  `id_error` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `waktu` datetime NOT NULL,
  `url` varchar(100) NOT NULL,
  `ip_address` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_data_error`
--

INSERT INTO `tb_data_error` (`id_error`, `email`, `waktu`, `url`, `ip_address`) VALUES
(1, 'zackie23@rocketmail.com', '2025-04-16 08:36:51', '/bookingonline/pages/cek_login.php zackie23@rocketmail.com;123', '::1;Mozilla/5.0 '),
(2, 'zackie23@rocketmail.com', '2025-04-16 08:37:34', '/bookingonline/pages/cek_login.php zackie23@rocketmail.com;', '::1;Mozilla/5.0 '),
(3, 'johananakbaik0@gmail.com', '2025-04-16 12:29:18', '/rentalap/pages/cek_login.php johananakbaik0@gmail.com;124', '::1;Mozilla/5.0 '),
(4, 'johananakbaik0@gmail.com', '2025-04-16 12:29:20', '/rentalap/pages/cek_login.php johananakbaik0@gmail.com;124', '::1;Mozilla/5.0 '),
(5, 'johananakbaik0@gmail.com', '2025-04-16 11:42:11', 'http://localhost/rentalap/pages/cabang', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tb_data_login`
--

CREATE TABLE `tb_data_login` (
  `id_session` int(11) NOT NULL,
  `name_session` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `time_login` datetime NOT NULL,
  `time_logout` datetime NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `type_browser` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_data_login`
--

INSERT INTO `tb_data_login` (`id_session`, `name_session`, `email`, `time_login`, `time_logout`, `ip_address`, `type_browser`) VALUES
(1, 'bbacsr9hm9q5sh2dn39i7ke9i0', 'johananakbaik0@gmail.com', '2025-04-16 12:30:19', '0000-00-00 00:00:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36'),
(2, 'f0abbda1bbiqjf24m8pn1s977m', 'johananakbaik0@gmail.com', '2025-04-16 12:30:19', '2025-04-16 12:34:10', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36'),
(3, '2j48fc5ncrimdqathkauimm2ut', 'johananakbaik0@gmail.com', '2025-04-16 12:34:16', '2025-04-16 12:35:20', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36'),
(4, 'ehm7qcho0j2cfri417sc1rlnij', 'johananakbaik0@gmail.com', '2025-04-16 12:35:28', '0000-00-00 00:00:00', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/125.0.0.0 Safari/537.36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_fields`
--

CREATE TABLE `tb_fields` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `sport_type` varchar(25) NOT NULL,
  `hourly_price` decimal(10,2) NOT NULL,
  `image_url` text DEFAULT NULL,
  `active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_fields`
--

INSERT INTO `tb_fields` (`id`, `branch_id`, `name`, `sport_type`, `hourly_price`, `image_url`, `active`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 2, 'lapangan bola', 'bola', '2.00', 'bola', 0, '2025-04-16 06:04:56', '2025-04-16 06:11:52', NULL, NULL),
(3, 3, 'taman sari', 'bultang', '2.00', 'bola', 0, '2025-04-16 06:08:58', '2025-04-16 06:12:17', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_operator`
--

CREATE TABLE `tb_operator` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_owners`
--

INSERT INTO `tb_owners` (`id`, `user_id`, `business_name`, `status`, `verified_at`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 8, 'Yasser Sport', 'pending', NULL, '2025-04-18 03:55:07', '2025-04-18 03:55:07', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_packages`
--

CREATE TABLE `tb_packages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `max_fields` int(11) DEFAULT 2,
  `max_branches` int(11) DEFAULT 1,
  `price` int(11) DEFAULT NULL,
  `duration_days` int(11) DEFAULT 30,
  `description` text DEFAULT NULL,
  `is_trial` tinyint(1) NOT NULL,
  `is_recommended` tinyint(1) NOT NULL,
  `is_visible` tinyint(1) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_packages`
--

INSERT INTO `tb_packages` (`id`, `name`, `max_fields`, `max_branches`, `price`, `duration_days`, `description`, `is_trial`, `is_recommended`, `is_visible`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 'Basic', 2, 1, 0, 0, 'Paket gratis untuk pengguna baru', 1, 0, 1, '2025-04-18 07:22:47', '2025-04-18 07:22:47', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(3, 'Standard', 5, 3, 99000, 30, 'Cocok untuk penyewa lapangan kecil', 0, 0, 1, '2025-04-18 07:22:47', '2025-04-18 07:22:47', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(4, 'Pro', 10, 5, 199000, 30, 'Paket lengkap untuk UKM', 0, 1, 1, '2025-04-18 07:22:47', '2025-04-18 07:22:47', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(5, 'Business', 30, 10, 499000, 90, 'Untuk bisnis skala menengah', 0, 0, 1, '2025-04-18 07:22:47', '2025-04-18 07:24:03', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(6, 'Enterprise', 999, 999, 999000, 365, 'Paket untuk perusahaan besar', 0, 0, 1, '2025-04-18 07:22:47', '2025-04-18 07:23:46', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `tb_payment`
--

CREATE TABLE `tb_payment` (
  `id` bigint(20) NOT NULL,
  `owner_id` bigint(20) NOT NULL,
  `subscription_id` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `method` enum('transfer','manual') NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` enum('pending','paid','failed') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_roles`
--

CREATE TABLE `tb_roles` (
  `id` bigint(20) NOT NULL,
  `name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) NOT NULL,
  `updated_by` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_roles`
--

INSERT INTO `tb_roles` (`id`, `name`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 'Administrator', '2025-04-16 02:51:28', '2025-04-16 02:51:28', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(2, 'Owner', '2025-04-16 04:35:02', '2025-04-16 04:35:02', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(3, 'Operator', '2025-04-16 04:35:08', '2025-04-16 04:35:08', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com'),
(4, 'User', '2025-04-16 04:35:12', '2025-04-16 04:35:12', 'zackie23@rocketmail.com', 'zackie23@rocketmail.com');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_teams`
--

CREATE TABLE `tb_teams` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `leader_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_team_members`
--

CREATE TABLE `tb_team_members` (
  `id` bigint(20) NOT NULL,
  `team_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `is_leader` tinyint(1) DEFAULT 0,
  `joined_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tickets`
--

CREATE TABLE `tb_tickets` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `subject` varchar(255) NOT NULL,
  `status` enum('open','in_progress','resolved','closed') DEFAULT 'open',
  `priority` enum('low','medium','high') DEFAULT 'low',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` varchar(50) DEFAULT NULL,
  `updated_by` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ticket_messages`
--

CREATE TABLE `tb_ticket_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `ticket_id` int(10) UNSIGNED NOT NULL,
  `sender_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `is_admin_reply` tinyint(1) DEFAULT 0,
  `attachment_url` varchar(255) DEFAULT NULL,
  `crated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_users`
--

CREATE TABLE `tb_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `google_id` varchar(100) DEFAULT NULL,
  `avatar_url` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_users`
--

INSERT INTO `tb_users` (`id`, `name`, `email`, `password`, `phone`, `google_id`, `avatar_url`, `is_active`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(2, 'Zackie', 'zackie23@rocketmail.com', '522b1d3228c545eca926b0c2a391068d', '085247156008', '', '', 1, '2025-04-15 17:22:18', '2025-04-15 21:05:53', 0, 0),
(6, 'Johan', 'johananakbaik0@gmail.com', '522b1d3228c545eca926b0c2a391068d', '08', '', '', 1, '2025-04-15 20:59:10', '2025-04-15 20:59:10', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user_roles`
--

CREATE TABLE `tb_user_roles` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user_roles`
--

INSERT INTO `tb_user_roles` (`id`, `user_id`, `role_id`, `branch_id`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 6, 2, NULL, '2025-04-15 20:59:10', '2025-04-16 04:34:43', 0, 0),
(2, 2, 1, NULL, '2025-04-15 21:02:49', '2025-04-15 21:15:10', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_bookings`
--
ALTER TABLE `tb_bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `tb_branches`
--
ALTER TABLE `tb_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_data_error`
--
ALTER TABLE `tb_data_error`
  ADD PRIMARY KEY (`id_error`);

--
-- Indexes for table `tb_data_login`
--
ALTER TABLE `tb_data_login`
  ADD PRIMARY KEY (`id_session`);

--
-- Indexes for table `tb_fields`
--
ALTER TABLE `tb_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_operator`
--
ALTER TABLE `tb_operator`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD UNIQUE KEY `branch_id` (`branch_id`);

--
-- Indexes for table `tb_owners`
--
ALTER TABLE `tb_owners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_packages`
--
ALTER TABLE `tb_packages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_payment`
--
ALTER TABLE `tb_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`),
  ADD KEY `subscription_id` (`subscription_id`);

--
-- Indexes for table `tb_roles`
--
ALTER TABLE `tb_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_subscriptions`
--
ALTER TABLE `tb_subscriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_owner` (`id_owner`),
  ADD KEY `id_package` (`id_package`);

--
-- Indexes for table `tb_teams`
--
ALTER TABLE `tb_teams`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leader_id` (`leader_id`);

--
-- Indexes for table `tb_team_members`
--
ALTER TABLE `tb_team_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_tickets`
--
ALTER TABLE `tb_tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `tb_ticket_messages`
--
ALTER TABLE `tb_ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `sender_id` (`sender_id`);

--
-- Indexes for table `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_user_roles`
--
ALTER TABLE `tb_user_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_bookings`
--
ALTER TABLE `tb_bookings`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_branches`
--
ALTER TABLE `tb_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_data_error`
--
ALTER TABLE `tb_data_error`
  MODIFY `id_error` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_data_login`
--
ALTER TABLE `tb_data_login`
  MODIFY `id_session` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_fields`
--
ALTER TABLE `tb_fields`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_operator`
--
ALTER TABLE `tb_operator`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_owners`
--
ALTER TABLE `tb_owners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_packages`
--
ALTER TABLE `tb_packages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_payment`
--
ALTER TABLE `tb_payment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_roles`
--
ALTER TABLE `tb_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_subscriptions`
--
ALTER TABLE `tb_subscriptions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_teams`
--
ALTER TABLE `tb_teams`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_team_members`
--
ALTER TABLE `tb_team_members`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_tickets`
--
ALTER TABLE `tb_tickets`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_ticket_messages`
--
ALTER TABLE `tb_ticket_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_user_roles`
--
ALTER TABLE `tb_user_roles`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_operator`
--
ALTER TABLE `tb_operator`
  ADD CONSTRAINT `tb_operator_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`),
  ADD CONSTRAINT `tb_operator_ibfk_2` FOREIGN KEY (`branch_id`) REFERENCES `tb_branches` (`id`);

--
-- Constraints for table `tb_teams`
--
ALTER TABLE `tb_teams`
  ADD CONSTRAINT `tb_teams_ibfk_1` FOREIGN KEY (`leader_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_team_members`
--
ALTER TABLE `tb_team_members`
  ADD CONSTRAINT `tb_team_members_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `tb_teams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_team_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_tickets`
--
ALTER TABLE `tb_tickets`
  ADD CONSTRAINT `tb_tickets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tb_users` (`id`);

--
-- Constraints for table `tb_ticket_messages`
--
ALTER TABLE `tb_ticket_messages`
  ADD CONSTRAINT `tb_ticket_messages_ibfk_1` FOREIGN KEY (`ticket_id`) REFERENCES `tb_tickets` (`id`),
  ADD CONSTRAINT `tb_ticket_messages_ibfk_2` FOREIGN KEY (`sender_id`) REFERENCES `tb_users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
