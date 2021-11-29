-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 05:41 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `market_shop`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `addAcademicYr` ()  BEGIN
DECLARE shopCount, itr int DEFAULT 0;
DECLARE _sid int;
SELECT COUNT(*) INTO shopCount FROM shop;
SET itr = 0;
WHILE itr < shopCount DO
	SELECT SID INTO _sid FROM shop LIMIT itr,1;
    IF(NOT EXISTS(SELECT * FROM annual_rent WHERE SID = _sid AND AcademicYr = EXTRACT(year from CURDATE()))) THEN
    	INSERT INTO annual_rent (AcademicYr, SID) VALUES (EXTRACT(year from CURDATE()), _sid);
    END IF;
    IF(NOT EXISTS(SELECT * FROM annual_elec_bill WHERE SID = _sid AND AcademicYr = EXTRACT(year from CURDATE()))) THEN
    	INSERT INTO annual_elec_bill (AcademicYr, SID) VALUES (EXTRACT(year from CURDATE()), _sid);
    END IF;
    SET itr = itr + 1;
END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `giveExtension` (IN `shop_id` INT)  IF (((SELECT LP_ExpiryDate FROM shop WHERE SID = shop_id) = CURDATE()) AND ((SELECT AVG(Score) FROM feedback WHERE SID = shop_id GROUP BY SID) >= 3) AND ((SELECT AVG(`Score`)FROM `feedback` WHERE `SID` = shop_id GROUP BY `SID`) < 4)) THEN
	UPDATE shop SET ExtensionPeriod = 2 WHERE SID = shop_id;
    UPDATE shop SET LicensePeriod = LicensePeriod + 2 WHERE SID = shop_id;
    UPDATE shop SET LP_StartDate = DATE_ADD(LP_ExpiryDate, INTERVAL 1 DAY) WHERE SID = shop_id;
    UPDATE shop SET LP_ExpiryDate = DATE_ADD(LP_ExpiryDate, INTERVAL 2 YEAR) WHERE SID = shop_id;
ELSEIF (((SELECT LP_ExpiryDate FROM shop WHERE SID = shop_id) = CURDATE()) AND ((SELECT AVG(Score) FROM feedback WHERE SID = shop_id GROUP BY SID) >= 4)) THEN
    UPDATE shop SET ExtensionPeriod = 4 WHERE SID = shop_id;
    UPDATE shop SET LicensePeriod = LicensePeriod + 4 WHERE SID = shop_id;
    UPDATE shop SET LP_StartDate = DATE_ADD(LP_ExpiryDate, INTERVAL 1 DAY) WHERE SID = shop_id;
    UPDATE shop SET LP_ExpiryDate = DATE_ADD(LP_ExpiryDate, INTERVAL 4 YEAR) WHERE SID = shop_id;
END IF$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `reminderLicenseExpiry` (`shop_id` INT) RETURNS VARCHAR(100) CHARSET utf8mb4 BEGIN
	DECLARE diff INT;
	DECLARE exp_date DATE;
	DECLARE reminder VARCHAR(100);
	SELECT LP_ExpiryDate INTO exp_date FROM shop WHERE SID = shop_id;
	SET diff = DATEDIFF(exp_date, CURDATE());
	SET reminder = CONCAT("Your shop's license expires in ", diff, " days");
	RETURN (reminder);
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdmID` int(11) NOT NULL,
  `AdmName` varchar(20) NOT NULL,
  `Password` varchar(42) NOT NULL,
  `Department` varchar(20) NOT NULL,
  `Contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`AdmID`, `AdmName`, `Password`, `Department`, `Contact`) VALUES
