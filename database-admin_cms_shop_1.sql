-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 10, 2015 at 03:21 PM
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
  `site_id` int(10) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `code` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `cat` int(10) unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `description` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `image` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `price` int(10) unsigned NOT NULL,
  `count` int(10) unsigned DEFAULT NULL,
  `visibility` enum('1','0') NOT NULL,
  `stat` enum('1','0') NOT NULL,
  `label` varchar(25) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cat` (`cat`),
  KEY `access` (`access`),
  KEY `site_id` (`site_id`),
  FULLTEXT KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `site_id`, `priority`, `access`, `code`, `cat`, `title`, `description`, `image`, `price`, `count`, `visibility`, `stat`, `label`) VALUES
(12, 1, 12, 0, '488', 12, 'محصول یکم', 'بسی\nب\nسیب\nسیب', 'Product\\1438773754kKdm6.jpg', 50000, 120, '1', '1', 'قیمت'),
(13, 1, 13, 0, '982', 12, 'محصولی جدید', 'بیسبسیبسیبسیبسیب\nیس\nبس', 'Product\\1439115311haFGX.jpg', 9822, 550, '1', '1', 'ویژه'),
(19, 1, 19, 0, '254', 12, 'fsdfds', 'fsdfsd\nfsd\nffsd', 'Product\\1439212233S35MO.jpg', 45646, 20, '1', '1', 'fsdf');

-- --------------------------------------------------------

--
-- Table structure for table `product_cat`
--

CREATE TABLE IF NOT EXISTS `product_cat` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `priority` int(11) NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `parent_id` int(10) unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `type_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `access` (`access`),
  KEY `type_id` (`type_id`),
  KEY `parent_id` (`parent_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `product_cat`
--

INSERT INTO `product_cat` (`id`, `site_id`, `priority`, `access`, `parent_id`, `title`, `type_id`) VALUES
(9, 1, 2, 0, 0, 'دسته سوم', 0),
(12, 1, 1, 0, 0, 'دسته پنجم', 11),
(13, 1, 0, 0, 0, 'دسته پنجم', 0),
(14, 1, 2, 0, 14, 'دسته داخلی 7-1', 0),
(15, 1, 0, 0, 7, 'دسته داخلی 7-2', 0),
(16, 1, 1, 0, 7, 'دسته داخلی 7-1', 0),
(17, 1, 2, 0, 7, 'دسته داخلی 7-2', 0),
(18, 1, 0, 0, 14, 'دسته داخلی 14-1', 0),
(19, 1, 1, 0, 14, 'دسته داخلی 14-2', 0),
(40, 1, 3, 0, 0, 'دسته ویررر', 0),
(44, 1, 44, 0, 12, 'دسته زیر', 0),
(45, 1, 45, 0, 0, 'دیته جدیدد', 10),
(47, 1, 47, 0, 0, 'بسیسیببسی ب', 0),
(48, 1, 48, 0, 0, 'fdasfas', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_description`
--

CREATE TABLE IF NOT EXISTS `product_description` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `product_description`
--

INSERT INTO `product_description` (`id`, `site_id`, `product_id`, `text`) VALUES
(12, 1, 12, '&lt;div&gt;بیسب&lt;/div&gt;&lt;div&gt;یسب&lt;/div&gt;&lt;div&gt;سی&lt;/div&gt;&lt;div&gt;ب&lt;/div&gt;&lt;div&gt;سی&lt;/div&gt;'),
(13, 1, 13, '&lt;div&gt;fdsf&lt;/div&gt;&lt;div&gt;sdققققققققققققققققققق&lt;/div&gt;&lt;div&gt;fsd&lt;/div&gt;&lt;div&gt;fs&lt;/div&gt;&lt;div&gt;f&lt;/div&gt;&lt;div&gt;s&lt;/div&gt;'),
(19, 1, 19, '&lt;div&gt;sdf&lt;/div&gt;&lt;div&gt;sd&lt;/div&gt;&lt;div&gt;fsd&lt;/div&gt;&lt;div&gt;f&lt;/div&gt;&lt;div&gt;sdf&lt;/div&gt;');

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE IF NOT EXISTS `product_image` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `address` varchar(250) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=107 ;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `site_id`, `product_id`, `address`) VALUES
(40, 1, 12, 'Product\\1438773754L5Zpb.jpg'),
(77, 1, 13, 'Product\\1439107753dXOwL.jpg'),
(78, 1, 13, 'Product\\14391153090IeT4.jpg'),
(79, 1, 13, 'Product\\1439028156HhquP.jpg'),
(80, 1, 13, 'Product\\1439107753YQd64.jpg'),
(105, 1, 19, 'Product\\1439212233vua7d.jpg'),
(106, 1, 19, 'Product\\1439212233PI3ii.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE IF NOT EXISTS `product_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `site_id`, `title`) VALUES
(0, 1, 'دسته دوم'),
(10, 1, 'موبایلی'),
(11, 1, 'تلوزیون'),
(14, 1, 'لوازم خانگی'),
(15, 1, 'نمایشگر');

-- --------------------------------------------------------

--
-- Table structure for table `product_type_field`
--

CREATE TABLE IF NOT EXISTS `product_type_field` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `fieldset_id` int(10) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(30) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `structure` varchar(10) NOT NULL,
  `searchable` enum('0','1') NOT NULL DEFAULT '0',
  `options` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `fieldset_id` (`fieldset_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `product_type_field`
--

INSERT INTO `product_type_field` (`id`, `site_id`, `type_id`, `fieldset_id`, `priority`, `title`, `structure`, `searchable`, `options`) VALUES
(20, 1, 10, 4, 20, 'عمر باتری', 'textbox', '1', ''),
(21, 1, 10, 4, 21, 'سیستم عامل', 'selectbox', '0', '["اندروید","Ios"]'),
(24, 1, 11, 2, 28, 'رزولوشن', 'textbox', '1', ''),
(25, 1, 11, 1, 52, 'شفافیت تصویر', 'textbox', '1', ''),
(26, 1, 11, 2, 25, 'کنتراست تصویر', 'textbox', '1', ''),
(27, 1, 11, 1, 24, 'وضوح تصویر', 'textbox', '1', ''),
(28, 1, 11, 1, 27, 'پردازنده', 'textbox', '1', ''),
(52, 1, 11, 11, 50, 'بیسسیبس', 'selectbox', '', '["بیسبسیب","سیب"]'),
(53, 1, 11, 2, 23, 'کیفیت صفحه نمایش', 'selectbox', '', '["full hd","4k"]'),
(54, 1, 14, 12, 54, 'فیلد خاصص', 'textbox', '1', ''),
(55, 1, 15, 13, 55, 'نوع', 'textbox', '1', ''),
(56, 1, 15, 13, 56, 'اندازی', 'selectbox', '', '[17,19,21]'),
(57, 1, 15, 13, 57, 'سازنده', 'selectbox', '1', '["شرکت 1","شرکت 2"]'),
(58, 1, 15, 14, 58, 'سازنده', 'selectbox', '1', '["شرکت 1","شرکت 2"]'),
(59, 1, 11, 11, 59, 'قابلیت پخش موزیک', 'checkbox', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `product_type_fieldset`
--

CREATE TABLE IF NOT EXISTS `product_type_fieldset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `priority` int(10) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type_id` (`type_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `product_type_fieldset`
--

INSERT INTO `product_type_fieldset` (`id`, `site_id`, `type_id`, `priority`, `title`) VALUES
(1, 1, 11, 1, 'دسته عمومیبسیب'),
(2, 1, 11, 2, 'دسته خاص'),
(4, 1, 10, 4, 'ویژگی های نرم افزاریها'),
(11, 1, 11, 11, 'نمایشگر'),
(12, 1, 14, 12, 'دسته عمومی'),
(13, 1, 15, 13, 'اطلاعات کلی'),
(14, 1, 15, 14, 'اطلاعات خاص');

-- --------------------------------------------------------

--
-- Table structure for table `product_type_field_value`
--

CREATE TABLE IF NOT EXISTS `product_type_field_value` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL,
  `product_id` int(10) unsigned NOT NULL,
  `field_id` int(10) unsigned NOT NULL,
  `value` varchar(500) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`,`field_id`),
  KEY `field_id` (`field_id`),
  KEY `site_id` (`site_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=87 ;

--
-- Dumping data for table `product_type_field_value`
--

INSERT INTO `product_type_field_value` (`id`, `site_id`, `product_id`, `field_id`, `value`) VALUES
(29, 1, 12, 27, '16666'),
(30, 1, 12, 28, '6111'),
(31, 1, 12, 25, '1666666'),
(32, 1, 12, 53, '4k'),
(33, 1, 12, 26, '16666'),
(34, 1, 12, 24, '4654'),
(35, 1, 12, 52, 'سیب'),
(36, 1, 13, 27, '18889888'),
(37, 1, 13, 28, 'corei7'),
(38, 1, 13, 25, '902'),
(39, 1, 13, 53, 'full hd'),
(40, 1, 13, 26, '19888222'),
(41, 1, 13, 24, '920222'),
(42, 1, 13, 52, 'بیسبسیب'),
(79, 1, 19, 27, 'fsdf'),
(80, 1, 19, 28, 'fsdfs'),
(81, 1, 19, 25, 'vbnbvn'),
(82, 1, 19, 53, '4k'),
(83, 1, 19, 26, 'jhkj'),
(84, 1, 19, 24, 'k'),
(85, 1, 19, 52, 'بیسبسیب'),
(86, 1, 19, 59, '1');

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
  ADD CONSTRAINT `type` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_description`
--
ALTER TABLE `product_description`
  ADD CONSTRAINT `product_description_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_type_field`
--
ALTER TABLE `product_type_field`
  ADD CONSTRAINT `product_type_field_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_type_field_ibfk_2` FOREIGN KEY (`fieldset_id`) REFERENCES `product_type_fieldset` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_type_fieldset`
--
ALTER TABLE `product_type_fieldset`
  ADD CONSTRAINT `product_type_fieldset_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `product_type` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_type_field_value`
--
ALTER TABLE `product_type_field_value`
  ADD CONSTRAINT `product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_type_field_value_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `product_type_field` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
