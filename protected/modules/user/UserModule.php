<?php
class UserModule extends  CWebModule{
	public function init()
	{
	
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
	
		// import the module-level models and components
		$this->setImport(array(
				'user.models.*',
				'user.components.*',
				'user.widget.*',
				'user.components.qq_connect.*',
				'user.components.weibo_connect.*',
		));
		Yii::app()->user->loginUrl = '/user/site/login';
		//这里重写父类里的组件
		//如有需要还可以参考API添加相应组件
		Yii::app()->setComponents(array(
			'errorHandler'=>array(
			'class'=>'CErrorHandler',
			'errorAction'=>'user/site/error',
			),
			
		), false);
		
		//页码
		$_GET['p']=isset($_GET['p'])&&$_GET['p']>=1?intval($_GET['p']):1;
		
	}
	
	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if(parent::beforeControllerAction($controller, $action)){
				$route=$controller->id.'/'.$action->id;
				//                if(!$this->allowIp(Yii::app()->request->userHostAddress) && $route!=='default/error')
				//                    throw new CHttpException(403,"You are not allowed to access this page.");
				$publicPages=array(
						'site/login',
						'site/reg',
						'site/forgetpassword',
						'site/logout',
						//登陆框
						'site/dialogLogin',
						
						'post/verifyCode',
						'verifyCode/index',
						'post/getCateChildClass',
						'post/getSelectClassForEdit',
						
						/*第三方登陆*/
						'post/qqLogin',
						'post/checkLogin',
						'post/qqLoginBack',
						'post/getUserInfo',
						'post/qqLoginBackMain',
						'post/weiboLogin',
						'post/weiboLoginBack',
						'post/taobaoLogin',
						'post/taobaoLoginBack',
						
						
						/*找回密码*/
						'site/forgetpassword',
						'site/forgetpasswordCheck',
						'site/resetPassword',
						'site/forgetpasswordResetSave',
						
						/*收藏*/
						//'collect/save',
				);
				if(Yii::app()->user->isGuest && !in_array($route,$publicPages))
					Yii::app()->user->loginRequired();
				else
					return true;
			}
	
			return true;
		}
		else
			return false;
	}
	
	
}