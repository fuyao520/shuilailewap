<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `company_ad`;");
E_C("CREATE TABLE `company_ad` (
  `ad_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '广告ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `ad_name` varchar(100) NOT NULL DEFAULT '' COMMENT '广告名称',
  `ad_img` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `ad_url` text NOT NULL COMMENT '地址',
  `ad_order` int(11) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>