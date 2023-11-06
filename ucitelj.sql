-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: localhost
-- Čas nastanka: 06. nov 2023 ob 19.34
-- Različica strežnika: 10.4.28-MariaDB
-- Različica PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `skupinice`
--

-- --------------------------------------------------------

--
-- Struktura tabele `ucitelj`
--

CREATE TABLE `ucitelj` (
  `id_ucitelja` int(11) NOT NULL,
  `ime_ucitelja` varchar(30) NOT NULL,
  `priimek_ucitelja` varchar(30) NOT NULL,
  `E-mail` varchar(30) NOT NULL,
  `Geslo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `ucitelj`
--

INSERT INTO `ucitelj` (`id_ucitelja`, `ime_ucitelja`, `priimek_ucitelja`, `E-mail`, `Geslo`) VALUES
(1, 'Nika', 'Horvat', 'nika.horvat@ucitelj.si', 'NikaHorvat123'),
(2, 'Jure', 'Bizjak', 'jure.bizjak@ucitelj.si', 'JureBizjak123'),
(3, 'Petra', 'Krajnc', 'petra.krajnc@ucitelj.si', 'PetraKrajnc123'),
(4, 'Neža', 'Mlakar', 'neza.mlakar@ucitelj.si', 'NežaMlakar123'),
(5, 'Žiga', 'Gorenšek', 'ziga.gorensek@ucitelj.si', 'ŽigaGorenšek123'),
(6, 'Tjaša', 'Blažič', 'tjasa.blazic@ucitelj.si', 'TjašaBlažič123'),
(7, 'janci', 'zamernikk', 'zamernik.jan@gmail.com', '$2y$10$RG/wrXBKEK1HWjxaIV9Rx.k'),
(8, 'Maks', 'Bizjak', 'maks.bizjak@ucitelj.si', 'MaksBizjak123'),
(9, 'Manca', 'Čeh', 'manca.ceh@ucitelj.si', 'MancaČeh123'),
(10, 'janci', 'banci banance', 'ban@gem', '123');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `ucitelj`
--
ALTER TABLE `ucitelj`
  ADD PRIMARY KEY (`id_ucitelja`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `ucitelj`
--
ALTER TABLE `ucitelj`
  MODIFY `id_ucitelja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
