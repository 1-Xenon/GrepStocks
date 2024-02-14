-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: grepstock
-- Generation Time: Jan 19, 2024 at 05:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grepstocks`
--
CREATE DATABASE IF NOT EXISTS `grepstocks` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `grepstocks`;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `adminID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`adminID`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$st.psOK8BZccJgaYseHNmeh8ofwFXzLc0ZMua0m.XMdSralB1/ZiC'),
(2, 'admin1', '$2y$10$A3Q9d.P9eNtsAI5AyNnA..yY8S0Oe2BVLGNLn5H5BlOBpCKVgh4Se');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartItemID` int(11) NOT NULL,
  `cartID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productBrand` varchar(255) NOT NULL,
  `productQuantity` int(11) NOT NULL,
  `productColour` varchar(255) NOT NULL,
  `productPrice` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`cartItemID`, `cartID`, `userID`, `productID`, `productName`, `productBrand`, `productQuantity`, `productColour`, `productPrice`) VALUES
(57, 1, 5, 2, 'Ear Piece', 'Apple', 4, 'Black', 14.99);

-- --------------------------------------------------------

--
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `productID` int(11) NOT NULL,
  `inventoryStock` int(11) NOT NULL,
  `currentStock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`productID`, `inventoryStock`, `currentStock`) VALUES
