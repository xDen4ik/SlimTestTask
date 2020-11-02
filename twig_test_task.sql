-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 02 2020 г., 17:29
-- Версия сервера: 5.7.23-log
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `twig_test_task`
--

-- --------------------------------------------------------

--
-- Структура таблицы `sessions`
--

CREATE TABLE `sessions` (
  `session_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_ip` varchar(255) NOT NULL,
  `device_type` varchar(255) NOT NULL,
  `browser` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `sessions`
--

INSERT INTO `sessions` (`session_id`, `user_id`, `user_ip`, `device_type`, `browser`) VALUES
(1, 6, '127.0.0.1', '0', 'Chrome'),
(2, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(3, 7, '127.0.0.1', 'COMPUTER', 'Chrome'),
(4, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(5, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(6, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(7, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(8, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(9, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(10, 7, '127.0.0.1', 'COMPUTER', 'Chrome'),
(11, 6, '127.0.0.1', 'COMPUTER', 'Chrome'),
(12, 7, '127.0.0.1', 'COMPUTER', 'Chrome'),
(13, 7, '127.0.0.1', 'COMPUTER', 'Chrome');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `updated_at` varchar(100) NOT NULL,
  `created_at` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `updated_at`, `created_at`) VALUES
(6, 'Den', 'This', 'lifestealer228@gmail.com', '$2y$10$yYh9hdoVDEEx7EUftNDkaeVgLf4JB8HEKuVOoC9RYXuTVtj9reyRy', '2020-11-01 22:27:14', '2020-10-30 17:34:39'),
(7, 'Denis', 'Pacha', 'cool.den0@yandex.ru', '$2y$10$cVsLBAj4uLrx9U1kO.Z8HeYUXfVd.8ghdLsWqbGTzDVxL/yYnO6t.', '2020-11-01 22:03:57', '2020-10-30 21:27:29');

-- --------------------------------------------------------

--
-- Структура таблицы `user_logs`
--

CREATE TABLE `user_logs` (
  `log_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user_logs`
--

INSERT INTO `user_logs` (`log_id`, `user_id`, `session_id`, `created_at`) VALUES
(1, 6, 1, '2020-10-30 20:25:01'),
(2, 6, 2, '2020-10-30 20:26:34'),
(3, 7, 3, '2020-10-30 21:27:30'),
(4, 6, 4, '2020-11-01 19:47:34'),
(5, 6, 5, '2020-11-01 20:42:17'),
(6, 6, 6, '2020-11-01 20:47:15'),
(7, 6, 7, '2020-11-01 20:53:35'),
(8, 6, 8, '2020-11-01 21:00:17'),
(9, 6, 9, '2020-11-01 21:07:35'),
(10, 7, 10, '2020-11-01 22:09:00'),
(11, 6, 11, '2020-11-01 22:27:31'),
(12, 7, 12, '2020-11-02 15:03:45'),
(13, 7, 13, '2020-11-02 16:05:14');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`session_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `sessions`
--
ALTER TABLE `sessions`
  MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `log_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
