<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_pay`;");
E_C("CREATE TABLE `user_pay` (
  `pay_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '本站订单号 唯一',
  `order_id` int(11) NOT NULL DEFAULT '0' COMMENT '商品订单id',
  `coupons_id` int(11) NOT NULL DEFAULT '0' COMMENT '优惠券id',
  `user_money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '会员余额',
  `pay_trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '服务商的订单号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `sessionid` varchar(50) NOT NULL DEFAULT '' COMMENT '游客会话id',
  `money` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '充值金额',
  `pay_time` int(11) NOT NULL DEFAULT '0' COMMENT '支付创建时间',
  `pay_time_complete` int(11) NOT NULL DEFAULT '0' COMMENT '支付成功时间',
  `pay_state` int(11) NOT NULL DEFAULT '0' COMMENT '支付状态（成功=1，失败=0）',
  `pay_type` int(11) NOT NULL DEFAULT '0' COMMENT '支付方式（支付宝=1，财付通=2,网银在线=3...）',
  `ip` varchar(50) NOT NULL DEFAULT '' COMMENT 'IP地址',
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `user_pay` values('1','201312241201567766','2','0','0.00','','10000','','15.00','1387857716','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('2','201312241234061479','2','0','0.00','','10000','','15.00','1387859646','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('3','201312241234521751','2','0','0.00','','10000','','15.00','1387859692','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('4','201312241237235778','2','0','0.00','','10000','','15.00','1387859843','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('5','201312241238585856','2','0','0.00','','10000','','15.00','1387859938','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('6','201312241241462290','2','0','0.00','','10000','','15.00','1387860106','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('7','201312241247154003','2','0','0.00','','10000','','15.00','1387860435','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('8','201312241256242170','2','0','0.00','','10000','','15.00','1387860984','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('9','201312241309169884','2','0','0.00','','10000','','15.00','1387861756','0','0','1','110.80.91.26');");
E_D("replace into `user_pay` values('10','201312241309353308','2','0','0.00','','10000','','15.00','1387861775','0','0','3','110.80.91.26');");
E_D("replace into `user_pay` values('11','201401081636511476','10','0','0.00','','10000','','1208.00','1389170211','0','0','1','120.36.149.135');");
E_D("replace into `user_pay` values('12','201404062123251541','29','0','0.00','','10000','','8.00','1396790605','0','0','3','112.5.252.92');");

require("../../inc/footer.php");
?>