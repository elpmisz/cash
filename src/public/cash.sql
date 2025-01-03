-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: database
-- Generation Time: Jan 03, 2025 at 07:27 AM
-- Server version: 11.6.2-MariaDB-ubu2404
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cash`
--

-- --------------------------------------------------------

--
-- Table structure for table `cash_authorize`
--

CREATE TABLE `cash_authorize` (
  `id` int(11) NOT NULL,
  `type_id` int(1) NOT NULL,
  `login_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_authorize`
--

INSERT INTO `cash_authorize` (`id`, `type_id`, `login_id`, `status`, `updated`, `created`) VALUES
(1, 3, 1, 1, NULL, '2025-01-02 11:56:58'),
(2, 1, 1, 1, NULL, '2025-01-02 11:57:02'),
(3, 2, 1, 1, NULL, '2025-01-02 11:57:05'),
(4, 4, 1, 1, '2025-01-02 13:31:52', '2025-01-02 11:57:08');

-- --------------------------------------------------------

--
-- Table structure for table `cash_file`
--

CREATE TABLE `cash_file` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_file`
--

INSERT INTO `cash_file` (`id`, `request_id`, `name`, `status`, `updated`, `created`) VALUES
(1, 2, 'a4d988bac372cabb85c0fd96273c7b07.pdf', 1, NULL, '2025-01-03 13:49:45'),
(2, 2, '430d64236d2c43623aec9fd86bddec3d.pdf', 1, NULL, '2025-01-03 13:49:45'),
(3, 1, 'f20d29eabc98e5c34e5269ece7e6d0f7.png', 1, NULL, '2025-01-03 14:03:32'),
(4, 1, 'cbd7788a728eb5e41663f021a1101d2e.jpg', 1, NULL, '2025-01-03 14:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `cash_item`
--

CREATE TABLE `cash_item` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `text` varchar(100) NOT NULL,
  `amount` decimal(20,2) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_item`
--

INSERT INTO `cash_item` (`id`, `request_id`, `text`, `amount`, `status`, `updated`, `created`) VALUES
(1, 1, 'AAA', 24500.00, 1, '2025-01-03 09:48:50', '2025-01-03 09:45:55'),
(2, 1, 'BBB', 17600.00, 1, '2025-01-03 09:48:50', '2025-01-03 09:45:55'),
(3, 2, 'XXX', 27400.00, 1, NULL, '2025-01-03 09:47:13'),
(4, 2, 'YYY', 18300.00, 1, NULL, '2025-01-03 09:47:13'),
(5, 2, 'ZZZ', 8460.00, 1, NULL, '2025-01-03 09:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `cash_money`
--

CREATE TABLE `cash_money` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_money`
--

INSERT INTO `cash_money` (`id`, `amount`, `updated`, `created`) VALUES
(1, 50000, NULL, '2025-01-02 13:16:56');

-- --------------------------------------------------------

--
-- Table structure for table `cash_remark`
--

CREATE TABLE `cash_remark` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `text` varchar(200) NOT NULL,
  `status` int(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_remark`
--

INSERT INTO `cash_remark` (`id`, `request_id`, `login_id`, `text`, `status`, `created`) VALUES
(1, 1, 1, '', 3, '2025-01-03 11:01:29'),
(2, 2, 1, '', 2, '2025-01-03 11:05:21'),
(3, 2, 1, '', 3, '2025-01-03 11:29:28'),
(4, 1, 1, '', 4, '2025-01-03 11:36:47'),
(5, 2, 1, '', 4, '2025-01-03 11:36:54'),
(6, 1, 1, '', 5, '2025-01-03 13:32:33'),
(7, 2, 1, '', 5, '2025-01-03 13:33:16'),
(8, 2, 1, 'TESTTEST\r\nTESTTEST', 6, '2025-01-03 13:50:03'),
(9, 1, 1, '', 6, '2025-01-03 14:03:32');

-- --------------------------------------------------------

--
-- Table structure for table `cash_request`
--

CREATE TABLE `cash_request` (
  `id` int(11) NOT NULL,
  `uuid` uuid NOT NULL,
  `last` int(11) NOT NULL,
  `login_id` int(11) NOT NULL,
  `objective` text NOT NULL,
  `pay_type` int(11) DEFAULT NULL,
  `cheque` varchar(20) DEFAULT NULL,
  `payment` decimal(20,2) DEFAULT NULL,
  `receive_type` int(11) DEFAULT NULL,
  `receive` decimal(20,2) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_request`
--

INSERT INTO `cash_request` (`id`, `uuid`, `last`, `login_id`, `objective`, `pay_type`, `cheque`, `payment`, `receive_type`, `receive`, `status`, `updated`, `created`) VALUES
(1, 'daf2cb69-c97c-11ef-8ed9-0242ac120002', 1, 2, 'TESTETSTSET', 1, '', 42100.00, 2, 0.00, 6, '2025-01-03 14:03:32', '2025-01-03 09:45:55'),
(2, '0972f7b0-c97d-11ef-8ed9-0242ac120002', 2, 2, 'TESTSETSET\r\nTESTSETSET', 3, '1212312312121', 54160.00, 1, 660.00, 6, '2025-01-03 13:50:03', '2025-01-03 09:47:13');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `uuid` binary(20) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(200) NOT NULL,
  `level` int(1) NOT NULL DEFAULT 1,
  `status` int(1) NOT NULL DEFAULT 1,
  `updated` datetime DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `uuid`, `email`, `password`, `level`, `status`, `updated`, `created`) VALUES
(1, 0x30323133653763342d383961612d313165652d62, 'admin@test.com', '$2y$10$W08w.crPDLXzroZDNFirJObaHK91H.0D7ZszaRR6iQQi9W32.tnci', 9, 1, '2025-01-02 10:55:06', '2023-11-23 09:42:54'),
(2, 0x30626539306162662d633937342d313165662d38, 'user@test.com', '$2y$10$jwAmc2BoS2EwrzfL2LkYOel9FZHc9LSbRn4sge.SvmPiOyjoSgLVq', 1, 1, '2025-01-03 09:10:45', '2025-01-03 08:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `system`
--

CREATE TABLE `system` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_email` varchar(200) NOT NULL,
  `password_default` varchar(50) NOT NULL,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system`
--

INSERT INTO `system` (`id`, `name`, `email`, `password_email`, `password_default`, `updated`) VALUES
(1, 'CASH SYSTEM', 'cpl.issue@gmail.com', 'wtubrchtfugusotb', 'testtest', '2025-01-02 10:54:42');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `login` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `contact` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `login`, `firstname`, `lastname`, `manager_id`, `contact`) VALUES
(1, 1, 'Admin', 'System', NULL, ''),
(2, 2, 'User', 'System', 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cash_authorize`
--
ALTER TABLE `cash_authorize`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_file`
--
ALTER TABLE `cash_file`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_item`
--
ALTER TABLE `cash_item`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_money`
--
ALTER TABLE `cash_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_remark`
--
ALTER TABLE `cash_remark`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cash_request`
--
ALTER TABLE `cash_request`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uuid` (`uuid`);

--
-- Indexes for table `system`
--
ALTER TABLE `system`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cash_authorize`
--
ALTER TABLE `cash_authorize`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cash_file`
--
ALTER TABLE `cash_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cash_item`
--
ALTER TABLE `cash_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cash_money`
--
ALTER TABLE `cash_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cash_remark`
--
ALTER TABLE `cash_remark`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cash_request`
--
ALTER TABLE `cash_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `system`
--
ALTER TABLE `system`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
