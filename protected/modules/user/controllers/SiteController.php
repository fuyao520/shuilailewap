<?php
class SiteController extends UserController{
	public function actionIndex(){
		if(Yii::app()->user->isGuest){
			$this->redirect(array('site/login'));
		}else{
			$uid=Yii::app()->user->uid;
			$page=array();
			$m=User::model()->findByPk($uid);
			$m2=UserProfile::model()->findByPk($uid);
			$page['user']=array_merge(Dtable::toArr($m),Dtable::toArr($m2));		
			$page['points_total']=UserPoints::model()->get_total($uid);
			$page['collect_total']=UserCollect::model()->get_total($uid);
			
			$this->render('/index',array('page'=>$page));
			
		}
	}
	
		
	public function actionLogin(){
		$page=array();//die(print_r($_SESSION));
		if(!Yii::app()->user->isGuest){
			$this->redirect(array('site/index'));
		}	
		$page['connect_data']=$this->thirdpassport();
		$model = new UserLoginForm;
        // collect user input data
        $uname=isset($_POST['uname'])?$_POST['uname']:'';
		$upass=isset($_POST['upass'])?$_POST['upass']:'';
		$rancode=isset($_POST['rancode'])?$_POST['rancode']:'';
        if (isset($_POST['uname'])) {
        	$model->username=$uname;
        	$model->password=$upass;
            
        
            if($rancode==''){
            	$this->msg(array('state'=>0,'msgwords'=>'验证码不能为空','type'=>'json'));
            } 
            if(!isset($_SESSION['login_rancode'])||$_SESSION['login_rancode']!=$rancode){
            	$this->msg(array('state'=>0,'msgwords'=>'验证码无效','type'=>'json'));
            }           
            $user_model = User::model ()->findByAttributes (array ('uname' => $model->username));
			if ($user_model==null) {
				$this->msg(array('state'=>0,'msgwords'=>'账号不存在','type'=>'json'));
			}
			if ($user_model->upass != User::model()->password_encryption ( $upass )) {
				$this->msg(array('state'=>0,'msgwords'=>'密码不正确','type'=>'json'));
			}
			if($user_model->ustate==1){
				$this->msg(array('state'=>0,'msgwords'=>'账号禁止登陆','type'=>'json'));
			}
           
			// print_r($user_model);die('aa');
			if ($model->login ()) {
				$attributes = array (
					'last_loginip' => ip2long ( Yii::app ()->request->userHostAddress ),
					'last_logindate' => date ( 'Y-m-d H:i:s', time () ) 
				);		
				//检测是否存在第三方登陆
				if(isset($page['connect_data']['type'])&&$page['connect_data']['type']){	
					//检测是否已经绑定账号
					$m=Dtable::model('user_thirdpassport')->findByAttributes(array('media_type'=>$page['connect_data']['type'],'openid'=>$page['connect_data']['openid']));
					if($m){
						//$this->msg(array('state'=>0,'msgwords'=>'账号已经绑定过，数据出错','type'=>'json'));						
					}else{
						$m=new Dtable('user_thirdpassport');
						$m->media_type=$page['connect_data']['type'];
						$m->openid=$page['connect_data']['openid'];
						$m->created=time();
						$m->uid=$user_model->uid;
						$m->user_data=helper::json_encode_cn($page['connect_data']);
						$m->save();
						
						//保存第三方登陆的头像
						$user_profile=Dtable::model('user_extern')->findByAttributes(array('uid'=>$user_model->uid));
						if($user_profile){
							if(!$user_profile->tou_img){
								$user_profile->tou_img=$page['connect_data']['tou_img'];
								$user_profile->save();
							}
						}else{
							$user_profile=new Dtable('user_extern');
							$user_profile->uid=$user_model->uid;
							$user_profile->tou_img=$page['connect_data']['tou_img'];
							$user_profile->save();
						}
					}
					
				}	
				
				$this->msg(array('state'=>1,'msgwords'=>'登陆成功','type'=>'json','url'=>$this->createUrl('frame/index')));
			}else{
				$this->msg(array('state'=>0,'msgwords'=>'登陆失败！','type'=>'json'));
			}
         
		
		}
		$this->render('/login',array('page'=>$page));
	}
	public function actionReg(){
		$page=array();
		
		$page['connect_data']=$this->thirdpassport();
		
		if($_POST) {
			$uphone=$this->post('uphone');
			$uname=$this->post('uname');
			$upass=$this->post('upass');
			$upass2=$this->post('upass2');
			$uemail=$this->post('uemail');
			$uqq=$this->post('uqq');
			$rancode=$this->post('rancode');
			
			if($rancode==''){
				$this->msg(array('state'=>0,'msgwords'=>'验证码不能为空','type'=>'json'));
			}
			
			if((!isset($_SESSION['reg_rancode'])) || ($_SESSION['reg_rancode']!=$rancode)){
				$this->msg(array('state'=>0,'msgwords'=>'验证码不正确','type'=>'json'));
			}
			if($upass!=$upass2){
				$this->msg(array('state'=>0,'msgwords'=>'两次密码不一致"','type'=>'json'));
			}
			//事物回滚
			$transaction = Yii::app()->db->beginTransaction();
			try {			
				$re=User::model()->reg_new($uphone,$uname,$uemail,$upass,0,$uqq);
				switch($re){
					case -7:$msgwords='手机号码不合法';break;
					case -6:$msgwords='手机号码已经被注册';break;
					case -5:$msgwords='密码不合法';break;
					case -3:$msgwords='Email不合法';break;
					case -4:$msgwords='用户名不合法';break;
					case -2:$msgwords='用户名已被注册';break;
					case -1:$msgwords='邮箱已被注册';break;
					default:
						$msgwords='注册成功';					
					
				}		
				if($re>0){
					if(isset($page['connect_data']['openid'])){
						$m=new Dtable('user_thirdpassport');
						$m->uid=$re;
						$m->media_type=$page['connect_data']['name'];
						$m->created=time();
						$m->openid=$page['connect_data']['openid'];
						$m->user_data=helper::json_encode_cn($page['connect_data']);
						$m->save();
					}					
					$model = new UserLoginForm;
					$model->username=$uname;
					if(!$model->login()){
						$this->msg(array('state'=>-2,'msgwords'=>'登陆程序错误','type'=>'json'));
					}
					
				}
				$transaction->commit(); //提交事务会真正的执行数据库操作
			} catch (Exception $e) {
				$transaction->rollback(); //如果操作失败, 数据回滚
				$this->msg(array('state'=>0,'msgwords'=>'注册失败，数据出错','type'=>'json'));
			}
			
			$this->msg(array('state'=>$re,'msgwords'=>$msgwords,'type'=>'json'));
		}	
		$this->render('/reg',array('page'=>$page));
	}
	public function actionRegok(){		
		$this->render('/regok');
	}
	
