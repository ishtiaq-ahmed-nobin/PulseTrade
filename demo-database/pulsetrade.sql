-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 29, 2026 at 06:32 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pulsetrade`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('setting_free_shipping_threshold', 's:3:\"100\";', 1785236884),
('setting_shipping_cost', 's:4:\"9.99\";', 1785236884),
('setting_store_address', 's:0:\"\";', 1785239787),
('setting_store_currency', 's:3:\"৳\";', 1785301523),
('setting_store_email', 's:0:\"\";', 1785239787),
('setting_store_name', 's:10:\"PulseTrade\";', 1785239787),
('setting_store_phone', 's:0:\"\";', 1785239787);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `parent_id`, `created_at`, `updated_at`) VALUES
(1, 'Laptops & Computers', 'laptops-computers', 'High performance workhorses and sleek notebooks for creators and professionals.', NULL, '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(2, 'Smartphones & Tablets', 'smartphones-tablets', 'Latest mobile devices and tablets with cutting edge features.', NULL, '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(3, 'Audio & Headphones', 'audio-headphones', 'Immersive sound experience with premium noise cancelling gear.', NULL, '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(4, 'Smart Wearables', 'smart-wearables', 'Fitness trackers, smartwatches, and lifestyle wearables.', NULL, '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(5, 'Accessories', 'accessories', 'Essential accessories, chargers, cases, and cables.', NULL, '2026-07-19 23:01:37', '2026-07-19 23:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'percentage',
  `value` decimal(8,2) NOT NULL,
  `min_order` decimal(8,2) NOT NULL DEFAULT 0.00,
  `usage_limit` int(11) DEFAULT NULL,
  `used_count` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `code`, `type`, `value`, `min_order`, `usage_limit`, `used_count`, `is_active`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'WELCOME10', 'percentage', 10.00, 50.00, 100, 34, 1, '2027-01-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(2, 'SAVE50', 'fixed', 50.00, 200.00, 50, 12, 1, '2026-10-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(3, 'SUMMER20', 'percentage', 20.00, 100.00, 200, 87, 1, '2026-09-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(4, 'FLASH15', 'percentage', 15.00, 75.00, 30, 30, 0, '2026-07-23 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(5, 'FREESHIP', 'fixed', 9.99, 25.00, NULL, 156, 1, NULL, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(6, 'VIP30', 'percentage', 30.00, 500.00, 10, 4, 1, '2027-07-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(7, 'NEWYEAR', 'percentage', 25.00, 150.00, 100, 0, 0, '2026-01-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(8, 'I50', 'percentage', 50.00, 1000.00, 200, 0, 1, '2026-07-30 09:39:00', '2026-07-28 03:39:33', '2026-07-28 03:39:33'),
(9, '10', 'fixed', 10.00, 10.00, NULL, 0, 1, '2026-07-31 10:11:00', '2026-07-28 04:11:35', '2026-07-28 04:11:35');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_07_19_100001_create_categories_table', 1),
(5, '2026_07_19_100002_create_products_table', 1),
(6, '2026_07_19_100003_create_orders_table', 1),
(7, '2026_07_19_100004_create_order_items_table', 1),
(8, '2026_07_19_100005_create_reviews_table', 1),
(9, '2026_07_20_044710_create_coupons_table', 2),
(10, '2026_07_20_044710_create_settings_table', 2),
(11, '2026_07_20_044710_create_subscribers_table', 2),
(12, '2026_07_28_000000_add_coupon_columns_to_orders_table', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `order_number` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `shipping_address` text NOT NULL,
  `shipping_phone` varchar(255) NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'cod',
  `payment_status` varchar(255) NOT NULL DEFAULT 'pending',
  `coupon_code` varchar(255) DEFAULT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_number`, `status`, `total_amount`, `shipping_address`, `shipping_phone`, `payment_method`, `payment_status`, `coupon_code`, `discount_amount`, `created_at`, `updated_at`) VALUES
