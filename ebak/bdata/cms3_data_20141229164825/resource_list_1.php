<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `resource_list`;");
E_C("CREATE TABLE `resource_list` (
  `resource_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '关系ID',
  `fromid` varchar(50) NOT NULL DEFAULT '0' COMMENT '标识',
  `resource_url` varchar(255) NOT NULL DEFAULT '' COMMENT '资源地址',
  `resource_type` int(11) NOT NULL DEFAULT '0' COMMENT '资源类型（图片=1，FLASH=2，视频=3，下载=4）',
  `r_width` int(11) NOT NULL DEFAULT '0' COMMENT '资源宽度',
  `r_height` int(11) NOT NULL DEFAULT '0' COMMENT '资源高度',
  `r_size` int(11) NOT NULL DEFAULT '0' COMMENT '资源大小',
  `resource_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `r_name` varchar(100) NOT NULL DEFAULT '' COMMENT '资源名称',
  `mark` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '属性标记',
  PRIMARY KEY (`resource_id`)
) ENGINE=MyISAM AUTO_INCREMENT=114811 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `resource_list` values('114803','0','/uploadfile/2014/12/25/201412251527130895.jpg','0','0','0','0','0','54706d9e4538e','0');");
E_D("replace into `resource_list` values('114804','0','/uploadfile/2014/12/25/201412251527133085.png','0','0','0','0','0','54706d2d29278','0');");
E_D("replace into `resource_list` values('114805','0','/uploadfile/2014/12/25/549bdd6c69d6d.jpg','1','72','72','4908','50','1jpg','0');");
E_D("replace into `resource_list` values('114806','0','/uploadfile/2014/12/25/549bdd98a9359.png','1','200','200','37985','50','1418177796402','0');");
E_D("replace into `resource_list` values('114807','0','/uploadfile/2014/12/25/549bdea5b0816.jpg','1','72','72','4908','50','1jpg','0');");
E_D("replace into `resource_list` values('114808','0','/uploadfile/2014/12/25/549bdea9b54f3.jpg','1','72','72','5047','50','2','0');");
E_D("replace into `resource_list` values('114809','0','/uploadfile/2014/12/25/549bdec5150ae.jpg','1','72','72','4908','50','1jpg','0');");
E_D("replace into `resource_list` values('114810','0','/uploadfile/2014/12/25/549bdeeaa9089.png','1','200','200','37985','50','1418177796402','0');");

require("../../inc/footer.php");
?>