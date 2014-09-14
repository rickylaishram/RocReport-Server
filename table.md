## Tables

	# ************************************************************
	# Generation Time: 2014-09-14 00:16:10 +0000
	# ************************************************************


	/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
	/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
	/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
	/*!40101 SET NAMES utf8 */;
	/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
	/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
	/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


	# Dump of table admin
	# ------------------------------------------------------------

	CREATE TABLE `admin` (
	  `id` int(11) NOT NULL,
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `country` varchar(50) NOT NULL DEFAULT '',
	  `admin_level_1` varchar(100) NOT NULL DEFAULT '',
	  `admin_level_2` varchar(100) NOT NULL DEFAULT '',
	  `sublocality` varchar(100) NOT NULL DEFAULT '',
	  `email` varchar(50) NOT NULL DEFAULT '',
	  UNIQUE KEY `id` (`id`),
	  KEY `email` (`email`),
	  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table api_requests
	# ------------------------------------------------------------

	CREATE TABLE `api_requests` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `client_id` varchar(100) NOT NULL DEFAULT '',
	  `time` int(11) NOT NULL,
	  `method` varchar(50) NOT NULL DEFAULT '',
	  `ip` varchar(50) NOT NULL DEFAULT '',
	  PRIMARY KEY (`id`),
	  KEY `client_id` (`client_id`),
	  CONSTRAINT `api_requests_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `client` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table bid
	# ------------------------------------------------------------

	CREATE TABLE `bid` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `report_id` int(11) NOT NULL,
	  `email` varchar(50) NOT NULL DEFAULT '',
	  `amount` int(11) NOT NULL,
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `duration` int(11) NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `report_id` (`report_id`),
	  KEY `email` (`email`),
	  CONSTRAINT `bid_ibfk_3` FOREIGN KEY (`email`) REFERENCES `contractor` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `bid_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`) ON UPDATE CASCADE,
	  CONSTRAINT `bid_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table categories
	# ------------------------------------------------------------

	CREATE TABLE `categories` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `name` varchar(20) NOT NULL DEFAULT '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table client
	# ------------------------------------------------------------

	CREATE TABLE `client` (
	  `id` varchar(100) NOT NULL DEFAULT '',
	  `name` varchar(20) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `contact` varchar(50) NOT NULL DEFAULT '',
	  `rate_limit` int(11) DEFAULT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table contractor
	# ------------------------------------------------------------

	CREATE TABLE `contractor` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `email` varchar(50) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `latitude` double NOT NULL,
	  `longitude` double NOT NULL,
	  `radius` int(11) NOT NULL,
	  `score_total` float NOT NULL,
	  `score_month_1` float NOT NULL,
	  `score_month_2` float NOT NULL,
	  `score_month_3` float NOT NULL,
	  `score_month_4` float NOT NULL,
	  `score_month_5` float NOT NULL,
	  `category` int(11) unsigned NOT NULL,
	  PRIMARY KEY (`id`),
	  KEY `email` (`email`),
	  KEY `category` (`category`),
	  CONSTRAINT `contractor_ibfk_2` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON UPDATE CASCADE,
	  CONSTRAINT `contractor_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table image
	# ------------------------------------------------------------

	CREATE TABLE `image` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `filename` varchar(100) NOT NULL DEFAULT '',
	  `email` varchar(50) NOT NULL DEFAULT '',
	  `client` varchar(100) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `server` varchar(10000) NOT NULL DEFAULT '',
	  PRIMARY KEY (`id`),
	  KEY `filename` (`filename`),
	  KEY `email` (`email`),
	  KEY `client` (`client`),
	  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `image_ibfk_2` FOREIGN KEY (`client`) REFERENCES `client` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table rating_contractor
	# ------------------------------------------------------------

	CREATE TABLE `rating_contractor` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `contractor_email` varchar(50) NOT NULL DEFAULT '',
	  `user_email` varchar(50) NOT NULL DEFAULT '',
	  `score` int(11) NOT NULL,
	  `comment` varchar(200) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`),
	  KEY `contractor_email` (`contractor_email`),
	  KEY `user_email` (`user_email`),
	  CONSTRAINT `rating_contractor_ibfk_3` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `rating_contractor_ibfk_1` FOREIGN KEY (`contractor_email`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `rating_contractor_ibfk_2` FOREIGN KEY (`contractor_email`) REFERENCES `contractor` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table rating_user
	# ------------------------------------------------------------

	CREATE TABLE `rating_user` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `contractor_email` varchar(50) NOT NULL DEFAULT '',
	  `user_email` varchar(50) NOT NULL DEFAULT '',
	  `score` int(11) NOT NULL,
	  `comment` varchar(200) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  PRIMARY KEY (`id`),
	  KEY `contractor_email` (`contractor_email`),
	  KEY `user_email` (`user_email`),
	  CONSTRAINT `rating_user_ibfk_3` FOREIGN KEY (`user_email`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `rating_user_ibfk_1` FOREIGN KEY (`contractor_email`) REFERENCES `contractor` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `rating_user_ibfk_2` FOREIGN KEY (`contractor_email`) REFERENCES `user` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table report
	# ------------------------------------------------------------

	CREATE TABLE `report` (
	  `formatted_address` varchar(100) NOT NULL DEFAULT '',
	  `country` varchar(100) NOT NULL DEFAULT '',
	  `admin_area_level_1` varchar(100) NOT NULL DEFAULT '',
	  `admin_area_level_2` varchar(100) NOT NULL DEFAULT '',
	  `sublocality` varchar(100) NOT NULL DEFAULT '',
	  `latitude` double NOT NULL,
	  `longitude` double NOT NULL,
	  `report_id` int(11) NOT NULL AUTO_INCREMENT,
	  `category` int(11) unsigned NOT NULL,
	  `description` varchar(120) NOT NULL DEFAULT '',
	  `email` varchar(50) NOT NULL DEFAULT '',
	  `picture` varchar(100) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `score` float NOT NULL DEFAULT '0',
	  `closed` tinyint(4) NOT NULL DEFAULT '0',
	  PRIMARY KEY (`report_id`),
	  KEY `email` (`email`),
	  KEY `category` (`category`),
	  KEY `picture` (`picture`),
	  CONSTRAINT `report_ibfk_2` FOREIGN KEY (`picture`) REFERENCES `image` (`filename`) ON DELETE CASCADE,
	  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`category`) REFERENCES `categories` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table superadmin
	# ------------------------------------------------------------

	CREATE TABLE `superadmin` (
	  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	  `email` varchar(50) NOT NULL DEFAULT '',
	  PRIMARY KEY (`id`),
	  KEY `email` (`email`),
	  CONSTRAINT `superadmin_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table token
	# ------------------------------------------------------------

	CREATE TABLE `token` (
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `client` varchar(50) NOT NULL DEFAULT '',
	  `token` varchar(100) NOT NULL DEFAULT '',
	  `email` varchar(50) NOT NULL DEFAULT '',
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY (`id`),
	  KEY `email` (`email`),
	  KEY `client` (`client`),
	  CONSTRAINT `token_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `token_ibfk_1` FOREIGN KEY (`client`) REFERENCES `client` (`id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table update
	# ------------------------------------------------------------

	CREATE TABLE `update` (
	  `update_id` int(11) NOT NULL AUTO_INCREMENT,
	  `report_id` int(11) NOT NULL,
	  `description` varchar(500) NOT NULL DEFAULT '',
	  `updated_by` varchar(50) NOT NULL DEFAULT '',
	  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `status` varchar(20) NOT NULL DEFAULT '',
	  PRIMARY KEY (`update_id`),
	  KEY `report_id` (`report_id`),
	  KEY `updated_by` (`updated_by`),
	  CONSTRAINT `update_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `update_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table user
	# ------------------------------------------------------------

	CREATE TABLE `user` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `email` varchar(50) NOT NULL DEFAULT '',
	  `name` varchar(50) NOT NULL DEFAULT '',
	  `password` varchar(200) NOT NULL DEFAULT '',
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `verified` tinyint(4) NOT NULL DEFAULT '0',
	  `salt` varchar(50) NOT NULL DEFAULT '',
	  PRIMARY KEY (`id`),
	  KEY `email` (`email`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table vote
	# ------------------------------------------------------------

	CREATE TABLE `vote` (
	  `vote_id` int(11) NOT NULL AUTO_INCREMENT,
	  `report_id` int(11) NOT NULL,
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `email` varchar(100) NOT NULL DEFAULT '',
	  PRIMARY KEY (`vote_id`),
	  UNIQUE KEY `report_id_2` (`report_id`,`email`),
	  KEY `report_id` (`report_id`),
	  KEY `email` (`email`),
	  CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE,
	  CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;



	# Dump of table watchlist
	# ------------------------------------------------------------

	CREATE TABLE `watchlist` (
	  `inform_id` int(11) NOT NULL AUTO_INCREMENT,
	  `report_id` int(11) NOT NULL,
	  `added_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	  `email` varchar(50) NOT NULL DEFAULT '',
	  PRIMARY KEY (`inform_id`),
	  UNIQUE KEY `report_id_2` (`report_id`,`email`),
	  KEY `report_id` (`report_id`),
	  KEY `email` (`email`),
	  CONSTRAINT `watchlist_ibfk_2` FOREIGN KEY (`report_id`) REFERENCES `report` (`report_id`) ON UPDATE CASCADE,
	  CONSTRAINT `watchlist_ibfk_1` FOREIGN KEY (`email`) REFERENCES `user` (`email`) ON UPDATE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;




	/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
	/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
	/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
	/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
	/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
	/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
