<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `flink`;");
E_C("CREATE TABLE `flink` (
  `flink_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情ID',
  `flink_hosturl` varchar(255) NOT NULL DEFAULT '' COMMENT '域名地址或分类地址',
  `flink_name` varchar(100) NOT NULL DEFAULT '' COMMENT '友链名称',
  `flink_img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `flink_url` text NOT NULL COMMENT '地址',
  `flink_is_site` int(11) DEFAULT '0' COMMENT '0=首页，1代表全站',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市或区域ID',
  `flink_order` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`flink_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `flink` values('1','','腾讯游戏','','http://game.qq.com','0','0','50');");

require("../../inc/footer.php");
?>