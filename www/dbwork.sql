/*
SQLyog 企业版 - MySQL GUI v7.14 
MySQL - 5.5.25 : Database - q&a
*********************************************************************
*/


/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`q&a` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `q&a`;

/*Table structure for table `t_answer` */

DROP TABLE IF EXISTS `t_answer`;

CREATE TABLE `t_answer` (
  `answerId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `content` blob,
  `parentAnswerId` int(11) DEFAULT NULL,
  `replyUserId` int(11) DEFAULT NULL,
  `time` date DEFAULT NULL,
  PRIMARY KEY (`answerId`),
  KEY `FK_t_answer_userId` (`userId`),
  KEY `fk_answer_replyUserId` (`replyUserId`),
  KEY `FK_t_answer_questionId` (`questionId`),
  CONSTRAINT `fk_answer_replyUserId` FOREIGN KEY (`replyUserId`) REFERENCES `t_user` (`userId`),
  CONSTRAINT `FK_t_answer_questionId` FOREIGN KEY (`questionId`) REFERENCES `t_question` (`questionId`) ON DELETE SET NULL,
  CONSTRAINT `FK_t_answer_userId` FOREIGN KEY (`userId`) REFERENCES `t_user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `t_answer` */

insert  into `t_answer`(`answerId`,`questionId`,`userId`,`content`,`parentAnswerId`,`replyUserId`,`time`) values (7,5,11,'<cc><div id=\"post_content_60114331265\" class=\"d_post_content j_d_post_content \">不行的哦，你只能自己计算好位置，一次输出一行内的两个，再输第二行。中间可以用\\t分隔。</div><br></cc>',NULL,NULL,'2014-11-10'),(8,5,9,'一定不可以？',7,NULL,'2014-11-10'),(9,5,8,'???',7,NULL,'2014-11-10'),(10,5,8,'<p>可以用数组和for循环，再加上“\\n”实现</p><p>&nbsp;</p>',NULL,NULL,'2014-11-10'),(11,7,9,'<div id=\"post_content_60116796838\" class=\"d_post_content j_d_post_content \">            atoi，+1，itoa，就五个步骤，根据一定的思路来就五个</div>',NULL,NULL,'2014-11-10'),(12,9,8,'换个思路，在head里插入style元素，内容：<br>div[id^=\"baidu_clb_ad_\"] {<br>    display: none;<br>}',NULL,NULL,'2014-11-10'),(13,9,11,'<cc><div id=\"post_content_60116585016\" class=\"d_post_content j_d_post_content \">用jquety的选择器能行不？</div><br></cc>',NULL,NULL,'2014-11-10'),(14,9,11,'取所有div。循环取ID 正则取值。或者 document.querySelector 填选择器 支持模糊匹配。',NULL,NULL,'2014-11-10'),(15,9,9,'能给写一下吗，第一种方法正则取值的，感谢',14,NULL,'2014-11-10'),(16,9,11,'循环div数组。判断ID是否XX开头就行了。getElementsByTagName(\"div\")',14,9,'2014-11-10');

/*Table structure for table `t_collect` */

DROP TABLE IF EXISTS `t_collect`;

CREATE TABLE `t_collect` (
  `collectId` int(11) NOT NULL AUTO_INCREMENT,
  `questionId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `time` date DEFAULT NULL,
  PRIMARY KEY (`collectId`),
  KEY `FK_t_collect_userId` (`userId`),
  KEY `FK_t_collect_questionId` (`questionId`),
  CONSTRAINT `FK_t_collect_questionId` FOREIGN KEY (`questionId`) REFERENCES `t_question` (`questionId`),
  CONSTRAINT `FK_t_collect_userId` FOREIGN KEY (`userId`) REFERENCES `t_user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `t_collect` */

insert  into `t_collect`(`collectId`,`questionId`,`userId`,`time`) values (1,5,9,'2014-11-10');

/*Table structure for table `t_question` */

DROP TABLE IF EXISTS `t_question`;

CREATE TABLE `t_question` (
  `questionId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `score` int(11) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `view` int(11) DEFAULT NULL,
  `time` date DEFAULT NULL,
  `solved` tinyint(1) DEFAULT NULL,
  `bestAnswer` int(11) DEFAULT NULL,
  PRIMARY KEY (`questionId`),
  KEY `FK_t_question_userId` (`userId`),
  KEY `fk_question_bestAnswer` (`bestAnswer`),
  CONSTRAINT `fk_question_bestAnswer` FOREIGN KEY (`bestAnswer`) REFERENCES `t_answer` (`answerId`) ON DELETE CASCADE,
  CONSTRAINT `FK_t_question_userId` FOREIGN KEY (`userId`) REFERENCES `t_user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `t_question` */

insert  into `t_question`(`questionId`,`userId`,`title`,`content`,`score`,`label`,`view`,`time`,`solved`,`bestAnswer`) values (5,9,' 【求助】一个简单的问题','举个例子说：<br><img src=\"data:image/png;base64,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\" alt=\"\"><br>我怎么样一列一列的输将他们输成两列？<br>\n                      ',2,'C语言,求助',19,'2014-11-10',1,10),(6,8,'求教c++如何输入未知长度字符串','\n如题-_-||',2,'C++,字符串',2,'2014-11-10',NULL,NULL),(7,11,'C++编程问题 谁能帮忙写一下? 谢谢','<div id=\"post_content_60095749423\" class=\"d_post_content j_d_post_content \">每当我启动此程序 ,然后就在指定的TXT文档记录一次 ，比如我第一次启动就记录数字 “1” ，第二次启动的时候则读取此TXT文档然后把“1”改为”2“ ， 第N次启动则读取文档将N改为N +1</div>\n                      ',5,'C++',4,'2014-11-10',1,11),(8,8,'如何使得多边形<area>在onmouseover时显示边界','\n当点击时会显示边界，如何在鼠标悬停时就显示边界？',2,'HTML',1,'2014-11-10',NULL,NULL),(9,9,'getElementById的问题希望能解惑','<div id=\"post_content_60116234125\" class=\"d_post_content j_d_post_content \">            小弟是新手中的菜鸟有个疑问  <a href=\"http://www.baidu.com/s?wd=%E7%99%BE%E5%BA%A6%E5%B9%BF%E5%91%8A%E7%AE%A1%E5%AE%B6&amp;ie=gbk&amp;tn=SE_hldp00990_u6vqbx10\" class=\"ps_cb\" target=\"_blank\">百度广告管家</a>的，希望能给小弟解惑<br><br><br>&lt;script language=\"javascript\"&gt;<br>function close(){      <br>document.getElementById(\"baidu_clb_ad_*\").style.display = \"none\";<br>}<br>&lt;/script&gt;<br>-------------------------------------------------------------------------------------------------------------------<br>&lt;div id=\"baidu_clb_ad_123456\"&gt;&lt;/div&gt;    这个123456是随机的数字 刷新会变成234567<br><br><br>我想上面getElementById    baidu_clb_ad_* （通配符也不好用）    有什么办法可以获取到div的id呢</div>\n                      ',2,'javascript',7,'2014-11-10',1,14);

/*Table structure for table `t_review` */

DROP TABLE IF EXISTS `t_review`;

CREATE TABLE `t_review` (
  `answerId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `up` tinyint(1) DEFAULT NULL,
  KEY `FK_t_stamp_userId` (`userId`),
  KEY `FK_t_review` (`answerId`),
  CONSTRAINT `FK_t_review` FOREIGN KEY (`answerId`) REFERENCES `t_answer` (`answerId`),
  CONSTRAINT `FK_t_stamp_userId` FOREIGN KEY (`userId`) REFERENCES `t_user` (`userId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `t_review` */

insert  into `t_review`(`answerId`,`userId`,`up`) values (10,11,1),(14,9,1),(14,8,1);

/*Table structure for table `t_user` */

DROP TABLE IF EXISTS `t_user`;

CREATE TABLE `t_user` (
  `userId` int(11) NOT NULL AUTO_INCREMENT,
  `userName` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `email` varchar(40) DEFAULT NULL,
  `signature` varchar(255) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `registerTime` datetime DEFAULT NULL,
  `lastLoginTime` datetime DEFAULT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `t_user` */

insert  into `t_user`(`userId`,`userName`,`password`,`icon`,`email`,`signature`,`score`,`registerTime`,`lastLoginTime`) values (8,'alwing','202cb962ac59075b5165329ea1ff5c5ecbdbbeef','5460b7d1c0ffc.jpg','1@test.com','......',8,'2014-11-10 14:24:21','2014-11-10 22:28:20'),(9,'笨笨兔很笨','202cb962ac59075b5165329ea1ff5c5ecbdbbeef','5460caaae1183.jpg','2@qq.com',NULL,11,'2014-11-10 14:41:04','2014-11-10 22:24:15'),(10,' windsun_ul','202cb962ac59075b5165329ea1ff5c5ecbdbbeef','5460b896e9599.jpg','2@test.com',NULL,10,'2014-11-10 21:07:19','2014-11-10 21:07:19'),(11,'lxy5266','202cb962ac59075b5165329ea1ff5c5ecbdbbeef','5460b8fe8441e.jpg','3@test.com',NULL,7,'2014-11-10 21:08:38','2014-11-10 22:29:30'),(12,'跑起来就有风','202cb962ac59075b5165329ea1ff5c5ecbdbbeef','5460b98022f22.jpg','4@test.com',NULL,10,'2014-11-10 21:11:09','2014-11-10 21:11:09');

/*Table structure for table `t_area` */

DROP TABLE IF EXISTS `t_area`;

CREATE TABLE `t_area` (
  `areaId` int(11) NOT NULL AUTO_INCREMENT,
  `areaName` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`areaId`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `t_area` */

insert  into `t_area`(`areaId`,`areaName`) values (10,'math'),(11,'science'),(12,'reading');

/*Table structure for table `t_interest` */

DROP TABLE IF EXISTS `t_interest`;

CREATE TABLE `t_interest` (
  `interestId` int(11) NOT NULL AUTO_INCREMENT,
  `areaId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  PRIMARY KEY (`interestId`),
  KEY `FK_t_interest_userId` (`userId`),
  KEY `FK_t_interest_areaId` (`areaId`),
  CONSTRAINT `FK_t_interest_areaId` FOREIGN KEY (`areaId`) REFERENCES `t_area` (`areaId`),
  CONSTRAINT `FK_t_interest_userId` FOREIGN KEY (`userId`) REFERENCES `t_user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `t_interest` */

insert  into `t_interest`(`interestId`,`areaId`,`userId`) values (9,10,8),(10,11,8);

/*Table structure for table `t_expert` */

DROP TABLE IF EXISTS `t_expert`;

CREATE TABLE `t_expert` (
  `expertId` int(11) NOT NULL AUTO_INCREMENT,
  `areaId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`expertId`),
  KEY `FK_t_expert_userId` (`userId`),
  KEY `FK_t_expert_areaId` (`areaId`),
  CONSTRAINT `FK_t_expert_areaId` FOREIGN KEY (`areaId`) REFERENCES `t_area` (`areaId`),
  CONSTRAINT `FK_t_expert_userId` FOREIGN KEY (`userId`) REFERENCES `t_user` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `t_expert` */

insert  into `t_expert`(`expertId`,`areaId`,`userId`,`bio`) values (9,10,8, '3 years'),(10,11,8, '4 years');


/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
