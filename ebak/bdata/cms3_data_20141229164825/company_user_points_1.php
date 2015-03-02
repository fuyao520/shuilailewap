<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `company_user_points`;");
E_C("CREATE TABLE `company_user_points` (
  `points_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'points_id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `points` int(11) DEFAULT NULL COMMENT 'points',
  `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '积分产生时间',
  `points_reason` varchar(100) NOT NULL DEFAULT '' COMMENT '积分产生原因',
  PRIMARY KEY (`points_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员-积分'");

require("../../inc/footer.php");
?>