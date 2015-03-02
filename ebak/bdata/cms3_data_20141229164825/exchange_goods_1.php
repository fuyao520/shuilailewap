<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `exchange_goods`;");
E_C("CREATE TABLE `exchange_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `exchange_point` int(11) NOT NULL DEFAULT '0' COMMENT '兑换积分',
  `is_exchange` int(11) NOT NULL DEFAULT '0' COMMENT '是否可兑换',
  `is_hot` int(11) NOT NULL DEFAULT '0' COMMENT '是否热销',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED");
E_D("replace into `exchange_goods` values('1','6','1','2000','1','0');");
E_D("replace into `exchange_goods` values('2','7','2','700','1','0');");

require("../../inc/footer.php");
?>