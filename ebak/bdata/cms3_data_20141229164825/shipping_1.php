<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `shipping`;");
E_C("CREATE TABLE `shipping` (
  `shipping_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID号',
  `shipping_code` varchar(20) NOT NULL COMMENT '配送方式的字符串代号',
  `shipping_name` varchar(120) NOT NULL COMMENT '配送方式的名称',
  `shipping_desc` varchar(255) NOT NULL COMMENT '配送方式的描述',
  `insure` varchar(10) NOT NULL DEFAULT '0' COMMENT '保价费用，单位元，或者是百分数，该值直接输出为报价费用',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '该配送方式是否被禁用，1，可用；0，禁用',
  PRIMARY KEY (`shipping_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='配送方式配置信息表'");
E_D("replace into `shipping` values('9','','顺丰速递','','15','1');");
E_D("replace into `shipping` values('10','','圆通快递','','8','1');");

require("../../inc/footer.php");
?>