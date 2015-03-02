<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_star`;");
E_C("CREATE TABLE `user_star` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `cover` varchar(255) NOT NULL DEFAULT '' COMMENT '图片',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '推荐时间',
  `reason` varchar(100) NOT NULL DEFAULT '' COMMENT '推荐理由',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户-达人'");
E_D("replace into `user_star` values('1','10007','/static/default/images/2.jpg','1411056000','让女人更美丽');");
E_D("replace into `user_star` values('2','10004','/uploadfile/2014/09/24/54228a18ec965.jpeg','1411488000','骨灰级买家');");

require("../../inc/footer.php");
?>