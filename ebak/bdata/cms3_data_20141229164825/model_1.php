<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `model`;");
E_C("CREATE TABLE `model` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '模型ID',
  `model_type` int(11) NOT NULL DEFAULT '0' COMMENT '0=内容模型，1=表单模型（独立表）',
  `parent_model_id` int(11) NOT NULL DEFAULT '0' COMMENT '父模型id',
  `model_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型名称',
  `model_table_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模型的表名称',
  `cmodel_id` varchar(100) NOT NULL DEFAULT '0' COMMENT '模型子表的ID',
  `is_system` int(11) NOT NULL DEFAULT '0' COMMENT '是否是系统',
  PRIMARY KEY (`model_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `model` values('8','0','0','文章','article','0','0');");
E_D("replace into `model` values('9','1','0','在线留言','message','0','0');");

require("../../inc/footer.php");
?>