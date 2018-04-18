-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas generowania: 18 Kwi 2018, 15:35
-- Wersja serwera: 5.7.21-0ubuntu0.16.04.1
-- Wersja PHP: 7.0.28-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `aseto`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `breaks_details`
--

CREATE TABLE `breaks_details` (
  `id` int(11) NOT NULL,
  `agent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `break_start` datetime NOT NULL,
  `break_stop` datetime NOT NULL,
  `time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `worktime`
--

CREATE TABLE `worktime` (
  `id` int(11) NOT NULL,
  `agent` varchar(64) NOT NULL,
  `data` datetime NOT NULL,
  `worktime` int(11) NOT NULL,
  `pausetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `breaks_details`
--
ALTER TABLE `breaks_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `worktime`
--
ALTER TABLE `worktime`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `breaks_details`
--
ALTER TABLE `breaks_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `worktime`
--
ALTER TABLE `worktime`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
