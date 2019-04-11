-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host: 
-- Generation Time: Apr 11, 2019 at 12:11 PM
-- Server version: 5.5.53-MariaDB
-- PHP Version: 5.4.45-pl0-gentoo

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `prescripttrails`
--

-- --------------------------------------------------------

--
-- Table structure for table `translations`
--

CREATE TABLE IF NOT EXISTS `translations` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `trail_id` int(6) NOT NULL,
  `desc` varchar(1100) NOT NULL,
  `lighting` varchar(150) NOT NULL,
  `surface` varchar(200) NOT NULL,
  `parking` varchar(200) NOT NULL,
  `facilities` varchar(200) NOT NULL,
  `hours` varchar(200) NOT NULL,
  `attractions` varchar(4000) NOT NULL,
  `loops` varchar(4000) NOT NULL,
  `lang` varchar(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
