-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Jun 2025 pada 08.25
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sayurin`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `komentar`
--

CREATE TABLE `komentar` (
  `id_komentar` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `komentar` text NOT NULL,
  `rating` int(11) NOT NULL,
  `tanggal` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `komentar`
--

INSERT INTO `komentar` (`id_komentar`, `id_user`, `id_produk`, `komentar`, `rating`, `tanggal`) VALUES
(1, 2, 18, 'Murah dan fresh, mantapp', 5, '2025-05-21 22:06:42'),
(2, 2, 23, 'ada yang asem buahnya, overall enak', 4, '2025-05-21 22:07:15'),
(3, 2, 20, 'fresh dan lebih murah dari yang saya beli di supermarket', 5, '2025-05-21 22:10:30'),
(4, 3, 18, 'saya membuatnya menjadi kol goreng, rasanya enak. bagus sekali', 5, '2025-05-21 22:13:06'),
(5, 3, 23, 'enak, segar, asam dan manis cocok untuk dijadikan minuman strawberry', 5, '2025-05-21 22:14:13'),
(6, 4, 17, 'saya membuatnya jadi tumis telur dan pare, enak dan fresh saaat datang. Packagingnya aman, mantap', 5, '2025-05-21 22:16:48'),
(7, 4, 23, 'saya sebenernya tidak terlalu suka strawberry, namun strawberry di sini enakk', 4, '2025-05-21 22:17:53'),
(8, 5, 23, 'LETSS GOOO!!!', 5, '2025-05-22 21:30:22'),
(9, 5, 27, 'MANTAPP BUNGG!!!!!', 5, '2025-05-22 21:52:05'),
(10, 2, 23, 'buahnya segar', 3, '2025-05-23 10:05:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(50) NOT NULL,
  `harga_produk` varchar(50) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `kategori` varchar(50) NOT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga_produk`, `foto`, `kategori`, `stok`) VALUES
(17, 'Pare', '8000', '682db20c29f74-pare.jpg', 'sayur', 96),
(18, 'Sayur Kol', '6000', '682db2340c25e-kol.jpg', 'sayur', 100),
(19, 'Wortel', '9500', '682db24767f75-wortel.jpg', 'sayur', 100),
(20, 'Brokoli', '25000', '682db2523c5f6-brokoli.jpg', 'sayur', 100),
(21, 'Apel', '19000', '682db26a7ac4f-apel.jpg', 'buah', 100),
(22, 'Jeruk', '8500', '682db275b43fc-jeruk.jpg', 'buah', 100),
(23, 'Strawberry', '15000', '682db2b52525e-strawberry.jpg', 'buah', 100),
(25, 'Bundle Buah Small', '60000', '682f294815e32-bundle1.jpg', 'bundle', 50),
(26, 'Bundle Buah Medium', '75000', '682f298ea8e94-bundle2.jpg', 'bundle', 50),
(27, 'Bundle Sayur Small', '13000', '682f29c2bfcf7-bundle3.jpg', 'bundle', 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_user` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `metode` varchar(20) NOT NULL,
  `jumlah_pembelian` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_user`, `id_produk`, `tanggal`, `metode`, `jumlah_pembelian`) VALUES
(2, 18, '2025-05-21 22:05:20', 'OVO', 1),
(2, 18, '2025-05-21 22:05:32', 'DANA', 1),
(2, 23, '2025-05-21 22:06:04', 'DANA', 1),
(2, 20, '2025-05-21 22:06:12', 'QRIS', 1),
(3, 18, '2025-05-21 22:11:49', 'QRIS', 1),
(3, 21, '2025-05-21 22:12:04', 'QRIS', 1),
(3, 20, '2025-05-21 22:12:17', 'DANA', 1),
(3, 23, '2025-05-21 22:13:19', 'DANA', 1),
(4, 23, '2025-05-21 22:14:48', 'QRIS', 1),
(4, 22, '2025-05-21 22:14:58', 'QRIS', 1),
(4, 17, '2025-05-21 22:15:06', 'DANA', 1),
(3, 21, '2025-05-21 23:51:44', 'DANA', 1),
(5, 23, '2025-05-22 21:30:03', 'DANA', 1),
(5, 27, '2025-05-22 21:43:43', 'DANA', 2),
(2, 23, '2025-05-23 10:02:53', 'DANA', 1),
(2, 17, '2025-06-25 14:18:11', 'OVO', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama`, `email`, `username`, `password`, `profile`) VALUES
(1, 'admin', 'adminsayurin@gmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', NULL),
(2, 'Farid Nanda Syauqi', 'faridnanda26@gmail.com', 'Farid', '202cb962ac59075b964b07152d234b70', '682fd78e239c7-farid.jpg'),
(3, 'Cindy Natasya Aulia Putri', 'cindynatasya88@gmail.com', 'Cindy', '8016e420a7541a05a43c9b2e07167c55', '682c417e1d1be-fotoProfile.jpg'),
(4, 'Raffi Fatthoni', 'raffifatthoni493@gmail.com', 'Spica', '97d0ac566dcc40023a01934dccba99e8', '682f264d100ad-raffi.jpg'),
(5, 'Naufal Ihsanul Islam', 'naufal@gmail.com', 'Nopalll', '029afa8b516152fa34f1b2fbe50f1eab', '682f2c5277b5e-nopal.jpg'),
(6, 'dael zikri', 'dael@gmail.com', 'dael44', '202cb962ac59075b964b07152d234b70', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD PRIMARY KEY (`id_komentar`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `komentar`
--
ALTER TABLE `komentar`
  MODIFY `id_komentar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `komentar_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `komentar_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
