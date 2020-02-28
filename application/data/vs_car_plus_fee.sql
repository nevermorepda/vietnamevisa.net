-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 27, 2020 at 04:05 AM
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
-- Database: `vietnamevisanet`
--

-- --------------------------------------------------------

--
-- Table structure for table `vs_car_plus_fee`
--

CREATE TABLE `vs_car_plus_fee` (
  `id` int(20) NOT NULL,
  `port` bigint(20) NOT NULL DEFAULT '0',
  `distance` double NOT NULL DEFAULT '0',
  `distance_plus` double NOT NULL DEFAULT '0',
  `seat_4` double NOT NULL DEFAULT '0',
  `seat_7` double NOT NULL DEFAULT '0',
  `seat_16` double NOT NULL DEFAULT '0',
  `seat_24` double NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vs_car_plus_fee`
--

INSERT INTO `vs_car_plus_fee` (`id`, `port`, `distance`, `distance_plus`, `seat_4`, `seat_7`, `seat_16`, `seat_24`) VALUES
(1, 1, 5, 1, 2, 3, 4, 5),
(2, 2, 5, 1, 1, 2, 3, 4),
(3, 3, 5, 1, 1, 1, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_car_plus_fee`
--
ALTER TABLE `vs_car_plus_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_car_plus_fee`
--
ALTER TABLE `vs_car_plus_fee`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
