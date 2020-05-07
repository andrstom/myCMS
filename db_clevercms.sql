-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 07. kvě 2020, 09:46
-- Verze serveru: 10.1.38-MariaDB
-- Verze PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `clevercms`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(2, 'Lorem ipsum dolor sit amet', '<p style=\"text-align: center;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'john@doe.com', 1581332797, 'andrsak85@gmail.com', 1588831971),
(3, 'Lorem ipsum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', 'john@doe.com', 1581489026, 'andrsak85@gmail.com', 1588831917);

-- --------------------------------------------------------

--
-- Struktura tabulky `articles_gallery`
--

CREATE TABLE `articles_gallery` (
  `id` int(11) NOT NULL,
  `articles_id` int(11) NOT NULL,
  `gallery_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `articles_gallery`
--

INSERT INTO `articles_gallery` (`id`, `articles_id`, `gallery_id`) VALUES
(1, 3, 19),
(2, 2, 20);

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `articles_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Article comments';

-- --------------------------------------------------------

--
-- Struktura tabulky `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Images (URL)';

-- --------------------------------------------------------

--
-- Struktura tabulky `food_alergens`
--

CREATE TABLE `food_alergens` (
  `id` int(11) NOT NULL,
  `short_name` varchar(20) NOT NULL,
  `long_name` varchar(100) NOT NULL,
  `detail` text NOT NULL,
  `image_url` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Food alergens (alergeny)';

--
-- Vypisuji data pro tabulku `food_alergens`
--

INSERT INTO `food_alergens` (`id`, `short_name`, `long_name`, `detail`, `image_url`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, '1', 'Obiloviny obsahující lepek', '<p>p&scaron;enice, žito, ječmen, oves, &scaron;palda, kamut nebo jejich hybridn&iacute; odrůdy a v&yacute;robky z nich</p>', '/img/food_menu/obiloviny.jpg', 'andrsak85@gmail.com', 2147483647, 'andrsak85@gmail.com', 1588677339),
(2, '2', 'Korýši', '<p>Kor&yacute;&scaron;i a v&yacute;robky z nich</p>', '/img/food_menu/korysi.jpg', 'andrsak85@gmail.com', 2147483647, 'andrsak85@gmail.com', 1588677351),
(5, '3', 'Vejce', '<p>Vejce a v&yacute;robky z nich</p>', '/img/food_menu/vejce.jpg', 'jidelna@msval.cz', 1587629791, 'andrsak85@gmail.com', 1588677363),
(6, '4', 'Ryby', '<p>Ryby a v&yacute;robky z nich</p>', '/img/food_menu/ryby.jpg', 'jidelna@msval.cz', 1587631126, 'andrsak85@gmail.com', 1588677372),
(7, '5', 'Podzemnice olejná (arašídy)', '<p>Ara&scaron;&iacute;dy a v&yacute;robky z nich</p>', '/img/food_menu/arasidy.jpg', 'jidelna@msval.cz', 1587631168, 'andrsak85@gmail.com', 1588677400),
(8, '6', 'Sojové boby (sója)', '<p>Sojov&eacute; boby a v&yacute;robky z nich</p>', '/img/food_menu/sojove-boby.jpg', 'jidelna@msval.cz', 1587631226, 'andrsak85@gmail.com', 1588677409),
(9, '7', 'Mléko', '<p>Ml&eacute;ko a v&yacute;robky z něj</p>', '/img/food_menu/mleko.jpg', 'jidelna@msval.cz', 1587631329, 'andrsak85@gmail.com', 1588677428),
(10, '8', 'Skořápkové plody', '<p>mandle, l&iacute;skov&eacute; ořechy, vla&scaron;sk&eacute; ořechy, ke&scaron;u ořechy, pekanov&eacute;<br />ořechy, para ořechy, pist&aacute;cie, makadamie a v&yacute;robky z nich</p>', '/img/food_menu/orechy.jpg', 'jidelna@msval.cz', 1587631378, 'andrsak85@gmail.com', 1588677438),
(11, '9', 'Celer', '<p>Celer a v&yacute;robky z něj</p>', '/img/food_menu/celer.jpg', 'jidelna@msval.cz', 1587631400, 'andrsak85@gmail.com', 1588677447),
(12, '10', 'Hořčice', '<p>Hořčice a v&yacute;robky z n&iacute;</p>', '/img/food_menu/horcice.jpg', 'jidelna@msval.cz', 1587631426, 'andrsak85@gmail.com', 1588677457),
(13, '11', 'Sezamová semena (sezam)', '<p>Sezamov&aacute; semena a v&yacute;robky z nich</p>', '/img/food_menu/sezam.png', 'jidelna@msval.cz', 1587631464, 'andrsak85@gmail.com', 1588677472),
(14, '12', 'Oxid siřičitý a siřičitany', '<p>v koncentrac&iacute;ch vy&scaron;&scaron;&iacute;ch 10 mg, ml/kg, l, vyj&aacute;dřeno SO<sub>2</sub></p>', '/img/food_menu/so2.png', 'jidelna@msval.cz', 1587631538, 'andrsak85@gmail.com', 1588677510),
(15, '13', 'Vlčí bob (lupina)', '<p>Vlč&iacute; bob a v&yacute;robky z něj</p>', '/img/food_menu/lupina.jpg', 'jidelna@msval.cz', 1587631570, 'andrsak85@gmail.com', 1588677519),
(16, '14', 'Měkkýši', '<p>Měkk&yacute;&scaron;i a v&yacute;robky z nich</p>', '/img/food_menu/mekkysi.jpg', 'jidelna@msval.cz', 1587631595, 'andrsak85@gmail.com', 1588677531);

-- --------------------------------------------------------

--
-- Struktura tabulky `food_menu`
--

CREATE TABLE `food_menu` (
  `id` int(11) NOT NULL,
  `day` date NOT NULL,
  `week` int(5) NOT NULL,
  `breakfast` varchar(255) NOT NULL,
  `breakfast_alergens` varchar(100) NOT NULL,
  `soup` varchar(255) NOT NULL,
  `soup_alergens` varchar(100) NOT NULL,
  `main_course` varchar(255) NOT NULL,
  `main_course_alergens` varchar(100) NOT NULL,
  `snack` varchar(255) NOT NULL,
  `snack_alergens` varchar(100) NOT NULL,
  `creator` varchar(255) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='menu (jidelnicek)';

--
-- Vypisuji data pro tabulku `food_menu`
--

INSERT INTO `food_menu` (`id`, `day`, `week`, `breakfast`, `breakfast_alergens`, `soup`, `soup_alergens`, `main_course`, `main_course_alergens`, `snack`, `snack_alergens`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(4, '2020-05-11', 20, 'Makový koláč, čaj', '1', 'Hovězí vývar, nudle', '1', 'Rajská omáčka, knedlík', '1', 'Rohlík se šunkou, ovoce', '1', 'jidelna@msval.cz', 1587724086, 'andrsak85@gmail.com', 1588581645),
(5, '2020-05-12', 20, 'snídaně', '1, 2', 'polevka', '1', 'hlavni', '1', 'svaca', '1, 2, 4', 'jidelna@msval.cz', 1588240508, 'andrsak85@gmail.com', 1588581694),
(6, '2020-05-13', 20, 'asdg', '3', 'sdfg', '7, 8', 'sdfghfg', '4, 7', 'fdgjfgjh', '2, 5, 7', 'jidelna@msval.cz', 1588240509, 'andrsak85@gmail.com', 1588581707),
(7, '2020-05-14', 20, 'fghjgfhj', '5, 6', 'fhkhjk', '7, 8', 'ghjkghk', '8', 'hjkghjkjhg', '6, 7', 'jidelna@msval.cz', 1588240509, 'andrsak85@gmail.com', 1588581717),
(8, '2020-05-15', 20, '-', '', '', '', '', '', '', '', 'jidelna@msval.cz', 1588240509, 'andrsak85@gmail.com', 1588581977);

-- --------------------------------------------------------

--
-- Struktura tabulky `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` varchar(255) NOT NULL,
  `album_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `url_thumb` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Images (URL)';

--
-- Vypisuji data pro tabulku `gallery`
--

INSERT INTO `gallery` (`id`, `name`, `description`, `album_id`, `url`, `url_thumb`, `creator`, `created_at`) VALUES
(19, 'countryside1.jpg', 'Country', 1, '/img/galerie/countryside1.jpg', '/img/galerie/thumb/countryside1.jpg', 'andrsak85@gmail.com', '2020-05-07 06:11:57'),
(20, 'puzzle.jpg', '', 1, '/img/galerie/puzzle.jpg', '/img/galerie/thumb/puzzle.jpg', 'andrsak85@gmail.com', '2020-05-07 06:12:51');

-- --------------------------------------------------------

--
-- Struktura tabulky `gallery_album`
--

CREATE TABLE `gallery_album` (
  `id` int(11) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `gallery_album`
--

INSERT INTO `gallery_album` (`id`, `short_name`, `name`) VALUES
(1, 'nezarazeno', 'Nezařazeno'),
(2, 'produkty', 'Produkty'),
(3, 'priroda', 'Příroda');

-- --------------------------------------------------------

--
-- Struktura tabulky `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `token` varchar(100) NOT NULL,
  `confirmed` varchar(5) NOT NULL,
  `created_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`, `token`, `confirmed`, `created_at`) VALUES
(1, 'andrsak85@gmail.com', '8d8037f57d896b45d704073e35bc460412154572', 'ANO', 1584975519);

-- --------------------------------------------------------

--
-- Struktura tabulky `organisation`
--

CREATE TABLE `organisation` (
  `id` int(11) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `gsm` varchar(20) NOT NULL,
  `street` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal` varchar(10) NOT NULL,
  `ico` varchar(15) NOT NULL,
  `dic` varchar(15) NOT NULL,
  `account` varchar(50) NOT NULL,
  `sponsors` varchar(5) NOT NULL,
  `clients` varchar(5) NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(255) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='about organisation';

--
-- Vypisuji data pro tabulku `organisation`
--

INSERT INTO `organisation` (`id`, `short_name`, `name`, `logo`, `email`, `phone`, `gsm`, `street`, `city`, `postal`, `ico`, `dic`, `account`, `sponsors`, `clients`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, 'cleverCMS', 'cleverCMS', '/organisations/1/main_logo.png', 'john.doe@mejluj.cz', '+420 123 456 789', '+420 123 456 789', 'Neznámá 666', 'Neználkov', '666 09', '123456', 'CZ123456', '123654789/0989', 'ANO', 'ANO', 'andrsak85@gmail.com', 1582889043, 'andrsak85@gmail.com', 1588833865);

-- --------------------------------------------------------

--
-- Struktura tabulky `organisation_clients`
--

CREATE TABLE `organisation_clients` (
  `id` int(11) NOT NULL,
  `organisation_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `image_url` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `organisation_clients`
--

INSERT INTO `organisation_clients` (`id`, `organisation_id`, `name`, `link`, `image_url`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, 1, 'Strider', 'http://www.seznam.cz', '/organisations/1/image_client_1.png', 'andrsak85@gmail.com', 1588753330, 'andrsak85@gmail.com', 1588834589),
(2, 1, 'InFocus', 'http://www.seznam.cz', '/organisations/1/image_client_2.png', 'andrsak85@gmail.com', 1588834618, '', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `organisation_employees`
--

CREATE TABLE `organisation_employees` (
  `id` int(11) NOT NULL,
  `organisation_id` int(11) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gsm` varchar(20) NOT NULL,
  `position` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `organisation_employees`
--

INSERT INTO `organisation_employees` (`id`, `organisation_id`, `firstname`, `lastname`, `email`, `gsm`, `position`, `image`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(4, 1, 'Parťák', 'Tom', 'jsem@boss.cz', '+420 123 456 789', 'boss', '/organisations/1/image_employee_4.jpg', 'andrsak85@gmail.com', 1584024274, 'andrsak85@gmail.com', 1588834322),
(8, 1, 'Petra', 'Šikovná', 'petra@sikovna.cz', '', 'office manager', '/organisations/1/image_employee_8.jpg', 'andrsak85@gmail.com', 1584024451, 'andrsak85@gmail.com', 1588833665);

-- --------------------------------------------------------

--
-- Struktura tabulky `organisation_sponsors`
--

CREATE TABLE `organisation_sponsors` (
  `id` int(11) NOT NULL,
  `organisation_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` text NOT NULL,
  `image_url` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `organisation_sponsors`
--

INSERT INTO `organisation_sponsors` (`id`, `organisation_id`, `name`, `link`, `image_url`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, 1, 'Sponzor 1', 'https://www.centrum.cz', '/organisations/1/image_sponsor_1.png', 'andrsak85@gmail.com', 1586860858, 'andrsak85@gmail.com', 1588834640),
(6, 1, 'Sponzor 2', 'https://www.centrum.cz', '/organisations/1/image_sponsor_6.png', 'andrsak85@gmail.com', 1586863906, 'andrsak85@gmail.com', 1588834650);

-- --------------------------------------------------------

--
-- Struktura tabulky `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `section_type` varchar(100) NOT NULL,
  `section_priority` int(11) NOT NULL,
  `section_width` int(11) NOT NULL,
  `section_columns` int(11) NOT NULL,
  `section_title` text NOT NULL,
  `section_content` text NOT NULL,
  `section_image` text NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `sections`
--

INSERT INTO `sections` (`id`, `section_type`, `section_priority`, `section_width`, `section_columns`, `section_title`, `section_content`, `section_image`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, 'about', 1, 12, 4, 'cleverCMS', '<p style=\"text-align: center;\">Vytvoř si snadno a rychle osobn&iacute; nebo firemn&iacute; web.</p>', '', 'andrsak85@gmail.com', 1582889043, 'andrsak85@gmail.com', 1588832561),
(2, 'univ', 2, 12, 6, 'Lorem ipsum dolor sit amet', '<p style=\"text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '', 'andrsak85@gmail.com', 1584359030, 'admin@example.com', 1588836965),
(3, 'univ', 3, 6, 12, 'Lorem ipsum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '', 'andrsak85@gmail.com', 1588833231, '', 0),
(4, 'univ', 4, 6, 6, 'Lorem ipsum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '', 'andrsak85@gmail.com', 1588833280, '', 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `sections_details`
--

CREATE TABLE `sections_details` (
  `id` int(11) NOT NULL,
  `sections_id` int(11) NOT NULL,
  `detail_title` varchar(255) NOT NULL,
  `detail_content` text NOT NULL,
  `detail_image` varchar(255) NOT NULL,
  `creator` varchar(100) NOT NULL,
  `created_at` int(11) NOT NULL,
  `editor` varchar(100) NOT NULL,
  `edited_at` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='souvisejici obory s organizaci';

--
-- Vypisuji data pro tabulku `sections_details`
--

INSERT INTO `sections_details` (`id`, `sections_id`, `detail_title`, `detail_content`, `detail_image`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, 1, 'Responsivní design', '', '/sections/1/image_detail_1.jpg', 'andrsak85@gmail.com', 1585655701, 'andrsak85@gmail.com', 1588832960),
(2, 2, 'Lorem ipsum', '<p style=\"text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '/sections/2/image_detail_2.jpg', 'andrsak85@gmail.com', 1584433550, 'andrsak85@gmail.com', 1588833332),
(3, 1, 'Intuitivní ovládání', '', '/sections/1/image_detail_3.jpg', 'andrsak85@gmail.com', 1584539454, 'andrsak85@gmail.com', 1588832988),
(11, 1, 'Univerzální využití', '', '/sections/1/image_detail_11.jpg', 'andrsak85@gmail.com', 1584539515, 'andrsak85@gmail.com', 1588833029),
(12, 2, 'Lorem ipsum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>', '/sections/2/image_detail_12.jpg', 'andrsak85@gmail.com', 1584614272, 'andrsak85@gmail.com', 1588833353);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(5) NOT NULL COMMENT 'user ID',
  `firstname` varchar(50) NOT NULL COMMENT 'firstname',
  `lastname` varchar(50) NOT NULL COMMENT 'lastname',
  `password` text NOT NULL COMMENT 'user password',
  `email` varchar(100) NOT NULL COMMENT 'e-mail',
  `street` varchar(100) NOT NULL COMMENT 'street address',
  `city` varchar(100) NOT NULL COMMENT 'city address',
  `postal` varchar(10) NOT NULL COMMENT 'zip/postal code',
  `gsm` varchar(20) NOT NULL COMMENT 'telephone, GSM',
  `notice` text NOT NULL COMMENT 'notice',
  `role` varchar(50) NOT NULL COMMENT 'user role',
  `active` varchar(5) NOT NULL COMMENT 'active user (true/false)',
  `token` varchar(100) NOT NULL,
  `creator` varchar(100) NOT NULL COMMENT 'creator name',
  `created_at` int(11) NOT NULL COMMENT 'date of create',
  `editor` varchar(100) NOT NULL COMMENT 'editors name',
  `edited_at` int(11) NOT NULL COMMENT 'date of edit'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `password`, `email`, `street`, `city`, `postal`, `gsm`, `notice`, `role`, `active`, `token`, `creator`, `created_at`, `editor`, `edited_at`) VALUES
(1, 'Jméno', 'Příjmení', '$2y$10$9cMBkd.qAyi9xsFQkg9MqOOiY9S0dnmscVOH0Azd10OFyI3zmn63S', 'admin@example.com', 'Ulice 25', 'Město', '123 45', '724 708 808', 'Poznámka', 'Admin', 'ANO', '', '', 0, 'andrsak85@gmail.com', 1588831250);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `articles_gallery`
--
ALTER TABLE `articles_gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`articles_id`),
  ADD KEY `gallery_id` (`gallery_id`) USING BTREE;

--
-- Klíče pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_id` (`articles_id`) USING BTREE;

--
-- Klíče pro tabulku `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `food_alergens`
--
ALTER TABLE `food_alergens`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `food_menu`
--
ALTER TABLE `food_menu`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`),
  ADD KEY `album_id` (`album_id`) USING BTREE;

--
-- Klíče pro tabulku `gallery_album`
--
ALTER TABLE `gallery_album`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `organisation`
--
ALTER TABLE `organisation`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `organisation_clients`
--
ALTER TABLE `organisation_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_id` (`organisation_id`) USING BTREE;

--
-- Klíče pro tabulku `organisation_employees`
--
ALTER TABLE `organisation_employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_id` (`organisation_id`);

--
-- Klíče pro tabulku `organisation_sponsors`
--
ALTER TABLE `organisation_sponsors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `organisation_id` (`organisation_id`) USING BTREE;

--
-- Klíče pro tabulku `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `sections_details`
--
ALTER TABLE `sections_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sections_id` (`sections_id`) USING BTREE;

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `articles_gallery`
--
ALTER TABLE `articles_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `food_alergens`
--
ALTER TABLE `food_alergens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pro tabulku `food_menu`
--
ALTER TABLE `food_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pro tabulku `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pro tabulku `gallery_album`
--
ALTER TABLE `gallery_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `organisation`
--
ALTER TABLE `organisation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `organisation_clients`
--
ALTER TABLE `organisation_clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `organisation_employees`
--
ALTER TABLE `organisation_employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pro tabulku `organisation_sponsors`
--
ALTER TABLE `organisation_sponsors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pro tabulku `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `sections_details`
--
ALTER TABLE `sections_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT COMMENT 'user ID', AUTO_INCREMENT=4;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `articles_gallery`
--
ALTER TABLE `articles_gallery`
  ADD CONSTRAINT `articles_gallery_ibfk_1` FOREIGN KEY (`articles_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `articles_gallery_ibfk_2` FOREIGN KEY (`gallery_id`) REFERENCES `gallery` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`articles_id`) REFERENCES `articles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `gallery_album` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `organisation_clients`
--
ALTER TABLE `organisation_clients`
  ADD CONSTRAINT `organisation_clients_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `organisation_employees`
--
ALTER TABLE `organisation_employees`
  ADD CONSTRAINT `organisation_employees_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `organisation_sponsors`
--
ALTER TABLE `organisation_sponsors`
  ADD CONSTRAINT `organisation_sponsors_ibfk_1` FOREIGN KEY (`organisation_id`) REFERENCES `organisation` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `sections_details`
--
ALTER TABLE `sections_details`
  ADD CONSTRAINT `sections_details_ibfk_1` FOREIGN KEY (`sections_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
