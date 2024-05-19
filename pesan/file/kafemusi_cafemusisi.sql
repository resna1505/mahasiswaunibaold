-- phpMyAdmin SQL Dump
-- version 3.5.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 04, 2013 at 11:12 PM
-- Server version: 5.1.68-cll
-- PHP Version: 5.3.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `kafemusi_cafemusisi`
--

-- --------------------------------------------------------

--
-- Table structure for table `acos`
--

DROP TABLE IF EXISTS `acos`;
CREATE TABLE IF NOT EXISTS `acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `acos`
--

INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, '', NULL, 'controllers', 1, 1000),
(2, 1, '', NULL, 'Users', 2, 25),
(3, 2, '', NULL, 'admin_index', 3, 4),
(4, 2, '', NULL, 'admin_view', 5, 6),
(5, 2, '', NULL, 'admin_add', 7, 8),
(6, 2, '', NULL, 'admin_edit', 9, 10),
(7, 2, '', NULL, 'admin_delete', 11, 12),
(8, 2, '', NULL, 'admin_change_password', 13, 14),
(9, 2, '', NULL, 'change_password', 15, 16),
(15, 1, '', NULL, 'Dashboards', 26, 50),
(16, 15, '', NULL, 'admin_index', 27, 28),
(17, 15, '', NULL, 'index', 29, 30);

-- --------------------------------------------------------

--
-- Table structure for table `aros`
--

DROP TABLE IF EXISTS `aros`;
CREATE TABLE IF NOT EXISTS `aros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `aros`
--

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Group', 1, 'Admin', 1, 2),
(2, NULL, 'Group', 2, 'Member', 3, 4);

-- --------------------------------------------------------

--
-- Table structure for table `aros_acos`
--

DROP TABLE IF EXISTS `aros_acos`;
CREATE TABLE IF NOT EXISTS `aros_acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned NOT NULL,
  `aco_id` int(10) unsigned NOT NULL,
  `_create` char(2) NOT NULL DEFAULT '0',
  `_read` char(2) NOT NULL DEFAULT '0',
  `_update` char(2) NOT NULL DEFAULT '0',
  `_delete` char(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `aros_acos`
--

INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 2, 9, '1', '1', '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` char(36) NOT NULL,
  `slug` varchar(125) NOT NULL,
  `title` varchar(100) NOT NULL,
  `text` text NOT NULL,
  `tag` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `title` (`title`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` char(36) NOT NULL,
  `parent_id` char(36) NOT NULL,
  `type` char(1) NOT NULL,
  `module_id` char(36) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `comment` text NOT NULL,
  `lft` int(10) unsigned NOT NULL,
  `rght` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `parent_id` (`parent_id`),
  KEY `user_id` (`user_id`),
  KEY `module_id` (`module_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `parent_id`, `type`, `module_id`, `user_id`, `comment`, `lft`, `rght`, `created`) VALUES
