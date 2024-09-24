-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 24, 2024 lúc 08:45 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_aptech`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_users`
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
-- Đang đổ dữ liệu cho bảng `tbl_users`
--

INSERT INTO `tbl_users` (`user_guid`, `user_id`, `user_name`, `user_email`, `created_date`, `update_date`, `deleted`, `user_password`) VALUES
('97e0c9306b494d94d8b1e29544493758', 'hoangvv', 'Vũ Việt Hoàng', 'vuviethoang1941991@gmail.com', '2024-09-24 11:57:33', '2024-09-24 12:05:12', b'0', '123456');

--
-- Bẫy `tbl_users`
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
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`user_guid`),
  ADD UNIQUE KEY `user_id` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
