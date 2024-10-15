-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 15, 2024 at 09:29 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_aptech`
--
CREATE DATABASE IF NOT EXISTS `project_aptech` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `project_aptech`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`category_id`, `category_name`, `description`, `created_date`, `deleted`) VALUES
(1, 'Skincare', 'Products that cleanse, protect, and nourish the skin to maintain health', '2024-10-01 00:16:35', 0),
(2, 'Makeup', 'Cosmetic products used to enhance or alter the appearance of the face', '2024-10-01 00:16:35', 0),
(3, 'Haircare', 'Products designed to maintain or improve the condition and appearance of hair', '2024-10-01 00:16:35', 0),
(4, 'Bodycare', 'Products that cleanse, moisturize, and protect the skin on the body', '2024-10-01 00:16:35', 0),
(5, 'Fragrance', 'Perfumes and scented products used to provide a pleasant aroma', '2024-10-01 00:16:35', 0),
(6, 'Nailcare', 'Products that improve the appearance and health of nails and cuticles', '2024-10-01 00:16:35', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_guid` varchar(32) NOT NULL,
  `customer_code` varchar(100) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_password` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_city` varchar(100) DEFAULT NULL,
  `customer_country` varchar(100) DEFAULT NULL,
  `customer_image_path` varchar(200) DEFAULT NULL,
  `session_login` varchar(255) DEFAULT NULL,
  `session_date` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_customers`
--

INSERT INTO `tbl_customers` (`customer_guid`, `customer_code`, `customer_name`, `customer_email`, `customer_password`, `customer_phone`, `customer_address`, `customer_city`, `customer_country`, `customer_image_path`, `session_login`, `session_date`, `created_date`, `update_date`, `deleted`) VALUES
('56e79337-7f50-11ef-81a7-e0d55e8c', 'USR0001', 'Đỗ Hoàng Linh', 'DoHoangLinh@aptechlearning.edu.vn', '123456', '0366202085', '', 'Hà Nội', 'Việt Nam', NULL, NULL, NULL, '2024-10-01 00:20:50', '2024-10-08 01:18:54', 0),
('56e7a3e8-7f50-11ef-81a7-e0d55e8c', 'USR0002', 'Vũ Việt Hoàng', 'hoang.vv.2497@aptechlearning.edu.vn', '123456', '0324656042', '', 'Hà Nội', 'Việt Nam', 'Public/img/avatars/56e7a3e8-7f50-11ef-81a7-e0d55e8c20241015_192615.jpg', '0167cfe9065bbecc0213a13aca710d92', '2024-10-15 22:46:24', '2024-10-01 00:20:50', '2024-10-16 00:26:15', 0),
('56e7a53c-7f50-11ef-81a7-e0d55e8c', 'hoangvv2', 'Võ Văn Hoàng', 'vovanhoang1999@gmail.com', '123456', '0324673961', '', 'Hà Nội', 'Việt Nam', NULL, NULL, NULL, '2024-10-01 00:20:50', '2024-10-08 01:18:54', 0),
('56e7a5bb-7f50-11ef-81a7-e0d55e8c', 'hoangvv', 'Vũ Việt Hoàng', 'vuviethoang1941991@gmail.com', '123456', '0349401683', '', 'Hà Nội', 'Việt Nam', NULL, NULL, NULL, '2024-10-01 00:20:50', '2024-10-08 01:18:54', 0);

--
-- Triggers `tbl_customers`
--
DELIMITER $$
CREATE TRIGGER `insert_customer` BEFORE INSERT ON `tbl_customers` FOR EACH ROW BEGIN
    -- Kiểm tra trùng lặp customer_code
    IF EXISTS (SELECT 1 FROM tbl_customers WHERE customer_code = NEW.customer_code) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: customer_code already exists.';
    END IF;
    
    -- Tạo customer_guid tự động nếu không được cung cấp
    IF NEW.customer_guid IS NULL OR NEW.customer_guid = '' THEN
        SET NEW.customer_guid = UUID();
    END IF;
    
    -- Kiểm tra nếu customer_guid đã tồn tại thì tạo lại mã khác
    WHILE EXISTS (SELECT 1 FROM tbl_customers WHERE customer_guid = NEW.customer_guid) DO
        SET NEW.customer_guid = UUID();
    END WHILE;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `image_id` int(11) NOT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_images`
--