(1, 10, 5),
(2, 10, 10),
(3, 10, 10),
(4, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `cartID` int(11) NOT NULL,
  `totalPrice` double NOT NULL,
  `markAsComplete` int(11) NOT NULL,
  `datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `cartID`, `totalPrice`, `markAsComplete`, `datetime`) VALUES
(1, 1, 80, 1, '2024-01-18 20:50:45'),
(2, 1, 189.94, 1, '2024-01-18 20:52:57'),
(3, 1, 74.95, 1, '2024-01-18 20:56:01'),
(4, 1, 164.89000000000001, 1, '2024-01-18 20:57:41'),
(5, 1, 59.96, 1, '2024-01-18 21:00:38'),
(6, 1, 180, 1, '2024-01-18 21:02:53'),
(7, 1, 164.89, 1, '2024-01-18 21:04:34'),
(8, 1, 164.89, 1, '2024-01-18 21:05:54'),
(9, 1, 149.9, 1, '2024-01-18 21:19:56'),
(10, 1, 134.91, 1, '2024-01-18 21:28:32'),
(11, 1, 0, 1, '2024-01-18 21:28:36'),
(12, 1, 89.94, 1, '2024-01-18 21:28:45'),
(13, 1, 0, 1, '2024-01-18 21:28:51'),
(14, 1, 0, 1, '2024-01-18 21:35:10'),
(15, 1, 74.95, 1, '2024-01-18 21:39:52'),
(16, 1, 44.97, 1, '2024-01-18 21:39:59'),
(17, 16, 80, 1, '2024-01-19 14:16:04'),
(18, 16, 0, 1, '2024-01-19 15:23:26'),
(19, 16, 0, 1, '2024-01-19 15:23:57'),
(20, 16, 0, 1, '2024-01-19 15:24:11'),
(21, 16, 0, 1, '2024-01-19 15:29:26'),
(22, 22, 22, 1, '0000-00-00 00:00:00'),
(23, 16, 0, 1, '2024-01-19 16:22:54'),
(24, 16, 20, 1, '2024-01-19 16:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `pictures`
--

CREATE TABLE `pictures` (
  `pictureID` int(11) NOT NULL,
  `picturePath` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pictures`
--

INSERT INTO `pictures` (`pictureID`, `picturePath`) VALUES
(1, 'data:image/jpeg;base64,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3dkG3MhevGtAAAFgMAOS5r0LakmihNVO0ioqGizSLOihzDTwc42c4brNGYK6WsgiIgIiKAiIqCIiAiIgIiICIiAsdpzQVNWR9VUwslZu2hi0kWuxwxY7mCCsiiDiGtXQe4Xfo+baGfUzGxHJkowO4AOA5uK5RpnQtTSP2KmF8Lt222wd+F3ovHNpK9jKCso45mGOWNkjHZse0Oae9pwKUeMVUHL0Zp/oZ0dPd0O3TON/3Z2o7/8ALfew5NLVoGluhGvjJMEsM7d2Jhef5XXb/UrRzRstvy3eSrDmniO7EeR/VZrSGo2k4P3lDP3sZ1o96LaCwdRA6M2eCx3suBa7yOKCvYHEedvnZOpPA+GPyVsJefxVQmvvv8SgmMLuB8lRscSB43+SzGjNUdI1BHU0U7r+sYyxvvvs34re9X+g+rkIdWTMgbhdjPtZOYJwY3vBd3JRy6GMvcGRtdI9xs1rWklxOQDRi4ruHRh0UmFzavSDQZBZ0UGBEZzD5NxeNzRgM8TlvmqepFFo4f6vF27WdM/tyu49v1QbZNAHJbGpQREUBERUERFAREVBERAREQEREBERAREQEREBERAVL2A4EAjmLqpEFo7RkBzhj/y2/kp4qdjfRY1vc0D5KREBERAREQEREBERAREUBERUEREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBERQERFQREQEREBERAREQEREBERAREQEREBERAREQEREBERAREQf/2Q=='),
(2, 'data:image/png;base64,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'),
(3, 'data:image/jpeg;base64,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'),
(4, 'data:image/jpeg;base64,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');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` int(11) NOT NULL,
  `productName` varchar(255) NOT NULL,
  `productDescription` text NOT NULL,
  `productPrice` double NOT NULL,
  `currentStock` int(11) NOT NULL,
  `productPictureID` int(11) NOT NULL,
  `productBrand` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `productName`, `productDescription`, `productPrice`, `currentStock`, `productPictureID`, `productBrand`) VALUES
(1, 'Office Mouse', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 20, 1, 1, 'Logitech'),
(2, 'Ear Piece', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 14.99, 1, 2, 'Apple'),
(3, 'Power Bank', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 25, 1, 3, 'Xiao Mi'),
(4, 'Mouse Pad', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 9.99, 1, 4, 'Logitech');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `reviewID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `review` text NOT NULL,
  `reviewRating` int(11) NOT NULL,
  `reviewDateTime` datetime NOT NULL,
  `reviewEditTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `username`, `password`, `email`) VALUES
(1, 'staff', '$2y$10$YYaCmUdKzwae1S8hVjxi9OBZid2dTEMzWjqmkBPPH5u79Hol7VEt2', 'staff@gmaill.com');

-- --------------------------------------------------------

--
-- Table structure for table `userlog`
--

CREATE TABLE `userlog` (
  `username` varchar(255) NOT NULL,
  `time` datetime NOT NULL,
  `description` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userlog`
--

INSERT INTO `userlog` (`username`, `time`, `description`) VALUES
('nicholas1', '2024-01-19 00:47:56', 'Registration'),
('nicholas1', '2024-01-19 00:48:34', 'Login time'),
('nicholas1', '2024-01-19 14:09:07', 'Login time'),
('nicholas1', '2024-01-19 14:15:23', 'Logout time'),
('nicholas1', '2024-01-19 14:15:43', 'Login time'),
('nicholas1', '2024-01-19 14:19:08', 'Logout time'),
('nicholas1', '2024-01-19 15:07:17', 'Login time'),
('nicholas1', '2024-01-19 15:10:15', 'Logout time'),
('nicholas1', '2024-01-19 15:10:41', 'Login time'),
('nicholas1', '2024-01-19 15:12:15', 'Logout time'),
('nicholas1', '2024-01-19 15:14:28', 'Login time'),
('nicholas1', '2024-01-19 15:20:04', 'Logout time'),
('nicholas1', '2024-01-19 15:22:07', 'Login time'),
('nicholas1', '2024-01-19 15:36:02', 'Logout time'),
('nicholas1', '2024-01-19 15:38:08', 'Login time'),
('staff', '2024-01-19 16:20:08', 'Logout time'),
('nicholas1', '2024-01-19 16:20:39', 'Login time'),
('nicholas1', '2024-01-19 16:29:32', 'Logout time'),
('nicholas1', '2024-01-19 17:06:07', 'Login time'),
('nicholas1', '2024-01-19 17:06:24', 'Changed Password'),
('nicholas1', '2024-01-19 17:07:28', 'Logout time'),
('test', '2024-01-19 17:08:40', 'Registration'),
('test', '2024-01-19 17:10:04', 'Logout time'),
('2202735c1231231', '2024-01-19 23:31:32', 'Registration'),
('2202735csdfvbgnhn', '2024-01-19 23:31:50', 'Registration'),
('2202735cmkmkmkmkm', '2024-01-19 23:32:10', 'Registration');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(512) NOT NULL,
  `password` longtext NOT NULL,
  `profilepicture` mediumtext DEFAULT NULL,
  `secretKey` varchar(1024) NOT NULL,
  `cartID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password`, `profilepicture`, `secretKey`, `cartID`) VALUES
