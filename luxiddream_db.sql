-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2024 at 08:38 AM
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
  `card_id` int(5) NOT NULL,
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

INSERT INTO `cards` (`card_id`, `card_code`, `card_name`, `details`, `image`, `created_at`, `updated_at`) VALUES
(1, '1', 'Help people using their natural coping', 'Discuss with someone Spend time with family Find safe way to help other.', '1.png', '2024-01-01 16:03:51', '2024-01-01 16:03:51'),
(2, '2', 'Listen with eye, ear, heart', 'Give undivided attention, hearingcarefully,caring and showing respect', '2.png', '2024-01-01 16:21:25', '2024-01-01 16:21:25'),
(3, '3', 'Provide factual information', 'Be honest about what you know\r\nand what you don’t know', '3.png', '2024-01-10 00:00:00', '2024-01-10 00:57:13'),
(4, '4', 'Always ask', 'Ask about need and concern', '4.png', '2024-01-10 00:57:13', '2024-01-10 00:57:13'),
(5, '5', 'What to do first', 'Help prioritize urgent needs', '5.png', '2024-01-10 01:00:22', '2024-01-10 01:00:22');

-- --------------------------------------------------------

--
-- Table structure for table `cards_relation`
--

CREATE TABLE `cards_relation` (
  `card_relation_id` int(5) NOT NULL,
  `card_id_first` int(5) DEFAULT NULL,
  `card_id_second` int(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` int(5) NOT NULL,
  `level` tinyint(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `player_id` int(5) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`player_id`, `username`, `password`, `email`, `phone`, `image`, `created_at`, `updated_at`) VALUES
(1, 'creator', '1234', '', '', NULL, '2024-01-10 01:17:00', '2024-01-10 01:17:00'),
(2, 'player', '1234', '', '', NULL, '2024-01-10 01:17:06', '2024-01-10 01:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `players_stats`
--

CREATE TABLE `players_stats` (
  `player_stats_id` int(5) NOT NULL,
  `player_id` int(5) DEFAULT NULL,
  `played_all` int(5) DEFAULT NULL,
  `played_last` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `players_stats`
--

INSERT INTO `players_stats` (`player_stats_id`, `player_id`, `played_all`, `played_last`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '2024-01-10 01:17:00', '2024-01-10 01:17:00'),
(2, 2, NULL, NULL, '2024-01-10 01:17:06', '2024-01-10 01:17:06');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(5) NOT NULL,
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

INSERT INTO `rooms` (`room_id`, `invite_code`, `level`, `creator_name`, `status`, `round_time`, `created_at`, `updated_at`) VALUES
(1, '791567', 1, 'creator', 0, NULL, '2024-02-17 22:33:05', '2024-02-17 22:33:05');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_cards`
--

CREATE TABLE `rooms_cards` (
  `room_cards_id` int(5) NOT NULL,
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
  `room_players_id` int(5) NOT NULL,
  `player_id` int(5) DEFAULT NULL,
  `room_id` int(5) DEFAULT NULL,
  `name_ingame` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0 COMMENT '0=not ready, 1=ready',
  `role` tinyint(2) DEFAULT 0 COMMENT '0=player, 1=creator',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_players`
--

INSERT INTO `rooms_players` (`room_players_id`, `player_id`, `room_id`, `name_ingame`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'creator', 1, 1, '2024-02-17 22:33:05', '2024-02-17 22:33:05'),
(2, 2, 1, 'player', 0, 0, '2024-02-17 23:49:52', '2024-02-18 00:07:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`card_id`);

--
-- Indexes for table `cards_relation`
--
ALTER TABLE `cards_relation`
  ADD PRIMARY KEY (`card_relation_id`);

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`level_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`);

--
-- Indexes for table `players_stats`
--
ALTER TABLE `players_stats`
  ADD PRIMARY KEY (`player_stats_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `rooms_cards`
--
ALTER TABLE `rooms_cards`
  ADD PRIMARY KEY (`room_cards_id`);

--
-- Indexes for table `rooms_players`
--
ALTER TABLE `rooms_players`
  ADD PRIMARY KEY (`room_players_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cards`
--
ALTER TABLE `cards`
  MODIFY `card_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cards_relation`
--
ALTER TABLE `cards_relation`
  MODIFY `card_relation_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `players_stats`
--
ALTER TABLE `players_stats`
  MODIFY `player_stats_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms_cards`
--
ALTER TABLE `rooms_cards`
  MODIFY `room_cards_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms_players`
--
ALTER TABLE `rooms_players`
  MODIFY `room_players_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
