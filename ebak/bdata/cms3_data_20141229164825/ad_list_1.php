<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `ad_list`;");
E_C("CREATE TABLE `ad_list` (
  `ad_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `area_id` int(11) NOT NULL DEFAULT '0' COMMENT '广告位',
  `city_id` int(11) NOT NULL DEFAULT '0' COMMENT '城市ID',
  `show_type` int(11) NOT NULL DEFAULT '0' COMMENT '展现方式, 0=代码,1=文字,2=图片,3=flash',
  `ad_title` varchar(255) NOT NULL DEFAULT '' COMMENT '广告标题',
  `ad_words` varchar(255) NOT NULL DEFAULT '' COMMENT '文字',
  `ad_img` text NOT NULL COMMENT '图片URL',
  `ad_url` text NOT NULL COMMENT '广告URL',
  `url_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '分类作为url',
  `words_setting` text COMMENT '文字格式，加粗，颜色，倾斜，下划线，json格式',
  `ad_code` text NOT NULL COMMENT '广告代码',
  `start_date` int(11) NOT NULL DEFAULT '0' COMMENT '生效时间',
  `expire_date` int(11) NOT NULL DEFAULT '0' COMMENT '到期时间',
  `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ad_order` int(11) NOT NULL DEFAULT '0' COMMENT '广告排序',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>