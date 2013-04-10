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
  `username` varchar(45) NOT NULL, 
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

-- --------------------------------------------------------

--
-- Table structure for table `gtcr_employee`
--

CREATE TABLE `gtcr_employee` ( 
  `username` varchar(45) NOT NULL, 
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `driving_plan`
--

CREATE TABLE `driving_plan` ( 
  `driving_plan_type` varchar(45) NOT NULL, 
  `monthly_payment` int(11) DEFAULT NULL, 
  `discount` int(11) DEFAULT NULL, 
  `annual_fees` int(11) DEFAULT NULL, 
  PRIMARY KEY (`driving_plan_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

-- --------------------------------------------------------

--
-- Table structure for table 'Credit Card'
--

CREATE TABLE `credit_card` ( 
  `name` varchar(45) DEFAULT NULL, 
  `card_number` int(11) unsigned NOT NULL, 
  `cvv` int(11) DEFAULT NULL, 
  `expiry_date` date DEFAULT NULL, 
  `billing_address` varchar(45) DEFAULT NULL, 
  PRIMARY KEY (`card_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `gt_student_faculty_member`
--

CREATE TABLE `gt_student_faculty_member` ( 
  `username` varchar(45) NOT NULL, 
  `password` VARCHAR(45) NOT NULL,
  `fname` varchar(45) NOT NULL, 
  `lname` varchar(45) NOT NULL, 
  `minitial` varchar(1) DEFAULT NULL, 
  `address` varchar(45) DEFAULT NULL, 
  `phone_number` varchar(45) DEFAULT NULL, 
  `email_address` varchar(45) DEFAULT NULL, 
  `card_number` int(11) unsigned NOT NULL, 
  `driving_plan` varchar(45) NOT NULL, 
  PRIMARY KEY (`username`),
  CONSTRAINT `FK_CardNo` FOREIGN KEY (`card_number`) REFERENCES `credit_card` (`card_number`),  
  CONSTRAINT `FK_DrivingPlanType` FOREIGN KEY (`driving_plan`) REFERENCES `driving_plan` (`driving_plan_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table 'Location'
--
CREATE TABLE `location` ( 
  `location_name` varchar(45) NOT NULL, 
  `capacity` int(10) unsigned DEFAULT NULL, 
  PRIMARY KEY (`location_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `car`
--

CREATE TABLE `car` ( 
  `vehicle_sno` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `auxiliary-cable` bit(1) DEFAULT NULL, 
  `transmission_type` bit(1) NOT NULL, 
  `seating_capacity` int(10) unsigned DEFAULT NULL, 
  `bluetooth_connectivity` bit(1) NOT NULL, 
  `daily_rate` int(10) unsigned NOT NULL, 
  `hourly_rate` int(10) unsigned NOT NULL, 
  `color` varchar(10) NOT NULL, 
  `car_type` varchar(45) NOT NULL, 
  `car_model` varchar(45) NOT NULL, 
  `under_maintenance_flag` bit(1) NOT NULL, 
  `car_location` varchar(45) NOT NULL, 
  PRIMARY KEY (`vehicle_sno`), 
  KEY `FK_car_Location` (`car_location`), 
  CONSTRAINT `FK_car_Location` FOREIGN KEY (`car_location`) REFERENCES `location` (`location_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

-- --------------------------------------------------------

--
-- Table structure for table 'Maintenance Request'
--

CREATE TABLE `maintenance_request` ( 
  `vehicle_sno` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `request_date_time` datetime NOT NULL, 
  `username` varchar(45) NOT NULL, 
  PRIMARY KEY (`vehicle_sno`,`request_date_time`) USING BTREE, 
  CONSTRAINT `FK_VehicleSno_2` FOREIGN KEY (`vehicle_sno`) REFERENCES `car` (`vehicle_sno`),
  CONSTRAINT `FK_Username_2` FOREIGN KEY (`username`) REFERENCES `gtcr_employee` (`username`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `maintenance_request_problems`
--
CREATE TABLE `maintenance_request_problems` ( 
  `vehicle_sno` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `request_date_time` datetime NOT NULL, 
  `problem` varchar(45) NOT NULL, 
  PRIMARY KEY (`vehicle_sno`,`request_date_time`,`problem`) USING BTREE, 
  CONSTRAINT `FK_maintenance_request_problems_2` FOREIGN KEY (`vehicle_sno`, `request_date_time`) REFERENCES `maintenance_request` (`vehicle_sno`, `request_date_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

-- --------------------------------------------------------

--
-- Table structure for table 'Reservation'
--
CREATE TABLE `reservation` ( 
  `res_id` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `username` varchar(45) NOT NULL, 
  `pick_up_datetime` datetime NOT NULL, 
  `return_datetime` datetime NOT NULL, 
  `late_by` varchar(10) DEFAULT NULL, 
  `return_status` varchar(10) NOT NULL, 
  `estimated_cost` int(10) unsigned NOT NULL, 
  `late_fees` int(10) unsigned DEFAULT NULL, 
  `reservation_location` varchar(45) NOT NULL, 
  `vehicle_sno` int(10) unsigned NOT NULL, 
  PRIMARY KEY (`res_id`), 
   CONSTRAINT `FK_reservation_2` FOREIGN KEY (`vehicle_sno`) REFERENCES `car` (`vehicle_sno`),
  CONSTRAINT `FK_reservation_1` FOREIGN KEY (`reservation_location`) REFERENCES `location` (`location_name`),
CONSTRAINT `FK_reservation_3` FOREIGN KEY (`username`) REFERENCES `gt_student_faculty_member` (`username`) 
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

--
-- Table structure for table 'Reservation_Extended_Time'
--

CREATE TABLE `reservation_extended_time` ( 
  `res_id` int(10) unsigned NOT NULL AUTO_INCREMENT, 
  `extended_time` datetime NOT NULL, 
  PRIMARY KEY (`res_id`), 
  CONSTRAINT `FK_reservation_extended_time_1` FOREIGN KEY (`res_id`) REFERENCES `reservation` (`res_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8; 

-- --------------------------------------------------------

 
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
