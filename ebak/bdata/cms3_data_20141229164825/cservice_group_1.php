<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice_group`;");
E_C("CREATE TABLE `cservice_group` (
  `groupid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID',
  `groupname` varchar(50) NOT NULL DEFAULT '' COMMENT '用户组名称',
  `sno` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '录入者',
  `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加日期',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统用户组'");
E_D("replace into `cservice_group` values('1','技术组','0','0','0');");
E_D("replace into `cservice_group` values('2','编辑组','0','0','0');");

require("../../inc/footer.php");
?>