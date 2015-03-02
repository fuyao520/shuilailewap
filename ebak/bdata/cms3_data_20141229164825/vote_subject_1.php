<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `vote_subject`;");
E_C("CREATE TABLE `vote_subject` (
  `subject_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主题id',
  `subject` varchar(255) NOT NULL DEFAULT '' COMMENT '标题',
  `subject_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '介绍',
  `is_checkbox` int(11) NOT NULL DEFAULT '0' COMMENT '是否复选',
  `minval` int(11) NOT NULL DEFAULT '0' COMMENT '最少选项',
  `maxval` int(11) NOT NULL DEFAULT '0' COMMENT '最大选项',
  `start_time` int(11) NOT NULL DEFAULT '0' COMMENT '上线时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '下线时间',
  `allowview` int(11) NOT NULL DEFAULT '0' COMMENT '是否允许查看投票结果',
  `allowguest` int(11) NOT NULL DEFAULT '0' COMMENT '是否允许游客投票',
  `reward_point` int(11) NOT NULL DEFAULT '0' COMMENT '奖励积分',
  `optionnumeber` int(11) NOT NULL DEFAULT '0' COMMENT '选项数量',
  `votenumber` int(11) NOT NULL DEFAULT '0' COMMENT '共计投票',
  `enabled` int(11) NOT NULL DEFAULT '0' COMMENT '是否启用,0=未启用,1=启用',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `template` varchar(100) NOT NULL DEFAULT '' COMMENT '模版',
  `subject_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `limit_day` int(11) NOT NULL DEFAULT '0' COMMENT '间隔时间允许投票，天为单位，',
  PRIMARY KEY (`subject_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `vote_subject` values('1','你最喜欢的水果','asdfasdfasdfs检查出你最喜欢的水果有哪些呢，这个对健康非常重要','1','0','0','1388193827','1419729827','1','1','0','0','8','1','1388193827','','50','1');");

require("../../inc/footer.php");
?>