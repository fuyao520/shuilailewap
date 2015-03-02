<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `linkage_type`;");
E_C("CREATE TABLE `linkage_type` (
  `linkage_type_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `linkage_type_name` varchar(100) NOT NULL DEFAULT '' COMMENT '名称',
  `linkage_type_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`linkage_type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `linkage_type` values('1','世界地区','0');");
E_D("replace into `linkage_type` values('14','商品属性','0');");
E_D("replace into `linkage_type` values('15','商品分类','0');");
E_D("replace into `linkage_type` values('16','手游类型','0');");

require("../../inc/footer.php");
?>