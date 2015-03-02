<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice_roles`;");
E_C("CREATE TABLE `cservice_roles` (
  `sno` mediumint(8) unsigned NOT NULL COMMENT '客服ID',
  `role_id` char(32) NOT NULL COMMENT '角色ID',
  `created` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`sno`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='系统用户 - 角色'");
E_D("replace into `cservice_roles` values('2','2','0');");

require("../../inc/footer.php");
?>