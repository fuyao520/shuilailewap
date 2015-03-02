<?php
class AdminModule extends  CWebModule{
	public function init()
	{
	
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
	
		// import the module-level models and components
		$this->setImport(array(
				'admin.models.*',
				'admin.components.*',
				'admin.widget.*',
		));
		Yii::app()->user->loginUrl = '/admin/site/login';
		//这里重写父类里的组件
		//如有需要还可以参考API添加相应组件
		Yii::app()->setComponents(array(
		'errorHandler'=>array(
		'class'=>'CErrorHandler',
		'errorAction'=>'admin/site/error',
		),
		'admin_user'=>array(
		'class'=>'AdminWebUser',//后台登录类实例
		'stateKeyPrefix'=>'admin',//后台session前缀
		'loginUrl'=>Yii::app()->createUrl('admin/site/login'),
		// 'returnUrl'=>Yii::app()->createUrl('admin/node/index'),
		),
		), false);
		
		
		
		//页码
		$_GET['p']=isset($_GET['p'])&&$_GET['p']>=1?intval($_GET['p']):1;
		
	}
	
	public function beforeControllerAction($controller, $action){
		if(parent::beforeControllerAction($controller, $action)){
			// this method is called before any module controller action is performed
			// you may place customized code here
			if(parent::beforeControllerAction($controller, $action)){
				$route=$controller->id.'/'.$action->id;
				//                if(!$this->allowIp(Yii::app()->request->userHostAddress) && $route!=='default/error')
					//                    throw new CHttpException(403,"You are not allowed to access this page.");
				$publicPages=array(
						'site/login',
						'post/VerifyCode',
				);
				if(Yii::app()->admin_user->isGuest && !in_array($route,$publicPages)){
					Yii::app()->admin_user->loginRequired();
				}else{
					if(!Yii::app()->admin_user->isGuest && !$this->check_auth($controller,$action)){
						die('no access');
					}
					return true;
					
				}
			}
			return true;
		}else{
			return false;
	
		}
	}
	
	private function check_auth($controller,$action){
		$auth_tag=$controller->id.'_'.$action->id;//die($auth_tag);
		foreach(struct::$public_user_auth as $r){
			if(stripos($r,'*')){
				if(preg_match('~'.$r.'~i',$auth_tag)){
					return true;
				}
			}else{
				if(strtolower($r)==strtolower($auth_tag)){
					return true;
				}
			}
		}
		$group_id=Yii::app()->admin_user->groupid;
		$uid=Yii::app()->admin_user->uid;
		if($uid==Yii::app()->params['management']['super_admin_id']
				|| $group_id==Yii::app()->params['management']['super_group_id']
		){
			return true;
		}
		$levels=Yii::app()->admin_user->mylevel;
		$levels=is_array($levels)?$levels:array();
		foreach ($levels as $r){
			if(stripos($r,'*')){
				if(preg_match('~'.$r.'~i',$auth_tag)){
					return true;
				}
			}else{//echo $r.'::::'.$auth_tag.'<br>';
				if(strtolower($r)==strtolower($auth_tag)){
					return true;
				}
			}	
		}
		
	}
	
}