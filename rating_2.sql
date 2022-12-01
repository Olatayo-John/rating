-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 01, 2022 at 01:20 PM
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
(1, 'Logs table cleared. [ID: 44, Name: cdssa]', 'Thursday, 01-Dec-2022 13:31:21 IST'),
(2, 'User subscription Deactivated | Admin | [ID: 44, UserID: 56]', 'Thursday, 01-Dec-2022 14:21:26 IST'),
(3, 'Logged In | User | [ID: 49, Name: cdssatest]', 'Thursday, 01-Dec-2022 14:22:23 IST'),
(4, 'Logged Out. [ID: , Name: ]', 'Thursday, 01-Dec-2022 16:30:59 IST'),
(5, 'Failed Login Attempt- Inactive Account | User | [Name: xyz]', 'Thursday, 01-Dec-2022 16:31:11 IST'),
(6, 'Logged In | User | [ID: 59, Name: xyz]', 'Thursday, 01-Dec-2022 16:31:31 IST'),
(7, 'New Website created | User | [ID: 59, WebName: xyzplatform, WebLink: xyzplatform.com]', 'Thursday, 01-Dec-2022 16:33:27 IST');

-- --------------------------------------------------------

--
-- Table structure for table `all_ratings`
--

CREATE TABLE `all_ratings` (
  `id` int(11) NOT NULL,
  `user_ip` varchar(45) NOT NULL,
  `star` int(11) DEFAULT NULL,
  `review` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `mobile` bigint(255) DEFAULT NULL,
  `web_name` varchar(255) NOT NULL,
  `web_link` varchar(255) NOT NULL,
  `form_key` varchar(32) NOT NULL,
  `rated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `company_details`
--

CREATE TABLE `company_details` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `cmpyName` varchar(255) NOT NULL,
  `cmpyMobile` varchar(255) DEFAULT NULL,
  `cmpyEmail` text DEFAULT NULL,
  `cmpyLogo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `company_details`
--

INSERT INTO `company_details` (`id`, `userid`, `cmpyName`, `cmpyMobile`, `cmpyEmail`, `cmpyLogo`) VALUES
(1, 49, 'ABCD', '', 'abc@gmail.com', 'abc_logo.jpg'),
(2, 59, 'XYZ', '', 'abc@gmail.com', 'xyz_logo.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `bdy` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
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
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` varchar(255) NOT NULL,
  `sms_quota` varchar(255) NOT NULL,
  `email_quota` varchar(255) NOT NULL,
  `whatsapp_quota` varchar(255) NOT NULL,
  `web_quota` varchar(255) NOT NULL,
  `orderBy` int(11) NOT NULL DEFAULT 1,
  `active` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `amount`, `sms_quota`, `email_quota`, `whatsapp_quota`, `web_quota`, `orderBy`, `active`) VALUES
(1, 'Free Plan', '0.00 /per month', '5', '100', '25', '1', 1, 1),
(2, 'Basic Plan', '1.00 /per month', '5', '100', '50', '2', 2, 1),
(3, 'Regular Plan', '2.00 /per month', '5', '100', '100', '3', 3, 0),
(4, 'Test Plan', '500 /per month', '50', '50', '50', '10', 4, 1),
(5, 'ggg', '55', '5', '5', '5', '5', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `quota`
--

CREATE TABLE `quota` (
  `id` int(11) NOT NULL,
  `by_user_id` int(11) NOT NULL,
  `sms_quota` int(255) NOT NULL,
  `email_quota` int(255) NOT NULL,
  `whatsapp_quota` int(255) NOT NULL,
  `web_quota` int(255) NOT NULL,
  `by_form_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `quota`
--

INSERT INTO `quota` (`id`, `by_user_id`, `sms_quota`, `email_quota`, `whatsapp_quota`, `web_quota`, `by_form_key`) VALUES
(19, 44, 1000000, 1000000, 1000000, 99999, 'cdssa97667'),
(25, 49, 5, 97, 3, 3, 'cdssa52180'),
(28, 52, 1, 91, 1, 3, 'hhhhh74672'),
(31, 55, 0, 0, 0, 0, 'usero40541'),
(32, 56, 0, 0, 0, 0, 'usert73279'),
(33, 57, 0, 0, 0, 0, 'usert13336'),
(34, 58, 5, 100, 5, 5, 'vvvvv94484'),
(35, 59, 5, 100, 5, 4, 'xyz78253');

-- --------------------------------------------------------

--
-- Table structure for table `sent_links`
--

CREATE TABLE `sent_links` (
  `id` int(11) NOT NULL,
  `link_for` varchar(255) NOT NULL,
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

INSERT INTO `sent_links` (`id`, `link_for`, `sent_to_sms`, `sent_to_email`, `subj`, `body`, `user_id`, `sent_at`) VALUES
(1, 'email', '', 'olatayojohn10@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/hhhhh74672\r\n\r\nhhhhh\r\nhhhhh@gmail.com\r\nRegards', 52, '2022-11-08 07:19:03'),
(2, 'email', '', 'testmail@gmail.com', 'Rating', 'hhhhh\r\nhhhhh@gmail.com\r\nRegards', 52, '2022-11-08 07:52:15'),
(3, 'email', '', 'olatayojohn10@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/hhhhh74672\r\n\r\nhhhhh\r\nhhhhh@gmail.com\r\nRegards', 52, '2022-11-08 07:52:52'),
(4, 'email', '', 'olatayojohn10@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/hhhhh74672\r\n\r\nhhhhh\r\nhhhhh@gmail.com\r\nRegards', 52, '2022-11-08 07:52:57'),
(5, 'sms', '7556435678', '', '', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/hhhhh74672\r\n\r\nhhhhh\r\nhhhhh@gmail.com\r\nRegards', 52, '2022-11-08 07:53:09'),
(12, 'email', '', 'a@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 06:27:00'),
(13, 'email', '', 'b@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 06:27:00'),
(14, 'email', '', 'c@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 06:27:00'),
(15, 'email', '', 'olatayoefficient@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 06:27:00'),
(16, 'email', '', 'johnnktech@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 06:27:00'),
(20, 'sms', '5887736459', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 07:33:10'),
(21, 'sms', '5887736459', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 07:33:10'),
(22, 'sms', '5887736459', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 07:33:11'),
(23, 'whatsapp', '7556435678', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-09 08:10:58'),
(24, 'email', '', 'testmail@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/usero40541\r\n\r\nuserone\r\nuserone@nktech.com\r\nRegards', 55, '2022-11-15 11:38:28'),
(25, 'email', '', 'janedoe@nktech.in', 'test subject', 'test body test test test', 55, '2022-11-15 11:40:16'),
(26, 'email', '', 'abc@gmail.com', 'Rating', 'Click the link below, to rate any of my websites\r\nhttp://localhost/rating2/wtr/cdssa52180\r\n\r\ncdssatest\r\ncompanyadmin@gmail.com\r\nRegards', 49, '2022-11-15 11:40:49'),
(27, 'whatsapp', '1234567890', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/cdssa52180\n\ncdssatest\ncompanyadmin@gmail.com\nRegards', 49, '2022-11-15 11:41:31'),
(28, 'whatsapp', '6665432346', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/cdssa52180\n\ncdssatest\ncompanyadmin@gmail.com\nRegards', 49, '2022-11-15 11:43:37'),
(29, 'whatsapp', '1234567890', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-16 10:56:02'),
(30, 'whatsapp', '1234567890', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-16 10:57:48'),
(31, 'whatsapp', '1234567890', '', '', 'Click the link below, to rate any of my websites\nhttp://localhost/rating2/wtr/hhhhh74672\n\nhhhhh\nhhhhh@gmail.com\nRegards', 52, '2022-11-16 10:58:30');

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
  `gender` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
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

INSERT INTO `users` (`id`, `sadmin`, `admin`, `iscmpy`, `cmpy`, `cmpyid`, `uname`, `fname`, `lname`, `email`, `mobile`, `gender`, `dob`, `active`, `website_form`, `sub`, `act_key`, `form_key`, `password`, `latest_activity`, `created_at`) VALUES
(44, 1, 0, 0, NULL, NULL, 'cdssa', 'super', 'Admin', 'superadmin@gmail.com', 5446765456, 'Male', '0000-00-00', 1, 1, 1, '$2y$10$SduzKFtU4KB.gKlV3jH.meDSQAjx2kG83/riCR4ZV/yS0p4SBC.kC', 'cdssa97667', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Thursday, 01-Dec-2022 12:06:23 IST', '2021-02-13 07:08:05'),
(49, 0, 1, 1, 'ABCD', NULL, 'cdssatest', 'abc-name', '', 'companyadmin@gmail.com', 1234567890, 'Other', '2022-11-01', 1, 1, 1, '$2y$10$qP2l7Rk7L.MAxWMiyZCTRe1BAa4/5m17qaBNtKGBuQSUxbzDZKrTq', 'cdssa52180', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Thursday, 01-Dec-2022 14:22:22 IST', '2021-09-07 08:23:52'),
(52, 0, 0, 0, NULL, NULL, 'hhhhh', 'hhhhh', '', 'hhhhh@gmail.com', 4555565675, 'Female', '2022-11-16', 1, 1, 1, '$2y$10$L7DVvCO4pvpEQEw3yLSeaebFkYFOt1nvHDMsGtWCTRFmNXz7zmHPm', 'hhhhh74672', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Thursday, 24-Nov-2022 16:10:31 IST', '2021-09-20 12:22:17'),
(55, 0, 0, 1, 'ABCD', 49, 'userone', 'userone', '', 'userone@nktech.com', 8663524345, 'Female', '1998-03-20', 1, 1, 0, '$2y$10$gsb7trlrsjT74VvcDje3b.wKDEmX3FKV.PyWFB90looi8tGYtgzgS', 'usero40541', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 15-Nov-2022 17:07:41 IST', '2021-09-22 12:29:01'),
(56, 0, 0, 1, 'ABCD', 49, 'usertwo', 'usertwo', '', 'usertwo@nktech.com', 7353529180, 'Female', '0000-00-00', 0, 0, 0, '$2y$10$vmPAs3SiANi3cFjTCHKlmeSwGNoEeB/wyk6hXQH2OVUz5dFJMxExi', 'usert73279', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Thursday, 01-Dec-2022 11:53:38 IST', '2022-11-14 06:51:47'),
(57, 0, 0, 1, 'ABCD', 49, 'userthree', 'userthree', '', 'userthree@nktech.com', 5665323457, 'Female', '0000-00-00', 0, 0, 0, '$2y$10$q6aMNjt1Nkj.eXqkpQfLkOG6.pMywa0jdsjla2BGQuV2BfOSmmMDa', 'usert13336', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', '', '2022-11-14 07:15:21'),
(58, 0, 0, 0, '', NULL, 'vvvvv', 'john', '', 'john@gmail.com', 5664723823, 'Male', '1998-03-29', 0, 0, 0, '$2y$10$nAVkPXdk8zFp/1kWn0BoqegzDBlWIXpf.8cYhj8FHizBNgoB70/Km', 'vvvvv94484', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Tuesday, 15-Nov-2022 15:32:05 IST', '2022-11-15 08:37:40'),
(59, 0, 1, 1, 'XYZ', NULL, 'xyz', 'xyz-name', '', 'companyadmin@gmail.com', 1234567890, 'Male', '0000-00-00', 1, 0, 0, '$2y$10$qC2ja0lIapOGVWQK6NN3Su8Z9m3/FEHkLPE62UXKEtOdDGmZ.vmkm', 'xyz78253', '$2y$10$W4k87xr1ysG3gSSFcJQCGOh3igPrFgSzRqT8HepawwbSkKOB/..1G', 'Thursday, 01-Dec-2022 16:31:31 IST', '2022-11-15 08:40:44');

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
  `star_rating` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `websites`
--

INSERT INTO `websites` (`id`, `user_id`, `form_key`, `web_name`, `web_link`, `active`, `total_ratings`, `star_rating`) VALUES
(10, 52, 'hhhhh74672', 'testWeb', 'https://google.com', 1, 0, 0),
(15, 55, 'usero40541', 'nnn', 'http://localhost/rating2/websites', 1, 0, 0),
(20, 49, 'cdssa52180', 'my-website', 'mywebsite.com', 0, 0, 0),
(21, 52, 'hhhhh74672', 'website-two', 'websitetwo.com', 1, 0, 0),
(22, 44, 'cdssa97667', 'mywebsite', 'somelink.com', 1, 0, 0),
(24, 59, 'xyz78253', 'xyzplatform', 'xyzplatform.com', 1, 0, 0);

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
-- Indexes for table `company_details`
--
ALTER TABLE `company_details`
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
-- Indexes for table `plans`
--
ALTER TABLE `plans`
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `all_ratings`
--
ALTER TABLE `all_ratings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_details`
--
ALTER TABLE `company_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quota`
--
ALTER TABLE `quota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `sent_links`
--
ALTER TABLE `sent_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `websites`
--
ALTER TABLE `websites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
