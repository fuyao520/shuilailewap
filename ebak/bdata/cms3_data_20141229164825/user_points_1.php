<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_points`;");
E_C("CREATE TABLE `user_points` (
  `points_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `points` int(11) NOT NULL DEFAULT '0' COMMENT '积分数值，有符号整数，获取>0，消耗<0',
  `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '积分产生时间',
  `points_reason` varchar(100) NOT NULL DEFAULT '' COMMENT '积分产生原因',
  PRIMARY KEY (`points_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `user_points` values('1','10000','23244','1389255290','看你帅送给你');");
E_D("replace into `user_points` values('2','10000','700','1389257930','积分商城消费，订单号 201401091658504913');");
E_D("replace into `user_points` values('3','10000','700','1389258125','积分商城消费，订单号 201401091702051218');");
E_D("replace into `user_points` values('4','10000','-2000','1389258191','积分商城消费，订单号 201401091703118797');");
E_D("replace into `user_points` values('5','10000','-2000','1389258875','积分商城消费，订单号 201401091714356796');");
E_D("replace into `user_points` values('6','10000','-2000','1389258875','积分商城消费，订单号 201401091714357930');");
E_D("replace into `user_points` values('7','10000','-700','1396790529','积分商城消费，订单号 201404062122093059');");

require("../../inc/footer.php");
?>