-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2021 at 12:39 PM
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
-- Database: `rating`
--

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
  `user_id` int(11) NOT NULL,
  `user_form_key` varchar(255) NOT NULL,
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

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `user_id`, `user_form_key`, `m_id`, `txn_id`, `order_id`, `currency`, `paid_amt`, `payment_mode`, `gateway_name`, `bank_txn_id`, `bank_name`, `check_sum_hash`, `status`, `paid_at`) VALUES
(2, 7, 'nktech25107', 'iIBeFs81533256459164', '20210218111212800110168035902372873', 3930042, 'INR', 500, 'NB', 'PNB', '11658353898', 'PNB', 'NxsV326Uh2p5eHq/tQMI6cODg8eOMTerokpaB7nlwDrBMaHbHDwNdnHDkhlx4TSwMxa3IapkMYQplrri/xHeZZlxjxgyKqNvYD+C9nVo3nI=', 'TXN_SUCCESS', '2021-02-18 08:29:39'),
(3, 7, 'nktech25107', 'iIBeFs81533256459164', '20210218111212800110168274502354224', 1108119, 'INR', 1000, 'NB', 'ICICI', '11034846835', 'ICICI', 'r6UANs8QfAYl+NMe7aJAPAsKOUnx747ORCjoLU4dsP919NS5NgV8MnXBQQPe2He5QyMZoVv4bFCJwmeZzYVOngPEdlepBkYRax+h9un1LCs=', 'TXN_SUCCESS', '2021-02-18 09:53:57');

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
  `by_form_key` varchar(255) NOT NULL,
  `bought_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quota`
--

INSERT INTO `quota` (`id`, `by_user_id`, `bought`, `used`, `bal`, `by_form_key`, `bought_at`) VALUES
(17, 7, 1500, 0, 1500, 'nktech25107', '2020-11-26 05:46:01'),
(18, 14, 0, 0, 0, 'testname36458', '2020-11-26 05:46:01'),
(19, 44, 0, 0, 0, 'cdssa97667', '2021-02-13 07:08:06');

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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `s_admin` int(1) NOT NULL DEFAULT 0,
  `admin` int(1) NOT NULL DEFAULT 0,
  `uname` varchar(255) NOT NULL,
  `fname` longtext DEFAULT NULL,
  `lname` longtext DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT 0,
  `website_form` int(1) NOT NULL DEFAULT 0,
  `sub` int(1) NOT NULL DEFAULT 0,
  `sub_active` int(1) NOT NULL DEFAULT 0,
  `web_quota` bigint(255) NOT NULL DEFAULT 10,
  `act_key` varchar(255) NOT NULL,
  `form_key` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `s_admin`, `admin`, `uname`, `fname`, `lname`, `email`, `mobile`, `active`, `website_form`, `sub`, `sub_active`, `web_quota`, `act_key`, `form_key`, `password`, `created_at`) VALUES
(7, 1, 1, 'nktech', 'NKTECH', 'test_last_name', 'john.nktech@gmail.com', 8920877101, 1, 1, 1, 0, 10, '$2y$10$9ZcjM4o5eldhu/Clox/LpOTGBen3ZA3SmTZ79YZyfYXio9RNN4ari', 'nktech25107', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', '2020-10-30 13:30:07'),
(13, 0, 0, 'test two', 'Test two', 'name', 'olatayoefficient@gmail.com', 8920877101, 0, 0, 0, 0, 2, '$2y$10$RbR.2P/6ugN4BoalG2hGFOD.aH6PQOuFBc3PuXf3azOy/U1GlldGu', 'testtwo45637', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', '2020-10-30 13:30:07'),
(14, 0, 0, 'test_name', 'test', '', 'olatayoefficient@gmail.com', 7456034856, 0, 0, 0, 0, 10, '$2y$10$9ZcjM4o5eldhu/Clox/LpOTGBen3ZA3SmTZ79YZyfYXio9RNN4ari', 'testname36458', '$2y$10$LnwwSHazrMfxkMP.T5ZSjO8dBZ6mzHWOcAKkyR2i98Fx9IXOBBOJe', '2020-11-26 05:46:00'),
(44, 0, 0, 'cdssa', 'olatayo', 'John', 'olatayoefficient@gmail.com', 4555565634, 1, 1, 0, 0, 10, '$2y$10$8C61BUT0L4hIj6baOuRom.7cX87w3IkL2b6SjIU1ms2Ri90oDJS6S', 'cdssa97667', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', '2021-02-13 07:08:05');

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
(1, 7, 'nktech25107', 'nktech', 0, 0, 0, 0, 0, 0, 0, 0),
(3, 13, 'testtwo45637', 'test two', 0, 0, 0, 0, 0, 0, 0, 0),
(39, 13, 'testname36458', 'test_name', 0, 0, 0, 0, 0, 0, 0, 0),
(40, 44, 'cdssa97667', 'cdssa', 0, 0, 0, 0, 0, 0, 0, 0);

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
(1, 7, 'nktech25107', 'official website', 'https://nktech.in', 1, 0, 0, 0, 0, 0, 0),
(2, 7, 'nktech25107', 'google', 'https://google.com', 1, 0, 0, 0, 0, 0, 0),
(3, 7, 'nktech25107', 'facebook', 'https://fb.com', 0, 0, 0, 0, 0, 0, 0),
(5, 7, 'nktech25107', 'glassdoor', 'https://glassdoor.com', 1, 0, 0, 0, 0, 0, 0),
(6, 7, 'nktech25107', 'trust pilot', 'https://trustpilot.com', 0, 0, 0, 0, 0, 0, 0),
(49, 44, 'cdssa97667', 'test test', 'https://testest.com', 1, 0, 0, 0, 0, 0, 0),
(50, 44, 'cdssa97667', 'etst web name', 'http://www.etstwebname.com', 1, 0, 0, 0, 0, 0, 0),
(51, 44, 'cdssa97667', 'another testing', 'http://anothertesting.com', 1, 0, 0, 0, 0, 0, 0),
(52, 44, 'cdssa97667', 'http://anothertesting.com', 'http://anothertestingtwo.com', 1, 0, 0, 0, 0, 0, 0),
(54, 44, 'cdssa97667', 'fff-two', 'https://ggg.com', 1, 0, 0, 0, 0, 0, 0),
(55, 44, 'cdssa97667', 'fff-3', 'https://ggg.com', 0, 0, 0, 0, 0, 0, 0),
(56, 44, 'cdssa97667', 'fff-4', 'https://ggg.com', 1, 0, 0, 0, 0, 0, 0),
(57, 44, 'cdssa97667', 'fff-5', 'https://ggg.com', 1, 0, 0, 0, 0, 0, 0),
(58, 44, 'cdssa97667', 'fff-6', 'https://ggg.com', 0, 0, 0, 0, 0, 0, 0),
(78, 44, 'cdssa97667', 'test alert', 'https://sgsgs.com', 1, 0, 0, 0, 0, 0, 0);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `all_ratings`
--
ALTER TABLE `all_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `quota`
--
ALTER TABLE `quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sent_links`
--
ALTER TABLE `sent_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `user_details`
--
ALTER TABLE `user_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
