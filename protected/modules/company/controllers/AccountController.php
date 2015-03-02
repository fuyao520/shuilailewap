<?php
class AccountController extends  CompanyController{
		
	public function actionBindEmail(){
		$page=array();	
		$uid=Yii::app()->company_user->uid;
		$m=CompanyUser::model()->findByPk($uid);
		$page['user']=Dtable::toArr($m);
		if($_POST){
			if($m->uemail_verify==1){
				$this->msg(array('state'=>-1,'msgwords'=>'已绑定邮箱','type'=>'json'));
			}
			$email=$this->post('email');
			$email_rancode=$this->post('email_rancode');
			$email_verify_code=$this->post('email_verify_code');
			if(!verify::check_email($email)){
				$this->msg(array('state'=>-1,'msgwords'=>'邮箱格式不正确'.$email,'type'=>'json'));
			}
			if($_SESSION['rancode']!=$email_rancode){
				$this->msg(array('state'=>-2,'msgwords'=>'图片验证码错误','type'=>'json'));
			}
			if($_SESSION['email_message_rancode']!=$email_verify_code){
				$this->msg(array('state'=>-3,'msgwords'=>'邮箱验证码错误','type'=>'json'));
			}
			if($_SESSION['bind_email']!=$email){
				$this->msg(array('state'=>-3,'msgwords'=>'邮箱和验证码不匹配','type'=>'json'));
			}
			$m->uemail=$email;
			$m->uemail_verify=1;
			$m->save();			
			$this->msg(array('state'=>1,'msgwords'=>'成功绑定邮箱','type'=>'json'));
				
		}	
		$this->render('/account_bind_email',array('page'=>$page));
	}
	
	//绑定手机号
	public function actionBindMobile(){
		$page=array();
		$uid=Yii::app()->company_user->uid;
		$m=CompanyUser::model()->findByPk($uid);
		$page['user']=Dtable::toArr($m);
		if($_POST){		
			if($m->uphone_verify==1){
				$this->msg(array('state'=>-1,'msgwords'=>'已绑定手机号','type'=>'json'));
			}
			$cellphone=intval($this->post('cellphone'));
			$cellphone_rancode=$this->post('cellphone_rancode');
			$cellphone_verify_code=$this->post('cellphone_verify_code');
			if(!preg_match('~1\d{10}$~',$cellphone,$r2)){
				$this->msg(array('state'=>-1,'msgwords'=>'手机号格式不正确','type'=>'json'));
			}
			if($_SESSION['cellphone_rancode']!=$cellphone_rancode){
				$this->msg(array('state'=>-2,'msgwords'=>'图片验证码错误','type'=>'json'));
			}
			if($_SESSION['message_rancode']!=$cellphone_verify_code){
				$this->msg(array('state'=>-3,'msgwords'=>'短信验证码错误','type'=>'json'));
			}
			if($_SESSION['bind_cellphone']!=$cellphone){
				$this->msg(array('state'=>-3,'msgwords'=>'手机号和验证码不匹配','type'=>'json'));
			}
			//手机号码是唯一的
			$m->uphone=$cellphone;
			$m->uphone_verify=1;
			$m->save();			
			if(isset($_SESSION['old_cellphone_verify'])){
				unset($_SESSION['old_cellphone_verify']);
			}
			$this->msg(array('state'=>1,'msgwords'=>'成功绑定手机号','type'=>'json'));
			
		}
		$this->render('/account_bind_mobile',array('page'=>$page));
	}
	
	//发送手机验证码
	public function actionSentMobileMessage(){
		$cellphone=$this->post('cellphone');
		$cellphone_rancode=$this->post('cellphone_rancode');
		if(!preg_match('~1\d{10}$~',$cellphone,$r2)){
			$this->msg(array('state'=>-1,'msgwords'=>'手机号格式不正确','type'=>'json'));
		}
		if(!isset($_SESSION['cellphone_rancode']) || $_SESSION['cellphone_rancode']!=$cellphone_rancode){
			$this->msg(array('state'=>-2,'msgwords'=>'图片验证码错误','type'=>'json'));
		}
	
		if(!isset($_COOKIE['message_rancode02'])){
			//发送间隔时间为五分钟
			$cookietime=time()+60*1;
			$cookie_domain=Yii::app()->params['basic']['cookie_domain'];
			$cookie_path='/';
		}else{
			$this->msg(array('state'=>-6,'msgwords'=>'两分钟后再试','type'=>'json'));
		}	
		$message_rancode=helper::randstr(6);
		$_SESSION['message_rancode']=$message_rancode;
		$_SESSION['bind_cellphone']=$cellphone;
		//发送短信
		$field=array();
		$field['mobile_arr'][]=$cellphone;
		$field['content']='手机短信验证码：'.$message_rancode.''.Yii::app()->params['basic']['sitename'];
		$field['content']=iconv('UTF-8','GB2312',$field['content']);
		$field['send_time']='';
		$result=helper::send_message($field);
		if($result['code']==1){
			setcookie("message_rancode02",1,$cookietime,$cookie_path,$cookie_domain);
			$this->msg(array('state'=>1,'msgwords'=>'发送成功(测试'.$message_rancode.')','type'=>'json'));
		}else{
			$this->msg(array('state'=>0,'msgwords'=>'发送失败','type'=>'json'));
		}
	
	
	}
	
