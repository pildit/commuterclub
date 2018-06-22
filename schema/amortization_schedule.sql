-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 22, 2018 at 08:54 PM
-- Server version: 10.1.24-MariaDB
-- PHP Version: 7.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `testat`
--

-- --------------------------------------------------------

--
-- Table structure for table `amortization_schedule`
--

CREATE TABLE `amortization_schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `period` date NOT NULL,
  `beginning_balance` decimal(10,2) NOT NULL,
  `payment` decimal(10,2) NOT NULL,
  `principal` decimal(10,2) NOT NULL,
  `interest` decimal(10,2) NOT NULL,
  `cumulative_principal` decimal(10,2) NOT NULL,
  `cumulative_interest` decimal(10,2) NOT NULL,
  `ending_balance` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amortization_schedule`
--
ALTER TABLE `amortization_schedule`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amortization_schedule`
--
ALTER TABLE `amortization_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
