<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `pm_list`;");
E_C("CREATE TABLE `pm_list` (
  `pm_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pm_title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `pm_body` text NOT NULL COMMENT '内容',
  `uid_post` int(11) NOT NULL DEFAULT '0' COMMENT '发出站内信用户ID',
  `uid_recv` int(11) NOT NULL DEFAULT '0' COMMENT '接收站内信用户ID',
  `post_date` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `recv_date` int(11) NOT NULL DEFAULT '0' COMMENT '接收（阅读）时间，可用户判断接收用户是否已读',
  `pm_type` int(1) NOT NULL DEFAULT '0' COMMENT '站内信类型（系统=1，用户=2）',
  PRIMARY KEY (`pm_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>