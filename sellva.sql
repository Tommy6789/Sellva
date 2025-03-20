-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 20, 2025 at 03:19 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sellva`
--

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `keranjangs`
--

CREATE TABLE `keranjangs` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_produk` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

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
(12, '2025_01_27_081020_create_detail_transaksis_table', 4),
(13, '2025_02_14_080653_create_profiles_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `total` int NOT NULL DEFAULT '0',
  `metode_pembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nominal_pembayaran` int DEFAULT NULL,
  `kembalian` int DEFAULT NULL,
  `waktu_order` datetime DEFAULT NULL,
  `waktu_pembayaran` datetime DEFAULT NULL,
  `status` enum('proses','selesai') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `id_user`, `total`, `metode_pembayaran`, `nominal_pembayaran`, `kembalian`, `waktu_order`, `waktu_pembayaran`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 20000, 'tunai', 30000, 10000, '2025-03-17 08:13:24', '2025-03-20 07:23:22', 'selesai', '2025-03-17 01:13:24', '2025-03-20 00:23:22'),
(2, 1, 20000, 'tunai', 30000, 10000, '2025-03-17 08:15:02', '2025-03-19 07:49:01', 'selesai', '2025-03-17 01:15:02', '2025-03-19 00:49:01'),
(3, 1, 32000, 'tunai', 50000, 18000, '2025-03-19 08:08:04', '2025-03-19 08:08:29', 'selesai', '2025-03-19 01:08:04', '2025-03-19 01:08:29'),
(4, 1, 86000, 'tunai', 100000, 14000, '2025-03-19 08:11:55', '2025-03-19 08:12:04', 'selesai', '2025-03-19 01:11:55', '2025-03-19 01:12:04'),
(5, 1, 45000, 'tunai', 100000, 55000, '2025-03-19 08:12:18', '2025-03-19 08:12:29', 'selesai', '2025-03-19 01:12:18', '2025-03-19 01:12:29'),
(6, 1, 27000, 'tunai', 50000, 23000, '2025-03-19 09:32:59', '2025-03-19 09:33:43', 'selesai', '2025-03-19 02:32:59', '2025-03-19 02:33:43'),
(7, 1, 18000, 'tunai', 20000, 2000, '2025-03-20 07:22:54', '2025-03-20 07:23:06', 'selesai', '2025-03-20 00:22:54', '2025-03-20 00:23:06'),
(8, 2, 20000, NULL, NULL, NULL, '2025-03-20 08:28:20', NULL, 'proses', '2025-03-20 01:28:20', '2025-03-20 01:28:20'),
(9, 2, 36000, NULL, NULL, NULL, '2025-03-20 09:24:53', NULL, 'proses', '2025-03-20 02:24:53', '2025-03-20 02:24:53'),
(10, 2, 36000, 'tunai', 50000, 14000, '2025-03-20 09:27:39', '2025-03-20 09:27:52', 'selesai', '2025-03-20 02:27:39', '2025-03-20 02:27:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` bigint UNSIGNED NOT NULL,
  `id_order` bigint UNSIGNED NOT NULL,
  `id_produk` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `harga` int DEFAULT NULL,
  `subtotal` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `id_order`, `id_produk`, `quantity`, `harga`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 2, 4, 5000, 20000, '2025-03-17 01:13:24', '2025-03-17 01:13:24'),
