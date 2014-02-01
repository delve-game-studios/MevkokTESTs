-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Време на генериране:  1 фев 2014 в 02:51
-- Версия на сървъра: 5.5.34
-- Версия на PHP: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данни: `MevkokTESTs`
--

-- --------------------------------------------------------

--
-- Структура на таблица `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура на таблица `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT 'Undefined',
  `path` varchar(250) NOT NULL DEFAULT '/index.php',
  `active` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`path`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Ссхема на данните от таблица `pages`
--

INSERT INTO `pages` (`id`, `name`, `path`, `active`, `created_at`, `updated_at`) VALUES
(32, 'Expression 2', 'e2', 0, '2014-01-22 19:53:52', '2014-01-22 19:53:52'),
(33, 'Users', 'users', 0, '2014-01-22 20:35:55', '2014-01-22 20:35:55');

-- --------------------------------------------------------

--
-- Структура на таблица `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` varchar(8) NOT NULL DEFAULT 'offline',
  `email` varchar(100) NOT NULL,
  `faction` varchar(100) NOT NULL,
  `rank` int(1) NOT NULL DEFAULT '0',
  `fullname` varchar(100) NOT NULL,
  `age` int(2) NOT NULL DEFAULT '13',
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`,`email`),
  KEY `faction` (`faction`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Ссхема на данните от таблица `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `status`, `email`, `faction`, `rank`, `fullname`, `age`, `country`, `city`, `created_at`, `updated_at`) VALUES
(1, 'mevkok', 'e3dfa13a8c33eafe728f9176b2ecb9a0', 'offline', 'games_citadel@abv.bg', 'ShadowBuilders', 9, 'Milan Vugrinchev', 22, 'Bulgaria', 'Varna', '2014-01-20 19:00:00', '2014-01-20 19:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
