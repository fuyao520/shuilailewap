<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_order`;");
E_C("CREATE TABLE `user_order` (
  `user_order_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '订单id',
  `trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '本站订单号 唯一',
  `pay_trade_no` varchar(50) NOT NULL DEFAULT '' COMMENT '服务商的订单号',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `sessionid` varchar(50) NOT NULL DEFAULT '' COMMENT '游客会话id',
  `pay_type` int(11) NOT NULL DEFAULT '0' COMMENT '支付方式（支付宝=1，财付通=2,网银在线=3...）',
  `order_state` int(11) NOT NULL DEFAULT '0' COMMENT '订单状态(0=等待付款,1=已经付款，等待发货,2=已发货，等待确认收货,3=交易成功)',
  `invoice_number` varchar(100) NOT NULL DEFAULT '' COMMENT '发货单号',
  `consignee` varchar(60) NOT NULL COMMENT '收货人的姓名，用户页面填写，默认取值于表user_address',
  `send_goods` int(11) NOT NULL DEFAULT '0' COMMENT '发货状态（0=未发货,1=已发货）',
  `address` varchar(255) NOT NULL COMMENT '收货人的详细地址，用户页面填写，默认取值于表user_address',
  `mobile` varchar(60) NOT NULL COMMENT '收货人的手机，用户页面填写，默认取值于表user_address',
  `tel` varchar(50) NOT NULL DEFAULT '' COMMENT '电话号码',
  `email` varchar(60) NOT NULL COMMENT '收货人的手机，用户页面填写，默认取值于表user_address',
  `postscript` varchar(255) NOT NULL COMMENT '订单附言，由用户提交订单前填写',
  `tohours` varchar(50) NOT NULL DEFAULT '' COMMENT '送到时间段（用户选择）',
  `shipping_id` tinyint(3) NOT NULL DEFAULT '0' COMMENT '用户选择的配送方式id，取值表ecs_shipping',
  `shipping_name` varchar(120) NOT NULL COMMENT '用户选择的配送方式的名称，取值表ecs_shipping',
  `shipping_fee` int(11) NOT NULL DEFAULT '0' COMMENT '配送费用',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '是否参加了优惠活动0=否，1=是',
  `gift_detail` varchar(120) NOT NULL DEFAULT '' COMMENT '优惠说明',
  `order_cate` int(11) NOT NULL DEFAULT '0' COMMENT '订单分类,1=快点,2=金和楼,3=综合',
  `order_money_count` decimal(11,2) NOT NULL DEFAULT '0.00' COMMENT '总计',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '订单创建时间',
  `pay_time_complete` int(11) NOT NULL DEFAULT '0' COMMENT '完成付款时间',
  `extension_code` varchar(30) NOT NULL COMMENT '通过活动购买的商品的代号；exchange_goods是积分商城，GROUP_BUY是团购；AUCTION，是拍卖；正常普通产品该处为空',
  `extension_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '通过活动购买的物品的id',
  `integral` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '使用的积分数量',
  PRIMARY KEY (`user_order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `user_order` values('1','201312240935068563','','10000','','8','1','','周飞','0','江西省','18607002510','18607002510','','','undefined','9','顺丰速递','15','0','','0','15.00','1387848906','0','','0','0');");
E_D("replace into `user_order` values('3','201312241018323466','','10000','','8','1','','周飞','0','江西省','18607002510','18607002510','','','undefined','9','顺丰速递','15','0','','0','15.00','1387851512','0','','0','0');");
E_D("replace into `user_order` values('4','201312241026389910','','0','54817f2553151730b1220c5414a4bde4','8','1','','feifei2','0','fjasdlkjfasdfasdf','18650182402','92834','','','undefined','9','顺丰速递','15','0','','0','15.00','1387851998','0','','0','0');");
E_D("replace into `user_order` values('7','201401081420499361','','10000','','8','1','','周飞','0','江西省','18607002510','18607002510','','','undefined','9','顺丰速递','15','0','','0','491.00','1389162049','0','','0','0');");
E_D("replace into `user_order` values('10','201401081623524451','','10000','','8','1','','周飞','0','江西省','18607002510','18607002510','','','undefined','10','圆通快递','8','0','','0','1208.00','1382069432','0','','0','0');");
E_D("replace into `user_order` values('23','201401101513461910','','10000','','8','1','','周飞','0','河北省张家口市下花园区红谷经典203','18650182402','','','','undefined','9','顺丰速递','15','0','','0','275.00','1389338026','0','','0','0');");

require("../../inc/footer.php");
?>