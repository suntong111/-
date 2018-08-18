/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1_3306
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : shop

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2018-08-18 14:57:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `shop_address`
-- ----------------------------
DROP TABLE IF EXISTS `shop_address`;
CREATE TABLE `shop_address` (
  `addressid` bigint(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(32) DEFAULT NULL,
  `lastname` varchar(32) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `address` text,
  `postcode` char(6) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `userid` bigint(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`addressid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_address
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_admin`
-- ----------------------------
DROP TABLE IF EXISTS `shop_admin`;
CREATE TABLE `shop_admin` (
  `adminid` int(11) NOT NULL AUTO_INCREMENT,
  `adminuser` varchar(32) DEFAULT NULL,
  `adminpass` char(32) DEFAULT NULL,
  `adminemail` varchar(50) DEFAULT NULL,
  `logintime` int(11) DEFAULT NULL,
  `loginip` bigint(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`adminid`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_admin
-- ----------------------------
INSERT INTO `shop_admin` VALUES ('1', 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 'stloveywj@163.com', '1534411227', '2130706433', null);
INSERT INTO `shop_admin` VALUES ('9', 'admin', 'd81f9c1be2e08964bf9f24b15f0e4900', '12322@qq.com', '1534411227', '2130706433', null);
INSERT INTO `shop_admin` VALUES ('4', 'admin156', '202cb962ac59075b964b07152d234b70', 'stloveywewj@163.com', '1533173685', '2130706433', null);
INSERT INTO `shop_admin` VALUES ('5', 'admin1563', '202cb962ac59075b964b07152d234b70', '12e3@qq.com', null, null, null);
INSERT INTO `shop_admin` VALUES ('6', 'adminrero', '202cb962ac59075b964b07152d234b70', '1234@qq.com', null, null, null);
INSERT INTO `shop_admin` VALUES ('7', 'adminrer1', '76d80224611fc919a5d54f0ff9fba446', '5926918588@qq.com', null, null, null);
INSERT INTO `shop_admin` VALUES ('10', 'wqeq', 'd81f9c1be2e08964bf9f24b15f0e4900', '345@qq.com', null, null, null);
INSERT INTO `shop_admin` VALUES ('11', 'admin', 'd81f9c1be2e08964bf9f24b15f0e4900', '123@qq.com', null, null, null);

-- ----------------------------
-- Table structure for `shop_cart`
-- ----------------------------
DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE `shop_cart` (
  `cartid` bigint(11) NOT NULL AUTO_INCREMENT,
  `productid` bigint(11) DEFAULT NULL,
  `productnum` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `userid` bigint(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`cartid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_cart
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_category`
-- ----------------------------
DROP TABLE IF EXISTS `shop_category`;
CREATE TABLE `shop_category` (
  `cateid` bigint(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) DEFAULT NULL,
  `parentid` bigint(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`cateid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_category
-- ----------------------------
INSERT INTO `shop_category` VALUES ('2', '衣服', '0', '1533362657');
INSERT INTO `shop_category` VALUES ('3', '袜子', '0', '1533362672');
INSERT INTO `shop_category` VALUES ('4', '丝袜', '3', '1533362693');

-- ----------------------------
-- Table structure for `shop_order`
-- ----------------------------
DROP TABLE IF EXISTS `shop_order`;
CREATE TABLE `shop_order` (
  `orderid` bigint(11) NOT NULL AUTO_INCREMENT,
  `userid` bigint(11) DEFAULT NULL,
  `addressid` bigint(11) DEFAULT NULL,
  `amount` decimal(10,0) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `expressno` varchar(50) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `updatetime` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `tradeno` varchar(100) DEFAULT NULL,
  `tradeext` text,
  PRIMARY KEY (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_order
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_order_detail`
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail`;
CREATE TABLE `shop_order_detail` (
  `detailid` bigint(11) NOT NULL AUTO_INCREMENT,
  `productid` bigint(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `productnum` int(11) DEFAULT NULL,
  `orderid` bigint(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detailid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_order_detail
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_product`
-- ----------------------------
DROP TABLE IF EXISTS `shop_product`;
CREATE TABLE `shop_product` (
  `productid` bigint(11) NOT NULL AUTO_INCREMENT,
  `cateid` bigint(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `descr` text,
  `num` bigint(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `cover` varchar(200) DEFAULT NULL,
  `pics` text,
  `issale` enum('') DEFAULT NULL,
  `saleprice` decimal(10,0) DEFAULT NULL,
  `ishot` enum('') DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `ison` varchar(200) DEFAULT NULL,
  `istui` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_product
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_profile`
-- ----------------------------
DROP TABLE IF EXISTS `shop_profile`;
CREATE TABLE `shop_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `truename` varchar(32) DEFAULT NULL,
  `age` tinyint(11) DEFAULT NULL,
  `sex` enum('') DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `nickname` varchar(32) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_profile
-- ----------------------------

-- ----------------------------
-- Table structure for `shop_user`
-- ----------------------------
DROP TABLE IF EXISTS `shop_user`;
CREATE TABLE `shop_user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `userpass` char(32) DEFAULT NULL,
  `useremail` varchar(100) DEFAULT NULL,
  `createtime` int(11) DEFAULT NULL,
  `openid` char(32) DEFAULT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of shop_user
-- ----------------------------
INSERT INTO `shop_user` VALUES ('1', 'eqwe q', '202cb962ac59075b964b07152d234b70', '592691858@qq.com', '1533194233', null);
