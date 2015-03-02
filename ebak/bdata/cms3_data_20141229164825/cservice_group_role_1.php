<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice_group_role`;");
E_C("CREATE TABLE `cservice_group_role` (
  `groupid` smallint(6) unsigned NOT NULL COMMENT '用户组ID',
  `role_id` char(32) NOT NULL DEFAULT '' COMMENT '角色ID',
  `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`groupid`,`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='用户组 - 角色'");
E_D("replace into `cservice_group_role` values('1','1','0');");
E_D("replace into `cservice_group_role` values('2','2','0');");

require("../../inc/footer.php");
?>