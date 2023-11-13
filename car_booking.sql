-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2023 at 08:38 AM
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
-- Database: `car_booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `agency_username` varchar(255) NOT NULL,
  `agency_mobile` int(255) NOT NULL,
  `agency_address` varchar(255) NOT NULL,
  `agency_password` varchar(255) NOT NULL,
  `agency_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agency`
--

INSERT INTO `agency` (`agency_username`, `agency_mobile`, `agency_address`, `agency_password`, `agency_email`) VALUES
('spm55', 2147483647, 'kaisarganj', 'Abhi@430', 'mbrrkn@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `agencycar`
--

CREATE TABLE `agencycar` (
  `car_id` int(255) NOT NULL,
  `agency_username` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencycar`
--

INSERT INTO `agencycar` (`car_id`, `agency_username`) VALUES
(55, 'spm55');

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `car_id` int(255) NOT NULL,
  `car_model` varchar(255) NOT NULL,
  `car_number` varchar(255) NOT NULL,
  `seating_cap` int(255) NOT NULL,
  `rent_per_day` int(255) NOT NULL,
  `car_img` varchar(255) DEFAULT NULL,
  `car_available` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`car_id`, `car_model`, `car_number`, `seating_cap`, `rent_per_day`, `car_img`, `car_available`) VALUES
(55, 'tata nano', 'up4536', 99, 999, 'uploads/asp.jpg', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(255) NOT NULL,
  `customer_username` varchar(255) NOT NULL,
  `customer_mobile` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_password` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `customer_username`, `customer_mobile`, `customer_address`, `customer_password`, `customer_email`) VALUES
(1, 'anant', '8090211618', 'kaisarganj', 'Abhi@430', 'mbrrkn@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `rentedcar`
--

CREATE TABLE `rentedcar` (
  `return_id` int(255) NOT NULL,
  `customer_username` varchar(255) NOT NULL,
  `car_id` int(255) NOT NULL,
  `no_of_days` int(255) NOT NULL,
  `start_date` varchar(255) NOT NULL,
  `end_date` varchar(255) NOT NULL,
  `car_return_date` varchar(255) NOT NULL,
  `total_amount` int(255) NOT NULL,
  `rent_per_day` int(255) NOT NULL,
  `return_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rentedcar`
--

INSERT INTO `rentedcar` (`return_id`, `customer_username`, `car_id`, `no_of_days`, `start_date`, `end_date`, `car_return_date`, `total_amount`, `rent_per_day`, `return_status`) VALUES
(1, 'anant', 55, 99, '2023-11-16', '2024-02-23', '2023-11-12', 98901, 999, 'R'),
(2, 'anant', 55, 0, '2023-11-18', '2023-11-18', '', 0, 999, 'NR');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`agency_username`);

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD UNIQUE KEY `car_number` (`car_number`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rentedcar`
--
ALTER TABLE `rentedcar`
  ADD PRIMARY KEY (`return_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rentedcar`
--
ALTER TABLE `rentedcar`
  MODIFY `return_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
