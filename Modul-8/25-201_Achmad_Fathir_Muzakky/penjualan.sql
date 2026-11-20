
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `penjualan` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `penjualan`;

DROP TABLE IF EXISTS `transaksi_detail`;
DROP TABLE IF EXISTS `transaksi`;
DROP TABLE IF EXISTS `barang`;
DROP TABLE IF EXISTS `pelanggan`;
DROP TABLE IF EXISTS `supplier`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `telp` varchar(12) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `pelanggan` (
  `id` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `telp` varchar(12) NOT NULL,
  `alamat` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `barang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode_barang` varchar(10) NOT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  PRIMARY KEY (`id`,`kode_barang`),
  KEY `supplier_id` (`supplier_id`),
  CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `waktu_transaksi` date NOT NULL,
  `keterangan` text NOT NULL,
  `total` int(11) NOT NULL,
  `pelanggan_id` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `pelanggan_id` (`pelanggan_id`),
  CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `transaksi_detail` (
  `transaksi_id` int(11) NOT NULL,
  `barang_id` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  KEY `barang_id` (`barang_id`),
  KEY `transaksi_id` (`transaksi_id`),
  CONSTRAINT `transaksi_detail_ibfk_1` FOREIGN KEY (`barang_id`) REFERENCES `barang` (`id`),
  CONSTRAINT `transaksi_detail_ibfk_2` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksi` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `users` (
  `id_user` tinyint(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL,
  `password` varchar(35) NOT NULL,
  `level` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Sumber Makmur', '08123456701', 'Jl. Rungkut No. 10 Surabaya'),
(2, 'CV Tani Jaya', '08123456702', 'Jl. Diponegoro No. 25 Surabaya'),
(3, 'PT Indo Pangan', '08123456703', 'Jl. Ahmad Yani No. 8 Sidoarjo'),
(4, 'UD Berkah Abadi', '08123456704', 'Jl. Raya Gresik No. 15 Gresik'),
(5, 'PT Bersih Sejahtera', '08123456705', 'Jl. Pemuda No. 30 Surabaya');

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `telp`, `alamat`) VALUES
('PLG001', 'Budi Santoso', 'L', '08111111101', 'Jl. Kenjeran No. 1 Surabaya'),
('PLG002', 'Siti Aminah', 'P', '08111111102', 'Jl. Darmo No. 2 Surabaya'),
('PLG003', 'Agus Wijaya', 'L', '08111111103', 'Jl. Gubeng No. 3 Surabaya'),
('PLG004', 'Dewi Lestari', 'P', '08111111104', 'Jl. Manyar No. 4 Surabaya'),
('PLG005', 'Rudi Hartono', 'L', '08111111105', 'Jl. Wonokromo No. 5 Surabaya');

INSERT INTO `barang` (`id`, `kode_barang`, `nama_barang`, `harga`, `stok`, `supplier_id`) VALUES
(1, 'BRG001', 'Mouse Wireless', 85000, 50, 1),
(2, 'BRG002', 'Keyboard Mekanik', 350000, 30, 1),
(3, 'BRG003', 'Flashdisk 32 GB', 55000, 100, 2),
(4, 'BRG004', 'Headset Gaming', 275000, 25, 2),
(5, 'BRG005', 'Kabel USB Type C', 25000, 200, 3),
(6, 'BRG006', 'Charger 20 Watt', 75000, 80, 3),
(7, 'BRG007', 'Webcam Full HD', 320000, 20, 4),
(8, 'BRG008', 'Power Bank 10000 mAh', 180000, 40, 5);

INSERT INTO `transaksi` (`id`, `waktu_transaksi`, `keterangan`, `total`, `pelanggan_id`) VALUES
(1, '2026-10-01', 'Belanja bulanan', 195000, 'PLG001'),
(2, '2026-10-02', 'Belanja harian', 600000, 'PLG002'),
(3, '2026-10-03', 'Belanja harian', 1565000, 'PLG003'),
(4, '2026-10-05', 'Belanja harian', 235000, 'PLG004'),
(5, '2026-10-07', 'Belanja bulanan', 870000, 'PLG005'),
(6, '2026-10-09', 'Stok warung', 1250000, 'PLG001'),
(7, '2026-10-12', 'Belanja harian', 1320000, 'PLG002'),
(8, '2026-10-15', 'Belanja harian', 440000, 'PLG003'),
(9, '2026-10-18', 'Belanja mingguan', 510000, 'PLG004'),
(10, '2026-10-20', 'Belanja mingguan', 805000, 'PLG005');

INSERT INTO `transaksi_detail` (`transaksi_id`, `barang_id`, `harga`, `qty`) VALUES
(1, 1, 85000, 1),
(1, 3, 55000, 2),
(2, 2, 350000, 1),
(2, 5, 25000, 10),
(3, 4, 275000, 2),
(3, 6, 75000, 5),
(3, 7, 320000, 2),
(4, 8, 180000, 1),
(4, 3, 55000, 1),
(5, 1, 85000, 2),
(5, 2, 350000, 2),
(6, 5, 25000, 20),
(6, 6, 75000, 10),
(7, 7, 320000, 3),
(7, 8, 180000, 2),
(8, 4, 275000, 1),
(8, 3, 55000, 3),
(9, 1, 85000, 1),
(9, 6, 75000, 4),
(9, 5, 25000, 5),
(10, 2, 350000, 1),
(10, 4, 275000, 1),
(10, 8, 180000, 1);

INSERT INTO `users` (`id_user`, `username`, `password`, `level`) VALUES
(1, 'budi', '00dfc53ee86af02e742515cdcf075ed3', 1),
(2, 'wati', 'a92db7089e286f23cf575b0ddf35bc35', 2);

SET FOREIGN_KEY_CHECKS = 1;
