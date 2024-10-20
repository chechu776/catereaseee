-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 07, 2024 at 06:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `csp_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `csp_id`, `menu_id`, `quantity`) VALUES
(1, 7, 5, 15),
(2, 7, 4, 11);

-- --------------------------------------------------------

--
-- Table structure for table `csp_table`
--

CREATE TABLE `csp_table` (
  `csp_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `csp_name` varchar(100) NOT NULL,
  `location` varchar(200) NOT NULL,
  `status` enum('approved','requested') NOT NULL DEFAULT 'requested',
  `category` varchar(20) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `csp_table`
--

INSERT INTO `csp_table` (`csp_id`, `userid`, `csp_name`, `location`, `status`, `category`, `logo`) VALUES
(5, 111, 'aadhils kitchen', 'edappally', 'approved', 'Veg', 'images/b4.jpg'),
(7, 113, 'hagshs', 'joich', 'approved', 'Non-Veg', 'images/allstarcatering.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(50) NOT NULL,
  `password` varchar(30) NOT NULL,
  `user_type` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `user_type`) VALUES
('aadhil@gmail.com', 'aadhil', 'CSP'),
('chechu@gmail.com', 'chechu', '2'),
('jihad@gmail.com', '123456', 'CSP'),
('raaa@gmail.com', 'raaaaa', '1'),
('raash@gmail.com', '123456', '0'),
('shameerchechu@gmail.com', 'chechu', '0');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `csp_id` int(11) NOT NULL,
  `menu_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `csp_id`, `menu_name`, `description`, `price`, `image`) VALUES
(4, 7, 'mutton biriyani', 'asdfghjklkjnhbvcxzxcfvbn', 150.00, 'images/mb.jpg'),
(5, 5, 'kizhiporota', 'asdfghjkl;.,mngfdxcvb', 120.00, 'images/broast.jpg');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `name`, `phno`, `email`, `password`, `usertype`, `status`) VALUES
(1, 'chechu', '9744516588', 'chechu@gmail.com', 'chechu', 'admin', 'active'),
(65, 'Shamsu', '9876543210', 'shameerchechu@gmail.com', 'chechu', 'User', 'active'),
(67, 'raashid', '6432121212', 'raash@gmail.com', '123456', 'User', 'active'),
(103, 'raashid', '9786757489', 'rash@gmail.com', 'raashid', 'CSP', 'active'),
(111, 'aadhil', '7726425600', 'aadhil@gmail.com', 'aadhil', 'CSP', 'active'),
(113, 'jihad ', '9634567867', 'jihad@gmail.com', '123456', 'CSP', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `csp_id` (`csp_id`),
  ADD KEY `menu_id` (`menu_id`);

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
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`),
  ADD KEY `csp_id` (`csp_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `csp_table`
--
ALTER TABLE `csp_table`
  MODIFY `csp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`csp_id`) REFERENCES `csp_table` (`csp_id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`);

--
-- Constraints for table `csp_table`
--
ALTER TABLE `csp_table`
  ADD CONSTRAINT `foreign key` FOREIGN KEY (`userid`) REFERENCES `user` (`userid`);

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`csp_id`) REFERENCES `csp_table` (`csp_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;