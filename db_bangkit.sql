-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Nov 2025 pada 14.30
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_bangkit`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Makanan Ringan', 'makanan-ringan', '2025-11-16 01:20:11', '2025-11-16 01:20:11'),
(2, 'Fashion', 'fashion', '2025-11-16 19:36:25', '2025-11-16 19:36:25'),
(3, 'Minuman', 'minuman', '2025-11-22 05:20:09', '2025-11-22 05:20:09'),
(4, 'Makanan', 'makanan', '2025-11-22 05:39:35', '2025-11-22 05:39:35');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjangs`
--

CREATE TABLE `keranjangs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `keranjangs`
--

INSERT INTO `keranjangs` (`id`, `user_id`, `produk_id`, `jumlah`, `created_at`, `updated_at`) VALUES
(7, 3, 17, 1, '2025-11-22 06:00:50', '2025-11-22 06:00:50'),
(8, 3, 15, 3, '2025-11-22 06:01:00', '2025-11-22 06:01:00'),
(9, 3, 10, 3, '2025-11-22 06:01:11', '2025-11-22 06:01:11'),
(10, 3, 7, 1, '2025-11-22 06:01:31', '2025-11-22 06:01:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_05_07_131929_create_produks_table', 1),
(5, '2025_05_07_142350_create_transaksis_table', 1),
(6, '2025_05_07_153931_create_reviews_table', 1),
(7, '2025_05_20_145444_add_foto_to_produks_table', 1),
(8, '2025_05_20_154329_create_keranjangs_table', 1),
(9, '2025_05_20_162241_create_transaksi_details_table', 1),
(10, '2025_05_21_172123_add_is_approved_to_users_table', 1),
(11, '2025_06_11_160814_add_alamat_and_ongkir_to_transaksis_table', 1),
(12, '2025_06_19_165831_add_is_approved_to_produks_table', 1),
(13, '2025_06_20_014017_add_all_profile_fields_to_users_table', 1),
(14, '2025_06_30_142107_add_license_fields_to_users_table', 1),
(15, '2025_09_30_023335_create_personal_access_tokens_table', 1),
(16, '2025_10_20_093755_add_status_pembayaran_to_transaksis_table', 1),
(17, '2025_10_21_054746_remove_status_pembayaran_from_transaksis_table', 1),
(18, '2025_10_21_071344_create_sliders_table', 1),
(19, '2025_10_21_074321_make_slider_buttons_nullable', 1),
(20, '2025_10_21_080302_create_product_images_table', 1),
(21, '2025_10_21_081711_create_categories_table', 1),
(22, '2025_10_21_081740_add_category_id_to_produks_table', 1),
(23, '2025_10_29_044303_add_order_id_midtrans_to_transaksis_table', 1),
(24, '2025_10_29_071609_add_nama_umkm_to_produks_table', 1),
(25, '2025_11_13_031233_add_soft_deletes_to_users_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `product_images`
--

CREATE TABLE `product_images` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `product_images`
--

INSERT INTO `product_images` (`id`, `produk_id`, `image_path`, `created_at`, `updated_at`) VALUES
(3, 2, '1763281561_69198a9982a4c_WhatsApp-Image-2025-02-05-at-12.02.51-1024x1024.jpeg.webp', '2025-11-16 01:26:01', '2025-11-16 01:26:01'),
(4, 2, '1763281561_69198a998ad2f_S20d609cf92104593af5aaef64dfcbb187.jpg', '2025-11-16 01:26:01', '2025-11-16 01:26:01'),
(8, 5, '1763347072_691a8a80cf683_blimbing-2.webp', '2025-11-16 19:37:52', '2025-11-16 19:37:52'),
(9, 5, '1763347072_691a8a80dbcdc_4.webp', '2025-11-16 19:37:52', '2025-11-16 19:37:52'),
(10, 5, '1763347072_691a8a80dfe25_3.jpg', '2025-11-16 19:37:52', '2025-11-16 19:37:52'),
(11, 5, '1763347072_691a8a80e52c4_2.webp', '2025-11-16 19:37:52', '2025-11-16 19:37:52'),
(12, 5, '1763347072_691a8a80ea0dc_1.jpg', '2025-11-16 19:37:52', '2025-11-16 19:37:52'),
(13, 2, '1763347206_691a8b06a555e_4.webp', '2025-11-16 19:40:06', '2025-11-16 19:40:06'),
(14, 2, '1763347206_691a8b06c1cdc_3.jpg', '2025-11-16 19:40:06', '2025-11-16 19:40:06'),
(15, 2, '1763347206_691a8b06c4068_2.webp', '2025-11-16 19:40:06', '2025-11-16 19:40:06'),
(16, 2, '1763347206_691a8b06cb385_1.jpg', '2025-11-16 19:40:06', '2025-11-16 19:40:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `produks`
--

CREATE TABLE `produks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `harga` decimal(10,2) NOT NULL,
  `stok` int(11) NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 0,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `nama_umkm` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `produks`
--

