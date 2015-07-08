-- phpMyAdmin SQL Dump
-- version 4.2.13
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 08, 2015 at 08:40 AM
-- Server version: 5.6.21
-- PHP Version: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `stemmenteller`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
`movie_id` int(10) NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `movie_can_win` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `setting_name` varchar(255) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_name`, `setting_value`) VALUES
('background_image_url', '406667d1780b3f2a501c4b0cc9a6cbb4.jpg'),
('custom_text', '<h1>Tijdelijk geen uitslagen</h1><script>alert(''booboo'')</script>'),
('festival_name', 'NFF36'),
('show_ranking_auto_limit_day', '01'),
('show_ranking_auto_limit_hour', '14'),
('show_ranking_auto_limit_minutes', '00'),
('show_ranking_auto_limit_month', '11'),
('show_ranking_auto_limit_year', '2014'),
('show_ranking_status', 'from4'),
('voting_minimum', '100');

-- --------------------------------------------------------

--
-- Table structure for table `showings`
--

CREATE TABLE IF NOT EXISTS `showings` (
`showing_id` int(10) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `showing_datetime` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`user_id` int(5) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(128) NOT NULL,
  `user_level` int(3) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_password`, `user_level`) VALUES
(1, 'admin', '$2y$10$/BiR/aylmWeJxrk1uEfPuumSphFMvj8jw3jWkGIj5GtI3izz6TlHy', 0),
(2, 'manager', '$2y$10$hNdWAExDUw6Actis480q5ujpJIafRE/nfgjDr3HGs/.mBhjS8HcMa', 1);

-- --------------------------------------------------------

--
-- Table structure for table `votings`
--

CREATE TABLE IF NOT EXISTS `votings` (
`voting_id` int(10) NOT NULL,
  `voting_datetime` int(20) NOT NULL,
  `movie_id` int(10) NOT NULL,
  `showing_id` int(10) NOT NULL,
  `grades` text NOT NULL,
  `num_visitors` int(5) NOT NULL,
  `num_volunteers` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
 ADD PRIMARY KEY (`movie_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
 ADD UNIQUE KEY `UNIQUE` (`setting_name`);

--
-- Indexes for table `showings`
--
ALTER TABLE `showings`
 ADD PRIMARY KEY (`showing_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `votings`
--
ALTER TABLE `votings`
 ADD PRIMARY KEY (`voting_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
MODIFY `movie_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
MODIFY `showing_id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `user_id` int(5) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `votings`
--
ALTER TABLE `votings`
MODIFY `voting_id` int(10) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
