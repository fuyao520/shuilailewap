<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_login`;");
E_C("CREATE TABLE `user_login` (
  `logs_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `login_date` int(11) NOT NULL DEFAULT '0' COMMENT '登录时间',
  `login_ip` varchar(100) NOT NULL DEFAULT '' COMMENT '登录地址',
  PRIMARY KEY (`logs_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>