-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 14, 2024 at 03:26 PM
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
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `csp_id` int(11) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `venue` varchar(255) NOT NULL,
  `event_date` date NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `advance_payment` decimal(10,2) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('confirmed','pending','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `csp_id`, `menu_id`, `venue`, `event_date`, `quantity`, `advance_payment`, `total_price`, `created_at`, `status`) VALUES
(2, 115, 8, NULL, 'community hall', '2024-11-01', 1000, 13000.00, 130000.00, '2024-10-10 07:52:04', 'confirmed'),
(21, 115, 8, NULL, 'town hall', '2024-10-19', 1, 130.00, 1300.00, '2024-10-11 16:59:39', 'pending');

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
(33, 8, 6, 10),
(34, 8, 7, 20),
(35, 8, 6, 10),
(36, 8, 7, 20),
(37, 8, 6, 10),
(38, 8, 6, 10),
(39, 8, 6, 10),
(40, 8, 7, 20),
(41, 8, 6, 10),
(42, 9, 8, 4),
(43, 9, 8, 4),
(44, 9, 8, 3),
(45, 8, 6, 10),
(46, 8, 7, 20),
(47, 10, 9, 1),
(48, 8, 6, 10);

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
(8, 119, 'shameers kitchen', 'kochi', 'approved', 'Non-Veg', 'images/b4.jpg'),
(9, 120, 'chatoos catering', '', 'approved', 'Non-Veg', 'images/starcatering.jpg'),
(10, 122, 'chatoos catering', 'kochi', 'approved', 'Non-Veg', 'images/sheetal.webp');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `role` enum('User','CSP') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `name`, `message`, `role`, `created_at`) VALUES
(9, 'shameer', 'adsfvf', 'CSP', '2024-10-10 05:45:03'),
(11, 'shamsu', 'ascdvbf', 'User', '2024-10-10 05:46:29'),
(12, 'manaf', 'hasvuhksacca', 'User', '2024-10-11 15:13:49');

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
('alth@gmail.com', 'althaf', 'User'),
('d@gmail.com', '123456', 'CSP'),
('manaf@gmail.com', 'manaf7', 'CSP'),
('shameer@gmail.com', 'shameer', 'CSP'),
('shameerchechu@gmail.com', '123456', 'User');

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
(6, 8, 'chicken biriyani', 'yummy', 130.00, 'images/cb.jpg'),
(7, 8, 'broasted chicken', 'asdxcfvgbhnjkl', 100.00, 'images/broast.jpg'),
(8, 9, 'chicken biriyani', 'kochis best cb', 140.00, 'images/cb.jpg'),
(9, 10, 'biriyani', 'safdgfhj', 100.00, 'images/bb.jpg');

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
(115, 'Shamsu', '9876543210', 'shameerchechu@gmail.com', '123456', 'User', 'active'),
(119, 'shameer', '9744516588', 'shameer@gmail.com', 'shameer', 'CSP', 'active'),
(120, 'manaf', '9988776655', 'manaf@gmail.com', 'manaf7', 'CSP', 'active'),
(121, 'althaf', '9911223344', 'alth@gmail.com', 'althaf', 'User', 'active'),
(122, 'werwgtyhft', '9987743728', 'd@gmail.com', '123456', 'CSP', 'active');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `csp_id` (`csp_id`),
  ADD KEY `user_id` (`user_id`);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

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
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `csp_table`
--
ALTER TABLE `csp_table`
  MODIFY `csp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`csp_id`) REFERENCES `csp_table` (`csp_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`userid`);

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
