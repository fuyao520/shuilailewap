<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `comment_list`;");
E_C("CREATE TABLE `comment_list` (
  `comment_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级评论id',
  `fromid` varchar(100) NOT NULL DEFAULT '' COMMENT '最好用 表名-ID 标识',
  `comment` text NOT NULL COMMENT '评论内容',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '评论者id',
  `uname` varchar(20) NOT NULL DEFAULT '0' COMMENT '评论者昵称',
  `ischeck` int(11) NOT NULL DEFAULT '0' COMMENT '审核状态，1：审核成功；2：审核失败',
  `create_date` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `ipaddr` varchar(50) NOT NULL DEFAULT '' COMMENT '发布ip地址',
  `has_son` int(11) NOT NULL DEFAULT '0' COMMENT '跟帖条数',
  `comments_type` int(11) NOT NULL DEFAULT '0' COMMENT '类型，备留字段',
  `good` int(11) NOT NULL DEFAULT '0' COMMENT '赞',
  `bad` int(11) NOT NULL DEFAULT '0' COMMENT '踩',
  `reply` varchar(1000) NOT NULL DEFAULT '' COMMENT '评论管理员回复',
  `attr` varchar(255) NOT NULL DEFAULT '' COMMENT '附加信息',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>