-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2023 at 07:27 PM
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
(8, 'jan', 'jansa', 'jan@aa', 1, '', 'M', '', '123', ''),
(10, 'janci', 'jancek', 'janci@gmail', 1, '', 'm', 'ker', '', ''),
(21, 'kia', 'jak', 'jak@kia', 2, 'r4', 'm', 'ker', '123', 'profilna_slika/osnovna_slika.jpg'),
(23, 'asda', 'asdasd', 'asdasad@asd', 3, '4', 'm', 'asd', 'asd', 'profilna_slika/osnovna_slika.jpg'),
(24, 'asda', 'asdasd', 'asdasad@asd', 3, '4', 'm', 'asd', 'asd', 'profilna_slika/osnovna_slika.jpg');

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
(12, 10, 2),
(13, 21, 3);

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

--
-- Dumping data for table `dodeljene_naloge`
--

INSERT INTO `dodeljene_naloge` (`id_dodeljene_naloge`, `id_predmeta`, `naziv_naloge`, `datoteka`, `Naloga`) VALUES
(4, 3, '123', 'Učni list - Polinomi - 2 (1).pdf', '123'),
(5, 3, '123', 'Učni list - Polinomi - 2 (1).pdf', '123'),
(6, 3, '123123', '01_Od_nepostavljenega_racunalnika_do_spletne_aplikacije_2021-22 (1).docx', '123'),
(7, 3, 'naloga', 'Slika5.png', 'Naloga je...'),
(8, 3, 'naloga', 'Slika5.png', 'Naloga je...'),
(9, 3, 'naloga', 'Učni list - Polinomi - 1.pdf', 'Naloga je...'),
(10, 3, 'naloga', 'Učni list - Polinomi - 1.pdf', 'Naloga je...');

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
-- Table structure for table `oddane_naloge`
--

CREATE TABLE `oddane_naloge` (
  `id_oddane_naloge` int(11) NOT NULL,
  `id_dijaka` int(11) NOT NULL,
  `id_dodeljene_naloge` int(11) NOT NULL,
  `datoteka` varchar(255) NOT NULL,
  `besedilo` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `oddane_naloge`
--

INSERT INTO `oddane_naloge` (`id_oddane_naloge`, `id_dijaka`, `id_dodeljene_naloge`, `datoteka`, `besedilo`) VALUES
(1, 21, 4, 'oddane_naloge/0708-POLINOMI-RACIONALNA.pdf', '');

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
(32, '3', 0),
(33, 'ika', 0);

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
(20, 'Kaja', 'Pikica', 'pika@kaja', '$2y$10$cO6CNSmp3FCoyYhqhXaUlel', 'profilna_slika/osnovna_slika.jpg'),
(21, 'Jan', 'asdasd', 'jan@u', '$2y$10$xZAe7U90iNwKACEVcm/./.D', 'profilna_slika/IMG-0499.jpg');

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
(6, 20, 9),
(9, 20, 18),
(10, 20, 19),
(11, 20, 20),
(21, 21, 2),
(22, 21, 3),
(23, 21, 5),
(24, 21, 30),
(25, 21, 31),
(26, 21, 32),
(27, 21, 33);

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
-- Indexes for table `oddane_naloge`
--
ALTER TABLE `oddane_naloge`
  ADD PRIMARY KEY (`id_oddane_naloge`),
  ADD KEY `id_dijaka` (`id_dijaka`),
  ADD KEY `id_dodeljene_naloge` (`id_dodeljene_naloge`);

--
-- Indexes for table `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`id_predmeta`);

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
  MODIFY `id_dijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `dijak_predmet`
--
ALTER TABLE `dijak_predmet`
  MODIFY `id_dijak_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `dodeljene_naloge`
--
ALTER TABLE `dodeljene_naloge`
  MODIFY `id_dodeljene_naloge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `gradivo`
--
ALTER TABLE `gradivo`
  MODIFY `id_gradiva` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `oddane_naloge`
--
ALTER TABLE `oddane_naloge`
  MODIFY `id_oddane_naloge` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id_predmeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `ucitelj`
--
ALTER TABLE `ucitelj`
  MODIFY `id_ucitelja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `ucitelj_predmet`
--
ALTER TABLE `ucitelj_predmet`
  MODIFY `id_ucitelj_predmet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

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
-- Constraints for table `oddane_naloge`
--
ALTER TABLE `oddane_naloge`
  ADD CONSTRAINT `oddane_naloge_ibfk_1` FOREIGN KEY (`id_dijaka`) REFERENCES `dijak` (`id_dijaka`),
  ADD CONSTRAINT `oddane_naloge_ibfk_2` FOREIGN KEY (`id_dodeljene_naloge`) REFERENCES `dodeljene_naloge` (`id_dodeljene_naloge`);

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
