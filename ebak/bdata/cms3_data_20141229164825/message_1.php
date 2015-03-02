<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `message`;");
E_C("CREATE TABLE `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `is_check` int(11) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `corder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '姓名',
  `content` varchar(255) NOT NULL DEFAULT '' COMMENT '留言内容',
  `ipaddr` varchar(20) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '留言时间',
  `mobile` varchar(50) NOT NULL DEFAULT '' COMMENT '电话',
  `email` varchar(30) NOT NULL DEFAULT '' COMMENT '邮箱',
  `reply` varchar(255) NOT NULL DEFAULT '' COMMENT '回复',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");

require("../../inc/footer.php");
?>