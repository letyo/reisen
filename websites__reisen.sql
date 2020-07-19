-- phpMyAdmin SQL Dump
-- version 4.7.2
-- https://www.phpmyadmin.net/
--
-- Gép: localhost
-- Létrehozás ideje: 2017. Júl 19. 12:29
-- Kiszolgáló verziója: 5.7.18
-- PHP verzió: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `websites__reisen`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `brute`
--

CREATE TABLE `brute` (
  `user_id` int(11) NOT NULL,
  `time` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `brute`
--

INSERT INTO `brute` (`user_id`, `time`) VALUES
(1, 1490896836),
(1, 1492001291),
(1, 1492001309),
(1, 1492001315),
(1, 1492001322),
(1, 1492001327),
(1, 1492001336),
(1, 1499257551);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `members`
--

CREATE TABLE `members` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `password` varchar(300) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL,
  `next_valid_login_time` int(30) NOT NULL,
  `session_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_hungarian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- A tábla adatainak kiíratása `members`
--

INSERT INTO `members` (`user_id`, `username`, `password`, `email`, `next_valid_login_time`, `session_id`) VALUES
(1, 'buksi', '$2y$10$zY/SeVHEZOFywwhAG762nekzkpzumNBeLi4ZzLXgFG0WVVC8jNHu.', 'hetyey.g@gmail.com', 1492005006, '158f0b4b75d4578.95156712'),
(2, 'juhg', '$2y$10$w5RxkO5Zr.jxJHh00RrwGexlHEU01m4BEzV3ot2.8vpB4/MlF7kYu', 'juhg24@gmail.com', 0, ''),
(3, 'alma', '$2y$10$i/1VT2G907/YmUKP3uwA5OJ2RGurUeJJ5BzpkcELKLoYEgYXBo24y', 'alma@alma.hu', 0, '');

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`user_id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `members`
--
ALTER TABLE `members`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
