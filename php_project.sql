-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2024 at 09:38 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `crm_credentials`
--

CREATE TABLE `crm_credentials` (
  `id` int(11) NOT NULL,
  `crm_name` int(11) NOT NULL,
  `crm_apiendpoint` text NOT NULL,
  `crm_username` varchar(255) DEFAULT NULL,
  `crm_password` varchar(255) DEFAULT NULL,
  `crm_userid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `privileges`
--

CREATE TABLE `privileges` (
  `id` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `privileges`
--

INSERT INTO `privileges` (`id`, `NAME`) VALUES
(1, 'Products'),
(2, 'CRM Credentials'),
(3, 'Provider'),
(4, 'Provider Paths'),
(5, 'User Role');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` float(8,2) NOT NULL,
  `image` int(11) NOT NULL,
  `thumbnail` int(11) NOT NULL,
  `is_active` enum('0','1') NOT NULL DEFAULT '1' COMMENT '"0" = inactive,\r\n"1" = active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_deleted` enum('0','1') NOT NULL DEFAULT '0' COMMENT '"0" = not deleted,\r\n"1" = deleted',
  `tags` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `providers`
--

CREATE TABLE `providers` (
  `id` int(11) NOT NULL,
  `provider_type` enum('1','2') NOT NULL COMMENT '1 = CRM,\r\n2 = cloudflare',
  `provider_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `NAME` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `NAME`) VALUES
(1, 'superadmin'),
(2, 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `role_privileges`
--

CREATE TABLE `role_privileges` (
  `role_id` int(11) NOT NULL,
  `privilege_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `role_privileges`
--

INSERT INTO `role_privileges` (`role_id`, `privilege_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(2, 2),
(2, 3),
(2, 4),
(2, 5);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `password_original` varchar(255) NOT NULL,
  `role` enum('1','2') NOT NULL DEFAULT '2' COMMENT '1 = super admin,\r\n2 = admin',
  `is_active` enum('0','1') NOT NULL DEFAULT '1' COMMENT '0 = inactive,\r\n1 = active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `password_original`, `role`, `is_active`, `created_at`) VALUES
(1, 'arpan', 'test@test.com', '$2y$10$J/PLPyWXRl0jmRvPQxGhqOp5r5t6R/iQccmvDTY/70RAowvL/9voy', '123456', '1', '1', '2024-05-07 12:13:54'),
(2, 'test', '', '', '', '2', '1', '2024-05-07 12:13:54'),
(3, 'test2', '', '', '', '2', '1', '2024-05-07 12:13:54'),
(12, 'test', 'test1@test.com', '$2y$10$1xqFHhXiTykAPO0nPkA7T.MgOqzphoRYRdIkF2CehmHJibGOqh9hO', '123456', '2', '1', '2024-05-29 13:01:49'),
(17, 'arpan', 'abc@abc.com', 'password', 'password', '2', '1', '2024-06-17 14:02:08'),
(18, 'arpan2', 'abc2@abc.com', 'password2', 'password2', '2', '1', '2024-06-17 14:02:08'),
(19, 'arpan', 'abc@abc.com', 'password', 'password', '2', '1', '2024-06-20 08:24:55'),
(20, 'arpan2', 'abc2@abc.com', 'password2', 'password2', '2', '1', '2024-06-20 08:24:55'),
(21, 'arpan', 'abc@abc.com', 'password', 'password', '2', '1', '2024-06-25 11:33:11'),
(22, 'arpan2', 'abc2@abc.com', 'password2', 'password2', '2', '1', '2024-06-25 11:33:11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `crm_credentials`
--
ALTER TABLE `crm_credentials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `privileges`
--
ALTER TABLE `privileges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `providers`
--
ALTER TABLE `providers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD PRIMARY KEY (`role_id`,`privilege_id`),
  ADD KEY `privilege_id` (`privilege_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `crm_credentials`
--
ALTER TABLE `crm_credentials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `privileges`
--
ALTER TABLE `privileges`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `providers`
--
ALTER TABLE `providers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_privileges`
--
ALTER TABLE `role_privileges`
  ADD CONSTRAINT `role_privileges_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_privileges_ibfk_2` FOREIGN KEY (`privilege_id`) REFERENCES `privileges` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
