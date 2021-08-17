-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2021 at 01:33 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_db`
--

CREATE TABLE `admin_db` (
  `id` int(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `last_login` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_db`
--

INSERT INTO `admin_db` (`id`, `fullname`, `email`, `password`, `created_at`, `last_login`) VALUES
(1, 'FaizanAli', 'faizan@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', '2021-07-12', '29, Jul 2021 01:48:42 PM');

-- --------------------------------------------------------

--
-- Table structure for table `orders_db`
--

CREATE TABLE `orders_db` (
  `oid` int(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `catagory` varchar(255) NOT NULL,
  `price_per_unit` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders_db`
--

INSERT INTO `orders_db` (`oid`, `fullname`, `quantity`, `product`, `created_at`, `catagory`, `price_per_unit`, `total_price`) VALUES
(8, 'Faizan Ali', '3==4==', 'Breaker==Breaker==', '29, Jul 2021 13:44:46', '50 AMP==60 AMP==', '200==1200==', '5400'),
(9, 'Faizan Ali', '20==1==', 'Breaker==Generator==', '29, Jul 2021 14:14:53', '50 AMP==200 Watt==', '1200==3000==', '27000');

-- --------------------------------------------------------

--
-- Table structure for table `product_db`
--

CREATE TABLE `product_db` (
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `stock_updated` varchar(255) DEFAULT NULL,
  `catagory` varchar(255) NOT NULL,
  `sold` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_db`
--

INSERT INTO `product_db` (`pid`, `name`, `stock`, `price`, `created_at`, `stock_updated`, `catagory`, `sold`) VALUES
(1, 'Breaker', '65', '1500', '2021-07-13', '29, Jul 2021 03:21:18 PM', '50 AMP', 45),
(2, 'Breaker', '55', '6500', '2021-07-14', '15, Jul 2021 03:29:28 AM', '60 AMP', 16),
(3, 'Parwaz Fan', '24', '5600', '2021-07-14', NULL, 'Condenser Fan Motor', 1),
(4, 'Generator', '34', '6000', '15, Jul 2021 12:17:45 AM', NULL, '200 Watt', 1),
(7, 'Pump', '5', '6000', '15, Jul 2021 11:09:08 AM', NULL, '500 Watt', 0);

-- --------------------------------------------------------

--
-- Table structure for table `record_db`
--

CREATE TABLE `record_db` (
  `pid` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stock` int(255) NOT NULL,
  `created_at` varchar(255) NOT NULL,
  `catagory` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `record_db`
--

INSERT INTO `record_db` (`pid`, `name`, `stock`, `created_at`, `catagory`) VALUES
(1, 'Breaker', 10, '29, Jul 2021 03:21:18 PM', '50 AMP');

-- --------------------------------------------------------

--
-- Table structure for table `return_db`
--

CREATE TABLE `return_db` (
  `id` int(255) NOT NULL,
  `product` varchar(255) NOT NULL,
  `price` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `catagory` varchar(255) NOT NULL,
  `returned_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `return_db`
--

INSERT INTO `return_db` (`id`, `product`, `price`, `quantity`, `catagory`, `returned_at`) VALUES
(1, 'Breaker', '1200', '1', '30 AMP', '15, Jul 2021 02:21:45 AM'),
(2, 'Breaker', '1600', '1', '60 AMP', '29, Jul 2021 10:42:36 AM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_db`
--
ALTER TABLE `admin_db`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders_db`
--
ALTER TABLE `orders_db`
  ADD PRIMARY KEY (`oid`);

--
-- Indexes for table `product_db`
--
ALTER TABLE `product_db`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `record_db`
--
ALTER TABLE `record_db`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `return_db`
--
ALTER TABLE `return_db`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_db`
--
ALTER TABLE `admin_db`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `orders_db`
--
ALTER TABLE `orders_db`
  MODIFY `oid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_db`
--
ALTER TABLE `product_db`
  MODIFY `pid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `record_db`
--
ALTER TABLE `record_db`
  MODIFY `pid` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_db`
--
ALTER TABLE `return_db`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
