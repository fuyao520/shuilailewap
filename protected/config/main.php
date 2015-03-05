<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Shui lai le',
		
	'theme'=>'default',	
	
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*', 
		'application.components.*',
		
	),

	'defaultController'=>'site',

	'modules'=>array(
		'admin',
		'upload',
		'user',
		'company',
		'wap'
	
	),
	
	'preload'=>array('log'),
	// application components
	'components'=>array(
		'session'=>array(
				'timeout'=>3600*24*365,
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
	
		// uncomment the following to use a MySQL database
		
		//测试域名自动根据检测数据库配置文件
		'db'=>require(dirname(__FILE__).'/'.(strpos($_SERVER['HTTP_HOST'],'localhost')?'db_test':'db').'.php'),
		
		
		'cache' => array (
		
				'class' => 'system.caching.CFileCache',
				'directoryLevel' => 1,
		
		),
		'dbcache'=>array(
				'class'=>' system.caching.CDbCache',
		),
		
		
		
		
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName' => false,
			'rules'=>array(			
				'post/<id:\d+>/<title:.*?>'=>'post/view',
				'posts/<tag:.*?>'=>'post/index',
				'admin2050'=>'admin/site/login',
                'wap'=>'wap/site/index',
				'map/?'=>'site/map',
				'admin/site/login'=>'site/error',				
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'Detail-<cate_id:\d+>-<info_id:\d+>\.html'=>'details/index',
				'details/<info_id:\d+>\.html'=>'details/index/model_table_name/article',
				'games/<info_id:\d+>\.html'=>'details/index/model_table_name/game_mobile',
				'goods/<info_id:\d+>\.html'=>'details/index/model_table_name/goods',
				'<cname_py:\w+>'=>'cate/index',
				'<cname_py:\w+>/<p:\d+>\.html'=>'cate/index',
				'list-<cate_id:\d+>-<p:\d+>\.html'=>'cate/index',
				/*商品筛选*/
				'goods-<cname_py:\w+>-<area:\d*>-<brand:\d*>-<guige:\d*>-<order:\d*>-<search_txt:.*>-<p:\d*>\.html'=>'cate/goods',
				/*水站筛选*/
				'companys-<area:\d*>-<brand:\d*>-<location_x:.*>-<location_y:.*>-<order:\d*>-<search_txt:.*>-<p:\d*>\.html'=>'companys/index',
		
				'search/<search_txt:.*>/?'=>'search/index',
				'search/<search_txt:.*>/<p:\d+>'=>'search/index',
                'w3g'=>'wap/site/index'
			),
		),
		/*
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// 下面显示页面日志
	            array(
	                'class'=>'CWebLogRoute',
	                'levels'=>'trace',
	                级别为trace
	                'categories'=>'system.db.*'
	                //只显示关于数据库信息,包括数据库连接,数据库执行语句
	            ),
			),
		),
		*/
		'search_article' => array(
				'class' => 'application.extensions.xunsearch.EXunSearch',
				'xsRoot' => ' /usr/local/xunsearch',  // xunsearch 安装目录
				'project' => '/usr/local/xunsearch/sdk/php/app/shouyou_article.ini', // 搜索项目名称或对应的 ini 文件路径
				'charset' => 'utf-8', // 您当前使用的字符集（索引、搜索结果）
		),
		'search_game' => array(
				'class' => 'application.extensions.xunsearch.EXunSearch',
				'xsRoot' => ' /usr/local/xunsearch',  // xunsearch 安装目录
				'project' => '/usr/local/xunsearch/sdk/php/app/shouyou_game.ini', // 搜索项目名称或对应的 ini 文件路径
				'charset' => 'utf-8', // 您当前使用的字符集（索引、搜索结果）
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);