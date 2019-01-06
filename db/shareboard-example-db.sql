-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Czas generowania: 04 Sty 2019, 13:55
-- Wersja serwera: 8.0.13
-- Wersja PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `shareboard`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `share_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `comments`
--

INSERT INTO `comments` (`id`, `user_id`, `share_id`, `comment`) VALUES
(1, 1, 13, 'Bob\'s comment'),
(2, 2, 13, 'Alice\'s comment');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `shares`
--

CREATE TABLE `shares` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `like_count` int(11) NOT NULL,
  `comment_count` int(11) NOT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Zrzut danych tabeli `shares`
--

INSERT INTO `shares` (`id`, `user_id`, `title`, `body`, `like_count`, `comment_count`) VALUES
(1, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 1, 0),
(2, 2, 'Alice\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(3, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(4, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(5, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(6, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(7, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(8, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(9, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(10, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(11, 2, 'Alice\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(12, 1, 'Bob\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget justo porttitor urna dictum fermentum sit amet sed mauris. Praesent molestie vestibulum erat ac rhoncus. Aenean nunc risus, accumsan nec ipsum et, convallis sollicitudin dui. Proin dictum quam a semper malesuada. Etiam porta sit amet risus quis porta. Nulla facilisi. Cras at interdum ante. Ut gravida pharetra ligula vitae malesuada.', 0, 0),
(13, 2, 'Alice\'s post', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam et fermentum dui. Ut orci quam, ornare sed lorem sed, hendrerit auctor dolor. Nulla viverra, nibh quis ultrices malesuada, ligula ipsum vulputate diam, aliquam egestas nibh ante vel dui. Sed in tellus interdum eros vulputate placerat sed non enim. Pellentesque eget.', 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `about` varchar(500) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT 'This paragraph contains a brief descrption of user''s profile. User can edit this content and personalize it for other users to see.',
  `created_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published_shares` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `liked_shares` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `profile_pic` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `about`, `published_shares`, `liked_shares`, `profile_pic`) VALUES
(1, 'Bob', 'bob@mail.com', '$2y$10$RxObUfjRSzuiUWiuGi4N9eJmlOJrzUV.FInD899WayupCgpzUB/fe', 'This paragraph contains a brief descrption of user\'s profile. User can edit this content and personalize it for other users to see.', ',1,', ',13,', 1),
(2, 'Alice', 'alice@mail.com', '$2y$10$qdYXi488L12uYfPhaOmqe.oUleiawewkqeBBa7p4xeWYDGCkzk9Hy', 'This paragraph contains a brief descrption of user\'s profile. User can edit this content and personalize it for other users to see.', ',13,', ',13,1,', 1),
(3, 'TestUser', 'test@mail.com', '$2y$10$V7HR0R3zs6ZjNRGXVCe56ObeMqzQbzXZW6zp5xTIJ8ItlUaeVnDfG', 'This paragraph contains a brief descrption of user\'s profile. User can edit this content and personalize it for other users to see.', ',', ',', 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `shares`
--
ALTER TABLE `shares`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `shares`
--
ALTER TABLE `shares`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
