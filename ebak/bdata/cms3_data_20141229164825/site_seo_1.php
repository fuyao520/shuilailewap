<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `site_seo`;");
E_C("CREATE TABLE `site_seo` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `mark` varchar(200) NOT NULL DEFAULT '' COMMENT '备注',
  `url` varchar(400) NOT NULL COMMENT '页面地址',
  `seo_title` varchar(400) NOT NULL DEFAULT '' COMMENT 'seo标题',
  `seo_keyword` varchar(400) NOT NULL DEFAULT '' COMMENT 'seo关键词',
  `seo_description` varchar(800) NOT NULL DEFAULT '' COMMENT 'seo描述',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `displayorder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示顺序',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='seo页面设置'");
E_D("replace into `site_seo` values('1','首页','/','FFFeicms-yii版','Feicms-yii版','Feicms-yii版','0','50');");
E_D("replace into `site_seo` values('2','关于我们','/list-107-1.html','关于我们呵呵呵呵呵呵','','','0','50');");

require("../../inc/footer.php");
?>