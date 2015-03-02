<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `info_category`;");
E_C("CREATE TABLE `info_category` (
  `cate_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '类别id',
  `model_id` int(11) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类id',
  `relation_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '关联分类',
  `cname` varchar(100) NOT NULL DEFAULT '' COMMENT '分类名称',
  `cname_py` varchar(100) NOT NULL DEFAULT '' COMMENT '分类字母别名',
  `cname_en` varchar(50) NOT NULL DEFAULT '' COMMENT '英文名',
  `cimg` varchar(500) NOT NULL DEFAULT '' COMMENT '分类LOGO图片URL地址',
  `ctitle` varchar(500) NOT NULL DEFAULT '' COMMENT 'SEO标题',
  `ckey` varchar(500) NOT NULL DEFAULT '' COMMENT 'SEO关键词',
  `cdesc` varchar(500) NOT NULL DEFAULT '' COMMENT 'SEO描述',
  `cbody` text COMMENT '分类介绍',
  `corder` int(11) NOT NULL DEFAULT '0' COMMENT '分类排序',
  `cvistors` int(11) NOT NULL DEFAULT '0' COMMENT '分类浏览量',
  `totals` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '数据量',
  `cjump_url` varchar(255) NOT NULL DEFAULT '' COMMENT '手动填写url',
  `jump_first_cate` int(11) NOT NULL DEFAULT '0' COMMENT '是否跳转到第一个子分类',
  `csetting` text NOT NULL COMMENT '设置，模版等 json格式',
  `field_setting` text NOT NULL COMMENT '设置 需要隐藏的字段 json格式 ',
  `getcateids` varchar(255) NOT NULL DEFAULT '' COMMENT '同时获取指定栏目内容（用英文逗号隔开）',
  `cate_host` varchar(100) NOT NULL DEFAULT '' COMMENT '绑定域名',
  `host_is_top` int(11) NOT NULL DEFAULT '0' COMMENT '域名作为 该分类的url，1为是，0为否 ',
  `ad_area_id` int(11) NOT NULL DEFAULT '0' COMMENT '绑定广告位ID',
  `pagesize` int(11) NOT NULL DEFAULT '0' COMMENT '每页显示大小',
  `nav_show` int(11) NOT NULL DEFAULT '0' COMMENT '导航显示',
  `extern_content` text NOT NULL COMMENT '扩展数据，类似模型，但是都保存在本字段的json',
  `highlight` int(11) NOT NULL DEFAULT '0' COMMENT '高亮(否=0，是=1)',
  `recommend` int(11) NOT NULL DEFAULT '0' COMMENT '推荐(否=0，是=1)',
  `single` int(11) NOT NULL DEFAULT '0' COMMENT '单篇介绍(否=0，是=1)',
  PRIMARY KEY (`cate_id`)
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `info_category` values('107','8','0','107','关于我们','guanyuwomen','','','','','','','50','0','1','','0','{\"templates_display\":\"\",\"templates_list\":\"common%2Flistvar%2Flist_content.php\",\"templates_detail\":\"\",\"list_rewrite\":\"0\",\"detail_rewrite\":\"0\",\"pagesize\":\"\"}','[]','','','0','0','0','1','[]','0','0','0');");
E_D("replace into `info_category` values('108','8','0','108','新闻资讯','xinwenzixun','','','','','','','50','0','1','','0','{\"templates_display\":\"\",\"templates_list\":\"\",\"templates_detail\":\"\",\"list_rewrite\":\"0\",\"detail_rewrite\":\"0\",\"pagesize\":\"\"}','[]','','','0','0','0','1','[]','0','0','0');");
E_D("replace into `info_category` values('109','8','0','0','招商加盟','zhaoshangjiameng','','','','','','','50','0','0','','0','{\"templates_display\":\"\",\"templates_list\":\"\",\"templates_detail\":\"\",\"list_rewrite\":\"0\",\"detail_rewrite\":\"0\",\"pagesize\":\"\"}','[]','','','0','0','0','1','[]','0','0','0');");
E_D("replace into `info_category` values('110','8','0','0','联系我们','lianxiwomen','','','','','','','50','0','0','','0','{\"templates_display\":\"\",\"templates_list\":\"\",\"templates_detail\":\"\",\"list_rewrite\":\"0\",\"detail_rewrite\":\"0\",\"pagesize\":\"\"}','[]','','','0','0','0','1','[]','0','0','0');");
E_D("replace into `info_category` values('111','8','107','107','公司简介','gongsijianjie','','','','','','','50','0','1','','0','{\"templates_display\":\"\",\"templates_list\":\"\",\"templates_detail\":\"\",\"list_rewrite\":\"0\",\"detail_rewrite\":\"0\",\"pagesize\":\"\"}','[]','','','0','0','0','0','[]','0','1','0');");
E_D("replace into `info_category` values('112','8','107','107','企业文化','qiyewenhua','','','','','',NULL,'50','0','0','','0','','','','','0','0','0','0','','0','0','0');");
E_D("replace into `info_category` values('113','8','107','107','资质荣誉','zizhirongyu','','','','','',NULL,'50','0','0','','0','','','','','0','0','0','0','','0','0','0');");
E_D("replace into `info_category` values('114','8','107','107','领导致辞','lingdaozhici','','','','','',NULL,'50','0','0','','0','','','','','0','0','0','0','','0','0','0');");
E_D("replace into `info_category` values('115','8','108','108','行业资讯','xingyezixun','','','','','',NULL,'50','0','1','','0','','','','','0','0','0','0','','0','0','0');");
E_D("replace into `info_category` values('116','8','108','108','新闻公告','xinwengonggao','','','','','',NULL,'50','0','0','','0','','','','','0','0','0','0','','0','0','0');");

require("../../inc/footer.php");
?>