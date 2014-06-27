-- phpMyAdmin SQL Dump
-- version 4.1.6
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 27, 2014 at 09:51 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `musichive`
--

-- --------------------------------------------------------

--
-- Table structure for table `playlists`
--

CREATE TABLE IF NOT EXISTS `playlists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `playlists`
--

INSERT INTO `playlists` (`id`, `name`, `user_id`) VALUES
(1, 'SSSS', '10152135941790163'),
(2, 'hiiii', '10152135941790163'),
(3, 'asda', '10152135941790163'),
(4, 'asda', '10152135941790163'),
(5, 'Salah Yahya', '10152135941790163'),
(6, 'asda', '10152135941790163'),
(7, '', '10152135941790163'),
(8, 'asdsa', '10152135941790163');

-- --------------------------------------------------------

--
-- Table structure for table `user_playlist`
--

CREATE TABLE IF NOT EXISTS `user_playlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `playlist_id` int(11) NOT NULL,
  `friend_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=11 ;

--
-- Dumping data for table `user_playlist`
--

INSERT INTO `user_playlist` (`id`, `user_id`, `playlist_id`, `friend_id`) VALUES
(1, '10152135941790163', 1, '1'),
(2, '10152135941790163', 1, '2'),
(3, '10152135941790163', 1, '34'),
(4, '10152135941790163', 2, '10154268085775048'),
(5, '10152135941790163', 3, '10154268085775048'),
(6, '10152135941790163', 4, '10154268085775048'),
(7, '10152135941790163', 5, '10154268085775048'),
(8, '10152135941790163', 6, '10154268085775048'),
(9, '10152135941790163', 7, ''),
(10, '10152135941790163', 8, '10154268085775048');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
