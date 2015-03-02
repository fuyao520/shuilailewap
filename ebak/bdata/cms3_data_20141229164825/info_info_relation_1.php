<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `info_info_relation`;");
E_C("CREATE TABLE `info_info_relation` (
  `relation_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关系ID',
  `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '资讯ID',
  `model_id` int(11) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `info_id_related` int(11) NOT NULL DEFAULT '0' COMMENT '关联资讯ID',
  `model_id_related` int(11) NOT NULL DEFAULT '0' COMMENT '关联资讯ID的模型ID',
  `displayorder` int(11) NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '类型(特殊)',
  PRIMARY KEY (`relation_id`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED");

require("../../inc/footer.php");
?>