-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 31, 2015 at 10:47 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `admin_cms_shop 1`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` int(10) unsigned NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `cat` int(10) unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `visibility` enum('1','0') NOT NULL,
  `stat` enum('1','0') NOT NULL,
  `label` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat` (`cat`),
  KEY `access` (`access`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `priority`, `access`, `cat`, `title`, `price`, `visibility`, `stat`, `label`) VALUES
(1, 0, 0, 7, 'product_1', 500, '1', '1', ''),
(2, 0, 0, 7, 'product_2', 500, '1', '1', ''),
(3, 0, 0, 7, 'product_3', 500, '1', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_cat`
--

CREATE TABLE IF NOT EXISTS `product_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `priority` int(11) NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `access` (`access`),
  KEY `type_id` (`type_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `product_cat`
--

INSERT INTO `product_cat` (`id`, `priority`, `access`, `parent_id`, `title`, `type_id`) VALUES
(7, 1, 0, 0, 'cat1', 0),
(8, 2, 0, 0, 'cat2', 2),
(9, 3, 0, 0, 'دسته سوم', 0),
(10, 4, 0, 0, 'دسته چهارم', 0),
(11, 5, 0, 0, 'دسته چهارم', 0),
(12, 6, 0, 0, 'دسته پنجم', 0),
(13, 0, 0, 0, 'دسته پنجم', 0),
(14, 0, 0, 7, 'دسته داخلی 7-1', 0),
(15, 0, 0, 7, 'دسته داخلی 7-2', 0),
(16, 0, 0, 7, 'دسته داخلی 7-1', 0),
(17, 0, 0, 7, 'دسته داخلی 7-2', 0),
(18, 0, 0, 14, 'دسته داخلی 14-1', 0),
(19, 0, 0, 14, 'دسته داخلی 14-2', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE IF NOT EXISTS `product_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(50) NOT NULL,
  `create_date` int(10) unsigned NOT NULL,
  `update_date` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `title`, `create_date`, `update_date`) VALUES
(0, 'type_0_dont_delete_it', 0, 0),
(2, 'type_1', 1424596920, 1424596920);

-- --------------------------------------------------------

--
-- Table structure for table `product_type_field`
--

CREATE TABLE IF NOT EXISTS `product_type_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type_id` int(10) unsigned NOT NULL,
  `title` varchar(30) NOT NULL,
  `structure` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `product_type_field`
--

INSERT INTO `product_type_field` (`id`, `type_id`, `title`, `structure`) VALUES
(1, 2, 'field_1', 'text'),
(2, 2, 'field_2', 'text'),
(3, 2, 'field_3', 'text');

-- --------------------------------------------------------

--
-- Table structure for table `product_type_field_value`
--

CREATE TABLE IF NOT EXISTS `product_type_field_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `value` varchar(500) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`field_id`),
  KEY `field_id` (`field_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `product_type_field_value`
--

INSERT INTO `product_type_field_value` (`id`, `product_id`, `field_id`, `value`) VALUES
(1, 1, 1, 'field_val_1'),
(2, 1, 2, 'field_val_2'),
(3, 2, 1, 'field_val_1'),
(4, 2, 2, 'field_val_2'),
(5, 3, 2, 'field_val_2'),
(6, 1, 3, '3333'),
(7, 2, 3, '4444');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `cat` FOREIGN KEY (`cat`) REFERENCES `product_cat` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_cat`
--
ALTER TABLE `product_cat`
  ADD CONSTRAINT `type` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id`);

--
-- Constraints for table `product_type_field`
--
ALTER TABLE `product_type_field`
  ADD CONSTRAINT `product_type_field_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_type_field_value`
--
ALTER TABLE `product_type_field_value`
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_type_field_value_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `product_type_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
