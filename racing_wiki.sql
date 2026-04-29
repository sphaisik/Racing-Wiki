-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 29, 2026 at 04:52 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `racing_wiki`
--

-- --------------------------------------------------------

--
-- Table structure for table `analytics_views`
--

CREATE TABLE `analytics_views` (
  `id` bigint(20) NOT NULL,
  `race_page_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(512) DEFAULT NULL,
  `viewed_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bookmarks`
--

CREATE TABLE `bookmarks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `race_page_id` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(120) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`) VALUES
(1, 'Open-Wheel Racing', 'open-wheel-racing', 'Cars with exposed wheels and single-seat cockpits.', 'images/open_wheel.jpg'),
(2, 'Touring Car Racing', 'touring-car-racing', 'Modified road cars racing on circuits.', 'images/touring.jpg'),
(3, 'Sports Car Racing', 'sports-car-racing', 'Racing with sports prototype and grand touring (GT) cars.', 'images/sports.jpg'),
(4, 'Production Car Racing', 'production-car-racing', 'Racing with minimally modified production vehicles.', 'images/production.jpg'),
(5, 'Stock Car Racing', 'stock-car-racing', 'Racing with cars resembling production models but heavily modified.', 'images/stock.jpg'),
(6, 'One-Make Racing', 'one-make-racing', 'All competitors use identical cars from a single manufacturer.', 'images/one-make.jpg'),
(7, 'Drag Racing', 'drag-racing', 'Straight-line acceleration races over a short distance (usually 1/4 mile).', 'images/drag.jpg'),
(8, 'Off-Road Racing', 'off-road-racing', 'Racing on unpaved surfaces like dirt, sand, or gravel.', 'images/off-road.webp'),
(9, 'Rallying', 'rallying', 'Timed stage races on closed public or private roads with varied surfaces.', 'images/rally.jpg'),
(10, 'Dirt Track Racing', 'dirt-track-racing', 'Racing on oval dirt tracks.', 'images/dirt_track.webp');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `race_page_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `parent_comment_id` int(11) DEFAULT NULL,
  `content` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `is_moderated` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `achievements` varchar(255) DEFAULT NULL,
  `years_active` varchar(50) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `image_media_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`id`, `name`, `country`, `dob`, `bio`, `achievements`, `years_active`, `image_path`, `image_media_id`) VALUES
(1, 'Michael Schumacher', 'Germany', NULL, '7× Formula 1 World Champion. Considered one of the greatest F1 drivers of all time.', '7× World Champion', '1991–2012', 'driver-img/Michael-Schumacher.jpg', NULL),
(2, 'Lewis Hamilton', 'UK', NULL, '7× Formula 1 World Champion. Holds the record for most wins and pole positions in F1.', '7× World Champion', '2007–Present', 'driver-img/Lewis-Hamilton.jpg', NULL),
(3, 'Sébastien Loeb', 'France', NULL, '9× WRC World Rally Champion. Dominated the World Rally Championship throughout the 2000s.', '9× World Champion', '1999–Present', 'driver-img/Sébastien-Loeb.jpg', NULL),
(4, 'Sébastien Ogier', 'France', NULL, '8× WRC World Rally Champion. One of the most decorated rally drivers in history.', '8× World Champion', '2007–Present', 'driver-img/Sébastien-Ogier.jpg', NULL),
(5, 'John Force', 'USA', NULL, '16× NHRA Funny Car Champion. The most successful driver in NHRA drag racing history.', '16× NHRA Champion', '1978–Present', 'driver-img/John-Force.jpg', NULL),
(6, 'Dale Earnhardt Sr.', 'USA', NULL, '7× NASCAR Cup Series Champion, known as \"The Intimidator\". Tragically lost his life at Daytona in 2001.', '7× Cup Series Champion', '1975–2001', 'driver-img/Dale-Earnhardt.jpg', NULL),
(7, 'Jimmie Johnson', 'USA', NULL, '7× NASCAR Cup Series Champion. Won five consecutive titles from 2006–2010.', '7× Cup Series Champion', '2001–Present', 'driver-img/Jimmie-Johnson.jpg', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `driver_categories`
--

CREATE TABLE `driver_categories` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `driver_categories`
--

INSERT INTO `driver_categories` (`id`, `driver_id`, `category_id`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 9),
(4, 4, 9),
(5, 5, 7),
(6, 6, 5),
(7, 7, 5);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `race_page_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `start_datetime` datetime DEFAULT NULL,
  `end_datetime` datetime DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `timezone` varchar(100) DEFAULT NULL,
  `recurring_rule` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `winner` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `race_page_id`, `title`, `start_datetime`, `end_datetime`, `location`, `timezone`, `recurring_rule`, `description`, `winner`, `image`) VALUES
