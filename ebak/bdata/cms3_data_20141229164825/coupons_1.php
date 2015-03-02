<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `coupons`;");
E_C("CREATE TABLE `coupons` (
  `coupons_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `coupons_state` int(11) NOT NULL DEFAULT '0' COMMENT '优惠卷状态(0=未使用,1=已使用)',
  `coupons_money` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '优惠卷面值',
  `sent_time` int(11) NOT NULL DEFAULT '0' COMMENT '赠送时间',
  `expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间',
  PRIMARY KEY (`coupons_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED");

require("../../inc/footer.php");
?>