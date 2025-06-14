-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 14, 2025 at 05:31 PM
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
-- Database: `laundrify`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel_cache_analytics_dashboard_30days', 'a:12:{s:10:\"totalUsers\";i:17;s:8:\"newUsers\";i:0;s:12:\"totalSellers\";i:2;s:10:\"newSellers\";i:0;s:11:\"totalOrders\";i:11;s:12:\"totalRevenue\";d:775.8899999999999;s:13:\"avgOrderValue\";d:70.53545454545453;s:17:\"orderStatusCounts\";a:4:{s:15:\"pickup_departed\";i:4;s:8:\"accepted\";i:2;s:9:\"cancelled\";i:4;s:7:\"pending\";i:1;}s:17:\"userRetentionRate\";d:64.70588235294117;s:19:\"sellerRetentionRate\";d:550;s:16:\"dailyActiveUsers\";a:3:{s:10:\"2025-05-19\";i:1;s:10:\"2025-05-26\";i:1;s:10:\"2025-05-27\";i:2;}s:12:\"dailyRevenue\";a:3:{s:10:\"2025-05-19\";s:6:\"275.94\";s:10:\"2025-05-26\";s:6:\"231.63\";s:10:\"2025-05-27\";s:6:\"268.32\";}}', 1748334275),
('laravel_cache_analytics_users_30days', 'a:8:{s:10:\"totalUsers\";i:17;s:8:\"newUsers\";i:0;s:11:\"activeUsers\";i:11;s:18:\"registrationsByDay\";a:0:{}s:11:\"usersByCity\";a:0:{}s:14:\"orderFrequency\";a:5:{i:1;i:1;s:3:\"2-3\";i:0;s:3:\"4-5\";i:0;s:4:\"6-10\";i:1;s:3:\"10+\";i:0;}s:16:\"avgOrdersPerUser\";i:1;s:19:\"usersWithMostOrders\";a:2:{i:0;O:8:\"stdClass\":4:{s:2:\"id\";i:17;s:4:\"name\";s:4:\"Anas\";s:5:\"email\";s:14:\"anas@gmail.com\";s:11:\"order_count\";i:10;}i:1;O:8:\"stdClass\":4:{s:2:\"id\";i:1;s:4:\"name\";s:10:\"Admin User\";s:5:\"email\";s:19:\"admin@laundrify.com\";s:11:\"order_count\";i:1;}}}', 1748334595);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `service_id`, `created_at`, `updated_at`) VALUES
(32, 1, 5, '2025-05-27 03:07:39', '2025-05-27 03:07:39'),
(33, 1, 4, '2025-05-27 03:07:41', '2025-05-27 03:07:41');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `feedback` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `order_id`, `user_id`, `seller_id`, `feedback`, `created_at`, `updated_at`) VALUES
(1, 2, 17, 1, 'Well done', '2025-04-07 05:53:33', '2025-04-07 05:53:33'),
(2, 2, 17, 1, 'lovely', '2025-04-21 16:20:04', '2025-04-21 16:20:04');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `sender_id` bigint UNSIGNED NOT NULL,
  `sender_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `order_id`, `sender_id`, `sender_type`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 17, 'user', 'hi', 0, '2025-04-21 15:29:31', '2025-04-21 15:29:31'),
(2, 2, 17, 'user', 'hoo', 0, '2025-04-21 15:34:14', '2025-04-21 15:34:14'),
(3, 2, 17, 'user', 'hoo', 0, '2025-04-21 15:34:19', '2025-04-21 15:34:19'),
(4, 2, 17, 'user', 'hoo', 0, '2025-04-21 16:14:25', '2025-04-21 16:14:25'),
(5, 3, 1, 'seller', 'hi bro', 1, '2025-04-21 17:10:18', '2025-05-27 02:51:29'),
(6, 3, 1, 'seller', 'hi bro', 1, '2025-04-21 17:10:24', '2025-05-27 02:51:29'),
(7, 3, 1, 'seller', 'hi bro', 1, '2025-04-21 17:10:47', '2025-05-27 02:51:29'),
(8, 3, 1, 'seller', 'hi bro', 1, '2025-04-21 17:14:10', '2025-05-27 02:51:29'),
(9, 3, 1, 'seller', 'yoo', 1, '2025-04-21 17:14:27', '2025-05-27 02:51:29'),
(10, 3, 1, 'seller', 'p', 1, '2025-04-21 17:17:22', '2025-05-27 02:51:29'),
(11, 3, 1, 'seller', 'diddy', 1, '2025-04-21 17:17:30', '2025-05-27 02:51:29'),
(12, 3, 1, 'seller', 'yo', 1, '2025-04-21 17:23:27', '2025-05-27 02:51:29'),
(13, 3, 17, 'user', 'dababy', 0, '2025-04-21 17:41:01', '2025-04-21 17:41:01'),
(14, 5, 1, 'seller', 'Hi, your order will be ready soon', 1, '2025-05-19 12:34:25', '2025-05-19 12:36:14'),
(15, 5, 17, 'user', 'Ok, thanks', 1, '2025-05-19 12:36:23', '2025-05-27 01:14:24'),
(16, 5, 1, 'seller', 'Hi, whats the update', 0, '2025-05-27 01:14:29', '2025-05-27 01:14:29'),
(17, 10, 1, 'seller', 'hi, how are you?', 1, '2025-05-27 01:17:46', '2025-05-27 01:17:53'),
(18, 10, 17, 'user', 'fine', 1, '2025-05-27 01:17:57', '2025-05-27 01:20:44'),
(19, 11, 2, 'seller', 'hi', 1, '2025-05-27 02:03:09', '2025-05-27 02:03:37'),
(20, 11, 2, 'seller', 'pickup gotten', 1, '2025-05-27 02:03:13', '2025-05-27 02:03:37'),
(21, 11, 17, 'user', 'ok', 0, '2025-05-27 02:03:40', '2025-05-27 02:03:40'),
(22, 12, 2, 'seller', 'pickup done', 1, '2025-05-27 02:07:15', '2025-05-27 02:51:44'),
(23, 12, 17, 'user', 'ok', 1, '2025-05-27 02:08:44', '2025-05-27 02:08:47'),
(24, 4, 2, 'seller', 'pickup done', 0, '2025-05-27 02:51:00', '2025-05-27 02:51:00'),
(25, 14, 1, 'user', 'hi', 1, '2025-05-27 03:10:24', '2025-05-27 03:10:27'),
(26, 14, 1, 'seller', 'hey', 1, '2025-05-27 03:10:31', '2025-05-27 03:10:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2024_12_12_180538_create_sellers_table', 1),
(4, '2024_12_12_180539_create_services_table', 1),
(5, '2024_12_14_132911_create_users_table', 1),
(6, '2024_12_16_140213_create_user_profile_updates_table', 1),
(7, '2024_12_16_180740_create_sessions_table', 2),
(8, '2024_12_18_172704_create_notifications_table', 2),
(9, '2024_12_27_184305_create_orders_table', 2),
(10, '2024_12_27_184336_create_order_items_table', 2),
(11, '2025_03_09_205809_create_messages_table', 2),
(12, '2025_03_25_152156_create_feedback_table', 2),
(13, '2025_04_07_094536_create_seller_verifications_table', 2),
(14, '2025_04_24_224639_add_remember_token_to_sellers_table', 3),
(15, '2025_05_26_200506_create_favorites_table', 4),
(16, '2025_05_26_205032_add_cancellation_reason_to_orders_table', 5),
(17, '2025_05_26_215551_add_suspension_to_users_table', 6),
(18, '2025_05_27_000814_add_suspension_fields_to_sellers_table', 7),
(19, '2025_05_27_003613_add_category_to_services_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint UNSIGNED NOT NULL,
  `data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('005214fe-dabb-48a2-bdf2-2d6b004f2beb', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":7,\"order_details\":[{\"id\":10,\"order_id\":7,\"service_id\":4,\"quantity\":1,\"price\":\"54.00\",\"created_at\":\"2025-05-26T20:59:14.000000Z\",\"updated_at\":\"2025-05-26T20:59:14.000000Z\"}]}', '2025-05-26 16:50:04', '2025-05-26 15:59:14', '2025-05-26 16:50:04'),
('25dbf202-aa13-42dc-9eb7-368ddb460333', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":10,\"order_details\":[{\"id\":13,\"order_id\":10,\"service_id\":2,\"quantity\":1,\"price\":\"77.56\",\"created_at\":\"2025-05-27T06:16:24.000000Z\",\"updated_at\":\"2025-05-27T06:16:24.000000Z\"}]}', '2025-05-27 03:01:13', '2025-05-27 01:16:24', '2025-05-27 03:01:13'),
('27b8593e-367b-443e-8d94-62ae9304ff5b', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 2, '{\"seller_name\":\"Bettie Grimes\",\"order_id\":12,\"order_details\":[{\"id\":15,\"order_id\":12,\"service_id\":7,\"quantity\":1,\"price\":\"15.30\",\"created_at\":\"2025-05-27T07:06:14.000000Z\",\"updated_at\":\"2025-05-27T07:06:14.000000Z\"}]}', NULL, '2025-05-27 02:06:14', '2025-05-27 02:06:14'),
('2d629c66-cfbe-41fc-8225-97b3c21ce744', 'App\\Notifications\\OrderCancelledNotification', 'App\\Models\\Seller', 1, '{\"order_id\":6,\"message\":\"Order #6 has been cancelled by the customer.\",\"cancellation_reason\":\"jhkjhkjhkk\",\"cancelled_at\":\"May 26, 2025 09:16 PM\",\"user_id\":17,\"user_name\":\"Anas\",\"service_url\":\"http:\\/\\/127.0.0.1:8000\\/seller\\/order\\/6\\/handle\"}', '2025-05-26 16:50:05', '2025-05-26 16:16:04', '2025-05-26 16:50:05'),
('3376733e-e28f-4606-a7f1-7f58130c1367', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":8,\"order_details\":[{\"id\":11,\"order_id\":8,\"service_id\":1,\"quantity\":1,\"price\":\"41.03\",\"created_at\":\"2025-05-26T21:06:01.000000Z\",\"updated_at\":\"2025-05-26T21:06:01.000000Z\"}]}', '2025-05-26 16:50:05', '2025-05-26 16:06:01', '2025-05-26 16:50:05'),
('455a1031-4feb-485c-bfd9-e65f622ef9bd', 'App\\Notifications\\SellerAccountSuspendedNotification', 'App\\Models\\Seller', 1, '{\"title\":\"Seller Account Suspended\",\"message\":\"Your seller account has been suspended. Reason: seller suspension test.\",\"type\":\"seller_account_suspended\"}', '2025-05-27 03:01:13', '2025-05-26 19:16:16', '2025-05-27 03:01:13'),
('4b786913-c414-4ad7-932b-d110cbe975de', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":13,\"order_details\":[{\"id\":16,\"order_id\":13,\"service_id\":5,\"quantity\":1,\"price\":\"82.60\",\"created_at\":\"2025-05-27T07:49:41.000000Z\",\"updated_at\":\"2025-05-27T07:49:41.000000Z\"}]}', '2025-05-27 03:01:13', '2025-05-27 02:49:41', '2025-05-27 03:01:13'),
('5dbbefd8-8565-4b5a-93c2-59519f8b498b', 'App\\Notifications\\AccountSuspendedNotification', 'App\\Models\\User', 17, '{\"title\":\"Account Suspended\",\"message\":\"Your account has been suspended. Reason: testing\",\"type\":\"account_suspended\"}', NULL, '2025-05-26 18:13:35', '2025-05-26 18:13:35'),
('5f3d5a5d-8a41-48d5-84be-cf3c7a200099', 'App\\Notifications\\OrderCancelledNotification', 'App\\Models\\Seller', 1, '{\"order_id\":7,\"message\":\"Order #7 has been cancelled by the customer.\",\"cancellation_reason\":\"Quited\",\"cancelled_at\":\"May 26, 2025 09:02 PM\",\"user_id\":17,\"user_name\":\"Anas\",\"service_url\":\"http:\\/\\/127.0.0.1:8000\\/seller\\/order\\/7\\/handle\"}', '2025-05-26 16:50:05', '2025-05-26 16:02:06', '2025-05-26 16:50:05'),
('63aedfe7-f65d-4907-97db-c19ae98108c0', 'App\\Notifications\\OrderCancelledNotification', 'App\\Models\\Seller', 1, '{\"order_id\":8,\"message\":\"Order #8 has been cancelled by the customer.\",\"cancellation_reason\":\"no homo bro\",\"cancelled_at\":\"May 26, 2025 09:08 PM\",\"user_id\":17,\"user_name\":\"Anas\",\"service_url\":\"http:\\/\\/127.0.0.1:8000\\/seller\\/order\\/8\\/handle\"}', '2025-05-26 16:50:05', '2025-05-26 16:08:25', '2025-05-26 16:50:05'),
('73e76dec-4c8d-4e56-97a2-b232b3f02759', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":1,\"order_details\":[{\"id\":1,\"order_id\":1,\"service_id\":3,\"quantity\":2,\"price\":\"449.00\",\"created_at\":\"2025-04-07T10:48:02.000000Z\",\"updated_at\":\"2025-04-07T10:48:02.000000Z\"},{\"id\":2,\"order_id\":1,\"service_id\":1,\"quantity\":1,\"price\":\"41.03\",\"created_at\":\"2025-04-07T10:48:02.000000Z\",\"updated_at\":\"2025-04-07T10:48:02.000000Z\"}]}', '2025-05-26 16:50:05', '2025-04-07 05:48:03', '2025-05-26 16:50:05'),
('9a0e86a7-3438-4d04-9c96-a1c153bb971e', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":3,\"order_details\":[{\"id\":4,\"order_id\":3,\"service_id\":3,\"quantity\":1,\"price\":\"82.35\",\"created_at\":\"2025-04-21T19:40:55.000000Z\",\"updated_at\":\"2025-04-21T19:40:55.000000Z\"}]}', '2025-05-26 16:50:05', '2025-04-21 14:40:56', '2025-05-26 16:50:05'),
('ba4f116b-decf-461a-ad36-54cdc4c8efda', 'App\\Notifications\\AccountUnsuspendedNotification', 'App\\Models\\User', 17, '{\"title\":\"Account Reactivated\",\"message\":\"Your account has been reactivated. You can now log in and continue using our services.\",\"type\":\"account_unsuspended\"}', NULL, '2025-05-26 19:00:31', '2025-05-26 19:00:31'),
('bed34d61-39e8-4a90-b56c-958796ce1662', 'App\\Notifications\\OrderCancelledNotification', 'App\\Models\\Seller', 1, '{\"order_id\":9,\"message\":\"Order #9 has been cancelled by the customer.\",\"cancellation_reason\":\"pending cancel\",\"cancelled_at\":\"May 26, 2025 09:42 PM\",\"user_id\":17,\"user_name\":\"Anas\",\"service_url\":\"http:\\/\\/127.0.0.1:8000\\/seller\\/order\\/9\\/handle\"}', '2025-05-26 16:50:05', '2025-05-26 16:42:08', '2025-05-26 16:50:05'),
('c31dfc97-74d9-4e37-bf96-f626607b25eb', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 2, '{\"seller_name\":\"Bettie Grimes\",\"order_id\":11,\"order_details\":[{\"id\":14,\"order_id\":11,\"service_id\":7,\"quantity\":1,\"price\":\"15.30\",\"created_at\":\"2025-05-27T06:59:26.000000Z\",\"updated_at\":\"2025-05-27T06:59:26.000000Z\"}]}', NULL, '2025-05-27 01:59:26', '2025-05-27 01:59:26'),
('d7934982-59ac-4993-be2c-176bc3a6d106', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":6,\"order_details\":[{\"id\":9,\"order_id\":6,\"service_id\":5,\"quantity\":1,\"price\":\"82.60\",\"created_at\":\"2025-05-26T20:57:49.000000Z\",\"updated_at\":\"2025-05-26T20:57:49.000000Z\"}]}', '2025-05-26 16:50:05', '2025-05-26 15:57:51', '2025-05-26 16:50:05'),
('e0338f6f-471c-482a-9a13-422c6e7a1867', 'App\\Notifications\\SellerAccountUnsuspendedNotification', 'App\\Models\\Seller', 1, '{\"title\":\"Seller Account Reactivated\",\"message\":\"Your seller account has been reactivated and is now fully functional.\",\"type\":\"seller_account_unsuspended\"}', '2025-05-27 03:01:13', '2025-05-26 19:21:47', '2025-05-27 03:01:13'),
('e409f04e-2457-4e5b-9e11-7de78cfca739', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 2, '{\"seller_name\":\"Bettie Grimes\",\"order_id\":4,\"order_details\":[{\"id\":5,\"order_id\":4,\"service_id\":9,\"quantity\":1,\"price\":\"95.29\",\"created_at\":\"2025-05-19T17:26:41.000000Z\",\"updated_at\":\"2025-05-19T17:26:41.000000Z\"},{\"id\":6,\"order_id\":4,\"service_id\":7,\"quantity\":1,\"price\":\"15.30\",\"created_at\":\"2025-05-19T17:26:41.000000Z\",\"updated_at\":\"2025-05-19T17:26:41.000000Z\"},{\"id\":7,\"order_id\":4,\"service_id\":8,\"quantity\":1,\"price\":\"87.79\",\"created_at\":\"2025-05-19T17:26:41.000000Z\",\"updated_at\":\"2025-05-19T17:26:41.000000Z\"}]}', NULL, '2025-05-19 12:26:43', '2025-05-19 12:26:43'),
('ed7d1e6a-cf71-418b-95a1-4a806f1d8b1a', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":9,\"order_details\":[{\"id\":12,\"order_id\":9,\"service_id\":4,\"quantity\":1,\"price\":\"54.00\",\"created_at\":\"2025-05-26T21:33:27.000000Z\",\"updated_at\":\"2025-05-26T21:33:27.000000Z\"}]}', '2025-05-26 16:50:05', '2025-05-26 16:33:27', '2025-05-26 16:50:05'),
('ed9bd426-ff11-4f6a-8e51-aadfb79bfd55', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":2,\"order_details\":[{\"id\":3,\"order_id\":2,\"service_id\":1,\"quantity\":1,\"price\":\"41.03\",\"created_at\":\"2025-04-07T10:52:07.000000Z\",\"updated_at\":\"2025-04-07T10:52:07.000000Z\"}]}', '2025-05-26 16:50:05', '2025-04-07 05:52:07', '2025-05-26 16:50:05'),
('f3097319-e6d1-45e0-8c4d-bc25b1121875', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":5,\"order_details\":[{\"id\":8,\"order_id\":5,\"service_id\":2,\"quantity\":1,\"price\":\"77.56\",\"created_at\":\"2025-05-19T17:30:40.000000Z\",\"updated_at\":\"2025-05-19T17:30:40.000000Z\"}]}', '2025-05-26 16:50:05', '2025-05-19 12:30:40', '2025-05-26 16:50:05'),
('f92818a8-84ee-4887-9fbb-487eb3710a86', 'App\\Notifications\\NewOrderNotification', 'App\\Models\\Seller', 1, '{\"seller_name\":\"Kameron Dooley\",\"order_id\":14,\"order_details\":[{\"id\":17,\"order_id\":14,\"service_id\":2,\"quantity\":1,\"price\":\"77.56\",\"created_at\":\"2025-05-27T08:06:43.000000Z\",\"updated_at\":\"2025-05-27T08:06:43.000000Z\"}]}', '2025-05-27 03:07:07', '2025-05-27 03:06:45', '2025-05-27 03:07:07');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','accepted','in_progress','completed','cancelled','rejected','pickup_departed','picked_up','started_washing','ironing','ready_for_delivery','delivered') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `total_amount` decimal(10,2) NOT NULL,
  `transaction_id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cancellation_reason` text COLLATE utf8mb4_unicode_ci,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `seller_id`, `address`, `phone`, `status`, `total_amount`, `transaction_id`, `cancellation_reason`, `cancelled_at`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'House No. 1391, Gulbahar No. 02, Karachi No.18', '03002924987', 'completed', '939.03', '2323232', NULL, NULL, '2025-04-07 05:48:02', '2025-04-07 05:49:33'),
(2, 17, 1, 'kldfsjldkjf', '28420348', 'completed', '41.03', '23432432', NULL, NULL, '2025-04-07 05:52:07', '2025-04-07 05:52:39'),
(3, 17, 1, 'testing', '3492997826', 'pickup_departed', '82.35', '555444', NULL, NULL, '2025-04-21 14:40:55', '2025-04-21 17:07:22'),
(4, 17, 2, 'testing', '0349299782', 'pickup_departed', '198.38', NULL, NULL, NULL, '2025-05-19 12:26:41', '2025-05-27 02:50:52'),
(5, 17, 1, 'gulbahar', '0349299782', 'accepted', '77.56', NULL, NULL, NULL, '2025-05-19 12:30:40', '2025-05-19 12:33:40'),
(6, 17, 1, 'gulbahar', '0349299782', 'cancelled', '82.60', NULL, 'jhkjhkjhkk', '2025-05-26 16:16:04', '2025-05-26 15:57:49', '2025-05-26 16:16:04'),
(7, 17, 1, 'gulbahar', '0349299782', 'cancelled', '54.00', NULL, 'Quited', '2025-05-26 16:02:06', '2025-05-26 15:59:14', '2025-05-26 16:02:06'),
(8, 17, 1, 'gulbahar', '0349299782', 'cancelled', '41.03', NULL, 'no homo bro', '2025-05-26 16:08:25', '2025-05-26 16:06:01', '2025-05-26 16:08:25'),
(9, 17, 1, 'gulbahar', '0349299782', 'cancelled', '54.00', NULL, 'pending cancel', '2025-05-26 16:42:08', '2025-05-26 16:33:27', '2025-05-26 16:42:08'),
(10, 17, 1, 'gulbahar', '0349299782', 'accepted', '77.56', NULL, NULL, NULL, '2025-05-27 01:16:24', '2025-05-27 01:17:14'),
(11, 17, 2, 'testing', '0349299782', 'pickup_departed', '15.30', NULL, NULL, NULL, '2025-05-27 01:59:26', '2025-05-27 02:03:16'),
(12, 17, 2, 'gulbahar', '0349299782', 'pickup_departed', '15.30', NULL, NULL, NULL, '2025-05-27 02:06:14', '2025-05-27 02:07:03'),
(13, 17, 1, 'gulbahar', '0349299782', 'pending', '82.60', NULL, NULL, NULL, '2025-05-27 02:49:41', '2025-05-27 02:49:41'),
(14, 1, 1, 'gulbahar', '0349299782', 'pickup_departed', '77.56', NULL, NULL, NULL, '2025-05-27 03:06:43', '2025-05-27 03:10:01');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint UNSIGNED NOT NULL,
  `order_id` bigint UNSIGNED NOT NULL,
  `service_id` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `service_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(5, 4, 9, 1, '95.29', '2025-05-19 12:26:41', '2025-05-19 12:26:41'),
(6, 4, 7, 1, '15.30', '2025-05-19 12:26:41', '2025-05-19 12:26:41'),
(7, 4, 8, 1, '87.79', '2025-05-19 12:26:41', '2025-05-19 12:26:41'),
(8, 5, 2, 1, '77.56', '2025-05-19 12:30:40', '2025-05-19 12:30:40'),
(9, 6, 5, 1, '82.60', '2025-05-26 15:57:49', '2025-05-26 15:57:49'),
(10, 7, 4, 1, '54.00', '2025-05-26 15:59:14', '2025-05-26 15:59:14'),
(12, 9, 4, 1, '54.00', '2025-05-26 16:33:27', '2025-05-26 16:33:27'),
(13, 10, 2, 1, '77.56', '2025-05-27 01:16:24', '2025-05-27 01:16:24'),
(14, 11, 7, 1, '15.30', '2025-05-27 01:59:26', '2025-05-27 01:59:26'),
(15, 12, 7, 1, '15.30', '2025-05-27 02:06:14', '2025-05-27 02:06:14'),
(16, 13, 5, 1, '82.60', '2025-05-27 02:49:41', '2025-05-27 02:49:41'),
(17, 14, 2, 1, '77.56', '2025-05-27 03:06:43', '2025-05-27 03:06:43');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sellers`
--

CREATE TABLE `sellers` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Path to seller profile image',
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'City where seller operates',
  `area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Area where seller operates',
  `accountIsApproved` int UNSIGNED NOT NULL COMMENT '1 for yes, 0 for no',
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `suspension_reason` text COLLATE utf8mb4_unicode_ci,
  `suspended_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sellers`
--

INSERT INTO `sellers` (`id`, `name`, `email`, `password`, `remember_token`, `profile_image`, `city`, `area`, `accountIsApproved`, `is_deleted`, `created_at`, `updated_at`, `is_suspended`, `suspended_at`, `suspension_reason`, `suspended_by`) VALUES
(1, 'Kameron Dooley', 'volkman.cielo@example.org', '$2y$12$SCusb7lzF7DaJo7RmRWPVO17eY5J2lJEu9Z/VLSPmb0q5e1gqpFQ2', 'h621n2zahB2FXl9ndY8TGBujjErEnL4xah2d88LANTQPKYl3WYhX47C7bejf', 'https://th.bing.com/th/id/OIP.Ucq6dUyuAOmhO-iQbhA4nwHaHC?cb=iwc2&rs=1&pid=ImgDetMain', 'Neldaport', 'Casper Knolls', 1, 0, '2025-04-07 05:45:34', '2025-05-26 19:21:46', 0, NULL, NULL, NULL),
(2, 'Bettie Grimes', 'lebsack.onie@example.org', '$2y$12$BAgzbpCt1pYz4/Gw19rO..H7jXVLhT7RhpnnnbKYTNvgwC0geGJLO', 'pcUV31yogoRjmLpWILwYXqHZYXsEi6ycx9kR25W0uV7EOVHT4SVxNRB2fK0W', 'https://media.istockphoto.com/id/1289220545/photo/beautiful-woman-smiling-with-crossed-arms.jpg?s=612x612&w=0&k=20&c=qmOTkGstKj1qN0zPVWj-n28oRA6_BHQN8uVLIXg0TF8=', 'Lavonneberg', 'Boehm Creek', 1, 0, '2025-04-07 05:45:34', '2025-04-07 05:45:34', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `seller_verifications`
--

CREATE TABLE `seller_verifications` (
  `id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `documents` json DEFAULT NULL COMMENT 'Paths to verification documents',
  `business_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `reason_for_verification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `rejection_reason` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `reviewed_by` bigint UNSIGNED DEFAULT NULL,
  `submitted_at` timestamp NULL DEFAULT NULL,
  `reviewed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint UNSIGNED NOT NULL,
  `seller_id` bigint UNSIGNED NOT NULL,
  `service_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seller_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_area` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_delivery_time` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `seller_contact_no` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `service_price` decimal(10,2) NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `seller_id`, `service_name`, `category`, `service_description`, `seller_city`, `seller_area`, `availability`, `service_delivery_time`, `seller_contact_no`, `service_price`, `image`, `is_approved`, `created_at`, `updated_at`) VALUES
(2, 1, 'Bulk Laundry', 'Dry Cleaning', 'Velit qui molestiae fuga impedit itaque dolores molestias. Quam fugit eum adipisci explicabo voluptates maiores. Voluptatem at ipsum molestiae vel quis.', 'New Maynardside', 'German Grove', '24/7', 'Same Day', '+1 (762) 334-2186', '77.56', 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(4, 1, 'Wash & Iron', 'Washing', 'Quae laudantium et aut impedit molestiae. Expedita sint rem adipisci ut et aut eos. Sit autem adipisci nihil et inventore in voluptas dolorem.', 'Ferryfurt', 'Lionel Highway', '24/7', 'Same Day', '+18484331117', '54.00', 'https://images.unsplash.com/photo-1610557892470-55d9e80c0bce', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(5, 1, 'Express Service', 'Pressing', 'Ab quis ex occaecati officia. Quo sequi voluptas qui officiis. Et sed incidunt sequi non commodi ut ratione. Harum molestias dicta voluptas vel iste omnis.', 'East Meda', 'Zachariah Ridges', 'Mon-Fri', '24 Hours', '317.415.9054', '82.60', 'https://images.unsplash.com/photo-1604335399105-a0c585fd81a1', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(6, 2, 'Wash & Iron', 'Washing', 'Qui consectetur aliquam temporibus ducimus voluptas qui qui. Ad ut temporibus harum quibusdam iure facilis tempora. Quia repellendus vitae et voluptas quo. Non aut nulla ut et cumque.', 'South Abigalefurt', 'Kemmer Lock', 'Weekends', '48 Hours', '754-971-9046', '34.10', 'https://images.unsplash.com/photo-1582735689369-4fe89db7114c', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(7, 2, 'Premium Wash', 'Washing', 'Ut omnis voluptatibus vel ex minima. Natus deserunt itaque veniam officia dicta iste. Est atque nostrum molestiae voluptates accusamus quod. Rem laborum suscipit eum et voluptas itaque.', 'Nolanfurt', 'Lauryn Gardens', '24/7', '72 Hours', '1-708-776-8010', '15.30', 'https://images.unsplash.com/photo-1517677208171-0bc6725a3e60', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(8, 2, 'Dry Cleaning', 'Dry Cleaning', 'Dolor quia fugiat dignissimos debitis. Nemo cupiditate dolore inventore est. Laudantium sequi ipsa ipsa illum exercitationem et repudiandae. Aliquam corporis delectus aut consequatur quibusdam distinctio temporibus.', 'West Rosendo', 'Libby Track', 'Weekends', '72 Hours', '+1-507-665-7910', '87.79', 'https://images.unsplash.com/photo-1610557892470-55d9e80c0bce', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(9, 2, 'Wash & Iron', 'Washing', 'Ut eos commodi est. Sit molestias omnis minus cumque. Et ut vero qui eius quos nobis.', 'Port Joy', 'Madisyn Vista', 'Mon-Sat', '48 Hours', '740.921.8605', '95.29', 'https://images.unsplash.com/photo-1545173168-9f1947eebb7f', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03'),
(10, 2, 'Iron Only', 'Ironing', 'In sint eaque et. Eos porro optio eius sequi. Sequi quia consectetur commodi.', 'West Jaceton', 'Ara Mountain', 'Mon-Sat', '72 Hours', '1-571-295-3598', '82.18', 'https://images.unsplash.com/photo-1610557892470-55d9e80c0bce', 1, '2025-04-07 05:45:35', '2025-05-26 19:37:03');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `sellerType` tinyint NOT NULL DEFAULT '2' COMMENT '1 for admin, 2 for buyer, 3 for seller',
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Mobile number of the user',
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Primary address line',
  `address2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Secondary address line (optional)',
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'City of residence',
  `state` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'State of residence',
  `zip` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Postal code',
  `pickup_time` enum('morning','afternoon','evening') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'Preferred pickup time',
  `is_verified` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indicates if the user has verified their email',
  `otp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'OTP for email verification',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `is_suspended` tinyint(1) NOT NULL DEFAULT '0',
  `suspended_at` timestamp NULL DEFAULT NULL,
  `suspension_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `suspended_by` bigint UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sellerType`, `name`, `email`, `email_verified_at`, `password`, `mobile`, `address`, `address2`, `city`, `state`, `zip`, `pickup_time`, `is_verified`, `otp`, `remember_token`, `created_at`, `updated_at`, `is_suspended`, `suspended_at`, `suspension_reason`, `suspended_by`) VALUES
(1, 1, 'Admin User', 'admin@laundrify.com', '2025-04-07 05:45:31', '$2y$12$Ti5oedxU2.T9vcu8czwqw.NQxxRDH9ZNN/8JOWRvfyYD2NsWU6MFG', '385.933.1262', '7059 Josiah Common Apt. 521', 'Apt. 267', 'Vernontown', 'Hawaii', '24273-4282', 'morning', 1, NULL, NULL, '2025-04-07 05:45:31', '2025-04-07 05:45:31', 0, NULL, NULL, NULL),
(2, 2, 'Ms. Carolanne Oberbrunner Jr.', 'rico.mcclure@example.org', '2025-04-07 05:45:31', '$2y$12$7Ogt.8Aqm3P47ipqasUGCeMQhPF9yuA1GWgGde1eKcv96gKbwxFSK', '+1-407-368-3719', '63885 Dooley Roads', 'Suite 153', 'Averychester', 'Connecticut', '75327-3701', 'evening', 1, '455208', NULL, '2025-04-07 05:45:31', '2025-04-07 05:45:31', 0, NULL, NULL, NULL),
(3, 2, 'Tianna Medhurst PhD', 'goldner.delphine@example.net', '2025-04-07 05:45:31', '$2y$12$ehkHdRbBdoj7aQWHElad0u1o..Qvd4YyTLBb2dXbA2BV/aRv9m.4u', '941-874-3932', '7846 Koelpin Loaf Suite 264', 'Suite 326', 'South Opal', 'Wisconsin', '75364-5222', 'afternoon', 1, '727581', NULL, '2025-04-07 05:45:31', '2025-04-07 05:45:31', 0, NULL, NULL, NULL),
(4, 2, 'Donavon King', 'stracke.gracie@example.net', '2025-04-07 05:45:31', '$2y$12$Xf2KdWiukfUQ3d6SIN9vmOlRWr38sMmAQF6LgENAnuk9eBvM5rBNu', '(929) 504-5184', '7774 Salvatore Circle Apt. 991', 'Suite 686', 'Lednerbury', 'Nevada', '29125', 'morning', 1, '992787', NULL, '2025-04-07 05:45:31', '2025-04-07 05:45:31', 0, NULL, NULL, NULL),
(5, 2, 'Silas Heidenreich', 'vryan@example.com', '2025-04-07 05:45:31', '$2y$12$WBdSCOGZhi7A.d/P7CXZRuS7I3d6mWptZ5m6Sfl/TaKO1W/AtIGl2', '774-436-4939', '86837 Alberto Wells Suite 580', 'Apt. 451', 'Londonfort', 'Alaska', '44580', 'morning', 1, '122838', NULL, '2025-04-07 05:45:32', '2025-04-07 05:45:32', 0, NULL, NULL, NULL),
(6, 2, 'Xander Hodkiewicz', 'gardner37@example.org', '2025-04-07 05:45:32', '$2y$12$TUEg8Cr79F4SQ3iLXrYku.ZPX/aFz/UjdwK9dYC54vvG3oowzex8u', '620-709-2351', '714 Myrl Hollow Apt. 564', 'Suite 970', 'North Antonetta', 'Washington', '84044-8159', 'evening', 0, '957174', NULL, '2025-04-07 05:45:32', '2025-04-07 05:45:32', 0, NULL, NULL, NULL),
(7, 2, 'Ms. Taya Reynolds', 'charity.braun@example.com', '2025-04-07 05:45:32', '$2y$12$rtJoTHgZGUECoXnWnqDmVus4aQvc1kiCK7rMyjGokgWfzkEGYkDqa', '+1-339-501-3319', '70318 Felicia Pike', 'Suite 567', 'South Stacy', 'Minnesota', '30571-1405', 'evening', 0, '418576', NULL, '2025-04-07 05:45:32', '2025-04-07 05:45:32', 0, NULL, NULL, NULL),
(8, 2, 'Raegan Nicolas', 'murray.irma@example.org', '2025-04-07 05:45:32', '$2y$12$4tH9r7EWf0VTdCD3LoygTOLVJ4ILz7AGdo/htoX8333OoO.rSwAd2', '+1.661.306.4373', '26858 Hunter Trafficway', 'Apt. 665', 'North Jammie', 'Wisconsin', '78313-8107', 'afternoon', 1, '366494', NULL, '2025-04-07 05:45:32', '2025-04-07 05:45:32', 0, NULL, NULL, NULL),
(9, 2, 'Selena Schmidt DVM', 'emclaughlin@example.com', '2025-04-07 05:45:32', '$2y$12$PPTqVi71zzcmc2cbgF1z3eo.kzMvPRSeFfGBTJ5OwASdt2hshCe0y', '+14843521748', '93063 Keira Port Suite 096', 'Suite 427', 'Ulicesside', 'Colorado', '09105', 'evening', 0, '257173', NULL, '2025-04-07 05:45:32', '2025-04-07 05:45:32', 0, NULL, NULL, NULL),
(10, 2, 'Mr. Estevan Bailey Sr.', 'erice@example.net', '2025-04-07 05:45:32', '$2y$12$dghqbz1IrkOEDkL/o8moeeLZqIX/ASJzV0SXsx.DxSs1TbmxrABLW', '1-971-721-0605', '851 Terence Island', 'Apt. 647', 'South Jules', 'Mississippi', '41456-5185', 'evening', 0, '816999', NULL, '2025-04-07 05:45:32', '2025-04-07 05:45:32', 0, NULL, NULL, NULL),
(11, 2, 'Delilah Jerde', 'daugherty.giovanni@example.org', '2025-04-07 05:45:32', '$2y$12$3xq3pATBY7UkVcpqn1BDNuGybdNlAZBv/OiYbaJjHb2yzFFpM/j7K', '1-347-631-4707', '68010 Dibbert Squares Apt. 958', 'Suite 649', 'South Ansleyside', 'Kentucky', '33361-3241', 'afternoon', 1, '772286', NULL, '2025-04-07 05:45:33', '2025-04-07 05:45:33', 0, NULL, NULL, NULL),
(12, 3, 'Schowalter-Gaylord', 'mmueller@jast.com', '2025-04-07 05:45:33', '$2y$12$BzTYYnNWmyDRSD.G.6Q/sOJFRKc5uTfjWHCc7TLAwY.Ao9ZpEVfTu', '(929) 291-5663', '43933 Littel Isle Suite 839', 'Suite 687', 'Selmerburgh', 'Pennsylvania', '97743-2874', NULL, 1, NULL, NULL, '2025-04-07 05:45:33', '2025-04-07 05:45:33', 0, NULL, NULL, NULL),
(13, 3, 'Trantow, Willms and Jacobson', 'jacobi.ocie@leffler.com', '2025-04-07 05:45:33', '$2y$12$7qN.AKWjNSEVR87hcgDhd.pXkesYX9K3/Ak7S4piDAWuMZnM99Iym', '+17206259171', '18001 Reichel Stream', 'Suite 293', 'Kesslerton', 'Washington', '79654-0718', NULL, 1, NULL, NULL, '2025-04-07 05:45:33', '2025-04-07 05:45:33', 0, NULL, NULL, NULL),
(14, 3, 'Gaylord Ltd', 'deonte36@bergstrom.com', '2025-04-07 05:45:33', '$2y$12$xApcmBhyyUYRYmQJ1BRvB.faaIFuu3XGmY4s1L9CUmko.rgkjsDh2', '(682) 523-4543', '6886 Elmira Village Suite 894', 'Apt. 149', 'Camrenland', 'Illinois', '09372-1290', NULL, 1, NULL, NULL, '2025-04-07 05:45:33', '2025-04-07 05:45:33', 0, NULL, NULL, NULL),
(15, 3, 'Zieme, Borer and King', 'perry60@halvorson.com', '2025-04-07 05:45:33', '$2y$12$racpB0H5iGMyup8V8DDgIuV9jXIVt3wB2tYS9Yyzjj3DmE/fRG8Qu', '+1 (732) 894-5768', '1902 Bauch Shoals Apt. 115', 'Apt. 088', 'McLaughlinmouth', 'New Jersey', '76722-6604', NULL, 1, NULL, NULL, '2025-04-07 05:45:33', '2025-04-07 05:45:33', 0, NULL, NULL, NULL),
(16, 3, 'Paucek and Sons', 'ethyl.crist@botsford.com', '2025-04-07 05:45:33', '$2y$12$Yw7sBfvwET/gwbwIeoEaiu2ZgoTM/RMTdGtoxNZgQLwLtqS8/qGsK', '+1.424.705.5321', '4502 Waters Park', 'Suite 572', 'East Marguerite', 'Illinois', '13413', NULL, 1, NULL, NULL, '2025-04-07 05:45:34', '2025-04-07 05:45:34', 0, NULL, NULL, NULL),
(17, 2, 'Anas', 'anas@gmail.com', NULL, '$2y$12$jEbAO5lQS0Ltvf5/DrOUDOl960skDUsdbOxMyud7qpNNJ/qOgP5nW', '15151515151', 'kldfsjldkjf', NULL, 'Karachi', 'Sindh', '787878', 'evening', 1, NULL, NULL, '2025-04-07 05:51:08', '2025-05-26 19:00:30', 0, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile_updates`
--

CREATE TABLE `user_profile_updates` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `profile_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `favorites_user_id_service_id_unique` (`user_id`,`service_id`),
  ADD KEY `favorites_service_id_foreign` (`service_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `feedback_order_id_foreign` (`order_id`),
  ADD KEY `feedback_user_id_foreign` (`user_id`),
  ADD KEY `feedback_seller_id_foreign` (`seller_id`);

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
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `messages_order_id_foreign` (`order_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`),
  ADD KEY `orders_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_service_id_foreign` (`service_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sellers`
--
ALTER TABLE `sellers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `sellers_email_unique` (`email`),
  ADD KEY `sellers_suspended_by_foreign` (`suspended_by`);

--
-- Indexes for table `seller_verifications`
--
ALTER TABLE `seller_verifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `seller_verifications_seller_id_foreign` (`seller_id`),
  ADD KEY `seller_verifications_reviewed_by_foreign` (`reviewed_by`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `services_seller_id_foreign` (`seller_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_suspended_by_foreign` (`suspended_by`);

--
-- Indexes for table `user_profile_updates`
--
ALTER TABLE `user_profile_updates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_profile_updates_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `sellers`
--
ALTER TABLE `sellers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `seller_verifications`
--
ALTER TABLE `seller_verifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_profile_updates`
--
ALTER TABLE `user_profile_updates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_service_id_foreign` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `sellers`
--
ALTER TABLE `sellers`
  ADD CONSTRAINT `sellers_suspended_by_foreign` FOREIGN KEY (`suspended_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `seller_verifications`
--
ALTER TABLE `seller_verifications`
  ADD CONSTRAINT `seller_verifications_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `seller_verifications_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `services`
--
ALTER TABLE `services`
  ADD CONSTRAINT `services_seller_id_foreign` FOREIGN KEY (`seller_id`) REFERENCES `sellers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_suspended_by_foreign` FOREIGN KEY (`suspended_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `user_profile_updates`
--
ALTER TABLE `user_profile_updates`
  ADD CONSTRAINT `user_profile_updates_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
