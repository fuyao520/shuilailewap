<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `article`;");
E_C("CREATE TABLE `article` (
  `info_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '资讯ID',
  `last_cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '类别ID',
  `audit` int(11) NOT NULL DEFAULT '0' COMMENT '是否审核',
  `info_title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `info_img` varchar(255) NOT NULL DEFAULT '' COMMENT '封面',
  `info_attr_title` varchar(255) NOT NULL DEFAULT '' COMMENT '标题样式',
  `info_tags` varchar(100) NOT NULL DEFAULT '' COMMENT '标签',
  `info_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `info_body` text NOT NULL COMMENT '介绍',
  `info_editor` varchar(50) NOT NULL DEFAULT '' COMMENT '责任编辑',
  `info_from` varchar(100) NOT NULL DEFAULT '' COMMENT '来源',
  `info_visitors` int(11) NOT NULL DEFAULT '0' COMMENT '浏览量',
  `info_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `info_py` varchar(100) NOT NULL DEFAULT '' COMMENT '标题拼音',
  `info_jump_url` varchar(255) NOT NULL DEFAULT '' COMMENT '跳转地址',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `info_extern` text NOT NULL COMMENT '扩展数据',
  `flag_c` int(11) NOT NULL DEFAULT '0' COMMENT '推荐',
  `flag_h` int(11) NOT NULL DEFAULT '0' COMMENT '头条',
  `flag_s` int(11) NOT NULL DEFAULT '0' COMMENT '滚动',
  `flag_a` int(11) NOT NULL DEFAULT '0' COMMENT '特推',
  `flag_d` int(11) NOT NULL DEFAULT '0' COMMENT '幻灯',
  `flag_img` int(11) NOT NULL DEFAULT '0' COMMENT '图片',
  `comments_total` int(11) NOT NULL DEFAULT '0' COMMENT '评论',
  PRIMARY KEY (`info_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8");
E_D("replace into `article` values('1','111','1','公司简介','/uploadfile/2014/12/25/201412251527130895_crop.jpg','{\"color\":\"\",\"bold\":\"\"}','','   xxx农业科技有限公司是由中国民营企业30强的正泰集团投资控股、专业从事现代农业和生物高科技投资与经营的核心业务平台。   作为《茶叶籽油》国家标准制定单位、中国茶叶流通协会茶叶籽专业委员会主','<p style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\"><span style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; white-space: pre;\"><img alt=\"\" align=\"left\" src=\"/uploadfile/2014/12/25/201412251527130895.jpg\" width=\"300\" style=\"margin: 30px 10px 10px 0px; padding: 0px; border: none;\" /></span></span></p><p style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\"><span style=\"margin: 0px; padding: 0px;\"><span style=\"margin: 0px; padding: 0px; white-space: pre;\"></span>&nbsp; &nbsp; &nbsp; xxxxxx科技有限公司是由中国民营企业30强的正泰集团投资控股、专业从事现代农业和生物高科技投资与经营的核心业务平台。</span></p><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\">&nbsp; &nbsp; &nbsp; 作为《茶叶籽油》国家标准制定单位、中国茶叶流通协会茶叶籽专业委员会主任单位、全国投资规模最大的茶叶籽综合开发利用领军企业，泰谷不仅聘请了国内油脂、茶学、营养、保健、烹饪、美食等10余位顶级权威专家，打造国内一流科研团队，并与国家重点实验室-植物功能成分利用国家工程技术研究中心（BFI）全程紧密战略合作，可靠的产品质量不仅通过ISO22000、ISO9007、ISO14001、GB/T28001、QS等体系认证，还顺利通过日本、香港、美国的认证或检测。<br style=\"margin: 0px; padding: 0px;\" /><span style=\"margin: 0px; padding: 0px; white-space: pre;\"></span></span><p style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\"><span style=\"margin: 0px; padding: 0px;\">&nbsp; &nbsp; &nbsp; 泰谷作为正泰集团农业板块的核心企业，在集团“实现产值冲千亿”的宏伟战略规划蓝图中，即将开启新的产业篇章！</span></p><br style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\" /><p style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\"><span style=\"margin: 0px; padding: 0px;\"><img src=\"/uploadfile/2014/12/25/201412251527133085.png\" alt=\"\" width=\"300\" style=\"margin: 20px 10px 10px 0px; padding: 0px; border: none; float: left;\" /><br style=\"margin: 0px; padding: 0px;\" /></span></p><span style=\"margin: 0px; padding: 0px; font-family: 微软雅黑, arial; font-size: 14px; letter-spacing: 1px; line-height: 28px;\">&nbsp; &nbsp; &nbsp; 正泰集团创建于1984年，是我国工业电器龙头企业和新能源领军企业，现有总资产达200多亿元，2012年销售额突破400亿，综合实力已连续名列全国民营企业500强前30位，在册员工29000多人。<br style=\"margin: 0px; padding: 0px;\" />&nbsp; 产业涵盖低压电器、输配电设备、仪器仪表、建筑电器、汽车电器、工业自动化、光伏发电和装备制造等，是国内规模最大、品种最齐全的清洁能源供应商和能效管理系列解决方案提供商。<br style=\"margin: 0px; padding: 0px;\" />&nbsp; &nbsp; &nbsp; 在全国各地有2000多家经销商，并在国外设立了50多家销售机构，产品畅销世界100多个国家和地区，并已进入欧洲、亚洲、中东和非洲等国际主配套市场。<br style=\"margin: 0px; padding: 0px;\" />&nbsp; &nbsp; &nbsp; 正泰电器（股票代码601877）为入选沪深300指数的主板上市企业，下属正泰太阳能、理想能源设备等多家企业皆已进入上市准备期。</span>','admin','','0','50','','','1419492429','[]','0','0','0','0','0','0','0');");
E_D("replace into `article` values('2','115','1','日式战略RPG《悠久的格子恐惧》将登双平台','','{\"color\":\"\",\"bold\":\"\"}','','Qmax有限公司于日前宣布，将会在iOS和Android双平台上推出一款名为《悠久的格子恐惧》(悠久のラティスフィア)的手游新作，并预定在12月下旬上架。在游戏中，玩家可以选择帅气的剑士、可爱的魔法师','<p><span style=\"color: rgb(51, 51, 51); font-family: 微软雅黑, 宋体; font-size: 16px; line-height: 28px; text-indent: 32px;\">Qmax有限公司于日前宣布，将会在iOS和Android双平台上推出一款名为《悠久的格子恐惧》(悠久のラティスフィア)的手游新作，并预定在12月下旬上架。</span></p><p><span style=\"color: rgb(51, 51, 51); font-family: 微软雅黑, 宋体; font-size: 16px; line-height: 28px; text-indent: 32px;\"></span></p><p style=\"margin: 0px 0px 24px; padding: 0px; font-size: 16px; color: rgb(51, 51, 51); text-indent: 2em; line-height: 28px; font-family: 微软雅黑, 宋体;\">在游戏中，玩家可以选择帅气的剑士、可爱的魔法师等来组成自己的战斗队伍，并通过合成强化等手段来让自己战胜各种敌人。此外，游戏还搭载了斗技场，让玩家可以与好友进行对战切磋。</p><div><br /></div><br />','admin','','0','50','','','1419684975','[]','0','0','0','0','0','0','0');");

require("../../inc/footer.php");
?>