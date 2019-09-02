-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: worshiphhn.org.mysql.service.one.com:3306
-- Generation Time: Aug 07, 2019 at 08:21 AM
-- Server version: 10.3.14-MariaDB-1:10.3.14+maria~bionic
-- PHP Version: 7.2.19-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `worshiphhn_org`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `activity_type_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `team_id` int(11) DEFAULT NULL,
  `song_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `special_needs` text DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `global_order` int(11) NOT NULL DEFAULT 0,
  `bible_verse` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `activity_type_id`, `event_id`, `user_id`, `team_id`, `song_id`, `name`, `description`, `special_needs`, `start_time`, `end_time`, `global_order`, `bible_verse`) VALUES
(132, 25, 19, 18, NULL, NULL, 'Presentation technition', NULL, NULL, NULL, NULL, 4, NULL),
(133, 17, 19, NULL, NULL, NULL, 'Prayer basket', NULL, NULL, '11:15:00', NULL, 0, NULL),
(134, 22, 19, NULL, 6, NULL, 'Intercessory prayer team', NULL, NULL, NULL, NULL, 6, NULL),
(135, 21, 19, 21, NULL, NULL, 'Sound technition', NULL, NULL, NULL, NULL, 5, NULL),
(136, 28, 19, NULL, 5, NULL, 'Praise and worship team', NULL, NULL, NULL, NULL, 3, NULL),
(137, 23, 19, 6, NULL, NULL, 'Meeting leader (MC)', NULL, NULL, NULL, NULL, 2, NULL),
(138, 24, 19, 22, NULL, NULL, 'Meeting organizer', NULL, NULL, NULL, NULL, 1, NULL),
(139, 18, 19, 15, NULL, NULL, 'Sermon', NULL, NULL, '11:37:00', NULL, 0, '65,1188,17,-1;17,443,11,20;46,1085,4,8'),
(140, 29, 19, NULL, 8, NULL, 'Hosting team', NULL, NULL, NULL, NULL, 8, NULL),
(141, 20, 19, 20, NULL, NULL, 'Video technition', NULL, NULL, NULL, NULL, 7, NULL),
(182, 19, 19, NULL, NULL, NULL, 'Announcements', NULL, NULL, '11:20:00', NULL, 0, NULL),
(183, 16, 19, NULL, NULL, 1574, 'Song', NULL, NULL, '11:09:00', NULL, 0, NULL),
(184, 27, 19, NULL, NULL, NULL, 'Welcome all', '', NULL, '11:00:00', NULL, 0, NULL),
(185, 16, 19, NULL, NULL, 1579, 'Song', NULL, NULL, '11:03:00', NULL, 0, NULL),
(186, 30, 19, NULL, NULL, NULL, 'Collect', NULL, NULL, '11:25:00', NULL, 0, NULL),
(187, 16, 19, NULL, NULL, 1705, 'Song', NULL, NULL, '12:30:00', NULL, 0, NULL),
(188, 16, 19, NULL, NULL, 1593, 'Song', NULL, NULL, '12:35:00', NULL, 0, NULL),
(189, 16, 19, NULL, NULL, 1592, 'Song', NULL, NULL, '12:40:00', NULL, 0, NULL),
(207, 25, 31, 18, NULL, NULL, 'Presentation technition', NULL, NULL, NULL, NULL, 4, NULL),
(210, 21, 31, 21, NULL, NULL, 'Sound technition', NULL, NULL, NULL, NULL, 5, NULL),
(211, 28, 31, NULL, 5, NULL, 'Praise and worship team', NULL, NULL, NULL, NULL, 3, NULL),
(212, 23, 31, 15, NULL, NULL, 'Meeting leader (MC)', NULL, NULL, NULL, NULL, 2, NULL),
(213, 24, 31, 22, NULL, NULL, 'Meeting organizer', NULL, NULL, NULL, NULL, 1, NULL),
(214, 18, 31, 15, NULL, NULL, 'Sermon', NULL, NULL, '11:37:00', NULL, 0, NULL),
(215, 29, 31, NULL, 8, NULL, 'Hosting team', NULL, NULL, NULL, NULL, 8, NULL),
(217, 19, 31, NULL, NULL, NULL, 'Announcements', NULL, NULL, '11:20:00', NULL, 0, NULL),
(218, 16, 31, NULL, NULL, 1574, 'Song', NULL, NULL, '11:09:00', NULL, 0, NULL),
(219, 27, 31, NULL, NULL, NULL, 'Welcome all', NULL, NULL, '11:00:00', NULL, 0, NULL),
(220, 16, 31, NULL, NULL, 1579, 'Song', NULL, NULL, '11:03:00', NULL, 0, NULL),
(221, 30, 31, NULL, NULL, NULL, 'Collect', NULL, NULL, '11:25:00', NULL, 0, NULL),
(222, 16, 31, NULL, NULL, 1705, 'Song', NULL, NULL, '12:30:00', NULL, 0, NULL),
(223, 16, 31, NULL, NULL, 1593, 'Song', NULL, NULL, '12:35:00', NULL, 0, NULL),
(224, 16, 31, NULL, NULL, 1592, 'Song', NULL, NULL, '12:40:00', NULL, 0, NULL),
(225, 25, 32, 18, NULL, NULL, 'Presentation technition', NULL, NULL, NULL, NULL, 4, NULL),
(226, 17, 32, NULL, NULL, NULL, 'Prayer basket', NULL, NULL, '11:15:00', NULL, 0, NULL),
(227, 22, 32, NULL, 6, NULL, 'Intercessory prayer team', NULL, NULL, NULL, NULL, 6, NULL),
(228, 21, 32, 21, NULL, NULL, 'Sound technition', NULL, NULL, NULL, NULL, 5, NULL),
(229, 28, 32, NULL, 5, NULL, 'Praise and worship team', NULL, NULL, NULL, NULL, 3, NULL),
(230, 23, 32, 15, NULL, NULL, 'Meeting leader (MC)', NULL, NULL, NULL, NULL, 2, NULL),
(231, 24, 32, 22, NULL, NULL, 'Meeting organizer', NULL, NULL, NULL, NULL, 1, NULL),
(232, 18, 32, 15, NULL, NULL, 'Sermon', NULL, NULL, '11:37:00', NULL, 0, NULL),
(233, 29, 32, NULL, 8, NULL, 'Hosting team', NULL, NULL, NULL, NULL, 8, NULL),
(234, 20, 32, 20, NULL, NULL, 'Video technition', NULL, NULL, NULL, NULL, 7, NULL),
(235, 19, 32, NULL, NULL, NULL, 'Announcements', NULL, NULL, '11:20:00', NULL, 0, NULL),
(236, 16, 32, NULL, NULL, 1574, 'Song', NULL, NULL, '11:09:00', NULL, 0, NULL),
(237, 27, 32, NULL, NULL, NULL, 'Welcome all', NULL, NULL, '11:00:00', NULL, 0, NULL),
(238, 16, 32, NULL, NULL, 1579, 'Song', NULL, NULL, '11:03:00', NULL, 0, NULL),
(239, 30, 32, NULL, NULL, NULL, 'Collect', NULL, NULL, '11:25:00', NULL, 0, NULL),
(240, 16, 32, NULL, NULL, 1705, 'Song', NULL, NULL, '12:30:00', NULL, 0, NULL),
(241, 16, 32, NULL, NULL, 1593, 'Song', NULL, NULL, '12:35:00', NULL, 0, NULL),
(242, 16, 32, NULL, NULL, 1592, 'Song', NULL, NULL, '12:40:00', NULL, 0, NULL),
(243, 25, 33, 18, NULL, NULL, 'Presentation technition', NULL, NULL, NULL, NULL, 4, NULL),
(244, 21, 33, 21, NULL, NULL, 'Sound technition', NULL, NULL, NULL, NULL, 5, NULL),
(245, 28, 33, NULL, 5, NULL, 'Praise and worship team', NULL, NULL, NULL, NULL, 3, NULL),
(246, 23, 33, 15, NULL, NULL, 'Meeting leader (MC)', NULL, NULL, NULL, NULL, 2, NULL),
(247, 24, 33, 22, NULL, NULL, 'Meeting organizer', NULL, NULL, NULL, NULL, 1, NULL),
(248, 18, 33, 15, NULL, NULL, 'Sermon', NULL, NULL, '11:37:00', NULL, 0, NULL),
(249, 29, 33, NULL, 8, NULL, 'Hosting team', NULL, NULL, NULL, NULL, 8, NULL),
(250, 19, 33, NULL, NULL, NULL, 'Announcements', NULL, NULL, '11:20:00', NULL, 0, NULL),
(251, 16, 33, NULL, NULL, 1574, 'Song', NULL, NULL, '11:09:00', NULL, 0, NULL),
(252, 27, 33, NULL, NULL, NULL, 'Welcome all', NULL, NULL, '11:00:00', NULL, 0, NULL),
(253, 16, 33, NULL, NULL, 1579, 'Song', NULL, NULL, '11:03:00', NULL, 0, NULL),
(254, 30, 33, NULL, NULL, NULL, 'Collect', NULL, NULL, '11:25:00', NULL, 0, NULL),
(255, 16, 33, NULL, NULL, 1705, 'Song', NULL, NULL, '12:30:00', NULL, 0, NULL),
(256, 16, 33, NULL, NULL, 1593, 'Song', NULL, NULL, '12:35:00', NULL, 0, NULL),
(257, 16, 33, NULL, NULL, 1592, 'Song', NULL, NULL, '12:40:00', NULL, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `activity_type`
--

CREATE TABLE `activity_type` (
  `id` int(11) NOT NULL,
  `church_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `using_user` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `notify_user_event_errors` tinyint(4) NOT NULL,
  `using_team` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `team_type_id` int(11) DEFAULT NULL,
  `description` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `use_globally` tinyint(4) NOT NULL,
  `using_song` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `file` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `bible_verse` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `special_needs` enum('Not used','Allow','Demand') NOT NULL DEFAULT 'Not used',
  `default_global_order` int(11) NOT NULL,
  `default_start_time` time DEFAULT NULL,
  `default_end_time` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity_type`
--

INSERT INTO `activity_type` (`id`, `church_id`, `name`, `using_user`, `notify_user_event_errors`, `using_team`, `team_type_id`, `description`, `use_globally`, `using_song`, `file`, `bible_verse`, `special_needs`, `default_global_order`, `default_start_time`, `default_end_time`) VALUES
(16, 2, 'Song', 'Not used', 0, 'Not used', NULL, 'Not used', 0, 'Demand', 'Not used', 'Not used', 'Not used', 0, NULL, NULL),
(17, 2, 'Prayer basket', 'Not used', 0, 'Not used', NULL, 'Not used', 0, 'Not used', 'Not used', 'Not used', 'Not used', 0, NULL, NULL),
(18, 2, 'Sermon', 'Demand', 0, 'Not used', NULL, 'Not used', 0, 'Not used', 'Not used', 'Allow', 'Not used', 0, NULL, NULL),
(19, 2, 'Announcements', 'Allow', 0, 'Not used', NULL, 'Not used', 0, 'Not used', 'Not used', 'Not used', 'Not used', 0, NULL, NULL),
(20, 2, 'Video technition', 'Demand', 0, 'Not used', NULL, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 7, NULL, NULL),
(21, 2, 'Sound technition', 'Demand', 0, 'Not used', NULL, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 5, NULL, NULL),
(22, 2, 'Intercessory prayer', 'Not used', 0, 'Demand', 9, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 6, NULL, NULL),
(23, 2, 'Meeting leader (MC)', 'Demand', 0, 'Not used', NULL, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 2, NULL, NULL),
(24, 2, 'Meeting organizer', 'Demand', 1, 'Not used', NULL, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 1, NULL, NULL),
(25, 2, 'Presentation technition', 'Demand', 0, 'Not used', NULL, 'Not used', 1, 'Not used', 'Allow', 'Not used', 'Not used', 4, NULL, NULL),
(26, 2, 'Baptism', 'Not used', 0, 'Not used', NULL, 'Not used', 0, 'Not used', 'Not used', 'Not used', 'Not used', 0, NULL, NULL),
(27, 2, 'Other', 'Not used', 0, 'Not used', NULL, 'Allow', 0, 'Not used', 'Not used', 'Not used', 'Not used', 0, NULL, NULL),
(28, 2, 'Praise and worship team', 'Not used', 0, 'Demand', 8, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 3, NULL, NULL),
(29, 2, 'Hosting team', 'Not used', 0, 'Demand', 10, 'Not used', 1, 'Not used', 'Not used', 'Not used', 'Not used', 8, NULL, NULL),
(30, 2, 'Collect', 'Not used', 0, 'Allow', 10, 'Not used', 0, 'Not used', 'Not used', 'Not used', 'Not used', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `attach_file`
--

CREATE TABLE `attach_file` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `mime` varchar(100) NOT NULL,
  `itemId` int(11) NOT NULL,
  `hash` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `model` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `attach_file`
--

INSERT INTO `attach_file` (`id`, `name`, `mime`, `itemId`, `hash`, `size`, `model`) VALUES
(170, 'ruth.jpg', 'image/jpeg', 14, 'KoU3BDWDJgpmuG1dvpZKbGOWxoRKQF', 48113, 'user'),
(171, 'kalle.jpg', 'image/jpeg', 15, 'rR2p5sjboXuXawJjckDJVk1KLkhDB0', 40669, 'user'),
(174, 'malin.png', 'image/png', 16, 'jGNlZ3T3CIa2hswlrbGOXfng5tWJT6', 444238, 'user'),
(175, 'gabriel.png', 'image/png', 19, 'feu3VgZARRhonloOaWvlYnnKfi4emX', 61371, 'user'),
(176, 'malek.png', 'image/png', 20, '2rkAtiqyDh402hqoSqETGu6J4JqMy1', 7345, 'user'),
(177, 'profile.png', 'image/png', 6, '4cJNcw2P8H5tbmHKSdVvmjyalUojTu', 72768, 'user'),
(182, 'oska.jpg', 'image/jpeg', 23, 'MeGaBOuv0XMWQmI9Dexw02c3YQImX7', 969930, 'user'),
(184, 'IMG_20190728_102303050.jpg', 'image/jpeg', 22, 'qlOpIrp8WQua8hUuFy8GRggxdfz6Vn', 776668, 'user'),
(186, 'marita.jpg', 'image/jpeg', 24, '95k4z0YluuqwdOGff6wIViDUUVXGrU', 6867, 'user'),
(188, 'gustav_n.jpg', 'image/jpeg', 25, 'RX6GbGnPvuGkc2YSpkFumAmvySy28z', 3681, 'user'),
(189, 'Annika-Nilsson.jpg', 'image/jpeg', 28, 'wGpE4YipQWTLZ8xGLBiuav3X7naldK', 47138, 'user'),
(190, 'Classe.png', 'image/png', 27, 'vvGX8lVEqSsUqgYyqF9f2LoqVn0u7x', 42132, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('ChurchAdmin', 14, 1565114952),
('ChurchAdmin', 36, 1565099864),
('ChurchAdmin', 42, 1565151779),
('EventEditor', 15, 1564923348),
('EventEditor', 24, 1564924454),
('EventManager', 16, 1564924415),
('EventManager', 19, 1564923659),
('EventManager', 22, 1564924589),
('Member', 17, 1564923708),
('Member', 18, 1564923284),
('Member', 20, 1564924543),
('Member', 21, 1564924730),
('Member', 23, 1564924795),
('Member', 26, 1564924359),
('Member', 27, 1564923625),
('Member', 28, 1564924283),
('MemberUnaccepted', 30, 1564868748),
('MemberUnaccepted', 31, 1564869062),
('MemberUnaccepted', 32, 1564869246),
('MemberUnaccepted', 39, 1565112404),
('MemberUnaccepted', 40, 1565112621),
('TeamManager', 25, 1564924316),
('theCreator', 6, 1565165947);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('ChurchAdmin', 1, 'Can do anything inside of one church', NULL, NULL, 1561583215, 1561583215),
('EventEditor', 1, 'Member plus can edit events', NULL, NULL, 1561583215, 1561583215),
('EventManager', 1, 'Can add, delete, update events.', NULL, NULL, 1561583215, 1561583215),
('Member', 1, 'Accepted member', NULL, NULL, 1561583215, 1561583215),
('MemberUnaccepted', 1, 'An email validated member that is not yet accepted to be a normal member ', NULL, NULL, 1561583215, 1561583215),
('TeamManager', 1, 'Can manage his own team', NULL, NULL, 1561583215, 1561583215),
('theCreator', 1, 'Can create churches', NULL, NULL, 1561583215, 1561583215);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('ChurchAdmin', 'EventManager'),
('EventEditor', 'Member'),
('EventManager', 'TeamManager'),
('Member', 'MemberUnaccepted'),
('TeamManager', 'EventEditor'),
('theCreator', 'ChurchAdmin');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bible`
--

CREATE TABLE `bible` (
  `id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `church_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bible_contents`
--

CREATE TABLE `bible_contents` (
  `id` int(11) NOT NULL,
  `bible_id` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `chapter` int(11) NOT NULL,
  `verse` int(11) NOT NULL,
  `text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `bible_verse`
--

CREATE TABLE `bible_verse` (
  `id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `book` int(11) NOT NULL,
  `chapter` int(11) NOT NULL,
  `verse` int(11) NOT NULL,
  `to_verse` int(11) NOT NULL,
  `order_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `church`
--

CREATE TABLE `church` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `admin_email` varchar(100) DEFAULT NULL,
  `time_zone` varchar(50) NOT NULL DEFAULT 'Europe/Stockholm',
  `paper_size` varchar(50) NOT NULL DEFAULT 'A4',
  `paper_margin_top_bottom` float NOT NULL DEFAULT 0.25,
  `paper_margin_right_left` float NOT NULL DEFAULT 0.5
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `church`
--

INSERT INTO `church` (`id`, `name`, `admin_email`, `time_zone`, `paper_size`, `paper_margin_top_bottom`, `paper_margin_right_left`) VALUES
(2, 'Generic Church', 'thomas@gmail.com', 'Europe/Stockholm', 'A4', 0.25, 0.5);

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `church_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `church_id`, `name`, `description`, `start_date`, `end_date`) VALUES
(19, 2, 'Sunday service', NULL, '2019-08-25 11:00:00', '2019-08-25 13:30:00'),
(31, 2, 'Wednesday prayer meeting', NULL, '2019-08-28 18:00:00', '2019-08-28 19:30:00'),
(32, 2, 'Sunday service', NULL, '2019-09-01 11:00:00', '2019-09-01 13:30:00'),
(33, 2, 'Wednesday prayer meeting', NULL, '2019-09-04 18:00:00', '2019-09-04 19:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `language`
--

CREATE TABLE `language` (
  `id` int(11) NOT NULL,
  `iso_name` varchar(7) DEFAULT NULL,
  `display_name_english` varchar(100) NOT NULL,
  `display_name_native` varchar(100) NOT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `language`
--

INSERT INTO `language` (`id`, `iso_name`, `display_name_english`, `display_name_native`, `church_id`) VALUES
(3, 'en-US', 'English', 'English', 2),
(4, 'sv', 'Swedish', 'Svenska', 2),
(6, 'fr', 'French', 'Française', 2),
(7, 'de', 'German', 'Deutsche', 2),
(8, 'fi', 'Finish', 'Suomalainen', 2),
(9, 'ru', 'Russian', 'русский', 2),
(10, 'pt', 'Portuguese', 'Português', 2),
(11, 'es', 'Spanish', 'Español', 2),
(12, 'ar', 'Arabic', 'العربية', 2),
(13, 'no', 'Norwegian', 'Norsk', 2),
(14, 'da', 'Danish', 'Dansk', 2),
(38, 'ja', 'Japanese', '日本人', 2),
(39, 'ko', 'Korean', '한국어', 2),
(40, 'it', 'Italian', 'Italiana', 2),
(41, 'zh-CN', 'Simplified Chinese', '中文', 2),
(42, 'zh-TW', 'Traditional Chinese', '繁體中文', 2),
(43, 'th', 'Thai', 'ไทย', 2),
(44, 'tl', 'Filipino', 'Pilipino', 2),
(45, 'id', 'Indonesian', 'Bahasa Indonesia', 2);

-- --------------------------------------------------------

--
-- Table structure for table `message_template`
--

CREATE TABLE `message_template` (
  `id` int(11) NOT NULL,
  `church_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `message_type_id` int(11) NOT NULL,
  `message_system` enum('Email','SMS') NOT NULL DEFAULT 'Email',
  `name` varchar(100) NOT NULL,
  `show_accept_button` tinyint(4) NOT NULL,
  `show_reject_button` tinyint(4) NOT NULL,
  `show_link_to_object` tinyint(4) NOT NULL,
  `allow_custom_message` tinyint(4) NOT NULL,
  `accept_button_text` varchar(200) NOT NULL,
  `reject_button_text` varchar(200) NOT NULL,
  `link_text` varchar(200) NOT NULL,
  `use_auto_subject` tinyint(4) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `body` mediumtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `message_template`
--

INSERT INTO `message_template` (`id`, `church_id`, `language_id`, `message_type_id`, `name`, `show_accept_button`, `show_reject_button`, `show_link_to_object`, `allow_custom_message`, `accept_button_text`, `reject_button_text`, `link_text`, `use_auto_subject`, `subject`, `body`) VALUES
(18, 2, 4, 1, 'Kräva svar', 1, 1, 1, 1, 'Ja, jag kommer', 'Nej, jag kommer inte', 'Klicka här för att se evenemäng', 1, '', 'Du är schemalagt till att göra uppgiften som angivs i ämnet av detta mejl. Var snäll och meddela oss om du kan eller inte kan komma och göra uppgiften igenom att trycka på en av knapparna nedan.\r\nOm du vill se mer om evenemanget klicka på länken längst ner i mejlet.\r\nTack och Gud Välsigna Dig!'),
(20, 2, 3, 1, 'Demand reply', 1, 1, 1, 1, 'Yes, I will come and do this.', 'No, I can\'t come.', 'Click here to see the event', 1, '', 'You are scheduled to do the task given in the subject of this email. Please let us know if you can come or not by clicking on one of the buttons below.  \r\nIf you want to see more about the event then click on the link at the bottom of the email.\r\nThank you and may God Bless You!'),
(21, 2, 3, 4, 'Reminder with \'no\' reply', 0, 1, 1, 1, '', 'No, I can\'t come and do the task', 'Click here to see the event', 1, '', 'You are scheduled to do the task given in the subject of this email. Please let us know if you can\'t come by clicking on the button below.  \r\nIf you want to see more about the event then click on the link at the bottom of the email.\r\nThank you and may God Bless You!'),
(22, 2, 4, 4, 'Endast \'nej\' svar angiven', 0, 1, 1, 1, '', 'Nej, jag kommer inte.', 'Klicka här för att se evenemanget', 1, '', 'Du är schemalagt till att göra uppgiften som angivs i ämnet av detta mejl. Var snäll och meddela oss om du inte kan komma och göra uppgiften igenom att trycka på knappen nedan.\r\nOm du vill se mer om evenemanget klicka på länken längst ner i mejlet.\r\nTack och Gud Välsigna Dig!'),
(23, 2, 4, 2, 'Påminnelse endast', 0, 0, 1, 1, '', '', 'Klicka här för att se evenemanget', 1, '', 'Detta är bara en påminnelse att du är schemalagt till att göra uppgiften som angivs i ämnet av detta mejl. \r\n\r\nOm du vill se mer om evenemanget klicka på länken längst ner i mejlet.\r\n\r\nTack och Gud Välsigna Dig!'),
(24, 2, 3, 2, 'Reminder only', 0, 0, 0, 1, '', '', '', 1, '', 'This is just a reminder that you are scheduled to do the task given in the subject of this email. \r\n\r\nIf you want to see more about the event then click on the link at the bottom of the email.\r\n\r\nThank you and may God Bless You!'),
(25, 2, 4, 5, 'Tomt brev', 0, 0, 1, 1, '', '', 'Klicka här för att se evenemanget', 1, '', 'Gud Välsigna dig!'),
(26, 2, 3, 5, 'Empty email', 0, 0, 1, 1, '', '', 'Click here to see the event', 1, '', 'may God Bless You !');

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE `message_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `message_type`
--

INSERT INTO `message_type` (`id`, `name`, `church_id`) VALUES
(1, 'Demand yes or no reply', 2),
(2, 'Reminder', 2),
(4, 'Demand \'no\' reply only', 2),
(5, 'Empty letter', 2);

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1561583195),
('m141022_115823_create_user_table', 1561583199),
('m141022_115912_create_rbac_tables', 1561583199);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `status` enum('Not replied yet','Accepted','Rejected','No reply requested') NOT NULL DEFAULT 'Not replied yet',
  `sms_status` varchar(400) DEFAULT NULL,
  `sms_status_id` varchar(200) DEFAULT NULL,
  `sms_id` varchar(200) DEFAULT NULL,
  `event_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `team_id` int(11) DEFAULT NULL,
  `message_template_id` int(11) NOT NULL,
  `notify_key` varchar(100) DEFAULT NULL,
  `notified_date` datetime DEFAULT NULL,
  `notify_replied_date` datetime DEFAULT NULL,
  `message_name` varchar(200) DEFAULT NULL,
  `message_html` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `status`, `event_id`, `activity_id`, `user_id`, `team_id`, `message_template_id`, `notify_key`, `notified_date`, `notify_replied_date`, `message_name`, `message_html`) VALUES
(44, 'Not replied yet', 19, 137, 6, NULL, 20, 'tbEg7k1NJV70ad5azKL43X8KiNWbLvmT6AcYrKI7rMrblZ4cgL', '2019-08-04 21:26:30', NULL, 'Demand reply', '<div  style=\'min-width:100%;\' ></div>\r\n<hr style=\'color:lightblue;background-color:lightblue;height:2px;margin:3px;\' />\r\n<p  style=\'width:100%;margin-bottom:30px;\' >You are scheduled to do the task given in the subject of this email. Please let us know if you can come or not by clicking on one of the buttons below.  <br />If you want to see more about the event then click on the link at the bottom of the email.<br />Thank you and may God Bless You!</p>\r\n<div  style=\'min-width:100%;\' >\r\n<div style=\'display:inline-block;margin-bottom:40px;white-space: nowrap\'><a href=\'http://jesusislord.se/whhn/site/reply?type=accept&hash=tbEg7k1NJV70ad5azKL43X8KiNWbLvmT6AcYrKI7rMrblZ4cgL\' style=\'text-decoration: none;background-color:lightgreen;color:black;padding:10px;margin:5px;border-top: 2px solid #CCCCCC;border-right: 2px solid #333333;border-bottom: 2px solid #333333;border-left: 2px solid #CCCCCC;\' >Yes, I will come and do this.</a></div>\r\n<div style=\'display:inline-block;margin-bottom:40px;white-space: nowrap\'><a href=\'http://jesusislord.se/whhn/site/reply?type=reject&hash=tbEg7k1NJV70ad5azKL43X8KiNWbLvmT6AcYrKI7rMrblZ4cgL\' style=\'text-decoration: none;background-color:lightpink;color:black;padding:10px;margin:5px;border-top: 2px solid #CCCCCC;border-right: 2px solid #333333;border-bottom: 2px solid #333333;border-left: 2px solid #CCCCCC;\' >No, I can&#039;t come.</a></div>\r\n</div>\r\n<a href=\'http://jesusislord.se/whhn/event/activities?id=19\' style=\'background-color: #d2f5ff;color:blue;text-decoration:underline;width:100%\'>Click here to see the event</a>');

-- --------------------------------------------------------

--
-- Table structure for table `song`
--

CREATE TABLE `song` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `name2` varchar(100) DEFAULT NULL,
  `author` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `song`
--

INSERT INTO `song` (`id`, `name`, `name2`, `author`, `description`, `church_id`) VALUES
(1574, 'Amazing Grace', NULL, 'John Newton', 'Amazing Grace! how sweet the sound\r\nThat saved a wretch like me;\r\nI once was lost, but now am found,\r\nWas blind, but now I see.\r\n\r\n’Twas grace that taught my heart to fear,\r\nAnd grace my fears relieved;\r\nHow precious did that grace appear,\r\nThe hour I first believed!\r\n\r\nThrough many dangers, toils and snares\r\nI have already come;\r\n’Tis grace that brought me safe thus far,\r\nAnd grace will lead me home.\r\n\r\nThe Lord has promised good to me,\r\nHis word my hope secures;\r\nHe will my shield and portion be\r\nAs long as life endures.\r\n\r\nYes, when this heart and flesh shall fail,\r\nAnd mortal life shall cease,\r\nI shall possess within the veil\r\nA life of joy and peace.\r\n\r\nWhen we’ve been there a thousand years,\r\nBright shining as the sun,\r\nWe’ve no less days to sing God’s praise\r\nThan when we first begun.\r\n', 2),
(1579, 'At the Name of Jesus', NULL, 'Caroline Maria Noel', 'At the name of Jesus,\r\nEvery knee shall bow,\r\nEvery tongue confess Him\r\nKing of glory now;\r\n’Tis the Father’s pleasure\r\nWe should call Him Lord,\r\nWho from the beginning\r\nWas the mighty Word.\r\n\r\nHumbled for a season,\r\nTo receive a name\r\nFrom the lips of sinners\r\nUnto whom He came;\r\nFaithfully He bore it\r\nSpotless to the last,\r\nBrought it back victorious,\r\nWhen from death He passed.\r\n\r\nBore it up triumphant\r\nWith its human light,\r\nThrough all ranks of creatures\r\nTo the central height,\r\nTo the throne of Godhead,\r\nTo the Father’s breast,\r\nFilled it with the glory\r\nOf that perfect rest.\r\n\r\nIn your hearts enthrone Him;\r\nThere let Him subdue\r\nAll that is not holy,\r\nAll that is not true;\r\nCrown Him as your Captain\r\nIn temptation’s hour,\r\nLet His will enfold you\r\nIn its light and power.\r\n\r\nBrothers, this Lord Jesus\r\nShall return again,\r\nWith His Father’s glory,\r\nWith His angel-train;\r\nFor all wreaths of empire\r\nMeet upon His brow,\r\nAnd our hearts confess Him\r\nKing of glory now.\r\n', 2),
(1592, 'Christ the Lord is Risen Today', NULL, 'Charles Wesley', 'Christ the Lord is Risen today: Hallelujah!\r\nSons of men and angels say: Hallelujah!\r\nRaise your joys and triumphs high: Hallelujah!\r\nSing, ye heavens, and earth reply: Hallelujah!\r\n\r\nLove’s redeeming work is done: Hallelujah!\r\nFought the fight, the battle won: Hallelujah!\r\nVain the stone, the watch, the seal: Hallelujah!\r\nChrist hath burst the gates of hell: Hallelujah!\r\n\r\nLives again our glorious King: Hallelujah!\r\nWhere, O death, is now thy sting? Hallelujah!\r\nOnce He died, our souls to save: Hallelujah!\r\nWhere thy victory, O grave? Hallelujah!\r\n\r\nSoar we now where Christ hath led: Hallelujah!\r\nFollowing our exalted Head: Hallelujah!\r\nMade like Him, like Him we rise: Hallelujah!\r\nOurs the cross, the grave, the skies: Hallelujah!\r\n\r\nHail the Lord of earth and heaven: Hallelujah!\r\nPraise to Thee by both be given: Hallelujah!\r\nThee we greet, in triumph sing: Hallelujah!\r\nHail our resurrected King: Hallelujah!\r\n', 2),
(1593, 'Christ, Whose Glory Fills the Skies', NULL, 'Charles Wesley', 'Christ, whose glory fills the skies,\r\nChrist, the true, the only light,\r\nSun of righteousness, arise,\r\nTriumph o\'er the shades of night:\r\nDay-spring from on high, be near;\r\nDay-star in my heart appear.\r\n\r\nDark and cheerless is the morn\r\nUnaccompanied by Thee;\r\nJoyless is the day\'s return,\r\nTill Thy mercy\'s beams I see;\r\nTill they inward light impart,\r\nGlad my eyes, and warm my heart.\r\n\r\nVisit then this soul of mine;\r\nPierce the gloom of sin and grief;\r\nFill me, radiancy divine;\r\nScatter all my unbelief;\r\nMore and more Thyself display,\r\nShining to the perfect day.\r\n', 2),
(1705, 'Silent Night', NULL, 'Joseph Mohr', 'Silent night, holy night! \r\nSleeps the world; hid from sight, \r\nMary and Joseph in stable bare \r\nWatch o’er the Child beloved and fair, \r\nSleeping in heavenly rest, \r\nSleeping in heavenly rest.\r\n\r\nSilent night, holy night! \r\nShepherds first saw the light, \r\nHeard resounding clear and long, \r\nFar and near, the angel-song: \r\n‘Christ the Redeemer is here, \r\nChrist the Redeemer is here.’\r\n\r\nSilent night, holy night! \r\nSon of God, O how bright \r\nLove is smiling from Thy face! \r\nStrikes for us now the hour of grace, \r\nSaviour, since Thou art born, \r\nSaviour, since Thou art born.\r\n', 2);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `id` int(11) NOT NULL,
  `church_id` int(11) NOT NULL,
  `team_type_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`id`, `church_id`, `team_type_id`, `name`) VALUES
(5, 2, 8, 'Gustavs team'),
(6, 2, 9, 'P.Os team'),
(8, 2, 10, '1. Stenlund'),
(9, 2, 8, 'Gabriels team'),
(10, 2, 10, '2. Ay'),
(11, 2, 10, '3. Lundin'),
(12, 2, 10, '4.Grupp 4'),
(13, 2, 10, '5. Hannomaa/Holmgren'),
(14, 2, 10, '6. Nilsson'),
(15, 2, 10, '7. Forsén'),
(16, 2, 10, '8. Gustafsson'),
(17, 2, 8, 'Ruths team'),
(18, 2, 9, 'Takala team'),
(19, 2, 9, 'Lindberg team'),
(20, 2, 9, 'Marg/Barbro team');

-- --------------------------------------------------------

--
-- Table structure for table `team_blocked`
--

CREATE TABLE `team_blocked` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `team_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_blocked`
--

INSERT INTO `team_blocked` (`id`, `start_date`, `end_date`, `team_id`) VALUES
(6, '2019-07-10 00:00:00', '2019-08-07 00:00:00', 10),
(7, '2019-07-31 00:00:00', '2019-08-02 00:00:00', 8);

-- --------------------------------------------------------

--
-- Table structure for table `team_type`
--

CREATE TABLE `team_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_type`
--

INSERT INTO `team_type` (`id`, `name`, `church_id`) VALUES
(8, 'Praise and worship team', 2),
(9, 'Intercessory prayer team', 2),
(10, 'Hosting team', 2);

-- --------------------------------------------------------

--
-- Table structure for table `team_user`
--

CREATE TABLE `team_user` (
  `id` int(11) NOT NULL,
  `team_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `team_user`
--

INSERT INTO `team_user` (`id`, `team_id`, `user_id`, `admin`) VALUES
(25, 9, 19, 1),
(26, 18, 24, 1),
(27, 17, 14, 1),
(28, 5, 25, 1),
(29, 8, 22, 0),
(30, 10, 18, 0),
(31, 11, 25, 0),
(32, 12, 23, 0),
(33, 13, 17, 0),
(34, 14, 21, 0),
(35, 15, 14, 0),
(36, 16, 14, 0),
(37, 19, 24, 0),
(38, 20, 20, 0),
(39, 6, 27, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobilephone` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `account_activation_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `church_id` int(11) NOT NULL,
  `display_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `language_id` int(11) NOT NULL,
  `hide_user_icons` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password_hash`, `status`, `auth_key`, `password_reset_token`, `account_activation_token`, `created_at`, `updated_at`, `church_id`, `display_name`, `language_id`, `hide_user_icons`) VALUES
(6, 'Calum', 'thomas@gmail.com', '$2y$13$ywiXEwj31qScRYEKikKJL.RhOJHSzPMQw1pvA0w8WD0vLxwQNfjg2', 10, 'mIOAjnC6DB6lY6X3yfeuoyqB9zs0ysRg', NULL, NULL, 1561711824, 1565165947, 2, 'Calum Meisner', 3, 0),
(14, 'Maximiliane', 'thomas@cross-connect.se', '$2y$13$sKHwDMwHjS5btfW5kyN6v.sLgun2OCAgCrYuJfRQkMIFXEwVjQUXW', 10, 'JayOC1oajUevtq5EnuzfrrGlHCXUv68O', NULL, NULL, 1564231452, 1565114952, 2, 'Maximiliane Dušek', 4, 0),
(15, 'Ramazan', 'ramazan.black@gmail.com', '$2y$13$YlUwLvyfOKbKcrGbd6b0weXi1caqAhfGfPt.MtavDKatqtKZ4KeLi', 10, 'P58OcIuZazP5eKne68aLzr7mPVZ1Wb0c', NULL, NULL, 1564233750, 1564923348, 2, 'Ramazan Black', 4, 0),
(17, 'Mahavira', 'mahavira.ohanigan@hotmail.com', '$2y$13$Ohcvhy1BSRA8mg3ABNJ7keDbCSRV4ZvaGA1JnDtjmMa.qWH2Ahinq', 10, 'wJRxwszaL4Of9f-E0xEkisklysjrFuYT', NULL, NULL, 1564234442, 1564923708, 2, 'Mahavira O\'Hanigan', 4, 0),
(18, 'Delphia', 'delphia.guidi@gmail.com', '$2y$13$0wSQGLzOubvhApaZB8LNmu5aC7Kr0GSU.iQE/H6g5/cfngRqp2Mga', 10, 'dqGQQ5RnbPORVXlP-W2omsEzre7WJpBZ', NULL, NULL, 1564234584, 1564923284, 2, 'Delphia Guidi', 4, 0),
(19, 'Saveriu', 'saveriu.cuocco@gmail.com', '$2y$13$bmlkrte2Uvm1lHNU0cjUZOPHSq46n9aw8ZFSZM2Hi.GIzm1mm1FyO', 10, 'kvxLs3POWDMDQqMgLP7pq2_NMz221ols', NULL, NULL, 1564234753, 1564923659, 2, 'Saveriu Cuocco', 4, 0),
(20, 'Thaddaios', 'thaddaios.macFarlane@hotmail.com', '$2y$13$zOrUjnjcOiDNdJjOcP5r6.PTAmN6AhH.4s5CSMeDu1PhYJsyFN72e', 10, '1KppZKbwh-hV_SoTymlweoMbAihwk39O', NULL, NULL, 1564235169, 1564924543, 2, 'Thaddaios MacFarlane', 4, 0),
(21, 'Kwadwo', 'kwadwo.naoumov@gmail.com', '$2y$13$gLZqqWmosZMYg6vRUTsv9uMY890QGeMi65IGMNmqv9ZIeUiE8Hveq', 10, 'SbrRwGpx2_cC_VAmUK7mE5DDrfK6M69l', NULL, NULL, 1564235448, 1564924730, 2, 'Kwadwo Naoumov', 4, 0),
(22, 'Cinta', 'cinta.coughlin@hotmail.com', '$2y$13$kbVP3Jq8P7HX1LT4TQZkt.UCD.WsmNi7AplOQgHRqnt6OU/i0kPca', 10, 'UAWLSk3EgBPXKY7RQovLZOW7PsKK76ST', NULL, NULL, 1564235780, 1564924589, 2, 'Cinta Coughlin', 4, 0),
(23, 'Laurent', 'laurent.royle@live.se', '$2y$13$xQFglC81Jtsk5ewmGIKOG.YFoEQpI9JGToM3B/qHVLuglaedjEF0i', 10, 'BBkpJ21Xlip1If2xTiyP-0hEPbr0hl8k', NULL, NULL, 1564300511, 1564924795, 2, 'Laurent Royle', 4, 0),
(24, 'Shailaja', 'shailaja.ford@gmail.com', '$2y$13$U7RwD3v6xEqzl2L0kl/jge6Hj7TaAZoCWoZQoGZ0XinB1SQK.s1bO', 10, 'vTKIqvgYP_e66vcRv0xjlo-FsQ9TJHCp', NULL, NULL, 1564305580, 1564924454, 2, 'Shailaja Ford', 4, 0),
(25, 'Elof', 'elof.rhee@telia.com', '$2y$13$pX9E6W6SGKr1pdnWFucS1.bw3XvTzKgWL0xhwFfw62TSb6Xh8D/cK', 10, 'iHVSKJSYyXOZGdlsnYsJmg_jzHjTWfvt', NULL, NULL, 1564307247, 1564924316, 2, 'Elof Rhee', 4, 0),
(26, 'Olof', 'olof.medved@hotmail.com', '$2y$13$2GR4bAwxfeKkLi6Y8xYzsOQMJZqyr2YUXR.sjYX76R9kFRd1HaT/e', 10, 'Z7bXl6XHWqKZx7j9UQWSB26w-z2K0bZy', NULL, NULL, 1564308151, 1564924359, 2, 'Olof Medved', 4, 0),
(27, 'Yuli', 'yuli.andrews@gmail.com', '$2y$13$cjL7zUGNUo4Inqwes8a8iu8SPGf8KmKXzcrHtNTH7NEAefpkuJbVC', 10, 'u8vWcLuw7NyPb9iELGpgbXFuqqaDydhE', NULL, NULL, 1564308663, 1564923625, 2, 'Yuli Andrews', 4, 0),
(28, 'Svatava', 'svatava.pokorny@gmail.com', '$2y$13$mHusIOlbuR0Rb5ujOBOIN.jpfgL1L95KKWVg8WfK2q01nvn20Tx2C', 10, 'cdU4XyJ67wRUPlSuIB0BvhlABn5XmKqe', NULL, NULL, 1564308820, 1564924283, 2, 'Svatava Pokorny', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user_blocked`
--

CREATE TABLE `user_blocked` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `log` (
  `id` int(11) NOT NULL,
  `datestamp` datetime NOT NULL,
  `place` varchar(100) NOT NULL,
  `what` varchar(100) NOT NULL,
  `who` varchar(255) NOT NULL,
  `before` text DEFAULT NULL,
  `after` text DEFAULT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`);

ALTER TABLE `log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
ALTER TABLE `log`
  ADD CONSTRAINT `log_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_type_id` (`activity_type_id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `team_id` (`team_id`),
  ADD KEY `song_id` (`song_id`);

--
-- Indexes for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `activity_type_ibfk_2` (`team_type_id`);

--
-- Indexes for table `attach_file`
--
ALTER TABLE `attach_file`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hash` (`hash`),
  ADD KEY `model` (`model`),
  ADD KEY `itemId` (`itemId`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `bible`
--
ALTER TABLE `bible`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bible_ibfk_1` (`language_id`),
  ADD KEY `bible_ibfk_2` (`church_id`);

--
-- Indexes for table `bible_contents`
--
ALTER TABLE `bible_contents`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `book` (`bible_id`,`book`,`chapter`,`verse`);

--
-- Indexes for table `bible_verse`
--
ALTER TABLE `bible_verse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bible_verse_ibfk_1` (`activity_id`);

--
-- Indexes for table `church`
--
ALTER TABLE `church`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`);

--
-- Indexes for table `language`
--
ALTER TABLE `language`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dislplay_name_english` (`display_name_english`,`church_id`) USING BTREE,
  ADD UNIQUE KEY `iso_name` (`iso_name`,`church_id`) USING BTREE,
  ADD KEY `church_id` (`church_id`);

--
-- Indexes for table `message_template`
--
ALTER TABLE `message_template`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `message_template_ibfk_2` (`language_id`),
  ADD KEY `message_template_ibfk_3` (`message_type_id`);

--
-- Indexes for table `message_type`
--
ALTER TABLE `message_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_type_ibfk_1` (`church_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_id` (`activity_id`),
  ADD KEY `team_user_notify_ibfk_2` (`user_id`),
  ADD KEY `notification_ibfk_3` (`event_id`),
  ADD KEY `notification_ibfk_4` (`team_id`),
  ADD KEY `notification_ibfk_5` (`message_template_id`);

--
-- Indexes for table `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`author`,`church_id`) USING BTREE,
  ADD KEY `song_ibfk_1` (`church_id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `team_type_id` (`team_type_id`);

--
-- Indexes for table `team_blocked`
--
ALTER TABLE `team_blocked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `team_type`
--
ALTER TABLE `team_type`
  ADD PRIMARY KEY (`id`),
  ADD KEY `church_id` (`church_id`);

--
-- Indexes for table `team_user`
--
ALTER TABLE `team_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_team_unique` (`user_id`,`team_id`),
  ADD KEY `team_id` (`team_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`,`church_id`) USING BTREE,
  ADD UNIQUE KEY `password_reset_token` (`password_reset_token`),
  ADD UNIQUE KEY `account_activation_token` (`account_activation_token`),
  ADD KEY `church_id` (`church_id`),
  ADD KEY `user_ibfk_2` (`language_id`);

--
-- Indexes for table `user_blocked`
--
ALTER TABLE `user_blocked`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=259;

--
-- AUTO_INCREMENT for table `activity_type`
--
ALTER TABLE `activity_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `attach_file`
--
ALTER TABLE `attach_file`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `bible`
--
ALTER TABLE `bible`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bible_contents`
--
ALTER TABLE `bible_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bible_verse`
--
ALTER TABLE `bible_verse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `church`
--
ALTER TABLE `church`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `language`
--
ALTER TABLE `language`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `message_template`
--
ALTER TABLE `message_template`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `message_type`
--
ALTER TABLE `message_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `song`
--
ALTER TABLE `song`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1743;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `team_blocked`
--
ALTER TABLE `team_blocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `team_type`
--
ALTER TABLE `team_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `team_user`
--
ALTER TABLE `team_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `user_blocked`
--
ALTER TABLE `user_blocked`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`activity_type_id`) REFERENCES `activity_type` (`id`),
  ADD CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `activity_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `activity_ibfk_4` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `activity_ibfk_5` FOREIGN KEY (`song_id`) REFERENCES `song` (`id`);

--
-- Constraints for table `activity_type`
--
ALTER TABLE `activity_type`
  ADD CONSTRAINT `activity_type_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  ADD CONSTRAINT `activity_type_ibfk_2` FOREIGN KEY (`team_type_id`) REFERENCES `team_type` (`id`);

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `bible`
--
ALTER TABLE `bible`
  ADD CONSTRAINT `bible_ibfk_1` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `bible_ibfk_2` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Constraints for table `bible_contents`
--
ALTER TABLE `bible_contents`
  ADD CONSTRAINT `bible_contents_ibfk_1` FOREIGN KEY (`bible_id`) REFERENCES `bible` (`id`);

--
-- Constraints for table `bible_verse`
--
ALTER TABLE `bible_verse`
  ADD CONSTRAINT `bible_verse_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`);

--
-- Constraints for table `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Constraints for table `language`
--
ALTER TABLE `language`
  ADD CONSTRAINT `language_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Constraints for table `message_template`
--
ALTER TABLE `message_template`
  ADD CONSTRAINT `message_template_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  ADD CONSTRAINT `message_template_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`),
  ADD CONSTRAINT `message_template_ibfk_3` FOREIGN KEY (`message_type_id`) REFERENCES `message_type` (`id`);

--
-- Constraints for table `message_type`
--
ALTER TABLE `message_type`
  ADD CONSTRAINT `message_type_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Constraints for table `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`id`),
  ADD CONSTRAINT `notification_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `notification_ibfk_3` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `notification_ibfk_4` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `notification_ibfk_5` FOREIGN KEY (`message_template_id`) REFERENCES `message_template` (`id`);

--
-- Constraints for table `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  ADD CONSTRAINT `team_ibfk_2` FOREIGN KEY (`team_type_id`) REFERENCES `team_type` (`id`);

--
-- Constraints for table `team_blocked`
--
ALTER TABLE `team_blocked`
  ADD CONSTRAINT `team_blocked_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`);

--
-- Constraints for table `team_type`
--
ALTER TABLE `team_type`
  ADD CONSTRAINT `team_type_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`);

--
-- Constraints for table `team_user`
--
ALTER TABLE `team_user`
  ADD CONSTRAINT `team_user_ibfk_1` FOREIGN KEY (`team_id`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `team_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`church_id`) REFERENCES `church` (`id`),
  ADD CONSTRAINT `user_ibfk_2` FOREIGN KEY (`language_id`) REFERENCES `language` (`id`);

--
-- Constraints for table `user_blocked`
--
ALTER TABLE `user_blocked`
  ADD CONSTRAINT `user_blocked_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
