<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice_aclog`;");
E_C("CREATE TABLE `cservice_aclog` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '日志标识',
  `sno` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '客服编号',
  `accode` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '动作编号',
  `log_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '操作时间',
  `log_ip` char(15) NOT NULL DEFAULT '' COMMENT '操作ip',
  `log_details` text COMMENT '操作细节',
  PRIMARY KEY (`log_id`)
) ENGINE=MyISAM AUTO_INCREMENT=40164 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统用户行为日志'");
E_D("replace into `cservice_aclog` values('40122','1','0','1419491195','121.204.131.216','添加了模型ID：1文章');");
E_D("replace into `cservice_aclog` values('40123','1','0','1419491309','121.204.131.216','批量添加了内容分类关于我们 新闻资讯 招商加盟 联系我们');");
E_D("replace into `cservice_aclog` values('40124','1','0','1419491322','121.204.131.216','修改内容分类ID107[关于我们]成功');");
E_D("replace into `cservice_aclog` values('40125','1','0','1419491326','121.204.131.216','修改内容分类ID108[新闻资讯]成功');");
E_D("replace into `cservice_aclog` values('40126','1','0','1419491330','121.204.131.216','修改内容分类ID109[招商加盟]成功');");
E_D("replace into `cservice_aclog` values('40127','1','0','1419491334','121.204.131.216','修改内容分类ID110[联系我们]成功');");
E_D("replace into `cservice_aclog` values('40128','1','0','1419492156','121.204.131.216','批量添加了内容分类公司简介 企业文化 资质荣誉 领导致辞');");
E_D("replace into `cservice_aclog` values('40129','1','0','1419492172','121.204.131.216','修改内容分类ID107[关于我们]成功');");
E_D("replace into `cservice_aclog` values('40130','1','0','1419492226','121.204.131.216','批量添加了内容分类行业资讯 新闻公告');");
E_D("replace into `cservice_aclog` values('40131','1','0','1419492235','121.204.131.216','修改内容分类ID108[新闻资讯]成功');");
E_D("replace into `cservice_aclog` values('40132','1','0','1419492443','121.204.131.216','添加了内容ID：1公司简介');");
E_D("replace into `cservice_aclog` values('40133','1','0','1419492505','121.204.131.216','修改内容分类ID107[关于我们]成功');");
E_D("replace into `cservice_aclog` values('40134','1','0','1419492526','121.204.131.216','修改了内容 ID:1公司简介 ');");
E_D("replace into `cservice_aclog` values('40135','1','0','1419492551','121.204.131.216','修改内容分类ID111[公司简介]成功');");
E_D("replace into `cservice_aclog` values('40136','1','0','1419492565','121.204.131.216','修改了内容 ID:1公司简介 ');");
E_D("replace into `cservice_aclog` values('40137','1','0','1419498822','127.0.0.1','修改了会员 ID:10000feifei ');");
E_D("replace into `cservice_aclog` values('40138','1','0','1419585717','121.204.131.216','修改了内容 ID:1公司简介2 ');");
E_D("replace into `cservice_aclog` values('40139','1','0','1419585841','121.204.131.216','修改了内容 ID:1公司简介2 ');");
E_D("replace into `cservice_aclog` values('40140','1','0','1419585846','121.204.131.216','修改了内容 ID:1公司简介 ');");
E_D("replace into `cservice_aclog` values('40141','1','0','1419586461','121.204.131.216','修改了内容 ID:1公司简介 ');");
E_D("replace into `cservice_aclog` values('40142','1','0','1419586850','121.204.131.216','删除了伪静态ID（15）');");
E_D("replace into `cservice_aclog` values('40143','1','0','1419685016','183.251.96.7','添加了内容ID：1日式战略RPG《悠久的格子恐惧》将登双平台');");
E_D("replace into `cservice_aclog` values('40144','1','0','1419685038','183.251.96.7','修改了内链 ID:2平台 ');");
E_D("replace into `cservice_aclog` values('40145','1','0','1419685045','183.251.96.7','修改了内链 ID:2平台 ');");
E_D("replace into `cservice_aclog` values('40146','1','0','1419760180','183.251.96.7','修改了seo页面 ID:1首页 ');");
E_D("replace into `cservice_aclog` values('40147','1','0','1419760238','183.251.96.7','修改了seo页面 ID:1首页 ');");
E_D("replace into `cservice_aclog` values('40148','1','0','1419760317','183.251.96.7','添加了seo页面ID：1关于我们');");
E_D("replace into `cservice_aclog` values('40149','1','0','1419760334','183.251.96.7','修改了seo页面 ID:2关于我们 ');");
E_D("replace into `cservice_aclog` values('40150','1','0','1419760345','183.251.96.7','修改了seo页面 ID:2关于我们 ');");
E_D("replace into `cservice_aclog` values('40151','1','0','1419833874','121.204.131.216','添加了模型ID：1在线留言');");
E_D("replace into `cservice_aclog` values('40152','1','0','1419833902','121.204.131.216','添加了模型字段ID：1姓名');");
E_D("replace into `cservice_aclog` values('40153','1','0','1419833915','121.204.131.216','添加了模型字段ID：1留言内容');");
E_D("replace into `cservice_aclog` values('40154','1','0','1419833931','121.204.131.216','添加了模型字段ID：1ip地址');");
E_D("replace into `cservice_aclog` values('40155','1','0','1419833947','121.204.131.216','添加了模型字段ID：1留言时间');");
E_D("replace into `cservice_aclog` values('40156','1','0','1419835778','121.204.131.216','修改了模型字段 ID:669留言内容 ');");
E_D("replace into `cservice_aclog` values('40157','1','0','1419835798','121.204.131.216','添加了模型字段ID：1电话');");
E_D("replace into `cservice_aclog` values('40158','1','0','1419835816','121.204.131.216','添加了模型字段ID：1邮箱');");
E_D("replace into `cservice_aclog` values('40159','1','0','1419836001','121.204.131.216','添加了模型字段ID：1回复');");
E_D("replace into `cservice_aclog` values('40160','1','0','1419841437','121.204.131.216','修改了内容 ID:2日式战略RPG《悠久的格子恐惧》将登双平台 ');");
E_D("replace into `cservice_aclog` values('40161','1','0','1419841616','121.204.131.216','修改了内容 ID:2日式战略RPG《悠久的格子恐惧》将登双平台 ');");
E_D("replace into `cservice_aclog` values('40162','1','0','1419841731','121.204.131.216','裁剪了封面图片,ID：article-1');");
E_D("replace into `cservice_aclog` values('40163','1','0','1419842704','121.204.131.216','删除了登陆记录ID（1,2,3,4,5,6）');");

require("../../inc/footer.php");
?>