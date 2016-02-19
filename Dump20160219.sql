CREATE DATABASE  IF NOT EXISTS `lenggirl` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `lenggirl`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: localhost    Database: lenggirl
-- ------------------------------------------------------
-- Server version	5.6.17

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `think_userinfo`
--

DROP TABLE IF EXISTS `think_userinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL COMMENT '用户名',
  `realname` varchar(64) DEFAULT NULL COMMENT '真名',
  `personid` varchar(200) DEFAULT NULL COMMENT '身份证',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否已经审核',
  `picture1` varchar(200) DEFAULT NULL COMMENT '身份证照片正',
  `picture2` varchar(200) DEFAULT NULL COMMENT '身份证反面',
  `phone` varchar(200) DEFAULT NULL COMMENT '联系手机',
  `address` text COMMENT '通讯地址',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户信息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_userinfo`
--

LOCK TABLES `think_userinfo` WRITE;
/*!40000 ALTER TABLE `think_userinfo` DISABLE KEYS */;
INSERT INTO `think_userinfo` VALUES (1,'hunterhug','陈雪见','445121199304162023',1,'20160217/56c46a93d2063.jpg','20160215/56c1ca71747ef.jpg','13247391421','中国台湾'),(2,'1234567','你三十岁','223323333333333333',1,'20160216/56c337380e54c.jpg','20160216/56c3373bb8a83.jpg','13247391421','fff');
/*!40000 ALTER TABLE `think_userinfo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_webabout`
--

DROP TABLE IF EXISTS `think_webabout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_webabout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) DEFAULT NULL COMMENT '用户名',
  `about` mediumtext COMMENT '介绍',
  `createtime` datetime DEFAULT NULL COMMENT '创建时间',
  `updatetime` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='网站介绍表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_webabout`
--

LOCK TABLES `think_webabout` WRITE;
/*!40000 ALTER TABLE `think_webabout` DISABLE KEYS */;
INSERT INTO `think_webabout` VALUES (1,'hunterhug','&lt;p&gt;&lt;img alt=&quot;psu.jpg&quot; src=&quot;/pictures/image/20160218/1455810205125493.jpg&quot; title=&quot;1455810205125493.jpg&quot;/&gt;&lt;img alt=&quot;QQ截图20160211141828.png&quot; src=&quot;/pictures/image/20160218/1455809956118875.png&quot; title=&quot;1455809956118875.png&quot;/&gt;ffff&lt;/p&gt;','2016-02-18 23:38:14','2016-02-18 23:45:54');
/*!40000 ALTER TABLE `think_webabout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_comment`
--

DROP TABLE IF EXISTS `think_comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_comment` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `nickname` varchar(64) NOT NULL,
  `content` tinytext NOT NULL,
  `createtime` int(11) unsigned DEFAULT NULL,
  `email` varchar(64) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `pid` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_comment`
--

LOCK TABLES `think_comment` WRITE;
/*!40000 ALTER TABLE `think_comment` DISABLE KEYS */;
INSERT INTO `think_comment` VALUES (84,'sss','dds',1454561383,'569929309@qq.com',1,0),(85,'dsc','dscsdcsd',1454561398,'569929309@qq.com',1,0);
/*!40000 ALTER TABLE `think_comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_paper`
--

DROP TABLE IF EXISTS `think_paper`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_paper` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `author` varchar(64) NOT NULL,
  `content` text,
  `createtime` int(11) unsigned DEFAULT NULL,
  `updatetime` int(11) unsigned DEFAULT NULL,
  `order` mediumint(8) NOT NULL DEFAULT '1',
  `view` mediumint(8) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `cid` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_paper`
--

LOCK TABLES `think_paper` WRITE;
/*!40000 ALTER TABLE `think_paper` DISABLE KEYS */;
INSERT INTO `think_paper` VALUES (30,'sac','casc','<p><img alt=\"psu.jpg\" src=\"/uploads/image/20151201/1448979731883700.jpg\" title=\"1448979731883700.jpg\"/></p>',1448979737,1448979737,1,4,1,18),(28,'rtb','rt','<p style=\"line-height: 16px;\"><img style=\"vertical-align: middle; margin-right: 2px;\" src=\"http://localhost/lenggirl/Public/ueditor/dialogs/attachment/fileTypeImages/icon_jpg.gif\"/><a title=\"照片_20130731_191116.jpg\" style=\"font-size:12px; color:#0066cc;\" href=\"/uploads/file/20151201/1448971046527483.jpg\">照片_20130731_191116.jpg</a></p><p><img title=\"1448971061536089.png\" alt=\"scrawl.png\" src=\"/uploads/image/20151201/1448971061536089.png\"/></p>',1446987798,1448971063,1,12,1,15),(29,'e','e','<p><img alt=\"psu.jpg\" src=\"/lenggirl/uploads/image/20151109/1447080352952207.jpg\" title=\"1447080352952207.jpg\"/></p>',1447080367,1447080367,1,7,1,15);
/*!40000 ALTER TABLE `think_paper` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_category`
--

DROP TABLE IF EXISTS `think_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_category` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(64) NOT NULL,
  `content` text,
  `createtime` int(11) unsigned DEFAULT NULL,
  `updatetime` int(11) unsigned DEFAULT NULL,
  `order` tinyint(3) NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `title` (`title`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_category`
--

LOCK TABLES `think_category` WRITE;
/*!40000 ALTER TABLE `think_category` DISABLE KEYS */;
INSERT INTO `think_category` VALUES (15,'看书补大脑','',1446987068,1446987229,1,1),(16,'动漫2次元','',1446987182,1446987182,1,1),(17,'吃货大集合','',1446987202,1446987202,1,1),(18,'深夜闲聊','',1446987260,1446987260,1,1),(19,'微信心灵鸡汤','',1446987275,1446987275,1,1);
/*!40000 ALTER TABLE `think_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_usersafe`
--

DROP TABLE IF EXISTS `think_usersafe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_usersafe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `question1` varchar(200) DEFAULT NULL,
  `question2` varchar(200) DEFAULT NULL,
  `question3` varchar(200) DEFAULT NULL,
  `answer1` varchar(200) DEFAULT NULL,
  `answer2` varchar(200) DEFAULT NULL,
  `answer3` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_usersafe`
--

LOCK TABLES `think_usersafe` WRITE;
/*!40000 ALTER TABLE `think_usersafe` DISABLE KEYS */;
INSERT INTO `think_usersafe` VALUES (5,'hunterhug','我喜欢去哪里？','我最爱吃？','我最爱吃？','2','2','2'),(7,'1234567','我最爱吃？','我最爱吃？','我最爱吃？','1','1','1');
/*!40000 ALTER TABLE `think_usersafe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_user`
--

DROP TABLE IF EXISTS `think_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_user` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `lastlogintime` datetime DEFAULT NULL,
  `lastloginip` varchar(40) DEFAULT NULL,
  `loginnum` mediumint(8) unsigned DEFAULT '0',
  `email` varchar(50) DEFAULT NULL,
  `createtime` datetime DEFAULT NULL,
  `updatetime` datetime DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_user`
--

LOCK TABLES `think_user` WRITE;
/*!40000 ALTER TABLE `think_user` DISABLE KEYS */;
INSERT INTO `think_user` VALUES (1,'hunterhug','一只尼玛','e10adc3949ba59abbe56e057f20f883e','2016-02-19 21:30:23','0.0.0.0',63,'569929309@qq.com','2016-02-11 14:08:29','2016-02-11 21:57:16',0),(23,'eewfwef','wfw','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-11 20:58:24',NULL,1),(21,'freferf','1234','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-11 20:27:46',NULL,1),(22,'admin','666','e10adc3949ba59abbe56e057f20f883e','2016-02-13 17:20:51','0.0.0.0',2,'569929309@qq.com','2016-02-11 20:28:18',NULL,1),(19,'fergreg','111111','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-11 20:26:58','2016-02-11 21:55:01',0),(20,'rtgrtg','rtgtrg','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569***@qq.com','2016-02-11 20:27:26',NULL,1),(24,'admins','1212','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-11 21:14:18',NULL,0),(25,'123456','5656','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-11 21:15:19',NULL,0),(26,'hunter','aa','e10adc3949ba59abbe56e057f20f883e','2016-02-13 14:56:39','0.0.0.0',1,'569929309@qq.com','2016-02-13 14:55:51',NULL,1),(27,'hunterhug1','111','e10adc3949ba59abbe56e057f20f883e',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-13 16:55:02',NULL,3),(28,'hunterhug2','xgxd','0ed1660671eb752038063c319c6615d5',NULL,'0.0.0.0',0,'569929309@qq.com','2016-02-14 13:26:12','2016-02-14 13:26:29',3),(29,'1234567','12345','96e79218965eb72c92a549dd5a330112','2016-02-17 23:51:48','0.0.0.0',4,'569929309@qq.com','2016-02-16 22:31:57',NULL,1);
/*!40000 ALTER TABLE `think_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `think_webinfo`
--

DROP TABLE IF EXISTS `think_webinfo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `think_webinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL COMMENT '网站拥有者',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '网站标题',
  `desc` text COMMENT '网站描述',
  `logo` varchar(200) DEFAULT NULL COMMENT '网站logo',
  `address` text COMMENT '联系地址',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '网站状态',
  `phone` varchar(200) DEFAULT NULL COMMENT '联系电话',
  `webinfo` text COMMENT '备案信息',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='网站信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `think_webinfo`
--

LOCK TABLES `think_webinfo` WRITE;
/*!40000 ALTER TABLE `think_webinfo` DISABLE KEYS */;
INSERT INTO `think_webinfo` VALUES (1,'hunterhug','中小企业智能管理系统','这是一个\r\n很好的网站','20160214/56c0516a60c72.jpg','广东省海珠区广东财经大学',0,'0768-6833066','粤ICP备16008312号-1'),(2,'hunter','DDD','DD','20160213/56bedbc433f1f.jpg','DD',1,'0768-6833066','DD'),(3,'admin','brtb','rtb',NULL,'brtb',1,'0768-6833066','bbr'),(4,'1234567','rrr','rrrrrr','20160217/56c497530527e.jpg','dd',1,'13247391421','ee');
/*!40000 ALTER TABLE `think_webinfo` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-19 21:47:40
