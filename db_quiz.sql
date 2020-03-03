-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 08, 2018 at 05:56 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `username` varchar(10) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`username`, `nama`, `password`) VALUES
('asf6768', 'Ambalan Soekarno Fatmawati', '$2y$10$Ck1kx4S4.o/JO8cNJa0JGOGFHFOhIzVlLh7LGx06M8oibUjGD40gC'),
('testtest', 'testtest', '$2y$10$bZKtkFmWl6WdxKdm6RYWmuqencQMdaz2vMt7LO7eKmcI6smv.jlPO');

-- --------------------------------------------------------

--
-- Table structure for table `tb_answer`
--

CREATE TABLE `tb_answer` (
  `id_answer` int(11) NOT NULL,
  `username_answer` varchar(100) CHARACTER SET latin1 NOT NULL,
  `team_answer` int(11) NOT NULL,
  `question` int(11) NOT NULL,
  `choice` int(11) NOT NULL,
  `time_answer` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_log`
--

CREATE TABLE `tb_log` (
  `id_log` int(11) NOT NULL,
  `username_log` varchar(100) CHARACTER SET latin1 NOT NULL,
  `type_log` varchar(50) CHARACTER SET latin1 NOT NULL,
  `time_log` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_question`
--

CREATE TABLE `tb_question` (
  `id_question` int(11) NOT NULL,
  `question_name` text NOT NULL,
  `question_image` varchar(255) DEFAULT NULL,
  `option1` varchar(100) NOT NULL,
  `option2` varchar(100) NOT NULL,
  `option3` varchar(100) NOT NULL,
  `option4` varchar(100) NOT NULL,
  `option5` varchar(100) NOT NULL,
  `answer` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_question`
--

INSERT INTO `tb_question` (`id_question`, `question_name`, `question_image`, `option1`, `option2`, `option3`, `option4`, `option5`, `answer`) VALUES
(1, 'Coba tambah soal', '', '1', '2', '3', '4', '5', 1),
(2, 'Coba ubah soal bergambar', 'img/WIN_20171223_13_34_30_Pro.jpg', '1', '2', '3', '4', '5', 5),
(3, 'Ubah soal tanpa gambar, jawaban 3', '', '1', '2', '3', '4', '5', 3),
(4, 'Ubah soal dengan gambar, jawaban 4', 'img/Bali-is-Safe.png', '1', '2', '3', '4', '5', 4),
(6, 'Coba upload baru', 'img/Jalak-Bali.png', '1', '2', '3', '4', '5', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_setting`
--

CREATE TABLE `tb_setting` (
  `total_question` int(11) NOT NULL,
  `point_right` int(11) NOT NULL,
  `point_wrong` int(11) NOT NULL,
  `point_unanswered` int(11) NOT NULL,
  `time_hours` int(11) NOT NULL,
  `time_minutes` int(11) NOT NULL,
  `allow_registration` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_setting`
--

INSERT INTO `tb_setting` (`total_question`, `point_right`, `point_wrong`, `point_unanswered`, `time_hours`, `time_minutes`, `allow_registration`) VALUES
(50, 3, -1, 0, 1, 30, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_team`
--

CREATE TABLE `tb_team` (
  `id_team` int(11) NOT NULL,
  `name_team` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tb_team`
--

INSERT INTO `tb_team` (`id_team`, `name_team`) VALUES
(11, 'SMP Singaraja'),
(12, 'SMP Manggis'),
(13, 'Tim Tambahan Berubah');

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `username` varchar(100) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `team` int(11) DEFAULT NULL,
  `done` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`username`, `nama`, `password`, `team`, `done`) VALUES
('manggis1', 'Made Siswi', '$2y$10$CwmHoLdkUd6Deb3QSYhKQ.bn.b.uRJoXjjXhe0zzTzRboTNY4OSSm', 12, 0),
('manggis2', 'Kadek Siswi', '$2y$10$RghfySTGdraZlnAotesx0.k969xARecInxq3bl4.9.gC63IJkpuE.', 12, 0),
('singaraja1', 'Putu Siswa', '$2y$10$adXo8B6oswM3gvqVB2CqxOzYFwSNG3mjWmyaxFZZ20XjUdjVNcW/e', 11, 0),
('singaraja2', 'Gede Siswa', '$2y$10$DOcvJycm3nWfKDeK/O4R9.B.UrVpe2HuxNkeaNwh/.tZV56czx6Ci', 11, 0),
('tambahuser1', 'Ubah user Tambahan 1', '$2y$10$BLkmh2KLMYK7qkiHsb2wn.sMS9uejBHfiVRsl1Dts.wu6vRqvuIsy', 13, 0),
('tambahuser2', 'Ubah user Tambahan 2 dan password', '$2y$10$UJdM45ESyjW7inGjdVVW4.Bb2IQRbcyqnPCUjt4qyZK4UR4mAnFSS', 13, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `tb_answer`
--
ALTER TABLE `tb_answer`
  ADD PRIMARY KEY (`id_answer`),
  ADD KEY `user_answer` (`username_answer`),
  ADD KEY `user_question` (`question`),
  ADD KEY `team_answer` (`team_answer`);

--
-- Indexes for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `user_log` (`username_log`);

--
-- Indexes for table `tb_question`
--
ALTER TABLE `tb_question`
  ADD PRIMARY KEY (`id_question`);

--
-- Indexes for table `tb_team`
--
ALTER TABLE `tb_team`
  ADD PRIMARY KEY (`id_team`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`username`),
  ADD KEY `team_name` (`team`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_answer`
--
ALTER TABLE `tb_answer`
  MODIFY `id_answer` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_log`
--
ALTER TABLE `tb_log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_question`
--
ALTER TABLE `tb_question`
  MODIFY `id_question` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_team`
--
ALTER TABLE `tb_team`
  MODIFY `id_team` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_answer`
--
ALTER TABLE `tb_answer`
  ADD CONSTRAINT `team_answer` FOREIGN KEY (`team_answer`) REFERENCES `tb_team` (`id_team`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_answer` FOREIGN KEY (`username_answer`) REFERENCES `tb_user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_question` FOREIGN KEY (`question`) REFERENCES `tb_question` (`id_question`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_log`
--
ALTER TABLE `tb_log`
  ADD CONSTRAINT `user_log` FOREIGN KEY (`username_log`) REFERENCES `tb_user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD CONSTRAINT `team_name` FOREIGN KEY (`team`) REFERENCES `tb_team` (`id_team`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
