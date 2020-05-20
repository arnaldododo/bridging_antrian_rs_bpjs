-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 20, 2020 at 07:36 AM
-- Server version: 5.7.26
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `bpjs_antrian`
--

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id_antrian` int(11) NOT NULL,
  `no_peserta` varchar(13) DEFAULT NULL,
  `poli` varchar(5) NOT NULL,
  `nik` varchar(16) DEFAULT NULL,
  `tgl_periksa` datetime NOT NULL,
  `no_antrian` varchar(5) NOT NULL,
  `poli_eksekutif` enum('0','1') NOT NULL DEFAULT '0',
  `no_referensi` varchar(100) NOT NULL,
  `notelp` varchar(20) DEFAULT NULL,
  `jns_referensi` varchar(1) NOT NULL,
  `jns_req` varchar(1) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id_antrian`, `no_peserta`, `poli`, `nik`, `tgl_periksa`, `no_antrian`, `poli_eksekutif`, `no_referensi`, `notelp`, `jns_referensi`, `jns_req`, `timestamp`) VALUES
(2, '0000000000123', '001', '3506141308950002', '2020-05-20 00:00:00', '1', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:28:00'),
(3, '0000000000124', '001', '3506141308950002', '2020-05-20 00:00:00', '2', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:33:49'),
(4, '0000000000125', '001', '3506141308950002', '2020-05-20 00:00:00', '3', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:34:36'),
(5, '0000003000125', '002', '3506141308950002', '2020-05-20 00:00:00', '1', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:35:56');

-- --------------------------------------------------------

--
-- Table structure for table `poli`
--

CREATE TABLE `poli` (
  `kode_poli` varchar(10) NOT NULL,
  `nama_poli` varchar(100) NOT NULL,
  `kode_antri` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `poli`
--

INSERT INTO `poli` (`kode_poli`, `nama_poli`, `kode_antri`) VALUES
('001', 'Penyakit Dalam', 'A'),
('002', 'Jantung', 'B');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('cnVtYWhzYWtpdA==', 'cnVtYWhzYWtpdA==');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id_antrian`);

--
-- Indexes for table `poli`
--
ALTER TABLE `poli`
  ADD PRIMARY KEY (`kode_poli`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
