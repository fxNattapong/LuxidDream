-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 23, 2024 at 01:44 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
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
  `code` varchar(10) DEFAULT NULL,
  `skill` tinyint(2) DEFAULT NULL COMMENT '0=search , 1=listening, 2=link',
  `color` tinyint(2) DEFAULT NULL COMMENT '0=red, 1=yellow 2=green, 3=blue',
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`card_id`, `code`, `skill`, `color`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, '111', 0, 0, 'สังเกตหาคนที่กำลังเผชิญกับความทุกข์ทรมาน', 'ตัวสั่น เจ็บปวด ร้องไห้ สับสน กังวล รู้สึกผิด โกรธ เป็นต้น', 'vxZL523Oo1.png', '2024-02-23 02:15:40', '2024-02-23 02:23:25'),
(2, '112', 0, 0, 'สังเกตหาคนที่มีความเสี่ยงถูกแบ่งแยก', 'ควรได้รับการปกป้อง? มีความเสี่ยงจะเกิด ความรุนแรง ?', 'eQInDAz5uZ.png', '2024-02-23 02:25:59', '2024-02-23 02:25:59'),
(3, '113', 0, 0, 'สังเกตหาที่ปลอดภัย', 'อะไรที่เป็นอันตราย ? อันตรายกับตนเอง หรือผู้อื่น ?', 'ZsvvBgu4Ye.png', '2024-02-23 02:26:19', '2024-02-23 02:26:19'),
(4, '121', 1, 0, 'รับรู้ความรู้สึกและจุดแข็งของผู้อื่น และเคารพความเป็นส่วนตัว', '', '1lVx8CFz0b.png', '2024-02-23 02:29:10', '2024-02-23 02:32:00'),
(5, '122', 1, 0, 'ซื่อสัตย์กับข้อมูลที่เรารู้และข้อมูล ที่เราไม่รู้', 'จัดเตรียมข้อมูล ที่เป็นจริง', 'YZqAUnkUD8.png', '2024-02-23 02:32:58', '2024-02-23 02:32:58'),
(6, '123', 1, 0, 'ไม่บังคับให้ต้องพูดและไม่ตัดสิน', '', '4XOynA8d98.png', '2024-02-23 02:33:27', '2024-02-23 02:33:27'),
(7, '211', 0, 1, 'สังเกตหาเด็กที่ต้องการได้รับ ความช่วยเหลือ', 'พามาหาผู้ดูแล', '4PjBH9lHj8.png', '2024-02-23 02:34:03', '2024-02-23 02:34:03'),
(8, '221', 1, 1, 'ช่วยผู้อื่นให้เชื่อมโยงกับความรู้สึกทางกาย ของพวกเขา สิ่งแวดล้อม และลมหายใจ', '', 'BKzhDrcvhE.png', '2024-02-23 02:34:48', '2024-02-23 02:34:48'),
(9, '222', 1, 1, 'คอยสอบถามความต้องการและสิ่งที่กังวล', '', 'Icu0mU716w.png', '2024-02-23 02:35:25', '2024-02-23 02:35:25'),
(10, '231', 2, 1, 'ช่วยระบุแหล่งช่วยเหลือและสนับสนุน', '', 'IYEyoheIoq.png', '2024-02-23 02:36:23', '2024-02-23 02:36:33'),
(11, '232', 2, 1, 'หาข้อมูลที่แม่นยำและคอยส่งข่าว', '', 'ufh0N0Nr9V.png', '2024-02-23 02:36:52', '2024-02-23 02:36:52'),
(12, '233', 2, 1, 'ช่วยจัดลำดับความสำคัญและเร่งด่วน ว่าอะไรต้องทำก่อน', '', 'UMYGO0G6ZJ.png', '2024-02-23 02:37:29', '2024-02-23 02:37:29'),
(13, '311', 0, 2, 'สังเกตหาคนที่ต้องการปัจจัยพื้นฐาน', 'อาหาร ที่พัก เสื้อผ้า น้ำสะอาด', 'cPw8BDiw2n.png', '2024-02-23 02:38:14', '2024-02-23 02:38:57'),
(14, '312', 0, 2, 'สังเกตหาคนที่มีโรคประจำตัว หรือมีภาวะการเจ็บป่วยทางกาย', 'ต้องการเข้าถึง การบริการ ?', 'evxwIrW4DM.png', '2024-02-23 02:40:12', '2024-02-23 02:40:12'),
(15, '313', 0, 2, 'สังเกตหาคนที่ต้องการความช่วยเหลือ ทางการแพทย์', '', 'OsQhiW6sSX.png', '2024-02-23 02:40:37', '2024-02-23 02:40:37'),
(16, '314', 0, 2, 'สังเกตหาคนที่ต้องได้รับการช่วยชีวิต', 'มีการบาดเจ็บ ขั้นวิกฤต ?', 'uy2CNZkrpq.png', '2024-02-23 02:41:17', '2024-02-23 02:41:17'),
(17, '331', 2, 2, 'ช่วยระลึกถึงวิธีแก้ปัญหาในอดีต', '', 'jPUAKulb2F.png', '2024-02-23 02:41:54', '2024-02-23 02:41:54'),
(18, '332', 2, 2, 'เชื่อมโยงการเข้าถึงบริการต่าง ๆ', '', 'XoMsgdtR17.png', '2024-02-23 02:42:25', '2024-02-23 02:42:25'),
(19, '421', 1, 3, 'ฟังโดยไม่แบ่งความสนใจ ตั้งใจฟัง ใส่ใจและให้เกียรติ', 'ฟังด้วยตา หู และ ใจ', '9F62ollgrY.png', '2024-02-23 02:43:03', '2024-02-23 02:43:03'),
(20, '422', 1, 3, 'ไม่สร้างเรื่องที่ไม่จริงและไม่สัญญา ในสิ่งที่ทำไม่ได้', '', 'wEpptx6m5a.png', '2024-02-23 02:43:27', '2024-02-23 02:43:41'),
(21, '423', 1, 3, 'เข้าหาด้วยความเคารพ แนะนำตัวเอง ช่วยให้เขารู้สึกสะดวกสบาย และทำให้เขารู้สึกปลอดภัย', '', 'jhZYptvK0v.png', '2024-02-23 02:44:01', '2024-02-23 02:44:01'),
(22, '431', 2, 3, 'ช่วยให้จัดการปัญหาด้วยวิธีเรียบง่าย', 'พูดคุยกับบางคน ใช้เวลากับครอบครัว หาวิธีปลอดภัย ในการช่วยเหลือคนอื่น', 'xdlZm3CE7U.png', '2024-02-23 02:44:45', '2024-02-23 02:44:45'),
(23, '432', 2, 3, 'ช่วยให้จัดการปัญหาด้วยวิธีเรียบง่าย', 'พักผ่อน กินอาหารสม่ำเสมอ ดูแขสุขภาวะอนามัย ผ่อนคลาย ออกกำลังกาย หลีกเลี่ยงสารเสพติด', '2wfa9BtUbE.png', '2024-02-23 02:45:11', '2024-02-23 02:45:11'),
(24, '433', 2, 3, 'เชื่อมโยงเขาเข้ากับคนที่รักและ สังคมที่คอยสนับสนุน', '', '7rYpyQ3n0D.png', '2024-02-23 02:45:40', '2024-02-23 02:45:40');

