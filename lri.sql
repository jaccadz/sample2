-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2016 at 04:18 PM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lri`
--
CREATE DATABASE IF NOT EXISTS `lri` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `lri`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `add_id` int(5) NOT NULL AUTO_INCREMENT,
  `add_person` varchar(100) NOT NULL,
  `add_houseNo` varchar(10) NOT NULL,
  `add_building` varchar(30) NOT NULL DEFAULT ' ',
  `add_street` varchar(50) NOT NULL,
  `add_brgySubd` varchar(30) NOT NULL,
  `add_city` varchar(30) NOT NULL,
  `user_id` int(4) NOT NULL,
  PRIMARY KEY (`add_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`add_id`, `add_person`, `add_houseNo`, `add_building`, `add_street`, `add_brgySubd`, `add_city`, `user_id`) VALUES
(1, 'Dizon, Brezelle', '48', ' ', 'Marigold St.', 'Ladislawa Village', 'Davao City', 2);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `cat_id` int(4) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) NOT NULL,
  `cat_status` varchar(12) NOT NULL DEFAULT 'Available',
  PRIMARY KEY (`cat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_status`) VALUES
(1, 'Meal', 'Available'),
(2, 'Pasta', 'Available'),
(3, 'Salad', 'Available'),
(4, 'Drinks', 'Available'),
(5, 'Wines', 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `ord_id` int(10) NOT NULL AUTO_INCREMENT,
  `ord_deliver_to` varchar(200) NOT NULL,
  `ord_billing_to` varchar(200) NOT NULL,
  `ord_grandTotal` decimal(30,2) NOT NULL,
  `ord_datePlace` datetime NOT NULL,
  `ord_status` varchar(20) NOT NULL DEFAULT 'On placed',
  `user_id` int(4) NOT NULL,
  PRIMARY KEY (`ord_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ord_id`, `ord_deliver_to`, `ord_billing_to`, `ord_grandTotal`, `ord_datePlace`, `ord_status`, `user_id`) VALUES
(1, 'Dizon, Brezelle  @  48   Marigold St. Ladislawa Village Davao City', 'Dizon, Brezelle  @  48   Marigold St. Ladislawa Village Davao City', '280.00', '2014-01-22 01:30:07', 'On delivery', 2);

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE IF NOT EXISTS `order_details` (
  `ordDet_id` int(10) NOT NULL AUTO_INCREMENT,
  `ordDet_qty` int(30) NOT NULL,
  `ordDet_subTotal` decimal(30,2) NOT NULL,
  `prd_id` int(4) NOT NULL,
  `ord_id` int(4) NOT NULL,
  PRIMARY KEY (`ordDet_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`ordDet_id`, `ordDet_qty`, `ordDet_subTotal`, `prd_id`, `ord_id`) VALUES
(1, 1, '250.00', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `prd_id` int(4) NOT NULL AUTO_INCREMENT,
  `prd_name` varchar(50) NOT NULL,
  `prd_price` decimal(5,2) NOT NULL,
  `prd_desc` varchar(255) NOT NULL,
  `prd_imgLoc` varchar(60) NOT NULL,
  `prd_status` varchar(12) NOT NULL DEFAULT 'Available',
  `cat_id` int(4) NOT NULL,
  PRIMARY KEY (`prd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`prd_id`, `prd_name`, `prd_price`, `prd_desc`, `prd_imgLoc`, `prd_status`, `cat_id`) VALUES
(1, 'Italian''s Omelet', '99.99', 'This omelet is simply delicious with fresh tomato, basil, and Land O Lakes® All-Natural Eggs!', 'resources/uploads/99d9c7d8cd.jpg', 'Available', 1),
(2, 'Flowered Italian Salad', '250.00', 'A salad that bursts in your mouth. It is made out of different fresh fruits, that may help your health.', 'resources/uploads/2b6857c386.jpg', 'Available', 3),
(3, 'Italian Pasta 101', '340.50', 'Special recipe of La Ristorani Restaurant. Made in special pasta with mouth bursting sauce.', 'resources/uploads/b995dada23.jpg', 'Available', 2),
(4, 'Carbone''s Caesar Salad', '175.00', 'Made in fresh lettuce with delizioso dressing made in Italy.', 'resources/uploads/37ec6a329b.jpg', 'Available', 3),
(5, 'Sour cream pancake', '70.00', 'Sour cream is the special ingredient that makes these pancakes light, fluffy and tender for breakfast or anytime of the day.', 'resources/uploads/e82f6a8354.jpg', 'Available', 1),
(6, 'Barolo Villero', '999.99', 'The most popular italian wine.', 'resources/uploads/8d1ec594c6.jpg', 'Available', 5),
(7, 'Limoncello Lemonade', '150.00', 'The limoncello liqueur is a very Italian flavor and blended with ice it becomes a delicious slushie.', 'resources/uploads/f4f19c92f4.jpg', 'Available', 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(4) NOT NULL AUTO_INCREMENT,
  `user_lname` varchar(30) DEFAULT NULL,
  `user_fname` varchar(30) DEFAULT NULL,
  `user_mname` varchar(30) DEFAULT 'Not set',
  `user_gender` varchar(6) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_mobile` varchar(12) DEFAULT NULL,
  `user_landline` varchar(7) DEFAULT NULL,
  `user_username` varchar(15) DEFAULT NULL,
  `user_pass` varchar(30) DEFAULT NULL,
  `user_dateReg` date DEFAULT NULL,
  `user_type` varchar(10) DEFAULT 'Customer',
  `user_status` int(2) DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_lname`, `user_fname`, `user_mname`, `user_gender`, `user_email`, `user_mobile`, `user_landline`, `user_username`, `user_pass`, `user_dateReg`, `user_type`, `user_status`) VALUES
(1, 'Cadelina', 'Jacob', 'Ladanan', 'Male', 'jcadelina@umindanao.edu.ph', NULL, NULL, 'admin', 'admin', NULL, 'Admin', 1),
(2, 'Dizons', 'Brezelle', 'Deles', 'Female', 'zelled@ymail.com', '09127784938', '3001212', 'zelled', 'pangit12', '2014-01-21', 'Customer', 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
