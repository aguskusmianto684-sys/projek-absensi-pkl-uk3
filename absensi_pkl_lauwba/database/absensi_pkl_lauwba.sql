-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 29, 2025 at 02:40 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `absensi_pkl_lauwba`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int NOT NULL,
  `participant_id` int NOT NULL,
  `check_in` datetime DEFAULT NULL,
  `check_in_location` varchar(255) DEFAULT NULL,
  `check_out` datetime DEFAULT NULL,
  `check_out_location` varchar(255) DEFAULT NULL,
  `status` enum('hadir','izin','sakit','alpa') DEFAULT 'hadir',
  `verified_by` int DEFAULT NULL,
  `verified_at` datetime DEFAULT NULL,
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `participant_id`, `check_in`, `check_in_location`, `check_out`, `check_out_location`, `status`, `verified_by`, `verified_at`, `note`, `created_at`, `updated_at`) VALUES
(3, 4, '2025-10-22 20:54:00', 'pt lauwba', NULL, NULL, 'hadir', 1, '2025-11-15 14:14:53', 'hadir', '2025-10-22 20:55:03', '2025-11-15 14:14:53'),
(4, 4, '2025-10-24 21:11:00', 'pt lauwba', '2025-10-25 14:56:00', 'pt lauwba', 'izin', NULL, NULL, 'telat ', '2025-10-24 21:11:55', '2025-11-15 14:14:31'),
(5, 5, '2025-10-24 21:15:00', 'pt lauwba', '2025-10-25 14:56:00', 'pt lauwba', 'izin', 8, '2025-11-08 15:34:28', 'sakit hati', '2025-10-24 21:20:14', '2025-11-08 15:34:28'),
(9, 4, '2025-11-08 16:50:22', 'Kampus Lauwba', NULL, NULL, 'hadir', 8, '2025-11-17 15:59:48', '', '2025-11-08 16:50:22', '2025-11-17 15:59:48'),
(11, 4, '2025-09-27 16:00:00', 'pt lauwba', NULL, NULL, 'hadir', 1, '2025-11-18 14:42:55', 'hadir', '2025-11-18 14:42:27', '2025-11-18 14:42:55'),
(12, 8, '2025-11-18 14:50:34', 'Kampus Lauwba', '2025-11-18 14:51:25', 'Kampus Lauwba', 'hadir', 1, '2025-11-18 14:50:47', ' | Check-out: sudah uk3', '2025-11-18 14:50:34', '2025-11-18 14:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `action` varchar(100) DEFAULT NULL,
  `description` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `action`, `description`, `created_at`) VALUES
