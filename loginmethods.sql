-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2024 at 02:44 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loginmethods`
--

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL,
  `room_name` varchar(100) NOT NULL,
  `room_price` decimal(10,2) NOT NULL,
  `room_type` varchar(50) NOT NULL,
  `room_capacity` int(11) NOT NULL,
  `room_details` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`room_id`, `room_name`, `room_price`, `room_type`, `room_capacity`, `room_details`) VALUES
(1, 'Single Room', 1000.00, 'Standard', 1, '1 bed room , 1 electricfan'),
(2, 'Double Room', 2000.00, 'Standard', 2, '2 bed room , aircoon');

-- --------------------------------------------------------

--
-- Table structure for table `tenant`
--

CREATE TABLE `tenant` (
  `tenantID` int(11) NOT NULL,
  `Username` varchar(255) DEFAULT NULL,
  `AccType` varchar(255) NOT NULL,
  `Pass_word` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `payment` varchar(255) NOT NULL,
  `sex` enum('male','female') NOT NULL,
  `user_profile_picture` varchar(255) NOT NULL,
  `account_type` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tenant`
--

INSERT INTO `tenant` (`tenantID`, `Username`, `AccType`, `Pass_word`, `firstname`, `lastname`, `payment`, `sex`, `user_profile_picture`, `account_type`) VALUES
(1, 'mamamo', 'Admin', '$2y$10$ad./bhIXqp3pJdti7LOhg.kM0fQ3zrvFWgpSatudCsV9wD5Ci0cy6', 'pogi01', 'mamamo', '', 'male', '', 1),
(2, 'kiano', 'Tenant', '$2y$10$huw3fmOe6EGa3dbcu2..gOKbLM7Ce6M2ZqULHPKIgvG1GBEWL3rsS', 'kian', 'recto', '', 'male', '', 0),
(3, 'pogiako', 'Admin', '$2y$10$eB0rwV14B9bXhjsdViteq.nHq3V2hF3WbHcfMg.4E7N3BbRSSzKqa', 'kayel', 'pogi', '', 'female', '', 0),
(4, '', '', '$2y$10$0L6Y1a1nUy/4YDOKmdSNyuTRgpVX.BDX4dyWYLzwmOio7X3yDk1D.', 'khyle', 'libao', '', 'male', 'uploads/baboy na tulog_1719198962.jpg', 0),
(5, '', '', '$2y$10$yz6XykcJQGHf5y9r6okSbO8pyhG8BRl3Sord1bgqwVs2ZG2FDKXE.', 'khyle', 'libao', '', 'male', 'uploads/baboy na tulog_1719199090.jpg', 0),
(6, '', '', '$2y$10$wGIkzjSpvnWB3sIM4uTn..JTjfifyvBGgfCIcCslS7aa3xeNOSGjm', 'Tenant1', 'pogiako', '', 'male', 'uploads/car_1719199125.jpg', 0),
(7, 'maemae', 'Tenant', '$2y$10$vOIoSp1FVVj..HVrCIqL6..Zfg.S7nS7b0jRFLriKQiOxRxnGkAe6', 'maemae', 'pureza', '', 'female', '', 1),
(8, 'hannahkit', 'Admin', '$2y$10$honoYkZxbDDnTC5SOAdRk.aMcAbsJnW8V85Ah5dA17QoBYIqR1eL6', 'hannah', 'alcataz', '', 'female', '', 0),
(9, 'kayel01', 'Admin', '$2y$10$fvK.EH9B4rhlLyuUBX45fuwzL7OsIrhXgDHBR7H/2UXWCtKF4foz.', 'kayel', 'haha', '', 'female', '', 0),
(10, 'nilsmikel', 'Admin', '$2y$10$gyEEbMEXkSsYrcuLT.q.Ju.cDdssnCUXS6Q7tXz3EtVEQhfLj0Q82', 'nils', 'martija', '', 'female', '', 0),
(14, 'kayel01', '', '$2y$10$v41orW/BDVjiH3YhW5Adwe3sIF3FN.nSqhtdH1mZ992VMCMUq2hDG', 'first', 'last', 'Installment', 'male', 'uploads/sdas.jpg', 1),
(15, 'admin', '', '$2y$10$5DOIKL12aleeV3A3hHY.PuMk1aX9FxFJqd9TRBtAwQKjVxjBu6FTa', 'first', 'last', 'Installment', 'male', 'uploads/hdfg.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tenant_info`
--

CREATE TABLE `tenant_info` (
  `tenant_add_id` int(11) NOT NULL,
  `tenantID` int(11) NOT NULL,
  `tenant_add_floor` varchar(255) DEFAULT NULL,
  `tenant_add_unitNo` varchar(255) DEFAULT NULL,
  `tenant_add_numBed` int(11) DEFAULT NULL,
  `tenant_Amount` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tenant_info`
--

INSERT INTO `tenant_info` (`tenant_add_id`, `tenantID`, `tenant_add_floor`, `tenant_add_unitNo`, `tenant_add_numBed`, `tenant_Amount`) VALUES
(4, 14, '2', '12', 4, 3000.00),
(5, 15, '2', '12', 4, 3000.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `tenant`
--
ALTER TABLE `tenant`
  ADD PRIMARY KEY (`tenantID`);

--
-- Indexes for table `tenant_info`
--
ALTER TABLE `tenant_info`
  ADD PRIMARY KEY (`tenant_add_id`),
  ADD UNIQUE KEY `tenantID` (`tenantID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tenant`
--
ALTER TABLE `tenant`
  MODIFY `tenantID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tenant_info`
--
ALTER TABLE `tenant_info`
  MODIFY `tenant_add_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tenant_info`
--
ALTER TABLE `tenant_info`
  ADD CONSTRAINT `tenant_info_ibfk_1` FOREIGN KEY (`tenantID`) REFERENCES `tenant` (`tenantID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
