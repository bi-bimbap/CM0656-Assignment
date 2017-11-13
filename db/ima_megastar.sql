-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2017 at 11:42 AM
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
-- Table structure for table `album`
--

CREATE TABLE `album` (
  `albumID` int(10) NOT NULL,
  `albumCoverPath` varchar(255) NOT NULL,
  `albumStatus` varchar(30) NOT NULL,
  `albumCreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `albumDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `article`
--

CREATE TABLE `article` (
  `articleID` int(10) NOT NULL,
  `auctionID` int(10) NOT NULL,
  `articleName` varchar(255) NOT NULL,
  `articlePath` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `auction`
--

CREATE TABLE `auction` (
  `auctionID` int(10) NOT NULL,
  `auctionTitle` varchar(255) NOT NULL,
  `itemName` varchar(255) NOT NULL,
  `itemDesc` varchar(255) NOT NULL,
  `startDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `endDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `startPrice` int(10) NOT NULL,
  `itemPrice` int(10) DEFAULT NULL,
  `currentBid` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `auction`
--

INSERT INTO `auction` (`auctionID`, `auctionTitle`, `itemName`, `itemDesc`, `startDate`, `endDate`, `startPrice`, `itemPrice`, `currentBid`) VALUES
(1, 'Test Auction', 'Item A', 'This is an item.', '2017-11-13 04:55:09', '2017-11-09 16:00:00', 50, NULL, 0),
(2, 'Auction 2', 'Item B', 'This is an item.', '2017-11-13 04:55:12', '2017-11-08 16:00:00', 20, NULL, 0);

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
  `bidTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bid`
--

INSERT INTO `bid` (`bidID`, `userID`, `auctionID`, `bidAmount`, `bidStatus`, `bidTime`) VALUES
(1, 1, 1, 55, 'active', '2017-11-11 16:00:00'),
(2, 42, 1, 60, 'active', '2017-11-12 15:01:22'),
(3, 46, 1, 100, 'withdrawn', '2017-11-12 15:01:47');

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `commentID` int(10) NOT NULL,
  `photoID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commentStatus` varchar(30) NOT NULL,
  `commentDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competition_question`
--

CREATE TABLE `competition_question` (
  `questionID` int(10) NOT NULL,
  `templateID` int(10) NOT NULL,
  `questionTitle` varchar(255) NOT NULL,
  `questionAns` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competition_result`
--

CREATE TABLE `competition_result` (
  `resultID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `testID` int(10) NOT NULL,
  `result` int(10) NOT NULL,
  `competitionDuration` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competition_template`
--

CREATE TABLE `competition_template` (
  `templateID` int(10) NOT NULL,
  `templateTitle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `competition_test`
--

CREATE TABLE `competition_test` (
  `testID` int(10) NOT NULL,
  `testName` varchar(255) NOT NULL,
  `templateID` int(10) NOT NULL,
  `testStartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `testEndDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prize` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `competition_test`
--

INSERT INTO `competition_test` (`testID`, `testName`, `templateID`, `testStartDate`, `testEndDate`, `prize`) VALUES
(1, 'Test competition', 1, '2017-10-31 16:00:00', '2017-11-10 16:00:00', 'Prize A'),
(2, 'Competition B', 1, '2017-08-31 16:00:00', '2017-09-21 16:00:00', 'Prize B');

-- --------------------------------------------------------

--
-- Table structure for table `discussion_inappropriate`
--

CREATE TABLE `discussion_inappropriate` (
  `inappropriatePhraseID` int(10) NOT NULL,
  `inappropriatePhrase` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_message`
--

CREATE TABLE `discussion_message` (
  `messageID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `threadID` int(10) NOT NULL,
  `messageContent` varchar(255) NOT NULL,
  `messageDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `messageStatus` varchar(30) NOT NULL,
  `replyTo` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `discussion_thread`
--

CREATE TABLE `discussion_thread` (
  `threadID` int(10) NOT NULL,
  `threadName` varchar(255) NOT NULL,
  `threadDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `photo`
--

CREATE TABLE `photo` (
  `photoID` int(10) NOT NULL,
  `albumID` int(10) NOT NULL,
  `photoStatus` varchar(30) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `photoPath` varchar(255) NOT NULL,
  `photoDescription` varchar(255) NOT NULL,
  `userID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportID` int(10) NOT NULL,
  `contentID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `reportReason` varchar(255) NOT NULL,
  `reportDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reportFrom` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
(1, 'Seah Min Min', 'seahjm', 'seahjm96040207@gmail.com', '$2y$10$L79dSkQkm7PqcTS3TllQwuORdYYgbt0fe52A4QPxxZzY08DATjKFC', '14, Tanjung Rambutan, Georgetown, Penang', '1996-09-28', 'senior', 'active', '2017-11-05 09:35:10', 0, 'favouriteBook', 'StarWars', '2017-06-06 00:00:00'),
(2, 'sjm', 'sjm', 'sjm@gmail.com', '$2y$10$QhcmnXerCrhpj.jvc3urA.zC5ugD5khXDP6N6db6OFkRK91ndc4EO', NULL, NULL, 'admin', 'active', NULL, 0, 'favouriteBook', '123', '2017-09-18 00:00:00'),
(3, 'Seah Jia-Min', NULL, 'seahjm@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', NULL, NULL, 'mainAdmin', 'active', NULL, 0, 'favouriteBook', 'StarWars', '2017-10-09 00:00:00'),
(35, 'Zorina Abreu', 'ZA', 'ZA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-11-18', 'junior', 'banned', '0000-00-00 00:00:00', 3, 'maidenName', '123', '2017-05-12 00:00:00'),
(36, 'Tobias Blattman', 'TB', 'TB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-04-26', 'junior', 'banned', '0000-00-00 00:00:00', 4, 'birthPlace', '123', '2017-04-04 00:00:00'),
(37, 'Tanzeer Cao', 'TC', 'TC@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2002-02-17', 'junior', 'banned', '0000-00-00 00:00:00', 3, 'favouriteBook', '123', '2017-11-06 00:00:00'),
(38, 'Sachie Clark', 'SC', 'SC@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2003-05-19', 'junior', 'active', '0000-00-00 00:00:00', 0, 'birthPlace', '123', '2017-10-02 00:00:00'),
(39, 'Radu Donahue', 'RD', 'RD@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2013-03-16', 'junior', 'active', '0000-00-00 00:00:00', 0, 'school', '123', '2017-09-04 00:00:00'),
(40, 'Philip Duncan', 'PD', 'PD@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2014-10-14', 'junior', 'banned', '0000-00-00 00:00:00', 0, 'favouriteBook', '123', '2017-08-07 00:00:00'),
(41, 'Yoon Akin-Aderibigbe', 'YA', 'YA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2005-07-27', 'junior', 'active', '0000-00-00 00:00:00', 0, 'birthPlace', '123', '2017-10-12 00:00:00'),
(42, 'Pallavi Fox', 'PF', 'PF@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1992-04-17', 'senior', 'active', '0000-00-00 00:00:00', 5, 'maidenName', '123', '2017-08-14 00:00:00'),
(43, 'Muge Graves', 'MG', 'MG@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2012-12-25', 'junior', 'banned', '0000-00-00 00:00:00', 0, 'favouriteBook', '123', '2017-07-10 00:00:00'),
(44, 'Martinez Hofman', 'MH', 'MH@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-05-21', 'junior', 'banned', '0000-00-00 00:00:00', 0, 'maidenName', '123', '2017-11-06 00:00:00'),
(45, 'Yat Lun Atri', 'YLA', 'YLA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2011-01-01', 'junior', 'active', '0000-00-00 00:00:00', 0, 'birthPlace', '123', '2017-05-01 00:00:00'),
(46, 'Yi Feng Rlvarez', 'YFR', 'YFR@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1992-07-08', 'senior', 'banned', '0000-00-00 00:00:00', 0, 'school', '123', '2017-04-18 00:00:00'),
(47, 'Yi Baramendia', 'YB', 'YB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2007-04-12', 'junior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', '123', '2017-08-14 00:00:00'),
(48, 'Yaya Sashkenazi', 'YS', 'YS@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2004-02-12', 'junior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', '123', '2017-09-04 00:00:00'),
(49, 'Yat Lun Batri', 'YLB', 'YLB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2011-08-08', 'junior', 'active', '0000-00-00 00:00:00', 0, 'school', '123', '2017-10-30 00:00:00'),
(50, 'Yasu Hiro Au', 'YHA', 'YHA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1998-06-27', 'senior', 'banned', '0000-00-00 00:00:00', 0, 'favouriteBook', '123', '2017-09-04 00:00:00'),
(51, 'Yan Wen Aurori', 'YWA', 'YWA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1991-06-24', 'senior', 'active', '0000-00-00 00:00:00', 0, 'school', '123', '2017-10-12 00:00:00'),
(52, 'Yan Baustin Zen', 'YBZ', 'YBZ@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1993-07-15', 'senior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', '123', '2017-07-25 00:00:00'),
(53, 'Ya Han Bagdat', 'YHB', 'YHB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2004-02-02', 'junior', 'active', '0000-00-00 00:00:00', 0, 'favouriteBook', '123', '2017-06-13 00:00:00'),
(54, 'Yael Bala', 'YB', 'YB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-06-13', 'junior', 'active', '0000-00-00 00:00:00', 0, 'maidenName', '123', '2017-07-17 00:00:00'),
(55, 'Seah Jia-Wei', NULL, 'seahjm96@gmail.com', NULL, NULL, NULL, 'admin', 'pending', '2017-11-11 23:02:04', 0, NULL, NULL, '2017-06-20 00:00:00'),
(56, 'Cheong Yi Qi', NULL, 'seahjm96@hotmail.com', NULL, NULL, NULL, 'admin', 'banned', '2017-11-12 00:44:57', 0, NULL, NULL, '2017-05-23 00:00:00'),
(58, 'HHY', NULL, 'hhy@test.com', NULL, NULL, NULL, 'admin', 'pending', '2017-11-12 02:54:17', 0, NULL, NULL, '2017-05-09 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `user_banned`
--

CREATE TABLE `user_banned` (
  `userID` int(10) NOT NULL,
  `banReason` varchar(255) NOT NULL,
  `banDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `banBy` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_banned`
--

INSERT INTO `user_banned` (`userID`, `banReason`, `banDate`, `banBy`) VALUES
(35, 'Test', '2017-11-10 04:17:14', '3'),
(37, 'TC', '2017-11-10 04:21:14', '3'),
(50, 'Test ban', '2017-11-10 04:08:13', '3');

-- --------------------------------------------------------

--
-- Table structure for table `user_blacklist`
--

CREATE TABLE `user_blacklist` (
  `userID` int(10) NOT NULL,
  `blacklistReason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_blacklist`
--

INSERT INTO `user_blacklist` (`userID`, `blacklistReason`) VALUES
(42, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `watchlist`
--

CREATE TABLE `watchlist` (
  `watchListID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `auctionID` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`albumID`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`articleID`);

--
-- Indexes for table `auction`
--
ALTER TABLE `auction`
  ADD PRIMARY KEY (`auctionID`);

--
-- Indexes for table `bid`
--
ALTER TABLE `bid`
  ADD PRIMARY KEY (`bidID`);

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `competition_question`
--
ALTER TABLE `competition_question`
  ADD PRIMARY KEY (`questionID`);

--
-- Indexes for table `competition_result`
--
ALTER TABLE `competition_result`
  ADD PRIMARY KEY (`resultID`);

--
-- Indexes for table `competition_template`
--
ALTER TABLE `competition_template`
  ADD PRIMARY KEY (`templateID`);

--
-- Indexes for table `competition_test`
--
ALTER TABLE `competition_test`
  ADD PRIMARY KEY (`testID`);

--
-- Indexes for table `discussion_inappropriate`
--
ALTER TABLE `discussion_inappropriate`
  ADD PRIMARY KEY (`inappropriatePhraseID`);

--
-- Indexes for table `discussion_message`
--
ALTER TABLE `discussion_message`
  ADD PRIMARY KEY (`messageID`);

--
-- Indexes for table `discussion_thread`
--
ALTER TABLE `discussion_thread`
  ADD PRIMARY KEY (`threadID`);

--
-- Indexes for table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`photoID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`reportID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_banned`
--
ALTER TABLE `user_banned`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `user_blacklist`
--
ALTER TABLE `user_blacklist`
  ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `watchlist`
--
ALTER TABLE `watchlist`
  ADD PRIMARY KEY (`watchListID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `album`
--
ALTER TABLE `album`
  MODIFY `albumID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `articleID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `auction`
--
ALTER TABLE `auction`
  MODIFY `auctionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `bidID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `commentID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competition_question`
--
ALTER TABLE `competition_question`
  MODIFY `questionID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competition_result`
--
ALTER TABLE `competition_result`
  MODIFY `resultID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competition_template`
--
ALTER TABLE `competition_template`
  MODIFY `templateID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `competition_test`
--
ALTER TABLE `competition_test`
  MODIFY `testID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `discussion_inappropriate`
--
ALTER TABLE `discussion_inappropriate`
  MODIFY `inappropriatePhraseID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `discussion_message`
--
ALTER TABLE `discussion_message`
  MODIFY `messageID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `discussion_thread`
--
ALTER TABLE `discussion_thread`
  MODIFY `threadID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `photo`
--
ALTER TABLE `photo`
  MODIFY `photoID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;
--
-- AUTO_INCREMENT for table `user_banned`
--
ALTER TABLE `user_banned`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
--
-- AUTO_INCREMENT for table `user_blacklist`
--
ALTER TABLE `user_blacklist`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;
--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `watchListID` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
