-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2021 at 06:47 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `connect4`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `clear_game` ()  BEGIN
	UPDATE `board` SET `piece_color`=null;
	UPDATE `players` SET `username`=null, `token`=null;
	UPDATE `game_status` SET `status`='not active', 				`p_turn`=null, `result`=null;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `play` (IN `col_num` INT, IN `color` TEXT)  play:
BEGIN
if (SELECT piece_color FROM `board` WHERE x=6 AND y=col_num)IS NULL THEN
UPDATE `board` SET piece_color=color WHERE x=6 AND y=col_num;
UPDATE `game_status` SET p_turn=if(color='R','Y','R');
LEAVE play;
END IF;

if (SELECT piece_color FROM `board` WHERE x=5 AND y=col_num)IS NULL THEN
UPDATE `board` SET piece_color=color WHERE x=5 AND y=col_num;
UPDATE `game_status` SET p_turn=if(color='R','Y','R');
LEAVE play;
END IF;

if (SELECT piece_color FROM `board` WHERE x=4 AND y=col_num)IS NULL THEN
UPDATE `board` SET piece_color=color WHERE x=4 AND y=col_num;
UPDATE `game_status` SET p_turn=if(color='R','Y','R');
LEAVE play;
END IF;

if (SELECT piece_color FROM `board` WHERE x=3 AND y=col_num)IS NULL THEN
UPDATE `board` SET piece_color=color WHERE x=3 AND y=col_num;
UPDATE `game_status` SET p_turn=if(color='R','Y','R');
LEAVE play;
END IF;

if (SELECT piece_color FROM `board` WHERE x=2 AND y=col_num)IS NULL THEN
UPDATE `board` SET piece_color=color WHERE x=2 AND y=col_num;
UPDATE `game_status` SET p_turn=if(color='R','Y','R');
LEAVE play;
END IF;

if (SELECT piece_color FROM `board` WHERE x=1 AND y=col_num)IS NULL THEN
UPDATE `board` SET piece_color=color WHERE x=1 AND y=col_num;
UPDATE `game_status` SET p_turn=if(color='R','Y','R');
LEAVE play;
END IF;

END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `board`
--

CREATE TABLE `board` (
  `x` tinyint(1) NOT NULL,
  `y` tinyint(1) NOT NULL,
  `piece_color` enum('R','Y') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `board`
--

INSERT INTO `board` (`x`, `y`, `piece_color`) VALUES
(1, 1, 'Y'),
(1, 2, 'R'),
(1, 3, 'Y'),
(1, 4, 'R'),
(1, 5, 'Y'),
(1, 6, 'Y'),
(1, 7, 'Y'),
(2, 1, 'R'),
(2, 2, 'Y'),
(2, 3, 'Y'),
(2, 4, 'R'),
(2, 5, 'R'),
(2, 6, 'Y'),
(2, 7, 'R'),
(3, 1, 'Y'),
(3, 2, 'R'),
(3, 3, 'Y'),
(3, 4, 'R'),
(3, 5, 'Y'),
(3, 6, 'Y'),
(3, 7, 'Y'),
(4, 1, 'R'),
(4, 2, 'Y'),
(4, 3, 'R'),
(4, 4, 'Y'),
(4, 5, 'R'),
(4, 6, 'R'),
(4, 7, 'R'),
(5, 1, 'Y'),
(5, 2, 'R'),
(5, 3, 'R'),
(5, 4, 'Y'),
(5, 5, 'Y'),
(5, 6, 'R'),
(5, 7, 'Y'),
(6, 1, 'R'),
(6, 2, 'Y'),
(6, 3, 'R'),
(6, 4, 'Y'),
(6, 5, 'R'),
(6, 6, 'R'),
(6, 7, 'R');

-- --------------------------------------------------------

--
-- Table structure for table `game_status`
--

CREATE TABLE `game_status` (
  `status` enum('not active','initialized','started','\r\nended','aborded') NOT NULL DEFAULT 'not active',
  `p_turn` enum('R','Y') DEFAULT NULL,
  `result` enum('R','Y','D') DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `game_status`
--

INSERT INTO `game_status` (`status`, `p_turn`, `result`, `last_change`) VALUES
('not active', 'R', NULL, '2021-01-03 17:15:31');

--
-- Triggers `game_status`
--
DELIMITER $$
CREATE TRIGGER `game_status_update` BEFORE UPDATE ON `game_status` FOR EACH ROW BEGIN
	SET NEW.last_change = NOW();
 END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `players`
--

CREATE TABLE `players` (
  `username` varchar(20) DEFAULT NULL,
  `piece_color` enum('R','Y') NOT NULL,
  `token` varchar(32) DEFAULT NULL,
  `last_change` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `players`
--

INSERT INTO `players` (`username`, `piece_color`, `token`, `last_change`) VALUES
('it154603', 'R', '19943d368455d24f8fefa6cdf1876d21', '2021-01-03 17:13:51'),
('vasiloudis', 'Y', '05f868a682353e2c4f3b6f72447816ef', '2021-01-03 17:13:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `board`
--
ALTER TABLE `board`
  ADD PRIMARY KEY (`x`,`y`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
