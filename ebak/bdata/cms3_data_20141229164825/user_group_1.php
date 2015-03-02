<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_group`;");
E_C("CREATE TABLE `user_group` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '组ID',
  `group_name` varchar(50) NOT NULL DEFAULT '' COMMENT '组名称',
  `is_system` text NOT NULL COMMENT '是否是系统',
  `group_level` text NOT NULL COMMENT 'json格式,组权限',
  `group_rank` int(11) NOT NULL DEFAULT '0' COMMENT '权限值',
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `user_group` values('1','普通会员','','null','1');");

require("../../inc/footer.php");
?>