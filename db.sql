-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 17, 2011 at 10:26 AM
-- Server version: 5.0.91
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `toolszon_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `account_id` int(6) NOT NULL auto_increment,
  `acctype` varchar(30) NOT NULL,
  `country` varchar(30) NOT NULL,
  `info` varchar(150) NOT NULL,
  `addinfo` varchar(150) NOT NULL,
  `login` varchar(150) NOT NULL,
  `pass` varchar(150) NOT NULL,
  `sold` int(1) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `date_added` varchar(30) NOT NULL,
  `valid_system` varchar(10) NOT NULL,
  `valid_user` varchar(10) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `date_purchased` varchar(30) NOT NULL,
  PRIMARY KEY  (`account_id`),
  UNIQUE KEY `account_id` (`account_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=167 ;

-- --------------------------------------------------------

--
-- Table structure for table `cards`
--

CREATE TABLE IF NOT EXISTS `cards` (
  `card_id` int(6) NOT NULL auto_increment,
  `number` varchar(30) NOT NULL,
  `expire` varchar(10) NOT NULL,
  `cvv` varchar(10) NOT NULL,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `address` varchar(50) NOT NULL,
  `city` varchar(30) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `card_type` varchar(20) NOT NULL,
  `dob` varchar(30) NOT NULL,
  `sold` int(1) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `date_added` varchar(30) NOT NULL,
  `valid_system` varchar(10) NOT NULL,
  `valid_user` varchar(10) NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `date_purchased` varchar(30) NOT NULL,
  `ssn` varchar(40) NOT NULL,
  PRIMARY KEY  (`card_id`),
  UNIQUE KEY `card_id` (`card_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE IF NOT EXISTS `cart` (
  `card_id` int(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `charge_bin` tinyint(4) NOT NULL,
  `charge_zip` tinyint(4) NOT NULL,
  `charge_city` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checkerapi`
--

CREATE TABLE IF NOT EXISTS `checkerapi` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `ip` varchar(999) NOT NULL,
  `last_payment_date` varchar(30) NOT NULL,
  `amountchecked` int(6) NOT NULL,
  `invalidtimes` int(9) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `checkercards`
--

CREATE TABLE IF NOT EXISTS `checkercards` (
  `cardid` int(6) NOT NULL auto_increment,
  `number` varchar(50) NOT NULL,
  `expire` varchar(10) NOT NULL,
  `cvv` int(5) NOT NULL,
  `username` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY  (`cardid`),
  UNIQUE KEY `cardid` (`cardid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6819 ;

-- --------------------------------------------------------

--
-- Table structure for table `checkerhistory`
--

CREATE TABLE IF NOT EXISTS `checkerhistory` (
  `id` int(6) NOT NULL auto_increment,
  `number` varchar(50) NOT NULL,
  `date` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4674 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `msgid` int(6) NOT NULL,
  `username` varchar(30) NOT NULL,
  `subject` varchar(500) NOT NULL,
  `message` text NOT NULL,
  `viewed` tinyint(1) NOT NULL,
  `touser` varchar(30) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY  (`msgid`),
  UNIQUE KEY `msgid` (`msgid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `newsid` int(11) NOT NULL auto_increment,
  `subject` varchar(400) NOT NULL,
  `message` mediumtext NOT NULL,
  `type` varchar(40) NOT NULL,
  `time` varchar(40) NOT NULL,
  PRIMARY KEY  (`newsid`),
  UNIQUE KEY `newsid` (`newsid`),
  KEY `newsid_2` (`newsid`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=67 ;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(6) NOT NULL auto_increment,
  `amount` decimal(10,2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `lrpaidby` varchar(30) NOT NULL,
  `lrtrans` varchar(50) NOT NULL,
  `wmid` varchar(30) NOT NULL,
  `wmextra` varchar(30) NOT NULL,
  `ip` varchar(30) NOT NULL,
  `state` varchar(20) NOT NULL,
  `date` varchar(30) NOT NULL,
  PRIMARY KEY  (`order_id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=981 ;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE IF NOT EXISTS `purchases` (
  `purchase_id` int(6) NOT NULL auto_increment,
  `amount` decimal(10,2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL,
  `before_balance` decimal(10,2) NOT NULL,
  `after_balance` decimal(10,2) NOT NULL,
  PRIMARY KEY  (`purchase_id`),
  UNIQUE KEY `purchase_id` (`purchase_id`),
  KEY `purchase_id_2` (`purchase_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3324 ;

-- --------------------------------------------------------

--
-- Table structure for table `referral`
--

CREATE TABLE IF NOT EXISTS `referral` (
  `username` varchar(30) NOT NULL,
  `referrals` int(6) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `refunds`
--

CREATE TABLE IF NOT EXISTS `refunds` (
  `card_id` int(6) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `username` varchar(30) NOT NULL,
  `date` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE IF NOT EXISTS `settings` (
  `shop_online` tinyint(1) NOT NULL,
  `registration` tinyint(4) NOT NULL,
  `autorefunds` tinyint(1) NOT NULL,
  `validrateeu` tinyint(3) NOT NULL,
  `validrateus` tinyint(3) NOT NULL,
  `checker_invalids` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`shop_online`, `registration`, `autorefunds`, `validrateeu`, `validrateus`, `checker_invalids`) VALUES
(1, 1, 1, 90, 90, 0),
(1, 1, 1, 90, 90, 0),
(1, 1, 1, 90, 90, 0),
(1, 1, 1, 90, 90, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE IF NOT EXISTS `tickets` (
  `id` int(6) NOT NULL auto_increment,
  `subject` varchar(250) NOT NULL,
  `message` text NOT NULL,
  `date` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `status` varchar(30) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `icq` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `ips` text NOT NULL,
  `regdate` varchar(30) NOT NULL,
  `lastlogin` varchar(30) NOT NULL,
  `failedlogin` int(30) NOT NULL,
  `balance` decimal(10,2) NOT NULL,
  `checkercredits` int(11) NOT NULL,
  `lastip` varchar(30) NOT NULL,
  `amount_purchased` int(6) NOT NULL,
  `amount_refunds` int(6) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `banned` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `icq`, `email`, `ips`, `regdate`, `lastlogin`, `failedlogin`, `balance`, `checkercredits`, `lastip`, `amount_purchased`, `amount_refunds`, `admin`, `banned`) VALUES
('administrator', '6fc6768c5be17a3d7aff878ce098d163', '123456', 'administrator@sh0p.in', '41.155.20.61', '2011-10-01 23:03:49', '2011-10-17 09:24:10', 0, '0.00', 0, '41.155.8.231', 0, 0, 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
