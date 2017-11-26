-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2017 at 07:39 PM
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
-- Table structure for table `album_comment`
--

CREATE TABLE `album_comment` (
  `commentID` int(10) NOT NULL,
  `photoID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `uploadDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `commentStatus` varchar(30) NOT NULL,
  `commentDescription` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `album_photo`
--

CREATE TABLE `album_photo` (
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
(1, 'Get This Item!', 'Item A', 'This is an item.', '2017-11-26 18:33:12', '2017-11-09 16:00:00', 20, NULL, 0),
(2, 'Ima\'s Guitar Up for Auction!', 'Item B', 'This is an item.', '2017-11-26 18:33:42', '2017-11-08 16:00:00', 20, NULL, 0);

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
(1, 39, 1, 55, 'active', '2017-11-12 00:00:00'),
(2, 40, 1, 60, 'active', '2017-11-12 23:01:22'),
(3, 41, 1, 100, 'withdrawn', '2017-11-12 23:01:47'),
(4, 46, 1, 30, 'active', '2017-11-06 00:00:00'),
(5, 48, 1, 30, 'active', '2017-11-06 00:00:00'),
(6, 49, 2, 30, 'active', '2017-11-06 00:00:00'),
(7, 50, 2, 30, 'withdrawn', '2017-11-06 00:00:00'),
(8, 53, 2, 30, 'active', '2017-11-06 00:00:00'),
(9, 54, 2, 40, 'active', '2017-11-06 00:00:00'),
(10, 55, 2, 40, 'withdrawn', '2017-11-06 00:00:00');

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

--
-- Dumping data for table `competition_question`
--

INSERT INTO `competition_question` (`questionID`, `templateID`, `questionTitle`, `questionAns`) VALUES
(1, 1, 'question 1', 'answer 1'),
(2, 1, 'question 2', 'answer 2'),
(3, 1, 'question 3', 'answer 3'),
(4, 1, 'question 4', 'answer 4'),
(5, 2, 'question 1', 'answer 1'),
(6, 2, 'question 2', 'answer 2'),
(7, 2, 'question 3', 'answer 3'),
(8, 2, 'question 4', 'answer 4');

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

--
-- Dumping data for table `competition_result`
--

INSERT INTO `competition_result` (`resultID`, `userID`, `testID`, `result`, `competitionDuration`) VALUES
(1, 38, 2, 90, '00:00:32'),
(2, 43, 2, 70, '00:03:00'),
(3, 35, 1, 88, '00:01:00'),
(4, 36, 1, 70, '00:02:00'),
(5, 44, 1, 77, '00:02:00'),
(6, 47, 2, 80, '00:02:00');

-- --------------------------------------------------------

--
-- Table structure for table `competition_template`
--

CREATE TABLE `competition_template` (
  `templateID` int(10) NOT NULL,
  `templateTitle` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `competition_template`
--

INSERT INTO `competition_template` (`templateID`, `templateTitle`) VALUES
(1, 'test'),
(2, 'test template');

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
(1, 'How Well Do You Know Ima Megastar?', 13, 1, '2017-11-26 18:23:44', '2017-11-10 16:00:00', 'Prize A'),
(2, 'Come Test Your Knowledge!', 16, 1, '2017-11-26 18:23:48', '2017-09-21 16:00:00', 'Prize B');

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
-- Table structure for table `file`
--

CREATE TABLE `file` (
  `fileID` int(10) NOT NULL,
  `auctionID` int(10) NOT NULL,
  `fileName` varchar(255) NOT NULL,
  `filePath` varchar(255) NOT NULL,
  `fileType` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `paymentID` int(10) NOT NULL,
  `userID` int(10) NOT NULL,
  `paymentFile` varchar(255) NOT NULL,
  `paymentStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `reportID` int(10) NOT NULL,
  `contentID` int(10) NOT NULL,
  `contentType` varchar(255) NOT NULL,
  `userID` int(10) NOT NULL,
  `reportReason` varchar(255) NOT NULL,
  `reportDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reportFrom` varchar(30) NOT NULL,
  `reportStatus` int(10) NOT NULL
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
  `bidPenalty` int(10) NOT NULL,
  `securityQuestion` varchar(255) DEFAULT NULL,
  `securityAns` varchar(255) DEFAULT NULL,
  `registeredDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `fullName`, `username`, `emailAddr`, `passwordHash`, `shippingAddr`, `dob`, `userType`, `userStatus`, `memberConfirmationExpiryDate`, `penaltyCount`, `bidPenalty`, `securityQuestion`, `securityAns`, `registeredDate`) VALUES
(1, 'Ho Hao Yuan', 'Bobo Yuan', 'bobo@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', '14, Tanjung Rambutan, Georgetown, Penang', '1996-09-28', 'senior', 'banned', '2017-11-24 07:00:00', 0, 0, 'favouriteBook', 'StarWars', '2017-06-06 00:00:00'),
(2, 'Lim Qiu Ni', NULL, 'qn@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', NULL, NULL, 'admin', 'active', NULL, 0, 0, 'favouriteBook', 'Harry Potter', '2017-09-18 00:00:00'),
(3, 'Seah Jia-Min', NULL, 'seahjm@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', NULL, NULL, 'mainAdmin', 'active', NULL, 0, 0, 'favouriteBook', 'StarWars', '2017-10-09 00:00:00'),
(35, 'Zorina Abreu', 'Zorina', 'ZA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-11-18', 'junior', 'active', '0000-00-00 00:00:00', 3, 0, 'maidenName', 'Sim', '2017-05-12 00:00:00'),
(36, 'Tobias Blattman', 'Tobias', 'TB@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', '14, Tanjung Rambutan, Georgetown, Penang', '2006-04-26', 'junior', 'active', '0000-00-00 00:00:00', 3, 0, 'birthPlace', 'Singapore', '2017-04-04 00:00:00'),
(37, 'Tanzeer Cao', 'Tanzeer', 'TC@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', '14, Tanjung Rambutan, Georgetown, Penang', '1933-02-17', 'senior', 'banned', '0000-00-00 00:00:00', 3, 0, 'favouriteBook', 'Networking', '2017-11-06 00:00:00'),
(38, 'Sachie Clark', 'Sachie', 'SC@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', '14, Tanjung Rambutan, Georgetown, Penang', '2003-05-19', 'junior', 'active', '0000-00-00 00:00:00', 0, 0, 'birthPlace', 'Sarawak', '2017-10-02 00:00:00'),
(39, 'Radu Donahue', 'Radu', 'RD@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1923-03-16', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'school', 'Wawasan', '2017-09-04 00:00:00'),
(40, 'Philip Duncan', 'Philip', 'PD@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', '14, Tanjung Rambutan, Georgetown, Penang', '1911-10-14', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'favouriteBook', 'Java', '2017-08-07 00:00:00'),
(41, 'Yoon Akin-Aderibigbe', 'Yoon', 'YA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1915-07-27', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'birthPlace', 'Kedah', '2017-10-12 00:00:00'),
(42, 'Pallavi Fox', 'Fox', 'PF@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1977-04-17', 'senior', 'banned', '0000-00-00 00:00:00', 0, 0, 'maidenName', 'Tan', '2017-08-14 00:00:00'),
(43, 'Muge Graves', 'Muge', 'MG@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2002-12-25', 'junior', 'active', '0000-00-00 00:00:00', 0, 0, 'favouriteBook', 'C#', '2017-07-10 00:00:00'),
(44, 'Martinez Hofman', 'Hofman', 'MH@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2006-05-21', 'junior', 'active', '0000-00-00 00:00:00', 0, 0, 'maidenName', 'Lee', '2017-11-06 00:00:00'),
(45, 'Yat Lun Atri', 'Atri', 'YLA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2011-01-01', 'junior', 'banned', '0000-00-00 00:00:00', 0, 0, 'birthPlace', 'Penang', '2017-05-01 00:00:00'),
(46, 'Yi Feng Rlvarez', 'Rlvarez', 'YFR@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1974-07-08', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'school', 'Disted', '2017-04-18 00:00:00'),
(47, 'Yi Baramendia', 'Baramendia', 'YBA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '2001-04-12', 'junior', 'active', '0000-00-00 00:00:00', 0, 0, 'favouriteBook', 'C++', '2017-08-14 00:00:00'),
(48, 'Yaya Sashkenazi', 'Sashkenazi', 'YS@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1967-02-12', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'maidenName', 'Lim', '2017-09-04 00:00:00'),
(49, 'Yat Lun Batri', 'Batri', 'YLB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1963-08-08', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'school', 'Inti', '2017-10-30 00:00:00'),
(50, 'Yasu Hiro Au', 'Yasu Hiro', 'YHA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1955-06-27', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'favouriteBook', 'Me Before You', '2017-09-04 00:00:00'),
(51, 'Yan Wen Aurori', 'Aurora', 'YWA@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1953-06-24', 'senior', 'banned', '0000-00-00 00:00:00', 0, 0, 'school', 'KDU', '2017-10-12 00:00:00'),
(52, 'Yan Baustin Zen', 'Zen', 'YBZ@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1993-07-15', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'maidenName', 'Tan', '2017-07-25 00:00:00'),
(53, 'Ya Han Bagdat', 'Han', 'YHB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1934-02-02', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'favouriteBook', 'Percy Jackson', '2017-06-13 00:00:00'),
(54, 'Yael Bala', 'Bala', 'YB@gmail.com', '$2y$10$jDkxp2bOXzl2daCyUzxvEe8xvpIXpIghyaD.Mrxk1M3edpiIkuPde', '14, Tanjung Rambutan, Georgetown, Penang', '1943-06-13', 'senior', 'active', '0000-00-00 00:00:00', 0, 0, 'maidenName', 'Yeap', '2017-07-17 00:00:00'),
(55, 'Choo Zhao Hooi', 'Choo Zhao Hooi', 'zhaohooi@gmail.com', '$2y$10$WMWgvBXlPIqalLkx8zPpc.y1UTtYetYZOC.MIE99uHtU1ZbC.cLLq', 'Test Address', '1986-06-19', 'senior', 'active', '2017-11-23 22:27:52', 0, 0, 'favouriteFood', 'Burgers', '2017-06-20 00:00:00'),
(56, 'Cheong Yi Qi', NULL, 'yq@hotmail.com', NULL, NULL, NULL, 'admin', 'banned', '2017-11-12 00:44:57', 0, 0, NULL, NULL, '2017-05-23 00:00:00'),
(58, 'HHY', NULL, 'hhy@test.com', NULL, NULL, NULL, 'admin', 'pending', '2017-11-12 02:54:17', 0, 0, NULL, NULL, '2017-05-09 00:00:00'),
(59, '123', '123', '123@test.com', '$2y$10$7aw0yMHM.uhkajVyghcv/OCE0AKlP4zx1YeqRs8zsBlJLgS1Q8rwW', '123', '2007-11-05', 'junior', 'pending', '2017-11-24 00:02:20', 0, 0, 'favouriteBook', '123', NULL),
(60, '12', '12', '12@test.com', '$2y$10$bVaLRuTqI3yhb71I96nAAu.DJ2K4LRWoDUm1HqzhYobCDso8iERuq', '123', '2007-11-05', 'junior', 'pending', '2017-11-24 00:04:00', 0, 0, 'favouriteBook', '123', NULL);

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
(1, 'Inappropriate comments', '2017-11-26 09:23:01', '3'),
(37, 'Bad behaviour, Inappropriate comments   A, Inappropriate comments B', '2017-11-26 17:48:54', '3'),
(42, 'Inappropriate comments', '2017-11-26 09:34:24', '3'),
(45, 'Inappropriate comments', '2017-11-26 09:34:53', '3'),
(51, 'Ban behaviour', '2017-11-26 09:35:18', '3');

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
(35, 'Inappropriate comment A, Inappropriate comment B, Inappropriate comment C'),
(36, 'Inappropriate comment D, Inappropriate comment E, Inappropriate comment F');

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
-- Indexes for table `album_comment`
--
ALTER TABLE `album_comment`
  ADD PRIMARY KEY (`commentID`);

--
-- Indexes for table `album_photo`
--
ALTER TABLE `album_photo`
  ADD PRIMARY KEY (`photoID`);

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
-- Indexes for table `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`fileID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`paymentID`);

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
-- AUTO_INCREMENT for table `album_comment`
--
ALTER TABLE `album_comment`
  MODIFY `commentID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `album_photo`
--
ALTER TABLE `album_photo`
  MODIFY `photoID` int(10) NOT NULL AUTO_INCREMENT;
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
  MODIFY `bidID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `competition_question`
--
ALTER TABLE `competition_question`
  MODIFY `questionID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `competition_result`
--
ALTER TABLE `competition_result`
  MODIFY `resultID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `competition_template`
--
ALTER TABLE `competition_template`
  MODIFY `templateID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
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
-- AUTO_INCREMENT for table `file`
--
ALTER TABLE `file`
  MODIFY `fileID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `paymentID` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `reportID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;
--
-- AUTO_INCREMENT for table `user_banned`
--
ALTER TABLE `user_banned`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;
--
-- AUTO_INCREMENT for table `user_blacklist`
--
ALTER TABLE `user_blacklist`
  MODIFY `userID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `watchlist`
--
ALTER TABLE `watchlist`
  MODIFY `watchListID` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
