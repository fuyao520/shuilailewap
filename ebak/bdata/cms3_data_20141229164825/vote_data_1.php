<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `vote_data`;");
E_C("CREATE TABLE `vote_data` (
  `data_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `uid` int(8) unsigned NOT NULL COMMENT '用户ID',
  `uname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户名',
  `subject_id` int(11) NOT NULL DEFAULT '0' COMMENT '选项ID',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '投票时间',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT '投票时间',
  `data` varchar(255) NOT NULL DEFAULT '' COMMENT '投票的数据,json格式 [3,5,6]，表示 投给了 3，5，6',
  PRIMARY KEY (`data_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `vote_data` values('1','0','','1','1388201239','127.0.0.1','[\"3\"]');");
E_D("replace into `vote_data` values('2','0','','1','1388996020','120.36.149.135','[\"1\",\"2\"]');");
E_D("replace into `vote_data` values('3','0','','1','1389408145','110.87.93.11','[\"2\"]');");
E_D("replace into `vote_data` values('4','0','','1','1389675517','110.87.93.11','[\"1\"]');");
E_D("replace into `vote_data` values('5','0','','1','1390042848','112.5.252.235','[\"2\",\"3\"]');");
E_D("replace into `vote_data` values('6','0','','1','1390533281','110.80.95.135','[\"2\"]');");

require("../../inc/footer.php");
?>