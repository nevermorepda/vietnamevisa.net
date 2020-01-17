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
-- Table structure for table `vs_agent_private_letter_fee`
--

CREATE TABLE `vs_agent_private_letter_fee` (
  `id` int(10) UNSIGNED NOT NULL,
  `agents_id` bigint(20) NOT NULL DEFAULT '1',
  `tourist_1ms` double NOT NULL DEFAULT '10',
  `tourist_1mm` double NOT NULL DEFAULT '10',
  `tourist_3ms` double NOT NULL DEFAULT '10',
  `tourist_3mm` double NOT NULL DEFAULT '10',
  `tourist_6mm` double NOT NULL DEFAULT '10',
  `tourist_1ym` double NOT NULL DEFAULT '10',
  `business_1ms` double NOT NULL DEFAULT '10',
  `business_1mm` double NOT NULL DEFAULT '10',
  `business_3ms` double NOT NULL DEFAULT '10',
  `business_3mm` double NOT NULL DEFAULT '10',
  `business_6mm` double NOT NULL DEFAULT '10',
  `business_1ym` double NOT NULL DEFAULT '10'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vs_agent_private_letter_fee`
--

INSERT INTO `vs_agent_private_letter_fee` (`id`, `agents_id`, `tourist_1ms`, `tourist_1mm`, `tourist_3ms`, `tourist_3mm`, `tourist_6mm`, `tourist_1ym`, `business_1ms`, `business_1mm`, `business_3ms`, `business_3mm`, `business_6mm`, `business_1ym`) VALUES
(1, 1, 5, 5, 5, 5, 10, 10, 5, 5, 5, 5, 10, 10),
(2, 2, 5, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10, 10),
(3, 3, 10, 10, 5, 10, 10, 10, 10, 5, 10, 10, 10, 10);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_agent_private_letter_fee`
--
ALTER TABLE `vs_agent_private_letter_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_agent_private_letter_fee`
--
ALTER TABLE `vs_agent_private_letter_fee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
