<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `rewrite`;");
E_C("CREATE TABLE `rewrite` (
  `rewrite_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '伪静态id',
  `rewrite_node` varchar(50) NOT NULL DEFAULT '' COMMENT '节点',
  `rewrite_ident` varchar(50) NOT NULL DEFAULT '' COMMENT '调用标识',
  `rewrite_name` varchar(100) NOT NULL DEFAULT '' COMMENT '伪静态名称',
  `rewrite_type` int(11) NOT NULL DEFAULT '0' COMMENT '类型(0=列表,1=详情页)',
  `rewrite_example` varchar(255) NOT NULL DEFAULT '' COMMENT '示例',
  `true_url` varchar(255) NOT NULL DEFAULT '' COMMENT 'url原型',
  `rewrite_rule` varchar(255) NOT NULL DEFAULT '' COMMENT '伪静态规则',
  `rewrite_page_rule` varchar(255) NOT NULL DEFAULT '' COMMENT '伪静态规则（页码）',
  `rewrite_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`rewrite_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `rewrite` values('1','','','资讯详情页','1','/details/1.html','','/details/{info_id}.html','/details/{info_id}_{p}.html','3');");
E_D("replace into `rewrite` values('2','','','拼音根目录','0','/news/','','/{cname_py}/','/{cname_py}/{p}.html','1');");
E_D("replace into `rewrite` values('3','','','商品详情页','1','/goods/1.html','','/goods/{info_id}.html','/goods/{info_id}_{p}.html','4');");
E_D("replace into `rewrite` values('4','','','list简洁风格','0','list-2-1.html','','/list-{cate_id}-1.html','/list-{cate_id}-{p}.html','5');");
E_D("replace into `rewrite` values('5','','','detail通用风格','1','detail-2-104.html','','/detail-{cate_id}-{info_id}.html','','2');");

require("../../inc/footer.php");
?>