<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `company`;");
E_C("CREATE TABLE `company` (
  `company_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '公司id',
  `company_logo` varchar(100) NOT NULL DEFAULT '' COMMENT '公司logo',
  `company_banner` varchar(100) NOT NULL DEFAULT '' COMMENT 'banner横幅',
  `company_name` varchar(100) NOT NULL DEFAULT '' COMMENT '公司名称',
  `seo_title` varchar(100) NOT NULL DEFAULT '' COMMENT '首页seo标题',
  `seo_keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '首页seo关键词',
  `seo_description` varchar(200) NOT NULL DEFAULT '' COMMENT '首页seo描述',
  `domain_type` int(11) NOT NULL DEFAULT '0' COMMENT '1=三级域名，2=独立域名',
  `domain_py` varchar(100) NOT NULL DEFAULT '' COMMENT '三级域名拼音',
  `domain` varchar(100) NOT NULL DEFAULT '' COMMENT '独立域名',
  `style` varchar(20) NOT NULL DEFAULT '' COMMENT '独立网站模板风格',
  `company_address` varchar(200) NOT NULL DEFAULT '' COMMENT '公司地址',
  `company_tel` varchar(100) NOT NULL DEFAULT '' COMMENT '公司电话',
  `company_fax` varchar(100) NOT NULL DEFAULT '' COMMENT '传真',
  `company_about` varchar(1000) NOT NULL DEFAULT '' COMMENT '公司简介（公司网站首页）',
  `qq` varchar(100) NOT NULL DEFAULT '' COMMENT '公司QQ，逗号分开',
  `contact` varchar(100) NOT NULL DEFAULT '' COMMENT '联系人',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `foot_html` varchar(500) NOT NULL DEFAULT '' COMMENT '底部html',
  `erweima` varchar(200) NOT NULL DEFAULT '' COMMENT '二维码,图片',
  `weibo` varchar(200) NOT NULL DEFAULT '' COMMENT '新浪微博,url',
  `company_type` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司类型',
  `company_hide_name` varchar(50) NOT NULL DEFAULT '' COMMENT '隐藏后的名称',
  `not_true` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '假账号（管理员添加的）',
  `year` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司成立年份',
  `scale` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '公司规模',
  `reg_assets` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '注册资本',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '网址',
  `business_products` varchar(255) NOT NULL DEFAULT '' COMMENT '主营产品',
  `business_stones` varchar(255) NOT NULL DEFAULT '' COMMENT '主营石种',
  PRIMARY KEY (`company_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8 COMMENT='企业'");
E_D("replace into `company` values('10000','/uploadfile/2014/12/25/549bdeeaa9089.png','','南平飞飞科技有限公司','','','','0','','','','','0791-2389273','0791-2389273','','','','','','','','1','','0','0','0','0','','','');");

require("../../inc/footer.php");
?>