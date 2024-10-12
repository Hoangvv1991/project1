-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 12, 2024 at 12:42 PM
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
(1, 'Skincare', 'Products that cleanse, protect, and nourish the skin to maintain health', '2024-10-01 00:16:35', NULL),
(2, 'Makeup', 'Cosmetic products used to enhance or alter the appearance of the face', '2024-10-01 00:16:35', NULL),
(3, 'Haircare', 'Products designed to maintain or improve the condition and appearance of hair', '2024-10-01 00:16:35', NULL),
(4, 'Bodycare', 'Products that cleanse, moisturize, and protect the skin on the body', '2024-10-01 00:16:35', NULL),
(5, 'Fragrance', 'Perfumes and scented products used to provide a pleasant aroma', '2024-10-01 00:16:35', NULL),
(6, 'Nailcare', 'Products that improve the appearance and health of nails and cuticles', '2024-10-01 00:16:35', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_guid` varchar(32) NOT NULL,
  `customer_code` varchar(8) DEFAULT NULL,
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
('56e7a3e8-7f50-11ef-81a7-e0d55e8c', 'USR0002', 'Vũ Việt Hoàng', 'hoang.vv.2497@aptechlearning.edu.vn', '123456', '0324656042', '', 'Hà Nội', 'Việt Nam', NULL, '4985bca07c795a17fe806fc81e2c6934', '2024-10-10 00:57:20', '2024-10-01 00:20:50', '2024-10-10 00:57:20', 0),
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
(1, 'public/img/1256600_slot2.jpg', '2024-10-06 18:07:33', '2024-10-06 18:07:33', 0);

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
('5d128984-80e4-11ef-bef9-e0d55e8c', 'SK001', 'Hydrating Facial Cleanser', 1, 'LOR01', 15.99, 100, 'A gentle cleanser that hydrates and purifies the skin.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d17831a-80e4-11ef-bef9-e0d55e8c', 'SK002', 'Moisturizing Lotion', 1, 'EST02', 18.99, 150, 'A rich lotion that deeply moisturizes and nourishes the skin.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d178fef-80e4-11ef-bef9-e0d55e8c', 'SK003', 'Anti-Aging Serum', 1, 'NIVE03', 29.99, 200, 'An advanced serum that reduces the appearance of fine lines.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24778a-80e4-11ef-bef9-e0d55e8c', 'SK004', 'Brightening Face Mask', 1, 'LAN04', 22.99, 80, 'A mask that brightens and revitalizes dull skin.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d247b00-80e4-11ef-bef9-e0d55e8c', 'SK005', 'Sunscreen SPF 50', 1, 'MAYB05', 12.99, 120, 'A lightweight sunscreen that provides broad-spectrum protection.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d247d7b-80e4-11ef-bef9-e0d55e8c', 'SK006', 'Gentle Exfoliator', 1, 'REVL06', 19.99, 90, 'A gentle exfoliating scrub that removes dead skin cells.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d248349-80e4-11ef-bef9-e0d55e8c', 'SK007', 'Face Oil', 1, 'MAC07', 25.99, 110, 'A nourishing oil that provides hydration and radiance.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24865a-80e4-11ef-bef9-e0d55e8c', 'SK008', 'Night Cream', 1, 'DOVE08', 24.99, 130, 'A rich night cream that hydrates and repairs the skin overnight.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2488f1-80e4-11ef-bef9-e0d55e8c', 'SK009', 'Cleansing Water', 1, 'LOR01', 15.49, 160, 'A cleansing water that removes makeup and impurities.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d248b73-80e4-11ef-bef9-e0d55e8c', 'SK010', 'Hydrating Mask', 1, 'EST02', 20.99, 70, 'A hydrating mask that leaves skin plump and dewy.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d248ddd-80e4-11ef-bef9-e0d55e8c', 'SK011', 'Facial Mist', 1, 'NIVE03', 13.99, 140, 'A refreshing mist that hydrates and soothes the skin.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249669-80e4-11ef-bef9-e0d55e8c', 'SK012', 'Pore Minimizer', 1, 'LAN04', 27.99, 75, 'A primer that minimizes the appearance of pores.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249954-80e4-11ef-bef9-e0d55e8c', 'SK013', 'Firming Eye Cream', 1, 'MAYB05', 29.99, 50, 'An eye cream that firms and brightens the eye area.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249be0-80e4-11ef-bef9-e0d55e8c', 'SK014', 'Peeling Gel', 1, 'REVL06', 18.49, 85, 'A gel that gently removes dead skin and impurities.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d249e63-80e4-11ef-bef9-e0d55e8c', 'SK015', 'Revitalizing Serum', 1, 'MAC07', 32.99, 65, 'A serum that revitalizes and restores skin elasticity.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24a0d0-80e4-11ef-bef9-e0d55e8c', 'MK001', 'Foundation', 2, 'LOR01', 30.99, 200, 'A full-coverage foundation that lasts all day.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24a3aa-80e4-11ef-bef9-e0d55e8c', 'MK002', 'Lipstick', 2, 'EST02', 15.99, 150, 'A matte lipstick with intense color pay-off.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24a615-80e4-11ef-bef9-e0d55e8c', 'MK003', 'Eyeshadow Palette', 2, 'NIVE03', 35.99, 120, 'A palette with 12 versatile shades for endless looks.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24ab1e-80e4-11ef-bef9-e0d55e8c', 'MK004', 'Mascara', 2, 'LAN04', 19.99, 180, 'A volumizing mascara that lifts and defines lashes.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24aea5-80e4-11ef-bef9-e0d55e8c', 'MK005', 'Blush', 2, 'MAYB05', 12.99, 200, 'A powder blush that gives a natural flush.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b165-80e4-11ef-bef9-e0d55e8c', 'MK006', 'Highlighter', 2, 'REVL06', 14.99, 160, 'A shimmering highlighter for a radiant glow.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b400-80e4-11ef-bef9-e0d55e8c', 'MK007', 'Eyeliner', 2, 'MAC07', 16.99, 140, 'A long-lasting eyeliner that glides on smoothly.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b6df-80e4-11ef-bef9-e0d55e8c', 'MK008', 'Setting Spray', 2, 'DOVE08', 18.49, 130, 'A setting spray that keeps makeup in place all day.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24b973-80e4-11ef-bef9-e0d55e8c', 'MK009', 'Lip Gloss', 2, 'LOR01', 11.99, 190, 'A shiny lip gloss that adds volume to lips.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24bbf6-80e4-11ef-bef9-e0d55e8c', 'MK010', 'BB Cream', 2, 'EST02', 22.99, 110, 'A lightweight BB cream that evens out skin tone.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d24e2e9-80e4-11ef-bef9-e0d55e8c', 'MK011', 'Makeup Remover', 2, 'NIVE03', 9.99, 250, 'A gentle makeup remover that cleanses without irritation.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d250ce6-80e4-11ef-bef9-e0d55e8c', 'MK012', 'Contour Kit', 2, 'LAN04', 28.99, 75, 'A contour kit that sculpts and defines facial features.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d251c8a-80e4-11ef-bef9-e0d55e8c', 'MK013', 'Lip Liner', 2, 'MAYB05', 13.49, 140, 'A creamy lip liner that defines lips perfectly.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d252e8d-80e4-11ef-bef9-e0d55e8c', 'MK014', 'Setting Powder', 2, 'REVL06', 15.99, 120, 'A translucent powder that sets makeup for a flawless finish.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2539c4-80e4-11ef-bef9-e0d55e8c', 'MK015', 'Makeup Brush Set', 2, 'MAC07', 45.99, 50, 'A set of high-quality brushes for flawless application.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d253d0a-80e4-11ef-bef9-e0d55e8c', 'HC001', 'Shampoo', 3, 'LOR01', 12.99, 150, 'A nourishing shampoo for healthy hair.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d253fe6-80e4-11ef-bef9-e0d55e8c', 'HC002', 'Conditioner', 3, 'EST02', 13.99, 150, 'A moisturizing conditioner that leaves hair soft.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2542bb-80e4-11ef-bef9-e0d55e8c', 'HC003', 'Hair Mask', 3, 'NIVE03', 14.99, 100, 'A deep conditioning hair mask for damaged hair.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d2547b5-80e4-11ef-bef9-e0d55e8c', 'HC004', 'Hair Oil', 3, 'LAN04', 19.99, 90, 'A lightweight hair oil that adds shine.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d254bbc-80e4-11ef-bef9-e0d55e8c', 'BC001', 'Body Wash', 4, 'MAYB05', 9.99, 200, 'A refreshing body wash that cleanses the skin.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d256c4b-80e4-11ef-bef9-e0d55e8c', 'BC002', 'Body Lotion', 4, 'REVL06', 11.99, 150, 'A moisturizing body lotion that hydrates the skin.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d25764a-80e4-11ef-bef9-e0d55e8c', 'FR001', 'Perfume', 5, 'MAC07', 49.99, 100, 'A long-lasting perfume with a floral scent.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0),
('5d257c2e-80e4-11ef-bef9-e0d55e8c', 'FR002', 'Body Spray', 5, 'DOVE08', 15.99, 120, 'A light body spray for a refreshing scent.', 1, '2024-10-03 00:32:57', '2024-10-06 18:07:40', 0);

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
('292ce2bc-7f53-11ef-81a7-e0d55e8c', 'LOR01', 'L\'Oréal', 'Jane Doe', 'contact@loreal.com', '0301234567', '1 L\'Oréal St', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292e6544-7f53-11ef-81a7-e0d55e8c', 'EST02', 'Estée Lauder', 'John Smith', 'contact@estee.com', '0301234568', '2 Estée Lauder Rd', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292ec306-7f53-11ef-81a7-e0d55e8c', 'NIVE03', 'Nivea', 'Alice Johnson', 'contact@nivea.com', '0301234569', '3 Nivea Ave', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292ecafd-7f53-11ef-81a7-e0d55e8c', 'LAN04', 'Lancôme', 'Emily White', 'contact@lancome.com', '0301234570', '4 Lancôme Blvd', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292ed0f1-7f53-11ef-81a7-e0d55e8c', 'MAYB05', 'Maybelline', 'Chris Green', 'contact@maybelline.com', '0301234571', '5 Maybelline Pkwy', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292ed764-7f53-11ef-81a7-e0d55e8c', 'REVL06', 'Revlon', 'Laura Black', 'contact@revlon.com', '0301234572', '6 Revlon Dr', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292eda38-7f53-11ef-81a7-e0d55e8c', 'MAC07', 'MAC Cosmetics', 'Robert Blue', 'contact@mac.com', '0301234573', '7 MAC St', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL),
('292eeec0-7f53-11ef-81a7-e0d55e8c', 'DOVE08', 'Dove', 'Patricia Red', 'contact@dove.com', '0301234574', '8 Dove Ln', 'Hanoi', 'Vietnam', '2024-10-01 00:41:02', '2024-10-01 00:41:02', NULL);

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
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- Constraints for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD CONSTRAINT `fk_customer_user` FOREIGN KEY (`customer_email`) REFERENCES `tbl_users` (`user_email`);

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