	public function actionEditPassword(){
		$uid=Yii::app()->user->uid;
		if(isset($_POST['old_password'])){
			$old_upass=$this->post('old_password');
			$upass=$this->post('new_password');
			if($old_upass==''){
				$this->msg(array("state"=>0,"msgwords"=>'原始密码不能为空','type'=>'json'));
			}		
			if(verify::check_password($upass)==0){
				$this->msg(array("state"=>0,"msgwords"=>'新密码不合法','type'=>'json'));
			}
			$old_upass=User::model()->password_encryption($old_upass);
			$upass=User::model()->password_encryption($upass);
			$m=User::model()->findByAttributes(array('uid'=>$uid,'upass'=>$old_upass));
			if(!$m){
				$this->msg(array("state"=>0,"msgwords"=>'原始密码不正确','type'=>'json'));
			}
			$m->upass=$upass;
			$dbresult=$m->save();
			if($dbresult){
				$this->msg(array('state'=>1,'msgwords'=>'密码修改成功','type'=>'json'));
			}else{
				$this->msg(array('state'=>0,'msgwords'=>'操作失败，未知原因','type'=>'json'));
			}
		}
		$this->render('/edit_password');
	}
	public function actionLogout(){
		if(isset($_POST['time'])){
			Yii::app()->user->logout();
			$this->redirect('login');
		}else{
			die('非法请求');
		}
	}
	//显示忘记密码
	public function actionForgetpassword(){
		$this->render('/forgetpassword');
	}
	//忘记密码，发送邮件
	public function actionForgetpasswordCheck(){		
		$email=$this->post('email');
		$rancode=$this->post('rancode');
		if(verify::check_email($email)==0){
			 $this->msg(array('state'=>0,'msgwords'=>'email不合法"','type'=>'json'));	
			 	
		}
		if((!isset(Yii::app()->session['forgetpassword_rancode'])) ||
			(Yii::app()->session['forgetpassword_rancode']=='') || 
			(Yii::app()->session['forgetpassword_rancode']!=$rancode)){
			$this->msg(array('state'=>0,'msgwords'=>'验证码不正确"','type'=>'json'));
		}
		$m=User::model()->findByAttributes(array('uemail'=>$email));
		if(!$m){
			$this->msg(array('state'=>0,'msgwords'=>'该email不存在"','type'=>'json'));
		}
		$uid=$m->uid;
		$uname=$m->uname;
		$forget_pass_code=md5(rand(10000000,99999999)*rand(500,999));
		$m->forget_pass_code=$forget_pass_code;
		$m->save();
		$page['smail']=array();	  	
		$page['smail']['url']="http://".Yii::app()->params['basic']['sitedomain']."/user/site/resetPassword?uid=".$uid."&forget_pass_code=".$forget_pass_code."";
		$page['smail']['title']= Yii::app()->params['basic']['sitename']."--会员邮件重置密码通知";
		$page['smail']['body'] = '';
		$page['smail']['body'] .= "尊敬的用户".$uname."，您好：\r\n";
		$page['smail']['body'] .= "重置密码请点击或复制下面链接到地址栏访问这地址：\r\n\r\n";
		$page['smail']['body'] .= "".$page['smail']['url']."\r\n\r\n";
		helper::send_email($uname,$email,$page['smail']['title'],$page['smail']['body']); 
		
		$this->msg(array('state'=>1,'msgwords'=>'邮件成功发送"','type'=>'json'));
	}
	//邮箱里点击 显示的修改密码的 界面
	function actionResetPassword(){
		$uid=intval($this->get('uid'));
		$forget_pass_code=helper::escape($this->get('forget_pass_code'));
		if(!$uid || !$forget_pass_code){
			echo "<script>window.location='".$this->createUrl('site/login')."'</script>";
			exit();
		}
		$sql="select * from user_list where uid=".$uid." and forget_pass_code='".$forget_pass_code."' ";
		$rc['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rc['list'])==0){
			echo "<script>window.location='".$this->createUrl('site/login')."'</script>";
			exit();
		}
		$page['user']=$rc['list'][0];
		$this->render('/forgetpasswordReset',array('page'=>$page));
	}
	
