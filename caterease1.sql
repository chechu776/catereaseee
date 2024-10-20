-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 26, 2024 at 09:18 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `caterease`
--

-- --------------------------------------------------------

--
-- Table structure for table `csp_table`
--

CREATE TABLE `csp_table` (
  `csp_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `csp_name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `status` enum('approved','requested') NOT NULL DEFAULT 'requested'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `csp_table`
--

INSERT INTO `csp_table` (`csp_id`, `userid`, `csp_name`, `address`, `status`) VALUES
(1, 107, 'raaaa', 'aaaaa', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_type` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `user_type`) VALUES
('chechu@gmail.com', 'chechu', 2),
('raaa@gmail.com', 'raaaaa', 1),
('raash@gmail.com', '123456', 0),
('shameerchechu@gmail.com', 'chechu', 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int(10) NOT NULL,
  `name` varchar(30) NOT NULL,
  `phno` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `usertype` varchar(30) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `name`, `phno`, `email`, `password`, `usertype`, `status`) VALUES
(1, 'chechu', '9744516588', 'chechu@gmail.com', 'chechu', 'admin', 'active'),
(65, 'Shamsu', '9876543210', 'shameerchechu@gmail.com', 'chechu', 'User', 'active'),
(67, 'raashid', '6432121212', 'raash@gmail.com', '123456', 'User', 'active'),
(103, 'raashid', '9786757489', 'rash@gmail.com', 'raashid', 'CSP', 'active'),
(107, 'raaaaa', '9999999999', 'raaa@gmail.com', 'raaaaa', '1', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `csp_table`
--
ALTER TABLE `csp_table`
  ADD PRIMARY KEY (`csp_id`),
  ADD KEY `foreign key` (`userid`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `csp_table`
--
ALTER TABLE `csp_table`
  MODIFY `csp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `csp_table`
--
ALTER TABLE `csp_table`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
