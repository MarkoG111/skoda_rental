-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2025 at 11:03 AM
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
-- Database: `skoda_rent`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `status` tinyint(1) NOT NULL,
  `requested_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `user_id`, `car_id`, `date_from`, `date_to`, `status`, `requested_at`) VALUES
(1, 3, 3, '2024-01-27', '2024-01-30', 1, '2024-01-26 22:01:50'),
(2, 3, 1, '2024-01-30', '2024-01-31', 1, '2024-01-28 16:09:53'),
(3, 4, 2, '2024-01-28', '2024-01-30', 2, '2024-01-28 19:08:02'),
(4, 4, 5, '2024-01-28', '2024-01-30', 2, '2024-01-28 19:08:13');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `main_image` varchar(255) NOT NULL,
  `model_year` int(11) NOT NULL,
  `mileage` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `doors` int(11) NOT NULL,
  `luggage` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `transmission_id` int(11) NOT NULL,
  `fuel_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `name`, `description`, `main_image`, `model_year`, `mileage`, `seats`, `doors`, `luggage`, `category_id`, `transmission_id`, `fuel_id`, `created_at`) VALUES
(1, 'Skoda Fabia 1.0 TSI ', 'TSI new model\r\n                      ', '/Fabia.jpg', 2014, 224255, 4, 3, 2, 2, 2, 2, '2024-01-26 18:50:13'),
(2, 'Skoda Karoq 2.0 TDI ', 'SUV Jeep 2.0\r\n                      ', '/Karoq.jpg', 2019, 121000, 6, 6, 2, 3, 1, 1, '2024-01-26 19:15:21'),
(3, 'Skoda Kodiaq 2.0', 'TDI DSG 4X4 SL\r\n                      ', '/Kodiaq.jpg', 2018, 164221, 5, 5, 1, 3, 1, 1, '2024-01-26 19:16:51'),
(4, 'Skoda Octavia 1.6', 'TDI 85/116 (kW/KS)\r\n                      ', '/Octavia.jpg', 2011, 310215, 5, 4, 1, 6, 2, 3, '2024-01-26 19:17:53'),
(5, 'Skoda Rapid 1.0', 'TSI 81/110 (kW/KS)\r\n                      ', '/Rapid1.jpg', 2012, 244199, 5, 5, 3, 4, 2, 2, '2024-01-26 19:19:07'),
(9, 'Skoda Octavia 2.0', 'Red Skoda Octavia Caravan\r\n                      ', '/OctaviaC.jpg', 2013, 198442, 5, 5, 1, 1, 2, 2, '2024-01-31 17:43:14'),
(10, 'Skoda Superb 2.0 TDI', '2.0 TDI DSG Newest model\r\n                      ', '/Superb.jpg', 2023, 45051, 5, 5, 1, 4, 1, 1, '2024-01-31 17:45:20');

-- --------------------------------------------------------

--
-- Table structure for table `car_features`
--

CREATE TABLE `car_features` (
  `car_feature_id` int(11) NOT NULL,
  `feature_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `feature_value` tinyint(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `car_features`
--

INSERT INTO `car_features` (`car_feature_id`, `feature_id`, `car_id`, `feature_value`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 4, 1, 1),
(5, 5, 1, 1),
(6, 6, 1, 0),
(7, 7, 1, 1),
(8, 8, 1, 1),
(9, 9, 1, 1),
(10, 10, 1, 0),
(11, 11, 1, 0),
(12, 12, 1, 0),
(13, 1, 2, 1),
(14, 2, 2, 1),
(15, 3, 2, 1),
(16, 4, 2, 1),
(17, 5, 2, 1),
(18, 6, 2, 1),
(19, 7, 2, 1),
(20, 8, 2, 0),
(21, 9, 2, 1),
(22, 10, 2, 1),
(23, 11, 2, 1),
(24, 12, 2, 1),
(25, 1, 3, 1),
(26, 2, 3, 1),
(27, 3, 3, 0),
(28, 4, 3, 1),
(29, 5, 3, 1),
(30, 6, 3, 1),
(31, 7, 3, 1),
(32, 8, 3, 0),
(33, 9, 3, 1),
(34, 10, 3, 0),
(35, 11, 3, 0),
(36, 12, 3, 1),
(37, 1, 4, 1),
(38, 2, 4, 1),
(39, 3, 4, 1),
(40, 4, 4, 1),
(41, 5, 4, 1),
(42, 6, 4, 1),
(43, 7, 4, 1),
(44, 8, 4, 0),
(45, 9, 4, 1),
(46, 10, 4, 0),
(47, 11, 4, 1),
(48, 12, 4, 1),
(49, 1, 5, 1),
(50, 2, 5, 1),
(51, 3, 5, 1),
(52, 4, 5, 1),
(53, 5, 5, 1),
(54, 6, 5, 1),
(55, 7, 5, 1),
(56, 8, 5, 0),
(57, 9, 5, 1),
(58, 10, 5, 1),
(59, 11, 5, 1),
(60, 12, 5, 1),
(97, 1, 9, 1),
(98, 2, 9, 1),
(99, 3, 9, 1),
(100, 4, 9, 1),
(101, 5, 9, 0),
(102, 6, 9, 0),
(103, 7, 9, 1),
(104, 8, 9, 1),
(105, 9, 9, 1),
(106, 10, 9, 0),
(107, 11, 9, 0),
(108, 12, 9, 0),
(109, 1, 10, 1),
(110, 2, 10, 1),
(111, 3, 10, 1),
(112, 4, 10, 1),
(113, 5, 10, 1),
(114, 6, 10, 0),
(115, 7, 10, 1),
(116, 8, 10, 1),
(117, 9, 10, 1),
(118, 10, 10, 0),
(119, 11, 10, 1),
(120, 12, 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Caravan'),
(2, 'Hatchback'),
(3, 'SUV'),
(4, 'Limousin'),
(5, 'Coupe'),
(6, 'Sedan');

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

CREATE TABLE `features` (
  `feature_id` int(11) NOT NULL,
  `feature_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`feature_id`, `feature_name`) VALUES
