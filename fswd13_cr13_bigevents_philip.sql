-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2021 at 10:22 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fswd13_cr13_bigevents_philip`
--
CREATE DATABASE IF NOT EXISTS `fswd13_cr13_bigevents_philip` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fswd13_cr13_bigevents_philip`;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `fk_events_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capacity` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `fk_events_id`, `name`, `date`, `description`, `image`, `capacity`, `email`, `phone`, `address`, `url`) VALUES
(1, 5, 'AniNite', '2021-08-27 11:00:00', 'Bei der größten, schönsten und besten Anime- und Manga-Convention Österreichs!*Nach einer furchtbaren gefühlt endlosen Pause freut sich das gesamte AniNite-Team dich endlich wieder begrüßen zu dürfen!', 'https://scontent-ams4-1.xx.fbcdn.net/v/t1.6435-9/126899882_10157794258120754_9008659320302045072_n.jpg?_nc_cat=103&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=1i8rXo3AYugAX8mA9Sm&_nc_ht=scontent-ams4-1.xx&oh=8bb8bcc34caeb95874eba323495e0393&oe=6158EE5A', 1000, 'info@aninite.at', ' / ', 'Parkallee 2, A-2334 Vösendorf', 'https://www.aninite.at/'),
(2, 3, 'Area 52', '2021-09-04 14:00:00', 'Wiens beste Gaming-Location! Vorbeikommen und zocken. Hunderte Games zur Auswahl. Euch erwarten 24 PlayStation 4, 12 Nintendo Switch und 40 PC-Systeme. Wir veranstalten viele Turniere in den unterschiedlichsten Disziplinen. Es gibt LAN-Parties, Bootcamps,', 'https://scontent-ams4-1.xx.fbcdn.net/v/t1.18169-9/427916_380923375285525_1796853266_n.jpg?_nc_cat=110&ccb=1-5&_nc_sid=09cbfe&_nc_ohc=mQh1yq2ePq8AX9AkDO7&tn=a8nkFYFszhIWfe_y&_nc_ht=scontent-ams4-1.xx&oh=41b0ccbee1403907313a763e8a400d22&oe=61569D95', 100, 'office@area52.at', '+43 1 264005352', 'Franklinstrasse 20/9/R1 1210 Wien, Austria', 'http://www.area52.at/'),
(3, 5, 'YuniCon', '2021-10-29 09:00:00', 'Anime, Manga and Gaming Fans out there watch out! YuniCon opens its gates again from 29.-31. October 2021.\r\nThere will be tons of Action, Entertainment and Fun! Come join us, let’s celebrate and make the Convention into an unforgettable memory!', 'Announcement_YuniCon_2020.jpg', 500, 'info@yunicon.at', '+43 650 5403268', 'Möhringgasse 2-4, Schwechat, AT 2320', 'http://www.yunicon.at/'),
(4, 2, 'Detective Conan Movie 24', '2021-06-06 19:30:00', 'The Scarlet Bullet is the 24th movie in the Detective Conan franchise. On March 24, 2021, the movie was announced to be screened in IMAX, MX4D, 4DX, and DOLBY CINEMA.', 'conanfilm24-61325ade131ea.jpg', 40, 'office@gasometer.at', '/', 'Guglgasse 8/2/2/1, 1110 Wien', 'https://www.megaplex.at/film/detectiv-conan-24'),
(5, 1, 'Kris Kristofferson', '2021-11-15 20:00:00', 'Einzig Kris Kristofferson schaut seit Jahren regelmäßig auch hierzulande vorbei. Der 72-Jährige gastierte am Freitag in der Wiener Stadthalle, wie zuletzt üblich ohne Band.', 'https://www.volume.at/cdn/kris_1__original.jpg', 500, 'presse@stadthalle.com', '+43 1 981 00-0', 'Wiener Stadthalle, Halle F, Roland Rainer Platz 1, 1150 Vienna', 'https://www.stadthalle.com/'),
(6, 1, 'Lenny Kravitz', '2029-12-09 19:30:00', 'Rock-Größe Lenny Kravitz gastiert im Rahmen seiner Europatournee am 17. Dezember in der Wiener Stadthalle.\r\nKravitz´ zehntes Studioalbum Strut wird am 23. September 2014 veröffentlicht. Ein Album voll purem Rock´n´Roll, das voller Rhythmizität jegliche Fo', 'https://815.si/wp-content/uploads/2018/05/25188995_1697420083635325_8127096420683058350_o-696x392.jpg', 500, 'presse@stadthalle.com', '+43 1 981 00-0', 'Wiener Stadthalle - Halle D, Roland Rainer Platz 1,\r\n1150 Vienna', 'https://www.stadthalle.com/de/schauen/events/19/Lenny-Kravitz');

-- --------------------------------------------------------

--
-- Table structure for table `type`
--

CREATE TABLE `type` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `type`
--

INSERT INTO `type` (`id`, `name`) VALUES
(1, 'Music'),
(2, 'Movie'),
(3, 'Sport'),
(4, 'Theater'),
(5, 'Convention');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5387574AFC33C7F5` (`fk_events_id`);

--
-- Indexes for table `type`
--
ALTER TABLE `type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `type`
--
ALTER TABLE `type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `FK_5387574AFC33C7F5` FOREIGN KEY (`fk_events_id`) REFERENCES `type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
