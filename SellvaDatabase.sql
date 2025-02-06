-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping data for table sellva.failed_jobs: ~0 rows (approximately)

-- Dumping data for table sellva.keranjangs: ~0 rows (approximately)

-- Dumping data for table sellva.migrations: ~11 rows (approximately)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2019_08_19_000000_create_failed_jobs_table', 1),
	(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(5, '2025_01_10_011534_create_produks_table', 1),
	(6, '2025_01_10_011919_create_keranjangs_table', 1),
	(7, '2025_01_10_015435_create_vouchers_table', 1),
	(8, '2025_01_10_015712_create_transaksis_table', 1),
	(9, '2025_01_10_021358_create_wishlists_table', 1),
	(10, '2025_01_27_075059_create_detail_transaksis_table', 2),
	(11, '2025_01_27_080048_create_detail_keranjangs_table', 3),
	(12, '2025_01_27_081020_create_detail_transaksis_table', 4);

-- Dumping data for table sellva.orders: ~18 rows (approximately)
INSERT INTO `orders` (`id`, `id_user`, `total`, `metode_pembayaran`, `nominal_pembayaran`, `kembalian`, `waktu_order`, `waktu_pembayaran`, `status`, `created_at`, `updated_at`) VALUES
	(5, 1, 64000, 'tunai', 100000, 36000, '2025-02-04 12:10:00', '2025-02-05 07:11:18', 'selesai', '2025-02-03 23:50:26', '2025-02-05 00:11:18'),
	(11, 1, 72000, 'tunai', 100000, 28000, '2025-02-05 07:08:16', '2025-02-05 07:08:57', 'selesai', '2025-02-05 00:08:16', '2025-02-05 00:08:57'),
	(12, 1, 18000, 'tunai', 20000, 2000, '2025-02-05 07:11:42', '2025-02-05 07:11:56', 'selesai', '2025-02-05 00:11:42', '2025-02-05 00:11:56'),
	(13, 1, 84000, 'tunai', 100000, 16000, '2025-02-05 07:14:16', '2025-02-05 07:17:59', 'selesai', '2025-02-05 00:14:16', '2025-02-05 00:17:59'),
	(14, 1, 36000, 'debit', 50000, 14000, '2025-02-05 07:18:15', '2025-02-05 07:18:44', 'selesai', '2025-02-05 00:18:15', '2025-02-05 00:18:44'),
	(15, 1, 27000, NULL, NULL, NULL, '2025-02-05 07:23:54', NULL, 'proses', '2025-02-05 00:23:54', '2025-02-05 00:23:54'),
	(16, 1, 109000, NULL, NULL, NULL, '2025-02-05 23:58:17', NULL, 'proses', '2025-02-05 16:58:17', '2025-02-05 16:58:17'),
	(17, 1, 45000, NULL, NULL, NULL, '2025-02-06 00:00:04', NULL, 'proses', '2025-02-05 17:00:04', '2025-02-05 17:00:04'),
	(18, 1, 36000, NULL, NULL, NULL, '2025-02-06 00:02:11', NULL, 'proses', '2025-02-05 17:02:11', '2025-02-05 17:02:11'),
	(19, 1, 45000, NULL, NULL, NULL, '2025-02-06 00:07:07', NULL, 'proses', '2025-02-05 17:07:07', '2025-02-05 17:07:07'),
	(20, 1, 25000, NULL, NULL, NULL, '2025-02-06 00:08:30', NULL, 'proses', '2025-02-05 17:08:30', '2025-02-05 17:08:30'),
	(21, 1, 45000, NULL, NULL, NULL, '2025-02-06 00:14:23', NULL, 'proses', '2025-02-05 17:14:23', '2025-02-05 17:14:23'),
	(22, 1, 27000, NULL, NULL, NULL, '2025-02-06 00:16:47', NULL, 'proses', '2025-02-05 17:16:47', '2025-02-05 17:16:47'),
	(23, 1, 36000, NULL, NULL, NULL, '2025-02-06 00:17:48', NULL, 'proses', '2025-02-05 17:17:48', '2025-02-05 17:17:48'),
	(24, 1, 56000, NULL, NULL, NULL, '2025-02-06 00:20:34', NULL, 'proses', '2025-02-05 17:20:34', '2025-02-05 17:20:34'),
	(25, 1, 15000, NULL, NULL, NULL, '2025-02-06 00:23:03', NULL, 'proses', '2025-02-05 17:23:03', '2025-02-05 17:23:03'),
	(26, 1, 55000, NULL, NULL, NULL, '2025-02-06 00:23:55', NULL, 'proses', '2025-02-05 17:23:55', '2025-02-05 17:23:55'),
	(27, 1, 55000, NULL, NULL, NULL, '2025-02-06 00:24:27', NULL, 'proses', '2025-02-05 17:24:27', '2025-02-05 17:24:27');

-- Dumping data for table sellva.order_details: ~27 rows (approximately)
INSERT INTO `order_details` (`id`, `id_order`, `id_produk`, `quantity`, `harga`, `subtotal`, `total`, `created_at`, `updated_at`) VALUES
	(7, 5, 2, 3, 9000, 27000, 27000, '2025-02-03 23:50:26', '2025-02-03 23:50:26'),
	(8, 5, 3, 3, 5000, 15000, 15000, '2025-02-03 23:50:26', '2025-02-03 23:50:26'),
	(9, 5, 4, 2, 11000, 22000, 22000, '2025-02-03 23:50:26', '2025-02-03 23:50:26'),
	(21, 11, 2, 2, 9000, 18000, 18000, '2025-02-05 00:08:16', '2025-02-05 00:08:16'),
	(22, 11, 3, 2, 5000, 10000, 10000, '2025-02-05 00:08:16', '2025-02-05 00:08:16'),
	(23, 11, 4, 4, 11000, 44000, 44000, '2025-02-05 00:08:16', '2025-02-05 00:08:16'),
	(24, 12, 2, 2, 9000, 18000, 18000, '2025-02-05 00:11:42', '2025-02-05 00:11:42'),
	(25, 13, 2, 4, 9000, 36000, 36000, '2025-02-05 00:14:16', '2025-02-05 00:14:16'),
	(26, 13, 3, 3, 5000, 15000, 15000, '2025-02-05 00:14:16', '2025-02-05 00:14:16'),
	(27, 13, 4, 3, 11000, 33000, 33000, '2025-02-05 00:14:16', '2025-02-05 00:14:16'),
	(28, 14, 2, 4, 9000, 36000, 36000, '2025-02-05 00:18:15', '2025-02-05 00:18:15'),
	(29, 15, 2, 3, 9000, 27000, 27000, '2025-02-05 00:23:54', '2025-02-05 00:23:54'),
	(30, 16, 3, 5, 5000, 25000, 25000, '2025-02-05 16:58:17', '2025-02-05 16:58:17'),
	(31, 16, 4, 6, 11000, 66000, 66000, '2025-02-05 16:58:17', '2025-02-05 16:58:17'),
	(32, 16, 2, 2, 9000, 18000, 18000, '2025-02-05 16:58:17', '2025-02-05 16:58:17'),
	(33, 17, 2, 5, 9000, 45000, 45000, '2025-02-05 17:00:04', '2025-02-05 17:00:04'),
	(34, 18, 2, 4, 9000, 36000, 36000, '2025-02-05 17:02:11', '2025-02-05 17:02:11'),
	(35, 19, 2, 5, 9000, 45000, 45000, '2025-02-05 17:07:07', '2025-02-05 17:07:07'),
	(36, 20, 3, 5, 5000, 25000, 25000, '2025-02-05 17:08:30', '2025-02-05 17:08:30'),
	(37, 21, 2, 5, 9000, 45000, 45000, '2025-02-05 17:14:23', '2025-02-05 17:14:23'),
	(38, 22, 2, 3, 9000, 27000, 27000, '2025-02-05 17:16:47', '2025-02-05 17:16:47'),
	(39, 23, 2, 4, 9000, 36000, 36000, '2025-02-05 17:17:48', '2025-02-05 17:17:48'),
	(40, 24, 2, 4, 9000, 36000, 36000, '2025-02-05 17:20:34', '2025-02-05 17:20:34'),
	(41, 24, 3, 4, 5000, 20000, 20000, '2025-02-05 17:20:34', '2025-02-05 17:20:34'),
	(42, 25, 3, 3, 5000, 15000, 15000, '2025-02-05 17:23:03', '2025-02-05 17:23:03'),
	(43, 26, 4, 5, 11000, 55000, 55000, '2025-02-05 17:23:55', '2025-02-05 17:23:55'),
	(44, 27, 4, 5, 11000, 55000, 55000, '2025-02-05 17:24:27', '2025-02-05 17:24:27');

-- Dumping data for table sellva.password_reset_tokens: ~0 rows (approximately)

-- Dumping data for table sellva.personal_access_tokens: ~0 rows (approximately)

-- Dumping data for table sellva.produks: ~3 rows (approximately)
INSERT INTO `produks` (`id`, `nama`, `harga`, `stok`, `gambar`, `tanggal_masuk`, `expire`, `created_at`, `updated_at`) VALUES
	(2, 'Chitato Ayam Bumbu 68g', 9000, 50, 'GambarProduk/1737684378.png', '2025-01-24', '2025-10-04', '2025-01-22 00:29:34', '2025-01-23 19:06:19'),
	(3, 'TEH KOTAK 300ML', 5000, 99, 'GambarProduk/1737531680.jpg', '2025-01-24', '2025-09-24', '2025-01-22 00:41:20', '2025-01-22 00:41:20'),
	(4, 'Sariwangi Teh Hijau Celup 1.85 g x 25 Pcs', 11000, 99, 'GambarProduk/1737686375.png', '2025-02-25', '2025-11-29', '2025-01-23 19:39:35', '2025-01-23 19:40:55');

-- Dumping data for table sellva.users: ~0 rows (approximately)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `alamat`, `nomor_telepon`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'pelanggan1', 'pelanggan123@gmail.com', NULL, '$2y$12$cmRHA.2G0DXNmO9Kw25cv.om4BCnRSdJbqpgcPPWYhiVterpTAJV6', 'jalan dhoho', 812345678, 'admin', NULL, '2025-01-31 18:07:33', '2025-01-31 18:07:33');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
