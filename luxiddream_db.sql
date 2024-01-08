-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 08, 2024 at 06:46 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `luxiddream_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE `cards` (
  `id` int(5) NOT NULL,
  `card_code` varchar(10) DEFAULT NULL,
  `card_name` varchar(50) DEFAULT NULL,
  `details` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`id`, `card_code`, `card_name`, `details`, `image`, `created_at`, `updated_at`) VALUES
(1, '1', 'Help people using their natural coping', 'Discuss with someone Spend time with family Find safe way to help other.', NULL, '2024-01-01 16:03:51', '2024-01-01 16:03:51'),
(2, '2', 'card2', 'details', NULL, '2024-01-01 16:21:25', '2024-01-01 16:21:25');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `id` int(5) NOT NULL,
  `room_id` int(5) DEFAULT NULL,
  `name_ingame` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0 COMMENT '0=not ready, 1=ready',
  `played_all` int(5) DEFAULT 0,
  `played_last` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`id`, `room_id`, `name_ingame`, `username`, `password`, `email`, `phone`, `image`, `status`, `played_all`, `played_last`, `created_at`, `updated_at`) VALUES
(75, 36, '1234', 'test', '1234', '', '', NULL, 0, 0, NULL, '2024-01-09 00:10:30', '2024-01-09 00:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(5) NOT NULL,
  `invite_code` varchar(30) DEFAULT NULL,
  `level` tinyint(2) DEFAULT NULL,
  `creator_name` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0,
  `round_time` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`id`, `invite_code`, `level`, `creator_name`, `status`, `round_time`, `created_at`, `updated_at`) VALUES
(36, '220975', 1, 'test', 0, NULL, '2024-01-09 00:10:39', '2024-01-09 00:10:39');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_cards`
--

CREATE TABLE `rooms_cards` (
  `id` int(5) NOT NULL,
  `room_id` int(5) DEFAULT NULL,
  `card_code` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rooms_players`
--

CREATE TABLE `rooms_players` (
  `id` int(5) NOT NULL,
  `player_id` int(5) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0 COMMENT '0=not ready, 1=ready',
  `role` tinyint(2) DEFAULT 0 COMMENT '0=player, 1=creator',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_cards`
--
ALTER TABLE `rooms_cards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rooms_players`
--
ALTER TABLE `rooms_players`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `rooms_cards`
--
ALTER TABLE `rooms_cards`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `rooms_players`
--
ALTER TABLE `rooms_players`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
