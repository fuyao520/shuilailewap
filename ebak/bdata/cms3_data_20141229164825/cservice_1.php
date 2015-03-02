<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice`;");
E_C("CREATE TABLE `cservice` (
  `csno` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `csname` char(8) NOT NULL DEFAULT '' COMMENT '客服名',
  `groupid` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '用户组',
  `cspwd` varchar(128) NOT NULL DEFAULT '' COMMENT '密码',
  `cssalt` varchar(32) NOT NULL DEFAULT '' COMMENT 'salt',
  `cscreated` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `csemail` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `csmobile` varchar(50) NOT NULL DEFAULT '' COMMENT '手机',
  `csstatus` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态',
  `csname_true` varchar(40) NOT NULL DEFAULT '' COMMENT '真实姓名',
  PRIMARY KEY (`csno`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统用户'");
E_D("replace into `cservice` values('1','admin','0','57fff0ea55146baa6ac1a9999dfcd1ad','','0','','','0','');");
E_D("replace into `cservice` values('2','xiaoli','2','ab0bf52d21d8244bd24b44a400b6f1f5','','0','1783427@qq.com','','0','编辑小李');");

require("../../inc/footer.php");
?>