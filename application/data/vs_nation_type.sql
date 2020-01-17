-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 23, 2019 at 12:01 PM
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
-- Table structure for table `vs_nation_type`
--

CREATE TABLE `vs_nation_type` (
  `id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NULL DEFAULT NULL,
  `updated_by` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vs_nation_type`
--

INSERT INTO `vs_nation_type` (`id`, `name`, `created_date`, `updated_date`, `updated_by`) VALUES
(1, 'Normal', '2019-08-23 08:52:20', '2019-08-23 08:52:20', 8060),
(2, 'Difficult', '2019-08-23 09:00:29', '2019-08-23 09:00:50', 8060),
(3, 'Difficult (documents)', '2019-08-23 09:00:30', '2019-08-23 09:00:30', 8060),
(4, 'Special', '2019-08-23 09:01:05', '2019-08-23 09:01:05', 8060);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_nation_type`
--
ALTER TABLE `vs_nation_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_nation_type`
--
ALTER TABLE `vs_nation_type`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
