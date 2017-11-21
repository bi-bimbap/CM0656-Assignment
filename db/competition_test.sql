-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 21, 2017 at 09:03 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ima_megastar`
--

-- --------------------------------------------------------

--
-- Table structure for table `competition_test`
--

CREATE TABLE `competition_test` (
  `testID` int(10) NOT NULL,
  `testName` varchar(255) NOT NULL,
  `ageRange` int(10) NOT NULL,
  `templateID` int(10) NOT NULL,
  `testStartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `testEndDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prize` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `competition_test`
--

INSERT INTO `competition_test` (`testID`, `testName`, `ageRange`, `templateID`, `testStartDate`, `testEndDate`, `prize`) VALUES
(1, 'Test competition', 0, 1, '2017-10-31 16:00:00', '2017-11-10 16:00:00', 'Prize A'),
(2, 'Competition B', 0, 1, '2017-08-31 16:00:00', '2017-09-21 16:00:00', 'Prize B');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `competition_test`
--
ALTER TABLE `competition_test`
  ADD PRIMARY KEY (`testID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `competition_test`
--
ALTER TABLE `competition_test`
  MODIFY `testID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
