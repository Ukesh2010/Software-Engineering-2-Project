-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 15, 2015 at 06:58 PM
-- Server version: 5.6.25
-- PHP Version: 5.6.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `se2`
--

-- --------------------------------------------------------

--
-- Table structure for table `counseller`
--

CREATE TABLE IF NOT EXISTS `counseller` (
  `counseller_id` int(11) NOT NULL,
  `counseller_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `followup`
--

CREATE TABLE IF NOT EXISTS `followup` (
  `counseller_id` int(11) DEFAULT NULL,
  `lead_id` int(11) DEFAULT NULL,
  `followup_date` date DEFAULT NULL,
  `feedback` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `intake`
--

CREATE TABLE IF NOT EXISTS `intake` (
  `intake_id` int(11) NOT NULL,
  `intake_start_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lead`
--

CREATE TABLE IF NOT EXISTS `lead` (
  `lead_id` int(11) NOT NULL,
  `lead_first_name` varchar(100) DEFAULT NULL,
  `lead_middle_name` varchar(100) DEFAULT NULL,
  `lead_last_name` varchar(100) DEFAULT NULL,
  `lead_adddress` varchar(100) DEFAULT NULL,
  `lead_mobile_no` varchar(100) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `isStudent` tinyint(4) DEFAULT NULL,
  `intake_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counseller`
--
ALTER TABLE `counseller`
  ADD PRIMARY KEY (`counseller_id`);

--
-- Indexes for table `intake`
--
ALTER TABLE `intake`
  ADD PRIMARY KEY (`intake_id`);

--
-- Indexes for table `lead`
--
ALTER TABLE `lead`
  ADD PRIMARY KEY (`lead_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