(2, 'admin2', '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'CBE', '9987766666'),
(1, 'admin1', '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'CSE', '5678009712');

-- --------------------------------------------------------

--
-- Table structure for table `annual_elec_bill`
--

CREATE TABLE `annual_elec_bill` (
  `AcademicYr` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `JanStat` tinyint(1) NOT NULL DEFAULT 0,
  `FebStat` tinyint(1) NOT NULL DEFAULT 0,
  `MarStat` tinyint(1) NOT NULL DEFAULT 0,
  `AprStat` tinyint(1) NOT NULL DEFAULT 0,
  `MayStat` tinyint(1) NOT NULL DEFAULT 0,
  `JunStat` tinyint(1) NOT NULL DEFAULT 0,
  `JulStat` tinyint(1) NOT NULL DEFAULT 0,
  `AugStat` tinyint(1) NOT NULL DEFAULT 0,
  `SepStat` tinyint(1) NOT NULL DEFAULT 0,
  `OctStat` tinyint(1) NOT NULL DEFAULT 0,
  `NovStat` tinyint(1) NOT NULL DEFAULT 0,
  `DecStat` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `annual_elec_bill`
--

INSERT INTO `annual_elec_bill` (`AcademicYr`, `SID`, `JanStat`, `FebStat`, `MarStat`, `AprStat`, `MayStat`, `JunStat`, `JulStat`, `AugStat`, `SepStat`, `OctStat`, `NovStat`, `DecStat`) VALUES
(2019, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2020, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2020, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 60, 0, 0, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0),
(2021, 61, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 1342, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `annual_rent`
--

CREATE TABLE `annual_rent` (
  `AcademicYr` int(11) NOT NULL,
  `SID` int(11) NOT NULL,
  `JanStat` tinyint(1) NOT NULL DEFAULT 0,
  `FebStat` tinyint(1) NOT NULL DEFAULT 0,
  `MarStat` tinyint(1) NOT NULL DEFAULT 0,
  `AprStat` tinyint(1) NOT NULL DEFAULT 0,
  `MayStat` tinyint(1) NOT NULL DEFAULT 0,
  `JunStat` tinyint(1) NOT NULL DEFAULT 0,
  `JulStat` tinyint(1) NOT NULL DEFAULT 0,
  `AugStat` tinyint(1) NOT NULL DEFAULT 0,
  `SepStat` tinyint(1) NOT NULL DEFAULT 0,
  `OctStat` tinyint(1) NOT NULL DEFAULT 0,
  `NovStat` tinyint(1) NOT NULL DEFAULT 0,
  `DecStat` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `annual_rent`
--

INSERT INTO `annual_rent` (`AcademicYr`, `SID`, `JanStat`, `FebStat`, `MarStat`, `AprStat`, `MayStat`, `JunStat`, `JulStat`, `AugStat`, `SepStat`, `OctStat`, `NovStat`, `DecStat`) VALUES
(2019, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2020, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2020, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0),
(2021, 2, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 3, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 6, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(2021, 60, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2021, 61, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0),
(2021, 1342, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `association`
--

CREATE TABLE `association` (
  `SID` int(11) DEFAULT NULL,
  `SkID` int(11) NOT NULL,
  `DoJ` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `association`
--

INSERT INTO `association` (`SID`, `SkID`, `DoJ`) VALUES
(1, 1, '2021-11-29 14:39:48'),
(4, 2, '2021-11-29 14:39:48'),
(5, 3, '2021-11-29 14:39:48'),
(60, 4, '2021-11-29 14:39:48'),
(1, 5, '2021-11-29 14:41:29'),
(3, 6, '2021-11-29 14:39:48'),
(1, 7, '2021-11-29 14:39:48'),
(1, 8, '2021-11-29 14:39:48'),
(61, 9, '2021-11-29 14:39:48'),
(3, 10, '2021-11-29 14:39:48'),
(1, 11, '2021-11-29 14:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `PurID` int(11) NOT NULL,
  `SID` int(11) DEFAULT NULL,
  `CustomerName` varchar(20) DEFAULT NULL,
  `TotalAmount` int(11) DEFAULT NULL,
  `ItemsBought` varchar(50) DEFAULT NULL,
  `Score` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`PurID`, `SID`, `CustomerName`, `TotalAmount`, `ItemsBought`, `Score`) VALUES
(1, 1, '', 100, '', 4),
(2, 3, '', 0, '', 3),
(3, 1, '', 120, 'Basket', 4),
(7, 4, 'Ash', 100, '', 2),
(8, 3, 'Nany', 320, '', 3),
(9, 3, '', 120, 'Bakery', 4),
(10, 60, '', 1220, 'Birthday Cake', 4),
(11, 61, '', 220, '', 3),
(12, 5, '', 10, 'Frooti', 4),
(13, 5, '', 1000, 'Birthday Cake', 5);

-- --------------------------------------------------------

--
-- Table structure for table `request_add_sk`
--

CREATE TABLE `request_add_sk` (
  `ReqID` int(11) NOT NULL,
  `_SkName` varchar(20) NOT NULL,
  `_AadharID` varchar(12) NOT NULL,
  `_Address` varchar(50) NOT NULL,
  `_Gender` char(1) NOT NULL,
  `_Contact` varchar(10) NOT NULL,
  `_SID` int(11) DEFAULT NULL,
  `SkID_requester` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_add_sk`
--

INSERT INTO `request_add_sk` (`ReqID`, `_SkName`, `_AadharID`, `_Address`, `_Gender`, `_Contact`, `_SID`, `SkID_requester`) VALUES
(1, 'shopkeeper7', '', '', '', '', 1, NULL),
(3, 'shopkeeper70', '868686890098', '', 'F', '2367977090', 60, 2),
(4, 'shopkeeper71', '789686890098', '', 'M', '2389767090', 61, 3),
(5, 'shopkeeper72', '567886890098', '', 'F', '8907977090', 2, 4),
(6, 'shopkeeper73', '889986890098', '', 'M', '2369077090', 4, 2),
(7, 'shopkeeper74', '868698890098', '', 'F', '2876577090', 5, 6),
(8, 'shopkeeper75', '868686890889', '', 'M', '7899977090', 2, 6),
(9, 'shopkeeper80', '868686890098', '', 'M', '2367977090', 60, 2),
(10, 'shopkeeper79', '868686890098', '', 'F', '2367977090', 6, 6),
(11, 'shopkeeper90', '123456789089', '', '', '9123545877', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request_elec_bill`
--

CREATE TABLE `request_elec_bill` (
  `SID` int(11) NOT NULL,
  `PayForWhichMonth` int(11) NOT NULL,
  `PayForWhichYear` int(11) NOT NULL,
  `PayeeName` varchar(20) NOT NULL,
  `PayDateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Amount` int(11) NOT NULL,
  `SkID_requester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_elec_bill`
--

INSERT INTO `request_elec_bill` (`SID`, `PayForWhichMonth`, `PayForWhichYear`, `PayeeName`, `PayDateTime`, `Amount`, `SkID_requester`) VALUES
(2, 1, 2021, 'shopkeeper1', '2021-11-29 05:48:31', 700, 1),
(3, 1, 2021, 'shopkeeper2', '2021-11-29 05:48:31', 700, 2),
(4, 1, 2021, 'shopkeeper3', '2021-11-29 05:48:31', 700, 3),
(6, 1, 2021, 'shopkeeper4', '2021-11-29 05:48:31', 700, 4),
(2, 5, 2021, 'shopkeeper1', '2021-11-29 05:48:31', 700, 1),
(3, 5, 2021, 'shopkeeper2', '2021-11-29 05:48:31', 700, 2),
(4, 5, 2021, 'shopkeeper3', '2021-11-29 05:48:31', 700, 3),
(6, 5, 2021, 'shopkeeper4', '2021-11-29 05:48:31', 700, 4),
(7, 5, 2021, 'shopkeeper5', '2021-11-29 05:48:31', 700, 6),
(1, 7, 2021, 'shopkeeper1', '2021-11-29 20:05:55', 100, 1),
(1, 12, 2020, 'shopkeeper1', '2021-11-29 01:33:12', 300, 1);

-- --------------------------------------------------------

--
-- Table structure for table `request_rent`
--

CREATE TABLE `request_rent` (
  `SID` int(11) NOT NULL,
  `PayForWhichMonth` int(11) NOT NULL,
  `PayForWhichYear` int(11) NOT NULL,
  `PayeeName` varchar(20) NOT NULL,
  `PayDateTime` datetime NOT NULL DEFAULT current_timestamp(),
  `Amount` int(11) NOT NULL,
  `SkID_requester` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `request_rent`
--

INSERT INTO `request_rent` (`SID`, `PayForWhichMonth`, `PayForWhichYear`, `PayeeName`, `PayDateTime`, `Amount`, `SkID_requester`) VALUES
(2, 1, 2021, 'shopkeeper1', '2021-11-29 05:49:36', 700, 1),
(3, 1, 2021, 'shopkeeper2', '2021-11-29 05:49:36', 700, 2),
(4, 1, 2021, 'shopkeeper3', '2021-11-29 05:49:36', 700, 3),
(6, 1, 2021, 'shopkeeper4', '2021-11-29 05:49:36', 700, 4),
(2, 4, 2021, '', '2021-11-29 18:11:27', 200, 4),
(1, 5, 2020, 'shopkeeper1', '2021-11-29 01:32:52', 290, 1),
(3, 5, 2021, 'shopkeeper2', '2021-11-29 05:49:36', 700, 2),
(4, 5, 2021, 'shopkeeper3', '2021-11-29 05:49:36', 700, 3),
(6, 5, 2021, 'shopkeeper4', '2021-11-29 05:49:36', 700, 4),
(7, 5, 2021, 'shopkeeper5', '2021-11-29 05:49:36', 700, 6),
(1, 7, 2021, 'shopkeeper1', '2021-11-29 20:05:38', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `SID` int(11) NOT NULL,
  `SName` varchar(20) NOT NULL,
  `OwnerName` varchar(20) NOT NULL,
  `Contact` varchar(10) NOT NULL,
  `Location` varchar(30) NOT NULL,
  `Area` int(11) NOT NULL,
  `LP_StartDate` date NOT NULL,
  `LP_ExpiryDate` date NOT NULL,
  `LicensePeriod` int(11) NOT NULL,
  `ExtensionPeriod` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`SID`, `SName`, `OwnerName`, `Contact`, `Location`, `Area`, `LP_StartDate`, `LP_ExpiryDate`, `LicensePeriod`, `ExtensionPeriod`) VALUES
(1, 'Nescafe123', 'shopkeeper1', '', 'Tutorial Block', 0, '2021-11-29', '2025-11-28', 6, 4),
(2, 'Night Canteen', 'shopkeeper2', '9887655432', 'Food Court', 800, '2021-01-01', '2022-01-01', 1, 0),
(3, 'shop3', 'shopkeeper3', '', 'Admin Building', 0, '0000-00-00', '0000-00-00', 0, 0),
(4, 'shop4', 'shopkeeper4', '', 'Food Court', 0, '0000-00-00', '0000-00-00', 0, 0),
(5, 'Frostic Shop', 'Anshu', '1234567890', 'Near OBH', 0, '2021-11-01', '0000-00-00', 2, 0),
(6, 'Food Canteen', 'shopkeeper6', '9087655432', 'Cycle Shop', 810, '2021-01-01', '2022-01-01', 1, 0),
(7, 'Night Canteen', 'shopkeeper7', '9888905432', 'Saloon', 700, '2021-01-01', '2022-01-01', 1, 0),
(60, 'Frostik Shop2', 'Mehuli', '', 'Food Court', 0, '0000-00-00', '0000-00-00', 0, 0),
(61, 'Eskrim2', '', '', 'Old Boy\'s Hostel', 0, '0000-00-00', '0000-00-00', 0, 0),
(1342, 'Eskrim', 'Pomo', '9123546733', 'Near OBH', 189, '2020-11-29', '2021-11-12', 4, 5);

-- --------------------------------------------------------

--
-- Table structure for table `shopkeeper`
--

CREATE TABLE `shopkeeper` (
  `SkID` int(11) NOT NULL,
  `Password` varchar(42) NOT NULL,
  `SkName` varchar(20) NOT NULL,
  `AadharID` varchar(12) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Gender` char(1) NOT NULL,
  `SecurityPassExp` date NOT NULL,
  `Contact` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shopkeeper`
--

INSERT INTO `shopkeeper` (`SkID`, `Password`, `SkName`, `AadharID`, `Address`, `Gender`, `SecurityPassExp`, `Contact`) VALUES
(1, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper1', '123456789012', '', '', '2021-11-04', '9123546733'),
(2, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper2', '987663237326', 'Patna', 'F', '2023-11-14', '4566778889'),
(3, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper3', '', '', '', '2023-11-15', ''),
(4, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper4', '', '', '', '2021-11-26', ''),
(5, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper100', '123456789045', '', '', '2023-11-16', ''),
(6, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper6', '987663237329', '22/B Jodhpur Street', 'F', '2022-11-22', '4566778880'),
(7, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper7', '987663234526', '22/B Jodhpur Street', 'M', '2021-11-22', '8966778889'),
(8, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper8', '', '', '', '2022-11-22', ''),
(9, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper9', '123456789012', '45/A/1 Barrackpore', 'M', '2023-01-01', '9876543210'),
(10, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'shopkeeper6', '', '', '', '2024-06-28', ''),
(11, '9259518b42378dbe174d403ea22fb6ffa8ceb870', 'Ram', '123456789012', '', 'M', '2021-12-09', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `annual_elec_bill`
--
ALTER TABLE `annual_elec_bill`
  ADD PRIMARY KEY (`AcademicYr`,`SID`),
  ADD KEY `elec_sid_index` (`SID`),
  ADD KEY `elec_acadyr_index` (`AcademicYr`);

--
-- Indexes for table `annual_rent`
--
ALTER TABLE `annual_rent`
  ADD PRIMARY KEY (`AcademicYr`,`SID`),
  ADD KEY `rent_sid_index` (`SID`),
  ADD KEY `rent_acadyr_index` (`AcademicYr`);

--
-- Indexes for table `association`
--
ALTER TABLE `association`
  ADD PRIMARY KEY (`SkID`),
  ADD KEY `sid_fk` (`SID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`PurID`),
  ADD KEY `feedback_index` (`SID`);

--
-- Indexes for table `request_add_sk`
--
ALTER TABLE `request_add_sk`
  ADD PRIMARY KEY (`ReqID`),
  ADD KEY `req_sk_fk` (`_SID`),
  ADD KEY `skid_addsk_fk` (`SkID_requester`);

--
-- Indexes for table `request_elec_bill`
--
ALTER TABLE `request_elec_bill`
  ADD PRIMARY KEY (`PayForWhichMonth`,`PayForWhichYear`,`SkID_requester`),
  ADD KEY `elecreq_fk2` (`SID`),
  ADD KEY `skid_elec_fk2` (`SkID_requester`);

--
-- Indexes for table `request_rent`
--
ALTER TABLE `request_rent`
  ADD PRIMARY KEY (`PayForWhichMonth`,`PayForWhichYear`,`SkID_requester`),
  ADD KEY `rentreq_fk2` (`SID`),
  ADD KEY `skid_rent_fk2` (`SkID_requester`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`SID`);

--
-- Indexes for table `shopkeeper`
--
ALTER TABLE `shopkeeper`
  ADD PRIMARY KEY (`SkID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `PurID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `request_add_sk`
--
ALTER TABLE `request_add_sk`
  MODIFY `ReqID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `annual_elec_bill`
--
ALTER TABLE `annual_elec_bill`
  ADD CONSTRAINT `sidelec_fk` FOREIGN KEY (`SID`) REFERENCES `shop` (`SID`);

--
-- Constraints for table `annual_rent`
--
ALTER TABLE `annual_rent`
  ADD CONSTRAINT `sidrent_fk` FOREIGN KEY (`SID`) REFERENCES `shop` (`SID`);

--
-- Constraints for table `association`
--
ALTER TABLE `association`
  ADD CONSTRAINT `sid_fk` FOREIGN KEY (`SID`) REFERENCES `shop` (`SID`),
  ADD CONSTRAINT `skid_fk` FOREIGN KEY (`SkID`) REFERENCES `shopkeeper` (`SkID`);

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_fk` FOREIGN KEY (`SID`) REFERENCES `shop` (`SID`);

--
-- Constraints for table `request_add_sk`
--
ALTER TABLE `request_add_sk`
  ADD CONSTRAINT `req_sk_fk` FOREIGN KEY (`_SID`) REFERENCES `shop` (`SID`),
  ADD CONSTRAINT `skid_addsk_fk` FOREIGN KEY (`SkID_requester`) REFERENCES `shopkeeper` (`SkID`);

--
-- Constraints for table `request_elec_bill`
--
ALTER TABLE `request_elec_bill`
  ADD CONSTRAINT `elecreq_fk` FOREIGN KEY (`SID`) REFERENCES `shop` (`SID`),
  ADD CONSTRAINT `skid_elec_fk` FOREIGN KEY (`SkID_requester`) REFERENCES `shopkeeper` (`SkID`);

--
-- Constraints for table `request_rent`
--
ALTER TABLE `request_rent`
  ADD CONSTRAINT `rentreq_fk` FOREIGN KEY (`SID`) REFERENCES `shop` (`SID`),
  ADD CONSTRAINT `skid_rent_fk` FOREIGN KEY (`SkID_requester`) REFERENCES `shopkeeper` (`SkID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
