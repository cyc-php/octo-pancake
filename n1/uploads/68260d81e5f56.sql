-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主機： 127.0.0.1
-- 產生時間： 2025-05-15 15:34:21
-- 伺服器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 資料庫： `game_task_platform`
--

-- --------------------------------------------------------

--
-- 資料表結構 `rewards`
--

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `task_id` int(11) DEFAULT NULL,
  `exp` int(11) DEFAULT NULL,
  `coins` int(11) DEFAULT NULL,
  `item_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `rewards`
--

INSERT INTO `rewards` (`id`, `task_id`, `exp`, `coins`, `item_name`) VALUES
(1, 4, 0, 0, ''),
(2, 5, 0, 0, '');

-- --------------------------------------------------------

--
-- 資料表結構 `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `reward` varchar(100) DEFAULT NULL,
  `deadline` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `tasks`
--

INSERT INTO `tasks` (`id`, `title`, `description`, `reward`, `deadline`) VALUES
(1, '新手任務', '上傳一張圖片', '星星一枚', '2025-05-15'),
(2, '讚', '上傳一張圖片', '經驗值:50 金幣:5 獎品:星星', '2025-05-15'),
(3, '高級', '上傳一張圖片', 'exp: 50 coins: 100 item_name: 超級神劍', '2025-05-15'),
(4, '無', '上傳一張圖片', 'exp: 50 coins: 100 item_name: 超級神劍', '2025-05-15'),
(5, '無', '上傳一張圖片', 'exp: 50 coins: 100 item_name: 超級神劍', '2025-05-15');

-- --------------------------------------------------------

--
-- 資料表結構 `uploads`
--

CREATE TABLE `uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `upload_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- 資料表結構 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','player') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(3, 'player01', '$2y$10$cD/p/yOI8tU9xu1I2bQi9OvLiZwYMRaq12X5RfTivJ62Cr8rHtxru', 'player'),
(4, 'admin', '$2y$10$AAl9bbwqoBcE83kZ65VjSehGlthhuHC5f6n.t25LsoLRk/MFb1hey', 'admin');

-- --------------------------------------------------------

--
-- 資料表結構 `user_tasks`
--

CREATE TABLE `user_tasks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `status` enum('pending','completed') DEFAULT 'pending',
  `upload_file_path` varchar(255) DEFAULT NULL,
  `reward_claimed` enum('no','yes') DEFAULT 'no'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- 傾印資料表的資料 `user_tasks`
--

INSERT INTO `user_tasks` (`id`, `user_id`, `task_id`, `status`, `upload_file_path`, `reward_claimed`) VALUES
(5, 3, 1, 'completed', '../uploads/682528c06fed3.png', 'no'),
(6, 4, 1, 'completed', '../uploads/682532444661d.png', 'no'),
(7, 4, 1, 'completed', '../uploads/6825335da603e.png', 'no'),
(8, 4, 2, 'completed', '../uploads/68256936ce46c.png', 'no'),
(9, 4, 3, 'completed', '../uploads/68256ae0db9fc.png', 'no'),
(10, 4, 4, 'completed', '../uploads/68256cb5bc7c7.png', 'yes'),
(11, 4, 5, 'completed', '../uploads/68256f18955f9.png', 'yes');

--
-- 已傾印資料表的索引
--

--
-- 資料表索引 `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `task_id` (`task_id`);

--
-- 資料表索引 `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- 資料表索引 `uploads`
--
ALTER TABLE `uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- 資料表索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- 資料表索引 `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_id` (`task_id`);

--
-- 在傾印的資料表使用自動遞增(AUTO_INCREMENT)
--

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `uploads`
--
ALTER TABLE `uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用資料表自動遞增(AUTO_INCREMENT) `user_tasks`
--
ALTER TABLE `user_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 已傾印資料表的限制式
--

--
-- 資料表的限制式 `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);

--
-- 資料表的限制式 `uploads`
--
ALTER TABLE `uploads`
  ADD CONSTRAINT `uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- 資料表的限制式 `user_tasks`
--
ALTER TABLE `user_tasks`
  ADD CONSTRAINT `user_tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `user_tasks_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
