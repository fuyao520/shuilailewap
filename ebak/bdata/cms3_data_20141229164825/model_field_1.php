<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('utf8');
E_D("DROP TABLE IF EXISTS `model_field`;");
E_C("CREATE TABLE `model_field` (
  `field_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '字段ID',
  `model_id` int(11) NOT NULL DEFAULT '0' COMMENT '模型ID',
  `field_name` varchar(100) NOT NULL DEFAULT '' COMMENT '字段',
  `field_txt` varchar(50) NOT NULL DEFAULT '' COMMENT '提示文字',
  `form_type` varchar(50) NOT NULL DEFAULT '' COMMENT '表单类型',
  `setting` text NOT NULL COMMENT 'json格式，默认值，选中值等',
  `tips` varchar(255) NOT NULL DEFAULT '' COMMENT '表单提示附加',
  `pattern` varchar(100) NOT NULL DEFAULT '' COMMENT '数据检验正则',
  `length` varchar(50) NOT NULL DEFAULT '' COMMENT '文本长度',
  `linkage_type_id` int(11) NOT NULL DEFAULT '0' COMMENT '联动类型ID',
  `linkage_select_selectnum` int(11) NOT NULL DEFAULT '0' COMMENT '联动类型的select限制数量',
  `linkage_select_parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '联动类型从哪个分类开始',
  `field_order` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `is_system` int(11) NOT NULL DEFAULT '0' COMMENT '是否为系统字段',
  `list_show` int(11) NOT NULL DEFAULT '0' COMMENT '是否在后台列表中 显示0=显示，1不显示',
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=675 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC");
E_D("replace into `model_field` values('664','8','comments_total','评论','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('663','8','flag_img','图片','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('661','8','flag_a','特推','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('662','8','flag_d','幻灯','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('660','8','flag_s','滚动','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('659','8','flag_h','头条','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('658','8','flag_c','推荐','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('657','8','info_extern','扩展数据','html_editor_complex','','','','','0','0','0','50','1','0');");
E_D("replace into `model_field` values('656','8','create_time','创建时间','sjc','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('655','8','info_jump_url','跳转地址','varchar_single_line','','','','255','0','0','0','50','1','0');");
E_D("replace into `model_field` values('654','8','info_py','标题拼音','varchar_single_line','','','','100','0','0','0','2','1','0');");
E_D("replace into `model_field` values('653','8','info_order','排序','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('652','8','info_visitors','浏览量','int_','','','','11','0','0','0','50','1','1');");
E_D("replace into `model_field` values('489','51','info_id','资讯ID','int_','','','','11','0','0','0','50','1','1');");
E_D("replace into `model_field` values('512','0','height','高度','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','255','0','0','0','50','0','1');");
E_D("replace into `model_field` values('651','8','info_from','来源','varchar_single_line','','','50','100','0','0','0','50','0','0');");
E_D("replace into `model_field` values('650','8','info_editor','责任编辑','varchar_single_line','','','','50','0','0','0','50','1','1');");
E_D("replace into `model_field` values('649','8','info_body','介绍','html_editor_complex','','','','','0','0','0','50','0','1');");
E_D("replace into `model_field` values('641','8','info_id','资讯ID','int_','','','','11','0','0','0','50','1','1');");
E_D("replace into `model_field` values('642','8','last_cate_id','类别ID','int_','','','','11','0','0','0','50','1','1');");
E_D("replace into `model_field` values('643','8','audit','是否审核','int_','','','','11','0','0','0','50','1','0');");
E_D("replace into `model_field` values('644','8','info_title','标题','varchar_single_line','','','','255','0','0','0','50','0','1');");
E_D("replace into `model_field` values('645','8','info_img','封面','simage','','','','255','0','0','0','50','1','1');");
E_D("replace into `model_field` values('646','8','info_attr_title','标题样式','varchar_single_line','','','','255','0','0','0','50','1','0');");
E_D("replace into `model_field` values('647','8','info_tags','标签','varchar_single_line','','','','100','0','0','0','50','1','0');");
E_D("replace into `model_field` values('648','8','info_desc','摘要','multi_line','','','','255','0','0','0','50','0','0');");
E_D("replace into `model_field` values('665','9','id','ID','int_','','','','11','0','0','0','0','1','1');");
E_D("replace into `model_field` values('666','9','is_check','是否审核','int_','','','','11','0','0','0','0','1','0');");
E_D("replace into `model_field` values('667','9','corder','排序','int_','','','','11','0','0','0','0','1','0');");
E_D("replace into `model_field` values('668','9','username','姓名','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','20','0','0','0','50','0','1');");
E_D("replace into `model_field` values('669','9','content','留言内容','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','255','0','0','0','50','0','1');");
E_D("replace into `model_field` values('670','9','ipaddr','ip地址','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','20','0','0','0','50','0','1');");
E_D("replace into `model_field` values('671','9','create_time','留言时间','sjc','{\"ini_value\":\"\",\"default_value\":\"\"}','','','11','0','0','0','50','0','1');");
E_D("replace into `model_field` values('672','9','mobile','电话','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','50','0','0','0','50','0','1');");
E_D("replace into `model_field` values('673','9','email','邮箱','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','30','0','0','0','50','0','1');");
E_D("replace into `model_field` values('674','9','reply','回复','varchar_single_line','{\"ini_value\":\"\",\"default_value\":\"\"}','','','255','0','0','0','50','0','0');");

require("../../inc/footer.php");
?>