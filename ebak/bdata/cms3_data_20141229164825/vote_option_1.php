<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `vote_option`;");
E_C("CREATE TABLE `vote_option` (
  `option_id` int(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '选项ID',
  `subject_id` int(8) unsigned NOT NULL DEFAULT '0',
  `option` varchar(255) NOT NULL DEFAULT '' COMMENT '选项名称',
  `option_order` tinyint(2) unsigned DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`option_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `vote_option` values('1','1','苹果','0');");
E_D("replace into `vote_option` values('2','1','橘子','1');");
E_D("replace into `vote_option` values('3','1','雪梨','2');");

require("../../inc/footer.php");
?>