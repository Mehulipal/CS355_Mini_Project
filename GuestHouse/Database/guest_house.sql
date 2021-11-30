-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2021 at 11:03 PM
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
-- Database: `guest_house`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `FoodBill` (IN `InGuestID` INT, OUT `ans` INT)  BEGIN
DECLARE cnt, itr int DEFAULT 0;
DECLARE nop int;
DECLARE p1 int;
Select count(*) into cnt from foodBooking where GuestID= InGuestID;
SET itr = 0;
SELECT itr into ans;
WHILE itr < cnt DO
SELECT NoOfPlates INTO nop FROM foodbooking WHERE GuestID=InGuestID LIMIT itr,1;
Select price into p1 from foodDetails where FoodID= (SELECT FoodID FROM foodBooking WHERE GuestID=InGuestID LIMIT itr,1);
SET ans = ans + p1*nop;
SET itr = itr + 1;
END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `FoodBillMonthly` (IN `mn` INT, OUT `ans` INT)  BEGIN
DECLARE cnt, itr int DEFAULT 0;
DECLARE nop int;
DECLARE p1 int;
Select count(*) into cnt from foodBooking where MONTH(BookingDT)= mn;
SET itr = 0;
SELECT itr into ans;
WHILE itr < cnt DO
SELECT NoOfPlates INTO nop FROM foodbooking WHERE MONTH(BookingDT)= mn LIMIT itr,1;
Select price into p1 from foodDetails where FoodID= (SELECT FoodID FROM foodBooking WHERE MONTH(BookingDT)= mn LIMIT itr,1);
SET ans = ans + p1*nop;
SET itr = itr + 1;
END WHILE;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `RoomRent` (IN `InGuestID` INT, OUT `ans` INT)  BEGIN
Declare p1 int;
Declare d1 int;
Declare it int;

Select RoomPrice into p1 from roomtype where roomTypeID = (select roomTypeID from roominfo,reserve where guestId = InGuestID AND roominfo.RoomNo = reserve.RoomNo AND ReservationStatus = 1); 
Select datediff(SYSDATE(),CheckInDT) into it from reserve where GuestID=InGuestID;
IF it<0 THEN SET d1=0;
Else 
Select datediff(SYSDATE(),CheckInDT) into d1 from reserve where GuestID=InGuestID;
End If;
Select p1*d1 into ans;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `absenteeslist`
--