INSERT INTO `tbl_images` (`image_id`, `image_path`, `created_date`, `update_date`, `deleted`) VALUES
(1, 'Public/img/products/5d17831a-80e4-11ef-bef9-e0d55e8c20241015_205706.jpg', '2024-10-06 18:07:33', '2024-10-16 01:57:06', 0),
(2, 'Public/img/products/5d17831a-80e4-11ef-bef9-e0d55e8c20241015_212730.jpg', '2024-10-16 02:03:48', '2024-10-16 02:27:30', 0),
(3, 'http://example2.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(4, 'http://example3.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(5, 'http://example4.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(6, 'http://example5.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(7, 'http://example6.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(8, 'http://example7.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(9, 'http://example8.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(10, 'http://example9.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(11, 'http://example10.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(12, 'http://example11.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(13, 'http://example12.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(14, 'http://example13.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(15, 'http://example14.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(16, 'http://example15.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(17, 'http://example16.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(18, 'http://example17.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(19, 'http://example18.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(20, 'http://example19.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(21, 'http://example20.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(22, 'http://example21.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(23, 'http://example22.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(24, 'http://example23.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(25, 'http://example24.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(26, 'http://example25.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(27, 'http://example26.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(28, 'http://example27.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(29, 'http://example28.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(30, 'http://example29.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(31, 'http://example30.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(32, 'http://example31.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(33, 'http://example32.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(34, 'http://example33.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(35, 'http://example34.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(36, 'http://example35.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(37, 'http://example36.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(38, 'http://example37.com', '2024-10-16 02:03:48', '2024-10-16 02:03:48', 0),
(39, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(40, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(41, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(42, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(43, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(44, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(45, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(46, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(47, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(48, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(49, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(50, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(51, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(52, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(53, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(54, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(55, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(56, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(57, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(58, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(59, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(60, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(61, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(62, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(63, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(64, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(65, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(66, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(67, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(68, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0),
(69, NULL, '2024-10-16 02:26:23', '2024-10-16 02:26:23', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

CREATE TABLE `tbl_orders` (
  `order_guid` varchar(32) NOT NULL,
  `customer_guid` varchar(32) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders_details`
--

CREATE TABLE `tbl_orders_details` (
  `order_details_guid` varchar(32) NOT NULL,
  `order_guid` varchar(32) DEFAULT NULL,
  `product_guid` varchar(32) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`permission_id`, `permission_name`) VALUES
(1, 'READ'),
(2, 'ADD'),
(3, 'UPDATE'),
(4, 'DELETE');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_guid` varchar(32) NOT NULL,
  `product_code` varchar(8) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_code` varchar(8) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_products`
--

INSERT INTO `tbl_products` (`product_guid`, `product_code`, `product_name`, `category_id`, `supplier_code`, `price`, `stock`, `description`, `image_id`, `created_date`, `update_date`, `deleted`) VALUES
('5d128984-80e4-11ef-bef9-e0d55e8c', 'SK001', 'Hydrating Facial Cleanser', 1, 'LOR01', 15.99, 100, 'A gentle cleanser that hydrates and purifies the skin.', 1, '2024-10-03 00:32:57', '2024-10-13 22:17:04', 1),
('5d17831a-80e4-11ef-bef9-e0d55e8c', 'SK002', 'Moisturizing Lotion', 1, 'EST02', 18.99, 150, 'A rich lotion that deeply moisturizes and nourishes the skin.', 2, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d178fef-80e4-11ef-bef9-e0d55e8c', 'SK003', 'Anti-Aging Serum', 1, 'NIVE03', 29.99, 200, 'An advanced serum that reduces the appearance of fine lines.', 3, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24778a-80e4-11ef-bef9-e0d55e8c', 'SK004', 'Brightening Face Mask', 1, 'LAN04', 22.99, 80, 'A mask that brightens and revitalizes dull skin.', 4, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d247b00-80e4-11ef-bef9-e0d55e8c', 'SK005', 'Sunscreen SPF 50', 1, 'MAYB05', 12.99, 120, 'A lightweight sunscreen that provides broad-spectrum protection.', 5, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d247d7b-80e4-11ef-bef9-e0d55e8c', 'SK006', 'Gentle Exfoliator', 1, 'REVL06', 19.99, 90, 'A gentle exfoliating scrub that removes dead skin cells.', 6, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d248349-80e4-11ef-bef9-e0d55e8c', 'SK007', 'Face Oil', 1, 'MAC07', 25.99, 110, 'A nourishing oil that provides hydration and radiance.', 7, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24865a-80e4-11ef-bef9-e0d55e8c', 'SK008', 'Night Cream', 1, 'DOVE08', 24.99, 130, 'A rich night cream that hydrates and repairs the skin overnight.', 8, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2488f1-80e4-11ef-bef9-e0d55e8c', 'SK009', 'Cleansing Water', 1, 'LOR01', 15.49, 160, 'A cleansing water that removes makeup and impurities.', 9, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d248b73-80e4-11ef-bef9-e0d55e8c', 'SK010', 'Hydrating Mask', 1, 'EST02', 20.99, 70, 'A hydrating mask that leaves skin plump and dewy.', 10, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d248ddd-80e4-11ef-bef9-e0d55e8c', 'SK011', 'Facial Mist', 1, 'NIVE03', 13.99, 140, 'A refreshing mist that hydrates and soothes the skin.', 11, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249669-80e4-11ef-bef9-e0d55e8c', 'SK012', 'Pore Minimizer', 1, 'LAN04', 27.99, 75, 'A primer that minimizes the appearance of pores.', 12, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249954-80e4-11ef-bef9-e0d55e8c', 'SK013', 'Firming Eye Cream', 1, 'MAYB05', 29.99, 50, 'An eye cream that firms and brightens the eye area.', 13, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249be0-80e4-11ef-bef9-e0d55e8c', 'SK014', 'Peeling Gel', 1, 'REVL06', 18.49, 85, 'A gel that gently removes dead skin and impurities.', 14, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249e63-80e4-11ef-bef9-e0d55e8c', 'SK015', 'Revitalizing Serum', 1, 'MAC07', 32.99, 65, 'A serum that revitalizes and restores skin elasticity.', 15, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24a0d0-80e4-11ef-bef9-e0d55e8c', 'MK001', 'Foundation', 2, 'LOR01', 30.99, 200, 'A full-coverage foundation that lasts all day.', 16, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24a3aa-80e4-11ef-bef9-e0d55e8c', 'MK002', 'Lipstick', 2, 'EST02', 15.99, 150, 'A matte lipstick with intense color pay-off.', 17, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24a615-80e4-11ef-bef9-e0d55e8c', 'MK003', 'Eyeshadow Palette', 2, 'NIVE03', 35.99, 120, 'A palette with 12 versatile shades for endless looks.', 18, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24ab1e-80e4-11ef-bef9-e0d55e8c', 'MK004', 'Mascara', 2, 'LAN04', 19.99, 180, 'A volumizing mascara that lifts and defines lashes.', 19, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24aea5-80e4-11ef-bef9-e0d55e8c', 'MK005', 'Blush', 2, 'MAYB05', 12.99, 200, 'A powder blush that gives a natural flush.', 20, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b165-80e4-11ef-bef9-e0d55e8c', 'MK006', 'Highlighter', 2, 'REVL06', 14.99, 160, 'A shimmering highlighter for a radiant glow.', 21, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b3f6-80e4-11ef-bef9-e0d55e8c', 'MK007', 'Bronzer', 2, 'MAC07', 16.99, 140, 'A bronzer that adds warmth and dimension to the face.', 22, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b68e-80e4-11ef-bef9-e0d55e8c', 'MK008', 'Setting Spray', 2, 'LOR01', 21.99, 110, 'A setting spray that locks in makeup all day.', 23, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b89c-80e4-11ef-bef9-e0d55e8c', 'MK009', 'Makeup Remover', 2, 'EST02', 11.99, 90, 'A gentle makeup remover that cleanses the skin.', 24, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24bc61-80e4-11ef-bef9-e0d55e8c', 'MK010', 'Nail Polish', 2, 'NIVE03', 7.99, 80, 'A long-lasting nail polish in vibrant colors.', 25, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24bf04-80e4-11ef-bef9-e0d55e8c', 'MK011', 'Lip Gloss', 2, 'LAN04', 9.99, 60, 'A glossy lip product that hydrates and adds shine.', 26, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24c0a5-80e4-11ef-bef9-e0d55e8c', 'MK012', 'Makeup Brush Set', 2, 'MAYB05', 49.99, 50, 'A set of professional brushes for flawless application.', 27, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24c38f-80e4-11ef-bef9-e0d55e8c', 'MK013', 'Face Primer', 2, 'REVL06', 28.99, 40, 'A smoothing primer that preps the skin for makeup.', 28, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24c5a0-80e4-11ef-bef9-e0d55e8c', 'MK014', 'Brow Gel', 2, 'MAC07', 12.49, 90, 'A brow gel that shapes and sets brows in place.', 29, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24c7c6-80e4-11ef-bef9-e0d55e8c', 'MK015', 'Lip Balm', 2, 'LOR01', 6.99, 150, 'A nourishing lip balm that hydrates and protects.', 30, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24ca9e-80e4-11ef-bef9-e0d55e8c', 'BK001', 'Novel - The Great Gatsby', 3, 'LOR01', 14.99, 300, 'A classic novel by F. Scott Fitzgerald.', 31, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24cd67-80e4-11ef-bef9-e0d55e8c', 'BK002', 'Self-Help - The Power of Habit', 3, 'EST02', 16.99, 200, 'A guide to building good habits and breaking bad ones.', 32, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24cf43-80e4-11ef-bef9-e0d55e8c', 'BK003', 'Biography - Steve Jobs', 3, 'NIVE03', 18.99, 150, 'The life story of Steve Jobs, co-founder of Apple Inc.', 33, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24d1ab-80e4-11ef-bef9-e0d55e8c', 'BK004', 'Cookbook - The Joy of Cooking', 3, 'LAN04', 29.99, 80, 'A comprehensive cookbook with a variety of recipes.', 34, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24d48a-80e4-11ef-bef9-e0d55e8c', 'BK005', 'Mystery - Gone Girl', 3, 'MAYB05', 19.99, 120, 'A psychological thriller about a marriage gone wrong.', 35, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24d6da-80e4-11ef-bef9-e0d55e8c', 'BK006', 'Fiction - To Kill a Mockingbird', 3, 'REVL06', 22.99, 90, 'A novel about racial injustice in the Deep South.', 36, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24d9c3-80e4-11ef-bef9-e0d55e8c', 'BK007', 'Fantasy - Harry Potter and the Sorcerer\'s Stone', 3, 'MAC07', 24.99, 150, 'The first book in the Harry Potter series.', 37, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24dc22-80e4-11ef-bef9-e0d55e8c', 'BK008', 'Science - A Brief History of Time', 3, 'LOR01', 28.99, 200, 'A popular science book by Stephen Hawking.', 38, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24de9b-80e4-11ef-bef9-e0d55e8c', 'BK009', 'Health - How Not to Die', 3, 'EST02', 16.49, 180, 'A guide to living a healthier life.', 39, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24e079-80e4-11ef-bef9-e0d55e8c', 'BK010', 'History - Sapiens: A Brief History of Humankind', 3, 'NIVE03', 25.99, 70, 'A thought-provoking history of humanity.', 40, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24e28d-80e4-11ef-bef9-e0d55e8c', 'BK011', 'Poetry - The Sun and Her Flowers', 3, 'LAN04', 19.99, 65, 'A beautiful collection of poetry.', 41, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24e44d-80e4-11ef-bef9-e0d55e8c', 'BK012', 'Children - The Very Hungry Caterpillar', 3, 'MAYB05', 9.99, 100, 'A classic children\'s book.', 42, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24e68e-80e4-11ef-bef9-e0d55e8c', 'BK013', 'Graphic Novel - Watchmen', 3, 'REVL06', 29.99, 80, 'A groundbreaking graphic novel.', 43, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24e8d8-80e4-11ef-bef9-e0d55e8c', 'BK014', 'Mystery - The Girl with the Dragon Tattoo', 3, 'MAC07', 21.99, 120, 'A mystery novel with a strong female lead.', 44, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24eb7d-80e4-11ef-bef9-e0d55e8c', 'BK015', 'Historical Fiction - The Nightingale', 3, 'LOR01', 18.99, 90, 'A novel set during World War II.', 45, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24ee4f-80e4-11ef-bef9-e0d55e8c', 'BK016', 'Fantasy - The Hobbit', 3, 'EST02', 17.99, 150, 'A fantasy novel about a hobbit\'s adventure.', 46, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24f067-80e4-11ef-bef9-e0d55e8c', 'BK017', 'Science Fiction - Dune', 3, 'NIVE03', 29.99, 70, 'A science fiction epic set on a desert planet.', 47, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24f44e-80e4-11ef-bef9-e0d55e8c', 'BK018', 'Classic - Pride and Prejudice', 3, 'LAN04', 15.99, 180, 'A classic novel by Jane Austen.', 48, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24f658-80e4-11ef-bef9-e0d55e8c', 'BK019', 'Graphic Novel - Maus', 3, 'MAYB05', 22.99, 75, 'A Pulitzer Prize-winning graphic novel.', 49, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24f877-80e4-11ef-bef9-e0d55e8c', 'BK020', 'Biography - Becoming', 3, 'REVL06', 24.99, 60, 'The memoir of Michelle Obama.', 50, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24fa35-80e4-11ef-bef9-e0d55e8c', 'BK021', 'Fantasy - The Name of the Wind', 3, 'MAC07', 29.99, 90, 'A fantasy novel by Patrick Rothfuss.', 51, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24fdb1-80e4-11ef-bef9-e0d55e8c', 'BK022', 'Historical Fiction - The Book Thief', 3, 'LOR01', 18.99, 120, 'A novel narrated by Death.', 52, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2501e0-80e4-11ef-bef9-e0d55e8c', 'BK023', 'Science - The Selfish Gene', 3, 'EST02', 20.49, 100, 'A book on evolution and genetics.', 53, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2503f6-80e4-11ef-bef9-e0d55e8c', 'BK024', 'Non-Fiction - Educated', 3, 'NIVE03', 24.99, 80, 'A memoir about education and self-discovery.', 54, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d250628-80e4-11ef-bef9-e0d55e8c', 'BK025', 'Poetry - Milk and Honey', 3, 'LAN04', 16.99, 75, 'A collection of poetry about survival and love.', 55, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d250854-80e4-11ef-bef9-e0d55e8c', 'BK026', 'Graphic Novel - Persepolis', 3, 'MAYB05', 22.99, 60, 'A graphic memoir about growing up in Iran.', 56, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d250a9a-80e4-11ef-bef9-e0d55e8c', 'BK027', 'Mystery - The Da Vinci Code', 3, 'REVL06', 18.99, 150, 'A mystery thriller involving art and history.', 57, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d250d04-80e4-11ef-bef9-e0d55e8c', 'BK028', 'Science Fiction - The Martian', 3, 'MAC07', 29.99, 90, 'A science fiction novel about an astronaut stranded on Mars.', 58, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d250f44-80e4-11ef-bef9-e0d55e8c', 'BK029', 'Classic - 1984', 3, 'LOR01', 15.99, 110, 'A dystopian novel by George Orwell.', 59, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2511d9-80e4-11ef-bef9-e0d55e8c', 'BK030', 'Historical Fiction - The Night Circus', 3, 'EST02', 24.99, 75, 'A magical tale set in a mysterious circus.', 60, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0);

--
-- Triggers `tbl_products`
--
DELIMITER $$
CREATE TRIGGER `before_insert_product` BEFORE INSERT ON `tbl_products` FOR EACH ROW BEGIN
    -- Kiểm tra trùng lặp product_code
    IF EXISTS (SELECT 1 FROM tbl_products WHERE product_code = NEW.product_code) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: product_code already exists.';
    END IF;
    
    -- Tạo product_guid tự động nếu không được cung cấp
    IF NEW.product_guid IS NULL OR NEW.product_guid = '' THEN
        SET NEW.product_guid = UUID();
    END IF;
    
    -- Kiểm tra nếu product_guid đã tồn tại thì tạo lại mã khác
    WHILE EXISTS (SELECT 1 FROM tbl_products WHERE product_guid = NEW.product_guid) DO
        SET NEW.product_guid = UUID();
    END WHILE;
    
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`role_id`, `role_name`, `created_date`, `update_date`, `deleted`) VALUES
(1, 'home', '2024-10-03 00:14:12', '2024-10-03 00:14:12', 0),
(2, 'products', '2024-10-03 00:14:12', '2024-10-03 00:14:12', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles_permissions`
--

CREATE TABLE `tbl_roles_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_roles_permissions`
--

INSERT INTO `tbl_roles_permissions` (`role_id`, `permission_id`, `created_date`, `update_date`, `deleted`) VALUES
(1, 1, '2024-10-03 00:19:57', '2024-10-03 00:19:57', 0),
(2, 1, '2024-10-03 00:19:57', '2024-10-03 00:19:57', 0),
(2, 2, '2024-10-03 00:19:57', '2024-10-03 00:19:57', 0),
(2, 3, '2024-10-03 00:19:57', '2024-10-03 00:19:57', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

CREATE TABLE `tbl_suppliers` (
  `supplier_guid` varchar(32) NOT NULL,
  `supplier_code` varchar(8) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_phone` varchar(20) DEFAULT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `supplier_city` varchar(100) DEFAULT NULL,
  `supplier_country` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_suppliers`
--

INSERT INTO `tbl_suppliers` (`supplier_guid`, `supplier_code`, `supplier_name`, `contact_name`, `supplier_email`, `supplier_phone`, `supplier_address`, `supplier_city`, `supplier_country`, `created_date`, `update_date`, `deleted`) VALUES
('292ce2bc-7f53-11ef-81a7-e0d55e8c', 'LOR01', 'L\'Oréal', 'Jane Doe', 'contact@loreal.com', '0301234567', '1 L\'Oréal St', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292e6544-7f53-11ef-81a7-e0d55e8c', 'EST02', 'Estée Lauder', 'John Smith', 'contact@estee.com', '0301234568', '2 Estée Lauder Rd', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292ec306-7f53-11ef-81a7-e0d55e8c', 'NIVE03', 'Nivea', 'Alice Johnson', 'contact@nivea.com', '0301234569', '3 Nivea Ave', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292ecafd-7f53-11ef-81a7-e0d55e8c', 'LAN04', 'Lancôme', 'Emily White', 'contact@lancome.com', '0301234570', '4 Lancôme Blvd', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292ed0f1-7f53-11ef-81a7-e0d55e8c', 'MAYB05', 'Maybelline', 'Chris Green', 'contact@maybelline.com', '0301234571', '5 Maybelline Pkwy', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292ed764-7f53-11ef-81a7-e0d55e8c', 'REVL06', 'Revlon', 'Laura Black', 'contact@revlon.com', '0301234572', '6 Revlon Dr', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292eda38-7f53-11ef-81a7-e0d55e8c', 'MAC07', 'MAC Cosmetics', 'Robert Blue', 'contact@mac.com', '0301234573', '7 MAC St', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0),
('292eeec0-7f53-11ef-81a7-e0d55e8c', 'DOVE08', 'Dove', 'Patricia Red', 'contact@dove.com', '0301234574', '8 Dove Ln', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-16 01:33:51', 0);

--
-- Triggers `tbl_suppliers`
--
DELIMITER $$
CREATE TRIGGER `before_insert_supplier` BEFORE INSERT ON `tbl_suppliers` FOR EACH ROW BEGIN
    -- Kiểm tra trùng lặp supplier_code
    IF EXISTS (SELECT 1 FROM tbl_suppliers WHERE supplier_code = NEW.supplier_code) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'Error: supplier_code already exists.';
    END IF;

    -- Tạo supplier_guid tự động nếu không được cung cấp
    IF NEW.supplier_guid IS NULL OR NEW.supplier_guid = '' THEN
        SET NEW.supplier_guid = UUID();
    END IF;

    -- Kiểm tra nếu supplier_guid đã tồn tại thì tạo lại mã khác
    WHILE EXISTS (SELECT 1 FROM tbl_suppliers WHERE supplier_guid = NEW.supplier_guid) DO
        SET NEW.supplier_guid = UUID();
    END WHILE;

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userroles`
--

CREATE TABLE `tbl_userroles` (
  `user_guid` varchar(32) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_userroles`
--

INSERT INTO `tbl_userroles` (`user_guid`, `role_id`, `created_date`, `update_date`, `deleted`) VALUES
('04abcb0efc3172fe0dba06809d56b60a', 1, '2024-10-03 00:24:55', '2024-10-03 00:24:55', 0),
('706b82ca0a6a07c5351502d1b53846a4', 2, '2024-10-03 00:24:55', '2024-10-03 00:24:55', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_guid` varchar(32) NOT NULL,
  `user_name` varchar(8) NOT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` tinyint(1) DEFAULT 0,
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_guid`, `user_name`, `full_name`, `user_email`, `created_date`, `update_date`, `deleted`, `user_password`) VALUES
('04abcb0efc3172fe0dba06809d56b60a', 'USR0001', 'Đỗ Hoàng Linh', 'DoHoangLinh@aptechlearning.edu.vn', '2024-10-01 00:00:14', '2024-10-01 00:00:14', 0, '123456'),
('6c35cb8a7c9a84154c7716f3a60d1f31', 'USR0002', 'Vũ Việt Hoàng', 'hoang.vv.2497@aptechlearning.edu.vn', '2024-10-01 00:00:14', '2024-10-01 00:00:14', 0, '123456'),
('706b82ca0a6a07c5351502d1b53846a4', 'hoangvv2', 'Võ Văn Hoàng', 'vovanhoang1999@gmail.com', '2024-09-24 14:42:32', '2024-09-24 18:16:05', 0, '1111'),
('97e0c9306b494d94d8b1e29544493758', 'hoangvv', 'Vũ Việt Hoàng', 'vuviethoang1941991@gmail.com', '2024-09-24 11:57:33', '2024-09-24 12:05:12', 0, '123456');

--
-- Triggers `tbl_users`
--
DELIMITER $$
CREATE TRIGGER `insert_user` BEFORE INSERT ON `tbl_users` FOR EACH ROW BEGIN
    -- Kiểm tra trùng user_name
    IF EXISTS (SELECT 1 FROM tbl_users WHERE user_name = NEW.user_name) THEN
        SIGNAL SQLSTATE '45000' 
        SET MESSAGE_TEXT = 'User name đã tồn tại';
    END IF;
    
    -- Tạo mã MD5 cho user_guid và kiểm tra trùng
    SET NEW.user_guid = MD5(UUID());
    
    WHILE EXISTS (SELECT 1 FROM tbl_users WHERE user_guid = NEW.user_guid) DO
        SET NEW.user_guid = MD5(UUID());
    END WHILE;
    
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD PRIMARY KEY (`customer_guid`),
  ADD KEY `fk_customer_user` (`customer_email`);

--
-- Indexes for table `tbl_images`
--
ALTER TABLE `tbl_images`
  ADD PRIMARY KEY (`image_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`order_guid`),
  ADD KEY `customer_guid` (`customer_guid`);

--
-- Indexes for table `tbl_orders_details`
--
ALTER TABLE `tbl_orders_details`
  ADD PRIMARY KEY (`order_details_guid`),
  ADD KEY `order_guid` (`order_guid`),
  ADD KEY `product_guid` (`product_guid`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`permission_id`);

--
-- Indexes for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`product_guid`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `supplier_code` (`supplier_code`),
  ADD KEY `image_id` (`image_id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `tbl_roles_permissions`
--
ALTER TABLE `tbl_roles_permissions`
  ADD PRIMARY KEY (`role_id`,`permission_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `tbl_suppliers`
--
ALTER TABLE `tbl_suppliers`
  ADD PRIMARY KEY (`supplier_guid`),
  ADD KEY `supplier_code` (`supplier_code`);

--
-- Indexes for table `tbl_userroles`
--
ALTER TABLE `tbl_userroles`
  ADD PRIMARY KEY (`user_guid`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_guid`),
  ADD UNIQUE KEY `user_email` (`user_email`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD CONSTRAINT `tbl_orders_ibfk_1` FOREIGN KEY (`customer_guid`) REFERENCES `tbl_customers` (`customer_guid`);

--
-- Constraints for table `tbl_orders_details`
--
ALTER TABLE `tbl_orders_details`
  ADD CONSTRAINT `tbl_orders_details_ibfk_1` FOREIGN KEY (`order_guid`) REFERENCES `tbl_orders` (`order_guid`),
  ADD CONSTRAINT `tbl_orders_details_ibfk_2` FOREIGN KEY (`product_guid`) REFERENCES `tbl_products` (`product_guid`);

--
-- Constraints for table `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `fk_products_categories` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tbl_products_ibfk_2` FOREIGN KEY (`supplier_code`) REFERENCES `tbl_suppliers` (`supplier_code`),
  ADD CONSTRAINT `tbl_products_ibfk_3` FOREIGN KEY (`image_id`) REFERENCES `tbl_images` (`image_id`);

--
-- Constraints for table `tbl_roles_permissions`
--
ALTER TABLE `tbl_roles_permissions`
  ADD CONSTRAINT `tbl_roles_permissions_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`role_id`),
  ADD CONSTRAINT `tbl_roles_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `tbl_permissions` (`permission_id`);

--
-- Constraints for table `tbl_userroles`
--
ALTER TABLE `tbl_userroles`
  ADD CONSTRAINT `tbl_userroles_ibfk_1` FOREIGN KEY (`user_guid`) REFERENCES `tbl_users` (`user_guid`),
  ADD CONSTRAINT `tbl_userroles_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `tbl_roles` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