(1, 1, 'Tambah', 'Menambahkan data absensi untuk peserta ID: 4 dengan status: izin', '2025-10-24 21:11:55'),
(2, 1, 'Tambah Absensi', 'Nama Peserta: agus kusmmianto | Participant ID: 5 | Status: izin | Check-in: 2025-10-24T21:15 | Lokasi Check-in: pt lauwba | Check-out: - | Lokasi Check-out: - | Catatan: sakit hati', '2025-10-24 21:20:14'),
(3, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 21:26:03'),
(4, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-24 21:26:07'),
(5, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 22:12:42'),
(6, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-10-24 22:12:50'),
(7, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-10-24 22:17:16'),
(8, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-24 22:17:21'),
(9, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 22:17:42'),
(10, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-10-24 22:17:48'),
(11, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-10-24 22:48:25'),
(12, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-24 22:48:32'),
(13, 1, 'Edit', 'Mengedit data peserta (ID: 4) - Sekolah: smkn 3 , Program: rekayasa perangkat lunak, Pembimbing: pa maman.', '2025-10-24 22:52:33'),
(14, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 22:52:54'),
(15, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-10-24 22:53:03'),
(16, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-10-24 22:53:53'),
(17, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-24 22:53:58'),
(18, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 22:54:08'),
(19, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-10-24 22:54:15'),
(20, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-10-24 22:57:24'),
(21, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-24 22:57:31'),
(22, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 22:57:37'),
(23, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-10-24 22:57:43'),
(24, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-10-24 22:57:57'),
(25, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-24 22:58:01'),
(26, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-24 23:00:18'),
(27, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-10-24 23:00:24'),
(28, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-10-25 11:21:22'),
(29, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 11:21:26'),
(30, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-25 11:22:17'),
(31, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-10-25 11:22:25'),
(32, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 12:42:26'),
(33, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 13:39:01'),
(34, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 13:39:01'),
(35, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:39:05'),
(36, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:39:05'),
(37, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-10-25 13:39:06'),
(38, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-10-25 13:39:06'),
(39, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-10-25 13:39:07'),
(40, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-10-25 13:39:07'),
(41, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:39:08'),
(42, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:39:08'),
(43, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 13:43:09'),
(44, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 13:43:09'),
(45, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:43:10'),
(46, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:43:10'),
(47, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-10-25 13:43:11'),
(48, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-10-25 13:43:11'),
(49, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:43:12'),
(50, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:43:12'),
(51, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 13:43:14'),
(52, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 13:43:14'),
(53, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-10-25 13:43:15'),
(54, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-10-25 13:43:15'),
(55, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:46:50'),
(56, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:46:50'),
(57, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:46:51'),
(58, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:46:51'),
(59, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-10-25 13:46:53'),
(60, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-10-25 13:46:53'),
(61, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-10-25 13:46:54'),
(62, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-10-25 13:46:54'),
(63, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 13:46:55'),
(64, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 13:46:55'),
(65, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 13:46:56'),
(66, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 13:46:56'),
(67, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-25 13:47:49'),
(68, 5, 'Login', 'User amad berhasil login ke sistem.', '2025-10-25 13:47:58'),
(69, 5, 'Logout', 'User amad telah logout dari sistem.', '2025-10-25 13:54:14'),
(70, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-10-25 13:54:23'),
(71, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-10-25 13:54:38'),
(72, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 13:54:41'),
(73, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:56:13'),
(74, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:56:13'),
(75, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:56:14'),
(76, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:56:14'),
(77, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:58:45'),
(78, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 13:58:45'),
(79, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:58:45'),
(80, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 13:58:45'),
(81, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:00:23'),
(82, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:00:23'),
(83, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:00:24'),
(84, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:00:34'),
(85, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:00:58'),
(86, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:00:58'),
(87, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:01:05'),
(88, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:01:14'),
(89, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 14:02:24'),
(90, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 14:02:24'),
(91, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 14:02:25'),
(92, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 14:02:33'),
(93, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:02:41'),
(94, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:02:41'),
(95, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:02:41'),
(96, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:02:50'),
(97, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:03:04'),
(98, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:03:04'),
(99, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:03:08'),
(100, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:03:16'),
(101, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 14:03:25'),
(102, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 14:03:25'),
(103, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 14:03:25'),
(104, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 14:03:34'),
(105, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:03:43'),
(106, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:03:43'),
(107, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:03:43'),
(108, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:03:53'),
(109, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:04:19'),
(110, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:04:19'),
(111, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:04:55'),
(112, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:05:03'),
(113, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:05:32'),
(114, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:05:32'),
(115, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:06:24'),
(116, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:06:33'),
(117, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:10:24'),
(118, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:10:24'),
(119, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:10:26'),
(120, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:10:34'),
(121, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:11:54'),
(122, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:11:54'),
(123, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:11:55'),
(124, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:12:03'),
(125, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:14:17'),
(126, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:14:25'),
(127, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:14:32'),
(128, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:14:40'),
(129, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:14:48'),
(130, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:14:56'),
(131, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:15:05'),
(132, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:15:12'),
(133, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:15:43'),
(134, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:15:51'),
(135, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:18:42'),
(136, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:18:50'),
(137, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:20:59'),
(138, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:21:26'),
(139, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:28:53'),
(140, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:29:01'),
(141, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:30:13'),
(142, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:30:24'),
(143, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:30:31'),
(144, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:30:48'),
(145, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-25 14:32:37'),
(146, 7, 'Login', 'User alin berhasil login ke sistem.', '2025-10-25 14:32:45'),
(147, 7, 'Logout', 'User alin telah logout dari sistem.', '2025-10-25 14:49:32'),
(148, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 14:49:36'),
(149, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:49:50'),
(150, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:49:55'),
(151, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 14:51:40'),
(152, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 14:51:46'),
(153, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-25 14:53:31'),
(154, 7, 'Login', 'User alin berhasil login ke sistem.', '2025-10-25 14:53:38'),
(155, 7, 'Logout', 'User alin telah logout dari sistem.', '2025-10-25 14:56:02'),
(156, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 14:56:06'),
(157, 1, 'Edit Absensi', '\r\n                Mengedit data absensi ID: 4 \r\n                | Peserta: dimas \r\n                | Status Lama: izin → Baru: izin\r\n                | Check-in Lama: 2025-10-24 21:11:00 → Baru: 2025-10-24T21:11\r\n                | Check-out Lama: - → Baru: 2025-10-25T14:56\r\n                | Catatan: telat ', '2025-10-25 14:56:38'),
(158, 1, 'Edit Absensi', '\r\n                Mengedit data absensi ID: 5 \r\n                | Peserta: agus kusmmianto \r\n                | Status Lama: izin → Baru: izin\r\n                | Check-in Lama: 2025-10-24 21:15:00 → Baru: 2025-10-24T21:15\r\n                | Check-out Lama: - → Baru: 2025-10-25T14:56\r\n                | Catatan: sakit hati', '2025-10-25 14:57:00'),
(159, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-25 14:57:10'),
(160, 7, 'Login', 'User alin berhasil login ke sistem.', '2025-10-25 14:57:17'),
(161, 7, 'Logout', 'User alin telah logout dari sistem.', '2025-10-25 15:27:23'),
(162, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 15:27:26'),
(163, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-10-25 15:28:23'),
(164, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-10-25 15:28:29'),
(165, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 15:28:36'),
(166, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-10-25 15:43:46'),
(167, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-10-25 15:43:50'),
(168, 1, 'Tambah', 'Menambahkan user baru: Username = iis, Nama Lengkap = iis, Role = peserta, Status = aktif', '2025-10-25 15:53:16'),
(169, 1, 'Hapus', 'Menghapus user dengan ID: 10, Username: iis, Role: peserta', '2025-10-25 15:55:52'),
(170, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 15:57:07'),
(171, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 15:57:42'),
(172, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 15:57:56'),
(173, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 15:59:06'),
(174, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 15:59:11'),
(175, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:00:02'),
(176, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:00:07'),
(177, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:00:12'),
(178, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:00:17'),
(179, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:00:24'),
(180, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:00:29'),
(181, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:01:23'),
(182, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:01:29'),
(183, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 16:01:48'),
(184, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-10-25 16:06:24'),
(185, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:06:29'),
(186, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:07:08'),
(187, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:08:48'),
(188, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:10:42'),
(189, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:11:06'),
(190, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:11:36'),
(191, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:11:50'),
(192, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:12:58'),
(193, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:13:03'),
(194, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:14:14'),
(195, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:18:01'),
(196, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:18:13'),
(197, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-10-25 16:18:26'),
(198, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-10-25 16:18:45'),
(199, 1, 'Edit', 'Memperbarui data user ID: 11, Username: iis, Nama: iis, Phone: 08595089819, Role: peserta, Status: aktif', '2025-10-25 16:28:45'),
(200, 1, 'Edit', 'Memperbarui data user ID: 11, Username: iis, Nama: iis, Phone: 085950898193, Role: peserta, Status: aktif', '2025-10-25 16:28:57'),
(201, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-10-25 16:30:07'),
(202, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-03 09:54:55'),
(203, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-03 09:55:03'),
(204, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-03 09:55:08'),
(205, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-03 09:55:14'),
(206, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-03 09:55:25'),
(207, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-03 11:27:02'),
(208, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-03 11:35:04'),
(209, 12, 'Login', 'User agus berhasil login ke sistem.', '2025-11-03 11:35:10'),
(210, 12, 'Logout', 'User agus telah logout dari sistem.', '2025-11-03 11:38:15'),
(211, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-03 11:38:18'),
(212, 1, 'Edit', 'Memperbarui data user ID: 12, Username: agus, Nama: agus, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-03 11:38:34'),
(213, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-03 11:38:38'),
(214, 12, 'Login', 'User agus berhasil login ke sistem.', '2025-11-03 11:38:47'),
(215, 12, 'Logout', 'User agus telah logout dari sistem.', '2025-11-03 11:40:56'),
(216, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-03 11:41:00'),
(217, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-03 11:44:26'),
(218, 12, 'Login', 'User agus berhasil login ke sistem.', '2025-11-03 11:44:33'),
(219, 12, 'Logout', 'User agus telah logout dari sistem.', '2025-11-03 11:53:17'),
(220, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-03 11:53:21'),
(221, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-03 11:55:26'),
(222, 12, 'Login', 'User agus berhasil login ke sistem.', '2025-11-03 11:55:31'),
(223, 12, 'Logout', 'User agus telah logout dari sistem.', '2025-11-03 11:56:03'),
(224, 5, 'Login', 'User amad berhasil login ke sistem.', '2025-11-03 11:56:19'),
(225, 5, 'Logout', 'User amad telah logout dari sistem.', '2025-11-03 11:59:46'),
(226, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-03 11:59:53'),
(227, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-03 12:06:46'),
(228, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-03 12:06:51'),
(229, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-03 12:08:10'),
(230, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-03 12:08:23'),
(231, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 10:06:17'),
(232, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 10:06:22'),
(233, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-06 10:09:21'),
(234, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-06 10:09:27'),
(235, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 10:13:20'),
(236, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 10:13:25'),
(237, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 10:27:14'),
(238, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 10:27:18'),
(239, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 10:27:43'),
(240, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 10:27:52'),
(241, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 10:45:10'),
(242, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 10:45:14'),
(243, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 10:45:45'),
(244, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 10:45:50'),
(245, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 11:11:13'),
(246, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 11:11:16'),
(247, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-11-06 11:11:23'),
(248, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-06 11:12:16'),
(249, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-06 11:12:17'),
(250, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-06 11:13:49'),
(251, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-06 11:13:54'),
(252, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-11-06 11:14:09'),
(253, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-06 11:14:21'),
(254, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-06 11:16:11'),
(255, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-06 11:16:36'),
(256, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-06 11:18:33'),
(257, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 11:20:31'),
(258, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 11:20:39'),
(259, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 11:50:01'),
(260, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 11:50:07'),
(261, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 11:59:16'),
(262, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-06 11:59:21'),
(263, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-06 12:08:21'),
(264, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 12:08:26'),
(265, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 21:14:24'),
(266, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 21:14:28'),
(267, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 21:20:15'),
(268, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 21:20:22'),
(269, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 21:24:32'),
(270, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 21:24:35'),
(271, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 21:27:28'),
(272, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 21:27:50'),
(273, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 21:54:03'),
(274, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 21:54:12'),
(275, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 21:56:32'),
(276, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-06 21:56:42'),
(277, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-06 21:56:54'),
(278, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-06 21:57:01'),
(279, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-06 21:58:18'),
(280, 11, 'Login', 'User iis berhasil login ke sistem.', '2025-11-06 21:58:24'),
(281, 11, 'Logout', 'User iis telah logout dari sistem.', '2025-11-06 21:59:19'),
(282, 12, 'Login', 'User agus berhasil login ke sistem.', '2025-11-06 21:59:23'),
(283, 12, 'Logout', 'User agus telah logout dari sistem.', '2025-11-06 22:00:53'),
(284, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 22:00:57'),
(285, 1, 'Tambah', 'Menambahkan peserta baru dari sekolah: smkn 3 , program: rekayasa perangkat lunak, dengan pembimbing: pa maman.', '2025-11-06 22:01:21'),
(286, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-06 22:01:27'),
(287, 12, 'Login', 'User agus berhasil login ke sistem.', '2025-11-06 22:01:32'),
(288, 12, 'Logout', 'User agus telah logout dari sistem.', '2025-11-06 22:22:35'),
(289, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-06 22:22:39'),
(290, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 8', '2025-11-07 13:49:18'),
(291, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-07 13:49:29'),
(292, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-07 13:49:37'),
(293, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-07 14:47:12'),
(294, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-07 14:51:28'),
(295, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-08 14:50:14'),
(296, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-08 14:50:23'),
(297, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-08 14:54:17'),
(298, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-08 14:54:21'),
(299, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-08 15:02:47'),
(300, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-08 15:02:52'),
(301, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-08 15:28:00'),
(302, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-08 15:28:04'),
(303, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-08 15:29:56'),
(304, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-08 15:32:38'),
(305, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 5', '2025-11-08 15:33:00'),
(306, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 5', '2025-11-08 15:34:28'),
(307, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-08 15:43:40'),
(308, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-08 15:43:44'),
(309, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-08 15:50:36'),
(310, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-08 15:50:42'),
(311, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-08 15:54:24'),
(312, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-08 15:54:30'),
(313, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 8', '2025-11-08 15:54:34'),
(314, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-08 15:54:38'),
(315, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-08 15:54:45'),
(316, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 3', '2025-11-08 15:54:49'),
(317, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-08 16:33:50'),
(318, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-08 16:33:55'),
(319, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-08 16:50:42'),
(320, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-08 16:50:45'),
(321, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-08 16:50:55'),
(322, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-09 14:39:08'),
(323, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-09 14:39:20'),
(324, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-09 14:40:53'),
(325, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-09 14:41:00'),
(326, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-13 20:19:47'),
(327, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-13 20:21:45'),
(328, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-13 20:21:48'),
(329, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-13 20:22:32'),
(330, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 8', '2025-11-13 20:24:22'),
(331, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 8', '2025-11-13 20:27:52'),
(332, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-13 20:28:46'),
(333, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-13 20:34:28'),
(334, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-13 20:37:55'),
(335, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-15 13:20:58'),
(336, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 13:21:21'),
(337, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 13:21:44'),
(338, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 13:22:06'),
(339, 1, 'Edit', 'Memperbarui data user ID: 4, Username: dimas, Nama: dimas, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-15 13:23:24'),
(340, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 13:23:40'),
(341, 1, 'Edit', 'Memperbarui data user ID: 4, Username: dimas, Nama: dimas, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-15 13:25:36'),
(342, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 13:25:43'),
(343, 1, 'Edit', 'Memperbarui data user ID: 4, Username: dimas, Nama: dimas, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-15 13:28:20'),
(344, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-15 13:28:33'),
(345, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 13:28:54'),
(346, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 4', '2025-11-15 13:29:15'),
(347, 1, 'Edit', 'Memperbarui data user ID: 4, Username: dimas, Nama: dimas, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-15 13:31:57'),
(348, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 13:32:06'),
(349, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-15 13:32:27'),
(350, 1, 'Edit', 'Memperbarui data user ID: 4, Username: dimas, Nama: dimas, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-15 13:40:13'),
(351, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-15 13:40:32'),
(352, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-15 13:40:38'),
(353, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-15 13:40:47'),
(354, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-15 13:41:05'),
(355, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-15 13:41:43'),
(356, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-15 13:41:47'),
(357, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-15 13:42:11'),
(358, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-15 13:42:16'),
(359, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-15 13:42:49'),
(360, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-15 13:42:53'),
(361, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 10', '2025-11-15 13:42:59'),
(362, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 10', '2025-11-15 14:12:15'),
(363, 1, 'Edit', 'Memperbarui data user ID: 4, Username: dimas, Nama: dimas, Phone: 085950898193, Role: peserta, Status: aktif', '2025-11-15 14:13:08'),
(364, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 10', '2025-11-15 14:13:27'),
(365, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 14:13:49'),
(366, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 6', '2025-11-15 14:14:10'),
(367, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 4', '2025-11-15 14:14:31'),
(368, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 3', '2025-11-15 14:14:53'),
(369, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 10', '2025-11-15 14:15:36'),
(370, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 14:15:58'),
(371, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 10', '2025-11-15 14:25:58'),
(372, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 14:26:00'),
(373, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 8', '2025-11-15 14:26:01'),
(374, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 8', '2025-11-15 14:26:56'),
(375, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 14:26:59'),
(376, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 10', '2025-11-15 14:37:29'),
(377, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 14:37:30'),
(378, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 6', '2025-11-15 14:37:33'),
(379, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-15 15:10:51'),
(380, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-15 15:11:03'),
(381, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 10', '2025-11-15 15:11:20'),
(382, 1, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 10', '2025-11-15 15:13:08'),
(383, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 10', '2025-11-15 15:16:05'),
(384, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-15 15:17:51'),
(385, 4, 'Login', 'User dimas berhasil login ke sistem.', '2025-11-15 15:17:57'),
(386, 4, 'Logout', 'User dimas telah logout dari sistem.', '2025-11-15 15:22:08'),
(387, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-15 15:23:10'),
(388, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-15 15:30:35'),
(389, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-15 15:30:46'),
(390, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-16 15:41:17'),
(391, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-16 15:41:23'),
(392, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 10', '2025-11-16 15:41:27'),
(393, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 10', '2025-11-16 15:42:19'),
(394, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 10', '2025-11-16 15:42:28'),
(395, 8, 'Hapus Absensi', 'Menghapus data absensi milik peserta: dimas | ID Absensi: 6 | Status: hadir | Check-in: 2025-11-06 09:48:44 | Check-out: 2025-11-06 21:48:41 | Catatan: Check-out via QR', '2025-11-17 15:58:15'),
(396, 8, 'Hapus Absensi', 'Menghapus data absensi milik peserta: dimas | ID Absensi: 10 | Status: hadir | Check-in: 2025-11-15 13:42:36 | Check-out: 2025-11-15 15:16:31 | Catatan: Check-in via QR | Check-out: sudah', '2025-11-17 15:58:20'),
(397, 8, 'Batalkan Verifikasi', 'Membatalkan verifikasi absensi ID: 9', '2025-11-17 15:58:32'),
(398, 8, 'Verifikasi', 'Memverifikasi data absensi ID: 9', '2025-11-17 15:59:48'),
(399, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-17 17:16:24'),
(400, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-17 17:16:28'),
(401, 1, 'Hapus Absensi', 'Menghapus data absensi milik peserta: agus | ID Absensi: 8 | Status: hadir | Check-in: 2025-11-06 22:01:39 | Check-out: 2025-11-06 22:01:55 | Catatan: Check-out via QR', '2025-11-18 09:16:18'),
(402, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-18 14:38:51'),
(403, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-18 14:40:00'),
(404, 1, 'Tambah Absensi', 'Nama Peserta: dimas | Participant ID: 4 | Status: hadir | Check-in: 2025-09-27T16:00 | Lokasi Check-in: pt lauwba | Check-out: - | Lokasi Check-out: - | Catatan: hadir', '2025-11-18 14:42:27'),
(405, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 11', '2025-11-18 14:42:56'),
(406, 1, 'Logout', 'User admin telah logout dari sistem.', '2025-11-18 14:46:56'),
(407, 8, 'Login', 'User adam berhasil login ke sistem.', '2025-11-18 14:47:09'),
(408, 8, 'Logout', 'User adam telah logout dari sistem.', '2025-11-18 14:49:17'),
(409, 1, 'Login', 'User admin berhasil login ke sistem.', '2025-11-18 14:49:26'),
(410, 1, 'Verifikasi', 'Memverifikasi data absensi ID: 12', '2025-11-18 14:50:47');

-- --------------------------------------------------------

--
-- Table structure for table `participants`
--

CREATE TABLE `participants` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `school` varchar(150) DEFAULT NULL,
  `program_study` varchar(100) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `supervisor_name` varchar(150) DEFAULT NULL,
  `supervisor_id` int DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `participants`
--

INSERT INTO `participants` (`id`, `user_id`, `school`, `program_study`, `start_date`, `end_date`, `supervisor_name`, `supervisor_id`, `created_at`, `updated_at`) VALUES
(3, 3, 'smkn 3 banjar', 'rpl', NULL, NULL, NULL, NULL, '2025-10-22 14:55:37', '2025-10-22 14:55:37'),
(4, 4, 'smkn 3 ', 'rekayasa perangkat lunak', '2025-10-20', '2025-10-31', 'pa maman', 8, '2025-10-22 15:12:51', '2025-10-24 22:52:33'),
(5, 3, 'smkn 3 ', 'rekayasa perangkat lunak', '2025-10-20', '2025-10-31', 'pa maman', 8, '2025-10-22 16:17:43', '2025-10-22 16:17:43'),
(6, 12, 'smkn 3 ', 'rekayasa perangkat lunak', '2025-10-20', '2025-10-31', 'pa maman', 6, '2025-11-06 22:01:21', '2025-11-06 22:01:21'),
(7, 13, 'smkn 3 banjar', 'rekayasa perangkat lunak', '2025-11-17', '2025-11-17', 'amad', 5, '2025-11-17 17:28:08', '2025-11-17 17:28:08'),
(8, 14, 'smkn 3 banjar', 'rekayasa perangkat lunak', '2025-11-17', '2025-11-17', 'adam', 8, '2025-11-18 14:49:39', '2025-11-18 14:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `qr_sessions`
--

CREATE TABLE `qr_sessions` (
  `id` int NOT NULL,
  `token` varchar(255) NOT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `expired_at` datetime NOT NULL,
  `created_by` int DEFAULT NULL,
  `valid_from` time DEFAULT NULL,
  `valid_until` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `qr_sessions`
--

INSERT INTO `qr_sessions` (`id`, `token`, `file_name`, `created_at`, `expired_at`, `created_by`, `valid_from`, `valid_until`) VALUES
(1, 'absen_690c114530df04.14391014', NULL, '2025-11-06 03:08:53', '2025-11-06 11:08:53', 1, NULL, NULL),
(2, 'absen_690c118e9577d2.81269181', NULL, '2025-11-06 03:10:06', '2025-11-06 11:10:06', 1, NULL, NULL),
(3, 'absen_690c11aa6ac831.95883744', NULL, '2025-11-06 03:10:34', '2025-11-06 11:10:34', 1, NULL, NULL),
(4, 'absen_690c12358e1781.36018178', NULL, '2025-11-06 03:12:53', '2025-11-06 11:12:53', 1, NULL, NULL),
(5, 'absen_690c136165bcd4.69883903', NULL, '2025-11-06 03:17:53', '2025-11-06 11:17:53', 4, NULL, NULL),
(6, 'absen_690c1361903054.82448046', NULL, '2025-11-06 03:17:53', '2025-11-06 11:17:53', 4, NULL, NULL),
(7, 'absen_690c1361bebbb7.15566417', NULL, '2025-11-06 03:17:53', '2025-11-06 11:17:53', 4, NULL, NULL),
(8, 'absen_690c13621b0543.47011147', NULL, '2025-11-06 03:17:54', '2025-11-06 11:17:54', 4, NULL, NULL),
(9, 'absen_690c1362489197.47965438', NULL, '2025-11-06 03:17:54', '2025-11-06 11:17:54', 4, NULL, NULL),
(10, 'absen_690c13626d6303.47803302', NULL, '2025-11-06 03:17:54', '2025-11-06 11:17:54', 4, NULL, NULL),
(11, 'absen_690c159b4fd493.47324756', NULL, '2025-11-06 03:27:23', '2025-11-06 11:27:23', 1, NULL, NULL),
(12, 'absen_690c19cf4ce615.83330983', NULL, '2025-11-06 03:45:19', '2025-11-06 11:45:19', 1, NULL, NULL),
(13, 'absen_690c2b2b8b7df2.06435824', NULL, '2025-11-06 04:59:23', '2025-11-06 23:59:59', 8, NULL, NULL),
(14, 'aa426b4e99849665c75731a7fab36b91', NULL, '2025-11-06 21:15:20', '2025-11-07 14:15:20', NULL, NULL, NULL),
(15, '79e0b9127650ff3b39597f6a5379fbf7', NULL, '2025-11-06 21:25:36', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(16, '78fd42f3b99b6ebe725db6f9d9ea4df8', NULL, '2025-11-06 21:26:57', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(17, '73534d868616d2d97610568e903a6472', NULL, '2025-11-06 21:54:19', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(18, '46e4776a05a84c359c75532034e2a762', NULL, '2025-11-06 22:26:35', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(19, 'a456ca9540612f77ea3c8cebf879459e', NULL, '2025-11-06 22:28:08', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(20, '5d889c471efebb9a61f468c8e16b532f', 'qr_1762443549.png', '2025-11-06 22:39:11', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(21, '8b150d37ce28fa45f4e69efb92ac3ea6', 'qr_1762443710.png', '2025-11-06 22:41:52', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(22, 'c09b3e415dad79708df4df6e337da5bd', 'qr_1762443770.png', '2025-11-06 22:42:51', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(23, 'a335e143032392879b351eefaff1b9b3', NULL, '2025-11-06 22:43:35', '2025-11-06 18:00:00', NULL, '07:00:00', '18:00:00'),
(24, '284312b63e22e8207cbc07fc02fc4327', NULL, '2025-11-07 13:48:55', '2025-11-07 18:00:00', NULL, '07:00:00', '18:00:00'),
(25, '282117d729f6c2c5b3bfdf4f6e6fd92a', NULL, '2025-11-08 15:50:22', '2025-11-08 18:00:00', NULL, '07:00:00', '18:00:00'),
(26, '5f1bc6c0ee91013b71bfa92ec891ad87', NULL, '2025-11-15 13:40:21', '2025-11-15 18:00:00', NULL, '07:00:00', '18:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` int NOT NULL,
  `date` date DEFAULT NULL,
  `expected_in` time DEFAULT NULL,
  `expected_out` time DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`id`, `date`, `expected_in`, `expected_out`, `description`, `created_at`) VALUES
(3, '2025-10-22', '08:01:00', '17:00:00', 'Meeting dengan tim pengembangan proyek', '2025-10-22 16:41:38'),
(5, '2025-10-19', '08:00:00', '16:00:00', 'Hari Senin', '2025-10-25 11:16:44'),
(6, '2025-10-20', '08:00:00', '16:00:00', 'Hari Selasa', '2025-10-25 11:16:44'),
(7, '2025-10-23', '08:00:00', '16:00:00', 'Hari Kamis', '2025-10-25 11:20:25'),
(8, '2025-10-24', '08:00:00', '16:00:00', 'Hari Jumat', '2025-10-25 11:20:25');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int NOT NULL,
  `setting_key` varchar(100) DEFAULT NULL,
  `setting_value` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `created_at`, `updated_at`) VALUES
(1, 'app_name', 'Lauwba Academy Absensi', '2025-10-24 08:47:43', '2025-10-24 08:47:43'),
(2, 'timezone', 'Asia/Jakarta', '2025-10-24 08:47:43', '2025-10-24 08:47:43'),
(3, 'max_absent_time', '09:00:00', '2025-10-24 08:47:43', '2025-10-24 08:47:43'),
(4, 'late_tolerance_min', '15', '2025-10-24 08:47:43', '2025-10-24 08:47:43'),
(5, 'attendance_message', 'Selamat datang di sistem absensi Lauwba Academy!', '2025-10-24 08:47:43', '2025-10-24 08:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `department` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `note` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `supervisors`
--

INSERT INTO `supervisors` (`id`, `user_id`, `department`, `phone`, `note`, `created_at`) VALUES
(3, 8, 'sas', 'sas', 'sa', '2025-10-22 15:47:20'),
(5, 7, '', '', '', '2025-10-22 16:02:36'),
(6, 8, 'rpl', '323423433534', 'sangat baik', '2025-10-22 16:15:01');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('admin','pembimbing','peserta') DEFAULT 'peserta',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `full_name`, `email`, `phone`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$VNcKu3E2gIA5Xgfb72dl5uIkZOxO5QKs6Btprvk0l0p0dvpVf0U3a', 'Administrator', 'admin@lauwba.com', NULL, 'admin', 'aktif', '2025-10-22 10:02:05', '2025-10-22 10:42:21'),
(3, 'agus baik', '$2y$10$onRtpWNB6/s9LbN05gS9NezkSjvEHAU7Xx4LaKTmYUM9Phn0yGA.6', 'agus kusmmianto', 'agus@gmail.com', '085950898193', 'peserta', 'aktif', '2025-10-22 14:55:37', '2025-11-08 15:34:22'),
(4, 'dimas', '$2y$10$qFhkpFNUV7GgPTgi3N1pI.yxJR230rfkZVquTwAlpHL0oJk5p1Hei', 'dimas', 'aguskusmianto866@gmail.com', '085950898193', 'peserta', 'aktif', '2025-10-22 15:12:51', '2025-11-15 14:13:08'),
(5, 'amad', '$2y$10$lhYFnIT2uy0dgoUEyhrrx.txfahdCeM5xjLUvBSOUMi.9DfoOVL2a', 'amad', 'amad@gmail.com', NULL, 'pembimbing', 'aktif', '2025-10-22 15:47:20', '2025-10-22 15:47:20'),
(6, 'ali', '$2y$10$TntNDNzes.mPxO8buLxKGOdSbWHqqxs85HptCHM5yeo9luPA2Y2Hu', 'ali', 'ali@gmail.com', NULL, 'pembimbing', 'aktif', '2025-10-22 15:57:39', '2025-10-22 15:57:39'),
(7, 'alin', '$2y$10$TtGLzRV34NRU7h/ZR4JI7Ox01gQQDYQ0ND3ktA5w9PvZSGOTAhvi.', 'alin', 'alin@gmail.com', NULL, 'pembimbing', 'aktif', '2025-10-22 16:02:36', '2025-10-23 18:03:56'),
(8, 'adam', '$2y$10$U87rUgiQtFB/pFn3tElEnOA0jiUAVDm8FhiioeYEUxy4AJhX1wLx6', 'adam', '@gmail.com', '085950898193', 'pembimbing', 'aktif', '2025-10-22 16:12:55', '2025-10-25 15:28:16'),
(11, 'iis', '$2y$10$l.w5WWKGCk.ABizuPJahjenWBuljgjQg0WnyuiFhwvHhpgYixE8O.', 'iis', 'a@gmail', '085950898193', 'peserta', 'aktif', '2025-10-25 15:56:10', '2025-10-25 16:28:57'),
(12, 'agus', '$2y$10$F.Vdr2/dFcwptPZnwJcCNu0Jn0eIN/fia1BQicxauGVrmNCXJIIOu', 'agus', 'aguskusmianto686@gmail.com', '085950898193', 'peserta', 'aktif', '2025-11-03 09:54:04', '2025-11-03 11:38:34'),
(13, 'didi', '$2y$10$N/lWO/skVf9RTGc3Bs5C9u7xLHGqQbXyHwgUjOGtbjNWkjc8Z6qge', 'didi', 'aguskusmianto68@gmail.com', '085950898193', 'peserta', 'aktif', '2025-11-17 17:27:39', '2025-11-17 17:27:39'),
(14, 'bagus', '$2y$10$0Uu8QONQ7qP8IFNhaiLpGeU/MKAdYps/c0Lsrbs1sNUl6IdsiIcQ6', 'bagus1', 'bagus@gmail.com', '085950898193', 'peserta', 'aktif', '2025-11-18 14:49:07', '2025-11-18 14:49:07');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_rekap_absensi`
-- (See below for the actual view)
--
CREATE TABLE `v_rekap_absensi` (
`participant_id` int
,`nama_peserta` varchar(150)
,`total_absen` bigint
,`total_hadir` decimal(23,0)
,`total_izin` decimal(23,0)
,`total_sakit` decimal(23,0)
,`total_alpa` decimal(23,0)
);

-- --------------------------------------------------------

--
-- Structure for view `v_rekap_absensi`
--
DROP TABLE IF EXISTS `v_rekap_absensi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_rekap_absensi`  AS SELECT `p`.`id` AS `participant_id`, `u`.`full_name` AS `nama_peserta`, count(`a`.`id`) AS `total_absen`, sum((case when (`a`.`status` = 'hadir') then 1 else 0 end)) AS `total_hadir`, sum((case when (`a`.`status` = 'izin') then 1 else 0 end)) AS `total_izin`, sum((case when (`a`.`status` = 'sakit') then 1 else 0 end)) AS `total_sakit`, sum((case when (`a`.`status` = 'alpa') then 1 else 0 end)) AS `total_alpa` FROM ((`participants` `p` left join `users` `u` on((`p`.`user_id` = `u`.`id`))) left join `attendance` `a` on((`a`.`participant_id` = `p`.`id`))) GROUP BY `p`.`id`, `u`.`full_name` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participant_id` (`participant_id`),
  ADD KEY `verified_by` (`verified_by`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `participants`
--
ALTER TABLE `participants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Indexes for table `qr_sessions`
--
ALTER TABLE `qr_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `token_2` (`token`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=411;

--
-- AUTO_INCREMENT for table `participants`
--
ALTER TABLE `participants`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `qr_sessions`
--
ALTER TABLE `qr_sessions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`participant_id`) REFERENCES `participants` (`id`),
  ADD CONSTRAINT `attendance_ibfk_2` FOREIGN KEY (`verified_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `participants`
--
ALTER TABLE `participants`
  ADD CONSTRAINT `participants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `participants_ibfk_2` FOREIGN KEY (`supervisor_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `supervisors`
--
ALTER TABLE `supervisors`
  ADD CONSTRAINT `supervisors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
