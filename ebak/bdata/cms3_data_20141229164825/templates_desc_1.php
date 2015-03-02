<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `templates_desc`;");
E_C("CREATE TABLE `templates_desc` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `file_name` varchar(50) NOT NULL DEFAULT '' COMMENT '文件名',
  `desc` varchar(50) NOT NULL DEFAULT '' COMMENT '模版类型说明',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `templates_desc` values('16','goods_detail.php','商品详细页模版');");
E_D("replace into `templates_desc` values('17','goods_list.php','商品列表模版');");
E_D("replace into `templates_desc` values('18','comment.php','评论包含模版');");
E_D("replace into `templates_desc` values('19','default.php','默认的文章列表形式');");
E_D("replace into `templates_desc` values('20','list_content.php','显示单篇的形式');");
E_D("replace into `templates_desc` values('21','list_news.php','默认的资讯的列表形式');");
E_D("replace into `templates_desc` values('22','liuyan.php','留言板');");
E_D("replace into `templates_desc` values('23','vote_form.php','投票表单');");
E_D("replace into `templates_desc` values('24','vote_list.php','投票列表');");
E_D("replace into `templates_desc` values('25','list.php','默认栏目封面页');");
E_D("replace into `templates_desc` values('26','session_order.php','游客订单列表和详细');");
E_D("replace into `templates_desc` values('27','feedback.php','在线反馈');");
E_D("replace into `templates_desc` values('28','get_order.php','确认订单');");
E_D("replace into `templates_desc` values('29','cart.php','购物车');");
E_D("replace into `templates_desc` values('30','vote_detail.php','投票展示');");
E_D("replace into `templates_desc` values('31','evaluate.php','商品评价包含模版');");
E_D("replace into `templates_desc` values('32','inc.php','模版入口包含');");
E_D("replace into `templates_desc` values('33','special_cover.php','专题列表页');");
E_D("replace into `templates_desc` values('34','special_info_list.php','专题的文档列表');");
E_D("replace into `templates_desc` values('35','exchange_goods.php','积分商城商品列表');");
E_D("replace into `templates_desc` values('36','exchange_goods_detail.php','积分物品详细模版');");
E_D("replace into `templates_desc` values('37','goods.php','商品详情模版');");
E_D("replace into `templates_desc` values('38','group_goods.php','团购商品列表模版');");
E_D("replace into `templates_desc` values('39','group_goods_detail.php','团购商品详情模版');");
E_D("replace into `templates_desc` values('40','company_manager.php','代理商管理中心');");
E_D("replace into `templates_desc` values('41','company_member.php','代理商登录');");

require("../../inc/footer.php");
?>