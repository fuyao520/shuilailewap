<?php
class SiteController extends HomeController{
	public $page;
	
	public function filters(){
		return array (
			array (
					'COutputCache',
					'duration' => 3600*24*0,
					'varyByParam' => array('from'),
					'dependency' => array(
							'class'=>'CDbCacheDependency',
							'sql'=>'SELECT MAX(log_id) FROM cservice_aclog',  //根据管理员操作日志去检测缓存是否失效
					)
					
			)
		);
    }
    
	public function actionIndex(){
		$page=array();
		$this->render('/map',array('page'=>$page));
	}
	public function actionMap(){
		$page=array();
		$this->render('/map',array('page'=>$page));
	}

	
}