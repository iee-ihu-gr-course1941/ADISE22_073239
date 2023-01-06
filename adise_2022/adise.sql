-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Εξυπηρετητής: 127.0.0.1
-- Χρόνος δημιουργίας: 06 Ιαν 2023 στις 22:34:49
-- Έκδοση διακομιστή: 10.4.25-MariaDB
-- Έκδοση PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Βάση δεδομένων: `adise`
--

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `boardprogress`
--

CREATE TABLE `boardprogress` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tileId` int(11) NOT NULL,
  `isPlayed` tinyint(4) NOT NULL DEFAULT 0,
  `dateModified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `boards`
--

CREATE TABLE `boards` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `owner` varchar(50) NOT NULL,
  `dateCreated` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `boards`
--

INSERT INTO `boards` (`id`, `name`, `owner`, `dateCreated`) VALUES
(7, 'Random', 'Chatzia', '2023-01-02 00:00:00');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `boardtiles`
--

CREATE TABLE `boardtiles` (
  `id` int(11) NOT NULL,
  `tileId` int(11) NOT NULL,
  `boardId` int(11) NOT NULL,
  `boardOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `boardtiles`
--

INSERT INTO `boardtiles` (`id`, `tileId`, `boardId`, `boardOrder`) VALUES
(18, 5, 7, 8),
(23, 13, 7, 12),
(24, 10, 7, 13),
(27, 9, 7, 16),
(29, 5, 7, 18),
(31, 1, 7, 19),
(32, 9, 7, 20),
(33, 18, 7, 21),
(34, 26, 7, 22),
(35, 3, 7, 23),
(36, 13, 7, 24),
(37, 5, 7, 25),
(38, 1, 7, 26);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `players`
--

CREATE TABLE `players` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `players`
--

INSERT INTO `players` (`id`, `name`) VALUES
(1, 'someone-1'),
(2, 'someone-2'),
(3, 'someone-3'),
(4, 'someone-4'),
(5, 'someone-5');

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `tileprogress`
--

CREATE TABLE `tileprogress` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `tileId` int(11) NOT NULL,
  `played` int(11) NOT NULL DEFAULT 0,
  `dateModified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `tiles`
--

CREATE TABLE `tiles` (
  `id` int(11) NOT NULL,
  `title` varchar(70) NOT NULL,
  `player` int(11) NOT NULL,
  `variation` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `filePath` varchar(250) NOT NULL,
  `playOrder` int(11) NOT NULL,
  `isPlayed` tinyint(4) NOT NULL DEFAULT 0,
  `plays` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `tiles`
--

INSERT INTO `tiles` (`id`, `title`, `player`, `variation`, `points`, `filePath`, `playOrder`, `isPlayed`, `plays`) VALUES
(1, 'zero-zero', 1, 2, 0, 'assets/images/tiles/zero-zero.png', 1, 1, 32),
(2, 'one-zero', 1, 2, 0, 'assets/images/tiles/one-zero.png', 7, 1, 29),
(3, 'two-zero', 1, 2, 0, 'assets/images/tiles/two-zero.png', 2, 1, 30),
(4, 'three-zero', 1, 2, 5, 'assets/images/tiles/three-zero.png', 8, 1, 36),
(5, 'four-zero', 1, 2, 5, 'assets/images/tiles/four-zero.png', 4, 1, 29),
(6, 'five-zero', 1, 2, 5, 'assets/images/tiles/five-zero.png', 6, 1, 31),
(7, 'six-zero', 1, 2, 5, 'assets/images/tiles/six-zero.png', 3, 1, 24),
(8, 'one-one', 1, 2, 0, 'assets/images/tiles/one-one.png', 5, 1, 25),
(9, 'one-two', 1, 2, 5, 'assets/images/tiles/one-two.png', 12, 1, 33),
(10, 'one-three', 1, 2, 5, 'assets/images/tiles/one-three.png', 20, 1, 33),
(11, 'one-four', 1, 2, 5, 'assets/images/tiles/one-four.png', 9, 1, 28),
(12, 'one-five', 1, 2, 5, 'assets/images/tiles/οne-five.png', 11, 1, 34),
(13, 'one-six', 1, 2, 5, 'assets/images/tiles/one-six.png', 21, 1, 45),
(14, 'two-two', 1, 2, 5, 'assets/images/tiles/two-two.png', 10, 1, 39),
(15, 'two-three', 1, 2, 5, 'assets/images/tiles/two-three.png', 17, 1, 23),
(16, 'two-four', 1, 2, 5, 'assets/images/tiles/two-four.png', 22, 1, 32),
(17, 'two-five', 1, 2, 5, 'assets/images/tiles/two-five.png', 13, 1, 18),
(18, 'two-six', 1, 2, 10, 'assets/images/tiles/two-six.png', 23, 1, 23),
(19, 'three-three', 1, 2, 5, 'assets/images/tiles/three-three.png', 14, 1, 29),
(20, 'three-four', 1, 2, 5, 'assets/images/tiles/three-four.png', 24, 1, 27),
(21, 'three-five', 1, 2, 10, 'assets/images/tiles/three-five.png', 16, 1, 37),
(22, 'three-six', 1, 2, 10, 'assets/images/tiles/three-six.png', 15, 1, 29),
(23, 'four-four', 1, 2, 10, 'assets/images/tiles/four-four.png', 25, 1, 29),
(24, 'four-five', 1, 2, 10, 'assets/images/tiles/four-five.png', 18, 1, 32),
(25, 'four-six', 1, 2, 10, 'assets/images/tiles/four-six.png', 19, 1, 37),
(26, 'five-five', 1, 2, 10, 'assets/images/tiles/five-five.png', 27, 1, 26),
(27, 'five-six', 1, 2, 10, 'assets/images/tiles/five-six.png', 28, 1, 29),
(28, 'six-six', 1, 2, 10, 'assets/images/tiles/six-six.png', 26, 1, 21);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(25) NOT NULL,
  `lastName` varchar(25) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signUpDate` datetime NOT NULL DEFAULT current_timestamp(),
  `isSubscribed` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `username`, `email`, `password`, `signUpDate`, `isSubscribed`) VALUES
(1, 'iChatzia', 'Giannis', 'Chatzia', 'Someone12@gmail.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '2022-12-20 21:09:57', 0),
(2, 'John', 'Giannis', 'Chatzi', 'Example@gmail.com', 'b109f3bbbc244eb82441917ed06d618b9008dd09b3befd1b5e07394c706a8bb980b1d7785e5976ec049b46df5f1326af5a2ea6d103fd07c95385ffab0cacbc86', '2022-12-20 22:15:54', 0);

-- --------------------------------------------------------

--
-- Δομή πίνακα για τον πίνακα `variations`
--

CREATE TABLE `variations` (
  `id` int(11) NOT NULL,
  `title` varchar(250) NOT NULL,
  `player` int(11) NOT NULL,
  `gamePath` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Άδειασμα δεδομένων του πίνακα `variations`
--

INSERT INTO `variations` (`id`, `title`, `player`, `gamePath`) VALUES
(1, 'Block dominoes', 1, 'assets/images/variations/block-dominoes.jpg'),
(2, 'Straight dominoes', 1, 'assets/images/variations/straight-dominoes.jpg'),
(3, 'All Fives dominoes', 2, 'assets/images/variations/all-fives-dominoes.jpg'),
(4, 'Chicken Foot dominoes', 3, 'assets/images/variations/chicken-foot-dominoes.jpg'),
(5, 'Mexican Train dominoes', 4, 'assets/images/variations/mexican-train-dominoes.jpg'),
(6, 'Kingdomino', 5, 'assets/images/variations/king-domino.jpg');

--
-- Ευρετήρια για άχρηστους πίνακες
--

--
-- Ευρετήρια για πίνακα `boardprogress`
--
ALTER TABLE `boardprogress`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `boards`
--
ALTER TABLE `boards`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `boardtiles`
--
ALTER TABLE `boardtiles`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `players`
--
ALTER TABLE `players`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `tileprogress`
--
ALTER TABLE `tileprogress`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `tiles`
--
ALTER TABLE `tiles`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Ευρετήρια για πίνακα `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT για άχρηστους πίνακες
--

--
-- AUTO_INCREMENT για πίνακα `boardprogress`
--
ALTER TABLE `boardprogress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `boards`
--
ALTER TABLE `boards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT για πίνακα `boardtiles`
--
ALTER TABLE `boardtiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT για πίνακα `players`
--
ALTER TABLE `players`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT για πίνακα `tileprogress`
--
ALTER TABLE `tileprogress`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT για πίνακα `tiles`
--
ALTER TABLE `tiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT για πίνακα `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT για πίνακα `variations`
--
ALTER TABLE `variations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
