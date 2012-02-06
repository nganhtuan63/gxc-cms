-- phpMyAdmin SQL Dump
-- version 3.2.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 22, 2011 at 05:09 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `hmn`
--

-- --------------------------------------------------------

--
-- Table structure for table `gxc_auth_assignment`
--

CREATE TABLE `gxc_auth_assignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_auth_assignment`
--

INSERT INTO `gxc_auth_assignment` VALUES('Admin', '1', NULL, 'N;');
INSERT INTO `gxc_auth_assignment` VALUES('Reporter', '2', NULL, 'N;');
INSERT INTO `gxc_auth_assignment` VALUES('Admin', '7', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_auth_item`
--

CREATE TABLE `gxc_auth_item` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_auth_item`
--

INSERT INTO `gxc_auth_item` VALUES('Guest', 2, 'Guest', 'return Yii::app()->user->isGuest;', 'N;');
INSERT INTO `gxc_auth_item` VALUES('Authenticated', 2, 'Authenticated', 'return !Yii::app()->user->isGuest;', 'N;');
INSERT INTO `gxc_auth_item` VALUES('Admin', 2, NULL, NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Reporter', 2, 'Reporter', NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Besite.*', 1, NULL, NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Besite.Index', 0, NULL, NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Besite.Error', 0, NULL, NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Besite.Login', 0, NULL, NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Besite.Logout', 0, NULL, NULL, 'N;');
INSERT INTO `gxc_auth_item` VALUES('Editor', 2, 'Editor', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_auth_item_child`
--

CREATE TABLE `gxc_auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_auth_item_child`
--

INSERT INTO `gxc_auth_item_child` VALUES('Authenticated', 'Besite.Error');
INSERT INTO `gxc_auth_item_child` VALUES('Authenticated', 'Besite.Login');
INSERT INTO `gxc_auth_item_child` VALUES('Authenticated', 'Besite.Logout');
INSERT INTO `gxc_auth_item_child` VALUES('Guest', 'Besite.Error');
INSERT INTO `gxc_auth_item_child` VALUES('Guest', 'Besite.Login');
INSERT INTO `gxc_auth_item_child` VALUES('Guest', 'Besite.Logout');
INSERT INTO `gxc_auth_item_child` VALUES('Reporter', 'Besite.Error');
INSERT INTO `gxc_auth_item_child` VALUES('Reporter', 'Besite.Index');
INSERT INTO `gxc_auth_item_child` VALUES('Reporter', 'Besite.Login');
INSERT INTO `gxc_auth_item_child` VALUES('Reporter', 'Besite.Logout');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_autologin_tokens`
--

CREATE TABLE `gxc_autologin_tokens` (
  `user_id` bigint(20) NOT NULL,
  `token` char(40) NOT NULL,
  PRIMARY KEY (`user_id`,`token`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gxc_autologin_tokens`
--

INSERT INTO `gxc_autologin_tokens` VALUES(1, 'fa0bb00d122c62e9542782ca19e2ae88d86ca986');
INSERT INTO `gxc_autologin_tokens` VALUES(2, 'aac3ddaa05a90bcb3f5388007b19ba8030580f89');
INSERT INTO `gxc_autologin_tokens` VALUES(6, 'bcc004ff53b3f34ca77cb03aeff11be335e878ee');
INSERT INTO `gxc_autologin_tokens` VALUES(8, '37c9b55303a1a2b187d5f797d7f8d31852829f76');
INSERT INTO `gxc_autologin_tokens` VALUES(14, '2b66fc152ce5cd593a036d872a55b2d7d9fd7046');
INSERT INTO `gxc_autologin_tokens` VALUES(15, 'efc2be922891608fb55c2803432d003d2ac651a6');
INSERT INTO `gxc_autologin_tokens` VALUES(16, '298e220a3ed5f9c3b9481d7f5a5b114e1093c606');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_block`
--

CREATE TABLE `gxc_block` (
  `block_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '',
  `created` int(11) DEFAULT '0',
  `creator` bigint(20) NOT NULL,
  `updated` int(11) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`block_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `gxc_block`
--

INSERT INTO `gxc_block` VALUES(10, 'Site Top Link ', 'toplink', 1317829306, 1, 1317829306, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(11, 'Top Menu', 'menu', 1317919115, 1, 1317919115, 'a:1:{s:7:"menu_id";s:1:"3";}');
INSERT INTO `gxc_block` VALUES(9, 'Site Search Header', 'search', 1317828912, 1, 1317828912, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(12, 'Filter Block', 'filter', 1318063632, 1, 1318063632, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(13, 'Content Block', 'content', 1318063642, 1, 1318063642, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(14, 'Filter Block', 'filter', 1318134334, 1, 1318134334, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(15, 'Content Block', 'content', 1318134343, 1, 1318134343, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(16, 'Filter Block', 'filter', 1318218992, 1, 1318218992, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(17, 'Content Block', 'content', 1318250989, 1, 1318250989, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(22, 'About HTML', 'html', 1321631963, 1, 1321634393, 'a:1:{s:4:"html";s:1568:"<div class="website-info">\r\n<h1>About us</h1>\r\n<p>\r\n	&nbsp;</p>\r\n<div>\r\n	<div>\r\n		What is OnSaleGrab.com?</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		OnSaleGrab.com is a place where you can find fashion sale items which update daily.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Everyday, our search engine will look for sale items from different store/brands online. Once an item found and is still valid, it will be listed on OnSaleGrab.com.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		When you click on an item, you will be lead to the root site where you can buy or add it to wishlist.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Besides, you can save your search filter and get alerts when having new items that fit your search.</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		In general, Onsalegrab.com was made to help you save time and money.&nbsp;</div>\r\n	<div>\r\n		How OnSaleGrab.com was born ?</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Our ladies ( moms, aunts, sisters, girlfriends,...) have a common hobby : &ldquo;Spending time online to buy sale stuff&rdquo;, and that&rsquo;s why we make this app to help them make it easier and</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		How you can help ?</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		It will be great if you can share with us your fav online stores/brand, f</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Meet the Team</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Tuan Nguyen</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Tri &nbsp;Nguyen</div>\r\n	<div>\r\n		&nbsp;</div>\r\n	<div>\r\n		Connect with us</div>\r\n</div>\r\n\r\n</div>";}');
INSERT INTO `gxc_block` VALUES(20, 'Show hide Filter Bar', 'filter', 1318253221, 1, 1318253221, 'a:1:{s:11:"filter_type";s:8:"showhide";}');
INSERT INTO `gxc_block` VALUES(21, 'Content Block', 'content', 1318254054, 1, 1318254054, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(23, 'Sign up Block', 'html', 1321674626, 1, 1321675413, 'a:1:{s:4:"html";s:106:"<div class="website-info" style="width:500px; margin:0 auto">\r\n<h1>Sign up for OnSaleGrab.com</h1>\r\n</div>";}');
INSERT INTO `gxc_block` VALUES(24, 'Sign up Block', 'signup', 1321675428, 1, 1321675428, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(25, 'Info Menu', 'html', 1321773691, 1, 1321773691, 'a:1:{s:4:"html";s:326:"<ul id="nav-info">\r\n  <li class="active"><a href="/about" id="about_link">About us</a></li>\r\n  <li><a href="/about/resources" id="term_link">Terms and Conditions</a></li>\r\n  <li><a href="/about/opensource" id="privacy_link">Privacy Policy</a></li>\r\n  <li><a href="/about/employees" id="contact_link">Contact us</a></li>\r\n</ul>";}');
INSERT INTO `gxc_block` VALUES(26, 'About Content', 'html', 1321773915, 1, 1322713072, 'a:1:{s:4:"html";s:1190:" <div class="website-info">\r\n        <h1>About us</h1>\r\n    </div>\r\n\r\n<h2 class="infoTitle">What is OnSaleGrab.com?</h2>\r\n\r\n<p>OnSaleGrab.com is a place where you can find sale items of designer clothing and fashion. Our site gets updated daily so you will be the first one to know the best deals.</p>\r\n\r\n<p>Every day, our search engine will look for sale items from different store/brands online. Once a deal is found and still valid, it will be listed on OnSaleGrab.com.</p>\r\n\r\n<p>OnSaleGrab.com is built to make your online bargain hunting simple and stress-free. Enjoy your shopping and love your money-saving!</p>\r\n\r\n<h2 class="infoTitle">How was OnSaleGrab.com born?</h2>\r\n\r\n<p>Our ladies ( moms, aunts, sisters, girlfriends,...) have a common  hobby : “Spending time online to buy sale stuff”. And that’s why we make this app to help their online shopping experience easy and enjoyable. </p>\r\n\r\n<p>It will be great if you can share with us your favorite online stores/brands. And our search engine will work it best to bring you the best deals of your most-wanted designer fashion.</p>\r\n\r\n\r\n<h2 class="infoTitle">Meet the Team</h2>\r\n\r\n<p>Tuan Nguyen</p>\r\n\r\n<p>Tri  Nguyen</p>\r\n";}');
INSERT INTO `gxc_block` VALUES(27, 'User Menu Block', 'usermenu', 1321931746, 1, 1321931746, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(28, 'Dashboard user Block', 'dashboard', 1321948158, 1, 1321948158, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(29, 'Dashboard user Block', 'dashboard', 1321948181, 1, 1321948181, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(30, 'Sign in Block', 'signin', 1322034317, 1, 1322034317, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(31, 'User Profile Block', 'profile', 1322147526, 1, 1322147526, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(32, 'Avatar Block', 'avatar', 1322538232, 1, 1322538232, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(33, 'Remove Avatar Block', 'reset_avatar', 1322622835, 14, 1322622835, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(34, 'Active User Block', 'active_user', 1322624593, 1, 1322624593, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(35, 'Account Block', 'account', 1322636701, 1, 1322636701, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(36, 'Recover Password Block', 'recover_password', 1322816750, 1, 1322816750, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(37, 'Reset Password Block', 'reset_password', 1323096052, 1, 1323096052, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(38, 'Item Iframe Block', 'iframe', 1323266455, 1, 1323266455, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(39, 'Item Header Block', 'html', 1323266475, 1, 1323266475, 'a:1:{s:4:"html";s:7:"<p></p>";}');
INSERT INTO `gxc_block` VALUES(40, 'Header for Item Block', 'header_item', 1323267704, 1, 1323267704, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(41, 'Ajax Block', 'ajax', 1323847686, 1, 1323847686, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(42, 'Active User Block', 'active_user', 1324370202, 1, 1324370202, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(43, 'Page Info Block', 'page_info', 1324370388, 1, 1324370388, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(44, 'Top Users Block', 'top_users', 1324370403, 1, 1324370403, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(45, 'Intro Site Block', 'intro_site', 1324371274, 1, 1324371274, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(46, 'Social Connect Block', 'social_connect', 1324371292, 1, 1324371292, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(47, 'Sign in Block', 'signin', 1324373581, 1, 1324373581, 'a:0:{}');
INSERT INTO `gxc_block` VALUES(48, 'Share Lesson Block', 'share_lesson', 1324545848, 1, 1324545848, 'a:0:{}');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_content_list`
--

CREATE TABLE `gxc_content_list` (
  `content_list_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `created` int(11) NOT NULL,
  PRIMARY KEY (`content_list_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `gxc_content_list`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_hmn_object_lesson`
--

CREATE TABLE `gxc_hmn_object_lesson` (
  `object_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_author` bigint(20) unsigned DEFAULT '0',
  `object_date` int(11) NOT NULL DEFAULT '0',
  `object_date_gmt` int(11) NOT NULL DEFAULT '0',
  `object_content` longtext,
  `object_title` text,
  `object_excerpt` text,
  `object_status` tinyint(4) NOT NULL DEFAULT '1',
  `comment_status` tinyint(4) NOT NULL DEFAULT '1',
  `object_password` varchar(20) DEFAULT NULL,
  `object_name` varchar(255) NOT NULL DEFAULT '',
  `object_modified` int(11) NOT NULL DEFAULT '0',
  `object_modified_gmt` int(11) NOT NULL DEFAULT '0',
  `object_content_filtered` text,
  `object_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `object_type` varchar(20) NOT NULL DEFAULT 'object',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  `object_slug` varchar(255) DEFAULT NULL,
  `object_description` text,
  `object_keywords` text,
  `lang` tinyint(4) DEFAULT '1',
  `object_author_name` varchar(255) DEFAULT NULL,
  `total_number_meta` tinyint(3) NOT NULL,
  `total_number_resource` tinyint(3) NOT NULL,
  `tags` text,
  `object_view` int(11) NOT NULL DEFAULT '0',
  `like` int(11) NOT NULL DEFAULT '0',
  `dislike` int(11) NOT NULL DEFAULT '0',
  `rating_scores` int(11) NOT NULL DEFAULT '0',
  `rating_average` float NOT NULL DEFAULT '0',
  `layout` varchar(125) DEFAULT NULL,
  `obj_image` text NOT NULL,
  `format` varchar(50) NOT NULL DEFAULT 'writing',
  `obj_data` longtext NOT NULL,
  PRIMARY KEY (`object_id`),
  KEY `object_name` (`object_name`),
  KEY `type_status_date` (`object_type`,`object_status`,`object_date`,`object_id`),
  KEY `object_parent` (`object_parent`),
  KEY `object_author` (`object_author`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gxc_hmn_object_lesson`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_language`
--

CREATE TABLE `gxc_language` (
  `lang_id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `lang_name` varchar(255) DEFAULT '',
  `lang_desc` varchar(255) DEFAULT '',
  `lang_required` tinyint(1) DEFAULT '0',
  `lang_active` tinyint(1) DEFAULT '0',
  `lang_short` varchar(10) NOT NULL,
  PRIMARY KEY (`lang_id`),
  KEY `lang_desc` (`lang_desc`),
  KEY `lang_name` (`lang_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `gxc_language`
--

INSERT INTO `gxc_language` VALUES(1, 'vi_vn', 'Vietnamese', 0, 1, 'vi');
INSERT INTO `gxc_language` VALUES(2, 'en_us', 'English', 0, 1, 'en');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_menu`
--

CREATE TABLE `gxc_menu` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(255) NOT NULL,
  `menu_description` varchar(255) NOT NULL,
  `lang` tinyint(4) DEFAULT NULL,
  `guid` varchar(255) NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gxc_menu`
--

INSERT INTO `gxc_menu` VALUES(3, 'Top Menu', 'Top Menu', 2, '4e8c8044a3598');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_menu_item`
--

CREATE TABLE `gxc_menu_item` (
  `menu_item_id` int(10) NOT NULL AUTO_INCREMENT,
  `menu_id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  `type` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `parent` int(10) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL,
  PRIMARY KEY (`menu_item_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `gxc_menu_item`
--

INSERT INTO `gxc_menu_item` VALUES(8, 3, 'Women', 'Dress, Skirts, Camisoles,...', '2', '1', 0, 0);
INSERT INTO `gxc_menu_item` VALUES(9, 3, 'Men', 'Jeans, Shorts, Wallets,...', '2', '70', 0, 1);
INSERT INTO `gxc_menu_item` VALUES(10, 3, 'Kids', 'New born, infant, girls, boys,...', '2', '136', 0, 2);
INSERT INTO `gxc_menu_item` VALUES(11, 3, 'Shoes', 'Boots, Sandals, Pumps, Heels,...', '2', '207', 0, 3);
INSERT INTO `gxc_menu_item` VALUES(12, 3, 'Beauty', 'Makeup, Bath & Spa, Skincare', '2', '248', 0, 4);
INSERT INTO `gxc_menu_item` VALUES(13, 3, 'Bags', 'Handbags, Luggage, Totes, Satchel,...', '2', '316', 0, 5);
INSERT INTO `gxc_menu_item` VALUES(24, 3, 'Accessories', 'Sunglasses, Watches, Wallets,...', '2', '353', 0, 6);
INSERT INTO `gxc_menu_item` VALUES(15, 3, 'Tops', '', '2', '2', 8, 0);
INSERT INTO `gxc_menu_item` VALUES(16, 3, 'Pants & Shorts', '', '2', '11', 8, 1);
INSERT INTO `gxc_menu_item` VALUES(17, 3, 'Dresses', '', '2', '18', 8, 2);
INSERT INTO `gxc_menu_item` VALUES(18, 3, 'Jeans', '', '2', '24', 8, 3);
INSERT INTO `gxc_menu_item` VALUES(19, 3, 'Skirts', '', '2', '35', 8, 4);
INSERT INTO `gxc_menu_item` VALUES(20, 3, 'T-shirts', '', '2', '3', 15, 0);
INSERT INTO `gxc_menu_item` VALUES(21, 3, 'Tops', '', '2', '71', 9, 0);
INSERT INTO `gxc_menu_item` VALUES(22, 3, 'Pants & Shorts', '', '2', '80', 9, 1);
INSERT INTO `gxc_menu_item` VALUES(23, 3, 'T-shirts', '', '2', '72', 21, 0);
INSERT INTO `gxc_menu_item` VALUES(25, 3, 'All Accessorires', 'All Accessorires', '3', '#', 24, 0);
INSERT INTO `gxc_menu_item` VALUES(89, 3, 'Fragrances', 'Fragrances', '3', '#', 25, 1);
INSERT INTO `gxc_menu_item` VALUES(44, 3, 'Laptop Bags', 'Laptop Bags', '3', '#', 40, 3);
INSERT INTO `gxc_menu_item` VALUES(43, 3, 'Luggage', 'Luggage', '3', '#', 40, 2);
INSERT INTO `gxc_menu_item` VALUES(42, 3, 'Messenger Bags', 'Messenger Bags', '3', '#', 40, 1);
INSERT INTO `gxc_menu_item` VALUES(41, 3, 'Backpacks', 'Backpacks', '3', '#', 40, 0);
INSERT INTO `gxc_menu_item` VALUES(40, 3, 'All Bags', 'All Bags', '3', '#', 13, 0);
INSERT INTO `gxc_menu_item` VALUES(45, 3, 'Travel Bags', 'Travel Bags', '3', '#', 40, 4);
INSERT INTO `gxc_menu_item` VALUES(46, 3, 'Duffle Bags', 'Duffle Bags', '3', '#', 40, 5);
INSERT INTO `gxc_menu_item` VALUES(47, 3, 'Diaper Bags', 'Diaper Bags', '3', '#', 40, 6);
INSERT INTO `gxc_menu_item` VALUES(48, 3, 'Briefcases', 'Briefcases', '3', '#', 40, 7);
INSERT INTO `gxc_menu_item` VALUES(49, 3, 'Camisoles', 'Camisoles', '3', '#', 15, 1);
INSERT INTO `gxc_menu_item` VALUES(50, 3, 'Tanks', 'Tanks', '3', '#', 15, 2);
INSERT INTO `gxc_menu_item` VALUES(51, 3, 'Tunics', 'Tunics', '3', '#', 15, 3);
INSERT INTO `gxc_menu_item` VALUES(52, 3, 'Blouse/Shirts', 'Blouse/Shirts', '3', '#', 15, 4);
INSERT INTO `gxc_menu_item` VALUES(53, 3, 'Sweater', 'Sweater', '3', '#', 15, 5);
INSERT INTO `gxc_menu_item` VALUES(54, 3, 'Casual', 'Casual', '3', '#', 16, 0);
INSERT INTO `gxc_menu_item` VALUES(55, 3, 'Capri', 'Capri', '3', '#', 16, 1);
INSERT INTO `gxc_menu_item` VALUES(56, 3, 'Legging', 'Legging', '3', '#', 16, 2);
INSERT INTO `gxc_menu_item` VALUES(57, 3, 'Shorts', 'Shorts', '3', '#', 16, 3);
INSERT INTO `gxc_menu_item` VALUES(58, 3, 'Sleepwear', 'Sleepwear', '3', '#', 8, 5);
INSERT INTO `gxc_menu_item` VALUES(59, 3, 'Sportwears', 'Sportwears', '3', '#', 8, 6);
INSERT INTO `gxc_menu_item` VALUES(60, 3, 'Swimwears', 'Swimwears', '3', '#', 8, 7);
INSERT INTO `gxc_menu_item` VALUES(61, 3, 'Intimates', 'Intimates', '3', '#', 8, 8);
INSERT INTO `gxc_menu_item` VALUES(62, 3, 'Jackets', 'Jackets', '3', '#', 8, 9);
INSERT INTO `gxc_menu_item` VALUES(63, 3, 'Outerwear', 'Outerwear', '3', '#', 8, 10);
INSERT INTO `gxc_menu_item` VALUES(64, 3, 'Knee length', 'Knee length', '3', '#', 17, 0);
INSERT INTO `gxc_menu_item` VALUES(65, 3, 'Short', 'Short', '3', '#', 17, 1);
INSERT INTO `gxc_menu_item` VALUES(66, 3, 'Long', 'Long', '3', '#', 17, 2);
INSERT INTO `gxc_menu_item` VALUES(67, 3, 'Mini', 'Mini', '3', '#', 17, 3);
INSERT INTO `gxc_menu_item` VALUES(68, 3, 'Tea Length', 'Tea Length', '3', '#', 17, 4);
INSERT INTO `gxc_menu_item` VALUES(69, 3, 'Skinny', 'Skinny', '3', '#', 16, 4);
INSERT INTO `gxc_menu_item` VALUES(70, 3, 'Trousers', 'Trousers', '3', '#', 16, 5);
INSERT INTO `gxc_menu_item` VALUES(71, 3, 'Lounge pants', 'Lounge pants', '3', '#', 16, 6);
INSERT INTO `gxc_menu_item` VALUES(72, 3, 'Cargo pants', 'Cargo pants', '3', '#', 16, 7);
INSERT INTO `gxc_menu_item` VALUES(73, 3, 'Sweat pants', 'Sweat pants', '3', '#', 16, 8);
INSERT INTO `gxc_menu_item` VALUES(75, 3, 'Boot cuts', 'Boot cuts', '3', '#', 18, 0);
INSERT INTO `gxc_menu_item` VALUES(76, 3, 'Low rise', 'Low rise', '3', '#', 18, 1);
INSERT INTO `gxc_menu_item` VALUES(77, 3, 'Slim fit', 'Slim fit', '3', '#', 18, 2);
INSERT INTO `gxc_menu_item` VALUES(78, 3, 'Straight leg', 'Straight leg', '3', '#', 18, 3);
INSERT INTO `gxc_menu_item` VALUES(79, 3, 'Skinny fit', 'Skinny fit', '3', '#', 18, 4);
INSERT INTO `gxc_menu_item` VALUES(80, 3, 'Jackets', 'Jackets', '3', '#', 59, 0);
INSERT INTO `gxc_menu_item` VALUES(81, 3, 'Pants', 'Pants', '3', '#', 59, 1);
INSERT INTO `gxc_menu_item` VALUES(82, 3, 'Shorts', 'Shorts', '3', '#', 59, 2);
INSERT INTO `gxc_menu_item` VALUES(83, 3, 'Skirts', 'Skirts', '3', '#', 59, 3);
INSERT INTO `gxc_menu_item` VALUES(84, 3, 'One piece swimsuit', 'One piece swimsuit', '3', '#', 60, 0);
INSERT INTO `gxc_menu_item` VALUES(86, 3, 'Bikini', 'Bikini', '3', '#', 60, 1);
INSERT INTO `gxc_menu_item` VALUES(87, 3, 'Swim sets', 'Swim sets', '3', '#', 60, 2);
INSERT INTO `gxc_menu_item` VALUES(88, 3, 'Wallets', 'Wallets', '3', '#', 25, 0);
INSERT INTO `gxc_menu_item` VALUES(90, 3, 'Grooming', 'Grooming', '3', '#', 25, 2);
INSERT INTO `gxc_menu_item` VALUES(91, 3, 'Hats', 'Hats', '3', '#', 25, 3);
INSERT INTO `gxc_menu_item` VALUES(92, 3, 'Watches', 'Watches', '3', '#', 25, 4);
INSERT INTO `gxc_menu_item` VALUES(93, 3, 'Money clips', 'Money clips', '3', '#', 25, 5);
INSERT INTO `gxc_menu_item` VALUES(94, 3, 'Phone cases', 'Phone cases', '3', '#', 25, 6);

-- --------------------------------------------------------

--
-- Table structure for table `gxc_object`
--

CREATE TABLE `gxc_object` (
  `object_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_author` bigint(20) unsigned DEFAULT '0',
  `object_date` int(11) NOT NULL DEFAULT '0',
  `object_date_gmt` int(11) NOT NULL DEFAULT '0',
  `object_content` longtext,
  `object_title` text,
  `object_excerpt` text,
  `object_status` tinyint(4) NOT NULL DEFAULT '1',
  `comment_status` tinyint(4) NOT NULL DEFAULT '1',
  `object_password` varchar(20) DEFAULT NULL,
  `object_name` varchar(255) NOT NULL DEFAULT '',
  `object_modified` int(11) NOT NULL DEFAULT '0',
  `object_modified_gmt` int(11) NOT NULL DEFAULT '0',
  `object_content_filtered` text,
  `object_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `guid` varchar(255) NOT NULL DEFAULT '',
  `object_type` varchar(20) NOT NULL DEFAULT 'object',
  `comment_count` bigint(20) NOT NULL DEFAULT '0',
  `object_slug` varchar(255) DEFAULT NULL,
  `object_description` text,
  `object_keywords` text,
  `lang` tinyint(4) DEFAULT '1',
  `object_author_name` varchar(255) DEFAULT NULL,
  `total_number_meta` tinyint(3) NOT NULL,
  `total_number_resource` tinyint(3) NOT NULL,
  `tags` text,
  `object_view` int(11) NOT NULL DEFAULT '0',
  `like` int(11) NOT NULL DEFAULT '0',
  `dislike` int(11) NOT NULL DEFAULT '0',
  `rating_scores` int(11) NOT NULL DEFAULT '0',
  `rating_average` float NOT NULL DEFAULT '0',
  `layout` varchar(125) DEFAULT NULL,
  PRIMARY KEY (`object_id`),
  KEY `object_name` (`object_name`),
  KEY `type_status_date` (`object_type`,`object_status`,`object_date`,`object_id`),
  KEY `object_parent` (`object_parent`),
  KEY `object_author` (`object_author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `gxc_object`
--

INSERT INTO `gxc_object` VALUES(1, 1, 0, 0, 'E/W Satchel with Detachable Shoulder Strap', 'E/W Satchel with Detachable Shoulder Strap', 'E/W Satchel with Detachable Shoulder Strap', 1, 1, NULL, 'E/W Satchel with Detachable Shoulder Strap', 1323741201, 1323716001, NULL, 0, '4ee6b011a1b23', 'object', 0, 'ew-satchel-with-detachable-shoulder-strap', 'E/W Satchel with Detachable Shoulder Strap', 'E/W Satchel with Detachable Shoulder Strap', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(2, 1, 0, 0, 'Small Crossbody', 'Small Crossbody', 'Small Crossbody', 1, 1, NULL, 'Small Crossbody', 1323741201, 1323716001, NULL, 0, '4ee6b011c7dac', 'object', 0, 'small-crossbody', 'Small Crossbody', 'Small Crossbody', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(3, 1, 0, 0, 'Clutch with Pocket and Detachable Shoulder Strap', 'Clutch with Pocket and Detachable Shoulder Strap', 'Clutch with Pocket and Detachable Shoulder Strap', 1, 1, NULL, 'Clutch with Pocket and Detachable Shoulder Strap', 1323741201, 1323716001, NULL, 0, '4ee6b011cafcc', 'object', 0, 'clutch-with-pocket-and-detachable-shoulder-strap', 'Clutch with Pocket and Detachable Shoulder Strap', 'Clutch with Pocket and Detachable Shoulder Strap', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(4, 1, 0, 0, 'Flap Clutch with Detachable Chain Handle ', 'Flap Clutch with Detachable Chain Handle ', 'Flap Clutch with Detachable Chain Handle ', 1, 1, NULL, 'Flap Clutch with Detachable Chain Handle ', 1323741201, 1323716001, NULL, 0, '4ee6b011cfbf3', 'object', 0, 'flap-clutch-with-detachable-chain-handle', 'Flap Clutch with Detachable Chain Handle ', 'Flap Clutch with Detachable Chain Handle ', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(5, 1, 0, 0, 'Medium Carryall', 'Medium Carryall', 'Medium Carryall', 1, 1, NULL, 'Medium Carryall', 1323741201, 1323716001, NULL, 0, '4ee6b011d45b7', 'object', 0, 'medium-carryall', 'Medium Carryall', 'Medium Carryall', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(6, 1, 0, 0, 'Nylon City Zip Large Crossbody', 'Nylon City Zip Large Crossbody', 'Nylon City Zip Large Crossbody', 1, 1, NULL, 'Nylon City Zip Large Crossbody', 1323741201, 1323716001, NULL, 0, '4ee6b011d73de', 'object', 0, 'nylon-city-zip-large-crossbody', 'Nylon City Zip Large Crossbody', 'Nylon City Zip Large Crossbody', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(7, 1, 0, 0, 'Urban Fusion Crossbody w/ Detatchable Shoulder Strap', 'Urban Fusion Crossbody w/ Detatchable Shoulder Strap', 'Urban Fusion Crossbody w/ Detatchable Shoulder Strap', 1, 1, NULL, 'Urban Fusion Crossbody w/ Detatchable Shoulder Strap', 1323741201, 1323716001, NULL, 0, '4ee6b011d9eb2', 'object', 0, 'urban-fusion-crossbody-w-detatchable-shoulder-strap', 'Urban Fusion Crossbody w/ Detatchable Shoulder Strap', 'Urban Fusion Crossbody w/ Detatchable Shoulder Strap', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(8, 1, 0, 0, 'Small Printed Crossbody with Webbing', 'Small Printed Crossbody with Webbing', 'Small Printed Crossbody with Webbing', 1, 1, NULL, 'Small Printed Crossbody with Webbing', 1323741201, 1323716001, NULL, 0, '4ee6b011dcb68', 'object', 0, 'small-printed-crossbody-with-webbing', 'Small Printed Crossbody with Webbing', 'Small Printed Crossbody with Webbing', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(9, 1, 0, 0, 'Luster Calf Small Crossbody with Geometric Lock', 'Luster Calf Small Crossbody with Geometric Lock', 'Luster Calf Small Crossbody with Geometric Lock', 1, 1, NULL, 'Luster Calf Small Crossbody with Geometric Lock', 1323741201, 1323716001, NULL, 0, '4ee6b011e0e1a', 'object', 0, 'luster-calf-small-crossbody-with-geometric-lock', 'Luster Calf Small Crossbody with Geometric Lock', 'Luster Calf Small Crossbody with Geometric Lock', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(10, 1, 0, 0, 'Luster Calf Large Ew Tote w/ Geometic Lock and Detatchable Shoulder Strap', 'Luster Calf Large Ew Tote w/ Geometic Lock and Detatchable Shoulder Strap', 'Luster Calf Large Ew Tote w/ Geometic Lock and Detatchable Shoulder Strap', 1, 1, NULL, 'Luster Calf Large Ew Tote w/ Geometic Lock and Detatchable Shoulder Strap', 1323741201, 1323716001, NULL, 0, '4ee6b011e3b4d', 'object', 0, 'luster-calf-large-ew-tote-w-geometic-lock-and-detatchable-shoulder-strap', 'Luster Calf Large Ew Tote w/ Geometic Lock and Detatchable Shoulder Strap', 'Luster Calf Large Ew Tote w/ Geometic Lock and Detatchable Shoulder Strap', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(11, 1, 0, 0, 'Luster Calf Large Zip Wristlette', 'Luster Calf Large Zip Wristlette', 'Luster Calf Large Zip Wristlette', 1, 1, NULL, 'Luster Calf Large Zip Wristlette', 1323741201, 1323716001, NULL, 0, '4ee6b011e6a05', 'object', 0, 'luster-calf-large-zip-wristlette', 'Luster Calf Large Zip Wristlette', 'Luster Calf Large Zip Wristlette', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(12, 1, 0, 0, 'Antique Calf Top Handle Flap w/ Modern Turnlock and Detatchable Shoulder Strap', 'Antique Calf Top Handle Flap w/ Modern Turnlock and Detatchable Shoulder Strap', 'Antique Calf Top Handle Flap w/ Modern Turnlock and Detatchable Shoulder Strap', 1, 1, NULL, 'Antique Calf Top Handle Flap w/ Modern Turnlock and Detatchable Shoulder Strap', 1323741201, 1323716001, NULL, 0, '4ee6b011e958c', 'object', 0, 'antique-calf-top-handle-flap-w-modern-turnlock-and-detatchable-shoulder-strap', 'Antique Calf Top Handle Flap w/ Modern Turnlock and Detatchable Shoulder Strap', 'Antique Calf Top Handle Flap w/ Modern Turnlock and Detatchable Shoulder Strap', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(13, 1, 0, 0, 'Long Sleeve V-Neck Dress With Side Draping', 'Long Sleeve V-Neck Dress With Side Draping', 'Long Sleeve V-Neck Dress With Side Draping', 1, 1, NULL, 'Long Sleeve V-Neck Dress With Side Draping', 1323741202, 1323716002, NULL, 0, '4ee6b0120ab88', 'object', 0, 'long-sleeve-v-neck-dress-with-side-draping', 'Long Sleeve V-Neck Dress With Side Draping', 'Long Sleeve V-Neck Dress With Side Draping', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(14, 1, 0, 0, 'Long Sleeve Crewneck Dress With Side Draping', 'Long Sleeve Crewneck Dress With Side Draping', 'Long Sleeve Crewneck Dress With Side Draping', 1, 1, NULL, 'Long Sleeve Crewneck Dress With Side Draping', 1323741202, 1323716002, NULL, 0, '4ee6b0120e964', 'object', 0, 'long-sleeve-crewneck-dress-with-side-draping', 'Long Sleeve Crewneck Dress With Side Draping', 'Long Sleeve Crewneck Dress With Side Draping', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(15, 1, 0, 0, 'Sleeveless Scarf Cozy Dress', 'Sleeveless Scarf Cozy Dress', 'Sleeveless Scarf Cozy Dress', 1, 1, NULL, 'Sleeveless Scarf Cozy Dress', 1323741202, 1323716002, NULL, 0, '4ee6b01211714', 'object', 0, 'sleeveless-scarf-cozy-dress', 'Sleeveless Scarf Cozy Dress', 'Sleeveless Scarf Cozy Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(16, 1, 0, 0, 'Sleeveless Scarf Cozy Dress', 'Sleeveless Scarf Cozy Dress', 'Sleeveless Scarf Cozy Dress', 1, 1, NULL, 'Sleeveless Scarf Cozy Dress', 1323741202, 1323716002, NULL, 0, '4ee6b01214666', 'object', 0, 'sleeveless-scarf-cozy-dress', 'Sleeveless Scarf Cozy Dress', 'Sleeveless Scarf Cozy Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(17, 1, 0, 0, 'Elbow Sleeve Dress With Cdc Back Yoke And Sleeve', 'Elbow Sleeve Dress With Cdc Back Yoke And Sleeve', 'Elbow Sleeve Dress With Cdc Back Yoke And Sleeve', 1, 1, NULL, 'Elbow Sleeve Dress With Cdc Back Yoke And Sleeve', 1323741202, 1323716002, NULL, 0, '4ee6b01217123', 'object', 0, 'elbow-sleeve-dress-with-cdc-back-yoke-and-sleeve', 'Elbow Sleeve Dress With Cdc Back Yoke And Sleeve', 'Elbow Sleeve Dress With Cdc Back Yoke And Sleeve', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(18, 1, 0, 0, 'Elbow Sleeve Easy Crewneck Dress', 'Elbow Sleeve Easy Crewneck Dress', 'Elbow Sleeve Easy Crewneck Dress', 1, 1, NULL, 'Elbow Sleeve Easy Crewneck Dress', 1323741202, 1323716002, NULL, 0, '4ee6b01219c15', 'object', 0, 'elbow-sleeve-easy-crewneck-dress', 'Elbow Sleeve Easy Crewneck Dress', 'Elbow Sleeve Easy Crewneck Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(19, 1, 0, 0, 'Cold Shoulder Double Layer Dress', 'Cold Shoulder Double Layer Dress', 'Cold Shoulder Double Layer Dress', 1, 1, NULL, 'Cold Shoulder Double Layer Dress', 1323741202, 1323716002, NULL, 0, '4ee6b0121ca18', 'object', 0, 'cold-shoulder-double-layer-dress', 'Cold Shoulder Double Layer Dress', 'Cold Shoulder Double Layer Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(20, 1, 0, 0, 'Sleeveless V-Neck Dress With Ruffle Front', 'Sleeveless V-Neck Dress With Ruffle Front', 'Sleeveless V-Neck Dress With Ruffle Front', 1, 1, NULL, 'Sleeveless V-Neck Dress With Ruffle Front', 1323741202, 1323716002, NULL, 0, '4ee6b0121f401', 'object', 0, 'sleeveless-v-neck-dress-with-ruffle-front', 'Sleeveless V-Neck Dress With Ruffle Front', 'Sleeveless V-Neck Dress With Ruffle Front', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(21, 1, 0, 0, '3-4 Sleeve Scoopneck Dress With Tiered Ruffle Bottom', '3-4 Sleeve Scoopneck Dress With Tiered Ruffle Bottom', '3-4 Sleeve Scoopneck Dress With Tiered Ruffle Bottom', 1, 1, NULL, '3-4 Sleeve Scoopneck Dress With Tiered Ruffle Bottom', 1323741202, 1323716002, NULL, 0, '4ee6b01221fee', 'object', 0, '3-4-sleeve-scoopneck-dress-with-tiered-ruffle-bottom', '3-4 Sleeve Scoopneck Dress With Tiered Ruffle Bottom', '3-4 Sleeve Scoopneck Dress With Tiered Ruffle Bottom', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(22, 1, 0, 0, 'Three Quarter Sleeve V-Neck Dress And Grosgrain Belt', 'Three Quarter Sleeve V-Neck Dress And Grosgrain Belt', 'Three Quarter Sleeve V-Neck Dress And Grosgrain Belt', 1, 1, NULL, 'Three Quarter Sleeve V-Neck Dress And Grosgrain Belt', 1323741202, 1323716002, NULL, 0, '4ee6b0122509e', 'object', 0, 'three-quarter-sleeve-v-neck-dress-and-grosgrain-belt', 'Three Quarter Sleeve V-Neck Dress And Grosgrain Belt', 'Three Quarter Sleeve V-Neck Dress And Grosgrain Belt', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(23, 1, 0, 0, 'Boatneck Full Length Dress', 'Boatneck Full Length Dress', 'Boatneck Full Length Dress', 1, 1, NULL, 'Boatneck Full Length Dress', 1323741202, 1323716002, NULL, 0, '4ee6b01227bf4', 'object', 0, 'boatneck-full-length-dress', 'Boatneck Full Length Dress', 'Boatneck Full Length Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(24, 1, 0, 0, ' Shift Dress With Layered Leather Strips ', ' Shift Dress With Layered Leather Strips ', ' Shift Dress With Layered Leather Strips ', 1, 1, NULL, ' Shift Dress With Layered Leather Strips ', 1323741202, 1323716002, NULL, 0, '4ee6b0122a806', 'object', 0, 'shift-dress-with-layered-leather-strips', ' Shift Dress With Layered Leather Strips ', ' Shift Dress With Layered Leather Strips ', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(25, 1, 0, 0, 'V-Neck Dress With Drop Waist', 'V-Neck Dress With Drop Waist', 'V-Neck Dress With Drop Waist', 1, 1, NULL, 'V-Neck Dress With Drop Waist', 1323741227, 1323716027, NULL, 0, '4ee6b02b7a3a4', 'object', 0, 'v-neck-dress-with-drop-waist', 'V-Neck Dress With Drop Waist', 'V-Neck Dress With Drop Waist', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(26, 1, 0, 0, 'Three Quarter Sleeve V-Neck Wrap Dress', 'Three Quarter Sleeve V-Neck Wrap Dress', 'Three Quarter Sleeve V-Neck Wrap Dress', 1, 1, NULL, 'Three Quarter Sleeve V-Neck Wrap Dress', 1323741227, 1323716027, NULL, 0, '4ee6b02b83d43', 'object', 0, 'three-quarter-sleeve-v-neck-wrap-dress', 'Three Quarter Sleeve V-Neck Wrap Dress', 'Three Quarter Sleeve V-Neck Wrap Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(27, 1, 0, 0, 'Short Sleeve Pleat Shoulder Dress', 'Short Sleeve Pleat Shoulder Dress', 'Short Sleeve Pleat Shoulder Dress', 1, 1, NULL, 'Short Sleeve Pleat Shoulder Dress', 1323741227, 1323716027, NULL, 0, '4ee6b02b88cad', 'object', 0, 'short-sleeve-pleat-shoulder-dress', 'Short Sleeve Pleat Shoulder Dress', 'Short Sleeve Pleat Shoulder Dress', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(28, 1, 0, 0, 'Sleeveless Dress With Exposed Darts', 'Sleeveless Dress With Exposed Darts', 'Sleeveless Dress With Exposed Darts', 1, 1, NULL, 'Sleeveless Dress With Exposed Darts', 1323741227, 1323716027, NULL, 0, '4ee6b02b8d3e3', 'object', 0, 'sleeveless-dress-with-exposed-darts', 'Sleeveless Dress With Exposed Darts', 'Sleeveless Dress With Exposed Darts', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(29, 1, 0, 0, 'Printed Snake Flap Clutch', 'Printed Snake Flap Clutch', 'Printed Snake Flap Clutch', 1, 1, NULL, 'Printed Snake Flap Clutch', 1323741227, 1323716027, NULL, 0, '4ee6b02ba156f', 'object', 0, 'printed-snake-flap-clutch', 'Printed Snake Flap Clutch', 'Printed Snake Flap Clutch', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(30, 1, 0, 0, 'Printed Snake Small Top Handle Briefcase', 'Printed Snake Small Top Handle Briefcase', 'Printed Snake Small Top Handle Briefcase', 1, 1, NULL, 'Printed Snake Small Top Handle Briefcase', 1323741227, 1323716027, NULL, 0, '4ee6b02baa315', 'object', 0, 'printed-snake-small-top-handle-briefcase', 'Printed Snake Small Top Handle Briefcase', 'Printed Snake Small Top Handle Briefcase', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(31, 1, 0, 0, 'Faux Fur Large Hobo', 'Faux Fur Large Hobo', 'Faux Fur Large Hobo', 1, 1, NULL, 'Faux Fur Large Hobo', 1323741227, 1323716027, NULL, 0, '4ee6b02bb0199', 'object', 0, 'faux-fur-large-hobo', 'Faux Fur Large Hobo', 'Faux Fur Large Hobo', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(32, 1, 0, 0, 'T&amp;amp;C Double Pocket Crossbody with Modern Turnlock', 'T&amp;amp;C Double Pocket Crossbody with Modern Turnlock', 'T&amp;amp;C Double Pocket Crossbody with Modern Turnlock', 1, 1, NULL, 'T&amp;amp;C Double Pocket Crossbody with Modern Turnlock', 1323741227, 1323716027, NULL, 0, '4ee6b02bb6f8a', 'object', 0, 'tampampc-double-pocket-crossbody-with-modern-turnlock', 'T&amp;amp;C Double Pocket Crossbody with Modern Turnlock', 'T&amp;amp;C Double Pocket Crossbody with Modern Turnlock', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(33, 1, 0, 0, 'T&amp;amp;C Large Top Zip Crossbody with Modern Turnlock', 'T&amp;amp;C Large Top Zip Crossbody with Modern Turnlock', 'T&amp;amp;C Large Top Zip Crossbody with Modern Turnlock', 1, 1, NULL, 'T&amp;amp;C Large Top Zip Crossbody with Modern Turnlock', 1323741227, 1323716027, NULL, 0, '4ee6b02bbbe8d', 'object', 0, 'tampampc-large-top-zip-crossbody-with-modern-turnlock', 'T&amp;amp;C Large Top Zip Crossbody with Modern Turnlock', 'T&amp;amp;C Large Top Zip Crossbody with Modern Turnlock', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(34, 1, 0, 0, 'Nylon Logo Flat Crossbody', 'Nylon Logo Flat Crossbody', 'Nylon Logo Flat Crossbody', 1, 1, NULL, 'Nylon Logo Flat Crossbody', 1323741227, 1323716027, NULL, 0, '4ee6b02bbf12f', 'object', 0, 'nylon-logo-flat-crossbody', 'Nylon Logo Flat Crossbody', 'Nylon Logo Flat Crossbody', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(35, 1, 0, 0, 'T&amp;amp;C 12&amp;quot; Laptop Case', 'T&amp;amp;C 12&amp;quot; Laptop Case', 'T&amp;amp;C 12&amp;quot; Laptop Case', 1, 1, NULL, 'T&amp;amp;C 12&amp;quot; Laptop Case', 1323741227, 1323716027, NULL, 0, '4ee6b02bc2e25', 'object', 0, 'tampampc-12ampquot-laptop-case', 'T&amp;amp;C 12&amp;quot; Laptop Case', 'T&amp;amp;C 12&amp;quot; Laptop Case', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);
INSERT INTO `gxc_object` VALUES(36, 1, 0, 0, 'Nylon Logo New Medium Cosmetic', 'Nylon Logo New Medium Cosmetic', 'Nylon Logo New Medium Cosmetic', 1, 1, NULL, 'Nylon Logo New Medium Cosmetic', 1323741227, 1323716027, NULL, 0, '4ee6b02bc731d', 'object', 0, 'nylon-logo-new-medium-cosmetic', 'Nylon Logo New Medium Cosmetic', 'Nylon Logo New Medium Cosmetic', 1, 'Bot', 1, 1, '', 0, 0, 0, 0, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `gxc_object_meta`
--

CREATE TABLE `gxc_object_meta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `meta_object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `object_id` (`meta_object_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `gxc_object_meta`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_object_resource`
--

CREATE TABLE `gxc_object_resource` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `resource_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `resource_order` int(11) NOT NULL DEFAULT '0',
  `description` longtext,
  PRIMARY KEY (`object_id`,`resource_id`),
  KEY `resource_id` (`resource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_object_resource`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_object_term`
--

CREATE TABLE `gxc_object_term` (
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`object_id`,`term_id`),
  KEY `term_id` (`term_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_object_term`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_page`
--

CREATE TABLE `gxc_page` (
  `page_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `parent` bigint(20) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `lang` tinyint(4) NOT NULL,
  `guid` varchar(255) NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1',
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `allow_index` tinyint(1) NOT NULL DEFAULT '1',
  `allow_follow` tinyint(1) NOT NULL DEFAULT '1',
  `display_type` varchar(50) NOT NULL DEFAULT 'main',
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `gxc_page`
--

INSERT INTO `gxc_page` VALUES(14, 'home', 'Học mỗi ngày.com ! ', 'Học mỗi ngày.com ! ', 0, 'hmn', 'home', 2, '4e8c1d1a0ec15', 1, 'Học mỗi ngày.com ! ', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(15, 'About us', 'About us', 'About us - OnSaleGrab.com', 14, 'osg', 'about-us', 2, '4ec680ddc6a19', 1, 'About us', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(16, 'Sign up', 'Đăng ký thành viên', 'Đăng ký thành viên', 14, 'hmn', 'sign-up', 2, '4ec7278413735', 1, 'Đăng ký thành viên', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(17, 'Dashboard', 'Dashboard', 'Dashboard', 16, 'hmn', 'dashboard', 2, '4ecb0e345b71c', 1, 'dashboard', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(18, 'Error', 'Error', 'Error', 15, 'osg', 'error', 2, '4ecc979eb8a8d', 1, 'error', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(19, 'Sign in', 'Đăng nhập', 'Đăng nhập', 16, 'hmn', 'sign-in', 2, '4ecca48ff3bff', 1, 'Đăng nhập', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(20, 'Profile', 'Thông tin cá nhân', 'Thông tin cá nhân', 17, 'hmn', 'profile', 2, '4ece5ec86e748', 1, 'Thông tin cá nhân', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(21, 'Avatar', 'Avatar', 'Avatar', 20, 'hmn', 'avatar', 2, '4ed454fa38f12', 1, 'Avatar', 1, 1, 'blank');
INSERT INTO `gxc_page` VALUES(22, 'Remove Avatar', 'Remove Avatar', 'Remove Avatar', 0, 'osg', 'remove-avatar', 2, '4ed59f75659d3', 1, '', 1, 1, 'empty');
INSERT INTO `gxc_page` VALUES(23, 'User activation', 'Kích hoạt tài khoản', 'Kích hoạt tài khoản', 0, 'hmn', 'user-activation', 2, '4ed5a652c6dc5', 1, 'Kích hoạt tài khoản', 1, 1, 'empty');
INSERT INTO `gxc_page` VALUES(24, 'Account', 'Quản lý tài khoản', 'Quản lý tài khoản', 20, 'hmn', 'account', 2, '4ed5d59fd3d41', 1, 'Quản lý tài khoản', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(25, 'Forgot password?', 'Quên mật khẩu?', 'Quên mật khẩu?', 19, 'hmn', 'forgot-password', 2, '4ed894f028318', 1, 'Quên mật khẩu?', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(26, 'Reset Password', 'Reset Password', 'Reset Password', 25, 'hmn', 'reset-password', 2, '4edcd7f6e3302', 1, 'Reset Password', 1, 1, 'main');
INSERT INTO `gxc_page` VALUES(27, 'Item', 'Item', 'Item', 0, 'osg', 'item', 2, '4edf71ac9ab61', 1, 'Item', 1, 1, 'item');
INSERT INTO `gxc_page` VALUES(28, 'Ajax', 'Ajax', 'Ajax', 0, 'osg', 'ajax', 2, '4ee85008cb59d', 1, 'Ajax', 1, 1, 'empty');
INSERT INTO `gxc_page` VALUES(29, 'Share', 'Chia sẻ bài học', 'Chia sẻ bài học', 19, 'hmn', 'share', 2, '4ef2f73a67286', 1, 'Chia sẻ bài học', 1, 1, 'main');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_page_block`
--

CREATE TABLE `gxc_page_block` (
  `page_id` int(11) NOT NULL,
  `block_id` int(11) NOT NULL,
  `block_order` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `region` int(11) NOT NULL,
  PRIMARY KEY (`page_id`,`block_id`,`block_order`,`region`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_page_block`
--

INSERT INTO `gxc_page_block` VALUES(15, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(15, 26, 1, 1, 3);
INSERT INTO `gxc_page_block` VALUES(14, 13, 1, 1, 2);
INSERT INTO `gxc_page_block` VALUES(14, 44, 2, 1, 3);
INSERT INTO `gxc_page_block` VALUES(14, 46, 3, 1, 3);
INSERT INTO `gxc_page_block` VALUES(15, 11, 1, 1, 1);
INSERT INTO `gxc_page_block` VALUES(15, 25, 1, 1, 2);
INSERT INTO `gxc_page_block` VALUES(14, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(16, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(16, 24, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(14, 45, 1, 1, 3);
INSERT INTO `gxc_page_block` VALUES(17, 28, 2, 1, 4);
INSERT INTO `gxc_page_block` VALUES(17, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(17, 27, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(18, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(18, 11, 1, 1, 1);
INSERT INTO `gxc_page_block` VALUES(19, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(19, 47, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(20, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(20, 27, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(20, 31, 2, 1, 4);
INSERT INTO `gxc_page_block` VALUES(21, 32, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(22, 33, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(23, 34, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(24, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(24, 27, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(24, 35, 2, 1, 4);
INSERT INTO `gxc_page_block` VALUES(25, 36, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(25, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(26, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(26, 37, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(29, 48, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(29, 10, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(27, 40, 1, 1, 0);
INSERT INTO `gxc_page_block` VALUES(27, 38, 1, 1, 4);
INSERT INTO `gxc_page_block` VALUES(28, 41, 1, 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `gxc_rights`
--

CREATE TABLE `gxc_rights` (
  `itemname` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY (`itemname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_rights`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_session`
--

CREATE TABLE `gxc_session` (
  `id` char(32) NOT NULL,
  `expire` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_session`
--

INSERT INTO `gxc_session` VALUES('d2297ebacc4b30e10034dc517fb9c146', 1324548885, 'mp-translate|s:5:"en_us";');
INSERT INTO `gxc_session` VALUES('e2edbdb51796a2177dbf4194248783b2', 1324549917, 'mp-translate|s:5:"en_us";gxc_system_user_hmn__id|s:1:"1";gxc_system_user_hmn__name|s:19:"admin@localhost.com";gxc_system_user_hmnautoLoginToken|s:40:"fa0bb00d122c62e9542782ca19e2ae88d86ca986";gxc_system_user_hmn__states|a:1:{s:14:"autoLoginToken";b:1;}current_user|O:4:"User":12:{s:18:"\0CActiveRecord\0_md";N;s:19:"\0CActiveRecord\0_new";b:0;s:26:"\0CActiveRecord\0_attributes";a:24:{s:7:"user_id";s:1:"1";s:8:"username";s:5:"admin";s:8:"user_url";s:5:"admin";s:12:"display_name";s:15:"Tuấn Nguyễn";s:8:"password";s:32:"1a1a807162bccbce3ccc42a6db21d8d6";s:4:"salt";s:24:"hefd3213cxzczjdasdase321";s:5:"email";s:19:"admin@localhost.com";s:5:"fbuid";N;s:6:"status";s:1:"1";s:12:"created_time";s:10:"1307183214";s:12:"updated_time";s:10:"1324547451";s:12:"recent_login";s:10:"1324547451";s:19:"user_activation_key";s:10:"1307183214";s:9:"confirmed";s:1:"1";s:6:"gender";N;s:8:"location";N;s:3:"bio";N;s:14:"birthday_month";N;s:12:"birthday_day";N;s:13:"birthday_year";N;s:6:"avatar";N;s:15:"email_site_news";s:1:"1";s:18:"email_search_alert";s:1:"1";s:17:"email_recover_key";N;}s:23:"\0CActiveRecord\0_related";a:0:{}s:17:"\0CActiveRecord\0_c";N;s:18:"\0CActiveRecord\0_pk";s:1:"1";s:21:"\0CActiveRecord\0_alias";s:1:"t";s:15:"\0CModel\0_errors";a:0:{}s:19:"\0CModel\0_validators";N;s:17:"\0CModel\0_scenario";s:6:"update";s:14:"\0CComponent\0_e";N;s:14:"\0CComponent\0_m";N;}gxc_system_user_hmnRights_isSuperuser|b:1;');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_settings`
--

CREATE TABLE `gxc_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(64) NOT NULL DEFAULT 'system',
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `category_key` (`category`,`key`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `gxc_settings`
--

INSERT INTO `gxc_settings` VALUES(3, 'system', 'support_email', 's:22:"support@onsalegrab.com";');
INSERT INTO `gxc_settings` VALUES(5, 'system', 'page_size', 's:2:"10";');
INSERT INTO `gxc_settings` VALUES(6, 'system', 'language_number', 's:1:"2";');
INSERT INTO `gxc_settings` VALUES(7, 'general', 'site_name', 's:12:"On Sale Grab";');
INSERT INTO `gxc_settings` VALUES(8, 'general', 'site_title', 's:40:"On Sale Grab - Found sale stuff everyday";');
INSERT INTO `gxc_settings` VALUES(9, 'general', 'site_description', 's:40:"On Sale Grab - Found sale stuff everyday";');
INSERT INTO `gxc_settings` VALUES(10, 'system', 'page_slug', 's:4:"page";');
INSERT INTO `gxc_settings` VALUES(11, 'system', 'term_slug', 's:3:"cat";');
INSERT INTO `gxc_settings` VALUES(12, 'system', 'content_slug', 's:7:"content";');
INSERT INTO `gxc_settings` VALUES(13, 'general', 'homepage', 's:4:"home";');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_source_message`
--

CREATE TABLE `gxc_source_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(32) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=185 ;

--
-- Dumping data for table `gxc_source_message`
--

INSERT INTO `gxc_source_message` VALUES(1, 'cms', 'Update User');
INSERT INTO `gxc_source_message` VALUES(2, 'cms', 'This email has been registerd.');
INSERT INTO `gxc_source_message` VALUES(3, 'cms', 'Username has been registerd.');
INSERT INTO `gxc_source_message` VALUES(4, 'cms', 'Url has been registerd.');
INSERT INTO `gxc_source_message` VALUES(5, 'cms', 'User');
INSERT INTO `gxc_source_message` VALUES(6, 'cms', 'Username');
INSERT INTO `gxc_source_message` VALUES(7, 'cms', 'User Url');
INSERT INTO `gxc_source_message` VALUES(8, 'cms', 'Display Name');
INSERT INTO `gxc_source_message` VALUES(9, 'cms', 'Password');
INSERT INTO `gxc_source_message` VALUES(10, 'cms', 'Salt');
INSERT INTO `gxc_source_message` VALUES(11, 'cms', 'Email');
INSERT INTO `gxc_source_message` VALUES(12, 'cms', 'Fbuid');
INSERT INTO `gxc_source_message` VALUES(13, 'cms', 'Status');
INSERT INTO `gxc_source_message` VALUES(14, 'cms', 'Created Time');
INSERT INTO `gxc_source_message` VALUES(15, 'cms', 'Updated Time');
INSERT INTO `gxc_source_message` VALUES(16, 'cms', 'Recent Login');
INSERT INTO `gxc_source_message` VALUES(17, 'cms', 'User Activation Key');
INSERT INTO `gxc_source_message` VALUES(18, 'cms', 'Disabled');
INSERT INTO `gxc_source_message` VALUES(19, 'cms', 'Active');
INSERT INTO `gxc_source_message` VALUES(20, 'cms', 'Create new User');
INSERT INTO `gxc_source_message` VALUES(21, 'cms', 'Email is not valid');
INSERT INTO `gxc_source_message` VALUES(22, 'cms', 'User name');
INSERT INTO `gxc_source_message` VALUES(23, 'cms', 'Manage Users');
INSERT INTO `gxc_source_message` VALUES(24, 'cms', 'Displaying');
INSERT INTO `gxc_source_message` VALUES(25, 'cms', 'in');
INSERT INTO `gxc_source_message` VALUES(26, 'cms', 'results');
INSERT INTO `gxc_source_message` VALUES(27, 'cms', 'Go to page:');
INSERT INTO `gxc_source_message` VALUES(28, 'cms', 'Next');
INSERT INTO `gxc_source_message` VALUES(29, 'cms', 'previous');
INSERT INTO `gxc_source_message` VALUES(30, 'cms', 'First');
INSERT INTO `gxc_source_message` VALUES(31, 'cms', 'Last');
INSERT INTO `gxc_source_message` VALUES(32, 'cms', 'Roles');
INSERT INTO `gxc_source_message` VALUES(33, 'cms', 'Edit');
INSERT INTO `gxc_source_message` VALUES(34, 'cms', 'Delete');
INSERT INTO `gxc_source_message` VALUES(35, 'cms', 'Welcome');
INSERT INTO `gxc_source_message` VALUES(36, 'cms', 'Settings');
INSERT INTO `gxc_source_message` VALUES(37, 'cms', 'Change Password');
INSERT INTO `gxc_source_message` VALUES(38, 'cms', 'Sign out');
INSERT INTO `gxc_source_message` VALUES(39, 'cms', 'Dashboard');
INSERT INTO `gxc_source_message` VALUES(40, 'cms', 'Content');
INSERT INTO `gxc_source_message` VALUES(41, 'cms', 'Create Content');
INSERT INTO `gxc_source_message` VALUES(42, 'cms', 'Draft Content');
INSERT INTO `gxc_source_message` VALUES(43, 'cms', 'Pending Content');
INSERT INTO `gxc_source_message` VALUES(44, 'cms', 'Published Content');
INSERT INTO `gxc_source_message` VALUES(45, 'cms', 'Manage Content');
INSERT INTO `gxc_source_message` VALUES(46, 'cms', 'Category');
INSERT INTO `gxc_source_message` VALUES(47, 'cms', 'Create Term');
INSERT INTO `gxc_source_message` VALUES(48, 'cms', 'Manage Terms');
INSERT INTO `gxc_source_message` VALUES(49, 'cms', 'Create Taxonomy');
INSERT INTO `gxc_source_message` VALUES(50, 'cms', 'Mangage Taxonomy');
INSERT INTO `gxc_source_message` VALUES(51, 'cms', 'Pages');
INSERT INTO `gxc_source_message` VALUES(52, 'cms', 'Create Menu');
INSERT INTO `gxc_source_message` VALUES(53, 'cms', 'Manage Menus');
INSERT INTO `gxc_source_message` VALUES(54, 'cms', 'Create Queue');
INSERT INTO `gxc_source_message` VALUES(55, 'cms', 'Manage Queues');
INSERT INTO `gxc_source_message` VALUES(56, 'cms', 'Create Slot');
INSERT INTO `gxc_source_message` VALUES(57, 'cms', 'Manage Slots');
INSERT INTO `gxc_source_message` VALUES(58, 'cms', 'Create Page');
INSERT INTO `gxc_source_message` VALUES(59, 'cms', 'Manage Pages');
INSERT INTO `gxc_source_message` VALUES(60, 'cms', 'Resource');
INSERT INTO `gxc_source_message` VALUES(61, 'cms', 'Create Resource');
INSERT INTO `gxc_source_message` VALUES(62, 'cms', 'Manage Resource');
INSERT INTO `gxc_source_message` VALUES(63, 'cms', 'Manage');
INSERT INTO `gxc_source_message` VALUES(64, 'cms', 'Comments');
INSERT INTO `gxc_source_message` VALUES(65, 'cms', 'Create User');
INSERT INTO `gxc_source_message` VALUES(66, 'cms', 'Permission');
INSERT INTO `gxc_source_message` VALUES(67, 'RightsModule.core', 'Assignments');
INSERT INTO `gxc_source_message` VALUES(68, 'RightsModule.core', 'Here you can view which permissions has been assigned to each user.');
INSERT INTO `gxc_source_message` VALUES(69, 'RightsModule.core', 'No users found.');
INSERT INTO `gxc_source_message` VALUES(70, 'RightsModule.core', 'Name');
INSERT INTO `gxc_source_message` VALUES(71, 'RightsModule.core', 'Roles');
INSERT INTO `gxc_source_message` VALUES(72, 'RightsModule.core', 'Tasks');
INSERT INTO `gxc_source_message` VALUES(73, 'RightsModule.core', 'Operations');
INSERT INTO `gxc_source_message` VALUES(74, 'RightsModule.core', 'Permissions');
INSERT INTO `gxc_source_message` VALUES(75, 'cms', 'Save');
INSERT INTO `gxc_source_message` VALUES(76, 'RightsModule.core', 'Assign');
INSERT INTO `gxc_source_message` VALUES(77, 'RightsModule.core', 'Revoke');
INSERT INTO `gxc_source_message` VALUES(78, 'RightsModule.core', 'Item');
INSERT INTO `gxc_source_message` VALUES(79, 'RightsModule.core', 'Here you can view and manage the permissions assigned to each role.');
INSERT INTO `gxc_source_message` VALUES(80, 'RightsModule.core', 'Authorization items can be managed under {roleLink}, {taskLink} and {operationLink}.');
INSERT INTO `gxc_source_message` VALUES(81, 'RightsModule.core', 'Generate items for controller actions');
INSERT INTO `gxc_source_message` VALUES(82, 'RightsModule.core', 'No authorization items found.');
INSERT INTO `gxc_source_message` VALUES(83, 'RightsModule.core', 'Hover to see from where the permission is inherited.');
INSERT INTO `gxc_source_message` VALUES(84, 'RightsModule.core', 'Source');
INSERT INTO `gxc_source_message` VALUES(85, 'RightsModule.core', 'A role is group of permissions to perform a variety of tasks and operations, for example the authenticated user.');
INSERT INTO `gxc_source_message` VALUES(86, 'RightsModule.core', 'Roles exist at the top of the authorization hierarchy and can therefore inherit from other roles, tasks and/or operations.');
INSERT INTO `gxc_source_message` VALUES(87, 'RightsModule.core', 'Create a new role');
INSERT INTO `gxc_source_message` VALUES(88, 'RightsModule.core', 'No roles found.');
INSERT INTO `gxc_source_message` VALUES(89, 'RightsModule.core', 'Description');
INSERT INTO `gxc_source_message` VALUES(90, 'RightsModule.core', 'Business rule');
INSERT INTO `gxc_source_message` VALUES(91, 'RightsModule.core', 'Data');
INSERT INTO `gxc_source_message` VALUES(92, 'RightsModule.core', 'Delete');
INSERT INTO `gxc_source_message` VALUES(93, 'RightsModule.core', 'Are you sure you want to delete this role?');
INSERT INTO `gxc_source_message` VALUES(94, 'RightsModule.core', 'Values within square brackets tell how many children each item has.');
INSERT INTO `gxc_source_message` VALUES(95, 'RightsModule.core', 'A task is a permission to perform multiple operations, for example accessing a group of controller action.');
INSERT INTO `gxc_source_message` VALUES(96, 'RightsModule.core', 'Tasks exist below roles in the authorization hierarchy and can therefore only inherit from other tasks and/or operations.');
INSERT INTO `gxc_source_message` VALUES(97, 'RightsModule.core', 'Create a new task');
INSERT INTO `gxc_source_message` VALUES(98, 'RightsModule.core', 'No tasks found.');
INSERT INTO `gxc_source_message` VALUES(99, 'RightsModule.core', 'Are you sure you want to delete this task?');
INSERT INTO `gxc_source_message` VALUES(100, 'RightsModule.core', 'An operation is a permission to perform a single operation, for example accessing a certain controller action.');
INSERT INTO `gxc_source_message` VALUES(101, 'RightsModule.core', 'Operations exist below tasks in the authorization hierarchy and can therefore only inherit from other operations.');
INSERT INTO `gxc_source_message` VALUES(102, 'RightsModule.core', 'Create a new operation');
INSERT INTO `gxc_source_message` VALUES(103, 'RightsModule.core', 'No operations found.');
INSERT INTO `gxc_source_message` VALUES(104, 'RightsModule.core', 'Are you sure you want to delete this operation?');
INSERT INTO `gxc_source_message` VALUES(105, 'RightsModule.core', 'Operation');
INSERT INTO `gxc_source_message` VALUES(106, 'RightsModule.core', 'Task');
INSERT INTO `gxc_source_message` VALUES(107, 'RightsModule.core', 'Role');
INSERT INTO `gxc_source_message` VALUES(108, 'RightsModule.core', 'Create :type');
INSERT INTO `gxc_source_message` VALUES(109, 'RightsModule.core', 'Do not change the name unless you know what you are doing.');
INSERT INTO `gxc_source_message` VALUES(110, 'RightsModule.core', 'A descriptive name for this item.');
INSERT INTO `gxc_source_message` VALUES(111, 'RightsModule.core', 'Code that will be executed when performing access checking.');
INSERT INTO `gxc_source_message` VALUES(112, 'RightsModule.core', 'Save');
INSERT INTO `gxc_source_message` VALUES(113, 'RightsModule.core', 'Cancel');
INSERT INTO `gxc_source_message` VALUES(114, 'cms', 'Manage User');
INSERT INTO `gxc_source_message` VALUES(115, 'cms', 'Update this user');
INSERT INTO `gxc_source_message` VALUES(116, 'cms', 'View this user');
INSERT INTO `gxc_source_message` VALUES(117, 'cms', 'Make sure the username, user url and email are unique ');
INSERT INTO `gxc_source_message` VALUES(118, 'cms', 'Here you can add new member for the site');
INSERT INTO `gxc_source_message` VALUES(119, 'cms', 'Here you can view all members information of your site');
INSERT INTO `gxc_source_message` VALUES(120, 'cms', 'View User');
INSERT INTO `gxc_source_message` VALUES(121, 'cms', 'View user details');
INSERT INTO `gxc_source_message` VALUES(122, 'cms', 'Create new content');
INSERT INTO `gxc_source_message` VALUES(123, 'cms', 'Event');
INSERT INTO `gxc_source_message` VALUES(124, 'cms', 'Article');
INSERT INTO `gxc_source_message` VALUES(125, 'cms', 'Object');
INSERT INTO `gxc_source_message` VALUES(126, 'cms', 'Object Author');
INSERT INTO `gxc_source_message` VALUES(127, 'cms', 'Object Date');
INSERT INTO `gxc_source_message` VALUES(128, 'cms', 'Object Date Gmt');
INSERT INTO `gxc_source_message` VALUES(129, 'cms', 'Object Content');
INSERT INTO `gxc_source_message` VALUES(130, 'cms', 'Object Title');
INSERT INTO `gxc_source_message` VALUES(131, 'cms', 'Object Excerpt');
INSERT INTO `gxc_source_message` VALUES(132, 'cms', 'Object Status');
INSERT INTO `gxc_source_message` VALUES(133, 'cms', 'Comment Status');
INSERT INTO `gxc_source_message` VALUES(134, 'cms', 'Object Password');
INSERT INTO `gxc_source_message` VALUES(135, 'cms', 'Object Name');
INSERT INTO `gxc_source_message` VALUES(136, 'cms', 'Object Modified');
INSERT INTO `gxc_source_message` VALUES(137, 'cms', 'Object Modified Gmt');
INSERT INTO `gxc_source_message` VALUES(138, 'cms', 'Object Content Filtered');
INSERT INTO `gxc_source_message` VALUES(139, 'cms', 'Object Parent');
INSERT INTO `gxc_source_message` VALUES(140, 'cms', 'Guid');
INSERT INTO `gxc_source_message` VALUES(141, 'cms', 'Object Type');
INSERT INTO `gxc_source_message` VALUES(142, 'cms', 'Comment Count');
INSERT INTO `gxc_source_message` VALUES(143, 'cms', 'Object Slug');
INSERT INTO `gxc_source_message` VALUES(144, 'cms', 'Object Description');
INSERT INTO `gxc_source_message` VALUES(145, 'cms', 'Object Keywords');
INSERT INTO `gxc_source_message` VALUES(146, 'cms', 'Lang');
INSERT INTO `gxc_source_message` VALUES(147, 'cms', 'Object Author Name');
INSERT INTO `gxc_source_message` VALUES(148, 'cms', 'Total Number Meta');
INSERT INTO `gxc_source_message` VALUES(149, 'cms', 'Total Number Resource');
INSERT INTO `gxc_source_message` VALUES(150, 'cms', 'Tags');
INSERT INTO `gxc_source_message` VALUES(151, 'cms', 'Object View');
INSERT INTO `gxc_source_message` VALUES(152, 'cms', 'Like');
INSERT INTO `gxc_source_message` VALUES(153, 'cms', 'Dislike');
INSERT INTO `gxc_source_message` VALUES(154, 'cms', 'Rating Scores');
INSERT INTO `gxc_source_message` VALUES(155, 'cms', 'Rating Average');
INSERT INTO `gxc_source_message` VALUES(156, 'cms', 'Layout');
INSERT INTO `gxc_source_message` VALUES(157, 'cms', 'Person');
INSERT INTO `gxc_source_message` VALUES(158, 'cms', 'Resources');
INSERT INTO `gxc_source_message` VALUES(159, 'cms', 'Content Extra');
INSERT INTO `gxc_source_message` VALUES(160, 'cms', 'Summary & SEO');
INSERT INTO `gxc_source_message` VALUES(161, 'cms', 'Summary');
INSERT INTO `gxc_source_message` VALUES(162, 'cms', 'SEO');
INSERT INTO `gxc_source_message` VALUES(163, 'cms', 'Add Term');
INSERT INTO `gxc_source_message` VALUES(164, 'cms', 'Here you can manage your Terms');
INSERT INTO `gxc_source_message` VALUES(165, 'cms', 'Term id');
INSERT INTO `gxc_source_message` VALUES(166, 'cms', 'Taxonomy id');
INSERT INTO `gxc_source_message` VALUES(167, 'cms', 'Name');
INSERT INTO `gxc_source_message` VALUES(168, 'cms', 'Description');
INSERT INTO `gxc_source_message` VALUES(169, 'cms', 'Slug');
INSERT INTO `gxc_source_message` VALUES(170, 'cms', 'Parent');
INSERT INTO `gxc_source_message` VALUES(171, 'cms', 'Published');
INSERT INTO `gxc_source_message` VALUES(172, 'cms', 'Draft');
INSERT INTO `gxc_source_message` VALUES(173, 'cms', 'Pending');
INSERT INTO `gxc_source_message` VALUES(174, 'cms', 'Hidden');
INSERT INTO `gxc_source_message` VALUES(175, 'cms', 'Publish');
INSERT INTO `gxc_source_message` VALUES(176, 'cms', 'Send to Person: ');
INSERT INTO `gxc_source_message` VALUES(177, 'cms', 'Send');
INSERT INTO `gxc_source_message` VALUES(178, 'cms', 'Send to: ');
INSERT INTO `gxc_source_message` VALUES(179, 'cms', 'Please choose a name');
INSERT INTO `gxc_source_message` VALUES(180, 'cms', 'You are not allowed to send content to this user');
INSERT INTO `gxc_source_message` VALUES(181, 'cms', 'Allow');
INSERT INTO `gxc_source_message` VALUES(182, 'cms', 'Disable');
INSERT INTO `gxc_source_message` VALUES(183, 'cms', 'General');
INSERT INTO `gxc_source_message` VALUES(184, 'cms', 'System');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_tag`
--

CREATE TABLE `gxc_tag` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `frequency` int(11) DEFAULT '1',
  `slug` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `slug` (`slug`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `gxc_tag`
--

INSERT INTO `gxc_tag` VALUES(1, 'article', 3, 'article');
INSERT INTO `gxc_tag` VALUES(2, 'seo', 3, 'seo');
INSERT INTO `gxc_tag` VALUES(3, 'event', 3, 'event');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_tag_relationships`
--

CREATE TABLE `gxc_tag_relationships` (
  `tag_id` bigint(20) NOT NULL,
  `object_id` bigint(20) NOT NULL,
  PRIMARY KEY (`tag_id`,`object_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_tag_relationships`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_taxonomy`
--

CREATE TABLE `gxc_taxonomy` (
  `taxonomy_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'article',
  `lang` tinyint(4) DEFAULT '1',
  `guid` varchar(255) NOT NULL,
  PRIMARY KEY (`taxonomy_id`),
  KEY `taxonomy` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gxc_taxonomy`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_term`
--

CREATE TABLE `gxc_term` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `taxonomy_id` int(20) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `slug` varchar(255) NOT NULL DEFAULT '',
  `parent` bigint(20) NOT NULL DEFAULT '0',
  `order` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`term_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gxc_term`
--


-- --------------------------------------------------------

--
-- Table structure for table `gxc_transfer`
--

CREATE TABLE `gxc_transfer` (
  `transfer_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) NOT NULL,
  `from_user_id` bigint(20) NOT NULL,
  `to_user_id` bigint(20) NOT NULL,
  `before_status` tinyint(2) NOT NULL,
  `after_status` tinyint(2) NOT NULL,
  `type` int(11) NOT NULL,
  `note` varchar(125) DEFAULT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`transfer_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Dumping data for table `gxc_transfer`
--

INSERT INTO `gxc_transfer` VALUES(13, 18, 1, 0, 2, 1, 3, NULL, 1314807316);

-- --------------------------------------------------------

--
-- Table structure for table `gxc_translated_message`
--

CREATE TABLE `gxc_translated_message` (
  `id` int(11) NOT NULL DEFAULT '0',
  `language` varchar(16) NOT NULL DEFAULT '',
  `translation` text,
  PRIMARY KEY (`id`,`language`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `gxc_translated_message`
--

INSERT INTO `gxc_translated_message` VALUES(1, 'en_us', 'Update User');
INSERT INTO `gxc_translated_message` VALUES(2, 'en_us', 'This email has been registered');
INSERT INTO `gxc_translated_message` VALUES(3, 'en_us', 'Username has been registered');
INSERT INTO `gxc_translated_message` VALUES(4, 'en_us', 'Url has been registered');
INSERT INTO `gxc_translated_message` VALUES(14, 'en_us', 'Created time');
INSERT INTO `gxc_translated_message` VALUES(5, 'en_us', 'User');
INSERT INTO `gxc_translated_message` VALUES(6, 'en_us', 'Username');
INSERT INTO `gxc_translated_message` VALUES(8, 'en_us', 'Display name');
INSERT INTO `gxc_translated_message` VALUES(23, 'vi_vn', 'Quản lý thành viên');
INSERT INTO `gxc_translated_message` VALUES(24, 'vi_vn', 'Hiển thị');
INSERT INTO `gxc_translated_message` VALUES(25, 'vi_vn', 'trong');
INSERT INTO `gxc_translated_message` VALUES(26, 'vi_vn', 'kết quả');
INSERT INTO `gxc_translated_message` VALUES(27, 'vi_vn', 'Đến trang:');
INSERT INTO `gxc_translated_message` VALUES(28, 'vi_vn', 'Sau');
INSERT INTO `gxc_translated_message` VALUES(29, 'vi_vn', 'Trước');
INSERT INTO `gxc_translated_message` VALUES(30, 'vi_vn', 'Đầu');
INSERT INTO `gxc_translated_message` VALUES(31, 'vi_vn', 'Cuối');
INSERT INTO `gxc_translated_message` VALUES(32, 'vi_vn', 'Nhóm');
INSERT INTO `gxc_translated_message` VALUES(13, 'vi_vn', 'Trạng thái');
INSERT INTO `gxc_translated_message` VALUES(14, 'vi_vn', 'Tạo');
INSERT INTO `gxc_translated_message` VALUES(15, 'vi_vn', 'Cập nhật');
INSERT INTO `gxc_translated_message` VALUES(16, 'vi_vn', 'Gần đây');
INSERT INTO `gxc_translated_message` VALUES(17, 'vi_vn', 'Active Key');
INSERT INTO `gxc_translated_message` VALUES(2, 'vi_vn', 'Email đã đăng ký');
INSERT INTO `gxc_translated_message` VALUES(3, 'vi_vn', 'Username đã đăng ký');
INSERT INTO `gxc_translated_message` VALUES(4, 'vi_vn', 'Url đã đăng ký');
INSERT INTO `gxc_translated_message` VALUES(33, 'vi_vn', 'Sửa');
INSERT INTO `gxc_translated_message` VALUES(34, 'vi_vn', 'Xoá');
INSERT INTO `gxc_translated_message` VALUES(5, 'vi_vn', 'Thành viên');
INSERT INTO `gxc_translated_message` VALUES(6, 'vi_vn', 'Username');
INSERT INTO `gxc_translated_message` VALUES(7, 'vi_vn', 'User Url');
INSERT INTO `gxc_translated_message` VALUES(8, 'vi_vn', 'Tên');
INSERT INTO `gxc_translated_message` VALUES(9, 'vi_vn', 'Mật khẩu');
INSERT INTO `gxc_translated_message` VALUES(10, 'vi_vn', 'Salt');
INSERT INTO `gxc_translated_message` VALUES(11, 'vi_vn', 'Email');
INSERT INTO `gxc_translated_message` VALUES(12, 'vi_vn', 'FB Id');
INSERT INTO `gxc_translated_message` VALUES(1, 'vi_vn', 'Cập nhật');
INSERT INTO `gxc_translated_message` VALUES(18, 'vi_vn', 'Khoá');
INSERT INTO `gxc_translated_message` VALUES(19, 'vi_vn', 'Kích hoạt');
INSERT INTO `gxc_translated_message` VALUES(75, 'vi_vn', 'Lưu');
INSERT INTO `gxc_translated_message` VALUES(35, 'vi_vn', 'Xin chào ');
INSERT INTO `gxc_translated_message` VALUES(36, 'vi_vn', 'Thông tin');
INSERT INTO `gxc_translated_message` VALUES(38, 'vi_vn', 'Đăng xuất');
INSERT INTO `gxc_translated_message` VALUES(37, 'vi_vn', 'Đổi mật khẩu');
INSERT INTO `gxc_translated_message` VALUES(20, 'vi_vn', 'Thêm mới');
INSERT INTO `gxc_translated_message` VALUES(21, 'vi_vn', 'Email không hợp lệ');
INSERT INTO `gxc_translated_message` VALUES(22, 'vi_vn', 'Username');
INSERT INTO `gxc_translated_message` VALUES(114, 'vi_vn', 'Quản lý thành viên');
INSERT INTO `gxc_translated_message` VALUES(65, 'vi_vn', 'Thêm mới');
INSERT INTO `gxc_translated_message` VALUES(115, 'vi_vn', 'Thay đổi thông tin');
INSERT INTO `gxc_translated_message` VALUES(116, 'vi_vn', 'Xem thông tin');
INSERT INTO `gxc_translated_message` VALUES(117, 'vi_vn', 'Username, url và email cần duy nhất');
INSERT INTO `gxc_translated_message` VALUES(118, 'vi_vn', 'Bạn có thể thểm mới thành viên tại đây');
INSERT INTO `gxc_translated_message` VALUES(119, 'vi_vn', 'Bạn có thể xem thông tin các thành viên tại đây ');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_user`
--

CREATE TABLE `gxc_user` (
  `user_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `user_url` varchar(128) DEFAULT NULL,
  `display_name` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `salt` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `fbuid` bigint(20) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_time` int(11) NOT NULL,
  `updated_time` int(11) NOT NULL,
  `recent_login` int(11) NOT NULL,
  `user_activation_key` varchar(255) NOT NULL DEFAULT '',
  `confirmed` tinyint(2) NOT NULL DEFAULT '0',
  `gender` varchar(10) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `bio` text,
  `birthday_month` varchar(50) DEFAULT NULL,
  `birthday_day` varchar(2) DEFAULT NULL,
  `birthday_year` varchar(4) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `email_site_news` tinyint(1) NOT NULL DEFAULT '1',
  `email_search_alert` tinyint(1) NOT NULL DEFAULT '1',
  `email_recover_key` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `gxc_user`
--

INSERT INTO `gxc_user` VALUES(1, 'admin', 'admin', 'Tuấn Nguyễn', '1a1a807162bccbce3ccc42a6db21d8d6', 'hefd3213cxzczjdasdase321', 'admin@localhost.com', NULL, 1, 1307183214, 1324547451, 1324547451, '1307183214', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL);
INSERT INTO `gxc_user` VALUES(2, 'reporter', 'reporter', 'Reporter', 'd0bf47e7daf6fce945a2796cf5ae930a', 'hefd3213cxzczjdasdase321', 'reporter@localhost.com', NULL, 1, 1307183214, 1314204280, 1314089738, '1307183214', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL);
INSERT INTO `gxc_user` VALUES(6, 'member', '', 'Member', '1a1a807162bccbce3ccc42a6db21d8d6', 'hefd3213cxzczjdasdase321', 'member@localhost.com', NULL, 1, 1314625570, 1314628422, 1314628422, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL);
INSERT INTO `gxc_user` VALUES(7, 'tri', '', 'Tri', '1a1a807162bccbce3ccc42a6db21d8d6', 'hefd3213cxzczjdasdase321', 'nminhtri0806@gmail.com', NULL, 1, 1317886124, 1317886124, 1317886124, '', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL);
INSERT INTO `gxc_user` VALUES(8, 'onsalegrab.com@gmail.com', '', 'Onsalegrab', 'f8100b2b04def2dca2030bb9d3b934ce', 'hefd3213cxzczjdasdase321', 'onsalegrab.com@gmail.com', NULL, 1, 1321928848, 1322035546, 1322035546, '', 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL);
INSERT INTO `gxc_user` VALUES(14, 'edo@yahoo.com', '', 'Tuan Nguyen', '1a1a807162bccbce3ccc42a6db21d8d6', 'hefd3213cxzczjdasdase321', 'edo@yahoo.com', NULL, 1, 1322038430, 1323334361, 1323334361, '537d488a70b9df4fcab95cfdce2fb48b', 0, 'male', 'Vietnam', 'Loving web stuff', 'march', '6', '1986', '1000/14_Vnu3moVv.jpg', 1, 1, NULL);
INSERT INTO `gxc_user` VALUES(16, 'info@onsalegrab.com', '', 'Tri Nguyen', '6b4a329adc7b8568994608de172681d7', 'hefd3213cxzczjdasdase321', 'info@onsalegrab.com', NULL, 1, 1322814261, 1323097179, 1323097179, 'b2ddf6d4ce010401e12963a3b9aca3d0', 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `gxc_user_meta`
--

CREATE TABLE `gxc_user_meta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `gxc_user_meta`
--

