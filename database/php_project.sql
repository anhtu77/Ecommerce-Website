-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 24, 2024 lúc 03:16 AM
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
(4, 'shoes', '2024-11-22 18:22:36', '2024-11-22 18:22:36'),
(5, 'clothes', '2024-11-22 18:23:30', '2024-11-22 18:23:30');

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
(103, 666.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-24 08:30:40'),
(104, 1665.00, 'not paid', 3, 987654321, 'ha noi', 'Ha Noi', '2024-11-24 08:44:17');

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
(66, 103, '33', 'Air Jordan', 'Air Jordan1.jpeg', 666.00, 1, 3, '2024-11-24 08:30:40', '39'),
(67, 104, '34', 'Men&#039;s Short', 'Men\'s Short1.jpeg', 555.00, 2, 3, '2024-11-24 08:44:17', 'S'),
(68, 104, '34', 'Men&#039;s Short', 'Men\'s Short1.jpeg', 555.00, 1, 3, '2024-11-24 08:44:17', 'M');

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
(33, 'Air Jordan', 'shoes', 'mid', 'Air Jordan1.jpeg', 'Air Jordan2.jpeg', 'Air Jordan3.jpeg', 'Air Jordan4.jpeg', 666.00, 'red white black', 399),
(34, 'Men Short', 'clothes', 'short', 'Men\'s Short1.jpeg', 'Men\'s Short2.jpeg', 'Men\'s Short3.jpeg', 'Men\'s Short4.jpeg', 555.00, 'Grey', 197),
(35, 'Jogger', 'clothes', 'jogger-grey', 'Jogger1.jpeg', 'Jogger2.jpeg', 'Jogger3.jpeg', 'Jogger4.jpeg', 678.00, 'grey', 400),
(36, 'JoggerPanBe', 'shoes', 'panbe', 'JoggerPanBe1.jpeg', 'JoggerPanBe2.jpeg', 'JoggerPanBe3.jpeg', 'JoggerPanBe4.jpeg', 789.00, 'Be', 400),
(37, 'Pants', 'clothes', 'Pants Black', 'Pants1.jpeg', 'Pants2.jpeg', 'Pants3.jpeg', 'Pants4.jpeg', 345.00, 'black', 200),
(38, 'Pants2', 'clothes', 'hi', 'Pants21.jpeg', 'Pants22.jpeg', 'Pants23.jpeg', 'Pants24.jpeg', 60.00, 'black', 200);

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
(42, 33, 1, 99, '2024-11-22 18:28:08', '2024-11-24 01:30:40'),
(43, 33, 2, 100, '2024-11-22 18:28:08', '2024-11-22 18:28:08'),
(44, 33, 3, 100, '2024-11-22 18:28:08', '2024-11-22 18:28:08'),
(45, 33, 4, 100, '2024-11-22 18:28:08', '2024-11-22 18:28:08'),
(50, 35, 5, 100, '2024-11-22 18:39:02', '2024-11-22 18:39:02'),
(51, 35, 6, 100, '2024-11-22 18:39:02', '2024-11-22 18:39:02'),
(52, 35, 7, 100, '2024-11-22 18:39:02', '2024-11-22 18:39:02'),
(53, 35, 8, 100, '2024-11-22 18:39:02', '2024-11-22 18:39:02'),
(54, 36, 1, 100, '2024-11-22 18:42:26', '2024-11-22 18:42:26'),
(55, 36, 2, 100, '2024-11-22 18:42:26', '2024-11-22 18:42:26'),
(56, 36, 3, 100, '2024-11-22 18:42:26', '2024-11-22 18:42:26'),
(57, 36, 4, 100, '2024-11-22 18:42:26', '2024-11-22 18:42:26'),
(58, 37, 5, 50, '2024-11-22 18:47:34', '2024-11-22 18:47:34'),
(59, 37, 6, 50, '2024-11-22 18:47:34', '2024-11-22 18:47:34'),
(60, 37, 7, 50, '2024-11-22 18:47:34', '2024-11-22 18:47:34'),
(61, 37, 8, 50, '2024-11-22 18:47:34', '2024-11-22 18:47:34'),
(62, 38, 5, 50, '2024-11-24 01:48:33', '2024-11-24 01:48:33'),
(63, 38, 6, 50, '2024-11-24 01:48:33', '2024-11-24 01:48:33'),
(64, 38, 7, 50, '2024-11-24 01:48:33', '2024-11-24 01:48:33'),
(65, 38, 8, 50, '2024-11-24 01:48:33', '2024-11-24 01:48:33'),
(66, 34, 5, 48, '2024-11-24 01:49:06', '2024-11-24 01:49:06'),
(67, 34, 6, 49, '2024-11-24 01:49:06', '2024-11-24 01:49:06'),
(68, 34, 7, 50, '2024-11-24 01:49:06', '2024-11-24 01:49:06'),
(69, 34, 8, 50, '2024-11-24 01:49:06', '2024-11-24 01:49:06');

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT cho bảng `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `product_sizes`
--
ALTER TABLE `product_sizes`
  MODIFY `product_size_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

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
