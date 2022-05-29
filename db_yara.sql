-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 23, 2022 at 04:34 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_yara`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_keluar`
--

CREATE TABLE `tb_keluar` (
  `idkeluar` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `penerima` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_keluar`
--

INSERT INTO `tb_keluar` (`idkeluar`, `idbarang`, `tanggal`, `penerima`, `qty`) VALUES
(1, 1, '2022-05-11 07:24:21', 'samsu', 40),
(2, 3, '2022-05-11 07:24:55', 'maskun', 101),
(3, 1, '2022-05-11 08:04:35', 'maskunno', 9000),
(4, 19, '2022-05-13 10:18:53', 'yanto', 100),
(5, 19, '2022-05-13 10:19:21', 'kasman', 900),
(6, 21, '2022-05-13 11:35:45', 'yong', 800),
(7, 22, '2022-05-13 11:38:51', '', 6000),
(11, 20, '2022-05-14 15:57:28', 'pembeli', 500),
(12, 20, '2022-05-14 16:01:12', 'pe', 10),
(13, 20, '2022-05-14 16:10:50', 'pembeli', 90),
(14, 20, '2022-05-14 17:46:11', 'samsu', 90),
(15, 23, '2022-05-16 15:23:56', 'pembeli', 180),
(16, 24, '2022-05-16 15:24:26', 'pembeli', 590),
(17, 26, '2022-05-17 04:47:57', 'yana', 600),
(18, 34, '2022-05-18 03:58:10', 'pembeli', 100),
(19, 32, '2022-05-20 03:23:51', 'pembeli', 100),
(21, 32, '2022-05-21 15:45:29', 'pembeli', 10),
(22, 32, '2022-05-21 15:45:46', 'pembeli', 90);

-- --------------------------------------------------------

--
-- Table structure for table `tb_login`
--

CREATE TABLE `tb_login` (
  `iduser` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_login`
--

INSERT INTO `tb_login` (`iduser`, `email`, `password`) VALUES
(1, 'yaracookies@gmail.com', '123'),
(4, 'yaracookies@yara.com', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_masuk`
--

CREATE TABLE `tb_masuk` (
  `idmasuk` int(11) NOT NULL,
  `idbarang` int(11) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `keterangan` varchar(25) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_masuk`
--

INSERT INTO `tb_masuk` (`idmasuk`, `idbarang`, `tanggal`, `keterangan`, `qty`) VALUES
(4, 3, '2022-05-11 06:48:18', 'samsu', 200),
(14, 4, '2022-05-12 17:58:14', 'yara', 1000),
(15, 5, '2022-05-12 18:00:12', 'ya', 2),
(16, 6, '2022-05-12 18:01:34', 'debi', 200),
(17, 7, '2022-05-12 18:03:04', 'yara', 100),
(18, 8, '2022-05-13 09:25:12', 'y', 1),
(19, 9, '2022-05-13 09:26:55', 'yong', 500),
(20, 10, '2022-05-13 09:28:43', 'yara', 20),
(21, 11, '2022-05-13 09:31:39', 'yong', 50),
(22, 12, '2022-05-13 09:34:03', 'yara', 500),
(23, 13, '2022-05-13 09:35:54', 'yara', 400),
(24, 13, '2022-05-13 09:48:08', 'yara', 400),
(25, 15, '2022-05-13 09:49:21', 'yara', 200),
(26, 16, '2022-05-13 09:51:23', 'y', 300),
(27, 17, '2022-05-13 09:57:11', 'yara', 50),
(28, 18, '2022-05-13 10:03:45', 'y', 200),
(29, 19, '2022-05-13 10:06:53', 'yara', 90),
(31, 24, '2022-05-13 11:59:08', 'yong', 90),
(34, 20, '2022-05-14 16:10:35', 'yara', 100),
(35, 26, '2022-05-17 04:47:37', 'ujang', 91),
(36, 34, '2022-05-18 03:57:47', 'yara', 100),
(37, 36, '2022-05-19 09:00:40', 'yara', 100),
(38, 32, '2022-05-19 09:04:37', 'yara', 90),
(39, 32, '2022-05-19 09:07:00', 'yara', 100);

-- --------------------------------------------------------

--
-- Table structure for table `tb_stock`
--

CREATE TABLE `tb_stock` (
  `idbarang` int(11) NOT NULL,
  `namabarang` varchar(25) NOT NULL,
  `deskripsi` varchar(25) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(99) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_stock`
--

INSERT INTO `tb_stock` (`idbarang`, `namabarang`, `deskripsi`, `stock`, `image`) VALUES
(32, 'Brownies', 'Makanan', 0, '48412da82cd2dfe113fe9b990ec5f684.jpg'),
(36, 'cookies', 'Makanan', 190, '482526e29ee1227f762c999f56bcf192.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_keluar`
--
ALTER TABLE `tb_keluar`
  ADD PRIMARY KEY (`idkeluar`);

--
-- Indexes for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`iduser`);

--
-- Indexes for table `tb_masuk`
--
ALTER TABLE `tb_masuk`
  ADD PRIMARY KEY (`idmasuk`);

--
-- Indexes for table `tb_stock`
--
ALTER TABLE `tb_stock`
  ADD PRIMARY KEY (`idbarang`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_keluar`
--
ALTER TABLE `tb_keluar`
  MODIFY `idkeluar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tb_login`
--
ALTER TABLE `tb_login`
  MODIFY `iduser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_masuk`
--
ALTER TABLE `tb_masuk`
  MODIFY `idmasuk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tb_stock`
--
ALTER TABLE `tb_stock`
  MODIFY `idbarang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
