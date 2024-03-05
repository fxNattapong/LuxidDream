-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 05, 2024 at 09:07 PM
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
  `code` varchar(10) DEFAULT NULL,
  `skill` tinyint(2) DEFAULT NULL COMMENT '0=search , 1=listening, 2=link',
  `color` tinyint(2) DEFAULT NULL COMMENT '0=red, 1=yellow 2=green, 3=blue',
  `name` varchar(100) DEFAULT NULL,
  `description` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cards`
--

INSERT INTO `cards` (`card_id`, `code`, `skill`, `color`, `name`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, '111', 0, 0, 'สังเกตหาคนที่กำลังเผชิญกับความทุกข์ทรมาน', 'ตัวสั่น เจ็บปวด ร้องไห้ สับสน กังวล รู้สึกผิด โกรธ เป็นต้น', 'jXvWbvmG0x.png', '2024-02-23 02:15:40', '2024-03-03 14:30:17'),
(2, '112', 0, 0, 'สังเกตหาคนที่มีความเสี่ยงถูกแบ่งแยก', 'ควรได้รับการปกป้อง? มีความเสี่ยงจะเกิด ความรุนแรง ?', 'LI0ChKIRCA.png', '2024-02-23 02:25:59', '2024-03-03 14:30:27'),
(3, '113', 0, 0, 'สังเกตหาที่ปลอดภัย', 'อะไรที่เป็นอันตราย ? อันตรายกับตนเอง หรือผู้อื่น ?', 'j9oS6fFklJ.png', '2024-02-23 02:26:19', '2024-03-03 14:30:33'),
(4, '121', 1, 0, 'รับรู้ความรู้สึกและจุดแข็งของผู้อื่น และเคารพความเป็นส่วนตัว', '', 'Z9dZNLASbg.png', '2024-02-23 02:29:10', '2024-03-03 14:30:39'),
(5, '122', 1, 0, 'ซื่อสัตย์กับข้อมูลที่เรารู้และข้อมูล ที่เราไม่รู้', 'จัดเตรียมข้อมูล ที่เป็นจริง', 'YZqAUnkUD8.png', '2024-02-23 02:32:58', '2024-02-23 02:32:58'),
(6, '123', 1, 0, 'ไม่บังคับให้ต้องพูดและไม่ตัดสิน', '', 'UICIyCGsOE.png', '2024-02-23 02:33:27', '2024-03-03 14:31:04'),
(7, '211', 0, 1, 'สังเกตหาเด็กที่ต้องการได้รับ ความช่วยเหลือ', 'พามาหาผู้ดูแล', 'ZFT9FIflaT.png', '2024-02-23 02:34:03', '2024-03-03 14:31:32'),
(8, '221', 1, 1, 'ช่วยผู้อื่นให้เชื่อมโยงกับความรู้สึกทางกาย ของพวกเขา สิ่งแวดล้อม และลมหายใจ', '', '6YaX59xsYu.png', '2024-02-23 02:34:48', '2024-03-03 14:31:39'),
(9, '222', 1, 1, 'คอยสอบถามความต้องการและสิ่งที่กังวล', '', 'gMUyVLpNB1.png', '2024-02-23 02:35:25', '2024-03-03 14:31:46'),
(10, '231', 2, 1, 'ช่วยระบุแหล่งช่วยเหลือและสนับสนุน', '', 'IYEyoheIoq.png', '2024-02-23 02:36:23', '2024-02-23 02:36:33'),
(11, '232', 2, 1, 'หาข้อมูลที่แม่นยำและคอยส่งข่าว', '', 'CSBbv0wZ0F.png', '2024-02-23 02:36:52', '2024-03-03 14:32:28'),
(12, '233', 2, 1, 'ช่วยจัดลำดับความสำคัญและเร่งด่วน ว่าอะไรต้องทำก่อน', '', 'drt1wJGI0w.png', '2024-02-23 02:37:29', '2024-03-03 14:32:35'),
(13, '311', 0, 2, 'สังเกตหาคนที่ต้องการปัจจัยพื้นฐาน', 'อาหาร ที่พัก เสื้อผ้า น้ำสะอาด', 'c34O9VrBNz.png', '2024-02-23 02:38:14', '2024-03-03 14:32:43'),
(14, '312', 0, 2, 'สังเกตหาคนที่มีโรคประจำตัว หรือมีภาวะการเจ็บป่วยทางกาย', 'ต้องการเข้าถึง การบริการ ?', '3bh9tR52ou.png', '2024-02-23 02:40:12', '2024-03-03 14:32:48'),
(15, '313', 0, 2, 'สังเกตหาคนที่ต้องการความช่วยเหลือ ทางการแพทย์', '', 'bd3PASp6iu.png', '2024-02-23 02:40:37', '2024-03-03 14:32:55'),
(16, '314', 0, 2, 'สังเกตหาคนที่ต้องได้รับการช่วยชีวิต', 'มีการบาดเจ็บ ขั้นวิกฤต ?', 'KVM7B6AD9u.png', '2024-02-23 02:41:17', '2024-03-03 14:33:01'),
(17, '331', 2, 2, 'ช่วยระลึกถึงวิธีแก้ปัญหาในอดีต', '', 'Vwa5t79c5B.png', '2024-02-23 02:41:54', '2024-03-03 14:33:09'),
(18, '332', 2, 2, 'เชื่อมโยงการเข้าถึงบริการต่าง ๆ', '', 'a6cfUskEYO.png', '2024-02-23 02:42:25', '2024-03-03 14:33:17'),
(19, '421', 1, 3, 'ฟังโดยไม่แบ่งความสนใจ ตั้งใจฟัง ใส่ใจและให้เกียรติ', 'ฟังด้วยตา หู และ ใจ', '2mOftLwypG.png', '2024-02-23 02:43:03', '2024-03-03 14:33:22'),
(20, '422', 1, 3, 'ไม่สร้างเรื่องที่ไม่จริงและไม่สัญญา ในสิ่งที่ทำไม่ได้', '', 'eoxW4aSyId.png', '2024-02-23 02:43:27', '2024-03-03 14:33:29'),
(21, '423', 1, 3, 'เข้าหาด้วยความเคารพ แนะนำตัวเอง ช่วยให้เขารู้สึกสะดวกสบาย และทำให้เขารู้สึกปลอดภัย', '', '0LvzNeSFzl.png', '2024-02-23 02:44:01', '2024-03-03 14:33:34'),
(22, '431', 2, 3, 'ช่วยให้จัดการปัญหาด้วยวิธีเรียบง่าย', 'พูดคุยกับบางคน ใช้เวลากับครอบครัว หาวิธีปลอดภัย ในการช่วยเหลือคนอื่น', 'wOc5cJOgTL.png', '2024-02-23 02:44:45', '2024-03-03 14:33:43'),
(23, '432', 2, 3, 'ช่วยให้จัดการปัญหาด้วยวิธีเรียบง่าย', 'พักผ่อน กินอาหารสม่ำเสมอ ดูแขสุขภาวะอนามัย ผ่อนคลาย ออกกำลังกาย หลีกเลี่ยงสารเสพติด', 'x1uxk88HF9.png', '2024-02-23 02:45:11', '2024-03-03 14:33:49'),
(24, '433', 2, 3, 'เชื่อมโยงเขาเข้ากับคนที่รักและ สังคมที่คอยสนับสนุน', '', 'CJurmu0Mvk.png', '2024-02-23 02:45:40', '2024-03-03 14:33:56');

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
  `level` tinyint(2) DEFAULT NULL COMMENT '0=easy, 1=medium, 2=hard',
  `round` tinyint(2) DEFAULT NULL,
  `time_1` varchar(5) DEFAULT NULL,
  `time_2` varchar(5) DEFAULT NULL,
  `time_3` varchar(5) DEFAULT NULL,
  `time_4` varchar(5) DEFAULT NULL,
  `time_5` varchar(5) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`level_id`, `level`, `round`, `time_1`, `time_2`, `time_3`, `time_4`, `time_5`, `created_at`, `updated_at`) VALUES
(1, 0, 5, '7.00', '6.00', '5.00', '4.00', '3.30', '2024-02-22 21:14:52', '2024-02-22 21:14:52'),
(2, 1, 4, '7.00', '6.30', '6.00', '4.00', NULL, '2024-02-22 21:24:47', '2024-02-22 21:24:47'),
(3, 2, 5, '6.00', '4.00', '3.30', '3.00', NULL, '2024-02-22 21:24:58', '2024-02-22 21:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `links`
--

CREATE TABLE `links` (
  `link_id` int(5) NOT NULL,
  `type` tinyint(1) DEFAULT NULL COMMENT '0=stable, 1=empty, 2=dream',
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `links`
--

INSERT INTO `links` (`link_id`, `type`, `image`, `created_at`, `updated_at`) VALUES
(1, 0, 'bdPAd4rQA7.png', '2024-02-29 22:58:54', '2024-02-29 23:18:37'),
(2, 0, '7xmYMVlNMK.png', '2024-02-29 23:20:49', '2024-02-29 23:20:49'),
(3, 0, 'hku1Gezj4r.png', '2024-02-29 23:20:56', '2024-02-29 23:20:56'),
(4, 0, 'EZGNEy0KkB.png', '2024-02-29 23:21:15', '2024-02-29 23:21:15'),
(5, 0, '7q6xtqMljx.png', '2024-02-29 23:21:51', '2024-02-29 23:21:51'),
(6, 0, 'ZoLJzw6bwJ.png', '2024-02-29 23:22:04', '2024-02-29 23:22:04'),
(7, 0, 'Ab2DL33Itz.png', '2024-02-29 23:22:10', '2024-02-29 23:22:10'),
(8, 0, 'pPm8Cw2bWq.png', '2024-02-29 23:22:15', '2024-02-29 23:22:15'),
(9, 0, '36nLragrBf.png', '2024-02-29 23:23:31', '2024-02-29 23:23:31'),
(10, 0, 'YpBD8cknAk.png', '2024-02-29 23:24:25', '2024-02-29 23:24:25'),
(11, 0, 'rQ6yA7MPxK.png', '2024-02-29 23:24:38', '2024-02-29 23:24:38'),
(12, 0, 'aahgWYbHad.png', '2024-02-29 23:24:56', '2024-02-29 23:24:56'),
(13, 0, 'Nfwu42b6eo.png', '2024-02-29 23:25:03', '2024-02-29 23:25:03'),
(14, 0, '514lOjMmz2.png', '2024-02-29 23:25:14', '2024-02-29 23:25:14'),
(15, 0, 'xHATZpHhjG.png', '2024-02-29 23:25:23', '2024-02-29 23:25:23'),
(16, 0, 'Zk6rjJLusp.png', '2024-02-29 23:25:37', '2024-02-29 23:25:37'),
(17, 0, '90V73jCXh4.png', '2024-02-29 23:25:43', '2024-02-29 23:25:43'),
(18, 0, 'iaVPdqK3AK.png', '2024-02-29 23:25:51', '2024-02-29 23:25:51'),
(19, 0, '7HBsskEimz.png', '2024-02-29 23:26:14', '2024-02-29 23:26:14'),
(20, 0, 'vzisETJ2pW.png', '2024-02-29 23:26:24', '2024-02-29 23:26:24'),
(21, 1, 'aGujBP8wOA.png', '2024-02-29 23:36:42', '2024-02-29 23:36:42'),
(22, 2, 'RsCvWNtprO.png', '2024-02-29 23:36:42', '2024-03-03 20:11:05');

-- --------------------------------------------------------

--
-- Table structure for table `nightmares`
--

CREATE TABLE `nightmares` (
  `nightmare_id` int(5) NOT NULL,
  `type` tinyint(2) DEFAULT NULL COMMENT '0=anger, 1=anxiety, 2=panic, 3=sad, 4=peace, 5=start',
  `description` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nightmares`
