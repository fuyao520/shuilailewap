<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_extern`;");
E_C("CREATE TABLE `user_extern` (
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `sex` int(2) NOT NULL DEFAULT '0' COMMENT '性别（女=1，男=2）',
  `tou_img` varchar(100) NOT NULL DEFAULT '' COMMENT '头像地址',
  `birth_day` int(11) NOT NULL DEFAULT '0' COMMENT '出生年月日',
  `constellation` varchar(20) NOT NULL DEFAULT '' COMMENT '星座',
  `signature` varchar(100) NOT NULL DEFAULT '' COMMENT '个性签名',
  `occupation` varchar(20) NOT NULL DEFAULT '' COMMENT '职业',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `user_extern` values('10002','2','http://tp2.sinaimg.cn/1668374717/50/5660710381/1','1251820800','金牛座','累觉不爱。','');");

require("../../inc/footer.php");
?>