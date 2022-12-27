-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 27, 2022 at 08:33 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `porat-staff`
--

-- --------------------------------------------------------

--
-- Table structure for table `boat`
--

CREATE TABLE `boat` (
  `IDBoat` int(11) NOT NULL,
  `Name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `boat`
--

INSERT INTO `boat` (`IDBoat`, `Name`) VALUES
(1, 'Orca'),
(2, 'Shark'),
(3, 'Dolphin'),
(4, 'Barracuda'),
(5, '721BG - 60ks, 5m'),
(6, '881BG - 115ks, 5.5m'),
(7, '722BG - 150ks, 6m'),
(8, '723BG - 150ks, 6m'),
(9, 'Sessa Key Largo'),
(10, '725BG - 150ks, 6.5m'),
(11, '724BG - 225ks, 7m'),
(12, 'Barracuda - Damir');

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

CREATE TABLE `client` (
  `IDClient` int(11) NOT NULL,
  `Name` varchar(25) NOT NULL,
  `Surname` varchar(25) NOT NULL,
  `TelNum` varchar(25) NOT NULL,
  `OIB` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`IDClient`, `Name`, `Surname`, `TelNum`, `OIB`) VALUES
(1, 'Jan', 'Jurjec', '+385995921212', '236589541fn');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `IDEmployee` int(11) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Pin` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`IDEmployee`, `Username`, `Pin`) VALUES
(1, 'root', 0),
(2, 'Pero', 123456);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `IDReservation` int(11) NOT NULL,
  `BoatID` int(11) NOT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `FinishDateTime` datetime DEFAULT NULL,
  `ClientID` int(11) NOT NULL,
  `Price` float NOT NULL,
  `AdvancePayment` float NOT NULL,
  `PriceDiffrence` float NOT NULL,
  `EmployeeID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`IDReservation`, `BoatID`, `StartDateTime`, `FinishDateTime`, `ClientID`, `Price`, `AdvancePayment`, `PriceDiffrence`, `EmployeeID`) VALUES
(6, 1, '2022-12-22 08:00:00', '2022-12-31 19:00:00', 1, 150, 50, 100, 1),
(7, 2, '2022-12-23 14:00:00', '2022-12-23 19:00:00', 1, 15, 15, 15, 1),
(8, 3, '2022-12-23 08:00:00', '2022-12-23 14:00:00', 1, 45, 45, 45, 1),
(9, 2, '2022-12-23 08:00:00', '2022-12-23 13:00:00', 1, 225, 50, 20, 1),
(10, 11, '2022-12-22 08:00:00', '2022-12-29 19:00:00', 1, 600, 100, 500, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boat`
--
ALTER TABLE `boat`
  ADD PRIMARY KEY (`IDBoat`);

--
-- Indexes for table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`IDClient`);

--
-- Indexes for table `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`IDEmployee`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`IDReservation`),
  ADD KEY `EmployeeID` (`EmployeeID`),
  ADD KEY `BoatID` (`BoatID`),
  ADD KEY `ClientID` (`ClientID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boat`
--
ALTER TABLE `boat`
  MODIFY `IDBoat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `client`
--
ALTER TABLE `client`
  MODIFY `IDClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `IDEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `IDReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`IDEmployee`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`BoatID`) REFERENCES `boat` (`IDBoat`),
  ADD CONSTRAINT `reservation_ibfk_3` FOREIGN KEY (`ClientID`) REFERENCES `client` (`IDClient`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
