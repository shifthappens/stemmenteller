-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 13, 2024 at 02:59 PM
-- Server version: 8.0.40-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stemmenteller`
--

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int NOT NULL,
  `movie_name` varchar(255) NOT NULL,
  `movie_can_win` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `movie_name`, `movie_can_win`) VALUES
(164, 'Kneecap', 1),
(165, 'The Outrun', 1),
(166, 'Birthday Girl', 1),
(167, 'Efterklang: The Makedonium Band', 1),
(168, 'Homecoming', 1),
(169, 'Shorts Special: King Ridwan & Kendis', 1),
(170, 'Noordse kortfilms: Een Frisse Blik', 1),
(171, 'That They May Face the Rising Sun', 1),
(172, 'Poison', 1),
(173, 'Death is a Problem for the Living', 1),
(174, 'In Liebe Eure Hilde', 1),
(175, 'Mother Vera', 1),
(176, 'Mijn bijzonder rare week met Tess', 1),
(177, 'Gondola', 1),
(178, 'Buladó', 1),
(179, 'A Happy Day', 1),
(180, 'Solitude', 1),
(181, 'Creatura', 1),
(182, 'Armand', 1),
(183, 'Loveable', 1),
(184, 'Silence of the Tides', 1),
(185, 'Hammarskjöld - Fight for Peace', 1),
(186, 'Bird', 1),
(187, 'Way Home', 1),
(188, 'Wir Sind die Flut', 1),
(189, 'Light Light Light', 1),
(190, 'Film & Food: Como agua para chocolata', 1),
(191, 'The Arctic Convoy', 1),
(192, 'The View', 1),
(193, 'Last swim', 1),
(194, 'Future Me', 1),
(195, 'Like Tears in Rain', 1),
(196, 'In Restless Dreams: The Music of Paul Simon', 1),
(197, 'EBLT presents: Witte Wieven', 1),
(198, 'Flow', 1),
(199, 'Touch', 1),
(200, 'The Riot', 1),
(201, 'Festen', 1),
(202, 'My Wonderful Stranger', 1),
(203, 'When the Light Breaks', 1),
(204, 'Toxic', 1),
(205, 'Sex', 1),
(206, 'Kollektivet', 1),
(207, 'Small Things Like These', 1),
(208, 'Butterflies', 1),
(209, 'The Gullspång Miracle', 1),
(210, 'IFA presents: Gloria!', 1),
(211, 'A Call from the Wild', 1),
(212, 'BBB in alle staten', 1),
(213, 'Mr. K', 1),
(214, 'Sons', 1),
(215, 'De Kunstmatige Vriendin (FPO)', 1),
(216, 'Nico', 1),
(217, 'Handling the Undead', 1),
(218, 'Blitz', 1),
(219, 'Oddity', 1),
(220, 'As the Tide Comes In', 1),
(221, 'A New Kind of Wilderness', 1),
(222, 'Afterwar', 1),
(223, 'My Father\'s Daughter', 1),
(224, 'Into the Abyss', 1),
(225, 'Two Strangers Trying Not to Kill Each Other', 1),
(226, 'Sing Sing', 1),
(227, 'Filmconcert: The Most Dangerous Game', 1),
(228, 'Roze Bubbel', 1),
(229, 'Bijt', 1),
(230, 'Queendom', 1),
(231, 'Familiebrunch: Drie rovers en een leeuw', 1),
(232, 'Melk', 1),
(233, 'SLOTFILM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `setting_name` varchar(255) NOT NULL,
  `setting_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`setting_name`, `setting_value`) VALUES
('background_image_url', '2b5d5dc413ddfc7012229314e69ad241.jpg'),
('custom_text', ''),
('festival_date_end', '2024-11-17'),
('festival_date_start', '2024-11-13'),
('festival_name', 'NFF43'),
('show_ranking_auto_limit_day', '17'),
('show_ranking_auto_limit_hour', '14'),
('show_ranking_auto_limit_minutes', '00'),
('show_ranking_auto_limit_month', '11'),
('show_ranking_auto_limit_year', '2024'),
('show_ranking_status', 'top5'),
('voting_minimum', '50');

-- --------------------------------------------------------

--
-- Table structure for table `showings`
--

