-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 16, 2021 at 04:08 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `si_klinik`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_akun_user`
--

CREATE TABLE `tb_akun_user` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_akun_user`
--

INSERT INTO `tb_akun_user` (`id`, `email`, `password`, `user_role`) VALUES
(1, 'dev@gmail.com', '$2y$10$.ss1tUkPKglHLP/C33iGOOFc6O3SRaHgiCrFeZucITfFcAEDCbM..', 'dev'),
(2, 'loketadministrasi1@gmail.com', '$2y$10$w.CstJJ/D1FMKhp026yjjO9a8DKLbDl7QlbJsLSL8Zzi3HZCQ9Jdi', 'petugas administrasi'),
(3, 'loketadministrasi2@gmail.com', '$2y$10$vEy0lRjb88CvQmFaO3Qj8uclrsbZC1GNStnm6mHtBKniFGmctKoOW', 'petugas administrasi'),
(4, 'dokterumum@gmail.com', '$2y$10$CIJIfaMV7Ide/PvbZSsLD.qkQN92KZIll/8lbSHwZ1UlXdb8s3d.a', 'dokter'),
(5, 'dokterbedah@gmail.com', '$2y$10$uYFd3DCDHseLd9v.EbCtpOkr/kaLRnycazbGI2aHvnAeVptAukjoa', 'dokter'),
(6, 'kepalaklinik@gmail.com', '$2y$10$AmsRx1IPrTnj7ZbxtqF4YOhfN4zuhA.CGKnZDOOge7ZG1DBzMGwoa', 'kepala klinik'),
(7, 'komputerantrianadm@gmail.com', '$2y$10$QuB.2lcda3aztKuv/vezD.NvW3MkfOPirIhzMBQaVxCiveTl7x.Ve', 'antrian adm'),
(8, 'pasien@gmail.com', '$2y$10$bNOY2wFaKNPD23813GxYDeesYRp9vQxQgdnWEEclf/SiE3AWS8yUm', 'pasien');

-- --------------------------------------------------------

--
-- Table structure for table `tb_antrian_administrasi`
--

