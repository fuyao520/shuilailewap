<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_fans`;");
E_C("CREATE TABLE `user_fans` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注人（主动）',
  `uid2` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '被关注人',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '关注时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='用户-粉丝/关注'");
E_D("replace into `user_fans` values('3','10002','10004','1411376587');");
E_D("replace into `user_fans` values('4','10011','10004','1411962865');");

require("../../inc/footer.php");
?>