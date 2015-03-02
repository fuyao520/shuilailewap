<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_thirdpassport`;");
E_C("CREATE TABLE `user_thirdpassport` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '编号',
  `uid` int(10) unsigned NOT NULL COMMENT '用户ID',
  `media_type` tinyint(1) unsigned NOT NULL COMMENT '类型',
  `openid` char(50) NOT NULL COMMENT 'openid',
  `user_data` text COMMENT '第三方账号资料',
  `created` int(10) unsigned NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='第三方登录'");
E_D("replace into `user_thirdpassport` values('7','10012','1','803A489D300CF3A623E94BC201F4E5C2','{\"type\":\"1\",\"name\":\"QQ\",\"nickname\":\"Fleeting+Time\",\"tou_img\":\"http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101153041%2F803A489D300CF3A623E94BC201F4E5C2%2F50\",\"openid\":\"803A489D300CF3A623E94BC201F4E5C2\"}','1412058552');");
E_D("replace into `user_thirdpassport` values('12','10002','1','E5D4646242F80ACF857A326BCBE3C765','{\"type\":\"1\",\"name\":\"QQ\",\"nickname\":\"Fei\",\"tou_img\":\"http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F100483003%2FE5D4646242F80ACF857A326BCBE3C765%2F50\",\"openid\":\"E5D4646242F80ACF857A326BCBE3C765\"}','1419836509');");
E_D("replace into `user_thirdpassport` values('13','10002','2','1668374717','{\"type\":\"2\",\"name\":\"%E6%96%B0%E6%B5%AA%E5%BE%AE%E5%8D%9A\",\"nickname\":\"%E5%8F%8D%E6%AF%92%E8%A3%81\",\"tou_img\":\"http%3A%2F%2Ftp2.sinaimg.cn%2F1668374717%2F50%2F5660710381%2F1\",\"openid\":\"1668374717\"}','1419836533');");
E_D("replace into `user_thirdpassport` values('9','10011','1','B3892A622FA4192BF2E26563FBE5B333','{\"type\":\"1\",\"name\":\"QQ\",\"nickname\":\"%E6%98%8E%E5%A4%A9%EF%BC%8C%E4%BD%A0%E5%A5%BD%E3%80%82\",\"tou_img\":\"http%3A%2F%2Fqzapp.qlogo.cn%2Fqzapp%2F101153041%2FB3892A622FA4192BF2E26563FBE5B333%2F50\",\"openid\":\"B3892A622FA4192BF2E26563FBE5B333\"}','1414995626');");

require("../../inc/footer.php");
?>