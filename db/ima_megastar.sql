-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2017 at 01:53 PM
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
  `competitionDuration` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
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
  `templateID` int(10) NOT NULL,
  `testStartDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `testEndDate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `prize` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `securityAns` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `username`, `emailAddr`, `passwordHash`, `shippingAddr`, `dob`, `userType`, `userStatus`, `memberConfirmationExpiryDate`, `penaltyCount`, `securityQuestion`, `securityAns`) VALUES
(1, 'sjm', 'seahjm', 'seahjm96@gmail.com', '$2y$10$DiOCuMyjUgHGsByjsjPK0.0LxTszCTS/6777w8l6ghOCFBf7.VqyW', '14, Tanjung Rambutan, Penang', '1996-09-28', 'admin', 'active', NULL, 0, 'favouriteBook', 'StarWars'),
(2, 'sjm', 'sjm', 'sjm@gmail.com', '$2y$10$QhcmnXerCrhpj.jvc3urA.zC5ugD5khXDP6N6db6OFkRK91ndc4EO', 'test', '2017-11-01', 'junior', 'pending', '2017-11-02 02:20:41', 0, 'favouriteBook', '123'),
(3, 'sjm', NULL, 'seahjm96@gmail.com', '$2y$10$DiOCuMyjUgHGsByjsjPK0.0LxTszCTS/6777w8l6ghOCFBf7.VqyW', NULL, NULL, 'admin', 'active', NULL, 0, 'favouriteBook', 'StarWars');

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

-- --------------------------------------------------------

--
-- Table structure for table `user_blacklist`
--

CREATE TABLE `user_blacklist` (
  `userID` int(10) NOT NULL,
  `blacklistReason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  MODIFY `auctionID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bid`
--
ALTER TABLE `bid`
  MODIFY `bidID` int(10) NOT NULL AUTO_INCREMENT;
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
  MODIFY `testID` int(10) NOT NULL AUTO_INCREMENT;
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
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_banned`
--
ALTER TABLE `user_banned`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `user_blacklist`
--
ALTER TABLE `user_blacklist`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `watchListID` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
