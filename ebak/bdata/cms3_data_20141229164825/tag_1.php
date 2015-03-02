<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `tag`;");
E_C("CREATE TABLE `tag` (
  `tag_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tag_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '标签分类',
  `tag_txt` varchar(50) NOT NULL DEFAULT '' COMMENT '文字',
  `tag_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`tag_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>