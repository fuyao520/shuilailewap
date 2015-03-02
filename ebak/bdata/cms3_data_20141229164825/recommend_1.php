<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `recommend`;");
E_C("CREATE TABLE `recommend` (
  `recommend_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关系ID',
  `recommend_name` varchar(100) NOT NULL DEFAULT '' COMMENT '推荐位名称',
  `table_name` varchar(100) NOT NULL DEFAULT '' COMMENT '数据表名',
  `id_field` varchar(100) NOT NULL DEFAULT '' COMMENT '数据表的ID字段名',
  `name_field` varchar(100) NOT NULL DEFAULT '' COMMENT '数据表的name字段名',
  `inid` varchar(1000) NOT NULL DEFAULT '' COMMENT '文档ID的集合，以逗号隔开',
  `recommend_order` int(11) NOT NULL DEFAULT '0' COMMENT '推荐位排序',
  PRIMARY KEY (`recommend_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>