<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `collector`;");
E_C("CREATE TABLE `collector` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
  `name` varchar(200) NOT NULL DEFAULT '' COMMENT '名字',
  `cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '栏目分类',
  `product_cate_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品分类',
  `keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '采集关键词',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `mark` varchar(100) NOT NULL DEFAULT '' COMMENT '备注',
  `runtimes` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '运行次数',
  `totals` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '采集总数量',
  `displayorder` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '显示顺序',
  `last_time` int(11) unsigned NOT NULL COMMENT '最后一次运行时间',
  `pageurl` varchar(255) NOT NULL DEFAULT '' COMMENT '分页url',
  `pagenums` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '页数',
  `nowpage` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '当前采集到第几页',
  `collect_type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '采集标识类型',
  `collect_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '采集标识第几个元素',
  `list_rule` varchar(255) NOT NULL DEFAULT '' COMMENT '列表页正则',
  `detail_rule` text COMMENT '内容页正则(json格式)',
  `detailurl` varchar(255) NOT NULL DEFAULT '' COMMENT '内容页url',
  `model_table` varchar(50) NOT NULL DEFAULT '' COMMENT '模型表',
  `list_title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题第几个元素',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='采集器'");

require("../../inc/footer.php");
?>