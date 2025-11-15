-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2025 at 09:56 AM
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
-- Database: `kathys_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `province` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `user_id`, `address`, `city`, `province`, `postal_code`, `created_at`, `updated_at`) VALUES
(1, 1, 'Zone 2, Patag', 'Cagayan de Oro City', 'Misamis Oriental', '9000', '2025-11-09 10:52:38', '2025-11-10 03:17:43'),
(10, 14, 'Lapasan', 'Cagayan de Oro City', 'Misamis Oriental', '9000', '2025-11-09 09:08:18', '2025-11-09 09:08:18'),
(11, 17, 'Pagatpat', 'Cagayan de Oro City', 'Misamis Oriental', '9000', '2025-11-09 09:30:45', '2025-11-09 09:30:45'),
(14, 20, 'Buena Vista Patag', 'cagayan de oro city', 'Misamis Oriental', '9000', '2025-11-09 09:52:37', '2025-11-09 09:52:37'),
(17, 23, 'Upper Carmen', 'cagayan de oro city', 'Misamis Oriental', '9000', '2025-11-09 10:26:27', '2025-11-09 10:26:27'),
(18, 24, 'Macasandig ', 'cagayan de oro city', 'Misamis Oriental', '9000', '2025-11-09 10:28:19', '2025-11-09 10:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `created_at`) VALUES
(1, 'Tulips', '2025-11-10 06:30:08'),
(2, 'Roses', '2025-11-10 06:38:12'),
(3, 'Sunflowers', '2025-11-10 06:38:24'),
(9, 'Orchids', '2025-11-10 08:35:56'),
(19, 'diase', '2025-11-13 21:16:54');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `address` text NOT NULL,
  `notes` text DEFAULT NULL,
  `payment_method` enum('gcash','cod') NOT NULL,
  `gcash_reference` varchar(50) DEFAULT NULL,
  `gcash_image` varchar(255) DEFAULT NULL,
  `subtotal` decimal(10,2) NOT NULL,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total` decimal(10,2) NOT NULL,
  `status` enum('pending','pending_verification','preparing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `name`, `mobile`, `email`, `city`, `province`, `zip`, `date`, `address`, `notes`, `payment_method`, `gcash_reference`, `gcash_image`, `subtotal`, `shipping_fee`, `total`, `status`, `created_at`, `updated_at`) VALUES
(16, 2, 'stephen plaza', '09475798243', 'stephenplaza2024@gmail.com', 'cagayan de oro city', 'Bohol', '9000', '2025-11-21', 'patag', 'happy bday letter', 'cod', NULL, NULL, 6291.00, 100.00, 6391.00, 'delivered', '2025-11-13 12:49:18', '2025-11-13 12:51:01'),
(17, 2, 'stephen plaza', '09475798243', 'stephenplaza2024@gmail.com', 'cagayan de oro city', 'Bohol', '9000', '2025-11-18', 'patag', 'birthday gift', 'gcash', 'GC12345678901234', 'uploads/orders/1763067000_8133dfb51c6408225336.png', 6396.00, 100.00, 6496.00, 'delivered', '2025-11-13 12:50:00', '2025-11-13 12:54:49'),
(18, 2, 'divine grace', '09475798243', 'divine@gmail.com', 'cagayan de oro city', 'Agusan del Norte', '9000', '2025-11-27', 'patag', 'birthday gift', 'cod', NULL, NULL, 2995.00, 100.00, 3095.00, 'cancelled', '2025-11-13 12:55:27', '2025-11-13 14:24:12'),
(19, 2, 'stephen plaza', '09475798243', 'stephenplaza2024@gmail.com', 'cagayan de oro city', 'Bohol', '9990', '2025-11-26', 'patag', 'birthday gift', 'gcash', 'GC12345678901234', 'uploads/orders/1763067358_61d69876a22c51a212dd.png', 3270.00, 100.00, 3370.00, 'delivered', '2025-11-13 12:55:58', '2025-11-13 12:57:05'),
(20, 2, 'stephen plaza', '09475798243', 'stephenplaza2024@gmail.com', 'cagayan de oro city', 'Bohol', '9990', '2025-11-20', 'patag', 'birthday gift', 'cod', NULL, NULL, 999.00, 100.00, 1099.00, 'cancelled', '2025-11-13 14:12:40', '2025-11-13 14:16:47'),
(21, 2, 'stephen plaza', '09475798243', 'stephenplaza2024@gmail.com', 'cagayan de oro city', 'Bohol', '9990', '2025-11-20', 'patag', 'birthday gift', 'cod', NULL, NULL, 1998.00, 100.00, 2098.00, 'pending', '2025-11-13 14:38:53', '2025-11-13 14:38:53'),
(22, 16, 'epoy sarip', '09452261475', 'epoysarip@gmail.com', 'Cagayan de oro City', 'Misamis Oriental', '9000', '2025-11-26', 'zone 2, lapasan Cagayan de Oro city', 'birthday message', 'gcash', '1234567890123', 'uploads/orders/1763099050_ac2b5f3513623b678f3a.jpg', 3395.00, 100.00, 3495.00, 'cancelled', '2025-11-13 21:44:11', '2025-11-13 22:02:18'),
(23, 16, 'kokoi', '09352261475', 'kokoi22@gmail.com', 'Cagayan de oro City', 'Misamis Oriental', '9000', '2025-11-18', 'zone 2, Kauswagan Cagayan de Oro city', '', 'gcash', '1234567890123', 'uploads/orders/1763101120_905684b23fe1b331e034.jpg', 6993.00, 100.00, 7093.00, 'preparing', '2025-11-13 22:18:40', '2025-11-13 22:22:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `order_item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`order_item_id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`, `subtotal`) VALUES
(17, 16, 4, 'Penelope', 699.00, 9, 6291.00),
(18, 17, 1, 'Red Roses', 1599.00, 4, 6396.00),
(19, 18, 6, 'Sunset Love', 599.00, 5, 2995.00),
(20, 19, 14, 'Hot Romance', 654.00, 5, 3270.00),
(21, 20, 3, 'Katie', 999.00, 1, 999.00),
(22, 21, 3, 'Katie', 999.00, 2, 1998.00),
(23, 22, 13, 'Roses Korean Style', 679.00, 5, 3395.00),
(24, 23, 3, 'Katie', 999.00, 7, 6993.00);

-- --------------------------------------------------------

--
-- Table structure for table `phone_numbers`
--

CREATE TABLE `phone_numbers` (
  `phone_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `phone_number` varchar(30) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `phone_numbers`
--

INSERT INTO `phone_numbers` (`phone_id`, `user_id`, `phone_number`, `type`, `created_at`, `updated_at`) VALUES
(1, 1, '09171234561', 'mobile', '2025-11-09 10:54:46', '2025-11-10 03:17:43'),
(8, 14, '09352261475', NULL, '2025-11-09 09:08:18', '2025-11-09 09:08:18'),
(9, 17, '09475798243', NULL, '2025-11-09 09:30:45', '2025-11-09 09:30:45'),
(12, 20, '09452261475', NULL, '2025-11-09 09:52:37', '2025-11-09 09:52:37'),
(15, 23, '09226147588', NULL, '2025-11-09 10:26:27', '2025-11-09 10:26:27'),
(16, 24, '09145632785', NULL, '2025-11-09 10:28:19', '2025-11-09 10:28:19');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(150) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `status` enum('high stock','low stock','out of stock') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `image`, `description`, `price`, `stock`, `category_id`, `created_at`, `status`) VALUES
(1, 'Red Roses', 'uploads/products/1762728791_dfbfd499e9c99e69a973.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 1599.00, 5, 2, '2025-11-10 06:53:11', 'low stock'),
(2, 'Sunburst', 'uploads/products/1762729748_3013335345c73b5ea5d7.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 2999.00, 0, 3, '2025-11-10 07:09:08', 'out of stock'),
(3, 'Katie', 'uploads/products/1762729808_0fe3e248a2d8c25a0670.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 999.00, 80, 1, '2025-11-10 07:10:08', 'high stock'),
(4, 'Penelope', 'uploads/products/1762729927_218bbdb9fb827db600b6.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 699.00, 40, 1, '2025-11-10 07:12:07', 'high stock'),
(5, 'Love in Full Bloom', 'uploads/products/1762730335_90baa7a9e79501e93e6d.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 1399.00, 25, 2, '2025-11-10 07:18:55', ''),
(6, 'Sunset Love', 'uploads/products/1762731175_6974bb8a28cde2d65ef1.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 599.00, 30, 3, '2025-11-10 07:32:55', ''),
(7, 'Edith', 'uploads/products/1762731378_41c760be673a66d736e2.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 499.00, 15, 3, '2025-11-10 07:36:18', 'low stock'),
(8, 'Purple Rain', 'uploads/products/1762731875_841ebc980c957c1d7c3d.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 1799.00, 25, 1, '2025-11-10 07:44:35', 'out of stock'),
(9, 'La Vie En Rose', 'uploads/products/1762732865_536ca6611fdc50096b28.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 2999.00, 100, 2, '2025-11-10 08:01:05', 'high stock'),
(10, 'Scarlette', 'uploads/products/1762732942_31f8ff8687ed5757141f.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 1899.00, 50, 1, '2025-11-10 08:02:22', 'high stock'),
(11, 'Citrus Kiss', 'uploads/products/1762733198_924e3b3f84d7d0365dd5.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 566.00, 65, 3, '2025-11-10 08:06:38', ''),
(13, 'Roses Korean Style', 'uploads/products/1762734372_3d0c08cb6800de1fe232.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 679.00, 100, 2, '2025-11-10 08:26:12', 'high stock'),
(14, 'Hot Romance', 'uploads/products/1762734568_d3357411f3b9435ed7be.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 654.00, 10, 2, '2025-11-10 08:29:28', 'low stock'),
(15, 'Violetta', 'uploads/products/1762734884_f096cd3ceafe9d3a8425.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 2199.00, 5, 1, '2025-11-10 08:34:44', 'low stock'),
(16, 'Liliana', 'uploads/products/Liliana.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 899.00, 15, 2, '2025-11-10 21:30:22', 'low stock'),
(18, 'Pixie Posy', 'uploads/products/Pixie Posy.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 245.00, 20, 9, '2025-11-10 21:50:55', NULL),
(19, 'Rosy Romance', 'uploads/products/Rosy Romance.webp', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. In semper massa lacus, eu condimentum felis placerat sed.', 750.00, 5, 2, '2025-11-12 05:07:22', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `role`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@gmail.com', '$2a$12$E4R900Hj/USkDRF25RvY8O4B.QLj3Zrp6zTY/i8IS5k7BIhwkBFSi', 'admin', 'default-avatar.jpg', 1, '2025-11-09 10:40:09', '2025-11-10 03:17:43'),
(2, 'Stephen Adolf', 'stephenadolf@gmail.com', '$2y$10$iLl6B/c8muvs31rjxjIjSOexMxgxFssCDhtVzqQdaftxjGrZPV29u', 'customer', 'customer1.png', 1, '2025-11-09 04:27:23', '2025-11-09 13:04:59'),
(14, 'mark', 'staff3@gmail.com', '$2y$10$YBh8uNAvKTOGVyP2XklTSeveJSyICYdOcid0gM5V5nWklggzoH/2W', 'staff', 'uploads/staff/staffprofile3.jpg', 0, '2025-11-09 09:08:18', '2025-11-13 05:04:10'),
(16, 'Dave lois', 'customer2@gmail.com', '$2y$10$1vazD3/MRRg/5rVfT36OPeabD4xguOf8Nn7Yu7k/2OfV3HFaPll0G', 'customer', 'customer2.png', 1, '2025-11-09 09:15:43', '2025-11-09 09:15:43'),
(17, 'Kesha Kate', 'staff1@gmail.com', '$2y$10$ijnBcDFHP6Z1Ug9uLg7UIuY46HvPcXRXkpYMFWERccrOqHwB06sdG', 'staff', 'uploads/staff/staffprofile1.jpg', 1, '2025-11-09 09:30:45', '2025-11-13 04:54:52'),
(20, 'Jester', 'staff2@gmail.com', '$2y$10$gcOa6Co3kaMPQ1v1IBbzX.YY84TI4W/lehb5/Ythj1F2fz9wWQsN2', 'staff', 'uploads/staff/staffprofile1.jpg', 0, '2025-11-09 09:52:37', '2025-11-13 05:04:02'),
(23, 'Ryan mark', 'staff4@gmail.com', '$2y$10$J8z/zs4PPbMcGbdNneXWHu8KNRwBZ4r/ZccyVv.t6uMn/L3H8RMUm', 'staff', 'uploads/staff/staffprofile1.jpg', 0, '2025-11-09 10:26:27', '2025-11-13 11:40:26'),
(24, 'Randolf', 'staff5@gmail.com', '$2y$10$AgivYqhw1pZBqmrZrwneWefwykraN4NpwsO5b3fnIQwajNu2dXi46', 'staff', 'uploads/staff/staffprofile1.jpg', 0, '2025-11-09 10:28:19', '2025-11-13 22:23:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`order_item_id`),
  ADD KEY `fk_order` (`order_id`),
  ADD KEY `fk_product` (`product_id`);

--
-- Indexes for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
  ADD PRIMARY KEY (`phone_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `order_item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
  MODIFY `phone_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Constraints for table `phone_numbers`
--
ALTER TABLE `phone_numbers`
  ADD CONSTRAINT `phone_numbers_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
