-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 12, 2023 at 10:46 AM
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
-- Database: `porat-staff`
--

-- --------------------------------------------------------

--
-- Table structure for table `boat`
--

CREATE TABLE `boat` (
  `IDBoat` int(11) NOT NULL,
  `Name` varchar(50) NOT NULL
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
-- Table structure for table `bugs`
--

CREATE TABLE `bugs` (
  `IDBugs` int(11) NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Text` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bugs`
--

INSERT INTO `bugs` (`IDBugs`, `EmployeeID`, `Text`) VALUES
(5, 5, 'Test'),
(9, 5, 'Ruzno'),
(10, 5, 'Test'),
(11, 5, 'Ruzno'),
(12, 5, 'Ruzno'),
(13, 5, 'ggg'),
(14, 5, 'ggg'),
(15, 5, 'ggg'),
(16, 5, 'ggg'),
(17, 5, 'ggg'),
(18, 5, 'dd'),
(20, 5, 'Test'),
(21, 5, 'Ovo je jedan jako veliki problem koji sam primjetio dok sa isao registrirati brod, a to je da se brod cinin narandastim, dok su svi ostali brodovi sivi. Nezan mzasto je narandasti, kada su vanzemaljci zeleni, a kupusi rozi. Zapravo kupus nije rozi nego sam ja glup...');

-- --------------------------------------------------------

--
-- Table structure for table `employee`
--

CREATE TABLE `employee` (
  `IDEmployee` int(11) NOT NULL,
  `Username` varchar(25) NOT NULL,
  `Pin` varchar(100) NOT NULL,
  `Level` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee`
--

INSERT INTO `employee` (`IDEmployee`, `Username`, `Pin`, `Level`) VALUES
(3, 'Pero', '123456', 0),
(4, 'Admin', '0000', 1),
(5, 'Nina', '2105', 0),
(6, 'Zoran', '1712', 0);

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `IDReservation` int(11) NOT NULL,
  `BoatID` int(11) NOT NULL,
  `StartDateTime` datetime NOT NULL,
  `FinishDateTime` datetime NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Surname` varchar(50) NOT NULL,
  `TelNum` varchar(50) NOT NULL,
  `OIB` varchar(50) NOT NULL,
  `Price` float NOT NULL,
  `AdvancePayment` float NOT NULL,
  `PriceDiffrence` float NOT NULL,
  `Deposit` float NOT NULL,
  `EmployeeID` int(11) NOT NULL,
  `Note` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`IDReservation`, `BoatID`, `StartDateTime`, `FinishDateTime`, `Name`, `Surname`, `TelNum`, `OIB`, `Price`, `AdvancePayment`, `PriceDiffrence`, `Deposit`, `EmployeeID`, `Note`) VALUES
(2, 1, '2023-01-06 08:00:00', '2023-01-06 19:00:00', 'Pero', 'Peric', '098765463', '92847583745', 50, 10, 0, 0, 3, ''),
(4, 2, '2023-01-06 08:00:00', '2023-01-06 14:00:00', 'Riva', 'Rivic', '+385995921212', '09890789678', 60, 20, 0, 0, 3, ''),
(5, 6, '2023-01-06 10:00:00', '2023-01-09 19:00:00', 'Jelena', 'Ujvari', '+42859373943', '94758375847', 150, 50, 100, 20, 3, ''),
(6, 4, '2023-01-07 08:00:00', '2023-01-07 19:00:00', 'Jovan', 'Krusic', '+3868975674', '87647563745', 50, 10, 0, 0, 3, ''),
(7, 9, '2023-01-07 08:00:00', '2023-01-07 19:00:00', 'Daniel', 'Lang', '+449876483', '782374856323', 200, 20, 0, 0, 3, ''),
(8, 1, '2023-01-07 08:00:00', '2023-01-07 14:00:00', 'Franjo', 'Balija', '+385938482', '0978674837LN', 50, 10, 40, 0, 3, ''),
(9, 1, '2023-01-08 08:00:00', '2023-01-08 14:00:00', 'nina', 'kontek', '+385958569955', '83638982637', 50, 20, 30, 0, 3, ''),
(11, 9, '2023-05-21 08:00:00', '2023-05-27 19:00:00', 'Nina Kontek', 'kontek', '578765', '5678665', 2100, 100, 2000, 0, 5, ''),
(12, 3, '2023-01-07 13:46:00', '2023-01-07 19:00:00', 'Jan', 'Jurjec', '93934', '3432', 102.22, 0, 0, 0, 3, ''),
(13, 2, '2023-01-09 08:00:00', '2023-01-09 14:00:00', 'Ninic', 'Ninolana', '2132', '2445', 50, 10, 40, 20, 5, 'Pripremiti ekstra 10 litara goriva, te ce ostati poslje 10h'),
(14, 1, '2023-01-09 08:00:00', '2023-01-09 14:00:00', 'Jan', 'Jurjec', '23', '2332', 50, 20, 30, 0, 5, ''),
(16, 5, '2023-01-10 08:00:00', '2023-01-13 19:00:00', 'Mario', 'Juvanic', '+3859959212211', '98374928374', 150, 20, 130, 0, 5, ''),
(17, 3, '2023-01-09 08:00:00', '2023-01-09 19:00:00', 'Miroslav', 'Krleza', '+385999728312', 'LN92849HT813', 60, 10, 50, 0, 5, ''),
(18, 11, '2023-01-09 08:00:00', '2023-01-11 19:00:00', 'Nikola', 'Tesla', '+3859284921', '83927583921', 300, 20, 0, 0, 5, ''),
(19, 1, '2023-01-10 08:00:00', '2023-01-10 19:00:00', 'Vladimir', 'Zelenski', '+385995921212', '93829485963', 60, 5, 55, 0, 5, ''),
(20, 2, '2023-01-10 08:00:00', '2023-01-10 19:00:00', 'Putin', 'Putin', '+4423948203', '02849438LKHJS', 60, 30, 0, 0, 3, ''),
(21, 3, '2023-01-10 15:00:00', '2023-01-10 19:00:00', 'Nikola', 'Budic', '00428392048', '928429429', 30, 10, 0, 0, 5, ''),
(23, 8, '2023-01-09 08:00:00', '2023-01-14 19:00:00', 'goran', 'bare', '098765432', '', 300, 100, 200, 0, 5, ''),
(24, 2, '2023-01-09 23:48:00', '2023-01-09 23:48:00', 'fg', 'dfg', '4565', '', 50, 20, 0, 0, 6, ''),
(25, 1, '2023-01-11 08:00:00', '2023-01-11 14:00:00', 'ih', 'jb', '809', '98', 50, 10, 40, 0, 3, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `boat`
--
ALTER TABLE `boat`
  ADD PRIMARY KEY (`IDBoat`);

--
-- Indexes for table `bugs`
--
ALTER TABLE `bugs`
  ADD PRIMARY KEY (`IDBugs`),
  ADD KEY `EmployeeID` (`EmployeeID`);

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
  ADD KEY `BoatID` (`BoatID`),
  ADD KEY `EmployeeID` (`EmployeeID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `boat`
--
ALTER TABLE `boat`
  MODIFY `IDBoat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `bugs`
--
ALTER TABLE `bugs`
  MODIFY `IDBugs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `employee`
--
ALTER TABLE `employee`
  MODIFY `IDEmployee` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `IDReservation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bugs`
--
ALTER TABLE `bugs`
  ADD CONSTRAINT `bugs_ibfk_1` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`IDEmployee`);

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`BoatID`) REFERENCES `boat` (`IDBoat`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`EmployeeID`) REFERENCES `employee` (`IDEmployee`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