('0106147a-79a3-11e2-a194-485b395a1bf2', '', '1', 'A1', 1, 'sdfadsfs', 1, 2, '0000-00-00 00:00:00'),
('512fa1f5-6830-4885-a863-04bc9aef675a', '5121e7ab-0e54-400a-8a8e-1b249aef675a', '1', 'A1', 8, 'ss', 0, 0, '2013-03-01 01:29:09'),
('512fa25c-5a94-4548-b583-04bc9aef675a', '5121e7ab-0e54-400a-8a8e-1b249aef675a', '1', 'A1', 8, 'ss', 0, 0, '2013-03-01 01:30:52'),
('51323da0-65bc-4153-aa60-06d89aef675a', '5121e7ab-0e54-400a-8a8e-1b249aef675a', '1', 'A1', 8, 'sds', 0, 0, '2013-03-03 00:57:52'),
('51323e06-6bd8-4e08-a327-06d89aef675a', '5121e7ab-0e54-400a-8a8e-1b249aef675a', '1', '5121e7ab-0e54-400a-8a8e-1b249aef675a', 8, 'sss', 0, 0, '2013-03-03 00:59:34'),
('51323e0f-6a30-43c8-bff3-06d89aef675a', '5121e7ab-0e54-400a-8a8e-1b249aef675a', '1', '5121e7ab-0e54-400a-8a8e-1b249aef675a', 8, 'iii', 0, 0, '2013-03-03 00:59:43'),
('51324461-4304-4257-9928-06d89aef675a', '5121e7ab-0e54-400a-8a8e-1b249aef675a', '1', '5121e7ab-0e54-400a-8a8e-1b249aef675a', 8, 'sss', 0, 0, '2013-03-03 01:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `email_drafts`
--

DROP TABLE IF EXISTS `email_drafts`;
CREATE TABLE IF NOT EXISTS `email_drafts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `draft` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `email_drafts`
--

INSERT INTO `email_drafts` (`id`, `title`, `subject`, `draft`, `created`, `modified`) VALUES
(1, 'Confirmation of registration', 'Confirmation of registration', '<p>\r\n	Hello {NAME}, Thanks for your registration.<br />\r\n	to activate your account please click {LINK_ACTIVATED}activate my account{/LINK}<br />\r\n	<br />\r\n	regards,<br />\r\n	Administrator</p>\r\n', '2013-02-01 00:00:00', '2013-02-02 21:07:46'),
(2, 'Your account was actived ', 'Your account was actived ', '<p>\r\n	welcome to my site,<br />\r\n	your account was actived, please {LINK_LOGIN}login{/LINK}<br />\r\n	username : {USERNAME}<br />\r\n	<br />\r\n	regards,<br />\r\n	administrator</p>\r\n', '2013-02-01 00:00:00', '2013-02-02 21:07:36'),
(3, 'Forgot Password', 'Forgor Password', '<p>\r\n	Hello {NAME}, you or someone has request to change password.<br />\r\n	Are you sure forgot password? to get new password please click {LINK_FORGOT}change password{/LINK}<br />\r\n	<br />\r\n	regards,<br />\r\n	Administrator</p>\r\n', '2013-02-01 00:00:00', '2013-02-01 00:00:00'),
(4, 'Request New Password', 'Request New Password', '<p>\r\n	Hello {NAME},<br />\r\n	your password has been changed, please {LINK_LOGIN}login{/LINK}<br />\r\n	username : {USERNAME}<br />\r\n	<br />\r\n	regards,<br />\r\n	administrator</p>\r\n', '2013-02-01 00:00:00', '2013-02-01 00:00:00'),
(5, 'Add user by Admin ', 'You has invite to be member cafe musisi', '<p>\r\n	Hello {NAME},<br />\r\n	You has invite to be member cafe musisi, your username : {USERNAME}. To get your password please click {LINK_PASSWORD}get password{/LINK}<br />\r\n	<br />\r\n	regards,<br />\r\n	administrator</p>\r\n', '2013-02-01 00:00:00', '2013-02-03 00:23:09');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `id` char(36) NOT NULL,
  `slug` varchar(125) NOT NULL,
  `title` varchar(100) NOT NULL,
  `file` varchar(255) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`),
  KEY `title` (`title`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `slug`, `title`, `file`, `user_id`, `created`, `modified`) VALUES
