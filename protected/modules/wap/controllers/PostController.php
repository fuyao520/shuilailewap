<?php
class PostController extends UserController{
	
	//检查登录
	public function actionCheckLogin(){
		$jsoncallback=$this->get('jsoncallback');
		$re=array();
		if(Yii::app()->user->isGuest){
			$re['islogin']=0;
		}else{
			$re['islogin']=1;
			$re['uname']=Yii::app()->user->uname;
		}
		$re=json_encode($re);
		exit($jsoncallback.'('.$re.')');
	}
	
	public function actionQqLogin(){
		$qc = new QC();
		$qc->qq_login();
	}
	public function actionQqLoginBack(){
		$page=array();
		if($this->get('state')==''){
			$this->msg(array('state'=>-2,'msgwords'=>'参数出错'));
		}
		$qc = new QC();
		$access_token=$qc->qq_callback();
		$qq_openid=$qc->get_openid();		 //只能调用一次，否则会client request's parameters are invalid, invalid openid的错误
		$arr=array('openid'=>$qq_openid,'access_token'=>$access_token);
		Yii::app()->session['connect_qq']=$arr;
		echo ('<script>setTimeout(\'window.location="'.$this->createUrl('post/qqLoginBackMain').'"\')</script>');
		die();
		
	}
	public function actionQqLoginBackMain(){
		$arr=Yii::app()->session['connect_qq'];
		$qc = new QC($arr['access_token'],$arr['openid']);
		$arr = $qc->get_user_info();
		$openid=Yii::app()->session['connect_qq']['openid'];
		$page['connect_data']=array('type'=>1,'name'=>'QQ','openid'=>$openid,'nickname'=>$arr['nickname'],'tou_img'=>$arr['figureurl_1']);
		//$this->render('/login',array('page'=>$page));
		$m=$this->oauthLogin($page['connect_data']['type'], $page['connect_data']['openid']);
		if($m){
			header("location:".$this->createUrl('site/index'));
		}else{
			header("location:".$this->createUrl('site/login').'?connect=1');
		}		
		die();
		
	}
	/*微博登陆api
	 * 
	 * */
	public function actionWeiboLogin(){
		$backurl=Yii::app()->params['weibo']['redirect_uri'];
		$appkey=Yii::app()->params['weibo']['wb_akey'];
		$appsecret=Yii::app()->params['weibo']['wb_skey'];
		$o = new SaeTOAuthV2( $appkey , $appsecret );		
		$code_url = $o->getAuthorizeURL($backurl);
		//die($code_url);
		header("location:$code_url");
		die();
		
		
	}
	public function actionWeiboLoginBack(){
		$backurl=Yii::app()->params['weibo']['redirect_uri'];
		$appkey=Yii::app()->params['weibo']['wb_akey'];
		$appsecret=Yii::app()->params['weibo']['wb_skey'];
		$o = new  SaeTOAuthV2( $appkey , $appsecret );			
		if (isset($_REQUEST['code'])) {
			$keys = array();
			$keys['code'] = $_REQUEST['code'];
			$keys['redirect_uri'] = $backurl;
			try {
				$token = $o->getAccessToken( 'code', $keys ) ;
			}catch (Exception $e) {
			}
		}
		
		if (!$token) {
			$this->msg(array('state'=>-2,'msgwords'=>'授权失败'));
		}
		$arr['access_token']=$token['access_token'];
		$arr['openid']=$openid=$token['uid'];
		Yii::app()->session['connect_weibo']=$arr;
		$page['connect_data']=array('type'=>2,'name'=>'微博','openid'=>$openid,'nickname'=>'','tou_img'=>'');
		$m=$this->oauthLogin($page['connect_data']['type'], $page['connect_data']['openid']);
		if($m){
			header("location:".$this->createUrl('site/index'));
		}else{
			header("location:".$this->createUrl('site/login').'?connect=2');
		}
		die();
		
	}
	
	public function actionTaobaoLogin(){
		/*测试时，需把test参数换成自己应用对应的值*/
		$url = ' https://oauth.taobao.com/authorize?a=1';
		$postfields= array('grant_type'=>'authorization_code',
				'client_id'=>Yii::app()->params['taobao']['appkey'],
				'response_type'=>'code',
				'redirect_uri'=>Yii::app()->params['taobao']['redirect_uri']);
		$params_str='';
		foreach($postfields as $k=>$r){
			$params_str.='&'.$k.'='.($r);
		}
		$url.=$params_str;	
		header("location:$url");
		die();			
		
	}
	
	public function actionTaobaoLoginBack(){
		if(!$this->get('code')){
			$this->msg(array('state'=>-2,'msgwords'=>'参数出错'));
		}
		$code=$this->get('code');
		/*测试时，需把test参数换成自己应用对应的值*/
		$url = 'https://oauth.taobao.com/token';
		$postfields= array('grant_type'=>'authorization_code',
				'client_id'=>Yii::app()->params['taobao']['appkey'],
				'client_secret'=>Yii::app()->params['taobao']['secretKey'],
				'code'=>$code,
				'redirect_uri'=>Yii::app()->params['taobao']['redirect_uri']
		);
		$post_data = '';
		foreach($postfields as $key=>$value){
			$post_data .="$key=".urlencode($value)."&";
		}		
		$tokenstr=helper::curl_post($url,$post_data);
		//print_r($tokenstr);die();
		$token=json_decode($tokenstr,1);
		if(isset($data['error'])){
			$this->msg(array('state'=>-2,'msgwords'=>'api出错'));
		}
		$arr['access_token']=$token['access_token'];
		$arr['openid']=$openid=$token['taobao_user_id'];
		Yii::app()->session['connect_taobao']=$arr;
		$page['connect_data']=array('type'=>3,'name'=>'淘宝','openid'=>$openid,'nickname'=>'','tou_img'=>'');
		$m=$this->oauthLogin($page['connect_data']['type'], $page['connect_data']['openid']);
		if($m){
			header("location:".$this->createUrl('site/index'));
		}else{
			header("location:".$this->createUrl('site/login').'?connect=3');
		}
		
	}
	
	/*第三方登陆之后检测是否绑定本站账号，是的话直接登陆
	 * return bool
	 * */
	private function oauthLogin($connect_type,$openid){		
		$m=Dtable::model('user_thirdpassport')->findByAttributes(array('media_type'=>$connect_type,'openid'=>$openid));
		if($m){
			$mu=User::model()->findByPk($m->uid);
			if(!$mu){
				$this->msg(array('state'=>-2,'msgwords'=>'该账号异常'));
			}
			$model = new UserLoginForm;
			$model->username=$mu->uname;
			if(!$model->login()){
				$this->msg(array('state'=>-2,'msgwords'=>'登陆程序错误'));
			}
			return 1;			
		}
		return 0;
		
	}
	
	
	
	
}
?>