	//保存重置密码
	public function actionForgetpasswordResetSave(){
		$uid=intval($this->post('uid'));
		$forget_pass_code=helper::escape($this->post('forget_pass_code'));
		$password=$this->post('password');	
		if(!$forget_pass_code|| $password==''){
			$this->msg(array('state'=>0,'msgwords'=>'提交不合法','type'=>'json'));
		}		
		if(!Verify::check_password($password)){
			$this->msg(array('state'=>0,'msgwords'=>'密码不规范"','type'=>'json'));
		}
		$password=User::model()->password_encryption($password);
		$sql="select * from user_list where uid=".$uid." and forget_pass_code='".$forget_pass_code."' ";
	    $rc['list']=Yii::app()->db->createCommand($sql)->queryAll();
		if(count($rc['list'])==0){
			$this->msg(array('state'=>0,'msgwords'=>'密码非法','type'=>'json'));	
		}	
		$usql="update user_list set upass='".$password."',forget_pass_code='',lastvisit_code='' where uid=".$uid." ";
		Yii::app()->db->createCommand($usql)->execute();
		$this->msg(array('state'=>1,'msgwords'=>'密码重置成功,3秒后转到登陆','type'=>'json'));	
		
	}
	
	//弹出登陆窗口
	public function actionDialogLogin(){
		$page=array();
		if(Yii::app()->user->isGuest==0){
			$this->msg(array('state'=>2,'msgwords'=>'already login','type'=>'getjson'));
		}
		$data=$this->renderFile(dirname(__FILE__).'/../views/dialog_login.php',array('page'=>$page),true);
		$this->msg(array('state'=>1,'msgwords'=>'ok','type'=>'getjson','data'=>$data));
	}
	
	
	/*第三方授权登陆
	 * 返回数组，第三方数据
	 */
	private function thirdpassport(){
		//第三方授权登陆
		if($this->get('connect')==1){
			if(!isset(Yii::app()->session['connect_qq'])){
				$this->msg(array('state'=>-2,'msgwords'=>'api出错,未授权'));
			}
			$openid=Yii::app()->session['connect_qq']['openid'];
			$access_token=Yii::app()->session['connect_qq']['access_token'];
			$qc = new QC($access_token,$openid);
			$arr = $qc->get_user_info();
	
			//print_r($arr);
			$page['connect_data']=array('type'=>1,'name'=>'QQ','nickname'=>$arr['nickname'],'tou_img'=>$arr['figureurl_1'],'openid'=>$openid);
		}else if($this->get('connect')==2){
			if(!isset(Yii::app()->session['connect_weibo'])){
				$this->msg(array('state'=>-2,'msgwords'=>'api出错,未授权'));
			}
			$appkey=Yii::app()->params['weibo']['wb_akey'];
			$appsecret=Yii::app()->params['weibo']['wb_skey'];
			$openid=Yii::app()->session['connect_weibo']['openid'];
			$access_token=Yii::app()->session['connect_weibo']['access_token'];
			$c = new SaeTClientV2( $appkey , $appsecret ,$access_token);
			$ms  = $c->home_timeline(); // done
			$uid_get = $c->get_uid();
			$uid = $uid_get['uid'];
			$user_message = $c->show_user_by_id( $uid);//根据ID获取用户等基本信息
			#print_r($user_message);
			//print_r($arr);
			$page['connect_data']=array('type'=>2,'name'=>'新浪微博','nickname'=>$user_message['screen_name'],'tou_img'=>$user_message['profile_image_url'],'openid'=>$openid);
		}else if($this->get('connect')==3){
			if(!isset(Yii::app()->session['connect_taobao'])){
				$this->msg(array('state'=>-2,'msgwords'=>'api出错,未授权'));
			}
			$openid=Yii::app()->session['connect_taobao']['openid'];
			$access_token=Yii::app()->session['connect_taobao']['access_token'];
			$page['connect_data']=array('type'=>3,'name'=>'淘宝','nickname'=>$openid,'tou_img'=>'','openid'=>$openid);
		}else{
			$page['connect_data']['type']='';
		}
		return $page['connect_data'];	
	}
		
	
}