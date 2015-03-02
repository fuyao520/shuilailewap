<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_list`;");
E_C("CREATE TABLE `user_list` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'uid',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员组ID',
  `uname` varchar(100) NOT NULL DEFAULT '' COMMENT '用户名',
  `uname_true` varchar(100) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `upass` varchar(100) NOT NULL DEFAULT '' COMMENT '密码',
  `uemail` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `uemail_verify` int(1) NOT NULL DEFAULT '0' COMMENT '邮箱是否验证',
  `uqq` varchar(100) NOT NULL DEFAULT '' COMMENT 'QQ',
  `uphone` varchar(100) NOT NULL DEFAULT '' COMMENT '手机',
  `uphone_verify` int(1) NOT NULL DEFAULT '0' COMMENT '手机是否验证',
  `ustate` int(11) NOT NULL DEFAULT '0' COMMENT '用户状态（正常=0，停用=1）',
  `reg_date` int(11) NOT NULL DEFAULT '0' COMMENT '注册地址',
  `reg_ip` varchar(100) NOT NULL DEFAULT '' COMMENT '注册IP地址',
  `forget_pass_code` varchar(100) NOT NULL DEFAULT '' COMMENT '重置密码验证字符串',
  `email_activation_code` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱激活验证字符串',
  `cell_activation_code` varchar(100) NOT NULL DEFAULT '' COMMENT '手机激活验证字符串',
  `lastvisit_code` varchar(100) NOT NULL DEFAULT '' COMMENT '登录密钥',
  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT '会员到期时间',
  `user_money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '用户现有资金',
  `user_vitual_money` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '用户现有虚拟币',
  `fans_total` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '粉丝数量',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=10081 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='会员'");
E_D("replace into `user_list` values('10002','0','feifei','','57fff0ea55146baa6ac1a9999dfcd1ad','137108692@qq.com','1','undefined','18650182402','1','0','1409824640','127.0.0.1','','','','','0','0.00','0.0','0');");

require("../../inc/footer.php");
?>