--

INSERT INTO `nightmares` (`nightmare_id`, `type`, `description`, `image`, `created_at`, `updated_at`) VALUES
(1, 2, 'ฉันรับสิ่งรู้สิ่งแวดล้อมเปลี่ยนไปเหมือนตัวเองไม่ใช่ตัวเอง', 'QgONbHwAqj.png', '2024-02-22 22:40:39', '2024-03-03 16:18:08'),
(2, 2, 'ฉันกลัวความตาย', '1MhTztcvLF.png', '2024-02-22 22:47:17', '2024-03-03 16:18:11'),
(3, 2, 'ฉันรู้สึกสูญเสียการควบคุม', 'GGfJwmApVi.png', '2024-02-22 22:47:32', '2024-03-03 16:18:15'),
(4, 2, 'ฉันแปลความรู้สึกทางกาย แย่กว่าความเป็นจริง', 'Lu5csmAbfz.png', '2024-02-22 22:50:59', '2024-03-03 16:18:18'),
(5, 1, 'ฉันหลงลืมความสามารถในการรับมือกับปัญหา', 'kO0E1fyBXK.png', '2024-02-22 22:51:22', '2024-03-03 00:45:15'),
(6, 1, 'ฉันประเมินขนาดปัญหาใหญ่เกินไป', 'ntk59lKMi7.png', '2024-02-23 01:02:55', '2024-03-03 00:45:21'),
(7, 1, 'ฉันประเมินโอกาสเกิดปัญหาสูงไป', '7VtGhHN5l2.png', '2024-02-23 01:03:11', '2024-03-03 00:45:27'),
(8, 1, 'ฉันประเมินความสามารถตัวเองต่ำเกินไป', 'LAdOnh6ONL.png', '2024-02-23 01:03:28', '2024-03-03 00:45:41'),
(9, 0, 'ฉันโดนดูถูก', '04YKlrLEt5.png', '2024-02-23 01:04:02', '2024-03-03 16:17:47'),
(10, 0, 'ฉันถูกกล่าวหา', '8jSuk7iyjj.png', '2024-02-23 01:04:14', '2024-03-03 16:17:52'),
(11, 0, 'ฉันถูกละเมิด', 'B3cytNggX9.png', '2024-02-23 01:04:26', '2024-03-03 16:17:55'),
(12, 0, 'ฉันไม่ได้รับความยุติธรรม', 'cgz6xqEfSi.png', '2024-02-23 01:04:41', '2024-03-03 16:17:59'),
(13, 3, 'ฉันสิ้นหวังไร้ซึ่งหนทาง', 'sv5Ey8KZje.png', '2024-02-23 01:05:45', '2024-03-03 00:41:56'),
(14, 3, 'ฉันมองตัวเองไม่ดี', 'Wuk4In71lu.png', '2024-02-23 01:06:02', '2024-03-03 00:42:47'),
(15, 3, 'ฉันมองว่าผู้อื่นไม่ดีกับฉัน', 'XtDVZCBSEY.png', '2024-02-23 01:06:19', '2024-03-03 00:43:29'),
(16, 3, 'ฉันมองว่าอนาคตจะมีแต่เรื่องไม่ดี', 'XvAGHWk24c.png', '2024-02-23 01:06:55', '2024-03-03 00:43:57'),
(17, 4, 'สงบ', 'c8DWamhseD.png', '2024-02-23 01:08:32', '2024-03-03 00:40:50'),
(18, 5, 'การ์ดเริ่ม', 'sKjK1S4VbJ.png', '2024-02-29 17:01:26', '2024-03-03 00:39:35');

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
  `role` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0=player, 1=admin',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `player_rule_id` int(5) DEFAULT NULL,
  `level_id` int(5) DEFAULT NULL,
  `invite_code` varchar(30) DEFAULT NULL,
  `creator_name` varchar(50) DEFAULT NULL,
  `round` tinyint(1) DEFAULT 0,
  `circle` tinyint(1) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `player_rule_id`, `level_id`, `invite_code`, `creator_name`, `round`, `circle`, `time`, `created_at`, `updated_at`) VALUES
