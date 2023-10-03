-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Gostitelj: 127.0.0.1
-- Čas nastanka: 03. okt 2023 ob 09.27
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
-- Zbirka podatkov: `skupinice`
--

-- --------------------------------------------------------

--
-- Struktura tabele `dijak`
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
-- Odloži podatke za tabelo `dijak`
--

INSERT INTO `dijak` (`id_dijaka`, `ime_dijaka`, `priimek_dijaka`, `E-mail`, `Letnik`, `Razred`, `Spol`, `Oddelek`, `Geslo`) VALUES
(1, 'jan', 'jan', 'zamernik.jan@gmail.com', 0, '', '', '', '0'),
(2, 'janahdsadjkljaslkd', 'janjsadjksdkjahsjkdh', 'zamernik.jan@gmail.commmmm', 0, '', '', '', '0'),
(3, 'sadddasd', 'dasdasd', 'asdasdad@asd', 3, '', '', '', '0'),
(4, '12', '1212', 'mnad@sadasd', 4, '', 'M', '', '0'),
(5, 'jan', 'tuhtar', 'jan.tuhtar7@gmial.com', 4, 'R4A', 'm', 'KER', 'hihi');

-- --------------------------------------------------------

--
-- Struktura tabele `oddelek`
--

CREATE TABLE `oddelek` (
  `id_oddelka` int(11) NOT NULL,
  `naziv_oddelka` varchar(30) NOT NULL,
  `razred` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `predmet`
--

CREATE TABLE `predmet` (
  `id_predmeta` int(11) NOT NULL,
  `id_ucitelja` int(11) NOT NULL,
  `id_razred` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `razred`
--

CREATE TABLE `razred` (
  `id_razreda` int(11) NOT NULL,
  `ucenec` int(11) NOT NULL,
  `razrednik` int(11) NOT NULL,
  `oddelek` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabele `ucitelj`
--

CREATE TABLE `ucitelj` (
  `id_ucitelja` int(11) NOT NULL,
  `ime_ucitelja` varchar(30) NOT NULL,
  `priimek_ucitelja` varchar(30) NOT NULL,
  `spol` varchar(1) NOT NULL,
  `geslo` varchar(30) NOT NULL,
  `predmet` int(30) NOT NULL,
  `id_razred` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `dijak`
--
ALTER TABLE `dijak`
  ADD PRIMARY KEY (`id_dijaka`);

--
-- Indeksi tabele `oddelek`
--
ALTER TABLE `oddelek`
  ADD PRIMARY KEY (`id_oddelka`),
  ADD KEY `razred` (`razred`);

--
-- Indeksi tabele `predmet`
--
ALTER TABLE `predmet`
  ADD PRIMARY KEY (`id_predmeta`);

--
-- Indeksi tabele `razred`
--
ALTER TABLE `razred`
  ADD PRIMARY KEY (`id_razreda`),
  ADD KEY `oddelek` (`oddelek`),
  ADD KEY `ucenec` (`ucenec`);

--
-- Indeksi tabele `ucitelj`
--
ALTER TABLE `ucitelj`
  ADD PRIMARY KEY (`id_ucitelja`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `dijak`
--
ALTER TABLE `dijak`
  MODIFY `id_dijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT tabele `oddelek`
--
ALTER TABLE `oddelek`
  MODIFY `id_oddelka` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `predmet`
--
ALTER TABLE `predmet`
  MODIFY `id_predmeta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `razred`
--
ALTER TABLE `razred`
  MODIFY `id_razreda` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT tabele `ucitelj`
--
ALTER TABLE `ucitelj`
  MODIFY `id_ucitelja` int(11) NOT NULL AUTO_INCREMENT;

--
-- Omejitve tabel za povzetek stanja
--

--
-- Omejitve za tabelo `oddelek`
--
ALTER TABLE `oddelek`
  ADD CONSTRAINT `oddelek_ibfk_1` FOREIGN KEY (`razred`) REFERENCES `razred` (`id_razreda`);

--
-- Omejitve za tabelo `razred`
--
ALTER TABLE `razred`
  ADD CONSTRAINT `razred_ibfk_2` FOREIGN KEY (`oddelek`) REFERENCES `oddelek` (`id_oddelka`),
  ADD CONSTRAINT `razred_ibfk_3` FOREIGN KEY (`ucenec`) REFERENCES `dijak` (`id_dijaka`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
