<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `activity`;");
E_C("CREATE TABLE `activity` (
  `activity_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠活动的自增id',
  `activity_name` varchar(255) NOT NULL DEFAULT '' COMMENT '优惠活动的活动名称',
  `start_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动的开始时间',
  `end_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动的结束时间',
  `user_rank` int(11) NOT NULL DEFAULT '0' COMMENT '可以参加活动的用户信息，0=非会员，1=会员；2=所有',
  `act_range` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '优惠范围；0，全部商品；1，按分类；2，按品牌；3，按商品',
  `act_range_ext` varchar(255) NOT NULL COMMENT '根据优惠活动范围的不同，该处意义不同；但是都是优惠范围的约束；如，如果是商品，该处是商品的id，如果是品牌，该处是品牌的id',
  `min_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单达到金额下限，才参加活动',
  `max_amount` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '参加活动的订单金额下限，0，表示没有上限',
  `act_type` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '参加活动的优惠方式；0，减免现金；1，价格打折优惠',
  `act_type_ext` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '如果是送赠品，该处是允许的最大数量，0，无数量限制；现今减免，则是减免金额，单位元；打折，是折扣值，100算，8折就是80',
  `gift` text NOT NULL COMMENT '如果有特惠商品，这里是序列化后的特惠商品的id,name,price信息;取值于ecs_goods的goods_id，goods_name，价格是添加活动时填写的',
  `sort_order` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '活动在优惠活动页面显示的先后顺序，数字越大越靠后',
  PRIMARY KEY (`activity_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='优惠活动的配置信息，优惠活动包括送礼，减免，打折'");

require("../../inc/footer.php");
?>