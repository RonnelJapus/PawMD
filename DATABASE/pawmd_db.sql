-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 13, 2024 at 04:41 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pawmd_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `AppointmentID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`AppointmentID`, `ClientID`, `PetID`, `AppointmentDate`, `CreatedAt`) VALUES
(8, 17, 81, '2024-12-13', '2024-12-11 07:05:05'),
(9, 17, 79, '2024-12-14', '2024-12-11 09:56:28');

-- --------------------------------------------------------

--
-- Table structure for table `approved_appointments`
--

CREATE TABLE `approved_appointments` (
  `AppointmentID` int(11) NOT NULL,
  `ClientID` int(11) NOT NULL,
  `PetID` int(11) NOT NULL,
  `AppointmentDate` date NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `status` enum('Pending','Accepted','Declined') DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `approved_appointments`
--

INSERT INTO `approved_appointments` (`AppointmentID`, `ClientID`, `PetID`, `AppointmentDate`, `CreatedAt`, `status`) VALUES
(7, 17, 79, '2024-12-13', '2024-12-11 14:51:16', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `archive_client`
--

CREATE TABLE `archive_client` (
  `ClientID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` text DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `ArchivedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_client`
--

INSERT INTO `archive_client` (`ClientID`, `FirstName`, `LastName`, `PhoneNumber`, `Email`, `Address`, `Gender`, `ArchivedAt`) VALUES
(6, 'Ronnelito', 'ipanada', '21', 'wtaf@test', 'test', 'Male', '2024-11-27 09:27:40'),
(7, 'wata', '1', '1', '', '', 'Female', '2024-11-27 09:27:01'),
(8, 'wata', '1', '1', '', '', 'Female', '2024-11-27 09:26:58'),
(9, 'satani', 'satani', '12342321312', '', '', 'Male', '2024-11-27 10:46:46'),
(10, 'test', 'dasdas', '3213123', 'sadsad@sadsa', 'adsadsa', 'Male', '2024-11-27 09:39:57'),
(12, 'Ronnel', 'dsadas', '12321321', 'dsadsad@sadsadsa', 'dsadsa', 'Male', '2024-11-29 10:55:34'),
(13, 'wadasdsa', 'dsadsad', '12321321321', 'adsadas@sadsa.com', 'sadsa', 'Male', '2024-11-29 10:56:35'),
(14, 'delete', 'test', '1234567890', 'deletetest@gmail.com', 'test', 'Male', '2024-11-29 11:12:54'),
(15, 'delete  test5', 'ipanada', '0952234511', 'deletetest5@gmail.com', 'balingasag', 'Male', '2024-11-29 22:13:15'),
(16, 'Account', 'Test', '1234567890', 'AccountTest@gmail.com', 'testloca', 'Male', '2024-11-30 15:50:59'),
(18, 'register', 'test', '1232131', 'dsadsa@dsadsad', 'sdsadsada', 'Male', '2024-11-30 15:51:04');

-- --------------------------------------------------------

--
-- Table structure for table `archive_pets`
--

CREATE TABLE `archive_pets` (
  `pet_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` enum('Male','Female','Unknown') DEFAULT 'Unknown',
  `client_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_pets`
--

INSERT INTO `archive_pets` (`pet_id`, `name`, `breed`, `age`, `sex`, `client_id`, `image`) VALUES
(25, 'sad', '11111', 321321, 'Male', 1, 'uploads/Capture001.png'),
(65, 'testing12321312', '123123', 1231231, 'Female', 1, NULL),
(66, 'qwerty', '12321', 21312, 'Male', 1, NULL),
(67, 'testingan13213', 'dwadsa', 21312, 'Female', 1, NULL),
(68, 'try12321', 'dsadsa', 123, 'Male', 1, NULL),
(70, 'wadsdsa', 'dsadsa', 12321, 'Female', 1, NULL),
(69, 'wadsdsa', 'dsadsa', 12321, 'Female', 1, NULL),
(23, 'shibatestron', 'american bullytest123445', 2147483647, 'Male', 1, 'pet_67457ffa5258e4.14409322.png'),
(75, 'deletetest5', 'deletetest5', 1, 'Male', 15, 'uploads/RobloxScreenShot20240323_004847582.png');

-- --------------------------------------------------------

--
-- Table structure for table `archive_users`
--

CREATE TABLE `archive_users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `user_gender` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(50) NOT NULL,
  `designation` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'user',
  `archived_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `archive_users`
--

INSERT INTO `archive_users` (`user_id`, `user_firstname`, `user_lastname`, `contact_number`, `user_gender`, `user_email`, `user_password`, `designation`, `user_type`, `archived_at`) VALUES
(2, 'Raiden', 'MachineGun', '1', 'Male', 'Raiden@gmail.com', '122', 'Vet', 'user', '2024-11-15 16:32:43'),
(4, 'pamel1', 'naypa', '111', 'Female', 'pamel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Staff', 'user', '2024-11-16 12:33:22'),
(5, 'Ronnel', 'Inao', '1', 'Male', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Staff', 'user', '2024-11-16 22:23:28'),
(9, 'Ronnel Wowie', 'Japus', '11111111', 'Male', 'Ronnel.Japus@example.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-16 14:08:10'),
(17, '111', '11112', '11', 'Male', '111@111', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-16 14:23:50'),
(18, '111', '11112', '11', 'Male', '111@111', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-16 14:25:25'),
(19, 'Carl', 'Inao', '0952234511', 'Male', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-16 22:12:00'),
(20, 'testingROnnel', 'Inao', '1', 'Male', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-16 22:18:06'),
(21, 'Ronnel', 'Inao', '0952234511', 'Male', 'Ronnel1@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'Vet', 'user', '2024-11-16 22:20:22'),
(23, '111', '11112', '11', 'Male', '111@111222', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-17 00:22:20'),
(24, 'Pamel', 'naypa', '12345', 'Female', 'pamel@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Vet', 'user', '2024-11-17 01:26:27'),
(25, 'Pamel', 'naypa', '12345', 'Female', 'pamel@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'Vet', 'user', '2024-11-20 06:38:39'),
(26, 'Ronnel', 'Inao', '0952234511', 'Female', 'Ronnel@gmail.com', '6512bd43d9caa6e02c990b0a82652dca', 'Staff', 'user', '2024-11-20 08:26:00'),
(28, 'Ronnel', '1', '21', 'Male', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-20 08:30:19'),
(29, 'Ronnel', '1', '0952234511', 'Male', '1@1', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-20 08:30:17'),
(30, 'Ronnel', 'MachineGun', '0952234511', 'Female', 'hashTest@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-20 08:30:15'),
(31, 'testingROnnel', 'Inao', '0952234511', 'Male', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-20 08:30:13'),
(32, 'wata', 'Inao', '0952234511', 'Female', '1@12', 'c4ca4238a0b923820dcc509a6f75849b', 'Staff', 'user', '2024-11-27 09:42:36'),
(33, 'Testing VET', 'wataaaaaa', '5555555555', 'Male', 'TESTINGVET@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-29 10:20:44'),
(34, 'client', 'test', '12342143213', 'Male', 'client@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'user', '2024-11-29 10:20:42');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `ClientID` int(11) NOT NULL,
  `FirstName` varchar(100) NOT NULL,
  `LastName` varchar(100) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `password` varchar(50) NOT NULL,
  `Address` text DEFAULT NULL,
  `Gender` enum('Male','Female','Other') DEFAULT NULL,
  `ProfileImage` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`ClientID`, `FirstName`, `LastName`, `PhoneNumber`, `Email`, `password`, `Address`, `Gender`, `ProfileImage`) VALUES
(1, 'Ronnelito', 'Japus', '123456789', 'Ronnel.Japus@gmail.com', '', 'balingasag', 'Male', NULL),
(3, 'testingROnnel1', 'testtt05', '12321321', 'wata@gmail.com', '', 'test12345', 'Male', NULL),
(11, 'trying hard ', 'harder', '123213', 'tryinghard@gmail.com', '', 'dawdwa', 'Male', NULL),
(17, 'Ronnel', 'Japus', '3213213123', 'pass@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'test', 'Male', 'testimg.jpg'),
(19, 'test', '100', '1', 'word@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'balingasag', 'Male', 'sample112321.png'),
(20, 'test', '1232', 'test', 'test@sdsadas', '', 'dasdsa', 'Male', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `pet_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `condition` varchar(255) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `symptoms` text DEFAULT NULL,
  `treatment` text DEFAULT NULL,
  `next_visit_date` date DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `pet_id`, `date`, `condition`, `diagnosis`, `symptoms`, `treatment`, `next_visit_date`, `notes`) VALUES
