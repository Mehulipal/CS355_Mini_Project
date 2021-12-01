-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 29, 2021 at 09:48 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Landscape Related Services`
--

-- --------------------------------------------------------

--
-- Table structure for table `AbsenteesList`
--

CREATE TABLE `AbsenteesList` (
  `GID` varchar(6) NOT NULL,
  `NumOfShiftsMissed` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `AbsenteesList`
--

INSERT INTO `AbsenteesList` (`GID`, `NumOfShiftsMissed`) VALUES
('100001', 1),
('100002', 0),
('100003', 1),
('100004', 0),
('100005', 0);

-- --------------------------------------------------------

--
-- Table structure for table `AdminDetails`
--

CREATE TABLE `AdminDetails` (
  `admID` varchar(6) NOT NULL,
  `passwd` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `AdminDetails`
--

INSERT INTO `AdminDetails` (`admID`, `passwd`) VALUES
('adm123', '2titan2');

-- --------------------------------------------------------

--
-- Table structure for table `Date`
--

CREATE TABLE `Date` (
  `KeyDate` date NOT NULL,
  `IsHoliday` tinyint(1) NOT NULL,
  `IsWeekend` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Date`
--

INSERT INTO `Date` (`KeyDate`, `IsHoliday`, `IsWeekend`) VALUES
('2021-11-01', 0, 0),
('2021-11-02', 0, 0),
('2021-11-03', 0, 0),
('2021-11-04', 1, 0),
('2021-11-05', 0, 0),
('2021-11-06', 0, 1),
('2021-11-07', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `EquipMaintainenceInfo`
--

CREATE TABLE `EquipMaintainenceInfo` (
  `ENumber` int(11) NOT NULL,
  `QuantityUnderRepair` int(11) NOT NULL,
  `DateOfRepair` date NOT NULL,
  `DateOfReturn` date NOT NULL,
  `Status` varchar(30) NOT NULL,
  `CostOfRepair` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `EquipMaintainenceInfo`
--

INSERT INTO `EquipMaintainenceInfo` (`ENumber`, `QuantityUnderRepair`, `DateOfRepair`, `DateOfReturn`, `Status`, `CostOfRepair`) VALUES
(6, 2, '2021-10-27', '2021-10-30', 'Done', 455),
(9, 2, '2021-11-01', '2021-11-04', 'Ongoing', 0);

-- --------------------------------------------------------

--
-- Table structure for table `EquipmentInfo`
--

CREATE TABLE `EquipmentInfo` (
  `ENumber` int(11) NOT NULL,
  `EName` varchar(60) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `InitialValuePerPiece` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `EquipmentInfo`
--

INSERT INTO `EquipmentInfo` (`ENumber`, `EName`, `Quantity`, `InitialValuePerPiece`) VALUES
(1, 'Pruning Shears', 30, 677),
(2, 'Garden Fork', 10, 776),
(3, 'Hand Trowel', 15, 100),
(4, 'Hoe', 10, 799),
(6, 'Ingco 1600 W Electric Lawn Mover LM385', 3, 7639),
(7, 'Unison Mild Steel Frame Wheel Type Push Mower', 4, 3499),
(8, 'Garden Hose with Adjustable Nozzle', 8, 315),
(9, 'Stihl Cordless Hedge Trimmer ', 3, 7632),
(10, 'TADSO-LID Garden Digger Auger', 4, 1499);

-- --------------------------------------------------------

--
-- Table structure for table `GardenerInfo`
--

CREATE TABLE `GardenerInfo` (
  `GID` varchar(6) NOT NULL,
  `GFirstName` varchar(15) NOT NULL,
  `GLastName` varchar(15) NOT NULL,
  `Gender` char(1) NOT NULL,
  `DoB` date NOT NULL,
  `Age` int(11) NOT NULL,
  `StartDate` date NOT NULL,
  `YearsWithIITP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `GardenerInfo`
--

INSERT INTO `GardenerInfo` (`GID`, `GFirstName`, `GLastName`, `Gender`, `DoB`, `Age`, `StartDate`, `YearsWithIITP`) VALUES
('100001', 'Rakesh', 'Agarwal', 'M', '1983-09-07', 38, '2008-05-08', 13),
('100002', 'Seema', 'Ahuja', 'F', '1986-04-02', 35, '2011-06-24', 10),
('100003', 'Satyam', 'Singh', 'M', '1992-07-17', 29, '2018-04-03', 3),
('100004', 'Shivansh', 'Mehta', 'M', '1980-03-16', 41, '2017-05-18', 4),
('100005', 'Vivek', 'Kumar', 'F', '1984-01-22', 37, '2009-06-02', 12);

-- --------------------------------------------------------

--
-- Table structure for table `LandscapeInfo`
--

CREATE TABLE `LandscapeInfo` (
  `LID` varchar(4) NOT NULL,
  `LandLocation` varchar(30) NOT NULL,
  `Area` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `LandscapeInfo`
--

INSERT INTO `LandscapeInfo` (`LID`, `LandLocation`, `Area`) VALUES
('1001', 'Admin Blk Front', 1050),
('1002', 'Tut. Blk Front', 2000),
('1003', 'Gate 1 Area', 4046),
('1004', 'Gate 2 Area', 4000),
('1005', 'Block 4 Front', 1000),
('1006', 'Block 6 Front', 2000);

-- --------------------------------------------------------

--
-- Table structure for table `RequestHandling`
--

CREATE TABLE `RequestHandling` (
  `LID` varchar(4) NOT NULL,
  `RequesterName` varchar(30) NOT NULL,
  `Job` varchar(30) NOT NULL,
  `DateOfRequest` date NOT NULL,
  `StatusMsg` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `RequestHandling`
--

INSERT INTO `RequestHandling` (`LID`, `RequesterName`, `Job`, `DateOfRequest`, `StatusMsg`) VALUES
('1001', 'Sujatha', 'Grass Cutting', '2021-11-16', 'Done'),
('1005', 'Neeraja', 'Indoor Plants Watering', '2021-11-23', 'Ongoing'),
('1003', 'Mehuli', 'Indoor Plants Watering', '2021-11-15', 'Ongoing');

-- --------------------------------------------------------

--
-- Table structure for table `SalaryPayment`
--

CREATE TABLE `SalaryPayment` (
  `GID` varchar(6) NOT NULL,
  `DateOfPayment` date NOT NULL,
  `SalaryAmt` int(11) NOT NULL,
  `OvertimeHours` int(11) DEFAULT NULL,
  `OvertimePayment` int(11) DEFAULT NULL,
  `TotalPay` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `SalaryPayment`
--

INSERT INTO `SalaryPayment` (`GID`, `DateOfPayment`, `SalaryAmt`, `OvertimeHours`, `OvertimePayment`, `TotalPay`) VALUES
('100001', '2021-11-30', 13000, 5, 250, 13250),
('100002', '2021-11-30', 10000, 4, 200, 10200),
('100003', '2021-11-30', 10000, 2, 100, 10100),
('100004', '2021-11-30', 10000, 2, 100, 10100),
('100005', '2021-11-30', 10000, 2, 100, 10100);

-- --------------------------------------------------------

--
-- Table structure for table `WorkRosterAndRecord`
--

CREATE TABLE `WorkRosterAndRecord` (
  `GID` varchar(6) NOT NULL,
  `LID` varchar(4) NOT NULL,
  `KeyDate` date NOT NULL,
  `Shift` char(1) NOT NULL,
  `Job` varchar(20) NOT NULL,
  `HoursAlloted` int(11) NOT NULL,
  `HoursDone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `WorkRosterAndRecord`
--

INSERT INTO `WorkRosterAndRecord` (`GID`, `LID`, `KeyDate`, `Shift`, `Job`, `HoursAlloted`, `HoursDone`) VALUES
('100001', '1001', '2021-11-01', 'M', 'Lawn Care', 3, 6),
('100002', '1002', '2021-11-01', 'M', 'Lawn Care', 3, 3),
('100003', '1003', '2021-11-01', 'M', 'Lawn Care', 3, 0),
('100004', '1004', '2021-11-01', 'M', 'Lawn Care', 3, 3),
('100005', '1005', '2021-11-01', 'M', 'Lawn Care', 3, 3),
('100001', '1006', '2021-11-01', 'A', 'Lawn Care', 3, 5),
('100002', '1001', '2021-11-01', 'A', 'Shrub Maintenance', 3, 5),
('100003', '1002', '2021-11-01', 'A', 'Shrub Maintenance', 3, 5),
('100004', '1003', '2021-11-01', 'A', 'Shrub Maintenance', 3, 5),
('100005', '1004', '2021-11-01', 'A', 'Shrub Maintenance', 3, 5),
('100001', '1005', '2021-11-02', 'M', 'Shrub Maintenance', 3, 3),
('100002', '1006', '2021-11-02', 'M', 'Shrub Maintenance', 3, 3),
('100003', '1001', '2021-11-02', 'M', 'Flower Bed Care', 3, 3),
('100004', '1002', '2021-11-02', 'M', 'Flower Bed Care', 3, 3),
('100005', '1003', '2021-11-02', 'M', 'Flower Bed Care', 3, 3),
('100001', '1004', '2021-11-02', 'A', 'Flower Bed Care', 3, 3),
('100002', '1005', '2021-11-02', 'A', 'Flower Bed Care', 3, 3),
('100003', '1006', '2021-11-02', 'A', 'Flower Bed Care', 3, 3),
('100004', '1001', '2021-11-02', 'A', 'Weeding', 3, 3),
('100005', '1002', '2021-11-02', 'A', 'Weeding', 3, 3),
('100001', '1003', '2021-11-03', 'M', 'Weeding', 3, 0),
('100002', '1004', '2021-11-03', 'M', 'Weeding', 3, 5);

--
-- Triggers `WorkRosterAndRecord`
--
DELIMITER $$
CREATE TRIGGER `after_WorkRosterAndRecord_update` AFTER UPDATE ON `WorkRosterAndRecord` FOR EACH ROW BEGIN
	IF new.HoursDone = 0 THEN
    	UPDATE AbsenteesList 
        SET NumOfShiftsMissed = NumOfShiftsMissed + 1 WHERE GID = new.GID;
    ELSE
    	UPDATE AbsenteesList 
        SET NumOfShiftsMissed = NumOfShiftsMissed WHERE GID = new.GID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `before_WorkRosterAndRecord_update` AFTER UPDATE ON `WorkRosterAndRecord` FOR EACH ROW BEGIN
	IF new.HoursDone > new.HoursAlloted THEN
    	UPDATE SalaryPayment 
        SET OvertimeHours = OvertimeHours + new.HoursDone - new.HoursAlloted WHERE GID = new.GID;
        UPDATE  SalaryPayment 
        SET OvertimePayment = OvertimeHours*50 WHERE GID = new.GID;
        UPDATE  SalaryPayment 
        SET TotalPay = SalaryAmt + OvertimePayment WHERE GID = new.GID;
    ELSE
    UPDATE SalaryPayment 
    SET OvertimeHours = OvertimeHours WHERE GID = new.GID;
     UPDATE  SalaryPayment 
        SET OvertimePayment = OvertimeHours*50 WHERE GID = new.GID;
     UPDATE  SalaryPayment 
        SET TotalPay = SalaryAmt + OvertimePayment WHERE GID = new.GID;
    
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Date`
--
ALTER TABLE `Date`
  ADD PRIMARY KEY (`KeyDate`);

--
-- Indexes for table `EquipMaintainenceInfo`
--
ALTER TABLE `EquipMaintainenceInfo`
  ADD KEY `fk` (`ENumber`);

--
-- Indexes for table `EquipmentInfo`
--
ALTER TABLE `EquipmentInfo`
  ADD PRIMARY KEY (`ENumber`);

--
-- Indexes for table `GardenerInfo`
--
ALTER TABLE `GardenerInfo`
  ADD PRIMARY KEY (`GID`);

--
-- Indexes for table `LandscapeInfo`
--
ALTER TABLE `LandscapeInfo`
  ADD PRIMARY KEY (`LID`);

--
-- Indexes for table `RequestHandling`
--
ALTER TABLE `RequestHandling`
  ADD KEY `fk_l` (`LID`);

--
-- Indexes for table `SalaryPayment`
--
ALTER TABLE `SalaryPayment`
  ADD KEY `fk_gid` (`GID`);

--
-- Indexes for table `WorkRosterAndRecord`
--
ALTER TABLE `WorkRosterAndRecord`
  ADD KEY `fk1` (`GID`),
  ADD KEY `fk2` (`LID`),
  ADD KEY `fk3` (`KeyDate`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `EquipMaintainenceInfo`
--
ALTER TABLE `EquipMaintainenceInfo`
  ADD CONSTRAINT `fk` FOREIGN KEY (`ENumber`) REFERENCES `EquipmentInfo` (`ENumber`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `RequestHandling`
--
ALTER TABLE `RequestHandling`
  ADD CONSTRAINT `fk_l` FOREIGN KEY (`LID`) REFERENCES `LandscapeInfo` (`LID`);

--
-- Constraints for table `SalaryPayment`
--
ALTER TABLE `SalaryPayment`
  ADD CONSTRAINT `fk_gid` FOREIGN KEY (`GID`) REFERENCES `GardenerInfo` (`GID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `WorkRosterAndRecord`
--
ALTER TABLE `WorkRosterAndRecord`
  ADD CONSTRAINT `fk1` FOREIGN KEY (`GID`) REFERENCES `GardenerInfo` (`GID`),
  ADD CONSTRAINT `fk2` FOREIGN KEY (`LID`) REFERENCES `LandscapeInfo` (`LID`),
  ADD CONSTRAINT `fk3` FOREIGN KEY (`KeyDate`) REFERENCES `Date` (`KeyDate`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