	//注册时候发送手机验证码
	public function actionRegSentMobileMessage(){
		$cellphone=$this->post('cellphone');
		if(!preg_match('~1\d{10}$~',$cellphone,$r2)){
			$this->msg(array('state'=>-1,'msgwords'=>'手机号格式不正确','type'=>'json'));
		}		
	
		if(!isset($_COOKIE['message_rancode02'])){
			//发送间隔时间为五分钟
			$cookietime=time()+60*1;
			$cookie_domain=Yii::app()->params['basic']['cookie_domain'];
			$cookie_path='/';
		}else{
			$this->msg(array('state'=>-6,'msgwords'=>'两分钟后再试','type'=>'json'));
		}
		$message_rancode=helper::randstr(6);
		$_SESSION['message_rancode']=$message_rancode;
		$_SESSION['bind_cellphone']=$cellphone;
		//发送短信
		$field=array();
		$field['mobile_arr'][]=$cellphone;
		$field['content']='手机短信验证码：'.$message_rancode.''.Yii::app()->params['basic']['sitename'];
		$field['content']=iconv('UTF-8','GB2312',$field['content']);
		$field['send_time']='';
		$result=helper::send_message($field);
		if($result['code']==1){
			setcookie("message_rancode02",1,$cookietime,$cookie_path,$cookie_domain);
			$this->msg(array('state'=>1,'msgwords'=>'发送成功(测试'.$message_rancode.')','type'=>'json'));
		}else{
			$this->msg(array('state'=>0,'msgwords'=>'发送失败','type'=>'json'));
		}
	
	
	}
	
	//发送邮箱验证码
	public function actionSentEmailMessage(){
		$uid=Yii::app()->company_user->uid;
		$muser=CompanyUser::model()->findByPk($uid);
		$email=$this->post('email');
		$email_rancode=$this->post('email_rancode');
		if(verify::check_email($email)==0){
			$this->msg(array('state'=>-1,'msgwords'=>'邮箱格式不正确','type'=>'json'));
		}
		if($_SESSION['rancode']!=$email_rancode){
			$this->msg(array('state'=>-2,'msgwords'=>'图片验证码错误','type'=>'json'));
		}
		$m=CompanyUser::model()->findByAttributes(array('uemail'=>$email));
		if($m){
			if($uid!=$m->uid){
				$this->msg(array('state'=>-2,'msgwords'=>'该邮箱已被注册','type'=>'json'));
			}
		}
		
		if(!isset($_COOKIE['email_message_rancode02'])){
			//发送间隔时间为10秒钟
			$cookietime=time()+10*1;
			$cookie_domain=Yii::app()->params['basic']['cookie_domain'];
			$cookie_path='/';
		}else{
			$this->msg(array('state'=>-6,'msgwords'=>'10秒后再试','type'=>'json'));
		}
		$email_message_rancode=helper::randstr(6);
		$_SESSION['email_message_rancode']=$email_message_rancode;
		$_SESSION['bind_email']=$email;
		//发送验证码
		$username=$muser->uname;
		$to=$email;
		$mail_title="邮箱验证码-".Yii::app()->params['basic']['sitename'];
		$mail_body="您的验证码是".$email_message_rancode;
		$result=helper::send_email($username,$to,$mail_title,$mail_body);
		if($result){
			setcookie("message_rancode02",1,$cookietime,$cookie_path,$cookie_domain);
			$this->msg(array('state'=>1,'msgwords'=>'发送成功','type'=>'json'));
		}else{
			$this->msg(array('state'=>0,'msgwords'=>'发送失败','type'=>'json'));
		}
	
	
	}
	
	
	
	
}