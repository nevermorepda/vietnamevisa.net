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
-- Table structure for table `vs_agent_processing_fee`
--

CREATE TABLE `vs_agent_processing_fee` (
  `id` int(10) UNSIGNED NOT NULL,
  `agents_id` bigint(20) NOT NULL DEFAULT '0',
  `nation_type_id` bigint(20) NOT NULL DEFAULT '0',
  `tourist_1ms_urgent` double NOT NULL DEFAULT '19',
  `tourist_1ms_emergency` double NOT NULL DEFAULT '49',
  `tourist_1ms_holiday` double NOT NULL DEFAULT '260',
  `tourist_1mm_urgent` double NOT NULL DEFAULT '19',
  `tourist_1mm_emergency` double NOT NULL DEFAULT '49',
  `tourist_1mm_holiday` double NOT NULL DEFAULT '260',
  `tourist_3ms_urgent` double NOT NULL DEFAULT '19',
  `tourist_3ms_emergency` double NOT NULL DEFAULT '49',
  `tourist_3ms_holiday` double NOT NULL DEFAULT '260',
  `tourist_3mm_urgent` double NOT NULL DEFAULT '19',
  `tourist_3mm_emergency` double NOT NULL DEFAULT '49',
  `tourist_3mm_holiday` double NOT NULL DEFAULT '260',
  `tourist_6mm_urgent` double NOT NULL DEFAULT '19',
  `tourist_6mm_emergency` double NOT NULL DEFAULT '49',
  `tourist_6mm_holiday` double NOT NULL DEFAULT '260',
  `tourist_1ym_urgent` double NOT NULL DEFAULT '19',
  `tourist_1ym_emergency` double NOT NULL DEFAULT '49',
  `tourist_1ym_holiday` double NOT NULL DEFAULT '260',
  `business_1ms_urgent` double NOT NULL DEFAULT '39',
  `business_1ms_emergency` double NOT NULL DEFAULT '49',
  `business_1ms_holiday` double NOT NULL DEFAULT '260',
  `business_1mm_urgent` double NOT NULL DEFAULT '39',
  `business_1mm_emergency` double NOT NULL DEFAULT '49',
  `business_1mm_holiday` double NOT NULL DEFAULT '260',
  `business_3ms_urgent` double NOT NULL DEFAULT '39',
  `business_3ms_emergency` double NOT NULL DEFAULT '49',
  `business_3ms_holiday` double NOT NULL DEFAULT '260',
  `business_3mm_urgent` double NOT NULL DEFAULT '39',
  `business_3mm_emergency` double NOT NULL DEFAULT '49',
  `business_3mm_holiday` double NOT NULL DEFAULT '260',
  `business_6mm_urgent` double NOT NULL DEFAULT '39',
  `business_6mm_emergency` double NOT NULL DEFAULT '49',
  `business_6mm_holiday` double NOT NULL DEFAULT '260',
  `business_1ym_urgent` double NOT NULL DEFAULT '39',
  `business_1ym_emergency` double NOT NULL DEFAULT '49',
  `business_1ym_holiday` double NOT NULL DEFAULT '260',
  `evisa_tourist_1ms_urgent` double NOT NULL DEFAULT '19',
  `evisa_tourist_1ms_emergency` double NOT NULL DEFAULT '49',
  `evisa_tourist_1ms_holiday` double NOT NULL DEFAULT '149',
  `evisa_business_1ms_urgent` double NOT NULL DEFAULT '19',
  `evisa_business_1ms_emergency` double NOT NULL DEFAULT '49',
  `evisa_business_1ms_holiday` double NOT NULL DEFAULT '149'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vs_agent_processing_fee`
--

INSERT INTO `vs_agent_processing_fee` (`id`, `agents_id`, `nation_type_id`, `tourist_1ms_urgent`, `tourist_1ms_emergency`, `tourist_1ms_holiday`, `tourist_1mm_urgent`, `tourist_1mm_emergency`, `tourist_1mm_holiday`, `tourist_3ms_urgent`, `tourist_3ms_emergency`, `tourist_3ms_holiday`, `tourist_3mm_urgent`, `tourist_3mm_emergency`, `tourist_3mm_holiday`, `tourist_6mm_urgent`, `tourist_6mm_emergency`, `tourist_6mm_holiday`, `tourist_1ym_urgent`, `tourist_1ym_emergency`, `tourist_1ym_holiday`, `business_1ms_urgent`, `business_1ms_emergency`, `business_1ms_holiday`, `business_1mm_urgent`, `business_1mm_emergency`, `business_1mm_holiday`, `business_3ms_urgent`, `business_3ms_emergency`, `business_3ms_holiday`, `business_3mm_urgent`, `business_3mm_emergency`, `business_3mm_holiday`, `business_6mm_urgent`, `business_6mm_emergency`, `business_6mm_holiday`, `business_1ym_urgent`, `business_1ym_emergency`, `business_1ym_holiday`, `evisa_tourist_1ms_urgent`, `evisa_tourist_1ms_emergency`, `evisa_tourist_1ms_holiday`, `evisa_business_1ms_urgent`, `evisa_business_1ms_emergency`, `evisa_business_1ms_holiday`) VALUES
(1, 1, 1, 19, 40, 160, 12, 49, 160, 45, 65, 160, 45, 65, 180, 35, 55, 280, 35, 55, 320, 69, 89, 220, 69, 89, 225, 69, 89, 200, 69, 89, 225, 69, 89, 290, 69, 89, 320, 19, 49, 149, 19, 49, 149),
(2, 3, 2, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(3, 1, 2, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 1, 19, 1, 260, 1, 49, 260, 39, 49, 1, 39, 1, 260, 1, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(4, 1, 3, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(5, 1, 4, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(6, 2, 1, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(7, 2, 2, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(8, 2, 3, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(9, 2, 4, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(10, 3, 1, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(11, 3, 3, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149),
(12, 3, 4, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 19, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 39, 49, 260, 19, 49, 149, 19, 49, 149);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vs_agent_processing_fee`
--
ALTER TABLE `vs_agent_processing_fee`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vs_agent_processing_fee`
--
ALTER TABLE `vs_agent_processing_fee`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
