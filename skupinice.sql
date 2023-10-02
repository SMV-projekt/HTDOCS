-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2023 at 08:35 PM
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
  `Geslo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dijak`
--

INSERT INTO `dijak` (`id_dijaka`, `ime_dijaka`, `priimek_dijaka`, `E-mail`, `Letnik`, `Razred`, `Spol`, `Oddelek`, `Geslo`) VALUES
(1, 'jan', 'jan', 'zamernik.jan@gmail.com', 0, '', '', '', 0),
(2, 'janahdsadjkljaslkd', 'janjsadjksdkjahsjkdh', 'zamernik.jan@gmail.commmmm', 0, '', '', '', 0),
(3, 'sadddasd', 'dasdasd', 'asdasdad@asd', 3, '', '', '', 0),
(4, '12', '1212', 'mnad@sadasd', 4, '', 'M', '', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dijak`
--
ALTER TABLE `dijak`
  ADD PRIMARY KEY (`id_dijaka`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dijak`
--
ALTER TABLE `dijak`
  MODIFY `id_dijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