(1, 'Airconditions'),
(2, 'AntiLock Breaking System'),
(3, 'Leather Seats'),
(4, 'Brake Assist'),
(5, 'Crash Sensor'),
(6, 'Onboard computer'),
(7, 'GPS'),
(8, 'Central Locking'),
(9, 'ABS'),
(10, 'Bluetooth'),
(11, 'Child Seat'),
(12, 'Parking Sensors');

-- --------------------------------------------------------

--
-- Table structure for table `fuels`
--

CREATE TABLE `fuels` (
  `fuel_id` int(11) NOT NULL,
  `fuel_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fuels`
--

INSERT INTO `fuels` (`fuel_id`, `fuel_type`) VALUES
(1, 'Diesel'),
(2, 'Petrol'),
(3, 'Gas');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `image_id` int(11) NOT NULL,
  `image_name` varchar(255) NOT NULL,
  `car_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`image_id`, `image_name`, `car_id`) VALUES
(1, '/Fabia2.jpg', 1),
(2, '/Fabia3.jpg', 1),
(3, '/Karoq2.jpg', 2),
(4, '/Karoq3.jpg', 2),
(5, '/Kodiaq2.jpg', 3),
(6, '/Kodiaq3.jpg', 3),
(7, '/Octavia2.jpg', 4),
(8, '/Octavia3.jpg', 4),
(9, '/Rapid2.jpg', 5),
(10, '/Rapid3.jpg', 5),
(49, '/OctaviaC2.jpg', 9),
(50, '/OctaviaC3.jpg', 9),
(51, '/Superb2.jpg', 10),
(52, '/Superb3.jpg', 10);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_id` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `href` varchar(255) NOT NULL,
  `priority` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `text`, `href`, `priority`) VALUES
(1, 'Admin', 'admin', 3),
(2, 'User', 'user', 2),
(3, 'Home', 'home', 1),
(4, 'Cars', 'cars', 1),
(5, 'About', 'about', 1),
(6, 'Contact', 'contact', 1);

-- --------------------------------------------------------

--
-- Table structure for table `prices`
--

CREATE TABLE `prices` (
  `price_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `price_per_day` decimal(10,0) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`price_id`, `car_id`, `price_per_day`, `date`) VALUES
(1, 1, 21, '2024-01-26 18:50:13'),
(2, 1, 21, '2024-01-26 18:52:39'),
(3, 1, 21, '2024-01-26 18:53:33'),
(4, 2, 50, '2024-01-26 19:15:21'),
(5, 3, 44, '2024-01-26 19:16:51'),
(6, 4, 19, '2024-01-26 19:17:53'),
(7, 5, 35, '2024-01-26 19:19:07'),
(8, 5, 35, '2024-01-26 22:03:22'),
(9, 5, 35, '2024-01-26 22:03:30'),
(10, 2, 50, '2024-01-26 22:06:36'),
(11, 5, 35, '2024-01-26 22:07:45'),
(12, 5, 35, '2024-01-26 22:08:41'),
(13, 5, 35, '2024-01-26 22:14:18'),
(14, 5, 35, '2024-01-26 22:14:30'),
(15, 5, 35, '2024-01-26 22:14:34'),
(16, 5, 35, '2024-01-26 22:14:56'),
(17, 5, 35, '2024-01-26 22:15:01'),
(18, 5, 35, '2024-01-26 22:15:06'),
(19, 5, 35, '2024-01-26 22:18:04'),
(20, 5, 35, '2024-01-26 22:18:55'),
(21, 5, 35, '2024-01-26 22:18:59'),
(22, 5, 35, '2024-01-26 22:18:59'),
(23, 5, 35, '2024-01-26 22:18:59'),
(24, 5, 35, '2024-01-26 22:18:59'),
(25, 5, 35, '2024-01-26 22:22:17'),
(26, 5, 35, '2024-01-26 22:23:03'),
(27, 1, 21, '2024-01-26 22:40:51'),
(28, 5, 35, '2024-01-26 22:42:16'),
(29, 5, 35, '2024-01-26 22:43:35'),
(30, 5, 35, '2024-01-26 22:43:40'),
(31, 5, 35, '2024-01-26 22:43:53'),
(32, 5, 35, '2024-01-26 22:44:00'),
(33, 5, 35, '2024-01-26 22:45:01'),
(34, 5, 35, '2024-01-26 22:45:39'),
(35, 5, 35, '2024-01-26 22:45:52'),
(36, 5, 35, '2024-01-26 22:46:49'),
(37, 5, 35, '2024-01-26 22:47:03'),
(38, 5, 35, '2024-01-26 22:50:10'),
(39, 5, 35, '2024-01-26 22:50:45'),
(40, 5, 35, '2024-01-26 22:51:37'),
(41, 5, 35, '2024-01-26 22:52:28'),
(42, 5, 35, '2024-01-26 23:02:45'),
(43, 5, 35, '2024-01-26 23:03:32'),
(44, 5, 35, '2024-01-26 23:20:42'),
(88, 9, 21, '2024-01-31 17:43:14'),
(89, 9, 21, '2024-01-31 17:43:24'),
(90, 9, 21, '2024-01-31 17:43:30'),
(91, 10, 56, '2024-01-31 17:45:20'),
(92, 10, 56, '2024-01-31 17:45:42'),
(93, 10, 56, '2024-01-31 17:49:48');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `review_text` text NOT NULL,
  `review_status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `user_id`, `car_id`, `review_text`, `review_status`) VALUES
