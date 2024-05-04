-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 24, 2024 at 09:48 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `internship`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `email_id` varchar(50) NOT NULL,
  `pwd` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_login`
--

INSERT INTO `admin_login` (`email_id`, `pwd`) VALUES
('admin@ims.com', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_guide_info`
--

CREATE TABLE `assigned_guide_info` (
  `aid` int(10) NOT NULL,
  `erno` int(10) NOT NULL,
  `snm` varchar(50) NOT NULL,
  `prj_title` varchar(25) NOT NULL,
  `comp_name` varchar(25) NOT NULL,
  `gnm` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned_guide_info`
--

INSERT INTO `assigned_guide_info` (`aid`, `erno`, `snm`, `prj_title`, `comp_name`, `gnm`) VALUES
(1, 576944, 'jitali', 'event-management', 'Zrock Infotech', 'preet');

-- --------------------------------------------------------

--
-- Table structure for table `company_info`
--

CREATE TABLE `company_info` (
  `cid` int(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `hrnm` varchar(50) NOT NULL,
  `desc` varchar(50) NOT NULL,
  `email` varchar(25) NOT NULL,
  `pwd` varchar(10) NOT NULL,
  `location` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_info`
--

INSERT INTO `company_info` (`cid`, `name`, `hrnm`, `desc`, `email`, `pwd`, `location`) VALUES
(1, 'Dolphin info tech', 'sayli', 'Join us for good working  experience', 'jitalipatel21@gmail.com', '3814', 'ahemedabad'),
(2, 'Zrock Infotech', 'Rishita', 'Join Us for work with enjoying ', 'jitalipatel120@gmail.com', '7679', 'surat');

-- --------------------------------------------------------

--
-- Table structure for table `faculty_regis`
--

CREATE TABLE `faculty_regis` (
  `fid` int(10) NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(15) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `mno` int(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `pwd` varchar(15) NOT NULL,
  `dept` varchar(30) NOT NULL,
  `desig` varchar(30) NOT NULL,
  `coursenm` varchar(25) NOT NULL,
  `clg` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty_regis`
--

INSERT INTO `faculty_regis` (`fid`, `name`, `surname`, `gender`, `mno`, `email`, `pwd`, `dept`, `desig`, `coursenm`, `clg`) VALUES
(1, 'preet', 'solanki', 'female', 2147483647, 'jitalipatel21@gmail.com', '3898', 'IT', 'professor', 'mca', 'LD');

-- --------------------------------------------------------

--
-- Table structure for table `intern_applications_info`
--

CREATE TABLE `intern_applications_info` (
  `iid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `intern_name` varchar(25) NOT NULL,
  `erno` int(10) NOT NULL,
  `email` varchar(25) NOT NULL,
  `education` varchar(25) NOT NULL,
  `current_sem` int(10) NOT NULL,
  `starting_year` year(4) NOT NULL,
  `ending_year` year(4) NOT NULL,
  `experiecnce` int(5) NOT NULL,
  `resume` blob NOT NULL,
  `position` varchar(25) NOT NULL,
  `comp_name` varchar(25) NOT NULL,
  `application_status` varchar(15) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `intern_applications_info`
--

INSERT INTO `intern_applications_info` (`iid`, `sid`, `intern_name`, `erno`, `email`, `education`, `current_sem`, `starting_year`, `ending_year`, `experiecnce`, `resume`, `position`, `comp_name`, `application_status`) VALUES
(1, 2, 'siya', 839845, 'siya@gmail.com', 'mca', 2, '2022', '2024', 0, 0x496e7465726e5f526573756d652f496e7465726e73686970735f4d616e6167656d656e745f53797374656d2e706466, 'react developer', 'Dolphin info tech', 'pending'),
(2, 1, 'jitali', 576944, 'jitalipatel21@gmail.com', 'mca', 4, '2022', '2024', 0, 0x496e7465726e5f526573756d652f4a502d2850292e706466, 'react developer', 'Zrock Infotech', 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `noc_info`
--

CREATE TABLE `noc_info` (
  `sid` int(10) NOT NULL,
  `nid` int(10) NOT NULL,
  `erno` int(25) NOT NULL,
  `name` varchar(25) NOT NULL,
  `address` varchar(25) NOT NULL,
  `reason` varchar(25) NOT NULL,
  `id_proof` blob NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `noc_info`
--

INSERT INTO `noc_info` (`sid`, `nid`, `erno`, `name`, `address`, `reason`, `id_proof`, `status`) VALUES
(1, 1, 576944, 'jitali', 'ahmedabad', 'internship', 0x4e4f435f4170706c69636174696f6e2f636c672049442e6a7067, 'approved'),
(2, 2, 839845, 'siya', 'gandhiagar', 'internship', 0x4e4f435f4170706c69636174696f6e2f636c672049442e6a7067, 'approved');

-- --------------------------------------------------------

--
-- Table structure for table `project_info`
--

CREATE TABLE `project_info` (
  `pi` int(10) NOT NULL,
  `intern_name` varchar(25) NOT NULL,
  `name` varchar(50) NOT NULL,
  `prj_title` varchar(25) NOT NULL,
  `duration` varchar(15) NOT NULL,
  `tool` varchar(25) NOT NULL,
  `tech` varchar(25) NOT NULL,
  `mnm` varchar(25) NOT NULL,
  `sta` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `project_info`
--

INSERT INTO `project_info` (`pi`, `intern_name`, `name`, `prj_title`, `duration`, `tool`, `tech`, `mnm`, `sta`) VALUES
(1, 'jitali', 'Zrock Infotech', 'event-management', '3 months', 'MYSQL SEREVER', 'php', 'Sayli', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `score_info`
--

CREATE TABLE `score_info` (
  `scid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `fid` int(10) NOT NULL,
  `erno` int(10) NOT NULL,
  `score` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `score_info`
--

INSERT INTO `score_info` (`scid`, `sid`, `fid`, `erno`, `score`) VALUES
(1, 1, 1, 576944, 20),
(2, 2, 1, 839845, 20);

-- --------------------------------------------------------

--
-- Table structure for table `student_regis`
--

CREATE TABLE `student_regis` (
  `sid` int(10) NOT NULL,
  `profile` blob NOT NULL,
  `name` varchar(25) NOT NULL,
  `surname` varchar(25) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `clg` varchar(25) NOT NULL,
  `erno` int(15) NOT NULL,
  `dept` varchar(25) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pwd` int(10) NOT NULL,
  `mno` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_regis`
--

INSERT INTO `student_regis` (`sid`, `profile`, `name`, `surname`, `gender`, `dob`, `clg`, `erno`, `dept`, `email`, `pwd`, `mno`) VALUES
(1, 0x70726f66696c657069632e6a7067, 'jitali', 'patel', 'female', '2001-03-19', 'LJ', 576944, 'it', 'jitalipatel21@gmail.com', 1406, 2147483647),
(2, 0x70726f66696c657069632e6a7067, 'siya', 'patel', 'female', '2005-07-16', 'CPI', 839845, 'BE', 'siya@gmail.com', 441, 1234567890);

-- --------------------------------------------------------

--
-- Table structure for table `vacancy_master`
--

CREATE TABLE `vacancy_master` (
  `cid` int(10) NOT NULL,
  `vid` int(10) NOT NULL,
  `vimg` blob NOT NULL,
  `vtype` varchar(11) NOT NULL,
  `position` varchar(25) NOT NULL,
  `post_date` date NOT NULL,
  `end_date` date NOT NULL,
  `desc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vacancy_master`
--

INSERT INTO `vacancy_master` (`cid`, `vid`, `vimg`, `vtype`, `position`, `post_date`, `end_date`, `desc`) VALUES
(1, 1, 0x576861747341707020496d61676520323032342d30342d313520617420352e30322e313020504d2e6a706567, 'Internship', 'react developer', '2024-04-23', '2024-04-24', 'Required Skills:HTML,CSS,JS'),
(2, 2, 0x576861747341707020496d61676520323032342d30342d313520617420352e30322e313220504d2e6a706567, 'Internship', 'react developer', '2024-04-23', '2024-04-25', 'required skills:HTML,CSS,JS');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigned_guide_info`
--
ALTER TABLE `assigned_guide_info`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `company_info`
--
ALTER TABLE `company_info`
  ADD PRIMARY KEY (`cid`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `faculty_regis`
--
ALTER TABLE `faculty_regis`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `intern_applications_info`
--
ALTER TABLE `intern_applications_info`
  ADD PRIMARY KEY (`iid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `noc_info`
--
ALTER TABLE `noc_info`
  ADD PRIMARY KEY (`nid`),
  ADD KEY `sid` (`sid`);

--
-- Indexes for table `project_info`
--
ALTER TABLE `project_info`
  ADD PRIMARY KEY (`pi`),
  ADD KEY `name` (`name`);

--
-- Indexes for table `score_info`
--
ALTER TABLE `score_info`
  ADD KEY `sid` (`sid`),
  ADD KEY `fid` (`fid`);

--
-- Indexes for table `student_regis`
--
ALTER TABLE `student_regis`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `vacancy_master`
--
ALTER TABLE `vacancy_master`
  ADD PRIMARY KEY (`vid`),
  ADD KEY `cid` (`cid`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `noc_info`
--
ALTER TABLE `noc_info`
  ADD CONSTRAINT `noc_info_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `student_regis` (`sid`);

--
-- Constraints for table `project_info`
--
ALTER TABLE `project_info`
  ADD CONSTRAINT `project_info_ibfk_1` FOREIGN KEY (`name`) REFERENCES `company_info` (`name`);

--
-- Constraints for table `score_info`
--
ALTER TABLE `score_info`
  ADD CONSTRAINT `score_info_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `student_regis` (`sid`),
  ADD CONSTRAINT `score_info_ibfk_2` FOREIGN KEY (`fid`) REFERENCES `faculty_regis` (`fid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