INSERT INTO `produks` (`id`, `nama`, `deskripsi`, `foto`, `harga`, `stok`, `is_approved`, `user_id`, `category_id`, `nama_umkm`, `created_at`, `updated_at`) VALUES
(2, 'Coklat Nanas', 'Coklat nanas Asli Subang', '1763281561_fcf06a4f47f8256e86fac5c7b2abee31@resize_ss700x700.jpg', 19999.00, 134, 1, 2, 1, 'Alam Sari', '2025-11-16 01:26:01', '2025-11-16 19:40:27'),
(5, 'produk', 'produk', '1763347072_blimbing-2.webp', 15000.00, 121, 1, 2, 2, 'produk', '2025-11-16 19:37:52', '2025-11-16 19:38:30'),
(6, 'Kopi Robusta Meranti Kopi', '100% Kopi asli', '1763814095_robnus1.png', 35000.00, 31, 1, 1, 3, 'KTH Tangkalna Lestari Abadi', '2025-11-22 05:21:36', '2025-11-22 05:24:47'),
(7, 'Kopi Arabika Meranti kopi', 'Kopi 100%', '1763814393_23.png', 40000.00, 32, 1, 2, 3, 'KTH Tangkalna Lestari Abadi', '2025-11-22 05:26:33', '2025-11-22 05:50:02'),
(8, 'Wajit Nanas', 'Wajit nanas', '1763814493_2.png', 19999.00, 213, 1, 2, 1, 'Alam Sari', '2025-11-22 05:28:13', '2025-11-22 05:50:07'),
(9, 'kripik Nanas', 'Kripik nanas subang', '1763814636_3.jpg', 20000.00, 21, 1, 2, 1, 'Alam Sari', '2025-11-22 05:30:37', '2025-11-22 05:50:24'),
(10, 'Manisan Nanas', 'Manisan nanas', '1763814738_4.jpg', 20000.00, 213, 1, 2, 1, 'Alam Sari', '2025-11-22 05:32:18', '2025-11-22 05:50:29'),
(11, 'Sirup nanas', 'Sirup asli nanas', '1763814838_5.png', 20000.00, 34, 1, 2, 3, 'Alam Sari', '2025-11-22 05:33:58', '2025-11-22 05:50:33'),
(12, 'Sistik Nanas Ananda', 'Sistik Nanas Subang', '1763815096_6.jpg', 15000.00, 32, 1, 2, 1, 'Wati Nurwati', '2025-11-22 05:38:16', '2025-11-22 05:50:40'),
(13, 'Beras Hitam Cimenak', 'Beras Hitam Berkualitas', '1763815309_7.jpg', 39999.00, 34, 1, 2, 4, 'Cimenak', '2025-11-22 05:41:49', '2025-11-22 05:52:15'),
(14, 'Abon Ikan Nila', 'Abon Ikan Asli', '1763815399_8.jpg', 20000.00, 54, 1, 2, 4, 'Dapoer Buaas', '2025-11-22 05:43:19', '2025-11-22 05:52:21'),
(15, 'Kripik Bawang Umbi', 'Umbi Pilihan Terbaik', '1763815505_9.jpg', 15000.00, 34, 1, 2, 1, 'Sekar Tanjung', '2025-11-22 05:45:05', '2025-11-22 05:52:27'),
(16, 'Cimol Kering', 'CImol enak gurih enyoy', '1763815621_10.jpg', 14999.00, 65, 1, 2, 1, 'Suksok Food', '2025-11-22 05:47:01', '2025-11-22 05:52:33'),
(17, 'Kripik Cireng', 'Cireng enak', '1763815790_11.jpg', 15000.00, 45, 1, 2, 1, 'ILham Snack', '2025-11-22 05:49:50', '2025-11-22 05:52:39');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(4) NOT NULL,
  `komentar` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('DCSwHMdWxXqIEHpKKbeJZM6zSqdxaFs5NyS25WLH', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiWDYyYW8wNVlJZVNFUUdtZm5FMVd1M3pRRFI2TFpoaHhBZzlIZG9vSSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9rZXJhbmphbmciO3M6NToicm91dGUiO3M6MTU6ImtlcmFuamFuZy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjM7fQ==', 1763817406),
('EJ6c0c2dcV4sizvOaLNE87QBOG7jQ2iJ9NS3dSm9', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36 Edg/142.0.0.0', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiOHBlVW85YlVXM3EzVTFIVjRMVmRhdFpxVm5XWUxmMEhUQTVPM2Z4USI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9zbGlkZXJzIjtzOjU6InJvdXRlIjtzOjE5OiJhZG1pbi5zbGlkZXJzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1763816289);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sliders`
--

CREATE TABLE `sliders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `subtitle`, `image`, `button_text`, `button_link`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(2, 'Cemilan Khas Indonesia', 'Cemilan Subang', '1763345861_slider1.webp', NULL, NULL, 0, 1, '2025-11-16 19:17:41', '2025-11-16 19:17:41'),
(3, 'GALERI PLUT SUBANG', 'GALERI PLUT Subang menyediakan segala produk Subang Asli', '1763816288_Picture1.png', 'Lihat Koleksi', 'http://127.0.0.1:8000/produk', 0, 1, '2025-11-22 05:58:08', '2025-11-22 05:58:08');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksis`
--

CREATE TABLE `transaksis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('menunggu pembayaran','diproses','dikirim','selesai') NOT NULL DEFAULT 'menunggu pembayaran',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `alamat_pengiriman` text DEFAULT NULL,
  `snap_token` varchar(255) DEFAULT NULL,
  `order_id_midtrans` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksis`
--

INSERT INTO `transaksis` (`id`, `user_id`, `total_harga`, `status`, `created_at`, `updated_at`, `alamat_pengiriman`, `snap_token`, `order_id_midtrans`) VALUES
(1, 3, 30000.00, 'diproses', '2025-11-16 01:51:06', '2025-11-16 01:55:25', 'subang', 'ac0419ba-0fc7-4398-816f-e3af13780ca6', 'TRX-1-1763283066'),
(2, 4, 120000.00, 'menunggu pembayaran', '2025-11-16 19:26:55', '2025-11-16 19:26:59', 'subang', 'f27b7aaa-34ea-4893-9f47-c5e210840d1a', 'TRX-2-1763346414'),
(3, 4, 15000.00, 'diproses', '2025-11-16 19:30:31', '2025-11-16 19:31:18', 'subang', '58517603-4a14-4380-86b1-85bff23c274e', 'TRX-3-1763346631');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_details`
--

CREATE TABLE `transaksi_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `transaksi_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `transaksi_details`
--

INSERT INTO `transaksi_details` (`id`, `transaksi_id`, `produk_id`, `jumlah`, `harga`, `created_at`, `updated_at`) VALUES
(2, 2, 2, 6, 20000.00, '2025-11-16 19:26:55', '2025-11-16 19:26:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT NULL,
  `role` enum('admin','penjual','pembeli') NOT NULL,
  `nama_toko` varchar(255) DEFAULT NULL,
  `no_telepon` varchar(255) DEFAULT NULL,
  `alamat_toko` text DEFAULT NULL,
  `nomor_lisensi` varchar(255) DEFAULT NULL,
  `file_lisensi` varchar(255) DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `foto_profil`, `role`, `nama_toko`, `no_telepon`, `alamat_toko`, `nomor_lisensi`, `file_lisensi`, `is_approved`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin1', 'admin@gmail.com', '$2y$12$Xks0RCx9k/tI6VZuESCOdO1h5iBqh5m5dZi2i0WmRFSiMKseAln0.', NULL, 'admin', NULL, NULL, NULL, NULL, NULL, 1, '2025-11-16 00:51:32', '2025-11-16 00:51:32', NULL),
(2, 'Galeri PLUT', 'galeriplut@gmail.com', '$2y$12$j0ZEt0yzJ1hKVSX.ZN5wTuNHggCWfslefRKcIEh7gdTPjlvLYjcQ.', NULL, 'penjual', NULL, NULL, NULL, NULL, NULL, 1, '2025-11-16 00:51:33', '2025-11-16 00:51:33', NULL),
(3, 'Arnov Abdillah Rahman', 'arnovabdillahr@gmail.com', '$2y$12$iWAOdQatJuVxd/CLKAdwr.aGVn1mt/V2vVIgYR9BfNNTN5ixWS2lO', NULL, 'pembeli', NULL, NULL, NULL, NULL, NULL, 1, '2025-11-16 00:53:30', '2025-11-16 02:28:22', NULL),
(4, 'Arnov Abdillah', 'rachaugy123@gmail.com', '$2y$12$7Oa3n75skCWqUkvUl1uWZeD.jwiZ.q5pmiv7gQX0RG8BXATy5qzwG', NULL, 'pembeli', NULL, NULL, NULL, NULL, NULL, 1, '2025-11-16 19:22:23', '2025-11-16 19:47:22', NULL);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `keranjangs_user_id_foreign` (`user_id`),
  ADD KEY `keranjangs_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indeks untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_images_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `produks`
--
ALTER TABLE `produks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `produks_user_id_foreign` (`user_id`),
  ADD KEY `produks_category_id_foreign` (`category_id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_produk_id_foreign` (`produk_id`),
  ADD KEY `reviews_transaksi_id_foreign` (`transaksi_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksis_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_details_transaksi_id_foreign` (`transaksi_id`),
  ADD KEY `transaksi_details_produk_id_foreign` (`produk_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `keranjangs`
--
ALTER TABLE `keranjangs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `produks`
--
ALTER TABLE `produks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjangs`
--
ALTER TABLE `keranjangs`
  ADD CONSTRAINT `keranjangs_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `keranjangs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produks`
--
ALTER TABLE `produks`
  ADD CONSTRAINT `produks_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `produks_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksis`
--
ALTER TABLE `transaksis`
  ADD CONSTRAINT `transaksis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi_details`
--
ALTER TABLE `transaksi_details`
  ADD CONSTRAINT `transaksi_details_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produks` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaksi_details_transaksi_id_foreign` FOREIGN KEY (`transaksi_id`) REFERENCES `transaksis` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