(5, 4, 5, 'asfasfasv sdv sdvsdv sdv', 1),
(7, 3, 3, 'Dobar auto posteno! VVV', 0);

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Table structure for table `transmissions`
--

CREATE TABLE `transmissions` (
  `transmission_id` int(11) NOT NULL,
  `transmission_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transmissions`
--

INSERT INTO `transmissions` (`transmission_id`, `transmission_type`) VALUES
(1, 'Automatic'),
(2, 'Manual');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `licence_number` varchar(255) NOT NULL,
  `years_of_experience` tinyint(4) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `city`, `address`, `phone`, `licence_number`, `years_of_experience`, `role_id`, `created_at`) VALUES
(2, 'Marko', 'Gačanović', 'markogacanovic111@gmail.com', 'd55b6a09d86d3079bb956c9a3f95490f', 'Belgrade', 'Bore Prodanovića 19', '069/330-7997', 'F255-931-50-331-0', 2, 1, '2024-01-01 13:01:06'),
(3, 'Jovan', 'Jovanovic', 'jovan@gmail.com', '0571b4dbea34085bf577afbcc5db43aa', 'Belgrade', 'Takovska 11', '063/821-3133', 'F255-931-50-331-2', 2, 2, '2024-01-18 21:36:48'),
(4, 'Sofija', 'Jovanovic', 'sofija@gmail.com', 'd5b23b8f546d97f17a074a66dbd085f3', 'Belgrade', 'Bore Prodanovića 19', '069/330-7997', 'F255-931-50-331-0', 3, 2, '2024-01-24 16:02:13'),
(5, 'Marko', 'Gačanović', 'testadmin@gmail.com', 'd55b6a09d86d3079bb956c9a3f95490f', 'Belgrade', 'Bore Prodanovića 19', '069/330-7997', 'F255-555-50-331-0', 3, 1, '2025-10-15 10:54:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `transmission_id` (`transmission_id`),
  ADD KEY `fuel_id` (`fuel_id`);

--
-- Indexes for table `car_features`
--
ALTER TABLE `car_features`
  ADD PRIMARY KEY (`car_feature_id`),
  ADD KEY `feature_id` (`feature_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Indexes for table `fuels`
--
ALTER TABLE `fuels`
  ADD PRIMARY KEY (`fuel_id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`image_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `prices`
--
ALTER TABLE `prices`
  ADD PRIMARY KEY (`price_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `transmissions`
--
ALTER TABLE `transmissions`
  ADD PRIMARY KEY (`transmission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `car_features`
--
ALTER TABLE `car_features`
  MODIFY `car_feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `fuels`
--
ALTER TABLE `fuels`
  MODIFY `fuel_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `prices`
--
ALTER TABLE `prices`
  MODIFY `price_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transmissions`
--
ALTER TABLE `transmissions`
  MODIFY `transmission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_3` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`),
  ADD CONSTRAINT `cars_ibfk_2` FOREIGN KEY (`transmission_id`) REFERENCES `transmissions` (`transmission_id`),
  ADD CONSTRAINT `cars_ibfk_3` FOREIGN KEY (`fuel_id`) REFERENCES `fuels` (`fuel_id`);

--
-- Constraints for table `car_features`
--
ALTER TABLE `car_features`
  ADD CONSTRAINT `car_features_ibfk_1` FOREIGN KEY (`feature_id`) REFERENCES `features` (`feature_id`),
  ADD CONSTRAINT `car_features_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `prices`
--
ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
