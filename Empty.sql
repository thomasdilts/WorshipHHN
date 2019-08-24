-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: worshiphhn.org.mysql.service.one.com:3306
-- Generation Time: Aug 07, 2019 at 08:32 AM
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
('ChurchAdmin', 36, 1565099864),
('ChurchAdmin', 42, 1565151779),
('EventManager', 16, 1564924415),
('MemberUnaccepted', 30, 1564868748),
('MemberUnaccepted', 31, 1564869062),
('MemberUnaccepted', 32, 1564869246),
('MemberUnaccepted', 39, 1565112404),
('MemberUnaccepted', 40, 1565112621),
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

-- --------------------------------------------------------

--
-- Table structure for table `message_type`
--

CREATE TABLE `message_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- Table structure for table `team_type`
--

CREATE TABLE `team_type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `church_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
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
(6, 'Calum', 'thomas@gmail.com', '$2y$13$ywiXEwj31qScRYEKikKJL.RhOJHSzPMQw1pvA0w8WD0vLxwQNfjg2', 10, 'mIOAjnC6DB6lY6X3yfeuoyqB9zs0ysRg', NULL, NULL, 1561711824, 1565165947, 2, 'Calum Meisner', 3, 0);

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
