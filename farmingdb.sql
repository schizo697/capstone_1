-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 09, 2024 at 05:21 AM
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
-- Database: `farmingdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `user_account`
--

CREATE TABLE `user_account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(244) NOT NULL,
  `password` varchar(244) NOT NULL,
  `level_id` int(11) NOT NULL,
  `info_id` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_account`
--

INSERT INTO `user_account` (`user_id`, `username`, `password`, `level_id`, `info_id`, `status`) VALUES
(1, 'admin', '$2y$10$y490bhUXHBSeIE8CpYGr0udMT98DEWwKc4SjBy.2Bp1Pcdp4QjKd.', 1, 1, 1),
(2, 'ww', 'ww', 2, 2, 1),
(3, 'admin', 'we', 3, 3, 1),
(4, 'wee', '$2y$10$rEgkUctyaGH5FTuZxAxsBOVpYoOXq4rtGmalteumM2qx3PO7bskCG', 4, 4, 1),
(5, 'wee', '$2y$10$/MuDz.jX2G1A7e7k7xnUuOn/no0yGXioVt29g1req9gQRZkTSq/Ci', 5, 5, 1),
(6, 'wee', '$2y$10$GFVS049iM1H5u2VPa3yaOOFdiybKRd8b8fJqbbo/IYJ9fSWT8mGO.', 6, 6, 1),
(7, 'wee', '$2y$10$MY5JwEyXpnWEEjAVY6uFY.2iqrzLb/daM5WskxaJLJpy9jySuAhvm', 7, 7, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `info_id` int(11) NOT NULL,
  `firstname` varchar(244) NOT NULL,
  `lastname` varchar(244) NOT NULL,
  `gender` varchar(244) NOT NULL,
  `contact` bigint(20) NOT NULL,
  `address` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`info_id`, `firstname`, `lastname`, `gender`, `contact`, `address`) VALUES
(1, 'admin', 'admin', 'male', 9913451231, 'aasdwasd'),
(2, 'ww', 'ww', 'ww', 0, 'ww'),
(3, 'we', 'we', 'we', 23, 'we'),
(4, 'wee', 'wee', 'wee', 123, 'wee'),
(5, 'wee', 'wee', 'wee', 123, 'wee'),
(6, 'ljhasd', 'lkajwd', 'oj', 123, 'awdkj'),
(7, 'ljhasd', 'lkajwd', 'oj', 123, 'awdkj');

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `level_id` int(11) NOT NULL,
  `level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`level_id`, `level`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 3),
(5, 1),
(6, 1),
(7, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_account`
--
ALTER TABLE `user_account`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`info_id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`level_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_account`
--
ALTER TABLE `user_account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user_level`
--
ALTER TABLE `user_level`
  MODIFY `level_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
