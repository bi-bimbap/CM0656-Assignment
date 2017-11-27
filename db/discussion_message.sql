-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2017 at 02:21 AM
-- Server version: 5.5.58-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ima-fanbase`
--

-- --------------------------------------------------------

--
-- Table structure for table `discussion_message`
--

CREATE TABLE IF NOT EXISTS `discussion_message` (
  `messageID` int(10) NOT NULL AUTO_INCREMENT,
  `userID` int(10) NOT NULL,
  `threadID` int(10) NOT NULL,
  `messageContent` varchar(255) NOT NULL,
  `messageDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `messageStatus` varchar(30) NOT NULL,
  `replyTo` int(10) DEFAULT NULL,
  PRIMARY KEY (`messageID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `discussion_message`
--

INSERT INTO `discussion_message` (`messageID`, `userID`, `threadID`, `messageContent`, `messageDateTime`, `messageStatus`, `replyTo`) VALUES
(1, 55, 4, 'This is cool ! ! !', '2017-11-27 01:57:40', 'active', NULL),
(2, 38, 4, 'Are you kidding?!', '2017-11-27 02:14:44', 'active', 1),
(3, 36, 4, 'Holly **** ! !', '2017-11-27 02:16:55', 'active', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
