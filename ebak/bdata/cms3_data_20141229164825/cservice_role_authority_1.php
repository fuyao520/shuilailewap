<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `cservice_role_authority`;");
E_C("CREATE TABLE `cservice_role_authority` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '角色ID',
  `authority_id` char(32) NOT NULL DEFAULT '' COMMENT '权限标识',
  `created` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`role_id`,`authority_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED COMMENT='角色-权限'");
E_D("replace into `cservice_role_authority` values('1','content_center','0');");
E_D("replace into `cservice_role_authority` values('2','infoCategory','0');");
E_D("replace into `cservice_role_authority` values('3','category_show','0');");
E_D("replace into `cservice_role_authority` values('4','category_add','0');");
E_D("replace into `cservice_role_authority` values('5','category_edit','0');");
E_D("replace into `cservice_role_authority` values('6','info','0');");
E_D("replace into `cservice_role_authority` values('7','info_show','0');");
E_D("replace into `cservice_role_authority` values('8','info_add','0');");
E_D("replace into `cservice_role_authority` values('9','info_edit','0');");
E_D("replace into `cservice_role_authority` values('10','info_del','0');");
E_D("replace into `cservice_role_authority` values('11','info_audit','0');");
E_D("replace into `cservice_role_authority` values('12','linkage','0');");
E_D("replace into `cservice_role_authority` values('13','linkage_show','0');");
E_D("replace into `cservice_role_authority` values('14','linkage_add','0');");
E_D("replace into `cservice_role_authority` values('15','linkage_edit','0');");
E_D("replace into `cservice_role_authority` values('16','linkage_del','0');");
E_D("replace into `cservice_role_authority` values('17','tbkGoodsLink','0');");
E_D("replace into `cservice_role_authority` values('18','tbCollector','0');");
E_D("replace into `cservice_role_authority` values('19','comment','0');");
E_D("replace into `cservice_role_authority` values('20','comment_show','0');");
E_D("replace into `cservice_role_authority` values('21','comment_edit','0');");
E_D("replace into `cservice_role_authority` values('22','comment_del','0');");
E_D("replace into `cservice_role_authority` values('23','special','0');");
E_D("replace into `cservice_role_authority` values('24','special_show','0');");
E_D("replace into `cservice_role_authority` values('25','special_add','0');");
E_D("replace into `cservice_role_authority` values('26','special_edit','0');");
E_D("replace into `cservice_role_authority` values('27','special_del','0');");
E_D("replace into `cservice_role_authority` values('28','nlink','0');");
E_D("replace into `cservice_role_authority` values('29','nlink_show','0');");
E_D("replace into `cservice_role_authority` values('30','nlink_add','0');");
E_D("replace into `cservice_role_authority` values('31','nlink_edit','0');");
E_D("replace into `cservice_role_authority` values('32','nlink_del','0');");
E_D("replace into `cservice_role_authority` values('33','tag','0');");
E_D("replace into `cservice_role_authority` values('34','tag_show','0');");
E_D("replace into `cservice_role_authority` values('35','tag_edit','0');");
E_D("replace into `cservice_role_authority` values('36','tag_del','0');");
E_D("replace into `cservice_role_authority` values('37','recommend','0');");
E_D("replace into `cservice_role_authority` values('38','recommend_show','0');");
E_D("replace into `cservice_role_authority` values('39','recommend_add','0');");
E_D("replace into `cservice_role_authority` values('40','recommend_edit','0');");
E_D("replace into `cservice_role_authority` values('41','recommend_del','0');");
E_D("replace into `cservice_role_authority` values('42','content_center','0');");
E_D("replace into `cservice_role_authority` values('43','category','0');");
E_D("replace into `cservice_role_authority` values('44','infoCategory_index','0');");
E_D("replace into `cservice_role_authority` values('45','infoCategory_update','0');");
E_D("replace into `cservice_role_authority` values('46','infoCategory_delete','0');");
E_D("replace into `cservice_role_authority` values('47','info','0');");
E_D("replace into `cservice_role_authority` values('48','info_index','0');");
E_D("replace into `cservice_role_authority` values('49','info_update','0');");
E_D("replace into `cservice_role_authority` values('50','info_delete','0');");
E_D("replace into `cservice_role_authority` values('51','info_audit','0');");
E_D("replace into `cservice_role_authority` values('52','linkage','0');");
E_D("replace into `cservice_role_authority` values('53','linkage_index','0');");
E_D("replace into `cservice_role_authority` values('54','linkage_update','0');");
E_D("replace into `cservice_role_authority` values('55','linkage_delele','0');");
E_D("replace into `cservice_role_authority` values('2','content_center','0');");
E_D("replace into `cservice_role_authority` values('2','info_delete','0');");
E_D("replace into `cservice_role_authority` values('2','infoCategory_update*','0');");
E_D("replace into `cservice_role_authority` values('2','info_audit','0');");
E_D("replace into `cservice_role_authority` values('2','info','0');");
E_D("replace into `cservice_role_authority` values('2','infoCategory_index','0');");
E_D("replace into `cservice_role_authority` values('2','info_update*','0');");
E_D("replace into `cservice_role_authority` values('2','infoCategory_delete','0');");
E_D("replace into `cservice_role_authority` values('2','info_index','0');");
E_D("replace into `cservice_role_authority` values('2','linkage','0');");
E_D("replace into `cservice_role_authority` values('2','linkage_index*','0');");
E_D("replace into `cservice_role_authority` values('2','linkage_update*','0');");
E_D("replace into `cservice_role_authority` values('2','linkage_delele*','0');");
E_D("replace into `cservice_role_authority` values('2','info_setSpecial','0');");
E_D("replace into `cservice_role_authority` values('2','info_setRecommend','0');");
E_D("replace into `cservice_role_authority` values('2','info_setInfoCate','0');");

require("../../inc/footer.php");
?>