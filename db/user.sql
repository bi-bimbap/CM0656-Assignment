-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 24, 2017 at 04:46 PM
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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(10) NOT NULL,
  `fullName` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `emailAddr` varchar(255) NOT NULL,
  `passwordHash` varchar(255) DEFAULT NULL,
  `shippingAddr` varchar(255) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `userType` varchar(30) NOT NULL,
  `userStatus` varchar(30) NOT NULL,
  `memberConfirmationExpiryDate` timestamp NULL DEFAULT NULL,
  `penaltyCount` int(10) NOT NULL,
  `securityQuestion` varchar(255) DEFAULT NULL,
  `securityAns` varchar(255) DEFAULT NULL,
  `registeredDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `username`, `emailAddr`, `passwordHash`, `shippingAddr`, `dob`, `userType`, `userStatus`, `memberConfirmationExpiryDate`, `penaltyCount`, `securityQuestion`, `securityAns`, `registeredDate`) VALUES
(1, 'Ho Hao Yuan', 'Bobo Yuan', 'seahjm96040207@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', '14, Tanjung Rambutan, Georgetown, Penang', '1996-09-28', 'senior', 'active', '2017-11-24 07:00:00', 0, 'favouriteBook', 'StarWars', '2017-06-06 00:00:00'),
(2, 'Lim Qiu Ni', NULL, 'sjm@gmail.com', '$2y$10$QhcmnXerCrhpj.jvc3urA.zC5ugD5khXDP6N6db6OFkRK91ndc4EO', NULL, NULL, 'admin', 'active', NULL, 0, 'favouriteBook', 'Harry Potter', '2017-09-18 00:00:00'),
(3, 'Seah Jia-Min', NULL, 'seahjm@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', NULL, NULL, 'mainAdmin', 'active', NULL, 0, 'favouriteBook', 'StarWars', '2017-10-09 00:00:00'),
(35, 'Zorina Abreu', 'Zorina', 'ZA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-11-18', 'junior', 'banned', '0000-00-00 00:00:00', 3, 'maidenName', 'Sim', '2017-05-12 00:00:00'),
(36, 'Tobias Blattman', 'Tobias', 'TB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-04-26', 'junior', 'banned', '0000-00-00 00:00:00', 4, 'birthPlace', 'Singapore', '2017-04-04 00:00:00'),
(37, 'Tanzeer Cao', 'Tanzeer', 'TC@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1933-02-17', 'senior', 'active', '0000-00-00 00:00:00', 3, 'favouriteBook', 'Networking', '2017-11-06 00:00:00'),
(38, 'Sachie Clark', 'Sachie', 'SC@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2003-05-19', 'junior', 'active', '0000-00-00 00:00:00', 0, 'birthPlace', 'Sarawak', '2017-10-02 00:00:00'),
(39, 'Radu Donahue', 'Radu', 'RD@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1923-03-16', 'senior', 'active', '0000-00-00 00:00:00', 0, 'school', 'Wawasan', '2017-09-04 00:00:00'),
(40, 'Philip Duncan', 'Philip', 'PD@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1911-10-14', 'senior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', 'Java', '2017-08-07 00:00:00'),
(41, 'Yoon Akin-Aderibigbe', 'Yoon', 'YA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1915-07-27', 'senior', 'active', '0000-00-00 00:00:00', 0, 'birthPlace', 'Kedah', '2017-10-12 00:00:00'),
(42, 'Pallavi Fox', 'Fox', 'PF@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1977-04-17', 'senior', 'banned', '0000-00-00 00:00:00', 5, 'maidenName', 'Tan', '2017-08-14 00:00:00'),
(43, 'Muge Graves', 'Muge', 'MG@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2012-12-25', 'junior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', 'C#', '2017-07-10 00:00:00'),
(44, 'Martinez Hofman', 'Hofman', 'MH@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-05-21', 'junior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', 'Lee', '2017-11-06 00:00:00'),
(45, 'Yat Lun Atri', 'Atri', 'YLA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2011-01-01', 'junior', 'active', '0000-00-00 00:00:00', 0, 'birthPlace', 'Penang', '2017-05-01 00:00:00'),
(46, 'Yi Feng Rlvarez', 'Rlvarez', 'YFR@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1974-07-08', 'senior', 'active', '0000-00-00 00:00:00', 0, 'school', 'Disted', '2017-04-18 00:00:00'),
(47, 'Yi Baramendia', 'Baramendia', 'YBA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2007-04-12', 'junior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', 'C++', '2017-08-14 00:00:00'),
(48, 'Yaya Sashkenazi', 'Sashkenazi', 'YS@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1967-02-12', 'senior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', 'Lim', '2017-09-04 00:00:00'),
(49, 'Yat Lun Batri', 'Batri', 'YLB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1963-08-08', 'senior', 'active', '0000-00-00 00:00:00', 0, 'school', 'Inti', '2017-10-30 00:00:00'),
(50, 'Yasu Hiro Au', 'Yasu Hiro', 'YHA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1955-06-27', 'senior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', 'Me Before You', '2017-09-04 00:00:00'),
(51, 'Yan Wen Aurori', 'Aurora', 'YWA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1953-06-24', 'senior', 'active', '0000-00-00 00:00:00', 0, 'school', 'KDU', '2017-10-12 00:00:00'),
(52, 'Yan Baustin Zen', 'Zen', 'YBZ@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1993-07-15', 'senior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', 'Tan', '2017-07-25 00:00:00'),
(53, 'Ya Han Bagdat', 'Han', 'YHB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1934-02-02', 'senior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', 'Percy Jackson', '2017-06-13 00:00:00'),
(54, 'Yael Bala', 'Bala', 'YB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1943-06-13', 'senior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', 'Yeap', '2017-07-17 00:00:00'),
(55, 'Choo Zhao Hooi', 'Choo Zhao Hooi', 'seahjm96@gmail.com', '$2y$10$3IgCcui9ZvSBvDCQG9ncTe4Ol1x0Xrd/fmQG6cF8L7yN2LQliuqum', 'Test Address', '1986-06-19', 'senior', 'active', '2017-11-23 22:27:52', 0, 'favouriteFood', 'Burgers', '2017-06-20 00:00:00'),
(56, 'Cheong Yi Qi', NULL, 'seahjm96@hotmail.com', NULL, NULL, NULL, 'admin', 'banned', '2017-11-12 00:44:57', 0, NULL, NULL, '2017-05-23 00:00:00'),
(58, 'HHY', NULL, 'hhy@test.com', NULL, NULL, NULL, 'admin', 'pending', '2017-11-12 02:54:17', 0, NULL, NULL, '2017-05-09 00:00:00'),
(59, '123', '123', '123@test.com', '$2y$10$7aw0yMHM.uhkajVyghcv/OCE0AKlP4zx1YeqRs8zsBlJLgS1Q8rwW', '123', '2007-11-05', 'junior', 'pending', '2017-11-24 00:02:20', 0, 'favouriteBook', '123', NULL),
(60, '12', '12', '12@test.com', '$2y$10$bVaLRuTqI3yhb71I96nAAu.DJ2K4LRWoDUm1HqzhYobCDso8iERuq', '123', '2007-11-05', 'junior', 'pending', '2017-11-24 00:04:00', 0, 'favouriteBook', '123', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
