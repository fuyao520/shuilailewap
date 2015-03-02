<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `info_special`;");
E_C("CREATE TABLE `info_special` (
  `special_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '专题id',
  `cate_id_top` int(11) NOT NULL DEFAULT '0' COMMENT '顶级类别id',
  `special_parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '专题上级分类',
  `special_name` varchar(100) NOT NULL DEFAULT '' COMMENT '专题名称',
  `special_desc` varchar(8000) NOT NULL DEFAULT '' COMMENT '专题介绍',
  `special_img` varchar(500) NOT NULL DEFAULT '' COMMENT '专题缩略图',
  `special_banner` varchar(500) NOT NULL DEFAULT '' COMMENT '专题横幅',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '专题模版',
  `sorder` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `typesetting` text NOT NULL COMMENT '本专题的小分类json格式,   如 1=>最新报道 2=>视频报道等自定义 ',
  `info_id` int(11) NOT NULL DEFAULT '0' COMMENT '资讯的ID',
  `special_editor` varchar(50) NOT NULL DEFAULT '' COMMENT '会员名称',
  `uid` int(11) NOT NULL DEFAULT '0',
  `audit` int(11) NOT NULL DEFAULT '0',
  `jump_url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '创建日期',
  PRIMARY KEY (`special_id`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>