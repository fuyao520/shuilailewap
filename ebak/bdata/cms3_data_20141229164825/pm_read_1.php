<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `pm_read`;");
E_C("CREATE TABLE `pm_read` (
  `read_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pm_id` int(11) NOT NULL DEFAULT '0' COMMENT '阅读用户ID',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '阅读用户ID',
  `read_date` int(11) NOT NULL DEFAULT '0' COMMENT '阅读时间，判断用户是否已读',
  PRIMARY KEY (`read_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED");

require("../../inc/footer.php");
?>