-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 16, 2018 at 02:22 PM
-- Server version: 5.7.21
-- PHP Version: 5.6.35

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `myutar`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail_entry`
--

DROP TABLE IF EXISTS `audit_trail_entry`;
CREATE TABLE IF NOT EXISTS `audit_trail_entry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_type` varchar(255) NOT NULL,
  `happened_at` int(11) NOT NULL,
  `foreign_pk` varchar(255) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `IN_audit_trail_entry_fast_access` (`model_type`,`happened_at`),
  KEY `FK_audit_trail_entry_user` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `audit_trail_entry`
--

INSERT INTO `audit_trail_entry` (`id`, `model_type`, `happened_at`, `foreign_pk`, `user_id`, `type`, `data`) VALUES
(1, 'app\\modules\\announcement\\models\\Notification', 1534420481, '{\"id\":18}', 'superadmin', 'insert', '[{\"attr\":\"id\",\"from\":null,\"to\":18},{\"attr\":\"title\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"description\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"image\",\"from\":null,\"to\":\",superadmin-08-16-2018.jpeg\"},{\"attr\":\"dId\",\"from\":null,\"to\":\"superadmin\"}]'),
(2, 'app\\modules\\announcement\\models\\Notification', 1534420539, '{\"id\":19}', 'superadmin', 'insert', '[{\"attr\":\"id\",\"from\":null,\"to\":19},{\"attr\":\"title\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"description\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"image\",\"from\":null,\"to\":\"Conceptual ER Diagram.jpg\"},{\"attr\":\"dId\",\"from\":null,\"to\":\"superadmin\"}]'),
(3, 'app\\modules\\announcement\\models\\Event', 1534420708, '{\"id\":19}', 'superadmin', 'delete', NULL),
(4, 'app\\modules\\announcement\\models\\Event', 1534420727, '{\"id\":20}', 'superadmin', 'insert', '[{\"attr\":\"id\",\"from\":null,\"to\":20},{\"attr\":\"title\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"venue\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"time\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"startDate\",\"from\":null,\"to\":\"2018-08-28\"},{\"attr\":\"endDate\",\"from\":null,\"to\":\"2018-08-29\"},{\"attr\":\"fee\",\"from\":null,\"to\":\"100\"},{\"attr\":\"type\",\"from\":null,\"to\":\"Competition\"},{\"attr\":\"description\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"image\",\"from\":null,\"to\":\"Conceptual ER Diagram.jpg\"},{\"attr\":\"dId\",\"from\":null,\"to\":\"superadmin\"}]'),
(5, 'app\\modules\\announcement\\models\\Event', 1534420825, '{\"id\":21}', 'superadmin', 'insert', '[{\"attr\":\"id\",\"from\":null,\"to\":21},{\"attr\":\"title\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"venue\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"time\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"startDate\",\"from\":null,\"to\":\"2018-08-31\"},{\"attr\":\"endDate\",\"from\":null,\"to\":\"2018-08-31\"},{\"attr\":\"fee\",\"from\":null,\"to\":\"199\"},{\"attr\":\"type\",\"from\":null,\"to\":\"Competition\"},{\"attr\":\"description\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"image\",\"from\":null,\"to\":\"Conceptual ER Diagram.jpg\"},{\"attr\":\"attachment\",\"from\":null,\"to\":\"1.4.3_Observations.docx\"},{\"attr\":\"dId\",\"from\":null,\"to\":\"superadmin\"}]'),
(6, 'app\\modules\\announcement\\models\\Event', 1534420982, '{\"id\":22}', 'thamvh', 'insert', '[{\"attr\":\"id\",\"from\":null,\"to\":22},{\"attr\":\"title\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"venue\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"time\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"startDate\",\"from\":null,\"to\":\"2018-08-27\"},{\"attr\":\"endDate\",\"from\":null,\"to\":\"2018-08-27\"},{\"attr\":\"fee\",\"from\":null,\"to\":\"100\"},{\"attr\":\"type\",\"from\":null,\"to\":\"Others\"},{\"attr\":\"description\",\"from\":null,\"to\":\"Test\"},{\"attr\":\"image\",\"from\":null,\"to\":\"Conceptual ER Diagram.jpg\"},{\"attr\":\"attachment\",\"from\":null,\"to\":\"backup.json\"},{\"attr\":\"dId\",\"from\":null,\"to\":\"DME\"}]'),
(7, 'app\\modules\\announcement\\models\\Notification', 1534424272, '{\"id\":19}', 'thamvh', 'update', '[{\"attr\":\"status\",\"from\":0,\"to\":1}]'),
(8, 'app\\modules\\announcement\\models\\Notification', 1534424274, '{\"id\":19}', 'thamvh', 'delete', NULL),
(9, 'app\\modules\\announcement\\models\\Notification', 1534424276, '{\"id\":18}', 'thamvh', 'update', '[{\"attr\":\"status\",\"from\":0,\"to\":1}]'),
(10, 'app\\modules\\announcement\\models\\Notification', 1534424278, '{\"id\":18}', 'thamvh', 'delete', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
