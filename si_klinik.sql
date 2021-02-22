-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2020 at 09:36 AM
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
(4, 'doktergigi@gmail.com', '$2y$10$uNQKNr0Q2fatPa3j0hPxOePnhhBtW62u8dnZhyp/BaBK/YbV3g00e', 'dokter'),
(5, 'dokteranak@gmail.com', '$2y$10$uNQKNr0Q2fatPa3j0hPxOePnhhBtW62u8dnZhyp/BaBK/YbV3g00e', 'dokter'),
(6, 'administrasi1@gmail.com', '$2y$10$uNQKNr0Q2fatPa3j0hPxOePnhhBtW62u8dnZhyp/BaBK/YbV3g00e', 'petugas administrasi'),
(7, 'administrasi2@gmail.com', '$2y$10$TunIS36u/PjeDWGVab4AW.lxbVqmUawK5XENPbft9YvuHisBKDgI2', 'petugas administrasi'),
(18, 'rulihanif@gmail.com', '$2y$10$PJx9TkEz2n0M8B16c7RdxOliEGRo3kfh3fnO3hKI2MUEslB6pXWjS', 'pasien'),
(20, 'dokterumum@gmail.com', '$2y$10$czj1C9/dEAFqLGOdxESWuOV7vs2uYXJ8EuhHzjP8KFgi.5c8CLFhO', 'dokter'),
(21, 'dev@gmail.com', '$2y$10$/1GGN6NCoOuo9fwFSG9Ev.1C4QzHwQ0EcsMu4Ay3PbPLsitym0R1a', 'dev'),
(22, 'doktertht@gmail.com', '$2y$10$7CCdgL7h4ahpOJWTfKPtBO.kXLPCVJ.JVwdH6ojyF8VlPO7wg2Pke', 'dokter'),
(23, 'antrianadm@gmail.com', '$2y$10$NhM0CuhTXfOq4tnctNiFwuag5dsuMlzW7hxI0fCVeWWZn7db1fqeW', 'antrian adm');

-- --------------------------------------------------------

--
-- Table structure for table `tb_antrian_administrasi`
--

