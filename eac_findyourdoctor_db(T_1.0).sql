-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 09:07 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eac_findyourdoctor_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_accounts`
--

CREATE TABLE `admin_accounts` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_name` varchar(255) NOT NULL,
  `admin_email` varchar(255) NOT NULL,
  `admin_account_status` varchar(255) NOT NULL COMMENT '"NEW" "OLD"',
  `admin_status` varchar(255) NOT NULL DEFAULT 'ACTIVE' COMMENT '"ACTIVE, INACTIVE"',
  `account_access` varchar(255) NOT NULL,
  `account_created_timestamp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_accounts`
--

INSERT INTO `admin_accounts` (`admin_id`, `admin_username`, `admin_password`, `admin_name`, `admin_email`, `admin_account_status`, `admin_status`, `account_access`, `account_created_timestamp`) VALUES
(1, 'marc', '$2y$10$ZkgThNp4XqRGDaXyuXVtr.5RGI0DsFW3Bop9MW1m.ZE7WVT6AnHvO', '', '', '', 'Active', 'Super Admin', '0000-00-00 00:00:00'),
(2, 'lee', '$2y$10$ipHz8QTqeErxQ5yHq9mvc.kNT4Byd7l4Zy5g.M6vIz.CdgR.7luJ2', '', '', '', 'Active', 'Admin', '0000-00-00 00:00:00'),
(3, 'test', '$2y$10$TX6XGGHg9b5BrZuHA6bJCOa9scgvdYtv1CUc1S1oQIcVPPES5SpyW', '', '', 'New', 'Inactive', 'Admin', '0000-00-00 00:00:00'),
(9, 'telle', '$2y$10$TX6XGGHg9b5BrZuHA6bJCOa9scgvdYtv1CUc1S1oQIcVPPES5SpyW', '', '', 'New', 'Active', 'Super Admin', '2024-07-24 11:48:06'),
(11, 'test_2', '$2y$10$TX6XGGHg9b5BrZuHA6bJCOa9scgvdYtv1CUc1S1oQIcVPPES5SpyW', '', '', 'New', 'Active', 'Admin', '2024-07-24 12:53:40');

-- --------------------------------------------------------

--
-- Table structure for table `admin_activity_logs`
--

