<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `order_goods`;");
E_C("CREATE TABLE `order_goods` (
  `order_goods_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单商品信息自增id',
  `order_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品信息对应的详细信息id，取值order_info的order_id',
  `goods_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '商品的的id，取值表ecs_goods 的goods_id',
  `goods_name` varchar(120) NOT NULL COMMENT '商品的名称，取值表ecs_goods ',
  `goods_img` varchar(120) NOT NULL COMMENT '商品的缩略图',
  `goods_sn` varchar(60) NOT NULL COMMENT '商品的唯一货号，取值ecs_goods ',
  `goods_number` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '商品的购买数量',
  `market_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品的市场售价，取值ecs_goods ',
  `goods_price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '商品的本店售价，取值ecs_goods ',
  `goods_attr` text NOT NULL COMMENT '购买该商品时所选择的属性；',
  `send_number` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '当不是实物时，是否已发货，0，否；1，是',
  `is_real` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否是实物，0，否；1，是；取值ecs_goods ',
  `extension_code` varchar(30) NOT NULL COMMENT '商品的扩展属性，比如像虚拟卡。取值ecs_goods ',
  `parent_id` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '父商品id，取值于ecs_cart的parent_id；如果有该值则是值多代表的物品的配件',
  `is_gift` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '是否参加优惠活动，0，否；其他，取值于ecs_cart 的is_gift，跟其一样，是参加的优惠活动的id',
  `gift_detail` varchar(120) NOT NULL DEFAULT '' COMMENT '优惠说明',
  PRIMARY KEY (`order_goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='订单的商品信息'");
E_D("replace into `order_goods` values('1','1','8','MT履带反击破移动破','/img/upload/2013/12/23/201312231908368554.jpg','','2','0.00','0.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('2','2','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','0.00','0.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('3','3','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','0.00','0.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('4','4','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','2','0.00','0.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('5','4','8','MT履带反击破移动破','/img/upload/2013/12/23/201312231908368554.jpg','','1','0.00','0.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('6','5','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','3','238.00','238.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('7','5','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','','0','1','','0','0','');");
E_D("replace into `order_goods` values('8','6','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[{\"attr_type_id\":\"4205\",\"attr_type_name\":\"内存大小\",\"attr_id\":\"4\",\"attr_name\":\"16G\"},{\"attr_type_id\":\"4204\",\"attr_type_name\":\"颜色\",\"attr_id\":\"6\",\"attr_name\":\"白色+2\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('9','7','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[{\"attr_type_id\":\"4205\",\"attr_type_name\":\"内存大小\",\"attr_id\":\"4\",\"attr_name\":\"16G\",\"attr_price\":\"20\"},{\"attr_type_id\":\"4204\",\"attr_type_name\":\"颜色\",\"attr_id\":\"2\",\"attr_name\":\"绿色\",\"attr_price\":\"0.00\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('10','7','8','MT履带反击破移动破','/img/upload/2013/12/23/201312231908368554.jpg','','1','0.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('11','7','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[{\"attr_type_id\":\"4205\",\"attr_type_name\":\"内存大小\",\"attr_id\":\"5\",\"attr_name\":\"24G\",\"attr_price\":\"60\"},{\"attr_type_id\":\"4204\",\"attr_type_name\":\"颜色\",\"attr_id\":\"6\",\"attr_name\":\"白色+2\",\"attr_price\":\"2\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('12','8','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','3','238.00','258.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"4\",\"info_id\":\"7\",\"corder\":\"1\",\"attr_name\":\"16G\",\"attr_price\":\"20.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"2\",\"info_id\":\"7\",\"corder\":\"20\",\"attr_name\":\"\\\\u7eff\\\\u8272\",\"attr_price\":\"0.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('13','8','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','248.50','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"3\",\"info_id\":\"7\",\"corder\":\"0\",\"attr_name\":\"8G\",\"attr_price\":\"10.50\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"2\",\"info_id\":\"7\",\"corder\":\"20\",\"attr_name\":\"\\\\u7eff\\\\u8272\",\"attr_price\":\"0.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('14','9','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','3','238.00','300.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"5\",\"info_id\":\"7\",\"corder\":\"2\",\"attr_name\":\"24G\",\"attr_price\":\"60.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"6\",\"info_id\":\"7\",\"corder\":\"22\",\"attr_name\":\"\\\\u767d\\\\u8272+2\",\"attr_price\":\"2.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('15','10','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','4','238.00','300.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"5\",\"info_id\":\"7\",\"corder\":\"2\",\"attr_name\":\"24G\",\"attr_price\":\"60.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"6\",\"info_id\":\"7\",\"corder\":\"22\",\"attr_name\":\"\\\\u767d\\\\u8272+2\",\"attr_price\":\"2.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('16','11','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','2','238.00','260.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"4\",\"info_id\":\"7\",\"corder\":\"1\",\"attr_name\":\"16G\",\"attr_price\":\"20.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"6\",\"info_id\":\"7\",\"corder\":\"22\",\"attr_name\":\"\\\\u767d\\\\u8272+2\",\"attr_price\":\"2.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('17','11','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','260.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"4\",\"info_id\":\"7\",\"corder\":\"1\",\"attr_name\":\"16G\",\"attr_price\":\"20.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"6\",\"info_id\":\"7\",\"corder\":\"22\",\"attr_name\":\"\\\\u767d\\\\u8272+2\",\"attr_price\":\"2.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('18','12','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('19','13','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('20','14','6','CC 圆锥破碎机','/img/2013/12/23/52b8193e3417b.jpg','','1','210.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('21','15','6','CC 圆锥破碎机','/img/2013/12/23/52b8193e3417b.jpg','','1','210.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('22','16','6','CC 圆锥破碎机','/img/2013/12/23/52b8193e3417b.jpg','','1','210.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('23','17','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','3','238.00','114.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('24','18','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('25','19','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('26','20','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('27','21','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('28','22','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','238.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('29','23','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','260.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"4\",\"info_id\":\"7\",\"corder\":\"1\",\"attr_name\":\"16G\",\"attr_price\":\"20.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"6\",\"info_id\":\"7\",\"corder\":\"22\",\"attr_name\":\"\\\\u767d\\\\u8272+2\",\"attr_price\":\"2.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('30','24','8','MT履带反击破移动破','/img/upload/2013/12/23/201312231908368554.jpg','','1','0.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('31','25','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','248.50','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"3\",\"info_id\":\"7\",\"corder\":\"0\",\"attr_name\":\"8G\",\"attr_price\":\"10.50\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"2\",\"info_id\":\"7\",\"corder\":\"20\",\"attr_name\":\"\\\\u7eff\\\\u8272\",\"attr_price\":\"0.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('32','26','8','MT履带反击破移动破','/img/upload/2013/12/23/201312231908368554.jpg','','1','0.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('33','27','8','MT履带反击破移动破','/img/upload/2013/12/23/201312231908368554.jpg','','1','0.00','0.00','[]','0','1','','0','0','');");
E_D("replace into `order_goods` values('34','28','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','260.00','[{\"attr_type_name\":\"\\\\u5185\\\\u5b58\\\\u5927\\\\u5c0f\",\"id\":\"4\",\"info_id\":\"7\",\"corder\":\"1\",\"attr_name\":\"16G\",\"attr_price\":\"20.00\",\"attr_img\":\"\",\"attr_type_id\":\"4205\"},{\"attr_type_name\":\"\\\\u989c\\\\u8272\",\"id\":\"6\",\"info_id\":\"7\",\"corder\":\"22\",\"attr_name\":\"\\\\u767d\\\\u8272+2\",\"attr_price\":\"2.00\",\"attr_img\":\"\",\"attr_type_id\":\"4204\"}]','0','1','','0','0','');");
E_D("replace into `order_goods` values('35','29','7','YKR 系列圆振筛','/img/2013/12/23/52b8196a3fb24.jpg','','1','238.00','0.00','[]','0','1','','0','0','');");

require("../../inc/footer.php");
?>