-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 15, 2020 at 10:01 AM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

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
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sudah_dilayani` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id_antrian`, `no_peserta`, `poli`, `nik`, `tgl_periksa`, `no_antrian`, `poli_eksekutif`, `no_referensi`, `notelp`, `jns_referensi`, `jns_req`, `timestamp`, `sudah_dilayani`) VALUES
(2, '0000000000123', '001', '3506141308950002', '2020-05-20 00:00:00', '1', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:28:00', '1'),
(3, '0000000000124', '001', '3506141308950002', '2020-05-20 00:00:00', '2', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:33:49', '0'),
(4, '0000000000125', '001', '3506141308950002', '2020-05-20 00:00:00', '3', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:34:36', '0'),
(5, '0000003000125', '002', '3506141308950002', '2020-05-20 00:00:00', '1', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-20 05:35:56', '0'),
(6, '0000003000120', '001', '3506141308950002', '2020-05-21 00:00:00', '1', '0', '0001R0040116A000001', '081123456778', '1', '2', '2020-05-21 03:28:11', '0');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_operasi`
--

CREATE TABLE `jadwal_operasi` (
  `id` bigint(20) NOT NULL,
  `kodebooking` varchar(20) NOT NULL,
  `nopeserta` varchar(13) DEFAULT NULL,
  `tanggaloperasi` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `jenistindakan` varchar(100) NOT NULL,
  `kodepoli` varchar(10) NOT NULL,
  `namapoli` varchar(20) NOT NULL,
  `terlaksana` int(1) NOT NULL,
  `lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jadwal_operasi`
--

INSERT INTO `jadwal_operasi` (`id`, `kodebooking`, `nopeserta`, `tanggaloperasi`, `jenistindakan`, `kodepoli`, `namapoli`, `terlaksana`, `lastupdate`) VALUES
(1, 'OP12340987', '0001234567890', '2021-08-22 09:14:05', 'Tumor ringan', '001', 'Penyakit Dalam', 0, '2020-07-15 09:34:27'),
(2, 'OP12340986', '0001234567891', '2020-07-14 09:14:05', 'katarak', '002', 'Jantung', 1, '2020-07-15 09:34:35');

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
-- Indexes for table `jadwal_operasi`
--
ALTER TABLE `jadwal_operasi`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id_antrian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `jadwal_operasi`
--
ALTER TABLE `jadwal_operasi`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
