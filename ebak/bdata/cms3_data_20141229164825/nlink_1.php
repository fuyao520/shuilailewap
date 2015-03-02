<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `nlink`;");
E_C("CREATE TABLE `nlink` (
  `nlink_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '内链ID',
  `nlink_txt` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `nlink_url` text NOT NULL COMMENT '网址',
  `norder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`nlink_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `nlink` values('2','平台','http://www.baidu.com','1');");
E_D("replace into `nlink` values('3','医疗器械','222222222','55');");
E_D("replace into `nlink` values('4','wawawa','111111','44');");

require("../../inc/footer.php");
?>