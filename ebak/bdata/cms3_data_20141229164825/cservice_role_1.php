<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice_role`;");
E_C("CREATE TABLE `cservice_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色标识',
  `role_name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名称',
  `role_status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `b_module` char(10) NOT NULL DEFAULT '' COMMENT '所属模块',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统角色'");
E_D("replace into `cservice_role` values('1','超级管理员','0','');");
E_D("replace into `cservice_role` values('2','编辑人员','0','');");

require("../../inc/footer.php");
?>