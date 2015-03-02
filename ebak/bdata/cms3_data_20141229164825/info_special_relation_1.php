<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `info_special_relation`;");
E_C("CREATE TABLE `info_special_relation` (
  `relation_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关系ID',
  `special_id` int(11) NOT NULL DEFAULT '0' COMMENT '专题ID',
  `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '资讯ID',
  `model_id` int(11) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `special_type` int(11) NOT NULL DEFAULT '0' COMMENT '所属某专题的小分类（从typesetting里选择）',
  `info_title` varchar(255) NOT NULL DEFAULT '' COMMENT '缓存标题',
  `i_s_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>