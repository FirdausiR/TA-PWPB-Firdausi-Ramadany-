-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Des 2021 pada 13.23
-- Versi server: 10.1.38-MariaDB
-- Versi PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `idbarang` varchar(5) NOT NULL,
  `nama` varchar(45) DEFAULT NULL,
  `harga` int(3) DEFAULT NULL,
  `diskon` tinyint(3) DEFAULT '0',
  `pajak` tinyint(3) DEFAULT '0',
  `stok` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`idbarang`, `nama`, `harga`, `diskon`, `pajak`, `stok`) VALUES
('4E53G', 'Sepatu Adidas', 2000000, 20, 10, 10),
('A1125', 'Sepatu Nike', 1000000, 20, 10, 5);

--
-- Trigger `barang`
--
DELIMITER $$
CREATE TRIGGER `after_insert_barang` AFTER INSERT ON `barang` FOR EACH ROW INSERT INTO stok SET
stok.idbarang = new.idbarang,
stok.masuk = new.stok,
stok.terjual = 0,
stok.updated_at = CURRENT_DATE
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok`
--

CREATE TABLE `stok` (
  `idstok` int(11) NOT NULL,
  `idbarang` varchar(5) DEFAULT NULL,
  `masuk` tinytext,
  `terjual` tinyint(1) DEFAULT NULL,
  `updated_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `stok`
--

INSERT INTO `stok` (`idstok`, `idbarang`, `masuk`, `terjual`, `updated_at`) VALUES
(13, '4E53G', '10', 0, '2021-12-15'),
(14, 'A1125', '5', 0, '2021-12-15'),
(15, 'A1125', '50', 0, '2021-12-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(65) NOT NULL,
  `password` varchar(200) DEFAULT NULL,
  `nama` varchar(65) DEFAULT NULL,
  `akses` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`username`, `password`, `nama`, `akses`) VALUES
('admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'RAGA MULIA KUSUMA', 1);

-- --------------------------------------------------------

--
-- Stand-in struktur untuk tampilan `v_barang`
-- (Lihat di bawah untuk tampilan aktual)
--
CREATE TABLE `v_barang` (
`idbarang` varchar(5)
,`nama` varchar(45)
,`harga` varchar(50)
,`diskon` varchar(6)
,`pajak` varchar(6)
,`stok` tinyint(1)
,`terjual` tinyint(1)
,`total` tinytext
,`last_modified` date
);

-- --------------------------------------------------------

--
-- Struktur untuk view `v_barang`
--
DROP TABLE IF EXISTS `v_barang`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_barang`  AS  select `barang`.`idbarang` AS `idbarang`,`barang`.`nama` AS `nama`,(select concat('Rp ',format(`barang`.`harga`,0))) AS `harga`,(select concat(`barang`.`diskon`,' %')) AS `diskon`,(select concat(`barang`.`pajak`,' %')) AS `pajak`,`barang`.`stok` AS `stok`,`stok`.`terjual` AS `terjual`,`stok`.`masuk` AS `total`,`stok`.`updated_at` AS `last_modified` from (`stok` join `barang` on((`barang`.`idbarang` = `stok`.`idbarang`))) order by `stok`.`updated_at` ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`idbarang`);

--
-- Indeks untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD PRIMARY KEY (`idstok`),
  ADD KEY `fk_stok_barang_idx` (`idbarang`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `stok`
--
ALTER TABLE `stok`
  MODIFY `idstok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `stok`
--
ALTER TABLE `stok`
  ADD CONSTRAINT `fk_stok_barang` FOREIGN KEY (`idbarang`) REFERENCES `barang` (`idbarang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
