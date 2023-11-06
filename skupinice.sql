-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 04:50 PM
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
  `Geslo` varchar(30) NOT NULL,
  `Profilna_slika` varchar(255) NOT NULL DEFAULT 'profilna_slika/osnovna_slika.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dijak`
--

INSERT INTO `dijak` (`id_dijaka`, `ime_dijaka`, `priimek_dijaka`, `E-mail`, `Letnik`, `Razred`, `Spol`, `Oddelek`, `Geslo`, `Profilna_slika`) VALUES
(8, 'jan', 'jan', 'jan@a', 1, '', 'M', '', '123', ''),
(10, 'janci', 'jancek', 'janci@gmail', 1, '', 'm', 'ker', '', '');

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
(2, 10, 3),
(3, 8, 21),
(4, 10, 21),
(5, 8, 26),
(6, 10, 26),
(7, 10, 27),
(8, 8, 27),
(9, 8, 24),
(10, 10, 24),
(11, 8, 2),
(12, 10, 2);

-- --------------------------------------------------------

--
-- Table structure for table `dodeljene_naloge`
--

CREATE TABLE `dodeljene_naloge` (
  `id_dodeljene_naloge` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL,
  `naziv_naloge` varchar(255) NOT NULL,
  `datoteka` varchar(255) NOT NULL,
  `Naloga` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gradivo`
--

CREATE TABLE `gradivo` (
  `id_gradiva` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL,
  `naziv_gradiva` varchar(255) NOT NULL,
  `datoteka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `gradivo`
--

INSERT INTO `gradivo` (`id_gradiva`, `id_predmeta`, `naziv_gradiva`, `datoteka`) VALUES
(1, 2, 'test', 'predtest. polinomi.pdf'),
(3, 2, '1', 'Učni list - Racionalna funkcija-1 (2).pdf'),
(4, 2, 'h1', 'hidrant1.jpg'),
(5, 2, '1', 'Učni list - Polinomi - 2 (2).pdf');

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
(5, 'Podjetništvo', 0),
(9, 'Likovna', 0),
(14, 'Slovenščina R4a', 0),
(15, 'asd', 0),
(16, 'haha', 0),
(17, 'haha', 0),
(18, 'haha', 0),
(19, 'asda', 0),
(20, 'hih', 0),
(21, 'Likovna', 0),
(22, 'Matematika', 0),
(23, 'Programiranje', 0),
(24, '1', 0),
(25, '2', 0),
(26, '3', 0),
(27, '4', 0),
(28, '5', 0),
(29, '6', 0),
(30, '1', 0),
(31, '2', 0),
(32, '3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `sporocilo`
--

CREATE TABLE `sporocilo` (
  `id_sporocila` int(11) NOT NULL,
  `id_sporocila_u` int(11) NOT NULL,
  `id_sporocila_d` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sporocilo_dijak`
--

CREATE TABLE `sporocilo_dijak` (
  `id_sporocila_d` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL,
  `id_dijaka` int(11) NOT NULL,
  `sporocilo` text NOT NULL,
  `cas` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sporocilo_ucitelj`
--

CREATE TABLE `sporocilo_ucitelj` (
  `id_sporocila_u` int(11) NOT NULL,
  `id_predmeta` int(11) NOT NULL,
  `id_ucitelja` int(11) NOT NULL,
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
  `Geslo` varchar(30) NOT NULL,
  `Profilna_slika` varchar(255) NOT NULL DEFAULT 'profilna_slika/osnovna_slika.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ucitelj`
--

INSERT INTO `ucitelj` (`id_ucitelja`, `ime_ucitelja`, `priimek_ucitelja`, `E-mail`, `Geslo`, `Profilna_slika`) VALUES
(7, 'janci', 'zamernikk', 'zamernik.jan@gmail.com', '$2y$10$RG/wrXBKEK1HWjxaIV9Rx.k', ''),
(10, 'janci', '', 'ban@gem', '$2y$10$YqoO8IaBysUiCnjpLbcq..2', ''),
(20, 'Kaja', 'Pikica', 'pika@kaja', '$2y$10$cO6CNSmp3FCoyYhqhXaUlel', 'profilna_slika/osnovna_slika.jpg'),
(21, 'Jan', 'jan', 'jan@u', '123', 'profilna_slika/osnovna_slika.jpg');

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
(4, 7, 5),
(6, 20, 9),
(9, 20, 18),
(10, 20, 19),
(11, 20, 20),
(12, 10, 21),
(13, 10, 22),
(14, 10, 23),
(15, 10, 24),
(16, 10, 25),
(17, 10, 26),
(18, 10, 27),
(19, 10, 28),
(20, 10, 29),
(21, 21, 2),
(22, 21, 3),
(23, 21, 5),
(24, 21, 30),
(25, 21, 31),
(26, 21, 32);

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
-- Indexes for table `dodeljene_naloge`
--
ALTER TABLE `dodeljene_naloge`
  ADD PRIMARY KEY (`id_dodeljene_naloge`),
  ADD KEY `id_predmeta` (`id_predmeta`);

--
-- Indexes for table `gradivo`
--
ALTER TABLE `gradivo`
  ADD PRIMARY KEY (`id_gradiva`),
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
  ADD KEY `id_sporocila_d` (`id_sporocila_d`),
  ADD KEY `id_sporocila_u` (`id_sporocila_u`);

--
-- Indexes for table `sporocilo_dijak`
--
ALTER TABLE `sporocilo_dijak`
  ADD PRIMARY KEY (`id_sporocila_d`),
  ADD KEY `id_dijaka` (`id_dijaka`),
  ADD KEY `id_predmeta` (`id_predmeta`);

--
-- Indexes for table `sporocilo_ucitelj`
--
ALTER TABLE `sporocilo_ucitelj`
  ADD PRIMARY KEY (`id_sporocila_u`),
  ADD KEY `id_predmeta` (`id_predmeta`),
  ADD KEY `id_ucitelja` (`id_ucitelja`);

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
  MODIFY `id_dijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `dijak_predmet`
--
ALTER TABLE `dijak_predmet`
  MODIFY `id_dijak_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dodeljene_naloge`
--
ALTER TABLE `dodeljene_naloge`
  MODIFY `id_dodeljene_naloge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gradivo`
--
ALTER TABLE `gradivo`
  MODIFY `id_gradiva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id_predmeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `sporocilo_dijak`
--
ALTER TABLE `sporocilo_dijak`
  MODIFY `id_sporocila_d` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sporocilo_ucitelj`
--
ALTER TABLE `sporocilo_ucitelj`
  MODIFY `id_sporocila_u` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ucitelj`
--
ALTER TABLE `ucitelj`
  MODIFY `id_ucitelja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  MODIFY `id_ucitelj_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

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
-- Constraints for table `dodeljene_naloge`
--
ALTER TABLE `dodeljene_naloge`
  ADD CONSTRAINT `dodeljene_naloge_ibfk_2` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`);

--
-- Constraints for table `gradivo`
--
ALTER TABLE `gradivo`
  ADD CONSTRAINT `gradivo_ibfk_1` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`);

--
-- Constraints for table `sporocilo`
--
ALTER TABLE `sporocilo`
  ADD CONSTRAINT `sporocilo_ibfk_1` FOREIGN KEY (`id_sporocila_d`) REFERENCES `sporocilo_dijak` (`id_sporocila_d`),
  ADD CONSTRAINT `sporocilo_ibfk_2` FOREIGN KEY (`id_sporocila_u`) REFERENCES `sporocilo_ucitelj` (`id_sporocila_u`);

--
-- Constraints for table `sporocilo_dijak`
--
ALTER TABLE `sporocilo_dijak`
  ADD CONSTRAINT `sporocilo_dijak_ibfk_1` FOREIGN KEY (`id_dijaka`) REFERENCES `dijak` (`id_dijaka`),
  ADD CONSTRAINT `sporocilo_dijak_ibfk_2` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`);

--
-- Constraints for table `sporocilo_ucitelj`
--
ALTER TABLE `sporocilo_ucitelj`
  ADD CONSTRAINT `sporocilo_ucitelj_ibfk_1` FOREIGN KEY (`id_predmeta`) REFERENCES `predmet` (`id_predmeta`),
  ADD CONSTRAINT `sporocilo_ucitelj_ibfk_2` FOREIGN KEY (`id_ucitelja`) REFERENCES `ucitelj` (`id_ucitelja`);

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
