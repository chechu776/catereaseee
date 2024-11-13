-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2024 at 08:55 AM
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
(2, 115, 8, 6, 'community hall', '2024-11-01', 1000, 13000.00, 130000.00, '2024-10-10 07:52:04', 'confirmed'),
(26, 115, 8, 6, 'town hall', '2024-10-31', 1, 13000.00, 130000.00, '2024-10-26 05:32:46', 'confirmed'),
(27, 115, 8, 6, 'sss', '2024-11-15', 1, 15000.00, 150000.00, '2024-11-07 04:52:23', 'pending');

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
(33, 8, 6, 1000),
(35, 8, 6, 1000),
(37, 8, 6, 1000),
(38, 8, 6, 1000),
(39, 8, 6, 1000),
(41, 8, 6, 1000),
(45, 8, 6, 1000),
(48, 8, 6, 1000),
(49, 8, 6, 1000),
(50, 8, 6, 1000),
(51, 8, 6, 1000),
(52, 8, 6, 1000),
(54, 8, 6, 1000),
(55, 8, 6, 1000),
(56, 8, 6, 1000),
(57, 8, 6, 1000);

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
(8, 119, 'B 4 Biriyani', 'kochi', 'approved', 'Non-Veg', 'images/b4.jpg'),
(11, 1011, 'chatoos catering', 'Mattancherry', 'approved', 'Non-Veg', 'images/chattoos.jpg'),
(12, 1012, 'Vijayalakshmi caters', 'Ernakulam', 'approved', 'Veg', 'images/vijaya.jpg'),
(13, 1013, 'sheetal catering', 'kaloor', 'approved', 'Veg', 'images/sheetal.webp'),
(14, 1014, 'rahumania catering', 'kochi', 'approved', 'Non-Veg', 'images/rahmania.png');

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
('chechu@gmail.com', 'chechu', 'admin'),
('manaf@gmail.com', 'manafe', 'CSP'),
('rahumania@gmail.com', 'rahumania', 'CSP'),
('shameer@gmail.com', 'shameer', 'CSP'),
('shameerchechu@gmail.com', '123456', 'User'),
('sheetal@gmail.com', 'sheetal', 'CSP'),
('vijayalakshmi@gmail.com', 'vijaya', 'CSP');

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
(6, 8, 'chicken biriyani combo', 'includes salad and pickle and icecream', 150.00, 'images/cb.jpg'),
(10, 8, 'Beef Biriyani Combo', 'includes salad , pickle , icecream', 160.00, 'images/bb.jpg'),
(11, 8, 'mutton biriyani combo', 'inlcude salad,pickle and icecream', 200.00, 'images/mb.jpg'),
(12, 11, 'chicken biriyani combo', 'includes salad, pickle and icecream', 140.00, 'images/cb.jpg'),
(13, 11, 'Beef Biriyani Combo', 'inludes salad, pickle , icecream', 150.00, 'images/bb.jpg'),
(14, 11, 'mutton biriyani combo', 'includes salad , pickle and icecream', 190.00, 'images/mb.jpg'),
(15, 12, 'Sadhya', 'includes all 26 dishes', 150.00, 'images/sadhya.jpeg'),
(16, 13, 'Sadhya', 'includes all 26 dishes', 180.00, 'images/sadhya.jpeg'),
(17, 14, 'chicken biriyani combo', 'includes salad pickle icecream', 160.00, 'images/cb.jpg'),
(18, 14, 'Beef Biriyani Combo', 'includes salad pickle icecream', 180.00, 'images/bb.jpg'),
(19, 14, 'mutton biriyani combo', 'includes salad pickle icecream', 220.00, 'images/mb.jpg');

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
(121, 'althaf', '9911223344', 'alth@gmail.com', 'althaf', 'User', 'active'),
(1000, 'chechu', '9746095567', 'chechu@gmail.com', 'chechu', 'admin', 'active'),
(1011, 'manaf', '9876789876', 'manaf@gmail.com', 'manafe', 'CSP', 'active'),
(1012, 'vijay', '9857676565', 'vijayalakshmi@gmail.com', 'vijaya', 'CSP', 'active'),
(1013, 'sheetal', '9142883747', 'sheetal@gmail.com', 'sheetal', 'CSP', 'active'),
(1014, 'afzal', '9876567890', 'rahumania@gmail.com', 'rahumania', 'CSP', 'active');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `csp_table`
--
ALTER TABLE `csp_table`
  MODIFY `csp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1015;

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
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menu` (`menu_id`) ON DELETE CASCADE;

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
