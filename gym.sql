-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th9 23, 2024 lúc 09:47 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `gym`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bycource`
--

CREATE TABLE `bycource` (
  `id` int(11) NOT NULL,
  `email` varchar(20) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `plan` varchar(10) NOT NULL,
  `cource` varchar(50) DEFAULT NULL,
  `pt` varchar(50) DEFAULT NULL,
  `price` varchar(50) NOT NULL,
  `createAt` datetime NOT NULL,
  `end` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `pt_id` int(11) NOT NULL,
  `cource_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cource`
--

CREATE TABLE `cource` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `description` varchar(255) NOT NULL,
  `time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cource`
--

INSERT INTO `cource` (`id`, `name`, `price`, `description`, `time`) VALUES
(5, 'tập thể hình cân đối', 120000, 'giúp có thân hình đẹp', 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login_token`
--

CREATE TABLE `login_token` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `token` int(11) NOT NULL,
  `createAt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `login_token`
--

INSERT INTO `login_token` (`id`, `userId`, `token`, `createAt`) VALUES
(25, 12, 2147483647, 2024),
(30, 12, 6, 2024),
(33, 12, 9, 2024),
(34, 23, 0, 2024),
(35, 12, 132030, 2024);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `pt`
--

CREATE TABLE `pt` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `createAt` datetime NOT NULL,
  `updateAt` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `pt`
--

INSERT INTO `pt` (`id`, `email`, `fullname`, `phone`, `address`, `gender`, `createAt`, `updateAt`) VALUES
(8, 'baquycr@gmail.com', 'Trịnh bá quý 12 3', '0358862502', 'Kiến Hưn, Hà Đông , Hà nội', 'Nam', '2024-08-25 15:05:24', '2024-08-26 00:47:03');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `forgotToken` varchar(50) DEFAULT NULL,
  `lastActivity` varchar(50) DEFAULT NULL,
  `activeToken` varchar(50) DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `admin` varchar(1) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `createAt` datetime DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `fullname`, `phone`, `password`, `forgotToken`, `lastActivity`, `activeToken`, `gender`, `admin`, `address`, `createAt`, `updateAt`) VALUES
(12, 'op3477662@gmail.com', 'Trịnh bá quý', '353762502', '$2y$10$21YeBlFFhf7Nksbxr0dBwext3IAtFPzNdP5Q8OjF4ghoy7rZlkFzC', NULL, '2024-09-05 00:46:01', '0', 'Other', '1', 'Kiến Hưng, Hà Đông , Hà nội', '2024-08-23 19:41:52', NULL),
(23, 'baquycr@gmail.com', 'Trịnh bá quý', '0353762502', '$2y$10$Ay/QRwMTIa/KDPxGoiCxMeb37g.EKZdzIheKxtF9jw6UVFq91a5uK', NULL, NULL, NULL, 'Nữ', '', 'Kiến Hưng, Hà Đông , Hà nội', '2024-08-26 01:20:38', NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bycource`
--
ALTER TABLE `bycource`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cource`
--
ALTER TABLE `cource`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `login_token`
--
ALTER TABLE `login_token`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `pt`
--
ALTER TABLE `pt`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bycource`
--
ALTER TABLE `bycource`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cource`
--
ALTER TABLE `cource`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `login_token`
--
ALTER TABLE `login_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT cho bảng `pt`
--
ALTER TABLE `pt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
