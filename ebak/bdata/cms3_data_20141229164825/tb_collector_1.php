<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `tb_collector`;");
E_C("CREATE TABLE `tb_collector` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '名字',
  `product_cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类',
  `keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '采集关键词',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `runtimes` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '运行次数',
  `totals` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '采集总数量',
  `displayorder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `last_time` int(11) unsigned NOT NULL COMMENT '最后一次运行时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='淘宝客采集器'");

require("../../inc/footer.php");
?>