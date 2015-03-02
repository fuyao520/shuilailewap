<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ad_area`;");
E_C("CREATE TABLE `ad_area` (
  `area_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `area_name` varchar(255) NOT NULL DEFAULT '' COMMENT '位置名称',
  `area_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '广告位描述',
  PRIMARY KEY (`area_id`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>