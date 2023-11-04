-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 03, 2023 at 04:32 PM
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
-- Database: `skupinice`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `E-mail` varchar(30) NOT NULL,
  `Geslo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `E-mail`, `Geslo`) VALUES
(1, 'admin@admin', 'Admin123');

-- --------------------------------------------------------

--
-- Table structure for table `dijak`
--

CREATE TABLE `dijak` (
  `id_dijaka` int(11) NOT NULL,
  `ime_dijaka` varchar(40) NOT NULL,
  `priimek_dijaka` varchar(40) NOT NULL,
  `E-mail` varchar(40) NOT NULL,
  `Letnik` int(1) NOT NULL,
  `Razred` varchar(10) NOT NULL,
  `Spol` varchar(1) NOT NULL,
  `Oddelek` varchar(10) NOT NULL,
  `Geslo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dijak`
--

INSERT INTO `dijak` (`id_dijaka`, `ime_dijaka`, `priimek_dijaka`, `E-mail`, `Letnik`, `Razred`, `Spol`, `Oddelek`, `Geslo`) VALUES
(8, 'jan', 'jan', 'jan@a', 1, '', 'M', '', '123'),
(9, 'jaja', 'jaja', 'jan@aa', 3, '', 'M', '', 'jan'),
(10, 'janci', 'jancek', 'janci@gmail', 1, '', 'm', 'ker', ''),
(15, 'aaa', 'a', 'b@a', 1, 'res', 'm', 'gda', ''),
(16, 'marija', 'planinšek', 'marijaplanin@gmail.com', 3, '', 'Ž', '', 'Nahribru');

-- --------------------------------------------------------

--
-- Table structure for table `dijak_predmet`
--

CREATE TABLE `dijak_predmet` (
  `id_dijak_predmet` int(11) NOT NULL,
  `id_dijaka` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dijak_predmet`
--

INSERT INTO `dijak_predmet` (`id_dijak_predmet`, `id_dijaka`, `id_predmeta`) VALUES
(1, 8, 3),
(2, 10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `predmet`
--

CREATE TABLE `predmet` (
  `id_predmeta` int(11) NOT NULL,
  `naziv_predmeta` varchar(30) NOT NULL,
  `id_učitelja` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `predmet`
--

INSERT INTO `predmet` (`id_predmeta`, `naziv_predmeta`, `id_učitelja`) VALUES
(2, 'slovenščina', 0),
(3, 'Angleščina', 0),
(4, 'Načrtovanje', 0),
(5, 'Podjetništvo', 0),
(9, 'Likovna', 0),
(10, 'qasda', 10),
(11, 'asd', 10);

-- --------------------------------------------------------

--
-- Table structure for table `sporocilo`
--

CREATE TABLE `sporocilo` (
  `id_sporocila` int(11) NOT NULL,
  `id_dijaka` int(11) NOT NULL,
  `id_ucitelj` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL,
  `sporocilo` text NOT NULL,
  `cas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ucitelj`
--

CREATE TABLE `ucitelj` (
  `id_ucitelja` int(11) NOT NULL,
  `ime_ucitelja` varchar(30) NOT NULL,
  `priimek_ucitelja` varchar(30) NOT NULL,
  `E-mail` varchar(30) NOT NULL,
  `Geslo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ucitelj`
--

INSERT INTO `ucitelj` (`id_ucitelja`, `ime_ucitelja`, `priimek_ucitelja`, `E-mail`, `Geslo`) VALUES
(7, 'janci', 'zamernikk', 'zamernik.jan@gmail.com', '$2y$10$RG/wrXBKEK1HWjxaIV9Rx.k'),
(10, 'janci', 'banci banance', 'ban@gem', '123');

-- --------------------------------------------------------

--
-- Table structure for table `ucitelj_predmet`
--

CREATE TABLE `ucitelj_predmet` (
  `id_ucitelj_predmet` int(11) NOT NULL,
  `id_ucitelja` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ucitelj_predmet`
--

INSERT INTO `ucitelj_predmet` (`id_ucitelj_predmet`, `id_ucitelja`, `id_predmeta`) VALUES
(1, 10, 3),
(2, 7, 2),
(3, 10, 4),
(4, 7, 5),
(5, 10, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `dijak`
--
ALTER TABLE `dijak`
  ADD PRIMARY KEY (`id_dijaka`);

--
-- Indexes for table `dijak_predmet`
--
ALTER TABLE `dijak_predmet`
  ADD PRIMARY KEY (`id_dijak_predmet`),
  ADD KEY `id_dijaka` (`id_dijaka`),
  ADD KEY `id_predmeta` (`id_predmeta`);

--
-- Indexes for table `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`id_predmeta`);

--
-- Indexes for table `sporocilo`
--
ALTER TABLE `sporocilo`
  ADD PRIMARY KEY (`id_sporocila`),
  ADD KEY `id_dijaka` (`id_dijaka`),
  ADD KEY `id_predmeta` (`id_predmeta`),
  ADD KEY `id_ucitelj` (`id_ucitelj`);

--
-- Indexes for table `ucitelj`
--
ALTER TABLE `ucitelj`
  ADD PRIMARY KEY (`id_ucitelja`);

--
-- Indexes for table `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  ADD PRIMARY KEY (`id_ucitelj_predmet`),
  ADD KEY `id_predmeta` (`id_predmeta`),
  ADD KEY `id_ucitelja` (`id_ucitelja`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `dijak`
--
ALTER TABLE `dijak`
  MODIFY `id_dijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `dijak_predmet`
--
ALTER TABLE `dijak_predmet`
  MODIFY `id_dijak_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id_predmeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sporocilo`
--
ALTER TABLE `sporocilo`
  MODIFY `id_sporocila` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ucitelj`
--
ALTER TABLE `ucitelj`
  MODIFY `id_ucitelja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  MODIFY `id_ucitelj_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `dijak_predmet`
--
ALTER TABLE `dijak_predmet`
  ADD CONSTRAINT `dijak_predmet_ibfk_1` FOREIGN KEY (`id_dijaka`) REFERENCES `dijak` (`id_dijaka`),
  ADD CONSTRAINT `dijak_predmet_ibfk_2` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`);

--
-- Constraints for table `sporocilo`
--
ALTER TABLE `sporocilo`
  ADD CONSTRAINT `sporocilo_ibfk_1` FOREIGN KEY (`id_dijaka`) REFERENCES `dijak` (`id_dijaka`),
  ADD CONSTRAINT `sporocilo_ibfk_2` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`),
  ADD CONSTRAINT `sporocilo_ibfk_3` FOREIGN KEY (`id_ucitelj`) REFERENCES `ucitelj` (`id_ucitelja`);

--
-- Constraints for table `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  ADD CONSTRAINT `ucitelj_predmet_ibfk_1` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`),
  ADD CONSTRAINT `ucitelj_predmet_ibfk_2` FOREIGN KEY (`id_ucitelja`) REFERENCES `ucitelj` (`id_ucitelja`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
