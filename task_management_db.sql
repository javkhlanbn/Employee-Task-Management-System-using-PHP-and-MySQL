-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2025 at 05:58 AM
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
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(1, 1, 10, 'hello', '2025-07-30 08:05:37'),
(2, 10, 9, 'hello', '2025-07-30 08:08:13'),
(3, 1, 10, 'asd', '2025-07-30 08:10:52');

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
(43, '\'Хугацаа дууссан\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(44, '\'Өнөөдөр дуусах\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(45, '\'2 хоногийн дараа дуусах\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(46, '\'5 хоногийн дараа дуусах\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(47, '\'Дуусах болоогүй\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(48, '\'Хугацаагүй\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 10, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(49, '\'test\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 17, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(50, '\'for dayn\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 18, 'Шинэ даалгавар өгсөн', '2025-07-30', 1),
(51, '\'test\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 17, 'Шинэ даалгавар өгсөн', '2025-07-30', 0),
(52, '\'test\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 21, 'Шинэ даалгавар өгсөн', '2025-08-01', 0),
(53, '\'test2\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 21, 'Шинэ даалгавар өгсөн', '2025-08-01', 0),
(54, '\'test\' танд томилогдсон. Үүнийг хянаж үзээд ажлаа эхлүүлнэ үү', 17, 'Шинэ даалгавар өгсөн', '2025-08-04', 0);

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `attachment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `assigned_to`, `due_date`, `status`, `created_at`, `attachment`) VALUES
(67, 'test', 'testhg', 17, '2025-08-06', 'completed', '2025-08-04 01:54:56', '1754272496_Draft.Interview.docx');

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
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `profile_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `role`, `created_at`, `profile_image`) VALUES
(16, 'Munkhtuya', 'Munkhtuya', '$2y$10$2ilgpg.s.4nUWHeyTzs72unogeBSS9XD6F0aRxNc0JlPVhx5Lineu', 'admin', '2025-07-30 08:55:15', NULL),
(17, 'Anujin', 'Anujin', '$2y$10$Z/NeAnFydf0EDJVaFdjYs.Ria5Vm8qWTLUW/C607FCuoRHEs0N3Bq', 'employee', '2025-07-30 08:56:01', NULL),
(18, 'Dayn', 'Dayn', '$2y$10$LCLkKdHyc9HEUGbrB8mGk.AcIdCNP6U17jfpSKJM093ECuL1tmjnq', 'employee', '2025-07-30 09:00:39', NULL),
(19, 'Deegii', 'Deegii', '$2y$10$LSOd0ZOUGYLnJsFLrNz9X.nWDrlNlJRaYoHTdDuCEoRzZRnOkQwOy', 'employee', '2025-08-01 03:56:11', NULL),
(21, 'Javkhaa', 'Javkhaa', '$2y$10$vrfYVbPfJW8U5PMTDJlsAeFh3cX2OhS.KJY1YkfRAv0m.S7JVT01.', 'employee', '2025-08-01 03:57:03', NULL),
(22, 'Davaa', 'Davaa', '$2y$10$vQUeAFVat6IjO0JoyuJHwuyTkoyDY8L58WBffBRmC8TKah7bfy59K', 'employee', '2025-08-01 03:57:29', NULL),
(23, 'Baagii', 'Baagii', '$2y$10$rOCY5FDP7x5jk.3R3gWoLuW1HtUZgCCI1p8j5SLgq4SKR7Qsc04t6', 'employee', '2025-08-01 03:57:46', NULL),
(24, 'Muugii', 'Muugii', '$2y$10$TlGadP1F9oh22zecQ0YZgevSb866pjM3jf/9GDCq1VDFOeNyNS3ty', 'employee', '2025-08-01 04:00:54', NULL),
(25, 'Choikhand', 'Choikhand', '$2y$10$rZB2BjdvMqrNVsQeNQjVre3GU1UhV5Y8X6JY19H3q0g5XZHqzfpZi', 'admin', '2025-08-01 04:03:43', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

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
