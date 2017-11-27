-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 01:31 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 7.0.15

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
-- Table structure for table `bid`
--

CREATE TABLE `bid` (
  `bidID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `auctionID` int(10) NOT NULL,
  `bidAmount` int(10) NOT NULL,
  `bidStatus` varchar(30) NOT NULL,
  `bidTime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`bidID`, `userID`, `auctionID`, `bidAmount`, `bidStatus`, `bidTime`) VALUES
(1, 1, 1, 55, 'active', '2017-11-12 00:00:00'),
(2, 42, 1, 60, 'active', '2017-11-12 23:01:22'),
(3, 46, 1, 100, 'withdrawn', '2017-11-12 23:01:47'),
(4, 1, 1, 120, 'active', '2017-11-25 23:45:54'),
(5, 3, 2, 10, 'active', '0000-00-00 00:00:00'),
(6, 1, 2, 123, 'active', '2017-11-27 00:00:00'),
(7, 3, 2, 125, 'active', '2017-11-27 00:00:00'),
(8, 1, 1, 100, 'buyItNow', '2017-11-27 01:24:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`bidID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `bidID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