CREATE TABLE `tb_antrian_administrasi` (
  `id` int(11) NOT NULL,
  `tanggal_antrian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_antrian_poli`
--

CREATE TABLE `tb_antrian_poli` (
  `id` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `tanggal_antrian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_biodata_user`
--

CREATE TABLE `tb_biodata_user` (
  `id` int(11) NOT NULL,
  `id_akun` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `nik` bigint(18) NOT NULL,
  `jenis_kelamin` varchar(12) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `gol_darah` varchar(10) NOT NULL,
  `no_hp` bigint(15) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_bpjs` bigint(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_biodata_user`
--

INSERT INTO `tb_biodata_user` (`id`, `id_akun`, `nama`, `nik`, `jenis_kelamin`, `tanggal_lahir`, `gol_darah`, `no_hp`, `alamat`, `no_bpjs`) VALUES
(1, 1, 'Iclinic Dev', 0, 'Laki - laki', '2001-12-10', 'Belum Tahu', 0, '-', NULL),
(2, 2, 'Loket Administrasi 1', 0, 'Laki - laki', '1970-01-01', 'Belum Tahu', 0, '-', NULL),
(3, 3, 'Loket Administrasi 2', 0, 'Perempuan', '1970-01-01', 'Belum Tahu', 0, '-', NULL),
(4, 4, 'dr. Hasna Utami', 0, 'Laki - laki', '1970-01-01', 'Belum Tahu', 0, '-', NULL),
(5, 5, 'dr. Lasmono Emin', 0, 'Laki - laki', '1970-01-01', 'Belum Tahu', 0, '-', NULL),
(6, 6, 'Kepala Klinik', 0, 'Laki - laki', '1970-01-01', 'Belum Tahu', 0, '-', NULL),
(7, 7, 'Pc Antrian Adm', 0, 'Laki - laki', '1970-01-01', 'Belum Tahu', 0, '-', NULL),
(8, 8, 'Pasien 1', 330225123456789, 'Laki - laki', '1970-01-01', 'B', 123456789, 'Purwokerto', 123456789);

-- --------------------------------------------------------

--
-- Table structure for table `tb_counter`
--

CREATE TABLE `tb_counter` (
  `id` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `nomor_antrian` int(3) NOT NULL,
  `no_loket` int(2) NOT NULL,
  `tanggal_pengoperasian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_counter`
--

INSERT INTO `tb_counter` (`id`, `id_unit`, `nomor_antrian`, `no_loket`, `tanggal_pengoperasian`) VALUES
(1, 1, 0, 1, '2021-10-16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id` int(11) NOT NULL,
  `id_unit` int(11) NOT NULL,
  `hari_praktek` varchar(10) NOT NULL,
  `waktu_praktek` time NOT NULL,
  `status_jadwal` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_jadwal`
--

INSERT INTO `tb_jadwal` (`id`, `id_unit`, `hari_praktek`, `waktu_praktek`, `status_jadwal`) VALUES
(1, 2, 'Senin', '08:00:00', 'Aktif'),
(2, 2, 'Selasa', '08:00:00', 'Aktif'),
(3, 2, 'Rabu', '08:00:00', 'Aktif'),
(4, 2, 'Kamis', '08:00:00', 'Aktif'),
(5, 2, 'Jumat', '08:00:00', 'Aktif'),
(6, 3, 'Senin', '09:00:00', 'Aktif'),
(7, 4, 'Kamis', '10:00:00', 'Aktif'),
(8, 3, 'Rabu', '09:00:00', 'Aktif'),
(9, 3, 'Sabtu', '10:00:00', 'Aktif'),
(10, 4, 'Selasa', '09:00:00', 'Aktif'),
(11, 4, 'Jumat', '08:00:00', 'Aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_loket_administrasi`
--

CREATE TABLE `tb_loket_administrasi` (
  `id` int(11) NOT NULL,
  `no_loket` int(3) NOT NULL,
  `id_assigned_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_loket_administrasi`
--

INSERT INTO `tb_loket_administrasi` (`id`, `no_loket`, `id_assigned_user`) VALUES
(1, 1, 2),
(2, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendaftaran_offline`
--

CREATE TABLE `tb_pendaftaran_offline` (
  `id` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `no_antrian_poli` int(3) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `nik` bigint(18) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` varchar(12) NOT NULL,
  `gol_darah` varchar(10) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `no_bpjs` bigint(25) DEFAULT NULL,
  `kd_pendaftaran` varchar(255) NOT NULL,
  `verifikasi_administrasi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pendaftaran_online`
--

CREATE TABLE `tb_pendaftaran_online` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `no_antrian_administrasi` int(3) NOT NULL,
  `no_antrian_poli` int(3) NOT NULL,
  `tanggal_periksa` date NOT NULL,
  `kd_pendaftaran` varchar(255) NOT NULL,
  `jenis_pembiayaan` varchar(10) NOT NULL,
  `verifikasi_administrasi` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_saran_masukan`
--

CREATE TABLE `tb_saran_masukan` (
  `id` int(11) NOT NULL,
  `subject` varchar(20) NOT NULL,
  `pesan` text NOT NULL,
  `waktu_submit` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_unit`
--

CREATE TABLE `tb_unit` (
  `id` int(11) NOT NULL,
  `nama_unit` varchar(50) NOT NULL,
  `id_akun_dokter` int(11) DEFAULT NULL,
  `max_kuota` int(3) DEFAULT NULL,
  `unit_status` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_unit`
--

INSERT INTO `tb_unit` (`id`, `nama_unit`, `id_akun_dokter`, `max_kuota`, `unit_status`) VALUES
(1, 'administrasi', NULL, NULL, NULL),
(2, 'Umum', 4, 30, 'Aktif'),
(3, 'Penyakit Dalam', 5, 10, 'Aktif'),
(4, 'Bedah', 5, 10, 'Aktif');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_akun_user`
--
ALTER TABLE `tb_akun_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_antrian_administrasi`
--
ALTER TABLE `tb_antrian_administrasi`
  ADD PRIMARY KEY (`id`,`tanggal_antrian`) USING BTREE;

--
-- Indexes for table `tb_antrian_poli`
--
ALTER TABLE `tb_antrian_poli`
  ADD PRIMARY KEY (`id`,`id_jadwal`) USING BTREE,
  ADD KEY `jadwal_id` (`id_jadwal`);

--
-- Indexes for table `tb_biodata_user`
--
ALTER TABLE `tb_biodata_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_akun` (`id_akun`);

--
-- Indexes for table `tb_counter`
--
ALTER TABLE `tb_counter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_id` (`id_unit`);

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_unit` (`id_unit`);

--
-- Indexes for table `tb_loket_administrasi`
--
ALTER TABLE `tb_loket_administrasi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_assigned_user` (`id_assigned_user`);

--
-- Indexes for table `tb_pendaftaran_offline`
--
ALTER TABLE `tb_pendaftaran_offline`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jadwal_poli` (`id_jadwal`);

--
-- Indexes for table `tb_pendaftaran_online`
--
ALTER TABLE `tb_pendaftaran_online`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_jadwal` (`id_jadwal`),
  ADD KEY `user_id` (`id_user`);

--
-- Indexes for table `tb_saran_masukan`
--
ALTER TABLE `tb_saran_masukan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_akun_dokter` (`id_akun_dokter`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_akun_user`
--
ALTER TABLE `tb_akun_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_biodata_user`
--
ALTER TABLE `tb_biodata_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tb_counter`
--
ALTER TABLE `tb_counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tb_loket_administrasi`
--
ALTER TABLE `tb_loket_administrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_pendaftaran_offline`
--
ALTER TABLE `tb_pendaftaran_offline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pendaftaran_online`
--
ALTER TABLE `tb_pendaftaran_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_saran_masukan`
--
ALTER TABLE `tb_saran_masukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_antrian_poli`
--
ALTER TABLE `tb_antrian_poli`
  ADD CONSTRAINT `jadwal_id` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id`);

--
-- Constraints for table `tb_biodata_user`
--
ALTER TABLE `tb_biodata_user`
  ADD CONSTRAINT `id_akun` FOREIGN KEY (`id_akun`) REFERENCES `tb_akun_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tb_counter`
--
ALTER TABLE `tb_counter`
  ADD CONSTRAINT `unit_id` FOREIGN KEY (`id_unit`) REFERENCES `tb_unit` (`id`);

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `id_unit` FOREIGN KEY (`id_unit`) REFERENCES `tb_unit` (`id`);

--
-- Constraints for table `tb_loket_administrasi`
--
ALTER TABLE `tb_loket_administrasi`
  ADD CONSTRAINT `id_assigned_user` FOREIGN KEY (`id_assigned_user`) REFERENCES `tb_akun_user` (`id`);

--
-- Constraints for table `tb_pendaftaran_offline`
--
ALTER TABLE `tb_pendaftaran_offline`
  ADD CONSTRAINT `id_jadwal_poli` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id`);

--
-- Constraints for table `tb_pendaftaran_online`
--
ALTER TABLE `tb_pendaftaran_online`
  ADD CONSTRAINT `id_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `tb_jadwal` (`id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`id_user`) REFERENCES `tb_akun_user` (`id`);

--
-- Constraints for table `tb_unit`
--
ALTER TABLE `tb_unit`
  ADD CONSTRAINT `id_akun_dokter` FOREIGN KEY (`id_akun_dokter`) REFERENCES `tb_akun_user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