('5121f870-58e8-4b0c-ba1d-1b229aef675a', 'dfgdfgs', 'dfgdfgs', 'alur scheduler task mohon faktur.odt', 1, '2013-02-18 16:46:24', '2013-02-18 16:46:24');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `created`, `modified`) VALUES
(1, 'Admin', '2013-02-01 00:00:00', '2013-02-01 00:00:00'),
(2, 'Member', '2013-02-01 00:00:00', '2013-02-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` char(36) NOT NULL,
  `type` char(1) NOT NULL,
  `module_id` char(36) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `operation` char(1) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `module_id` (`module_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mailinglists`
--

DROP TABLE IF EXISTS `mailinglists`;
CREATE TABLE IF NOT EXISTS `mailinglists` (
  `id` char(36) NOT NULL,
  `email` varchar(255) NOT NULL,
  `is_valid` smallint(1) NOT NULL DEFAULT '0',
  `actived` smallint(1) NOT NULL DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mailinglists`
--

INSERT INTO `mailinglists` (`id`, `email`, `is_valid`, `actived`, `created`, `modified`) VALUES
('505a76e9-42cc-4e36-b85b-17957bc88d07', 'andri.darmawan@gmail.com', 1, 1, '2012-09-20 01:52:41', '2012-09-20 05:35:28'),
('505a7742-7468-4fb9-a99f-17947bc88d07', 'nidza99@yahoo.com', 1, 1, '2012-09-20 01:54:10', '2012-09-20 05:35:33');

-- --------------------------------------------------------

--
-- Table structure for table `mailinglists_newsletters`
--

DROP TABLE IF EXISTS `mailinglists_newsletters`;
CREATE TABLE IF NOT EXISTS `mailinglists_newsletters` (
  `id` char(36) NOT NULL,
  `newsletter_id` char(36) NOT NULL,
  `mailinglist_id` char(36) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `job_unique` (`newsletter_id`,`mailinglist_id`),
  KEY `mailinglist_i` (`mailinglist_id`),
  KEY `newsletter_i` (`newsletter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` char(36) NOT NULL,
  `subject` varchar(128) NOT NULL,
  `content` text NOT NULL,
  `has_send` tinyint(1) NOT NULL DEFAULT '0',
  `start_blast` datetime DEFAULT NULL,
  `end_blast` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newsletters`
--

INSERT INTO `newsletters` (`id`, `subject`, `content`, `has_send`, `start_blast`, `end_blast`, `created`) VALUES
('505abc44-2b5c-4bea-b41f-09f17bc88d07', '1', '<p>\r\n	waret</p>\r\n', 1, '2012-09-20 08:37:37', '2012-09-20 08:37:42', '2012-09-20 06:48:36'),
('50654d8b-96ac-4100-8f0a-09f77bc88d07', 'Lebih Bijak Memilih Ubin', '<p>\r\n	&nbsp;</p>\r\n<h1>\r\n	Lebih Bijak Memilih Ubin</h1>\r\n<div>\r\n	Ubin adalah pilihan umum untuk digunakan sebagai material kamar mandi. Bukan hanya relatif kuat, namun ubin juga mudah dibersihkan dan memiliki banyak jenis, ukuran, dan tekstur untuk dipilih.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Saat ini, jika sedang ingin mengganti atau menambahkan ubin di kamar mandi, ada baiknya Anda memikirkannya baik-baik. Sekali Anda memasangnya, ubin tersebut hampir permanen. Untuk itu, Anda harus memilihlah dengan bijak. Berikut ini tips sederhana untuk sebelum memutuskan menggunakan tipe ubin tertentu pada kamar mandi Anda:</div>\r\n<div>\r\n	&nbsp;</div>\r\n<h3>\r\n	Anggaran</h3>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Sama seperti proyek renovasi rumah lainnya, langkah pertama perlu Anda lakukan dalam prosesnya adalah menetapkan anggaran. Ingatlah, bahwa biasanya ubin yang lebih mahal memiliki kualitas lebih baik.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Namun, jika bersikeras memilih ubin berkualitas terbaik, Anda sebaiknya siap dengan biaya besar. Namun, jika jeli dan tidak terburu-buru mencarinya, Anda tetap dapat menemukan ubin berkualitas baik dengan harga lebih murah.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Pilihlah material yang Anda inginkan</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Ubin dapat dibuat dari berbagai macam material termasuk keramik, kaca, granit, atau bahkan marmer. Ingatlah, bahwa tipe ubin yang dipilih akan sangat ditentukan oleh anggaran Anda. Misalnya, ubin keramik cenderung lebih murah dari ubin marmer.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<h3>\r\n	Warna dan gaya</h3>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Pilihlah warna dan gaya ubin Anda. Apakah Anda ingin ubin kamar mandi memiliki corak tertentu?</div>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Ada beberapa orang menyukai corak berulang, ada juga yang hanya menyukai corak solid garis-garis. Namun, apapun keinginan itu selalu ingatlah, bahwa pilihan Anda akan memiliki dampak besar pada keseluruhan dekorasi kamar mandi.</div>\r\n<div>\r\n	&nbsp;</div>\r\n<h3>\r\n	Jasa ahli</h3>\r\n<div>\r\n	&nbsp;</div>\r\n<div>\r\n	Walaupun tampak sederhana dan mudah, lebih baik Anda menyerahkan pemasangan ubin pada ahlinya. Memasang ubin bukan salah satu proyek renovasi rumah yang dapat dilakukan sendiri. Anda tentu menginginkan tampilan sempurna untuk kamar mandi selama beberapa tahun ke depan.</div>\r\n', 0, NULL, NULL, '2012-09-28 07:11:07');

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_configurations`
--

DROP TABLE IF EXISTS `newsletter_configurations`;
CREATE TABLE IF NOT EXISTS `newsletter_configurations` (
  `id` int(10) unsigned NOT NULL,
  `title` varchar(45) NOT NULL,
  `content` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title_UNIQUE` (`title`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `newsletter_configurations`
--

INSERT INTO `newsletter_configurations` (`id`, `title`, `content`) VALUES
(1, 'host', 'newsletter.cafemusisi.com'),
(2, 'email_sender', 'admin@newsletter.cafemusisi.com'),
(3, 'name_sender', 'cafe musisi'),
(4, 'cc', 'cafemusisi@gmail.com'),
(5, 'bcc', ''),
(6, 'email_testing', 'andri.darmawan@gmail.com, nidza99@yahoo.com, nidza99@nerdshack.com'),
(7, 'draft_confirmation', '<p>\r\n	Thanks for your subscribe to our mailinglist.<br />\r\n	To confirm your registration please click {LINK}Confirmation{/LINK}<br />\r\n	<br />\r\n	Best Regards,<br />\r\n	Imperial Treasure</p>\r\n'),
(8, 'smtp_host', NULL),
(9, 'smtp_port', NULL),
(10, 'smtp_username', NULL),
(11, 'smtp_password', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
CREATE TABLE IF NOT EXISTS `photos` (
  `id` char(36) NOT NULL,
  `photo_album_id` char(36) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `photo` varchar(125) NOT NULL,
  `description` text,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_album_id` (`photo_album_id`),
  KEY `photo` (`photo`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `photo_album_id`, `title`, `photo`, `description`, `user_id`, `created`, `modified`) VALUES
('5121bc9d-33a0-46cb-92c2-1b279aef675a', '5121bc9d-cf60-4f5e-a18a-1b279aef675a', 'sdsd', 'aurat.jpg', 'as', 1, '2013-02-18 12:31:09', '2013-02-18 12:31:09'),
('5121bc9d-1094-449e-934d-1b279aef675a', '5121bc9d-cf60-4f5e-a18a-1b279aef675a', 'dsds', 'emas.jpg', 'asasa', 1, '2013-02-18 12:31:09', '2013-02-18 12:31:09'),
('5121bc9d-29b8-462f-a954-1b279aef675a', '5121bc9d-cf60-4f5e-a18a-1b279aef675a', 'dsds', 'boneka-rumah.jpg', 'sas', 1, '2013-02-18 12:31:09', '2013-02-18 12:31:09'),
('51399a5c-80b0-4f1d-8294-7c25c01e8a76', '51399a5c-6130-4e64-8982-7c25c01e8a76', NULL, '2012-12-21 16.16.02.jpg', NULL, 10, '2013-03-08 14:59:24', '2013-03-08 14:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `photo_albums`
--

DROP TABLE IF EXISTS `photo_albums`;
CREATE TABLE IF NOT EXISTS `photo_albums` (
  `id` char(36) NOT NULL,
  `slug` varchar(125) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(125) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `photo_albums`
--

INSERT INTO `photo_albums` (`id`, `slug`, `title`, `description`, `picture`, `user_id`, `created`, `modified`) VALUES
('5121bc9d-cf60-4f5e-a18a-1b279aef675a', 'gbfgd', 'gbfgd', 'b', NULL, 1, '2013-02-18 12:31:09', '2013-02-18 12:31:09'),
('51399a5c-6130-4e64-8982-7c25c01e8a76', 'tes', 'tes', 'banjir', NULL, 10, '2013-03-08 14:59:24', '2013-03-08 14:59:24');

-- --------------------------------------------------------

--
-- Table structure for table `site_configurations`
--

DROP TABLE IF EXISTS `site_configurations`;
CREATE TABLE IF NOT EXISTS `site_configurations` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(225) DEFAULT NULL,
  `value` varchar(225) DEFAULT NULL,
  `sort` smallint(5) unsigned NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `site_configurations`
--

INSERT INTO `site_configurations` (`id`, `title`, `description`, `value`, `sort`, `modified`) VALUES
(1, 'Email Administrator', 'Email Administrator', 'admin@cafemusisi.com', 1, '2013-02-01 00:00:00'),
(2, 'Name of Email Administrator', 'Name of Email Administrator', 'Administrator', 2, '2013-02-01 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

DROP TABLE IF EXISTS `songs`;
CREATE TABLE IF NOT EXISTS `songs` (
  `id` char(36) NOT NULL,
  `song_album_id` char(36) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `file` varchar(125) NOT NULL DEFAULT '',
  `lyric` text,
  `picture` varchar(125) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_album_id` (`song_album_id`),
  KEY `photo` (`file`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `song_album_id`, `title`, `file`, `lyric`, `picture`, `user_id`, `created`, `modified`) VALUES
('5121dc3b-852c-4a14-82cc-1b259aef675a', '5121dc3b-3178-4f28-b674-1b259aef675a', 's', 'dua.mp3', 's', NULL, 1, '2013-02-18 14:46:03', '2013-02-18 14:46:03'),
('5121dc3b-8c58-4007-a690-1b259aef675a', '5121dc3b-3178-4f28-b674-1b259aef675a', 's', 'asal.mp3', 's', NULL, 1, '2013-02-18 14:46:03', '2013-02-18 14:46:03'),
('5121dc3b-7888-45e0-b93a-1b259aef675a', '5121dc3b-3178-4f28-b674-1b259aef675a', 's', 'satu.mp3', 's', NULL, 1, '2013-02-18 14:46:03', '2013-02-18 14:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `song_albums`
--

DROP TABLE IF EXISTS `song_albums`;
CREATE TABLE IF NOT EXISTS `song_albums` (
  `id` char(36) NOT NULL,
  `slug` varchar(125) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `picture` varchar(125) DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `song_albums`
--

INSERT INTO `song_albums` (`id`, `slug`, `title`, `description`, `user_id`, `picture`, `created`, `modified`) VALUES
('5121dc3b-3178-4f28-b674-1b259aef675a', 'dfgsdfgd', 'dfgsdfgd', 'dsgdfdfdfd', 1, NULL, '2013-02-18 14:46:03', '2013-02-18 14:46:03');

-- --------------------------------------------------------

--
-- Table structure for table `staticpages`
--

DROP TABLE IF EXISTS `staticpages`;
CREATE TABLE IF NOT EXISTS `staticpages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) DEFAULT NULL,
  `page_title` varchar(69) DEFAULT NULL,
  `meta_keyword` varchar(100) DEFAULT NULL,
  `meta_description` varchar(155) DEFAULT NULL,
  `content` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `staticpages`
--

INSERT INTO `staticpages` (`id`, `title`, `page_title`, `meta_keyword`, `meta_description`, `content`, `created`, `modified`) VALUES
(1, 'HOME', 'HOME', 'HOME', 'HOME', '<p>\r\n	Ini adalah halaman home</p>\r\n', '2013-02-01 00:00:00', '2013-02-02 21:44:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '2',
  `name` varchar(50) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `handphone` varchar(16) NOT NULL,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_actived` tinyint(1) NOT NULL DEFAULT '0',
  `is_agree_term_conditions` tinyint(1) NOT NULL,
  `address` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `handphone` (`handphone`),
  UNIQUE KEY `handphone_2` (`handphone`),
  KEY `group_id` (`group_id`),
  KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `group_id`, `name`, `username`, `password`, `email`, `handphone`, `is_verified`, `is_actived`, `is_agree_term_conditions`, `address`, `created`, `modified`) VALUES
(1, 2, 'dfdagd', 'A1s', 'a91498a347233df2d88595df84be39ca85dc6f5d', 'ads@yahoo.com', '3213', 1, 1, 1, 'fdsfasdf', '2013-02-02 19:11:49', '2013-02-24 15:29:53'),
(7, 1, 'Admin', 'admin', 'a91498a347233df2d88595df84be39ca85dc6f5d', 'admin@yahoo.com', 'hp', 1, 1, 1, 'jalan kaki', '2013-02-05 00:00:00', '2013-02-05 00:00:00'),
(8, 2, 'dfas', 'dadah', 'a91498a347233df2d88595df84be39ca85dc6f5d', 'dadah@yahoo.com', 'hape', 1, 1, 1, 'address', '2013-02-07 09:11:11', '2013-02-07 09:11:11'),
(9, 2, 'chqng', 'chung', '27c827caa3e1a28c7fc0e59e2a8d968a7ef6d8f5', 'mail@chung.web.id', '123456789', 0, 1, 1, 'testing', '2013-03-06 10:13:49', '2013-03-06 10:55:41'),
(10, 2, 'tes', 'tes', 'a91498a347233df2d88595df84be39ca85dc6f5d', 'tes@mail.com', '123234', 1, 1, 1, 'tes', '2013-03-08 14:51:40', '2013-03-08 14:56:46');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
CREATE TABLE IF NOT EXISTS `videos` (
  `id` char(36) NOT NULL,
  `video_album_id` char(36) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `file` varchar(125) NOT NULL,
  `description` text,
  `picture` varchar(125) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `photo_album_id` (`video_album_id`),
  KEY `photo` (`file`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `video_album_id`, `title`, `file`, `description`, `picture`, `user_id`, `created`, `modified`) VALUES
('5121e7ab-0e54-400a-8a8e-1b249aef675a', '5121e7ab-8df4-4da1-8edc-1b249aef675a', 'aaaaa', 'dua.avi', 'aaaaa aaaaa aaaaa aaaaa', NULL, 1, '2013-02-18 15:34:51', '2013-02-18 15:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `video_albums`
--

DROP TABLE IF EXISTS `video_albums`;
CREATE TABLE IF NOT EXISTS `video_albums` (
  `id` char(36) NOT NULL,
  `slug` varchar(125) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(125) DEFAULT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`),
  UNIQUE KEY `slug` (`slug`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_albums`
--

INSERT INTO `video_albums` (`id`, `slug`, `title`, `description`, `picture`, `user_id`, `created`, `modified`) VALUES
('5121e7ab-8df4-4da1-8edc-1b249aef675a', 'fg', 'fg', 'dsgfds', NULL, 1, '2013-02-18 15:34:51', '2013-02-18 15:35:12');

-- --------------------------------------------------------

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
CREATE TABLE IF NOT EXISTS `votes` (
  `id` char(36) NOT NULL,
  `type` char(1) NOT NULL,
  `module_id` char(36) NOT NULL,
  `user_id` bigint(20) unsigned NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `module_id_2` (`module_id`,`user_id`),
  KEY `type` (`type`),
  KEY `module_id` (`module_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `votes`
--

INSERT INTO `votes` (`id`, `type`, `module_id`, `user_id`, `created`) VALUES
('35945a64-79a1-11e2-a194-485b395a1bf2', '1', 'A1', 1, '0000-00-00 00:00:00'),
('359488d6-79a1-11e2-a194-485b395a1bf2', '1', 'A2', 2, '0000-00-00 00:00:00'),
('76087ab2-79a1-11e2-a194-485b395a1bf2', '1', 'A1', 2, '0000-00-00 00:00:00'),
('7608a8b6-79a1-11e2-a194-485b395a1bf2', '1', 'A3', 3, '0000-00-00 00:00:00'),
('51323f52-6768-4892-828c-06d89aef675a', '', '', 0, '2013-03-03 01:05:06'),
('51324352-3834-4889-a198-06d89aef675a', '1', '5121e7ab-0e54-400a-8a8e-1b249aef675a', 8, '2013-03-03 01:22:10');

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_streamlines`
--
DROP VIEW IF EXISTS `v_streamlines`;
CREATE TABLE IF NOT EXISTS `v_streamlines` (
`id` char(36)
,`module` varchar(12)
,`slug` varchar(125)
,`title` varchar(100)
,`content` text
,`user_id` bigint(20)
,`created` datetime
,`modified` datetime
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_top_comments`
--
DROP VIEW IF EXISTS `v_top_comments`;
CREATE TABLE IF NOT EXISTS `v_top_comments` (
`id` char(36)
,`qty` bigint(21)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `v_top_votes`
--
DROP VIEW IF EXISTS `v_top_votes`;
CREATE TABLE IF NOT EXISTS `v_top_votes` (
`id` char(36)
,`vote` bigint(21)
);
-- --------------------------------------------------------

--
-- Structure for view `v_streamlines`
--
DROP TABLE IF EXISTS `v_streamlines`;

CREATE ALGORITHM=UNDEFINED DEFINER=`kafemusi`@`localhost` SQL SECURITY DEFINER VIEW `v_streamlines` AS select `articles`.`id` AS `id`,'articles' AS `module`,`articles`.`slug` AS `slug`,`articles`.`title` AS `title`,`articles`.`text` AS `content`,`articles`.`user_id` AS `user_id`,`articles`.`created` AS `created`,`articles`.`modified` AS `modified` from `articles` union select `events`.`id` AS `id`,'events' AS `module`,`events`.`slug` AS `slug`,`events`.`title` AS `title`,`events`.`file` AS `content`,`events`.`user_id` AS `user_id`,`events`.`created` AS `created`,`events`.`modified` AS `modified` from `events` union select `photo_albums`.`id` AS `id`,'photo_albums' AS `module`,`photo_albums`.`slug` AS `slug`,`photo_albums`.`title` AS `title`,`photo_albums`.`description` AS `content`,`photo_albums`.`user_id` AS `user_id`,`photo_albums`.`created` AS `created`,`photo_albums`.`modified` AS `modified` from `photo_albums` union select `song_albums`.`id` AS `id`,'song_albums' AS `module`,`song_albums`.`slug` AS `slug`,`song_albums`.`title` AS `title`,`song_albums`.`description` AS `content`,`song_albums`.`user_id` AS `user_id`,`song_albums`.`created` AS `created`,`song_albums`.`modified` AS `modified` from `song_albums` union select `video_albums`.`id` AS `id`,'video_albums' AS `module`,`video_albums`.`slug` AS `slug`,`video_albums`.`title` AS `title`,`video_albums`.`description` AS `content`,`video_albums`.`user_id` AS `user_id`,`video_albums`.`created` AS `created`,`video_albums`.`modified` AS `modified` from `video_albums`;

-- --------------------------------------------------------

--
-- Structure for view `v_top_comments`
--
DROP TABLE IF EXISTS `v_top_comments`;

CREATE ALGORITHM=UNDEFINED DEFINER=`kafemusi`@`localhost` SQL SECURITY DEFINER VIEW `v_top_comments` AS select `comments`.`module_id` AS `id`,count(`comments`.`id`) AS `qty` from `comments` group by `comments`.`module_id`;

-- --------------------------------------------------------

--
-- Structure for view `v_top_votes`
--
DROP TABLE IF EXISTS `v_top_votes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`kafemusi`@`localhost` SQL SECURITY DEFINER VIEW `v_top_votes` AS select `votes`.`module_id` AS `id`,count(`votes`.`id`) AS `vote` from `votes` group by `votes`.`module_id`;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
