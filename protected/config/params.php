<?php

// this contains the application parameters that can be maintained via GUI
return array(
	//网站基本设置，CSS路径，域名，网站名称等
	'basic'=>array(
		'sitename'=>'水来了 ',	 //站点名称，全站标题中都有
		'siteurl'=>'http://shuilaile.izfei.com',	//站点域名路径
		'sitedomain'=>'cms3.izfei.com', //站点主域名 （主要用于泛解析，或者是其他拼装url）
		'wapdomain'=>'', //手机站域名
		'wapopen'=>'1',
		'cssurl'=>'/static/',	//样式表域名
		'upload_server'=>array(//上传资源服务器组，上传时候随机选择 .  资源服务器可分离， 整个框架和app里的upload模块端到新服务器即可 
			'/',   //注意后面要加上 ? 或者 & ，因为有其他参数会串接在这里，为了方便，当前站点请用 /  或者 http://xx.com/ 
		),
        'verify'=>array('secret'=>'feifeifei','key'=>'fefefefe',),//密钥验证字符串前缀，密钥（上传时使用）
		'verify_login'=>array('secret'=>'feifei','key'=>'zhoufei',),//同步其他站点登录时的密钥
		'cookie_domain'=>'.cms3.izfei.com',	//cookie有效域
		'pagesize'=>'20',	//列表页分页大小
        'foothtml'=>'Feicms 系统 Copyright@ All Rights Reserved <br>
			.', //底部公用文件HTML
		'siteid'=>'hxmcw',//本站id
        'tpl'=>'default', //模板 
		'tpl_wap'=>'wap', //手机版模板    
        'icp'=>'赣ICP备10003847号-2',//备案号
        'stat_code'=>'',//统计代码
        'seo_title'=>' ',//首页SEO标题
        'seo_keyword'=>'',//首页SEO关键词
        'seo_description'=>'',//首页SEO描述
		'is_rewrite_url'=>1,  //是否开启伪静态
		'connect_uc_server'=>'0', //是否开启ucenter
		'point_to_vitual_money'=>'0.1',//积分兑换点券的率，即积分乘以这个率 得到点券
		'site_timeout'=>'300', //超过几秒的算不在线  （被用于 当前玩家总数）
	),
	
    //邮件发送设置
	'mail'=>array(
	    'host'=>'smtp.163.com', //邮件发送SMTP服务器
		'port'=>'25', //邮件发送端口
		'username'=>'18607002510@163.com', //发送的邮箱
		'password'=>'zhoufei1991327', //邮箱密码
		'setfrom'=>'18607002510@163.com', //此项跟发送邮箱一致
		'addreplyto'=>'18607002510@163.com', //此项跟发送邮箱一致
		'charset'=>'UTF-8', //编码
		'debug'=>'0', //发送调试输出
        'reciveemail'=>'',
        'isopen'=>'0',
	),
	//微博
	'weibo'=>array(
		'wb_akey'=>'2573837058',
		'wb_skey'=>'f916fe022ecfa3a28d2ff525ce9f0e7c',
		'redirect_uri'=>'http://shuilaile.izfei.com/user/post/weiboLoginBack',
	),
	
	'alipay'=>array(
		//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
		//合作身份者id，以2088开头的16位纯数字
		//'partner'=> '2088202374334457 ',  //fei
		'partner'=>'2088711209415842',//龚健东
		//安全检验码，以数字和字母组成的32位字符
		//'key'	=> 'fjxjk3ujymstoi5u17v9gsz8w2rw0qfx',
		'key' =>'qc6qmlv5adlscfuk9zpfmdrba2c4xp9x',
		//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑
		//签名方式 不需修改
		'sign_type' => strtoupper('MD5'),
		//字符编码格式 目前支持 gbk 或 utf-8
		'input_charset'=> strtolower('utf-8'),
		//ca证书路径地址，用于curl中ssl校验
		//请保证cacert.pem文件在当前文件夹目录中
		'cacert'    => getcwd().'/protected/components/payment/alipay/cacert.pem',
		//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
		'transport'    => 'http',
		//'seller_email'=>'137108692@qq.com',
		'seller_email'=>'2664131719@qq.com',
	),
	
    //公司基本资料
    'company'=>array(
        'company_name'=>'123', //公司名称
        'company_tel400'=>'',//400电话
        'company_tel800'=>'',//800电话
        'company_tel'=>'', //座机
        'company_tax'=>'', //传真
        'company_phone'=>'', //手机
        'company_address'=>'',//地址
        'company_email'=>'',//邮箱
        'company_contact'=>'',//联系人
        'company_qq'=>'',//QQ号码
    ),
	//水印设置
	'water_mark'=>array(
	    'watermarkenabled'=>'0', //是否启用
		'source'=>'', //被打水印的图片
		'watermarktype'=>'0',//水印类型（图片1或文字0）
		'watermarkwidth'=>'100',//被打水印的图片的最小宽度 少于该尺寸则不加水印
		'watermarkheight'=>'100',//被打水印的图片的最小高度 少于该尺寸则不加水印
		'watermarkimg'=>'/img/2013/12/09/52a5cdb1ce4cb.png',//水印图片
		'watermarktext'=>'FEICMS',//水印文字
		'water_mark_font_family'=>'C:/Windows/fonts/simfang.ttf',//水印文字字体
		'watermarkfontsize'=>'25',//水印文字大小
		'watermarkfontcolor'=>'#FFFFFF',//水印文字颜色
		'watermarkpct'=>'85',//水印透明度
		'watermarkquality'=>'80',//JPEG水印图像质量
		'watermarkpos'=>'3',//水印位置(0=随机，1=左上角，2=右上角，3=右下角，4=左下角，5=居中)
	),
	//评论设置
	'comment'=>array(
	    'open'=>'1', //是否开启评论,0=关闭，1=开启
		'limit_time'=>'10', //评论间隔时间，秒
		'visitor_allow'=>'1', //普通游客是否可评论 ,0=不可以 ,1可以
	),
	//后台设置
	'management'=>array(
	    'layout'=>'2', //默认布局
		'name'=>'水来了后台', //后台管理名称
		'menu_open'=>'1', //后台菜单默认展开还是合起
		'super_group_id'=>'1',  //技术组id，在这里定义防止被修改
		'super_admin_id'=>'1',  //总管理员帐号 ，在这里定义防止被修改
		'super_role_id'=>'super_admin', //总角色id，防止被修改
		'pagesize'=>'20', //每页显示
	),
	
	
	
);
