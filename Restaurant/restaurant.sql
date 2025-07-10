-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 09, 2025 at 04:27 PM
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
-- Database: `restaurant`
--

-- --------------------------------------------------------

--
-- Table structure for table `card`
--

CREATE TABLE `card` (
  `username` varchar(20) NOT NULL,
  `itemid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryId` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `photo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryId`, `name`, `photo`) VALUES
(1, 'Food', 'food/friedchicken.jpg'),
(2, 'Drinks', 'drink/whiskey.jpg'),
(3, 'Desert', 'sweet/baklawa.jpg'),
(4, 'Pizza', 'food/pizza.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `username` varchar(40) NOT NULL,
  `orderid` int(11) NOT NULL,
  `statuss` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`username`, `orderid`, `statuss`) VALUES
('hisho_tl', 112, 1),
('hisho_tl', 114, 1),
('hisho_tl', 118, 1),
('weso-123', 113, 1),
('weso-123', 115, 1),
('weso-123', 116, 1);

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `itemID` int(11) NOT NULL,
  `name` varchar(20) NOT NULL,
  `categoryID` int(20) NOT NULL,
  `price` int(11) NOT NULL,
  `remainQuantity` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`itemID`, `name`, `categoryID`, `price`, `remainQuantity`, `photo`) VALUES
