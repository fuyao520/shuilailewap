<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `user_collect`;");
E_C("CREATE TABLE `user_collect` (
  `collect_id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '收藏记录的自增id',
  `uid` mediumint(8) NOT NULL DEFAULT '0' COMMENT '该条收藏记录的会员id，取值于ecs_users的user_id',
  `info_id` mediumint(8) NOT NULL DEFAULT '0' COMMENT '收藏的id',
  `table_name` varchar(8) NOT NULL DEFAULT '0' COMMENT '信息的数据表，表名',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '收藏时间',
  PRIMARY KEY (`collect_id`)
) ENGINE=MyISAM AUTO_INCREMENT=99 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `user_collect` values('4','10000','8','goods','1387856789');");
E_D("replace into `user_collect` values('3','10000','4','goods','1387856725');");
E_D("replace into `user_collect` values('5','10000','6','goods','1387856795');");
E_D("replace into `user_collect` values('19','10011','4307','goods','1411970610');");
E_D("replace into `user_collect` values('20','10011','4301','goods','1411970633');");
E_D("replace into `user_collect` values('21','10011','4304','goods','1411971845');");
E_D("replace into `user_collect` values('22','10011','2478','goods','1412041612');");
E_D("replace into `user_collect` values('23','10013','956','goods','1412066763');");
E_D("replace into `user_collect` values('24','10013','947','goods','1412066811');");
E_D("replace into `user_collect` values('17','10005','277','goods','1410967522');");
E_D("replace into `user_collect` values('25','10013','959','goods','1412066822');");
E_D("replace into `user_collect` values('26','10013','3872','goods','1412066851');");
E_D("replace into `user_collect` values('27','10013','3349','goods','1412066854');");
E_D("replace into `user_collect` values('28','10002','4310','goods','1412567590');");
E_D("replace into `user_collect` values('29','10002','5501','goods','1412753467');");
E_D("replace into `user_collect` values('34','10002','4964','goods','1412841328');");
E_D("replace into `user_collect` values('31','10002','7290','goods','1412760836');");
E_D("replace into `user_collect` values('32','10006','8008','goods','1412826742');");
E_D("replace into `user_collect` values('61','10006','6257','goods','1413108230');");
E_D("replace into `user_collect` values('35','10002','6179','goods','1413018997');");
E_D("replace into `user_collect` values('36','10002','4972','goods','1413019023');");
E_D("replace into `user_collect` values('37','10002','4971','goods','1413019166');");
E_D("replace into `user_collect` values('38','10002','4285','goods','1413019451');");
E_D("replace into `user_collect` values('39','10002','4292','goods','1413019457');");
E_D("replace into `user_collect` values('40','10002','4311','goods','1413019543');");
E_D("replace into `user_collect` values('41','10002','1006','goods','1413019798');");
E_D("replace into `user_collect` values('42','10002','1011','goods','1413019800');");
E_D("replace into `user_collect` values('43','10002','996','goods','1413019844');");
E_D("replace into `user_collect` values('44','10002','1005','goods','1413019849');");
E_D("replace into `user_collect` values('45','10002','1010','goods','1413019853');");
E_D("replace into `user_collect` values('46','10002','994','goods','1413019868');");
E_D("replace into `user_collect` values('47','10002','1015','goods','1413019899');");
E_D("replace into `user_collect` values('48','10002','4306','goods','1413019909');");
E_D("replace into `user_collect` values('49','10002','4305','goods','1413079803');");
E_D("replace into `user_collect` values('50','10002','4274','goods','1413079825');");
E_D("replace into `user_collect` values('51','10002','4276','goods','1413079872');");
E_D("replace into `user_collect` values('52','10002','4264','goods','1413080295');");
E_D("replace into `user_collect` values('53','10002','4263','goods','1413080297');");
E_D("replace into `user_collect` values('54','10002','4262','goods','1413080298');");
E_D("replace into `user_collect` values('55','10002','4253','goods','1413080301');");
E_D("replace into `user_collect` values('56','10002','4304','goods','1413082228');");
E_D("replace into `user_collect` values('57','10002','4300','goods','1413082231');");
E_D("replace into `user_collect` values('58','10002','4307','goods','1413083951');");
E_D("replace into `user_collect` values('59','10002','4309','goods','1413084255');");
E_D("replace into `user_collect` values('60','10002','4301','goods','1413086268');");
E_D("replace into `user_collect` values('62','10006','6260','goods','1413108243');");
E_D("replace into `user_collect` values('63','10006','6259','goods','1413108253');");
E_D("replace into `user_collect` values('64','10006','6261','goods','1413108274');");
E_D("replace into `user_collect` values('65','10002','8608','goods','1413108285');");
E_D("replace into `user_collect` values('66','10002','8607','goods','1413108288');");
E_D("replace into `user_collect` values('67','10002','8605','goods','1413108324');");
E_D("replace into `user_collect` values('68','10002','8603','goods','1413108380');");
E_D("replace into `user_collect` values('69','10002','7247','goods','1413108518');");
E_D("replace into `user_collect` values('70','10006','4972','goods','1413108616');");
E_D("replace into `user_collect` values('71','10006','4971','goods','1413108630');");
E_D("replace into `user_collect` values('72','10006','1261','goods','1413108828');");
E_D("replace into `user_collect` values('73','10002','3449','goods','1413108921');");
E_D("replace into `user_collect` values('74','10006','3492','goods','1413108966');");
E_D("replace into `user_collect` values('75','10002','6625','goods','1413165670');");
E_D("replace into `user_collect` values('76','10002','6626','goods','1413165672');");
E_D("replace into `user_collect` values('84','10002','8613','goods','1413182484');");
E_D("replace into `user_collect` values('83','10002','8611','goods','1413182482');");
E_D("replace into `user_collect` values('89','10002','6224','goods','1413184769');");
E_D("replace into `user_collect` values('81','10002','8606','goods','1413180501');");
E_D("replace into `user_collect` values('86','10002','850','goods','1413182497');");
E_D("replace into `user_collect` values('90','10002','9890','goods','1415257044');");
E_D("replace into `user_collect` values('94','10002','9889','goods','1415350810');");
E_D("replace into `user_collect` values('92','10002','9883','goods','1415257054');");
E_D("replace into `user_collect` values('93','10002','8507','goods','1415257233');");
E_D("replace into `user_collect` values('95','10002','9888','goods','1415350811');");
E_D("replace into `user_collect` values('96','10002','9887','goods','1415350822');");
E_D("replace into `user_collect` values('98','10080','9622','goods','1416032756');");

require("../../inc/footer.php");
?>