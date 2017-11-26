-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2017 at 04:58 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
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
-- Table structure for table `discussion_thread`
--

CREATE TABLE `discussion_thread` (
  `threadID` int(10) NOT NULL,
  `threadName` varchar(255) NOT NULL,
  `threadDescription` varchar(255) NOT NULL,
  `threadDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `discussion_thread`
--

INSERT INTO `discussion_thread` (`threadID`, `threadName`, `threadDescription`, `threadDateTime`, `userID`) VALUES
(1, 'Ima\'s 21st Birthday', 'Ima\'s Twenty-one Years Old Birthday Celebration', '2017-11-19 12:34:52', 2),
(2, 'Ima Falls Down Stair On New Year Eve!', 'Ima performs and nearly falls off stage on New Year\'s Eve', '2017-11-18 13:39:41', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussion_thread`
--
ALTER TABLE `discussion_thread`
  ADD PRIMARY KEY (`threadID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion_thread`
--
ALTER TABLE `discussion_thread`
  MODIFY `threadID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
