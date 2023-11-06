-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gostitelj: localhost
-- Čas nastanka: 06. nov 2023 ob 19.33
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
-- Struktura tabele `dijak`
--

CREATE TABLE `dijak` (
  `id_dijaka` int(11) NOT NULL,
  `ime_dijaka` varchar(40) NOT NULL,
  `priimek_dijaka` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Letnik` int(1) NOT NULL,
  `Razred` varchar(10) NOT NULL,
  `Spol` varchar(1) NOT NULL,
  `Oddelek` varchar(10) NOT NULL,
  `Geslo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Odloži podatke za tabelo `dijak`
--

INSERT INTO `dijak` (`id_dijaka`, `ime_dijaka`, `priimek_dijaka`, `Email`, `Letnik`, `Razred`, `Spol`, `Oddelek`, `Geslo`) VALUES
(1, 'jan', 'jan', 'zamernik.jan@gmail.com', 0, '', '', '', '0'),
(2, 'janahdsadjkljaslkd', 'janjsadjksdkjahsjkdh', 'zamernik.jan@gmail.commmmm', 0, '', '', '', '0'),
(3, 'sadddasd', 'dasdasd', 'asdasdad@asd', 3, '', '', '', '0'),
(4, '12', '1212', 'mnad@sadasd', 4, '', 'M', '', '0'),
(5, 'jan', 'tuhtar', 'jan.tuhtar7@gmial.com', 4, 'R4A', 'm', 'KER', 'hihi'),
(6, 'Emily', 'Johnson', 'emily.johnson@dijak.si', 3, 'R', 'z', 'ker', 'emily123'),
(7, 'Noah', 'Martinez', 'noah.martinez@dijak.si', 2, 'E', 'm', 'ker', 'Noah123'),
(8, 'Olivia', 'Wang', 'olivia.wang@dijak.si', 1, 'K', 'z', 'ker', 'Olivia123'),
(9, 'Liam', 'Rodriguez', 'liam.rodriguez@dijak.si', 2, 'R', 'm', 'ker', 'Liam123'),
(10, 'Sophia', 'Brown', 'sophia.brown@dijak.si', 1, 'K', 'z', 'ker', 'Sophia123'),
(11, 'Ethan', 'Garcia', 'ethan.garcia@dijak.si', 2, 'R', 'm', 'ker', 'Ethan123'),
(12, 'Ema', 'Škrbec', 'ema.skrbec@dijak.si', 2, 'K', 'z', 'ker', 'Ema123'),
(13, 'Matija', 'Hribar', 'matija.hribar@dijak.si', 4, 'R', 'm', 'ker', 'Matija123'),
(14, 'Lara', 'Kralj', 'lara.kralj@dijak.si', 3, 'R', 'z', 'ker', 'Lara123'),
(15, 'Tim', 'Gorišek', 'tim.gorišek@dijak.si', 2, 'E', 'm', 'ker', 'Tim123'),
(16, 'Zoja', 'Pogačar', 'zoja.pogacar@dijak.si', 2, 'K', 'z', 'ker', 'Zoja123'),
(17, 'Andraž', 'Černe', 'andraz.cerne@dijak.si', 3, 'R', 'm', 'ker', 'Andraž123'),
(18, 'Nives', 'Leban', 'nives.leban@dijak.si', 2, 'R', 'z', 'ker', 'Nives123'),
(19, 'Gal', 'Jerman', 'gal.jerman@djiak.si', 4, 'R', 'm', 'ker', 'Gal123'),
(20, 'Ela', 'Kocjančič', 'ela.kocjancic@dijak.si', 4, 'R', 'z', 'ker', 'Ela123'),
(21, 'Tilen', 'Čušin', 'tilen.cusin@dijak.si', 1, 'E', 'm', 'ker', 'Tilen123'),
(22, 'Tajda', 'Klemenčič', 'tajda.klemencic@dijak.si', 1, 'R', 'z', 'ker', 'Tajda123'),
(23, 'Marcel', 'Rajh', 'marcel.rajh@dijak.si', 2, 'E', 'm', 'ker', 'Marcel123'),
(24, 'Zala', 'Kolar', 'zala.kolar@dijak.si', 2, 'K', 'z', 'ker', 'Zala123'),
(25, 'Miha', 'Ambrožič', 'miha.ambrozic@dijak.si', 1, 'K', 'm', 'ker', 'Miha123'),
(26, 'Ivana', 'Zorko', 'ivana.zorko@dijak.si', 4, 'K', 'z', 'ker', 'Ivana123'),
(27, 'Urban', 'Verbič', 'urban.verbič@dijak.si', 4, 'R', 'm', 'ker', 'Urban123'),
(28, 'Zoya', 'Osterman', 'zoya.osterman@dijak.si', 4, 'K', 'z', 'ker', 'Zoya123'),
(29, 'Žan', 'Hočevar', 'zan.hocevar@dijak.si', 4, 'E', 'm', 'ker', 'Žan123'),
(30, 'Anja', 'Repnik', 'anja.repnik@dijak.si', 4, 'K', 'z', 'ker', 'Anja123'),
(31, 'Aljaž', 'Dolenc', 'aljaz.dolenc@dijak.si', 4, 'E', 'm', 'ker', 'Aljaž123'),
(32, 'Lana', 'Kos', 'lana.kos@dijak.si', 1, 'K', 'z', 'ker', 'Lana123'),
(33, 'Anej', 'Lavrič', 'anej.lavric@dijak.si', 3, 'E', 'm', 'ker', 'Anej123'),
(34, 'Zoja', 'Vogrin', 'zoja.vogrin@dijak.si', 1, 'K', 'z', 'ker', 'Zoja123'),
(35, 'Teo', 'Rozman', 'teo.rozman@dijak.si', 2, 'E', 'm', 'ker', 'Teo123'),
(36, 'Iza', 'Žagar', 'iza.zagar@dijak.si', 1, 'E', 'm', 'ker', 'Iza123'),
(37, 'Alenka', 'Bračko', 'alenka.bracko@dijak.si', 2, 'K', 'z', 'ker', 'Alenka123'),
(38, 'Valentin', 'Šturm', 'valentin.sturm@dijak.si', 2, 'R', 'm', 'ker', 'Valentin123'),
(39, 'Mina', 'Bezjak', 'mina.bezjak@dijak.si', 1, 'K', 'z', 'ker', 'Mina123'),
(40, 'Nik', 'Križaj', 'nik.krizaj@dijak.si', 4, 'E', 'm', 'ker', 'Nik123'),
(41, 'Zoja', 'Hojnik', 'zoja.hojnik@dijak.si', 3, 'K', 'z', 'ker', 'Zoja123'),
(42, 'Timon', 'Gajšek', 'timon.gajsek@dijak.si', 4, 'K', 'm', 'ker', 'Timon123'),
(43, 'Eva', 'Sešel', 'eva.sesel@dijak.si', 2, 'K', 'z', 'ker', 'Eva123'),
(44, 'Urban', 'Kovačič', 'urban.kovacic@djiak.si', 1, 'R', 'm', 'ker', 'Urban123'),
(45, 'Pia', 'Vidmar', 'pia.vidmar@dijak.si', 3, 'K', 'z', 'ker', 'Pia123'),
(46, 'Tilen', 'Štular', 'tilen.stular@dijak.si', 2, 'E', 'm', 'ker', 'Tilen123'),
(47, 'Neža', 'Hribernik', 'neza.hribernik@dijak.si', 3, 'K', 'z', 'ker', 'Neža123'),
(48, 'Filip', 'Planinc', 'filip.planinc@dijak.si', 1, 'R', 'm', 'ker', 'Filip123'),
(49, 'Tia', 'Prevc', 'tia.prevc@dijak.si', 2, 'R', 'z', 'ker', 'Tia123'),
(50, 'Lovro', 'Krivec', 'lovro.krivec@dijak.si', 1, 'R', 'm', 'ker', 'Lovro123'),
(51, 'Sara', 'Belec', 'sara.belec@dijak.si', 2, 'K', 'z', 'ker', 'Sara123'),
(52, 'Matija', 'Šuštar', 'matija.sustar@dijak.si', 3, 'E', 'm', 'ker', 'Matija123'),
(53, 'Elizabeta', 'Krajnc', 'elizabeta.krajnc@dijak.si', 3, 'K', 'z', 'ker', 'Elizabeta123'),
(54, 'Jaka', 'Zupančič', 'jaka.zupancic@dijak.si', 2, 'E', 'm', 'ker', 'Jaka123'),
(55, 'Nika', 'Kocjan', 'nika.kocjan@dijak.si', 3, 'K', 'z', 'ker', 'Nika123'),
(56, 'Alja', 'Hočevar', 'alja.hocevar@dijak.si', 3, 'R', 'z', 'ker', 'Alja123'),
(57, 'Jan', 'Kolar', 'jan.kolar@dijak.si', 4, 'E', 'm', 'ker', 'Jan123'),
(58, 'Vid', 'Zupan', 'vid.zupan@dijak.si', 3, 'E', 'm', 'ker', 'Vid123'),
(59, 'Luka', 'Potočnik', 'luka.potocnik@dijak.si', 1, 'E', 'm', 'ker', 'Luka123'),
(60, 'Niko', 'Čeh', 'niko.ceh@dijak.si', 3, 'R', 'm', 'ker', 'Niko123'),
(61, 'Živa', 'Drnovšek', 'ziva.drnovsek@dijak.si', 4, 'K', 'z', 'ker', 'Živa123'),
(62, 'Erik', 'Gregorčič', 'erik.gregorcic@dijak.si', 4, 'E', 'm', 'ker', 'Erik123'),
(63, 'Veronika', 'Vrhovnik', 'veronika.vrhovnik@dijak.si', 2, 'K', 'z', 'ker', 'Veronika123'),
(64, 'Timotej', 'Rožman', 'timotej.rozman@dijak.si', 2, 'R', 'm', 'ker', 'Timotej123'),
(65, 'Neja', 'Pogačnik', 'neja.pogačnik@dijak.si', 3, 'K', 'z', 'ker', 'Neja123'),
(66, 'Lan', 'Zajc', 'lan.zajc@dijak.si', 4, 'E', 'm', 'ker', 'Lan123'),
(67, 'Zoja', 'Gornik', 'zoja.gornik@dijak.si', 3, 'K', 'z', 'ker', 'Zoja123'),
(68, 'Tian', 'Rupnik', 'tian.rupnik@dijak.si', 1, 'E', 'm', 'ker', 'Tian123'),
(69, 'Nika', 'Vodopivec', 'nika.vodopivec@dijak.si', 2, 'K', 'z', 'ker', 'Nika123'),
(70, 'Tine', 'Kotnik', 'tine.kotnik@dijak.si', 2, 'E', 'm', 'ker', 'Tine123'),
(71, 'Manca', 'Kolar', 'manca.kolar@dijak.si', 2, 'K', 'z', 'ker', 'Manca123'),
(72, 'Rok', 'Komel', 'rok.komel@dijak.si', 2, 'E', 'm', 'ker', 'Rok123'),
(73, 'Vid', 'Leben', 'vid.leben@dijak.si', 3, 'R', 'm', 'ker', 'Vid123'),
(74, 'Filip', 'Hiti', 'filip.hiti@dijak.si', 1, 'K', 'm', 'ker', 'Filip123'),
(75, 'Nik', 'Gajšek', 'nik.gajsek@dijak.si', 4, 'R', 'm', 'ker', 'Nik123'),
(76, 'Zoja', 'Kralj', 'zoja.kralj@dijak.si', 4, 'K', 'z', 'ker', 'Zoja123'),
(77, 'Oskar', 'Golob', 'oskar.golob@dijak.si', 1, 'R', 'm', 'ker', 'Oskar123'),
(78, 'Gregor', 'Zalar', 'gregor.zalar@dijak.si', 3, 'E', 'm', 'ker', 'Gregor123'),
(79, 'Miha', 'Reberšak', 'miha.rebersak@dijak.si', 3, 'E', 'm', 'ker', 'Miha123'),
(80, 'Matic', 'Pogačar', 'matic.pogacar@dijak.si', 3, 'K', 'm', 'ker', 'Matic123'),
(81, 'Zoja', 'Tratnik', 'zoja.tratnik@dijak.si', 2, 'K', 'z', 'ker', 'Zoja123'),
(82, 'Janja', 'Kovač', 'janja.kovac@dijak.si', 3, 'K', 'z', 'ker', 'Janja123'),
(83, 'Erik', 'Pirš', 'erik.pirs@dijak.si', 2, 'R', 'm', 'ker', 'Erik123'),
(84, 'Zara', 'Krajnc', 'zara.krajnc@dijak.si', 1, 'K', 'z', 'ker', 'Zara123'),
(85, 'Aleks', 'Horvat', 'aleks.horvat@dijak.si', 1, 'E', 'm', 'ker', 'Aleks123'),
(86, 'Lana', 'Štular', 'lana.stular@dijak.si', 4, 'K', 'z', 'ker', 'Lana123'),
(87, 'Anže', 'Mlakar', 'anze.mlakar@dijak.si', 3, 'E', 'z', 'ker', 'Anže123'),
(88, 'Alja', 'Podobnik', 'alja.podobnik@dijak.si', 2, 'K', 'z', 'ker', 'Alja123'),
(89, 'Jure', 'Zorman', 'jure.zorman@dijak.si', 3, 'R', 'm', 'ker', 'Jure123'),
(90, 'Lovro', 'Petek', 'lovro.petek@dijak.si', 2, 'R', 'm', 'ker', 'Lovro123'),
(91, 'Neža', 'Bizjak', 'neza.bizjak@dijak.si', 4, 'K', 'z', 'ker', 'Neža123'),
(92, 'Aljaž', 'Hrovat', 'aljaz.hrovat@dijak.si', 1, 'K', 'm', 'ker', 'Aljaz1234'),
(93, 'Iva', 'Kocjančič', 'iva.kocjancic@dijak.si', 2, 'K', 'z', 'ker', 'Iva123'),
(94, 'Tilen', 'Hiti', 'tilen.hiti@dijak.si', 3, 'R', 'm', 'ker', 'Tilen1234'),
(95, 'Hana', 'Novak', 'hana.novak@dijak.si', 3, 'K', 'z', 'ker', 'Hana123'),
(96, 'Nejc', 'Zupan', 'nejc.zupan@dijak.si', 2, 'R', 'm', 'ker', 'Nejc123'),
(97, 'Zala', 'Kocjan', 'zala.kocjan@dijak.si', 2, 'E', 'z', 'ker', 'Zala123'),
(98, 'Ana', 'Novak', 'ana.novak@dijak.si', 4, 'K', 'z', 'ker', 'Ana123'),
(99, 'Luka', 'Kovač', 'luka.kovac@dijak.si', 1, 'K', 'm', 'ker', 'Luka123'),
(100, 'Marko', 'Zupan', 'marko.zupan@dijak.si', 4, 'R', 'm', 'ker', 'Marko123');

--
-- Indeksi zavrženih tabel
--

--
-- Indeksi tabele `dijak`
--
ALTER TABLE `dijak`
  ADD PRIMARY KEY (`id_dijaka`);

--
-- AUTO_INCREMENT zavrženih tabel
--

--
-- AUTO_INCREMENT tabele `dijak`
--
ALTER TABLE `dijak`
  MODIFY `id_dijaka` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
