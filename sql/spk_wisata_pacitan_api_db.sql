-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Jan 2021 pada 16.56
-- Versi server: 10.4.14-MariaDB
-- Versi PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spk_wisata_pacitan_api_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` text DEFAULT NULL,
  `username` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`) VALUES
(3, 'rovik admin', 'rovik', '123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pariwisata`
--

CREATE TABLE `data_pariwisata` (
  `id` int(11) NOT NULL,
  `kategori_id` int(11) NOT NULL,
  `nama` text DEFAULT NULL,
  `lokasi` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_pariwisata`
--

INSERT INTO `data_pariwisata` (`id`, `kategori_id`, `nama`, `lokasi`, `deskripsi`) VALUES
(2, 3, 'Grojjokan Dhuwur', 'di pacitan', 'Ini salah satu wisata di pacitan'),
(4, 4, 'Goa Gong', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(5, 4, 'Gua Putri', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(6, 4, 'Gua Tabuhan', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(7, 3, 'Hutan Pinus Gemaharjo', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(8, 3, 'Monumen Jendral Sudirman', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(9, 2, 'Pantai Bnyu Tibo', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(10, 2, 'Pantai Buyutan', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(11, 2, 'Pantai Karang Bolong', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(12, 2, 'Pantai Kasap', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(13, 2, 'Pantai Klayar', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(14, 2, 'Pantai Pancer Door', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(15, 2, 'Pantai Pangasan', 'di Pacitan', 'Ini salah satu wisata di pacitan'),
(16, 2, 'Pantai Srau', 'di Pacitan', 'Ini salah satu wisata di pacitan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `data_pariwisata_attribut`
--

CREATE TABLE `data_pariwisata_attribut` (
  `id` int(11) NOT NULL,
  `data_pariwisata_id` int(11) NOT NULL,
  `kriteria_range_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `data_pariwisata_attribut`
--

INSERT INTO `data_pariwisata_attribut` (`id`, `data_pariwisata_id`, `kriteria_range_id`) VALUES
(14, 2, 2),
(15, 2, 8),
(16, 2, 9),
(17, 2, 6),
(18, 4, 12),
(19, 4, 18),
(20, 4, 24),
(21, 4, 9),
(22, 5, 13),
(23, 5, 6),
(24, 5, 24),
(25, 5, 30),
(26, 6, 14),
(27, 6, 19),
(28, 6, 25),
(29, 6, 9),
(30, 7, 15),
(31, 7, 21),
(32, 7, 25),
(33, 7, 31),
(34, 8, 15),
(35, 8, 21),
(36, 8, 26),
(38, 8, 30),
(39, 9, 2),
(40, 9, 22),
(41, 9, 27),
(42, 9, 30),
(43, 10, 16),
(44, 10, 23),
(45, 10, 28),
(46, 10, 30),
(47, 11, 2),
(48, 11, 36),
(49, 11, 8),
(50, 11, 32),
(51, 12, 16),
(52, 12, 19),
(53, 12, 26),
(54, 12, 30),
(55, 13, 12),
(56, 13, 18),
(58, 13, 8),
(59, 13, 33),
(60, 14, 17),
(61, 14, 19),
(62, 14, 28),
(63, 14, 34),
(64, 15, 2),
(65, 15, 6),
(66, 15, 29),
(67, 15, 35),
(68, 16, 2),
(70, 16, 26),
(71, 16, 21),
(72, 16, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `url_gambar` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `deskripsi`, `url_gambar`) VALUES
(2, 'Pantai', 'wisata pantai', '/img/category_pantai.png'),
(3, 'Rekreasi', 'wisata rekreasi', '/img/category_rekreasi.png'),
(4, 'Goa', 'wisata goa', '	\r\n/img/category_goa.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `nama` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai` float DEFAULT NULL,
  `attribut` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kriteria`
--

INSERT INTO `kriteria` (`id`, `nama`, `deskripsi`, `nilai`, `attribut`) VALUES
(2, 'Tiket Masuk', 'Tiket Masuk', 4.4, 'COST'),
(3, 'Jarak', 'Jarak tempat wisata', 3.5, 'COST'),
(4, 'Umur', 'umur untuk masuk tempat wisata', 2.1, 'BENEFIT'),
(5, 'Fasilitas', 'Fasilitas tempat wisata', 3.9, 'BENEFIT');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria_range`
--

CREATE TABLE `kriteria_range` (
  `id` int(11) NOT NULL,
  `kriteria_id` int(11) NOT NULL,
  `nama` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `nilai` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `kriteria_range`
--

INSERT INTO `kriteria_range` (`id`, `kriteria_id`, `nama`, `deskripsi`, `nilai`) VALUES
(2, 2, 'Tiket Masuk : 1,9', 'Fasilitas Tempat Parkir tempat wisata', 1.9),
(6, 5, 'Fasilitas : 1,8', 'harga tiket tempat swisata', 1.8),
(8, 3, 'Jarak : 1,6', 'jarak tempat swisata', 1.6),
(9, 4, 'Umur : 2,4', 'umur untuk masuk tempat swisata', 2.4),
(12, 2, 'Tiket Masuk 2.5', 'Tiket Masuk', 2.5),
(13, 2, 'Tiket Masuk :1.7', 'Tiket Masuk', 1.7),
(14, 2, 'Tiket Masuk :2.1', 'Tiket Masuk', 2.1),
(15, 2, 'Tiket Masuk : 2.0', 'Tiket Masuk', 2),
(16, 2, 'Tiket Masuk : 2.3', 'Tiket Masuk', 2.3),
(17, 2, 'Tiket Masuk : 1.8', 'Tiket Masuk', 1.8),
(18, 5, 'Fasilitas ; 2.0', 'Fasilitas', 2),
(19, 5, 'Fasilitas ; 1.4', 'Fasilitas ', 1.4),
(20, 5, 'Fasilitas ; 2.3', 'Fasilitas ', 2.3),
(21, 5, 'Fasilitas ; 2.2', 'Fasilitas', 2.2),
(22, 5, 'Fasilitas ; 1.7', 'Fasilitas', 1.7),
(23, 5, 'Fasilitas ; 2.4', 'Fasilitas ', 2.4),
(24, 3, 'jarak : 1.8', 'jarak', 1.8),
(25, 3, 'jarak : 1.9', 'jarak', 1.9),
(26, 3, 'jarak : 1.7', 'jarak', 1.7),
(27, 3, 'jarak : 1.3', 'jarak', 1.3),
(28, 3, 'jarak : 2.2', 'jarak', 2.2),
(29, 3, 'jarak : 2.0', 'jarak', 2),
(30, 4, 'Umur : 2.0', 'Umur', 2),
(31, 4, 'Umur :  2.3', 'Umur ', 2.3),
(32, 4, 'Umur :  1.9', 'Umur', 1.9),
(33, 4, 'Umur :  1.6', 'Umur', 1.6),
(34, 4, 'Umur :  2.1', 'Umur', 2.1),
(35, 4, 'Umur :  2.2', 'Umur', 2.2),
(36, 5, 'Fasilitas ; 1.9', 'Fasilitas', 1.9);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `data_pariwisata`
--
ALTER TABLE `data_pariwisata`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indeks untuk tabel `data_pariwisata_attribut`
--
ALTER TABLE `data_pariwisata_attribut`
  ADD PRIMARY KEY (`id`),
  ADD KEY `data_pariwisata_id` (`data_pariwisata_id`),
  ADD KEY `kriteria_range_id` (`kriteria_range_id`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kriteria_range`
--
ALTER TABLE `kriteria_range`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `data_pariwisata`
--
ALTER TABLE `data_pariwisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `data_pariwisata_attribut`
--
ALTER TABLE `data_pariwisata_attribut`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kriteria_range`
--
ALTER TABLE `kriteria_range`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `data_pariwisata`
--
ALTER TABLE `data_pariwisata`
  ADD CONSTRAINT `data_pariwisata_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`);

--
-- Ketidakleluasaan untuk tabel `data_pariwisata_attribut`
--
ALTER TABLE `data_pariwisata_attribut`
  ADD CONSTRAINT `data_pariwisata_attribut_ibfk_1` FOREIGN KEY (`data_pariwisata_id`) REFERENCES `data_pariwisata` (`id`),
  ADD CONSTRAINT `data_pariwisata_attribut_ibfk_2` FOREIGN KEY (`kriteria_range_id`) REFERENCES `kriteria_range` (`id`);

--
-- Ketidakleluasaan untuk tabel `kriteria_range`
--
ALTER TABLE `kriteria_range`
  ADD CONSTRAINT `kriteria_range_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
