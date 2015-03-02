<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `info_cate_relation`;");
E_C("CREATE TABLE `info_cate_relation` (
  `relation_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关系ID',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类ID',
  `model_id` int(11) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `my_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '当前资讯的分类ID',
  `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '资讯ID',
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED");

require("../../inc/footer.php");
?>