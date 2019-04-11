-- phpMyAdmin SQL Dump
-- version 4.0.5
-- http://www.phpmyadmin.net
--
-- Host:
-- Generation Time: Apr 11, 2019 at 12:10 PM
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
-- Table structure for table `trails`
--

CREATE TABLE IF NOT EXISTS `trails` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `city` varchar(60) NOT NULL,
  `zip` int(5) NOT NULL,
  `crossstreets` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `transit` varchar(250) NOT NULL,
  `lat` varchar(200) NOT NULL,
  `lng` varchar(200) NOT NULL,
  `desc` varchar(1100) NOT NULL,
  `lighting` varchar(150) NOT NULL,
  `difficulty` int(5) NOT NULL,
  `surface` varchar(200) NOT NULL,
  `parking` varchar(200) NOT NULL,
  `facilities` varchar(200) NOT NULL,
  `hours` varchar(200) NOT NULL,
  `loopcount` int(5) NOT NULL,
  `satImgURL` varchar(350) NOT NULL,
  `largeImgURL` varchar(350) NOT NULL,
  `thumbURL` varchar(350) NOT NULL,
  `attractions` varchar(3500) NOT NULL,
  `loops` varchar(3500) NOT NULL,
  `published` varchar(100) NOT NULL,
  `rating` float NOT NULL DEFAULT '3',
  `ratings` int(6) NOT NULL DEFAULT '1',
  `favorites` int(8) NOT NULL,
  `ModifiedTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `reviews` int(9) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=73 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
