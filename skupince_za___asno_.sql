-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 12. sep 2023 ob 08.20
-- Različica strežnika: 10.4.27-MariaDB
-- Različica PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Zbirka podatkov: `skupince(za časno)`
--

-- --------------------------------------------------------

--
-- Struktura tabele `predmet`
--

CREATE TABLE `predmet` (
  `id_predmeta` int(11) NOT NULL,
  `naziv_predmeta` varchar(11) NOT NULL,
  `id_učitelja` int(11) NOT NULL,
  `letnik` int(11) NOT NULL,
  `razred` varchar(11) NOT NULL,
  `id_učenca` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `predmet`
--

INSERT INTO `predmet` (`id_predmeta`, `naziv_predmeta`, `id_učitelja`, `letnik`, `razred`, `id_učenca`) VALUES
(2, 'Slovenščina', 1, 4, 'R4a', 2);

-- --------------------------------------------------------

--
-- Struktura tabele `učenec`
--

CREATE TABLE `učenec` (
  `id_učenca` int(11) NOT NULL,
  `ime_učenca` varchar(11) NOT NULL,
  `priimek_učenca` varchar(11) NOT NULL,
  `letnik` int(11) NOT NULL,
  `razred` varchar(11) NOT NULL,
  `spol` varchar(1) NOT NULL,
  `datum_rojstva` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `učenec`
--

INSERT INTO `učenec` (`id_učenca`, `ime_učenca`, `priimek_učenca`, `letnik`, `razred`, `spol`, `datum_rojstva`) VALUES
(2, 'Manja', 'Zdovc', 4, 'R4A', 'ž', '2005-03-20');

-- --------------------------------------------------------

--
-- Struktura tabele `učitelj`
--

CREATE TABLE `učitelj` (
  `id_učitelja` int(11) NOT NULL,
  `ime_učitelja` varchar(11) NOT NULL,
  `priimek_učitelja` varchar(11) NOT NULL,
  `spol` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `učitelj`
--

INSERT INTO `učitelj` (`id_učitelja`, `ime_učitelja`, `priimek_učitelja`, `spol`) VALUES
(1, 'Borut', 'Slemenšek', 'm');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`id_predmeta`),
  ADD KEY `id_učitelja` (`id_učitelja`),
  ADD KEY `id_ucenca` (`id_učenca`);

--
-- Indeksi tabele `učenec`
--
ALTER TABLE `učenec`
  ADD PRIMARY KEY (`id_učenca`);

--
-- Indeksi tabele `učitelj`
--
ALTER TABLE `učitelj`
  ADD PRIMARY KEY (`id_učitelja`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id_predmeta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `učenec`
--
ALTER TABLE `učenec`
  MODIFY `id_učenca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT tabele `učitelj`
--
ALTER TABLE `učitelj`
  MODIFY `id_učitelja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `predmet`
--
ALTER TABLE `predmet`
  ADD CONSTRAINT `predmet_ibfk_1` FOREIGN KEY (`id_učitelja`) REFERENCES `učitelj` (`id_učitelja`),
  ADD CONSTRAINT `predmet_ibfk_2` FOREIGN KEY (`id_učenca`) REFERENCES `učenec` (`id_učenca`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
