-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Okt 2025 pada 03.26
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webhook-ci`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender` varchar(30) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `message_type` varchar(20) DEFAULT 'text',
  `raw_payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`raw_payload`)),
  `message_id` varchar(100) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'queued',
  `note` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `last_status_time` datetime DEFAULT NULL,
  `daily_id` int(11) DEFAULT NULL,
  `log_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `messages`
--

INSERT INTO `messages` (`id`, `sender`, `message`, `message_type`, `raw_payload`, `message_id`, `status`, `note`, `created_at`, `updated_at`, `last_status_time`, `daily_id`, `log_date`) VALUES
(143, '6285717857565', '', 'status', '{\"id\":\"be09647e-5e89-48dd-8387-a0a02bc9920b\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"read\",\"note\":\"success\",\"timestamp\":\"2025-10-15T02:05:37.648005467Z\",\"ref_id\":\"\",\"source\":\"\"}', 'be09647e-5e89-48dd-8387-a0a02bc9920b', 'read', 'success', '2025-10-15 09:05:23', '2025-10-15 09:05:36', NULL, NULL, NULL),
(144, '6282125152089', '', 'status', '{\"id\":\"bc71d96f-9d5b-4df8-891a-42d495745f9e\",\"message\":\"\",\"phone\":\"6282125152089\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"sent\",\"note\":\"success\",\"timestamp\":\"2025-10-15T02:08:16.041810083Z\",\"ref_id\":\"\",\"source\":\"\"}', 'bc71d96f-9d5b-4df8-891a-42d495745f9e', 'sent', 'success', '2025-10-15 09:08:13', '2025-10-15 09:08:14', NULL, NULL, NULL),
(145, '6285717857566', '', 'status', '{\"id\":\"16822db3-5e6f-4be6-a5f5-a073e9bfd426\",\"message\":\"\",\"phone\":\"6285717857566\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"cancel\",\"note\":\"whatsapp number not found\",\"timestamp\":\"2025-10-15T02:15:19.42261874Z\",\"ref_id\":\"\",\"source\":\"\"}', '16822db3-5e6f-4be6-a5f5-a073e9bfd426', 'cancel', 'whatsapp number not found', '2025-10-15 09:15:17', '2025-10-15 09:15:17', NULL, NULL, NULL),
(146, '6285717857565', '', 'status', '{\"id\":\"163a4842-1c1a-437f-ab60-a3fa89b29a11\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"read\",\"note\":\"success\",\"timestamp\":\"2025-10-15T02:52:55.532253713Z\",\"ref_id\":\"\",\"source\":\"\"}', '163a4842-1c1a-437f-ab60-a3fa89b29a11', 'read', 'success', '2025-10-15 09:52:42', '2025-10-15 09:52:53', NULL, 1, '2025-10-15'),
(147, '6281298214213', '', 'status', '{\"id\":\"7861c820-5acd-4e40-8673-08b33e8dc325\",\"message\":\"\",\"phone\":\"6281298214213\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"delivered\",\"note\":\"sending to whatsapp server\",\"timestamp\":\"2025-10-15T02:55:50.208559319Z\",\"ref_id\":\"\",\"source\":\"\"}', '7861c820-5acd-4e40-8673-08b33e8dc325', 'delivered', 'sending to whatsapp server', '2025-10-15 09:55:48', '2025-10-15 09:55:48', NULL, 2, '2025-10-15'),
(148, '6285717857565', '', 'status', '{\"id\":\"5ac673cb-8d49-4fb7-b238-ce712e3e8e86\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"read\",\"note\":\"success\",\"timestamp\":\"2025-10-15T02:57:32.873074914Z\",\"ref_id\":\"\",\"source\":\"\"}', '5ac673cb-8d49-4fb7-b238-ce712e3e8e86', 'read', 'success', '2025-10-15 09:57:13', '2025-10-15 09:57:31', NULL, 3, '2025-10-15'),
(149, '6285717857565', 'Baik', 'text', '{\"id\":\"621fa60a-ecdf-4127-a255-a0d5a5add167\",\"pushName\":\"𝕍𝕖𝕣𝕕𝕚\",\"isGroup\":false,\"group\":{\"group_id\":\"\",\"sender\":\"\",\"subject\":\"\",\"owner\":\"\",\"desc\":\"\",\"participants\":null},\"message\":\"Baik\",\"phone\":\"6285717857565\",\"messageType\":\"text\",\"file\":\"\",\"url\":\"\",\"mimeType\":\"\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"isFromMe\":false,\"timestamp\":\"2025-10-15T02:58:31Z\",\"profileImage\":\"https://pps.whatsapp.net/v/t61.24694-24/560089088_1356336365881218_1988386492213279530_n.jpg?stp=dst-jpg_s96x96_tt6\\u0026ccb=11-4\\u0026oh=01_Q5Aa2wGeoFqaViGIHjDbp4v1s_MmduU7T3XxqcCu05BcjS8iwA\\u0026oe=68FC2D4B\\u0026_nc_sid=5e03e0\\u0026_nc_cat=106\",\"ticketId\":\"704c23bc-54af-4b8c-932d-08754fe6d560\",\"assigned\":\"4e931534-cbc0-40b1-9d29-7878fea2fadb\"}', NULL, 'received', NULL, '2025-10-15 09:58:30', '2025-10-15 09:58:30', NULL, NULL, NULL),
(150, '6285717857565', '', 'status', '{\"id\":\"a1a3bd3d-6ae8-4460-90d6-bcee4b88dc8d\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"read\",\"note\":\"success\",\"timestamp\":\"2025-10-15T02:58:32.836167703Z\",\"ref_id\":\"\",\"source\":\"\"}', 'a1a3bd3d-6ae8-4460-90d6-bcee4b88dc8d', 'read', 'success', '2025-10-15 09:58:31', '2025-10-15 09:58:31', NULL, 4, '2025-10-15'),
(151, '6285717857565', '', 'status', '{\"id\":\"22fa7a0c-36d6-4342-8021-93e9908a1e65\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"sent\",\"note\":\"success\",\"timestamp\":\"2025-10-15T04:08:43.709483261Z\",\"ref_id\":\"\",\"source\":\"\"}', '22fa7a0c-36d6-4342-8021-93e9908a1e65', 'sent', 'success', '2025-10-15 11:08:42', '2025-10-15 11:08:42', NULL, 5, '2025-10-15'),
(152, '6285717857565', '', 'status', '{\"id\":\"96e8a721-c4ea-4116-83c8-338a793f7110\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"sent\",\"note\":\"success\",\"timestamp\":\"2025-10-15T04:48:42.461313557Z\",\"ref_id\":\"\",\"source\":\"\"}', '96e8a721-c4ea-4116-83c8-338a793f7110', 'sent', 'success', '2025-10-15 11:33:51', '2025-10-15 11:48:41', NULL, 6, '2025-10-15'),
(153, '6283811298146', '', 'status', '{\"id\":\"ca16a578-1d12-4680-b0e6-b96e0f91b587\",\"message\":\"\",\"phone\":\"6283811298146\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"read\",\"note\":\"success\",\"timestamp\":\"2025-10-15T08:59:14.321615589Z\",\"ref_id\":\"\",\"source\":\"\"}', 'ca16a578-1d12-4680-b0e6-b96e0f91b587', 'read', 'success', '2025-10-15 15:07:11', '2025-10-15 15:59:12', NULL, 7, '2025-10-15'),
(154, '6285717857565', '', 'status', '{\"id\":\"a3b764c0-dd2e-4db4-9610-ebe43f29e55c\",\"message\":\"\",\"phone\":\"6285717857565\",\"deviceId\":\"SVRN18\",\"sender\":\"6285799920990\",\"status\":\"read\",\"note\":\"success\",\"timestamp\":\"2025-10-15T13:35:34.289353113Z\",\"ref_id\":\"\",\"source\":\"\"}', 'a3b764c0-dd2e-4db4-9610-ebe43f29e55c', 'read', 'success', '2025-10-15 20:35:17', '2025-10-15 20:35:32', NULL, 8, '2025-10-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `messages_status`
--

CREATE TABLE `messages_status` (
  `id` int(11) NOT NULL,
  `message_id` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `device` varchar(50) DEFAULT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `last_status_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `messages_status`
--
ALTER TABLE `messages_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT untuk tabel `messages_status`
--
ALTER TABLE `messages_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
