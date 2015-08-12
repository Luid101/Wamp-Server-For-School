-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 12, 2015 at 02:17 PM
-- Server version: 5.6.20-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `login_register`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
`id` int(11) NOT NULL,
  `title` text NOT NULL,
  `body` longtext NOT NULL,
  `days_of_week` tinytext NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL COMMENT 'when the announcement will be done',
  `author` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `polls`
--

CREATE TABLE IF NOT EXISTS `polls` (
`id` int(11) NOT NULL,
  `question` text NOT NULL,
  `option1` text NOT NULL,
  `answer1` int(11) NOT NULL,
  `option2` text NOT NULL,
  `answer2` int(11) NOT NULL,
  `option3` text NOT NULL,
  `answer3` int(11) NOT NULL,
  `option4` text NOT NULL,
  `answer4` int(11) NOT NULL,
  `option5` text NOT NULL,
  `answer5` int(11) NOT NULL,
  `option6` text NOT NULL,
  `answer6` int(11) NOT NULL,
  `option7` text NOT NULL,
  `answer7` int(11) NOT NULL,
  `option8` text NOT NULL,
  `answer8` int(11) NOT NULL,
  `option9` text NOT NULL,
  `answer9` int(11) NOT NULL,
  `option10` text NOT NULL,
  `answer10` int(11) NOT NULL,
  `author` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='max 10 options per polls' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `room_a`
--

CREATE TABLE IF NOT EXISTS `room_a` (
`id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Period_1` text NOT NULL,
  `Period_2` text NOT NULL,
  `Period_3A` text NOT NULL,
  `Period_3B` text NOT NULL,
  `Period_3C` text NOT NULL,
  `Period_4` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table data for a generic room.' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `room_b`
--

CREATE TABLE IF NOT EXISTS `room_b` (
`id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Period_1` text NOT NULL,
  `Period_2` text NOT NULL,
  `Period_3A` text NOT NULL,
  `Period_3B` text NOT NULL,
  `Period_3C` text NOT NULL,
  `Period_4` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table data for a generic room.' AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `room_c`
--

CREATE TABLE IF NOT EXISTS `room_c` (
`id` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Period_1` text NOT NULL,
  `Period_2` text NOT NULL,
  `Period_3A` text NOT NULL,
  `Period_3B` text NOT NULL,
  `Period_3C` text NOT NULL,
  `Period_4` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Table data for a generic room.' AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` tinytext NOT NULL COMMENT '0:admin,1:teacher,2:student'
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `vote_check`
--

CREATE TABLE IF NOT EXISTS `vote_check` (
  `student_id` int(11) NOT NULL,
  `id_of_poll` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polls`
--
ALTER TABLE `polls`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `room_a`
--
ALTER TABLE `room_a`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `Date` (`Date`);

--
-- Indexes for table `room_b`
--
ALTER TABLE `room_b`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `Date` (`Date`);

--
-- Indexes for table `room_c`
--
ALTER TABLE `room_c`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `Date` (`Date`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `polls`
--
ALTER TABLE `polls`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `room_a`
--
ALTER TABLE `room_a`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `room_b`
--
ALTER TABLE `room_b`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `room_c`
--
ALTER TABLE `room_c`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
