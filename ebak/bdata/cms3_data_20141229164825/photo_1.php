<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `photo`;");
E_C("CREATE TABLE `photo` (
  `photo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `photo_img` varchar(200) NOT NULL DEFAULT '' COMMENT '相册图片',
  `photo_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '创建时间',
  `photo_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`photo_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `photo` values('1','10027','/img/2013/09/16/5236d20ef353a.jpg','<img alt=\\\\\"大哭\\\\\" src=\\\\\"css/lib/xheditor/xheditor_emot/default/wail.gif\\\\\" />asdfasdfasdfasdf发斯蒂芬撒旦法玩儿','0','1379409939');");
E_D("replace into `photo` values('39','10030','/img/2013/09/21/523d360096581.jpg','精彩图片，美好生活！','50','1379743236');");
E_D("replace into `photo` values('38','10030','/img/2013/09/21/523d35efd78cc.jpg','精彩图片，美好生活！','50','1379743220');");
E_D("replace into `photo` values('40','10030','/img/2013/09/21/523d36083acc1.jpg','精彩图片，美好生活！','50','1379743242');");
E_D("replace into `photo` values('41','10030','/img/2013/09/21/523d360e318b3.jpg','精彩图片，美好生活！','50','1379743247');");
E_D("replace into `photo` values('37','10030','/img/2013/09/21/523d35e9202c4.jpg','','50','1379743211');");
E_D("replace into `photo` values('36','10030','/img/2013/09/21/523d35e1187e3.jpg','','50','1379743204');");
E_D("replace into `photo` values('35','10030','/img/2013/09/21/523d35db4ddf6.jpg','','50','1379743196');");
E_D("replace into `photo` values('34','10030','/img/2013/09/21/523d35d5ea5fb.jpg','','50','1379743190');");
E_D("replace into `photo` values('33','10030','/img/2013/09/21/523d35cff1fa8.jpg','','50','1379743185');");
E_D("replace into `photo` values('32','10030','/img/2013/09/21/523d35c98eb27.jpg','','50','1379743179');");
E_D("replace into `photo` values('31','10030','/img/2013/09/21/523d35c3dae98.jpg','','50','1379743173');");
E_D("replace into `photo` values('30','10030','/img/2013/09/21/523d350f8eae2.jpg','精彩图片，美好生活！','50','1379742994');");
E_D("replace into `photo` values('29','10030','/img/2013/09/21/523d34fb7f74e.jpg','精彩图片，美好生活！','50','1379742982');");
E_D("replace into `photo` values('28','10030','/img/2013/09/21/523d34dbdb461.jpg','精彩图片，美好生活！','50','1379742965');");
E_D("replace into `photo` values('42','10030','/img/2013/09/21/523d361262c82.jpg','精彩图片，美好生活！','50','1379743251');");
E_D("replace into `photo` values('43','10030','/img/2013/09/21/523d3617b109f.jpg','精彩图片，美好生活！','50','1379743257');");
E_D("replace into `photo` values('44','10030','/img/2013/09/21/523d361de2ae3.jpg','精彩图片，美好生活！','50','1379743263');");
E_D("replace into `photo` values('45','10030','/img/2013/09/21/523d3627703f7.jpg','精彩图片，美好生活！','50','1379743273');");
E_D("replace into `photo` values('46','10030','/img/2013/09/21/523d3639c92e7.jpg','精彩图片，美好生活！','50','1379743294');");
E_D("replace into `photo` values('47','10030','/img/2013/09/21/523d3641c0642.jpg','精彩图片，美好生活！','50','1379743299');");
E_D("replace into `photo` values('48','10030','/img/2013/09/21/523d36463702c.jpg','精彩图片，美好生活！','50','1379743303');");
E_D("replace into `photo` values('49','10034','/img/2013/09/22/523e82b8dc255.jpg','','50','1379828411');");
E_D("replace into `photo` values('50','10034','/img/2013/09/22/523e9f2d1bffa.jpg','','50','1379835695');");
E_D("replace into `photo` values('51','10037','/img/2013/10/10/5255fabd31edb.jpg','<img alt=\\\\\"偷笑\\\\\" src=\\\\\"css/lib/xheditor/xheditor_emot/default/titter.gif\\\\\" /><img alt=\\\\\"骂人\\\\\" src=\\\\\"css/lib/xheditor/xheditor_emot/default/curse.gif\\\\\" />','50','1381366468');");
E_D("replace into `photo` values('52','10037','/img/2013/10/10/5255fac9c57a3.jpg','很有男人味吧 ？&nbsp; <img alt=\\\\\"羡慕\\\\\" src=\\\\\"css/lib/xheditor/xheditor_emot/default/envy.gif\\\\\" /><br />','50','1381366488');");
E_D("replace into `photo` values('53','10037','/img/2013/10/10/5255faddf2d02.jpg','','50','1381366497');");
E_D("replace into `photo` values('54','10037','/img/2013/10/10/5255fae879a3f.jpg','越狱的男猪角~','50','1381366522');");
E_D("replace into `photo` values('55','10037','/img/2013/10/10/5255fb00a2bfc.jpg','','50','1381366530');");
E_D("replace into `photo` values('56','10037','/img/2013/10/10/5255fb11c2218.jpg','','50','1381366547');");
E_D("replace into `photo` values('57','10037','/img/2013/10/10/5255fb19ab362.jpg','','50','1381366554');");
E_D("replace into `photo` values('58','10040','','','50','1381819612');");
E_D("replace into `photo` values('59','10040','','','50','1381819646');");
E_D("replace into `photo` values('60','10040','','','50','1381819656');");
E_D("replace into `photo` values('61','10040','','','50','1381819670');");
E_D("replace into `photo` values('62','10040','','','50','1381819680');");
E_D("replace into `photo` values('63','10040','','','50','1381819688');");
E_D("replace into `photo` values('64','10040','','','50','1381819783');");
E_D("replace into `photo` values('65','10043','','','50','1383636250');");
E_D("replace into `photo` values('66','10043','','','50','1383639374');");
E_D("replace into `photo` values('67','10034','','','50','1383639719');");
E_D("replace into `photo` values('68','10043','http://110.80.22.218:81/img/2013/11/05/5278b749d64fd.jpg','','50','1383642955');");
E_D("replace into `photo` values('69','10043','http://110.80.22.218:81/img/2013/11/05/5278b7540fed1.jpg','','50','1383642965');");
E_D("replace into `photo` values('70','10043','','','50','1383642979');");

require("../../inc/footer.php");
?>