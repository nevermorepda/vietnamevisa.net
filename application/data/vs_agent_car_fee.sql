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
-- Table structure for table `vs_agent_car_fee`
--

CREATE TABLE `vs_agent_car_fee` (
  `id` int(10) UNSIGNED NOT NULL,
  `agents_id` bigint(20) NOT NULL DEFAULT '0',
  `seat_4` double NOT NULL DEFAULT '25',
  `seat_7` double NOT NULL DEFAULT '30',
  `seat_16` double NOT NULL DEFAULT '90',
  `seat_24` double NOT NULL DEFAULT '150',
  `airport` bigint(20) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vs_agent_car_fee`
--

INSERT INTO `vs_agent_car_fee` (`id`, `agents_id`, `seat_4`, `seat_7`, `seat_16`, `seat_24`, `airport`) VALUES
(1, 1, 25, 30, 90, 150, 2),
(2, 1, 25, 30, 90, 150, 1),
(3, 1, 35, 40, 100, 160, 3),
(4, 1, 25, 30, 90, 150, 5),
(5, 1, 25, 30, 90, 150, 6),
(6, 1, 25, 30, 90, 150, 7),
(7, 1, 25, 30, 90, 150, 8),
(8, 1, 0, 0, 0, 0, 9),
(9, 1, 0, 0, 0, 0, 10),
(10, 1, 0, 0, 0, 0, 11),
(11, 1, 0, 0, 0, 0, 12),
(12, 1, 0, 0, 0, 0, 13),
(13, 1, 0, 0, 0, 0, 14),
(14, 1, 0, 0, 0, 0, 15),
(15, 1, 0, 0, 0, 0, 16),
(16, 1, 0, 0, 0, 0, 17),
(17, 1, 0, 0, 0, 0, 18),
(18, 1, 0, 0, 0, 0, 19),
(19, 1, 0, 0, 0, 0, 20),
(20, 1, 0, 0, 0, 0, 21),
(21, 1, 0, 0, 0, 0, 22),
(22, 1, 0, 0, 0, 0, 23),
(23, 1, 0, 0, 0, 0, 24),
(24, 1, 0, 0, 0, 0, 25),
(25, 1, 0, 0, 0, 0, 26),
(26, 1, 0, 0, 0, 0, 27),
(27, 1, 0, 0, 0, 0, 28),
(28, 1, 35, 40, 100, 160, 4),
(29, 2, 25, 30, 90, 150, 1),
(30, 2, 25, 30, 90, 150, 2),
(31, 2, 25, 30, 90, 150, 3),
(32, 2, 25, 30, 90, 150, 4),
(33, 2, 25, 30, 90, 150, 5),
(34, 2, 25, 30, 90, 150, 6),
(35, 2, 25, 30, 90, 150, 7),
(36, 2, 25, 30, 90, 150, 8),
(37, 2, 25, 30, 90, 150, 9),
(38, 2, 25, 30, 90, 150, 10),
(39, 2, 25, 30, 90, 150, 11),
(40, 2, 25, 30, 90, 150, 12),
(41, 2, 25, 30, 90, 150, 13),
(42, 2, 25, 30, 90, 150, 14),
(43, 2, 25, 30, 90, 150, 15),
(44, 2, 25, 30, 90, 150, 16),
(45, 2, 25, 30, 90, 150, 17),
(46, 2, 25, 30, 90, 150, 18),
(47, 2, 25, 30, 90, 150, 19),
(48, 2, 25, 30, 90, 150, 20),
(49, 2, 25, 30, 90, 150, 21),
(50, 2, 25, 30, 90, 150, 22),
(51, 2, 25, 30, 90, 150, 23),
(52, 2, 25, 30, 90, 150, 24),
(53, 2, 25, 30, 90, 150, 25),
(54, 2, 25, 30, 90, 150, 26),
(55, 2, 25, 30, 90, 150, 27),
(56, 2, 25, 30, 90, 150, 28),
(57, 3, 999, 30, 90, 150, 1),
(58, 3, 25, 30, 90, 1, 2),
(59, 3, 25, 30, 90, 1, 3),
(60, 3, 25, 30, 90, 1, 4),
(61, 3, 25, 30, 90, 1, 5),
(62, 3, 25, 30, 90, 1, 6),
(63, 3, 25, 30, 90, 1, 7),
(64, 3, 25, 30, 90, 1, 8),
(65, 3, 122, 30, 90, 150, 9),
(66, 3, 25, 30, 90, 150, 10),
(67, 3, 25, 30, 90, 150, 11),
(68, 3, 25, 30, 90, 150, 12),
(69, 3, 25, 30, 90, 150, 13),
(70, 3, 25, 30, 90, 150, 14),
(71, 3, 25, 30, 90, 150, 15),
(72, 3, 25, 30, 90, 150, 16),
(73, 3, 25, 30, 90, 150, 17),
(74, 3, 25, 30, 90, 150, 18),
(75, 3, 25, 30, 90, 150, 19),
(76, 3, 25, 30, 90, 150, 20),
(77, 3, 25, 30, 90, 150, 21),
(78, 3, 25, 30, 90, 150, 22),
(79, 3, 25, 30, 90, 150, 23),
(80, 3, 25, 30, 90, 150, 24),
(81, 3, 25, 30, 90, 150, 25),
(82, 3, 25, 30, 90, 150, 26),
(83, 3, 25, 30, 90, 150, 27),
(84, 3, 25, 30, 90, 150, 28);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_agent_car_fee`
--
ALTER TABLE `vs_agent_car_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_agent_car_fee`
--
ALTER TABLE `vs_agent_car_fee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
