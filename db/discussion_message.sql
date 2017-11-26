-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 26, 2017 at 04:57 PM
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

--
-- Dumping data for table `discussion_message`
--

INSERT INTO `discussion_message` (`messageID`, `userID`, `threadID`, `messageContent`, `messageDateTime`, `messageStatus`, `replyTo`) VALUES
(18, 1, 2, 'This is so cool', '2017-11-23 13:15:54', 'active', NULL),
(20, 1, 1, 'She has Merz, Iphone and Bangalore as birthday gifts\r\n', '2017-11-26 15:55:06', 'active', NULL),
(21, 1, 1, 'yeah! me too', '2017-11-26 15:55:54', 'active', 30),
(22, 1, 1, 'Are you joking ?', '2017-11-26 15:56:22', 'active', 30),
(30, 38, 1, 'I wish to celebrate with her big big day', '2017-11-26 15:53:03', 'active', NULL),
(32, 1, 1, 'Have a wonderful birthday!!!!', '2017-11-26 15:54:11', 'active', NULL),
(101, 1, 2, 'hello **** you', '2017-11-26 10:33:44', 'active', 18);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `discussion_message`
--
ALTER TABLE `discussion_message`
  ADD PRIMARY KEY (`messageID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `discussion_message`
--
ALTER TABLE `discussion_message`
  MODIFY `messageID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