CREATE TABLE `tb_antrian_administrasi` (
  `id` int(11) NOT NULL,
  `tanggal_antrian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_antrian_administrasi`
--

INSERT INTO `tb_antrian_administrasi` (`id`, `tanggal_antrian`) VALUES
(1, '2020-12-05'),
(1, '2020-12-06'),
(1, '2020-12-08'),
(1, '2020-12-09'),
(1, '2020-12-10'),
(1, '2020-12-11'),
(1, '2020-12-12'),
(2, '2020-12-05'),
(2, '2020-12-06'),
(2, '2020-12-09'),
(2, '2020-12-10'),
(2, '2020-12-11'),
(2, '2020-12-12'),
(3, '2020-12-05'),
(3, '2020-12-06'),
(3, '2020-12-09'),
(3, '2020-12-10'),
(3, '2020-12-11'),
(3, '2020-12-12'),
(4, '2020-12-05'),
(4, '2020-12-06'),
(4, '2020-12-09'),
(4, '2020-12-10'),
(4, '2020-12-11'),
(4, '2020-12-12'),
(5, '2020-12-05'),
(5, '2020-12-09'),
(5, '2020-12-10'),
(5, '2020-12-11'),
(6, '2020-12-05'),
(6, '2020-12-09'),
(6, '2020-12-10'),
(6, '2020-12-11'),
(7, '2020-12-05'),
(7, '2020-12-09'),
(7, '2020-12-10'),
(8, '2020-12-05'),
(8, '2020-12-09'),
(9, '2020-12-09'),
(10, '2020-12-09'),
(11, '2020-12-09'),
(12, '2020-12-09'),
(13, '2020-12-09'),
(14, '2020-12-09'),
(15, '2020-12-09'),
(16, '2020-12-09'),
(17, '2020-12-09');

-- --------------------------------------------------------

--
-- Table structure for table `tb_antrian_poli`
--

CREATE TABLE `tb_antrian_poli` (
  `id` int(11) NOT NULL,
  `id_jadwal` int(11) NOT NULL,
  `tanggal_antrian` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_antrian_poli`
--

INSERT INTO `tb_antrian_poli` (`id`, `id_jadwal`, `tanggal_antrian`) VALUES
(1, 10, '2020-12-09'),
(1, 12, '2020-12-10'),
(1, 13, '2020-12-11'),
(1, 14, '2020-12-05'),
(1, 15, '2020-12-06'),
(1, 16, '2020-12-08'),
(1, 17, '2020-12-12'),
(1, 18, '2020-12-11'),
(2, 10, '2020-12-09'),
(2, 12, '2020-12-10'),
(2, 13, '2020-12-11'),
(2, 14, '2020-12-05'),
(2, 15, '2020-12-06'),
(2, 17, '2020-12-12'),
(2, 18, '2020-12-11'),
(3, 10, '2020-12-09'),
(3, 12, '2020-12-10'),
(3, 14, '2020-12-05'),
(3, 15, '2020-12-06'),
(4, 10, '2020-12-09'),
(4, 12, '2020-12-10'),
(4, 14, '2020-12-05'),
(4, 15, '2020-12-06'),
(5, 10, '2020-12-09'),
(5, 12, '2020-12-10'),
(5, 14, '2020-12-05'),
(6, 10, '2020-12-09'),
(6, 12, '2020-12-10'),
(6, 14, '2020-12-05'),
(7, 10, '2020-12-09'),
(7, 12, '2020-12-10'),
(7, 14, '2020-12-05'),
(8, 10, '2020-12-09'),
(8, 14, '2020-12-05'),
(9, 10, '2020-12-09'),
(10, 10, '2020-12-09'),
(11, 10, '2020-12-09'),
(12, 10, '2020-12-09');

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
(10, 21, 'dev', 12345678, 'laki - laki', '2313-12-31', 'Belum Tahu', 123123123, 'inet', NULL),
(12, 23, 'Ambil Antrian', 0, 'laki - laki', '0001-01-01', 'Belum Tahu', 0, '-', NULL),
(14, 4, 'dr. Spesialis Gigi. S.Kes', 3302252512010004, 'laki - laki', '2020-12-01', 'B', 813213124, 'Purwokerto', NULL),
(16, 5, 'dr. Spesialis Anak. S.Kes', 33022525215120, 'laki - laki', '0000-00-00', 'A', 84123123, 'Cilacap', NULL),
(17, 20, 'dr. Umum. S.Kes', 3302252510010002, 'laki - laki', '2020-12-01', 'A', 822125148982, 'Purwokerto', NULL),
(18, 18, 'Ruly Adhika MH', 3302252510010002, 'Laki - laki', '2001-12-25', 'B', 82241148983, 'Purwokerto', 12412315231231),
(19, 22, 'dr. Spesialis Tht. S.Kes', 3302252112010004, 'Laki - laki', '2020-12-01', 'A', 8123123123, 'Pwt', NULL),
(20, 6, 'Administrasi Loket 1', 0, 'Laki - laki', '0000-00-00', 'Belum Tahu', 0, '-', NULL),
(21, 7, 'Administrasi Loket 2', 0, 'laki - laki', '0000-00-00', 'Belum Tahu', 0, '-', NULL);

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
(1, 1, 4, 3, '2020-12-12');

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
(9, 7, 'Senin', '10:40:00', 'Aktif'),
(10, 7, 'Rabu', '10:20:00', 'Aktif'),
(12, 9, 'Kamis', '11:20:00', 'Aktif'),
(13, 10, 'Jumat', '14:00:00', 'Aktif'),
(14, 9, 'Sabtu', '09:45:00', 'Aktif'),
(15, 10, 'Minggu', '10:05:00', 'Aktif'),
(16, 11, 'Selasa', '10:00:00', 'Aktif'),
(17, 11, 'Sabtu', '02:06:00', 'Aktif'),
(18, 7, 'Jumat', '10:00:00', 'Aktif');

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
(15, 1, 6),
(18, 2, 7);

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

--
-- Dumping data for table `tb_pendaftaran_offline`
--

INSERT INTO `tb_pendaftaran_offline` (`id`, `id_jadwal`, `no_antrian_poli`, `tanggal_periksa`, `nik`, `nama`, `tanggal_lahir`, `jenis_kelamin`, `gol_darah`, `alamat`, `no_bpjs`, `kd_pendaftaran`, `verifikasi_administrasi`) VALUES
(1, 14, 1, '2020-12-05', 33022525120, 'Ruly', '2020-12-18', 'laki - laki', 'A', 'Purwokerto', NULL, '5fcba84d81b064.85281664', 'Terverifikasi'),
(2, 14, 8, '2020-12-05', 123123, 'Ruly', '2020-12-17', 'laki - laki', 'B', 'qwe', NULL, '5fcbab6a9bf976.94662631', 'Terverifikasi'),
(3, 15, 1, '2020-12-06', 3302252512010005, 'Ruly', '2020-12-30', 'laki - laki', 'B', 'pwt', NULL, '5fcc82048b9dc8.37029836', 'Terverifikasi'),
(4, 15, 2, '2020-12-06', 123123, 'qweqew', '2021-01-07', 'laki - laki', 'B', 'qwe', NULL, '5fcc82494444d9.50931686', 'Terverifikasi'),
(5, 15, 3, '2020-12-06', 123123123, 'qweqe', '2020-12-30', 'laki - laki', 'A', 'qewqe', NULL, '5fcc82c9aee837.84261106', 'Terverifikasi'),
(6, 15, 4, '2020-12-06', 123123, 'qweqew', '2020-12-17', 'laki - laki', 'B', 'qweqe', 12313, '5fcc83003bcc20.42716180', 'Terverifikasi'),
(7, 16, 1, '2020-12-08', 12312313, 'qeqe', '2021-01-06', 'laki - laki', 'B', 'qwe', 123, '5fcf0b40ba77f5.34128345', 'Terverifikasi'),
(12, 12, 4, '2020-12-10', 13123, 'qweqew', '0000-00-00', 'laki - laki', 'B', 'weq', NULL, '5fd10684177804.01403126', 'Terverifikasi'),
(13, 12, 5, '2020-12-10', 123123, 'www', '2020-12-16', 'laki - laki', 'A', 'wqe', 123123123, '5fd107186f62f0.81553431', 'Terverifikasi'),
(14, 12, 6, '2020-12-10', 123123, '321', '2020-12-12', 'laki - laki', 'B', 'qwe', 12313, '5fd1078b745d60.87970418', 'Terverifikasi'),
(15, 12, 7, '2020-12-10', 3213123123, 'test 1123', '0000-00-00', 'laki - laki', 'B', 'qeqwe', 123456789, '5fd124a88f1323.74589117', 'Terverifikasi'),
(16, 18, 2, '2020-12-11', 23123, 'qweqew', '2001-12-24', 'laki - laki', 'B', 'qwe', NULL, '5fd254bd42b754.22094009', 'Terverifikasi'),
(17, 14, 1, '2020-12-12', 131231, 'qweqe', '0023-12-13', 'Laki - laki', 'B', 'pwt\r\n', 123456, '5fd3b488b237a7.84439589', 'Terverifikasi'),
(18, 17, 1, '2020-12-12', 123123123, 'qeqe', '2020-12-03', 'Laki - laki', 'B', 'pwt', NULL, '5fd3b5dbb713b3.26485340', 'Terverifikasi'),
(19, 17, 2, '2020-12-12', 123123, 'qweqe', '2020-12-02', 'Laki - laki', 'B', 'qwe', 123123123, '5fd3b6a27c6676.12221821', 'Terverifikasi');

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

--
-- Dumping data for table `tb_pendaftaran_online`
--

INSERT INTO `tb_pendaftaran_online` (`id`, `id_user`, `id_jadwal`, `no_antrian_administrasi`, `no_antrian_poli`, `tanggal_periksa`, `kd_pendaftaran`, `jenis_pembiayaan`, `verifikasi_administrasi`) VALUES
(7, 18, 9, 11, 6, '2020-12-07', '5fcd17e3e02227.71325025', 'Umum', 'Terverifikasi'),
(8, 18, 9, 12, 7, '2020-12-07', '5fcd1c130372e1.99900328', 'BPJS', 'Terverifikasi'),
(9, 18, 10, 13, 8, '2020-12-09', '5fcd1c3d5d7998.03969998', 'Umum', 'Terverifikasi'),
(10, 18, 10, 14, 9, '2020-12-09', '5fcd1c6d483e70.33541674', 'Umum', 'Belum Verifikasi'),
(11, 18, 10, 15, 10, '2020-12-09', '5fcd257ff3cee1.86312173', 'BPJS', 'Terverifikasi'),
(12, 18, 12, 1, 1, '2020-12-10', '5fcd278830d4a8.77335672', 'BPJS', 'Belum Verifikasi'),
(13, 18, 10, 16, 11, '2020-12-09', '5fcf0861e37057.23771981', 'Umum', 'Belum Verifikasi'),
(14, 18, 12, 2, 2, '2020-12-10', '5fd0f3e2966716.88332955', 'Umum', 'Belum Verifikasi'),
(15, 18, 13, 1, 1, '2020-12-11', '5fd22b2c4015f3.71507156', 'BPJS', 'Belum Verifikasi'),
(16, 18, 18, 2, 1, '2020-12-11', '5fd22b4589f220.04567966', 'BPJS', 'Terverifikasi'),
(17, 18, 13, 3, 2, '2020-12-11', '5fd22b5e58e542.71500139', 'Umum', 'Belum Verifikasi');

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

--
-- Dumping data for table `tb_saran_masukan`
--

INSERT INTO `tb_saran_masukan` (`id`, `subject`, `pesan`, `waktu_submit`) VALUES
(1, 'Test form', 'testing', 1607616682),
(2, 'test 255', 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Aliquam perspiciatis nisi officia laboriosam animi, ullam a dicta accusamus, tenetur voluptate impedit vel minus facilis nesciunt cumque! Minus aperiam, laboriosam placeat quas dolores possimus aut', 1607617473),
(3, 'test 2', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates, quas non enim repellendus suscipit nesciunt maxime! Id velit rem veritatis debitis reprehenderit fuga, dignissimos corporis ipsam sit laborum recusandae nihil, perferendis eius quidem ac', 1607617507),
(4, 'test', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptates, quas non enim repellendus suscipit nesciunt maxime! Id velit rem veritatis debitis reprehenderit fuga, dignissimos corporis ipsam sit laborum recusandae nihil, perferendis eius quidem accusantium amet cum fugit deserunt incidunt quae? Eos aperiam doloremque porro. Maiores neque assumenda iusto maxime adipisci modi commodi, tempore, quos dolor voluptatibus reprehenderit magni quisquam quo delectus qui quam. Ab consequuntur autem saepe, numquam distinctio molestias fugit iste pariatur quidem ipsa dolores ex quisquam in voluptas officia ipsam, officiis nisi rerum adipisci facilis libero maiores necessitatibus. Quaerat non cumque impedit consequuntur maiores accusamus nemo nihil quia necessitatibus iste! Temporibus maxime amet laborum iste fugiat excepturi exercitationem voluptatibus! Sit aliquam veritatis ea ipsa quaerat enim aut fugiat consequuntur dolorem deleniti repellat reiciendis, praesentium illo assumenda? Cupiditate ea vitae eum deleniti, sapiente repudiandae in nam quo repellat nemo harum eius vero ipsam ratione placeat nesciunt dolore pariatur fuga unde nisi! Id hic, aspernatur beatae est consequuntur atque a similique, harum libero voluptates unde veritatis cumque iusto vel quae eaque doloribus blanditiis ex reprehenderit? Ipsa cumque minus et sunt, quaerat perspiciatis delectus voluptates odio quia iusto, sequi eaque est explicabo ullam quas officia excepturi eligendi necessitatibus vel a, veniam repellendus! Ullam repellendus quia quas id consequuntur voluptatibus adipisci sed, repellat possimus, vel illum, a aperiam minima? Maxime facilis porro corporis expedita. Fugit, asperiores. Officia rerum inventore, reprehenderit placeat deleniti facilis nulla repellendus cumque repellat eius ipsum culpa est obcaecati molestiae similique recusandae omnis? Praesentium, minima repellendus ex modi beatae nemo blanditiis perspiciatis possimus mollitia quidem. Hic at soluta non dignissimos nam veritatis officiis quos dolorem qui commodi. Facilis, recusandae molestias dolores eum obcaecati sunt asperiores sit impedit tempore, quam nemo aliquid non. Praesentium recusandae, rerum labore deserunt unde non ipsum ad voluptatibus sunt suscipit repellat vero tenetur illum esse, repudiandae eaque dicta nobis, modi ullam expedita nulla totam exercitationem vel? Quia labore rerum libero maiores aut consequuntur repellendus odit voluptate distinctio rem, voluptates eligendi, debitis minus similique quod adipisci cupiditate delectus dolore nemo a accusantium hic. Beatae eveniet provident sit voluptas debitis molestiae iusto voluptatibus dolores ratione deleniti recusandae rerum excepturi modi magni sunt animi aliquid itaque quibusdam omnis possimus, qui necessitatibus cum ad minus? Provident, culpa accusantium? Dolore laboriosam illum voluptatum beatae quia. Sapiente, fugiat exercitationem ut mollitia error rerum amet ratione sit dolore similique inventore. Amet tenetur, obcaecati ducimus nulla laudantium debitis delectus, maiores cumque, eaque inventore non eligendi! Perspiciatis in repudiandae veritatis, quas temporibus pariatur voluptates? Fugit enim fuga, soluta magni dicta ex eos optio consequuntur pariatur obcaecati suscipit in, veritatis architecto nesciunt non esse, praesentium beatae doloribus dolorem minus? Architecto soluta, assumenda vel sunt fugit facilis tempora nisi rerum cupiditate praesentium accusantium voluptatum eligendi voluptatem aliquid nihil distinctio, illo nulla iure iusto labore pariatur. Sit tenetur natus ullam quasi mollitia veniam illum maiores, laudantium adipisci debitis sunt? Deleniti eos dolores quos non, incidunt dicta. Dolorum explicabo ipsa non velit excepturi, cumque hic corrupti et dolor quo recusandae harum, sequi numquam quaerat at obcaecati ut facere!', 1607617541),
(5, 'test 3', 'cek', 1607655749);

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
(7, 'Gigi', 4, 10, 'Aktif'),
(9, 'Anak', 5, 5, 'Aktif'),
(10, 'Umum', 20, 25, 'Aktif'),
(11, 'THT', 22, 5, 'Aktif');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `tb_biodata_user`
--
ALTER TABLE `tb_biodata_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `tb_counter`
--
ALTER TABLE `tb_counter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_loket_administrasi`
--
ALTER TABLE `tb_loket_administrasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tb_pendaftaran_offline`
--
ALTER TABLE `tb_pendaftaran_offline`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tb_pendaftaran_online`
--
ALTER TABLE `tb_pendaftaran_online`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_saran_masukan`
--
ALTER TABLE `tb_saran_masukan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_unit`
--
ALTER TABLE `tb_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
