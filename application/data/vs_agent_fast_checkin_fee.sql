-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 21, 2019 at 09:43 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 5.6.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vietnamvisa`
--

-- --------------------------------------------------------

--
-- Table structure for table `vs_agent_fast_checkin_fee`
--

CREATE TABLE `vs_agent_fast_checkin_fee` (
  `id` int(10) UNSIGNED NOT NULL,
  `agents_id` bigint(20) NOT NULL DEFAULT '0',
  `fc` double NOT NULL DEFAULT '25',
  `vip_fc` double NOT NULL DEFAULT '40',
  `airport` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vs_agent_fast_checkin_fee`
--

INSERT INTO `vs_agent_fast_checkin_fee` (`id`, `agents_id`, `fc`, `vip_fc`, `airport`) VALUES
(10, 1, 1, 40, 1),
(11, 1, 1, 40, 2),
(12, 1, 1, 40, 3),
(13, 1, 1, 40, 4),
(14, 1, 1, 40, 5),
(15, 1, 1, 40, 6),
(16, 1, 1, 40, 7),
(17, 1, 1, 40, 8),
(18, 1, 25, 40, 9),
(19, 1, 25, 40, 10),
(20, 1, 25, 40, 11),
(21, 1, 1, 40, 12),
(22, 1, 25, 40, 13),
(23, 1, 25, 40, 14),
(24, 1, 25, 40, 15),
(25, 1, 25, 40, 16),
(26, 1, 1, 40, 17),
(27, 1, 25, 40, 18),
(28, 1, 25, 40, 19),
(29, 1, 25, 40, 20),
(30, 1, 25, 40, 21),
(31, 1, 25, 40, 22),
(32, 1, 25, 40, 23),
(33, 1, 25, 40, 24),
(34, 1, 25, 40, 25),
(35, 1, 25, 40, 26),
(36, 1, 25, 40, 27),
(37, 1, 25, 40, 28),
(38, 3, 25, 40, 1),
(39, 3, 25, 40, 2),
(40, 3, 25, 40, 3),
(41, 3, 1, 40, 4),
(42, 3, 1, 40, 5),
(43, 3, 25, 40, 6),
(44, 3, 25, 40, 7),
(45, 3, 25, 40, 8),
(46, 3, 25, 40, 9),
(47, 3, 25, 40, 10),
(48, 3, 25, 40, 11),
(49, 3, 25, 40, 12),
(50, 3, 25, 40, 13),
(51, 3, 25, 40, 14),
(52, 3, 25, 40, 15),
(53, 3, 25, 40, 16),
(54, 3, 25, 40, 17),
(55, 3, 25, 40, 18),
(56, 3, 25, 40, 19),
(57, 3, 25, 40, 20),
(58, 3, 25, 40, 21),
(59, 3, 25, 40, 22),
(60, 3, 25, 40, 23),
(61, 3, 25, 40, 24),
(62, 3, 1, 40, 25),
(63, 3, 1, 40, 26),
(64, 3, 25, 40, 27),
(65, 3, 25, 40, 28),
(66, 2, 25, 40, 1),
(67, 2, 25, 40, 2),
(68, 2, 25, 40, 3),
(69, 2, 1, 40, 4),
(70, 2, 1, 40, 5),
(71, 2, 25, 40, 6),
(72, 2, 25, 40, 7),
(73, 2, 25, 40, 8),
(74, 2, 25, 40, 9),
(75, 2, 25, 40, 10),
(76, 2, 25, 40, 11),
(77, 2, 25, 40, 12),
(78, 2, 25, 40, 13),
(79, 2, 25, 40, 14),
(80, 2, 25, 40, 15),
(81, 2, 25, 40, 16),
(82, 2, 25, 40, 17),
(83, 2, 25, 40, 18),
(84, 2, 25, 40, 19),
(85, 2, 25, 40, 20),
(86, 2, 25, 40, 21),
(87, 2, 25, 40, 22),
(88, 2, 25, 40, 23),
(89, 2, 25, 40, 24),
(90, 2, 25, 40, 25),
(91, 2, 25, 40, 26),
(92, 2, 25, 40, 27),
(93, 2, 25, 40, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_agent_fast_checkin_fee`
--
ALTER TABLE `vs_agent_fast_checkin_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_agent_fast_checkin_fee`
--
ALTER TABLE `vs_agent_fast_checkin_fee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