(1, 'nicholas', 'hylovesnoah@gmail.com', '$2y$10$YEozVr5kOwUGSGHesmirjebY6N4MtKLCOb6u4iui2PLCvuBHmuYi2', 'pictures/Screenshot_20221110_113722.png', 'EGUQXEZ5FV7IIGGTIKV442JSYIXUSVVA7ZKQNNYIFFKFNSA57IFTGAHBKKXK5PZU5HHGFWOGXN3NKJZ3F5UFKXS4L3ZFUSSPIZJOK2I', 1),
(9, 'test123', 'n@2.com', '$2y$10$6eaXkSxbKpHVB17HnwyJAORt846SNQEKKaY0p/0qwzJ37A0GSH8uG', NULL, '', NULL),
(11, 'nicholas1', 'hpng135@gmail.com', '$2y$10$/BfDZUykFtQZTgLrm7z4mOX9NOnqd1OFknOAh2zgQGwN4FjO44kIW', 'profilePictures/LOA.jpg', '3U45YJPU2MVJ3VMDHMKJ6Z2ZUBOOZ72FGY3Y2PNMBXZJICDIK7TLCP5MHD54N7XAAFJJMGJOUNQUEMIIQZCXZQOA3JMVPJBOK6TCBII', 16),
(13, '2202735c1231231', 'hpng135@gmail.com1233', '$2y$10$mV6My.5yXnewOxl3elN2tuwgntwKuuxlqgsbRwdYqTqSG3u8GqFva', 'profilePictures/LOA.jpg', '', 51),
(14, '2202735csdfvbgnhn', '1234@3F83097A.OZZ', '$2y$10$MAicL8r/UZGk.lpIIQ7oc.P/TV3mjN.Ypm5KlJZNoHmBu1LMQrEBa', 'profilePictures/LOA.jpg', '', 53),
(15, '2202735cmkmkmkmkm', 'hpng134@gmail.commklnnjjno', '$2y$10$VgzJjEYVN4nZiP7l.MAR2uLq5zBxkUMkKEv0LXmTECc8tYPktfypG', 'profilePictures/LOA.jpg', '', 32);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartItemID`);

--
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `inventoryID` (`productID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`);

--
-- Indexes for table `pictures`
--
ALTER TABLE `pictures`
  ADD PRIMARY KEY (`pictureID`),
  ADD UNIQUE KEY `picturePath` (`picturePath`) USING HASH;

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productID`),
  ADD UNIQUE KEY `productPictureID` (`productPictureID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`reviewID`),
  ADD KEY `productID` (`productID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `email_UNIQUE` (`email`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartItemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `pictures`
--
ALTER TABLE `pictures`
  MODIFY `pictureID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `reviewID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`productPictureID`) REFERENCES `pictures` (`pictureID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