(1, 1, '2024-12-05', 'dwadaw', 'dwadwa', 'dwadwa', 'wadawd', '2025-01-03', 'awdawdwa'),
(2, 22, '2024-12-11', 'try', 'gi kapoy ug code', 'trying', 'dsadsa', '2024-12-14', 'dsadasdas'),
(3, 76, '2024-12-12', 'tres', 'dsad', 'wadsa', 'dsadsa', '2024-12-11', 'dsadsa'),
(4, 1, '2024-12-11', 'test', 'test', 'test', 'test', '2024-12-18', 'asdasdsaasdsa'),
(5, 1, '2024-12-11', 'test', 'test', 'test', 'test', '2024-12-12', 'test'),
(6, 72, '2024-12-11', 'test', 'dsad', 'sdsadsa', 'sadsa', '2024-12-21', 'dasdas');

-- --------------------------------------------------------

--
-- Table structure for table `pets`
--

CREATE TABLE `pets` (
  `pet_id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `breed` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `sex` enum('Male','Female','Unknown') DEFAULT 'Unknown',
  `client_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pets`
--

INSERT INTO `pets` (`pet_id`, `name`, `breed`, `age`, `sex`, `client_id`, `image`) VALUES
(1, 'sugar', 'mix', 1, 'Male', 1, NULL),
(22, 'shibatestingan', 'american bullytest', 1, 'Female', 1, 'pet_67455bb7112845.25364698.png'),
(64, 'test', 'trew', 12312, 'Male', 3, NULL),
(71, 'petimagetest', 'testimg', 1, 'Male', 1, 'uploads/testimg.jpg'),
(72, 'pamel', 'tao', 123, 'Female', 3, 'uploads/RobloxScreenShot20240330_230144567.png'),
(76, 'testing', 'american bullytest', 1, 'Male', 17, NULL),
(78, 'test55', '1', 1, 'Male', NULL, 'uploads/SHIRT.jpeg'),
(79, 'sugar1', 'american bullytest', 1, '', 17, 'SHIRT.jpeg'),
(80, 'wa', '1', 1, '', 17, 'RobloxScreenShot20240926_233741203.png'),
(81, 'testpet', 'mix', 1, '', 17, 'RobloxScreenShot20240330_234031303.png');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_firstname` varchar(50) NOT NULL,
  `user_lastname` varchar(50) NOT NULL,
  `contact_number` varchar(50) NOT NULL,
  `user_gender` varchar(50) NOT NULL,
  `user_email` varchar(50) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_type` varchar(50) NOT NULL DEFAULT 'user',
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_firstname`, `user_lastname`, `contact_number`, `user_gender`, `user_email`, `user_password`, `user_type`, `profile_image`) VALUES
(3, 'Ronnel', 'Test', '5555s', 'Male', 'Admintest@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'admin', 'testimg.jpg'),
(22, 'Ronnel', 'Inao', '0952234511', 'Female', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user', NULL),
(27, 'Ronnel', 'Inao', '0952234511', 'Female', 'Ronnel@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'user', NULL),
(35, 'pamel', 'naypa', '1234567890', 'Female', 'Pamel.naypa@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'user', NULL),
(36, 'Pamel', 'Naypa', '122332321', 'Male', 'VetTest@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Vet', 'fad5e79954583ad50ccb3f16ee64f66d.jpg'),
(37, 'Carl', 'Inao', '0952234511', 'Male', 'Carl.ipanada@gmail.com', 'c4ca4238a0b923820dcc509a6f75849b', 'Staff', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `PetID` (`PetID`);

--
-- Indexes for table `approved_appointments`
--
ALTER TABLE `approved_appointments`
  ADD PRIMARY KEY (`AppointmentID`),
  ADD KEY `ClientID` (`ClientID`),
  ADD KEY `PetID` (`PetID`);

--
-- Indexes for table `archive_client`
--
ALTER TABLE `archive_client`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `archive_users`
--
ALTER TABLE `archive_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`ClientID`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `pets`
--
ALTER TABLE `pets`
  ADD PRIMARY KEY (`pet_id`),
  ADD KEY `client_id` (`client_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `AppointmentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `ClientID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `pets`
--
ALTER TABLE `pets`
  MODIFY `pet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`PetID`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `approved_appointments`
--
ALTER TABLE `approved_appointments`
  ADD CONSTRAINT `approved_appointments_ibfk_1` FOREIGN KEY (`ClientID`) REFERENCES `client` (`ClientID`),
  ADD CONSTRAINT `approved_appointments_ibfk_2` FOREIGN KEY (`PetID`) REFERENCES `pets` (`pet_id`);

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`pet_id`) REFERENCES `pets` (`pet_id`) ON DELETE CASCADE;

--
-- Constraints for table `pets`
--
ALTER TABLE `pets`
  ADD CONSTRAINT `pets_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`ClientID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
