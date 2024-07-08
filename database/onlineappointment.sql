-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2024 at 02:25 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `onlineappointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_acc`
--

CREATE TABLE `tbl_acc` (
  `id` int(11) NOT NULL,
  `type` varchar(100) NOT NULL,
  `function` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_acc`
--

INSERT INTO `tbl_acc` (`id`, `type`, `function`) VALUES
(1, 'Patient', 1),
(2, 'Maintenance', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_holidays`
--

CREATE TABLE `tbl_holidays` (
  `id` int(11) NOT NULL,
  `date` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_holidays`
--

INSERT INTO `tbl_holidays` (`id`, `date`, `description`) VALUES
(4, '2024-03-11', 'JM'),
(5, '2024-05-31', 'zxcxzcxzcxzczx'),
(6, '2024-06-06', 'ZXC');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_login_info`
--

CREATE TABLE `tbl_login_info` (
  `id` int(10) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fk_patient_id` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_login_info`
--

INSERT INTO `tbl_login_info` (`id`, `username`, `password`, `fk_patient_id`) VALUES
(17, 'admin', '$2y$10$p.aoErEdTbak6FdBan4XD.SC6G1znSQaZejua7h9zgYtSom5xFyj6', 17),
(18, 'zxc', '$2y$10$l/88pt5R5tth46cBcMEGhu7ocmarN/uj0g/09aJ7j0KfSGslr1ZMe', 18),
(19, 'asd', '$2y$10$wEmk82QdBiOXm.ZF2hhR9OFjBLF4/7VYH58EoT69iALnBzxE3txg.', 19);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_patient`
--

CREATE TABLE `tbl_patient` (
  `id` int(11) NOT NULL,
  `image_url` text NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `middleinitial` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `age` int(10) NOT NULL,
  `contactnumber` varchar(12) NOT NULL,
  `presentaddress` varchar(100) NOT NULL,
  `type_user` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_patient`
--

INSERT INTO `tbl_patient` (`id`, `image_url`, `firstname`, `middleinitial`, `lastname`, `gender`, `birthday`, `age`, `contactnumber`, `presentaddress`, `type_user`) VALUES
(17, '../images/Uploads/user.png', 'John Mark', 'C', 'Engana', 'Male', '2002-06-30', 21, '09560494935', 'Koronadal City', 'Admin'),
(18, '../images/Uploads/user.png', 'zxc', 'zxc', 'zxc', 'Male', '2024-06-01', 0, '09560494935', 'Koronadal City', 'Patient'),
(19, '../images/Uploads/1697343601416.jpg', 'asd', 'asd', 'asd', 'Male', '1994-06-11', 30, '09560494935', 'Koronadal City', 'Staff');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_schedule`
--

CREATE TABLE `tbl_schedule` (
  `id` int(10) NOT NULL,
  `date_schedule` varchar(50) NOT NULL,
  `slots` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_schedule`
--

INSERT INTO `tbl_schedule` (`id`, `date_schedule`, `slots`) VALUES
(1, '2024-06-14', '295'),
(2, '2024-07-15', '10'),
(3, '2024-03-12', '200'),
(4, '2024-03-07', '300'),
(5, '2024-05-23', '300'),
(6, '2024-05-30', '500'),
(7, '2024-06-03', '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_service`
--

CREATE TABLE `tbl_service` (
  `id` int(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `fee` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_service`
--

INSERT INTO `tbl_service` (`id`, `type`, `fee`) VALUES
(2, 'zxc', '100'),
(3, 'asd', '-100'),
(4, 'ez', '100');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_transaction`
--

CREATE TABLE `tbl_transaction` (
  `id` int(10) NOT NULL,
  `transaction_number` varchar(100) NOT NULL,
  `fk_service_id` int(10) NOT NULL,
  `time_slot` varchar(100) NOT NULL,
  `fk_schedule_id` varchar(50) NOT NULL,
  `fk_patient_id` int(10) NOT NULL,
  `status` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_transaction`
--

INSERT INTO `tbl_transaction` (`id`, `transaction_number`, `fk_service_id`, `time_slot`, `fk_schedule_id`, `fk_patient_id`, `status`) VALUES
(35, 'TR-20240609-839399', 4, '4:00 PM', '1', 18, 'Unsuccessful'),
(36, 'TR-20240609-252472', 4, '', '1', 17, 'Reject'),
(37, 'TR-20240611-126292', 3, '12:00 PM', '1', 17, 'Complete');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_acc`
--
ALTER TABLE `tbl_acc`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_holidays`
--
ALTER TABLE `tbl_holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_login_info`
--
ALTER TABLE `tbl_login_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_service`
--
ALTER TABLE `tbl_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_acc`
--
ALTER TABLE `tbl_acc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_holidays`
--
ALTER TABLE `tbl_holidays`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_login_info`
--
ALTER TABLE `tbl_login_info`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_patient`
--
ALTER TABLE `tbl_patient`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tbl_schedule`
--
ALTER TABLE `tbl_schedule`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tbl_service`
--
ALTER TABLE `tbl_service`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_transaction`
--
ALTER TABLE `tbl_transaction`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