(30, 'appetizer', 1, 200000, 10, 'food/appetizer.jpg'),
(31, 'burger', 1, 150000, 15, 'food/burger.jpg'),
(32, 'burritos', 1, 300000, 15, 'food/burritos.jpg'),
(33, 'friedchicken', 1, 900000, 3, 'food/friedchicken.jpg'),
(34, 'pasta', 1, 400000, 17, 'food/pasta.jpg'),
(35, 'pizza', 1, 1200000, 12, 'food/pizza.jpg'),
(36, 'seafood', 1, 800000, 2, 'food/seafood.jpg'),
(38, 'sushi', 1, 1550000, 20, 'food/sushi.jpg'),
(39, 'tacos', 1, 500000, 4, 'food/tacos.jpg'),
(40, 'boomboom', 2, 150000, 15, 'drink/boomboom.jpg'),
(41, 'cocktail', 2, 250000, 10, 'drink/cocktail.jpg'),
(42, 'orange', 2, 80000, 11, 'drink/orange.jpg'),
(43, 'pepsi', 2, 50000, 29, 'drink/pepsi.jpg'),
(44, 'whiskey', 2, 450000, 7, 'drink/whiskey.jpg'),
(45, 'baklawa', 3, 660000, 9, 'sweet/baklawa.jpg'),
(46, 'halaweteljeben', 3, 840000, 4, 'sweet/halaweteljeben.jpg'),
(47, 'kallaj', 3, 510000, 8, 'sweet/kallaj.jpg'),
(48, 'katayef', 3, 300000, 19, 'sweet/katayef.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `offer`
--

CREATE TABLE `offer` (
  `offerid` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `percentage` int(2) NOT NULL,
  `enddate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `offer`
--

INSERT INTO `offer` (`offerid`, `itemid`, `percentage`, `enddate`) VALUES
(1, 45, 30, '2025-02-11'),
(2, 31, 50, '2025-02-10'),
(3, 34, 70, '2025-02-10'),
(4, 33, 50, '2025-02-20');

-- --------------------------------------------------------

--
-- Table structure for table `orderitem`
--

CREATE TABLE `orderitem` (
  `orderId` int(11) NOT NULL,
  `itemid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderitem`
--

INSERT INTO `orderitem` (`orderId`, `itemid`, `quantity`, `price`) VALUES
(110, 41, 1, 250000),
(111, 41, 1, 250000),
(111, 45, 1, 660000),
(112, 44, 5, 2250000),
(113, 31, 2, 300000),
(113, 32, 1, 300000),
(114, 31, 1, 75000),
(115, 44, 1, 450000),
(116, 41, 1, 250000),
(117, 31, 2, 150000),
(117, 32, 1, 300000),
(118, 31, 1, 75000),
(118, 48, 1, 300000);

-- --------------------------------------------------------

--
-- Table structure for table `orderr`
--

CREATE TABLE `orderr` (
  `orderId` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `payed` int(1) NOT NULL DEFAULT 0,
  `table` int(2) NOT NULL DEFAULT 0,
  `datee` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orderr`
--

INSERT INTO `orderr` (`orderId`, `username`, `price`, `payed`, `table`, `datee`) VALUES
(110, 'cashier1', 250000, 1, 0, '2025-02-09'),
(111, 'cashier1', 910000, 1, 7, '2025-02-09'),
(112, 'husseindika', 2250000, 1, 0, '2025-02-09'),
(113, 'husseindika', 600000, 1, 0, '2025-02-09'),
(114, 'husseindika', 75000, 2, 0, '2025-02-09'),
(115, 'dano_g', 450000, 2, 0, '2025-02-09'),
(116, 'dano_g', 250000, 2, 0, '2025-02-09'),
(117, 'cashier1', 450000, 0, 13, '2025-02-09'),
(118, 'husseindika', 375000, 2, 0, '2025-02-09');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` int(11) NOT NULL,
  `location` varchar(50) NOT NULL,
  `position` int(1) NOT NULL DEFAULT 0,
  `isactive` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`username`, `password`, `firstname`, `lastname`, `email`, `phone`, `location`, `position`, `isactive`) VALUES
('cashier1', 'cashier1', 'cashier', 'dika', 'cashier@gmail.com', 12345678, 'baalbeck,hizzin', 2, 0),
('dano_g', '11112222', 'daniel', 'ghazaly', 'danielghazaly@gmail.com', 81180758, 'zahle-hoshlomara', 0, 0),
('hisho_tl', 'hisham123', 'hisham', 'tlais', 'hishamtlais@gmail.com', 81806812, 'baalbek-brital', 3, 0),
('husseindika', 'hussein123', 'hussein', 'dika', 'hdika2311@gmail.com', 71104464, 'baalbeck,hizzin', 0, 1),
('mostafa_tf', 'bingbang', 'mostafa', 'tfaily', 'mostafatf97@gmail.com', 3036691, 'brital-highWay', 1, 0),
('weso-123', 'aboulwes', 'wassem', 'boarab', 'wasim@gmail.com', 3333444, 'sawile,bekaa', 3, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `username` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `stars` int(1) NOT NULL,
  `feedback` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`username`, `stars`, `feedback`) VALUES
('dano_g', 5, 'ohh'),
('hisho_tl', 3, 'yummy yummy'),
('husseindika', 5, 'specialen dishilen'),
('mostafa_tf', 3, 'yummy dishes');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`username`,`itemid`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`username`,`orderid`),
  ADD KEY `orderid` (`orderid`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`itemID`),
  ADD KEY `categoryID` (`categoryID`);

--
-- Indexes for table `offer`
--
ALTER TABLE `offer`
  ADD PRIMARY KEY (`offerid`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD PRIMARY KEY (`orderId`,`itemid`),
  ADD KEY `itemid` (`itemid`);

--
-- Indexes for table `orderr`
--
ALTER TABLE `orderr`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`username`),
  ADD KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `itemID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `offer`
--
ALTER TABLE `offer`
  MODIFY `offerid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orderr`
--
ALTER TABLE `orderr`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `card`
--
ALTER TABLE `card`
  ADD CONSTRAINT `card_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `items` (`itemID`) ON DELETE CASCADE,
  ADD CONSTRAINT `card_ibfk_2` FOREIGN KEY (`username`) REFERENCES `person` (`username`) ON DELETE CASCADE;

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`username`) REFERENCES `person` (`username`) ON DELETE CASCADE,
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`orderid`) REFERENCES `orderr` (`orderId`) ON DELETE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryId`) ON DELETE CASCADE;

--
-- Constraints for table `offer`
--
ALTER TABLE `offer`
  ADD CONSTRAINT `offer_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `items` (`itemID`) ON DELETE CASCADE;

--
-- Constraints for table `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_1` FOREIGN KEY (`itemid`) REFERENCES `items` (`itemID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`orderId`) REFERENCES `orderr` (`orderId`) ON DELETE CASCADE;

--
-- Constraints for table `orderr`
--
ALTER TABLE `orderr`
  ADD CONSTRAINT `orderr_ibfk_1` FOREIGN KEY (`username`) REFERENCES `person` (`username`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`username`) REFERENCES `person` (`username`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
