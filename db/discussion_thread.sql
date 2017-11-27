-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 27, 2017 at 02:22 AM
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
-- Table structure for table `discussion_thread`
--

CREATE TABLE IF NOT EXISTS `discussion_thread` (
  `threadID` int(10) NOT NULL AUTO_INCREMENT,
  `threadName` varchar(255) NOT NULL,
  `threadDescription` varchar(255) NOT NULL,
  `threadDateTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `userID` int(10) NOT NULL,
  PRIMARY KEY (`threadID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `discussion_thread`
--

INSERT INTO `discussion_thread` (`threadID`, `threadName`, `threadDescription`, `threadDateTime`, `userID`) VALUES
(4, 'Ima Falls Down Stair On New Year Eve!', 'Ima performs and nearly falls off stage on New Year''s Eve', '2017-11-27 01:17:33', 3),
(5, 'Ima''s 21st Birthday', 'Ima''s twenty-one years old birthday celebration', '2017-11-27 02:02:43', 3);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