CREATE TABLE `admin_activity_logs` (
  `admin_activity_logs_id` int(11) NOT NULL,
  `activity_logs_admin_id` int(11) NOT NULL,
  `edited_date` varchar(255) NOT NULL,
  `edited_time` varchar(255) NOT NULL,
  `edit_details` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor`
--

CREATE TABLE `doctor` (
  `doctor_id` int(11) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `doctor_firstname` varchar(255) NOT NULL,
  `doctor_middlename` varchar(255) NOT NULL,
  `doctor_lastname` varchar(255) NOT NULL,
  `doctor_sex` varchar(255) NOT NULL,
  `doctor_status` varchar(255) NOT NULL DEFAULT 'ACTIVE' COMMENT '"ACTIVE, INACTIVE"',
  `doctor_archive_status` varchar(255) NOT NULL DEFAULT 'UNHIDE' COMMENT '"UNHIDE, HIDDEN"',
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor`
--

INSERT INTO `doctor` (`doctor_id`, `doctor_name`, `doctor_firstname`, `doctor_middlename`, `doctor_lastname`, `doctor_sex`, `doctor_status`, `doctor_archive_status`, `profile_image`) VALUES
(1, 'Angeline D. Santos', 'Angeline', 'Domingo', 'Santos', 'Female', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(2, 'Eduardo C. Garcia', 'Eduardo', 'Carding', 'Garcia', 'Male', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(3, 'Rosario U. Santiago', 'Rosario', 'Uganda', 'Santiago', 'Male', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(4, 'May Ann J. Tan', 'May Ann', 'Jeminez', 'Tan', 'Female', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(5, 'Pedro S. Villanueva', 'Pedro', 'Santaigo', 'Villanueva', 'Male', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(6, 'Nelia L. Reyes', 'Neila', 'Lara', 'Reyes', 'Female', 'ACTIVE', 'HIDDEN', 'Doctor2.png'),
(7, 'Felicia D. Espinosa', 'Felicia', 'Domingo', 'Espinosa', 'Female', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(8, 'Danica R. Dela Cruz', 'Danica', 'Ricardo', 'Dela Cruz', 'Female', 'ACTIVE', 'VISIBLE', 'Doctor2.png'),
(9, 'Oliver H. Dadole', 'Oliver', 'Howrad', 'Dadole', 'Male', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(10, 'Nathan R. Lee', 'Nathan', 'Roberto', 'Lee', 'Male', 'ACTIVE', 'VISIBLE', 'Doctor1.png'),
(24, '', 'alfelor', 'bayo', 'France', 'Male', 'ACTIVE', 'UNHIDE', 'Doctor1.png'),
(25, '', 'kristelle', 'hdmi', 'marquez', 'Female', 'ACTIVE', 'UNHIDE', 'Doctor2.png'),
(26, '', 'john carl', 'garcia', 'mendoza', 'Male', 'ACTIVE', 'UNHIDE', 'Doctor1.png'),
(27, '', 'joshua', 'santaigo', 'santiago', 'Male', 'ACTIVE', 'UNHIDE', 'Doctor1.png'),
(28, '', 'russel', 'gamora', 'espina', 'Male', 'ACTIVE', 'UNHIDE', 'Doctor1.png'),
(29, '', 'kevin', 'martinez', 'golveo', 'Male', 'ACTIVE', 'UNHIDE', 'Doctor1.png'),
(30, '', '', '', '', '', 'ACTIVE', 'UNHIDE', 'Doctor2.png'),
(31, '', '', '', '', '', 'ACTIVE', 'UNHIDE', 'Doctor2.png'),
(32, '', 'marc', 'mar', 'lee', 'Male', 'ACTIVE', 'UNHIDE', 'Doctor1.png');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_archive`
--

CREATE TABLE `doctor_archive` (
  `doctor_archive_id` int(11) NOT NULL,
  `archive_doctor_id` int(11) NOT NULL,
  `archive_admin_id` int(11) NOT NULL,
  `archive_admin_name` varchar(255) NOT NULL,
  `archive_time` varchar(255) NOT NULL,
  `archive_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_category`
--

CREATE TABLE `doctor_category` (
  `category_id` int(11) NOT NULL,
  `category_doctor_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_hmo`
--

CREATE TABLE `doctor_hmo` (
  `doctor_hmo_id` int(11) NOT NULL,
  `hmo_doctor_id` int(11) NOT NULL,
  `hmo_id_2` int(11) NOT NULL,
  `doctor_hmo_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_hmo`
--

INSERT INTO `doctor_hmo` (`doctor_hmo_id`, `hmo_doctor_id`, `hmo_id_2`, `doctor_hmo_name`) VALUES
(1, 1, 13, 'Allianz PNB Life Insurance Inc'),
(2, 1, 15, 'Carewell Health Systems, Inc.'),
(3, 1, 18, 'Avega Managed Care, Inc.'),
(4, 1, 17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(5, 1, 4, 'KAISER International Healthgroup, Inc.'),
(6, 2, 13, 'Allianz PNB Life Insurance Inc'),
(7, 2, 15, 'Carewell Health Systems, Inc.'),
(8, 2, 2, 'Intellicare'),
(9, 2, 11, 'Pacific Cross Health Care, Inc.'),
(10, 3, 5, 'IMS Wellth Care, Inc.'),
(11, 3, 21, 'EastWest Health Care, Inc.'),
(12, 3, 22, 'Generali Life Assurance Philippines Inc.'),
(13, 4, 2, 'Intellicare'),
(14, 4, 15, 'Carewell Health Systems, Inc.'),
(15, 4, 18, 'Avega Managed Care, Inc.'),
(16, 5, 10, 'MedoCare Health Systems, Inc.'),
(17, 5, 2, 'Intellicare'),
(18, 5, 11, 'Pacific Cross Health Care, Inc.'),
(19, 6, 7, 'Medasia Philippines Inc.'),
(20, 6, 3, 'Insular Life Assurance Co., Ltd.'),
(21, 6, 16, 'AsianCare Health Systems Inc.'),
(22, 6, 10, 'MedoCare Health Systems, Inc.'),
(23, 6, 19, 'Beneficial Life Insurance Company, Inc.'),
(24, 7, 13, 'Allianz PNB Life Insurance Inc'),
(25, 8, 19, 'Beneficial Life Insurance Company, Inc.'),
(26, 8, 5, 'IMS Wellth Care, Inc.'),
(27, 8, 6, 'Maxicare Healthcare Corporation'),
(28, 8, 12, 'Value Care Health Systems Inc.'),
(29, 9, 23, 'Getwell Health Systems, Inc.'),
(30, 9, 14, 'Advanced Medical Access Philippines, Inc.'),
(31, 9, 25, 'Health Plan Philippines, Inc.'),
(32, 9, 2, 'Intellicare'),
(33, 9, 11, 'Pacific Cross Health Care, Inc.'),
(34, 9, 13, 'Allianz PNB Life Insurance Inc'),
(35, 10, 4, 'KAISER International Healthgroup, Inc.'),
(36, 10, 5, 'IMS Wellth Care, Inc.'),
(37, 10, 17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(38, 10, 14, 'Advanced Medical Access Philippines, Inc.');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_notes`
--

CREATE TABLE `doctor_notes` (
  `doctor_notes_id` int(11) NOT NULL,
  `notes_doctor_id` int(11) NOT NULL,
  `doctor_notes_details` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_notes`
--

INSERT INTO `doctor_notes` (`doctor_notes_id`, `notes_doctor_id`, `doctor_notes_details`) VALUES
(1, 1, 'Walk-ins are accepted.'),
(2, 2, '20 patients per day.'),
(3, 3, '15 patients per day.'),
(4, 4, '8 - 10 patients per day.'),
(5, 5, 'By appointment.'),
(6, 6, '10 patients per day.'),
(7, 7, '* First come first serve/walk-in.'),
(8, 8, '6 patients per day.'),
(9, 9, '2 to 5 patients per day'),
(10, 10, 'Strictly BY APPOINTMENT. You can email for more information at biancalatorres@eacmed.org.ph');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_room`
--

CREATE TABLE `doctor_room` (
  `doctor_room_id` int(11) NOT NULL,
  `room_doctor_id` int(11) NOT NULL,
  `doctor_room_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_room`
--

INSERT INTO `doctor_room` (`doctor_room_id`, `room_doctor_id`, `doctor_room_number`) VALUES
(24, 1, '2nd Floor - Room 2208'),
(25, 1, '2nd Floor - Room 2307'),
(26, 2, '3rd Floor - Room 3306'),
(27, 3, '2nd Floor - Room 2408'),
(28, 4, '2nd Floor - Room 2221'),
(29, 4, '2nd Floor - Room 2231'),
(30, 5, '2nd Floor - Room 2251'),
(31, 6, '3rd Floor - Room 3405'),
(32, 7, '3rd Floor - Room 3406'),
(33, 8, '4th Floor - Room 4102'),
(34, 9, '2nd Floor - Room 2405'),
(35, 10, '2nd Floor - Room 2342');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_schedule`
--

CREATE TABLE `doctor_schedule` (
  `doctor_schedule_id` int(11) NOT NULL,
  `schedule_doctor_id` int(11) NOT NULL,
  `doctor_schedule_day` varchar(255) NOT NULL,
  `doctor_schedule_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_schedule`
--

INSERT INTO `doctor_schedule` (`doctor_schedule_id`, `schedule_doctor_id`, `doctor_schedule_day`, `doctor_schedule_time`) VALUES
(1, 1, 'Monday', '8:00 AM - 12:00 PM'),
(2, 1, 'Tuesday', '8:00 AM - 12:00 PM'),
(3, 1, 'Wednesday', '1:00 PM - 4:00 PM'),
(4, 2, 'Monday', '8:00 AM - 12:00 PM'),
(5, 2, 'Wednesday', '8:00 AM - 12:00 PM'),
(6, 3, 'Thursday', '1:00 PM - 3:00 PM'),
(7, 3, 'Friday', '8:00 AM - 12:00 PM'),
(8, 3, 'Saturday', '1:00 AM - 5:00 PM'),
(9, 4, 'Monday', '1:00 PM - 5:00 PM'),
(10, 4, 'Wednesday', '1:00 PM - 5:00 PM'),
(11, 5, 'Tuesday', '11:00 AM - 1:00 PM'),
(12, 5, 'Thursday', '9:00 AM - 11:00 AM'),
(13, 6, 'Monday', '9:30 AM - 3:00 PM'),
(14, 6, 'Tuesday', '9:30 AM - 3:00 PM'),
(15, 6, 'Thursday', '1:00 PM - 3:00 PM'),
(16, 6, 'Friday', '1:00 PM - 3:00 PM'),
(17, 7, 'Tuesday', '9:00 AM - 12:00 PM'),
(18, 7, 'Wednesday', '10:00 AM - 1:00 PM'),
(19, 7, 'Saturday', '9:00 AM - 5:00 PM'),
(20, 8, 'Monday', '9:00 AM - 11:00 PM'),
(21, 8, 'Friday', '9:00 AM - 11:00 PM'),
(22, 9, 'Wednesday', '10:00 AM - 12:00 PM'),
(23, 9, 'Thursday', '12:00 PM - 3:00 PM'),
(24, 9, 'Friday', '12:00 PM - 3:00 PM'),
(25, 10, 'Thursday', '9:00 AM - 12:00 PM'),
(26, 10, 'Friday', '1:00 PM - 5:00 PM'),
(27, 10, 'Saturday', '1:00 PM - 5:00 PM');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_secretary`
--

CREATE TABLE `doctor_secretary` (
  `doctor_secretary_id` int(11) NOT NULL,
  `secretary_doctor_id` int(11) NOT NULL,
  `doctor_secretary_first_name` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `doctor_secretary_first_network` varchar(255) NOT NULL,
  `doctor_secretary_first_number` varchar(255) NOT NULL,
  `doctor_secretary_second_network` varchar(255) NOT NULL,
  `doctor_secretary_second_number` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_secretary`
--

INSERT INTO `doctor_secretary` (`doctor_secretary_id`, `secretary_doctor_id`, `doctor_secretary_first_name`, `sex`, `doctor_secretary_first_network`, `doctor_secretary_first_number`, `doctor_secretary_second_network`, `doctor_secretary_second_number`) VALUES
(1, 1, 'Luis V. Ramirez', 'Male', 'SMART', '0912 345 6789.', 'GLOBE', '0917 123 4567'),
(2, 2, 'Janine Joy D. Gonzales', 'Female', 'SMART', '0912 345 6789', '', ''),
(3, 2, 'Angelique C. Martinez', 'Female', 'GLOBE', '0935 678 9012', '', ''),
(4, 3, 'Sophia Marie L. Cruz', 'Female', 'SMART', '0938 765 4321', '', ''),
(5, 4, 'Emmanuel D. Holgado', 'Male', 'SMART', '0928 765 4321', '', ''),
(6, 5, 'Francisco S. Mendoza', 'Male', 'GLOBE', '0927 567 8901', '', ''),
(7, 5, 'Joshika S. Salvador', 'Male', 'GLOBE', '0935 345 6789', 'SMART', '0917 890 1234'),
(8, 6, 'Janine Joy D. Golveo', 'Female', 'GLOBE', '0927 567 8901', '', ''),
(9, 7, 'Russel Art S. Espiña', 'Male', 'SMART', '0933 210 9876', '', ''),
(10, 8, 'Francine J. Alfelor', 'Female', 'SMART', '0939 876 5432', 'DITO', '0917 789 0123'),
(11, 9, 'Lea Anne C. Toledo', 'Female', 'GLOBE', '0935 901 2345', '', ''),
(12, 10, 'Bianca Louise A. Torres', 'Female', 'GLOBE', '0935 345 6789', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_specialization`
--

CREATE TABLE `doctor_specialization` (
  `doctor_specialization_id` int(11) NOT NULL,
  `specialization_doctor_id` int(11) NOT NULL,
  `doctor_specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_specialization`
--

INSERT INTO `doctor_specialization` (`doctor_specialization_id`, `specialization_doctor_id`, `doctor_specialization_name`) VALUES
(1, 1, 'Internal Medicine'),
(2, 2, 'Orthopedics'),
(3, 3, 'Pediatrics'),
(4, 4, 'Surgery'),
(5, 5, 'Psychiatry'),
(6, 6, 'Obstetrics & Gynecology'),
(7, 7, 'Opthalmology'),
(8, 8, 'Radiology'),
(9, 9, 'Family and Community Medicine'),
(10, 10, 'Anesthesia');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_sub_specialization`
--

CREATE TABLE `doctor_sub_specialization` (
  `doctor_sub_specialization_id` int(11) NOT NULL,
  `sub_specialization_doctor_id` int(11) NOT NULL,
  `doctor_sub_specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_sub_specialization`
--

INSERT INTO `doctor_sub_specialization` (`doctor_sub_specialization_id`, `sub_specialization_doctor_id`, `doctor_sub_specialization_name`) VALUES
(1, 1, 'Cardiology'),
(2, 1, 'Dermatology'),
(3, 1, 'Rheumatology'),
(4, 1, 'Nephrology'),
(5, 2, 'Arthroplasty'),
(6, 2, 'Hand Surgery'),
(7, 3, 'Gastroenterology'),
(8, 3, 'General Pediatrics'),
(9, 3, 'Immunology'),
(10, 4, 'Audiology'),
(11, 4, 'Colon and Rectal'),
(12, 4, 'Pediatric Urology'),
(13, 5, 'Biological Psychiatry'),
(14, 6, 'Colposcopic'),
(15, 6, 'Ultrasound'),
(16, 6, 'Oncology'),
(17, 7, 'Retina'),
(18, 7, 'Cornea'),
(19, 8, 'CT Scan and MRI'),
(20, 8, 'Vascular and Interventional'),
(21, 9, 'Adoloscent and Young Adult Medicine'),
(22, 10, 'Palliative Care');

-- --------------------------------------------------------

--
-- Table structure for table `doctor_teleconsult`
--

CREATE TABLE `doctor_teleconsult` (
  `doctor_teleconsult_id` int(11) NOT NULL,
  `teleconsult_doctor_id` int(11) NOT NULL,
  `teleconsult_link` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctor_teleconsult`
--

INSERT INTO `doctor_teleconsult` (`doctor_teleconsult_id`, `teleconsult_doctor_id`, `teleconsult_link`) VALUES
(1, 1, ''),
(2, 2, ''),
(3, 5, ''),
(4, 8, 'https://chatgpt.com'),
(5, 9, 'https://www.youtube.com/');

-- --------------------------------------------------------

--
-- Table structure for table `hmo`
--

CREATE TABLE `hmo` (
  `hmo_id` int(11) NOT NULL,
  `hmo_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hmo`
--

INSERT INTO `hmo` (`hmo_id`, `hmo_name`) VALUES
(1, 'Healthway Medi-Access'),
(2, 'Intellicare'),
(3, 'Insular Life Assurance Co., Ltd.'),
(4, 'KAISER International Healthgroup, Inc.'),
(5, 'IMS Wellth Care, Inc.'),
(6, 'Maxicare Healthcare Corporation'),
(7, 'Medasia Philippines Inc.'),
(8, 'Medicard Philippines Inc.'),
(9, 'Medilink Network Inc.'),
(10, 'MedoCare Health Systems, Inc.'),
(11, 'Pacific Cross Health Care, Inc.'),
(12, 'Value Care Health Systems Inc.'),
(13, 'Allianz PNB Life Insurance Inc'),
(14, 'Advanced Medical Access Philippines, Inc.'),
(15, 'Carewell Health Systems, Inc.'),
(16, 'AsianCare Health Systems Inc.'),
(17, 'Etiqa Life And General Assurance Philippines, Inc.'),
(18, 'Avega Managed Care, Inc.'),
(19, 'Beneficial Life Insurance Company, Inc.'),
(21, 'EastWest Health Care, Inc.'),
(22, 'Generali Life Assurance Philippines Inc.'),
(23, 'Getwell Health Systems, Inc.'),
(24, 'Health Maintenance, Inc.'),
(25, 'Health Plan Philippines, Inc.');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_floor_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_floor_name`) VALUES
(1, '2nd Floor - Room 2208'),
(2, '3rd Floor - Room 3306'),
(3, '2nd Floor - Room 2408'),
(4, '2nd Floor - Room 2221'),
(5, '2nd Floor - Room 2251'),
(6, '3rd Floor - Room 3405'),
(7, '3rd Floor - Room 3406'),
(8, '4th Floor - Room 4102'),
(9, '2nd Floor - Room 2405'),
(10, '2nd Floor - Room 2342'),
(11, '3rd Floor - Room 3306'),
(21, '2nd Floor - Room 2307'),
(22, '2nd Floor - Room 2231');

-- --------------------------------------------------------

--
-- Table structure for table `specialization`
--

CREATE TABLE `specialization` (
  `specialization_id` int(11) NOT NULL,
  `specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `specialization`
--

INSERT INTO `specialization` (`specialization_id`, `specialization_name`) VALUES
(1, 'Internal Medicine'),
(2, 'Orthopedics'),
(3, 'Pediatrics'),
(4, 'Surgery'),
(5, 'Psychiatry'),
(6, 'Obstetrics & Gynecology'),
(7, 'Opthalmology'),
(8, 'Family and Community Medicine'),
(9, 'Anesthesia'),
(10, 'Radiology');

-- --------------------------------------------------------

--
-- Table structure for table `sub_specialization`
--

CREATE TABLE `sub_specialization` (
  `sub_specialization_id` int(11) NOT NULL,
  `sub_specs_id` int(11) NOT NULL,
  `sub_specialization_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sub_specialization`
--

INSERT INTO `sub_specialization` (`sub_specialization_id`, `sub_specs_id`, `sub_specialization_name`) VALUES
(1, 1, 'Cardiology'),
(2, 1, 'Dermatology'),
(3, 1, 'Endocrinology'),
(4, 1, 'Nephrology'),
(5, 1, 'Rheumatology'),
(6, 2, 'Arthroplasty'),
(7, 2, 'Hand Surgery'),
(8, 2, 'Knee Arthoscopy'),
(9, 2, 'Spine Surgery'),
(10, 3, 'Allergology'),
(11, 3, 'Gastroenterology'),
(12, 3, 'Immunology'),
(13, 3, 'General Pediatrics'),
(14, 4, 'Audiology'),
(15, 4, 'Neuro Surgery'),
(16, 4, 'Pediatric Urology'),
(17, 4, 'Colon and Rectal'),
(18, 5, 'Biological Psychiatry'),
(19, 5, 'Epilepsy'),
(20, 6, 'Colposcopic'),
(21, 6, 'Oncology'),
(22, 6, 'Ultrasound'),
(23, 6, 'Urologic Gynecology'),
(24, 7, 'Oculoplastics'),
(25, 7, 'Retina'),
(26, 7, 'Cornea'),
(27, 7, 'Cataract'),
(28, 8, 'Geriatric Medicine'),
(29, 8, 'Sleep Medicine'),
(30, 8, 'Sports Medicine'),
(31, 8, 'Adoloscent and Young Adult Medicine'),
(32, 9, 'Cardiovascular Anesthesia'),
(33, 9, 'General Anesthesia'),
(34, 9, 'Intensive Care'),
(35, 9, 'Palliative Care'),
(36, 10, 'CT Scan and MRI'),
(37, 10, 'Vascular and Interventional'),
(38, 10, 'Radiation Oncology'),
(39, 10, 'Pediatric Radiology');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  ADD PRIMARY KEY (`admin_activity_logs_id`);

--
-- Indexes for table `doctor`
--
ALTER TABLE `doctor`
  ADD PRIMARY KEY (`doctor_id`);

--
-- Indexes for table `doctor_archive`
--
ALTER TABLE `doctor_archive`
  ADD PRIMARY KEY (`doctor_archive_id`);

--
-- Indexes for table `doctor_category`
--
ALTER TABLE `doctor_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `doctor_hmo`
--
ALTER TABLE `doctor_hmo`
  ADD PRIMARY KEY (`doctor_hmo_id`);

--
-- Indexes for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  ADD PRIMARY KEY (`doctor_notes_id`);

--
-- Indexes for table `doctor_room`
--
ALTER TABLE `doctor_room`
  ADD PRIMARY KEY (`doctor_room_id`);

--
-- Indexes for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  ADD PRIMARY KEY (`doctor_schedule_id`);

--
-- Indexes for table `doctor_secretary`
--
ALTER TABLE `doctor_secretary`
  ADD PRIMARY KEY (`doctor_secretary_id`);

--
-- Indexes for table `doctor_specialization`
--
ALTER TABLE `doctor_specialization`
  ADD PRIMARY KEY (`doctor_specialization_id`);

--
-- Indexes for table `doctor_sub_specialization`
--
ALTER TABLE `doctor_sub_specialization`
  ADD PRIMARY KEY (`doctor_sub_specialization_id`);

--
-- Indexes for table `doctor_teleconsult`
--
ALTER TABLE `doctor_teleconsult`
  ADD PRIMARY KEY (`doctor_teleconsult_id`);

--
-- Indexes for table `hmo`
--
ALTER TABLE `hmo`
  ADD PRIMARY KEY (`hmo_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`);

--
-- Indexes for table `specialization`
--
ALTER TABLE `specialization`
  ADD PRIMARY KEY (`specialization_id`);

--
-- Indexes for table `sub_specialization`
--
ALTER TABLE `sub_specialization`
  ADD PRIMARY KEY (`sub_specialization_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_accounts`
--
ALTER TABLE `admin_accounts`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `admin_activity_logs`
--
ALTER TABLE `admin_activity_logs`
  MODIFY `admin_activity_logs_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor`
--
ALTER TABLE `doctor`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `doctor_archive`
--
ALTER TABLE `doctor_archive`
  MODIFY `doctor_archive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_category`
--
ALTER TABLE `doctor_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_hmo`
--
ALTER TABLE `doctor_hmo`
  MODIFY `doctor_hmo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `doctor_notes`
--
ALTER TABLE `doctor_notes`
  MODIFY `doctor_notes_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctor_room`
--
ALTER TABLE `doctor_room`
  MODIFY `doctor_room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `doctor_schedule`
--
ALTER TABLE `doctor_schedule`
  MODIFY `doctor_schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `doctor_secretary`
--
ALTER TABLE `doctor_secretary`
  MODIFY `doctor_secretary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `doctor_specialization`
--
ALTER TABLE `doctor_specialization`
  MODIFY `doctor_specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `doctor_sub_specialization`
--
ALTER TABLE `doctor_sub_specialization`
  MODIFY `doctor_sub_specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `doctor_teleconsult`
--
ALTER TABLE `doctor_teleconsult`
  MODIFY `doctor_teleconsult_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `hmo`
--
ALTER TABLE `hmo`
  MODIFY `hmo_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `specialization`
--
ALTER TABLE `specialization`
  MODIFY `specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `sub_specialization`
--
ALTER TABLE `sub_specialization`
  MODIFY `sub_specialization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
