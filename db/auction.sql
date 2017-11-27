-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 04:15 AM
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
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `auctionID` int(10) NOT NULL,
  `auctionTitle` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemDesc` varchar(255) NOT NULL,
  `startDate` datetime NOT NULL,
  `endDate` datetime NOT NULL,
  `startPrice` int(10) NOT NULL,
  `itemPrice` int(10) DEFAULT NULL,
  `currentBid` int(10) NOT NULL,
  `auctionStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`auctionID`, `auctionTitle`, `itemName`, `itemDesc`, `startDate`, `endDate`, `startPrice`, `itemPrice`, `currentBid`, `auctionStatus`) VALUES
(1, 'Test Auction', 'Item A', 'This is an item.', '2017-11-13 12:55:09', '2017-11-30 00:00:00', 50, 100, 0, 'ended'),
(2, 'Auction 2', 'Item B', 'This is an item.', '2017-11-13 12:55:12', '2017-11-26 00:00:00', 20, NULL, 100, 'active'),
(3, '123', '123', '123', '2017-11-25 22:50:37', '2017-12-22 22:30:38', 123, 0, 0, ''),
(4, 'Minimal Black Mug that designed by Ima!', 'Mug with Ima\'s Initial', 'Minimal Black Mug that designed by Ima!', '2017-11-28 23:10:18', '2017-11-27 14:05:18', 20, 0, 0, ''),
(6, 'abc', 'abc', 'abc', '2017-11-28 07:25:44', '2017-11-30 22:25:44', 1000, 0, 0, ''),
(7, 'Ima\'s pretty shoes!', 'shoes', 'Ima\'s pretty shoes!', '2017-11-27 01:00:14', '2017-12-30 08:45:47', 70, 0, 0, ''),
(8, 'I am so sleepy', 'Sleepy', 'I am so sleepy', '2017-11-30 08:25:24', '2017-12-08 15:25:24', 500, 0, 0, ''),
(9, 'Qiunitesting1', 'Qiunitesting1', 'Qiunitesting1', '2017-11-27 01:57:51', '2017-12-15 09:30:36', 12, 0, 0, ''),
(10, 'Qiunitesting1', 'Qiunitesting1', 'Qiunitesting1', '2017-11-27 01:57:51', '2017-12-15 09:30:36', 12, 0, 0, ''),
(11, 'testingqiuni123', 'testingqiuni123', 'testingqiuni123', '2017-11-27 02:00:01', '2017-11-30 16:50:48', 123, 0, 0, ''),
(12, 'testingqiuni123', 'testingqiuni123', 'testingqiuni123', '2017-11-27 02:00:01', '2017-11-30 16:50:48', 123, 0, 0, ''),
(13, '123412341234', '123412341234', '123412341234', '2017-11-27 02:02:44', '2017-12-17 09:30:26', 1234, 0, 0, ''),
(14, '123', '123', '123', '2017-11-27 03:22:30', '2017-11-29 09:30:21', 123, 0, 0, 'active'),
(15, 'Hi Ima', 'Hi Ima', 'Hi Ima', '2017-11-27 03:27:24', '2017-11-30 21:45:10', 123, 0, 0, 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`auctionID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `auctionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
