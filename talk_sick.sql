-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2024 at 03:22 PM
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
-- Database: `talk_sick`
--

-- --------------------------------------------------------

--
-- Table structure for table `donation_history`
--

CREATE TABLE `donation_history` (
  `donation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(256) NOT NULL,
  `date` datetime NOT NULL,
  `donation_amount` float NOT NULL,
  `point_earned` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donation_history`
--

INSERT INTO `donation_history` (`donation_id`, `user_id`, `name`, `date`, `donation_amount`, `point_earned`) VALUES
(1, 5, 'red', '2024-12-16 05:07:09', 1000, 10000),
(2, 4, 'yes', '2024-12-16 17:21:32', 123, 1230),
(3, 8, 'yim', '2024-12-16 17:30:39', 123, 1230),
(5, 0, 'Anonymous', '2024-12-16 10:46:22', 1, 10),
(6, 0, 'hi', '2024-12-16 11:37:11', 1, 10),
(7, 0, 'hi', '2024-12-16 12:03:53', 1, 10),
(8, 0, 'hi', '2024-12-16 12:04:42', 1, 10),
(9, 0, 'hi', '2024-12-16 12:06:39', 1, 10),
(13, 0, 'pokemon', '2024-12-16 14:02:30', 13, 130),
(16, 0, 'pokemon', '2024-12-16 14:52:15', 9999, 99990),
(17, 0, 'pokemon', '2024-12-16 15:06:55', 9999, 99990),
(18, 0, 'Anonymous', '2024-12-16 15:07:55', 9999, 99990),
(19, 17, 'pikachu', '2024-12-16 22:09:20', 9999, 99990);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_description` varchar(1000) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_image` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_description`, `product_price`, `product_image`) VALUES
(1, 'TalkSick T-shirt', 'This comfortable and stylish shirt is made from high-quality organic cotton and features our iconic TalkSick logo. By wearing this T-shirt, you express your support for sustainable communities and contribute to TalkSick\'s mission of building a better future. It\'s not just a piece of clothing; it\'s a statement of your dedication to sustainable cities and communities!', 1000, 'images/TalkSick_Shirt.jpg'),
(2, 'TalkSick Hat', 'Shade yourself in style while promoting a greener future with the Talk Sick Hat. Crafted from eco-friendly materials,the embroidered Talk Sick logo adds a touch of uniqueness, showcasing your support for our mission to create safe, resilient, and sustainable communities. Wear it proudly and be a part of the positive change we\'re building together!', 500, 'images/TalkSick_Hat.jpg'),
(3, 'TalkSick Wrist Band', 'Promote your commitment to food health with the TalkSick Wrist Band. This durable and stylish band is made from eco-friendly materials and features the TalkSick logo, representing your dedication to healthier eating habits. Wear it as a daily reminder and become an ambassador for positive conversations about nutrition and wellness!', 2500, 'images/TalkSick_WristBand.jpg'),
(4, 'TalkSick Keychain', 'Carry your commitment to food health everywhere you go with the TalkSick Keychain. Made from eco-friendly materials, this stylish keychain features the TalkSick logo, representing your dedication to healthier eating habits. Attach it to your keys as a daily reminder and become an ambassador for positive conversations about nutrition and wellness!', 2000, 'images/TalkSick_Keychain.jpg'),
(5, 'TalkSick Mug', 'Sip your way to better health with the TalkSick Mug. Made from eco-friendly materials, this stylish mug features the TalkSick logo, symbolizing your commitment to healthier eating habits. Use it for your daily beverages and become an ambassador for positive conversations about nutrition and wellness!', 3000, 'images/TalkSick_Mug.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(100) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `zip` varchar(5) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `current_point` int(11) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `first_name`, `last_name`, `address`, `zip`, `city`, `state`, `country`, `current_point`, `is_admin`) VALUES
(0, 'NULL', 'NULL', 'NULL', 'Null', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 0, 0),
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin@gmail.com', 'jonas', 'ho', 'somewhere', '88450', 'ereth', 'overhere', 'Malaysia', 0, 1),
(4, 'yes', 'a6105c0a611b41b08f1209506350279e', 'yes@123.com', 'yes', 'yes', 'yes', '47199', 'yes', 'yes', 'yes', 1230, 0),
(5, 'red', 'bda9643ac6601722a28f238714274da4', 'red@gmail.com', 'red', 'red', 'red', '12345', 'city', 'state', 'cont', 8000, 1),
(6, 'red1', 'bda9643ac6601722a28f238714274da4', 'red@gmail.com', 'red', 'red', 'red', '12345', 'city', 'state', 'cont', 0, 0),
(8, 'yim', 'b267562f4175e137ab7ae4b9465e3314', 'yim@live.com', 'yim', 'yim', 'yim', '88450', 'yim', 'yim', 'yim', 1230, 0),
(15, 'testing', '098f6bcd4621d373cade4e832627b4f6', 'money@gmail.com', 'test', 'test', 'test', '84450', 'test', 'test', 'test', 50000, 0),
(17, 'pikachu', '202cb962ac59075b964b07152d234b70', 'pikachu@gmail.com', 'test', 'chu', 'test', '84450', 'test', 'test', 'Malaysia', 97490, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD PRIMARY KEY (`donation_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donation_history`
--
ALTER TABLE `donation_history`
  MODIFY `donation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `donation_history`
--
ALTER TABLE `donation_history`
  ADD CONSTRAINT `donation_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