-- --------------------------------------------------------

--
-- Table structure for table `cards_relation`
--

CREATE TABLE `cards_relation` (
  `card_relation_id` int(5) NOT NULL,
  `card_id_first` int(5) DEFAULT NULL,
  `card_id_second` int(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `level_id` int(5) NOT NULL,
  `level` tinyint(2) DEFAULT NULL COMMENT '0=easy, 1=medium, 2=hard',
  `round` tinyint(2) DEFAULT NULL,
  `time_1` varchar(5) DEFAULT NULL,
  `time_2` varchar(5) DEFAULT NULL,
  `time_3` varchar(5) DEFAULT NULL,
  `time_4` varchar(5) DEFAULT NULL,
  `time_5` varchar(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level`, `round`, `time_1`, `time_2`, `time_3`, `time_4`, `time_5`, `created_at`, `updated_at`) VALUES
(1, 0, 5, '7.00', '6.00', '5.00', '4.00', '3.30', '2024-02-22 21:14:52', '2024-02-22 21:14:52'),
(2, 1, 4, '7.00', '6.30', '6.00', '4.00', NULL, '2024-02-22 21:24:47', '2024-02-22 21:24:47'),
(3, 2, 5, '6.00', '4.00', '3.30', '3.00', NULL, '2024-02-22 21:24:58', '2024-02-22 21:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `nightmares`
--

CREATE TABLE `nightmares` (
  `nightmare_id` int(5) NOT NULL,
  `type` tinyint(2) DEFAULT NULL COMMENT '0=panic, 1=anxiety, 2=anger, 3=sad, 4=peace',
  `description` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `nightmares`
--

INSERT INTO `nightmares` (`nightmare_id`, `type`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 0, 'ฉันรับสิ่งรู้สิ่งแวดล้อมเปลี่ยนไปเหมือนตัวเองไม่ใช่ตัวเอง', '9xBj9NNK1P.png', '2024-02-22 22:40:39', '2024-02-22 22:40:39'),
(2, 0, 'ฉันกลัวความตาย', 'XBbLxyyibs.png', '2024-02-22 22:47:17', '2024-02-22 22:47:17'),
(3, 0, 'ฉันรู้สึกสูญเสียการควบคุม', 'jU7p5saHN5.png', '2024-02-22 22:47:32', '2024-02-22 22:47:32'),
(4, 0, 'ฉันแปลความรู้สึกทางกาย แย่กว่าความเป็นจริง', 'HlMNobEGMv.png', '2024-02-22 22:50:59', '2024-02-22 22:50:59'),
(5, 1, 'ฉันหลงลืมความสามารถในการรับมือกับปัญหา', 'ZqP2FACSFT.png', '2024-02-22 22:51:22', '2024-02-23 01:02:36'),
(6, 1, 'ฉันประเมินขนาดปัญหาใหญ่เกินไป', 'BopG7Rpqvz.png', '2024-02-23 01:02:55', '2024-02-23 01:02:55'),
(7, 1, 'ฉันประเมินโอกาสเกิดปัญหาสูงไป', 'Tif8mZYZ0Q.png', '2024-02-23 01:03:11', '2024-02-23 01:03:38'),
(8, 1, 'ฉันประเมินความสามารถตัวเองต่ำเกินไป', 'SOxTT21PwW.png', '2024-02-23 01:03:28', '2024-02-23 01:03:28'),
(9, 2, 'ฉันโดนดูถูก', 'u7c6M5YLEC.png', '2024-02-23 01:04:02', '2024-02-23 01:04:02'),
(10, 2, 'ฉันถูกกล่าวหา', 'is8xvI8z3D.png', '2024-02-23 01:04:14', '2024-02-23 01:04:14'),
(11, 2, 'ฉันถูกละเมิด', 'd2Sqv4rKwu.png', '2024-02-23 01:04:26', '2024-02-23 01:04:26'),
(12, 2, 'ฉันไม่ได้รับความยุติธรรม', '7mqZ1XiZWn.png', '2024-02-23 01:04:41', '2024-02-23 01:04:41'),
(13, 3, 'ฉันสิ้นหวังไร้ซึ่งหนทาง', 'A45WZPiLMC.png', '2024-02-23 01:05:45', '2024-02-23 01:06:37'),
(14, 3, 'ฉันมองตัวเองไม่ดี', 'uvQh8pOj9n.png', '2024-02-23 01:06:02', '2024-02-23 01:06:02'),
(15, 3, 'ฉันมองว่าผู้อื่นไม่ดีกับฉัน', 'VaA2DY9kVg.png', '2024-02-23 01:06:19', '2024-02-23 01:06:19'),
(16, 3, 'ฉันมองว่าอนาคตจะมีแต่เรื่องไม่ดี', 'z9GbmVRJjo.png', '2024-02-23 01:06:55', '2024-02-23 01:06:55'),
(17, 4, 'สงบ', '6cLMW1s2eP.png', '2024-02-23 01:08:32', '2024-02-23 01:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `player_id` int(5) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` tinyint(2) NOT NULL DEFAULT '0' COMMENT '0=player, 1=admin',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`player_id`, `username`, `password`, `phone`, `email`, `image`, `role`, `created_at`, `updated_at`) VALUES
(1, 'admin', '1234', '0123456789', 'admin@gmail.com', '9FKxEjQukz.png', 1, '2024-01-10 01:17:00', '2024-02-21 23:09:34'),
(2, 'player', '1234', '', '', NULL, 0, '2024-01-10 01:17:06', '2024-02-21 23:12:15');

-- --------------------------------------------------------

--
-- Table structure for table `players_rule`
--

CREATE TABLE `players_rule` (
  `player_rule_id` int(5) NOT NULL,
  `amount` int(2) DEFAULT NULL,
  `circle` int(2) DEFAULT NULL,
  `nightmare_5` int(2) DEFAULT NULL,
  `nightmare_6` int(2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `players_rule`
--

INSERT INTO `players_rule` (`player_rule_id`, `amount`, `circle`, `nightmare_5`, `nightmare_6`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 1, 1, '2024-02-23 16:31:22', '2024-02-23 16:31:22'),
(2, 5, 3, 3, 0, '2024-02-23 16:32:55', '2024-02-23 16:32:55'),
(3, 6, 3, 2, 1, '2024-02-23 16:32:58', '2024-02-23 16:32:58'),
(4, 7, 4, 3, 1, '2024-02-23 16:33:02', '2024-02-23 16:33:02'),
(5, 8, 4, 2, 2, '2024-02-23 16:52:24', '2024-02-23 16:52:24');

-- --------------------------------------------------------

--
-- Table structure for table `players_stats`
--

CREATE TABLE `players_stats` (
  `player_stats_id` int(5) NOT NULL,
  `player_id` int(5) DEFAULT NULL,
  `played_all` int(5) DEFAULT NULL,
  `played_last` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `level_id` int(5) DEFAULT NULL,
  `invite_code` varchar(30) DEFAULT NULL,
  `creator_name` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms_cards`
--

CREATE TABLE `rooms_cards` (
  `room_cards_id` int(5) NOT NULL,
  `room_id` int(5) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rooms_nightmares`
--

CREATE TABLE `rooms_nightmares` (
  `room_nightmare_id` int(5) NOT NULL,
  `room_id` int(5) DEFAULT NULL,
  `nightmare_id` int(5) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `rooms_players`
--

CREATE TABLE `rooms_players` (
  `room_players_id` int(5) NOT NULL,
  `player_id` int(5) DEFAULT NULL,
  `room_id` int(5) DEFAULT NULL,
  `name_ingame` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '0' COMMENT '0=not ready, 1=ready',
  `role` tinyint(2) DEFAULT '0' COMMENT '0=player, 1=creator',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `nightmares`
--
ALTER TABLE `nightmares`
  ADD PRIMARY KEY (`nightmare_id`);

--
-- Indexes for table `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`player_id`);

--
-- Indexes for table `players_rule`
--
ALTER TABLE `players_rule`
  ADD PRIMARY KEY (`player_rule_id`);

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
-- Indexes for table `rooms_nightmares`
--
ALTER TABLE `rooms_nightmares`
  ADD PRIMARY KEY (`room_nightmare_id`);

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
  MODIFY `card_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `cards_relation`
--
ALTER TABLE `cards_relation`
  MODIFY `card_relation_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `level_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `nightmares`
--
ALTER TABLE `nightmares`
  MODIFY `nightmare_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `players_rule`
--
ALTER TABLE `players_rule`
  MODIFY `player_rule_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `players_stats`
--
ALTER TABLE `players_stats`
  MODIFY `player_stats_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms_cards`
--
ALTER TABLE `rooms_cards`
  MODIFY `room_cards_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms_nightmares`
--
ALTER TABLE `rooms_nightmares`
  MODIFY `room_nightmare_id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rooms_players`
--
ALTER TABLE `rooms_players`
  MODIFY `room_players_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
