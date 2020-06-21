-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 09, 2020 at 12:27 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `argumentdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `l_argument`
--

CREATE TABLE `l_argument` (
  `ArgID` int(10) NOT NULL,
  `UserID` int(6) NOT NULL,
  `Title` varchar(100) NOT NULL,
  `LeftSide` varchar(100) NOT NULL,
  `RightSide` varchar(100) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `l_argument`
--

INSERT INTO `l_argument` (`ArgID`, `UserID`, `Title`, `LeftSide`, `RightSide`, `date`) VALUES
(1, 1, 'Is a hot dog a sandwich?', 'A hot dog is a sandwich', 'A hot dog is not a sandwich', '2020-04-09 03:27:01'),
(2, 5, 'Do cats have nine lives?', 'No way they have nine lives!', 'Of course they do!', '2020-04-09 03:29:07'),
(3, 1, 'Is Charlie cool?', 'OH YEAH', 'no way', '2020-04-09 03:34:04'),
(4, 3, 'Is this project any good?', 'Project is great!', 'It could be better', '2020-04-09 04:03:51'),
(5, 6, 'Is Jones a good teacher?', 'He\'s the best teacher ever!', 'No he really is the best, no beef here', '2020-04-09 04:10:00'),
(6, 7, 'Is football better than hockey?', 'Football', 'Hockey', '2020-04-09 04:11:27'),
(7, 8, 'Rap or Classical music?', 'Rap', 'Classical', '2020-04-09 04:12:07'),
(8, 9, 'Did I stay up until 6 to finish this?', 'No way you did that, liar', 'Okay you might have', '2020-04-09 05:26:31'),
(9, 10, 'White or whole grain?', 'Whole grain', 'I want bread not dirt', '2020-04-09 05:48:03'),
(10, 11, 'I cant keep thinking of beef please help', 'Help him', 'Let him rot', '2020-04-09 05:49:39'),
(11, 4, 'Is C   better than Java?', 'Java is the best', 'C   all day, everyday ', '2020-04-09 05:55:41'),
(12, 10, 'Should we settle the beef?', 'We should!', 'I\'m scared :,(', '2020-04-09 06:23:18');

-- --------------------------------------------------------

--
-- Table structure for table `l_comment`
--

CREATE TABLE `l_comment` (
  `UserID` int(6) NOT NULL,
  `ArgID` int(10) NOT NULL,
  `CommentText` varchar(200) NOT NULL,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `l_comment`
--

INSERT INTO `l_comment` (`UserID`, `ArgID`, `CommentText`, `date`) VALUES
(3, 3, 'Charlie is pretty cool!', '2020-04-09 04:02:37'),
(3, 2, 'No way they have nine lives!', '2020-04-09 04:03:00'),
(8, 7, 'I think it\'s rap', '2020-04-09 04:18:31'),
(1, 3, 'This is a long comment to test the table but no way', '2020-04-09 04:30:03'),
(5, 7, 'I like rap much better', '2020-04-09 05:47:12'),
(10, 9, 'I just think whole grain is healthy', '2020-04-09 05:48:15'),
(11, 10, 'Man please help me', '2020-04-09 05:49:48'),
(11, 9, 'I like whole grain too!', '2020-04-09 05:50:08'),
(11, 1, 'I think its a taco', '2020-04-09 05:50:23'),
(3, 7, 'Its rap allllll the way!', '2020-04-09 05:52:19'),
(4, 7, 'Classical is good too', '2020-04-09 05:52:43'),
(4, 11, 'I prefer Java over C', '2020-04-09 05:55:59'),
(4, 3, 'Charlie is very cool', '2020-04-09 05:56:51'),
(5, 3, 'Eh, Charlie is alright', '2020-04-09 05:57:16'),
(6, 3, 'I really like charlie', '2020-04-09 05:57:45'),
(7, 3, 'Charlie is a cool dude', '2020-04-09 05:58:04'),
(10, 12, 'I AINT SCARED', '2020-04-09 06:23:25'),
(10, 7, 'I changed my mind I like rap better', '2020-04-09 06:25:52');

-- --------------------------------------------------------

--
-- Table structure for table `l_user`
--

CREATE TABLE `l_user` (
  `UserName` varchar(20) NOT NULL,
  `UserID` int(6) NOT NULL,
  `Passwrd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `l_user`
--

INSERT INTO `l_user` (`UserName`, `UserID`, `Passwrd`) VALUES
('Cameron', 1, 'Test'),
('Sage', 2, 'Test'),
('Eric', 3, 'Test'),
('Jones', 4, 'Test'),
('Emily', 5, 'Test'),
('Kim', 6, 'Test'),
('Ian', 7, 'Test'),
('Sabrina', 8, 'Test'),
('Joe', 9, 'Test'),
('Jimmy', 10, 'Test'),
('Tom', 11, 'Test');

-- --------------------------------------------------------

--
-- Table structure for table `l_vote`
--

CREATE TABLE `l_vote` (
  `ArgId` int(10) NOT NULL,
  `UserId` int(6) NOT NULL,
  `Vote` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `l_vote`
--

INSERT INTO `l_vote` (`ArgId`, `UserId`, `Vote`) VALUES
(2, 3, 0),
(3, 1, 0),
(3, 3, 0),
(3, 5, 1),
(4, 1, 0),
(6, 1, 0),
(7, 1, 0),
(7, 3, 0),
(7, 4, 1),
(7, 5, 0),
(7, 8, 0),
(7, 10, 1),
(8, 1, 0),
(8, 5, 0),
(8, 9, 1),
(9, 10, 0),
(9, 11, 0),
(10, 11, 0),
(12, 10, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `l_argument`
--
ALTER TABLE `l_argument`
  ADD PRIMARY KEY (`ArgID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `l_comment`
--
ALTER TABLE `l_comment`
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ArgID` (`ArgID`);

--
-- Indexes for table `l_user`
--
ALTER TABLE `l_user`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `l_vote`
--
ALTER TABLE `l_vote`
  ADD PRIMARY KEY (`ArgId`,`UserId`),
  ADD KEY `UserId` (`UserId`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `l_argument`
--
ALTER TABLE `l_argument`
  ADD CONSTRAINT `l_argument_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `l_user` (`UserID`);

--
-- Constraints for table `l_comment`
--
ALTER TABLE `l_comment`
  ADD CONSTRAINT `l_comment_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `l_user` (`UserID`),
  ADD CONSTRAINT `l_comment_ibfk_2` FOREIGN KEY (`ArgID`) REFERENCES `l_argument` (`ArgID`);

--
-- Constraints for table `l_vote`
--
ALTER TABLE `l_vote`
  ADD CONSTRAINT `l_vote_ibfk_1` FOREIGN KEY (`ArgId`) REFERENCES `l_argument` (`ArgID`),
  ADD CONSTRAINT `l_vote_ibfk_2` FOREIGN KEY (`UserId`) REFERENCES `l_user` (`UserID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