(1, 7, '2025 Indianapolis 500', '2025-05-25 12:00:00', '2025-05-25 17:00:00', 'Indianapolis, USA', 'America/New_York', NULL, 'Annual 500-mile IndyCar race at the Indianapolis Motor Speedway.', 'Josef Newgarden', 'event/2025-Indianapolis-500.webp'),
(2, 8, '24 Hours of Le Mans 2024', '2024-06-15 16:00:00', '2024-06-16 16:00:00', 'Le Mans, France', 'Europe/Paris', NULL, 'The legendary 24-hour endurance race on the Circuit de la Sarthe.', 'Ferrari', 'event/24h-Le-Mans-2024.jpg'),
(3, 9, 'F1 Season Finale 2025', '2025-12-07 13:00:00', '2025-12-07 16:00:00', 'Abu Dhabi, UAE', 'Asia/Dubai', NULL, 'The final race of the 2025 Formula 1 World Championship season.', 'Max Verstappen', 'event/F1-Season-Finale-2025.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `path` varchar(1024) DEFAULT NULL,
  `mime_type` varchar(100) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `uploaded_at` datetime DEFAULT current_timestamp(),
  `is_approved` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime NOT NULL,
  `used` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `race_pages`
--

CREATE TABLE `race_pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `summary` varchar(1024) DEFAULT NULL,
  `content` longtext DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `is_published` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `race_pages`
--

INSERT INTO `race_pages` (`id`, `title`, `slug`, `category_id`, `summary`, `content`, `created_by`, `is_published`, `created_at`, `updated_at`) VALUES
(1, 'Monte Carlo Rally', 'monte-carlo-rally', 9, 'Historic WRC rally stage through Monaco known for its challenging snow and tarmac mix.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(2, 'Gainesville Raceway', 'gainesville-raceway', 7, 'Premier NHRA drag racing facility in Florida hosting major national events.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(3, 'Pocono Raceway', 'pocono-raceway', 5, 'Unique triangular NASCAR oval in Pennsylvania, known as the Tricky Triangle.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(4, 'Indianapolis Motor Speedway', 'indianapolis-motor-speedway', 5, '2.5-mile oval known as The Brickyard, hosting both NASCAR and IndyCar events.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(5, 'Circuit de Monaco', 'circuit-de-monaco', 1, 'Iconic 3.34 km F1 street circuit through Monte Carlo with 19 turns.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(6, 'Suzuka Circuit', 'suzuka-circuit', 1, '5.81 km Japanese F1 circuit famous for its unique figure-8 layout and 18 turns.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(7, '2025 Indianapolis 500', '2025-indianapolis-500', 1, 'The 109th running of the Indianapolis 500. Winner: Josef Newgarden.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(8, '24 Hours of Le Mans 2024', '24-hours-le-mans-2024', 3, '2024 FIA WEC endurance race at Le Mans, France. Winner: Ferrari.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39'),
(9, 'F1 Season Finale 2025', 'f1-season-finale-2025', 1, '2025 Formula 1 Abu Dhabi Grand Prix season finale. Winner: Max Verstappen.', NULL, NULL, 1, '2026-04-13 02:27:39', '2026-04-13 02:27:39');

-- --------------------------------------------------------

--
-- Table structure for table `race_page_drivers`
--

CREATE TABLE `race_page_drivers` (
  `id` int(11) NOT NULL,
  `race_page_id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `race_page_drivers`
--

INSERT INTO `race_page_drivers` (`id`, `race_page_id`, `driver_id`, `note`) VALUES
(1, 5, 1, '5× Monaco GP winner'),
(2, 5, 2, '3× Monaco GP winner'),
(3, 6, 1, '6× Japanese GP winner'),
(4, 6, 2, 'Multiple Suzuka wins'),
(5, 1, 3, '8× Monte Carlo Rally winner'),
(6, 1, 4, '8× Monte Carlo Rally winner'),
(7, 3, 6, 'Multiple Pocono wins'),
(8, 4, 7, 'Brickyard 400 winner'),
(9, 2, 5, '16× NHRA champion'),
(10, 7, 7, 'Past Indy competitor');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(3, 'admin'),
(1, 'guest'),
(2, 'registered');

-- --------------------------------------------------------

--
-- Table structure for table `subcategories`
--

CREATE TABLE `subcategories` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `subcategories`
--

INSERT INTO `subcategories` (`id`, `category_id`, `name`, `slug`, `description`) VALUES
(1, 1, 'Formula 1 (F1)', 'formula-1-f1', 'Formula 1 (F1) is the pinnacle of open-wheel racing, featuring the fastest cars and most skilled drivers competing globally in a series of Grand Prix events.'),
(2, 1, 'IndyCar', 'indycar', 'IndyCar is a premier American open-wheel racing series, famous for the Indianapolis 500, showcasing high-speed oval and road course racing.'),
(3, 1, 'Formula 2, Formula 3', 'formula-2-formula-3', 'Formula 2 and Formula 3 serve as key feeder series to Formula 1, providing young drivers with competitive single-seater racing experience.'),
(4, 1, 'GP2, GP3', 'gp2-gp3', 'GP2 and GP3 were former feeder series to Formula 1, now replaced by FIA Formula 2 and Formula 3 championships, focusing on driver development.'),
(5, 1, 'Formula E (electric open-wheel racing)', 'formula-e-electric-open-wheel-racing', 'Formula E is an all-electric single-seater racing series promoting sustainable motorsport with races held on city street circuits worldwide.'),
(6, 2, 'British Touring Car Championship (BTCC)', 'british-touring-car-championship-btcc', 'The British Touring Car Championship (BTCC) is a popular touring car racing series in the UK, featuring modified production cars competing on circuits.'),
(7, 2, 'World Touring Car Cup (WTCR)', 'world-touring-car-cup-wtcr', 'The World Touring Car Cup (WTCR) is an international touring car championship featuring production-based cars racing on circuits globally.'),
(8, 2, 'Super Touring', 'super-touring', 'Super Touring was a popular touring car racing category in the 1990s, known for highly modified production cars and close competition.'),
(9, 2, 'TCR Series', 'tcr-series', 'The TCR Series is a global touring car racing category with cost-effective, production-based cars designed for close and competitive racing.'),
(10, 3, 'Endurance racing (e.g., 24 Hours of Le Mans)', 'endurance-racing-eg-24-hours-of-le-mans', 'Endurance racing, such as the 24 Hours of Le Mans, tests the durability of cars and stamina of drivers over long-distance races.'),
(11, 3, 'GT3, GT4 classes', 'gt3-gt4-classes', 'GT3 and GT4 classes feature grand touring cars modified for racing, balancing performance and cost for competitive sports car racing.'),
(12, 3, 'IMSA WeatherTech SportsCar Championship', 'imsa-weathertech-sportscar-championship', 'The IMSA WeatherTech SportsCar Championship is a North American sports car racing series featuring multiple classes competing simultaneously.'),
(13, 3, 'FIA World Endurance Championship (WEC)', 'fia-world-endurance-championship-wec', 'The FIA World Endurance Championship (WEC) is a global endurance racing series including iconic events like the 24 Hours of Le Mans.'),
(14, 4, 'B Spec', 'b-spec', 'B Spec racing features small, production-based cars with minimal modifications, emphasizing driver skill and close competition.'),
(15, 4, 'Super Production', 'super-production', 'Super Production is a racing category for production cars with limited modifications, focusing on affordability and competitive racing.'),
(16, 4, 'Group N', 'group-n', 'Group N is a motorsport category for near-production cars, allowing only minimal modifications to maintain close ties to road vehicles.'),
(17, 5, 'NASCAR Cup Series', 'nascar-cup-series', 'The NASCAR Cup Series is the premier stock car racing series in the USA, known for high-speed oval track racing and large fan following.'),
(18, 5, 'ARCA Menards Series', 'arca-menards-series', 'The ARCA Menards Series is a stock car racing series in the USA, serving as a developmental platform for drivers aspiring to NASCAR.'),
(19, 5, 'Late Model Stock Cars', 'late-model-stock-cars', 'Late Model Stock Cars are a popular class of stock car racing vehicles, often raced on short oval tracks in grassroots motorsport.'),
(20, 6, 'Porsche Carrera Cup', 'porsche-carrera-cup', 'The Porsche Carrera Cup is a one-make racing series featuring identical Porsche 911 GT3 Cup cars competing in sprint races.'),
(21, 6, 'Ferrari Challenge', 'ferrari-challenge', 'The Ferrari Challenge is a one-make racing series where drivers compete in identical Ferrari race cars, promoting brand loyalty and driver development.'),
(22, 6, 'Renault Clio Cup', 'renault-clio-cup', 'The Renault Clio Cup is a one-make racing series featuring Renault Clio cars, popular in Europe for developing young racing talent.'),
(23, 7, 'Top Fuel Dragsters', 'top-fuel-dragsters', 'Top Fuel Dragsters are the fastest accelerating vehicles in drag racing, capable of covering a quarter-mile in under 4 seconds.'),
(24, 7, 'Funny Cars', 'funny-cars', 'Funny Cars are drag racing vehicles with custom bodies and powerful engines, known for their distinctive appearance and high speeds.'),
(25, 7, 'Pro Stock', 'pro-stock', 'Pro Stock drag racing features cars that resemble production models but are highly modified for maximum performance in straight-line acceleration.'),
(26, 7, 'Motorcycle Drag Racing', 'motorcycle-drag-racing', NULL),
(27, 8, 'Rally Raid (e.g., Dakar Rally)', 'rally-raid-eg-dakar-rally', NULL),
(28, 8, 'Short Course Off-Road Racing', 'short-course-off-road-racing', NULL),
(29, 8, 'Baja 1000', 'baja-1000', NULL),
(30, 8, 'Desert Racing', 'desert-racing', NULL),
(31, 9, 'World Rally Championship (WRC)', 'world-rally-championship-wrc', NULL),
(32, 9, 'Rallycross', 'rallycross', NULL),
(33, 9, 'Hill Climb', 'hill-climb', NULL),
(34, 10, 'Sprint Cars', 'sprint-cars', NULL),
(35, 10, 'Late Models', 'late-models', NULL),
(36, 10, 'Modifieds', 'modifieds', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `length_km` decimal(8,3) DEFAULT NULL,
  `length_display` varchar(50) DEFAULT NULL,
  `turns` int(11) DEFAULT NULL,
  `famous_for` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `race_page_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `name`, `slug`, `location`, `country`, `category_id`, `length_km`, `length_display`, `turns`, `famous_for`, `image`, `race_page_id`) VALUES
(1, 'Monte Carlo Rally', 'monte-carlo-rally', 'Monaco', 'Monaco', 9, 300.000, '~300 km stages', NULL, 'Snow & tarmac mix', 'track-img/Monte-Carlo-Rally.jpg', 1),
(2, 'Gainesville Raceway', 'gainesville-raceway', 'Gainesville, Florida', 'USA', 7, 0.402, '402 m', 0, 'NHRA events', 'track-img/Gainesville-Raceway-Drag.jpg', 2),
(3, 'Pocono Raceway', 'pocono-raceway', 'Long Pond, Pennsylvania', 'USA', 5, 4.023, '2.5 mi', 3, 'Tricky Triangle', 'track-img/Pocono-Raceway-NASCAR.jpg', 3),
(4, 'Indianapolis Motor Speedway', 'indianapolis-motor-speedway', 'Indianapolis, Indiana', 'USA', 5, 4.023, '2.5 mi', 4, 'The Brickyard', 'track-img/Indianapolis-Motor-Speedway-NASCAR.jpg', 4),
(5, 'Circuit de Monaco', 'circuit-de-monaco', 'Monte Carlo', 'Monaco', 1, 3.337, '3.34 km', 19, 'Tight street circuit', 'track-img/Monte-Carlo-F1.jpg', 5),
(6, 'Suzuka Circuit', 'suzuka-circuit', 'Suzuka, Mie', 'Japan', 1, 5.807, '5.81 km', 18, 'Figure-8 layout', 'track-img/Suzuka-Circuit-F1.jpg', 6);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(80) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `display_name` varchar(120) DEFAULT NULL,
  `avatar_media_id` int(11) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `analytics_views`
--
ALTER TABLE `analytics_views`
  ADD PRIMARY KEY (`id`),
  ADD KEY `race_page_id` (`race_page_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_page` (`user_id`,`race_page_id`),
  ADD KEY `race_page_id` (`race_page_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `race_page_id` (`race_page_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `parent_comment_id` (`parent_comment_id`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `driver_categories`
--
ALTER TABLE `driver_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_dc` (`driver_id`,`category_id`),
  ADD KEY `dc_ibfk_2` (`category_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `race_page_id` (`race_page_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uploaded_by` (`uploaded_by`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `race_pages`
--
ALTER TABLE `race_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `race_page_drivers`
--
ALTER TABLE `race_page_drivers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `race_page_id` (`race_page_id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `race_page_id` (`race_page_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `analytics_views`
--
ALTER TABLE `analytics_views`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bookmarks`
--
ALTER TABLE `bookmarks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `driver_categories`
--
ALTER TABLE `driver_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `race_pages`
--
ALTER TABLE `race_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `race_page_drivers`
--
ALTER TABLE `race_page_drivers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `analytics_views`
--
ALTER TABLE `analytics_views`
  ADD CONSTRAINT `analytics_views_ibfk_1` FOREIGN KEY (`race_page_id`) REFERENCES `race_pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `analytics_views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `bookmarks`
--
ALTER TABLE `bookmarks`
  ADD CONSTRAINT `bookmarks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `bookmarks_ibfk_2` FOREIGN KEY (`race_page_id`) REFERENCES `race_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`race_page_id`) REFERENCES `race_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`parent_comment_id`) REFERENCES `comments` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `driver_categories`
--
ALTER TABLE `driver_categories`
  ADD CONSTRAINT `dc_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dc_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`race_page_id`) REFERENCES `race_pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `media_ibfk_1` FOREIGN KEY (`uploaded_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `race_pages`
--
ALTER TABLE `race_pages`
  ADD CONSTRAINT `race_pages_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `race_pages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `race_page_drivers`
--
ALTER TABLE `race_page_drivers`
  ADD CONSTRAINT `race_page_drivers_ibfk_1` FOREIGN KEY (`race_page_id`) REFERENCES `race_pages` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `race_page_drivers_ibfk_2` FOREIGN KEY (`driver_id`) REFERENCES `drivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `subcategories`
--
ALTER TABLE `subcategories`
  ADD CONSTRAINT `subcategories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tracks`
--
ALTER TABLE `tracks`
  ADD CONSTRAINT `tracks_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tracks_ibfk_2` FOREIGN KEY (`race_page_id`) REFERENCES `race_pages` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
