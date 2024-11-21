-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 21, 2024 lúc 06:15 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `php_project`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(250) NOT NULL,
  `admin_email` text NOT NULL,
  `admin_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'admin', 'admin@email.com', '827ccb0eea8a706c4c34a16891f84e7b');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`, `updated_at`) VALUES
(2, 'shoes', '2024-11-18 19:21:16', '2024-11-18 23:40:51'),
(3, 'clothes', '2024-11-18 22:43:43', '2024-11-18 22:43:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `user_id` int(11) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `user_id`, `user_phone`, `user_city`, `user_address`, `order_date`) VALUES
(15, 155.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-24 17:57:43'),
(16, 310.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-24 17:59:21'),
(17, 155.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-24 18:11:02'),
(18, 155.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-24 18:12:19'),
(19, 155.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-24 19:16:37'),
(20, 155.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-25 00:20:11'),
(21, 155.00, 'paid', 2, 985433612, 'hanoi', 'Ninh Bình', '2024-10-25 00:22:28'),
(22, 123.00, 'paid', 1, 985433612, 'hanoi', 'Ninh Bình', '2024-10-30 12:22:59'),
(23, 155.00, 'paid', 1, 985433612, 'hanoi', 'Ninh Bình', '2024-10-31 21:04:20'),
(24, 306.00, 'not paid', 3, 352266234, 'Ha Noi', 'Mỹ Đức', '2024-11-17 23:03:01'),
(25, 306.00, 'not paid', 3, 352266234, 'Ha Noi', 'Mỹ Đức', '2024-11-17 23:09:31'),
(26, 306.00, 'not paid', 3, 352266234, 'Ha Noi', 'Mỹ Đức', '2024-11-17 23:10:28'),
(27, 306.00, 'not paid', 3, 352266234, 'Ha Noi', 'Mỹ Đức', '2024-11-17 23:11:45'),
(28, 600.00, 'not paid', 3, 352266234, 'Ha Noi', 'Mỹ Đức', '2024-11-17 23:16:01'),
(29, 999.00, 'not paid', 3, 333333333, 'ha noi', 'Ha Noi', '2024-11-19 06:56:04'),
(30, 777.00, 'paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 13:42:33'),
(32, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 16:26:45'),
(33, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 16:50:05'),
(34, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 16:50:56'),
(35, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 16:58:02'),
(36, 2997.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 17:11:46'),
(37, 3774.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 18:06:35'),
(38, 6882.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 19:38:13'),
(39, 6882.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 19:57:48'),
(40, 6882.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 19:58:05'),
(41, 6882.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 19:59:35'),
(42, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 19:59:54'),
(43, 1998.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-20 20:04:44'),
(44, 2775.00, 'not paid', 3, 987654321, 'Ha', 'Yen Nghia', '2024-11-20 20:14:13'),
(45, 3774.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:29:30'),
(46, 3774.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:43:30'),
(47, 3774.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:43:47'),
(48, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:44:11'),
(49, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:44:41'),
(50, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:45:59'),
(51, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:48:28'),
(52, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:49:57'),
(53, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:52:55'),
(54, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 20:55:52'),
(55, 4662.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 21:03:26'),
(56, 5661.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 21:05:07'),
(57, 5550.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-20 21:13:13'),
(58, 5550.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 00:09:32'),
(59, 5550.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 00:13:46'),
(60, 5550.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 00:16:13'),
(61, 999.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 14:03:44'),
(62, 7770.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 14:14:36'),
(63, 1998.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 19:11:21'),
(64, 2775.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 19:34:33'),
(65, 3663.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 19:42:14'),
(66, 3663.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:32:02'),
(67, 3663.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:49:35'),
(68, 3663.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:50:02'),
(69, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:50:57'),
(70, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:51:20'),
(71, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:51:43'),
(72, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:56:07'),
(73, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:56:18'),
(74, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:56:24'),
(75, 888.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:58:11'),
(76, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:59:04'),
(77, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 20:59:46'),
(78, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:00:05'),
(79, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:01:52'),
(80, 2775.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-21 21:04:25'),
(81, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:04:42'),
(82, 1998.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:05:47'),
(83, 2997.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:09:54'),
(84, 3663.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:24:37'),
(85, 3663.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:25:35'),
(86, 5661.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:27:05'),
(87, 5661.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 21:32:01'),
(88, 5661.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:03:02'),
(89, 5661.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:10:06'),
(90, 5661.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:10:59'),
(91, 5661.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:14:40'),
(92, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:42:47'),
(93, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:45:14'),
(94, 999.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:45:29'),
(95, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:46:52'),
(96, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:47:20'),
(97, 1887.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:54:15'),
(98, 4662.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 22:56:09'),
(99, 4551.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 23:24:59'),
(100, 4662.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 23:26:56'),
(101, 888.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-21 23:50:09'),
(102, 4662.00, 'not paid', 3, 352266234, 'Hà Nội', 'Mỹ Đức', '2024-11-22 00:00:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_quantity` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `size_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `product_image`, `product_price`, `product_quantity`, `user_id`, `order_date`, `size_name`) VALUES
(31, 31, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 5, 3, '2024-11-20 15:44:48', NULL),
(32, 31, '31', 'Malong', 'Malong1.jpeg', 999.00, 2, 3, '2024-11-20 15:44:48', NULL),
(33, 31, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-20 15:44:48', NULL),
(34, 31, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-20 15:44:48', NULL),
(35, 41, '31', 'Malong', 'Malong1.jpeg', 999.00, 2, 3, '2024-11-20 19:59:35', NULL),
(36, 41, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-20 19:59:35', NULL),
(37, 41, '30', 'Giày Malong', 'Giày Malong1.jpeg', 777.00, 5, 3, '2024-11-20 19:59:35', NULL),
(38, 42, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-20 19:59:54', NULL),
(39, 46, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 2, 3, '2024-11-20 20:43:30', NULL),
(40, 47, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 2, 3, '2024-11-20 20:43:47', NULL),
(41, 48, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-20 20:44:11', NULL),
(42, 49, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-20 20:44:41', NULL),
(43, 50, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-20 20:45:59', NULL),
(44, 51, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-20 20:48:28', NULL),
(45, 52, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-20 20:49:57', NULL),
(46, 68, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-21 20:50:02', NULL),
(47, 68, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-21 20:50:02', NULL),
(48, 68, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 2, 3, '2024-11-21 20:50:02', NULL),
(49, 96, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-21 22:47:20', NULL),
(50, 96, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-21 22:47:20', NULL),
(51, 97, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-21 22:54:15', NULL),
(52, 97, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-21 22:54:15', NULL),
(53, 98, '30', 'Giày Malong', 'Giày Malong1.jpeg', 777.00, 5, 3, '2024-11-21 22:56:09', NULL),
(54, 98, '30', 'Giày Malong', 'Giày Malong1.jpeg', 777.00, 1, 3, '2024-11-21 22:56:09', NULL),
(55, 99, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-21 23:24:59', NULL),
(56, 99, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-21 23:24:59', NULL),
(57, 99, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-21 23:24:59', NULL),
(58, 100, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 3, 3, '2024-11-21 23:26:56', NULL),
(59, 100, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-21 23:26:56', NULL),
(60, 100, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-21 23:26:56', NULL),
(61, 101, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-21 23:50:09', 'M'),
(62, 102, '32', 'Áo ManU', 'Áo ManU1.jpeg', 888.00, 1, 3, '2024-11-22 00:00:21', 'M'),
(63, 102, '31', 'Malong', 'Malong1.jpeg', 999.00, 2, 3, '2024-11-22 00:00:21', '39'),
(64, 102, '30', 'Giày Malong', 'Giày Malong1.jpeg', 777.00, 1, 3, '2024-11-22 00:00:21', '42'),
(65, 102, '31', 'Malong', 'Malong1.jpeg', 999.00, 1, 3, '2024-11-22 00:00:21', '40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `transaction_id` varchar(250) NOT NULL,
  `payment_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `user_id`, `transaction_id`, `payment_date`) VALUES
(1, 16, 2, '2', '2024-10-25 00:00:00'),
(2, 17, 2, '9', '2024-10-25 00:00:00'),
(3, 18, 2, '36', '2024-10-25 00:00:00'),
(4, 19, 2, '7WF43479MN180904F', '2024-10-24 19:16:58'),
(5, 20, 2, '4S955036LD4523455', '2024-10-24 19:20:23'),
(6, 21, 2, '5MM791195X949415M', '2024-10-25 00:22:39'),
(7, 22, 1, '36D436151Y560225B', '2024-10-30 12:23:44'),
(8, 23, 1, '8S0168773L4185408', '2024-10-31 21:06:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(100) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image2` varchar(255) NOT NULL,
  `product_image3` varchar(255) NOT NULL,
  `product_image4` varchar(255) NOT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_color` varchar(100) NOT NULL,
  `product_stock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `product_color`, `product_stock`) VALUES
(30, 'Giày Malong', 'shoes', 'test7', 'Giày Malong1.jpeg', 'Giày Malong2.jpeg', 'Giày Malong3.jpeg', 'Giày Malong4.jpeg', 777.00, 'red white', 83),
(31, 'Malong', 'shoes', 't2', 'Malong1.jpeg', 'Malong2.jpeg', 'Malong3.jpeg', 'Malong4.jpeg', 999.00, 'red white', 82),
(32, 'Áo ManU', 'clothes', '2019', 'Áo ManU1.jpeg', 'Áo ManU2.jpeg', 'Áo ManU3.jpeg', 'Áo ManU4.jpeg', 888.00, 'red', 189);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_sizes`
--

CREATE TABLE `product_sizes` (
  `product_size_id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_sizes`
--

INSERT INTO `product_sizes` (`product_size_id`, `product_id`, `size_id`, `stock`, `created_at`, `updated_at`) VALUES
(34, 30, 4, 74, '2024-11-21 11:44:35', '2024-11-21 17:00:21'),
(35, 30, 3, 9, '2024-11-21 11:44:35', '2024-11-21 15:56:09'),
(38, 31, 1, 34, '2024-11-21 15:50:52', '2024-11-21 17:00:21'),
(39, 31, 2, 48, '2024-11-21 15:50:52', '2024-11-21 17:00:21'),
(40, 32, 6, 90, '2024-11-21 15:51:00', '2024-11-21 17:00:21'),
(41, 32, 8, 99, '2024-11-21 15:51:00', '2024-11-21 16:24:59');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sizes`
--

CREATE TABLE `sizes` (
  `size_id` int(11) NOT NULL,
  `size_name` varchar(50) NOT NULL,
  `size_type` enum('shoe','clothes') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `sizes`
--

INSERT INTO `sizes` (`size_id`, `size_name`, `size_type`, `created_at`, `updated_at`) VALUES
(1, '39', 'shoe', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(2, '40', 'shoe', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(3, '41', 'shoe', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(4, '42', 'shoe', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(5, 'S', 'clothes', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(6, 'M', 'clothes', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(7, 'L', 'clothes', '2024-11-19 00:26:24', '2024-11-19 00:26:24'),
(8, 'XL', 'clothes', '2024-11-19 00:26:24', '2024-11-19 00:26:24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `role`) VALUES
(1, 'Anh Tu', 'oai2@gmail.com', '25f9e794323b453885f5181f1b624d0b', 'customer'),
(2, 'Quoc Oai', 'oai@gmail.com', '25d55ad283aa400af464c76d713c07ad', 'customer'),
(3, 'Nguyễn Hữu Nghĩa', 'huunghia@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'customer'),
(4, 'Admin', 'admin@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'admin');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Chỉ mục cho bảng `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Chỉ mục cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD PRIMARY KEY (`product_size_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Chỉ mục cho bảng `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`size_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UX_Constraint` (`user_email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `product_size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `sizes`
--
ALTER TABLE `sizes`
  MODIFY `size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  ADD CONSTRAINT `product_sizes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`),
  ADD CONSTRAINT `product_sizes_ibfk_2` FOREIGN KEY (`size_id`) REFERENCES `sizes` (`size_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
