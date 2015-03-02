<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `exchange_code`;");
E_C("CREATE TABLE `exchange_code` (
  `exchange_code_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '兑换码id',
  `exchange_code` varchar(50) NOT NULL DEFAULT '' COMMENT '兑换码',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `exchange_state` int(11) NOT NULL DEFAULT '0' COMMENT '兑换状态(0=未兑换,1=已兑换)',
  `exchange_time` int(11) NOT NULL DEFAULT '0' COMMENT '兑换时间',
  PRIMARY KEY (`exchange_code_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>