-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 30, 2013 at 12:13 AM
-- Server version: 5.1.44
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `jq_invoice`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemCode` varchar(255) NOT NULL,
  `qtyOnHand` int(11) NOT NULL,
  `itemDesc` varchar(255) NOT NULL,
  `itemPrice` double NOT NULL,
  `itemRetail` varchar(255) NOT NULL,
  `itemWholesale` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `itemCode`, `qtyOnHand`, `itemDesc`, `itemPrice`, `itemRetail`, `itemWholesale`) VALUES
(1, '1000', 99, 'Widget', 100.5, '150.77', '55.99'),
(2, '1001', 15, 'Red Hat', 25.02, '28.00', '15.00'),
(7, '1003', 67, 'ioPad with Cover', 300.18, '400.00', '200.00'),
(8, '1004', 21, 'Touch Screen Monitor', 150.99, '233.00', '114.88');
