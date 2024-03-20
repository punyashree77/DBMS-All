-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 10:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbmslab3`
--

-- --------------------------------------------------------

--
-- Table structure for table `actor`
--

CREATE TABLE `actor` (
  `act_id` int(11) NOT NULL,
  `act_name` varchar(40) DEFAULT NULL,
  `act_gender` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actor`
--

INSERT INTO `actor` (`act_id`, `act_name`, `act_gender`) VALUES
(100, 'sudeep', 'm'),
(101, 'darshan', 'm'),
(102, 'anushka', 'f'),
(103, 'punith', 'm'),
(104, 'katrina', 'f'),
(105, 'surya', 'm');

-- --------------------------------------------------------

--
-- Table structure for table `director`
--

CREATE TABLE `director` (
  `dir_id` int(11) NOT NULL,
  `dir_name` varchar(40) DEFAULT NULL,
  `dir_phone` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `director`
--

INSERT INTO `director` (`dir_id`, `dir_name`, `dir_phone`) VALUES
(1000, 'rajamouli', 1234567890),
(1001, 'steven spielberg', 2121212121),
(1002, 'hitchcock', 2147483647),
(1003, 'muniratna', 1313131313),
(1004, 'ramesh', 2147483647);

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `mov_id` int(11) NOT NULL,
  `mov_title` varchar(20) DEFAULT NULL,
  `mov_year` year(4) DEFAULT NULL,
  `mov_lang` varchar(30) DEFAULT NULL,
  `dir_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`mov_id`, `mov_title`, `mov_year`, `mov_lang`, `dir_id`) VALUES
(20, 'bahubali-1', '2015', 'telugu', 1000),
(21, 'bahubali-2', '2018', 'telugu', 1000),
(22, 'raj', '2018', 'kannada', 1001),
(23, 'warhouse', '2010', 'english', 1002);

-- --------------------------------------------------------

--
-- Table structure for table `movie_cast`
--

CREATE TABLE `movie_cast` (
  `act_id` int(11) NOT NULL,
  `mov_id` int(11) NOT NULL,
  `role` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `movie_cast`
--

INSERT INTO `movie_cast` (`act_id`, `mov_id`, `role`) VALUES
(100, 22, 'hero'),
(101, 20, 'heroien'),
(101, 21, 'heroien'),
(102, 22, 'hero'),
(105, 23, 'hero');

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `mov_id` int(11) DEFAULT NULL,
  `rev_stars` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`mov_id`, `rev_stars`) VALUES
(20, 4),
(20, 3),
(20, 5),
(21, 5),
(21, 3),
(21, 2),
(22, 5),
(22, 5),
(22, 5),
(23, 4),
(23, 2),
(23, 5),
(23, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actor`
--
ALTER TABLE `actor`
  ADD PRIMARY KEY (`act_id`);

--
-- Indexes for table `director`
--
ALTER TABLE `director`
  ADD PRIMARY KEY (`dir_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`mov_id`),
  ADD KEY `dir_id` (`dir_id`);

--
-- Indexes for table `movie_cast`
--
ALTER TABLE `movie_cast`
  ADD PRIMARY KEY (`act_id`,`mov_id`),
  ADD KEY `mov_id` (`mov_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD KEY `mov_id` (`mov_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`dir_id`) REFERENCES `director` (`dir_id`) ON DELETE CASCADE;

--
-- Constraints for table `movie_cast`
--
ALTER TABLE `movie_cast`
  ADD CONSTRAINT `movie_cast_ibfk_1` FOREIGN KEY (`act_id`) REFERENCES `actor` (`act_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `movie_cast_ibfk_2` FOREIGN KEY (`mov_id`) REFERENCES `movies` (`mov_id`) ON DELETE CASCADE;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`mov_id`) REFERENCES `movies` (`mov_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
