-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2024 at 09:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apply`
--

-- --------------------------------------------------------

--
-- Table structure for table `sellerapplication`
--

CREATE TABLE `sellerapplication` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `business_name` varchar(255) NOT NULL,
  `business_address` text NOT NULL,
  `business_description` text NOT NULL,
  `valid_id` varchar(255) NOT NULL,
  `status` enum('pending','accepted','rejected','reported') DEFAULT 'pending',
  `application_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `reason_report` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sellerapplication`
--

INSERT INTO `sellerapplication` (`id`, `name`, `email`, `phone`, `business_name`, `business_address`, `business_description`, `valid_id`, `status`, `application_date`, `reason_report`) VALUES
(17, 'Joel R. De Jesus Jr', 'dejesusjoel731@gmail.com', '09876892124', 'Plantshop', 'Aliaga', 'ddd', 'uploads/Screenshot 2024-10-01 205720.png', 'reported', '2024-10-02 07:01:14', 'gggggggggg'),
(18, 'Gab', 'olpottado205@gmail.com', '0933221581', 'Plant', 'Cabanatuan', 'Ok naman', 'uploads/Screenshot 2024-10-01 200917.png', 'accepted', '2024-10-02 07:04:45', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `business_name` varchar(100) DEFAULT NULL,
  `business_address` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `business_name`, `business_address`, `created_at`) VALUES
(1, 'titengmatigas', 'dejesusjoel731@gmail.com', '09992675109', 'talungan', 'Aliaga', '2024-10-02 03:49:10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sellerapplication`
--
ALTER TABLE `sellerapplication`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sellerapplication`
--
ALTER TABLE `sellerapplication`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