CREATE TABLE `showings` (
  `showing_id` int NOT NULL,
  `movie_id` int NOT NULL,
  `showing_datetime` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `showings`
--

INSERT INTO `showings` (`showing_id`, `movie_id`, `showing_datetime`) VALUES
(299, 164, '1731528000'),
(300, 164, '1731529800'),
(301, 164, '1731774600'),
(302, 165, '1731528900'),
(303, 165, '1731792600'),
(304, 165, '1731861900'),
(305, 166, '1731530700'),
(306, 166, '1731846600'),
(307, 167, '1731530700'),
(308, 167, '1731679200'),
(309, 168, '1731531600'),
(310, 168, '1731776400'),
(311, 169, '1731574800'),
(312, 170, '1731576600'),
(313, 171, '1731582000'),
(314, 171, '1731669300'),
(315, 171, '1731782700'),
(316, 172, '1731582000'),
(317, 172, '1731767400'),
(318, 173, '1731582000'),
(319, 173, '1731670200'),
(320, 173, '1731793500'),
(321, 174, '1731582900'),
(322, 174, '1731687300'),
(323, 175, '1731582900'),
(324, 175, '1731697200'),
(325, 175, '1731862800'),
(326, 176, '1731583800'),
(327, 176, '1731752100'),
(328, 177, '1731583800'),
(329, 177, '1731697200'),
(330, 177, '1731752100'),
(331, 178, '1731680100'),
(332, 178, '1731752100'),
(333, 179, '1731590100'),
(334, 179, '1731696300'),
(335, 179, '1731871800'),
(336, 180, '1731591000'),
(337, 180, '1731768300'),
(338, 180, '1731855600'),
(339, 181, '1731591000'),
(340, 181, '1731862800'),
(341, 182, '1731591000'),
(342, 182, '1731678300'),
(343, 183, '1731591900'),
(344, 183, '1731759300'),
(345, 183, '1731837600'),
(346, 184, '1731591900'),
(347, 184, '1731687300'),
(348, 185, '1731600000'),
(349, 185, '1731679200'),
(350, 185, '1731751200'),
(351, 186, '1731600000'),
(352, 186, '1731696300'),
(353, 186, '1731793500'),
(354, 187, '1731600000'),
(355, 187, '1731679200'),
(356, 187, '1731767400'),
(357, 188, '1731600900'),
(358, 188, '1731705300'),
(359, 189, '1731600900'),
(360, 189, '1731706200'),
(361, 189, '1731847500'),
(362, 190, '1731609000'),
(363, 191, '1731609900'),
(364, 191, '1731759300'),
(365, 191, '1731854700'),
(366, 192, '1731609900'),
(367, 192, '1731686400'),
(368, 192, '1731696300'),
(369, 193, '1731609900'),
(370, 193, '1731766500'),
(371, 193, '1731837600'),
(372, 194, '1731609900'),
(373, 195, '1731610800'),
(374, 195, '1731704400'),
(375, 195, '1731752100'),
(376, 196, '1731610800'),
(377, 196, '1731855600'),
(378, 197, '1731610800'),
(379, 198, '1731611700'),
(380, 198, '1731838500'),
(381, 199, '1731618000'),
(382, 199, '1731670200'),
(383, 199, '1731774600'),
(384, 200, '1731618000'),
(385, 201, '1731618000'),
(386, 201, '1731783600'),
(387, 202, '1731618000'),
(388, 202, '1731670200'),
(389, 202, '1731751200'),
(390, 203, '1731618900'),
(391, 203, '1731688200'),
(392, 203, '1731847500'),
(393, 204, '1731619800'),
(394, 204, '1731792600'),
(395, 205, '1731669300'),
(396, 205, '1731774600'),
(397, 205, '1731872700'),
(398, 206, '1731670200'),
(399, 206, '1731774600'),
(400, 207, '1731671100'),
(401, 207, '1731783600'),
(402, 207, '1731846600'),
(403, 208, '1731679200'),
(404, 208, '1731759300'),
(405, 208, '1731846600'),
(406, 209, '1731687300'),
(407, 209, '1731751200'),
(408, 210, '1731688200'),
(409, 210, '1731784500'),
(410, 211, '1731688200'),
(411, 211, '1731784500'),
(412, 211, '1731838500'),
(413, 212, '1731697200'),
(414, 213, '1731697200'),
(415, 213, '1731872700'),
(416, 214, '1731700800'),
(417, 215, '1731702600'),
(418, 216, '1731704400'),
(419, 216, '1731873600'),
(420, 217, '1731704400'),
(421, 217, '1731799800'),
(422, 218, '1731705300'),
(423, 218, '1731793500'),
(424, 219, '1731712500'),
(425, 219, '1731791700'),
(426, 220, '1731759300'),
(427, 220, '1731854700'),
(428, 221, '1731760200'),
(429, 221, '1731838500'),
(430, 222, '1731760200'),
(431, 222, '1731837600'),
(432, 223, '1731768300'),
(433, 223, '1731839400'),
(434, 224, '1731771000'),
(435, 225, '1731775500'),
(436, 225, '1731854700'),
(437, 226, '1731857400'),
(438, 227, '1731857400'),
(439, 228, '1731776400'),
(440, 229, '1731783600'),
(441, 230, '1731792600'),
(442, 230, '1731862800'),
(443, 231, '1731841200'),
(444, 232, '1731845700'),
(445, 233, '1731873600');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(128) NOT NULL,
  `user_level` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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

CREATE TABLE `votings` (
  `voting_id` int NOT NULL,
  `voting_datetime` int NOT NULL,
  `movie_id` int NOT NULL,
  `showing_id` int NOT NULL,
  `grades` text NOT NULL,
  `num_visitors` int NOT NULL,
  `num_volunteers` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

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
  MODIFY `movie_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=234;

--
-- AUTO_INCREMENT for table `showings`
--
ALTER TABLE `showings`
  MODIFY `showing_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=446;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `votings`
--
ALTER TABLE `votings`
  MODIFY `voting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
