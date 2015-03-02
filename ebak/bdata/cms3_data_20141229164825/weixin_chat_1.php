<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `weixin_chat`;");
E_C("CREATE TABLE `weixin_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `is_check` int(11) DEFAULT '0' COMMENT '是否审核',
  `userid` varchar(255) NOT NULL DEFAULT '' COMMENT '用户id',
  `msgtype` varchar(50) NOT NULL DEFAULT '' COMMENT '消息类型',
  `keyword` text NOT NULL COMMENT '回复内容',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '回复时间',
  `postobj` text NOT NULL COMMENT '发送包',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=257 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");

require("../../inc/footer.php");
?>