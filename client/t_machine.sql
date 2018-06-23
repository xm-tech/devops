/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : supergirlserver

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2016-06-28 00:44:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `t_machine`
-- ----------------------------
DROP TABLE IF EXISTS `t_machine`;
CREATE TABLE `t_machine` (
  `ip` varchar(255) DEFAULT NULL,
  `inip` varchar(255) DEFAULT NULL,
  `cpucore` int(2) DEFAULT '2',
  `memoryAvailable` varchar(255) DEFAULT '16',
  `sizeExdiskFree` varchar(255) DEFAULT '100',
  `servernum` int(11) DEFAULT '0',
  `freshTime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of t_machine
-- ----------------------------
INSERT INTO `t_machine` VALUES ('114.55.72.240', '10.24.252.125', '2', '10.85', '99.39', '8', '2016-06-28 00:29:02');
INSERT INTO `t_machine` VALUES ('114.55.90.118', '10.25.84.113', '2', '12.11', '99.72', '3', '2016-06-28 00:29:04');
INSERT INTO `t_machine` VALUES ('120.27.163.191', '10.47.54.131', '2', '16', '100', '0', '2016-06-28 00:38:27');
