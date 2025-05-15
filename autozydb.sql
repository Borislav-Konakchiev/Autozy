-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Време на генериране: 15 май 2025 в 13:31
-- Версия на сървъра: 8.4.3
-- Версия на PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данни: `autozydb`
--

-- --------------------------------------------------------

--
-- Структура на таблица `brands`
--

CREATE TABLE `brands` (
  `brand_id` int NOT NULL,
  `brand_name` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES
(1, 'Toyota'),
(2, 'BMW'),
(3, 'Audi');

-- --------------------------------------------------------

--
-- Структура на таблица `cars`
--

CREATE TABLE `cars` (
  `car_id` int NOT NULL,
  `brand_id` int NOT NULL,
  `year` int DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `mileage` int DEFAULT NULL,
  `transmission_id` int NOT NULL,
  `fuel_type_id` int NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int NOT NULL,
  `model` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `cars`
--

INSERT INTO `cars` (`car_id`, `brand_id`, `year`, `price`, `mileage`, `transmission_id`, `fuel_type_id`, `image`, `user_id`, `model`) VALUES
(4, 3, 2025, 200000.00, 10, 2, 1, NULL, 16, 'A4');

-- --------------------------------------------------------

--
-- Структура на таблица `car_feature`
--

CREATE TABLE `car_feature` (
  `car_id` int NOT NULL,
  `feature_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `car_feature`
--

INSERT INTO `car_feature` (`car_id`, `feature_id`) VALUES
(4, 1),
(4, 4),
(4, 6);

-- --------------------------------------------------------

--
-- Структура на таблица `car_images`
--

CREATE TABLE `car_images` (
  `id` int NOT NULL,
  `car_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `car_images`
--

INSERT INTO `car_images` (`id`, `car_id`, `image_path`) VALUES
(5, 4, 'images/1747076478_AudiA42.jpg');

-- --------------------------------------------------------

--
-- Структура на таблица `features`
--

CREATE TABLE `features` (
  `feature_id` int NOT NULL,
  `feature_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `features`
--

INSERT INTO `features` (`feature_id`, `feature_name`) VALUES
(1, 'Климатик'),
(2, 'Навигация'),
(3, 'Кожен салон'),
(4, 'Парктроник'),
(5, 'Камера за задно виждане'),
(6, 'Подгряване на седалките'),
(7, 'Автоматични фарове'),
(8, 'Bluetooth'),
(9, 'Темпомат');

-- --------------------------------------------------------

--
-- Структура на таблица `fueltypes`
--

CREATE TABLE `fueltypes` (
  `fuel_type_id` int NOT NULL,
  `fuel_type_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `fueltypes`
--

INSERT INTO `fueltypes` (`fuel_type_id`, `fuel_type_name`) VALUES
(1, 'Бензин'),
(2, 'Дизел'),
(3, 'Електрически');

-- --------------------------------------------------------

--
-- Структура на таблица `transmissions`
--

CREATE TABLE `transmissions` (
  `transmission_id` int NOT NULL,
  `transmission_type` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `transmissions`
--

INSERT INTO `transmissions` (`transmission_id`, `transmission_type`) VALUES
(1, 'Ръчна'),
(2, 'Автоматична');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Схема на данните от таблица `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `email`, `created_at`, `updated_at`) VALUES
(16, 'Борислав Конакчиев', '$2y$10$YHWv2/tfnkbGyewJn/NeqOm0tzGh29jz0/gqmkqrodr8E6UjGxEke', 'borko_konakchiev@abv.bg', '2025-05-07 18:56:21', '2025-05-07 18:56:21');

--
-- Indexes for dumped tables
--

--
-- Индекси за таблица `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Индекси за таблица `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`car_id`),
  ADD KEY `Cars_Brands_FK` (`brand_id`),
  ADD KEY `Cars_FuelTypes_FK` (`fuel_type_id`),
  ADD KEY `Cars_Transmissions_FK` (`transmission_id`),
  ADD KEY `fk_user` (`user_id`);

--
-- Индекси за таблица `car_feature`
--
ALTER TABLE `car_feature`
  ADD PRIMARY KEY (`car_id`,`feature_id`),
  ADD KEY `feature_id` (`feature_id`);

--
-- Индекси за таблица `car_images`
--
ALTER TABLE `car_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `car_images_ibfk_1` (`car_id`);

--
-- Индекси за таблица `features`
--
ALTER TABLE `features`
  ADD PRIMARY KEY (`feature_id`);

--
-- Индекси за таблица `fueltypes`
--
ALTER TABLE `fueltypes`
  ADD PRIMARY KEY (`fuel_type_id`);

--
-- Индекси за таблица `transmissions`
--
ALTER TABLE `transmissions`
  ADD PRIMARY KEY (`transmission_id`);

--
-- Индекси за таблица `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `car_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `car_images`
--
ALTER TABLE `car_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `features`
--
ALTER TABLE `features`
  MODIFY `feature_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ограничения за дъмпнати таблици
--

--
-- Ограничения за таблица `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `Cars_Brands_FK` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`brand_id`),
  ADD CONSTRAINT `Cars_FuelTypes_FK` FOREIGN KEY (`fuel_type_id`) REFERENCES `fueltypes` (`fuel_type_id`),
  ADD CONSTRAINT `Cars_Transmissions_FK` FOREIGN KEY (`transmission_id`) REFERENCES `transmissions` (`transmission_id`),
  ADD CONSTRAINT `fk_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Ограничения за таблица `car_feature`
--
ALTER TABLE `car_feature`
  ADD CONSTRAINT `car_feature_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `car_feature_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `features` (`feature_id`) ON DELETE CASCADE;

--
-- Ограничения за таблица `car_images`
--
ALTER TABLE `car_images`
  ADD CONSTRAINT `car_images_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`car_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
