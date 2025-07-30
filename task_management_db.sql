-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2025 at 06:40 AM
-- Server version: 10.4.16-MariaDB
-- PHP Version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `task_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `recipient` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `is_read` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `message`, `recipient`, `type`, `date`, `is_read`) VALUES
(20, '\'test\' танд хуваарилагдсан тул шалгаж үзээд ажлаа эхлүүлнэ үү.', 9, 'Шинэ даалгавар хуваарилагдлаа', '2025-07-30', 0),
(21, '\'another one\' танд хуваарилагдлаа.  -аас өмнө биелүүлнэ үү.', 9, 'Шинэ даалгавар ирлээ', '2025-07-30', 0),
(22, '\'fuck\' танд хуваарилагдлаа.  -аас өмнө биелүүлнэ үү.', 9, 'Шинэ даалгавар ирлээ', '2025-07-30', 0),
(23, '\'йыбйыб\' танд хуваарилагдсан.', 9, 'Шинэ даалгавар ирлээ', '2025-07-30', 0),
(24, '\'hahah\' танд хуваарилагдсан.', 10, 'Шинэ даалгавар ирлээ', '2025-07-30', 0),
(25, '\'йыбйыб\' танд хуваарилагдлаа дуусах хугацаа', 10, 'Шинэ даалгавар ирлээ', '2025-07-30', 0),
(26, '\'Asdasdad\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `assigned_to` int(11) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `status` enum('pending','in_progress','completed') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`) VALUES
(31, 'test', 'trest', 9, '2025-08-09', 'pending', '2025-07-30 04:29:39'),
(32, 'another one', 'asdasd', 9, '2025-07-31', 'pending', '2025-07-30 04:32:23'),
(33, 'another one', 'asdasd', 9, '2025-07-31', 'pending', '2025-07-30 04:33:05'),
(34, 'fuck', 'fuck you', 9, '2025-08-14', 'pending', '2025-07-30 04:33:54'),
(35, 'fuck', 'fuck you', 9, '2025-08-14', 'pending', '2025-07-30 04:34:44'),
(36, 'йыбйыб', 'йыбыйб', 9, '2025-08-09', 'pending', '2025-07-30 04:36:32'),
(37, 'hahah', 'hahahha', 10, '2025-08-01', 'pending', '2025-07-30 04:37:34'),
(38, 'йыбйыб', 'йыбйыб', 10, '2025-08-09', 'pending', '2025-07-30 04:38:43'),
(39, 'Asdasdad', 'sdfdsfsdf', 10, '2025-07-31', 'pending', '2025-07-30 04:39:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','employee') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'Oliver', 'admin', '$2y$10$TnyR1Y43m1EIWpb0MiwE8Ocm6rj0F2KojE3PobVfQDo9HYlAHY/7O', 'admin', '2024-08-28 07:10:04'),
(2, 'Elias A.', 'elias', '$2y$10$8xpI.hVCVd/GKUzcYTxLUO7ICSqlxX5GstSv7WoOYfXuYOO/SZAZ2', 'employee', '2024-08-28 07:10:40'),
(7, 'John', 'john', '$2y$10$CiV/f.jO5vIsSi0Fp1Xe7ubWG9v8uKfC.VfzQr/sjb5/gypWNdlBW', 'employee', '2024-08-29 17:11:21'),
(8, 'Oliver', 'oliver', '$2y$10$E9Xx8UCsFcw44lfXxiq/5OJtloW381YJnu5lkn6q6uzIPdL5yH3PO', 'employee', '2024-08-29 17:11:34'),
(9, 'dayn', 'dayn123', '$2y$10$UNVzWlH6eUJth.D4mDFXEOgcbbcD6FZlxItyzSplY3f2aARl4WW2S', 'employee', '2025-07-30 04:05:21'),
(10, 'anar', 'anar', '$2y$10$ZBtkfXQR1K2lHavX4/UdfuiwNhnxv57HMEmeeS10K.CQfZlAcG0nm', 'employee', '2025-07-30 04:37:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
