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
-- Table structure for table `discussion_inappropriate`
--

CREATE TABLE IF NOT EXISTS `discussion_inappropriate` (
  `inappropriatePhraseID` int(10) NOT NULL AUTO_INCREMENT,
  `inappropriatePhrase` varchar(255) NOT NULL,
  `replacementWord` varchar(255) NOT NULL,
  PRIMARY KEY (`inappropriatePhraseID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `discussion_inappropriate`
--

INSERT INTO `discussion_inappropriate` (`inappropriatePhraseID`, `inappropriatePhrase`, `replacementWord`) VALUES
(1, 'asshole', '*******'),
(2, 'ass', '***'),
(3, 'fuck', '****'),
(4, 'fucker', '******'),
(5, 'fucking', '*******'),
(6, 'bitch', '*****'),
(7, 'cunt', '****'),
(8, 'idiot', '*****'),
(9, 'motherfucker', '************'),
(10, 'shit', '****'),
(11, 'pussy', '*****'),
(12, 'whore', '*****'),
(13, 'stupid', '******');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
