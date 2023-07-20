-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2023 at 07:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jazzburger`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `idcust` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`idcust`, `username`, `password`) VALUES
(1, 'hanif2023', '$2y$10$2T65B3PsOSsswZ7XfZSvhuL1tHmuspDFedjkjiWaHM2TZ.zkEeN6e');

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `menu_code` int(11) NOT NULL,
  `menu_name` varchar(100) NOT NULL,
  `menu_detail` text NOT NULL,
  `menu_price` decimal(10,2) NOT NULL,
  `menu_stock` int(11) NOT NULL,
  `menu_pictures` varchar(100) NOT NULL,
  `menu_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_code`, `menu_name`, `menu_detail`, `menu_price`, `menu_stock`, `menu_pictures`, `menu_category`) VALUES
(1, 'Butterkill double', 'Deskripsi Butterkill Double', '120000.00', 20, 'butterkill-double.jpg', 'main course'),
(2, 'Butterkill single', 'Deskripsi Butterkill Single', '90000.00', 25, 'butterkill-single.jpg', 'main course'),
(3, 'Cocacola 330ml', 'Deskripsi Coca-Cola 330ml', '15000.00', 100, 'cocacola-330ml.jpg', 'drinks'),
(4, 'El jefe', 'Deskripsi El Jefe', '110000.00', 15, 'el-jefe.jpg', 'main course'),
(5, 'El pollo loco', 'Deskripsi El Pollo Loco', '95000.00', 18, 'el-pollo-loco.jpg', 'main course'),
(6, 'Enter sandwich', 'Deskripsi Enter Sandwich', '85000.00', 30, 'enter-sandwich.jpg', 'main course'),
(7, 'Gold sabbath', 'Deskripsi Gold Sabbath', '130000.00', 12, 'gold-sabbath.jpg', 'main course'),
(8, 'Jalapenostic front', 'Deskripsi Jalapenostic Front', '80000.00', 20, 'jalapenostic-front.jpg', 'main course'),
(9, 'Joey bellodona', 'Deskripsi Joey Bellodona', '90000.00', 22, 'joey-bellodona.jpg', 'main course'),
(10, 'Judas fries', 'Deskripsi Judas Fries', '50000.00', 50, 'judas-fries.jpg', 'side dishes'),
(11, 'madballs', 'Deskripsi Madballs', '75000.00', 15, 'madballs.jpg', 'main course'),
(12, 'Mineral water 600ml', 'Deskripsi Mineral Water 600ml', '10000.00', 80, 'mineral-water-600ml.jpg', 'drinks'),
(13, 'Motley double', 'Deskripsi Motley Double', '115000.00', 14, 'motley-double.jpg', 'main course'),
(14, 'Motley single', 'Deskripsi Motley Single', '85000.00', 20, 'motley-single.jpg', 'main course'),
(15, 'mozpit', 'Deskripsi Mozpit', '95000.00', 17, 'mozpit.jpg', 'main course'),
(16, 'Municipal wings', 'Deskripsi Municipal Wings', '80000.00', 22, 'municipal-wings.jpg', 'main course'),
(17, 'Philly anselmo', 'Deskripsi Philly Anselmo', '100000.00', 18, 'philly-anselmo.jpg', 'main course'),
(18, 'Pokka green tea', 'Deskripsi Pokka Green Tea', '18000.00', 90, 'pokka-green-tea.jpg', 'drinks'),
(19, 'Sabbath double', 'Deskripsi Sabbath Double', '110000.00', 16, 'sabbath-double.jpg', 'main course'),
(20, 'Sabbath single', 'Deskripsi Sabbath Single', '85000.00', 20, 'sabbath-single.jpg', 'main course'),
(21, 'Schweppes ginger ale', 'Deskripsi Schweppes Ginger Ale', '17000.00', 70, 'schweppes-ginger-ale.jpg', 'drinks'),
(22, 'Schweppes soda', 'Deskripsi Schweppes Soda', '16000.00', 75, 'schweppes-soda.jpg', 'drinks'),
(23, 'sepultuna', 'Deskripsi Sepultuna', '90000.00', 18, 'sepultuna.jpg', 'main course'),
(24, 'splattertrash', 'Deskripsi Splattertrash', '100000.00', 16, 'splattertrash.jpg', 'main course'),
(25, 'Sprite 330ml', 'Deskripsi Sprite 330ml', '15000.00', 95, 'sprite-330ml.jpg', 'drinks'),
(26, 'stryper', 'Deskripsi Stryper', '100000.00', 15, 'stryper.jpg', 'main course'),
(27, 'The great southern', 'Deskripsi The Great Southern', '105000.00', 20, 'the-great-southern.jpg', 'main course'),
(28, 'The lemmy', 'Deskripsi The Lemmy', '100000.00', 18, 'the-lemmy.jpg', 'main course');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `custname` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `notes` text DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `custname`, `address`, `phone`, `notes`, `order_date`) VALUES
(1, 'ad', 'asd', 'asd', 'asd', '2023-07-20 17:46:22'),
(2, 'sd', 'asd', 'asd', 'asd', '2023-07-20 17:46:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`idcust`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`menu_code`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `idcust` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `menu_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
