-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 26, 2024 at 07:13 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

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

-- --------------------------------------------------------

--
-- Table structure for table `tbl_categories`
--

CREATE TABLE `tbl_categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customers`
--

CREATE TABLE `tbl_customers` (
  `customer_guid` varchar(32) NOT NULL,
  `customer_id` varchar(8) DEFAULT NULL,
  `customer_name` varchar(100) DEFAULT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `customer_phone` varchar(20) DEFAULT NULL,
  `customer_address` varchar(255) DEFAULT NULL,
  `customer_city` varchar(100) DEFAULT NULL,
  `customer_country` varchar(100) DEFAULT NULL,
  `customer_image_path` varchar(200) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_images`
--

CREATE TABLE `tbl_images` (
  `image_id` int(11) NOT NULL,
  `image_path` varchar(200) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  `deleted` bit(1) DEFAULT NULL
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
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `permission_id` int(11) NOT NULL,
  `permission_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_products`
--

CREATE TABLE `tbl_products` (
  `product_guid` varchar(32) NOT NULL,
  `product_id` varchar(8) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `supplier_guid` varchar(32) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image_id` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles_permissions`
--

CREATE TABLE `tbl_roles_permissions` (
  `role_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_suppliers`
--

CREATE TABLE `tbl_suppliers` (
  `supplier_guid` varchar(32) NOT NULL,
  `supplier_id` varchar(8) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `supplier_email` varchar(255) DEFAULT NULL,
  `supplier_phone` varchar(20) DEFAULT NULL,
  `supplier_address` varchar(255) DEFAULT NULL,
  `supplier_city` varchar(100) DEFAULT NULL,
  `supplier_country` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` bit(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_userroles`
--

CREATE TABLE `tbl_userroles` (
  `user_guid` varchar(32) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `user_guid` varchar(32) NOT NULL,
  `user_id` varchar(8) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `update_date` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted` bit(1) DEFAULT b'0',
  `user_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`user_guid`, `user_id`, `user_name`, `user_email`, `created_date`, `update_date`, `deleted`, `user_password`) VALUES
('706b82ca0a6a07c5351502d1b53846a4', 'hoangvv2', 'Võ Văn Hoàng', 'vovanhoang1999@gmail.com', '2024-09-24 14:42:32', '2024-09-24 18:16:05', b'0', '1111'),
('97e0c9306b494d94d8b1e29544493758', 'hoangvv', 'Vũ Việt Hoàng', 'vuviethoang1941991@gmail.com', '2024-09-24 11:57:33', '2024-09-24 12:05:12', b'0', '123456');

--
-- Triggers `tbl_users`
--
DELIMITER $$
CREATE TRIGGER `insert_user_guid` BEFORE INSERT ON `tbl_users` FOR EACH ROW BEGIN
    -- Tạo mã user_guid duy nhất dựa trên MD5 của UUID
    SET NEW.user_guid = MD5(UUID());
    
    -- Thiết lập giá trị mặc định cho deleted nếu chưa được cung cấp
    IF NEW.deleted IS NULL THEN
        SET NEW.deleted = 0;
    END IF;
    
    -- Thiết lập ngày tạo (created_date) và cập nhật (update_date) mặc định
    SET NEW.created_date = CURRENT_TIMESTAMP;
    SET NEW.update_date = CURRENT_TIMESTAMP;
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
  ADD KEY `fk_customer_user` (`customer_id`);

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
  ADD KEY `supplier_guid` (`supplier_guid`),
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
  ADD PRIMARY KEY (`supplier_guid`);

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
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_categories`
--
ALTER TABLE `tbl_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_images`
--
ALTER TABLE `tbl_images`
  MODIFY `image_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `permission_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_customers`
--
ALTER TABLE `tbl_customers`
  ADD CONSTRAINT `fk_customer_user` FOREIGN KEY (`customer_id`) REFERENCES `tbl_users` (`user_id`);

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
  ADD CONSTRAINT `tbl_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `tbl_categories` (`category_id`),
  ADD CONSTRAINT `tbl_products_ibfk_2` FOREIGN KEY (`supplier_guid`) REFERENCES `tbl_suppliers` (`supplier_guid`),
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
