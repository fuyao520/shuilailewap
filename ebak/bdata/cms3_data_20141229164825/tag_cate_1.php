<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `tag_cate`;");
E_C("CREATE TABLE `tag_cate` (
  `tag_cate_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `tag_cate_name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',
  `info_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '资讯分类id',
  `tag_cate_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`tag_cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `tag_cate` values('1','搜索词','1','50');");
E_D("replace into `tag_cate` values('2','图片标签','0','50');");

require("../../inc/footer.php");
?>