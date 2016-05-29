/*
Navicat MySQL Data Transfer

Source Server         : mysqlLocal
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : archery_scoring

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-02-12 09:57:04
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `category`
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `range_Id` varchar(5) NOT NULL DEFAULT '',
  `categories` varchar(100) DEFAULT NULL,
  `range` varchar(5) DEFAULT NULL,
  `shoot_qty` int(10) DEFAULT NULL,
  PRIMARY KEY (`range_Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES ('1', 'RecurveMale', '30M', '36');
INSERT INTO `category` VALUES ('2', 'RecurveMale', '50M', '30');

-- ----------------------------
-- Table structure for `players`
-- ----------------------------
DROP TABLE IF EXISTS `players`;
CREATE TABLE `players` (
  `player_id` int(4) NOT NULL,
  `player_name` varchar(255) DEFAULT NULL,
  `player_gender` varchar(6) DEFAULT NULL,
  `team` varchar(255) DEFAULT NULL,
  `player_no` varchar(4) DEFAULT NULL,
  `player_bow_cat` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `player_id` (`player_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of players
-- ----------------------------
INSERT INTO `players` VALUES ('1', 'Mohd Hariz bin Naim', 'Male', 'Melaka', '1C', 'Recurve');
INSERT INTO `players` VALUES ('2', 'Mohd Ali Rustam', 'Male', 'Melaka', '4C', 'Recurve');
INSERT INTO `players` VALUES ('3', 'Mohd Ali Abu', 'Male', 'Melaka', '7B', 'Compound');
INSERT INTO `players` VALUES ('4', 'Siti Fatimah', 'Female', 'Melaka', '8A', 'Compound');
INSERT INTO `players` VALUES ('5', 'Nur Nadia', 'Female', 'Melaka', '8B', 'Compound');
INSERT INTO `players` VALUES ('6', 'Bazla Md Soom', 'Female', 'Melaka', '6B', 'Recurve');
INSERT INTO `players` VALUES ('7', 'Mohd Zukry Hussin', 'Male', 'Kelantan', '7A', 'Compound');
INSERT INTO `players` VALUES ('8', 'Amir Mohd Ramli', 'Male', 'Melaka', '3C', 'Recurve');
INSERT INTO `players` VALUES ('9', 'Ahmad Saiful Tarmizi', 'Male', 'Melaka', '2C', 'Recurve');
INSERT INTO `players` VALUES ('10', 'Mohd Fadzil Manaf', 'Male', 'Kedah', '2A', 'Recurve');
INSERT INTO `players` VALUES ('11', 'Hassan Albana ', 'Male', 'Kedah', '3A', 'Recurve');
INSERT INTO `players` VALUES ('12', 'Mohd Atif bin Ramlan', 'Male', 'Kedah', '4A', 'Recurve');
INSERT INTO `players` VALUES ('13', 'Mohd Zulhairi bin Seman', 'Male', 'Kedah', '1A', 'Recurve');
INSERT INTO `players` VALUES ('14', 'Mohd Farihan bin Husin', 'Male', 'Kelantan', '4B', 'Recurve');
INSERT INTO `players` VALUES ('15', 'Mohd Helme bin Abrar', 'Male', 'Kelantan', '3B', 'Recurve');
INSERT INTO `players` VALUES ('16', 'Tok Jiang Ziya', 'Male', 'Kelantan', '2B', 'Recurve');
INSERT INTO `players` VALUES ('17', 'Tok Harimau Bintang', 'Male', 'Kelantan', '1B', 'Recurve');
INSERT INTO `players` VALUES ('18', 'Ji Kao Ji Chang', 'Male', 'Selangor', '1D', 'Recurve');
INSERT INTO `players` VALUES ('19', 'Ji Fat Ji Chang', 'Male', 'Selangor', '2D', 'Recurve');
INSERT INTO `players` VALUES ('20', 'Jiang Choong Ziya', 'Male', 'Selangor', '3D', 'Recurve');
INSERT INTO `players` VALUES ('21', 'Nenek Merbok', 'Female', 'Melaka', '5C', 'Recurve');
INSERT INTO `players` VALUES ('22', 'Sang Pipit Merah', 'Female', 'Melaka', '6C', 'Recurve');
INSERT INTO `players` VALUES ('23', 'Haidayu bt Anuar', 'Female', 'Melaka', '5D', 'Recurve');
INSERT INTO `players` VALUES ('24', 'Nenek Tilik', 'Female', 'Kelantan', '5A', 'Recurve');
INSERT INTO `players` VALUES ('25', 'Biduanda Layang', 'Female', 'Kelantan', '6A', 'Recurve');
INSERT INTO `players` VALUES ('26', 'Biduanda Tebuan', 'Female', 'Kelantan', '5B', 'Recurve');

-- ----------------------------
-- Table structure for `scoring`
-- ----------------------------
DROP TABLE IF EXISTS `scoring`;
CREATE TABLE `scoring` (
  `archer_no` varchar(4) DEFAULT NULL,
  `range` varchar(255) DEFAULT NULL,
  `Nth_arrow` int(11) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `cntX` int(1) DEFAULT NULL,
  `cnt10` int(1) DEFAULT NULL,
  `cnt9` int(1) DEFAULT NULL,
  `cntM` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of scoring
-- ----------------------------
INSERT INTO `scoring` VALUES ('3C', '1', '1', '10', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '2', '10', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '3', '9', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '4', '9', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '5', '9', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '6', '9', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '7', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '8', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '9', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '10', '9', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '11', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '12', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '13', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '14', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '15', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '16', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '17', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '18', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '19', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '20', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '21', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '22', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '23', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '24', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '25', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '26', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '27', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '28', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '29', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '30', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '31', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '32', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '33', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '34', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3C', '1', '35', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '1', '9', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '2', '9', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '3', '9', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '4', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '5', '9', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '6', '9', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '7', '8', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '8', '8', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '9', '7', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '10', '10', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '11', '10', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '12', '10', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '13', '8', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '14', '8', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '15', '7', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '16', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '17', '8', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '18', '8', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '19', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '20', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '21', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '22', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '23', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '24', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '25', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '26', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '27', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '28', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '29', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '30', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '31', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '32', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '33', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '34', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '35', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3a', '1', '36', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '1', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '2', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '3', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '4', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '5', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '6', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '7', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '8', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '9', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '10', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '11', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '12', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '13', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '14', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '15', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '16', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '17', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '18', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '19', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '20', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '21', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '22', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '23', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '24', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '25', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '26', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '27', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '28', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '29', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '30', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '31', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '32', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '33', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '34', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '35', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('3B', '1', '36', '0', null, null, null, null);
INSERT INTO `scoring` VALUES ('1A', '1', '1', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '2', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '3', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '4', '8', '0', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '5', '7', '0', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '6', '7', '0', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '7', '10', '1', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '8', '10', '1', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '9', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '10', '10', '1', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '11', '7', '0', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '12', '7', '0', '0', '0', '0');
INSERT INTO `scoring` VALUES ('1A', '1', '13', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '14', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '15', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '16', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '17', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '18', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '19', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '20', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '21', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '22', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '23', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '24', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '25', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '26', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '27', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '28', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '29', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '30', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '31', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '32', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '33', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '34', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '35', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1A', '1', '36', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('1D', '1', '1', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '2', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '3', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '4', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '5', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '6', '10', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '7', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '8', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '9', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '10', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '11', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '12', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '13', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '14', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '15', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '16', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '17', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '18', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '19', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '20', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '21', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '22', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '23', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '24', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '25', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '26', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '27', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '28', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '29', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '30', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '31', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '32', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '33', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '34', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '35', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('1D', '1', '36', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '1', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '2', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '3', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '4', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '5', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '6', '10', '1', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '7', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '8', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '9', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '10', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '11', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '12', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '13', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '14', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '15', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '16', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '17', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '18', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '19', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '20', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '21', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '22', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '23', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '24', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '25', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '26', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '27', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '28', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '29', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '30', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '31', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '32', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '33', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '34', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '35', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('2B', '1', '36', '0', '0', null, null, null);
INSERT INTO `scoring` VALUES ('3c', '1', '1', '10', '0', '1', '0', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '2', '10', '0', '1', '0', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '3', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '4', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '5', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '6', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '7', '10', '1', '0', '0', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '8', '10', '1', '0', '0', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '9', '10', '0', '1', '0', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '10', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '11', '9', '0', '0', '1', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '12', '8', '0', '0', '0', '0');
INSERT INTO `scoring` VALUES ('3c', '1', '13', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '14', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '15', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '16', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '17', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '18', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '19', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '20', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '21', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '22', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '23', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '24', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '25', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '26', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '27', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '28', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '29', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '30', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '31', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '32', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '33', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '34', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '35', '0', '0', '0', '0', '1');
INSERT INTO `scoring` VALUES ('3c', '1', '36', '0', '0', '0', '0', '1');

-- ----------------------------
-- Table structure for `staf`
-- ----------------------------
DROP TABLE IF EXISTS `staf`;
CREATE TABLE `staf` (
  `staff_id` varchar(15) NOT NULL DEFAULT '',
  `staff_name` varchar(255) DEFAULT NULL,
  `staff_password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of staf
-- ----------------------------
INSERT INTO `staf` VALUES ('developer', 'hariz', 'ÿXh#û%À`');
