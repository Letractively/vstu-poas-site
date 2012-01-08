-- phpMyAdmin SQL Dump
-- version 3.5.0-dev
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 08, 2011 at 07:44 PM
-- Server version: 5.1.40-community
-- PHP Version: 5.3.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `poas`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE IF NOT EXISTS `courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `year` int(10) unsigned NOT NULL,
  `course` set('1','2','3','4','5','6','pg1','pg2','pg3','pg4','d1','d2','d3') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `directions`
--

CREATE TABLE IF NOT EXISTS `directions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(300) NOT NULL,
  `name_en` varchar(300) DEFAULT NULL,
  `full_ru` text,
  `full_en` text,
  `image` int(10) unsigned DEFAULT NULL,
  `short_ru` text NOT NULL,
  `short_en` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `direction_members`
--

CREATE TABLE IF NOT EXISTS `direction_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `directionid` int(10) unsigned NOT NULL,
  `ishead` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(150) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'student', 'Student'),
(3, 'lecturer', 'Lecturers');

-- --------------------------------------------------------

--
-- Table structure for table `interests`
--

CREATE TABLE IF NOT EXISTS `interests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `short` varchar(10) NOT NULL,
  `full` varchar(100) NOT NULL,
  `userid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `url` varchar(25) NOT NULL,
  `name_ru` varchar(50) DEFAULT NULL,
  `name_en` varchar(50) DEFAULT NULL,
  `notice_ru` varchar(400) DEFAULT NULL,
  `notice_en` varchar(400) DEFAULT NULL,
  `text_ru` text NOT NULL,
  `text_en` text NOT NULL,
  `time` datetime NOT NULL,
  `update` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE IF NOT EXISTS `partners` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(300) NOT NULL,
  `name_en` varchar(300) DEFAULT NULL,
  `short_ru` text NOT NULL,
  `short_en` text,
  `full_ru` text NOT NULL,
  `full_en` text,
  `url` varchar(300) DEFAULT NULL,
  `image` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE IF NOT EXISTS `projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(150) NOT NULL,
  `name_en` varchar(150) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `image` int(10) unsigned DEFAULT NULL,
  `full_ru` text NOT NULL,
  `full_en` text,
  `short_ru` text NOT NULL,
  `short_en` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `project_members`
--

CREATE TABLE IF NOT EXISTS `project_members` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `projectid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE IF NOT EXISTS `publications` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_ru` varchar(300) NOT NULL,
  `name_en` varchar(300) DEFAULT NULL,
  `info_ru` varchar(300) DEFAULT NULL,
  `info_en` varchar(300) DEFAULT NULL,
  `fulltext_ru` varchar(300) DEFAULT NULL COMMENT 'Link to the document or NULL',
  `fulltext_en` varchar(300) DEFAULT NULL COMMENT 'Link to the document or NULL',
  `abstract_ru` varchar(300) DEFAULT NULL COMMENT 'Link to the document or NULL',
  `abstract_en` varchar(300) DEFAULT NULL COMMENT 'Link to the document or NULL',
  `year` int(10) unsigned NOT NULL,
  `fulltext_ru_file` int(11) DEFAULT NULL,
  `fulltext_en_file` int(11) DEFAULT NULL,
  `abstract_ru_file` int(11) DEFAULT NULL,
  `abstract_en_file` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `publication_authors`
--

CREATE TABLE IF NOT EXISTS `publication_authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `publicationid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(25) NOT NULL,
  `password` varchar(40) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `name_ru` varchar(30) NOT NULL,
  `surname_ru` varchar(30) NOT NULL,
  `patronymic_ru` varchar(30) NOT NULL,
  `photo` int(10) unsigned DEFAULT NULL,
  `name_en` varchar(30) NOT NULL,
  `surname_en` varchar(30) CHARACTER SET utf8 COLLATE utf8_danish_ci NOT NULL,
  `patronymic_en` varchar(30) NOT NULL,
  `address_ru` varchar(300) DEFAULT NULL,
  `cv_ru` text,
  `cv_en` text,
  `cabinet` varchar(10) DEFAULT NULL,
  `skype` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `rank_ru` varchar(100) DEFAULT NULL,
  `post_ru` varchar(100) DEFAULT NULL,
  `info_ru` text,
  `info_en` text,
  `rank_en` varchar(100) DEFAULT NULL,
  `post_en` varchar(100) DEFAULT NULL,
  `address_en` varchar(300) DEFAULT NULL,
  `teaching_ru` text,
  `teaching_en` text,
  `ip_address` int(10) unsigned NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `name_ru`, `surname_ru`, `patronymic_ru`, `photo`, `name_en`, `surname_en`, `patronymic_en`, `address_ru`, `cv_ru`, `cv_en`, `cabinet`, `skype`, `phone`, `url`, `rank_ru`, `post_ru`, `info_ru`, `info_en`, `rank_en`, `post_en`, `address_en`, `teaching_ru`, `teaching_en`, `ip_address`, `salt`, `created_on`, `last_login`, `active`, `activation_code`, `forgotten_password_code`, `remember_code`) VALUES
(1, 'admin', '5d0513311c47ced7975ab50810046f1a3b61a84a', NULL, 'Администратор', 'Сайта', 'I', NULL, 'Administrator', 'Site', 'I', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 0, 1323354646, 1, NULL, NULL, '800d9d46d32086f16e8b8899911691976a1ef76f');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(24, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE IF NOT EXISTS `user_courses` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `courseid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
