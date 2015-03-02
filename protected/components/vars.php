<?php 
//预定义数组
class vars {
    public static $fields=array(
		//模型的类型	
		'model_types'=>array(
			array('value'=>0,'txt'=>'内容模型'),
			array('value'=>1,'txt'=>'表单模型'),
			array('value'=>2,'txt'=>'会员模型'), 
		),
		'comments_types'=>array(
			array('value'=>1,'txt'=>'内容评论','mark'=>'info'), 
		),
		'ad_show_types'=>array(
			array('value'=>0,'txt'=>'代码'),
			array('value'=>1,'txt'=>'文字'),
			array('value'=>2,'txt'=>'图片'),
			array('value'=>3,'txt'=>'flash'),
		),
		'resource_types'=>array(
			array('value'=>1,'txt'=>'图片'), 
			array('value'=>2,'txt'=>'视频'),
			array('value'=>3,'txt'=>'下载'),
		),
		//表单类型
		'form_types'=>array(
			array('value'=>'varchar_single_line','txt'=>'(varchar)(varchar_single_line)单行文本','type'=>'varchar'),
			array('value'=>'char_single_line','txt'=>'(char)(char_single_line)单行文本','type'=>'char'),
			array('value'=>'multi_line','txt'=>'(varchar)(multi_line)多行文本','type'=>'varchar'),
			array('value'=>'text_area','txt'=>'(text)(multi_line)文本区域','type'=>'text'),
			array('value'=>'html_editor_simple','txt'=>'(text)(html_editor_simple)html编辑器（简洁）','type'=>'text'),
			array('value'=>'html_editor_complex','txt'=>'(text)(html_editor_complex)html编辑器（普通）','type'=>'text'),
			array('value'=>'int_','txt'=>'(int)(int_)数字类型','type'=>'int'),
			array('value'=>'decimal_','txt'=>'(decimal)(decimal_)小数类型','type'=>'decimal'),
			array('value'=>'sjc','txt'=>'(int)(sjc)时间戳（完整）','type'=>'int'),
			array('value'=>'sjc_date','txt'=>'(int)(sjc_date)时间戳（日期）','type'=>'int'),
			array('value'=>'simage','txt'=>'(varchar)(simage)缩略图','type'=>'varchar'),
			array('value'=>'image','txt'=>'(varchar)(image)图片','type'=>'varchar'),
			array('value'=>'file_','txt'=>'(varchar)(file_)附件','type'=>'varchar'),
			array('value'=>'option','txt'=>'(int)(option)option下拉','type'=>'int'),
			array('value'=>'option_text','txt'=>'(varchar)(option_text)option下拉','type'=>'varchar'),
			array('value'=>'option_for_text','txt'=>'(varchar)(option_for_text)文本+下拉','type'=>'varchar'),
			array('value'=>'radio','txt'=>'(int)(radio)radio单选','type'=>'int'),
			array('value'=>'checkbox','txt'=>'(varchar)(checkbox)checkbox复选框','type'=>'varchar'),
			array('value'=>'linkage','txt'=>'(int)(linkage)多级菜单联动','type'=>'int'),	
		),
		//顶层内容模型字段
		'model_default_fields'=>array(
			array('field_txt'=>'资讯ID','field_name'=>'info_id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'类别ID','field_name'=>'last_cate_id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'是否审核','field_name'=>'audit','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'标题','field_name'=>'info_title','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'255','field_order'=>'50','is_system'=>'0','list_show'=>1),
			array('field_txt'=>'封面','field_name'=>'info_img','form_type'=>'simage','setting'=>'','tips'=>'','pattern'=>'','length'=>'255','field_order'=>'50','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'标题样式','field_name'=>'info_attr_title','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'255','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'标签','field_name'=>'info_tags','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'100','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'摘要','field_name'=>'info_desc','form_type'=>'multi_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'255','field_order'=>'50','is_system'=>'0','list_show'=>0),
			array('field_txt'=>'介绍','field_name'=>'info_body','form_type'=>'html_editor_complex','setting'=>'','tips'=>'','pattern'=>'','length'=>'','field_order'=>'50','is_system'=>'0','list_show'=>1),
			array('field_txt'=>'责任编辑','field_name'=>'info_editor','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'50','field_order'=>'50','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'来源','field_name'=>'info_from','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'50','length'=>'100','field_order'=>'50','is_system'=>'0','list_show'=>0),
			array('field_txt'=>'浏览量','field_name'=>'info_visitors','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'排序','field_name'=>'info_order','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'标题拼音','field_name'=>'info_py','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'100','field_order'=>'2','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'跳转地址','field_name'=>'info_jump_url','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'255','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'创建时间','field_name'=>'create_time','form_type'=>'sjc','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'扩展数据','field_name'=>'info_extern','form_type'=>'html_editor_complex','setting'=>'','tips'=>'','pattern'=>'','length'=>'','field_order'=>'50','is_system'=>'1','list_show'=>0),
			
			
			array('field_txt'=>'推荐','field_name'=>'flag_c','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'头条','field_name'=>'flag_h','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'滚动','field_name'=>'flag_s','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'特推','field_name'=>'flag_a','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'幻灯','field_name'=>'flag_d','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			array('field_txt'=>'图片','field_name'=>'flag_img','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
				
			array('field_txt'=>'评论','field_name'=>'comments_total','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'50','is_system'=>'1','list_show'=>0),
			
		),
		//子模型字段
		'modelc_default_fields'=>array(
			array('field_txt'=>'ID','field_name'=>'id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'信息ID','field_name'=>'info_id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>1),
			//array('field_txt'=>'标题','field_name'=>'info_title','form_type'=>'varchar_single_line','setting'=>'','tips'=>'','pattern'=>'','length'=>'255','field_order'=>'50','is_system'=>'0','list_show'=>1),
			/**
			如果有三级模型,  这里会生成上一级父模型 的"表名_id"的字段，上层模型越多，字段则越多,
			比如 小说 story 是顶层模型，章节 story_chapter 是 第二层模型, 章节内容 story_content 是第三层模型 ， 则 story_content 里会保存 story_content_id 这个字段，comment  '章节id' 
			
			**/
			array('field_txt'=>'排序','field_name'=>'corder','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>0),
			
		),
		//表单模型
		'modeld_default_fields'=>array(
			array('field_txt'=>'ID','field_name'=>'id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'是否审核','field_name'=>'is_check','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>0),	
			array('field_txt'=>'排序','field_name'=>'corder','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>0),	
		),
		//会员模型
		'modelm_default_fields'=>array(
			array('field_txt'=>'ID','field_name'=>'id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>1),
			array('field_txt'=>'会员ID','field_name'=>'user_id','form_type'=>'int_','setting'=>'','tips'=>'','pattern'=>'','length'=>'11','field_order'=>'0','is_system'=>'1','list_show'=>1),
			
		),
		'info_attr_limits'=>array(
			array('value'=>'headline','txt'=>'头条'),
			array('value'=>'scroll','txt'=>'滚动'),
			array('value'=>'slideshow','txt'=>'幻灯'),
			array('value'=>'hot','txt'=>'热门'),
			array('value'=>'recommend','txt'=>'推荐'),
		),
		'special_node'=>array(
			array('value'=>1,'txt'=>'节点一'), 
			array('value'=>2,'txt'=>'节点二'),
			array('value'=>3,'txt'=>'节点三'), 
			array('value'=>4,'txt'=>'节点四'), 
		),
		'templates_types'=>array(
			array('type'=>'display','txt'=>'封面模版','dir'=>'i/display/'),
			array('type'=>'listvar','txt'=>'列表变量','dir'=>'i/listvar/'),
			array('type'=>'detail','txt'=>'详细模版','dir'=>'i/detail/'),		
		),
		//充值方式
		'pay_type'=>array(
			array('value'=>1,'txt'=>'支付宝'), 
			array('value'=>2,'txt'=>'财付通'),
			array('value'=>3,'txt'=>'银联'), 
			array('value'=>4,'txt'=>'盛付通'), 
			array('value'=>5,'txt'=>'汇款'), 
			
		),
		//付款方式
		'pay_type2'=>array(
			array('value'=>1,'txt'=>'支付宝及时到账'), 
			array('value'=>3,'txt'=>'银联'), 
			array('value'=>5,'txt'=>'汇款'),
			array('value'=>6,'txt'=>'余额支付'),
			array('value'=>7,'txt'=>'余额+支付宝'),
			array('value'=>8,'txt'=>'货到付款'),
			array('value'=>9,'txt'=>'余额+优惠券'),
			array('value'=>10,'txt'=>'支付宝担保交易'), 
			 
		),
		//支付结果
		'pay_state'=>array(
			array('value'=>0,'txt'=>'等待付款'),
			array('value'=>1,'txt'=>'支付成功'),
			array('value'=>2,'txt'=>'支付失败'), 
		),
		//订单状态
		'order_state'=>array(
			array('value'=>0,'txt'=>'等待付款'),
			array('value'=>1,'txt'=>'交易成功'), 
			array('value'=>2,'txt'=>'交易失败'), 
			array('value'=>3,'txt'=>'担保交易'), 
		),
		//兑换状态
		'exchange_state'=>array(
			array('value'=>0,'txt'=>'未兑换'),
			array('value'=>1,'txt'=>'已兑换'), 
		),
		//物流方式
		'shipping_type'=>array(
			array('value'=>1,'txt'=>''), 
			array('value'=>2,'txt'=>'财付通'),
			array('value'=>3,'txt'=>'网银在线'), 
			array('value'=>4,'txt'=>'盛付通'), 
			array('value'=>5,'txt'=>'汇款'), 
		),
		'search_type'=>array(
			array('value'=>'article','txt'=>'资讯'), 
			array('value'=>'goods','txt'=>'商品'), 
		),
		//优惠券状态
		'coupons_state'=>array(
			array('value'=>0,'txt'=>'可使用'),
			array('value'=>1,'txt'=>'已使用'), 
		),
		//为静态类型
		'rewrite_type'=>array(
			array('value'=>0,'txt'=>'栏目页'),
			array('value'=>1,'txt'=>'详情页'),
			array('value'=>2,'txt'=>'其它页'),
		),
    	/*企业类型*/	
    	'company_types'=>array(
    			array('value'=>1,'txt'=>'私营'),
    			array('value'=>2,'txt'=>'国企'),
    			array('value'=>3,'txt'=>'集体'),
    			array('value'=>4,'txt'=>'股份'),
    			array('value'=>5,'txt'=>'外商独资'),
    			array('value'=>6,'txt'=>'中外合资'),
    			array('value'=>7,'txt'=>'国有体制'),
    			
    	),
    	'constellations'=>array(
    		array('value'=>'白羊座','en'=>'Aries','txt'=>'白羊座')	,
    		array('value'=>'金牛座','en'=>'Taurus','txt'=>'金牛座')	,	
    		array('value'=>'双子座','en'=>'Gemini','txt'=>'双子座')	,
    		array('value'=>'巨蟹座','en'=>'Cancer','txt'=>'巨蟹座')	,
    		array('value'=>'狮子座','en'=>'Leo','txt'=>'狮子座')	,	
    		array('value'=>'处女座','en'=>'Virgo','txt'=>'处女座')	,
    		array('value'=>'天秤座','en'=>'Libra','txt'=>'天秤座')	,	
    		array('value'=>'天蝎座','en'=>'Scorpio','txt'=>'天蝎座')	,	
    		array('value'=>'射手座','en'=>'Sagittarius','txt'=>'射手座')	,	
    		array('value'=>'摩羯座','en'=>'Capricorn','txt'=>'摩羯座')	,	
    		array('value'=>'水瓶座','en'=>'Aquarius','txt'=>'水瓶座')	,	
    		array('value'=>'双鱼座','en'=>'Pisces','txt'=>'双鱼座')	,	
    	)	,
    	'direction_types'=>array(
    		array('value'=>'1','txt'=>'南方地区')	, 
    		array('value'=>'2','txt'=>'北方地区')	,
    	
    			
    	),
    		
    		//公司规模
    		'company_scales'=>array(
    				array('value'=>1,'txt'=>'20人以下'),
    				array('value'=>2,'txt'=>'20-50人'),
    				array('value'=>3,'txt'=>'50-100人'),
    				array('value'=>4,'txt'=>'100-300人'),
    				array('value'=>5,'txt'=>'300-1000人'),
    				array('value'=>6,'txt'=>'1000人以上'),
    		
    		)	,
    		//注册资本
    		'reg_assets'=>array(
    				array('value'=>1,'txt'=>'10万'),
    				array('value'=>2,'txt'=>'50万'),
    				array('value'=>3,'txt'=>'100-500万'),
    				array('value'=>4,'txt'=>'500-1000万'),
    				array('value'=>5,'txt'=>'1000万以上'),
    		
    		)	,
    		
    		
    		
    		//收藏类型
    		'collect_types'=>array(
    				array('value'=>'goods','txt'=>'商品','table'=>'goods'),    				    		
    		),
    		//浏览类型
    		'visit_types'=>array(
    				array('value'=>'goods','txt'=>'商品','table'=>'goods'),   		
    		),
		
	);	
	 /**
     * 返回某个节点的某个值
$node   节点
     *    $value  值
     */
    public static function get_field($node, $value) {
        // 遍历某个节点
        foreach(vars :: $fields[$node] as $f) {
            if ($f['value'] == $value) {
                return $f; //print_r($field);
            } 
        } 
        return array('value' => '', 'txt' => '-', 'txt_color' => '');
    } 

    /**
     * 根据值，返回文本或者HTML
     *    $node   节点
     *    $value  值
$type   返回类型 txt 文本 html 带颜色属性的HTML文本
     */
    public static function get_field_str($node, $value, $type = 'txt') {
        $field = vars :: get_field($node, $value); //print_r($field);
     	return $field[$type];
		
	   /* if ($type == 'txt') {
            return $field['txt'];
        } else {
            return '<font color="' . (isset($field['txt_color'])?$field['txt_color']:'') . '">' . $field['txt'] . '</font>';
        } */
    } 
    /**
     * 输出HTML表单
     *    $params 参数数组 array('node'=>'','type'=>'','default'=>'')
     *    -> $type 表单类型 select,checkbox,radio
     *    -> $node    节点
     *    -> $default 默认选中
     *    -> $name    表单名称后缀，用于一个页面多次出现时候区分
     */
    public static function input_str($params) {
        // 初始化
        $node = isset($params['node'])?$params['node']:'';
        $type = isset($params['type'])?$params['type']:'select';
        $default = isset($params['default'])?$params['default']:'';
        $name = isset($params['name'])?$params['name']:''; 
        // 下拉框
        if ($type == 'select') {
            $html = '';
            foreach(vars :: $fields[$node] as $f) {
                $select = '';
                if (strlen($default) > 0 && $f['value'] == $default) $select = ' selected';
                $html .= '<option value="' . $f['value'] . '"' . $select . '>' . $f['txt'] . '</option>';
            } 
            $html .= '';
            return $html;
        } 
        // 单选框
        if ($type == 'radio') {
            $html = '';
            foreach(vars :: $fields[$node] as $f) {
                $select = '';
                if (strlen($default) > 0 && $f['value'] == $default) $select = ' checked';
                $html .= '<input type="radio" name="' . ($name?$name:$node) . '" value="' . $f['value'] . '"' . $select . '>&nbsp;' . $f['txt'] . '&nbsp;&nbsp;';
            } 
            return $html;
        } 
        // 复选框
        if ($type == 'checkbox') {
            $html = '';
            foreach(vars :: $fields[$node] as $f) {
                $select = '';
                if (strlen($default) > 0 && $f['value'] == $default) $select = ' checked';
                $html .= '<input type="checkbox" name="' .( $name?$name:$node)  . '" value="' . $f['value'] . '"' . $select . '>&nbsp;' . $f['txt'] . '&nbsp;&nbsp;';
            } 
            return $html;
        } 
        return '-';
    } 
	
}
?>