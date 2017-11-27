-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2017 at 04:16 AM
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
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `fileID` int(10) NOT NULL,
  `auctionID` int(10) NOT NULL,
  `fileName` varchar(255) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `fileType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `file`
--

INSERT INTO `file` (`fileID`, `auctionID`, `fileName`, `filePath`, `fileType`) VALUES
(1, 14, 'Week 6 DIT PHP - validating data.ppt', 'CM0656-Assignment/uploads/Week 6 DIT PHP - validating data.ppt', 'article'),
(2, 11, 'Week 8 DIT PHP - basic logon system with encryption workshop.doc', 'CM0656-Assignment/uploads/Week 8 DIT PHP - basic logon system with encryption workshop.doc', 'article'),
(3, 12, 'Week 8 DIT PHP - basic logon system with encryption workshop.doc', 'CM0656-Assignment/uploads/Week 8 DIT PHP - basic logon system with encryption workshop.doc', 'article'),
(4, 13, 'Week 6 DIT PHP - validating data.ppt', 'CM0656-Assignment/uploads/Week 6 DIT PHP - validating data.ppt', 'article'),
(5, 13, 'Week 7 DIT PHP - sanitising data workshop.doc', 'CM0656-Assignment/uploads/Week 7 DIT PHP - sanitising data workshop.doc', 'article'),
(6, 13, 'Week 7 DIT PHP - sanitising data, including prepared statements.ppt', 'CM0656-Assignment/uploads/Week 7 DIT PHP - sanitising data, including prepared statements.ppt', 'article'),
(7, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(8, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article'),
(9, 1, 'yu0kYej.png', 'CM0656-Assignment/uploads/', 'coverPhoto'),
(10, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(11, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article'),
(12, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/', 'coverPhoto'),
(13, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(14, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article'),
(15, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(16, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article'),
(17, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/', 'coverPhoto'),
(18, 14, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(19, 13, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article'),
(20, 14, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'coverPhoto'),
(21, 14, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(22, 14, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article'),
(23, 15, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'coverPhoto'),
(24, 15, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'itemPhoto'),
(25, 15, 'yu0kYej.png', 'CM0656-Assignment/uploads/yu0kYej.png', 'article');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `fileID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
