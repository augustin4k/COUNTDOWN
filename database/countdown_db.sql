-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 27, 2021 at 03:15 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `countdown_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `backup_evenimente`
--

CREATE TABLE `backup_evenimente` (
  `id_backup` int(11) NOT NULL,
  `titlu` varchar(100) NOT NULL,
  `descriere` varchar(1000) DEFAULT NULL,
  `data_event` date NOT NULL,
  `ora` time NOT NULL,
  `tip_repetare` varchar(30) NOT NULL,
  `cantitate_repetare` int(200) NOT NULL,
  `culoare` varchar(30) NOT NULL,
  `id_user` int(100) NOT NULL,
  `completat` int(2) NOT NULL,
  `seen` int(2) NOT NULL,
  `id_event` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `evenimente`
--

CREATE TABLE `evenimente` (
  `id_event` int(11) NOT NULL,
  `titlu` varchar(100) NOT NULL,
  `descriere` varchar(1000) DEFAULT NULL,
  `data_event` date NOT NULL,
  `ora` time DEFAULT NULL,
  `tip_repetare` varchar(30) DEFAULT NULL,
  `cantitate_repetare` int(200) NOT NULL,
  `culoare` varchar(200) NOT NULL,
  `id_user` int(11) NOT NULL,
  `completat` int(2) NOT NULL,
  `seen` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `evenimente`
--
DELIMITER $$
CREATE TRIGGER `backup_events` BEFORE DELETE ON `evenimente` FOR EACH ROW INSERT INTO `backup_evenimente` (`id_backup`, `titlu`, `descriere`, `data_event`, `ora`, `tip_repetare`, `cantitate_repetare`, `culoare`, 	`id_user`, `completat`, `seen`, `id_event`) VALUES (NULL, OLD.titlu, OLD.descriere, OLD.data_event, OLD.ora, OLD.tip_repetare, OLD.cantitate_repetare, OLD.culoare, OLD.id_user, 1, OLD.seen, OLD.id_event)
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nume` varchar(25) NOT NULL,
  `prenume` varchar(25) NOT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `parola` varchar(1000) NOT NULL,
  `status` int(11) NOT NULL,
  `token` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backup_evenimente`
--
ALTER TABLE `backup_evenimente`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indexes for table `evenimente`
--
ALTER TABLE `evenimente`
  ADD PRIMARY KEY (`id_event`),
  ADD KEY `user_event_FK` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `backup_evenimente`
--
ALTER TABLE `backup_evenimente`
  MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=266;

--
-- AUTO_INCREMENT for table `evenimente`
--
ALTER TABLE `evenimente`
  MODIFY `id_event` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=303;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `evenimente`
--
ALTER TABLE `evenimente`
  ADD CONSTRAINT `user_event_FK` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