CREATE TABLE `absenteeslist` (
  `StaffID` int(11) NOT NULL,
  `NoOfShiftMissed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absenteeslist`
--

INSERT INTO `absenteeslist` (`StaffID`, `NoOfShiftMissed`) VALUES
(1, 1),
(2, 0);

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
(1, '', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `alldates`
--

CREATE TABLE `alldates` (
  `KeyDate` date NOT NULL,
  `isHoliday` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alldates`
--

INSERT INTO `alldates` (`KeyDate`, `isHoliday`) VALUES
('2021-11-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `emp`
--

CREATE TABLE `emp` (
  `EmpID` varchar(20) NOT NULL,
  `Name` text NOT NULL,
  `Department` text NOT NULL,
  `Designation` text NOT NULL,
  `PhoneNo` bigint(20) NOT NULL,
  `Email` text NOT NULL,
  `Password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `emp`
--

INSERT INTO `emp` (`EmpID`, `Name`, `Department`, `Designation`, `PhoneNo`, `Email`, `Password`) VALUES
('1901CS76', 'Mahima Rai', 'CSE', 'Student', 9608847284, 'abc@iitp.ac.in', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
('1901CS78', 'Mehuli Pal', 'CSE', 'Student', 9998887777, 'xyz@iitp.ac.in', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220');

-- --------------------------------------------------------

--
-- Table structure for table `foodbooking`
--

CREATE TABLE `foodbooking` (
  `FoodBkID` int(11) NOT NULL,
  `FoodID` int(11) NOT NULL,
  `GuestID` int(20) NOT NULL,
  `NoOfPlates` int(11) NOT NULL,
  `FoodBkStatus` tinyint(1) NOT NULL,
  `ServingDate` date NOT NULL,
  `BookingDT` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `foodbooking`
--

INSERT INTO `foodbooking` (`FoodBkID`, `FoodID`, `GuestID`, `NoOfPlates`, `FoodBkStatus`, `ServingDate`, `BookingDT`) VALUES
(1, 1, 100, 2, 1, '2021-11-30', '2021-11-29 13:52:56'),
(2, 1, 100, 2, 1, '2021-11-30', '2021-11-29 13:53:26'),
(3, 3, 112, 2, 1, '2021-12-28', '2021-12-28 02:46:46');

--
-- Triggers `foodbooking`
--
DELIMITER $$
CREATE TRIGGER `after_FoodBooking_insert` AFTER INSERT ON `foodbooking` FOR EACH ROW BEGIN
IF EXISTS (SELECT * FROM payments WHERE GuestID = new.GuestID) THEN
        call FoodBill(new.GuestID,@op);
    	UPDATE payments 
        SET FoodBill = (SELECT @op) WHERE GuestID = new.GuestID;
    ELSE
    call FoodBill(new.GuestID,@op);
    INSERT INTO payments VALUES (new.GuestID,0, @op);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `fooddetails`
--

CREATE TABLE `fooddetails` (
  `FoodID` int(11) NOT NULL,
  `TypeOfMeal` varchar(1) NOT NULL,
  `Price` int(11) NOT NULL,
  `Day` int(1) NOT NULL,
  `VegOrNon` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `fooddetails`
--

INSERT INTO `fooddetails` (`FoodID`, `TypeOfMeal`, `Price`, `Day`, `VegOrNon`) VALUES
(1, 'B', 25, 1, 'V'),
(2, 'B', 30, 1, 'N'),
(3, 'L', 60, 1, 'V');

-- --------------------------------------------------------

--
-- Table structure for table `guestinfo`
--

CREATE TABLE `guestinfo` (
  `GuestID` int(20) NOT NULL,
  `GuestName` text NOT NULL,
  `EmpID` varchar(20) NOT NULL,
  `PhoneNo` bigint(20) NOT NULL,
  `AdhaarNo` text NOT NULL,
  `Address` text NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `PayBy` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guestinfo`
--

INSERT INTO `guestinfo` (`GuestID`, `GuestName`, `EmpID`, `PhoneNo`, `AdhaarNo`, `Address`, `Gender`, `PayBy`) VALUES
(7, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(8, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(9, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(10, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(11, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(12, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(13, 'mehuli', '1901CS76', 9608847284, 'abcd1234', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(14, 'mehuli', '1901CS76', 9608847284, 'mnbsgey', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(15, 'mehuli', '1901CS76', 9608847284, 'abcd123u3', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(16, 'mehuli', '1901CS76', 9608847284, 'mnbsgeyhg', 'D-156,Shri Ram Krishna Kunj, Dharam Narayan Ji Ka Hattha, Paota, Jodhpur, Rajasthan, 342006', 'F', ''),
(18, 'Jenish', '1901CS76', 9027371955, 'hdjfherhjfj', 'jhfjqguerbfhjrbf', 'M', 'Guest'),
(57, 'Jenish', '1901CS76', 9027371955, 'hdjfherhjfj', 'jhfjqguerbfhjrbf', 'M', 'Guest'),
(61, 'Jenish', '1901CS76', 9027371955, 'hdjfherhjfj', 'jhfjqguerbfhjrbf', 'M', 'Guest'),
(90, 'Jenish', '1901CS76', 9027371955, 'hdjfherhjfj', 'jhfjqguerbfhjrbf', 'M', 'Guest'),
(100, 'mahima', '1901CS76', 9027371955, 'hgdjegfjew', 'jhdjgwgwjqd', 'F', 'Guest'),
(112, 'shruti', '1901CS76', 90876544321, 'jaiyyana', 'kehdiuwefhiehfiuefhief', 'F', 'indentor');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `GuestID` int(11) NOT NULL,
  `RoomRent` int(11) NOT NULL,
  `FoodBill` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`GuestID`, `RoomRent`, `FoodBill`) VALUES
(100, 2400, 100),
(112, 0, 120);

-- --------------------------------------------------------

--
-- Table structure for table `requesttable`
--

CREATE TABLE `requesttable` (
  `GuestName` text NOT NULL,
  `EmpID` varchar(20) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `AadhaarNo` text NOT NULL,
  `Address` text NOT NULL,
  `PhoneNo` bigint(10) NOT NULL,
  `CheckInDT` datetime NOT NULL,
  `CheckOutDT` datetime NOT NULL,
  `BookingDate` date NOT NULL,
  `RoomDesc` text NOT NULL,
  `PaymentBy` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `requesttable`
--

INSERT INTO `requesttable` (`GuestName`, `EmpID`, `Gender`, `AadhaarNo`, `Address`, `PhoneNo`, `CheckInDT`, `CheckOutDT`, `BookingDate`, `RoomDesc`, `PaymentBy`) VALUES
('Sujatha', '1901CS78', 'F', 'ABCDERTYU', 'jaipur', 9876543210, '2021-12-08 03:24:41', '2021-11-17 03:24:41', '2021-11-30', 'With Attached Bathroom', 'Guest');

-- --------------------------------------------------------

--
-- Table structure for table `reserve`
--

CREATE TABLE `reserve` (
  `ReserveID` int(20) NOT NULL,
  `GuestID` int(20) NOT NULL,
  `RoomNo` bigint(20) NOT NULL,
  `ReservationStatus` tinyint(1) NOT NULL,
  `CheckInDT` datetime NOT NULL,
  `CheckOutDT` datetime NOT NULL,
  `BookingDT` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reserve`
--

INSERT INTO `reserve` (`ReserveID`, `GuestID`, `RoomNo`, `ReservationStatus`, `CheckInDT`, `CheckOutDT`, `BookingDT`) VALUES
(1, 7, 101, 0, '2022-01-12 20:50:20', '2022-05-12 20:50:20', '2021-11-28'),
(2, 57, 101, 0, '2021-11-30 23:45:21', '2021-11-30 15:45:21', '2021-11-28'),
(10, 100, 102, 1, '2021-11-25 19:02:10', '2021-11-30 19:02:10', '2021-11-21');

--
-- Triggers `reserve`
--
DELIMITER $$
CREATE TRIGGER `after_reservation_insert` AFTER INSERT ON `reserve` FOR EACH ROW BEGIN
IF EXISTS (SELECT * FROM payments WHERE GuestID = new.GuestID) THEN
        call RoomRent(new.GuestID,@op);
    	UPDATE payments 
        SET RoomRent = (SELECT @op) WHERE GuestID = new.GuestID;
    ELSE
    call RoomRent(new.GuestID,@op);
    INSERT INTO payments VALUES (new.GuestID,@op,0);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `roominfo`
--

CREATE TABLE `roominfo` (
  `RoomNo` bigint(20) NOT NULL,
  `RoomTypeID` int(20) NOT NULL,
  `Availability` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roominfo`
--

INSERT INTO `roominfo` (`RoomNo`, `RoomTypeID`, `Availability`) VALUES
(101, 1, 1),
(102, 2, 0);

-- --------------------------------------------------------

--
-- Table structure for table `roomtype`
--

CREATE TABLE `roomtype` (
  `RoomTypeID` int(20) NOT NULL,
  `RoomDesc` text NOT NULL,
  `RoomPrice` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `roomtype`
--

INSERT INTO `roomtype` (`RoomTypeID`, `RoomDesc`, `RoomPrice`) VALUES
(1, 'With Attached Bathroom', 800),
(2, 'With Non-Attached Bathroom', 600);

-- --------------------------------------------------------

--
-- Table structure for table `shiftdetails`
--

CREATE TABLE `shiftdetails` (
  `ShiftID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `KeyDate` date NOT NULL,
  `HoursAllocated` int(11) NOT NULL,
  `HoursWorked` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shiftdetails`
--

INSERT INTO `shiftdetails` (`ShiftID`, `StaffID`, `KeyDate`, `HoursAllocated`, `HoursWorked`) VALUES
(2, 1, '2021-11-30', 5, 90),
(3, 1, '2021-11-30', 5, 0);

--
-- Triggers `shiftdetails`
--
DELIMITER $$
CREATE TRIGGER `after_shiftDetails_update` AFTER UPDATE ON `shiftdetails` FOR EACH ROW BEGIN
	IF new.HoursWorked = 0 THEN
    	UPDATE AbsenteesList 
        SET NoOfShiftMissed = NoOfShiftMissed + 1 WHERE StaffID = new.StaffID;
    ELSE
    	UPDATE AbsenteesList 
        SET NoOfShiftMissed = NoOfShiftMissed WHERE StaffID = new.StaffID;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_shiftdetails_update_forOvertimePay` AFTER UPDATE ON `shiftdetails` FOR EACH ROW BEGIN
IF new.HoursWorked > new.HoursAllocated THEN
    	UPDATE staffsalary 
        SET OvertimeHrs = OvertimeHrs + new.HoursWorked - new.HoursAllocated WHERE StaffID = new.StaffID;
        UPDATE  staffsalary 
        SET OvertimePay = OvertimeHrs*50,
        TotalPay = FixedSalary + OvertimePay
        WHERE StaffID = new.StaffID;
    ELSE
    UPDATE staffsalary 
    SET OvertimeHrs = OvertimeHrs WHERE StaffID = new.StaffID;
     UPDATE  staffsalary 
        SET OvertimePay = OvertimeHrs*50,
        TotalPay = FixedSalary + OvertimePay WHERE StaffID = new.StaffID;
    
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `staffdetails`
--

CREATE TABLE `staffdetails` (
  `StaffID` int(11) NOT NULL,
  `AdhaarID` text NOT NULL,
  `Name` text NOT NULL,
  `PhoneNo` bigint(10) NOT NULL,
  `Gender` varchar(1) NOT NULL,
  `EmploymentType` text NOT NULL,
  `Job` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffdetails`
--

INSERT INTO `staffdetails` (`StaffID`, `AdhaarID`, `Name`, `PhoneNo`, `Gender`, `EmploymentType`, `Job`) VALUES
(1, 'ABCD12345', 'Ramesh', 1234567890, 'M', 'Regular', 'House Cleaning'),
(2, 'ABCEF12345', 'Radha', 987654321, 'F', 'Regular', 'Cook');

-- --------------------------------------------------------

--
-- Table structure for table `staffsalary`
--

CREATE TABLE `staffsalary` (
  `StaffID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `FixedSalary` int(11) NOT NULL,
  `OvertimeHrs` int(11) NOT NULL,
  `OvertimePay` int(11) NOT NULL,
  `TotalPay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staffsalary`
--

INSERT INTO `staffsalary` (`StaffID`, `PaymentDate`, `FixedSalary`, `OvertimeHrs`, `OvertimePay`, `TotalPay`) VALUES
(1, '2021-11-30', 11000, 184, 9200, 20200),
(2, '2021-11-30', 13000, 0, 0, 13000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absenteeslist`
--
ALTER TABLE `absenteeslist`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdmID`);

--
-- Indexes for table `alldates`
--
ALTER TABLE `alldates`
  ADD PRIMARY KEY (`KeyDate`);

--
-- Indexes for table `emp`
--
ALTER TABLE `emp`
  ADD PRIMARY KEY (`EmpID`);

--
-- Indexes for table `foodbooking`
--
ALTER TABLE `foodbooking`
  ADD PRIMARY KEY (`FoodBkID`),
  ADD KEY `FK7` (`FoodID`),
  ADD KEY `FK8` (`GuestID`);

--
-- Indexes for table `fooddetails`
--
ALTER TABLE `fooddetails`
  ADD PRIMARY KEY (`FoodID`);

--
-- Indexes for table `guestinfo`
--
ALTER TABLE `guestinfo`
  ADD PRIMARY KEY (`GuestID`),
  ADD KEY `FK6` (`EmpID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD KEY `FK22` (`GuestID`);

--
-- Indexes for table `requesttable`
--
ALTER TABLE `requesttable`
  ADD KEY `FK41` (`EmpID`);

--
-- Indexes for table `reserve`
--
ALTER TABLE `reserve`
  ADD PRIMARY KEY (`ReserveID`),
  ADD KEY `FK5` (`RoomNo`),
  ADD KEY `FK4` (`GuestID`);

--
-- Indexes for table `roominfo`
--
ALTER TABLE `roominfo`
  ADD PRIMARY KEY (`RoomNo`),
  ADD KEY `FK3` (`RoomTypeID`);

--
-- Indexes for table `roomtype`
--
ALTER TABLE `roomtype`
  ADD PRIMARY KEY (`RoomTypeID`);

--
-- Indexes for table `shiftdetails`
--
ALTER TABLE `shiftdetails`
  ADD PRIMARY KEY (`ShiftID`,`StaffID`,`KeyDate`),
  ADD KEY `FK10` (`KeyDate`),
  ADD KEY `FK11` (`StaffID`);

--
-- Indexes for table `staffdetails`
--
ALTER TABLE `staffdetails`
  ADD PRIMARY KEY (`StaffID`);

--
-- Indexes for table `staffsalary`
--
ALTER TABLE `staffsalary`
  ADD KEY `FK40` (`StaffID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foodbooking`
--
ALTER TABLE `foodbooking`
  MODIFY `FoodBkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `guestinfo`
--
ALTER TABLE `guestinfo`
  MODIFY `GuestID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `reserve`
--
ALTER TABLE `reserve`
  MODIFY `ReserveID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `roomtype`
--
ALTER TABLE `roomtype`
  MODIFY `RoomTypeID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absenteeslist`
--
ALTER TABLE `absenteeslist`
  ADD CONSTRAINT `FK20` FOREIGN KEY (`StaffID`) REFERENCES `staffdetails` (`StaffID`);

--
-- Constraints for table `foodbooking`
--
ALTER TABLE `foodbooking`
  ADD CONSTRAINT `FK7` FOREIGN KEY (`FoodID`) REFERENCES `fooddetails` (`FoodID`),
  ADD CONSTRAINT `FK8` FOREIGN KEY (`GuestID`) REFERENCES `guestinfo` (`GuestID`);

--
-- Constraints for table `guestinfo`
--
ALTER TABLE `guestinfo`
  ADD CONSTRAINT `FK6` FOREIGN KEY (`EmpID`) REFERENCES `emp` (`EmpID`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `FK22` FOREIGN KEY (`GuestID`) REFERENCES `guestinfo` (`GuestID`);

--
-- Constraints for table `requesttable`
--
ALTER TABLE `requesttable`
  ADD CONSTRAINT `FK41` FOREIGN KEY (`EmpID`) REFERENCES `emp` (`EmpID`);

--
-- Constraints for table `reserve`
--
ALTER TABLE `reserve`
  ADD CONSTRAINT `FK4` FOREIGN KEY (`GuestID`) REFERENCES `guestinfo` (`GuestID`),
  ADD CONSTRAINT `FK5` FOREIGN KEY (`RoomNo`) REFERENCES `roominfo` (`RoomNo`);

--
-- Constraints for table `roominfo`
--
ALTER TABLE `roominfo`
  ADD CONSTRAINT `FK3` FOREIGN KEY (`RoomTypeID`) REFERENCES `roomtype` (`RoomTypeID`);

--
-- Constraints for table `shiftdetails`
--
ALTER TABLE `shiftdetails`
  ADD CONSTRAINT `FK10` FOREIGN KEY (`KeyDate`) REFERENCES `alldates` (`KeyDate`),
  ADD CONSTRAINT `FK11` FOREIGN KEY (`StaffID`) REFERENCES `staffdetails` (`StaffID`);

--
-- Constraints for table `staffsalary`
--
ALTER TABLE `staffsalary`
  ADD CONSTRAINT `FK40` FOREIGN KEY (`StaffID`) REFERENCES `staffdetails` (`StaffID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
