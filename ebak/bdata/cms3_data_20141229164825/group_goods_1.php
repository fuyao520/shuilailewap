<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `group_goods`;");
E_C("CREATE TABLE `group_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `group_goods_name` varchar(255) NOT NULL DEFAULT '' COMMENT '团购名称',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品id',
  `goods_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `group_price` decimal(11,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '团购价',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `restrict_amount` int(11) NOT NULL DEFAULT '0' COMMENT '达到此数量，团购活动自动结束。0表示没有数量限制。',
  `act_desc` text NOT NULL COMMENT '活动介绍',
  `ladder` text NOT NULL COMMENT '价格阶梯,json 格式  [{\"amount\":10,\"price\":330},{\"amount\":20,\"price\":300}]',
  `is_finish` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否结束',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `group_goods` values('1','【量贩团】二十年绍兴黄酒 1500ml团酒礼坛','8','0','120.00','1241971200','1427091200','0','askdfjasjdklfjasdlkfj','[{\"amount\":1,\"price\":200},{\"amount\":10,\"price\":170}]','0');");
E_D("replace into `group_goods` values('2','超级优惠团购YKR 系列圆振筛','7','0','104.00','1241971200','1521091200','0','','[{\"amount\":1,\"price\":260},{\"amount\":10,\"price\":235}]','0');");

require("../../inc/footer.php");
?>