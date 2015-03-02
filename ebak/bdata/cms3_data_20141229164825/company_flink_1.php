<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `company_flink`;");
E_C("CREATE TABLE `company_flink` (
  `flink_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `flink_name` varchar(100) NOT NULL DEFAULT '' COMMENT '友链名称',
  `flink_img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `flink_url` text NOT NULL COMMENT '地址',
  `flink_order` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`flink_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>