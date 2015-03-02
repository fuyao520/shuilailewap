<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `recv_address`;");
E_C("CREATE TABLE `recv_address` (
  `recv_address_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '地址id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `recv_address` varchar(255) NOT NULL DEFAULT '' COMMENT '收货地址',
  `recv_contact` varchar(20) NOT NULL DEFAULT '' COMMENT '联系人',
  `recv_cellphone` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  `recv_tel` varchar(50) NOT NULL DEFAULT '' COMMENT '电话号码',
  `recv_email` varchar(20) NOT NULL DEFAULT '' COMMENT '邮箱',
  `citydata` varchar(200) NOT NULL DEFAULT '' COMMENT '城市区域，json格式',
  `zip_code` varchar(20) NOT NULL DEFAULT '' COMMENT '邮政编码',
  `is_default` int(11) NOT NULL DEFAULT '0' COMMENT '是否为默认收货地址',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`recv_address_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `recv_address` values('1','10000','红谷经典203','周飞','18650182402','','333332','{\"province\":\"108\",\"city\":\"145\",\"area\":\"149\",\"province_txt\":\"\\\\u6cb3\\\\u5317\\\\u7701\",\"city_txt\":\"\\\\u5f20\\\\u5bb6\\\\u53e3\\\\u5e02\",\"area_txt\":\"\\\\u4e0b\\\\u82b1\\\\u56ed\\\\u533a\"}','','1','1389173473');");

require("../../inc/footer.php");
?>