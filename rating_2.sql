-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2021 at 03:22 PM
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
(1, 'New Websites created | User. [ID: 49, Web: 1]', 'Monday, 27-Sep-2021 09:25:47 CEST'),
(2, 'Logged In | User. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 09:29:00 CEST'),
(3, 'Logged Out. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 09:31:08 CEST'),
(4, 'New Website created | User. [ID: 49, WebName: ineb, WebLink: ineb.com]', 'Monday, 27-Sep-2021 09:45:19 CEST'),
(5, 'New Website created | User. [ID: 49, WebName: ineb3, WebLink: ineb3.com]', 'Monday, 27-Sep-2021 09:45:47 CEST'),
(6, 'Logged Out. [ID: 49, Name: cdssatest]', 'Monday, 27-Sep-2021 09:47:51 CEST'),
(7, 'Logged In | User. [ID: 52, Name: hhhhh]', 'Monday, 27-Sep-2021 09:47:55 CEST'),
(8, 'Logged Out. [ID: 52, Name: hhhhh]', 'Monday, 27-Sep-2021 09:48:26 CEST'),
(9, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Monday, 27-Sep-2021 09:48:29 CEST'),
(10, 'Logged Out. [ID: 49, Name: cdssatest]', 'Monday, 27-Sep-2021 09:52:44 CEST'),
(11, 'Logged In | User. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 09:52:49 CEST'),
(12, 'Logged Out. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 09:54:01 CEST'),
(13, 'Logged In | User. [ID: 44, Name: cdssa]', 'Monday, 27-Sep-2021 09:54:06 CEST'),
(14, 'Logged Out. [ID: 44, Name: cdssa]', 'Monday, 27-Sep-2021 09:54:21 CEST'),
(15, 'Logged In | User. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 10:03:49 CEST'),
(16, 'Sent single mail | User. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 10:29:44 CEST'),
(17, 'Quota too small | User. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 10:31:32 CEST'),
(18, 'Quota too small | User. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 10:36:41 CEST'),
(19, 'Logged Out. [ID: 53, Name: john.nktech.test]', 'Monday, 27-Sep-2021 10:38:07 CEST'),
(20, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Monday, 27-Sep-2021 10:38:12 CEST'),
(21, 'Logged Out. [ID: , Name: ]', 'Monday, 27-Sep-2021 13:11:38 CEST'),
(22, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Monday, 27-Sep-2021 13:30:07 CEST'),
(23, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Tuesday, 28-Sep-2021 07:05:08 CEST'),
(24, 'Logged Out. [ID: , Name: ]', 'Tuesday, 28-Sep-2021 11:35:38 CEST'),
(25, 'Logged In | User. [ID: 49, Name: cdssatest]', 'Tuesday, 28-Sep-2021 11:35:41 CEST'),
(26, 'User Deleted | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 12:56:36 CEST'),
(27, 'User profile updated | Admin. [ID: 49, UserID: 53, Username: ]', 'Tuesday, 28-Sep-2021 13:29:12 CEST'),
(28, 'User profile updated | Admin. [ID: 49, UserID: 53, Username: ]', 'Tuesday, 28-Sep-2021 13:29:44 CEST'),
(29, 'User profile updated | Admin. [ID: 49, UserID: 53, Username: ]', 'Tuesday, 28-Sep-2021 13:35:35 CEST'),
(30, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:38:01 CEST'),
(31, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:38:46 CEST'),
(32, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:39:55 CEST'),
(33, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:40:36 CEST'),
(34, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:41:05 CEST'),
(35, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:41:43 CEST'),
(36, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:42:39 CEST'),
(37, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:44:41 CEST'),
(38, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:45:11 CEST'),
(39, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:47:28 CEST'),
(40, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:49:52 CEST'),
(41, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:54:21 CEST'),
(42, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:55:35 CEST'),
(43, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:56:07 CEST'),
(44, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:56:17 CEST'),
(45, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:56:59 CEST'),
(46, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:58:10 CEST'),
(47, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:58:50 CEST'),
(48, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 13:59:52 CEST'),
(49, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:00:20 CEST'),
(50, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:01:12 CEST'),
(51, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:01:29 CEST'),
(52, 'User profile updated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:02:47 CEST'),
(53, 'Error deactivating user account | Admin. [ID: 49, UserID: ]', 'Tuesday, 28-Sep-2021 14:33:11 CEST'),
(54, 'Error deactivating user account | Admin. [ID: 49, UserID: ]', 'Tuesday, 28-Sep-2021 14:33:44 CEST'),
(55, 'Error deactivating user account | Admin. [ID: 49, UserID: ]', 'Tuesday, 28-Sep-2021 14:34:28 CEST'),
(56, 'Error deactivating user account | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:35:14 CEST'),
(57, 'Error deactivating user account | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:36:08 CEST'),
(58, 'User account Deactivated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:36:41 CEST'),
(59, 'User account Deactivated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:38:08 CEST'),
(60, 'User account Activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:38:15 CEST'),
(61, 'User account Activated | Admin. [ID: 49, UserID: 54]', 'Tuesday, 28-Sep-2021 14:42:12 CEST'),
(62, 'User account Deactivated | Admin. [ID: 49, UserID: 54]', 'Tuesday, 28-Sep-2021 14:42:31 CEST'),
(63, 'User subscription activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:53:15 CEST'),
(64, 'User subscription activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:54:49 CEST'),
(65, 'User subscription Deactivated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:55:02 CEST'),
(66, 'User subscription activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:57:23 CEST'),
(67, 'User subscription activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:57:52 CEST'),
(68, 'User subscription Deactivated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:57:57 CEST'),
(69, 'User subscription activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 14:58:43 CEST'),
(70, 'Error deactivating user subscription | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 15:03:54 CEST'),
(71, 'User subscription activated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 15:06:48 CEST'),
(72, 'User subscription Deactivated | Admin. [ID: 49, UserID: 53]', 'Tuesday, 28-Sep-2021 15:06:53 CEST');

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
(25, 49, 50, 18, 32, 10, 7, 5, 0, 'cdssa52180', '2021-09-07 08:23:53'),
(28, 52, 100, 0, 100, 15, 14, 0, 0, 'hhhhh74672', '2021-09-20 12:22:17'),
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
(44, 1, 0, 0, NULL, NULL, 'cdssa', '', '', 'cdssa@gmail.com', 5446765456, 1, 0, 1, '$2y$10$8C61BUT0L4hIj6baOuRom.7cX87w3IkL2b6SjIU1ms2Ri90oDJS6S', 'cdssa97667', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Monday, 27-Sep-2021 09:54:06 CEST', '2021-02-13 07:08:05'),
(49, 0, 1, 1, 'NKTECH', NULL, 'cdssatest', '', '', 'john.nktech@gmail.com', 7456034855, 1, 1, 0, '$2y$10$qP2l7Rk7L.MAxWMiyZCTRe1BAa4/5m17qaBNtKGBuQSUxbzDZKrTq', 'cdssa52180', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 28-Sep-2021 11:35:41 CEST', '2021-09-07 08:23:52'),
(52, 0, 0, 0, NULL, NULL, 'hhhhh', 'normal', 'user', 'normaluser@gmail.com', 4555565675, 1, 1, 0, '$2y$10$y72Ebn/wRjQfKitj7vlZgea3ZRKF4elOXM18CkeCUKR8PzNaVB.yy', 'hhhhh74672', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Monday, 27-Sep-2021 09:47:55 CEST', '2021-09-20 12:22:17'),
(53, 0, 0, 1, 'NKTECH', 49, 'john.nktech.test', 'john', 'nktech', 'john.nktech.test@gmail.com', 7456034859, 1, 1, 0, '$2y$10$PJ0KJm6pZt1GB2G4zB6gT.jTebyIlWlZZxQLU9TGb.N0oNn6JTIL.', 'john.17184', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Monday, 27-Sep-2021 10:03:49 CEST', '2021-09-22 07:22:43'),
(54, 0, 0, 1, 'NKTECH', 49, 'jvweed', 'olatayo', 'john', 'john.nktech@gmail.com', 7456034856, 2, 0, 0, '$2y$10$jz0zNLgOuzYG6hJoSRI/d.201FXXF/JvwF6BW3YvkSIKa/gQU6CIa', 'jvwee88603', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', '', '2021-09-22 07:27:10'),
(55, 0, 0, 1, 'NKTECH', 49, 'userone', 'user', 'one', 'userone@gmail.com', 4665748334, 0, 0, 0, '$2y$10$gsb7trlrsjT74VvcDje3b.wKDEmX3FKV.PyWFB90looi8tGYtgzgS', 'usero40541', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', '', '2021-09-22 12:29:01');

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
(23, 52, 'hhhhh74672', 'myweb', 'myweb.com', 1, 0, 0, 0, 0, 0, 0);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
