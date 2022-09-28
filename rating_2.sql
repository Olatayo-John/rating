-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2021 at 01:56 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rating_2`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE `activity` (
  `id` int(11) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `act_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `activity`
--

INSERT INTO `activity` (`id`, `msg`, `act_time`) VALUES
(1, 'Logs table cleared. [ID: 44, Name: cdssa]', 'Tuesday, 09-Nov-2021 06:30:17 CET'),
(2, 'Failed to update password | User. [ID: 54]', 'Tuesday, 09-Nov-2021 06:41:09 CET'),
(3, 'Logged Out. [ID: 54, Name: jvweed]', 'Tuesday, 09-Nov-2021 07:21:15 CET'),
(4, 'Failed Login Attempt- Inactive Account | User. [Name: jvweed]', 'Tuesday, 09-Nov-2021 07:23:08 CET'),
(5, 'Failed Login Attempt- Inactive Access | User. [Name: jvweed]', 'Tuesday, 09-Nov-2021 07:24:06 CET'),
(6, 'Failed Login Attempt- Inactive Access | User. [Name: jvweed]', 'Tuesday, 09-Nov-2021 07:25:10 CET'),
(7, 'Logged In | User. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 07:25:44 CET'),
(8, 'Failed to update password | User. [ID: 52]', 'Tuesday, 09-Nov-2021 08:43:27 CET'),
(9, 'Failed to update password | User. [ID: 52]', 'Tuesday, 09-Nov-2021 08:45:42 CET'),
(10, 'Failed to update password | User. [ID: 52]', 'Tuesday, 09-Nov-2021 08:46:03 CET'),
(11, 'Website status changed | User. [ID: 52, WebID: 23, Status: 0]', 'Tuesday, 09-Nov-2021 08:46:19 CET'),
(12, 'Website status changed | User. [ID: 52, WebID: 23, Status: 1]', 'Tuesday, 09-Nov-2021 08:46:35 CET'),
(13, 'Website status changed | User. [ID: 52, WebID: 29, Status: 1]', 'Tuesday, 09-Nov-2021 09:01:33 CET'),
(14, 'Logged Out. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 10:49:01 CET'),
(15, 'Logged In | User. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 10:49:09 CET'),
(16, 'SMS couldn\'t be sent | User. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 11:17:56 CET'),
(17, 'Failed to update password | User. [ID: 52]', 'Tuesday, 09-Nov-2021 11:48:12 CET'),
(18, 'Profile Updated | User. [ID: 52]', 'Tuesday, 09-Nov-2021 11:50:41 CET'),
(19, 'Failed to update password | User. [ID: 52]', 'Tuesday, 09-Nov-2021 11:50:49 CET'),
(20, 'Logged Out. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 12:06:13 CET'),
(21, 'Logged Out. [ID: , Name: ]', 'Tuesday, 09-Nov-2021 12:09:29 CET'),
(22, 'Logged In | User. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 12:09:36 CET'),
(23, 'Logged Out. [ID: , Name: ]', 'Tuesday, 09-Nov-2021 12:11:45 CET'),
(24, 'New Website created | User. [ID: 52, WebName: test test, WebLink: https://ggg.com]', 'Tuesday, 09-Nov-2021 12:12:43 CET'),
(25, 'Logged Out. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 12:15:03 CET'),
(26, 'Logged In | User. [ID: 53, Name: john.nktech.test]', 'Tuesday, 09-Nov-2021 12:15:46 CET'),
(27, 'Logged Out. [ID: , Name: ]', 'Tuesday, 09-Nov-2021 12:19:13 CET'),
(28, 'Logged In | User. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 12:19:25 CET'),
(29, 'Logged Out. [ID: 52, Name: hhhhh]', 'Tuesday, 09-Nov-2021 12:19:38 CET'),
(30, 'Website status changed | User. [ID: 53, WebID: 20, Status: 0]', 'Tuesday, 09-Nov-2021 12:20:34 CET'),
(31, 'Website status changed | User. [ID: 53, WebID: 20, Status: 1]', 'Tuesday, 09-Nov-2021 12:20:38 CET'),
(32, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 12:20:51 CET'),
(33, 'Logged Out. [ID: 53, Name: john.nktech.test]', 'Tuesday, 09-Nov-2021 12:47:45 CET'),
(34, 'User account Activated | Admin. [ID: 49, UserID: 54]', 'Tuesday, 09-Nov-2021 12:49:05 CET'),
(35, 'User account Deactivated | Admin. [ID: 49, UserID: 54]', 'Tuesday, 09-Nov-2021 12:49:18 CET'),
(36, 'Logged Out. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 13:22:10 CET'),
(37, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 13:22:13 CET'),
(38, 'Logged Out. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 13:22:43 CET'),
(39, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 13:22:45 CET'),
(40, 'Logged Out. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 13:23:34 CET'),
(41, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Tuesday, 09-Nov-2021 13:23:36 CET');

-- --------------------------------------------------------

--
-- Table structure for table `all_ratings`
--

CREATE TABLE `all_ratings` (
  `id` int(11) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `star` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile` bigint(255) NOT NULL,
  `web_name` varchar(255) NOT NULL,
  `form_key` varchar(32) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `all_ratings`
--

INSERT INTO `all_ratings` (`id`, `user_ip`, `star`, `name`, `mobile`, `web_name`, `form_key`, `rated_at`) VALUES
(1, '::1', 5, 'Test', 5667643456, 'testwebnamelength', 'cdssa52180', '2021-02-28 08:53:41'),
(2, '::1', 4, 'Test', 6573837485, 'testwebnamelength', 'cdssa52180', '2021-03-05 08:59:25'),
(3, '::1', 4, 'Test', 4665647337, 'testwebnamelength', 'cdssa52180', '2021-03-05 09:00:34'),
(4, '::1', 4, 'name name', 8474657464, 'webthree', 'cdssa52180', '2021-03-05 09:56:37'),
(5, '::1', 5, 'Test Ticket Dept.', 6447364543, 'webthree', 'cdssa52180', '2021-03-05 10:07:07'),
(6, '::1', 5, 'hhhhh John', 4663762733, 'testwebnamelength', 'cdssa52180', '2021-03-05 10:09:34'),
(7, '::1', 4, 'etname', 5665654365, 'webone', 'john.17184', '2021-03-05 10:09:34'),
(8, '::1', 5, 'namename', 6767865604, 'webone', 'john.17184', '2021-03-05 10:09:34'),
(9, '::1', 5, 'namenamename', 6767865604, 'webone', 'john.17184', '2021-03-05 10:09:34');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `bdy` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT 0,
  `user_form_key` varchar(255) DEFAULT '0',
  `m_id` varchar(255) NOT NULL,
  `txn_id` varchar(255) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `currency` varchar(255) NOT NULL,
  `paid_amt` int(11) NOT NULL,
  `payment_mode` varchar(255) NOT NULL,
  `gateway_name` varchar(255) NOT NULL,
  `bank_txn_id` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `check_sum_hash` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `paid_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `quota`
--

CREATE TABLE `quota` (
  `id` int(11) NOT NULL,
  `by_user_id` int(11) NOT NULL,
  `bought` bigint(20) NOT NULL,
  `used` bigint(20) NOT NULL,
  `bal` bigint(20) NOT NULL,
  `webspace` int(255) NOT NULL,
  `webspace_left` int(255) NOT NULL,
  `userspace` int(255) NOT NULL,
  `userspace_left` int(255) NOT NULL,
  `by_form_key` varchar(255) NOT NULL,
  `bought_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quota`
--

INSERT INTO `quota` (`id`, `by_user_id`, `bought`, `used`, `bal`, `webspace`, `webspace_left`, `userspace`, `userspace_left`, `by_form_key`, `bought_at`) VALUES
(19, 44, 100, 12, 88, 15, 15, 0, 0, 'cdssa97667', '2021-02-13 07:08:06'),
(25, 49, 50, 18, 32, 10, 7, 5, 2, 'cdssa52180', '2021-09-07 08:23:53'),
(28, 52, 100, 0, 100, 15, 12, 0, 0, 'hhhhh74672', '2021-09-20 12:22:17'),
(29, 53, 0, 0, 0, 0, 0, 0, 0, 'john.17184', '2021-09-22 07:22:43'),
(30, 54, 0, 0, 0, 0, 0, 0, 0, 'jvwee88603', '2021-09-22 07:27:10'),
(31, 55, 0, 0, 0, 0, 0, 0, 0, 'usero40541', '2021-09-22 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `sent_links`
--

CREATE TABLE `sent_links` (
  `id` int(11) NOT NULL,
  `sent_to_sms` longtext DEFAULT NULL,
  `sent_to_email` varchar(255) DEFAULT NULL,
  `subj` text DEFAULT NULL,
  `body` longtext NOT NULL,
  `user_id` int(255) NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sent_links`
--

INSERT INTO `sent_links` (`id`, `sent_to_sms`, `sent_to_email`, `subj`, `body`, `user_id`, `sent_at`) VALUES
(1, NULL, 'olatayoefficient@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating/wtr/jvwee41944\r\n\r\nJVweed\r\njohn.nktech@gmail.com\r\nRegards', 49, '2021-03-05 08:56:15'),
(2, '5334325142', NULL, 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating/wtr/jvwee41944\r\n\r\nJVweed\r\njohn.nktech@gmail.com\r\nRegards Click the link below, to rate any of my websites\r\nhttp://localhost/rating/wtr/jvwee41944\r\n\r\nJVweed\r\njohn.nktech@gmail.com\r\nRegards', 49, '2021-03-05 08:56:15'),
(4, NULL, 'a@gmail.com,b@gmail.com,c@gmail.com,olatayoefficient@gmail.com,johnnktech@gmail.com,olatayojohn10@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/cdssa97667\n\ncdssa\nolatayoefficient@gmail.com\nRegards', 44, '2021-09-21 06:58:02'),
(5, NULL, 'cdssa@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/cdssa97667\r\n\r\ncdssa\r\nolatayoefficient@gmail.com\r\nRegards', 44, '2021-09-21 07:07:37'),
(9, NULL, ',,,,', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/cdssa97667\n\ncdssa\nolatayoefficient@gmail.com\nRegards', 44, '2021-09-21 09:57:17'),
(10, NULL, 'cdssamail@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/john.17184\r\n\r\njohn.nktech.test\r\njohn.nktech.test@gmail.com\r\nRegards', 53, '2021-09-27 08:29:45'),
(11, NULL, 'a@gmail.com,b@gmail.com,c@gmail.com,olatayoefficient@gmail.com,johnnktech@gmail.com,olatayojohn10@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/john.17184\n\njohn.nktech.test\njohn.nktech.test@gmail.com\nRegards', 53, '2021-09-27 08:37:21');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `sadmin` int(11) NOT NULL DEFAULT 0,
  `admin` int(1) NOT NULL DEFAULT 0,
  `iscmpy` int(1) NOT NULL DEFAULT 0,
  `cmpy` varchar(255) DEFAULT NULL,
  `cmpyid` int(255) DEFAULT NULL,
  `uname` varchar(255) NOT NULL,
  `fname` longtext DEFAULT NULL,
  `lname` longtext DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `website_form` int(1) NOT NULL DEFAULT 0,
  `sub` int(1) NOT NULL DEFAULT 0,
  `act_key` varchar(255) NOT NULL,
  `form_key` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `latest_activity` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sadmin`, `admin`, `iscmpy`, `cmpy`, `cmpyid`, `uname`, `fname`, `lname`, `email`, `mobile`, `active`, `website_form`, `sub`, `act_key`, `form_key`, `password`, `latest_activity`, `created_at`) VALUES
(44, 1, 0, 0, NULL, NULL, 'cdssa', '', '', 'cdssa@gmail.com', 5446765456, 1, 0, 1, '$2y$10$0GGLzdfF9MRsV/kzrF7YleV0tNfC.Z6XZh2hRSixA/TNWqfUtoBjq', 'cdssa97667', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 09-Nov-2021 05:14:53 CET', '2021-02-13 07:08:05'),
(49, 0, 1, 1, 'NKTECH', NULL, 'cdssatest', '', '', 'john.nktech@gmail.com', 7456034855, 1, 1, 0, '$2y$10$qP2l7Rk7L.MAxWMiyZCTRe1BAa4/5m17qaBNtKGBuQSUxbzDZKrTq', 'cdssa52180', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 09-Nov-2021 13:23:36 CET', '2021-09-07 08:23:52'),
(52, 0, 0, 0, NULL, NULL, 'hhhhh', 'normal', 'user', 'normaluser@gmail.com', 4555565675, 1, 1, 0, '$2y$10$y72Ebn/wRjQfKitj7vlZgea3ZRKF4elOXM18CkeCUKR8PzNaVB.yy', 'hhhhh74672', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 09-Nov-2021 12:19:25 CET', '2021-09-20 12:22:17'),
(53, 0, 0, 1, 'NKTECH', 49, 'john.nktech.test', 'john', 'nktech', 'john.nktech@gmail.com', 7456034859, 1, 1, 0, '$2y$10$PJ0KJm6pZt1GB2G4zB6gT.jTebyIlWlZZxQLU9TGb.N0oNn6JTIL.', 'john.17184', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 09-Nov-2021 12:15:46 CET', '2021-09-22 07:22:43'),
(54, 0, 0, 1, 'NKTECH', 49, 'jvweed', 'olatayo', 'john', 'olatayojohn@gmail.com', 7456034856, 2, 0, 0, '$2y$10$jz0zNLgOuzYG6hJoSRI/d.201FXXF/JvwF6BW3YvkSIKa/gQU6CIa', 'jvwee88603', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 09-Nov-2021 06:16:47 CET', '2021-09-22 07:27:10'),
(55, 0, 0, 1, 'NKTECH', 49, 'userone', 'user', 'one', 'userone@gmail.com', 4665748334, 2, 0, 0, '$2y$10$gsb7trlrsjT74VvcDje3b.wKDEmX3FKV.PyWFB90looi8tGYtgzgS', 'usero40541', '$2y$10$uEMYCbG9G2C.tEFMGOWhLu4G2O3YbXGfc378dFlRLrTU/S9SRqH/S', '', '2021-09-22 12:29:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_details`
--

CREATE TABLE `user_details` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_key` varchar(255) NOT NULL,
  `uname` varchar(255) NOT NULL,
  `total_ratings` bigint(20) NOT NULL,
  `total_sms` int(11) NOT NULL,
  `total_email` int(11) NOT NULL,
  `total_one` bigint(20) NOT NULL,
  `total_two` bigint(20) NOT NULL,
  `total_three` bigint(20) NOT NULL,
  `total_four` bigint(20) NOT NULL,
  `total_five` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_details`
--

INSERT INTO `user_details` (`id`, `user_id`, `form_key`, `uname`, `total_ratings`, `total_sms`, `total_email`, `total_one`, `total_two`, `total_three`, `total_four`, `total_five`) VALUES
(40, 44, 'cdssa97667', 'cdssa', 0, 0, 12, 0, 0, 0, 0, 0),
(45, 49, 'cdssa52180', 'cdssatest', 6, 1, 1, 0, 0, 0, 3, 3),
(48, 52, 'hhhhh74672', 'hhhhh', 0, 0, 0, 0, 0, 0, 0, 0),
(49, 53, 'john.17184', 'john.nktech', 3, 0, 7, 0, 0, 0, 1, 2),
(50, 54, 'jvwee88603', 'jvweed', 0, 0, 0, 0, 0, 0, 0, 0),
(51, 55, 'usero40541', 'userone', 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `websites`
--

CREATE TABLE `websites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `form_key` varchar(32) NOT NULL,
  `web_name` varchar(255) NOT NULL,
  `web_link` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `total_ratings` bigint(20) NOT NULL,
  `five_star` bigint(20) NOT NULL,
  `four_star` bigint(20) NOT NULL,
  `three_star` bigint(20) NOT NULL,
  `two_star` bigint(20) NOT NULL,
  `one_star` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `websites`
--

INSERT INTO `websites` (`id`, `user_id`, `form_key`, `web_name`, `web_link`, `active`, `total_ratings`, `five_star`, `four_star`, `three_star`, `two_star`, `one_star`) VALUES
(16, 49, 'cdssa52180', 'webthree', 'webthree.com', 1, 2, 1, 1, 0, 0, 0),
(17, 49, 'cdssa52180', 'testwebnamelength', 'testweb.com', 1, 4, 2, 2, 0, 0, 0),
(20, 53, 'john.17184', 'webone', 'webone.com', 1, 3, 2, 1, 0, 0, 0),
(23, 52, 'hhhhh74672', 'myweb', 'myweb.com', 1, 0, 0, 0, 0, 0, 0),
(29, 52, 'hhhhh74672', 'myweb_', 'mywebb.com', 1, 0, 0, 0, 0, 0, 0),
(30, 52, 'hhhhh74672', 'test test', 'https://ggg.com', 1, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity`
--
ALTER TABLE `activity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `all_ratings`
--
ALTER TABLE `all_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `quota`
--
ALTER TABLE `quota`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sent_links`
--
ALTER TABLE `sent_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_details`
--
ALTER TABLE `user_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websites`
--
ALTER TABLE `websites`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity`
--
ALTER TABLE `activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `all_ratings`
--
ALTER TABLE `all_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `quota`
--
ALTER TABLE `quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `sent_links`
--
ALTER TABLE `sent_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
