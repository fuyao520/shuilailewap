<?php
class SiteController extends AdminController{
	public function filters(){
		return array(
			'accessControl',
		);
	}	
	public function actionIndex(){echo Yii::app()->admin_user->isGuest;
		if(Yii::app()->admin_user->isGuest){
			$this->redirect(array('site/login'));
		}else{
			//echo Yii::app()->admin_user->uname;
			$this->redirect(array('frame/index'));
		}
	}	
	public function actionLogin(){
		$this->admin_style='default';
		if(!Yii::app()->admin_user->isGuest){
			$this->redirect(array('frame/index'));
		}
		$model = new AdminLoginForm;
        // collect user input data
        $uname=isset($_POST['uname'])?$_POST['uname']:'';
		$upass=isset($_POST['upass'])?$_POST['upass']:'';
		$rancode=isset($_POST['rancode'])?$_POST['rancode']:'';
        if (isset($_POST['uname'])) {
            $model->username=$uname;
            $model->password=$upass;
            if($rancode==''){
            	$this->msg(array('state'=>0,'msgwords'=>'验证码不能为空'));
            } 
            if(!isset($_SESSION['rancode'])||$_SESSION['rancode']!=$rancode){
            	$this->msg(array('state'=>0,'msgwords'=>'验证码无效'));
            }           
            $user_model = AdminUser::model ()->findByAttributes (array ('csname' => $model->username));
			if ($user_model==null) {
				$this->msg(array('state'=>0,'msgwords'=>'账号不存在'));
			}
			if ($user_model->cspwd != AdminUser::password ( $upass )) {
				$this->msg(array('state'=>0,'msgwords'=>'密码不正确'));
			}
			if($user_model->csstatus==1){
				$this->msg(array('state'=>0,'msgwords'=>'账号禁止登陆'));
			}
			// print_r($user_model);die('aa');
			if ($model->login ()) {
				$attributes = array (
					'last_loginip' => ip2long ( Yii::app ()->request->userHostAddress ),
					'last_logindate' => date ( 'Y-m-d H:i:s', time () ) 
				);	
				$this->logs('登陆成功');
				$this->msg(array('state'=>1,'msgwords'=>'登陆成功','url'=>$this->createUrl('frame/index')));
				
			}
         
		
		}
		$this->render('login');
	}
	public function actionEditPassword(){
		$uname=Yii::app()->admin_user->uname;
		if(isset($_POST['old_upass'])){
			$old_upass=$this->post('old_upass');
			$upass=$this->post('new_upass');
			if($old_upass==''){
				$this->msg(array("state"=>0,"msgwords"=>'原始密码不能为空'));
			}		
			if(verify::check_password($upass)==0){
				$this->msg(array("state"=>0,"msgwords"=>'新密码不合法'));
			}
			$old_upass=AdminUser::password($old_upass);
			$upass=AdminUser::password($upass);
			$m=AdminUser::model()->findByAttributes(array('csname'=>$uname,'cspwd'=>$old_upass));
			if(!$m){
				$this->msg(array("state"=>0,"msgwords"=>'原始密码不正确'));
			}
			$m->cspwd=$upass;
			$dbresult=$m->save();
			if($dbresult){
				$this->logs('修改了密码');
				$this->msg(array('state'=>1,'msgwords'=>'密码修改成功'));			
			}else{
				$this->msg(array('state'=>0,'msgwords'=>'操作失败，未知原因'));
			}
		}
		$this->render('editPassword');
	}
	public function actionLogout(){
		$this->logs('退出系统');
		Yii::app()->admin_user->logout();
		$this->redirect('site/login');
	}
	
}