(1, 7, 'PT-00001', 'shipped', 1798.00, '56 Cedar Lane, Denver', '+15551002005', 'stripe', 'pending', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(2, 4, 'PT-00002', 'processing', 159.00, '78 Pine Road, Portland', '+15551002002', 'cod', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(3, 6, 'PT-00003', 'pending', 2198.00, '321 Maple Drive, Seattle', '+15551002004', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(4, 9, 'PT-00004', 'cancelled', 998.00, '14 Walnut Ct, Miami', '+15551002007', 'cod', 'pending', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(5, 10, 'PT-00005', 'completed', 7895.00, '27 Spruce Blvd, Chicago', '+15551002008', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(6, 2, 'PT-00006', 'shipped', 1799.00, '123 Main Street, Apt 4B, Metropolis', '+1987654321', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(7, 8, 'PT-00007', 'cancelled', 2534.00, '89 Birch Way, Boston', '+15551002006', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(8, 2, 'PT-00008', 'cancelled', 7442.00, '123 Main Street, Apt 4B, Metropolis', '+1987654321', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(9, 8, 'PT-00009', 'shipped', 799.00, '89 Birch Way, Boston', '+15551002006', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(10, 5, 'PT-00010', 'pending', 3073.00, '12 Elm Street, Austin', '+15551002003', 'cod', 'pending', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(11, 6, 'PT-00011', 'completed', 2645.00, '321 Maple Drive, Seattle', '+15551002004', 'stripe', 'failed', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(12, 8, 'PT-00012', 'processing', 1099.00, '89 Birch Way, Boston', '+15551002006', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(13, 3, 'PT-00013', 'processing', 8751.00, '45 Oak Avenue, Springfield', '+15551002001', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(14, 8, 'PT-00014', 'cancelled', 1565.00, '89 Birch Way, Boston', '+15551002006', 'stripe', 'pending', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(15, 5, 'PT-00015', 'shipped', 3015.00, '12 Elm Street, Austin', '+15551002003', 'cod', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(16, 10, 'PT-00016', 'cancelled', 7680.00, '27 Spruce Blvd, Chicago', '+15551002008', 'cod', 'failed', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(17, 10, 'PT-00017', 'processing', 637.00, '27 Spruce Blvd, Chicago', '+15551002008', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(18, 2, 'PT-00018', 'completed', 2556.00, '123 Main Street, Apt 4B, Metropolis', '+1987654321', 'stripe', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(19, 5, 'PT-00019', 'pending', 8021.00, '12 Elm Street, Austin', '+15551002003', 'cod', 'paid', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(20, 5, 'PT-00020', 'cancelled', 258.00, '12 Elm Street, Austin', '+15551002003', 'cod', 'pending', NULL, 0.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(21, 1, 'PT-20260728-NDAEW2', 'pending', 2299.00, 'PulseTrade HQ, Tech City, Dhaka 1000', '123456789', 'cod', 'pending', NULL, 0.00, '2026-07-28 03:29:38', '2026-07-28 03:29:38'),
(22, 1, 'PT-20260728-VS3DWU', 'pending', 1898.00, 'PulseTrade HQ, Tech City, Dhaka 1000', '123456789', 'cod', 'pending', NULL, 0.00, '2026-07-28 04:09:39', '2026-07-28 04:09:39'),
(23, 1, 'PT-20260728-RX5O3H', 'pending', 78.99, 'PulseTrade HQ, Tech City, Dhaka 1000', '123456789', 'stripe', 'paid', NULL, 0.00, '2026-07-28 04:12:20', '2026-07-28 04:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 2, 899.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(2, 2, 12, 1, 159.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(3, 3, 2, 2, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(4, 4, 6, 2, 499.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(5, 5, 1, 3, 2299.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(6, 5, 6, 2, 499.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(7, 6, 8, 1, 1799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(8, 7, 2, 2, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(9, 7, 16, 3, 69.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(10, 7, 17, 1, 129.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(11, 8, 2, 1, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(12, 8, 3, 3, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(13, 8, 11, 1, 649.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(14, 8, 14, 3, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(15, 9, 10, 1, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(16, 10, 10, 1, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(17, 10, 12, 3, 159.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(18, 10, 13, 3, 599.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(19, 11, 2, 2, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(20, 11, 12, 2, 159.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(21, 11, 15, 1, 129.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(22, 12, 3, 1, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(23, 13, 4, 3, 899.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(24, 13, 5, 3, 219.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(25, 13, 8, 3, 1799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(26, 14, 11, 2, 649.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(27, 14, 15, 1, 129.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(28, 14, 16, 2, 69.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(29, 15, 5, 1, 219.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(30, 15, 13, 2, 599.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(31, 15, 14, 2, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(32, 16, 2, 3, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(33, 16, 3, 2, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(34, 16, 4, 2, 899.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(35, 16, 15, 3, 129.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(36, 17, 6, 1, 499.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(37, 17, 16, 2, 69.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(38, 18, 9, 2, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(39, 18, 10, 1, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(40, 18, 12, 1, 159.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(41, 19, 2, 3, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(42, 19, 3, 2, 1099.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(43, 19, 9, 3, 799.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(44, 19, 17, 1, 129.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(45, 20, 17, 2, 129.00, '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(46, 21, 1, 1, 2299.00, '2026-07-28 03:29:38', '2026-07-28 03:29:38'),
(47, 22, 2, 1, 1099.00, '2026-07-28 04:09:39', '2026-07-28 04:09:39'),
(48, 22, 9, 1, 799.00, '2026-07-28 04:09:39', '2026-07-28 04:09:39'),
(49, 23, 16, 1, 69.00, '2026-07-28 04:12:20', '2026-07-28 04:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `sale_price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT NULL,
  `images` text DEFAULT NULL,
  `is_featured` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `name`, `slug`, `description`, `price`, `sale_price`, `stock`, `image`, `images`, `is_featured`, `created_at`, `updated_at`) VALUES
(1, 1, 'PulseBook Pro 16', 'pulsebook-pro-16', 'The ultimate notebook for professionals. M3-equivalent octa-core processor, 32GB unified memory, and 1TB SSD. 16-inch Liquid Retina XDR display with 1600 nits brightness. Six-speaker sound system and 22-hour battery.', 2499.00, 2299.00, 15, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(2, 1, 'PulseBook Air 13', 'pulsebook-air-13', 'Superlight. Supercharged. 13.6-inch Liquid Retina display, fanless design, 18-hour battery. Perfect for students and developers.', 1099.00, NULL, 30, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(3, 2, 'PulsePhone 15 Ultra', 'pulsephone-15-ultra', 'Aerospace-grade titanium. A17 Pro-equivalent chip, customizable Action button, powerful zoom camera system. Super Retina XDR with ProMotion 120Hz.', 1199.00, 1099.00, 25, 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1592432678016-e910b452f9a2?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(4, 2, 'PulseTab Pro 11', 'pulsetab-pro-11', 'Next-gen performance, ultra-thin. Tandem OLED display, ultra-wide Center Stage camera, 5G. Supports precision digital stylus.', 899.00, NULL, 20, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1527698266440-12104e498b76?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(5, 3, 'PulseBuds Pro 2', 'pulsebuds-pro-2', 'Richer audio, 2x Active Noise Cancellation. Adaptive Audio, Spatial Audio for deeply personal immersion.', 249.00, 219.00, 100, 'https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1606220588913-b3aacb4d2f46?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(6, 3, 'PulseMax Studio Wireless', 'pulsemax-studio-wireless', 'Over-ear headphones reimagined. Uncompromising fit, optimal acoustic seal, high-fidelity custom drivers.', 549.00, 499.00, 12, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(7, 4, 'PulseWatch Active 4', 'pulsewatch-active-4', 'Health companion. Blood oxygen, ECG, precision GPS, always-on OLED, aluminum casing, contactless payment.', 399.00, NULL, 45, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1546868871-a0d9a1c5a0e9?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(8, 1, 'PulseBook Studio 14', 'pulsebook-studio-14', 'Built for creators. 14-inch mini-LED display with P3 wide color, M3 Pro chip, 18GB memory. Up to 17 hours battery. MagSafe charging, six-speaker system with spatial audio.', 1999.00, 1799.00, 18, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1496181133206-80ce9b88a853?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1517336714731-489689fd1ca8?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1531297484001-80022131f5a1?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(9, 1, 'PulseDesk Mini', 'pulsedesk-mini', 'M3 chip desktop powerhouse in a compact design. 16GB unified memory, 512GB SSD, Wi-Fi 6E. Connect up to two displays. Perfect for home office setups.', 799.00, NULL, 40, 'https://images.unsplash.com/photo-1593642702743-b2a86983193b?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1593642702743-b2a86983193b?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1558618666-fcd25c85f82e?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1593642702743-b2a86983193b?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(10, 2, 'PulsePhone 15', 'pulsephone-15', 'The standard redefined. A17 chip, 48MP main camera, Ceramic Shield front. 6.1-inch Super Retina XDR display. All-day battery life and 5G.', 899.00, 799.00, 35, 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1598327105666-5b89351aff97?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1511707171634-5f897ff02aa9?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1592432678016-e910b452f9a2?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(11, 2, 'PulsePad Air', 'pulsepad-air', 'Lightweight powerhouse. 10.9-inch Liquid Retina display, M2 chip, Touch ID. Wi-Fi 6 and 5G optional. Works with Apple Pencil and Magic Keyboard.', 649.00, NULL, 28, 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1544244015-0df4b3ffc6b0?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1527698266440-12104e498b76?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(12, 3, 'PulseBuds 3', 'pulsebuds-3', 'Everyday earbuds elevated. Active Noise Cancellation, Transparency mode, personalized spatial audio. 6-hour listening time, 30 hours with case.', 179.00, 159.00, 80, 'https://images.unsplash.com/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1588423771073-b8903fbb85b5?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1606220588913-b3aacb4d2f46?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(13, 3, 'PulseSound Bar', 'pulsesound-bar', 'Cinematic sound for your living room. Dolby Atmos, room-filling sound with seven drivers. Works with all your devices via HDMI eARC, Wi-Fi, Bluetooth.', 699.00, 599.00, 15, 'https://images.unsplash.com/photo-1558089687-f282ffcbc126?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1558089687-f282ffcbc126?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(14, 4, 'PulseWatch Ultra 2', 'pulsewatch-ultra-2', 'The most rugged and capable smartwatch. 49mm titanium case, 2000-nit display, precision dual-frequency GPS. Depth gauge, water temperature, 36-hour battery.', 799.00, NULL, 20, 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1546868871-a0d9a1c5a0e9?auto=format&fit=crop&w=600&q=80\"]', 1, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(15, 4, 'PulseBand SE', 'pulseband-se', 'Fitness meets affordability. Heart rate monitoring, sleep tracking, 18 types of workouts. Water resistant to 50m. 15-day battery life.', 149.00, 129.00, 60, 'https://images.unsplash.com/photo-1576243345690-4e4b79b63288?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1576243345690-4e4b79b63288?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(16, 5, 'PulseChargPro 140W', 'pulsechargpro-140w', 'Charge everything at once. 140W GaN charger with 4 ports (2 USB-C, 2 USB-A). Compact design, foldable prongs. Charges MacBook Pro, iPhone, and iPad simultaneously.', 89.00, 69.00, 120, 'https://images.unsplash.com/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1558618666-fcd25c85f82e?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(17, 5, 'PulseHub Ultra', 'pulsehub-ultra', '11-in-1 USB-C hub. Dual HDMI 4K@60Hz, Ethernet, SD card, USB-A 3.0 ports, 100W passthrough charging. Aluminum body with built-in cable.', 129.00, NULL, 65, 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?auto=format&fit=crop&w=600&q=80', '[\"https:\\/\\/images.unsplash.com\\/photo-1558618666-fcd25c85f82e?auto=format&fit=crop&w=600&q=80\",\"https:\\/\\/images.unsplash.com\\/photo-1583394838336-acd977736f90?auto=format&fit=crop&w=600&q=80\"]', 0, '2026-07-19 23:01:37', '2026-07-28 22:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(2, 2, 1, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(3, 2, 3, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(4, 2, 3, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(5, 2, 5, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(6, 2, 5, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(7, 2, 6, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-28 22:18:07'),
(8, 2, 6, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 09:38:09', '2026-07-19 09:38:09'),
(9, 3, 1, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(10, 3, 3, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(11, 3, 5, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(12, 3, 6, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(13, 2, 8, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(14, 3, 8, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(15, 2, 10, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(16, 3, 10, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(17, 2, 13, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(18, 3, 13, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(19, 2, 14, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(20, 3, 14, 4, 'Very good value, although shipping took a bit longer than expected.', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(21, 1, 1, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(22, 1, 3, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(23, 1, 5, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(24, 1, 6, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(25, 1, 8, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(26, 1, 10, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(27, 1, 13, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07'),
(28, 1, 14, 5, 'Absolutely amazing product! Build quality is top-notch and it exceeds expectations.', '2026-07-28 22:18:07', '2026-07-28 22:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('CrBc4f5xVovbhRXs745qfTEV4YPqraiLM5A2l8Rt', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/150.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiSkFTYjZ1VU9mYmlYa2tyVGN4VzRRdzJmVUhYSmgxV1YwaXVqUGRwbiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHA6Ly9sb2NhbGhvc3Q6ODAwMC9hZG1pbi9zZXR0aW5ncyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6MzoidXJsIjthOjA6e31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MTM6Imxhc3Rfb3JkZXJfaWQiO2k6MjM7fQ==', 1785238384);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text DEFAULT NULL,
  `group` varchar(255) NOT NULL DEFAULT 'general',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `value`, `group`, `created_at`, `updated_at`) VALUES
(1, 'store_name', 'PulseTrade', 'store', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(2, 'store_email', 'hello@pulsetrade.com', 'store', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(3, 'store_phone', '+18005559876', 'store', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(4, 'store_address', '100 Tech Park Blvd, San Francisco, CA 94105', 'store', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(5, 'store_currency', 'USD', 'store', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(6, 'meta_title', 'PulseTrade - Premium Tech Electronics', 'seo', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(7, 'meta_description', 'Shop the latest in premium tech electronics. Laptops, phones, audio gear, wearables, and accessories from PulseTrade.', 'seo', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(8, 'free_shipping_threshold', '100', 'shipping', '2026-07-19 23:01:37', '2026-07-19 23:01:37'),
(9, 'shipping_cost', '9.99', 'shipping', '2026-07-19 23:01:37', '2026-07-19 23:01:37');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `email` varchar(255) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `subscribed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`id`, `email`, `name`, `is_active`, `subscribed_at`, `created_at`, `updated_at`) VALUES
(1, 'sarah@example.com', 'Sarah Mitchell', 1, '2026-03-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(2, 'james@example.com', 'James Wilson', 1, '2026-04-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(3, 'emma@example.com', 'Emma Garcia', 1, '2026-05-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(4, 'michael@example.com', 'Michael Chen', 1, '2026-06-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(5, 'olivia@example.com', 'Olivia Brown', 1, '2026-07-07 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(6, 'david@example.com', 'David Kim', 0, '2026-02-28 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(7, 'sophia@example.com', 'Sophia Martinez', 1, '2026-07-18 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(8, 'alex@example.com', 'Alex Turner', 1, '2026-07-23 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(9, 'newsletter_fan@example.com', 'Chris Lee', 1, '2026-07-26 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07'),
(10, 'tech_lover@example.com', 'Jordan Patel', 1, '2026-07-27 22:18:07', '2026-07-19 23:01:37', '2026-07-28 22:18:07');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'PulseTrade Admin', 'admin@pulsetrade.com', NULL, '$2y$12$J1LTl7ItEjsUQjAbEWtg5uQrzV6KEP5arqFilXwsPd6Lf5ZddBzqe', 'admin', '+1234567890', 'PulseTrade HQ, Tech City', '5yusaeUqMJGstLBl3YfNMwcN3I2kxMAWQcbks9IYGHEtxs2hYIujgYTGNGSs', '2026-07-19 09:38:09', '2026-07-28 22:18:04'),
(2, 'John Doe', 'customer@pulsetrade.com', NULL, '$2y$12$gE30KGgn5aFH0t8uSOykcuK53Pl9wk1WotxsBC12Bh4J9zUJh77xG', 'customer', '+1987654321', '123 Main Street, Apt 4B, Metropolis', NULL, '2026-07-19 09:38:09', '2026-07-28 22:18:04'),
(3, 'Sarah Mitchell', 'sarah@example.com', NULL, '$2y$12$fEVI2cFk35KvTAWuqnrYf.kdZTcdO/1085pVfDwSVqxeugjSyHv7e', 'customer', '+15551002001', '45 Oak Avenue, Springfield', NULL, '2026-07-19 23:01:35', '2026-07-28 22:18:05'),
(4, 'James Wilson', 'james@example.com', NULL, '$2y$12$d/xdCvAtrwOr2v0S/g2H7.1w4AGFiHK1lyC5YE/H5rDda1xJ3TxnW', 'customer', '+15551002002', '78 Pine Road, Portland', NULL, '2026-07-19 23:01:35', '2026-07-28 22:18:05'),
(5, 'Emma Garcia', 'emma@example.com', NULL, '$2y$12$2MOuPfKzuJYFt678vAtz1uuFXRgExEbx1Lje.md9QcEMHDW5E9ak6', 'customer', '+15551002003', '12 Elm Street, Austin', NULL, '2026-07-19 23:01:36', '2026-07-28 22:18:05'),
(6, 'Michael Chen', 'michael@example.com', NULL, '$2y$12$tjkzXl/p4ItVls3dxsp8QOuC.l8rs7HlwOtiUh4.TSHPIlsAyiQKK', 'customer', '+15551002004', '321 Maple Drive, Seattle', NULL, '2026-07-19 23:01:36', '2026-07-28 22:18:05'),
(7, 'Olivia Brown', 'olivia@example.com', NULL, '$2y$12$SeeOX2OuXl8kA64BN15N/.Ayv3DZ.w7EDJS.JcgPsINRsmLtff3Tu', 'customer', '+15551002005', '56 Cedar Lane, Denver', NULL, '2026-07-19 23:01:36', '2026-07-28 22:18:06'),
(8, 'David Kim', 'david@example.com', NULL, '$2y$12$z9BFIkmwOHUQAZ7s0WVgQOKvcQeFISquG0A0j3NLLxLtbly9w5duu', 'customer', '+15551002006', '89 Birch Way, Boston', NULL, '2026-07-19 23:01:36', '2026-07-28 22:18:06'),
(9, 'Sophia Martinez', 'sophia@example.com', NULL, '$2y$12$8d7zAlcQZt6aw5EAMmM9M.VbFN6UVirXSLUl1AeR5VoUaYjOzd746', 'customer', '+15551002007', '14 Walnut Ct, Miami', NULL, '2026-07-19 23:01:37', '2026-07-28 22:18:06'),
(10, 'Alex Turner', 'alex@example.com', NULL, '$2y$12$Ut.Ne600n5eFrDoNy3ctmOn17EsQQwAhMBpzXH4VY7.Ltpht2e17e', 'customer', '+15551002008', '27 Spruce Blvd, Chicago', NULL, '2026-07-19 23:01:37', '2026-07-28 22:18:06'),
(11, 'Demo User', 'user@pulsetrade.com', NULL, '$2y$12$zTgC.36UVvz/IvmR/ixev.KSuCjc5dcGRoYuAQR3rlJWS/EK4YFGq', 'customer', '+15551234567', '456 Demo Lane, User City', NULL, '2026-07-28 22:18:04', '2026-07-28 22:18:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`),
  ADD KEY `categories_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `coupons_code_unique` (`code`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `orders_order_number_unique` (`order_number`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `products_slug_unique` (`slug`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subscribers_email_unique` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
