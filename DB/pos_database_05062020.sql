-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2020 at 11:38 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `activity` varchar(55) DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `user_id`, `activity`, `datetime`, `bussiness_id`) VALUES
(1, 5, 'Login', '2020-04-05 03:08:23', 1),
(2, 5, 'Login', '2020-04-05 03:57:51', 1),
(3, 5, 'Login', '2020-04-05 05:46:17', 1),
(4, 5, 'Logout', '2020-04-05 05:49:03', 1),
(5, 5, 'Login', '2020-04-05 05:49:29', NULL),
(6, 5, 'Login', '2020-04-07 09:14:05', NULL),
(7, 5, 'Login', '2020-04-08 07:11:41', NULL),
(8, 5, 'Login', '2020-04-11 10:07:53', NULL),
(9, 5, 'Login', '2020-04-12 10:28:38', NULL),
(10, 5, 'Login', '2020-04-15 09:59:26', NULL),
(11, 5, 'Login', '2020-04-20 07:55:31', NULL),
(12, 5, 'Login', '2020-04-22 06:46:15', NULL),
(13, 5, 'Login', '2020-05-07 03:37:51', NULL),
(14, 5, 'Login', '2020-05-10 06:53:35', NULL),
(15, 5, 'Login', '2020-05-17 08:02:19', NULL),
(16, 5, 'Login', '2020-05-17 04:21:10', NULL),
(17, 5, 'Login', '2020-05-22 11:04:58', NULL),
(18, 5, 'Login', '2020-05-23 10:04:54', NULL),
(19, 5, 'Login', '2020-05-25 02:14:40', NULL),
(20, 5, 'Login', '2020-05-25 04:19:14', NULL),
(21, 5, 'Logout', '2020-05-25 07:05:27', NULL),
(22, 12, 'Login', '2020-05-25 07:05:29', 1),
(23, 12, 'Logout', '2020-05-25 07:05:45', 1),
(24, 5, 'Login', '2020-05-25 07:05:51', NULL),
(25, 5, 'Login', '2020-05-28 07:52:40', NULL),
(26, 5, 'Logout', '2020-05-28 08:42:16', NULL),
(27, 12, 'Login', '2020-05-28 08:42:19', 1),
(28, 5, 'Login', '2020-05-30 10:08:57', NULL),
(29, 5, 'Login', '2020-05-31 07:54:07', NULL),
(30, 5, 'Login', '2020-06-01 07:44:58', NULL),
(31, 5, 'Login', '2020-06-03 07:00:24', NULL),
(32, 5, 'Login', '2020-06-05 12:17:56', NULL),
(33, 5, 'Logout', '2020-06-05 07:59:56', NULL),
(34, 12, 'Login', '2020-06-05 07:59:59', NULL),
(35, 12, 'Logout', '2020-06-05 08:00:11', NULL),
(36, 5, 'Login', '2020-06-05 08:00:15', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `adjustments`
--

CREATE TABLE `adjustments` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `adjustment_items`
--

CREATE TABLE `adjustment_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `adjustment_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `adjustment` int(11) NOT NULL,
  `diff` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `bookings` varchar(500) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `payment_status` enum('Pending','Paid','Cancelled') NOT NULL DEFAULT 'Pending',
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `amount` double(10,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `booking_types`
--

CREATE TABLE `booking_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double(10,2) NOT NULL,
  `qty` int(1) NOT NULL DEFAULT 0,
  `hourly_price` double(10,2) NOT NULL DEFAULT 0.00,
  `hours` int(11) NOT NULL DEFAULT 1,
  `type` enum('fixed','hourly') NOT NULL,
  `available` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bussinesses`
--

CREATE TABLE `bussinesses` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bussinesses`
--

INSERT INTO `bussinesses` (`id`, `userId`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 5, 'Restaurant Aktiva', 'Restaurant Aktiva, ul kosovska brigada', '2020-05-25 20:19:48', '2020-05-25 20:31:59'),
(2, 5, 'Restaurant Kapri', 'Restaurant Kapri, ul kosovska brigada', '2020-05-25 20:44:30', '2020-05-25 20:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `bussiness_user`
--

CREATE TABLE `bussiness_user` (
  `user_id` int(11) NOT NULL,
  `bussiness_id` int(11) NOT NULL,
  `bussiness_role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `bussiness_user`
--

INSERT INTO `bussiness_user` (`user_id`, `bussiness_id`, `bussiness_role`) VALUES
(5, 1, 1),
(15, 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `updated_at`, `created_at`, `bussiness_id`) VALUES
(4, 'Cafetería', '2018-12-11 17:59:15', '2018-12-11 17:59:15', 1),
(5, 'Cafetería especial', '2018-12-11 18:00:36', '2018-12-11 18:00:36', NULL),
(6, 'Pije', '2020-04-11 10:15:08', '2018-12-11 18:00:57', 1),
(7, 'Licuados', '2018-12-11 18:01:12', '2018-12-11 18:01:12', 1),
(8, 'Aperitivos', '2018-12-11 18:01:27', '2018-12-11 18:01:27', 1),
(9, 'Sándwiches fríos', '2018-12-11 18:01:56', '2018-12-11 18:01:56', 1),
(10, 'Bebidas Con Alcohol', '2018-12-11 18:02:24', '2018-12-11 18:02:24', 1),
(11, 'Picadas', '2018-12-14 18:45:51', '2018-12-14 18:45:51', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `neighborhood` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `address`, `neighborhood`, `created_at`, `updated_at`, `deleted_at`, `comments`, `bussiness_id`) VALUES
(1, 'Berat Sulimani', 'berat@hotmail.com', NULL, '071444555', 'Skopje', NULL, NULL, '2020-05-23 09:31:14', NULL, 'test', NULL),
(9, 'Suad', 'suad@hotmail.com', NULL, '071444600', 'Skopje', NULL, NULL, NULL, NULL, 'test', NULL),
(10, 'Agron', 'agron@live.com', '$2y$10$qPipryZr9ZfPOC.zLTYtteQaUB.wnlFxNojwM9fVtIXfjEiQbMIPG', '070555888', 'Skopje', NULL, NULL, NULL, NULL, 'Agron mafia', NULL),
(12, 'Florent', 'florent@hotmail.com', '$2y$10$Dp5EdwV.ONtPdfC7EK/FHuKOTEFwOfuqUd1vnLFf9vbbkgvvJ0K3W', '070111222', 'Fejzula', NULL, NULL, NULL, NULL, 'My koment', 1);

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL,
  `price` double(10,2) DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`id`, `title`, `description`, `created_at`, `updated_at`, `price`, `bussiness_id`) VALUES
(1, 'Expense', 'Expense test', '2020-06-05 18:10:25', NULL, 20.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `hold_order`
--

CREATE TABLE `hold_order` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `table_id` int(11) DEFAULT NULL,
  `comment` varchar(255) DEFAULT NULL,
  `cart` text DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hold_order`
--

INSERT INTO `hold_order` (`id`, `user_id`, `table_id`, `comment`, `cart`, `status`, `created_at`, `bussiness_id`) VALUES
(1, 5, 1, NULL, '[{\"id\":\"70\",\"product_id\":\"7\",\"price\":\"80\",\"size\":null,\"name\":\"Nescafe cold ()\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 1, '2020-04-15 22:00:49', NULL),
(2, 5, 1, NULL, '[{\"id\":\"10\",\"product_id\":\"1\",\"price\":\"180\",\"size\":null,\"name\":\"Pizza ()\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 1, '2020-05-07 16:17:58', NULL),
(3, 5, 1, NULL, '[{\"id\":\"30\",\"product_id\":\"3\",\"price\":\"120\",\"size\":null,\"name\":\"Lahmachun ()\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 1, '2020-05-17 09:18:13', NULL),
(4, 5, 1, NULL, '[{\"id\":\"40\",\"product_id\":\"4\",\"price\":\"160\",\"size\":null,\"name\":\"Pide ()\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 1, '2020-05-17 09:22:10', NULL),
(5, 5, 1, NULL, '[{\"id\":\"40\",\"product_id\":\"4\",\"price\":\"160\",\"size\":null,\"name\":\"Pide ()\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 1, '2020-05-17 09:23:00', NULL),
(6, 5, 8, NULL, '[{\"id\":\"50\",\"product_id\":\"5\",\"price\":\"100\",\"size\":\"Big\",\"name\":\"Macchiato (Big)\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 0, '2020-05-23 11:22:11', NULL),
(7, 5, 15, NULL, '[{\"id\":\"10\",\"product_id\":\"1\",\"price\":\"180\",\"size\":null,\"name\":\"Pizza ()\",\"quantity\":\"1\",\"p_qty\":\"1\"}]', 1, '2020-06-05 18:36:31', 1);

-- --------------------------------------------------------

--
-- Table structure for table `homepage`
--

CREATE TABLE `homepage` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `label` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `homepage`
--

INSERT INTO `homepage` (`id`, `key`, `type`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'story_title', 'text', 'Story Title', '<span>Discover</span>Our Story', NULL, '2017-09-20 16:13:04'),
(2, 'story_desc', 'textarea', 'Story Description', 'accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.', NULL, '2017-09-20 16:13:04'),
(3, 'menu_title', 'text', 'Menu Title', '<span>Discover</span>Our Menu', NULL, '2017-09-20 16:13:04'),
(4, 'menu_desc', 'textarea', 'Menu Description', 'accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est.', NULL, '2017-09-20 16:13:04'),
(5, 'img_title1', 'text', 'Image Title 1', '<h2><span>We Are Sharing</span></h2>                    <h1>delicious treats</h1>', NULL, '2017-09-25 16:36:13'),
(6, 'img_title2', 'text', 'Image Title 2', '<h2><span>The Perfect</span></h2>                    <h1>Blend</h1>', NULL, '2017-09-25 16:36:13'),
(7, 'category', NULL, 'Home Categories', '4', NULL, '2020-04-07 20:15:34');

-- --------------------------------------------------------

--
-- Table structure for table `inventories`
--

CREATE TABLE `inventories` (
  `id` int(10) UNSIGNED NOT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `track_type` varchar(55) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `comments` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `storeroom` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ltm_translations`
--

CREATE TABLE `ltm_translations` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ltm_translations`
--

INSERT INTO `ltm_translations` (`id`, `status`, `locale`, `group`, `key`, `value`, `created_at`, `updated_at`) VALUES
(862, 0, 'en', 'auth', 'failed', 'These credentials do not match our records.', '2018-01-31 06:10:18', '2018-01-31 06:16:58'),
(863, 0, 'en', 'auth', 'throttle', 'Too many login attempts. Please try again in :seconds seconds.', '2018-01-31 06:10:18', '2018-01-31 06:16:58'),
(864, 0, 'en', 'common', 'home', 'Home', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(865, 0, 'en', 'common', 'add', 'Add', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(866, 0, 'en', 'common', 'add_new', 'Add New', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(867, 0, 'en', 'common', 'edit', 'Edit', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(868, 0, 'en', 'common', 'save', 'Save', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(869, 0, 'en', 'common', 'cancel', 'Cancel', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(870, 0, 'en', 'common', 'name', 'Name', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(871, 0, 'en', 'common', 'category', 'Category', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(872, 0, 'en', 'common', 'categories', 'Categories', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(873, 0, 'en', 'common', 'product', 'Product', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(874, 0, 'en', 'common', 'products', 'Products', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(875, 0, 'en', 'common', 'description', 'Description', '2018-01-31 06:10:18', '2018-01-31 06:26:25'),
(876, 0, 'en', 'common', 'delete', 'Delete', '2018-01-31 06:10:19', '2018-01-31 06:26:25'),
(877, 0, 'en', 'common', 'no_record_found', 'No Record Found', '2018-01-31 06:10:19', '2018-01-31 06:26:25'),
(878, 0, 'en', 'dashboard', 'today', 'Today', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(879, 0, 'en', 'dashboard', 'yesterday', 'Yesterday', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(880, 0, 'en', 'dashboard', '7_days', 'Last 7 Days', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(881, 0, 'en', 'dashboard', '30_days', 'Last 30 Days', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(882, 0, 'en', 'dashboard', '12_month', 'Last 12 Month', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(883, 0, 'en', 'dashboard', 'total_sales', 'Total Sales', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(884, 0, 'en', 'dashboard', 'last_pos_sales', 'Last 10 POS Sales', '2018-01-31 06:10:19', '2018-01-31 06:16:59'),
(885, 0, 'en', 'dashboard', 'top_10_items', 'Top 10 Sale Items', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(886, 0, 'en', 'dashboard', 'product_name', 'Product Name', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(887, 0, 'en', 'dashboard', 'sales', 'Sales', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(888, 0, 'en', 'dashboard', 'sales_date', 'Sales Date', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(889, 0, 'en', 'dashboard', 'discount', 'Discount', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(890, 0, 'en', 'dashboard', 'total_amount', 'Total Amount', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(891, 0, 'en', 'dashboard', 'status', 'Status', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(892, 0, 'en', 'dashboard', 'show', 'Show', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(893, 0, 'en', 'login', 'login', 'Login', '2018-01-31 06:10:19', '2018-01-31 06:26:12'),
(894, 0, 'en', 'login', 'login_text', 'Login in. To see it in action', '2018-01-31 06:10:19', '2018-01-31 06:26:12'),
(895, 0, 'en', 'pagination', 'previous', '&laquo; Previous', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(896, 0, 'en', 'pagination', 'next', 'Next &raquo;', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(897, 0, 'en', 'passwords', 'password', 'Passwords must be at least six characters and match the confirmation.', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(898, 0, 'en', 'passwords', 'reset', 'Your password has been reset!', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(899, 0, 'en', 'passwords', 'sent', 'We have e-mailed your password reset link!', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(900, 0, 'en', 'passwords', 'token', 'This password reset token is invalid.', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(901, 0, 'en', 'passwords', 'user', 'We can\'t find a user with that e-mail address.', '2018-01-31 06:10:19', '2018-01-31 06:17:00'),
(902, 0, 'en', 'pos', 'cart_items', 'Cart Items', '2018-01-31 06:10:20', '2018-01-31 06:17:00'),
(903, 0, 'en', 'pos', 'sub_total', 'Sub Total', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(904, 0, 'en', 'pos', 'total', 'Total', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(905, 0, 'en', 'pos', 'checkout', 'Checkout', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(906, 0, 'en', 'pos', 'clear_cart', 'Clear Cart', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(907, 0, 'en', 'pos', 'how_would_you_pay', 'How would you like to pay?', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(908, 0, 'en', 'pos', 'discount', 'Discount', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(909, 0, 'en', 'pos', 'tax', 'Tax', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(910, 0, 'en', 'pos', 'complete_order', 'Complete Order', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(911, 0, 'en', 'validation', 'accepted', 'The :attribute must be accepted.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(912, 0, 'en', 'validation', 'active_url', 'The :attribute is not a valid URL.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(913, 0, 'en', 'validation', 'after', 'The :attribute must be a date after :date.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(914, 0, 'en', 'validation', 'after_or_equal', 'The :attribute must be a date after or equal to :date.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(915, 0, 'en', 'validation', 'alpha', 'The :attribute may only contain letters.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(916, 0, 'en', 'validation', 'alpha_dash', 'The :attribute may only contain letters, numbers, and dashes.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(917, 0, 'en', 'validation', 'alpha_num', 'The :attribute may only contain letters and numbers.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(918, 0, 'en', 'validation', 'array', 'The :attribute must be an array.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(919, 0, 'en', 'validation', 'before', 'The :attribute must be a date before :date.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(920, 0, 'en', 'validation', 'before_or_equal', 'The :attribute must be a date before or equal to :date.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(921, 0, 'en', 'validation', 'between.numeric', 'The :attribute must be between :min and :max.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(922, 0, 'en', 'validation', 'between.file', 'The :attribute must be between :min and :max kilobytes.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(923, 0, 'en', 'validation', 'between.string', 'The :attribute must be between :min and :max characters.', '2018-01-31 06:10:20', '2018-01-31 06:17:01'),
(924, 0, 'en', 'validation', 'between.array', 'The :attribute must have between :min and :max items.', '2018-01-31 06:10:20', '2018-01-31 06:17:02'),
(925, 0, 'en', 'validation', 'boolean', 'The :attribute field must be true or false.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(926, 0, 'en', 'validation', 'confirmed', 'The :attribute confirmation does not match.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(927, 0, 'en', 'validation', 'date', 'The :attribute is not a valid date.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(928, 0, 'en', 'validation', 'date_format', 'The :attribute does not match the format :format.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(929, 0, 'en', 'validation', 'different', 'The :attribute and :other must be different.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(930, 0, 'en', 'validation', 'digits', 'The :attribute must be :digits digits.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(931, 0, 'en', 'validation', 'digits_between', 'The :attribute must be between :min and :max digits.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(932, 0, 'en', 'validation', 'dimensions', 'The :attribute has invalid image dimensions.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(933, 0, 'en', 'validation', 'distinct', 'The :attribute field has a duplicate value.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(934, 0, 'en', 'validation', 'email', 'The :attribute must be a valid email address.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(935, 0, 'en', 'validation', 'exists', 'The selected :attribute is invalid.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(936, 0, 'en', 'validation', 'file', 'The :attribute must be a file.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(937, 0, 'en', 'validation', 'filled', 'The :attribute field must have a value.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(938, 0, 'en', 'validation', 'image', 'The :attribute must be an image.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(939, 0, 'en', 'validation', 'in', 'The selected :attribute is invalid.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(940, 0, 'en', 'validation', 'in_array', 'The :attribute field does not exist in :other.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(941, 0, 'en', 'validation', 'integer', 'The :attribute must be an integer.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(942, 0, 'en', 'validation', 'ip', 'The :attribute must be a valid IP address.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(943, 0, 'en', 'validation', 'ipv4', 'The :attribute must be a valid IPv4 address.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(944, 0, 'en', 'validation', 'ipv6', 'The :attribute must be a valid IPv6 address.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(945, 0, 'en', 'validation', 'json', 'The :attribute must be a valid JSON string.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(946, 0, 'en', 'validation', 'max.numeric', 'The :attribute may not be greater than :max.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(947, 0, 'en', 'validation', 'max.file', 'The :attribute may not be greater than :max kilobytes.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(948, 0, 'en', 'validation', 'max.string', 'The :attribute may not be greater than :max characters.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(949, 0, 'en', 'validation', 'max.array', 'The :attribute may not have more than :max items.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(950, 0, 'en', 'validation', 'mimes', 'The :attribute must be a file of type: :values.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(951, 0, 'en', 'validation', 'mimetypes', 'The :attribute must be a file of type: :values.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(952, 0, 'en', 'validation', 'min.numeric', 'The :attribute must be at least :min.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(953, 0, 'en', 'validation', 'min.file', 'The :attribute must be at least :min kilobytes.', '2018-01-31 06:10:21', '2018-01-31 06:17:02'),
(954, 0, 'en', 'validation', 'min.string', 'The :attribute must be at least :min characters.', '2018-01-31 06:10:21', '2018-01-31 06:17:03'),
(955, 0, 'en', 'validation', 'min.array', 'The :attribute must have at least :min items.', '2018-01-31 06:10:21', '2018-01-31 06:17:03'),
(956, 0, 'en', 'validation', 'not_in', 'The selected :attribute is invalid.', '2018-01-31 06:10:21', '2018-01-31 06:17:03'),
(957, 0, 'en', 'validation', 'numeric', 'The :attribute must be a number.', '2018-01-31 06:10:21', '2018-01-31 06:17:03'),
(958, 0, 'en', 'validation', 'present', 'The :attribute field must be present.', '2018-01-31 06:10:21', '2018-01-31 06:17:03'),
(959, 0, 'en', 'validation', 'regex', 'The :attribute format is invalid.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(960, 0, 'en', 'validation', 'required', 'The :attribute field is required.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(961, 0, 'en', 'validation', 'required_if', 'The :attribute field is required when :other is :value.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(962, 0, 'en', 'validation', 'required_unless', 'The :attribute field is required unless :other is in :values.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(963, 0, 'en', 'validation', 'required_with', 'The :attribute field is required when :values is present.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(964, 0, 'en', 'validation', 'required_with_all', 'The :attribute field is required when :values is present.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(965, 0, 'en', 'validation', 'required_without', 'The :attribute field is required when :values is not present.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(966, 0, 'en', 'validation', 'required_without_all', 'The :attribute field is required when none of :values are present.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(967, 0, 'en', 'validation', 'same', 'The :attribute and :other must match.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(968, 0, 'en', 'validation', 'size.numeric', 'The :attribute must be :size.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(969, 0, 'en', 'validation', 'size.file', 'The :attribute must be :size kilobytes.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(970, 0, 'en', 'validation', 'size.string', 'The :attribute must be :size characters.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(971, 0, 'en', 'validation', 'size.array', 'The :attribute must contain :size items.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(972, 0, 'en', 'validation', 'string', 'The :attribute must be a string.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(973, 0, 'en', 'validation', 'timezone', 'The :attribute must be a valid zone.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(974, 0, 'en', 'validation', 'unique', 'The :attribute has already been taken.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(975, 0, 'en', 'validation', 'uploaded', 'The :attribute failed to upload.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(976, 0, 'en', 'validation', 'url', 'The :attribute format is invalid.', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(977, 0, 'en', 'validation', 'custom.attribute-name.rule-name', 'custom-message', '2018-01-31 06:10:22', '2018-01-31 06:17:03'),
(978, 1, 'es', 'auth', 'failed', 'Estas credenciales no coinciden con nuestros registros.', '2018-01-31 06:17:03', '2018-01-31 06:17:03'),
(979, 1, 'es', 'auth', 'throttle', 'Demasiados intentos de acceso. Por favor intente nuevamente en :seconds segundos.', '2018-01-31 06:17:03', '2018-01-31 06:17:03'),
(980, 0, 'es', 'common', 'home', 'Home', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(981, 0, 'es', 'common', 'add', 'Add', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(982, 0, 'es', 'common', 'add_new', 'Add New', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(983, 0, 'es', 'common', 'edit', 'Edit', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(984, 0, 'es', 'common', 'save', 'Save', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(985, 0, 'es', 'common', 'cancel', 'Cancel', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(986, 0, 'es', 'common', 'name', 'Name', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(987, 0, 'es', 'common', 'category', 'Category', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(988, 0, 'es', 'common', 'categories', 'Categories', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(989, 0, 'es', 'common', 'product', 'Product', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(990, 0, 'es', 'common', 'products', 'Products', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(991, 0, 'es', 'common', 'description', 'Description', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(992, 0, 'es', 'common', 'delete', 'Delete', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(993, 0, 'es', 'common', 'no_record_found', 'No Record Found', '2018-01-31 06:17:04', '2018-01-31 06:26:25'),
(994, 1, 'es', 'dashboard', 'today', 'Today', '2018-01-31 06:17:04', '2018-01-31 06:17:04'),
(995, 1, 'es', 'dashboard', 'yesterday', 'Yesterday', '2018-01-31 06:17:04', '2018-01-31 06:17:04'),
(996, 1, 'es', 'dashboard', '7_days', 'Last 7 Days', '2018-01-31 06:17:04', '2018-01-31 06:17:04'),
(997, 1, 'es', 'dashboard', '30_days', 'Last 30 Days', '2018-01-31 06:17:04', '2018-01-31 06:17:04'),
(998, 1, 'es', 'dashboard', '12_month', 'Last 12 Month', '2018-01-31 06:17:04', '2018-01-31 06:17:04'),
(999, 1, 'es', 'dashboard', 'total_sales', 'Total Sales', '2018-01-31 06:17:04', '2018-01-31 06:17:04'),
(1000, 1, 'es', 'dashboard', 'last_pos_sales', 'Last 10 POS Sales', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1001, 1, 'es', 'dashboard', 'top_10_items', 'Top 10 Sale Items', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1002, 1, 'es', 'dashboard', 'product_name', 'Product Name', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1003, 1, 'es', 'dashboard', 'sales', 'Sales', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1004, 1, 'es', 'dashboard', 'sales_date', 'Sales Date', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1005, 1, 'es', 'dashboard', 'discount', 'Discount', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1006, 1, 'es', 'dashboard', 'total_amount', 'Total Amount', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1007, 1, 'es', 'dashboard', 'status', 'Status', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1008, 1, 'es', 'dashboard', 'show', 'Show', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1009, 0, 'es', 'login', 'login', 'Login', '2018-01-31 06:17:05', '2018-01-31 06:26:12'),
(1010, 0, 'es', 'login', 'login_text', 'Login in. To see it in action', '2018-01-31 06:17:05', '2018-01-31 06:26:12'),
(1011, 1, 'es', 'pagination', 'previous', '&laquo; Anterior', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1012, 1, 'es', 'pagination', 'next', 'Siguiente &raquo;', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1013, 1, 'es', 'passwords', 'password', 'Las contraseñas deben coincidir y contener al menos 6 caracteres', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1014, 1, 'es', 'passwords', 'reset', '¡Tu contraseña ha sido restablecida!', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1015, 1, 'es', 'passwords', 'sent', '¡Te hemos enviado por correo el enlace para restablecer tu contraseña!', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1016, 1, 'es', 'passwords', 'token', 'El token de recuperación de contraseña es inválido.', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1017, 1, 'es', 'passwords', 'user', 'No podemos encontrar ningún usuario con ese correo electrónico.', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1018, 1, 'es', 'pos', 'cart_items', 'Cart Items', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1019, 1, 'es', 'pos', 'sub_total', 'Sub Total', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1020, 1, 'es', 'pos', 'total', 'Total', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1021, 1, 'es', 'pos', 'checkout', 'Checkout', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1022, 1, 'es', 'pos', 'clear_cart', 'Clear Cart', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1023, 1, 'es', 'pos', 'how_would_you_pay', 'How would you like to pay?', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1024, 1, 'es', 'pos', 'discount', 'Discount', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1025, 1, 'es', 'pos', 'tax', 'Tax', '2018-01-31 06:17:05', '2018-01-31 06:17:05'),
(1026, 1, 'es', 'pos', 'complete_order', 'Complete Order', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1027, 1, 'es', 'validation', 'accepted', ':attribute debe ser aceptado.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1028, 1, 'es', 'validation', 'active_url', ':attribute no es una URL válida.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1029, 1, 'es', 'validation', 'after', ':attribute debe ser una fecha posterior a :date.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1030, 1, 'es', 'validation', 'after_or_equal', ':attribute debe ser una fecha posterior o igual a :date.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1031, 1, 'es', 'validation', 'alpha', ':attribute sólo debe contener letras.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1032, 1, 'es', 'validation', 'alpha_dash', ':attribute sólo debe contener letras, números y guiones.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1033, 1, 'es', 'validation', 'alpha_num', ':attribute sólo debe contener letras y números.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1034, 1, 'es', 'validation', 'array', ':attribute debe ser un conjunto.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1035, 1, 'es', 'validation', 'before', ':attribute debe ser una fecha anterior a :date.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1036, 1, 'es', 'validation', 'before_or_equal', ':attribute debe ser una fecha anterior o igual a :date.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1037, 1, 'es', 'validation', 'between.numeric', ':attribute tiene que estar entre :min - :max.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1038, 1, 'es', 'validation', 'between.file', ':attribute debe pesar entre :min - :max kilobytes.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1039, 1, 'es', 'validation', 'between.string', ':attribute tiene que tener entre :min - :max caracteres.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1040, 1, 'es', 'validation', 'between.array', ':attribute tiene que tener entre :min - :max ítems.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1041, 1, 'es', 'validation', 'boolean', 'El campo :attribute debe tener un valor verdadero o falso.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1042, 1, 'es', 'validation', 'confirmed', 'La confirmación de :attribute no coincide.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1043, 1, 'es', 'validation', 'date', ':attribute no es una fecha válida.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1044, 1, 'es', 'validation', 'date_format', ':attribute no corresponde al formato :format.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1045, 1, 'es', 'validation', 'different', ':attribute y :other deben ser diferentes.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1046, 1, 'es', 'validation', 'digits', ':attribute debe tener :digits dígitos.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1047, 1, 'es', 'validation', 'digits_between', ':attribute debe tener entre :min y :max dígitos.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1048, 1, 'es', 'validation', 'dimensions', 'Las dimensiones de la imagen :attribute no son válidas.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1049, 1, 'es', 'validation', 'distinct', 'El campo :attribute contiene un valor duplicado.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1050, 1, 'es', 'validation', 'email', ':attribute no es un correo válido', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1051, 1, 'es', 'validation', 'exists', ':attribute es inválido.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1052, 1, 'es', 'validation', 'file', 'El campo :attribute debe ser un archivo.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1053, 1, 'es', 'validation', 'filled', 'El campo :attribute es obligatorio.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1054, 1, 'es', 'validation', 'image', ':attribute debe ser una imagen.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1055, 1, 'es', 'validation', 'in', ':attribute es inválido.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1056, 1, 'es', 'validation', 'in_array', 'El campo :attribute no existe en :other.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1057, 1, 'es', 'validation', 'integer', ':attribute debe ser un número entero.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1058, 1, 'es', 'validation', 'ip', ':attribute debe ser una dirección IP válida.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1059, 1, 'es', 'validation', 'ipv4', ':attribute debe ser un dirección IPv4 válida', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1060, 1, 'es', 'validation', 'ipv6', ':attribute debe ser un dirección IPv6 válida.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1061, 1, 'es', 'validation', 'json', 'El campo :attribute debe tener una cadena JSON válida.', '2018-01-31 06:17:06', '2018-01-31 06:17:06'),
(1062, 1, 'es', 'validation', 'max.numeric', ':attribute no debe ser mayor a :max.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1063, 1, 'es', 'validation', 'max.file', ':attribute no debe ser mayor que :max kilobytes.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1064, 1, 'es', 'validation', 'max.string', ':attribute no debe ser mayor que :max caracteres.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1065, 1, 'es', 'validation', 'max.array', ':attribute no debe tener más de :max elementos.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1066, 1, 'es', 'validation', 'mimes', ':attribute debe ser un archivo con formato: :values.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1067, 1, 'es', 'validation', 'mimetypes', ':attribute debe ser un archivo con formato: :values.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1068, 1, 'es', 'validation', 'min.numeric', 'El tamaño de :attribute debe ser de al menos :min.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1069, 1, 'es', 'validation', 'min.file', 'El tamaño de :attribute debe ser de al menos :min kilobytes.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1070, 1, 'es', 'validation', 'min.string', ':attribute debe contener al menos :min caracteres.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1071, 1, 'es', 'validation', 'min.array', ':attribute debe tener al menos :min elementos.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1072, 1, 'es', 'validation', 'not_in', ':attribute es inválido.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1073, 1, 'es', 'validation', 'numeric', ':attribute debe ser numérico.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1074, 1, 'es', 'validation', 'present', 'El campo :attribute debe estar presente.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1075, 1, 'es', 'validation', 'regex', 'El formato de :attribute es inválido.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1076, 1, 'es', 'validation', 'required', 'El campo :attribute es obligatorio.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1077, 1, 'es', 'validation', 'required_if', 'El campo :attribute es obligatorio cuando :other es :value.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1078, 1, 'es', 'validation', 'required_unless', 'El campo :attribute es obligatorio a menos que :other esté en :values.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1079, 1, 'es', 'validation', 'required_with', 'El campo :attribute es obligatorio cuando :values está presente.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1080, 1, 'es', 'validation', 'required_with_all', 'El campo :attribute es obligatorio cuando :values está presente.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1081, 1, 'es', 'validation', 'required_without', 'El campo :attribute es obligatorio cuando :values no está presente.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1082, 1, 'es', 'validation', 'required_without_all', 'El campo :attribute es obligatorio cuando ninguno de :values estén presentes.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1083, 1, 'es', 'validation', 'same', ':attribute y :other deben coincidir.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1084, 1, 'es', 'validation', 'size.numeric', 'El tamaño de :attribute debe ser :size.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1085, 1, 'es', 'validation', 'size.file', 'El tamaño de :attribute debe ser :size kilobytes.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1086, 1, 'es', 'validation', 'size.string', ':attribute debe contener :size caracteres.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1087, 1, 'es', 'validation', 'size.array', ':attribute debe contener :size elementos.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1088, 1, 'es', 'validation', 'string', 'El campo :attribute debe ser una cadena de caracteres.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1089, 1, 'es', 'validation', 'timezone', 'El :attribute debe ser una zona válida.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1090, 1, 'es', 'validation', 'unique', ':attribute ya ha sido registrado.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1091, 1, 'es', 'validation', 'uploaded', 'Subir :attribute ha fallado.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1092, 1, 'es', 'validation', 'url', 'El formato :attribute es inválido.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1093, 1, 'es', 'validation', 'custom.password.min', 'La :attribute debe contener más de :min caracteres', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1094, 1, 'es', 'validation', 'custom.email.unique', 'El :attribute ya ha sido registrado.', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1095, 1, 'es', 'validation', 'attributes.name', 'nombre', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1096, 1, 'es', 'validation', 'attributes.username', 'usuario', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1097, 1, 'es', 'validation', 'attributes.email', 'correo electrónico', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1098, 1, 'es', 'validation', 'attributes.first_name', 'nombre', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1099, 1, 'es', 'validation', 'attributes.last_name', 'apellido', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1100, 1, 'es', 'validation', 'attributes.password', 'contraseña', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1101, 1, 'es', 'validation', 'attributes.password_confirmation', 'confirmación de la contraseña', '2018-01-31 06:17:07', '2018-01-31 06:17:07'),
(1102, 1, 'es', 'validation', 'attributes.city', 'ciudad', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1103, 1, 'es', 'validation', 'attributes.country', 'país', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1104, 1, 'es', 'validation', 'attributes.address', 'dirección', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1105, 1, 'es', 'validation', 'attributes.phone', 'teléfono', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1106, 1, 'es', 'validation', 'attributes.mobile', 'móvil', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1107, 1, 'es', 'validation', 'attributes.age', 'edad', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1108, 1, 'es', 'validation', 'attributes.sex', 'sexo', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1109, 1, 'es', 'validation', 'attributes.gender', 'género', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1110, 1, 'es', 'validation', 'attributes.year', 'año', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1111, 1, 'es', 'validation', 'attributes.month', 'mes', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1112, 1, 'es', 'validation', 'attributes.day', 'día', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1113, 1, 'es', 'validation', 'attributes.hour', 'hora', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1114, 1, 'es', 'validation', 'attributes.minute', 'minuto', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1115, 1, 'es', 'validation', 'attributes.second', 'segundo', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1116, 1, 'es', 'validation', 'attributes.title', 'título', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1117, 1, 'es', 'validation', 'attributes.content', 'contenido', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1118, 1, 'es', 'validation', 'attributes.body', 'contenido', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1119, 1, 'es', 'validation', 'attributes.description', 'descripción', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1120, 1, 'es', 'validation', 'attributes.excerpt', 'extracto', '2018-01-31 06:17:08', '2018-01-31 06:17:08'),
(1121, 1, 'es', 'validation', 'attributes.date', 'fecha', '2018-01-31 06:17:09', '2018-01-31 06:17:09'),
(1122, 1, 'es', 'validation', 'attributes.time', 'hora', '2018-01-31 06:17:09', '2018-01-31 06:17:09'),
(1123, 1, 'es', 'validation', 'attributes.subject', 'asunto', '2018-01-31 06:17:09', '2018-01-31 06:17:09'),
(1124, 1, 'es', 'validation', 'attributes.message', 'mensaje', '2018-01-31 06:17:09', '2018-01-31 06:17:09');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `menu_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `link` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `order_by` int(11) NOT NULL,
  `translate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`menu_id`, `parent_id`, `link`, `title`, `active`, `order_by`, `translate`) VALUES
(1, 0, 'home', 'Home', 1, 1, 'Home');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2017_10_16_183611_create_categories_table', 0),
(2, '2017_10_16_183611_create_customers_table', 0),
(3, '2017_10_16_183611_create_homepage_table', 0),
(4, '2017_10_16_183611_create_menus_table', 0),
(5, '2017_10_16_183611_create_newsletters_table', 0),
(6, '2017_10_16_183611_create_pages_table', 0),
(7, '2017_10_16_183611_create_password_resets_table', 0),
(8, '2017_10_16_183611_create_permission_role_table', 0),
(9, '2017_10_16_183611_create_permissions_table', 0),
(10, '2017_10_16_183611_create_products_table', 0),
(11, '2017_10_16_183611_create_roles_table', 0),
(12, '2017_10_16_183611_create_sale_items_table', 0),
(13, '2017_10_16_183611_create_sales_table', 0),
(14, '2017_10_16_183611_create_settings_table', 0),
(15, '2017_10_16_183611_create_sliders_table', 0),
(16, '2017_10_16_183611_create_suppliers_table', 0),
(17, '2017_10_16_183611_create_users_table', 0),
(18, '2017_10_23_101103_create_categories_table', 0),
(19, '2017_10_23_101103_create_customers_table', 0),
(20, '2017_10_23_101103_create_homepage_table', 0),
(21, '2017_10_23_101103_create_menus_table', 0),
(22, '2017_10_23_101103_create_newsletters_table', 0),
(23, '2017_10_23_101103_create_pages_table', 0),
(24, '2017_10_23_101103_create_password_resets_table', 0),
(25, '2017_10_23_101103_create_permission_role_table', 0),
(26, '2017_10_23_101103_create_permissions_table', 0),
(27, '2017_10_23_101103_create_products_table', 0),
(28, '2017_10_23_101103_create_roles_table', 0),
(29, '2017_10_23_101103_create_sale_items_table', 0),
(30, '2017_10_23_101103_create_sales_table', 0),
(31, '2017_10_23_101103_create_settings_table', 0),
(32, '2017_10_23_101103_create_sliders_table', 0),
(33, '2017_10_23_101103_create_suppliers_table', 0),
(34, '2017_10_23_101103_create_users_table', 0),
(35, '2017_12_15_163503_entrust_setup_tables', 1),
(36, '2016_06_01_000001_create_oauth_auth_codes_table', 2),
(37, '2016_06_01_000002_create_oauth_access_tokens_table', 2),
(38, '2016_06_01_000003_create_oauth_refresh_tokens_table', 2),
(39, '2016_06_01_000004_create_oauth_clients_table', 2),
(40, '2016_06_01_000005_create_oauth_personal_access_clients_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

CREATE TABLE `newsletters` (
  `id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('2a08ec1da735bdd5e27b00a1e03da94dc230e9c5c9510676be00216be287b92adb363389c765a09c', 5, 1, 'Personal Access Token', '[]', 1, '2020-04-05 14:55:56', '2020-04-05 14:55:56', '2020-04-20 16:55:56'),
('87ad2ae415f6479da8613f07b7612c01d2979017272f02553a49b9f3c0ef1c9eed10014242f54750', 5, 1, 'Personal Access Token', '[]', 0, '2020-04-05 15:43:52', '2020-04-05 15:43:52', '2020-04-20 17:43:53'),
('c75a4a88b42afff05f61111abdbea7d50a5eca4e637f9907a1e2798bb3857db43969c50a5a38ef02', 5, 1, 'Personal Access Token', '[]', 0, '2020-06-05 18:11:16', '2020-06-05 18:11:16', '2020-06-20 20:11:16'),
('fed9543a802ffa90c8e752d3f7750a4b9dc6b356519e1796cb76244bb79dece91a9126f0ba55b8f1', 5, 1, 'Personal Access Token', '[]', 0, '2020-05-17 14:49:11', '2020-05-17 14:49:11', '2020-06-01 16:49:11');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'MX20pV4mmAB0sXCehCX5vk7X2leCm10HtMnxCQg2', 'http://localhost', 1, 0, 0, '2020-04-05 14:49:00', '2020-04-05 14:49:00'),
(2, NULL, 'Laravel Password Grant Client', 'LwokV9FDHE4fw6Q5RTA3MWC2cnutriwCq4Mjh4wE', 'http://localhost', 0, 1, 0, '2020-04-05 14:49:00', '2020-04-05 14:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2020-04-05 14:49:00', '2020-04-05 14:49:00');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `body` longtext NOT NULL,
  `parent_id` int(11) NOT NULL,
  `is_delete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `image`, `body`, `parent_id`, `is_delete`) VALUES
(1, 'Terms & Condition', 'services', '574724_page.jpg', 'Pellentesque pellentesque eget tempor tellus. Fusce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus. Fusce lacinia tempor malesuada.\r\n\r\n                            <h2>H2 Heading</h2>\r\n                            <p>Pellentesque pellentesque usce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus.  tellus eget tempor. Fusce lacinia tempor malesuada.</p>\r\n\r\n                            <h3>H3 Heading</h3>\r\n                            <p>Pellentesque tempor tellus eget pellentesque. usce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus.  Fusce lacinia tempor malesuada.</p>\r\n\r\n                            <h4>H4 Heading</h4>\r\n                            <p>Pellentesque pellentesque tempor tellus eget fermentum. usce lacllentesque eget tempor tellus ellentesque pelleinia tempor malesuada. Pellentesque pellentesque eget tempor tellus ellentesque pellentesque eget tempor tellus. </p>\r\n\r\n                            <h5>H5 Heading</h5><div>this is a test editing </div>\r\n                            <p>Pellentesque pellentesque tempor llentesque pellentesque tempor tellus eget libero llentesque pellentesque tempor tellus eget libero tellus ementellentesque tempor tellus eget fermentum. usce lacllentesque eget tempor tellus ellenellentesque tempor tellus eget fermentum. usce lacllentesque eget tempor tellus ellenum.</p>\r\n\r\n                            <h6>H6 Heading</h6>\r\n                            <p>Pellentesque pellentesque tempor tellus eget libero</p>', 0, 0),
(2, 'FAQ', 'faq', 'page2.jpg', '<div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span><span style=\"font-weight: bold;\"><br></span></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?<br></span></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><br></span></div><div><span style=\"font-weight: bold;\">1 : this is a question number 1</span><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><br></span></div><div><span style=\"font-weight: bold;\">1 : this is a question number 1</span><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><br></span></div><div><span style=\"color: rgb(102, 102, 102); font-family: \" varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\"><span style=\"color: rgb(103, 106, 108); font-weight: bold;\">1 : this is a question number 1</span><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><br></span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><span style=\"color: rgb(103, 106, 108); font-weight: bold;\">1 : this is a question number 1</span><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><br></span></div><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\"><span style=\"color: rgb(103, 106, 108); font-weight: bold;\">1 : this is a question number 1</span><div style=\"color: rgb(103, 106, 108);\"><span varela=\"\" round\",=\"\" sans-serif;=\"\" font-size:=\"\" 16px;\"=\"\" style=\"color: rgb(102, 102, 102);\">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique?</span></div></span></div></span></div></span></div>', 0, 0),
(3, 'About Us', 'about-us', 'page3.jpg', '<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat. </p>\r\n\r\n\r\n<h2> Heading 2</h2>\r\n\r\n<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat. </p><p><br></p><h2 style=\"color: rgb(103, 106, 108);\">Heading 2</h2><p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat.</p>', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `body` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'view_sale', 'View Sales ', NULL, NULL, NULL),
(2, 'add_sale', 'Add Sales', NULL, NULL, NULL),
(3, 'add_product', 'Add Product ', NULL, NULL, NULL),
(4, 'view_products', 'View Products', NULL, NULL, NULL),
(5, 'edit_products', 'Edit Products', NULL, NULL, NULL),
(6, 'delete_products', 'Delete Products', NULL, NULL, NULL),
(7, 'add_category', 'Add Category ', NULL, NULL, NULL),
(8, 'view_categorys', 'View Categorys', NULL, NULL, NULL),
(9, 'edit_categorys', 'Edit Categorys', NULL, NULL, NULL),
(10, 'delete_categorys', 'Delete Categorys', NULL, NULL, NULL),
(11, 'add_expense', 'Add Expense ', NULL, NULL, NULL),
(12, 'view_expense', 'View Expenses', NULL, NULL, NULL),
(13, 'edit_expense', 'Edit Expenses', NULL, NULL, NULL),
(14, 'delete_expense', 'Delete Expenses', NULL, NULL, NULL),
(15, 'setting', 'Overall Setting', NULL, NULL, NULL),
(16, 'frontend_setting', 'Frontend Setting', NULL, NULL, NULL),
(17, 'reports', 'View Reports ', NULL, NULL, NULL),
(18, 'roles', 'Manage Roles ', NULL, NULL, NULL),
(19, 'dashboard', 'Dasoboard', NULL, NULL, NULL),
(20, 'users', 'Manage Users', NULL, NULL, NULL),
(21, 'Profile', 'View Profile', NULL, NULL, NULL),
(22, 'view_waiting_orders', 'Waiting Orders', NULL, NULL, NULL),
(23, 'view_bussiness', 'View Create Bussines', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(1, 2),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(17, 2),
(18, 1),
(19, 1),
(19, 2),
(20, 1),
(21, 1),
(21, 2),
(21, 3),
(22, 1),
(22, 2),
(22, 3),
(23, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `barcode` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `titles` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prices` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `is_delete` int(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `barcode`, `name`, `description`, `titles`, `prices`, `quantity`, `is_delete`, `created_at`, `updated_at`, `deleted_at`, `bussiness_id`) VALUES
(1, 7, NULL, 'Pizza', 'Pica description', '[null]', '[\"180\"]', 0, 0, '2020-04-07 19:19:22', '2020-04-11 08:53:07', NULL, 1),
(2, 9, NULL, 'Tost', 'Tost me kashkaval, salam', '[null]', '[\"80\"]', 0, 0, '2020-04-11 08:48:32', '2020-04-11 08:53:18', NULL, 1),
(3, 8, NULL, 'Lahmachun', 'Lahmachun me salata marula limon', '[null]', '[\"120\"]', 0, 0, '2020-04-11 08:50:00', '2020-04-11 08:53:24', NULL, 1),
(4, 6, NULL, 'Pide', 'Pide me mish dhe veze', '[null]', '[\"160\"]', 0, 0, '2020-04-11 08:51:13', '2020-04-11 08:53:31', NULL, 1),
(5, 4, NULL, 'Macchiato', 'Coffe Machiato', '[\"Big\",\"Small\"]', '[\"100\",\"70\"]', 0, 0, '2020-04-11 10:27:35', '2020-04-11 10:27:35', NULL, 1),
(6, 4, NULL, 'Espresso', 'Espresso coffee', '[\"Big\",\"Small\"]', '[\"80\",\"60\"]', 0, 0, '2020-04-11 10:33:41', '2020-04-11 10:33:41', NULL, 1),
(7, 4, NULL, 'Nescafe cold', 'Nescafe cold with ice', '[null]', '[\"80\"]', 0, 0, '2020-04-11 10:39:16', '2020-04-11 10:39:16', NULL, 1),
(8, 8, NULL, 'Omlet', 'Omlet me kashkaval, kepurdha', '[null]', '[\"150\"]', 0, 0, '2020-04-11 11:10:20', '2020-04-11 11:13:05', NULL, 1),
(9, 7, NULL, 'Lasagne', 'Lasagne me kashkavall, tomato, mish i grire', '[null]', '[\"220\"]', 0, 0, '2020-04-11 11:12:54', '2020-04-11 11:12:54', NULL, 1),
(10, 7, NULL, 'Makarona', 'Makarona tomato, tuna, kepurdha', '[null]', '[\"200\"]', 0, 0, '2020-04-11 11:14:05', '2020-04-11 11:14:05', NULL, 1),
(11, 8, NULL, 'Pancake', 'Pancake me banane dhe nutela', '[null]', '[\"180\"]', 0, 0, '2020-04-11 11:16:45', '2020-04-11 11:16:45', NULL, 1),
(12, 8, NULL, 'Pallacinka', 'Pallacinka me nutella', '[null]', '[\"180\"]', 0, 0, '2020-04-11 11:17:22', '2020-04-11 11:19:57', NULL, NULL),
(13, 9, NULL, 'Doner', 'Doner me mish vici', '[\"Mish vici\",\"Mish pule\"]', '[\"80\",\"70\"]', 0, 0, '2020-04-11 11:19:46', '2020-04-11 11:19:46', NULL, NULL),
(14, 9, NULL, 'Durum', 'Durum me mish vici dhe pules', '[\"Mish vici\",\"Mish pule\"]', '[\"120\",\"110\"]', 0, 0, '2020-04-11 11:22:06', '2020-04-11 11:22:06', NULL, NULL),
(15, 9, NULL, 'Chicken burger', 'Chicken burger me sallata', '[null]', '[\"90\"]', 0, 0, '2020-04-11 11:22:43', '2020-04-11 11:22:43', NULL, NULL),
(16, 9, NULL, 'Chicken rools', 'Chicken rools patate, kechup majonez', '[null]', '[\"130\"]', 0, 0, '2020-04-11 11:25:06', '2020-04-11 11:25:06', NULL, NULL),
(17, 4, NULL, 'Tiramissu', 'Tiramissu cake', '[\"Price\"]', '[\"120\"]', 0, 0, '2020-05-10 16:54:38', '2020-05-10 16:54:38', NULL, NULL),
(18, 4, NULL, 'Pancake', 'Pancake me banane dhe nutela', '[\"Price\"]', '[\"150\"]', 0, 0, '2020-05-10 16:56:12', '2020-05-10 16:56:12', NULL, NULL),
(21, 4, NULL, 'work', 'working', '[null]', '[\"120\"]', 0, 0, '2020-06-05 13:30:30', '2020-06-05 13:30:30', NULL, 1),
(22, 4, NULL, 'bbb', 'bbb', '[null]', '[\"120\"]', 0, 0, '2020-06-05 13:44:21', '2020-06-05 13:44:21', NULL, 1),
(23, 4, NULL, 'bbb', 'bbb', '[null]', '[\"120\"]', 0, 0, '2020-06-05 13:45:48', '2020-06-05 13:45:48', NULL, 1),
(24, 4, NULL, 'new', 'new one', '[null]', '[\"120\"]', 0, 0, '2020-06-05 13:46:40', '2020-06-05 13:46:55', '2020-06-05 13:46:55', 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(11) NOT NULL,
  `bill_no` varchar(55) DEFAULT NULL,
  `supplier_id` int(11) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  `note` varchar(1000) DEFAULT NULL,
  `total_amount` decimal(25,2) DEFAULT NULL,
  `tax` decimal(25,2) DEFAULT NULL,
  `discount` decimal(25,2) DEFAULT NULL,
  `user` varchar(255) DEFAULT NULL,
  `updated_by` varchar(255) DEFAULT NULL,
  `paid` decimal(25,2) DEFAULT NULL,
  `paid_by` enum('cash','cheque') DEFAULT NULL,
  `cheque_no` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_items`
--

CREATE TABLE `purchase_items` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `units` int(11) NOT NULL DEFAULT 1,
  `unit_price` double(10,2) DEFAULT NULL,
  `gross_total` double(10,2) DEFAULT NULL,
  `sold_price` double(10,2) DEFAULT NULL,
  `created_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(100) DEFAULT NULL,
  `guests` int(2) DEFAULT NULL,
  `booking_date` date DEFAULT NULL,
  `booking_time` time DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status` enum('Booked','Cancelled') NOT NULL DEFAULT 'Booked'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Super Administrator', 'Main Admin', NULL, '2018-01-20 16:07:14'),
(2, 'manager', 'Sales Manager', NULL, NULL, '2017-12-15 12:38:09'),
(3, 'sales_staff', 'Sales Staff', NULL, NULL, '2019-01-10 11:01:56');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(5, 1),
(12, 2),
(15, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT 0,
  `cashier_id` int(11) DEFAULT NULL,
  `comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1:completed, 0 canceled',
  `amount` double(10,2) NOT NULL DEFAULT 0.00,
  `discount` double(10,2) DEFAULT 0.00,
  `vat` double(10,2) DEFAULT 0.00,
  `delivery_cost` double(10,2) DEFAULT 0.00,
  `name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `comment` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(10) COLLATE utf8_unicode_ci DEFAULT 'pos',
  `payment_with` enum('card','cash') COLLATE utf8_unicode_ci DEFAULT 'cash',
  `total_given` double(10,2) DEFAULT NULL,
  `change` double(10,2) NOT NULL DEFAULT 0.00,
  `table_id` int(11) DEFAULT NULL,
  `show_waitress` tinyint(1) DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `customer_id`, `cashier_id`, `comments`, `created_at`, `updated_at`, `status`, `amount`, `discount`, `vat`, `delivery_cost`, `name`, `email`, `phone`, `address`, `comment`, `type`, `payment_with`, `total_given`, `change`, `table_id`, `show_waitress`, `bussiness_id`) VALUES
(1, NULL, 5, 'Paying admin product', '2020-04-11 09:00:09', '2020-05-23 09:43:02', 1, 120.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 122.00, 2.00, 8, 1, 1),
(2, NULL, 5, NULL, '2020-04-15 20:01:23', '2020-05-23 09:43:02', 1, 240.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 240.00, 0.00, 8, 1, NULL),
(3, 0, NULL, NULL, '2020-04-20 18:04:09', '2020-05-23 09:42:41', 0, 170.00, 0.00, 0.00, 10.00, 'Berat', 'berat_01993@hotmail.com', '0715554884', 'skopje', 'Koment', 'order', 'cash', NULL, 0.00, 8, 1, NULL),
(6, 0, NULL, NULL, '2020-04-20 19:02:54', '2020-05-07 13:46:30', 1, 170.00, 0.00, 0.00, 10.00, 'Berat', 'berat_01993@hotmail.com', '0715554884', 'skopje', 'Koment', 'order', 'cash', NULL, 0.00, 8, 1, NULL),
(7, 0, NULL, NULL, '2020-04-20 19:05:21', '2020-05-23 09:43:02', 2, 170.00, 0.00, 0.00, 10.00, 'Berat', 'berat_01993@hotmail.com', '0715554884', 'skopje', 'Koment', 'order', 'cash', NULL, 0.00, 8, 1, NULL),
(8, 0, NULL, NULL, '2020-04-22 18:55:28', '2020-05-07 13:46:30', 1, 170.00, 0.00, 0.00, 10.00, 'Berat', 'berat_01993@hotmail.com', '0715554884', 'skopje', 'Koment', 'order', 'cash', NULL, 0.00, 8, 1, NULL),
(9, 0, NULL, NULL, '2020-04-22 18:55:36', '2020-05-23 12:05:38', 0, 170.00, 0.00, 0.00, 10.00, 'Berat', 'berat_01993@hotmail.com', '0715554884', 'skopje', 'Koment', 'order', 'cash', NULL, 0.00, 8, 1, NULL),
(10, 1, 5, NULL, '2020-05-07 13:45:42', '2020-05-07 13:45:42', 1, 120.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 120.00, 0.00, 8, 1, NULL),
(11, 1, 5, NULL, '2020-05-17 15:39:30', '2020-05-23 09:42:41', 1, 120.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 120.00, 0.00, 8, 1, NULL),
(12, 1, 5, NULL, '2020-05-17 15:47:15', '2020-05-17 15:47:15', 1, 160.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 160.00, 0.00, 8, 1, NULL),
(13, 1, 5, NULL, '2020-05-22 21:06:18', '2020-05-22 21:06:18', 1, 160.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 160.00, 0.00, 8, 1, NULL),
(14, 1, 5, NULL, '2020-05-22 21:09:20', '2020-05-23 12:05:27', 1, 120.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 120.00, 0.00, 8, 1, NULL),
(15, 1, 5, NULL, '2020-05-22 21:14:43', '2020-05-23 09:43:45', 1, 80.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 80.00, 0.00, 8, 0, NULL),
(16, NULL, 5, NULL, '2020-05-23 09:17:52', '2020-05-23 09:43:08', 1, 120.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 120.00, 0.00, 8, 0, NULL),
(17, NULL, 5, NULL, '2020-05-23 09:21:37', '2020-05-23 09:43:08', 1, 180.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 180.00, 0.00, 8, 0, NULL),
(18, NULL, 5, NULL, '2020-05-23 09:24:53', '2020-05-23 12:05:11', 1, 180.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 0.00, -180.00, 8, 0, NULL),
(19, NULL, 5, NULL, '2020-05-23 09:27:34', '2020-05-23 09:43:08', 1, 60.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 60.00, 0.00, 8, 0, NULL),
(20, 1, 5, NULL, '2020-05-23 09:31:22', '2020-05-23 09:31:22', 1, 160.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'order', 'cash', 160.00, 0.00, 8, 0, NULL),
(21, NULL, 5, NULL, '2020-06-05 16:17:40', '2020-06-05 16:17:40', 1, 80.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 80.00, 0.00, 10, 0, NULL),
(22, NULL, 5, NULL, '2020-06-05 16:32:33', '2020-06-05 17:13:27', 1, 80.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 80.00, 0.00, 15, 1, 1),
(23, NULL, 5, 'koment', '2020-06-05 16:51:28', '2020-06-05 16:51:28', 1, 180.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'pos', 'cash', 180.00, 0.00, 15, 0, 1),
(24, 12, 5, 'Florent', '2020-06-05 16:56:39', '2020-06-05 16:56:39', 1, 80.00, 0.00, 0.00, 0.00, NULL, NULL, NULL, NULL, NULL, 'order', 'cash', 80.00, 0.00, 10, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `p_qty` int(11) NOT NULL DEFAULT 0,
  `size` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `price`, `quantity`, `p_qty`, `size`, `created_at`, `updated_at`, `bussiness_id`) VALUES
(1, 1, 3, '120.00', 1, 0, 'Price', '2020-04-11 09:00:09', '2020-04-11 09:00:09', 1),
(2, 2, 7, '80.00', 1, 0, NULL, '2020-04-15 20:01:23', '2020-04-15 20:01:23', NULL),
(3, 2, 4, '160.00', 1, 0, NULL, '2020-04-15 20:01:23', '2020-04-15 20:01:23', NULL),
(4, 3, 4, '160.00', 1, 0, NULL, '2020-04-20 18:04:09', '2020-04-20 18:04:09', NULL),
(5, 6, 4, '160.00', 1, 0, '0', '2020-04-20 19:02:54', '2020-04-20 19:02:54', NULL),
(6, 7, 4, '160.00', 1, 0, '0', '2020-04-20 19:05:21', '2020-04-20 19:05:21', NULL),
(7, 8, 4, '160.00', 1, 0, '0', '2020-04-22 18:55:28', '2020-04-22 18:55:28', NULL),
(8, 9, 4, '160.00', 1, 0, '0', '2020-04-22 18:55:36', '2020-04-22 18:55:36', NULL),
(9, 10, 3, '120.00', 1, 0, NULL, '2020-05-07 13:45:42', '2020-05-07 13:45:42', NULL),
(10, 11, 3, '120.00', 1, 0, NULL, '2020-05-17 15:39:30', '2020-05-17 15:39:30', NULL),
(11, 12, 4, '160.00', 1, 0, NULL, '2020-05-17 15:47:15', '2020-05-17 15:47:15', NULL),
(12, 13, 4, '160.00', 1, 0, NULL, '2020-05-22 21:06:18', '2020-05-22 21:06:18', NULL),
(13, 14, 3, '120.00', 1, 0, NULL, '2020-05-22 21:09:20', '2020-05-22 21:09:20', NULL),
(14, 15, 2, '80.00', 1, 0, NULL, '2020-05-22 21:14:43', '2020-05-22 21:14:43', NULL),
(15, 16, 3, '120.00', 1, 0, NULL, '2020-05-23 09:17:52', '2020-05-23 09:17:52', NULL),
(16, 17, 1, '180.00', 1, 0, NULL, '2020-05-23 09:21:37', '2020-05-23 09:21:37', NULL),
(17, 18, 12, '180.00', 1, 0, NULL, '2020-05-23 09:24:53', '2020-05-23 09:24:53', NULL),
(18, 19, 6, '60.00', 1, 0, 'Small', '2020-05-23 09:27:34', '2020-05-23 09:27:34', NULL),
(19, 20, 4, '160.00', 1, 0, NULL, '2020-05-23 09:31:22', '2020-05-23 09:31:22', NULL),
(20, 21, 2, '80.00', 1, 0, NULL, '2020-06-05 16:17:41', '2020-06-05 16:17:41', NULL),
(21, 22, 2, '80.00', 1, 0, NULL, '2020-06-05 16:32:33', '2020-06-05 16:32:33', NULL),
(22, 23, 1, '180.00', 1, 0, NULL, '2020-06-05 16:51:28', '2020-06-05 16:51:28', NULL),
(23, 24, 2, '80.00', 1, 0, NULL, '2020-06-05 16:56:39', '2020-06-05 16:56:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `label` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `label`, `value`, `created_at`, `updated_at`) VALUES
(1, 'title', 'Site Title', 'Reto - Bar', NULL, '2018-12-14 21:58:02'),
(2, 'phone', 'Phone', '3005095213', NULL, '2018-12-08 17:09:43'),
(3, 'email', 'Email', 'test@gmail.com', NULL, '2020-04-11 08:45:00'),
(4, 'address', 'Address', 'Skopje', NULL, '2020-04-11 08:45:00'),
(5, 'country', 'Country', 'Macedonia', NULL, '2020-04-11 08:45:00'),
(6, 'timing1', 'Monday To Saturday', '8 am to 6 pm', NULL, '2020-04-11 08:45:00'),
(7, 'sunday', 'Sunday', '8 am to 13 pm', NULL, '2020-04-11 08:45:00'),
(8, 'facebook', 'Facebook', '', NULL, '2020-04-11 08:45:00'),
(9, 'twitter', 'Twitter', '', NULL, '2020-04-11 08:45:00'),
(10, 'vat', 'VAT', '0', NULL, '2018-12-14 21:58:02'),
(11, 'delivery_cost', 'Delivery Cost', '10', NULL, '2020-04-11 08:45:00'),
(12, 'currency', 'Currency', '€', NULL, '2020-04-11 08:45:00'),
(13, 'lng', 'Longitude', '', NULL, '2020-04-11 08:45:00'),
(14, 'lat', 'Latitude', '', NULL, '2020-04-11 08:45:00'),
(15, 'stripe', 'Stripe Payment', 'yes', NULL, '2019-01-09 17:17:58'),
(16, 'frontend', 'Hide Frontend', 'no', NULL, '2019-01-09 17:17:58'),
(17, 'promotions', 'Receipt Message', 'this is a receipt message edit', NULL, '2017-12-13 23:02:56'),
(18, 'discount', 'Discount ($)', '0', NULL, '2018-12-14 21:58:02');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(500) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sliders`
--

INSERT INTO `sliders` (`id`, `title`, `image`, `created_at`, `updated_at`) VALUES
(6, 'Slider Image', '333296.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tables`
--

CREATE TABLE `tables` (
  `id` int(11) NOT NULL,
  `table_name` varchar(200) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `bussiness_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tables`
--

INSERT INTO `tables` (`id`, `table_name`, `created_at`, `updated_at`, `bussiness_id`) VALUES
(2, 'Table 2', NULL, '2020-05-07 15:55:16', NULL),
(8, 'Table 5', NULL, NULL, NULL),
(9, 'Sale table 1', NULL, NULL, NULL),
(10, 'table test', NULL, NULL, 1),
(15, 'bus table', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 0,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role_id`, `remember_token`, `created_at`, `updated_at`) VALUES
(5, 'Admin', 'admin@example.com', '$2y$10$NDJ8GvTAdoJ/uG0AQ2Y.9ucXwjy75NVf.VgFnSZDSakRRvrEyAlMq', 1, '1U3j3uKXwG62GX8kgQeZVtaVpq53T8M7V4gnRlH526nl6ltLDn7PzAqk5zXF', '2020-04-11 08:53:52', '2017-12-05 04:48:48'),
(12, 'Sales', 'sales@manager.com', '$2y$10$XYD5Oa3sO.yHhC7DbNTtOuuse.VhgGi1LS9a2J.HePoo/9dos7L06', 2, 'YxThytV8PIFqfIJYyUzx1yjGHxIWi3flCyXO3Wr7kznaZDnmACdoWs6fZZJx', '2020-04-12 08:53:52', '2020-04-12 09:02:33'),
(15, 'Berk', 'berk@hotmail.com', '$2y$10$EoKxspIDejhmCBsxIdjwieXBmacmQM61SJ/NNEmlwTYP/TLZrzsBa', 1, NULL, '2020-06-01 17:53:41', '2020-06-01 17:53:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustments`
--
ALTER TABLE `adjustments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adjustment_items`
--
ALTER TABLE `adjustment_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `booking_types`
--
ALTER TABLE `booking_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bussinesses`
--
ALTER TABLE `bussinesses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bussiness_user`
--
ALTER TABLE `bussiness_user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `hold_order`
--
ALTER TABLE `hold_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `homepage`
--
ALTER TABLE `homepage`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `inventories`
--
ALTER TABLE `inventories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`menu_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `newsletters`
--
ALTER TABLE `newsletters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`),
  ADD KEY `password_resets_token_index` (`token`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `purchase_items`
--
ALTER TABLE `purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sale_id` (`purchase_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `settings_key_unique` (`key`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `suppliers_email_unique` (`email`);

--
-- Indexes for table `tables`
--
ALTER TABLE `tables`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `adjustments`
--
ALTER TABLE `adjustments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `adjustment_items`
--
ALTER TABLE `adjustment_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `booking_types`
--
ALTER TABLE `booking_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bussinesses`
--
ALTER TABLE `bussinesses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hold_order`
--
ALTER TABLE `hold_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `homepage`
--
ALTER TABLE `homepage`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `inventories`
--
ALTER TABLE `inventories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ltm_translations`
--
ALTER TABLE `ltm_translations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1125;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `menu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `newsletters`
--
ALTER TABLE `newsletters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchase_items`
--
ALTER TABLE `purchase_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tables`
--
ALTER TABLE `tables`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_ibfk_1` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
