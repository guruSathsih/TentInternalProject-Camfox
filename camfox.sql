-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 22, 2016 at 07:43 AM
-- Server version: 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `camfox`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `content`, `post_id`, `user_id`, `status`, `date_time`) VALUES
(1, 'nice!', 26, 1, 'new', '2015-12-17 00:00:00'),
(2, 'nice!', 26, 1, 'new', '2015-12-17 00:00:00'),
(3, 'super!', 26, 1, 'new', '2015-12-17 00:00:00'),
(4, 'good!', 23, 1, 'new', '2015-12-17 00:00:00'),
(5, 'super', 23, 1, 'new', '2015-12-17 00:00:00'),
(6, 'nice!', 26, 1, 'new', '2015-12-17 00:00:00'),
(7, 'good!', 26, 1, 'new', '2015-12-17 00:00:00'),
(8, 'ok', 22, 1, 'new', '2015-12-17 00:00:00'),
(9, 'right', 22, 1, 'new', '2015-12-17 00:00:00'),
(10, 'bye', 22, 1, 'new', '2015-12-17 00:00:00'),
(11, 'hi', 21, 1, 'new', '2015-12-17 00:00:00'),
(12, 'bye', 21, 1, 'new', '2015-12-17 00:00:00'),
(13, 'bye', 26, 1, 'new', '2015-12-17 00:00:00'),
(14, 'super', 21, 1, 'new', '2015-12-17 12:30:02'),
(15, 'fine', 26, 1, 'new', '2015-12-17 12:30:24'),
(16, 'fine', 22, 1, 'new', '2015-12-17 13:06:41'),
(17, 'hi', 25, 1, 'new', '2015-12-17 13:13:05'),
(18, 'bye', 26, 1, 'new', '2015-12-17 13:21:26'),
(19, 'new comment', 26, 1, 'new', '2015-12-18 13:13:11'),
(20, 'Test Timezone', 26, 1, 'new', '2015-12-18 13:22:26'),
(21, 'Comment1', 26, 1, 'new', '2015-12-18 12:27:37'),
(22, 'hi', 26, 1, 'new', '2015-12-21 07:03:23'),
(23, 'hi', 26, 1, 'new', '2015-12-21 10:39:48'),
(24, 'hi', 25, 1, 'new', '2015-12-21 10:46:07'),
(25, 'test timezone comment', 26, 1, 'new', '2015-12-21 11:11:52'),
(26, 'nice', 20, 1, 'new', '2015-12-21 11:12:26'),
(27, 'good', 24, 1, 'new', '2016-01-14 09:43:17'),
(28, 'dgfdg', 43, 7, 'new', '2016-01-21 07:28:40'),
(29, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 43, 7, 'new', '2016-01-21 09:10:49'),
(30, 'Quick comment test', 48, 8, 'new', '2016-01-21 10:09:33'),
(31, 'yes', 48, 8, 'new', '2016-01-21 10:22:08'),
(32, 'no', 48, 8, 'new', '2016-01-21 10:27:41'),
(33, 'nice', 46, 8, 'new', '2016-01-21 11:12:39'),
(34, 'good one', 48, 7, 'new', '2016-01-21 11:26:34'),
(35, 'ok', 48, 7, 'new', '2016-01-21 11:27:35'),
(36, 'thanks', 46, 7, 'new', '2016-01-21 11:28:58'),
(37, 'welcome', 46, 7, 'new', '2016-01-21 11:29:17'),
(38, 'thanks', 48, 8, 'new', '2016-01-21 11:54:51'),
(39, 'thank you', 48, 8, 'new', '2016-01-21 12:09:29'),
(40, 'hi', 48, 8, 'new', '2016-01-21 12:09:56');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE IF NOT EXISTS `contacts` (
  `id` int(11) NOT NULL,
  `parent` int(200) NOT NULL,
  `child` int(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `requested_date_time` datetime NOT NULL,
  `approved_date_time` datetime DEFAULT NULL,
  `notify_status` int(10) NOT NULL,
  `friends_status` text
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `parent`, `child`, `status`, `requested_date_time`, `approved_date_time`, `notify_status`, `friends_status`) VALUES
(1, 1, 6, 'approved', '2015-12-12 00:00:00', '0000-00-00 00:00:00', 0, 'Y'),
(3, 1, 8, 'approved', '2015-12-09 00:00:00', '0000-00-00 00:00:00', 0, 'Y'),
(4, 1, 7, 'approved', '2016-01-06 05:49:07', '2016-01-08 12:22:29', 1, 'Y'),
(5, 7, 1, 'approved', '2016-01-06 05:49:07', '2016-01-08 12:22:29', 0, 'Y'),
(6, 8, 7, 'approved', '2016-01-06 05:49:38', '2016-01-08 10:20:46', 0, 'Y'),
(7, 7, 8, 'approved', '2016-01-06 05:49:38', '2016-01-08 10:20:46', 1, 'Y'),
(12, 12, 7, 'pending', '2016-01-06 06:41:19', NULL, 0, 'N'),
(13, 7, 12, 'approved', '2016-01-06 06:41:19', NULL, 0, 'N'),
(14, 6, 7, 'pending', '2016-01-06 07:05:17', NULL, 0, 'N'),
(15, 7, 6, 'approved', '2016-01-06 07:05:17', NULL, 0, 'N'),
(16, 1, 13, 'approved', '2016-01-08 12:25:17', '2016-01-08 12:26:15', 1, 'Y'),
(17, 13, 1, 'approved', '2016-01-08 12:25:17', '2016-01-08 12:26:15', 0, 'Y'),
(18, 9, 1, 'approved', '2016-01-11 06:47:57', '2016-01-11 06:48:27', 1, 'Y'),
(19, 1, 9, 'approved', '2016-01-11 06:47:57', '2016-01-11 06:48:27', 0, 'Y'),
(20, 9, 7, 'pending', '2016-01-19 07:16:36', NULL, 0, 'N'),
(21, 7, 9, 'approved', '2016-01-19 07:16:36', NULL, 0, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL,
  `user_id` int(10) NOT NULL,
  `last_in` datetime NOT NULL,
  `new_events_count` int(10) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `user_id`, `last_in`, `new_events_count`) VALUES
(1, 1, '2016-01-21 07:04:16', 4),
(2, 13, '2016-01-21 11:50:53', 0),
(3, 7, '2016-01-22 05:33:25', 0),
(4, 8, '2016-01-21 11:56:55', 0),
(5, 9, '2016-01-12 10:01:56', 0);

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE IF NOT EXISTS `likes` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `post_id`, `comment_id`, `user_id`, `status`, `date_time`) VALUES
(3, 25, 0, 1, 'new', '2015-12-15 00:00:00'),
(5, 23, 0, 1, 'new', '2015-12-15 12:18:10'),
(6, 20, 0, 1, 'new', '2015-12-15 12:20:34'),
(7, 22, 0, 1, 'new', '2015-12-15 12:21:04'),
(9, 26, 0, 1, 'new', '2015-12-15 12:54:00'),
(12, 24, 0, 1, 'new', '2015-12-15 13:17:50'),
(13, 31, 0, 1, 'new', '2016-01-04 11:56:42'),
(14, 35, 0, 1, 'new', '2016-01-14 09:42:56'),
(15, 41, 0, 1, 'new', '2016-01-14 09:43:58'),
(16, 39, 0, 7, 'new', '2016-01-14 10:32:09'),
(18, 41, 0, 8, 'new', '2016-01-14 10:32:39'),
(19, 30, 0, 7, 'new', '2016-01-14 10:35:27'),
(20, 40, 0, 1, 'new', '2016-01-14 10:36:17'),
(21, 29, 0, 7, 'new', '2016-01-14 10:37:40'),
(22, 38, 0, 1, 'new', '2016-01-18 10:58:29'),
(23, 28, 0, 7, 'new', '2016-01-18 11:00:18'),
(24, 36, 0, 1, 'new', '2016-01-18 11:08:19'),
(25, 31, 0, 7, 'new', '2016-01-18 11:10:07'),
(26, 32, 0, 1, 'new', '2016-01-18 11:21:28'),
(27, 31, 0, 13, 'new', '2016-01-18 11:44:29'),
(28, 21, 0, 7, 'new', '2016-01-18 12:00:27'),
(29, 24, 0, 7, 'new', '2016-01-20 11:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL,
  `content` varchar(200) NOT NULL,
  `user_id` int(200) NOT NULL,
  `status` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL,
  `total_comments` int(3) NOT NULL,
  `total_likes` int(3) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `content`, `user_id`, `status`, `date_time`, `total_comments`, `total_likes`) VALUES
