-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2013 at 06:42 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `car rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

CREATE TABLE `administrator` (
  `Username` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'Location'
--

CREATE TABLE `Location` (
`LocationName` VARCHAR( 45 ) NOT NULL ,
`Capacity` INT( 11 ) NOT NULL ,
PRIMARY KEY ( `LocationName` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` (
`Vehicle_Sno` INT(11) NOT NULL,
`auxilary_cable` INT(1) NOT NULL,
`under_maintenance_flag` INT(1) NOT NULL,
`model_name` VARCHAR(45) NOT NULL,
`car_type` VARCHAR(45) NOT NULL,
`color` VARCHAR(45) NOT NULL,
`hourly_rate` DOUBLE NOT NULL,
`daily_rate` DOUBLE NOT NULL,
`bluetooth_connectivity` INT(1) NOT NULL,
`seating_capacity` INT(11) NOT NULL,
`LocationName` VARCHAR(45) NOT NULL,
`transmission_type` VARCHAR(45) NOT NULL,
PRIMARY KEY (`Vehicle_Sno`),
KEY `lname_fkey` (`LocationName`),
CONSTRAINT `lname_fkey` FOREIGN KEY (`LocationName`) REFERENCES `Location` (`LocationName`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `driving_plan`
--

CREATE TABLE IF NOT EXISTS `driving_plan` (
  `driving_plan_type` varchar(45) NOT NULL,
  `discount` int(11) NOT NULL,
  `annual_fees` int(11) NOT NULL,
  `monthly_payment` int(11) NOT NULL,
  PRIMARY KEY (`driving_plan_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gtcr_employee`
--

CREATE TABLE `gtcr_employee` (
  `Username` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'Credit Card'
--
CREATE TABLE `Credit_Card` (
`card_number` INT( 16 ) NOT NULL ,
`Name` VARCHAR( 45 ) NOT NULL ,
`CVV` INT( 3 ) NOT NULL ,
`expiry_date` DATE NOT NULL ,
`billing_address` VARCHAR( 100 ) NOT NULL ,
PRIMARY KEY ( `card_number` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gt_student_faculty_member`
--

CREATE TABLE `gt_student_faculty_member` (
  `Username` VARCHAR(45) NOT NULL,
  `Password` VARCHAR(45) NOT NULL,
  `fname` VARCHAR(45) NOT NULL,
  `minitial` VARCHAR(1) NOT NULL,
  `lname` VARCHAR(45) NOT NULL,
  `email_address` VARCHAR(45) NOT NULL,
  `address` VARCHAR(45) NOT NULL,
  `phone_number` VARCHAR(10) NOT NULL,
  `driving_plan_type` VARCHAR(45) NOT NULL,
  `card_number` INT(16) NOT NULL,
   PRIMARY KEY (`Username`),
   CONSTRAINT `driving_plan_type_fkey` FOREIGN KEY (`driving_plan_type`) REFERENCES `driving_plan` (`driving_plan_type`),
   CONSTRAINT `card_number_fkey` FOREIGN KEY (`card_number`) REFERENCES `Credit_Card` (`card_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'Maintenance Request'
--
CREATE TABLE `Maintenance Request` (
`Username` VARCHAR( 45 ) NOT NULL ,
`Date/Time` DATETIME NOT NULL ,
`VehicleSno` VARCHAR( 10 ) NOT NULL ,
PRIMARY KEY ( `Date/Time` , `VehicleSno` ),
KEY `username_fkey` (`Username`),
CONSTRAINT `username_fkey` FOREIGN KEY (`Username`) REFERENCES `gtcr_employee` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_request_problems`
--
CREATE TABLE `maintenance_request_problems` (
`problems` VARCHAR( 150 ) NOT NULL,
`Date/Time` DATETIME NOT NULL ,
`VehicleSno` VARCHAR( 10 ) NOT NULL ,
PRIMARY KEY (`problems`, `Date/Time`, `VehicleSno`),
CONSTRAINT `datetime_fkey` FOREIGN KEY (`Date/Time`) REFERENCES `Maintenance Request` (`Date/Time`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'Reservation'
--
CREATE TABLE `Reservation` (
`pick_up_datetime` DATETIME NOT NULL ,
`ReturnDateTime` DATETIME NOT NULL ,
`Username` VARCHAR( 45 ) NOT NULL ,
`LateBy` DATE NULL DEFAULT NULL ,
`ReturnStatus` VARCHAR( 45 ) NULL DEFAULT NULL ,
`EstimatedCost` INT( 10 ) NULL DEFAULT NULL ,
`LateFees` INT( 10 ) NULL DEFAULT NULL ,
`LocationName` VARCHAR(45) NOT NULL ,
`VehicleSno` VARCHAR(11) NOT NULL ,
PRIMARY KEY ( `Username`,  `pick_up_datetime`, `ReturnDateTime`),
KEY `locname_fkey` (`LocationName`),
CONSTRAINT `locname_fkey` FOREIGN KEY (`LocationName`) REFERENCES `Location` (`LocationName`) ON DELETE CASCADE ON UPDATE CASCADE,
CONSTRAINT `Username3_fkey` FOREIGN KEY (`Username`) REFERENCES `gt_student_faculty_member` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table 'Reservation_Extended_Time'
--

CREATE TABLE `Reservation_Extended_Time` (
`extended_time` TIME NOT NULL,
`pick_up_datetime` DATETIME NOT NULL,
`return_datetime` DATETIME NOT NULL,
`Username` VARCHAR(45) NOT NULL,
PRIMARY KEY (`extended_time`, `pick_up_datetime`,`Username`),
CONSTRAINT `username2_fkey` FOREIGN KEY (`Username`) REFERENCES `gt_student_faculty_member` (`Username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
-- --------------------------------------------------------

 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