(2, 2, 2, 4, 5000, 20000, '2025-03-17 01:15:02', '2025-03-17 01:15:02'),
(3, 3, 3, 4, 8000, 32000, '2025-03-19 01:08:04', '2025-03-19 01:08:04'),
(4, 4, 3, 4, 8000, 32000, '2025-03-19 01:11:55', '2025-03-19 01:11:55'),
(5, 4, 1, 6, 9000, 54000, '2025-03-19 01:11:55', '2025-03-19 01:11:55'),
(6, 5, 1, 5, 9000, 45000, '2025-03-19 01:12:18', '2025-03-19 01:12:18'),
(7, 6, 1, 3, 9000, 27000, '2025-03-19 02:32:59', '2025-03-19 02:32:59'),
(8, 7, 1, 2, 9000, 18000, '2025-03-20 00:22:54', '2025-03-20 00:22:54'),
(9, 8, 2, 4, 5000, 20000, '2025-03-20 01:28:20', '2025-03-20 01:28:20'),
(10, 9, 1, 4, 9000, 36000, '2025-03-20 02:24:53', '2025-03-20 02:24:53'),
(11, 10, 1, 4, 9000, 36000, '2025-03-20 02:27:39', '2025-03-20 02:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produks`
--

CREATE TABLE `produks` (
  `id` bigint UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `harga` int NOT NULL DEFAULT '0',
  `stok` int NOT NULL DEFAULT '0',
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_masuk` date DEFAULT NULL,
  `expire` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produks`
--

INSERT INTO `produks` (`id`, `nama`, `kategori`, `harga`, `stok`, `gambar`, `tanggal_masuk`, `expire`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Chitato Ayam Bumbu 68g', 'Snack', 9000, 95, 'GambarProduk/1737684378.png', '2025-11-05', '2025-11-28', '2025-01-22 00:29:34', '2025-03-20 02:27:52', NULL),
(2, 'TEH KOTAK 300ML', 'Minuman', 5000, 99, 'GambarProduk/1737531680.jpg', '2025-01-24', '2025-09-24', '2025-01-22 00:41:20', '2025-03-20 01:50:19', NULL),
(3, 'Sariwangi Teh Hijau Celup 1.85 g x 25 Pcs', 'Minuman Instan', 8000, 99, 'GambarProduk/1737686375.png', '2025-02-25', '2025-11-29', '2025-01-23 19:39:35', '2025-03-20 01:50:25', NULL),
(4, 'Lifebuoy Matcha Green Tea Aloe Vera Body Wash - 400ml', 'Produk Rumah Tangga', 33000, 99, 'GambarProduk/1740463461.png', '2025-02-25', '2025-05-14', '2025-02-25 06:03:30', '2025-03-20 01:50:30', NULL),
(5, 'Indomie', 'Makanan Instan', 3500, 99, 'GambarProduk/1742348561.png', '2025-03-19', '2026-01-02', '2025-03-19 01:42:41', '2025-03-20 00:57:26', NULL),
(7, 'Iron Cast Pan', 'Peralatan Rumah Tangga', 56000, 99, 'GambarProduk/1742349050.png', '2025-03-19', NULL, '2025-03-20 00:39:42', '2025-03-20 00:37:27', NULL),
(8, 'Kraft', 'Makanan Siap Saji', 35000, 99, 'GambarProduk/1742349153.png', '2025-03-19', '2026-01-01', '2025-03-19 01:52:33', '2025-03-20 03:14:48', NULL),
(9, 'IKEA 365+ piring saji', 'Peralatan Rumah Tangga', 49000, 99, 'GambarProduk/1742431818.png', '2025-03-20', NULL, '2025-03-20 00:50:18', '2025-03-20 00:50:18', NULL),
(10, 'Mangkok Keramik Hitam 19cm, 1set 4pcs', 'Peralatan Rumah Tangga', 375000, 99, 'GambarProduk/1742434436.png', '2025-03-20', NULL, '2025-03-20 01:33:56', '2025-03-20 01:33:56', NULL),
(11, 'Lays cheddar & sour cream 184.2 g', 'Snack', 20000, 99, 'GambarProduk/1742435404.png', '2025-03-20', '2025-12-20', '2025-03-20 01:50:04', '2025-03-20 01:50:04', NULL),
(12, 'Fanta Strawberry 1 liter', 'Minuman', 10500, 99, 'GambarProduk/1742436570.png', '2025-03-20', '2025-12-20', '2025-03-20 02:09:30', '2025-03-20 02:09:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint UNSIGNED NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `nik` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `npwp` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `foto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `id_user`, `nik`, `npwp`, `gender`, `tanggal_lahir`, `foto`, `created_at`, `updated_at`) VALUES
(4, 1, NULL, NULL, NULL, NULL, 'FotoProfile/1742346186.png', '2025-03-19 01:00:45', '2025-03-19 01:03:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `nomor_telepon` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `role` enum('admin','kasir','pelanggan') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pelanggan',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `alamat`, `nomor_telepon`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'david', 'david123@gmail.com', NULL, '$2y$12$0zlaS4.wtqqzgLpCjuvA3uSjq2FJ7VmF7unF3QXBWM.fL.9f.tFDK', 'jalan apel 10', '08123456789', 'admin', NULL, '2025-03-17 00:32:26', '2025-03-20 02:39:21'),
(2, 'lucas', 'lucas123@gmail.com', NULL, '$2y$12$EtPGg5wnviJH26CRg9WSnuFgahYG7PLLEvmWN9.WyeydyX459fu2y', 'jalan jeruk 12', '08123456789', 'admin', NULL, '2025-03-20 00:27:46', '2025-03-20 00:27:46');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `keranjangs_id_user_foreign` (`id_user`),
  ADD KEY `keranjangs_id_produk_foreign` (`id_produk`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `transaksis_id_user_foreign` (`id_user`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `detail_transaksis_id_produk_foreign` (`id_produk`),
  ADD KEY `id_transaksi` (`id_order`) USING BTREE;

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `profiles_id_user_foreign` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keranjangs`
--
ALTER TABLE `keranjangs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD CONSTRAINT `keranjangs_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produks` (`id`),
  ADD CONSTRAINT `keranjangs_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `transaksis_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `detail_transaksis_id_produk_foreign` FOREIGN KEY (`id_produk`) REFERENCES `produks` (`id`),
  ADD CONSTRAINT `id_transaksi` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id`);

--
-- Constraints for table `profiles`
--
ALTER TABLE `profiles`
  ADD CONSTRAINT `profiles_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