(1, '			hi, this is first post			', 1, 'new', '2015-12-11 11:04:48', 0, 0),
(2, '			hi, this is first post			', 1, 'new', '2015-12-11 11:07:39', 0, 0),
(3, '			hi, this is first post			', 1, 'new', '2015-12-11 11:07:59', 0, 0),
(4, '			hi, this is first post			', 1, 'new', '2015-12-11 11:08:06', 0, 0),
(5, '				hi, how are you		', 1, 'new', '2015-12-11 11:57:02', 0, 0),
(6, '				hi, how are you		', 1, 'new', '2015-12-11 12:00:56', 0, 0),
(7, '				hi, how are you		', 1, 'new', '2015-12-11 12:01:20', 0, 0),
(8, '			hi 			', 1, 'new', '2015-12-11 12:02:22', 0, 0),
(9, 'hi how are you 			', 1, 'new', '2015-12-11 12:03:18', 0, 0),
(10, 'hi how are you 			', 1, 'new', '2015-12-11 12:29:58', 0, 0),
(11, 'hi 		', 1, 'new', '2015-12-11 12:30:22', 0, 0),
(12, 'hi 		', 1, 'new', '2015-12-11 12:33:39', 0, 0),
(13, 'hi 		', 1, 'new', '2015-12-11 12:43:14', 0, 0),
(14, 'hi 		', 1, 'new', '2015-12-11 12:45:56', 0, 0),
(15, 'This is my first post						', 1, 'new', '2015-12-11 12:47:31', 0, 0),
(16, 'This is my first post						', 1, 'new', '2015-12-11 12:48:53', 0, 0),
(17, 'This is my first post						', 1, 'new', '2015-12-11 12:49:36', 0, 0),
(18, 'This is my first post						', 1, 'new', '2015-12-11 12:54:15', 0, 0),
(19, 'This is my first post						', 1, 'new', '2015-12-11 12:56:43', 0, 0),
(20, 'hi how r u	', 1, 'new', '2015-12-11 13:01:47', 1, 1),
(21, 'hi how r u', 1, 'new', '2015-12-11 13:06:43', 3, 1),
(22, 'hi. This is divya first post						', 1, 'new', '2015-12-14 06:40:49', 4, 1),
(23, 'This i s raja post						', 6, 'new', '2015-12-14 10:54:00', 2, 1),
(24, 'This is devi post						', 7, 'new', '2015-12-14 10:55:42', 1, 11),
(25, 'This is devi post						', 7, 'new', '2015-12-14 10:56:37', 2, 1),
(26, 'This is devi post						', 7, 'new', '2015-12-14 10:56:40', 14, 1),
(27, 'This is new test post		', 1, 'new', '2015-12-21 11:45:53', 0, 0),
(28, 'today', 1, 'new', '2015-12-22 06:51:20', 0, 1),
(29, 'today new post', 1, 'new', '2015-12-22 06:52:15', 0, 1),
(30, 'this is today post', 1, 'new', '2015-12-22 06:58:17', 0, 1),
(31, '	hi\n					', 1, 'new', '2015-12-28 09:01:13', 0, 111),
(32, '	hi bhumika					', 13, 'new', '2016-01-12 10:36:07', 0, 1),
(33, 'hi divya', 13, 'new', '2016-01-12 10:43:56', 0, 0),
(34, 'how r u divya						', 13, 'new', '2016-01-12 10:46:35', 0, 0),
(35, 'Hi all					', 7, 'new', '2016-01-12 10:59:52', 0, 1),
(36, '	Hello					', 7, 'new', '2016-01-12 11:00:36', 0, 1),
(37, '	hello					', 13, 'new', '2016-01-12 11:04:37', 0, 0),
(38, '	hi					', 7, 'new', '2016-01-12 12:05:26', 0, 1),
(39, '	Hi good morning					', 8, 'new', '2016-01-13 06:37:54', 0, 1),
(40, '	hi d					', 7, 'new', '2016-01-13 11:48:16', 0, 1),
(41, '	good					', 7, 'new', '2016-01-13 12:19:14', 0, 11),
(42, 'aaaaaaaaaaaaaaaaaaaaaabbbbbbbbbbbbbbbbbbbbbbbbbcccccccccccccccccccccccccccccdddddddddddddddddddd\n						', 7, 'new', '2016-01-19 06:22:38', 0, 0),
(43, 'dddddddddddddddddddddddddddd', 7, 'new', '2016-01-19 07:14:58', 2, 0),
(44, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaappppppppppppppppppppppppppppppxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxkkkkkkkkkkkkkkkkkkkkkkkkkkkk						', 7, 'new', '2016-01-21 09:13:21', 0, 0),
(45, 'vvvvvvvvvvv', 7, 'new', '2016-01-21 09:16:33', 0, 0),
(46, 'addddddddddddddddb ngjhgkhjkljk;kl;', 7, 'new', '2016-01-21 09:16:43', 3, 0),
(47, 'hi', 7, 'new', '2016-01-21 09:24:32', 0, 0),
(48, 'Quick brown fox jumped into the wall without Quick brown fox jumped into the wall without Quick brown fox jumped into the wall without Quick brown fox jumped into the wall without 		', 8, 'new', '2016-01-21 09:59:18', 8, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `user_name` varchar(200) NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `sur_name` varchar(200) DEFAULT NULL,
  `email_id` varchar(200) NOT NULL,
  `mobile_no` int(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `birth_date` date NOT NULL,
  `gender` text NOT NULL,
  `status` varchar(200) NOT NULL,
  `date_time` datetime NOT NULL,
  `picture` varchar(35689) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `online_datetime` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `first_name`, `sur_name`, `email_id`, `mobile_no`, `password`, `birth_date`, `gender`, `status`, `date_time`, `picture`, `last_login`, `online_datetime`) VALUES
(1, 'Divya', 'Divya', 's', 'divya@tentsoftware.com', 2147483647, 'divya', '1992-08-24', 'female', 'new', '2015-12-01 00:00:00', 'images/divya.png', '2016-01-21 07:04:16', '2016-01-21 07:10:24'),
(6, 'raja', 'Raja', 'R', 'raja@gmail.com', 963852147, 'raja', '2011-03-09', 'male', 'new', '2015-12-07 00:00:00', 'images/user thumbnails/HimalayanPalmCivet_small.jpg', '2016-01-07 11:58:20', NULL),
(7, 'devi', 'Devi', 'C', 'devi@gmail.com', 987563214, 'devi', '1991-09-30', 'female', 'new', '2015-12-07 00:00:00', 'images/user thumbnails/Macaw3_small.jpg', '2016-01-22 05:33:25', '2016-01-22 06:43:26'),
(8, 'deena', 'Deena', 'S', 'deena@gmail.com', 2147483647, 'deena', '1989-12-19', 'male', 'new', '2015-12-07 00:00:00', 'images/user thumbnails/SeaLion2_small.jpg', '2016-01-21 11:56:54', '2016-01-21 12:10:32'),
(9, 'raji', 'Raji', 'S', 'raji@gmail.com', 987654123, 'raji', '1992-01-09', 'female', 'new', '2015-12-07 00:00:00', '', '2016-01-12 10:01:56', '2016-01-12 10:35:26'),
(10, 'raji', 'Raji', 'S', 'raji@gmail.com', 987654123, 'raji', '1992-01-09', 'female', 'new', '2015-12-07 00:00:00', '', '2016-01-01 00:00:00', NULL),
(11, 'nadhiya', 'Nadhiya', 'L', 'nadhiya@gmail.com', 2147483647, 'nadhiya', '1987-02-18', 'female', 'new', '2015-12-07 00:00:00', '', '2016-01-04 00:00:00', NULL),
(12, 'kamal', 'Kamal', 'K', 'kamal@gmail.com', 2147483647, 'kamal', '1993-02-20', 'male', 'new', '2015-12-07 00:00:00', '', '2016-01-01 00:00:00', NULL),
(13, 'bhumika', 'Bhumika', 'S', 'bhumika@gmail.com', 2147483647, 'bhumika', '1989-08-15', 'female', 'new', '2015-12-08 00:00:00', '', '2016-01-21 11:50:53', '2016-01-18 12:15:36'),
(16, 'saravana', 'Saravanan', 'S', 'sarava@gmail.com', 987456321, 'saravana', '1988-07-10', 'female', 'new', '2015-12-08 00:00:00', '', '2016-01-02 00:00:00', NULL),
(17, 'saravana', 'Saravanan', 'S', 'sarava@gmail.com', 987456321, 'saravana', '0000-00-00', 'female', 'new', '2015-12-08 00:00:00', '', '2016-01-03 00:00:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=41;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=30;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
