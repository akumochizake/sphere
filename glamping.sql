-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 15 2024 г., 11:39
-- Версия сервера: 8.0.30
-- Версия PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `glamping`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sphere_id` int NOT NULL,
  `check_in_date` date NOT NULL,
  `check_in_time` time NOT NULL,
  `check_out_date` date NOT NULL,
  `check_out_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `sphere_id`, `check_in_date`, `check_in_time`, `check_out_date`, `check_out_time`) VALUES
(1, 1, 1, '2024-06-20', '10:00:00', '2024-06-25', '12:00:00'),
(2, 1, 2, '2024-07-01', '14:00:00', '2024-07-05', '11:00:00'),
(3, 2, 3, '2024-08-10', '09:00:00', '2024-08-15', '10:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `ordered_spheres`
--

CREATE TABLE `ordered_spheres` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `sphere_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `ordered_spheres`
--

INSERT INTO `ordered_spheres` (`id`, `user_id`, `sphere_id`) VALUES
(1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `sphere_id` int NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `spheres`
--

CREATE TABLE `spheres` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int NOT NULL,
  `area` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `availability` enum('available','booked') NOT NULL DEFAULT 'available',
  `image` varchar(255) NOT NULL,
  `available_from` date DEFAULT NULL,
  `available_to` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `spheres`
--

INSERT INTO `spheres` (`id`, `name`, `price`, `capacity`, `area`, `description`, `availability`, `image`, `available_from`, `available_to`) VALUES
(1, 'Уютная дача', '100.00', 4, '50.00', 'Прекрасная дача для уединенного отдыха на природе.', 'available', 'https://www.davno.ru/assets/images/cards/big/birthday-835.jpg', '2024-06-10', '2024-06-20'),
(2, 'Эко-бунгало', '80.00', 2, '35.00', 'Уютное бунгало с видом на лес и озеро.', 'available', '', '2024-07-01', '2024-07-10'),
(3, 'Люксовый домик', '150.00', 6, '80.00', 'Просторный домик с современным дизайном и всеми удобствами для комфортного проживания.', 'available', '', '2024-08-15', '2024-08-25');

-- --------------------------------------------------------

--
-- Структура таблицы `sphere_photos`
--

CREATE TABLE `sphere_photos` (
  `id` int NOT NULL,
  `sphere_id` int NOT NULL,
  `photo_url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `sphere_photos`
--

INSERT INTO `sphere_photos` (`id`, `sphere_id`, `photo_url`) VALUES
(1, 1, 'https://www.davno.ru/assets/images/cards/big/birthday-835.jpg'),
(2, 1, 'https://example.com/photos/sphere1_2.jpg'),
(3, 2, 'https://example.com/photos/sphere2_1.jpg'),
(4, 3, 'https://example.com/photos/sphere3_1.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, '', '$2y$10$.BRALvnoOWCaRDCXUyxGsu6ywdpvxnQfrHa.n.0iWvX0bbWPtPC2a'),
(2, 'zxc', '$2y$10$GTo52A84GNKZdBW7MQ19OOsCn4oa98UgDAaCRkeR007ok8StWMHqG');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sphere_id` (`sphere_id`);

--
-- Индексы таблицы `ordered_spheres`
--
ALTER TABLE `ordered_spheres`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sphere_id` (`sphere_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sphere_id` (`sphere_id`);

--
-- Индексы таблицы `spheres`
--
ALTER TABLE `spheres`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sphere_photos`
--
ALTER TABLE `sphere_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sphere_id` (`sphere_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `ordered_spheres`
--
ALTER TABLE `ordered_spheres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `spheres`
--
ALTER TABLE `spheres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `sphere_photos`
--
ALTER TABLE `sphere_photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`sphere_id`) REFERENCES `spheres` (`id`);

--
-- Ограничения внешнего ключа таблицы `ordered_spheres`
--
ALTER TABLE `ordered_spheres`
  ADD CONSTRAINT `ordered_spheres_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `ordered_spheres_ibfk_2` FOREIGN KEY (`sphere_id`) REFERENCES `spheres` (`id`);

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`sphere_id`) REFERENCES `spheres` (`id`);

--
-- Ограничения внешнего ключа таблицы `sphere_photos`
--
ALTER TABLE `sphere_photos`
  ADD CONSTRAINT `sphere_photos_ibfk_1` FOREIGN KEY (`sphere_id`) REFERENCES `spheres` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