(1, 1, 2, '411131', 'admin', 2, 2, NULL, '2024-03-04 18:09:38', '2024-03-06 02:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_cards`
--

CREATE TABLE `rooms_cards` (
  `room_card_id` int(5) NOT NULL,
  `room_link_id` int(5) DEFAULT NULL,
  `code` varchar(10) DEFAULT NULL,
  `position` tinyint(1) DEFAULT NULL COMMENT '0=first, 1=second, 2=third, 3=fourth',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_cards`
--

INSERT INTO `rooms_cards` (`room_card_id`, `room_link_id`, `code`, `position`, `created_at`, `updated_at`) VALUES
(1, 2, '222', 0, '2024-03-04 18:42:31', '2024-03-04 18:42:31'),
(2, 2, '311', 1, '2024-03-04 18:42:37', '2024-03-04 18:42:37'),
(3, 2, '211', 2, '2024-03-04 19:47:02', '2024-03-04 19:47:02'),
(4, 2, '331', 3, '2024-03-04 19:59:00', '2024-03-04 19:59:00'),
(5, 3, '221', 1, '2024-03-04 20:08:45', '2024-03-04 20:08:45'),
(6, 3, '121', 0, '2024-03-04 20:08:53', '2024-03-04 20:08:53'),
(7, 3, '111', 2, '2024-03-04 20:09:03', '2024-03-04 20:09:03'),
(8, 3, '211', 3, '2024-03-04 20:09:08', '2024-03-04 20:09:08'),
(9, 4, '111', 1, '2024-03-05 00:23:31', '2024-03-05 00:23:31'),
(10, 4, '421', 0, '2024-03-05 00:24:15', '2024-03-05 00:24:15'),
(11, 4, '112', 3, '2024-03-05 00:24:57', '2024-03-05 00:24:57'),
(12, 4, '422', 2, '2024-03-05 00:25:00', '2024-03-05 00:25:00');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_links`
--

CREATE TABLE `rooms_links` (
  `room_link_id` int(5) NOT NULL,
  `room_id` int(5) DEFAULT NULL,
  `room_nightmare_id` int(5) DEFAULT NULL,
  `link_id` int(5) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0 COMMENT '0=dream, 1=calm',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_links`
--

INSERT INTO `rooms_links` (`room_link_id`, `room_id`, `room_nightmare_id`, `link_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 21, 1, '2024-03-04 18:09:42', '2024-03-04 18:09:42'),
(2, 1, 2, 8, 1, '2024-03-04 18:09:42', '2024-03-04 19:59:01'),
(3, 1, 3, 7, 1, '2024-03-04 18:09:42', '2024-03-04 20:09:08'),
(4, 1, 4, 11, 1, '2024-03-04 18:09:42', '2024-03-05 00:25:00'),
(5, 1, 5, 21, 1, '2024-03-04 18:09:42', '2024-03-04 18:09:42'),
(6, 1, 7, 22, 0, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(7, 1, 8, 22, 0, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(8, 1, 9, 22, 0, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(9, 1, 10, 22, 0, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(10, 1, 11, 22, 0, '2024-03-06 02:10:24', '2024-03-06 02:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_nightmares`
--

CREATE TABLE `rooms_nightmares` (
  `room_nightmare_id` int(5) NOT NULL,
  `room_id` int(5) DEFAULT NULL,
  `room_link_id` int(5) DEFAULT NULL,
  `nightmare_id` int(5) DEFAULT NULL,
  `circle` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `rooms_nightmares`
--

INSERT INTO `rooms_nightmares` (`room_nightmare_id`, `room_id`, `room_link_id`, `nightmare_id`, `circle`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 18, 1, '2024-03-04 18:09:42', '2024-03-04 18:09:42'),
(2, 1, 2, 4, 1, '2024-03-04 18:09:42', '2024-03-04 18:09:42'),
(3, 1, 3, 5, 1, '2024-03-04 18:09:42', '2024-03-06 01:36:13'),
(4, 1, 4, 10, 1, '2024-03-04 18:09:42', '2024-03-04 18:09:42'),
(5, 1, 5, 15, 1, '2024-03-04 18:09:42', '2024-03-04 18:09:42'),
(6, 1, 2, 4, 2, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(7, 1, 6, 5, 2, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(8, 1, 7, 1, 2, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(9, 1, 8, 7, 2, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(10, 1, 9, 12, 2, '2024-03-06 02:10:24', '2024-03-06 02:10:24'),
(11, 1, 10, 16, 2, '2024-03-06 02:10:24', '2024-03-06 02:10:24');

-- --------------------------------------------------------

--
-- Table structure for table `rooms_players`
--

CREATE TABLE `rooms_players` (
  `room_player_id` int(5) NOT NULL,
  `player_id` int(5) DEFAULT NULL,
  `room_id` int(5) DEFAULT NULL,
  `name_ingame` varchar(50) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0 COMMENT '0=not ready, 1=ready,\r\n2=dis, 3=playing, 4=end',
  `role` tinyint(2) DEFAULT 0 COMMENT '0=player, 1=creator',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rooms_players`
--

INSERT INTO `rooms_players` (`room_player_id`, `player_id`, `room_id`, `name_ingame`, `status`, `role`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'creator', 1, 1, '2024-03-04 18:09:38', '2024-03-05 22:04:46'),
(2, 2, 1, 'player', 0, 0, '2024-03-04 18:09:38', '2024-03-06 02:15:24');

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
-- Indexes for table `links`
--
ALTER TABLE `links`
  ADD PRIMARY KEY (`link_id`);

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
  ADD PRIMARY KEY (`room_card_id`);

--
-- Indexes for table `rooms_links`
--
ALTER TABLE `rooms_links`
  ADD PRIMARY KEY (`room_link_id`);

--
-- Indexes for table `rooms_nightmares`
--
ALTER TABLE `rooms_nightmares`
  ADD PRIMARY KEY (`room_nightmare_id`);

--
-- Indexes for table `rooms_players`
--
ALTER TABLE `rooms_players`
  ADD PRIMARY KEY (`room_player_id`);

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
-- AUTO_INCREMENT for table `links`
--
ALTER TABLE `links`
  MODIFY `link_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `nightmares`
--
ALTER TABLE `nightmares`
  MODIFY `nightmare_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `players`
--
ALTER TABLE `players`
  MODIFY `player_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `room_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rooms_cards`
--
ALTER TABLE `rooms_cards`
  MODIFY `room_card_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `rooms_links`
--
ALTER TABLE `rooms_links`
  MODIFY `room_link_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `rooms_nightmares`
--
ALTER TABLE `rooms_nightmares`
  MODIFY `room_nightmare_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `rooms_players`
--
ALTER TABLE `rooms_players`
  MODIFY `room_player_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
